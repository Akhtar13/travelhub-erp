<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\HasMany;
class SeatLayout extends Model { protected $fillable=['name','rows','columns','status']; public function seats(): HasMany { return $this->hasMany(Seat::class); } public function schedules(): HasMany { return $this->hasMany(TravelSchedule::class); } }
