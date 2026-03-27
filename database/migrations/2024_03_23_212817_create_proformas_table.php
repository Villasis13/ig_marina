<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proformas', function (Blueprint $table) {
            $table->id('id_profo');
            $table->foreignId('id_clientes')->references('id_clientes')->on('clientes');
            $table->foreignId('id_users')->references('id_users')->on('users');
            $table->tinyInteger('profo_forma_pago');
            $table->string('profo_lugar_entrega',500)->nullable();
            $table->string('profo_observacion',1000)->nullable();
            $table->string('profo_serie');
            $table->integer('profo_correlativo');
            $table->date('profo_fecha_emision');
            $table->tinyInteger('profo_estado')->comment('1 activo , 0 inactivo');
            $table->tinyInteger('profo_acti_estado')->comment('0 creado , 1 aprobado para la venta , 2 entregado/vendido');
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
        Schema::dropIfExists('proformas');
    }
};
