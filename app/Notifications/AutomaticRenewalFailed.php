<?php

namespace App\Notifications;

use App\Models\Lifecycle;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;

class AutomaticRenewalFailed extends Notification
{
    use Queueable;

    public function __construct(
        protected Lifecycle $lifecycle,
        protected string $error
    ) {}

    public function toDatabase($notifiable)
    {
        return FilamentNotification::make()
            ->title('Automatic Renewal Failed')
            ->icon('heroicon-o-exclamation-circle')
            ->body("Automatic renewal failed for asset {$this->lifecycle->asset->tag_number}. Error: {$this->error}")
            ->danger()
            ->getDatabaseMessage();
    }
}
