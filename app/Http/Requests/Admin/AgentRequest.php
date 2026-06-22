<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class AgentRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['name'=>'required|string|max:255','company'=>'required|string|max:255','credit_balance'=>'nullable|numeric|min:0','currency_id'=>'nullable|exists:currencies,id','contact'=>'nullable|string|max:100','email'=>'nullable|email|max:255','status'=>'required|in:active,inactive,suspended']; } }
