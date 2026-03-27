<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cliente extends Model
{
    use HasFactory;
    protected $table = "clientes";
    protected $primaryKey = "id_clientes";
    private $log;
    public function __construct()
    {
        parent::__construct();
        $this->log =  new Logs();
    }

    public  function listar_clientes(){
        $datos = DB::table('clientes')->where('cliente_estado','=',1)->get();
        return $datos;
    }

    public function buscarCliente_numero($numero){
        try {
            $result = DB::table('clientes as c')
                ->join('tipo_documento as td','c.id_tipo_documento','=','td.id_tipo_documento')
                ->where('c.cliente_numero','=',$numero)
                ->where('c.cliente_estado','=',1)
                ->first();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    public  function listar_clienteventa_x_id($id){
        $cliente = DB::table('clientes as c')
            ->join('tipo_documento as ti','c.id_tipo_documento','=','ti.id_tipo_documento')
            ->where('c.id_clientes','=',$id)->first();
        return $cliente;
    }

    public function buscarCliente_codigo($numero){
        try {
            $result = DB::table('clientes as c')
                ->join('tipo_documento as td','c.id_tipo_documento','=','td.id_tipo_documento')
                ->where('c.cliente_codigo','=',$numero)
                ->where('c.cliente_estado','=',1)
                ->first();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
}
