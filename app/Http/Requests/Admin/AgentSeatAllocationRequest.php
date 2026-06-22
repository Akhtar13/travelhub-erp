<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class AgentSeatAllocationRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['agent_id'=>'required|exists:agents,id','travel_schedule_id'=>'required|exists:travel_schedules,id','allocated_seats'=>'required|integer|min:1','status'=>'required|in:active,inactive']; } }
