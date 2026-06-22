<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class SettingsRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['smtp_host'=>'nullable|string','smtp_port'=>'nullable|integer','currency'=>'nullable|string|max:10','timezone'=>'required|string','company_name'=>'required|string|max:255','seat_hold_duration'=>'required|integer|min:1|max:120']; } }
