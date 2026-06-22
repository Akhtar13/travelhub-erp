<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; use App\Http\Requests\Admin\BookingRequest; use App\Models\Booking; use App\Services\Admin\BookingService;
class BookingApiController extends Controller { public function index(){ return Booking::with('passenger','route','schedule','agent')->latest()->paginate(25); } public function store(BookingRequest $r,BookingService $s){ return response()->json($s->create($r->validated(),$r->user()->id)->load('passenger','seats'),201); } public function show(Booking $booking){ return $booking->load('passenger','route','schedule','agent','seats','checkIn'); } }
