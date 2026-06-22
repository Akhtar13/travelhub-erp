<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo;
class AgentSeatAllocation extends Model { protected $fillable=['agent_id','travel_schedule_id','allocated_seats','used_seats','allocation_date','status']; protected function casts(): array { return ['allocation_date'=>'date']; } public function agent(): BelongsTo { return $this->belongsTo(Agent::class); } public function schedule(): BelongsTo { return $this->belongsTo(TravelSchedule::class,'travel_schedule_id'); } }
