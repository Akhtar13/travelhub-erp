<?php
namespace App\Http\Requests\Admin; use Illuminate\Foundation\Http\FormRequest;
class MasterDataRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['name'=>'required|max:255','code'=>'nullable|max:50','status'=>'required|in:active,inActive','region_id'=>'nullable|exists:regions,id','email'=>'nullable|email','phone'=>'nullable|max:50','address'=>'nullable']; } }
