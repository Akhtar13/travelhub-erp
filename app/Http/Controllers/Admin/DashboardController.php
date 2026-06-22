<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\{User,Region,Location,ActivityLog};
class DashboardController extends Controller { public function __invoke(){return view('admin.dashboard.index',['cards'=>['Total Users'=>User::count(),'Total Routes'=>0,'Total Locations'=>Location::count(),'Total Agents'=>0,'Total Bookings'=>0,'Revenue'=>0],'activities'=>ActivityLog::latest()->limit(10)->get(),'monthlyBookings'=>array_fill(0,12,0),'revenue'=>array_fill(0,12,0)]);} }
