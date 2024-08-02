<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleUserRequest extends FormRequest
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
            'role_id' => "required|numeric",
            'user_id' => "required|numeric"
        ];
    }

    public function messages(): array
    {
        return [
            'role_id.required' => 'O campo e obrigatorio',
            'role_id.numeric' => 'O campo deve ser um numero',
            'user_id.required' => 'O campo e obrigatorio',
            'user_id.numeric' => 'O campo deve ser um numero',
        ];
    }
}
