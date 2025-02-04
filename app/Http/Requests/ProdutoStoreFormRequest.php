<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProdutoStoreFormRequest extends FormRequest
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
            'nome'=> 'required|max:255',
            'codigo'=> 'required|unique:App\Models\Produto,codigo',
            'preco'=> 'Required|max:10,2',
            'quantidade_estoque'=>'required|min:1',
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
            'codigo.required'=> 'O campo nome é obrigatório',
            'codigo.unique'=>'O campo é único',
            'preco.required'=>'O campo nome é obrigatório',
            'preco.max'=>'Você atingiu o número máximo de caracteres',
            'quantidade_estoque.required'=> 'O campo nome é obrigatório',
            'quantidade_estoque.min'=> 'Você precisa de 1 no mínimo',
        ];
    }
}
