<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\{BelongsTo,HasMany};
class Passenger extends Model { protected $fillable=['first_name','last_name','gender','dob','nationality_id','passport','national_id','contact_number']; protected function casts(): array { return ['dob'=>'date']; } public function nationality(): BelongsTo { return $this->belongsTo(Nationality::class); } public function bookings(): HasMany { return $this->hasMany(Booking::class); } }
