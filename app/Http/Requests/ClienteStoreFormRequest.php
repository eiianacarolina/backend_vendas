<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClienteStoreFormRequest extends FormRequest
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
            'nome' => 'required|max:255',
            'email' => 'required|unique:App\Models\Cliente,email|email',
            'telefone' => 'required|max:255',
            'endereco' => 'required|max:255',
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
            'nome.required' => 'O campo nome é obrigatório',
            'nome.max'=> 'Você atingiu o número máximo de caracteres',
            'email.required' => 'O campo é obrigatório',
            'email.unique' => 'O campo é único',
            'email.email' => 'O campo está incorreto',
            'telefone.required' => 'O campo é obrigatório',
            'telefone.max'=> 'Você atingiu o número máximo de caracteres',
            'endereco.required' => 'O campo é obrigatório',
            'endereco.max'=> 'Você atingiu o número máximo de caracteres',
        ];
    }
}
