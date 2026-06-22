<?php
namespace App\Http\Requests\Admin; use Illuminate\Foundation\Http\FormRequest;
class CompanySettingRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['company_name'=>'required|max:255','logo'=>'nullable|image|max:2048','email'=>'nullable|email','phone'=>'nullable|max:50','currency_id'=>'nullable|exists:currencies,id','timezone'=>'required|timezone','language_id'=>'nullable|exists:languages,id']; } }
