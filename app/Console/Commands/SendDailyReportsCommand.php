<?php
namespace App\Console\Commands;
use App\Jobs\GenerateReportJob; use Illuminate\Console\Command;
class SendDailyReportsCommand extends Command { protected $signature='travelhub:daily-reports'; protected $description='Queue daily reports'; public function handle(): int { GenerateReportJob::dispatch('revenue'); $this->info('Daily reports queued.'); return self::SUCCESS; } }
