<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tipo_ndebito extends Model
{
    use HasFactory;
    protected $table = "tipo_ndebitos";
    protected $primaryKey = "id_tipo_ndebito";
    public static function listar_tipo_notaD_x_codigo($codigo){
        $datos  = DB::table('tipo_ndebitos as t')->where('t.codigo','=',$codigo)->first();

        return $datos;
    }

    public static function listar_descripcion_segun_nota_debito(){
        $datos  = DB::table('tipo_ndebitos as t')->where('t.estado','=',0)->get();
        return $datos;
    }

}
