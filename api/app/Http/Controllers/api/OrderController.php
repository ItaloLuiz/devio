<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\orders;

class OrderController extends Controller
{
    public $qtda_paginas = 20;

    public function index()
    {
        return orders::paginate($this->qtda_paginas);
    }


    public function store(Request $request)
    {
        $orders = orders::create($request->all());

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
        return orders::where('id', '=', $id)->paginate($this->qtda_paginas);
    }


    public function update(Request $request, $id)
    {
        $orders = orders::findOrFail($id)->update($request->all());

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
        $orders = orders::findOrFail($id)->delete();

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
