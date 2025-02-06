<?php

namespace App\Http\Controllers;

use App\Models\ItemVenda;
use Illuminate\Http\Request;

class ItemVendaController extends Controller
{
    public function index()
    {
        $item_venda = ItemVenda::all();

        return response()->json([
            'status' => true,
            'data' => $item_venda
        ]);
    }
}
