<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'status' => false,
                'erros' => $validator->errors()
            ], 422));
    }
// o erro 422 e quando deu erro por conta da validacao 

    public function rules(): array
    {
        // recuperar o id que esta sendo enviado na rota na url
        $userID =  $this->route('user');
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . ($userID ? $userID->id : null),
            'password' => 'required|min:6'
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            'name.required' => "O campo nome e Obrigatorio ",
            'email.required' => "O campo email e Obrigatorio",
            'email.email' => "voce e burro e nao sabe escrever um email arrombado",
            'email.unique' => "Email ja esta em Uso",
            'password.required' => "senha e obrigatorio",
            'password.min' => "o minimo e 6 caracteres ",
        ];
    }
}
