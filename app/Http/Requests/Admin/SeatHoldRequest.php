<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class SeatHoldRequest extends FormRequest { public function authorize(): bool { return $this->user()->can('manage', \App\Models\Booking::class); } public function rules(): array { return ['travel_schedule_id'=>'required|exists:travel_schedules,id','seat_ids'=>'required|array|min:1','seat_ids.*'=>'integer|exists:seats,id']; } }
