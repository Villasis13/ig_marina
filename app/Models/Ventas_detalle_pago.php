<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ventas_detalle_pago extends Model
{
    use HasFactory;

    protected $fillable = ['id_venta','id_tipo_pago','venta_detalle_pago_monto','venta_detalle_pago_estado',];
    public static function venta_pago_store($venta_pagos){
        $venta_exitosa = new Ventas_detalle_pago();
        $venta_exitosa->fill($venta_pagos);
        $venta_exitosa->save();
        return $venta_exitosa;
    }

    public static function listar_formas_x_idventa($id){
        $datos = DB::table('ventas_detalle_pagos as vdp')
            ->join('tipo_pago as tp','vdp.id_tipo_pago','=','tp.id_tipo_pago')
            ->where('vdp.id_venta','=',$id)->get();
        return $datos;
    }
}
