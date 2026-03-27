<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Proveedores extends Model
{
    use HasFactory;
    protected $table = "proveedores";
    protected $primaryKey = "id_proveedores";
    private $log;
    public function __construct()
    {
        $this->log = new Logs();
    }

    public  function listar_proveedores(){
        try {
            $result = DB::table('proveedores')->join('tipo_documento','tipo_documento.id_tipo_documento','=','proveedores.id_tipo_documento')->where('proveedores.proveedores_estado','=',1)->get();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public  function datos_proveeedor($id){
        try {
            $result = DB::table('proveedores')->where('id_proveedores','=',$id)->first();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }


    public  function buscarProveedorNumero($numero){
        try {
            $result = DB::table('proveedores')->where([['proveedores_numero_documento','=',$numero],['proveedores_estado','=',1]])->first();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
}
