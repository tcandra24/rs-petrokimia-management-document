<?php

namespace App\Http\Requests\Transaction\PreMemo;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRequest extends FormRequest
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
            'note' => 'required',
            'status' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'note.required' => 'Catatan harus diisi',
            'status.required' => 'Status harus diisi',
        ];
    }
}
