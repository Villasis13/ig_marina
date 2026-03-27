<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Opciones extends Model
{
    use HasFactory;
    protected $table = "opciones";
    protected $primaryKey = "id_opciones";

    protected $fillable = ['id_submenu','opciones_nombre','opciones_funcion','opciones_orden','opciones_mostrar','opciones_estado'];
    protected $fillableUpdate  = ['opciones_nombre','opciones_funcion','opciones_orden','opciones_mostrar','opciones_estado'];
    private  $log;
    public function __construct()
    {
        $this->log = new Logs();
    }
    public  function guardar_opciones($model){
        try {
            if(isset($model['id_opciones'])){
                $menu = Opciones::find($model['id_opciones']);
                $menu->fill($model)->fillableUpdate; // Utiliza fillableUpdate para la actualización
                $result = $menu->save();
            }else{
                $guardar = new Opciones();
                $guardar->fill($model)->fillable;
                $result = $guardar->save();
            }
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public  function listar_datos_opciones($id){
        try {
            $result = DB::table('opciones')->where('opciones.id_opciones','=',$id)->first();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;

    }

    public  function listar_acciones_por_tab($id){
        try {
            $result = DB::table('permissions')->where([['permiso_grupo_grupo','=',$id],['permiso_estado','=',1]])->where('permiso_grupo','=',4)->get();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public  function listar_opciones_vista($nombre){
        try {
            $result = DB::table('opciones')->join('submenu','submenu.id_submenu','=','opciones.id_submenu')
                ->where('opciones.opciones_nombre','=',$nombre)->get();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
}
