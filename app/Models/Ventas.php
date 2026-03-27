<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ventas extends Model
{
    use HasFactory;
    protected $table = "ventas";
    protected $primaryKey = "id_venta";

//    protected $fillable = ['id_caja_numero','id_empresa','id_users','id_clientes','id_tipo_pago','id_moneda','venta_tipo_campo',
//        'venta_condicion_resumen','venta_tipo_envio','venta_direccion','venta_tipo','venta_serie','venta_correlativo','venta_descuento_global','venta_totalgratuita','venta_totalexonerada',
//        'venta_totalinafecta','venta_totalgravada','venta_totaligv','venta_incluye_igv','venta_totaldescuento','venta_icbper','venta_total','venta_pago_cliente',
//        'venta_vuelto','venta_fecha','venta_observacion','tipo_documento_modificar','serie_modificar','correlativo_modificar','venta_codigo_motivo_nota','venta_estado_sunat',
//        'venta_fecha_envio','venta_rutaXML','venta_rutaCDR','venta_respuesta_sunat','venta_fecha_de_baja','anulado_sunat','venta_cancelar','venta_seriecorrelativo_notaventa','venta_codigo','cambiar_concepto','concepto_nuevo','tipo_venta','venta_estado_venta','id_formas_pago','venta_estado_pago'];
//    public static function guardar_venta($venta){
//        $venta_exitosa = new Ventas();
//        $venta_exitosa->fill($venta);
//        $venta_exitosa->save();
//        return $venta_exitosa;
//    }
    public  function listar_venta_x_codigo($codigo){
        $datos = DB::table('ventas')
            ->where('venta_codigo', '=', $codigo)
            ->first();
        return $datos;
    }
    public  function listar_ventas_facturas($id_empresa){
        $datos = DB::table('ventas as v')
            ->join('empresa as e', 'e.id_empresa', '=', 'v.id_empresa')
            ->join('clientes as c', 'v.id_clientes', '=', 'c.id_clientes')
            ->join('monedas as mo', 'v.id_moneda', '=', 'mo.id_moneda')
            ->join('users as u', 'v.id_users', '=', 'u.id_users')
            ->where('v.venta_estado_sunat', '=', 0)
            ->where('e.id_empresa','=', $id_empresa)
            ->where('v.venta_tipo','=', '01')
            ->whereDate('v.venta_fecha','=', date('Y-m-d'))
            ->get();
        return $datos;
    }
    public  function listar_venta_x_id_pdf($id_venta){
        $datos = DB::table('ventas as v')
            ->join('empresa as e', 'e.id_empresa', '=', 'v.id_empresa')
            ->join('ubigeo as ub', 'ub.id_ubigeo', '=', 'e.id_ubigeo')
            ->join('clientes as c', 'v.id_clientes', '=', 'c.id_clientes')
            ->join('monedas as mo', 'v.id_moneda', '=', 'mo.id_moneda')
            ->leftJoin('users as u', 'v.id_users', '=', 'u.id_users')
            ->leftJoin('persona as p', 'p.id_persona', '=', 'u.id_persona')
            ->join('tipo_documento as ti', 'ti.id_tipo_documento', '=', 'c.id_tipo_documento')
            ->where('v.id_venta', '=', $id_venta)
            ->select('v.*','c.*','mo.*','u.*','ti.*','e.*','ub.*','p.persona_nombre')
            ->first();
        return $datos;
    }
    public function listar_ventas_cliente($id_cliente, $fecha_inicio, $fecha_fin, $id_empresa)
    {
        return DB::table('ventas as v')
            ->join('clientes as c', 'c.id_clientes', '=', 'v.id_clientes')
            ->where('v.id_empresa', '=', $id_empresa)
            ->whereDate('v.venta_fecha', '>=', $fecha_inicio)
            ->whereDate('v.venta_fecha', '<=', $fecha_fin)
            ->where('v.anulado_sunat', '=', 0)
            ->where('v.venta_cancelar', '=', 1)
            ->where([['v.venta_tipo', '<>', '07'], ['v.venta_tipo', '<>', '08']])
            ->where('v.venta_tipo', '<>', '20')
            ->where('v.id_clientes', '=', $id_cliente)
            ->select('v.*', 'c.cliente_nombre', 'c.cliente_razonsocial', 'c.cliente_numero', 'c.id_tipo_documento')
            ->orderBy('v.venta_fecha', 'desc')
            ->get();
    }

    public  function  listar_ventas_Reporte($fecha,$id_empresa){
        $datos = DB::table('ventas as v')
            ->where('v.id_empresa','=',$id_empresa)
            ->whereDate('v.venta_fecha', '=', $fecha)
            ->where('v.anulado_sunat', '=', 0)
            ->where('v.venta_cancelar', '=', 1)
            ->where([['v.venta_tipo','<>','07'],['v.venta_tipo','<>','08']])
            ->where('v.venta_tipo','<>','20')
            ->get();

        return $datos;
    }
    public  function  listar_ventas_x_mes($fecha,$fecha_final){
        $datos = DB::table('ventas as v')
            ->where('v.id_empresa','=',1)
            ->whereDate('v.venta_fecha', '>=', $fecha)
            ->whereDate('v.venta_fecha', '<=', $fecha_final)
            ->where('v.anulado_sunat', '=', 0)
            ->where('v.venta_cancelar', '=', 1)
            ->where([['v.venta_tipo','<>','07'],['v.venta_tipo','<>','08']])
            ->where('v.venta_tipo','<>','20')
            ->sum('v.venta_total');
        return $datos;
    }

    public function listarsuma_20_dias($id_empresa){
        $fechaActual = Carbon::now();
        // Obtén los datos de los últimos 7 días, en el orden correcto
        for ($i = 19; $i >= 0; $i--) {
            $fechaDia = $fechaActual->copy()->subDays($i);
            $nombreDia = $fechaDia->format('l');
            $suma =  DB::table('ventas as v')
                ->where([['v.anulado_sunat', '=', 0],['v.venta_cancelar', '=', 1],['v.venta_tipo','<>','07'],['v.venta_tipo','<>','08'],['v.venta_tipo','<>','20'],['v.id_empresa', '=', 1]])
                ->whereDate('v.venta_fecha', '=', $fechaDia->toDateString())
                ->get();
            $total_ventas = 0;
            foreach ($suma as $d){
//                $validarNC = DB::table('ventas')->where([['venta_tipo','=','07'],['serie_modificar','=',$d->venta_serie],['correlativo_modificar','=',$d->venta_correlativo],['tipo_documento_modificar','=',$d->venta_tipo],['id_su','=',$d->id_su]])->first();
//                $validarND = DB::table('ventas')->where([['venta_tipo','=','08'],['serie_modificar','=',$d->venta_serie],['correlativo_modificar','=',$d->venta_correlativo],['tipo_documento_modificar','=',$d->venta_tipo],['id_su','=',$d->id_su]])->first();
//                $sumarSub = $d->venta_total;
//                if($validarNC){
//                    $sumarSub = $sumarSub - $validarNC->venta_total;
//                }
//                if($validarND){
//                    $sumarSub = $sumarSub + $validarND->venta_total;
//                }
                $total_ventas += $d->venta_total;
            }
            $finalData[] = [
                'dia_semana' => $nombreDia,
                'numero_dia' => Carbon::parse($fechaDia)->day,
                'numero_mes' => Carbon::parse($fechaDia)->month,
                'conteo' => $total_ventas
            ];
        }
        return $finalData;
    }

    public  function listar_cuotas($id_venta){
        $datos = DB::table('ventas_cuotas')
            ->where('id_venta', '=', $id_venta)
            ->get();
        return $datos;
    }
    public  function listarProductVendidos($mes){
        $datos = DB::table('ventas as v')
            ->join('ventas_detalle as vd', 'v.id_venta', '=', 'vd.id_venta')
            ->join('producto as p', 'p.id_producto', '=', 'vd.id_producto')
            ->join('recetas as r', 'r.id_recetas', '=', 'p.id_recetas')
            ->where([['v.venta_estado_sunat', '=', '0'], ['p.producto_estado', '=', 1]])
            ->whereRaw('MONTH(v.venta_fecha) = MONTH(?) AND YEAR(v.venta_fecha) = YEAR(?)', [$mes, $mes])
            ->groupBy('r.recetas_nombre', 'p.id_producto')
            ->select('r.recetas_nombre', 'p.id_producto', DB::raw('COUNT(*) as total_registros'))
            ->orderBy('total_registros','desc')
            ->limit(5)
            ->get();
       return $datos;
    }
//    public  function listar_venta_x_id_pdf($id_venta){
//        $datos = DB::table('ventas as v')
//            ->join('empresa as e', 'e.id_empresa', '=', 'v.id_empresa')
//            ->join('ubigeo as ub', 'ub.id_ubigeo', '=', 'e.id_ubigeo')
//            ->join('clientes as c', 'v.id_clientes', '=', 'c.id_clientes')
//            ->join('monedas as mo', 'v.id_moneda', '=', 'mo.id_moneda')
//            ->leftJoin('users as u', 'v.id_users', '=', 'u.id_users')
//            ->join('tipo_documento as ti', 'ti.id_tipo_documento', '=', 'c.id_tipo_documento')
////            ->join('tipo_pago as tp', 'tp.id_tipo_pago', '=', 'v.id_tipo_pago')
//            ->where('v.id_venta', '=', $id_venta)
//            ->select('v.*','c.*','mo.*','u.*','ti.*','e.*','s.*','ub.*')
//            ->first();
//        return $datos;
//    }
    public  function listar_venta_detalle_x_id_venta_pdf($id_venta){
        $datos  = DB::table('ventas_detalle as vd')
            ->join('productos as p', 'vd.id_pro', '=', 'p.id_pro')
            ->join('tipo_afectacion as ta', 'p.id_tipo_afectacion', '=', 'ta.id_tipo_afectacion')
            ->where('vd.id_venta', '=', $id_venta)
            ->where('p.pro_estado', '=', 1)
            ->select('vd.*', 'p.*', 'ta.*')
            ->get();
        return $datos;
    }

    public  function listar_venta_detalle_x_nota($ID){
        $datos  = DB::table('ventas_detalle as vd')
            ->join('productos as p', 'p.id_pro', '=', 'vd.id_pro')
            ->join('medida as m', 'm.id_medida', '=', 'p.id_medida')
            ->join('tipo_afectacion as ta', 'p.id_tipo_afectacion', '=', 'ta.id_tipo_afectacion')
            ->where('vd.id_venta', $ID)
            ->get();
        return $datos;
    }
    public  function listar_soloventa_x_id($ID){
        $datos  = DB::table('ventas as v')->select('*')
            ->join('clientes as c', 'v.id_clientes', '=', 'c.id_clientes')
            ->join('monedas as mo', 'v.id_moneda', '=', 'mo.id_moneda')
            ->join('users as u', 'v.id_users', '=', 'u.id_users')
            ->where('v.id_venta','=', $ID)
            ->first();
        return $datos;
    }
    public  function listar_ventas_sin_enviar()
    {
        $datos =  DB::table('ventas')
            ->join('clientes as c', 'ventas.id_clientes', '=', 'c.id_clientes')
            ->join('monedas as mo', 'ventas.id_moneda', '=', 'mo.id_moneda')
            ->join('users as u', 'ventas.id_users', '=', 'u.id_users')
            ->where('ventas.venta_estado_sunat', '=', 0)
            ->count();
        return $datos;
    }
    public  function listar_venta_x_id($ID){
        $datos  = DB::table('ventas as v')
            ->join('clientes as c', 'v.id_clientes', '=', 'c.id_clientes')
            ->join('monedas as mo', 'v.id_moneda', '=', 'mo.id_moneda')
            ->leftJoin('users as u', 'v.id_users', '=', 'u.id_users')
            ->where('v.id_venta','=', $ID)
            ->first();
        return $datos;
    }

    public static function listar_venta_x_id_web($ID){
        $datos  = DB::table('ventas as v')
            ->join('clientes as c', 'v.id_clientes', '=', 'c.id_clientes')
            ->join('tipo_documento as td','td.id_tipo_documento','=','c.id_tipo_documento')
            ->join('monedas as mo', 'v.id_moneda', '=', 'mo.id_moneda')
            ->join('tipo_pago as tp', 'v.id_tipo_pago', '=', 'tp.id_tipo_pago')
            ->where('v.id_venta','=', $ID)
            ->first();
        return $datos;
    }
    public  function  listar_x_filtro_para_ventas($select_cliente, $fecha_inicio, $fecha_cierre, $estado){
        $datos = DB::table('ventas as v')
            ->Join('ventas_cuotas as vc', 'v.id_venta', '=', 'vc.id_venta')
            ->Join('monedas as m', 'v.id_moneda', '=', 'm.id_moneda')
            ->join('clientes as c', 'v.id_clientes', '=', 'c.id_clientes')
            ->join('tipo_documento as tp','c.id_tipo_documento','=','tp.id_tipo_documento');
        if (!empty($select_cliente)){
            $datos->where('c.id_clientes','=', $select_cliente);
        }
        if ($estado == 1) {
//            $datos->whereBetween(DB::raw('DATE(vc.venta_cuota_fecha)'), [$fecha_inicio, $fecha_cierre]);
            $datos->whereDate('vc.venta_cuota_fecha','>=',$fecha_inicio)
                ->whereDate('vc.venta_cuota_fecha','<=',$fecha_cierre);
        } else if ($estado == 0) {
            $datos->whereDate('vc.venta_cuota_fecha', '<=', $fecha_cierre);
        }
        $query = $datos->where([['v.venta_tipo','<>','07'],['v.venta_tipo','<>','08']])
            ->where('v.venta_tipo','<>','20')->get();

        return $query;
    }
    public  function datos_para_tabla($select_cliente,$fecha_inicio,$fecha_cierre,$estado){
        $datos = DB::table('pagos as p')
            ->join('monedas as m','p.id_moneda','=','m.id_moneda')
            ->join('ventas_cuotas as vc','p.id_ventas_cuotas','=','vc.id_ventas_cuotas')
            ->join('ventas as v','vc.id_venta','=','v.id_venta')
            ->join('clientes as c','v.id_clientes','=','c.id_clientes');
        if (!empty($select_cliente)){
            $datos->where('c.id_clientes','=', $select_cliente);
        }
        if ($estado == 1) {
            $datos->whereDate('vc.venta_cuota_fecha','>=',$fecha_inicio)
                ->whereDate('vc.venta_cuota_fecha','<=',$fecha_cierre);
        } else if ($estado == 0) {
            $datos->whereDate('vc.venta_cuota_fecha', '<=', $fecha_cierre);
        }
        $query = $datos->where([['v.venta_tipo','<>','07'],['v.venta_tipo','<>','08']])
            ->where('v.venta_tipo','<>','20')->get();

        return $query;
    }

    public  function traer_pagos_de_cuota($id){
        $datos = DB::table('pagos as p')
            ->join('ventas_cuotas as vc','p.id_ventas_cuotas','=','vc.id_ventas_cuotas')
            ->where('p.id_ventas_cuotas','=',$id)
            ->get();
        return $datos;
    }

    public  function listar_venta_x_fecha($fecha , $tipo){
        $datos = DB::table('ventas as v')
            ->join('clientes as c', 'v.id_clientes', '=', 'c.id_clientes')
            ->join('monedas as mo', 'v.id_moneda', '=', 'mo.id_moneda')
            ->join('users as u', 'v.id_users', '=', 'u.id_users')
            ->join('tipo_documento as td', 'c.id_tipo_documento', '=', 'td.id_tipo_documento')
            ->whereDate('v.venta_fecha', $fecha)
            ->where('v.venta_tipo', '<>', $tipo)
            ->where('v.venta_estado_sunat', '=', 0)
            ->where('v.tipo_documento_modificar', '<>', '01')
            ->where('v.venta_tipo_envio', '<>', 1)
            ->orderBy('v.id_venta', 'ASC')
            ->limit(350)
            ->get();
        return $datos;
    }

    public  function listar_venta_detalle_x_id_venta($id_venta){
        $datos  = DB::table('ventas_detalle as vd')
            ->join('productos as p' ,'vd.id_pro','=','p.id_pro')
            ->join('medida as m' ,'p.id_medida','=','m.id_medida')
            ->join('tipo_afectacion as ta', 'p.id_tipo_afectacion', '=', 'ta.id_tipo_afectacion')
            ->where('vd.id_venta', '=', $id_venta)
            ->where('p.pro_estado', '=', 1)
            ->select('vd.*','ta.*','p.*','m.*')
            ->get();
        return $datos;
    }

    public  function listar_venta_detalle_x_id_venta_venta($ID){
        $datos  = DB::table('ventas_detalle as vd')
            ->join('productos as p', 'vd.id_pro', '=', 'p.id_pro')
            ->join('tipo_afectacion as ta', 'p.id_tipo_afectacion', '=', 'ta.id_tipo_afectacion')
            ->where('vd.id_venta', $ID)
            ->get();
        return $datos;
    }
}
