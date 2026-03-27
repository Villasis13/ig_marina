<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tipo_venta extends Model
{
    use HasFactory;
    protected $table = "tipo_venta";
    protected $primaryKey = "id_tipo_venta";

    public  function listar_tipo_venta()
    {
        $datos = DB::table('tipo_venta')->where('tipo_venta_estado','=',1)->get();
        return $datos;
    }


}
