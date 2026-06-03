<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Productos extends Model
{
    use HasFactory;
    protected $table = "productos";
    protected $primaryKey = "id_pro";
    private $logs;
    public function __construct()
    {
       $this->logs = new Logs();
    }

    public function listar_productos(){
        try {
            $result = DB::table('productos as p')
                ->join('tipo_afectacion as ta','ta.id_tipo_afectacion','=','p.id_tipo_afectacion')
                ->where('p.pro_estado','=',1)
                ->get();
            //$result = DB::table('productos')->where('id_pro',1)->first();
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    public function buscar_codigo_repe($codigo,$id = null){
        try {
            $result = DB::table('productos as p')->where([['p.pro_estado','=',1],['p.pro_codigo','=',$codigo]]);
                if ($id){
                    $result->where('id_pro','<>',$id);
                }
            $result = $result->first();
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    public function datos_productos($id){
        try {
            $result = DB::table('productos as p')->where([['p.pro_estado','=',1],['p.id_pro','=',$id]])->first();
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public function buscar_productos($valor,$medida = null){
        try {
            // Divide el input en palabras
            $palabras = explode(' ', $valor);

            $result = DB::table('productos as p')
                ->where('p.pro_estado', '=', 1)
                ->select('p.*');
            if ($medida){
                $result->where('p.id_medida', '=', $medida);
            }
            $result = $result->where(function ($query) use ($palabras) {
                    foreach ($palabras as $palabra) {
                        $query->where('p.pro_nombre', 'like', '%' . $palabra . '%')
                            ->orWhere('p.pro_codigo', 'like', '%' . $palabra . '%');
                    }
                })->limit(100)->get();

//            $result = DB::table('productos as p')
//                ->where([['p.pro_nombre','like', '%'.$valor.'%'],['p.pro_estado','=',1]])->get();
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            $result = [];
        }
        return $result;
    }


    public function sin_bolsa($valor,$medida){
        try {
            // Divide el input en palabras
            $palabras = explode(' ', $valor);
            $result = DB::table('productos as p')
                ->where('p.pro_estado', '=', 1)
                ->where('p.impuesto_bolsa', '=', 0)
                ->where('p.id_medida', '=', $medida)
                ->where(function ($query) use ($palabras) {
                    foreach ($palabras as $palabra) {
                        $query->where('p.pro_nombre', 'like', '%' . $palabra . '%')
                            ->orWhere('p.pro_codigo', 'like', '%' . $palabra . '%');
                    }
                })->get();

//            $result = DB::table('productos as p')
//                ->where([['p.pro_nombre','like', '%'.$valor.'%'],['p.pro_estado','=',1]])->get();
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            $result = [];
        }
        return $result;
    }
}
