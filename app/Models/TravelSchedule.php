<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\{BelongsTo,HasMany};
class TravelSchedule extends Model { protected $fillable=['travel_route_id','seat_layout_id','departure_at','arrival_at','base_fare','status']; protected function casts(): array { return ['departure_at'=>'datetime','arrival_at'=>'datetime','base_fare'=>'decimal:2']; } public function route(): BelongsTo { return $this->belongsTo(TravelRoute::class,'travel_route_id'); } public function seatLayout(): BelongsTo { return $this->belongsTo(SeatLayout::class); } public function bookings(): HasMany { return $this->hasMany(Booking::class); } public function holds(): HasMany { return $this->hasMany(SeatHold::class); } }
