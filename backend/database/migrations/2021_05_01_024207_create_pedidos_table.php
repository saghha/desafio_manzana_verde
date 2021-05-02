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
            $table->id();
            $table->unsignedBigInteger('id_cliente');
            $table->dateTime('fecha_pedido');
            $table->decimal('precio_pedido', 20, 2)->default(0.00);
            $table->text('notas')->nullable();
            $table->string('tipo_entrega')->nullable();
            $table->boolean('pagado')->default(false);
            $table->string('codigo_pedido');
            $table->string('direccion_entrega')->nullable();
            $table->boolean('entregado')->default(false);
            $table->string('tipo_pago')->default('EFECTIVO');
            $table->timestamps();
            $table->softDeletes();
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
