<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customers;

class CustomerController extends Controller
{
    public $qtda_paginas = 20;


    public function index()
    {
        return customers::paginate($this->qtda_paginas);
    }

    public function store(Request $request)
    {
        $customer = customers::create($request->all());

        if (!$customer) {
            $status = true;
            $message = 'Cliente não cadastrado';
            $cod     = 409;
        } else {
            $status = false;
            $message = 'Cliente Cadastrado';
            $cod     = 201;
        }

        return response()->json([
            'error'  => $status,
            'message' => $message
        ], $cod);
    }

    public function show($id)
    {
        return customers::where('id', '=', $id)->paginate($this->qtda_paginas);
    }

    public function update(Request $request, $id)
    {
        $customer = customers::findOrFail($id)->update($request->all());

        if (!$customer) {
            $status = true;
            $message = 'Cliente não atualizado cadastrado';
            $cod     = 409;
        } else {
            $status = false;
            $message = 'Cliente Atualizado';
            $cod     = 205;
        }

        return response()->json([
            'error'  => $status,
            'message' => $message
        ], $cod);
    }

    public function destroy($id)
    {
        $customer = customers::findOrFail($id)->delete();

        if (!$customer) {
            $status = true;
            $message = 'Cliente não apagado';
            $cod     = 409;
        } else {
            $status = false;
            $message = 'Cliente Apagado';
            $cod     = 202;
        }

        return response()->json([
            'error'  => $status,
            'message' => $message
        ], $cod);
    }
}
