<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class WalletTransactionRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['amount'=>'required|numeric|min:0.01','description'=>'nullable|string|max:1000']; } }
