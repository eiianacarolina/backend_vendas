<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function store(Request $request)
    {
        $p = 0;

        foreach ($request->itens as $item) {
            $p += $item['quantidade'] * $item['preco'];
        }

        $venda = Venda::create([
            'cliente_id' => $request->cliente_id,
            'desconto' => $request->desconto,
            'data_venda' => date('Y-m-d H:i:s'),
            'subtotal' => $p,
            'total' => $p - $request->desconto
        ]);



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
}
