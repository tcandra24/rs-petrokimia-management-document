<?php

namespace App\Http\Requests\Transaction\DigitalSignature;

use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest extends FormRequest
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
            'number_transaction' => 'required',
            'signature' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'number_transaction.required' => 'Nomer transaksi wajib diisi',
            'signature.required' => 'Signature wajib diisi'
        ];
    }
}
