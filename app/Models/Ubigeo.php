<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ubigeo extends Model
{
    use HasFactory;
    protected $table = "ubigeo";
    protected $primaryKey = "id_ubigeo";
    public static function listar_ubigeo(){
        $datos = DB::table('ubigeo')->get();
        return $datos;
    }
}
