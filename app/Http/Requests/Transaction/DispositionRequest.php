<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class DispositionRequest extends FormRequest
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
            'memo_id' => 'nullable',
            'file' => 'nullable|mimes:pdf|max:5000'
        ];
    }

    public function messages(): array
    {
        return [
            'file.mimes' => 'File harus mempunyai format pdf',
            'file.max' => 'File tidak boleh lebih dari 5MB'
        ];
    }
}
