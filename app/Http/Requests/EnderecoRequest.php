<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;

class EnderecoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */    public function authorize(): bool
    {
        return true;
    }


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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    //chatgpt que fez
    public function rules(): array
    {
        $enderecoID = $this->route('endereco');

        return [
            'user_id' => [
                'nullable', // Permite que o campo seja nulo durante a criação
                'exists:users,id',
                function ($attribute, $value, $fail) use ($enderecoID) {
                    if ($enderecoID) {
                        $exists = DB::table('endereco')
                            ->where('user_id', $value)
                            ->where('id', '!=', $enderecoID)
                            ->exists();

                        if ($exists) {
                            $fail('O user_id já está associado a outro endereço.');
                        }
                    }
                }
            ],
            'situacao_id' => 'nullable|exists:situacao,id',
            'name' => 'required|string|max:255',
            'cep' => 'required|numeric',
            'rua' => 'required|string|max:255',
            'numero' => 'required|numeric',
            'complemento' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo user_id é obrigatório.',
            'user_id.exists' => 'O campo user_id deve corresponder a um usuário existente.',
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve ter no máximo :max caracteres.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'cep.numeric' => 'O campo CEP deve ser um número.',
            'rua.required' => 'O campo rua é obrigatório.',
            'rua.string' => 'O campo rua deve ser uma string.',
            'rua.max' => 'O campo rua deve ter no máximo :max caracteres.',
            'numero.required' => 'O campo número é obrigatório.',
            'numero.numeric' => 'O campo número deve ser um número.',
            'complemento.nullable' => 'O campo complemento é opcional.',
            'complemento.string' => 'O campo complemento deve ser uma string.',
            'complemento.max' => 'O campo complemento deve ter no máximo :max caracteres.',
            'situacao_id.required' => 'O campo situacao e obrigatorio'
        ];
    }
}
