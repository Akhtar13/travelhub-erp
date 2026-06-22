<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class SeatLayoutRequest extends FormRequest { public function authorize(): bool { return $this->user()->can('manage', \App\Models\SeatLayout::class); } public function rules(): array { return ['name'=>'required|max:255','rows'=>'required|integer|min:1|max:20','columns'=>'required|integer|min:1|max:10','status'=>'required|in:active,inActive','blocked_seats'=>'array','blocked_seats.*'=>'string']; } }
