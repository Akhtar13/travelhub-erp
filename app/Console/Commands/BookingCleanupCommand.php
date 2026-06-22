<?php
namespace App\Console\Commands;
use App\Models\Booking; use Illuminate\Console\Command;
class BookingCleanupCommand extends Command { protected $signature='travelhub:booking-cleanup'; protected $description='Cancel stale pending bookings'; public function handle(): int { Booking::where('status','pending')->where('created_at','<',now()->subDay())->update(['status'=>'cancelled']); return self::SUCCESS; } }
