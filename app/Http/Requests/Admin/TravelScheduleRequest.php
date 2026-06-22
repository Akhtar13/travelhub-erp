<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class TravelScheduleRequest extends FormRequest { public function authorize(): bool { return $this->user()->can('manage', \App\Models\TravelSchedule::class); } public function rules(): array { return ['travel_route_id'=>'required|exists:travel_routes,id','seat_layout_id'=>'required|exists:seat_layouts,id','departure_at'=>'required|date','arrival_at'=>'nullable|date|after:departure_at','base_fare'=>'required|numeric|min:0','status'=>'required|in:scheduled,cancelled,completed']; } }
