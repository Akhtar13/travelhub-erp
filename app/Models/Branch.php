<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Branch extends Model { protected $fillable=['region_id','name','code','email','phone','address','status']; public function region(): BelongsTo { return $this->belongsTo(Region::class); } }
