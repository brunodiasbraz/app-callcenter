<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClasseRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'course_id' => 'required_if:course_id,!=,null',
        ];
    }

    public function messages(): array
    {
        return[
            'name.required' => 'Campo nome da aula é obrigatório!',
            'description.required' => 'Campo descrição é obrigatório!',
            'course_id.required_if' => 'Dados incorretos!',
        ];
    }
}
