<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CheckIn extends Model { protected $fillable=['booking_id','passenger_id','travel_schedule_id','checked_in_by','checked_in_at','exit_fee','method','status']; protected function casts(): array { return ['checked_in_at'=>'datetime','exit_fee'=>'decimal:2']; } public function booking(): BelongsTo { return $this->belongsTo(Booking::class); } public function passenger(): BelongsTo { return $this->belongsTo(Passenger::class); } public function schedule(): BelongsTo { return $this->belongsTo(TravelSchedule::class,'travel_schedule_id'); } public function user(): BelongsTo { return $this->belongsTo(User::class,'checked_in_by'); } }
