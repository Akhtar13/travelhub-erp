<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Location extends Model { protected $fillable=['region_id','name','code','status']; public function region(): BelongsTo { return $this->belongsTo(Region::class); } public function originRoutes(): \Illuminate\Database\Eloquent\Relations\HasMany { return $this->hasMany(TravelRoute::class,'origin_location_id'); } public function destinationRoutes(): \Illuminate\Database\Eloquent\Relations\HasMany { return $this->hasMany(TravelRoute::class,'destination_location_id'); } public function routeStops(): \Illuminate\Database\Eloquent\Relations\HasMany { return $this->hasMany(RouteStop::class); } }
