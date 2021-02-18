<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'cod_produto', 'nome_produto',
        'valor_produto','imagem_produto','identificar_carrinho'
    ];
}
