<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; use App\Models\Passenger;
class PassengerApiController extends Controller { public function index(){ return Passenger::with('nationality')->latest()->paginate(25); } }
