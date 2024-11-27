<?php

namespace App\Http\Requests\Setting\User;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
        $user = $this->route('user');

        return [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'roles' => 'required',
            'password' => 'nullable|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'nullable|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'roles.required' => 'Peran harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.required_with' => 'Konfirmasi password harus diisi',
            'password.same' => 'Password dan Konfirmasi password harus sama',
            'confirm_password.min' => 'Konfirmasi password minimal 6 karakter',
        ];
    }
}
