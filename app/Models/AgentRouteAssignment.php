<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo;
class AgentRouteAssignment extends Model { protected $fillable=['agent_id','travel_route_id','seat_quota','daily_limit','price','status']; protected function casts(): array { return ['price'=>'decimal:2']; } public function agent(): BelongsTo { return $this->belongsTo(Agent::class); } public function route(): BelongsTo { return $this->belongsTo(TravelRoute::class,'travel_route_id'); } }
