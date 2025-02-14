<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Add your lifecycle renewals schedule here
Schedule::command('lifecycles:process-renewals')
    ->dailyAt('00:00')
    ->appendOutputTo(storage_path('logs/scheduler.log'))
    ->emailOutputOnFailure(['clark.wayne023@gmail.com'])
    ->runInBackground();
