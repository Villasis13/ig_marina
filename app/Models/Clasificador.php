<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Clasificador extends Model
{
    use HasFactory;
    protected $table = "clasificadores";
    protected $primaryKey = "id_clasificador";
    private $log;

    public function __construct()
    {
        $this->log = new Logs();
    }

    public function listar_clasificadores()
    {
        try {
            $result = DB::table('clasificadores')
                ->where('clasificador_estado', 1)
                ->orderBy('id_clasificador', 'asc')
                ->get();
        } catch (\Exception $e) {
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public function datos_clasificador($id)
    {
        try {
            $result = DB::table('clasificadores')->where('id_clasificador', $id)->first();
        } catch (\Exception $e) {
            $this->log->insertarLog($e);
            $result = null;
        }
        return $result;
    }

    public function clasificador_x_codigo($codigo)
    {
        try {
            $result = DB::table('clasificadores')
                ->where('clasificador_codigo', $codigo)
                ->where('clasificador_estado', 1)
                ->first();
        } catch (\Exception $e) {
            $this->log->insertarLog($e);
            $result = null;
        }
        return $result;
    }
}
