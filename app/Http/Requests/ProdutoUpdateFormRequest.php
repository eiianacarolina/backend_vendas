<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProdutoUpdateFormRequest extends FormRequest
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
            'nome'=> 'max:255',
            'codigo'=> 'unique:App\Models\Produto,codigo',
            'preco'=> '|max:10,2',
            'quantidade_estoque'=>'min:1',
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
            'nome.max'=> 'Você atingiu o número máximo de caracteres',
            'codigo.unique'=>'O campo é único',
            'preco.max'=>'Você atingiu o número máximo de caracteres',
            'quantidade_estoque.min'=> 'Você precisa de 1 no mínimo',
        ];
    }
}
