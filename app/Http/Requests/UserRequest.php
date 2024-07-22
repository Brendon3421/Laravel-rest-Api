<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'status' => false,
                'errors' => $validator->errors()
            ], 422));
    }

    public function rules(): array
    {
        $userID = $this->route('user');
        return [
            'name' => 'required' . ($userID ? $userID->id : null),
            'email' => 'required|email|unique:users,email,' . ($userID ? $userID->id : null),
            'password' => 'required|min:6',
            'genero_id' => 'required'. ($userID ? $userID->id : null)
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "O campo nome é obrigatório.",
            'email.required' => "O campo email é obrigatório.",
            'email.email' => "O campo deve ser um e-mail válido.",
            'email.unique' => "Email já está em uso.",
            'password.required' => "Senha é obrigatória.",
            'password.min' => "O mínimo é 6 caracteres.",
            'genero_id.required' => "O campo de genero e obrigatorio",
        ];
    }
}

