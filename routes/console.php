<?php

use Illuminate\Support\Facades\Schedule;

// Update asset statuses to Inactive when they reach retirement date
Schedule::command('assets:update-retired-status')
    ->daily()
    ->at('02:00')
    ->name('update-retired-assets-status')
    ->appendOutputTo(storage_path('logs/scheduler.log'))
    ->emailOutputOnFailure(['clark.wayne023@gmail.com'])
    ->runInBackground();
