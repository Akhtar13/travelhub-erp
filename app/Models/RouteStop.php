<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo;
class RouteStop extends Model { protected $fillable=['travel_route_id','location_id','stop_order','arrival_offset_minutes','departure_offset_minutes']; public function route(): BelongsTo { return $this->belongsTo(TravelRoute::class,'travel_route_id'); } public function location(): BelongsTo { return $this->belongsTo(Location::class); } }
