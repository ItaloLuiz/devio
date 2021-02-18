<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'cod_pedido', 'nome_produto', 'quantidade_produto',
        'valor_produto','nome_cliente','contato_cliente','obs_pedido','status_pedido'
    ];
}
