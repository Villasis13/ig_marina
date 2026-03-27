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
        Schema::create('proformas_detalles', function (Blueprint $table) {
            $table->id('id_profo_deta');
            $table->foreignId('id_profo')->references('id_profo')->on('proformas');
            $table->foreignId('id_pro')->references('id_pro')->on('productos');
            $table->decimal('profo_deta_precio',10,2);
            $table->integer('profo_deta_cantidad');
            $table->string('profo_deta_observacion',500);
            $table->tinyInteger('profo_deta_estado');
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
        Schema::dropIfExists('proformas_detalles');
    }
};
