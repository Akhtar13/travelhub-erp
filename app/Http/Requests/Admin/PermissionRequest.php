<?php
namespace App\Http\Requests\Admin; use Illuminate\Foundation\Http\FormRequest; use Illuminate\Validation\Rule;
class PermissionRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { $id=$this->route('permission')?->id; return ['name'=>['required','max:255',Rule::unique('permissions')->ignore($id)]]; } }
