<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movimientos_productos extends Model
{
    use HasFactory;

    protected $table = "movimientos_productos";
    protected $primaryKey = "id_movimientos_productos";
    public  function listar_movimientos_productos($tipo = null,$inicio,$final){
        $datos = DB::table('movimientos_productos as m')
            ->join('users as u','m.id_users','=','u.id_users')
            ->whereBetween('m.movimientos_productos_fecha',[$inicio,$final]);
        if ($tipo){
            $datos->where('m.movimientos_productos_tipo','=',$tipo);
        }
        $result = $datos->get();

        return $result;
    }

    public  function listar_movimientosxproductos($id_producto){
        $datos = DB::table('movimientos_productos_detalle as mpd')
            ->join('movimientos_productos as mp','mp.id_movimientos_productos','=','mpd.id_movimientos_productos')
            ->join('producto as p','p.id_producto','=','mpd.id_producto')
            ->join('users as u','u.id_users','=','mp.id_users')
            ->where('mpd.id_producto','=',$id_producto)
            ->where('mp.movimientos_productos_estado','=',1)
            ->where('mpd.movimientos_productos_detalle_estado','=',1)
            ->where('mp.movimientos_productos_tipo','=',2)
            ->get();
        // se modifico esta consulta con el fin que solo traiga datos de las salidas de un producto
        return $datos;
    }
    public  function listar_detalle_movimiento($id){
        $datos = DB::table('movimientos_productos_detalle as m')
            ->join('productos as p','p.id_pro','=','m.id_pro')
            ->where('m.id_movimientos_productos','=',$id)
            ->get();
        return $datos;
    }

    public  function listar_movimientos_productos_sintipo($inicio,$final){
        $datos = DB::table('movimientos_productos as m')
            ->join('users as u','m.id_users','=','u.id_users')
            ->whereDate('m.movimientos_productos_fecha','>=',$inicio)
            ->whereDate('m.movimientos_productos_fecha','<=',$final)
            ->get();
        return $datos;
    }
}
