<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresasRequest extends FormRequest
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
            "name" => 'required|string|max:255|min:10',
            "cnpj" => 'required|size:14',
            "razao_social" => 'required|string|max:255',
            "inscricao_estadual" => 'required|string|max:255',
            "fundacao" => 'required|date',
            "situacao_id" => 'required|exists:situacao,id',
            "endereco_id"=> 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            'name.min' => 'O campo nome deve ter pelo menos 10 caracteres.',

            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'cnpj.size' => 'O campo CNPJ deve ter exatamente 14 caracteres.',

            'razao_social.required' => 'O campo razão social é obrigatório.',
            'razao_social.string' => 'O campo razão social deve ser uma string.',
            'razao_social.max' => 'O campo razão social não pode ter mais de 255 caracteres.',

            'inscricao_estadual.required' => 'O campo inscrição estadual é obrigatório.',
            'inscricao_estadual.string' => 'O campo inscrição estadual deve ser uma string.',
            'inscricao_estadual.max' => 'O campo inscrição estadual não pode ter mais de 255 caracteres.',

            'fundacao.required' => 'O campo fundação é obrigatório.',
            'fundacao.date' => 'O campo fundação deve ser uma data válida.',

            'situacao_id.required' => 'O campo situação é obrigatório.',
            'situacao_id.integer' => 'O campo situação deve ser um número inteiro.',
            'situacao_id.exists' => 'A situação selecionada é inválida.',

            'endereco_id.required' => 'O campo endereço é obrigatório.',
            'endereco_id.integer' => 'O campo endereço deve ser um número inteiro.',
            'endereco_id.exists' => 'O endereço selecionado é inválido.',

            'contato_id.integer' => 'O campo contato deve ser um número inteiro.',
            'contato_id.exists' => 'O contato selecionado é inválido.',
        ];
    }
}
