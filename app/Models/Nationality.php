<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Nationality extends Model { protected $fillable=['name','code','status']; public function passengers(): \Illuminate\Database\Eloquent\Relations\HasMany { return $this->hasMany(Passenger::class); } }
