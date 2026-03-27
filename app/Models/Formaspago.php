<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Formaspago extends Model
{
    use HasFactory;
    protected $table = "formas_pago";
    protected $primaryKey = "id_formas_pago";
    public  function listar_formas_pago(){
        $datos = DB::table('formas_pago')->where('formas_pago_estado','=',1)->get();
        return $datos;
    }
}
