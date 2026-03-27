<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Oferta_detalle extends Model
{
    use HasFactory;

    protected $table = "oferta_detalle";
    protected $primaryKey = "id_oferta_detalle";

    public static function listar_detalle_oferta($id){
        $datos = DB::table('oferta_detalle as od')
            ->join('producto as p','p.id_producto','=','od.id_producto')
            ->join('producto_precios as pp','pp.id_producto','=','p.id_producto')
            ->join('recetas as r','r.id_recetas','=','p.id_recetas')
            ->where('id_oferta','=',$id)
            ->where('pp.producto_precios_estado','=',1)
            ->where('p.producto_estado','=',1)
            ->where('r.recetas_estado','=',1)
            ->get();
        return $datos;
    }
}
