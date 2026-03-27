<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Medida extends Model
{
    use HasFactory;
    protected $table = "medida";
    protected $primaryKey = "id_medida";

    public static function listar_medidas(){
        $datos = DB::table('medida')->where('medida_activo','=',1)->get();
        return $datos;
    }
}
