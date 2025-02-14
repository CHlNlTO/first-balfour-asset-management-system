<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LifecycleResource\Actions\RenewSubscriptionAction;
use App\Filament\Resources\LifecycleResource\Pages;
use App\Models\Lifecycle;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class LifecycleResource extends Resource
{
    protected static ?string $model = Lifecycle::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Manage Lifecycle';

    protected static ?int $navigationSort = 1;

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
                TextColumn::make('asset.tag_number')
                    ->label('Tag Number')
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('asset.asset_type')
                    ->label('Asset Type')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('asset.asset')
                    ->label('Asset')
                    ->sortable()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhereHas('asset.model.brand', function ($query) use ($search) {
                            $query->where('brands.name', 'like', "%{$search}%");
                        })
                            ->orWhereHas('asset.model', function ($query) use ($search) {
                                $query->where('models.name', 'like', "%{$search}%");
                            });
                    })
                    ->placeholder('N/A')
                    ->url(fn(Lifecycle $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                TextColumn::make('asset.software.licenseType.license_type')
                    ->label('Subscription Type')
                    ->sortable()
                    ->searchable()
                    ->placeholder('Hardware Asset'),
                TextColumn::make('asset.assetStatus.asset_status')
                    ->label('Asset Status')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn($record) => $record->asset->assetStatus?->color?->getColor())
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                TextColumn::make('lifecycle_status')
                    ->tooltip('Lifecycle Status is determined by the asset type and lifecycle dates')
                    ->label('Lifecycle Status')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->getStateUsing(fn(Lifecycle $record): string => $record->getLifecycleStatus())
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Active' => 'success',
                        'Nearing Retirement' => 'warning',
                        'End of Life (EOL)' => 'danger',
                        'Renewal Due' => 'warning',
                        'Expired' => 'danger',
                        'Inactive' => 'gray',
                        'Retirement Date Not Set' => 'gray',
                        'Unknown' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('acquisition_date')
                    ->label('Acquisition Date')
                    ->date('M d, Y')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('retirement_date')
                    ->label('Retirement Date')
                    ->getStateUsing(function (Lifecycle $record): string {
                        return $record->retirement_date
                            ? Carbon::parse($record->retirement_date)->format('M d, Y') . ' (' . Carbon::parse($record->retirement_date)->diffForHumans() . ')'
                            : 'Not Set';
                    })
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('auto_renewal_enabled')
                    ->label('Auto Renewal')
                    ->sortable()
                    ->getStateUsing(fn(Lifecycle $record): string => $record->auto_renewal_enabled ? 'Enabled' : 'Disabled')
                    ->color(fn(string $state): string => $state === 'Enabled' ? 'success' : 'danger')
                    ->badge()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime('M d, Y')
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
                RenewSubscriptionAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }

    private static function getSoftwareStatus($software, $now, $retirementDate): string
    {
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

                if ($now->diffInDays($subscriptionEndDate, false) <= 30) {
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

        if ($remainingLifespan <= 14) {
            return 'Nearing Retirement';
        } else {
            return 'Active';
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
        ];
    }
}
