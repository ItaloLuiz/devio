<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod_pedido');
            $table->string('nome_produto');
            $table->string('quantidade_produto');
            $table->string('valor_produto');
            $table->string('nome_cliente');
            $table->string('contato_cliente');
            $table->string('obs_pedido');
            $table->string('status_pedido'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
