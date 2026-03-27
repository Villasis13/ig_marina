<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Detalle_compra extends Model
{
    use HasFactory;
    protected $table  = "detalle_compra";
    protected $primaryKey = "id_detalle_compra";
    public  function listar_detalle_compra($id){

        $datos = DB::table('orden_compra_detalle as ocd')
            ->join('productos as p', 'ocd.id_pro', '=', 'p.id_pro')
            ->select('ocd.*',  'p.*')
            ->where('ocd.id_orden_compra', '=', $id)
            ->get();
//        $datos = DB::table('detalle_compra')->where('id_orden_compra','=',  $id)->where('detalle_compra_estado','=',1)->get();
        return $datos;
    }
}
