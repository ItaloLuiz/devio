<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customers extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'cod_cliente', 'nome_cliente', 'email_cliente',
        'cel_cliente','endereco_cliente'
    ];
}
