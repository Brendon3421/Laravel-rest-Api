<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContatoEmpresaRequest extends FormRequest
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
            'empresa_id' =>'nullable',
            'sub_empresa_id' =>'nullable',
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'celular' => 'required|numeric',
            'telefone_fixo' => 'nullable',
            'imagem' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'descricao' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O campo "nome" é obrigatório.',
            'nome.string' => 'O campo "nome" deve ser uma string.',
            'nome.max' => 'O campo "nome" não pode ter mais de 255 caracteres.',
            'email.required' => 'O campo "email" é obrigatório.',
            'email.email' => 'O campo "email" deve ser um endereço de e-mail válido.',
            'email.max' => 'O campo "email" não pode ter mais de 255 caracteres.',
            'celular.required' => 'O campo "celular" é obrigatório.',
            'celular.numeric' => 'O campo "celular" deve ser um número.',
            'telefone_fixo.numeric' => 'O campo "telefone_fixo" deve ser um número.',
            'imagem.mimes' => 'O campo "imagem" deve ser um arquivo de imagem do tipo: jpeg, png, jpg, gif, svg.',
            'imagem.max' => 'O campo "imagem" não pode ter mais de 2 MB.',
            'descricao.string' => 'O campo "descricao" deve ser uma string.',
            'descricao.max' => 'O campo "descricao" não pode ter mais de 500 caracteres.',
        ];
    }
}
