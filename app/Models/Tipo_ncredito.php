<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tipo_ncredito extends Model
{
    use HasFactory;
    protected $table = "tipo_ncreditos";
    protected $primaryKey = "id_tipo_ncreditos";

    public static function listar_tipo_notaC_x_codigo($codigo){
        $datos  = DB::table('tipo_ncreditos as t')->where('t.codigo','=',$codigo)->first();

        return $datos;
    }

    public static function listar_descripcion_segun_nota_credito(){
        $datos  = DB::table('tipo_ncreditos as t')->where('t.estado','=',0)->get();
        return $datos;
    }
}
