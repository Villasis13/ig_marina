<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Columnas GRE a empresa
        Schema::table('empresa', function (Blueprint $table) {
            $table->string('empresa_gre_id')->nullable()->after('empresa_ruta_certificado');
            $table->string('empresa_gre_clave')->nullable()->after('empresa_gre_id');
            $table->string('empresa_cert_pem')->nullable()->after('empresa_gre_clave');
            $table->string('empresa_key_pem')->nullable()->after('empresa_cert_pem');
        });

        // Tabla guia_remision
        Schema::create('guia_remision', function (Blueprint $table) {
            $table->id('id_guia');
            $table->unsignedBigInteger('id_empresa');
            $table->unsignedBigInteger('id_clientes');
            $table->unsignedBigInteger('id_venta')->nullable();
            $table->unsignedBigInteger('id_users');

            // Tipo y serie
            $table->string('guia_tipo', 2);             // 09=remitente, 31=transportista
            $table->string('guia_serie', 10)->nullable();
            $table->string('guia_correlativo', 10)->nullable();
            $table->date('guia_emision')->nullable();
            $table->date('guia_fecha_traslado');

            // Transporte
            $table->string('guia_motivo', 2)->nullable();
            $table->string('guia_tipo_trans', 2)->nullable(); // 01=público, 02=privado
            $table->string('guia_unidad_medida', 10)->nullable();
            $table->decimal('guia_peso_bruto', 10, 3)->nullable();
            $table->integer('guia_n_bulto')->nullable();
            $table->string('guia_placa', 20)->nullable();
            $table->string('guia_carreta', 20)->nullable();
            $table->string('vehiculo_marca', 50)->nullable();
            $table->string('guia_certificado_mtc', 50)->nullable();

            // Conductor
            $table->string('guia_licencia_conductor', 30)->nullable();
            $table->string('guia_conductor_nombre', 100)->nullable();
            $table->string('guia_conductor_apellidos', 100)->nullable();
            $table->string('guia_conductor_documento_tipo', 5)->nullable();
            $table->string('guia_conductor_numero', 20)->nullable();

            // Transportista (cuando tipo_trans=01 público)
            $table->string('guia_tipo_doc_trans', 5)->nullable();
            $table->string('guia_num_doc_trans', 20)->nullable();
            $table->string('guia_denominacion', 200)->nullable();

            // Destinatario (cuando tipo=31 transportista)
            $table->string('guia_denominacion_desti', 200)->nullable();
            $table->string('guia_direccion_desti', 300)->nullable();
            $table->string('guia_num_doc_desti', 20)->nullable();
            $table->string('guia_tipo_doc_desti', 5)->nullable();

            // Puntos de traslado
            $table->string('guia_direccion_part', 300)->nullable();
            $table->string('guia_ubigeo_part', 10)->nullable();
            $table->string('guia_direccion_llega', 300)->nullable();
            $table->string('guia_ubigeo_llega', 10)->nullable();

            // Estado SUNAT
            $table->tinyInteger('guia_estado_sunat')->default(0);
            $table->tinyInteger('guia_estado_aprobacion')->default(0);
            $table->text('guia_respuesta_sunat')->nullable();
            $table->text('guia_rutaXML')->nullable();
            $table->text('guia_rutaCDR')->nullable();
            $table->string('guia_remision_numTicket')->nullable();
            $table->dateTime('guia_remision_fecRecepcion')->nullable();
            $table->text('guia_linkpdf_sunat')->nullable();
            $table->dateTime('guia_fecha_envio')->nullable();

            $table->text('guia_observacion')->nullable();
            $table->timestamps();
        });

        // Tabla guia_remision_detalle
        Schema::create('guia_remision_detalle', function (Blueprint $table) {
            $table->id('id_guia_detalle');
            $table->unsignedBigInteger('id_guia');
            $table->string('guia_remision_detalle_descripcion', 300);
            $table->decimal('guia_remision_detalle_cantidad', 10, 2)->default(1);
            $table->decimal('guia_remision_peso', 10, 3)->default(0);
            $table->string('guia_remision_detalle_um', 10)->default('NIU');
            $table->timestamps();

            $table->foreign('id_guia')->references('id_guia')->on('guia_remision')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('guia_remision_detalle');
        Schema::dropIfExists('guia_remision');

        Schema::table('empresa', function (Blueprint $table) {
            $table->dropColumn(['empresa_gre_id', 'empresa_gre_clave', 'empresa_cert_pem', 'empresa_key_pem']);
        });
    }
};
