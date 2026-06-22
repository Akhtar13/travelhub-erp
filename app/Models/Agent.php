<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\{BelongsTo,HasMany};
class Agent extends Model { protected $fillable=['name','company','credit_balance','currency_id','contact','email','status']; protected function casts(): array { return ['credit_balance'=>'decimal:2']; } public function currency(): BelongsTo { return $this->belongsTo(Currency::class); } public function assignments(): HasMany { return $this->hasMany(AgentRouteAssignment::class); } public function allocations(): HasMany { return $this->hasMany(AgentSeatAllocation::class); } public function transactions(): HasMany { return $this->hasMany(AgentWalletTransaction::class); } public function bookings(): HasMany { return $this->hasMany(Booking::class); } }
