<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo;
class RouteCharge extends Model { protected $fillable=['travel_route_id','name','amount','type']; public function route(): BelongsTo { return $this->belongsTo(TravelRoute::class,'travel_route_id'); } }
