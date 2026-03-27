<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Producto_precios extends Model
{
    use HasFactory;
    protected $table = "producto_precios";
    protected $primaryKey = "id_producto_precios";
    public static function listar_producto_precio($id_producto_precio){
        $datos = DB::table('producto_precios')->where('id_producto_precios','=',$id_producto_precio)->first();
        return $datos;
    }
}
