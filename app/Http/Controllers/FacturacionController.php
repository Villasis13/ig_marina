<?php

namespace App\Http\Controllers;

use App\Mail\ComprobanteCorreo;
use App\Models\apiFacturacion;
use App\Models\Cita;
use App\Models\Opciones;
use App\Models\Paciente_sucursal;
use App\Models\Pagos_cita;
use App\Models\Serie;
use App\Models\Sucursal;
use App\Models\Tratamientos_sucursal;
use App\Models\User;
use App\Models\User_sucursal;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Clientes;
use App\Models\Empresa;
use App\Models\Envio_resumen;
use App\Models\Envio_resumen_detalle;
use App\Models\GeneradorXML;
use App\Models\General;
use App\Models\Ins_distribucion;
use App\Models\Logs;
use App\Models\Menu;
use App\Models\Moneda;
use App\Models\Movimientos_productos;
use App\Models\Producto;
use App\Models\Submenu;
use App\Models\Tipo_documento;
use App\Models\Tipo_ncredito;
use App\Models\Tipo_ndebito;
use App\Models\Tipo_pago;
use App\Models\Venta;
use App\Models\Venta_detalle;
use App\Models\Ventas;
use App\Models\Ventas_anulado;
use App\Models\Ventas_detalle_pago;
use App\Models\Ventas_detalles_pago;
use Codedge\Fpdf\Fpdf\Fpdf;
//use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Luecano\NumeroALetras\NumeroALetras;
use Mike42\Escpos\EscposImage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class FacturacionController extends Controller
{
    private $logs;
    private $general;
    private $usuarios;
    private $empresas;
    private $opciones;
    private $user_sucursal;
    private $submenu;
    private $caja;
    private $serie;
    private $tipos_de_pago;
    private $tipo_documento;
    private $ventas;
    private $cliente;
    private $pagos_cita;

    public function __construct()
    {
        $this->logs = new Logs();
        $this->usuarios = new User();
        $this->opciones = new Opciones();
        $this->general = new General();
        $this->empresas = new Empresa();
        $this->submenu = new Submenu();
        $this->caja = new Caja();
        $this->serie = new Serie();
        $this->tipos_de_pago = new Tipo_pago();
        $this->tipo_documento = new Tipo_documento();
        $this->ventas = new Ventas();
        $this->cliente = new \App\Models\Cliente();
    }
    public function pendiente_declarar(Request $request)
    {
        try {
            $datos_usuario = $this->usuarios->listar_datos_usuario(Auth::id());
            $empresas = "";
            $infoEmpre = "";
            $id_empresa = "";

            $opciones = $this->submenu->optiones_por_vista("pendiente_declarar");
            $filtro = false;
            $fecha_inicio = date('Y-m-d');
            $fecha_final = date('Y-m-d');
            $tipo_venta = "";
            $ventas = "";
            if (isset($request->enviar_registro)) {
                $query = DB::table('ventas as v')
                    ->join('empresa as e', 'e.id_empresa', '=', 'v.id_empresa')
                    ->join('clientes as c', 'v.id_clientes', '=', 'c.id_clientes')
                    ->join('monedas as mo', 'v.id_moneda', '=', 'mo.id_moneda')
                    ->join('users as u', 'v.id_users', '=', 'u.id_users')
                    ->where([['v.venta_estado_sunat', '=', 0],['e.id_empresa','=',1]]);

                if ($_POST['tipo_venta'] != "") {
                    $query->where('v.venta_tipo', $_POST['tipo_venta']);
                }

                if ($_POST['fecha_inicio'] != "" && $_POST['fecha_final'] != "") {
                    $query->whereBetween(DB::raw('DATE(v.venta_fecha)'), [$_POST['fecha_inicio'], $_POST['fecha_final']]);
                }
                $ventas = $query->orderBy('v.venta_fecha', 'asc')->get();

                foreach ($ventas as $v){
                    $v->tipo_pago = Ventas_detalle_pago::listar_formas_x_idventa($v->id_venta);
                }
                $fecha_inicio = $_POST['fecha_inicio'];
                $fecha_final = $_POST['fecha_final'];
                $tipo_venta = $_POST['tipo_venta'];

                $filtro = true;
            }

            $filtro2 = false;
            $fecha_hoy = date('Y-m-d');
            $ventas2 = "";
            if(isset($request->enviar_registro2)) {
                $query = DB::table('ventas')
                    ->join('empresa as e', 'e.id_empresa', '=', 'ventas.id_empresa')
                    ->join('clientes as c', 'ventas.id_clientes', '=', 'c.id_clientes')
                    ->join('monedas as mo', 'ventas.id_moneda', '=', 'mo.id_moneda')
                    ->join('users as u', 'ventas.id_users', '=', 'u.id_users')
                    ->where('ventas.venta_estado_sunat', 0)
                    ->where('ventas.venta_tipo', '<>', '01')
                    ->where('ventas.venta_tipo', '<>', '20')
                    ->where('ventas.tipo_documento_modificar', '<>', '01')
                    ->where('ventas.venta_tipo_envio', '<>', 1)
                    ->where('e.id_empresa', '=', 1);
                $where = false;
                if ($_POST['fecha_hoy'] != "") {
                    $where = true;
                    $query->whereDate('ventas.venta_fecha', '=', $_POST['fecha_hoy']);
                }

                if ($where) {
                    $datos = true;
                    $query->orderBy('ventas.venta_fecha', 'asc');
                    $ventas2 = $query->get();
                    foreach ($ventas2 as $v){
                        $v->tipo_pago = Ventas_detalle_pago::listar_formas_x_idventa($v->id_venta);
                    }
                }
                $fecha_hoy = $_POST['fecha_hoy'];
                $filtro2 = true ;
            }
            $ventas_cant = $this->ventas->listar_ventas_sin_enviar();


            return view('facturacion/pendientes_declarar',compact('opciones','infoEmpre','id_empresa','id_empresa','id_empresa','datos_usuario','empresas','filtro','fecha_inicio','filtro2','fecha_hoy','ventas2','fecha_final','tipo_venta','ventas','ventas_cant'));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
//            echo "<script language=\"javascript\">window.location.href= ruta_global + \"". "menu/principal" ."\";</script>";
        }
    }
    public function historial_envios(Request $request)
    {
        try {
            $empresas = "";
            $infoEmpre = "";
            $id_empresa = "";

            $opciones = $this->submenu->optiones_por_vista("historial_envios");
            $filtro1 = false;
            $fecha_ini = date('Y-m-d');
            $fecha_fin = date('Y-m-d');
            $ventas1 = "";
            $tipo_venta="";
            if(isset($request->enviar_registro1)) {
                //
                $ventas1 = DB::table('envio_resumen')
                    ->whereDate('envio_sunat_datetime','>=',$_POST['fecha_inicio'])
                    ->whereDate('envio_sunat_datetime','<=',$_POST['fecha_final'])
                    ->get();
                $fecha_ini = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_final'];
                $filtro1 = true ;
            }
            /// historial ventas sunat
            $filtro2 = false;
            $fecha_inicio1 = date('Y-m-d');
            $fecha_final1 = date('Y-m-d');
            $tipo_venta1 = "";
            $ventas2 = "";
            if(isset($request->enviar_registro2)) {
                $query = DB::table('ventas as v')
                    ->join('empresa as e', 'e.id_empresa', '=', 'v.id_empresa')
                    ->join('clientes as c', 'v.id_clientes', '=', 'c.id_clientes')
                    ->join('monedas as mo', 'v.id_moneda', '=', 'mo.id_moneda')
                    ->join('users as u', 'v.id_users', '=', 'u.id_users')
                    ->where('v.venta_estado_sunat', '=', 1);
                if($_POST['tipo_venta'] != '0'){
                    $query->where('v.venta_tipo', $_POST['tipo_venta']);
                }

                if($_POST['fecha_inicio'] != "" && $_POST['fecha_final'] != ""){
                    $query->whereBetween(DB::raw('DATE(v.venta_fecha)'), [$_POST['fecha_inicio'], $_POST['fecha_final']]);
                }
                $ventas2 = $query->orderBy('v.venta_fecha', 'asc')->get();
                foreach ($ventas2 as $v){
                    $v->resumen = DB::table('envio_resumen_detalle as er')
                        ->join('ventas as v','er.id_venta','=','v.id_venta')
                        ->where('er.id_venta','=',$v->id_venta)->first();
                }
                foreach ($ventas2 as $v){
                    $v->tipo_pago = Ventas_detalle_pago::listar_formas_x_idventa($v->id_venta);
                }
                $fecha_inicio1 = $_POST['fecha_inicio'];
                $fecha_final1 = $_POST['fecha_final'];
                $tipo_venta1 = $_POST['tipo_venta'];

                $filtro2 = true ;
            }
            // historial bajas de facturas
            $filtro3 = false;
            $fecha_inicio2 = date('Y-m-d');
            $fecha_final2 = date('Y-m-d');
            $ventas3 = "";
            if(isset($request->enviar_registro3)) {
                $fecha_inicio2 = $_POST['fecha_inicio_bajas'];
                $fecha_final2 = $_POST['fecha_final_bajas'];
                $ventas3 = DB::table('ventas as v')
                    ->join('empresa as e', 'e.id_empresa', '=', 'v.id_empresa')
                    ->join('ventas_anulados as va', 'v.id_venta', '=', 'va.id_venta')
                    ->whereDate('va.venta_anulado_datetime','>=',$fecha_inicio2)
                    ->whereDate('va.venta_anulado_datetime','<=',$fecha_final2)->get();
                foreach ($ventas3 as $v){
                    $v->tipo_pago = Ventas_detalle_pago::listar_formas_x_idventa($v->id_venta);
                }
                $filtro3 = true ;
            }
            return view('facturacion/historial_envios',compact('opciones','empresas','infoEmpre','id_empresa','tipo_venta1','filtro1','filtro2','filtro3','ventas1','ventas2','ventas3','fecha_ini','fecha_fin','fecha_inicio1','fecha_final1','fecha_inicio2','fecha_final2'));
        } catch (\Exception $e) {
            echo "<script language=\"javascript\">
                    alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                </script>";
        }
    }
    public function detalle_resumen(Request $request,$id)
    {
        try {
            $opciones = $this->submenu->optiones_por_vista("detalle_resumen");
            $resumen = DB::table('envio_resumen')->where('id_envio_resumen','=',$id)->first();
            $detalle = DB::table('envio_resumen_detalle as er')
                ->join('ventas as v','er.id_venta','=','v.id_venta')
                ->where('er.id_envio_resumen','=',$id)->get();
            foreach ($detalle as $deta){
                $deta->ven = DB::table('ventas as v')
                    ->join('clientes as c','v.id_clientes','=','c.id_clientes')
                    ->join('monedas as m','v.id_moneda','=','m.id_moneda')
                    ->join('users as u' ,'v.id_users','=','u.id_users')
                    ->where('v.id_venta','=',$deta->id_venta)->first();
            }

            return view('facturacion/resumen_detalle',compact('opciones','resumen','detalle'));
        } catch (\Exception $e) {
           $this->logs->insertarLog($e);

            echo "<script language=\"javascript\">
                    alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                </script>";
//            echo "<script language=\"javascript\">window.location.href= ruta_global + \"". "menu/principal" ."\";</script>";
        }
    }
    public function generar_nota(Request $request , $id)
    {
        try {
            $id_venta = (int)$id;
            if($id_venta){
                $opciones = $this->submenu->optiones_por_vista("generar_nota");
                $clientes = DB::table('clientes as c')
                    ->join('tipo_documento as td','td.id_tipo_documento','=','c.id_tipo_documento')->get();
                $tipo_pagos = $this->tipos_de_pago->listar_tipo_pago();
                $venta = $this->ventas->listar_venta_x_id($id);
                $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta($id);
                return view('facturacion/generar_nota',compact('opciones','clientes','venta','tipo_pagos','detalle_venta'));
            }

        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script language=\"javascript\">
                    alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                </script>";
        }
    }
    public function tipo_nota_descripcion(Request $request)
    {
        try {
            $tipo_comprobante = $_POST['tipo_comprobante'];
            if($tipo_comprobante != ""){
                if($tipo_comprobante == "07"){
                    $dato_nota = Tipo_ncredito::listar_descripcion_segun_nota_credito();
                    $nota = "Tipo Nota de Crédito";
                }else{
                    $dato_nota = Tipo_ndebito::listar_descripcion_segun_nota_debito();
                    $nota = "Tipo Nota de Débito";
                }
            }
            return json_encode(array('nota'=>$nota,'dato'=>$dato_nota));
        } catch (\Exception $e) {
            Logs::insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
    }
    public function consultar_serie(Request $request)
    {
        try {
            $concepto = $_POST['concepto'];
            $series = "";
            $correlativo = "";
            $empresa = DB::table('empresa as e')->where('e.id_empresa','=',1)->first();
            if($concepto == "LISTAR_SERIE"){
                $tipo_documento_modificar = $_POST['tipo_documento_modificar'];
                if($tipo_documento_modificar == "01" && $_POST['tipo_venta'] == "07"){
                    $serie_ = 'FC01';
                }elseif($tipo_documento_modificar == "03" && $_POST['tipo_venta'] == "07"){
                    $serie_ = 'BC01';
                }elseif($tipo_documento_modificar == "01" && $_POST['tipo_venta'] == "08"){
                    $serie_ = 'FD01';
                }elseif($tipo_documento_modificar == "03" && $_POST['tipo_venta'] == "08"){
                    $serie_ = 'BD01';
                }
                $series = DB::table('serie')->where([['serie.tipocomp','=',$request->tipo_venta],['serie.serie','=',$serie_],['estado','=',1]])->get();
            }else{
                $correlativo_ = DB::table('serie')->where('id_serie','=',$_POST['id_serie'])->first();
                $correlativo = $correlativo_->correlativo + 1;
            }
            $respuesta = array("serie" => $series, "correlativo" =>$correlativo);
            return json_encode($respuesta);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
    }
    public function crear_xml_enviar_sunat(Request $request)
    {
        try {
            $id = $request->id_venta;
            $venta = $this->ventas->listar_soloventa_x_id($id);
            $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta($id);
            $empresa = $this->empresas->listar_datos_empresa();
            $cliente = $this->cliente->listar_clienteventa_x_id($venta->id_clientes);
            $nombre = $empresa->empresa_ruc.'-'.$venta->venta_tipo.'-'.$venta->venta_serie.'-'.$venta->venta_correlativo;
            $ruta = "ApiFacturacion/xml/";
            if($venta->venta_tipo == '01' || $venta->venta_tipo == '03') {
                GeneradorXML::CrearXMLFactura($ruta.$nombre, $empresa, $cliente, $venta, $detalle_venta);
            }else{
                $detalle_venta = $this->ventas->listar_venta_detalle_x_nota($id);
                if($venta->venta_tipo == "07"){
                    $descripcion_nota = Tipo_ncredito::listar_tipo_notaC_x_codigo($venta->venta_codigo_motivo_nota);
                    GeneradorXML::CrearXMLNotaCredito($ruta.$nombre, $empresa, $cliente, $venta, $detalle_venta,$descripcion_nota);
                }else{
                    $descripcion_nota = Tipo_ndebito::listar_tipo_notaD_x_codigo($venta->venta_codigo_motivo_nota);
                    GeneradorXML::CrearXMLNotaDebito($ruta.$nombre, $empresa, $cliente, $venta, $detalle_venta,$descripcion_nota);

                }
            }



            $result = apiFacturacion::EnviarComprobanteElectronico($empresa,$nombre,"ApiFacturacion/","ApiFacturacion/xml/","ApiFacturacion/cdr/", $id);
            if($result == 1){
                $actualizar = DB::table('ventas')->where('id_venta','=',$id)
                    ->update([
                        'venta_tipo_envio'=>1,
                        'venta_estado_sunat'=>1,
                        'venta_fecha_envio'=>date('Y-m-d H:i:s')
                    ]);
                 $result = 1;
            }
            return json_encode($result);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
    }
    public function crear_enviar_resumen_sunat(Request $request)
    {
        try {
            $message = "";

            $fecha = $_POST['fecha'];
//            $id_empresa = $request->id_empresa;
            $emisor =$this->empresas->listar_datos_empresa();
            if($emisor->empresa_ruta_certificado != null and $emisor->empresa_clave_certificado != null ){
                $ventas =$this->ventas->listar_venta_x_fecha($fecha,"01");
                $serie = date('Ymd');
                $fila_serie = DB::table('serie as s')
                    ->where('s.tipocomp','=','RC')
                    ->first();
                $re = 1;
                if($fila_serie->serie != $serie ){
                    $correlativo = 1;
                }else{
                    $correlativo = $fila_serie->correlativo + 1;
                }
                if($re == 1){
                    $cabecera = array(
                        "tipocomp"		=>"RC",
                        "serie"			=>$serie,
                        "correlativo"	=>$correlativo,
                        "fecha_emision" =>date('Y-m-d'),
                        "fecha_envio"	=>date('Y-m-d')
                    );
                    $items = $ventas;
                    $ruta = public_path('ApiFacturacion/xml'); // local
//                $ruta = 'ApiFacturacion/xml';// servidor
                    $nombrexml = $emisor->empresa_ruc.'-'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];
                    $nom = $ruta."/".$nombrexml;
                    //CREAMOS EL XML DEL RESUMEN
                    GeneradorXML::CrearXMLResumenDocumentos($emisor, $cabecera, $items, $nom, $fecha);
                    $result = apiFacturacion::EnviarResumenComprobantes($emisor,$nombrexml,"empresas/certificado/","ApiFacturacion/xml/",1);
                    $ticket = $result['ticket'];
                    $message = $result['mensaje'];
                    if($result['result'] == 1){
                        $ruta_xml = 'ApiFacturacion/xml/'.$nombrexml.'.XML';
                        $envio = new Envio_resumen();
                        $envio->id_empresa = 1;
                        $envio->envio_resumen_fecha = $fecha;
                        $envio->envio_resumen_serie = $cabecera['serie'];
                        $envio->envio_resumen_correlativo = $cabecera['correlativo'];
                        $envio->envio_resumen_nombreXML = $ruta_xml;
                        $envio->envio_resumen_estado = 1;
                        $envio->envio_resumen_estadosunat = $result['mensaje'];
                        $envio->envio_resumen_ticket = $result['ticket'];
                        $envio->envio_sunat_datetime = date('Y-m-d H:i:s');
                        $resul = $envio->save();
                        if($resul == true){
                            if($fila_serie->serie != $serie){
                                $edit_serie = DB::table('serie')->where('tipocomp','=','RC')->update(['serie'=>$serie]);
                            }
                            //ACA ACTUALIZAMOS EL CORRELATIVO RESUMEN
                            $corr = DB::table('serie')->where('tipocomp','=','RC')->update(['correlativo'=>$correlativo]);
                            //ACA LISTAMOS EN RESUMEN POR MEDIO DE SU TICKET
                            $envio = DB::table('envio_resumen')->where('envio_resumen_ticket','=',$result['ticket'])->first();
                            foreach ($items as $i){
                                //aca se guardara los detalles del envio resumen
                                $guardar_resumen_detalle = new Envio_resumen_detalle();
                                $guardar_resumen_detalle->id_envio_resumen = $envio->id_envio_resumen;
                                $guardar_resumen_detalle->id_venta = $i->id_venta;
                                $guardar_resumen_detalle->envio_resumen_detalle_condicion = 1;
                                $guardardo = $guardar_resumen_detalle->save();

                                if($guardardo == 1 || $guardardo == true){
                                    if($i->anulado_sunat == "1" && $i->venta_condicion_resumen == "1"){
                                        $result = DB::table('ventas')->where('ventas.id_venta','=',$i->id_venta)
                                            ->update([
                                                'venta_tipo_envio'=>2,
                                                'venta_estado_sunat'=>0,
                                                'venta_fecha_envio'=>date('Y-m-d H:i:s')
                                            ]);
                                            DB::table('ventas')->where('id_venta',$i->id_venta)
                                            ->update(['venta_condicion_resumen'=>3]);
                                    }else{
//                                    guardar_estado_de_envio_venta
                                        $result = DB::table('ventas')->where('ventas.id_venta','=',$i->id_venta)
                                            ->update([
                                                'venta_tipo_envio'=>2,
                                                'venta_estado_sunat'=>1, // 0 ahora || 1 antes
                                                'venta_fecha_envio'=>date('Y-m-d H:i:s')
                                            ]);
                                    }
                                }
                            }
                            if($result  == true || $result == 1){
                                $result = apiFacturacion::ConsultarTicket($emisor, $cabecera, $ticket,"ApiFacturacion/cdr/", 1,1);
                            }
                        }
                    }elseif($result['result'] == 4){
                        $result = 4;
                    }elseif($result['result'] == 3){
                        $result = 3;
                    }
                }
            }else{
                $result = 7;
                $message = "La empresa actualmente no dispone de certificado ni clave para llevar a cabo la facturación electrónica.";
            }
//            $datos_resultado = array('verificar'=>$result,'message'=>$message);
//            return json_encode($datos_resultado);
            $datos =  array('resulta'=>$result,'mensaje'=>$message);
            return json_encode($datos);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
    }
    public function crear_enviar_resumen_sunatPri(Request $request)
    {
        try {
            $result = 6;
            $message = "";
            $baseUrl       = env('URL_FACTU');
            $fecha = $_POST['fecha'];
//            $id_empresa = $request->id_empresa;
            $emisor =$this->empresas->listar_datos_empresa();
            if($emisor->empresa_ruta_certificado != null and $emisor->empresa_clave_certificado != null ){
                $ventas =$this->ventas->listar_venta_x_fecha($fecha,"01");
                $serie = date('Ymd');
                $fila_serie = DB::table('serie as s')
                    ->where('s.tipocomp','=','RC')
                    ->first();
                $re = 1;
                if($fila_serie->serie != $serie ){
                    $correlativo = 1;
                }else{
                    $correlativo = $fila_serie->correlativo + 1;
                }
                if($re == 1){
                    $cabecera = array(
                        "tipocomp"		=>"RC",
                        "serie"			=>$serie,
                        "correlativo"	=>$correlativo,
                        "fecha_emision" =>date('Y-m-d'),
                        "fecha_envio"	=>date('Y-m-d')
                    );
                    $items = $ventas;
                    $ruta = public_path('ApiFacturacion/xml'); // local
//                $ruta = 'ApiFacturacion/xml';// servidor
                    $nombrexml = $emisor->empresa_ruc.'-'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];
                    $nom = $ruta."/".$nombrexml;
                    GeneradorXML::CrearXMLResumenDocumentos($emisor, $cabecera, $items, $nom, $fecha);


                    // 2) Crear Empresa
//            $panelTok = '230ff33f4c2210f3a3250b9c3b3eae9950f23f56a476ef7bd67fe3e4ae73c346';
//            $ruc      = '20528449833';
//            $razonSocial      = 'INVERSIONES GENERALES LA MARINA S.R.L.';
//            $tipoPlan = '01';
//            $empresa = apiFacturacion::crearEmpresa($baseUrl, $panelTok, $ruc,$razonSocial, $tipoPlan, /*insecure*/ true);
//            $username = $empresa['username'];
//            $password = $empresa['password'];

                    // 3) Obtener Token
                    $username = env('USERS_EMPRESA_NAM');
                    $password = env('USERS_EMPRESA_PAS');
                    $nombreArchivo = $nombrexml.'.XML';
                    $rutaXml       = $ruta.$nombreArchivo;
                    $tokenAcceso = apiFacturacion::obtenerToken($baseUrl, $username, $password, true);

                    // 4) Firmar XML
                    $firmarXml = apiFacturacion::FirmarXMLPRI($baseUrl, $tokenAcceso, $nom.'.XML', $nombrexml);

                    if ($firmarXml['mensaje'] == 'XML firmado correctamente') {
                        $enviarXml = apiFacturacion::EnviarASunatPri($baseUrl, $tokenAcceso, $firmarXml['xml'], $nombrexml, true);
                        if($enviarXml['mensaje'] == "Ticket obtenido con éxito"){
                            $ruta_xml = 'ApiFacturacion/xml/'.$nombrexml.'.XML';
                            $envio = new Envio_resumen();
                            $envio->id_empresa = 1;
                            $envio->envio_resumen_fecha = $fecha;
                            $envio->envio_resumen_serie = $cabecera['serie'];
                            $envio->envio_resumen_correlativo = $cabecera['correlativo'];
                            $envio->envio_resumen_nombreXML = $ruta_xml;
                            $envio->envio_resumen_estado = 1;
                            $envio->envio_resumen_estadosunat = $enviarXml['mensaje'];
                            $envio->envio_resumen_ticket = $enviarXml['raw']['ticket'];
                            $envio->envio_sunat_datetime = date('Y-m-d H:i:s');
                            $result = $envio->save();

                            if($fila_serie->serie != $serie){
                                DB::table('serie')->where('tipocomp','=','RC')->update(['serie'=>$serie]);
                            }
                            DB::table('serie')->where('tipocomp','=','RC')->update(['correlativo'=>$correlativo]);
                            $envio = DB::table('envio_resumen')->where('envio_resumen_ticket','=',$enviarXml['raw']['ticket'])->first();
                            foreach ($items as $i){
                                $guardar_resumen_detalle = new Envio_resumen_detalle();
                                $guardar_resumen_detalle->id_envio_resumen = $envio->id_envio_resumen;
                                $guardar_resumen_detalle->id_venta = $i->id_venta;
                                $guardar_resumen_detalle->envio_resumen_detalle_condicion = 1;
                                $guardardo = $guardar_resumen_detalle->save();

                                if($guardardo == 1 || $guardardo == true){
                                    if($i->anulado_sunat == "1" && $i->venta_condicion_resumen == "1"){
                                        $result = DB::table('ventas')->where('ventas.id_venta','=',$i->id_venta)
                                            ->update([
                                                'venta_tipo_envio'=>2,
                                                'venta_estado_sunat'=>0,
                                                'venta_fecha_envio'=>date('Y-m-d H:i:s')
                                            ]);
                                        DB::table('ventas')->where('id_venta',$i->id_venta)
                                            ->update(['venta_condicion_resumen'=>3]);
                                    }else{
                                        $result = DB::table('ventas')->where('ventas.id_venta','=',$i->id_venta)
                                            ->update([
                                                'venta_tipo_envio'=>2,
                                                'venta_estado_sunat'=>1,
                                                'venta_fecha_envio'=>date('Y-m-d H:i:s')
                                            ]);
                                    }
                                }
                            }
                            if($result  == true || $result == 1){
                                //$consultaTicket = apiFacturacion::ConsultarTicketPri($baseUrl, $tokenAcceso, $nombrexml);
                                $consultaTicket = apiFacturacion::ConsultarTicketPri($baseUrl, $tokenAcceso, $nombrexml, $enviarXml['raw']['ticket'], 1);
                            }
                        }
                    }
                }
            }else{
                $result = 7;
                $message = "La empresa actualmente no dispone de certificado ni clave para llevar a cabo la facturación electrónica.";
            }
//            $datos_resultado = array('verificar'=>$result,'message'=>$message);
//            return json_encode($datos_resultado);
//            $datos =  array('resulta'=>$result,'mensaje'=>$message);
            return $result;
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
    }
    public function consultar_ticket_resumen(Request $request){
        //Código de error general
        $result = 1;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            //$ok_data = $this->validar->validar_parametro('id_comanda_detalle', 'POST',true,$ok_data,11,'texto',0);

            //Validacion de datos
            if($ok_data) {
                $id_resumen = $request->id_resumen_diario;

                //$resumen_diario = $this->ventas->listar_resumen_diario_x_id($id_resumen);
                $resumen_diario = DB::table('envio_resumen')->where('id_envio_resumen','=',$id_resumen)->first();
                $serie = $resumen_diario->envio_resumen_serie;
                $correlativo = $resumen_diario->envio_resumen_correlativo;
                $ticket = $resumen_diario->envio_resumen_ticket;

                if(!empty($resumen_diario)){
                    //$result = $this->ventas->actualizar_correlativo_resumen('RC', $correlativo);
                    if($result == 1){
                        $cabecera = array(
                            "tipocomp"		=>"RC",
                            "serie"			=>$serie,
                            "correlativo"	=>$correlativo,
                            "fecha_emision" =>date('Y-m-d'),
                            "fecha_envio"	=>date('Y-m-d')
                        );
                        //$cabecera = $this->ventas->listar_serie_resumen('RC');

                        $ruta = "libs/ApiFacturacion/xml/";
                        $emisor = $this->empresas->listar_datos_empresa();
                        $nombrexml = $emisor->empresa_ruc.'-'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];
                        $result = apiFacturacion::ConsultarTicket($emisor, $cabecera, $ticket,"ApiFacturacion/cdr/", 1);

                    }
                }


            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }
    public function generar_nota_re(Request $request)
    {
        try {
            $microtime = microtime(true);
            $calculo = json_decode($request->calculo);
            $datos = json_decode($request->datos);
            $id_venta_ = $_POST['id_venta'];
            $tipo_pago = $_POST['id_tipo_pago'];
            $fecha = date('Y-m-d H:i:s');
            $dato_venta = $this->ventas->listar_venta_x_id($id_venta_);
            $empre = $this->ventas->listar_venta_x_id_pdf($id_venta_);
            $sacar_serie = DB::table('serie')->where('id_serie','=',$request->serie_nota)->first();
            // Iniciar transacción
            DB::beginTransaction();
            $venta = [
                'id_caja_numero' => $dato_venta->id_caja_numero,
                'id_empresa' => 1,
                'id_clientes' => $request->id_cliente,
                'id_users' => Auth::id(),
                'id_tipo_pago' => null,
                'id_moneda' => 1,
                'venta_condicion_resumen' => 1,
                'venta_tipo_envio' => $dato_venta->venta_tipo_envio,
                'venta_direccion' => null,
                'venta_tipo' => $request->tipo_venta,
                'venta_serie' => $sacar_serie->serie,
                'venta_correlativo' => $request->numero_nota,
                'venta_descuento_global' => 0.00,
                'venta_totalgratuita' => $calculo[1],
                'venta_totalexonerada' => $calculo[0],
                'venta_totalinafecta' => $calculo[2],
                'venta_totalgravada' => $calculo[3],
                'venta_totaligv' => $calculo[4],
                'venta_incluye_igv' => 1,
                'venta_totaldescuento' => 0.00,
                'venta_icbper' => $calculo[5],
                'venta_total' => $calculo[6],
                'venta_pago_cliente' => $calculo[6],
                'venta_vuelto' => 0.00,
                'venta_fecha' => $fecha,
                'venta_observacion' => $request->pago_observacion,
                'tipo_documento_modificar' => $request->Tipo_documento_modificar,
                'serie_modificar' => $request->serie_modificar,
                'correlativo_modificar' => $request->numero_modificar,
                'venta_codigo_motivo_nota' => $request->notatipo_descripcion,
                'venta_estado_sunat' => 0,
                'venta_fecha_envio' => null,
                'venta_rutaXML' => null,
                'venta_rutaCDR' => null,
                'venta_respuesta_sunat' => null,
                'venta_fecha_de_baja' => null,
                'anulado_sunat' => 0,
                'venta_cancelar' => 1,
                'venta_seriecorrelativo_notaventa' => null,
                'venta_codigo' => $microtime,
                'cambiar_concepto' => 1,
                'concepto_nuevo' => null,
                'tipo_venta' => $dato_venta->tipo_venta,
                'venta_estado_venta' => 1,// venta de sistema! esto es para saber si el cliente pago el pedido
                'id_formas_pago'=>$dato_venta->tipo_venta,
                'venta_estado_pago'=>$dato_venta->venta_estado_pago
            ];
            $guardar_venta = DB::table('ventas')->insert($venta);
            if($guardar_venta) {
                    $venta_a = $this->ventas->listar_venta_x_codigo($microtime);
                    foreach ($datos as $p){
                        $cantidad = $p->venta_detalle_cantidad;

                        if ($cantidad >= 12){
                            if ($p->id_venta_detalle){
                                $precio = $p->pro_precio_uni_ma;
                            }else{
                                $precio = $p->venta_detalle_precio_may;
                            }
                        }else{
                            $precio = $p->venta_detalle_precio_unitario;
                        }

//                        $precio = round($precio,2);

                        if ($p->id_tipo_afectacion == 1) {
                            if ($p->venta_detalle_porcentaje_igv == 18){
                                $calcu_igv = 1.18;
                                $porcentajeigv = 18;
                            }elseif ($p->venta_detalle_porcentaje_igv == 10){
                                $calcu_igv = 1.10;
                                $porcentajeigv = 10;
                            }else{
                                $calcu_igv = 0.00;
                                $porcentajeigv = 00.00;
                            }
                            $ca = $precio - ($precio / $calcu_igv);
//                            $ca = round($ca,2);
                            $precioOriginalValor = $precio - $ca;
                            $precioOriginalUnit = $precio;

                        } else {
                            $ca = 0;
                            $porcentajeigv = 0;
                            $precioOriginalValor = $precio;
                            $precioOriginalUnit = $precio;
                        }
                        $sumar = ($precioOriginalUnit * $cantidad) ;
                        $detalle = [
                            'id_venta' => $venta_a->id_venta,
                            'id_pro' => $p->id_pro,
                            'venta_detalle_valor_unitario' => $precioOriginalValor,
                            'venta_detalle_precio_unitario' => $precioOriginalUnit,
                            'venta_detalle_nombre_producto' => $p->venta_detalle_nombre_producto,
                            'venta_detalle_cantidad' => $cantidad,
                            'venta_detalle_total_igv' => $ca * $p->venta_detalle_cantidad,
                            'venta_detalle_porcentaje_igv' => $porcentajeigv,
                            'venta_detalle_total_icbper' => 0,
                            'venta_detalle_valor_total' => $precioOriginalValor * $cantidad,
                            'venta_detalle_importe_total' => $sumar,
                        ];
                        $guardar_venta_detalle = DB::table('ventas_detalle')->insert($detalle);
                    }
                    $venta_tipos_pagos = [
                        'id_venta' => $venta_a->id_venta,
                        'id_tipo_pago' => $request->id_tipo_pago,
                        'venta_detalle_pago_monto' => $calculo[6],
                        'venta_detalle_pago_estado' => 1,
                    ];
                    $guardar_tipo_venta = DB::table('ventas_detalle_pagos')->insert($venta_tipos_pagos);
                    if($guardar_tipo_venta){
                        // actualizar correlativo serie
                        $result = DB::table('serie')->where('id_serie','=',$request->serie_nota)->update(['correlativo'=>$request->numero_nota]);
                        if($_POST['tipo_venta'] == "07" && ($_POST['notatipo_descripcion'] == "01" || $_POST['notatipo_descripcion'] == "02")){
                            DB::table('ventas')->where([['venta_serie','=',$request->serie_modificar],['venta_correlativo','=',$request->numero_modificar]])
                            ->update(['anulado_sunat'=>1,'venta_cancelar'=>0]);
                        }
                        // Confirmar transacción
                        DB::commit();
                        $result = 1;
                    }
                }
            return json_encode($result);
        } catch (\Exception $e) {
            // Deshacer transacción en caso de error
            DB::rollback();
            $this->logs->insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
    }
// hacer la jugada aca
    public function anular_boleta_cambiarestado(Request $request)
    {
        try {
            $id_venta =$request->id_venta;
            $estado = $request->estado;
            $mensaje = 'Anulado con exito';
            $dato = $this->ventas->listar_venta_x_id($id_venta);
            if($dato->venta_tipo == '01'){
                //se creara un registro en la venta anulado
                /*$datos= Ventas::listar_venta_x_id($id_venta);
                $crear = DB::table('ventas_anulados')->insert([
                    'id_venta'=>$id_venta,
                    'id_users'=>Auth::id(),
                    'venta_anulado_fecha'=>date('Y-m-d'),
                    'venta_anulado_serie'=>$datos->venta_serie,
                    'venta_anulado_correlativo'=>$datos->venta_correlativo,
                    'venta_anulado_datetime'=>date('Y-m-d H:i:s'),
                    'venta_anulado_estado'=>1,
                ]);*/
                $result  = DB::table('ventas')->where('id_venta','=',$id_venta)->update(['venta_condicion_resumen'=>1, 'venta_tipo_envio'=>1, 'anulado_sunat'=>1, 'venta_cancelar'=>0, 'venta_estado_sunat'=>1,'venta_respuesta_sunat'=>$mensaje,'venta_fecha_de_baja'=>date('Y-m-d H:i:s')]);

            }else{
                $result = DB::table('ventas')->where('id_venta','=',$id_venta)->update(['venta_condicion_resumen'=>$estado, 'venta_tipo_envio'=>2, 'anulado_sunat'=>1, 'venta_cancelar'=>0, 'venta_estado_sunat'=>0]);
            }
//            if($request->valorReduccion == 1){
//                //SI VIENE UNO, ES PARA AUMENTAR STOCK
//                $items = $this->ventas->listar_venta_detalle_x_id_venta_venta($id_venta);
//                foreach ($items as $i){
//                    $cantidad = $i->venta_detalle_cantidad;
//                    $disminuir_stock_producto = DB::table('producto')->where('id_producto','=',$i->id_producto)->update(['producto_stock'=>$i->producto_stock + $cantidad]);
//                }
//            }


            return json_encode($result);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);

            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
    }

    public function cambiarestado_enviado(Request $request)
    {
        try {
            $id_venta = $request->id;
            $venta = $this->ventas->listar_venta_x_id($id_venta);
                if ($request->accion == "1033"){
                $respuesta = "La Factura numero ".$venta->venta_serie."-".$venta->venta_correlativo.", ha sido aceptada";
                $result = DB::table('ventas')->where('id_venta','=',$id_venta)->update(['venta_tipo_envio'=>1, 'venta_estado_sunat'=>1, 'venta_fecha_envio'=>date('Y-m-d H:i:s'), 'venta_respuesta_sunat'=>$respuesta]);
            }else if($request->accion == "1032"){
                $respuesta = "El comprobante ya esta informado y se encuentra con estado anulado o rechazado";
                $result = DB::table('ventas')->where('id_venta','=',$id_venta)->update(['venta_tipo_envio'=>1, 'venta_estado_sunat'=>1, 'venta_fecha_envio'=>date('Y-m-d H:i:s'), 'venta_respuesta_sunat'=>$respuesta, 'anulado_sunat'=>1, 'venta_cancelar'=>0,]);
            }
            return json_encode($result);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);

            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
    }
    public function buscar_productos(Request $request)
    {
        try {
            $palabras = explode(' ', $request->valor);
            $result = DB::table('productos as p')
                ->join('tipo_afectacion as t','t.id_tipo_afectacion','=','p.id_tipo_afectacion')
                ->where('p.pro_estado', '=', 1)
                ->where(function ($query) use ($palabras) {
                    foreach ($palabras as $palabra) {
                        $query->where('p.pro_nombre', 'like', '%' . $palabra . '%')
                            ->orWhere('p.pro_codigo', 'like', '%' . $palabra . '%');
                    }
                })->limit(10)->get();


//            $result = DB::table('productos as p')
//                ->join('tipo_afectacion as t','t.id_tipo_afectacion','=','p.id_tipo_afectacion')
//                ->where('t.tra_nombre','like','%'.$request->valor.'%')
//                ->where('t.tra_estado','=',1)
//                ->where('ts.tra_su_estado','=',1)
//                ->where('ts.id_su','=',$request->id_su)->get();

            return json_encode($result);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
//            Logs::insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
    }

    public function comunicacion_baja(Request $request)
    {
        try {
            $id = $request->id_venta;
            $da = $this->ventas->listar_soloventa_x_id($id);
            $serie = date('Ymd');
            $fila_serie = DB::table('serie as s')->where('s.tipocomp','=','RC')
                ->first();
            $venta = $this->ventas->listar_venta_x_id($id);
            $a = 1;
            if($fila_serie->serie != $serie ){
                $correlativo = 1;
            }else{
                $correlativo = $fila_serie->correlativo + 1;
            }
            if($a == 1){
                $cabecera = array(
                    "tipocomp"		=>"RC",
                    "serie"			=>$serie,
                    "correlativo"	=>$correlativo,
                    "fecha_emision" =>date('Y-m-d'),
                    "fecha_envio"	=>date('Y-m-d')
                );
                $items = $venta;
                $ruta = 'ApiFacturacion/xml/';
                $emisor = $this->empresas->listar_datos_empresa();
                $nombrexml = $emisor->empresa_ruc.'-'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];
                $nom = $ruta.$nombrexml;
                GeneradorXML::CrearXmlBajaDocumentos($emisor, $cabecera, $items, $nom);
                $result = apiFacturacion::EnviarResumenComprobantes($emisor,$nombrexml,"ApiFacturacion/","ApiFacturacion/xml/",1);
                $ticket = $result['ticket'];
                $message = $result['mensaje'];
                if($result['result'] == 1){
                    $ruta_xml = 'ApiFacturacion/xml/'.$nombrexml.'.XML';
                    $guardar_anulacion = Ventas_anulado::guardar_venta_anulacion(date('Y-m-d', strtotime($venta->venta_fecha)),$cabecera['serie'],$cabecera['correlativo'],$ruta_xml,$result['mensaje'],$id,Auth::id(),$result['ticket']);
                    if($guardar_anulacion == true){
                        if($fila_serie->serie != $serie){
                            $edit_serie = DB::table('serie')->where('tipocomp','=','RC')->update(['serie'=>$serie]);
                        }
                        //ACA ACTUALIZAMOS EL CORRELATIVO RESUMEN
                        $corr = DB::table('serie')->where('tipocomp','=','RC')->update(['correlativo'=>$correlativo]);
                        // actualizamos el esatdo venta anulado
                        $result  = DB::table('ventas')->where('id_venta','=',$id)->update(['anulado_sunat' =>1,'venta_cancelar' =>0]);

                        if($result == 1 || $result == true){
                            $result = apiFacturacion::ConsultarTicket($emisor, $cabecera, $ticket,"ApiFacturacion/cdr/", 1);
                        }
                    }
                }elseif($result['result'] == 4){
                    $result = 4;
                }elseif($result['result'] == 3){
                    $result = 3;

                }
            }

            return json_encode($result);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);

            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
    }


    public function crear_xml_enviar_sunatPri(Request $request)
    {
        try {
            $result = 6;
            $baseUrl       = env('URL_FACTU');
            $id            = $request->id_venta;
            $venta         = $this->ventas->listar_soloventa_x_id($id);
            $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta($id);
            $empresa       = $this->empresas->listar_datos_empresa();
            $cliente       = $this->cliente->listar_clienteventa_x_id($venta->id_clientes);
            $nombre        = $empresa->empresa_ruc.'-'.$venta->venta_tipo.'-'.$venta->venta_serie.'-'.$venta->venta_correlativo;
            $rutaDir       = 'ApiFacturacion/xml/';
            $ruta_archivo_cdr       = "ApiFacturacion/cdr/";

            // 1) Genera el XML sin firma
            if ($venta->venta_tipo == '01' || $venta->venta_tipo == '03') {
                GeneradorXML::CrearXMLFacturaPri($rutaDir.$nombre, $empresa, $cliente, $venta, $detalle_venta);
            }else{
                $detalle_venta = $this->ventas->listar_venta_detalle_x_nota($id);
                if($venta->venta_tipo == "07"){
                    $descripcion_nota = Tipo_ncredito::listar_tipo_notaC_x_codigo($venta->venta_codigo_motivo_nota);
                    GeneradorXML::CrearXMLNotaCreditoPRI($rutaDir.$nombre, $empresa, $cliente, $venta, $detalle_venta,$descripcion_nota);
                }else{
                    $descripcion_nota = Tipo_ndebito::listar_tipo_notaD_x_codigo($venta->venta_codigo_motivo_nota);
                    GeneradorXML::CrearXMLNotaDebitoPRI($rutaDir.$nombre, $empresa, $cliente, $venta, $detalle_venta,$descripcion_nota);
                }
            }

            // 2) Crear Empresa
//            $panelTok = '230ff33f4c2210f3a3250b9c3b3eae9950f23f56a476ef7bd67fe3e4ae73c346';
//            $ruc      = '20528449833';
//            $razonSocial      = 'INVERSIONES GENERALES LA MARINA S.R.L.';
//            $tipoPlan = '01';
//            $empresa = apiFacturacion::crearEmpresa($baseUrl, $panelTok, $ruc,$razonSocial, $tipoPlan, /*insecure*/ true);
//            $username = $empresa['username'];
//            $password = $empresa['password'];

            // 3) Obtener Token
            $username = env('USERS_EMPRESA_NAM');
            $password = env('USERS_EMPRESA_PAS');
            $nombreArchivo = $nombre.'.XML';
            $rutaXml       = $rutaDir.$nombreArchivo;
            $tokenAcceso = apiFacturacion::obtenerToken($baseUrl, $username, $password, true);

            // 4) Firmar XML
            $firmarXml = apiFacturacion::FirmarXMLPRI($baseUrl, $tokenAcceso, $rutaXml, $nombre);
            if ($firmarXml['mensaje'] == 'XML firmado correctamente') {
               /* $ruta_archivo_xml = 'ApiFacturacion/xml/';
                $ruta_xml_firmado = $ruta_archivo_xml . $nombre . '.XML';
                $rutazip = $ruta_archivo_xml . $nombre . '.zip';
                if (!file_exists($rutazip) && $zip = new \ZipArchive()) {
                    if ($zip->open($rutazip, \ZipArchive::CREATE) === true) {
                        $zip->addFile($ruta_xml_firmado, $nombre . '.XML');
                        $zip->close();
                    } else {
                        Log::warning('No se pudo crear ZIP local', ['rutazip' => $rutazip]);
                    }
                }*/


                DB::table('ventas')->where('id_venta','=',$id)->update(['venta_rutaXML'=>$rutaXml]);

                // 5) Enviar XML firmado a SUNAT
                $enviarXml = apiFacturacion::EnviarASunatPri($baseUrl, $tokenAcceso, $firmarXml['xml'], $nombre, true);
                if($enviarXml['estado'] == 200){
                    $cdr_xml = base64_decode($enviarXml["raw"]["cdr"]);
                    $nombre_xml_cdr = 'R-' . $nombre . '.XML';
                    $ruta_xml_cdr_absoluta = public_path($ruta_archivo_cdr . $nombre_xml_cdr);
                    $ruta_xml_cdr_relativa = $ruta_archivo_cdr . $nombre_xml_cdr;

                    if (!file_exists(dirname($ruta_xml_cdr_absoluta))) {
                        mkdir(dirname($ruta_xml_cdr_absoluta), 0755, true);
                    }

                    if (file_put_contents($ruta_xml_cdr_absoluta, $cdr_xml) === false) {
                        Log::error("Error al guardar CDR XML: " . $ruta_xml_cdr_absoluta);
                        $result = 0;
                    } else {
                        if (file_exists($ruta_xml_cdr_absoluta)) {
                            $xml_cdr = simplexml_load_file($ruta_xml_cdr_absoluta);

                            if ($xml_cdr !== false) {
                                $xml_cdr->registerXPathNamespace('c', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
                                $xml_cdr->registerXPathNamespace('sac', 'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1');
                                $ResponseCode = $xml_cdr->xpath('//c:ResponseCode');
                                $Description = $xml_cdr->xpath('//c:Description');
                                $codigo_respuesta = isset($ResponseCode[0]) ? (string)$ResponseCode[0] : '';
                                $descripcion_respuesta = isset($Description[0]) ? (string)$Description[0] : '';

                                DB::table('ventas')->where('id_venta', '=', $id)
                                    ->update([
                                        'venta_tipo_envio' => 1,
                                        'venta_estado_sunat' => 1,
                                        'venta_fecha_envio' => date('Y-m-d H:i:s'),
                                        'venta_respuesta_sunat' => $descripcion_respuesta ?: $enviarXml['mensaje'],
                                        'venta_rutaCDR' => $ruta_xml_cdr_relativa,
                                    ]);

                                $result = 1;
                                Log::info("CDR XML guardado exitosamente: " . $ruta_xml_cdr_absoluta);
                                Log::info("Ruta en BD: " . $ruta_xml_cdr_relativa);
                                Log::info("Respuesta SUNAT: " . $descripcion_respuesta);

                            } else {
                                Log::error("Error al cargar el CDR XML: " . $ruta_xml_cdr_absoluta);
                                $result = 0;
                            }
                        } else {
                            Log::error("El archivo CDR no se creó: " . $ruta_xml_cdr_absoluta);
                            $result = 0;
                        }
                    }
                }
            }

            return response()->json($result);

        } catch (\Throwable $e) {
            $this->logs->insertarLog($e);
//            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
            return response()->json($result);
        }
    }

    //FUNCIONES DE EXCEL
    public function excel_ventas_enviadas(Request $request){
        try{
            $tipo = $_GET['tipo'];
            $fecha_inicio = $_GET['fecha_inicio'];
            $fecha_final = $_GET['fecha_final'];
            $id_empresa = $_GET['empresa'];
            $query = DB::table('ventas as v')
//                ->join('formas_pago as f', 'v.id_formas_pago', '=', 'f.id_formas_pago')
                ->join('empresa as e', 'e.id_empresa', '=', 'v.id_empresa')
                ->join('clientes as c', 'v.id_clientes', '=', 'c.id_clientes')
                ->join('monedas as mo', 'v.id_moneda', '=', 'mo.id_moneda')
                ->join('users as u', 'v.id_users', '=', 'u.id_users')
                ->where('e.id_empresa',  '=', $id_empresa)
                ->where('v.venta_estado_sunat', '=', 1);

            if($tipo != '0'){
                $query->where('v.venta_tipo', $tipo);
            }

            if($fecha_inicio != "" && $fecha_final != ""){
                $query->whereBetween(DB::raw('date(v.venta_fecha)'), [$fecha_inicio, $fecha_final]);
            }
            $datos = $query->orderBy('v.venta_fecha', 'asc')->get();

            foreach ($datos as $v){
                $v->resumen = DB::table('envio_resumen_detalle as er')->join('ventas as v','er.id_venta','=','v.id_venta')->where('er.id_venta','=',$v->id_venta)->first();
            }
            foreach ($datos as $v){
                $TIPO_PAGOS = "";
                $pago = Ventas_detalle_pago::listar_formas_x_idventa($v->id_venta);
                foreach ($pago as $p){
                    $TIPO_PAGOS .= $p->tipo_pago_nombre.' - ';
                }
                $v->tipo_pago = $TIPO_PAGOS;
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $mensaje = "RESULTADO DE LA BUSQUEDA : ";
            $mensaje_="";
            if($tipo==0){
                $mensaje_ .= ' TODOS ';
            }elseif ($tipo=='03'){
                $mensaje_ .= ' BOLETAS ';
            }elseif ($tipo=='01'){
                $mensaje_ .= ' FACTURAS ';
            }elseif ($tipo=='07'){
                $mensaje_ .= ' NOTAS DE CREDITO ';
            }elseif ($tipo=='08'){
                $mensaje_ .= ' NOTAS DE DEBITO ';
            }
            if(isset($fecha_inicio,$fecha_final)){
                $mensaje.= " TIPO COMPROBANTE ".$mensaje_." DEL ".date("d-m-Y",strtotime($fecha_inicio))." HASTA : ".date("d-m-Y",strtotime($fecha_final));
            }
            // Agregar título en negritas
            $sheet->setCellValue('A1', $mensaje);
            $titleStyle = $sheet->getStyle('A1');
            $titleStyle->getFont()->setSize(16); // Tamaño de letra 14
            $titleStyle->getFont()->setBold(true); // Hacer el título en negritas
            // Combinar celdas para el título
            $sheet->mergeCells('A1:T1');
            // Agregar datos a las celdas para la cabecera
            $sheet->setCellValue('A2', '#');
            $sheet->setCellValue('B2', 'EMPRESA');
            $sheet->setCellValue('C2', 'FECHA DE EMISIÓN');
            $sheet->setCellValue('D2', 'TIPO DE ENVIO');
            $sheet->setCellValue('E2', 'COMPROBANTE');
            $sheet->setCellValue('F2', 'SERIE Y CORRELATIVO');

            $sheet->setCellValue('G2', 'CLIENTE');
            $sheet->setCellValue('H2', 'TIPO DE PAGO');
            $sheet->setCellValue('I2', 'FORMA DE PAGO');
            $sheet->setCellValue('J2', 'MONEDA');

            $sheet->setCellValue('K2', 'DESCUENTO');
            $sheet->setCellValue('L2', 'GRAVADO');
            $sheet->setCellValue('M2', 'EXONERADO');
            $sheet->setCellValue('N2', 'INAFECTO');
            $sheet->setCellValue('O2', 'GRATUITO');
            $sheet->setCellValue('P2', 'IGV');
            $sheet->setCellValue('Q2', 'ICBPER');
            $sheet->setCellValue('R2', 'TOTAL');
            $sheet->setCellValue('S2', 'ESTADO SUNAT');
            $sheet->setCellValue('T2', 'ESTADO COMPROBANTE');
            // Establecer el ancho de las columnas A a G
            $sheet->getColumnDimension('A')->setWidth(7); // Ancho de la columna A
            $sheet->getColumnDimension('B')->setWidth(30); // Ancho de la columna B
            $sheet->getColumnDimension('C')->setWidth(30); // Ancho de la columna C
            $sheet->getColumnDimension('D')->setWidth(22); // Ancho de la columna D
            $sheet->getColumnDimension('E')->setWidth(22); // Ancho de la columna E
            $sheet->getColumnDimension('F')->setWidth(25); // Ancho de la columna F
            $sheet->getColumnDimension('G')->setWidth(80); // Ancho de la columna G
            $sheet->getColumnDimension('H')->setWidth(25); // Ancho de la columna H
            $sheet->getColumnDimension('I')->setWidth(25); // Ancho de la columna I
            $sheet->getColumnDimension('J')->setWidth(18); // Ancho de la columna J

            $sheet->getColumnDimension('K')->setWidth(22); // Ancho de la columna K
            $sheet->getColumnDimension('L')->setWidth(22); // Ancho de la columna L
            $sheet->getColumnDimension('M')->setWidth(22); // Ancho de la columna M
            $sheet->getColumnDimension('N')->setWidth(22); // Ancho de la columna N
            $sheet->getColumnDimension('O')->setWidth(22); // Ancho de la columna O
            $sheet->getColumnDimension('P')->setWidth(22); // Ancho de la columna P
            $sheet->getColumnDimension('Q')->setWidth(22); // Ancho de la columna Q

            $sheet->getColumnDimension('R')->setWidth(20); // Ancho de la columna R
            $sheet->getColumnDimension('S')->setWidth(60); // Ancho de la columna S
            $sheet->getColumnDimension('T')->setWidth(60); // Ancho de la columna T
            // Obtener la fila 1 completa (desde A hasta T) como un rango
            $cellRange = 'A2:T2';
            $rowStyle = $sheet->getStyle($cellRange);
            // Establecer el fondo, tamaño de letra y hacer negritas en toda la fila 1 y cambiar color del texto
            $rowStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0b1892'); // Fondo
            $rowStyle->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); // color de texto
            $rowStyle->getFont()->setSize(14); // Tamaño de letra 14
            $rowStyle->getFont()->setBold(true); // Hacer negritas
            // contenido de la table
            $row = 3; // Empieza a partir de la terce fila (fila 2 es para encabezados)
            $conteo = 1;
            //$total = 0;
            $total_soles = 0;
            $total_dolares = 0;
            $estado_comprobante='';
            $stylee='';
            foreach ($datos as $item) {
                if($item->venta_tipo == "03"){
                    $tipo_comprobante = "BOLETA";
                    if($item->anulado_sunat == 0){
                        $estado_comprobante = 'REGISTRADO';
                        if($item->id_moneda == 1) {
                            $total_soles = round($total_soles + $item->venta_total, 2);
                        }else{
                            $total_dolares = round($total_dolares + $item->venta_total, 2);
                        }
                    }else{
                        $stylee="style= 'text-align: center; background-color: #FF6B70'";
                        $estado_comprobante = 'ANULADO';
                    }
                }elseif ($item->venta_tipo == "01"){
                    $tipo_comprobante = "FACTURA";
                    if($item->anulado_sunat == 0){
                        $estado_comprobante = 'REGISTRADO';
                        if($item->id_moneda == 1) {
                            $total_soles = round($total_soles + $item->venta_total, 2);
                        }else{
                            $total_dolares = round($total_dolares + $item->venta_total, 2);
                        }
                    }else{
                        $estado_comprobante = 'ANULADO';
                        $stylee="style= 'text-align: center; background-color: #FF6B70'";
                    }

                }elseif($item->venta_tipo == "07"){
                    $estado_comprobante = 'REGISTRADO';
                    $tipo_comprobante = "NOTA DE CRÉDITO";
                }elseif($item->venta_tipo == "08"){
                    $tipo_comprobante = "NOTA DE DÉBITO";
                    if($item->anulado_sunat == 0){
                        $estado_comprobante = 'REGISTRADO';
                        if($item->id_moneda == 1) {
                            $total_soles = round($total_soles + $item->venta_total, 2);
                        }else{
                            $total_dolares = round($total_dolares + $item->venta_total, 2);
                        }
                    }else{
                        $estado_comprobante = 'ANULADO';
                        $stylee="style= 'text-align: center; background-color: #FF6B70'";
                    }
                }else{
                    $tipo_comprobante = "--";
                }

                if($item->venta_tipo_envio == 1){
                    $tipo_venta = 'DIRECTO';
                }elseif($item->venta_tipo_envio == 2){
                    $tipo_venta = 'ENVIADO RESUMEN DIARIO';
                }else{
                    $tipo_venta = 'PENDIENTE DE ENVIO';
                }

                if($item->id_tipo_documento == 4){
                    $cliente = $item->cliente_razonsocial;
                }else{
                    $cliente = $item->cliente_nombre;
                }
                $forma_pago="";

                if($item->id_formas_pago==1){
                    $forma_pago = 'PAGADO';
                }else{
                    if($item->venta_estado_pago==0){
                        $forma_pago = 'PENDIENTE DE PAGO';
                    }elseif ($item->venta_estado_pago==1){
                        $forma_pago = 'PAGADO PARCIALMENTE';
                    }elseif ($item->venta_estado_pago==2){
                        $forma_pago = 'PAGADO';
                    }
                }
                $estilo_mensaje = "";
                if($item->venta_estado_sunat == 1){
                    if($item->venta_respuesta_sunat != ""){
                        $mensaje = $item->venta_respuesta_sunat;
                    }else{
                        $mensaje = 'Aceptado por Resumen Diario';
                    }
                    $estilo_mensaje = "style= 'color: green; font-size: 14px;'";
                }
                $sheet->setCellValue('A' . $row, $conteo);
                $sheet->setCellValue('B' . $row, $item->empresa_nombrecomercial);
                $sheet->setCellValue('C' . $row, date('d-m-Y H:i:s', strtotime($item->venta_fecha)));
                $sheet->setCellValue('D' . $row, $tipo_venta);
                $sheet->setCellValue('E' . $row, $tipo_comprobante);
                $sheet->setCellValue('F' . $row, $item->venta_serie. '-' .$item->venta_correlativo);

                $sheet->setCellValue('G' . $row, $item->cliente_numero. '||' .$cliente);
                $sheet->setCellValue('H' . $row, $item->tipo_pago);
                $sheet->setCellValue('I' . $row, $item->id_formas_pago == 1 ? 'CONTADO':'CREDITO' );

                $sheet->setCellValue('J' . $row, $item->moneda);
                $sheet->setCellValue('K' . $row, $item->venta_totaldescuento);
                $sheet->setCellValue('L' . $row, $item->venta_totalgravada);
                $sheet->setCellValue('M' . $row, $item->venta_totalexonerada);
                $sheet->setCellValue('N' . $row, $item->venta_totalinafecta);
                $sheet->setCellValue('O' . $row, $item->venta_totalgratuita);
                $sheet->setCellValue('P' . $row, $item->venta_totaligv);
                $sheet->setCellValue('Q' . $row, $item->venta_icbper);
                $sheet->setCellValue('R' . $row, number_format($item->venta_total,2));
                $sheet->setCellValue('S' . $row, $mensaje);
                $sheet->setCellValue('T' . $row, $estado_comprobante);
                if ($estado_comprobante == "ANULADO"){
                    $cellRange = 'A'.$row.':T'.$row;
                    $rowStyle = $sheet->getStyle($cellRange);
                    // Establecer el fondo, tamaño de letra y hacer negritas en toda la fila 1 y cambiar color del texto
                    $rowStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ff0000'); // Fondo
                    $rowStyle->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); // color de texto
                    $rowStyle->getFont()->setSize(12); // Tamaño de letra 14
                    $rowStyle->getFont()->setBold(true); // Hacer negritas
                }
                $row++; // Moverse a la siguiente fila
                $conteo++;
            }
            $row = $row+1;
            $sheet->setCellValue('A' . $row, '');
            $sheet->setCellValue('B' . $row, '');
            $sheet->setCellValue('C' . $row, '');
            $sheet->setCellValue('D' . $row, '');
            $sheet->setCellValue('E' . $row, '');
            $sheet->setCellValue('F' . $row, '');
            $sheet->setCellValue('G' . $row, '');
            $sheet->setCellValue('H' . $row, '');
            $sheet->setCellValue('I' . $row, '');
            $sheet->setCellValue('J' . $row, '');
            $sheet->setCellValue('k' . $row, '');
            $sheet->setCellValue('L' . $row, '');
            $sheet->setCellValue('M' . $row, '');
            $sheet->setCellValue('N' . $row, '');
            $sheet->setCellValue('O' . $row, '');
            $sheet->setCellValue('P' . $row, '');
            $sheet->setCellValue('Q' . $row, 'TOTAL S/. ');
            $sheet->setCellValue('R' . $row, $total_soles);
            $sheet->setCellValue('S' . $row, '');
            $sheet->setCellValue('T' . $row, '');
            $row = $row+1;
            $sheet->setCellValue('A' . $row, '');
            $sheet->setCellValue('B' . $row, '');
            $sheet->setCellValue('C' . $row, '');
            $sheet->setCellValue('D' . $row, '');
            $sheet->setCellValue('E' . $row, '');
            $sheet->setCellValue('F' . $row, '');
            $sheet->setCellValue('G' . $row, '');
            $sheet->setCellValue('H' . $row, '');
            $sheet->setCellValue('I' . $row, '');
            $sheet->setCellValue('J' . $row, '');
            $sheet->setCellValue('k' . $row, '');
            $sheet->setCellValue('L' . $row, '');
            $sheet->setCellValue('M' . $row, '');
            $sheet->setCellValue('N' . $row, '');
            $sheet->setCellValue('O' . $row, '');
            $sheet->setCellValue('P' . $row, '');
            $sheet->setCellValue('Q' . $row, 'TOTAL $.');
            $sheet->setCellValue('R' . $row, $total_dolares);
            $sheet->setCellValue('S' . $row, '');
            $sheet->setCellValue('T' . $row, '');


            $nameV = "excel_ventas_enviadas_".date('Ymd_His').'.xlsx';
            // Crear una respuesta (response) para el archivo Excel
            $response = response()->stream(
                function () use ($spreadsheet) {
                    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                    $writer->save('php://output');
                },
                200,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename='.$nameV,
                ]
            );
            return $response;
        }catch  (\Exception $e){
           $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
    }
//
//    public function excel_resumen_diario(Request $request , $fecha_inicio , $fecha_final){
//        try{
//            $ventas1 = DB::table('envio_resumen as er')
//                ->join('empresa as c', 'c.id_empresa', '=', 'er.id_empresa')
//                ->whereDate('er.envio_sunat_datetime','>=',$fecha_inicio)
//                ->whereDate('er.envio_sunat_datetime','<=',$fecha_final)->get();
//
//            $datos = $ventas1;
//            $spreadsheet = new Spreadsheet();
//            $sheet = $spreadsheet->getActiveSheet();
//            $mensaje = "RESULTADO DE LA BUSQUEDA : ";
//            if(isset($fecha_inicio,$fecha_final)){
//                $mensaje.= " DEL ".date("d-m-Y",strtotime($fecha_inicio))." HASTA : ".date("d-m-Y",strtotime($fecha_final));
//            }
//            // Agregar título en negritas
//            $sheet->setCellValue('A1', $mensaje);
//            $titleStyle = $sheet->getStyle('A1');
//            $titleStyle->getFont()->setSize(16); // Tamaño de letra 14
//            $titleStyle->getFont()->setBold(true); // Hacer el título en negritas
//            // Combinar celdas para el título
//            $sheet->mergeCells('A1:P1');
//            // Agregar datos a las celdas para la cabecera
//                $sheet->setCellValue('A2', '#');
//            $sheet->setCellValue('B2', 'EMPRESA');
//            $sheet->setCellValue('C2', 'FECHA DE EMISIÓN');
//            $sheet->setCellValue('D2', 'SERIE Y CORRELATIVO');
//            $sheet->setCellValue('E2', 'CLIENTE');
//            $sheet->setCellValue('F2', 'TIPO DE PAGO');
//            $sheet->setCellValue('G2', 'FORMA DE PAGO');
//            $sheet->setCellValue('H2', 'MONEDA');
//            $sheet->setCellValue('I2', 'DESCUENTO');
//            $sheet->setCellValue('J2', 'GRAVADO');
//            $sheet->setCellValue('K2', 'EXONERADO');
//            $sheet->setCellValue('L2', 'INAFECTO');
//            $sheet->setCellValue('M2', 'GRATUITO');
//            $sheet->setCellValue('N2', 'IGV');
//            $sheet->setCellValue('O2', 'ICBPER');
//            $sheet->setCellValue('P2', 'TOTAL');
//            // Establecer el ancho de las columnas A a P
//            $sheet->getColumnDimension('A')->setWidth(7); // Ancho de la columna A
//            $sheet->getColumnDimension('B')->setWidth(30); // Ancho de la columna B
//            $sheet->getColumnDimension('C')->setWidth(30); // Ancho de la columna C
//            $sheet->getColumnDimension('D')->setWidth(25); // Ancho de la columna D
//            $sheet->getColumnDimension('E')->setWidth(60); // Ancho de la columna E
//            $sheet->getColumnDimension('F')->setWidth(25); // Ancho de la columna F
//            $sheet->getColumnDimension('G')->setWidth(30); // Ancho de la columna G
//            $sheet->getColumnDimension('H')->setWidth(25); // Ancho de la columna H
//            $sheet->getColumnDimension('I')->setWidth(25); // Ancho de la columna I
//            $sheet->getColumnDimension('J')->setWidth(18); // Ancho de la columna J
//            $sheet->getColumnDimension('K')->setWidth(22); // Ancho de la columna K
//            $sheet->getColumnDimension('L')->setWidth(22); // Ancho de la columna L
//            $sheet->getColumnDimension('M')->setWidth(22); // Ancho de la columna M
//            $sheet->getColumnDimension('N')->setWidth(22); // Ancho de la columna N
//            $sheet->getColumnDimension('O')->setWidth(22); // Ancho de la columna O
//            $sheet->getColumnDimension('P')->setWidth(22); // Ancho de la columna P
//            // Obtener la fila 1 completa (desde A hasta G) como un rango
//            $cellRange = 'A2:P2';
//            $rowStyle = $sheet->getStyle($cellRange);
//            // Establecer el fondo, tamaño de letra y hacer negritas en toda la fila 1 y cambiar color del texto
//            $rowStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('399630'); // Fondo
//            $rowStyle->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); // color de texto
//            $rowStyle->getFont()->setSize(14); // Tamaño de letra 14
//            $rowStyle->getFont()->setBold(true); // Hacer negritas
//            // contenido de la table
//            $row = 3; // Empieza a partir de la terce fila (fila 2 es para encabezados)
//            $conteo = 1;
//            //$total = 0;
//            $total_soles = 0;
//            foreach ($datos as $item) {
//                if($item->venta_tipo == "03"){
//                    $tipo_comprobante = "BOLETA";
//                    if($item->anulado_sunat == 0){
//                        $total_soles = round($total_soles + $item->venta_total, 2);
//                    }
//                }elseif ($item->venta_tipo == "01"){
//                    $tipo_comprobante = "FACTURA";
//                    if($item->anulado_sunat == 0){
//                        $total_soles = round($total_soles + $item->venta_total, 2);
//                    }
//                }elseif($item->venta_tipo == "07"){
//                    $tipo_comprobante = "NOTA DE CRÉDITO";
//                }elseif($item->venta_tipo == "08"){
//                    $tipo_comprobante = "NOTA DE DÉBITO";
//                    if($item->anulado_sunat == 0){
//                        $total_soles = round($total_soles + $item->venta_total, 2);
//                    }
//                }else{
//                    $tipo_comprobante = "--";
//                }
//
//                if($item->venta_tipo_envio == 1){
//                    $tipo_venta = 'DIRECTO';
//                }elseif($item->venta_tipo_envio == 2){
//                    $tipo_venta = 'ENVIADO RESUMEN DIARIO';
//                }else{
//                    $tipo_venta = 'PENDIENTE DE ENVIO';
//                }
//
//                if($item->id_tipo_documento == 4){
//                    $cliente = $item->cliente_razonsocial;
//                }else{
//                    $cliente = $item->cliente_nombre;
//                }
//                $forma_pago="";
//
//                if($item->id_formas_pago==1){
//                    $forma_pago = 'PAGADO';
//                }else{
//                    if($item->venta_estado_pago==0){
//                        $forma_pago = 'PENDIENTE DE PAGO';
//                    }elseif ($item->venta_estado_pago==1){
//                        $forma_pago = 'PAGADO PARCIALMENTE';
//                    }elseif ($item->venta_estado_pago==2){
//                        $forma_pago = 'PAGADO';
//                    }
//                }
//                $sheet->setCellValue('A' . $row, $conteo);
//                $sheet->setCellValue('B' . $row, $item->empresa_nombrecomercial);
//                $sheet->setCellValue('C' . $row, date('d-m-Y H:i:s', strtotime($item->venta_fecha)));
//                $sheet->setCellValue('D' . $row, $item->venta_serie. '-' .$item->venta_correlativo);
//                $sheet->setCellValue('E' . $row, $item->cliente_numero. '||' .$cliente);
//                $sheet->setCellValue('F' . $row, $item->tipo_pago_nombre);
//                $sheet->setCellValue('G' . $row, $item->formas_pago_nombre);
//                $sheet->setCellValue('H' . $row, $item->moneda);
//                $sheet->setCellValue('I' . $row, $item->venta_totaldescuento);
//                $sheet->setCellValue('J' . $row, $item->venta_totalgravada);
//                $sheet->setCellValue('K' . $row, $item->venta_totalexonerada);
//                $sheet->setCellValue('L' . $row, $item->venta_totalinafecta);
//                $sheet->setCellValue('M' . $row, $item->venta_totalgratuita);
//                $sheet->setCellValue('N' . $row, $item->venta_totaligv);
//                $sheet->setCellValue('O' . $row, $item->venta_icbper);
//                $sheet->setCellValue('P' . $row, $item->simbolo.''.number_format($item->venta_total,2));
//
//                $row++; // Moverse a la siguiente fila
//                $conteo++;
//            }
//            $row = $row+1;
//            $sheet->setCellValue('A' . $row, '');
//            $sheet->setCellValue('B' . $row, '');
//            $sheet->setCellValue('C' . $row, '');
//            $sheet->setCellValue('D' . $row, '');
//            $sheet->setCellValue('E' . $row, '');
//            $sheet->setCellValue('F' . $row, '');
//            $sheet->setCellValue('G' . $row, '');
//            $sheet->setCellValue('H' . $row, '');
//            $sheet->setCellValue('I' . $row, '');
//            $sheet->setCellValue('J' . $row, '');
//            $sheet->setCellValue('k' . $row, '');
//            $sheet->setCellValue('L' . $row, '');
//            $sheet->setCellValue('M' . $row, '');
//            $sheet->setCellValue('N' . $row, '');
//            $sheet->setCellValue('O' . $row, '');
//            $sheet->setCellValue('P' . $row, '');
//
//            // Crear una respuesta (response) para el archivo Excel
//            $response = response()->stream(
//                function () use ($spreadsheet) {
//                    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//                    $writer->save('php://output');
//                },
//                200,
//                [
//                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
//                    'Content-Disposition' => 'attachment; filename=excel_resumen_diario.xlsx',
//                ]
//            );
//            return $response;
//        }catch  (\Exception $e){
//            Logs::insertarLog($e);
//            return response(json_encode($e),200)->header('Content-type','text/plain');
//        }
//    }
//
//    public function excel_baja_facturas(Request $request , $fecha_inicio , $fecha_final){
//        try{
//
//            $spreadsheet = new Spreadsheet();
//            $sheet = $spreadsheet->getActiveSheet();
//            $mensaje = "RESULTADO DE LA BUSQUEDA : ";
//            if(isset($fecha_inicio,$fecha_final)){
//                $mensaje.= " DEL ".date("d-m-Y",strtotime($fecha_inicio))." HASTA : ".date("d-m-Y",strtotime($fecha_final));
//            }
//            // Agregar título en negritas
//            $sheet->setCellValue('A1', $mensaje);
//            $titleStyle = $sheet->getStyle('A1');
//            $titleStyle->getFont()->setSize(16); // Tamaño de letra 14
//            $titleStyle->getFont()->setBold(true); // Hacer el título en negritas
//            // Combinar celdas para el título
//            $sheet->mergeCells('A1:L1');
//            // Agregar datos a las celdas para la cabecera
//
//
//
//            // Crear una respuesta (response) para el archivo Excel
//            $response = response()->stream(
//                function () use ($spreadsheet) {
//                    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//                    $writer->save('php://output');
//                },
//                200,
//                [
//                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
//                    'Content-Disposition' => 'attachment; filename=excel_facturas_bajas.xlsx',
//                ]
//            );
//            return $response;
//        }catch  (\Exception $e){
//            Logs::insertarLog($e);
//            return response(json_encode($e),200)->header('Content-type','text/plain');
//        }
//    }

}
