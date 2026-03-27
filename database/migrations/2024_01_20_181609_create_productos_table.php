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
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_pro');
            $table->foreignId('id_ca')->references('id_ca')->on('categorias');
            $table->foreignId('id_medida')->references('id_medida')->on('medida');
            $table->foreignId('id_tipo_afectacion')->references('id_tipo_afectacion')->on('tipo_afectacion');
            $table->string('pro_nombre');
            $table->string('pro_codigo');
            $table->string('pro_descripcion')->nullable();
            $table->string('pro_presentacion')->nullable();
            $table->string('pro_medida')->nullable();
            $table->decimal('pro_precio_valor',10,2);
            $table->decimal('pro_precio_uni',10,2);
            $table->decimal('pro_precio_valor_ma',10,2);
            $table->decimal('pro_precio_uni_ma',10,2);
            $table->decimal('pro_porcen_igv',10,2);
            $table->string('pro_foto');
            $table->integer('pro_stock')->nullable();
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
        Schema::dropIfExists('productos');
    }
};
