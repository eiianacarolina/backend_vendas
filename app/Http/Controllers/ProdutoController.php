<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoStoreFormRequest;
use App\Http\Requests\ProdutoUpdateFormRequest;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function store(ProdutoStoreFormRequest $request)
    {
        $produto = Produto::create([
            'nome' => $request->nome,
            'codigo' => $request->codigo,
            'preco' => $request->preco,
            'quantidade_estoque' => $request->quantidade_estoque
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Produto cadastrado',
            'data' => $produto
        ]);
    }

    public function index()
    {
        $produtos = Produto::all();

        return response()->json([
            'status' => true,
            'data' => $produtos
        ]);
    }

    public function show($id)
    {
        $produto = Produto::find($id);

        if ($produto == null) {
            return response()->json([
                'status' => false,
                'message' => 'Usuário não encontrado'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Usuário encntrado',
            'data' => $produto
        ]);
    }

    public function update(ProdutoUpdateFormRequest $request, $id)
    {
        $produto = Produto::find($request->id);

        if ($produto == null) {
            return response()->json([
                'status' => false,
                'message' => 'Produto não encontrado'
            ]);
        }

        if (isset($request->nome)) {
            $produto->nome = $request->nome;
        }

        if (isset($request->codigo)) {
            $produto->nome = $request->nome;
        }

        if (isset($request->preco)) {
            $produto->preco = $request->preco;
        }

        if (isset($request->quantidade_estoque)) {
            $produto->quantidade_estoque = $request->quantidade_estoque;
        }

        $produto->update();

        return response()->json([
            'status' => true,
            'message' => 'Informações Atualizadas',
            'data' => $produto
        ]);
    }

    public function delete($id)
    {
        $produto = Produto::find($id);

        if ($produto == null) {
            return response()->json([
                'status' => false,
                'message' => 'Cliente não encontrado'
            ]);
        }

        $produto->delete();

        return response()->json([
            'status' => true,
            'message' => 'Produto Deletado'
        ]);
    }
}
