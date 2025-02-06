<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VendaStoreFormRequest extends FormRequest
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
            'cliente_id'=> 'required',
            'desconto'=> 'required'
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
           'cliente_id.required'=> 'O campo é obrigatório',
           'desconto.required'=> 'O campo é obrigatório'
        ];
    }
}
