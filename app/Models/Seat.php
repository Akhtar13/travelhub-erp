<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\{BelongsTo,BelongsToMany,HasMany};
class Seat extends Model { protected $fillable=['seat_layout_id','seat_number','row_number','column_number','type','is_blocked']; protected function casts(): array { return ['is_blocked'=>'boolean']; } public function layout(): BelongsTo { return $this->belongsTo(SeatLayout::class,'seat_layout_id'); } public function bookings(): BelongsToMany { return $this->belongsToMany(Booking::class,'booking_seat')->withPivot('travel_schedule_id')->withTimestamps(); } public function holds(): HasMany { return $this->hasMany(SeatHold::class); } }
