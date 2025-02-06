<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendaStoreFormRequest;
use App\Http\Requests\VendaUpdateFormRequest;
use App\Models\ItemVenda;
use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function store(VendaStoreFormRequest $request)
    {
        $venda = Venda::create([
            'cliente_id' => $request->cliente_id,
            'desconto' => $request->desconto,
            'data_venda' => date('Y-m-d H:i:s'),
            'subtotal' => 0,
            'total' => 0
        ]);

        $subtotal = 0;
        //add os itens da venda percorrendo o for
        foreach ($request->itens as $item) {
            $subtotal += $item['quantidade'] * $item['preco'];

            $produto = Produto::find($item['produto_id']);

            if ($produto->quantidade_estoque == 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Este produto não está disponível'
                ]);
            }

            $produto->quantidade_estoque =  $produto->quantidade_estoque - $item['quantidade'];

            $item_venda = ItemVenda::create([
                'venda_id' => $venda->id,
                'produto_id' => $item['produto_id'],
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $item['preco'],
                'subtotal_item' => $subtotal
            ]);

            $produto->update();
        }

        // atualizar subtotal da venda e total da venda
        $venda->subtotal = $subtotal;
        $venda->total = $subtotal - $request->desconto;
        $venda->update();

        return response()->json([
            'status' => true,
            'data' => $venda
        ]);
    }

    public function index()
    {
        $vendas = Venda::all();

        return response()->json([
            'status' => true,
            'data' => $vendas
        ]);
    }

    public function show($id)
    {
        $venda = Venda::find($id);

        if ($venda == null) {
            return response()->json([
                'status' => false,
                'message' => 'Usuário não encontrado'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Usuário encntrado',
            'data' => $venda
        ]);
    }

    public function update(VendaUpdateFormRequest $request, $id)
    {
        $venda = Venda::find($request->id);

        if ($venda == null) {
            return response()->json([
                'status' => false,
                'message' => 'Produto não encontrado'
            ]);
        }

        if (isset($request->cliente_id)) {
            $venda->cliente_id = $request->cliente_id;
        }


        $venda->update();

        return response()->json([
            'status' => true,
            'message' => 'Informações Atualizadas',
            'data' => $venda
        ]);
    }
}
