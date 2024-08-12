<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContatosRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'empresa_id' => 'required|exists:empresas,id',
            'email' => 'required|email|max:255',
            'celular' => 'nullable|digits_between:10,15',
            'telefone_fixo' => 'nullable|digits_between:10,15',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo usuário é obrigatório.',
            'user_id.exists' => 'O usuário selecionado não é válido.',
            'empresa_id.required' => 'O campo empresa é obrigatório.',
            'empresa_id.exists' => 'A empresa selecionada não é válida.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'email.max' => 'O campo email não pode ter mais que 255 caracteres.',
            'celular.digits_between' => 'O campo celular deve ter entre 10 e 15 dígitos.',
            'telefone_fixo.digits_between' => 'O campo telefone fixo deve ter entre 10 e 15 dígitos.',
        ];
    }
}
