<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            // $table->integer('id_producto')->unsigned();
            // $table->string('nombre');
            // $table->integer('cantidad')->unsigned();
            $table->text('productos');
            $table->date('fecha');
            $table->string('nombre_cliente');
            $table->string('observaciones')->nullable();
            $table->string('sala');
            $table->string('asiento');
            $table->time('hora');
            $table->string('estado');

            $table->string('codigo_cliente');
            $table->integer('puntos')->unsigned();
            $table->double('costo_final', 8, 2);

            $table->string('numero_venta');

            // $table->unsignedBigInteger('pedido_id');
            // $table->string('nombre');
            // $table->integer('cantidad')->unsigned();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
