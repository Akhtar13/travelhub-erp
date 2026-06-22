<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; use App\Services\Admin\ReportService;
class ReportApiController extends Controller { public function show(string $type,ReportService $r){ abort_unless(in_array($type,['bookings','passengers','agents','credits','revenue']),404); return $r->{$type}(request()->all()); } }
