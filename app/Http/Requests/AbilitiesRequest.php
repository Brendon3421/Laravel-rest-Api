<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbilitiesRequest extends FormRequest
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
            'name' => 'required|nullable|string|max:255'
        ];
    }

    public function messages():array
    {
        return [
            'name.nullable' => 'O campo nao pode ser nulo',
            'name.required' => 'O campo e obrigatorio ',
            'name.string' => 'O campo deve ser um texto',
            'name.max' => 'O campo deve ter no :max',
        ];
    }
}
