<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tipo_afectacion extends Model
{
    use HasFactory;
    protected $table = "tipo_afectacion";
    protected $primaryKey = "id_tipo_afectacion";
    public static function listar_afectacion(){
        $datos = DB::table('tipo_afectacion')->get();
        return $datos;
    }

}
