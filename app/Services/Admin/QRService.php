<?php
namespace App\Services\Admin;
use App\Models\Booking;
class QRService { public function generate(Booking $booking): string { return route('admin.bookings.show',$booking).'?verify='.hash('sha256',$booking->pnr.'|'.$booking->id); } }
