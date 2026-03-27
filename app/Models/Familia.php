<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Familia extends Model
{
    use HasFactory;
    protected $table = "familias";
    protected $primaryKey = "id_fa";
    private $log;
    public function __construct()
    {
        $this->log =  new Logs();
    }

    public  function listar_familias(){
        try {
            $result = DB::table('familias as f')->where('f.fa_estado','=',1)->get();
        }catch(\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public  function datos_familias($id_fa){
        try {
            $result = DB::table('familias as f')->where('id_fa','=',$id_fa)->where('f.fa_estado','=',1)->first();
        }catch(\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public  function familias_x_nombre($nombre){
        try {
            $result = DB::table('familias as f')->where('f.fa_nombre','=',$nombre)->where('fa_estado','=',1)->first();
        }catch(\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
}
