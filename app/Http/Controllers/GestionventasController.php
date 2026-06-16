<?php

namespace App\Http\Controllers;

use App\Mail\ComprobanteCorreo;
use App\Models\Almacen;
use App\Models\Caja;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Clientes;
use App\Models\Contacto;
use App\Models\Detalle_compra;
use App\Models\Empresa;
use App\Models\Formaspago;
use App\Models\General;
use App\Models\Logs;
use App\Models\Movimientos_productos;
use App\Models\Movimientos_productosdetalle;
use App\Models\MovimientosProductosDetalle;
use App\Models\Orden_compra;
use App\Models\Producto;
use App\Models\Productos;
use App\Models\Proforma;
use App\Models\Proveedores;
use App\Models\Serie;
use App\Models\Submenu;
use App\Models\Tipo_cambio;
use App\Models\Tipo_documento;
use App\Models\Tipo_ncredito;
use App\Models\Tipo_ndebito;
use App\Models\Tipo_pago;
use App\Models\Tipo_venta;
use App\Models\Venta_detalle;
use App\Models\Ventas;
use App\Models\Lotes;
use App\Models\Series;
use App\Models\Ventas_detalle_pago;
use App\Utils\CustomFpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Luecano\NumeroALetras\NumeroALetras;

class GestionventasController extends Controller
{
    private $submenu;
    private $logs;
    private $general;
    private $productos;
    private $tipo_venta;
    private $tipo_pago;
    private $empresa;
    private $contacto;
    private  $movimeinto_producto;
    private $caja;
    private $clientes;
    private $formas_pago;
    private $tipo_documento;
    private $serie;
    private  $venta;
    private $proforma;

    public function __construct()
    {
        $this->submenu = new Submenu();
        $this->logs = new Logs();
        $this->general = new General();
        $this->productos = new Productos();
        $this->tipo_venta = new Tipo_venta();
        $this->tipo_pago = new Tipo_pago();
        $this->empresa = new Empresa();
        $this->contacto = new Contacto();
        $this->caja = new Caja();
        $this->movimeinto_producto =  new Movimientos_productos();
        $this->clientes =  new Cliente();
        $this->formas_pago =  new Formaspago();
        $this->tipo_documento =  new Tipo_documento();
        $this->serie =  new Serie();
        $this->venta = new Ventas();
        $this->proforma = new Proforma();
    }


    public function movimientos()
    {
        try {
//            ESTE IF ES PARA VERIFICAR SI ESE ROL TIENE EL PERMISO PARA LA VISTA
            $productos = $this->productos->listar_productos();
            $opciones = $this->submenu->optiones_por_vista("movimientos");


            return view('gestionventas/movimientos', compact('opciones','productos'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }
    public function proformas()
    {
        try {
//            ESTE IF ES PARA VERIFICAR SI ESE ROL TIENE EL PERMISO PARA LA VISTA
            $productos = $this->productos->listar_productos();
            $opciones = $this->submenu->optiones_por_vista("proformas");
            $desde = date('Y-m-d');
            $hasta = date('Y-m-d');
            $proformas = $this->proforma->listar_proformas_activas($desde, $hasta);

            if (isset($_POST['proforma_search_desde'],$_POST['proforma_search_hasta'])){
                $desde = $_POST['proforma_search_desde'];
                $hasta = $_POST['proforma_search_hasta'];
                $proformas = $this->proforma->listar_proformas_activas($desde, $hasta);
            }

            return view('gestionventas/proformas', compact('opciones','proformas','productos','hasta','desde'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }
    public function gestion_proforma()
    {
        try {
            $opciones = $this->submenu->optiones_por_vista("proformas");



            return view('gestionventas/realizar_proforma', compact('opciones'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }
    public function edit_proforma()
    {
        try {
            $id = $_GET['data'];
            if ($id){
                $proforma = DB::table('proformas as p')
                    ->join('clientes as c','c.id_clientes','=','p.id_clientes')
                    ->where('p.id_profo','=',$id)->first();
                $detalle = DB::table('proformas_detalles as pd')
                    ->join('productos as p','p.id_pro','=','pd.id_pro')
                    ->where('pd.id_profo','=',$id)->get();
                $detalle = json_encode($detalle);
                $opciones = $this->submenu->optiones_por_vista("proformas");
                return view('gestionventas/edit_proforma', compact('opciones','id','proforma','detalle'));
            }
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }
    public function realizar_ventas()
    {
        try {
//            ESTE IF ES PARA VERIFICAR SI ESE ROL TIENE EL PERMISO PARA LA VISTA
            $productos = $this->productos->listar_productos();
            $opciones = $this->submenu->optiones_por_vista("realizar_ventas");
            $validar_caja = $this->caja->buscar_apertura_caja();
            $clientes = $this->clientes->listar_clientes();
            $tipo_pago = $this->tipo_pago->listar_tipo_pago();
            $documento = $this->tipo_documento->listar_tipo_documento();
            $monedas = DB::table('monedas')->where('activo', 1)->get();
            $vendedores = DB::table('users')->where('users_estado', 1)->select('id_users','nombre_users','username')->get();
            return view('gestionventas/realizar_venta', compact('opciones','documento','tipo_pago','clientes','productos','validar_caja','monedas','vendedores'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }

    public function venta_detalle()
    {
        try {
            // Sacamos la información del dueño
            $id = $_GET['venta_id'];
            $id_venta = (int)$id;
            if($id_venta){
                $datos = "";
                $venta = $this->venta->listar_venta_x_id($id_venta);
                $detalle_venta = $this->venta->listar_venta_detalle_x_id_venta($id_venta);
                $empresa = $this->empresa->listar_datos_empresa();
                if($venta->venta_tipo == "07" || $venta->venta_tipo == "08"){
                    $detalle_venta = $this->venta->listar_venta_detalle_x_id_venta($id_venta);
                    if($venta->venta_tipo == "07"){
                        $datos =Tipo_ncredito::listar_tipo_notaC_x_codigo($venta->venta_codigo_motivo_nota);
                    }else{
                        $datos = Tipo_ndebito::listar_tipo_notaD_x_codigo($venta->venta_codigo_motivo_nota);
                    }
                    $venta->des = $datos->tipo_nota_descripcion;
                }

                // vamos a buscar si esa venta esta en cuotas!
                $cuotas = DB::table('ventas_cuotas')->where('id_venta','=',$id_venta)->get();
                $ruta_qr = $this->general->generar_qr($id_venta);


                $opciones = $this->submenu->optiones_por_vista("venta_detalle");
                return view('gestionventas/venta_detalle', compact('opciones','detalle_venta','empresa','datos','venta','cuotas','ruta_qr'));
            }
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }

    }



    public function buscar_movimientos_productos(Request $request)
    {
        try {
            $message = "";
            $result = $this->movimeinto_producto->listar_movimientos_productos($request->tipo, $request->desde, $request->hasta);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            $result = [];
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));
    }
    public function realizar_movimientos(Request $request)
    {
        try {
            $result = 1;
            $message = "";
            $datos = json_decode($request->datos);
            $tipo_movimiento = $request->tipo_movimiento;
            if ($tipo_movimiento == 2){
                $va = false;
                $message = "Los siguientes productos no cuenta con stock suficiente para el movimiento de salida :";
                foreach ($datos as $dat) {
                    $validar_stock = DB::table('productos')->where('id_pro', '=', $dat->id_producto)->first();
                    if ($dat->cantidad <= $validar_stock->pro_stock) {
                        $va = true;
                    }else{
                        $message.= $dat->nombre_producto.' ';
                    }
                }
                if ($va){
                    $guardar_movimientos = DB::table('movimientos_productos')->insert(['movimientos_productos_fecha' => date('Y-m-d'), 'id_users' => Auth::id(), 'movimientos_productos_fecha_creacion' => date('Y-m-d H:i:s'), 'movimientos_productos_tipo' => 2, 'movimientos_productos_estado' => 1, 'movimientos_productos_motivo' => $request->motivo_operacion]);
                    if ($guardar_movimientos) {
                        foreach ($datos as $d) {
                            $validar_stock_2 = DB::table('productos')->where('id_pro', '=', $d->id_producto)->first();
                            if ($d->cantidad <= $validar_stock_2->pro_stock) {
                                $ul_creacion = Movimientos_productos::latest('id_movimientos_productos')->first();
                                $detalle = DB::table('movimientos_productos_detalle')->insert([
                                    'id_movimientos_productos' => $ul_creacion->id_movimientos_productos,
                                    'id_pro' => $d->id_producto,
                                    'movimientos_productos_detalle_cantidad' => $d->cantidad,
                                    'movimientos_productos_detalle_estado' => 1,
                                ]);
                                if ($detalle) {
                                    DB::table('productos_log')->insert([
                                        'id_pro'                      => $d->id_producto,
                                        'id_tipo_movimiento_producto' => 4,
                                        'productos_log_fecha'         => date('Y-m-d'),
                                        'productos_log_cantidad'      => $d->cantidad,
                                        'productos_log_costo_unitario'=> floatval($validar_stock_2->pro_costo_promedio ?? 0),
                                        'productos_log_documento'     => 'MP-' . $ul_creacion->id_movimientos_productos,
                                        'productos_log_referencia_id' => $ul_creacion->id_movimientos_productos,
                                        'productos_log_estado'        => 1,
                                    ]);
                                    $reducir = DB::table('productos')->where('id_pro', '=', $d->id_producto)->update(['pro_stock' => $validar_stock->pro_stock - $d->cantidad]);
                                    // Marcar serie como vendida en movimiento de salida y sincronizar pro_stock
                                    if (!empty($d->id_serie_producto) && !empty($d->control_serie)) {
                                        \App\Models\Series::where('id_serie', $d->id_serie_producto)
                                            ->where('estado', 'disponible')
                                            ->update(['estado' => 'vendido']);
                                        DB::table('productos')->where('id_pro', $d->id_producto)
                                            ->update(['pro_stock' => \App\Models\Series::stockDisponible($d->id_producto)]);
                                    }
                                }
                            }
                        }
                        $result = $reducir ? 1 : 2;
                        $message = "El movimiento se llevó a cabo con éxito.";
                    }
                }else{
                    $result = 3;
                }
            }elseif ($tipo_movimiento == 1){ // INGRESO

                $guarNew = new Movimientos_productos();
                $guarNew->movimientos_productos_fecha = date('Y-m-d');
                $guarNew->id_users = Auth::id();
                $guarNew->movimientos_productos_fecha_creacion = date('Y-m-d H:i:s');
                $guarNew->movimientos_productos_tipo = 1;
                $guarNew->movimientos_productos_estado = 1;
                if ($guarNew->save()) {
                    $result = 1;
                    $idUltimoRegistro = $guarNew->id_movimientos_productos;
                    foreach ($datos as $d) {

                        $informacionProducto = DB::table('productos')->where('id_pro', '=', $d->id_producto)->first();

                        if ($result == 1){

                            $newDetalle = new MovimientosProductosDetalle();
                            $newDetalle->id_movimientos_productos = $idUltimoRegistro;
                            $newDetalle->id_pro = $d->id_producto;
                            $newDetalle->movimientos_productos_detalle_cantidad = $d->cantidad;
                            $newDetalle->movimientos_productos_detalle_estado = 1;
                            if ($newDetalle->save()){
                                DB::table('productos_log')->insert([
                                    'id_pro'                      => $d->id_producto,
                                    'id_tipo_movimiento_producto' => 3,
                                    'productos_log_fecha'         => date('Y-m-d'),
                                    'productos_log_cantidad'      => $d->cantidad,
                                    'productos_log_costo_unitario'=> floatval($informacionProducto->pro_costo_promedio ?? 0),
                                    'productos_log_documento'     => 'MP-' . $idUltimoRegistro,
                                    'productos_log_referencia_id' => $idUltimoRegistro,
                                    'productos_log_estado'        => 1,
                                ]);
                                $updateProduct = Productos::find($d->id_producto);
                                $updateProduct->pro_stock = ($informacionProducto->pro_stock + $d->cantidad);
                                if ($updateProduct->save()){
                                    $result = 1;
                                }else{
                                    $result = 2;
                                }
                                // Registrar nueva serie en ingreso y sincronizar pro_stock
                                if (!empty($d->numero_serie) && !empty($d->control_serie)) {
                                    \App\Models\Series::create([
                                        'id_pro'           => $d->id_producto,
                                        'numero_serie'     => $d->numero_serie,
                                        'numero_motor'     => $d->numero_motor     ?? null,
                                        'color'            => $d->color            ?? null,
                                        'anio_fabricacion' => $d->anio_fabricacion ?? null,
                                        'estado'           => 'disponible',
                                    ]);
                                    DB::table('productos')->where('id_pro', $d->id_producto)
                                        ->update(['pro_stock' => \App\Models\Series::stockDisponible($d->id_producto)]);
                                }
                            }else{
                                $result = 2;
                            }
                        }
                    }

                    $message = "El movimiento se llevó a cabo con éxito.";
                }else{
                    $result = 2;
                    $message = "Ocurrió un error al guardar el movimiento.";
                }

            }
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            $result = [];
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));
    }
    public function listarInformacionProforma(Request $request){
        try {
            $result = DB::table('proformas as p')
                ->join('clientes as c','c.id_clientes','=','p.id_clientes')
                ->where('p.id_profo','=',$request->data)->first();

            $detalle = DB::table('proformas_detalles as pd')
                ->join('productos as p','p.id_pro','=','pd.id_pro')
                ->where('pd.id_profo','=',$request->data)
                ->get();
        }catch (\Exception $e) {
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result,'detalle'=>$detalle)));
    }
    public function realizar_proforma(Request $request)
    {
        try {
            $result = 1;
            $message = "";
            $accion_funcion = $request->action_proforma_register;
            if ($accion_funcion == 1){
                $datos = json_decode($request->datos);
                $conteo_error = 0;
                $message = "Los siguientes productos no cuenta con stock suficiente para el movimiento de salida :";
                foreach ($datos as $dat) {
                    $validar_stock = DB::table('productos')->where('id_pro', '=', $dat->id_pro)->first();
                    if ($dat->cantidad > $validar_stock->pro_stock) {
                        $message.= $dat->pro_nombre.' ';
                        $conteo_error++;
                    }
                }
                if ($conteo_error == 0){ // validar stock productos
                    // CREAR CLIENTES
                    DB::beginTransaction();
                    $microtime = microtime(true);
                    $cliente = $this->clientes->buscarCliente_numero($request->num_documento);
                    if (!$cliente){
                        DB::table('clientes')->insert(['id_tipo_documento'=>$request->id_tipo_documento,'cliente_razonsocial'=>$request->razon_social_cliente, 'cliente_nombre'=>$request->razon_social_cliente, 'cliente_numero'=>$request->num_documento, 'cliente_direccion'=>$request->direccion_cliente, 'cliente_telefono'=>$request->tel_cliente, 'cliente_fecha'=>date('Y-m-d H:i:s'), 'cliente_estado'=>1,'cliente_codigo'=>$microtime]);
                        $cliente = $this->clientes->buscarCliente_codigo($microtime);
                    }else{
                        DB::table('clientes')->where('id_clientes','=',$cliente->id_clientes)
                            ->update(
                                ['id_tipo_documento'=>$request->id_tipo_documento,'cliente_razonsocial'=>$request->razon_social_cliente, 'cliente_nombre'=>$request->razon_social_cliente, 'cliente_numero'=>$request->num_documento, 'cliente_direccion'=>$request->direccion_cliente, 'cliente_telefono'=>$request->tel_cliente]
                            );
                    }
                    $correlativo = 1;
                    $sacar_ultimo = DB::table('proformas')->orderBy('id_profo','desc')->first();
                    if ($sacar_ultimo){
                        $correlativo = $sacar_ultimo->profo_correlativo + 1;
                    }
                    $insert = [
                        'id_clientes'=>$cliente->id_clientes,
                        'id_users'=>Auth::id(),
                        'profo_forma_pago'=>$request->forma_pago,
                        'profo_lugar_entrega'=>$request->lugar_entrega,
                        'profo_observacion'=>$request->observaciones_proforma,
                        'profo_serie'=>"PRO",
                        'profo_correlativo'=>$correlativo,
                        'profo_fecha_emision'=>date('Y-m-d H:i:s'),
                        'profo_estado'=>1,
                        'profo_acti_estado'=>0,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                        'profo_microtime'=>$microtime,
                    ];
                    $guardar_proforma = DB::table('proformas')->insert($insert);
                    if ($guardar_proforma){
                        $proforma_creada = DB::table('proformas')->where('profo_microtime','=',$microtime)->first();
                        if($proforma_creada){
                            $insert_detalle = [];
                            foreach ($datos as $d){
                                $insert_detalle[] = [
                                    'id_profo'=>$proforma_creada->id_profo,
                                    'id_pro'=>$d->id_pro,
                                    'profo_deta_precio'=>$d->producto_precio_final,
                                    'profo_deta_cantidad'=>$d->cantidad,
                                    'profo_deta_observacion'=>$d->comentarios,
                                    'profo_deta_estado'=>1,
                                    'profo_deta_usado'=>0,
                                ];
                            }
                            $detalle = DB::table('proformas_detalles')->insert($insert_detalle);
                            if ($detalle){
                                // Confirmar transacción
                                $result = 1;
                                $message = "Proforma realizada con éxito.";
                                DB::commit();
                            }
                        }else{
                            $result = 5;
                            $message = "Se ha producido un error al guardar la proforma.";
                            DB::rollback();
                        }

                    }else{
                        $result = 5;
                        $message = "Se ha producido un error al guardar la proforma.";
                        // Deshacer transacción en caso de error
                        DB::rollback();
                    }

                }else{
                    $result = 6;
                }
            }elseif ($accion_funcion == 2){

            }elseif ($accion_funcion == 3){
                $id_delete = $request->id;
                if ($id_delete){
                    $delete = DB::table('proformas')
                        ->where('id_profo','=',$id_delete)
                        ->update(['profo_estado'=>0]);
                    if ($delete){
                        $result  = 1;
                        $message = "Registro eliminado correctamente.";
                    }else{
                        $result  = 2;
                        $message = "Ha ocurrido un error al eliminar la proforma.";
                    }
                }else{
                    $result  = 3;
                    $message = "No existe una  proforma para eliminar.";
                }
            }
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            $result = [];
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));
    }
    public function buscar_productos(Request $request)
    {
        try {
            $message = "";
            $result = $this->productos->buscar_productos($request->valor,$request->medida);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            $result = [];
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));

    }


    public function detalle_movimientos_productos(Request $request)
    {
        try {
            $message = "";
            $result = $this->movimeinto_producto->listar_detalle_movimiento($request->id_movimiento);
        } catch (\Exception $e) {
            $result = [];
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));

    }

    public function consultar_serie(Request $request)
    {
        try {
            $concepto = $request->concepto;
            $series = "";
            $correlativo = "";
            $jalar_id_caja = $this->caja->buscar_apertura_caja();
            $id_caja = $jalar_id_caja->id_caja_numero;

            $serieMoto = null;
            $validarCheckMo = isset($request->checkMoto) && $request->checkMoto == 'true' ? true : false;
            if ($validarCheckMo){
                if ($request->tipo_venta == '01'){
                    $serieMoto = "FTT2";
                }elseif ($request->tipo_venta == '03'){
                    $serieMoto = "BTT2";
                }
            }

            if ($concepto == "LISTAR_SERIE") {
                if (isset($request->concepto)) {
                    $series = $this->serie->listarSerie_caja($request->tipo_venta, $id_caja,$serieMoto);
                } else {
                    $series = $this->serie->listarSerie_caja($request->tipo_venta, $id_caja,$serieMoto);
                }
            } else {
                $correlativo_ = $this->serie->listar_correlativos_x_serie($request->id_serie);
                $correlativo = $correlativo_->correlativo + 1;
            }
            $respuesta = array("serie" => $series, "correlativo" => $correlativo);
            return json_encode($respuesta);
        } catch (\Exception $e) {
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
    }





    public function buscar_series_producto(Request $request)
    {
        try {
            $series = Series::where('id_pro', $request->id_pro)
                ->where('estado', 'disponible')
                ->get(['id_serie as id_serie_producto', 'numero_serie', 'numero_motor', 'color', 'anio_fabricacion']);
            return response()->json(['result' => ['code' => 1, 'data' => $series]]);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response()->json(['result' => ['code' => 2, 'data' => []]]);
        }
    }

    public function generar_venta(Request $request){
        try {
            $message = "";
            $venta_a = "";
            $id_venta_final = "";
            $apertura = $this->caja->buscar_apertura_caja();
            if($apertura){
                $microtime = microtime(true);
                $product = json_decode($request->datos,true); // productos seleccionados
                if (count($product) > 0){
                    $impuesto_bolsa = 0;
                    $gravada = 0;
                    $exonerada = 0;
                    $gratuita = 0;
                    $inafectada = 0;
                    $total_igv = 0;
                    foreach ($product as $d){
                        $precio = $d['cantidad'] >= 12 ? $d['precio_mayor'] : $d['precio_venta'];
                        $desc_prod = isset($d['descuento']) ? floatval($d['descuento']) : 0;
                        $precio = $precio * (1 - $desc_prod / 100);
                        if ($d['id_tipo_afectacion'] == 1 ){
                            $menosC = $precio - ($precio / $d['porcentaje_igv']);
                            $menosC = round($menosC,2);
                            $total_igv += $menosC * $d['cantidad'];
                            $gravada+= ($precio - $menosC) * $d['cantidad'];
                            if($d['impuesto_bolsa'] == 1){
                                $impuesto_bolsa += $d['cantidad'] * 0.50;
                            }
                        }elseif ($d['id_tipo_afectacion'] == 2){
                            $exonerada += $precio * $d['cantidad'];
                        }elseif ($d['id_tipo_afectacion'] == 3){
                            $inafectada+= $precio * $d['cantidad'];
                        }elseif ($d['id_tipo_afectacion'] == 4){
                            $gratuita += $precio * $d['cantidad'];
                        }
                    }
                    $total_calculado_venta = $gravada + $exonerada + $inafectada + $total_igv + $impuesto_bolsa;

                    // ── Descuento global ──────────────────────────────────────────
                    $descuento_tipo  = $request->input('descuento_tipo', 'pct');
                    $descuento_valor = floatval($request->input('descuento_valor', 0));
                    $descuento_monto = 0;
                    $total_afectable = $gravada + $exonerada + $inafectada + $total_igv;

                    if ($descuento_valor > 0 && $total_afectable > 0) {
                        if ($descuento_tipo === 'pct') {
                            $descuento_monto = $total_afectable * ($descuento_valor / 100);
                        } else {
                            $descuento_monto = min($descuento_valor, $total_afectable);
                        }
                        $factor      = ($total_afectable - $descuento_monto) / $total_afectable;
                        $gravada    *= $factor;
                        $total_igv  *= $factor;
                        $exonerada  *= $factor;
                        $inafectada *= $factor;
                        $gratuita   *= $factor;
                        $total_calculado_venta = $gravada + $exonerada + $inafectada + $total_igv + $impuesto_bolsa;
                    }

                    $descuento_global_pct = $descuento_tipo === 'pct'
                        ? $descuento_valor
                        : ($total_afectable > 0 ? round(($descuento_monto / ($total_afectable + $descuento_monto)) * 100, 4) : 0);
                    // ── fin descuento ─────────────────────────────────────────────

                    $calculo_total = json_decode($request->calculo,true); // cuotas
                    $validar_cantidad_total = True;
                    if ($total_calculado_venta > 700 && $request->numero_documento == '11111111' ){
                        $validar_cantidad_total =  false;
                    }
                    if ($validar_cantidad_total){
                        // Iniciar transacción
                        DB::beginTransaction();
                        // cliente
                        $forma_pago = $request->id_formas_pago; // forma de pago 1 contado 2 credito
                        $numero_cliente = $request->numero_documento ? $request->numero_documento : 11111111;
                        $nombre_cliente = $request->nombre_cliente == 'ANONIMO' ? 'ANONIMO' : $request->nombre_cliente;
                        // fin cliente
                        $fecha = $request->fecha_emision
                            ? date('Y-m-d H:i:s', strtotime($request->fecha_emision))
                            : date('Y-m-d H:i:s'); //  fecha para la venta
                        $cliente = $this->clientes->buscarCliente_numero($numero_cliente);
                        if (!$cliente){
                            DB::table('clientes')->insert(['id_tipo_documento'=>$request->id_tipo_documento,'cliente_razonsocial'=>$nombre_cliente, 'cliente_nombre'=>$nombre_cliente, 'cliente_numero'=>$numero_cliente, 'cliente_direccion'=>$request->direccion_cliente, 'cliente_telefono'=>$request->telefono_cliente, 'cliente_fecha'=>date('Y-m-d H:i:s'), 'cliente_estado'=>1,'cliente_codigo'=>$microtime]);
                            $cliente = $this->clientes->buscarCliente_codigo($microtime);
                        }
                        $conteoStock = 0;
                        $message = "Los siguientes productos no tiene stock suficientes :";
                        foreach ($product as $p){
                            $producto = DB::table('productos')->where('id_pro','=',$p['id_pro'])->first();
                            if ($producto->id_medida == 58){
                                if ($producto->impuesto_bolsa == 0){
                                    if ($p['cantidad'] > $producto->pro_stock){
                                        $message .= $producto->pro_nombre.'-';
                                        $conteoStock++;
                                    }
                                }
                            }
                        }
                        if ($conteoStock == 0){
                            $message = "";
                            if ($forma_pago == 2){ // credito
                                $result = 1;
                                $cuotas = json_decode($request->cuotas,true); // cuotas
//                                $checkPartirPago = 0;
                                $coleccionCuotas = collect($cuotas);
                                $fechas = $coleccionCuotas->pluck('fecha_pago')->toArray();
                                $veri_fechas = count($fechas) === count(array_unique($fechas));
                                $veri_cuota = $coleccionCuotas->contains(function ($registro) {
                                    return $registro['monto'] === 0;
                                });
                                $validarTotal = $coleccionCuotas->sum('monto') == $total_calculado_venta;
                                if (!$veri_fechas || $veri_cuota || !$validarTotal) {
                                    $result = 5;
                                    $message = "";
                                    if (!$veri_fechas) {
                                        $message .= "Existen fechas de pago repetidas. <br> ";
                                    }
                                    if (!$veri_cuota) {
                                        $message .= "El monto en una de las cuotas es igual a 0. <br>";
                                    }
                                    if ($coleccionCuotas->sum('monto') != $total_calculado_venta) {
                                        $message = "El monto de las cuotas deben sumar el total de la venta  <br>";
                                    }
                                }
                                if ($result == 1){
                                    $sacar_serie = $this->serie->sacar_serie($request->serie,$apertura->id_caja_numero);
                                    $venta = [
                                        'id_caja_numero' => $apertura->id_caja_numero,
                                        'id_empresa' => 1,
                                        'id_clientes' => $cliente->id_clientes,
                                        'id_users' => Auth::id(),
                                        'id_tipo_pago' => null, // se guardara en la tabla ventas tipo pago
                                        'id_moneda' => 1, // defecto 1 = soles
                                        'venta_tipo_campo' =>0, // este campos sirve cuando la venta puede ser en dolares o soles
                                        'venta_condicion_resumen' => 1,
                                        'venta_tipo_envio' => 0,
                                        'venta_direccion' => $request->direccion_entrega ?: null,
                                        'venta_metodo_envio' => $request->metodo_envio ?: null,
                                        'venta_tipo' => $request->tipo_comprobante,
                                        'venta_serie' => $sacar_serie->serie,
                                        'venta_correlativo' => $sacar_serie->correlativo + 1,
                                        'venta_descuento_global' => round($descuento_global_pct, 4),
                                        'venta_totalgratuita' => $gratuita,
                                        'venta_totalexonerada' => $exonerada,
                                        'venta_totalinafecta' => $inafectada,
                                        'venta_totalgravada' => $gravada,
                                        'venta_totaligv' => $total_igv,
                                        'venta_incluye_igv' => 1,
                                        'venta_totaldescuento' => round($descuento_monto, 2),
                                        'venta_icbper' => $impuesto_bolsa,
                                        'venta_total' =>  $total_calculado_venta ,
                                        'venta_pago_cliente' => $total_calculado_venta,
                                        'venta_vuelto' => 0.00,
                                        'venta_fecha' => $fecha,
                                        'venta_observacion' => null,
                                        'id_vendedor' => $request->id_vendedor ?: Auth::id(),
                                        'venta_motivo' => $request->venta_motivo ?: 'ventas',
                                        'venta_fecha_vencimiento' => $request->venta_fecha_vencimiento ?: null,
                                        'venta_condicion_pago' => $request->venta_condicion_pago ?: 'contado',
                                        'tipo_documento_modificar' => "",
                                        'serie_modificar' => null,
                                        'correlativo_modificar' => "",
                                        'venta_codigo_motivo_nota' => null,
                                        'venta_estado_sunat' => 0,
                                        'venta_fecha_envio' => null,
                                        'venta_rutaXML' => null,
                                        'venta_rutaCDR' => null,
                                        'venta_respuesta_sunat' => null,
                                        'venta_fecha_de_baja' => null,
                                        'anulado_sunat' => 0,// 0 activo  1 anulado
                                        'venta_cancelar' => 1, // 1 activo 0 anulado
                                        'venta_seriecorrelativo_notaventa' => null,
                                        'venta_codigo' => $microtime,
                                        'cambiar_concepto' => 1,
                                        'concepto_nuevo' => null,
                                        'tipo_venta' => 0,// venta de sistema!
                                        'venta_estado_venta' => 1,// venta de sistema! esto es para saber si el cliente pago el pedido
                                        'id_formas_pago'=>$forma_pago,
                                        'venta_estado_pago'=> $forma_pago != 2 ? 2  : 0
                                    ];
                                    $guardar_venta =  DB::table('ventas')->insert($venta);
                                    if ($guardar_venta){
                                        $actualizar_serie = DB::table('serie')->where([['id_caja_numero','=',$sacar_serie->id_caja_numero],['serie','=',$sacar_serie->serie]])->update(['correlativo'=>$sacar_serie->correlativo +1]);
                                        if ($actualizar_serie){
                                            $ultima_venta = $this->venta->listar_venta_x_codigo($microtime);
                                            $detalles = [];
                                            foreach ($product as $d){
                                                $precio = $d['cantidad'] >= 12 ? $d['precio_mayor'] : $d['precio_venta'];
                                                $desc_prod = isset($d['descuento']) ? floatval($d['descuento']) : 0;
                                                $precio = round($precio * (1 - $desc_prod / 100), 2);
                                                $cantidad_igv = $d['id_tipo_afectacion'] == 1 ?  $precio - ($precio / $d['porcentaje_igv']) : 0;
                                                $cantidad_igv = round($cantidad_igv,2);

                                                if ($d['porcentaje_igv'] == 1.18){
                                                    $porcentaje_igv =18;
                                                }elseif($d['porcentaje_igv'] == 1.10){
                                                    $porcentaje_igv = 10;
                                                }else{
                                                    $porcentaje_igv = 0;
                                                }
                                                $detalles[] = [
                                                    'id_venta' => $ultima_venta->id_venta,
                                                    'id_pro' => $d['id_pro'],
                                                    'id_serie' => !empty($d['id_serie_producto']) ? $d['id_serie_producto'] : null,
                                                    'venta_detalle_valor_unitario' => $precio - $cantidad_igv,
                                                    'venta_detalle_precio_unitario' => $precio,
                                                    'venta_detalle_nombre_producto' => $d['nombre_producto'],
                                                    'venta_detalle_descripcion' => $d['descripcion'],
                                                    'venta_detalle_cantidad' => $d['cantidad'],
                                                    'venta_detalle_total_igv' => $cantidad_igv * $d['cantidad'],
                                                    'venta_detalle_porcentaje_igv' => $porcentaje_igv,
                                                    'venta_detalle_total_icbper' => 0,
                                                    'venta_detalle_valor_total' => (($precio - $cantidad_igv) * $d['cantidad']),
                                                    'venta_detalle_importe_total' => $precio * $d['cantidad'],
                                                    'venta_detalle_descuento' => $desc_prod,
                                                ];
                                                // Marcar serie como vendida si el producto usa control de serie
                                                if (!empty($d['id_serie_producto'])) {
                                                    Series::where('id_serie', $d['id_serie_producto'])
                                                        ->where('estado', 'disponible')
                                                        ->update(['estado' => 'vendido', 'id_venta' => $ultima_venta->id_venta]);
                                                    DB::table('productos')->where('id_pro', $d['id_pro'])
                                                        ->update(['pro_stock' => Series::stockDisponible($d['id_pro'])]);
                                                }
                                            }
                                            $guardar_venta_detalle = DB::table('ventas_detalle')->insert($detalles);
                                            if ($guardar_venta_detalle){
                                                $doc_log = ($ultima_venta->venta_serie ?? '') . '-' . ($ultima_venta->venta_correlativo ?? '');
                                                foreach ($detalles as $det) {
                                                    DB::table('productos_log')->insert([
                                                        'id_pro'                      => $det['id_pro'],
                                                        'id_tipo_movimiento_producto' => 2,
                                                        'productos_log_fecha'         => date('Y-m-d'),
                                                        'productos_log_cantidad'      => $det['venta_detalle_cantidad'],
                                                        'productos_log_costo_unitario'=> floatval($det['venta_detalle_precio_unitario'] ?? 0),
                                                        'productos_log_documento'     => $doc_log,
                                                        'productos_log_referencia_id' => $ultima_venta->id_venta,
                                                        'productos_log_estado'        => 1,
                                                    ]);
                                                }
                                                $ara_cuoas = [];
                                                foreach ($cuotas as $c){
                                                    $fechaDateTime = \DateTime::createFromFormat('j/n/Y', $c['fecha_pago']);
                                                    // Verificar si la conversión fue exitosa
                                                    if ($fechaDateTime) {
                                                        $fechaFormateada = $fechaDateTime->format('Y-m-d');
                                                    }
                                                    $ara_cuoas[]=[
                                                        'id_venta'=>$ultima_venta->id_venta,'venta_cuota_numero'=>$c['cuota'], 'venta_cuota_importe'=>$c['monto'], 'venta_cuota_fecha'=>$fechaFormateada, 'venta_cuota_estado'=>1, 'venta_cuota_pago'=>0
                                                    ];
                                                }
                                                $cuo = DB::table('ventas_cuotas')->insert($ara_cuoas);
                                                if ($cuo){
                                                    // Confirmar transacción
                                                    DB::commit();
                                                    $result = 1;
                                                    $message = "Venta realizada con éxito";
                                                    $id_venta_final = $ultima_venta->id_venta;
                                                }else{
                                                    // Deshacer transacción en caso de error
                                                    DB::rollback();
                                                    $result = 9;
                                                    $message = "Ha ocurrido un error al guardar las cuotas de la venta.";
                                                }
                                            }else{
                                                // Deshacer transacción en caso de error
                                                DB::rollback();
                                                $result = 8;
                                                $message = "Ha ocurrido un error al guardar los detalles de la venta.";
                                            }
                                        }else{
                                            // Deshacer transacción en caso de error
                                            DB::rollback();
                                            $result = 7;
                                            $message = "Ha ocurrido un error al actualizar la serie de la venta.";
                                        }
                                    }else{
                                        // Deshacer transacción en caso de error
                                        DB::rollback();
                                        $result = 6;
                                        $message = "Ha ocurrido un error al guardar la venta.";
                                    }
                                }else{
                                    // Deshacer transacción en caso de error
                                    DB::rollback();
                                    $result = 5;
                                }
                            }else{ // venta normal
                                // validamos que el total de los monto sean igual o mayor al total.
                                $partiPago = $request->has('partir_pago_check') ? 1 : 0;
                                if ($partiPago == 1){
                                    $monto1 = $request->pago_cliente;
                                    $monto2 = $request->pago_cliente_2;
                                    $validar_total_monto = (($monto1 + $monto2) == $total_calculado_venta ? true : false);
                                    $validar_tipo_pago = $request->id_tipo_pago != $request->id_tipo_pago_2 ? true : false;
                                }else{

                                    $pago_cliente = floatval($request->pago_cliente);
                                    $total_calculado_venta = floatval($total_calculado_venta); // Asegurarse de que ambos sean flotantes

                                    if (abs($pago_cliente - $total_calculado_venta) < 0.01 || $pago_cliente > $total_calculado_venta) {
                                        $validar_total_monto = true;
                                    } else {
                                        $validar_total_monto = false;
                                    }

                                    $validar_tipo_pago = $request->id_tipo_pago ? true : false;
                                }
                                if ($validar_total_monto == true && $validar_tipo_pago){
                                    if ($partiPago == 1){
                                        $vuelto = 0;
                                        $pago = $total_calculado_venta;
                                    }else{
                                        $vuelto = $request->pago_cliente - $total_calculado_venta;
                                        $pago = $request->pago_cliente;
                                    }
                                    $sacar_serie = $this->serie->sacar_serie($request->serie,$apertura->id_caja_numero);
                                    $venta = [
                                        'id_caja_numero' => $apertura->id_caja_numero,
                                        'id_empresa' => 1,
                                        'id_clientes' => $cliente->id_clientes,
                                        'id_users' => Auth::id(),
                                        'id_tipo_pago' => null, // se guardara en la tabla ventas tipo pago
                                        'id_moneda' => 1, // defecto 1 = soles
                                        'venta_tipo_campo' =>0, // este campos sirve cuando la venta puede ser en dolares o soles
                                        'venta_condicion_resumen' => 1,
                                        'venta_tipo_envio' => 0,
                                        'venta_direccion' => $request->direccion_entrega ?: null,
                                        'venta_metodo_envio' => $request->metodo_envio ?: null,
                                        'venta_tipo' => $request->tipo_comprobante,
                                        'venta_serie' => $sacar_serie->serie,
                                        'venta_correlativo' => $sacar_serie->correlativo + 1,
                                        'venta_descuento_global' => round($descuento_global_pct, 4),
                                        'venta_totalgratuita' => $gratuita,
                                        'venta_totalexonerada' => $exonerada,
                                        'venta_totalinafecta' => $inafectada,
                                        'venta_totalgravada' => $gravada,
                                        'venta_totaligv' => $total_igv,
                                        'venta_incluye_igv' => 1,
                                        'venta_totaldescuento' => round($descuento_monto, 2),
                                        'venta_icbper' => $impuesto_bolsa,
                                        'venta_total' =>  $total_calculado_venta ,
                                        'venta_pago_cliente' => $pago,
                                        'venta_vuelto' => $vuelto,
                                        'venta_fecha' => $fecha,
                                        'venta_observacion' => null,
                                        'id_vendedor' => $request->id_vendedor ?: Auth::id(),
                                        'venta_motivo' => $request->venta_motivo ?: 'ventas',
                                        'venta_fecha_vencimiento' => $request->venta_fecha_vencimiento ?: null,
                                        'venta_condicion_pago' => $request->venta_condicion_pago ?: 'contado',
                                        'tipo_documento_modificar' => "",
                                        'serie_modificar' => null,
                                        'correlativo_modificar' => "",
                                        'venta_codigo_motivo_nota' => null,
                                        'venta_estado_sunat' => 0,
                                        'venta_fecha_envio' => null,
                                        'venta_rutaXML' => null,
                                        'venta_rutaCDR' => null,
                                        'venta_respuesta_sunat' => null,
                                        'venta_fecha_de_baja' => null,
                                        'anulado_sunat' => 0,// 0 activo  1 anulado
                                        'venta_cancelar' => 1, // 1 activo 0 anulado
                                        'venta_seriecorrelativo_notaventa' => null,
                                        'venta_codigo' => $microtime,
                                        'cambiar_concepto' => 1,
                                        'concepto_nuevo' => null,
                                        'tipo_venta' => 0,// venta de sistema!
                                        'venta_estado_venta' => 1,// venta de sistema! esto es para saber si el cliente pago el pedido
                                        'id_formas_pago'=>$forma_pago,
                                        'venta_estado_pago'=> $forma_pago != 2 ? 2  : 0
                                    ];
                                    $guardar_venta =  DB::table('ventas')->insert($venta);
                                    if ($guardar_venta){
                                        $actualizar_serie = DB::table('serie')->where([['id_caja_numero','=',$sacar_serie->id_caja_numero],['serie','=',$sacar_serie->serie]])->update(['correlativo'=>$sacar_serie->correlativo +1]);
                                        if ($actualizar_serie){
                                            $ultima_venta = $this->venta->listar_venta_x_codigo($microtime);
                                            $detalles = [];
                                            foreach ($product as $d){
                                                $precio = $d['cantidad'] >= 12 ? $d['precio_mayor'] : $d['precio_venta'];
                                                $desc_prod = isset($d['descuento']) ? floatval($d['descuento']) : 0;
                                                $precio = round($precio * (1 - $desc_prod / 100), 2);
                                                $cantidad_igv = $d['id_tipo_afectacion'] == 1 ?  $precio - ($precio / $d['porcentaje_igv']) : 0;
                                                $cantidad_igv =  round($cantidad_igv,2);
                                                if ($d['porcentaje_igv'] == 1.18){
                                                    $porcentaje_igv =18;
                                                }elseif($d['porcentaje_igv'] == 1.10){
                                                    $porcentaje_igv = 10;
                                                }else{
                                                    $porcentaje_igv = 0;
                                                }
                                                $detalles[] = [
                                                    'id_venta' => $ultima_venta->id_venta,
                                                    'id_pro' => $d['id_pro'],
                                                    'id_serie' => !empty($d['id_serie_producto']) ? $d['id_serie_producto'] : null,
                                                    'venta_detalle_valor_unitario' => $precio - $cantidad_igv,
                                                    'venta_detalle_precio_unitario' => $precio,
                                                    'venta_detalle_nombre_producto' => $d['nombre_producto'],
                                                    'venta_detalle_descripcion' => $d['descripcion'],
                                                    'venta_detalle_cantidad' => $d['cantidad'],
                                                    'venta_detalle_total_igv' => $cantidad_igv * $d['cantidad'],
                                                    'venta_detalle_porcentaje_igv' => $porcentaje_igv,
                                                    'venta_detalle_total_icbper' => 0,
                                                    'venta_detalle_valor_total' => (($precio - $cantidad_igv) * $d['cantidad']),
                                                    'venta_detalle_importe_total' => $precio * $d['cantidad'],
                                                    'venta_detalle_descuento' => $desc_prod,
                                                ];
                                                // Marcar serie como vendida si el producto usa control de serie
                                                if (!empty($d['id_serie_producto'])) {
                                                    Series::where('id_serie', $d['id_serie_producto'])
                                                        ->where('estado', 'disponible')
                                                        ->update(['estado' => 'vendido', 'id_venta' => $ultima_venta->id_venta]);
                                                    DB::table('productos')->where('id_pro', $d['id_pro'])
                                                        ->update(['pro_stock' => Series::stockDisponible($d['id_pro'])]);
                                                }
                                            }
                                            $guardar_venta_detalle = DB::table('ventas_detalle')->insert($detalles);
                                            if ($guardar_venta_detalle){
                                                $doc_log = ($ultima_venta->venta_serie ?? '') . '-' . ($ultima_venta->venta_correlativo ?? '');
                                                foreach ($detalles as $det) {
                                                    DB::table('productos_log')->insert([
                                                        'id_pro'                      => $det['id_pro'],
                                                        'id_tipo_movimiento_producto' => 2,
                                                        'productos_log_fecha'         => date('Y-m-d'),
                                                        'productos_log_cantidad'      => $det['venta_detalle_cantidad'],
                                                        'productos_log_costo_unitario'=> floatval($det['venta_detalle_precio_unitario'] ?? 0),
                                                        'productos_log_documento'     => $doc_log,
                                                        'productos_log_referencia_id' => $ultima_venta->id_venta,
                                                        'productos_log_estado'        => 1,
                                                    ]);
                                                }
                                                // guardado en venta detalle pago
                                                if ($partiPago == 1){
                                                    $pagos = [
                                                        [
                                                            'id_venta' => $ultima_venta->id_venta,
                                                            'id_tipo_pago' => $request->id_tipo_pago,
                                                            'venta_detalle_pago_monto' => $request->pago_cliente,
                                                            'venta_detalle_pago_estado' => 1
                                                        ],
                                                        [
                                                            'id_venta' => $ultima_venta->id_venta,
                                                            'id_tipo_pago' => $request->id_tipo_pago_2,
                                                            'venta_detalle_pago_monto' => $request->pago_cliente_2,
                                                            'venta_detalle_pago_estado' => 1
                                                        ]
                                                    ];

                                                }else{
                                                    $pagos = [
                                                        [
                                                            'id_venta' => $ultima_venta->id_venta,
                                                            'id_tipo_pago' => $request->id_tipo_pago,
                                                            'venta_detalle_pago_monto' => $pago - $vuelto,
                                                            'venta_detalle_pago_estado' => 1
                                                        ]
                                                    ];
                                                }
                                                // Insertar los pagos en la base de datos

                                                foreach ($pagos as $pago) {
                                                    $cuo = DB::table('ventas_detalle_pagos')->insert($pago);
                                                }
                                                if ($cuo ){
                                                    // vamos a reducir el stock de los  productos
                                                    $detale = $this->venta->listar_venta_detalle_x_id_venta_venta($ultima_venta->id_venta);
                                                    foreach ($detale as $d){
                                                        $stock_reducir = $d->venta_detalle_cantidad;
                                                        $producto = $this->productos->datos_productos($d->id_pro);
                                                        if ($producto->impuesto_bolsa == 0){
                                                            if ($producto->control_lote) {
                                                                // Consumir lotes FIFO (por fecha_vencimiento ASC, luego id ASC)
                                                                $pendiente = $stock_reducir;
                                                                $lotes = Lotes::where('id_pro', $d->id_pro)
                                                                    ->where('estado', 'disponible')
                                                                    ->where('cantidad', '>', 0)
                                                                    ->orderByRaw('ISNULL(fecha_vencimiento), fecha_vencimiento ASC')
                                                                    ->orderBy('id_lote', 'asc')
                                                                    ->get();
                                                                foreach ($lotes as $lote) {
                                                                    if ($pendiente <= 0) break;
                                                                    $consumir = min($lote->cantidad, $pendiente);
                                                                    $nueva_cantidad = $lote->cantidad - $consumir;
                                                                    Lotes::where('id_lote', $lote->id_lote)->update([
                                                                        'cantidad' => $nueva_cantidad,
                                                                        'estado'   => $nueva_cantidad <= 0 ? 'agotado' : 'disponible',
                                                                    ]);
                                                                    $pendiente -= $consumir;
                                                                }
                                                                $nuevo_stock = Lotes::stockDisponible($d->id_pro);
                                                                DB::table('productos')->where('id_pro', $d->id_pro)->update(['pro_stock' => $nuevo_stock]);
                                                            } else {
                                                                DB::table('productos')->where('id_pro','=',$d->id_pro)
                                                                    ->update(['pro_stock'=>$producto->pro_stock - $stock_reducir]);
                                                            }
                                                        }
                                                    }
                                                    // Confirmar transacción
                                                    DB::commit();
                                                    $result = 1;
                                                    $message = "Venta realizada con éxito";
                                                    $id_venta_final = $ultima_venta->id_venta;
                                                }else{
                                                    // Deshacer transacción en caso de error
                                                    DB::rollback();
                                                    $result = 9;
                                                    $message = "Ha ocurrido un error al guardar las cuotas de la venta.";
                                                }
                                            }else{
                                                // Deshacer transacción en caso de error
                                                DB::rollback();
                                                $result = 8;
                                                $message = "Ha ocurrido un error al guardar los detalles de la venta.";
                                            }
                                        }else{
                                            // Deshacer transacción en caso de error
                                            DB::rollback();
                                            $result = 7;
                                            $message = "Ha ocurrido un error al actualizar la serie de la venta.";
                                        }
                                    }else{
                                        // Deshacer transacción en caso de error
                                        DB::rollback();
                                        $result = 6;
                                        $message = "Ha ocurrido un error al guardar la venta.";
                                    }
                                }else{
                                    // Deshacer transacción en caso de error
                                    DB::rollback();
                                    $result = 5;
                                    $message ="";
                                    if (!$validar_total_monto){
                                        $message ="El o los montos de pago deben ser mayo o igual a la suma total de la venta";
                                    }
                                    if (!$validar_tipo_pago){
                                        $message ="El o los tipo de pago deben ser diferentes.";
                                    }

                                }
                            }
                        }else{
                            // Deshacer transacción en caso de error
                            DB::rollback();
                            $result = 5;
                            $message = $message;
                        }
                    }else{
                        $result = 12;
                        $message ="Ingrese la información del cliente";
                    }
                }else{
                    $result = 4;
                    $message ="Asegúrese de incluir al menos un producto para poder completar la venta";
                }
            }else{
                $result = 3;
                $message = "Debe realizar una apertura de caja.";
            }

//            $resultado = array('result'=>$result,'message'=>$message,'id_venta'=>$id_venta_final);
//            return json_encode($resultado);
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            $result = [];
//            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message,'id_venta'=>$id_venta_final)));
    }


    public function imprimir_proforma(){
        $id = $_GET['data'];
        $id_proforma = (int)$id;
        if($id_proforma){
            $guardar_localmente = true;
            $ruta_guardado = "";

            $proforma =  $this->proforma->listar_proforma_x_id($id_proforma);
            $detalle =  $this->proforma->listar_detalle_x_id($id_proforma);
            $empresa =  DB::table('empresa')
                ->where('id_empresa','=',1)->first();


            $pdf = new CustomFpdf('P');
            $pdf->AddPage();
            //CABECERA DEL ARCHIVO
            if (file_exists($empresa->empresa_foto_ticket)) {
                $pdf->Image("$empresa->empresa_foto_ticket", 10, 10, 30,30);
            }
            $pdf->Ln(5);
            $pdf->SetFillColor(220,220,220);
            $pdf->SetFont('Arial','B',14);
            // FILA 1
            $pdf->Cell(35,6,'',0,0,'');
            $pdf->Cell(95,6,$empresa->empresa_razon_social,0,0,1);
            $pdf->Cell(50,0,'','T',1,'R');
            // FILA 2
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(130,6,'',0,0,1);
            $pdf->Cell(50,8, "RUC: $empresa->empresa_ruc",0,1,'C',0);
            // FILA 3
//            $pdf->SetFillColor(231,193,201);
            $pdf->SetFillColor(192,54,97);
            if (file_exists('home.png')) {
                $pdf->Image("home.png", 45, 24, 4,4);
            }
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(35,6,'',0,0,'');
            $pdf->Cell(5,6,'',0,0,'L',0);
            $pdf->Cell(90,6,utf8_decode("$empresa->empresa_domiciliofiscal"),0,0,'L',0);
            $pdf->SetTextColor(255,255,255);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(50,8,utf8_decode('COTIZACIÓN'),0,1,'C',1);
            $pdf->SetFillColor(220,220,220);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);
            // FILA 4
            if (file_exists('phone-call.png')) {
                $pdf->Image("phone-call.png", 45, 29, 4,4);
            }
            $pdf->Cell(35,4,'',0,0,'');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(5,0.5,'',0,0,'L',0);
            $pdf->Cell(90,0.5,utf8_decode("$empresa->empresa_telefono1  /  $empresa->empresa_telefono2  "),0,0,'L',0);
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(50,8,"$proforma->profo_serie - 0$proforma->profo_correlativo",0,1,'C',0);
            // FILA 5
            if (file_exists('email.png')) {
                $pdf->Image("email.png", 45, 34, 4,4);
            }
            $pdf->Cell(35,4,'',0,0);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(5,-6,'',0,0,'L',0);
            $pdf->Cell(90,-6,utf8_decode("$empresa->empresa_correo"),0,0,'L',0);
            $pdf->Cell(50,0,'','T',1,'R');

            $pdf->Ln(5);
            $pdf->SetFillColor(192,54,97);

            $pdf->Cell(180,0,'','T',1,'R');
            $pdf->Ln(3);
            //
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(18,5,utf8_decode("SEÑORES :"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(97,5,utf8_decode("$proforma->cliente_razonsocial"),0,0,'L');
            $fecha = date('d/m/Y',strtotime($proforma->profo_fecha_emision));
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(25,5,utf8_decode("FECHA :"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,utf8_decode("$fecha"),0,1,'L');
            //
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(18,5,utf8_decode("DIRECCIÓN :"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(97,5,utf8_decode("$proforma->cliente_direccion"),0,0,'L');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(25,5,utf8_decode("MONEDA :"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,utf8_decode("SOLES"),0,1,'L');
            //
            if ($proforma->id_tipo_documento == 2){
                $documento = 'DNI:';
            }else{
                $documento = 'RUC:';
            }
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(18,5,utf8_decode("$documento"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(32,5,utf8_decode("$proforma->cliente_numero"),0,0,'L');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(20,5,utf8_decode("TELÉFONO:"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(45,5,utf8_decode("$proforma->cliente_telefono"),0,0,'L');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(25,5,utf8_decode("REFERENCIA:"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,utf8_decode(""),0,1,'L');
            //
            if ($proforma->profo_forma_pago == 1){
                $forma_pago = "CONTADO";
            }else{
                $forma_pago = 'CREDITO';
            }
            $pdf->SetFont('Arial','B',7);
//            $pdf->Cell(20,5,utf8_decode("ATENCIÓN:"),0,0,'L');
            $pdf->Cell(20,5,utf8_decode(""),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(30,5,utf8_decode(""),0,0,'L');
//            $pdf->Cell(30,5,utf8_decode("$proforma->nombre_users"),0,0,'L');
            $pdf->SetFont('Arial','B',7);
//            $pdf->Cell(20,5,utf8_decode("CORREO:"),0,0,'L');
            $pdf->Cell(20,5,utf8_decode(""),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(45,5,utf8_decode(""),0,0,'L');
//            $pdf->Cell(45,5,utf8_decode("karenpamela@emyspets.com"),0,0,'L');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(25,5,utf8_decode("FORMA DE PAGO:"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,utf8_decode("$forma_pago"),0,1,'L');
            $pdf->Ln(3);
            $pdf->Cell(180,0,'','T',1,'R');
            $pdf->Ln(3);
            //
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(30,5,utf8_decode("LUGAR DE ENTREGA:"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(85,5,utf8_decode("$proforma->profo_lugar_entrega"),0,0,'L');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(25,5,utf8_decode("VENDEDOR:"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,utf8_decode("$proforma->nombre_users"),0,1,'L');
            //
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(30,5,utf8_decode("OBSERVACIONES:"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(85,5,utf8_decode("$proforma->profo_observacion"),0,0,'L');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(25,5,utf8_decode("CARGO:"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,utf8_decode("Dep de Ventas"),0,1,'L');
            //
            $pdf->Cell(115,5,utf8_decode(""),0,0,'L');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(25,5,utf8_decode("CORREO:"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,utf8_decode("$proforma->email"),0,1,'L');
            //
            $pdf->Cell(115,5,utf8_decode(""),0,0,'L');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(25,5,utf8_decode("TELÉFONO:"),0,0,'L');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,utf8_decode("$proforma->persona_telefono"),0,1,'L');
            $pdf->Ln(3);
            $pdf->Cell(180,0,'','T',1,'R');
            $pdf->Ln(3);
            //COLUMNAS
            $pdf->SetFont('Helvetica','B',7);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(10, 6, 'ITEM', 1,'','C',1);
            $pdf->Cell(25, 6, utf8_decode("CÓDIGO"),1,0,'C',1);
            $pdf->Cell(90, 6, utf8_decode('DESCRIPCIÓN'), 1,'','C',1);
            $pdf->Cell(15, 6, 'CANT',1,0,'C',1);
            $pdf->Cell(20, 6, 'PRECIO',1,0,'C',1);
            $pdf->Cell(20, 6, 'TOTAL',1,1,'C',1);
            $pdf->Ln(2);
            $pdf->SetTextColor(0,0,0);
            //PRODUCTOS
            $pdf->SetWidths(array(10,25,90,15,20,20));
            $aa=1;
            $filas_tot = 0;
            $total_proforma = 0;
            foreach ($detalle as $f){
                $pdf->SetFont('Helvetica', '', 7);
                $desc =  $f->profo_deta_observacion ? utf8_decode(": $f->profo_deta_observacion") : '';
                $nombre = utf8_decode("$f->pro_nombre $desc");
                $pdf->Row(array($aa,$f->pro_codigo, $nombre,  number_format(round("$f->profo_deta_cantidad",2), 2, '.', ' '),  number_format(round("$f->profo_deta_precio",2), 2, '.', ' '),number_format(round($f->profo_deta_precio * $f->profo_deta_cantidad,2), 2, '.', ' ')));
                $cant = strlen($nombre);
                $filas = ceil($cant / 65);
                if($filas==0){$filas=1;}
                $filas_tot+=$filas;
                $he = 4 * $filas;
                $aa++;
                $total_proforma += number_format(round($f->profo_deta_precio * $f->profo_deta_cantidad,2), 2, '.', ' ');

            }
            $pdf->Ln(5);
            $da = new NumeroALetras();
            $importe_letra = $da->toInvoice($total_proforma,'2','soles');
//            $pdf->Cell(70, 3, "$importe_letra", 0,0,'L');
            $pdf->Ln(5);
            $pdf->Cell(105,20,utf8_decode("$importe_letra"),1,0,'C');
            $pdf->SetTextColor(255,255,255);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(45,20,utf8_decode("TOTAL GENERAL"),1,0,'C',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(30,20,"S/ ".number_format(round($total_proforma,2), 2, '.', ' '),1,1,'C');
            $pdf->SetFont('Arial','',6);
            $pdf->Ln(2);
            $pdf->Cell(180,4,utf8_decode("Sistema de Géstion Administrativa, Desarrollado por Eder Alfredo | Whatsapp 956449198 | E-mail: reynaalfredo421@gmail.com"),0,0,'C');

            if(isset($guardar_localmente) && isset($ruta_guardado)){

//                $ruta_guardado = 'comprobantes/'.date('Y-m-d').'.pdf';
                $ruta_guardado = "Proforma-$proforma->profo_serie-0$proforma->profo_correlativo".'.pdf';
                $pdf->Output("I",$ruta_guardado);
            } else {
                $pdf->Output('',"proformas-" .date('Y-m-d'));
            }
            exit;

        }
    }
    public function imprimir_ticket_pdf(){
        // Obtener los métodos de la clase
        $id = $_GET['venta_id'];
        $id_venta = (int)$id;
        if($id_venta){
            $guardar_localmente = true;
            $ruta_guardado = "";
            $dato_venta = $this->venta->listar_venta_x_id_pdf($id_venta);
            $detalle_venta = $this->venta->listar_venta_detalle_x_id_venta_pdf($id_venta);
            $formas_de_pao = Ventas_detalle_pago::listar_formas_x_idventa($id_venta);
            $formas_de_pago_mensaje = "";
            $contador_pago = 0;
            foreach ($formas_de_pao as $for){
                $contador_pago++;
                if($contador_pago > 1){
                    $c='-';
                }else{
                    $c=' ';
                }
                $formas_de_pago_mensaje.= $for->tipo_pago_nombre.$c;
            }
            $fecha_hoy = date('Y-m-d', strtotime($dato_venta->venta_fecha));
            $empresa = $this->empresa->listar_datos_empresa();
            $ruta_qr = $this->general->generar_qr($dato_venta->id_venta);
            $dnni = "";
            if ($dato_venta->venta_tipo == "03") {
                $tipo_comprobante = "BOLETA DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $dnni = 'DNI';
                $documento = $dato_venta->cliente_numero;
            } else if ($dato_venta->venta_tipo == "01") {
                $tipo_comprobante = "FACTURA DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $dnni = 'RUC';
                $documento = $dato_venta->cliente_numero;
            } else if ($dato_venta->venta_tipo == "07") {
                $tipo_comprobante = "NOTA DE CRÉDITO DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $dnni = 'DOCUMENTO';
                $documento = "$dato_venta->cliente_numero";
            } else if($dato_venta->venta_tipo == "08") {
                $tipo_comprobante = "NOTA DE DÉBITO DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $dnni = 'DOCUMENTO';
                $documento = "$dato_venta->cliente_numero";
            }else if($dato_venta->venta_tipo == "20") {
                $tipo_comprobante = "NOTA DE VENTA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $dnni = 'DOCUMENTO';
                $documento = "$dato_venta->cliente_numero";
            }
            $da = new NumeroALetras();
            $importe_letra = $da->toInvoice($dato_venta->venta_total,'2','soles');
            $arrayImporte = explode(".", $dato_venta->venta_total);
//        $montoLetras = $importe_letra . ' con ' . $arrayImporte[1] . '/100 ' . $dato_venta->moneda;
            $dato_impresion = 'DATOS DE IMPRESION:';
            $filas_detalle = count($detalle_venta);

            //Define el marcador de posición usado para insertar el número total de páginas en el documento
            //require 'app/view/pdf/fpdf/fpdf.php';
            $pdf = new CustomFpdf('P');
            $pdf->AddPage();
            //CABECERA DEL ARCHIVO
            if (file_exists($empresa->empresa_foto_ticket)) {
                $pdf->Image("$empresa->empresa_foto_ticket", 10, 10, 100,25);
            }
            $pdf->Ln(5);
            $pdf->SetFillColor(220,220,220);
            $pdf->SetFont('Helvetica','',9);
            $pdf->Cell(105,0,'','',0);
            $pdf->Cell(75,0,'','T',1,'R');
            $pdf->Cell(158,8, "RUC $dato_venta->empresa_ruc",0,1,'R',0);
            $pdf->Cell(105,8,"",0,0,'R',0);
                $pdf->Cell(75,8,utf8_decode($tipo_comprobante),0,1,'C',1);
            $pdf->Cell(150,8,"$serie_correlativo",0,1,'R',0);
            $pdf->Cell(105,0,'','',0);
            $pdf->Cell(75,0,'','T',1,'R');
            $pdf->SetFont('Helvetica','B',9);
            $pdf->MultiAlignCell(105,4,"$dato_venta->empresa_razon_social",0,1,'C');
            $pdf->SetFont('Helvetica','',7);
            $pdf->Cell(105,4,"$dato_venta->empresa_domiciliofiscal $dato_venta->empresa_departamento  - $dato_venta->empresa_provincia - $dato_venta->empresa_distrito",0,1,'C');
            $pdf->Ln(3);
            $pdf->Cell(180,0,'','T',1,'R');
            $pdf->Ln(3);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(22,4,"$dnni:",0,0,'L');
            $pdf->SetFont('Helvetica','',8);
            $pdf->Cell(54,4, "     $documento",0,0,'L',false);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(15,4,"Cliente:",0,0,'L');
            if($dato_venta->id_tipo_documento != 4){
                $pdf->SetFont('Helvetica','',7);
                $pdf->MultiAlignCell(90,4, utf8_decode($dato_venta->cliente_nombre),0,1,'L',false);
            }else{
                $pdf->SetFont('Helvetica','',7);
                $pdf->MultiAlignCell(90,4, utf8_decode($dato_venta->cliente_razonsocial),0,1,'L',false);
            }
            $pdf->Ln(2);
            $pdf->SetFillColor(180,180,180);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(27,4,utf8_decode('Dirección:'),0,0,'L');
            $pdf->SetFont('Helvetica','',8);
            $pdf->MultiCell(154,4,utf8_decode($dato_venta->cliente_direccion ? $dato_venta->cliente_direccion : '-'),0,1,'');
            /* ------------------------------------------------------------ */
            $pdf->Ln(2);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(16,4, "Fecha:",0,0,'L',false);
            $pdf->SetFont('Helvetica','',8);
            $pdf->Cell(60,4, "             $fecha_hoy",0,0,'L',false);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(15,4, "Pago:",0,0,'L',false);
            $pdf->SetFont('Helvetica','',8);
            $pdf->Cell(60,4, "$formas_de_pago_mensaje",0,1,'L',false);
            $pdf->Ln(2);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(16,4, "Moneda:",0,0,'L',false);
            $pdf->SetFont('Helvetica','',8);
            $pdf->Cell(60,4, "             SOLES",0,0,'L',false);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(15,4, "Vendedor:",0,0,'L',false);
            $pdf->SetFont('Helvetica','',8);
            $pdf->Cell(60,4, utf8_decode(strtoupper($dato_venta->persona_nombre)),0,1,'L',false);
            $pdf->Ln(2);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(26,4,"Forma de pago:",0,0,'L');
            $pdf->SetFont('Helvetica','',7);
            $pdf->Cell(50,4,utf8_decode($dato_venta->id_formas_pago == 1 ? 'CONTADO' : 'CRÉDITO'),0,1,'L');

            /* ------------------------------------------------------------ */
            //AQUI SE BUSCARA LAS CUOTAS
            if($dato_venta->id_formas_pago == 2){
                $dato_cuotas = $this->venta->listar_cuotas($id);
                $c=1;
                foreach ($dato_cuotas as $da){
                    $pdf->Ln(2);
                    $pdf->SetFont('Helvetica','',6);
                    $pdf->MultiAlignCell(34,4,"- Cuota 00".$c.': '.date('d-m-Y',strtotime($da->venta_cuota_fecha)).' ('.$da->venta_cuota_importe.')',0,0,'L');
                    $c++;
                }
            }
            $pdf->Ln(3);
            $pdf->MultiCell(140,4,"",0,1,false);
            //COLUMNAS
            $pdf->Cell(180,0,'','T',1,'R');
            $pdf->Ln(3);
            $pdf->SetFont('Helvetica','B',7);
            $pdf->Cell(8,  8, 'ITEM',                  1, '', 'C', 1);
            $pdf->Cell(22, 8, utf8_decode('CÓDIGO'),   1, 0,  'C', 1);
            $pdf->Cell(58, 8, utf8_decode('PRODUCTO'),  1, '', 'C', 1);
            $pdf->Cell(28, 8, 'FAMILIA',               1, 0,  'C', 1);
            $pdf->Cell(10, 8, 'CANT',                  1, 0,  'C', 1);
            $pdf->Cell(10, 8, 'U.M.',                  1, 0,  'C', 1);
            $pdf->Cell(22, 8, 'P.UNIT',                1, 0,  'C', 1);
            $pdf->Cell(27, 8, 'P.VENTA',               1, 1,  'C', 1);

            //PRODUCTOS
            $pdf->SetWidths(array(8,22,58,28,10,10,22,27));
            $aa=1;
            $filas_tot = 0;
            foreach ($detalle_venta as $f){
                $pdf->SetFont('Helvetica', '', 7);
                $medida = DB::table('productos as p')
                    ->leftJoin('familias as fa', 'fa.id_fa', '=', 'p.id_fa')
                    ->where('p.id_pro', '=', $f->id_pro)
                    ->select('p.*', 'fa.fa_nombre', 'fa.fa_codigo as fa_codigo_fam')
                    ->first();
                $meT    = $medida->id_medida == 58 ? 'NIU' : 'ZZ';
                $familia = implode(' - ', array_filter([$medida->fa_codigo_fam ?? null, $medida->fa_nombre ?? null])) ?: '-';
                $pdf->Row(array(
                    $aa,
                    $medida->pro_codigo,
                    utf8_decode($f->venta_detalle_nombre_producto)."\n".utf8_decode($f->venta_detalle_descripcion),
                    utf8_decode($familia),
                    $f->venta_detalle_cantidad,
                    $meT,
                    number_format(round("$f->venta_detalle_precio_unitario", 2), 2, '.', ' '),
                    number_format(round("$f->venta_detalle_importe_total",    2), 2, '.', ' '),
                ));
                $cant = strlen($f->venta_detalle_nombre_producto);
                $filas = ceil($cant / 65);
                if($filas==0){$filas=1;}
                $filas_tot+=$filas;
                $he = 4 * $filas;
                $aa++;
            }
            $pdf->Ln(7);
            $pdf->Cell(70,3,'','T',0,'R');
            $pdf->Cell(70,0,'',0,0,'L');
            $pdf->Cell(40,3,'','T',1,'R');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(70, 3, "$importe_letra", 0,0,'L');
            if ($dato_venta->venta_tipo != "20") {
                $pdf->Image("$ruta_qr", '8', $pdf->GetY() + 4, '20', '20', '', '');
            }
            // SUMATORIO DE LOS PRODUCTOS Y EL IVA
//        $pdf->Cell(110, 1, "Descuento: $dato_venta->simbolo $dato_venta->venta_totaldescuento", 0,2,'R');
            $pdf->Ln(7);
            if($dato_venta->venta_tipo != "20"){
                $pdf->Cell(70,1,'',0,0,'R');
            }else{
                $pdf->Cell(70,1,'',0,0,'R');
            }
            $pdf->Cell(110, 1, "Op.Grat: $dato_venta->simbolo $dato_venta->venta_totalgratuita", 0,1,'R');
            $pdf->Ln(3);
            if($dato_venta->venta_tipo != "20"){
                $pdf->Cell(70,1,'',0,0,'R');
            }else{
                $pdf->Cell(70,1,'',0,0,'R');
            }
            $pdf->Cell(110, 1, "Op.Exon: $dato_venta->simbolo $dato_venta->venta_totalexonerada", 0,1,'R');
            $pdf->Ln(3);
            if($dato_venta->venta_tipo != "20"){
                $pdf->Cell(70,1,'',0,0,'R');
            }else{
                $pdf->Cell(70,1,'',0,0,'R');
            }
            $pdf->Cell(110, 1, "Op.Inaf: $dato_venta->simbolo $dato_venta->venta_totalinafecta", 0,1,'R');
            $pdf->Ln(3);
            $pdf->Cell(180, 1, "Op.Grav: $dato_venta->simbolo $dato_venta->venta_totalgravada", 0,1,'R');
            $pdf->Ln(3);
            $pdf->Cell(180, 1, "IGV: $dato_venta->simbolo $dato_venta->venta_totaligv", 0,1,'R');
            $pdf->Ln(3);
            $pdf->Cell(180, 1, "Pago con: $dato_venta->simbolo $dato_venta->venta_pago_cliente", 0,1,'R');
            $pdf->Ln(3);
            $pdf->Cell(180, 1, "Vuelto : $dato_venta->simbolo $dato_venta->venta_vuelto", 0,1,'R');
            $pdf->Ln(3);

            $pdf->Ln(5);
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->Cell(70,3,utf8_decode('BIENES TRANSFERIDOS EN LA AMAZONÍA REGIÓN SELVA '),0,0,'C');
            $pdf->SetFont('Helvetica', 'B', 9);
            $pdf->Cell(110, 1, "TOTAL: $dato_venta->simbolo ".number_format($dato_venta->venta_total, 2, '.', ','), 0,'1','R');
            $pdf->Ln(2);
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->Cell(70,3,utf8_decode('PARA SER CONSUMIDOS EN LA MISMA'),0,0,'C');
            $pdf->Ln(3);
            $pdf->Cell(60,0,'',0,1,'L');
            $pdf->Ln(3);
            $pdf->Cell(70,3,'','T',0,'R');
            $pdf->Cell(70,0,'',0,0,'L');
            $pdf->Cell(40,3,'','T',1,'R');
            if($filas_tot<4) {
                $hei = 96 + (5 * $filas_tot);
            }else{
                $hei = 94 + (5 * $filas_tot);
            }
            if(isset($guardar_localmente) && isset($ruta_guardado)){
                $ruta_guardado = 'comprobantes/'."$serie_correlativo-" .date('Y-m-d').'.pdf';
                $pdf->Output("I",$ruta_guardado);
            } else {
                $pdf->Output('',"$serie_correlativo-" .date('Y-m-d'));
            }
            exit;

        }
    }
    public function imprimir_ticket_pdf_local($id_ve){
        $id = $id_ve;
        $id_venta = (int)$id;
        if($id_venta){
            $guardar_localmente = true;
            $ruta_guardado = "";
            $dato_venta = $this->venta->listar_venta_x_id_pdf($id_venta);
            $detalle_venta = $this->venta->listar_venta_detalle_x_id_venta_pdf($id_venta);
            $formas_de_pao = Ventas_detalle_pago::listar_formas_x_idventa($id_venta);
            $formas_de_pago_mensaje = "";
            $contador_pago = 0;
            foreach ($formas_de_pao as $for){
                $contador_pago++;
                if($contador_pago > 1){
                    $c='-';
                }else{
                    $c=' ';
                }
                $formas_de_pago_mensaje.= $for->tipo_pago_nombre.$c;
            }
            $fecha_hoy = date('d-m-Y H:i:s');
            $empresa = $this->empresa->listar_datos_empresa();
            $ruta_qr = $this->general->generar_qr($dato_venta->id_venta);
            $dnni = "";
            if ($dato_venta->venta_tipo == "03") {
                $tipo_comprobante = "BOLETA DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $dnni = 'DNI';
                $documento = $dato_venta->cliente_numero;
            } else if ($dato_venta->venta_tipo == "01") {
                $tipo_comprobante = "FACTURA DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $dnni = 'RUC';
                $documento = $dato_venta->cliente_numero;
            } else if ($dato_venta->venta_tipo == "07") {
                $tipo_comprobante = "NOTA DE CRÉDITO DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";
            } else if($dato_venta->venta_tipo == "08") {
                $tipo_comprobante = "NOTA DE DÉBITO DE VENTA ELECTRONICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";
            }else if($dato_venta->venta_tipo == "20") {
                $tipo_comprobante = "NOTA DE VENTA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";
            }
            $da = new NumeroALetras();
            $importe_letra = $da->toInvoice($dato_venta->venta_total,'2','soles');
            $arrayImporte = explode(".", $dato_venta->venta_total);
//        $montoLetras = $importe_letra . ' con ' . $arrayImporte[1] . '/100 ' . $dato_venta->moneda;
            $dato_impresion = 'DATOS DE IMPRESION:';
            $filas_detalle = count($detalle_venta);

            //Define el marcador de posición usado para insertar el número total de páginas en el documento
            //require 'app/view/pdf/fpdf/fpdf.php';
            $pdf = new CustomFpdf('P');
            $pdf->AddPage();
            //CABECERA DEL ARCHIVO
            if (file_exists($empresa->empresa_foto_ticket)) {
                $pdf->Image("$empresa->empresa_foto_ticket", 50, 10, 28,25);
            }
            $pdf->Ln(5);
            $pdf->SetFillColor(220,220,220);
            $pdf->SetFont('Helvetica','',9);
            $pdf->Cell(105,0,'','',0);
            $pdf->Cell(75,0,'','T',1,'R');
            $pdf->Cell(158,8, "RUC $dato_venta->empresa_ruc",0,1,'R',0);
            $pdf->Cell(105,8,"",0,0,'R',0);
            $pdf->Cell(75,8,"$tipo_comprobante",0,1,'C',1);
            $pdf->Cell(150,8,"$serie_correlativo",0,1,'R',0);
            $pdf->Cell(105,0,'','',0);
            $pdf->Cell(75,0,'','T',1,'R');
            $pdf->SetFont('Helvetica','B',9);
            $pdf->MultiAlignCell(105,4,"$dato_venta->empresa_razon_social",0,1,'C');
            $pdf->SetFont('Helvetica','',7);
            $pdf->Cell(105,4,"$dato_venta->empresa_domiciliofiscal",0,1,'C');
            $pdf->Ln(3);
            $pdf->Cell(180,0,'','T',1,'R');
            $pdf->Ln(3);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(16,4, "Fecha:",0,0,'L',false);
            $pdf->SetFont('Helvetica','',8);
            $pdf->Cell(60,4, "$fecha_hoy",0,0,'L',false);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(14,4, "Pago:",0,0,'L',false);
            $pdf->SetFont('Helvetica','',8);
            $pdf->Cell(60,4, "$formas_de_pago_mensaje",0,1,'L',false);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(16,4,"$dnni:",0,0,'L');
            $pdf->SetFont('Helvetica','',8);
            $pdf->Cell(60,4, "$documento",0,0,'L',false);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(14,4,"Cliente:",0,0,'L');
            if($dato_venta->id_tipo_documento != 4){
                $pdf->SetFont('Helvetica','',7);
                $pdf->MultiAlignCell(90,4, utf8_decode($dato_venta->cliente_nombre),0,1,'L',false);
            }else{
                $pdf->SetFont('Helvetica','',7);
                $pdf->MultiAlignCell(90,4, utf8_decode($dato_venta->cliente_razonsocial),0,1,'L',false);
            }
            $pdf->SetFillColor(180,180,180);
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(16,4,utf8_decode('Dirección:'),0,0,'L');
            $pdf->SetFont('Helvetica','',8);
            $pdf->MultiCell(180,4,utf8_decode($dato_venta->cliente_direccion),0,1,'');
            $pdf->SetFont('Helvetica','B',8);
            $pdf->Cell(26,4,"Forma de pago:",0,0,'L');
            $pdf->SetFont('Helvetica','',7);
            $pdf->Cell(14,4,utf8_decode($dato_venta->id_formas_pago == 1 ? 'CONTADO' : 'CRÉDITO'),0,1,'L');
            //AQUI SE BUSCARA LAS CUOTAS
            if($dato_venta->id_formas_pago == 2){
                $dato_cuotas = $this->venta->listar_cuotas($id);
                $c=1;
                foreach ($dato_cuotas as $da){
                    $pdf->SetFont('Helvetica','',6);
                    $pdf->MultiAlignCell(34,4,"- Cuota 00".$c.': '.date('d-m-Y',strtotime($da->venta_cuota_fecha)).' ('.$da->venta_cuota_importe.')',0,0,'L');
                    $c++;
                }
            }
            $pdf->Ln(3);
            $pdf->MultiCell(140,4,"",0,1,false);
            //COLUMNAS
            $pdf->Cell(180,0,'','T',1,'R');
            $pdf->Ln(3);
            $pdf->SetFont('Helvetica','B',7);
            $pdf->Cell(8,  10, 'ITEM',                  1, '', 'C', 1);
            $pdf->Cell(22, 10, utf8_decode('CÓDIGO'),   1, 0,  'C', 1);
            $pdf->Cell(58, 10, utf8_decode('PRODUCTO'),  1, '', 'C', 1);
            $pdf->Cell(28, 10, 'FAMILIA',               1, 0,  'C', 1);
            $pdf->Cell(10, 10, 'CANT',                  1, 0,  'C', 1);
            $pdf->Cell(10, 10, 'U.M.',                  1, 0,  'C', 1);
            $pdf->Cell(22, 10, 'P.UNIT',                1, 0,  'C', 1);
            $pdf->Cell(27, 10, 'P.VENTA',               1, 1,  'C', 1);

            //PRODUCTOS
            $pdf->SetWidths(array(8,22,58,28,10,10,22,27));
            $aa=1;
            $filas_tot = 0;
            foreach ($detalle_venta as $f){
                $pdf->SetFont('Helvetica', '', 7);
                $medida = DB::table('productos as p')
                    ->leftJoin('familias as fa', 'fa.id_fa', '=', 'p.id_fa')
                    ->where('p.id_pro', '=', $f->id_pro)
                    ->select('p.*', 'fa.fa_nombre', 'fa.fa_codigo as fa_codigo_fam')
                    ->first();
                $meT    = $medida->id_medida == 58 ? 'NIU' : 'ZZ';
                $familia = implode(' - ', array_filter([$medida->fa_codigo_fam ?? null, $medida->fa_nombre ?? null])) ?: '-';
                $pdf->Row(array(
                    $aa,
                    $medida->pro_codigo,
                    utf8_decode($f->venta_detalle_nombre_producto)."\n".utf8_decode($f->venta_detalle_descripcion),
                    utf8_decode($familia),
                    $f->venta_detalle_cantidad,
                    $meT,
                    number_format(round("$f->venta_detalle_precio_unitario", 2), 2, '.', ' '),
                    number_format(round("$f->venta_detalle_importe_total",    2), 2, '.', ' '),
                ));
                $cant = strlen($f->venta_detalle_nombre_producto);
                $filas = ceil($cant / 65);
                if($filas==0){$filas=1;}
                $filas_tot+=$filas;
                $he = 4 * $filas;
                $aa++;
            }
            $pdf->Ln(7);
            $pdf->Cell(70,3,'','T',0,'R');
            $pdf->Cell(70,0,'',0,0,'L');
            $pdf->Cell(40,3,'','T',1,'R');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(70, 3, "$importe_letra", 0,0,'L');
            if ($dato_venta->venta_tipo != "20") {
                $pdf->Image("$ruta_qr", '8', $pdf->GetY() + 4, '20', '20', '', '');
            }
            // SUMATORIO DE LOS PRODUCTOS Y EL IVA
//        $pdf->Cell(110, 1, "Descuento: $dato_venta->simbolo $dato_venta->venta_totaldescuento", 0,2,'R');
            $pdf->Ln(7);
            if($dato_venta->venta_tipo != "20"){
                $pdf->Cell(70,1,'',0,0,'R');
            }else{
                $pdf->Cell(70,1,'',0,0,'R');
            }
            $pdf->Cell(110, 1, "Op.Grat: $dato_venta->simbolo $dato_venta->venta_totalgratuita", 0,1,'R');
            $pdf->Ln(3);
            if($dato_venta->venta_tipo != "20"){
                $pdf->Cell(70,1,'',0,0,'R');
            }else{
                $pdf->Cell(70,1,'',0,0,'R');
            }
            $pdf->Cell(110, 1, "Op.Exon: $dato_venta->simbolo $dato_venta->venta_totalexonerada", 0,1,'R');
            $pdf->Ln(3);
            if($dato_venta->venta_tipo != "20"){
                $pdf->Cell(70,1,'',0,0,'R');
            }else{
                $pdf->Cell(70,1,'',0,0,'R');
            }
            $pdf->Cell(110, 1, "Op.Inaf: $dato_venta->simbolo $dato_venta->venta_totalinafecta", 0,1,'R');
            $pdf->Ln(3);
            $pdf->Cell(180, 1, "Op.Grav: $dato_venta->simbolo $dato_venta->venta_totalgravada", 0,1,'R');
            $pdf->Ln(3);
            $pdf->Cell(180, 1, "IGV: $dato_venta->simbolo $dato_venta->venta_totaligv", 0,1,'R');
            $pdf->Ln(3);
            $pdf->Cell(180, 1, "Pago con: $dato_venta->simbolo $dato_venta->venta_pago_cliente", 0,1,'R');
            $pdf->Ln(3);
            $pdf->Cell(180, 1, "Vuelto : $dato_venta->simbolo $dato_venta->venta_vuelto", 0,1,'R');
            $pdf->Ln(3);

            $pdf->Ln(5);
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->Cell(70,0,utf8_decode(''),0,0,'L');
            $pdf->SetFont('Helvetica', 'B', 9);
            $pdf->Cell(110, 1, "TOTAL: $dato_venta->simbolo $dato_venta->venta_total", 0,'1','R');
            $pdf->SetFont('Helvetica', '', 7);
            $pdf->Ln(3);
            $pdf->Cell(60,0,'',0,1,'L');
            $pdf->Ln(3);
            $pdf->Cell(70,3,'','T',0,'R');
            $pdf->Cell(70,0,'',0,0,'L');
            $pdf->Cell(40,3,'','T',1,'R');
            if($filas_tot<4) {
                $hei = 96 + (5 * $filas_tot);
            }else{
                $hei = 94 + (5 * $filas_tot);
            }
            $pdfFilePath = 'comprobantes_ventas/'.$serie_correlativo.'-'.date('Y-m-d').'.pdf';
            // Generar y guardar el PDF en la ubicación deseada
            $pdf->Output($pdfFilePath, 'F');
            return $pdfFilePath;

        }
    }
    public function imprimir_ticketera_venta(){
        $id = $_GET['venta_id'];
        $id_venta = (int)$id;
        if($id_venta){
            $guardar_localmente = true;
            $ruta_guardado = "";
            $dato_venta = $this->venta->listar_venta_x_id_pdf($id_venta);
            $detalle_venta = $this->venta->listar_venta_detalle_x_id_venta_pdf($id_venta);
            $pagos = Ventas_detalle_pago::listar_formas_x_idventa($id_venta);
            $formas_de_pago_mensaje = "";
            $contador_pago =0;
            foreach ($pagos as $for){
                $contador_pago++;
                if($contador_pago > 1){
                    $c='-';
                }else{
                    $c=' ';
                }
                $formas_de_pago_mensaje.= $for->tipo_pago_nombre.$c;
            }
            $fecha_hoy = date('Y-m-d', strtotime($dato_venta->venta_fecha));
//                $empresa = $this->empresas->listar_datos_empresa($dato_venta->id_empresa);
            $ruta_qr = $this->general->generar_qr($dato_venta->id_venta);

            if ($dato_venta->venta_tipo == "03") {
                $tipo_comprobante = "BOLETA DE VENTA ELECTRÓNICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DNI:                        $dato_venta->cliente_numero";
            } else if ($dato_venta->venta_tipo == "01") {
                $tipo_comprobante = "FACTURA DE VENTA ELECTRÓNICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "RUC:                      $dato_venta->cliente_numero";
            } else if ($dato_venta->venta_tipo == "07") {
                $tipo_comprobante = "NOTA DE CRÉDITO DE VENTA ELECTRÓNICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";
            } else if($dato_venta->venta_tipo == "08") {
                $tipo_comprobante = "NOTA DE DÉBITO DE VENTA ELECTRÓNICA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";
            }else if($dato_venta->venta_tipo == "20") {
                $tipo_comprobante = "NOTA DE VENTA";
                $serie_correlativo = $dato_venta->venta_serie."-".$dato_venta->venta_correlativo;
                $documento = "DOCUMENTO: $dato_venta->cliente_numero";
            }
            $da = new NumeroALetras();
            $importe_letra = $da->toInvoice($dato_venta->venta_total,'2','soles');
            $arrayImporte = explode(".", $dato_venta->venta_total);
//        $montoLetras = $importe_letra . ' con ' . $arrayImporte[1] . '/100 ' . $dato_venta->moneda;
            $dato_impresion = 'DETALLE DE VENTA:';
            $filas_detalle = count($detalle_venta);
            // Altura base (puedes ajustarla según tus necesidades)
            $altura_base = 215; // mm (incluye leyenda amazonia)
            // Altura adicional por registro (puedes ajustarla según tus necesidades)
            $altura_por_registro = 15; // mm
            // Calcula la altura total
            $altura_total = $altura_base + ($altura_por_registro * ($filas_detalle - 1));
            // Crea el PDF con la altura total dinámica
            $pdf = new CustomFpdf('P', 'mm', array(80, $altura_total));
//            if($filas_detalle==1 || $filas_detalle==2){
//                $pdf = new FPDF('P','mm',array(80,220));
//            }elseif($filas_detalle==3 || $filas_detalle==4){
//                $pdf = new FPDF('P','mm',array(80,240));
//            }elseif($filas_detalle==5 || $filas_detalle==6){
//                $pdf = new FPDF('P','mm',array(80,260));
//            }else{
//                $pdf = new FPDF('P','mm',array(80,300));
//            }
            $pdf->AddPage();
            //CABECERA DEL ARCHIVO
            if (file_exists($dato_venta->empresa_foto_ticket)) {
                $pdf->Image("$dato_venta->empresa_foto_ticket", 5, 5, 65,18);
            }
            $pdf->Ln(15);
            $pdf->SetFont('Helvetica','',7);
            $pdf->Cell(60,4, "$dato_venta->empresa_razon_social",0,1,'C',0);
            $pdf->Cell(60,4,"RUC $dato_venta->empresa_ruc",0,1,'C');
            $pdf->SetFont('Helvetica','',7);
            $pdf->Cell(60,4,"$dato_venta->empresa_domiciliofiscal",0,1,'C');
            $pdf->Cell(60,4,"$dato_venta->ubigeo_departamento - $dato_venta->ubigeo_provincia - $dato_venta->ubigeo_distrito",0,1,'C');
            $pdf->SetFont('Helvetica','',10);
            $pdf->Ln(4);
            $pdf->Cell(60,4, utf8_decode($tipo_comprobante),0,1,'C',0);
            $pdf->Cell(60,4, "$serie_correlativo",0,1,'C',false);
            $pdf->SetFont('Helvetica','',8);
            $pdf->Ln(1);
            $pdf->Cell(60,4, "$fecha_hoy",0,1,'C',false);

            $pdf->SetFont('Helvetica','',7);
            $pdf->Ln(3);

            $pdf->Cell(60,4,"DATOS DEL CLIENTE",1,1,'C');

            $pdf->SetMargins(10,'');
            if($dato_venta->id_tipo_documento == 4){
                $pdf->MultiCell(60,4,utf8_decode("RAZÓN SOCIAL:    ".$dato_venta->cliente_razonsocial),0,1,'');
            }else{
                $pdf->MultiCell(60,4,utf8_decode("RAZÓN SOCIAL:    ".$dato_venta->cliente_nombre),0,1,'');
            }


            $pdf->Cell(60,4,"$documento",0,1,'');
            $pdf->MultiCell(60,4,utf8_decode("DIRECCIÓN:          ").utf8_decode($dato_venta->cliente_direccion),0,1,'');
            $pdf->Cell(60,4,"FECHA:                  ".date('Y-m-d', strtotime($dato_venta->venta_fecha)),0,1,'');
            $pdf->Cell(60,4,"TIPO DE PAGO:    ".$formas_de_pago_mensaje,0,1,'');
            $pdf->SetMargins(10,'');
            $pdf->Cell(60,4,"$dato_impresion",1,1,'C');
// COLUMNAS
            $pdf->SetFont('Helvetica','B',7);
            $pdf->Cell(30, 10, utf8_decode('Descripción'), 0);
            $pdf->Cell(5, 10, 'Cant',0,0,'R');
            $pdf->Cell(10, 10, 'Precio',0,0,'R');
            $pdf->Cell(15, 10, 'Total',0,0,'R');
            $pdf->Ln(8);
            $pdf->Cell(60,0,'','T');
            $pdf->Ln(1);

//PRODUCTOS
//        if($dato_venta->cambiar_concepto==2){
//            $pdf->SetFont('Helvetica', '', 6);
//            $pdf->MultiCell(30,4,"$dato_venta->concepto_nuevo",0,'L');
//            $pdf->Cell(35, -5, "1",0,0,'R');
//            $pdf->Cell(10, -5, number_format(round("$dato_venta->venta_total",2), 2, ',', ' '),0,0,'R');
//            $pdf->Cell(15, -5, number_format(round("$dato_venta->venta_total",2), 2, ',', ' '),0,0,'R');
//            $pdf->Ln(2);
//        }else{
//            foreach ($detalle_venta as $f){
//                $pdf->SetFont('Helvetica', '', 7);
//                $pdf->MultiCell(30,4,"$f->venta_detalle_nombre_producto",0,'L');
//                $pdf->Cell(35, -5, "$f->venta_detalle_cantidad",0,0,'R');
//                $pdf->Cell(10, -5, number_format(round("$f->venta_detalle_precio_unitario",2), 2, ',', ' '),0,0,'R');
//                $pdf->Cell(15, -5, number_format(round("$f->venta_detalle_valor_total",2), 2, ',', ' '),0,0,'R');
//                $pdf->Ln(2);
//            }
//
//        }
            foreach ($detalle_venta as $f){
                $pdf->SetFont('Helvetica', '', 7);
                $pdf->MultiCell(30,4,utf8_decode($f->venta_detalle_nombre_producto),0,'L');
                $pdf->Cell(35, -5, "$f->venta_detalle_cantidad",0,0,'R');
                $pdf->Cell(10, -5, number_format(round("$f->venta_detalle_precio_unitario",2), 2, '.', ' '),0,0,'R');
                $pdf->Cell(15, -5, number_format(round("$f->venta_detalle_importe_total",2), 2, '.', ' '),0,0,'R');
                $pdf->Ln(2);
            }

// SUMATORIO DE LOS PRODUCTOS Y EL IVA
            $pdf->Ln(3);
            $pdf->Cell(60,3,'','T');
            $pdf->Ln();
            $pdf->Cell(60, 1.5, "Op.Grat: $dato_venta->simbolo $dato_venta->venta_totalgratuita", 0,'1','R');
            $pdf->Ln();
            $pdf->Cell(60, 1.5, "Op.Exon: $dato_venta->simbolo $dato_venta->venta_totalexonerada", 0,'1','R');
            $pdf->Ln();
            $pdf->Cell(60, 1.5, "Op.Inaf: $dato_venta->simbolo $dato_venta->venta_totalinafecta", 0,'1','R');
            $pdf->Ln();
            $pdf->Cell(60, 1.5, "Op.Grav: $dato_venta->simbolo $dato_venta->venta_totalgravada", 0,'1','R');
            $pdf->Ln();
            $pdf->Cell(60, 1.5, "IGV: $dato_venta->simbolo $dato_venta->venta_totaligv", 0,'1','R');
            $pdf->Ln();
            $pdf->Cell(60, 1.5, "Pago con: $dato_venta->simbolo $dato_venta->venta_pago_cliente", 0,'1','R');
            $pdf->Ln();
            $pdf->Cell(60, 1.5, "Vuelto: $dato_venta->simbolo $dato_venta->venta_vuelto", 0,'1','R');
            $pdf->Ln();

            $pdf->SetFont('Helvetica', 'B', 7);
            $pdf->Ln();
            $pdf->Cell(60, 1.5, "TOTAL: $dato_venta->simbolo ".number_format($dato_venta->venta_total, 2, '.', ','), 0,'1','R');
            $pdf->Ln();
            $pdf->Cell(60, 1.5, "$importe_letra", 0,'1','R');
// PIE DE PAGINA
            $pdf->Ln(2);
            $pdf->Image("$ruta_qr", '8', $pdf->GetY() , '20', '20', '', '');

            // Leyenda amazonia debajo del QR
            $pdf->Ln(22);
            $pdf->SetFont('Helvetica', '', 6);
            $pdf->Cell(60, 3, utf8_decode('BIENES TRANSFERIDOS EN LA AMAZONIA'), 0, 1, 'C');
            $pdf->Cell(60, 3, utf8_decode('REGION SELVA PARA SER CONSUMIDOS EN LA MISMA'), 0, 1, 'C');
            $pdf->Ln(3);
//$pdf->Cell(60,0,'comprobante en www.sunat.gob.pe',0,1,'R');
//                $pdf->Ln(10);
//                $pdf->Cell(60,0,'---------------------------------------------------',0,1,'C');
//                $pdf->Ln(3);
//                $pdf->Cell(60,0,utf8_decode('ASSU Dent - Innovación en cada consulta'),0,1,'C');
            $pdf->Ln(3);
            $pdf->Cell(60,0,'',0,1,'C');
//        $imagePath = public_path();
            if(isset($guardar_localmente) && isset($ruta_guardado)){
                $ruta_guardado = 'comprobantes/'."$serie_correlativo-" .date('Y-m-d').'.pdf';
                $pdf->Output("I",$ruta_guardado);
            } else {
                $pdf->Output('',"$serie_correlativo-" .date('Y-m-d'));
            }
            exit;

        }


    }
    public function enviarComprobanteporCorreo( Request $request){
        // Código de error general
        $result = 2;
        // Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {

            $validator = Validator::make($request->all(), [
                'correoDestino' => 'required|email',
                'id_venta'=>'required'// Ajusta el nombre del parámetro según tus necesidades
                // Agrega más reglas según tus necesidades
            ]);

            // Comprobar si la validación falla
            if ($validator->fails()) {
                // Código 6: Integridad de datos errónea
                $result = 6;
                $message = "Integridad de datos fallida. Alguno(s) de los parámetros se están enviando de manera incorrecta";
            } else {
                $e = $this->venta->listar_venta_x_id_pdf($request->id_venta);
                $empresa = DB::table('empresa')->where('id_empresa','=',1)->first();
                $comprobante = $this->imprimir_ticket_pdf_local($request->id_venta);
                $correo_corpo = $empresa->empresa_correo;
                $envio = Mail::to(strtolower($request->correoDestino))->send(new ComprobanteCorreo($comprobante,$correo_corpo,$empresa));
                if($envio){
                    $result = 1;
                    $message = "Envio del comprobante fue existo";
                }else{
                    $result = 2;
                    $message = "Ocurrio un erro al envio del comprobante";
                }
            }

        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
//            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
        return response()->json(["result" => ["code" => $result, "message" => $message]]);

    }

}
