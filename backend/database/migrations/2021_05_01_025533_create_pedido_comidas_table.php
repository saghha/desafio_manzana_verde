<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoComidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_comidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_comida');
            $table->unsignedBigInteger('cantidad')->default(1);
            $table->decimal('precio', 20, 2);
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
        Schema::dropIfExists('pedido_comidas');
    }
}
