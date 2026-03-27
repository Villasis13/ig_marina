<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tipo_documento extends Model
{
    use HasFactory;
    protected $table = "tyipo_documento";
    protected $primaryKey = "id_tipo_documento";
    private  $log;
    public function __construct()
    {
        $this->log = new Logs();
    }
    public  function listar_tipo_documento(){
        try {
            $result = DB::table('tipo_documento')->get();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

}
