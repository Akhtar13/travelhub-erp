<?php
namespace App\Http\Requests\Admin; use Illuminate\Foundation\Http\FormRequest; use Illuminate\Validation\Rule;
class UserRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { $id=$this->route('user')?->id; return ['name'=>'required|string|max:255','email'=>['required','email',Rule::unique('users')->ignore($id)],'password'=>[$id?'nullable':'required','confirmed','min:8'],'phone'=>'nullable|string|max:50','avatar'=>'nullable|image|max:2048','status'=>'required|in:active,inActive','roles'=>'array','permissions'=>'array']; } }
