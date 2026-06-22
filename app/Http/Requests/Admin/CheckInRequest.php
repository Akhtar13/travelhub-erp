<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class CheckInRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['booking_id'=>'required_without:qr|exists:bookings,id','qr'=>'required_without:booking_id|string','exit_fee'=>'nullable|numeric|min:0','method'=>'nullable|in:manual,qr']; } }
