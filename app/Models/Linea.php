<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Linea extends Model
{
    use HasFactory;
    protected $table = "lineas";
    protected $primaryKey = "id_linea";
    private $log;

    public function __construct()
    {
        $this->log = new Logs();
    }

    public function listar_lineas()
    {
        try {
            $result = DB::table('lineas as l')
                ->where('l.linea_estado', '=', 1)
                ->orderBy('l.id_linea', 'asc')
                ->get();
        } catch (\Exception $e) {
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public function datos_linea($id)
    {
        try {
            $result = DB::table('lineas')->where('id_linea', '=', $id)->first();
        } catch (\Exception $e) {
            $this->log->insertarLog($e);
            $result = null;
        }
        return $result;
    }

    public function linea_x_codigo($codigo)
    {
        try {
            $result = DB::table('lineas')
                ->where('linea_codigo', '=', $codigo)
                ->where('linea_estado', '=', 1)
                ->first();
        } catch (\Exception $e) {
            $this->log->insertarLog($e);
            $result = null;
        }
        return $result;
    }
}
