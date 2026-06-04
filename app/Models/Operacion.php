<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Operacion extends Model
{
    use HasFactory;
    protected $table = "operaciones";
    protected $primaryKey = "id_operacion";
    private $log;

    public function __construct()
    {
        $this->log = new Logs();
    }

    public function listar_operaciones()
    {
        try {
            $result = DB::table('operaciones')
                ->where('operacion_estado', 1)
                ->orderBy('id_operacion', 'asc')
                ->get();
        } catch (\Exception $e) {
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public function datos_operacion($id)
    {
        try {
            $result = DB::table('operaciones')->where('id_operacion', $id)->first();
        } catch (\Exception $e) {
            $this->log->insertarLog($e);
            $result = null;
        }
        return $result;
    }
}
