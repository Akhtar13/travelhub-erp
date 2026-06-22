<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; use App\Models\TravelRoute; use Illuminate\Support\Facades\Cache;
class RouteApiController extends Controller { public function index(){ return Cache::remember('api.routes',300,fn()=>TravelRoute::with('origin','destination','stops','charges')->where('status','active')->get()); } }
