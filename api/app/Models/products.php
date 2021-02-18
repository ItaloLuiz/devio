<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'cod_produto', 'nome_produto', 'categoria_produto',
        'valor_produto','imagem_produto'
    ];
}
