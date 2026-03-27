<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Moneda extends Model
{
    use HasFactory;
    protected $table = "monedas";
    protected $primaryKey = "id_moneda";
    public static function listar_monedas(){
        $datos = DB::table('monedas')->where('activo','=',1)->get();
        return $datos;
    }
}
