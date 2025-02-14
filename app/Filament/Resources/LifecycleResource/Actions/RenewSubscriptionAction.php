<?php

namespace App\Filament\Resources\LifecycleResource\Actions;

use App\Models\Lifecycle;
use Illuminate\Support\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\DB;

class RenewSubscriptionAction
{
    public static function make(): Action
    {
        return Action::make('renew-subscription')
            ->label('Renew Subscription')
            ->icon('heroicon-o-arrow-path')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Renew Subscription')
            ->modalDescription(fn(Lifecycle $record) => "Current retirement date: " . $record->retirement_date?->format('M d, Y'))
            ->form([
                DatePicker::make('new_retirement_date')
                    ->label('New Retirement Date')
                    ->required()
                    ->minDate(fn(Lifecycle $record) => $record->retirement_date)
                    ->default(fn(Lifecycle $record) => static::calculateDefaultNewDate($record))
                    ->helperText('Must be after current retirement date'),

                Toggle::make('auto_renewal_enabled')
                    ->label('Enable Automatic Renewal')
                    ->helperText('Automatically renew this subscription before expiration')
                    ->default(fn(Lifecycle $record) => $record->auto_renewal_enabled),

                Textarea::make('remarks')
                    ->label('Remarks')
                    ->placeholder('Optional notes about this renewal')
                    ->maxLength(255)
            ])
            ->visible(fn(Lifecycle $record): bool => $record->isDueForRenewal())
            ->action(function (array $data, Lifecycle $record): void {
                try {
                    DB::beginTransaction();

                    // Update auto-renewal setting if changed
                    if ($record->auto_renewal_enabled !== $data['auto_renewal_enabled']) {
                        $record->update(['auto_renewal_enabled' => $data['auto_renewal_enabled']]);
                    }

                    // Process the renewal
                    $record->renewSubscription(
                        newDate: Carbon::parse($data['new_retirement_date']),
                        remarks: $data['remarks']
                    );

                    DB::commit();

                    // Show success notification
                    Notification::make()
                        ->title('Subscription Renewed')
                        ->body('The subscription has been successfully renewed.')
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    DB::rollBack();

                    // Notify current admin of the failure
                    Notification::make()
                        ->title('Renewal Failed')
                        ->body('Failed to renew subscription: ' . $e->getMessage())
                        ->danger()
                        ->send();

                    throw $e;
                }
            });
    }

    protected static function calculateDefaultNewDate(Lifecycle $lifecycle): ?Carbon
    {
        if (!$lifecycle->retirement_date) {
            return null;
        }

        $currentDate = Carbon::parse($lifecycle->retirement_date);

        // Get the license type
        $licenseType = $lifecycle->asset?->software?->licenseType?->license_type;

        return match ($licenseType) {
            'Monthly Subscription' => $currentDate->copy()->addMonth(),
            'Annual Subscription' => $currentDate->copy()->addYear(),
            default => $currentDate->copy()->addMonth() // Default to monthly if unknown
        };
    }
}
