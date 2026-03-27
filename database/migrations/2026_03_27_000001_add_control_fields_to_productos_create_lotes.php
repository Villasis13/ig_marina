<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Agregar columnas control_serie y control_lote a productos
        Schema::table('productos', function (Blueprint $table) {
            $table->tinyInteger('control_serie')->default(0)->after('impuesto_bolsa');
            $table->tinyInteger('control_lote')->default(0)->after('control_serie');
        });

        // 2. Migrar datos existentes: tipo_control='serie' → control_serie=1
        if (Schema::hasColumn('productos', 'tipo_control')) {
            DB::statement("UPDATE productos SET control_serie = 1 WHERE tipo_control = 'serie'");
            Schema::table('productos', function (Blueprint $table) {
                $table->dropColumn('tipo_control');
            });
        }

        // 3. Crear tabla lotes
        Schema::create('lotes', function (Blueprint $table) {
            $table->id('id_lote');
            $table->unsignedBigInteger('id_pro');
            $table->string('numero_lote');
            $table->date('fecha_vencimiento')->nullable();
            $table->integer('cantidad')->default(0);
            $table->text('observaciones')->nullable();
            $table->string('estado')->default('disponible'); // disponible, agotado
            $table->unsignedBigInteger('id_orden_compra')->nullable();
            $table->timestamps();
            $table->foreign('id_pro')->references('id_pro')->on('productos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lotes');

        Schema::table('productos', function (Blueprint $table) {
            $table->string('tipo_control')->nullable()->after('impuesto_bolsa');
            if (Schema::hasColumn('productos', 'control_lote')) {
                $table->dropColumn('control_lote');
            }
            if (Schema::hasColumn('productos', 'control_serie')) {
                $table->dropColumn('control_serie');
            }
        });
    }
};
