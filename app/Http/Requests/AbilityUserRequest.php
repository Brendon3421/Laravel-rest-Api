<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbilityUserRequest extends FormRequest
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
            'abilities' => 'required|array',
            'abilities.*.user_id' => 'required|integer|exists:users,id',
            'abilities.*.ability_id' => 'required|integer|exists:abilities,id'
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.numeric' => 'O campo dever um numero',
            'user_id.required' => 'O campo e obrigatorio',
            'ability_id.required' => 'O campo dever um numero',
            'ability_id.required' => 'O campo e obrigatorio',

        ];
    }
}
