<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LifecycleResource\Pages;
use App\Models\AssetStatus;
use App\Models\LicenseType;
use App\Models\Lifecycle;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Carbon;

class LifecycleResource extends Resource
{
    protected static ?string $model = Lifecycle::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Manage Assets';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('acquisition_date')
                    ->label('Acquisition Date')
                    ->displayFormat('m/d/Y')
                    ->required(),
                Forms\Components\DatePicker::make('retirement_date')
                    ->label('Retirement Date')
                    ->displayFormat('m/d/Y')
                    ->default(now()->addYears(5))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('asset.id')
                    ->label('Asset ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('asset.asset_type')
                    ->label('Asset Type')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('asset_name')
                    ->label('Asset')
                    ->getStateUsing(function (Lifecycle $record): string {
                        $asset = $record->asset;
                        return $asset ? " {$asset->brand} {$asset->model}" : 'N/A';
                    })
                    ->url(fn (Lifecycle $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                TextColumn::make('asset_status')
                    ->label('Asset Status')
                    ->getStateUsing(function (Lifecycle $record): string {
                        $assetStatus = AssetStatus::find($record->asset->asset_status);
                        return $assetStatus ? $assetStatus->asset_status : 'N/A';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Inactive' => 'gray',
                        'In Transfer' => 'primary',
                        'Maintenance' => 'warning',
                        'Lost' => 'gray',
                        'Disposed' => 'gray',
                        'Stolen' => 'danger',
                        'Unknown' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('asset.software.license_type')
                    ->label('Software License Type')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (Lifecycle $record): string {
                        // Access the related LicenseType through the relationships
                        $licenseType = $record->asset->software->licenseType->license_type ?? '';
                        return $licenseType;
                    })
                    ->placeholder('Hardware Asset'),
                TextColumn::make('lifecycle_status')
                    ->label('Lifecycle Status')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->getStateUsing(function (Lifecycle $record): string {
                        $asset = $record->asset;
                        $now = Carbon::now();
                        $acquisitionDate = $record->acquisition_date ? Carbon::parse($record->acquisition_date) : null;
                        $retirementDate = $record->retirement_date ? Carbon::parse($record->retirement_date) : null;

                        if (!$asset) {
                            return 'Unknown';
                        }

                        // Check if retirement date is approaching (within 90 days)
                        if ($retirementDate && $now->diffInDays($retirementDate, false) <= 90 && $now < $retirementDate) {
                            return 'Nearing Retirement';
                        }

                        if (!$retirementDate) {
                            return 'Retirement Date Not Set';
                        }

                        if ($now > $retirementDate) {
                            return 'End of Life (EOL)';
                        }

                        switch ($asset->asset_type) {
                            case 'software':
                                return self::getSoftwareStatus($asset->software, $now, $retirementDate);
                            case 'hardware':
                            case 'peripherals':
                                return self::getHardwareStatus($acquisitionDate, $retirementDate, $now);
                            default:
                                return 'Unknown';
                        }
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Subscription Active' => 'success',
                        'Subscription Renewal Due' => 'warning',
                        'Subscription Expired' => 'danger',
                        'Subscription Cancelled' => 'danger',
                        'End of Life (EOL)' => 'danger',
                        'Nearing Retirement' => 'warning',
                        'Active' => 'success',
                        'Mid-Life' => 'info',
                        'Nearing End of Life' => 'warning',
                        'Retirement Date Not Set' => 'info',
                        'One-Time License' => 'success',
                        'Open Source' => 'success',
                        'License Leasing' => 'info',
                        'Pay As You Go' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('acquisition_date')
                    ->label('Acquisition Date')
                    ->date('Y-m-d')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('retirement_date')
                    ->label('Retirement Date')
                    ->date('Y-m-d')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('asset_status')
                    ->label('Filter by Asset Status')
                    ->indicator('Asset Status')
                    ->relationship('asset.assetStatus', 'asset_status'),
                SelectFilter::make('license_type')
                    ->label('Filter by License Type')
                    ->indicator('License Type')
                    ->relationship('asset.software.licenseType', 'license_type'),

            ])
            ->actions([
            ])
            ->bulkActions([
            ])
            ->searchPlaceholder('Search by Asset ID')
            ->defaultSort('id', 'desc');
    }

    private static function getSoftwareStatus($software, $now, $retirementDate): string
    {
        if (!$software) {
            return 'Unknown';
        }

        // Retrieve the related LicenseType model instance
        $licenseType = $software->licenseType;

        if (!$licenseType) {
            return 'Unknown License Type';
        }

        switch ($licenseType->license_type) {
            case 'Monthly Subscription':
            case 'Annual Subscription':
                $subscriptionEndDate = $retirementDate ?? null;

                if (!$subscriptionEndDate) {
                    return 'Subscription Status Unknown';
                }

                if ($now > $subscriptionEndDate) {
                    return 'Subscription Expired';
                }

                if ($now->diffInDays($subscriptionEndDate, false) <= 30) {
                    return 'Subscription Renewal Due';
                }

                return 'Subscription Active';

            case 'One-Time':
                return 'One-Time License';

            case 'Open Source':
                return 'Open Source';

            case 'License Leasing':
                return 'License Leasing';

            case 'Pay As You Go':
                return 'Pay As You Go';

            default:
                return 'Unknown License Type';
        }
    }


    private static function getHardwareStatus($acquisitionDate, $retirementDate, $now): string
    {
        if (!$acquisitionDate || !$retirementDate) {
            return 'Lifecycle Status Unknown';
        }

        $totalLifespan = $acquisitionDate->diffInDays($retirementDate);
        $remainingLifespan = $now->diffInDays($retirementDate, false);

        if ($remainingLifespan <= 0) {
            return 'End of Life (EOL)';
        }

        $percentageRemaining = ($remainingLifespan / $totalLifespan) * 100;

        if ($percentageRemaining > 66) {
            return 'Active';
        } elseif ($percentageRemaining > 33) {
            return 'Mid-Life';
        } else {
            return 'Nearing End of Life';
        }
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLifecycles::route('/'),
            'create' => Pages\CreateLifecycle::route('/create'),
            'edit' => Pages\EditLifecycle::route('/{record}/edit'),
        ];
    }
}
