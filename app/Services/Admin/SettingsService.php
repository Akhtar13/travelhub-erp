<?php
namespace App\Services\Admin;
use App\Models\SystemSetting; use Illuminate\Support\Facades\Cache;
class SettingsService { public function all(): array { return Cache::rememberForever('system_settings',fn()=>SystemSetting::all()->groupBy('group')->map(fn($g)=>$g->pluck('value','key'))->toArray()); } public function put(string $group,string $key,?string $value,string $type='string'): SystemSetting { Cache::forget('system_settings'); return SystemSetting::updateOrCreate(compact('group','key'),compact('value','type')); } public function get(string $group,string $key,$default=null){ return data_get($this->all(),"$group.$key",$default); } }
