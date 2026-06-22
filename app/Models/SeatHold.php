<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo;
class SeatHold extends Model { protected $fillable=['travel_schedule_id','seat_id','user_id','token','expires_at']; protected function casts(): array { return ['expires_at'=>'datetime']; } public function schedule(): BelongsTo { return $this->belongsTo(TravelSchedule::class,'travel_schedule_id'); } public function seat(): BelongsTo { return $this->belongsTo(Seat::class); } public function user(): BelongsTo { return $this->belongsTo(User::class); } }
