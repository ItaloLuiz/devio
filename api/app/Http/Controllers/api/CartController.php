<?php

namespace App\Http\Controllers\api;





use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\products;
use App\Models\cart;

class CartController extends Controller
{
   
    public function index()
    {
        return cart::all();
    }


    public function store(Request $request)
    {
        $id = $request->id;
        $identificar_carrinho = $request->identificar_carrinho;
        
        $products = products::findOrFail($id);
        
        
        $cod_produto  = $products['cod_produto'];
        $nome_produto = $products['nome_produto'];       
        $valor_produto = $products['valor_produto'];
        $imagem_produto = $products['imagem_produto'];
        

        $cart = cart::create([
            'cod_produto'       => $cod_produto,
            'nome_produto'      => $nome_produto,           
            'valor_produto'     => $valor_produto,
            'imagem_produto'    => $imagem_produto,
            'identificar_carrinho' => $identificar_carrinho
        ]);

        if (!$cart) {
            $status = true;
            $message = 'Não inserido no carrinho';
            $cod     = 409;
        } else {
            $status = false;
            $message = 'Inserido no carrinho';
            $cod     = 201;
        }
        return response()->json([
            'error'  => $status,
            'message' => $message
        ], $cod);



    }

  
    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $cart = cart::findOrFail($id)->delete();

        if (!$cart) {
            $status = true;
            $message = 'não removido';
            $cod     = 409;
        } else {
            $status = false;
            $message = 'Item removido';
            $cod     = 202;
        }

        return response()->json([
            'error'  => $status,
            'message' => $message,
            'id'     => $id
        ], $cod);
    }
}
