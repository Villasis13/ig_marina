<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Oferta extends Model
{
    use HasFactory;
    protected $table = "oferta";
    protected $primaryKey = "id_oferta";

    public static function datos_oferta($id){
        $datos = DB::table('oferta')->where('id_oferta','=',$id)->first();
        return $datos;
    }

    public static function validate_product_on_offer($fecha_ini,$hora_ini,$fecha_cier,$hora_cier,$id_producto)
    {
        $datos = DB::table('oferta as o')
            ->join('oferta_detalle as od', 'o.id_oferta', '=', 'od.id_oferta')
            ->join('producto as p', 'p.id_producto', '=', 'od.id_producto')
            ->where(function ($query) use ($fecha_ini, $hora_ini, $fecha_cier, $hora_cier) {
                // Verifica si el rango de fecha y hora se superpone con alguna oferta
                $query->where(function ($subquery) use ($fecha_ini, $hora_ini, $fecha_cier, $hora_cier) {
                    $subquery->where('o.oferta_fecha_inicio', '<=', $fecha_ini)
                        ->where('o.oferta_hora_cierre', '>=', $hora_ini);
                })
                    ->orWhere(function ($subquery) use ($fecha_ini, $hora_ini, $fecha_cier, $hora_cier) {
                        $subquery->where('o.oferta_fecha_cierre', '>=', $fecha_cier)
                            ->where('o.oferta_hora_inicio', '<=', $hora_cier);
                    });
            })
            ->where('o.oferta_estado', 1)
            ->where('od.id_producto', $id_producto)
            ->exists();
        return $datos;

    }

    public static function validate_product_on_offer_id_offer($fecha_ini,$hora_ini,$fecha_cier,$hora_cier,$id_producto,$id_oferta)
    {
        $datos = DB::table('oferta as o')
            ->join('oferta_detalle as od', 'o.id_oferta', '=', 'od.id_oferta')
            ->join('producto as p', 'p.id_producto', '=', 'od.id_producto')
            ->where(function ($query) use ($fecha_ini, $hora_ini, $fecha_cier, $hora_cier) {
                // Verifica si el rango de fecha y hora se superpone con alguna oferta
                $query->where(function ($subquery) use ($fecha_ini, $hora_ini, $fecha_cier, $hora_cier) {
                    $subquery->where('o.oferta_fecha_inicio', '<=', $fecha_ini)
                        ->where('o.oferta_hora_cierre', '>=', $hora_ini);
                })
                    ->orWhere(function ($subquery) use ($fecha_ini, $hora_ini, $fecha_cier, $hora_cier) {
                        $subquery->where('o.oferta_fecha_cierre', '>=', $fecha_cier)
                            ->where('o.oferta_hora_inicio', '<=', $hora_cier);
                    });
            })
            ->where('o.oferta_estado', 1)
            ->where('od.id_producto', $id_producto)
            ->where('o.id_oferta','<>',$id_oferta)
            ->exists();
        return $datos;

    }

    public  static  function listar_ofertas($fecha,$hora,$tipo){
        $datos = DB::table('oferta')
            ->where('oferta_fecha_inicio', '<=', $fecha)
            ->where(function ($query) use ($fecha, $hora) {
                $query->where('oferta_fecha_cierre', '>', $fecha)
                    ->orWhere(function ($query) use ($fecha, $hora) {
                        $query->where('oferta_fecha_cierre', '=', $fecha)
                            ->where('oferta_hora_cierre', '>=', $hora);
                    });
            })
            ->where('oferta_estado', '=', 1)
            ->where('oferta_tipo', '=', $tipo)
            ->get();
        return $datos;
    }
    public  static  function listar_ofertas_admin($fecha,$hora){
        $datos = DB::table('oferta')
            ->where('oferta_fecha_inicio', '<=', $fecha)
            ->where(function ($query) use ($fecha, $hora) {
                $query->where('oferta_fecha_cierre', '>', $fecha)
                    ->orWhere(function ($query) use ($fecha, $hora) {
                        $query->where('oferta_fecha_cierre', '=', $fecha)
                            ->where('oferta_hora_cierre', '>=', $hora);
                    });
            })
            ->where('oferta_estado', '=', 1)
            ->get();
        return $datos;
    }

    public  static  function buscar_ofertas_fecha($fecha,$fechec){
        $datos = DB::table('oferta')->where('created_at', '<=', $fecha)
            ->where('created_at', '>=', $fechec)
            ->where('oferta_estado','=',1)
            ->get();
        return $datos;
    }


    public function consulta_oferta($id ,$fecha ,$hora,$tipo ){
        $datos = DB::table('oferta')
            ->join('oferta_detalle','oferta_detalle.id_oferta','=','oferta.id_oferta')
            ->where('oferta.oferta_fecha_inicio', '<=', $fecha)
            ->where(function ($query) use ($fecha, $hora) {
                $query->where('oferta.oferta_fecha_cierre', '>', $fecha)
                    ->orWhere(function ($query) use ($fecha, $hora) {
                        $query->where('oferta.oferta_fecha_cierre', '=', $fecha)
                            ->where('oferta.oferta_hora_cierre', '>=', $hora);
                    });
            })
            ->where('oferta.oferta_estado', '=', 1)
            ->where('oferta_detalle.id_producto','=',$id)
            ->where('oferta.oferta_tipo','=',$tipo)
            ->first();
        return $datos;
    }
}
