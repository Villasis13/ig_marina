<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UnidadManejo extends Model
{
    use HasFactory;
    protected $table = "unidad_manejos";
    protected $primaryKey = "id_unidad_manejo";
    private $log;

    public function __construct()
    {
        $this->log = new Logs();
    }

    public function listar_unidad_manejos()
    {
        try {
            $result = DB::table('unidad_manejos as um')
                ->leftJoin('medida as m', 'm.id_medida', '=', 'um.id_medida')
                ->where('um.unidad_manejo_estado', 1)
                ->select('um.*', 'm.medida_nombre', 'm.medida_codigo_unidad')
                ->orderBy('um.id_unidad_manejo', 'asc')
                ->get();
        } catch (\Exception $e) {
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public function datos_unidad_manejo($id)
    {
        try {
            $result = DB::table('unidad_manejos')->where('id_unidad_manejo', $id)->first();
        } catch (\Exception $e) {
            $this->log->insertarLog($e);
            $result = null;
        }
        return $result;
    }

    public function unidad_manejo_x_codigo($codigo)
    {
        try {
            $result = DB::table('unidad_manejos')
                ->where('unidad_manejo_codigo', $codigo)
                ->where('unidad_manejo_estado', 1)
                ->first();
        } catch (\Exception $e) {
            $this->log->insertarLog($e);
            $result = null;
        }
        return $result;
    }
}
