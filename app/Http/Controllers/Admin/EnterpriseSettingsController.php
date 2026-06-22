<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Http\Requests\Admin\SettingsRequest; use App\Services\Admin\SettingsService;
class EnterpriseSettingsController extends Controller { public function edit(SettingsService $s){ return view('admin.settings.enterprise',['settings'=>$s->all()]); } public function update(SettingsRequest $r,SettingsService $s){ foreach($r->validated() as $k=>$v){ $s->put(in_array($k,['smtp_host','smtp_port'])?'smtp':(in_array($k,['company_name'])?'company':'booking'),$k,(string)$v); } return back(); } }
