<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Inspiring;
use App\Models\Event;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Command to delete past events
Artisan::command('events:delete-past', function () {
    $now = Carbon::now();

    Event::where('date', '<', $now->toDateString())
        ->orWhere(function ($query) use ($now) {
            $query->where('date', '=', $now->toDateString())
                ->where('end_time', '<', $now->toTimeString());
        })->delete();

    $this->info('Past events have been deleted.');
})->describe('Deletes events that have ended');

// Schedule the command to run daily
app(Schedule::class)->command('events:delete-past')->everyMinute();
