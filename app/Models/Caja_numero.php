<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Caja_numero extends Model
{
    use HasFactory;
    protected $table = "caja_numero";
    protected $primaryKey = "id_caja_numero";

    public  function listar_caja_numeros(){
        $datos = DB::table('caja_numero')->where('caja_numero_estado','=',1)->get();
        return $datos;
    }
}
