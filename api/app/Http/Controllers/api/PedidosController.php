<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pedidos;

class PedidosController extends Controller
{
    public $qtda_paginas = 20;
   
    public function index()
    {
        return pedidos::paginate($this->qtda_paginas);
    }
 
  
    public function store(Request $request)
    {
        $orders = pedidos::create($request->all());

        if (!$orders) {
            $status = true;
            $message = 'Pedido não cadastrado';
            $cod     = 409;
        } else {
            $status = false;
            $message = 'Pedido Cadastrado';
            $cod     = 201;
        }

        return response()->json([
            'error'  => $status,
            'message' => $message
        ], $cod);
    }

    public function show($id)
    {
        return pedidos::where('id', '=', $id)->paginate($this->qtda_paginas);
    }  

    public function update(Request $request, $id)
    {
        $orders = pedidos::findOrFail($id)->update($request->all());

        if (!$orders) {
            $status = true;
            $message = 'Pedido não atualizado';
            $cod     = 409;
        } else {
            $status = false;
            $message = 'Pedido atualizado';
            $cod     = 205;
        }

        return response()->json([
            'error'  => $status,
            'message' => $message
        ], $cod);
    }

   
    public function destroy($id)
    {
        $orders = pedidos::findOrFail($id)->delete();

        if (!$orders) {
            $status = true;
            $message = 'Pedido não apagado';
            $cod     = 409;
        } else {
            $status = false;
            $message = 'Pedido apagado';
            $cod     = 202;
        }

        return response()->json([
            'error'  => $status,
            'message' => $message
        ], $cod);
    }
}

