<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contacto extends Model
{
    use HasFactory;
    protected $primaryKey = "id_contacto";
    protected $table = "contacto";

    public  function  listar_contacto(){
        $datos = DB::table('contacto')->where('contacto.contacto_estado','=',1)->get();
        return $datos;
    }
}
