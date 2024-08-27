<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

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
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'status' => false,
                'errors' => $validator->errors()
            ],
            422
        ));
    }

    public function rules(): array
    {
        // dd($contatoEmpresa_id);
        return [
            'empresa_id' => 'nullable',
            'sub_empresa_id' => 'nullable',
            'nome' => 'required|string|max:255',
            // 'email' => 'required|email|max:255|unique:contato_empresa,email,'. ($ ? $contatoEmpresa_id : 'null'),
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
            'empresa_id.nullable' => 'O campo "empresa_id" é opcional.',
            'sub_empresa_id.nullable' => 'O campo "sub_empresa_id" é opcional.',

            'nome.required' => 'O campo "nome" é obrigatório.',
            'nome.string' => 'O campo "nome" deve ser um texto.',
            'nome.max' => 'O campo "nome" não pode ter mais de 255 caracteres.',

            'email.required' => 'O campo "email" é obrigatório.',
            'email.email' => 'O campo "email" deve ser um endereço de e-mail válido.',
            'email.max' => 'O campo "email" não pode ter mais de 255 caracteres.',
            'email.unique' => 'O e-mail fornecido já está sendo utilizado.',

            'celular.required' => 'O campo "celular" é obrigatório.',
            'celular.numeric' => 'O campo "celular" deve conter apenas números.',

            'telefone_fixo.numeric' => 'O campo "telefone fixo" deve conter apenas números.',

            'imagem.mimes' => 'O campo "imagem" deve ser um arquivo de imagem do tipo: jpeg, png ou jpg.',
            'imagem.max' => 'O campo "imagem" não pode ter mais de 2 MB.',

            'descricao.string' => 'O campo "descrição" deve ser um texto.',
            'descricao.max' => 'O campo "descrição" não pode ter mais de 500 caracteres.',
        ];
    }
}
