<?php

/*
O cadastro das imagens serve apenas para 
ter algo visual e ajudar nos testes.

Não implementei o update com imagens.

*/

namespace App\Http\Controllers\api;

use App\Models\products;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public $qtda_paginas = 20;

    public function index()
    {
        return products::paginate($this->qtda_paginas);
    }


    public function store(Request $request)
    {
        $uploadFolder = 'produtos';
        $image = $request->file('imagem_produto');
        $image_uploaded_path = $image->store($uploadFolder, 'public');

        $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
        );

        $imagem_produto = $uploadedImageResponse['image_name'];

        $uuid = Str::uuid()->toString();

        $products = products::create([
            'cod_produto'  => $uuid,
            'nome_produto'      => request('nome_produto'),
            'categoria_produto' => request('categoria_produto'),
            'valor_produto'     => request('valor_produto'),
            'imagem_produto'    => $imagem_produto
        ]);

        if (!$products) {
            $status = true;
            $message = 'Produto não cadastrado';
            $cod     = 409;
        } else {
            $status = false;
            $message = 'Produto Cadastrado';
            $cod     = 201;
        }

        return response()->json([
            'error'  => $status,
            'message' => $message
        ], $cod);
    }


    public function show($id)
    {
        return products::where('id', '=', $id)->paginate($this->qtda_paginas);
    }


    public function update(Request $request, $id)
    {
        $products = products::findOrFail($id)->update($request->all());

        if (!$products) {
            $status = true;
            $message = 'Produto não atualizado';
            $cod     = 409;
        } else {
            $status = false;
            $message = 'Produto atualizado';
            $cod     = 205;
        }

        return response()->json([
            'error'  => $status,
            'message' => $message
        ], $cod);
    }


    public function destroy($id)
    {

        $getImagem   =  products::findOrFail($id);
        $image_path  = public_path("\storage\produtos\\") . $getImagem->imagem_produto;
        $products = $getImagem->delete();

        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        if (!$products) {
            $status = true;
            $message = 'Produto não apagado';
            $cod     = 409;
        } else {
            $status = false;
            $message = 'Produto apagado';
            $cod     = 202;
        }

        return response()->json([
            'error'  => $status,
            'message' => $message
        ], $cod);
    }
}
