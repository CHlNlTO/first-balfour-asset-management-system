<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ProcessLifecycleRenewals;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('lifecycles:process-renewals')
            ->dailyAt('00:06')
            ->appendOutputTo(storage_path('logs/scheduler.log'))
            ->emailOutputOnFailure(['your@email.com']);
        // ->runInBackground();
    }

    protected $commands = [
        ProcessLifecycleRenewals::class,
    ];
}
