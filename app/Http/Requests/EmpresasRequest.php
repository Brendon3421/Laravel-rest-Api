<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class EmpresasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'status' => false,
                'errors' => $validator->errors()
            ],
            422
        ));
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $empresaid = $this->route('empresas');
        // dd($empresaid->id);
        return [
            "name" => 'required|string',
            "user_id" => 'nullable|exists:users,id', // Verifique se a tabela 'users' é correta
            "situacao_id" => 'required|exists:situacao,id',
            "endereco_id" => 'nullable|exists:endereco,id',
            "contato_empresa_id" => 'nullable|exists:contato_empresa,id',
            "cnpj" =>   'required|unique:empresas,cnpj,'. ($empresaid ? $empresaid->id : 'null'),
            "inscricao_estadual" => 'required|string|max:255',
            "fundacao" => 'required|date',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'O nome da empresa é obrigatório.',
            'name.string' => 'O nome da empresa deve ser uma sequência de caracteres válida.',

            'cnpj.required' => 'O CNPJ da empresa é obrigatório.',
            'cnpj.unique' => 'O CNPJ digitado ja existe!',

            'razao_social.required' => 'A razão social da empresa é obrigatória.',
            'razao_social.string' => 'A razão social deve ser uma sequência de caracteres válida.',
            'razao_social.max' => 'A razão social não pode exceder 255 caracteres.',

            'inscricao_estadual.required' => 'A inscrição estadual da empresa é obrigatória.',
            'inscricao_estadual.string' => 'A inscrição estadual deve ser uma sequência de caracteres válida.',
            'inscricao_estadual.max' => 'A inscrição estadual não pode exceder 255 caracteres.',

            'fundacao.required' => 'A data de fundação da empresa é obrigatória.',
            'fundacao.date' => 'A data de fundação deve ser uma data válida.',

            'situacao_id.required' => 'A situação da empresa é obrigatória.',
            'situacao_id.exists' => 'A situação selecionada não é válida.',

            'endereco_id.required' => 'O endereço da empresa é obrigatório.',
            'endereco_id.exists' => 'O endereço selecionado não é válido.',

            'contato_empresa_id.required' => 'O contato da empresa é obrigatório.',
            'contato_empresa_id.exists' => 'O contato selecionado não é válido.',
        ];
    }
}
