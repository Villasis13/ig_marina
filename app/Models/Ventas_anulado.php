<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ventas_anulado extends Model
{
    use HasFactory;
    protected $table = "ventas_anulados";
    protected $primaryKey  = "id_venta_anulados";

    public static function guardar_venta_anulacion($fecha,$serie,$correlativo,$ruta_xml,$mensaje,$id_venta,$id_user,$ticket){
        $result = DB::table('ventas_anulados')->insert([
            'venta_anulado_fecha' => $fecha,
            'venta_anulado_serie' => $serie,
            'venta_anulado_correlativo' => $correlativo,
            'venta_anulacion_ticket' => $ticket,
            'venta_anulado_rutaXML' => $ruta_xml,
            'venta_anulado_estado_sunat' => $mensaje,
            'id_venta' => $id_venta,
            'id_users' => $id_user
        ]);
        if ($result == 1 || $result == true) {
            $datos = true;
        }
        return $datos;

    }
}
