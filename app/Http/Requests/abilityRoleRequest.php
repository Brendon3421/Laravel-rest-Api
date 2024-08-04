<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class abilityRoleRequest extends FormRequest
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
            'roles' => 'required|array',
            'roles.*.role_id' => 'required|numeric',
            'roles.*.ability_id' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'roles.required' => 'O campo roles é obrigatório.',
            'roles.array' => 'O campo roles deve ser um array.',
            'roles.*.role_id.required' => 'O campo role_id é obrigatório.',
            'roles.*.role_id.numeric' => 'O campo role_id deve ser um número.',
            'roles.*.ability_id.required' => 'O campo ability_id é obrigatório.',
            'roles.*.ability_id.numeric' => 'O campo ability_id deve ser um número.',
        ];
    }
}
