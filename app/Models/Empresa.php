<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Empresa extends Model
{
    use HasFactory;
    protected $table = "empresa";
    protected $primaryKey = "id_empresa";
    public  function listar_datos_empresa(){
        $datos = DB::table('empresa as e')
            ->join('ubigeo as u','u.id_ubigeo','=','e.id_ubigeo')
            ->where('e.id_empresa','=',1)->first();
        return $datos;
    }
}
