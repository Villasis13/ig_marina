<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Submenu extends Model
{
    use HasFactory;
    protected $table = "submenu";
    protected $primaryKey = "id_submenu";
    private  $log;
    public function __construct()
    {
        $this->log = new Logs();
    }

    public  function listar_datos_submenu($id){
        try {
            $result = DB::table('submenu')->where('submenu.id_submenu','=',$id)->first();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    protected $fillable = ['id_menu','submenu_nombre','submenu_funcion','submenu_mostrar','submenu_orden','submenu_estado'];
    protected $fillableUpdate  = ['submenu_nombre','submenu_funcion','submenu_mostrar','submenu_orden','submenu_estado'];
    public  function guardar_submenu($model){
        try {
            if(isset($model['id_submenu'])){
                $menu = Submenu::find($model['id_submenu']);
                $menu->fill($model)->fillableUpdate; // Utiliza fillableUpdate para la actualización
                $result = $menu->save();
            }else{
                $guardar = new Submenu();
                $guardar->fill($model)->fillable;
                $result = $guardar->save();
            }
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public  function optiones_por_vista($nombre){
        try {

            $result = DB::table('submenu')->join('opciones', 'submenu.id_submenu', '=', 'opciones.id_submenu')
                ->where([['opciones.opciones_estado', 1],['submenu.submenu_funcion','=', $nombre]])->orderBy('opciones_orden','asc')->get();

        }catch(\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

}
