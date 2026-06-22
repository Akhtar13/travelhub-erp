<?php
use Illuminate\Support\Facades\Schedule;
Schedule::command('travelhub:cleanup-seat-holds')->everyFiveMinutes();
Schedule::command('travelhub:daily-reports')->dailyAt('23:50');
Schedule::command('travelhub:booking-cleanup')->hourly();
