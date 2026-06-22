<?php
namespace App\Services\Admin;
use App\Models\Booking;
class PnrService { public function generate(): string { do { $pnr='TH'.now()->format('ymd').strtoupper(substr(bin2hex(random_bytes(4)),0,8)); } while (Booking::where('pnr',$pnr)->exists()); return $pnr; } }
