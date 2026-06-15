<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Orden_compra extends Model
{
    use HasFactory;
    protected $table  = "orden_compra";
    protected $primaryKey = "id_orden_compra";
    public  function validar_numero_factura($numero){
        $datos = DB::table('orden_compra')->where('orden_compra_numero_doc','like',  '%' . $numero . '%')->first();
        return $datos;
    }
    public  function datos_orden_compra($id){
        $datos = DB::table('orden_compra as oc')
            ->join('proveedores as p','oc.id_proveedores','=','p.id_proveedores')
            ->join('users as u','oc.id_solicitante','=','u.id_users')
            ->leftJoin('tipo_pago as tp','tp.id_tipo_pago','=','oc.id_tipo_pago')
            ->where('oc.id_orden_compra','=',  $id)
            ->where('oc.orden_compra_estado','=',  1)
            ->first();
        return $datos;
    }

    public  function OrdenComprasxAlmacen($id){
        $datos = DB::table('orden_compra')
            ->join('proveedores','orden_compra.id_proveedores','=','proveedores.id_proveedores')
            ->where([['orden_compra.id_almacen','=',  $id],['orden_compra_estado','=',1]])
            ->get();
        return $datos;
    }

    public  function datos_facturas_fp($parametro,$hasta,$desde){
        $datos  =DB::table('orden_compra')->select('*')
            ->join('empresa','orden_compra.id_sede','=','empresa.id_empresa')
            ->join('users as u', 'orden_compra.id_solicitante', '=', 'u.id_users')
            ->join('persona as p', 'u.id_persona', '=', 'p.id_persona')
            ->join('detalle_compra as dc', 'orden_compra.id_orden_compra', '=', 'dc.id_orden_compra')
            ->join('proveedores as p2', 'orden_compra.id_proveedores', '=', 'p2.id_proveedores')
            ->join('recursos as rs', 'dc.id_recursos', '=', 'rs.id_recursos')
            ->join('recursos as r', 'rs.id_recursos', '=', 'r.id_recursos')
            ->leftJoin('tipo_pago as tp','tp.id_tipo_pago','=','orden_compra.id_tipo_pago')
//            ->join('sucursal as s', 'rs.id_sucursal', '=', 's.id_sucursal')
            ->where('orden_compra_estado', 1)
            ->where('detalle_compra_estado', 1)
            ->where('p2.proveedores_estado', 1)
            ->whereBetween(DB::raw('date(orden_compra_fecha)'), [$hasta, $desde])
            ->where(function ($query) use ($parametro) {
                $query->where('p2.proveedores_nombre', 'like', '%' . $parametro . '%')
                    ->orWhere('p2.proveedores_numero_documento', 'like', '%' . $parametro . '%');
            })
            ->orderByDesc('orden_compra_fecha')
            ->get();
        return $datos;
    }

    public  function datos_facturas_fechas($fecha_hoy,$fecha_fin){
        $datos = DB::table('orden_compra')->select('*')
            ->join('empresa','orden_compra.id_sede','=','empresa.id_empresa')
            ->join('users as u', 'orden_compra.id_solicitante', '=', 'u.id_users')
            ->join('persona as p', 'u.id_persona', '=', 'p.id_persona')
            ->join('proveedores as p2', 'orden_compra.id_proveedores', '=', 'p2.id_proveedores')
            ->leftJoin('tipo_pago as tp','tp.id_tipo_pago','=','orden_compra.id_tipo_pago')

            ->where('orden_compra_estado', 1)
            ->whereBetween(DB::raw('date(orden_compra_fecha)'), [$fecha_hoy, $fecha_fin])
            ->orderByDesc('orden_compra_fecha')
            ->get();
        return $datos;
    }
    public  function datos_facturas_para($parametro){
        $datos = DB::table('orden_compra')->select('*')
            ->join('empresa','orden_compra.id_sede','=','empresa.id_empresa')
            ->join('users as u', 'orden_compra.id_solicitante', '=', 'u.id_users')
            ->join('persona as p', 'u.id_persona', '=', 'p.id_persona')
            ->join('detalle_compra as dc', 'orden_compra.id_orden_compra', '=', 'dc.id_orden_compra')
            ->join('proveedores as p2', 'orden_compra.id_proveedores', '=', 'p2.id_proveedores')
            ->join('recursos as rs', 'dc.id_recursos', '=', 'rs.id_recursos')
            ->join('recursos as r', 'rs.id_recursos', '=', 'r.id_recursos')
            ->leftJoin('tipo_pago as tp','tp.id_tipo_pago','=','orden_compra.id_tipo_pago')

            ->where('orden_compra_estado', 1)
            ->where('detalle_compra_estado', 1)
            ->where(function ($query) use ($parametro) {
                $query->where('p2.proveedores_nombre', 'like', '%' . $parametro . '%')
                    ->orWhere('p2.proveedores_nombre', 'like', '%' . $parametro . '%');
            })
            ->orderByDesc('orden_compra_fecha')
            ->get();
        return $datos;
    }

    public  function datos_facturas_pdf($parametro){
        $datos = DB::table('orden_compra')->select('*')
            ->join('users as u', 'orden_compra.id_solicitante', '=', 'u.id_users')
            ->join('persona as p', 'u.id_persona', '=', 'p.id_persona')
            ->join('orden_compra_detalle as dc', 'orden_compra.id_orden_compra', '=', 'dc.id_orden_compra')
            ->join('proveedores as p2', 'orden_compra.id_proveedores', '=', 'p2.id_proveedores')
            ->join('productos as pro', 'dc.id_pro', '=', 'pro.id_pro')
            ->where('dc.id_orden_compra', '=',$parametro)
            ->where('detalle_compra_estado', 1)
            ->orderByDesc('orden_compra_fecha')
            ->first();
        return $datos;
    }


    public  function valores_almacen($valor){
        $datos = DB::table('recursos_almacen as ra')
            ->join('recursos as r', 'r.id_recursos', '=', 'ra.id_recursos')
            ->join('almacen as a', 'a.id_almacen', '=', 'ra.id_almacen')
            ->join('medida as m', 'm.id_medida', '=', 'r.id_medida')
            ->where('r.recursos_estado', '=', 1)
            ->where('a.almacen_estado', '=', 1)
            ->where('ra.recursos_almacen_estado', '=', 1)
            ->where('a.id_almacen', '=', $valor)->get();
        return $datos;
    }

    public  function nombre_almacen($valor){
        $datos = DB::table('almacen')
            ->where('almacen_estado', '=', 1)
            ->where('id_almacen', '=', $valor)->first();
        return $datos;
    }

}
