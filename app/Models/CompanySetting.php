<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CompanySetting extends Model { protected $fillable=['company_name','logo','email','phone','currency_id','timezone','language_id']; }
