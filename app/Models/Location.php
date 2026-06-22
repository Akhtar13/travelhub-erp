<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Location extends Model { protected $fillable=['region_id','name','code','status']; public function region(): BelongsTo { return $this->belongsTo(Region::class); } }
