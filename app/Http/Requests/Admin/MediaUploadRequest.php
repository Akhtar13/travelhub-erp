<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class MediaUploadRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['file'=>'required|file|max:10240','collection'=>'required|in:company-logo,passenger-documents,invoices,attachments']; } }
