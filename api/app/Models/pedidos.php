<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pedidos extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'id_carrinho', 'nome_cliente', 'contato_cliente',
        'forma_pagamento','troco_cliente','endereco_cliente',
        'obs_cliente','status_pedido'
    ];
}
