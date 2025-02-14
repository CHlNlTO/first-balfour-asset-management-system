<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lifecycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'acquisition_date',
        'retirement_date',
        'auto_renewal_enabled',
        'renewal_in_progress',
        'remarks'
    ];

    protected $casts = [
        'auto_renewal_enabled' => 'boolean',
        'renewal_in_progress' => 'boolean',
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

        // // Check if retirement date is approaching (within 14 days)
        // if ($retirementDate && $now->diffInDays($retirementDate, false) <= 14 && $now < $retirementDate) {
        //     return 'Nearing Retirement';
        // }

        // if (!$retirementDate) {
        //     return 'Retirement Date Not Set';
        // }

        // if ($now > $retirementDate) {
        //     return 'End of Life (EOL)';
        // }

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

    public function renewals(): HasMany
    {
        return $this->hasMany(LifecycleRenewal::class);
    }

    public function isDueForRenewal(): bool
    {
        // Check if it's a software asset with subscription license
        if (
            !$this->asset ||
            $this->asset->asset_type !== 'software' ||
            !$this->asset->software?->licenseType
        ) {
            return false;
        }

        $licenseType = $this->asset->software->licenseType->license_type;
        if (!in_array($licenseType, ['Monthly Subscription', 'Annual Subscription'])) {
            return false;
        }

        // Check if within 14 days of expiration and not already expired
        $now = Carbon::now();
        $retirementDate = $this->retirement_date ? Carbon::parse($this->retirement_date) : null;

        return $retirementDate
            && $now < $retirementDate
            && $now->diffInDays($retirementDate, false) <= 14;
    }

    public function renewSubscription(?Carbon $newDate = null, ?string $remarks = null): void
    {
        Log::info('Renewing subscription for lifecycle ID: ' . $this->id);

        // Start transaction
        DB::beginTransaction();
        try {
            $oldDate = Carbon::parse($this->retirement_date);

            // If no new date provided, calculate based on license type
            if (!$newDate) {
                $licenseType = $this->asset->software->licenseType->license_type;
                $newDate = match ($licenseType) {
                    'Monthly Subscription' => $this->calculateNextMonthDate($oldDate),
                    'Annual Subscription' => $oldDate->copy()->addYear(),
                    default => throw new \Exception('Invalid license type for renewal')
                };
            }

            // Create renewal record
            $this->renewals()->create([
                'user_id' => auth()->id(), // Changed from auth()->user()
                'old_retirement_date' => $oldDate,
                'new_retirement_date' => $newDate,
                'is_automatic' => false,
                'remarks' => $remarks
            ]);

            // Update lifecycle
            $this->update([
                'retirement_date' => $newDate,
                'remarks' => $remarks
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function calculateNextMonthDate(Carbon $currentDate): Carbon
    {
        // If it's the last day of the month, use the last day of the next month
        if ($currentDate->copy()->endOfMonth()->isSameDay($currentDate)) {
            return $currentDate->copy()->addMonth()->endOfMonth();
        }

        return $currentDate->copy()->addMonth();
    }
}
