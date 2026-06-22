<?php
namespace App\Console\Commands;
use App\Services\Admin\SeatService; use Illuminate\Console\Command;
class CleanupSeatHoldsCommand extends Command { protected $signature='travelhub:cleanup-seat-holds'; protected $description='Remove expired automatic seat holds'; public function handle(SeatService $seats): int { $seats->releaseExpiredHolds(); $this->info('Expired seat holds cleaned.'); return self::SUCCESS; } }
