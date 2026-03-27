<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Producto extends Model
{
    use HasFactory;
    protected $table = "producto";
    protected $primaryKey = "id_producto";

    public static function  listar_productos(){
        $datos = DB::table('recetas as r')->join('producto as p','r.id_recetas','=','p.id_recetas')
            ->join('producto_precios as pr','pr.id_producto','=','p.id_producto')
            ->where([['pr.producto_precios_estado','=',1],['p.producto_estado','=',1]])->get();
        return $datos;
    }
    public static function  informacion_producto_codigo($codigo){
        $datos = DB::table('recetas as r')->join('producto as p','r.id_recetas','=','p.id_recetas')
            ->join('producto_precios as pr','pr.id_producto','=','p.id_producto')
            ->where([['pr.producto_precios_estado','=',1],['p.producto_estado','=',1]])
            ->where('p.codigo_barra','=',$codigo)->first();
        return $datos;
    }
    public static function  listar_datos_por_id($id){
        $datos = DB::table('recetas as r')
            ->join('producto as p','r.id_recetas','=','p.id_recetas')
            ->join('producto_precios as pr','pr.id_producto','=','p.id_producto')
            ->where([['pr.producto_precios_estado','=',1],['p.producto_estado','=',1]])
            ->where('p.id_producto','=',$id)->first();
        return $datos;
    }
    public static function  listar_productos_categoria($id_categoria){
        $datos = DB::table('recetas as r')->join('producto as p','r.id_recetas','=','p.id_recetas')
            ->join('producto_precios as pr','pr.id_producto','=','p.id_producto')
            ->where([['pr.producto_precios_estado','=',1],['p.producto_estado','=',1]])
            ->where('p.id_categoria','=',$id_categoria)
            ->where('p.producto_stock','>',0)
            ->limit(6)
            ->inRandomOrder()
            ->get();
        return $datos;
    }
    public static function  listar_productos_categoria_todo($id_categoria){
        $datos = DB::table('recetas as r')->join('producto as p','r.id_recetas','=','p.id_recetas')
            ->join('producto_precios as pr','pr.id_producto','=','p.id_producto')
            ->where([['pr.producto_precios_estado','=',1],['p.producto_estado','=',1]])
            ->where('p.id_categoria','=',$id_categoria)
//            ->where('p.producto_stock','>',0)
            ->inRandomOrder()
            ->get();
        return $datos;
    }
    public static function  listar_informacion_producto($id){
        $datos = DB::table('recetas as r')
            ->join('producto as p','r.id_recetas','=','p.id_recetas')
            ->join('producto_precios as pr','pr.id_producto','=','p.id_producto')
            ->where([['pr.producto_precios_estado','=',1],['p.producto_estado','=',1]])
            ->where('p.id_producto','=',$id)->first();
        return $datos;
    }


    public static function  listarDetalleRecetes($id){
        $datos = DB::table('recetas as r')
            ->join('detalle_recetas as pr','pr.id_recetas','=','r.id_recetas')
            ->join('recursos as re','re.id_recursos','=','pr.id_recursos')
            ->where([['pr.detalle_recetas_estado','=',1],['re.recursos_estado','=',1]])
            ->where([['r.recetas_estado','=',1],['r.id_recetas','=',$id]])->get();
        return $datos;
    }
    public static function  listarDetalleRecetesCa($id){
        $datos = DB::table('recetas as r')
            ->join('detalle_recetas as pr','pr.id_recetas','=','r.id_recetas')
            ->join('recursos as re','re.id_recursos','=','pr.id_recursos')
            ->join('medida as m','m.id_medida','=','re.id_medida')
            ->where([['pr.detalle_recetas_estado','=',1],['re.recursos_estado','=',1]])
            ->where([['r.recetas_estado','=',1],['r.id_recetas','=',$id]])->get();
        return $datos;
    }
    public static function  recursos_disminucion($id){
        $datos = DB::table('recetas as r')
            ->join('producto as p','r.id_recetas','=','p.id_recetas')
            ->join('producto_precios as pr','pr.id_producto','=','p.id_producto')
            ->join('detalle_recetas as dr','r.id_recetas','=','dr.id_recetas')
            ->where([['pr.producto_precios_estado','=',1],['p.producto_estado','=',1]])
            ->where([['p.id_producto','=',$id],['dr.detalle_recetas_estado','=',1]])->get();
        return $datos;
    }


    public static function  buscar_productos($valor){
        $datos =
            DB::table('recetas as r')
            ->join('producto as p', 'r.id_recetas', '=', 'p.id_recetas')
            ->join('producto_precios as pp', 'p.id_producto', '=', 'pp.id_producto')
            ->where(function ($query) use ($valor) {
                $query->where('r.recetas_nombre', 'like', '%' . $valor . '%')
                    ->orWhere(DB::raw('SOUNDEX(r.recetas_nombre)'), '=', DB::raw('SOUNDEX("' . $valor . '")'))
                    ->orWhere('p.codigo_barra', 'like', '%' . $valor . '%')
                    ->orWhere(DB::raw('SOUNDEX(p.codigo_barra)'), '=', DB::raw('SOUNDEX("' . $valor . '")'));
            })
            ->where('pp.producto_precios_estado', '=', 1)
            ->where('r.recetas_estado', '=', 1)
                ->where('p.producto_stock','>',0)
                ->limit(6)
            ->get();

        return $datos;
    }

    public static function  buscar_productos_sin_stock_($valor){
        $datos = DB::table('recetas as r')
            ->join('producto as p', 'r.id_recetas', '=', 'p.id_recetas')
            ->join('producto_precios as pp', 'p.id_producto', '=', 'pp.id_producto')
            ->where(function ($query) use ($valor) {
                $query->where('r.recetas_nombre', 'like', '%' . $valor . '%')
                    ->orWhere(DB::raw('SOUNDEX(r.recetas_nombre)'), '=', DB::raw('SOUNDEX("' . $valor . '")'))
                    ->orWhere('p.codigo_barra', 'like', '%' . $valor . '%')
                    ->orWhere(DB::raw('SOUNDEX(p.codigo_barra)'), '=', DB::raw('SOUNDEX("' . $valor . '")'));
            })
            ->where('pp.producto_precios_estado', '=', 1)
            ->where('r.recetas_estado', '=', 1)
//                ->where('p.producto_stock','>',0)
            ->limit(6)
            ->get();

        return $datos;
    }
}
