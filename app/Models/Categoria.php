<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categoria extends Model
{
    use HasFactory;
    protected $table = "categorias";
    protected $primaryKey = "id_c";
    private $log;
    public function __construct()
    {
        $this->log =  new Logs();
    }
    public  function listar_categoria_familias($id_fa){
        try {
            $result = DB::table('categorias as c')->where([['c.id_fa','=',$id_fa],['c.ca_estado','=',1]])->get();
        }catch(\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    public  function listar_categoria(){
        try {
            $result = DB::table('categorias as c')->where('c.ca_estado','=',1)->get();
        }catch(\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public  function categorias_x_nombre($nombre){
        try {
            $result = DB::table('categorias as c')->where([['c.ca_nombre','=',$nombre],['c.ca_estado','=',1]])->first();
        }catch(\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
























}
