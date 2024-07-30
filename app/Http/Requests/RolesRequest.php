<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest
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
            'name' => 'required|string|max:255|nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Esse campo e obrigatorio',
            'name.string' => 'Esse campo deve ser um texto',
            'name.max' => 'Esse campo nao pode ter mais de :max caracteres',
            'name.nullable' => 'Esse campo nao pode ser nulo',
        ];
    }
}
