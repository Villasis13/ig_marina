<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tipo_pago extends Model
{
    use HasFactory;
    protected $table = "tipo_pago";
    protected $primaryKey = "id_tipo_pago";

    public  function listar_tipo_pago()
    {
        $datos = DB::table('tipo_pago')->where('tipo_pago_estado','=',1)->get();
        return $datos;
    }
}
