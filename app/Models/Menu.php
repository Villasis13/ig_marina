<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;
    protected $table = "menus";
    protected $primaryKey = "id_menu";
    private  $log;
    public function __construct()
    {
        $this->log = new Logs();
    }
    public  function listar_menus_y_submenus(){
        try {
            $result = DB::table('menus as m')->where([['m.menu_estado','=',1],['m.menu_mostrar','=',1]])->orderBy('menu_orden','asc')->get();
            foreach ($result as $d){
                $d->submenu = DB::table('submenu as s')->where([['s.id_menu','=',$d->id_menu],['s.submenu_estado','=',1]])
                    ->where('s.submenu_mostrar','=',1)->orderBy('s.submenu_orden','asc')->get();
            }
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    public function listar_menus(){
        try {
            $result = DB::table('menus')->get();
            foreach ($result as $d){
                $d->contar = DB::table('submenu')->where('submenu.id_menu','=',$d->id_menu)->count();
            }
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    public  function listar_submenus($ID){
        try {
            $result = DB::table('submenu')->where('submenu.id_menu','=',$ID)->get();
            foreach ($result as $d){
                $d->contar = DB::table('opciones')->where('opciones.id_submenu','=',$d->id_submenu)->count();
            }
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    public  function listar_opciones($ID){
        try {
            $result = DB::table('opciones')->where('opciones.id_submenu','=',$ID)->get();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    protected $fillable = ['menu_nombre','menu_controlador','menu_icono','menu_orden','menu_mostrar','menu_estado'];
    protected $fillableUpdate  = ['menu_nombre','menu_controlador','menu_icono','menu_orden','menu_mostrar'];
    public  function guardar_menu($model){
        try {
            if(isset($model['id_menu'])){
                $menu = Menu::find($model['id_menu']);
                $menu->fill($model)->fillableUpdate; // Utiliza fillableUpdate para la actualización
                $result = $menu->save();
            }else{
                $guardar = new Menu();
                $guardar->fill($model)->fillable;
                $result = $guardar->save();
            }
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public  function listar_datos_menu($id){
        try {
            $result = DB::table('menus')->where('id_menu','=',$id)->first();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }

    public  function validar_permiso($nombre){
        try {
            $result = DB::table('permissions')->where('permissions.name','=',$nombre)->first();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    public function permisos_datos($nombre){
        try {
            $result = DB::table('permissions')->where('permissions.name','=',$nombre)->first();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
}
