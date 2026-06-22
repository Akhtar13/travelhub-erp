<?php
namespace App\Services\Admin;
use App\Models\ActivityLog; use Illuminate\Database\Eloquent\Model; use Illuminate\Support\Facades\Auth;
class ActivityLogger { public function log(string $event, string $description, ?Model $subject=null, array $properties=[]): void { ActivityLog::create(['log_name'=>'admin','description'=>$description,'event'=>$event,'subject_type'=>$subject ? $subject::class : null,'subject_id'=>$subject?->getKey(),'causer_type'=>Auth::check()?Auth::user()::class:null,'causer_id'=>Auth::id(),'properties'=>$properties]); } }
