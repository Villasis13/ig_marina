<?php

namespace App\Http\Controllers;

use App\Http\Middleware\DynamicPermissionMiddleware;
use App\Models\General;
use App\Models\Logs;
use App\Models\Menu;
use App\Models\Opciones;
use App\Models\Persona;
use App\Models\Sub_menu;
use App\Models\Submenu;
use App\Models\Tipo_documento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Role as ModelsRole;
use ZipStream\File;

class ConfiguracionController extends Controller
{
    private $menus;
    private $submenu;
    private $logs;
    private $usuarios;
    private $tipoDocument;
    private $opciones;
    private $persona;
    private $general;
    public function __construct()
    {
        $this->menus = new Menu();
        $this->submenu = new Submenu();
        $this->logs = new Logs();
        $this->usuarios = new User();
        $this->tipoDocument = new Tipo_documento();
        $this->opciones = new Opciones();
        $this->persona = new Persona();
        $this->general = new General();
    }

    public function menus()
    {
        try {
//            ESTE IF ES PARA VERIFICAR SI ESE ROL TIENE EL PERMISO PARA LA VISTA
            $lista_menus = $this->menus->listar_menus();
            $opciones = $this->submenu->optiones_por_vista("menus");

            return view('configuracion/menus', compact('lista_menus','opciones'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }

    }
    public function submenus($ID)
    {
        try {

            $listar_submenu = $this->menus->listar_submenus($ID);
            $opciones =  $this->submenu->optiones_por_vista("submenu");


            return view('configuracion/submenu', compact('listar_submenu','ID','opciones'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }

    }
    public function opciones($ID)
    {
        try {
            $listar_opciones = $this->menus->listar_opciones($ID);
            $opciones = $this->submenu->optiones_por_vista("opciones");

            return view('configuracion/opciones', compact('listar_opciones','ID','opciones'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }

    }
    public function usuarios()
    {
        try {
            $listar_usuarios = $this->usuarios->listar_usuarios();
            $listar_tipo_documento =  $this->tipoDocument->listar_tipo_documento();
            $roles = DB::table('roles')->where('rol_estado','=',1)->get();
            $opciones = $this->submenu->optiones_por_vista("usuarios");
            return view('configuracion/usuarios', compact('listar_usuarios','listar_tipo_documento','roles','opciones'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }

    }
    public function iconos()
    {
        try {
            $opciones = $this->submenu->optiones_por_vista("iconos");

            return view('configuracion/iconos',compact('opciones'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }

    }
     public function roles()
        {
            try {
                $listar_roles = DB::table('roles')->where('roles.rol_estado','=',1)->get();
                $opciones =  $this->submenu->optiones_por_vista("roles");

                foreach($listar_roles as $m){
                    $m->permisos = DB::table('role_has_permissions')->select('permissions.name')
                        ->join('permissions','permissions.id','=','role_has_permissions.permission_id')
                        ->where('role_has_permissions.role_id','=',$m->id)
                        ->count();
                }

                $listar_permisos = DB::table('permissions as p')
                    ->join('menus','menus.id_menu','=','p.permiso_grupo_grupo')
                    ->where([['p.permiso_estado','=',1],['p.permiso_grupo','=',1]])->get();
                foreach ($listar_permisos as $li){
                    $li->sub = DB::table('permissions')
                        ->join('submenu as s','s.id_submenu','=','permissions.permiso_grupo_grupo')
                        ->where('s.id_menu','=',$li->id_menu)
                        ->where('permissions.permiso_estado','=',1)
                        ->where('permissions.permiso_grupo','=',2)
                        ->get();
                }
                foreach($listar_permisos as $a){
                    foreach ($a->sub as $se){
                        $se->opciones = DB::table('permissions')
                            ->join('opciones as o','o.id_opciones','=','permissions.permiso_grupo_grupo')
                            ->where('o.id_submenu','=',$se->id_submenu)
                            ->where('permissions.permiso_estado','=',1)
                            ->where('permissions.permiso_grupo','=',3)
                            ->get();
                    }
                }

                foreach($listar_permisos as $a){
                    foreach ($a->sub as $b){
                        foreach ($b->opciones as $c){
                            $c->permisos = DB::table('permissions')
                                ->where('permissions.permiso_grupo_grupo','=',$c->id_opciones)
                                ->where('permissions.permiso_estado','=',1)
                                ->where('permissions.permiso_grupo','=',4)
                                ->get();
                        }
                    }
                }
                return view('configuracion/roles', compact('listar_roles','listar_permisos','opciones'));
            }catch (\Exception $e){
                $this->logs->insertarLog($e);
                echo "<script>
                        alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                        window.location.href = '" . route('admin') . "';
                    </script>";
            }

        }

    public function permisos()
    {
        try {
            $lista_permisos = DB::table('permissions')->where('permissions.permiso_estado','=',1)->get();
            $opciones = $this->submenu->optiones_por_vista("permisos");

            return view('configuracion/permisos', compact('lista_permisos','opciones'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }

    }

    public function crear_menu(Request $request)
    {
        try {
            if(empty($request->editar_menu)){
                $val = $this->menus->validar_permiso($request->controlador_menu);
                if ($val == null){
                    $menu = [
                        'menu_nombre'=>$request->nombre_menu,
                        'menu_controlador'=>$request->controlador_menu,
                        'menu_icono'=>$request->icono_menu,
                        'menu_orden'=>$request->orden_menu,
                        'menu_mostrar'=>$request->visible == true ? 1 : 0,
                        'menu_estado'=>1,
                    ];
                    $result = $this->menus->guardar_menu($menu);
                    $id_menu = Menu::latest('id_menu')->first();
                    //aca crearemos el permiso con el mismo nombre de la funcion
                    if($result == 1 || $result){
                        $permisos = new Permission();
                        $permisos->id_menu = $id_menu->id_menu;
                        $permisos->id_submenu = null;
                        $permisos->id_opciones = null;
                        $permisos->name = $request->controlador_menu;
                        $permisos->permiso_grupo = 1;
                        $permisos->permiso_grupo_grupo = $id_menu->id_menu;;
                        $permisos->syncRoles('superadmin');
                        $guardar = $permisos->save();
                    }
                }

            }else{
//                bucamos el permisos con el mismo nombre del campo funcion de la tabla menu
                $dato_menu = $this->menus->listar_datos_menu($request->editar_menu);
                $datos = $this->menus->permisos_datos($dato_menu->menu_controlador);
                $val = $this->menus->validar_permiso($request->controlador_menu);
                if($val == false || $val->id_menu == $request->editar_menu ){
                    $menu = [
                        'id_menu'=>$request->editar_menu,
                        'menu_nombre'=>$request->nombre_menu,
                        'menu_controlador'=>$request->controlador_menu,
                        'menu_icono'=>$request->icono_menu,
                        'menu_orden'=>$request->orden_menu,
                        'menu_mostrar'=>$request->visible == true ? 1 : 0,
                        'menu_estado'=>1,
                    ];
                    $result = $this->menus->guardar_menu($menu);
                    if($result == 1 || $result){
                        $permisos = Permission::find($datos->id);
                        $nombreAntiguo = $permisos->name;
                        $nombreNuevo = $request->input('controlador_menu');
                        $permisos->name = $request->controlador_menu;
                        $guardar = $permisos->save();
                    }
                }else{
                    $guardar = false;
                }

            }
            return response(json_encode($guardar),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);

            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    public function crear_submenu(Request $request)
    {
        try {
            if(empty($request->id_submenu)){
                $val = $this->menus->validar_permiso($request->controlador_submenu);
                if($val == null){
                    $submenu = [
                        'id_menu'=>$request->id_menu,
                        'submenu_nombre'=>$request->nombre_submenu,
                        'submenu_funcion'=>$request->controlador_submenu,
                        'submenu_mostrar'=>$request->visible_submenu == true ? 1 : 0,
                        'submenu_orden'=>$request->orden_submenu,
                        'submenu_estado'=>1,
                    ];
                    $result = $this->submenu->guardar_submenu($submenu);
                    $id_submenu = Submenu::latest('id_submenu')->first();

                    //aca crearemos el permiso con el mismo nombre de la funcion
                    if($result == 1 || $result){
                        $permisos = new Permission();
                        $permisos->id_menu = null;
                        $permisos->id_submenu = $id_submenu->id_submenu;
                        $permisos->id_opciones = null;
                        $permisos->name = $request->controlador_submenu;
                        $permisos->permiso_grupo = 2;
                        $permisos->permiso_grupo_grupo = $id_submenu->id_submenu;
                        $permisos->syncRoles('superadmin');
                        $guardar = $permisos->save();
                    }
                }
            }else{
//                bucamos el permisos con el mismo nombre del campo funcion de la tabla menu
                $dato_submenu = $this->submenu->listar_datos_submenu($request->id_submenu);
                $datos = $this->menus->permisos_datos($dato_submenu->submenu_funcion);
                $val = $this->menus->validar_permiso($request->controlador_menu);
                if($val == false || $val->id_submenu == $request->id_submenu){
                    $menu = [
                        'id_submenu'=>$request->id_submenu,
                        'submenu_nombre'=>$request->nombre_submenu,
                        'submenu_funcion'=>$request->controlador_submenu,
                        'submenu_mostrar'=>$request->visible_submenu == true ? 1 : 0,
                        'submenu_orden'=>$request->orden_submenu,
                        'submenu_estado'=>1,
                    ];
                    $result = $this->submenu->guardar_submenu($menu);
                    if($result == 1 || $result){
                        $permisos = Permission::find($datos->id);
                        $permisos->name = $request->controlador_submenu;
                        $guardar = $permisos->save();
                    }
                }else{
                    $guardar = false;
                }

            }
            return response(json_encode($guardar),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }

    public function crear_opciones(Request $request)
    {
        try {
            if(empty($request->id_opciones)){
                $val = $this->menus->validar_permiso($request->funcion_opciones);
                if($val == null){
                    $submenu = [
                        'id_submenu'=>$request->id_submenu,
                        'opciones_nombre'=>$request->nombre_opciones,
                        'opciones_funcion'=>$request->funcion_opciones,
                        'opciones_orden'=>$request->orden_opciones,
                        'opciones_mostrar'=>$request->visible_opciones == true ? 1 : 0,
                        'opciones_estado'=> 1,
                    ];
                    $result = $this->opciones->guardar_opciones($submenu);
                    $id_opciones = Opciones::latest('id_opciones')->first();

                    //aca crearemos el permiso con el mismo nombre de la funcion
                    if($result == 1 || $result){
                        $permisos = new Permission();
                        $permisos->id_menu = null;
                        $permisos->id_submenu = null;
                        $permisos->id_opciones = $id_opciones->id_opciones;
                        $permisos->name = $request->funcion_opciones;
                        $permisos->permiso_grupo = 3;
                        $permisos->permiso_grupo_grupo = $id_opciones->id_opciones;
                        $permisos->syncRoles('superadmin');
                        $guardar = $permisos->save();
                    }
                }
            }else{
//                bucamos el permisos con el mismo nombre del campo funcion de la tabla menu
                $dato_submenu = $this->opciones->listar_datos_opciones($request->id_opciones);
                $datos = $this->menus->permisos_datos($dato_submenu->opciones_funcion);
                $val = $this->menus->validar_permiso($request->controlador_menu);
                if($val == false || $val->id_opciones == $request->id_opciones){
                    $menu = [
                        'id_opciones'=>$request->id_opciones,
                        'opciones_nombre'=>$request->nombre_opciones,
                        'opciones_funcion'=>$request->funcion_opciones,
                        'opciones_orden'=>$request->orden_opciones,
                        'opciones_mostrar'=>$request->visible_opciones == true ? 1 : 0,
                        'opciones_estado'=> 1,
                    ];
                    $result = $this->opciones->guardar_opciones($menu);
                    if($result == 1 || $result){
                        $permisos = Permission::find($datos->id);
                        $permisos->name = $request->funcion_opciones;
                        $guardar = $permisos->save();
                    }
                }else{
                    $guardar = false;
                }

            }
            return response(json_encode($guardar),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }

    public function crear_permisos_opciones(Request $request){
        try {
            // validar si el nombre del permiso ya exite para esa opciones
            $validar = DB::table('permissions')
                ->where([['name','=',$request->nombre_permiso__],['permiso_grupo_grupo','=',$request->id_opciones_permisos]])
                ->where([['permiso_estado','=',1],['permiso_grupo','=',4]])->exists();
            if($validar != true){
                $permisos = new Permission();
                $permisos->id_menu = null;
                $permisos->id_submenu = null;
                $permisos->id_opciones = null;
                $permisos->name = $request->nombre_permiso__;
                $permisos->permiso_grupo = 4;
                $permisos->permiso_grupo_grupo = $request->id_opciones_permisos;
                $permisos->syncRoles('superadmin');
                $guardar = $permisos->save();
                if($guardar == true){
                    $result = 1;
                }else{
                    $result = 2;
                }
            }else{
                $result = 3;
            }

            return response(json_encode($result),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    public function crear_usuarios(Request $request)
    {
        $microtime = microtime(true);
        try {
            if(empty($request->id_users)){
//                primero creamos a la persona
                $persona = [
                    "id_empresa" => 1,
                    "persona_nombre" => $request->input('nombre_persona'),
                    "persona_apellido_paterno" => $request->input('persona_apellido_paterno'),
                    "persona_apellido_materno" => $request->input('persona_apellido_materno'),
                    "persona_email" => $request->input('email'),
                    "persona_tipo_documento" => $request->input('tipo_documento'),
                    "persona_dni" => $request->input('numero_doc'),
                    "persona_nacionalidad" => null,
                    "persona_estado_civil" => null,
                    "persona_direccion" => null,
                    "persona_discapacidad" => null,
                    "persona_job" => null,
                    "persona_nacimiento" => $request->input('persona_fecha_nacimiento'),
                    "persona_sexo" => null,
                    "persona_telefono" => $request->input('telefono'),
                    "persona_telefono_2" => null,
                    "persona_foto" => null,
                    "persona_hijos" => null,
                    "persona_departamento" => null,
                    "persona_provincia" => null,
                    "persona_distrito" => null,
                    "persona_adicional" => null,
                    "persona_afp" => null,
                    "persona_cuspp" => null,
                    "persona_blacklist" => 'NO',
                    "persona_bank" => null,
                    "persona_number_account" => null,
                    "persona_bank_alt" => null,
                    "persona_number_account_alt" => null,
                    "persona_bank_cts" => null,
                    "persona_account_cts" => null,
                    "persona_cv" => null,
                    "persona_empleado" => 1,
                    "person_codigo" => $microtime,
                    "persona_estado" => 1
                ];
                $guardar_persona = $this->persona->guardar_persona($persona);
                if($guardar_persona){
                    $id_persona = Persona::latest('id_persona')->first();
                    if($request->hasFile('foto_users') != null ){
                        $fi = $request->file('foto_users');
                        $lugardestino = 'usuarios/';
                        $foto_persona =  $this->general->convertir_webp($fi,$lugardestino);
                    }else{
                        $foto_persona = 'sin-fotografia.png'; // Ruta del archivo por defecto
                    }
//                    $u = [
//                        'nombre_users'=> $request->nombre_persona,
//                        'email'=> $request->email,
//                        'password'=>  bcrypt($request->password),
//                        'username'=>  $request->username,
//                        'user_fotografia'=>  $foto_persona,
//                        'id_persona'=>$id_persona->id_persona,
//                        'users_estado'=>1,
//                    ];
//                    $guardar_usuarios = User::guardar_usuario($u);
                    $user = new User;
                    $user->nombre_users = $request->nombre_persona;
                    $user->email = $request->email;
                    $user->password = bcrypt($request->password);
                    $user->username =  $request->username;
                    $user->user_fotografia = $foto_persona;
                    $user->id_persona = $id_persona->id_persona;
                    $user->users_estado = 1;
                    $roles = $request->id_roles;
                    $user->syncRoles($roles);
                    $result = $user->save();
                }
            }else{
                $datos_users = DB::table('users')->where('users.id_users','=',$request->id_users)->first();
                $actualizar_usuario = User::find($request->id_users);
                $actualizar_usuario->nombre_users = $request->nombre_persona;
                $actualizar_usuario->username = $request->username;
                DB::table('model_has_roles')->where('model_id',$request->id_users)->delete();
                $actualizar_usuario->assignRole($request->id_roles);
                if($request->hasFile('foto_users') != null ){
                    try{
                        unlink($datos_users->user_fotografia);
                    }catch  (\Exception $e){
                    }
                    $fi = $request->file('foto_users');
                    $foto = $this->general->convertir_webp($fi ,'usuarios/');
                    $actualizar_usuario->user_fotografia = $foto;
                }
                $guardado = $actualizar_usuario->save();
                if($guardado){
                    $per = Persona::find($datos_users->id_persona);
                    $per->persona_nombre = $request->nombre_persona;
                    $per->persona_apellido_paterno = $request->persona_apellido_paterno;
                    $per->persona_apellido_materno = $request->persona_apellido_materno;
                    $per->persona_email = $request->email;
                    $per->persona_tipo_documento = $request->tipo_documento;
                    $per->persona_dni = $request->numero_doc;
                    $per->persona_nacimiento = $request->persona_fecha_nacimiento;
                    $per->persona_telefono = $request->telefono;
                    $result = $per->save();
                }
            }
            return response(json_encode($result),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }

    public function crear_rol(Request $request){
        try {
            if(empty($request->id_rol)){
//                $r = [
//                    'name'=>$request->input('nombre_rol'),
//                    'rol_descripcion'=>$request->input('descripcion_rol'),
//                    'rol_estado'=>1,
//                ];
                $rol = DB::table('roles')->insert([
                    'name'=>$request->nombre_rol,
                    'rol_descripcion'=>$request->descripcion_rol,
                    'guard_name'=>'web',
                    'rol_estado'=>1,
                ]);
                if ($rol){
                    $rol = true;
                }
//                $rol = Role::guardar_rol($r);
            }else{
//                $r = [
//                    'id'=>$request->input('id_rol'),
//                    'name'=>$request->input('nombre_rol'),
//                    'rol_descripcion'=>$request->input('descripcion_rol'),
//                ];
//                $rol = Role::guardar_rol($r);
                $rol = DB::table('roles')->where('id','=',$request->id_rol)->update([
                    'name'=>$request->nombre_rol,
                    'rol_descripcion'=>$request->descripcion_rol,
                ]);
                if ($rol){
                    $rol = true;
                }

            }

            if($rol == 1 || $rol){
                $result = true;
            }
            return response(json_encode($result),200)->header('Content-type','text/plain');

        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    public function crear_permisos_rol(Request $request){
        try {
            $rol = ModelsRole::find($request->id_rol_editar);
            $rol->syncPermissions($request->check);
            $guardar_rol = $rol->save();
            return response(json_encode($guardar_rol),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    public function crear_permisos(Request $request){
        try {
            $per = new Permission();
            $per->name = $request->nombre_permisos;
            $guardar_rol = $per->save();
            return response(json_encode($guardar_rol),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }





    function listar_datos_menu( Request $request){
        try {
            $datos =  $this->menus->listar_datos_menu($request->id);
            return response(json_encode($datos),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    function listar_datos_submenu( Request $request){
        try {
            $datos = $this->submenu->listar_datos_submenu($request->id);
            return response(json_encode($datos),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    function listar_datos_opciones( Request $request){
        try {
            $datos =  $this->opciones->listar_datos_opciones($request->id);
            return response(json_encode($datos),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    function listar_acciones_opciones(Request $request){
        try {
            $datos =  $this->opciones->listar_acciones_por_tab($request->id);
            return response(json_encode($datos),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    function listar_datos_usuario( Request $request){
        try {
            $datos =  $this->usuarios->listar_datos_usuario($request->id);
            return response(json_encode($datos),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    function listar_datos_rol( Request $request){
        try {
            $datos = DB::table('roles')->where('roles.id','=',$request->id)->first();
//                Role::listar_datos_rol($request->id);
            return response(json_encode($datos),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    function listar_datos_permisos_por_rol( Request $request){
        try {
            $datos= DB::table('role_has_permissions')->select('permissions.name','permissions.id')
                ->join('permissions','permissions.id','=','role_has_permissions.permission_id')
                ->where('role_has_permissions.role_id','=',$request->id)
                ->get();
            return response(json_encode($datos),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }



    function deshabilitar_opcion( Request $request){
        try {
                $result = DB::table('opciones')->where('opciones.id_opciones','=',$request->id)
                    ->update([
                        'opciones_estado'=>$request->estado
                    ]);
                if($result == 1 || $result){
                    $resultado = true;
                }
            return response(json_encode($resultado),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    function deshabilitar_submenu( Request $request){
        try {
                $result = DB::table('submenu')->where('submenu.id_submenu','=',$request->id)
                    ->update([
                        'submenu_estado'=>$request->estado
                    ]);
                if($result == 1 || $result){
                    $resultado = true;
                }
            return response(json_encode($resultado),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    function deshabilitar_menu( Request $request){
        try {
                $result = DB::table('menus')->where('menus.id_menu','=',$request->id)
                    ->update([
                        'menu_estado'=>$request->estado
                    ]);
                if($result == 1 || $result){
                    $resultado = true;
                }
            return response(json_encode($resultado),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);

            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    function deshabilitar_usuario( Request $request){
        try {
                $result = DB::table('users')->where('users.id_users','=',$request->id)
                    ->update([
                        'users_estado'=>$request->estado
                    ]);
                if($result == 1 || $result){
                    $resultado = true;
                }
            return response(json_encode($resultado),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);

            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    function deshabilitar_rol( Request $request){
        try {
                $result = DB::table('roles')->where('roles.id','=',$request->id)
                    ->update([
                        'rol_estado'=>$request->estado
                    ]);
                if($result == 1 || $result){
                    $resultado = true;
                }
            return response(json_encode($resultado),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);

            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    function deshabilitar_permiso( Request $request){
        try {
                $result = DB::table('permissions')->where('permissions.id','=',$request->id)
                    ->update([
                        'permiso_estado'=>$request->estado
                    ]);
                if($result == 1 || $result){
                    $resultado = true;
                }
            return response(json_encode($resultado),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);

            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }

    function eliminar_permiso( Request $request){
        try {
            $result = DB::table('permissions')->where('permissions.id','=',$request->id)->delete();
            if($result == 1 || $result){
                $resultado = true;
            }
            return response(json_encode($resultado),200)->header('Content-type','text/plain');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);

            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }


}
