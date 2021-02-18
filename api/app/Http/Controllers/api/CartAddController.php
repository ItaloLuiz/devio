<?php 

namespace App\Http\Controllers\api;




use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;



class CartAddController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart =  session()->get('cart');
        return  $cart;
    }

    public function show(Request $request, $id)
    {
        $value = $request->session()->get('cart');
        return $value;

        //
    }


    public function store(Request $request)
    {        
       
        $id = $request->id;
        $product = DB::select('select * from products where id='.$id);
        $cart = Session::get('cart');

       

        $cart[$product[0]->cod_produto] = array(
            "id" => $product[0]->id,
            "nome_produto" => $product[0]->nome_produto,
            "valor" => $product[0]->valor_produto,
            "imagem" => $product[0]->imagem_produto            
        );
    
        Session::put('cart', $cart);
        Session::save();
        
 
       return $cart;

        
    }


}
