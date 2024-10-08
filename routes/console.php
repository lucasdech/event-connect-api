<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

function schedule(Schedule $schedule)
{
    $schedule->command('inspire')->hourly();
    $schedule->command('app:remove-expired-tokens')->daily();
    $schedule->command('telescope:prune')->daily();
}
