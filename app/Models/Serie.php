<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Serie extends Model
{
    use HasFactory;
    protected $table = "serie";
    protected $primaryKey = "id_serie";
    public  function listarSerie($co){
        $datos = DB::table('serie')->where([['tipocomp','=',$co],['estado','=',1]])->get();
        return $datos;
    }
    public  function listarDatos_Serie($co){
        $datos = DB::table('serie')->where([['tipocomp','=',$co],['estado','=',1]])->first();
        return $datos;
    }

    public  function listarSerie_caja($tipo ,$id_caja,$serieMoto = null){
        $datos = DB::table('serie')
            ->where([['tipocomp','=',$tipo],['estado','=',1]])
            ->where('id_caja_numero','=',$id_caja);
        if ($serieMoto){
            $datos->where('serie.serie','=',$serieMoto);
        }
        $datos = $datos->get();
        return $datos;
    }

    public  function listar_correlativos_x_serie($id_serie){
        $datos = DB::table('serie')->where('id_serie','=',$id_serie)->first();
        return $datos;
    }


    public  function sacar_serie($id_serie,$id_caja_numero){
        $datos = DB::table('serie')->where([['id_serie','=',$id_serie],['id_caja_numero','=',$id_caja_numero]])->first();
        return $datos;
    }
}
