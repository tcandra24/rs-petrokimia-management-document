<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class PreMemoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'regarding' => 'required',
            'content' => 'required',
            'file' => 'nullable|mimes:pdf|max:5000',
            'from_user_id' => 'required',
            'to_user_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'regarding.required' => 'Perihal wajib diisi',
            'content.required' => 'Isi wajib diisi',
            'file.mimes' => 'File harus mempunyai format pdf',
            'file.max' => 'File tidak boleh lebih dari 5MB',
            'from_user_id.required' => 'Pemohon wajib diisi',
            'to_user_id.required' => 'Termohon wajib diisi',
        ];
    }
}
