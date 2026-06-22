<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class AgentRouteAssignmentRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['agent_id'=>'required|exists:agents,id','travel_route_id'=>'required|exists:travel_routes,id','seat_quota'=>'required|integer|min:1','daily_limit'=>'required|integer|min:1','price'=>'nullable|numeric|min:0','status'=>'required|in:active,inactive']; } }
