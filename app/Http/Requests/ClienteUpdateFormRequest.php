<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClienteUpdateFormRequest extends FormRequest
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
            'nome' => 'max: 255',
            'email' => 'unique:App\Models\Cliente,email|email',
            'telefone' => 'max: 255',
            'endereco' => 'max: 255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Erro de Validação',
                'errors' => $validator->errors()
            ], 422)

        );
    }

    public function messages()
    {
        return [
            'nome.max' => 'Você atingiu o número máximo de caracteres',
            'email.unique' => 'O campo é único',
            'email.email' => 'O campo está incorreto',
            'telefone.max' => 'Você atingiu o número máximo de caracteres',
            'endereco.max' => 'Você atingiu o número máximo de caracteres',
        ];
    }
    

}
