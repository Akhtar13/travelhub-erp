<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo;
class AgentWalletTransaction extends Model { protected $fillable=['agent_id','booking_id','type','amount','balance_after','description','created_by']; protected function casts(): array { return ['amount'=>'decimal:2','balance_after'=>'decimal:2']; } public function agent(): BelongsTo { return $this->belongsTo(Agent::class); } public function booking(): BelongsTo { return $this->belongsTo(Booking::class); } public function creator(): BelongsTo { return $this->belongsTo(User::class,'created_by'); } }
