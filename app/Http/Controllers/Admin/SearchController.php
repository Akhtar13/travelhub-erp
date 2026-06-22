<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\{Agent,Booking,Passenger};
class SearchController extends Controller { public function __invoke(){ $q=request('q'); return view('admin.search.index',['q'=>$q,'bookings'=>$q?Booking::with('passenger')->where('pnr','like',"%$q%")->limit(10)->get():collect(),'passengers'=>$q?Passenger::where('first_name','like',"%$q%")->orWhere('last_name','like',"%$q%")->limit(10)->get():collect(),'agents'=>$q?Agent::where('name','like',"%$q%")->orWhere('company','like',"%$q%")->limit(10)->get():collect()]); } }
