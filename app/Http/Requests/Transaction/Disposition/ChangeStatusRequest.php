<?php

namespace App\Http\Requests\Transaction\Disposition;

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
        $rules = [
            'is_urgent' => 'required',
            'sub_divisions' => 'nullable',
            'note' => 'nullable',
            'status' => 'required',
        ];

        if($this->input('status') === 'approve') {
            $rules['instructions'] = 'required';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'is_urgent.required' => 'Sifat harus diisi',
            'sub_divisions.required' => 'Unit harus diisi',
            'instructions.required' => 'Instruksi harus diisi',
            'note.required' => 'Catatan harus diisi',
            'status.required' => 'Status harus diisi',
        ];
    }
}
