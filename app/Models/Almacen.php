<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Almacen extends Model
{
    use HasFactory;
    protected $table = "almacen";
    protected $primaryKey = "id_almacen";
    private $log;
    public function __construct()
    {
        $this->log =  new Logs();
    }
    public  function listar_almacen(){
        try {
            $result = DB::table('almacen')->where('almacen_estado','=',1)->get();
        }catch(\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    public  function datos_almacen($id){
        try {
            $result = DB::table('almacen')->where('id_almacen','=',$id)->first();
        }catch(\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    public  function listarOtrosAlmacenes($id){

        try {
            $result = DB::table('almacen')->where('id_almacen','<>',$id)
                ->where('almacen_estado','=',1)->get();
        }catch(\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
}
