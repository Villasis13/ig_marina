<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Caja_numero;
use App\Models\General;
use App\Models\Logs;
use App\Models\Menu;
use App\Models\Persona;
use App\Models\User;
use App\Models\Ventas;
use App\Models\Visualizacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
    private $usuario;
    private $log;
    private $general;
    private $caja;
    private $caja_numero;
    private $ventas;
    public function __construct()
    {
        $this->usuario = new User();
        $this->log = new Logs();
        $this->general = new General();
        $this->caja = new Caja();
        $this->caja_numero = new Caja_numero();
        $this->ventas =  new Ventas();
    }

    public function inicio(){
        try{
            // Obtener la fecha de inicio y fin del mes actual
            $fechaInicioMes = Carbon::now()->startOfMonth();
            $fechaFinMes = Carbon::now()->endOfMonth();
            $mesesEnEspanol = ['January' => 'enero', 'February' => 'febrero', 'March' => 'marzo', 'April' => 'abril', 'May' => 'mayo', 'June' => 'junio', 'July' => 'julio', 'August' => 'agosto', 'September' => 'septiembre', 'October' => 'octubre', 'November' => 'noviembre', 'December' => 'diciembre',];
            $nombreMes = $mesesEnEspanol[\Carbon\Carbon::now()->format('F')];

            $datos_usuario = $this->usuario->listar_datos_usuario(Auth::id());
            Session::put('persona', $datos_usuario->persona_nombre);
            $opciones = null;
            $apertura = $this->caja->buscar_apertura_caja();
            $caja = $this->caja_numero->listar_caja_numeros();
            $ventas_mes = $this->ventas->listar_ventas_x_mes($fechaInicioMes,$fechaFinMes);
            $clientes = DB::table('clientes')->where('cliente_estado','=',1)->count();
            $compras_mes = DB::table('orden_compra as oc')->where('orden_compra_estado','=',1)
                ->whereDate('orden_compra_fecha','>=',$fechaInicioMes)
                ->whereDate('orden_compra_fecha','<=',$fechaFinMes)->count();

            $productos_stock_bajo = DB::table('productos')
                ->where('pro_estado', 1)
                ->where('stock_minimo', '>', 0)
                ->whereRaw('pro_stock <= stock_minimo')
                ->select('pro_nombre', 'pro_codigo', 'pro_stock', 'stock_minimo')
                ->orderBy('pro_stock', 'asc')
                ->get();

            $lotes_por_vencer = DB::table('lotes as l')
                ->join('productos as p', 'p.id_pro', '=', 'l.id_pro')
                ->where('l.estado', 'disponible')
                ->where('l.cantidad', '>', 0)
                ->whereNotNull('l.fecha_vencimiento')
                ->whereDate('l.fecha_vencimiento', '<=', Carbon::now()->addDays(30))
                ->select('p.pro_nombre', 'p.pro_codigo', 'l.numero_lote', 'l.fecha_vencimiento', 'l.cantidad')
                ->orderBy('l.fecha_vencimiento', 'asc')
                ->get();


            $dias_espanol = [
                'Monday' => 'Lun',
                'Tuesday' => 'Mar',
                'Wednesday' => 'Mié',
                'Thursday' => 'Jue',
                'Friday' => 'Vie',
                'Saturday' => 'Sáb',
                'Sunday' => 'Dom'
            ];
            $fechaActual = Carbon::now();
            $numerosDiasSemana = [];
            for ($i = 0; $i <= 19; $i++) {
                $fechaDia = $fechaActual->copy()->subDays($i);
                $nombreDia = $dias_espanol[$fechaDia->format('l')];
                $numerosDiasSemana[] = [
                    'dia_semana' => $nombreDia,
                    'numero_dia' => $fechaDia->day,
                    'numero_mes' => $fechaDia->month,
                ];
            }
            // Invertimos el array para tener primero los días anteriores y luego la fecha actual
            $numerosDiasSemana = array_reverse($numerosDiasSemana);
            $dia_30dias = [];
            foreach ($numerosDiasSemana as $nu) {
                if($nu['numero_dia'] < 10){
                    $nuqqq = '0'.$nu['numero_dia'];
                }else{
                    $nuqqq =$nu['numero_dia'];
                }
                $dia_30dias[] = $nu['dia_semana'] . ' ' . $nuqqq . '/' . $nu['numero_mes'];
            }
            $dias_30 = $this->ventas->listarsuma_20_dias(1);
            // Obtener los días de la semana desde el lunes hasta el domingo
            $suma_ventas_30dias = [];
            foreach ($dias_30 as $s){
                $suma_ventas_30dias[] = $s['conteo'];
            }
            return view('admin/inicio', compact('opciones','suma_ventas_30dias','dia_30dias','apertura','clientes','compras_mes','ventas_mes','caja','nombreMes','productos_stock_bajo','lotes_por_vencer'));
        }catch (\Exception $e){
            $this->log->insertarLog($e);
            echo "<script>
                    alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                </script>";
            return redirect()->route('admin');

        }
    }

    public function aperturar_caja(Request $request){
        try {
            $fecha = Carbon::now();
            $co = $fecha->format('Y-m-d');

            $validar = $this->caja->verifiar_apertura_usuario_logueado();
            $validar2 = $this->caja->validar_apartura_caja($request->id_caja_inicio);
            if (!$validar){
                if (!$validar2){
                    if(!$validar && !$validar2){
                        $guardar = DB::table('caja')->insert([ 'id_caja_numero'=>$request->id_caja_inicio, 'caja_fecha'=>date('Y-m-d'), 'id_users_apertura'=>Auth::id(), 'caja_apertura'=>$request->monto_apertura, 'caja_fecha_apertura'=>date('Y-m-d H:i:s'), 'caja_estado'=>1]);
                    }
                    if($guardar){
                        $result = 1;
                    }else{
                        $result = 2;
                    }
                }else{
                    $result = 3;
                }
            }else{
                $result = 4;
            }

            return json_encode( $result );
        }catch (\Exception $e){
            $this->log->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }

    public function cerrar_caja(Request $request){
        try {
//            $buscar_id = Caja_apertura_cierre::where([['caja_apertura_cierre.id_caja_numeros',$request->caja_a_cierre],['caja_apertura_cierre.caja_estado',1]])->first();
            $cerrar = DB::table('caja')->where('id_caja','=',$request->id_caja)->update([
                'id_users_cierre'=>Auth::id(),
                'caja_cierre'=>$request->monto_cierre,
                'caja_fecha_cierre'=>date('Y-m-d H:i:s'),
                'caja_estado'=>0
            ]);
            $result = $cerrar ? 1 : 2;
            return json_encode( $result );
        }catch (\Exception $e){
            $this->log->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }


    public function informacionusuario(Request $request){
        try {
            $datos = $this->usuario->listar_datos_usuario(Auth::id());

            return json_encode( $datos );
        }catch (\Exception $e){
           $this->log->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
    public function modificarInformacionusuarioLogueado(Request $request){
        // Código de error general
        $result = 2;
        $message = "Ha ocurrido un error al guardar el registro";
        // Mensaje a devolver en caso de hacer consulta por app
//        $message = 'OK';
        try {
            if ($request->estado_accion_editar_usuario == 1){
                $fecha_actual = date('Y-m-d');
                $validator = Validator::make($request->all(), [
                    'nombre_persona_editarDatosPersonales' => 'regex:/^[A-Za-zñÑ\s]+$/',
                    'id_persona_editarLogueado' => 'required|numeric',
                    'apellido_paterno_editarDatosPersonales' => 'regex:/^[A-Za-zñÑ\s]+$/',
                    'apellido_materno_editarDatosPersonales' => 'regex:/^[A-Za-zñÑ\s]+$/',
                    'fecha_nacimiento_editarDatosPersonales' => 'before:'.$fecha_actual,
                    'numero_telefono_editarDatosPersonales' => 'numeric',
                ]);
                if (!$validator->fails()) {
                    $personaUpdate = Persona::find($request->id_persona_editarLogueado);
                    $personaUpdate->persona_nombre = $request->nombre_persona_editarDatosPersonales;
                    $personaUpdate->persona_apellido_paterno = $request->apellido_paterno_editarDatosPersonales;
                    $personaUpdate->persona_apellido_materno = $request->apellido_materno_editarDatosPersonales;
                    $personaUpdate->persona_nacimiento = $request->fecha_nacimiento_editarDatosPersonales;
                    $personaUpdate->persona_telefono = $request->numero_telefono_editarDatosPersonales;
                    $guardar = $personaUpdate->save();
                    if ($guardar){
                        $result = 1;
                        $message = "Los datos personales han sido actualizados exitosamente.";
                        session(['persona' => $request->nombre_persona_editarDatosPersonales]);
                    }else{
                        $result = 2;
                        $message = "Ha ocurrido un error al actualizar los datos personales.";
                    }
                }else{
                    // Obtén los mensajes de error
                    $errors = $validator->errors()->all();
                    // Puedes unir los mensajes en una cadena o manejarlos de otra manera
                    $message = implode(' ', $errors);
                    // Código 6: Integridad de datos errónea
                    $result = 6;
//                    $message = "Integridad de datos fallida. Alguno(s) de los parámetros se están enviando de manera incorrecta";
                }
            }elseif ($request->estado_accion_editar_usuario == 2){
                $validator = Validator::make($request->all(), [
                    'nombre_usuario_editarDatosLogueado' => 'regex:/^[A-Za-zñÑ0-9\s]+$/',
                    'email_usuario_editarDatosLogueado' => 'email',
                    'id_usuario_editarLogueado2' => 'required|numeric',
                ]);
                if (!$validator->fails()) {
                    $datosUsuarios = DB::table('users')->where('id_users','=',$request->id_usuario_editarLogueado2)->first();
                    $userUpdate = User::find($request->id_usuario_editarLogueado2);
//                    $userUpdate->nombre_users = $request->nombre_usuario_editarDatosLogueado;
                    $userUpdate->username = $request->nombre_usuario_editarDatosLogueado;
                    $userUpdate->email = $request->email_usuario_editarDatosLogueado;
                    if($request->hasFile('modificarFotoUsuarioLogueado') != null ){
                        try{
                            unlink($datosUsuarios->user_fotografia);
                        }catch  (\Exception $e){
                        }
                        $fi = $request->file('modificarFotoUsuarioLogueado');
                        $lugardestino = 'usuarios/';
                        $foto = $this->general->convertir_webp($fi ,$lugardestino);
                        $userUpdate->user_fotografia = $foto;
                    }
                    $guardar = $userUpdate->save();
                    if ($guardar){
                        $result = 1;
                        $message = "Los datos del usuario han sido actualizados exitosamente.";
                    }else{
                        $result = 2;
                        $message = "Ha ocurrido un error al actualizar los datos del usuarios.";
                    }
                }else{
                    // Código 6: Integridad de datos errónea
                    $result = 6;
                    $errors = $validator->errors()->all();
                    $message = implode(' ', $errors);
                }
            }else{
                $userUpdate = User::find($request->id_usuarioLogueadoContrasenaNueva);
                $userUpdate->password = bcrypt($request->contraseñaUsuarioLogueadoNuevo);
                $guardar = $userUpdate->save();
                if ($guardar){
                    $result = 1;
                    $message = "La contraseña han sido actualizado exitosamente.";
                }else{
                    $result = 2;
                    $message = "Ha ocurrido un error al actualizar la contraseña.";
                }
            }
        } catch (\Exception $e) {
            $this->log->insertarLog($e);
            return json_encode($e);
        }
        // Retornamos el JSON
        return response()->json(["result" => ["code" => $result, "message" => $message]]);
    }

}
