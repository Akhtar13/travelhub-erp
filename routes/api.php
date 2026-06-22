<?php
use Illuminate\Support\Facades\Route; use App\Http\Controllers\Api\{AuthController,BookingApiController,RouteApiController,AgentApiController,PassengerApiController,ReportApiController};
Route::post('auth/login',[AuthController::class,'login']);
Route::middleware('api.token')->group(function(){ Route::post('auth/logout',[AuthController::class,'logout']); Route::apiResource('bookings',BookingApiController::class)->only(['index','store','show']); Route::get('routes',[RouteApiController::class,'index']); Route::get('agents',[AgentApiController::class,'index']); Route::get('passengers',[PassengerApiController::class,'index']); Route::get('reports/{type}',[ReportApiController::class,'show']); });
