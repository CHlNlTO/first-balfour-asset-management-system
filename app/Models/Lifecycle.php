<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Lifecycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'acquisition_date',
        'retirement_date',
        'remarks'
    ];

    protected $casts = [
        'retirement_date' => 'date',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function getLifecycleStatus(): string
    {
        $asset = $this->asset;
        $now = Carbon::now();
        $acquisitionDate = $this->acquisition_date ? Carbon::parse($this->acquisition_date) : null;
        $retirementDate = $this->retirement_date ? Carbon::parse($this->retirement_date) : null;

        if (!$asset) {
            return 'Unknown';
        }

        switch ($asset->asset_type) {
            case 'software':
                return $this->getSoftwareStatus($now, $retirementDate);
            case 'hardware':
            case 'peripherals':
                return $this->getHardwareStatus($acquisitionDate, $retirementDate, $now);
            default:
                return 'Unknown';
        }
    }

    private function getSoftwareStatus(Carbon $now, ?Carbon $retirementDate): string
    {
        $software = $this->asset->software;

        if (!$software) {
            return 'Unknown';
        }

        $licenseType = $software->licenseType;

        if (!$licenseType) {
            return 'Unknown';
        }

        switch ($licenseType->license_type) {
            case 'Monthly Subscription':
            case 'Annual Subscription':
                $subscriptionEndDate = $retirementDate ?? null;

                if (!$subscriptionEndDate) {
                    return 'Unknown';
                }

                if ($now > $subscriptionEndDate) {
                    return 'Expired';
                }

                if ($now->diffInDays($subscriptionEndDate, false) <= 14) {
                    return 'Renewal Due';
                }

                return 'Active';

            case 'One-Time':
            case 'Open Source':
            case 'License Leasing':
            case 'Pay As You Go':
                return 'Active';

            default:
                return 'Unknown License Type';
        }
    }

    private function getHardwareStatus(?Carbon $acquisitionDate, ?Carbon $retirementDate, Carbon $now): string
    {
        if (!$acquisitionDate || !$retirementDate) {
            return 'Lifecycle Status Unknown';
        }

        $totalLifespan = $acquisitionDate->diffInDays($retirementDate);
        $remainingLifespan = $now->diffInDays($retirementDate, false);

        if ($remainingLifespan <= 0) {
            return 'End of Life (EOL)';
        }

        if ($remainingLifespan <= 14) {
            return 'Nearing Retirement';
        }

        return 'Active';
    }





    // Add this new scope method for lifecycle status filtering
    public function scopeWithLifecycleStatus(Builder $query, string $status): Builder
    {
        switch ($status) {
            case 'Active':
                // For software with subscription
                return $query->where(function ($q) {
                    $q->where(function ($q) {
                        $q->whereHas('asset', function ($q) {
                            $q->where('asset_type', 'software');
                        })
                            ->whereHas('asset.software.licenseType', function ($q) {
                                $q->whereIn('license_type', ['Monthly Subscription', 'Annual Subscription']);
                            })
                            ->whereRaw('retirement_date > NOW()')
                            ->whereRaw('DATEDIFF(retirement_date, NOW()) > 14');
                    })
                        // For software with one-time, open source, etc.
                        ->orWhere(function ($q) {
                            $q->whereHas('asset', function ($q) {
                                $q->where('asset_type', 'software');
                            })
                                ->whereHas('asset.software.licenseType', function ($q) {
                                    $q->whereIn('license_type', ['One-Time', 'Open Source', 'License Leasing', 'Pay As You Go']);
                                });
                        })
                        // For hardware and peripherals
                        ->orWhere(function ($q) {
                            $q->whereHas('asset', function ($q) {
                                $q->whereIn('asset_type', ['hardware', 'peripherals']);
                            })
                                ->whereNotNull('acquisition_date')
                                ->whereNotNull('retirement_date')
                                ->whereRaw('retirement_date > NOW()')
                                ->whereRaw('DATEDIFF(retirement_date, NOW()) > 14');
                        });
                });

            case 'Nearing Retirement':
                return $query->whereHas('asset', function ($q) {
                    $q->whereIn('asset_type', ['hardware', 'peripherals']);
                })
                    ->whereNotNull('acquisition_date')
                    ->whereNotNull('retirement_date')
                    ->whereRaw('retirement_date > NOW()')
                    ->whereRaw('DATEDIFF(retirement_date, NOW()) <= 14');

            case 'End of Life (EOL)':
                return $query->whereHas('asset', function ($q) {
                    $q->whereIn('asset_type', ['hardware', 'peripherals']);
                })
                    ->whereNotNull('acquisition_date')
                    ->whereNotNull('retirement_date')
                    ->whereRaw('retirement_date <= NOW()');

            case 'Renewal Due':
                return $query->whereHas('asset', function ($q) {
                    $q->where('asset_type', 'software');
                })
                    ->whereHas('asset.software.licenseType', function ($q) {
                        $q->whereIn('license_type', ['Monthly Subscription', 'Annual Subscription']);
                    })
                    ->whereNotNull('retirement_date')
                    ->whereRaw('retirement_date > NOW()')
                    ->whereRaw('DATEDIFF(retirement_date, NOW()) <= 14');

            case 'Expired':
                return $query->whereHas('asset', function ($q) {
                    $q->where('asset_type', 'software');
                })
                    ->whereHas('asset.software.licenseType', function ($q) {
                        $q->whereIn('license_type', ['Monthly Subscription', 'Annual Subscription']);
                    })
                    ->whereNotNull('retirement_date')
                    ->whereRaw('retirement_date <= NOW()');

            case 'Unknown':
            case 'Lifecycle Status Unknown':
            case 'Unknown License Type':
                return $query->where(function ($q) {
                    // Missing asset
                    $q->whereDoesntHave('asset')
                        // Or missing license type for software
                        ->orWhere(function ($q) {
                            $q->whereHas('asset', function ($q) {
                                $q->where('asset_type', 'software');
                            })
                                ->whereDoesntHave('asset.software.licenseType');
                        })
                        // Or missing acquisition date or retirement date for hardware/peripherals
                        ->orWhere(function ($q) {
                            $q->whereHas('asset', function ($q) {
                                $q->whereIn('asset_type', ['hardware', 'peripherals']);
                            })
                                ->where(function ($q) {
                                    $q->whereNull('acquisition_date')
                                        ->orWhereNull('retirement_date');
                                });
                        });
                });

            default:
                return $query;
        }
    }

    // Add a static method to get all available lifecycle statuses
    public static function getLifecycleStatusOptions(): array
    {
        return [
            'Active' => 'Active',
            'Nearing Retirement' => 'Nearing Retirement',
            'End of Life (EOL)' => 'End of Life (EOL)',
            'Renewal Due' => 'Renewal Due',
            'Expired' => 'Expired',
            'Unknown' => 'Unknown',
            'Lifecycle Status Unknown' => 'Lifecycle Status Unknown',
            'Unknown License Type' => 'Unknown License Type'
        ];
    }
}
