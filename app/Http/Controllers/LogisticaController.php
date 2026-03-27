<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\GuiaRemision;
use App\Models\GuiaRemisionDetalle;
use App\Models\GeneradorXML;
use App\Models\apiFacturacion;
use App\Models\Categoria;
use App\Models\Contacto;
use App\Models\Detalle_compra;
use App\Models\Empresa;
use App\Models\Lotes;
use App\Models\Series;
use App\Models\Familia;
use App\Models\General;
use App\Models\Logs;
use App\Models\Menu;
use App\Models\Opciones;
use App\Models\Orden_compra;
use App\Models\Persona;
use App\Models\Productos;
use App\Models\Proveedores;
use App\Models\Recursos;
use App\Models\Recursos_almacen;
use App\Models\Submenu;
use App\Models\Tipo_documento;
use App\Models\Tipo_pago;
use App\Models\Tipo_venta;
use App\Models\User;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class LogisticaController extends Controller
{
    private $submenu;
    private $logs;
    private $general;
    private $almacen;
    private $productos;
    private $categorias;
    private $proveedores;
    private $tipo_venta;
    private $tipo_pago;
    private $ordenCompra;
    private $ordenCompraDetalle;
    private $empresa;
    private $contacto;
    private $guiaRemision;
    private $guiaRemisionDetalle;
    public function __construct()
    {
        $this->submenu = new Submenu();
        $this->logs = new Logs();
        $this->general = new General();
        $this->almacen = new Almacen();
        $this->productos = new Productos();
        $this->categorias = new Categoria();
        $this->proveedores = new Proveedores();
        $this->tipo_venta = new Tipo_venta();
        $this->tipo_pago = new Tipo_pago();
        $this->ordenCompra = new Orden_compra();
        $this->ordenCompraDetalle = new Detalle_compra();
        $this->empresa = new Empresa();
        $this->contacto = new Contacto();
        $this->guiaRemision = new GuiaRemision();
        $this->guiaRemisionDetalle = new GuiaRemisionDetalle();
    }
    public function gestionar_productos()
    {
        try {
//            ESTE IF ES PARA VERIFICAR SI ESE ROL TIENE EL PERMISO PARA LA VISTA
            $productos = $this->productos->listar_productos();
            $cate = $this->categorias->listar_categoria();
            $opciones = $this->submenu->optiones_por_vista("gestionar_productos");
            $tipoAfectacion = DB::table('tipo_afectacion')->get();
            return view('logistica/gestionar_productos', compact('opciones','cate','productos','tipoAfectacion'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }
    public function compras()
    {
        try {
//            ESTE IF ES PARA VERIFICAR SI ESE ROL TIENE EL PERMISO PARA LA VISTA
            $proveedores = $this->proveedores->listar_proveedores();
            $tipo_venta = $this->tipo_venta->listar_tipo_venta();
            $tipo_pago = $this->tipo_pago->listar_tipo_pago();
            $cate = $this->categorias->listar_categoria();
            $opciones = $this->submenu->optiones_por_vista("compras");
            return view('logistica/compras', compact('opciones','cate','proveedores','tipo_venta','tipo_pago'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }
    public function ordenCompraDetalle()
    {
        try {
            $id = $_GET['ordenCompra'];
            if ($id){
                $orden_compra = $this->ordenCompra->datos_orden_compra($id);
                $detalle_orden_compra = $this->ordenCompraDetalle->listar_detalle_compra($id);
                $total = 0;
                foreach($detalle_orden_compra as $d){
                    $total+=$d->detalle_compra_total_pedido;
                }
                $empresa = $this->empresa->listar_datos_empresa();
                $opciones = $this->submenu->optiones_por_vista("ordenCompraDetalle");
                return view('logistica/ordenCompraDetalle', compact('opciones','orden_compra','detalle_orden_compra','total','empresa'));

            }else{
                echo "<script>
                    alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                    window.location.href = '" . route('admin') . "';
                </script>";
            }

        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }
    public function compras_pdf()
    {
        try {
            $id = $_GET['ordenCompra'];
            if ($id){
                $datos = $this->ordenCompra->datos_facturas_pdf($id);
                $orden_compra = $this->ordenCompra->datos_orden_compra($id);
                $detalle_orden = $this->ordenCompraDetalle->listar_detalle_compra($id);
                $empresa = $this->empresa->listar_datos_empresa();
                $contacto = $this->contacto->listar_contacto();
                $guardar_localmente = true;
                $total = 0;
                foreach($detalle_orden as $d){
                    $total+=$d->detalle_compra_total_pedido;
                }
                $pdf = new FPDF('P');
                $pdf->SetMargins(5, 7, 5);
                $pdf->AddPage();
                $pdf->AliasNbPages();
                $pdf->SetFillColor(220, 220, 220);
                //CABECERA DEL ARCHIVO
                if (file_exists($empresa->empresa_foto)) {
                    $pdf->Image("$empresa->empresa_foto", 27, 5, 45,30);
                }
                $pdf->Ln(5);
                $pdf->SetFont('Arial','B',20);
                $pdf->Cell(110);
                if($orden_compra->orden_compra_tipo_doc != 'RECIBO POR HONORARIOS'){
                    $pdf->Cell(70,6,'ORDEN DE COMPRA',0,1,'R',false);
                }else{
                    $pdf->Cell(75,6,'RECIBO POR HONORARIOS',0,1,'C',false);
                }
                $pdf->Ln(2);
                $pdf->SetFont('Arial','',10);
                $pdf->Cell(120);
                $pdf->Cell(15,6,'FECHA',0,0,'R',false);
                $pdf->Cell(5);
                $pdf->Cell(30,6,date('d-m-Y'),1,1,'C',false);

                $pdf->SetFont('Arial','',10);
                $pdf->Cell(120);
                $pdf->Cell(15,6,'OC #',0,0,'R',false);
                $pdf->Cell(5);
                $pdf->Cell(30,6,$datos->orden_compra_numero,1,1,'C',false);
                $pdf->Ln(5);
                //DATOS DE LA EMPRESA
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(30,5,'RAZON SOCIAL',0,0,'L',false);
                $pdf->Cell(2,5,':',0,0,'R',false);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(150,5,$empresa->empresa_razon_social,0,1,'L',false);
                $pdf->Ln(2);
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(30,5,'DIRECCION',0,0,'L',false);
                $pdf->Cell(2,5,':',0,0,'R',false);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(150,5,$empresa->empresa_domiciliofiscal,0,1,'L',false);
                $pdf->Ln(2);
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(30,5,'TELEFONO',0,0,'L',false);
                $pdf->Cell(2,5,':',0,0,'R',false);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(150,5,$contacto[5]->contacto_valor.' - '.$contacto[6]->contacto_valor ,0,1,'L',false);
                $pdf->Ln(2);
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(30,5,'CORREOS',0,0,'L',false);
                $pdf->Cell(2,5,':',0,0,'R',false);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(150,5,$contacto[9]->contacto_valor.' - '.$contacto[10]->contacto_valor ,0,1,'L',false);
                $pdf->Ln(5);
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(24,5,'SOLICITANTE',0,0,'L',false);
                $pdf->Cell(2,5,': ',0,0,'L',false);
                $pdf->SetFont('Arial','',8);
                $pdf->MultiAlignCell(95,5,$orden_compra->nombre_users,0,0,'L',false);
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(35,5,utf8_decode('F. EMISIÓN'),0,0,'L',false);
                $pdf->Cell(2,5,': ',0,0,'L',false);
                $pdf->SetFont('Arial','',8);
                $pdf->MultiAlignCell(30,5,date("d-m-Y",strtotime($orden_compra->orden_compra_fecha_emision_doc)),0,1,'L',false);

                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(24,5,'PROVEEDOR',0,0,'L',false);
                $pdf->Cell(2,5,': ',0,0,'L',false);
                $pdf->SetFont('Arial','',8);
                $pdf->MultiAlignCell(95,5,utf8_decode($orden_compra->proveedores_nombre),0,0,'L',false);
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(35,5,'NRO. COMPROBANTE',0,0,'L',false);
                $pdf->Cell(2,5,': ',0,0,'L',false);
                $pdf->SetFont('Arial','',8);
                $pdf->MultiAlignCell(30,5,$orden_compra->orden_compra_numero_doc,0,1,'L',false);
//                if ($orden_compra->orden_compra_tipo_doc != 'RECIBO POR HONORARIOS'){
//                    $pdf->SetFont('Arial','B',9);
//                    $pdf->Cell(24,5,'',0,0,'L',false);
//                    $pdf->Cell(2,5,'',0,0,'L',false);
//                    $pdf->SetFont('Arial','',8);
//                    $pdf->MultiAlignCell(95,5,'',0,0,'L',false);
//                    $pdf->SetFont('Arial','B',9);
//                    $pdf->Cell(35,5,'G. OPERATIVOS S/',0,0,'L',false);
//                    $pdf->Cell(2,5,': ',0,0,'L',false);
//                    $pdf->SetFont('Arial','',8);
//                    $pdf->MultiAlignCell(30,5,$orden_compra->orden_compra_gastos_operativos,0,1,'L',false);
//
//                    $pdf->SetFont('Arial','B',9);
//                    $pdf->Cell(24,5,'',0,0,'L',false);
//                    $pdf->Cell(2,5,' ',0,0,'L',false);
//                    $pdf->SetFont('Arial','',8);
//                    $pdf->MultiAlignCell(95,5,'',0,0,'L',false);
//                    $pdf->SetFont('Arial','B',9);
//                    $pdf->Cell(35,5,'FLETE S/.',0,0,'L',false);
//                    $pdf->Cell(2,5,': ',0,0,'L',false);
//                    $pdf->SetFont('Arial','',8);
//                    $pdf->MultiAlignCell(30,5,$orden_compra->orden_compra_flete,0,1,'L',false);
//                }

                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(24,5,'SUCURSAL',0,0,'L',false);
                $pdf->Cell(2,5,': ',0,0,'L',false);
                $pdf->SetFont('Arial','',8);
                $pdf->MultiAlignCell(95,5,$empresa->empresa_nombrecomercial,0,0,'L',false);

                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(35,5,'TOTAL S/. ',0,0,'L',false);
                $pdf->Cell(2,5,': ',0,0,'L',false);
                $pdf->SetFont('Arial','',8);
                $pdf->MultiAlignCell(30,5,$total,0,1,'L',false);


                //CABECERA DEL DETALLE DE LOS ITEMS DE LA ORDEN DE COMPRA
                if($orden_compra->orden_compra_tipo_doc != 'RECIBO POR HONORARIOS'){
                    $pdf->Ln(5);
                    $pdf->SetFont('Helvetica','B',7);
                    $pdf->Cell(8, 6, '#', 1,'','C',1);
                    $pdf->Cell(90, 6, 'RECURSO',1,0,'C',1);
                    $pdf->Cell(35, 6, 'CANT. SOLICITADA', 1,0,'C',1);
                    $pdf->Cell(30, 6, 'PRECIO COMPRA',1,0,'C',1);
//                    $pdf->Cell(15, 6, 'PESO',1,0,'C',1);
//                    $pdf->Cell(15, 6, 'FLETE',1,0,'C',1);
//                    $pdf->Cell(15, 6, 'GASTO',1,0,'C',1);
                    $pdf->Cell(25, 6, 'TOTAL',1,1,'C',1);
                    //CUERPO DEL DETALLE DE LOS ITEMS DE LA ORDEN DE COMPRA
                    $pdf->SetWidths(array(8,90,35,30,25));
                    $aa=1;
                    foreach ($detalle_orden as $f){
                        $pdf->SetFont('Helvetica', '', 7);
                        $pdf->Row(array($aa,$f->detalle_orden_nombre_producto, $f->detalle_compra_cantidad,$f->detalle_compra_precio_compra,number_format(round("$f->detalle_compra_total_pedido",2), 2, '.', ' ')));
                        $aa++;
                    }
                }else{
                    $pdf->Ln(5);
                    $pdf->SetFont('Helvetica','B',7);
                    $pdf->Cell(8, 6, '#', 1,'','C',1);
                    $pdf->Cell(85, 6, utf8_decode('DESCRIPCIÓN'),1,0,'C',1);
                    $pdf->Cell(30, 6, 'CANT. SOLICITADA', 1,0,'C',1);
                    $pdf->Cell(30, 6, 'PRECIO UNIT',1,0,'C',1);
                    $pdf->Cell(25, 6, 'TOTAL',1,1,'C',1);

                    $pdf->SetWidths(array(8,85,30,30,25));
                    $aa=1;
                    foreach ($detalle_orden as $f){
                        $pdf->SetFont('Helvetica', '', 7);
                        $pdf->Row(array($aa,$f->detalle_orden_nombre_producto, $f->detalle_compra_cantidad,$f->detalle_compra_precio_compra,number_format(round("$f->detalle_compra_total_pedido",2), 2, '.', ' ')));
                        $aa++;
                    }
                }



                if(isset($guardar_localmente) && isset($ruta_guardado)){
                    $ruta_guardado = 'ordencompra/filepdf/'."compra_".date('Y-m-d').'.pdf';
                    $pdf->Output("I",$ruta_guardado);
                } else {
                    $pdf->Output('',"" .date('Y-m-d'));
                }
                exit;

            }else{
                echo "<script>
                    alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                    window.location.href = '" . route('admin') . "';
                </script>";
            }

        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }


    public function guardar_producto(Request $request)
    {
        try {
            $result = 2;
            $message = "Ha ocurrido un error.";
            if($request->estadoActionFuctionProductos == 1){
                $validar = $this->productos->buscar_codigo_repe($request->pro_codigo);
                if(!$validar){
                        if($request->hasFile('pro_foto') != null ){
                        $fi = $request->file('pro_foto');
                        $lugardestino = 'productos/';
                        $foto_productos =  $this->general->convertir_webp($fi,$lugardestino);

                        if ($request->tipoAfectacion == 1){
                            /* GRAVADA*/
                            $valorunit = (($request->pro_precio_uni / 1.18));
                            $valormayo = (($request->pro_precio_uni_ma / 1.18));
                        }else{
                            /* OTROS*/
                            $valorunit = $request->pro_precio_uni;
                            $valormayo = $request->pro_precio_uni_ma;
                        }

                        $guardar = DB::table('productos')->insert([
                            'id_ca'=>$request->id_ca,
                            'id_medida'=>$request->unidadMedida,
                            'id_tipo_afectacion'=>$request->tipoAfectacion,
                            'pro_nombre'=>$request->pro_nombre,
                            'pro_codigo'=>$request->pro_codigo,
                            'pro_descripcion'=>$request->pro_descripcion,
                            'pro_presentacion'=>$request->pro_presentacion,
                            'pro_medida'=>$request->pro_medida,
                            'pro_precio_valor'=>$valorunit,
                            'pro_precio_uni'=>$request->pro_precio_uni,
                            'pro_precio_valor_ma'=>$valormayo,
                            'pro_precio_uni_ma'=>$request->pro_precio_uni_ma,
                            'pro_porcen_igv'=>$request->tipoAfectacion == 1 ? 1.18 : 0,
                            'pro_stock'=>0,
                            'pro_foto'=>$foto_productos,
                            'pro_estado'=>1,
                            'impuesto_bolsa'=>$request->has('impuesto_bolsa') ? 1 : 0,
                            'control_serie' => $request->has('control_serie') ? 1 : 0,
                            'control_lote'  => $request->has('control_lote')  ? 1 : 0,
                        ]);
                        $result = $guardar ? 1 : 2;
                        $message = "¡Registro guardado exitoso!";
                    }else{
                        $result = 3;
                        $message = "Debe ingresar una imagen para el producto";
                    }
                }else{
                    $result = 3;
                    $message = "Ya hay un productos registrado con el código proporcionado.";

                }
            }elseif($request->estadoActionFuctionProductos == 2){
                $validar = $this->productos->buscar_codigo_repe($request->pro_codigo,$request->id_pro);
                if(!$validar){
                    $datos_actuales = $this->productos->datos_productos($request->id_pro);
                    if($request->hasFile('pro_foto') != null ){
                        if (file_exists($datos_actuales->pro_foto)){
                            try{
                                unlink($datos_actuales->pro_foto);
                            }catch  (\Exception $e){}
                        }

                        $fi = $request->file('pro_foto');
                        $lugardestino = 'productos/';
                        $foto_productos = $this->general->convertir_webp($fi ,$lugardestino);
                    }else{
                        $foto_productos = $datos_actuales->pro_foto;
                    }
                    if ($request->tipoAfectacion == 1){
                        /* GRAVADA*/
                        $valorunit = (($request->pro_precio_uni / 1.18));
                        $valormayo = (($request->pro_precio_uni_ma / 1.18));
                    }else{
                        /* OTROS*/
                        $valorunit = $request->pro_precio_uni;
                        $valormayo = $request->pro_precio_uni_ma;
                    }
                    $actualizar = DB::table('productos')->where('id_pro','=',$request->id_pro)->update([
                        'id_ca'=>$request->id_ca,
                        'id_medida'=>$request->unidadMedida,
                        'id_tipo_afectacion'=>$request->tipoAfectacion,
                        'pro_nombre'=>$request->pro_nombre,
                        'pro_codigo'=>$request->pro_codigo,
                        'pro_descripcion'=>$request->pro_descripcion,
                        'pro_presentacion'=>$request->pro_presentacion,
                        'pro_medida'=>$request->pro_medida,
                        'pro_precio_valor'=>$valorunit,
                        'pro_precio_uni'=>$request->pro_precio_uni,
                        'pro_precio_valor_ma'=>$valormayo,
                        'pro_precio_uni_ma'=>$request->pro_precio_uni_ma,
                        'pro_porcen_igv'=>$request->tipoAfectacion == 1 ? 1.18 : 0,
                        'pro_foto'=>$foto_productos,
                        'impuesto_bolsa'=>$request->has('impuesto_bolsa') ? 1 : 0,
                        'control_serie' => $request->has('control_serie') ? 1 : 0,
                        'control_lote'  => $request->has('control_lote')  ? 1 : 0,
                    ]);
                    $result = $actualizar == 1 || $actualizar == 0 ? 1 : 2;
                    $message = "¡Registro actualizado exitoso!";
                }else{
                    $result = 3;
                    $message = "Ya hay un productos registrado con el código proporcionado.";
                }
            }else{
                $datos_actuales = $this->productos->datos_productos($request->id_pro);
                if (file_exists($datos_actuales->pro_foto)){
                    try{
                        unlink($datos_actuales->pro_foto);
                    }catch  (\Exception $e){}
                }
                $delete = DB::table('productos')->where('id_pro','=',$request->id_pro)->update(['pro_estado'=>0]);
                $result = $delete ?1:2;
                $message = "¡Registro eliminado exitoso!";
            }
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));
    }
    public function crear_orden_compra(Request $request)
    {
        try {
            $result = 2;
            $message = "Ha ocurrido un error.";
            if($request->estadoActionFuctionOrdenCompra == 1){
                $datos = json_decode($request->datos);
                $microtine = microtime(true);
                $fecha = date('Y-m-d H:i:s');
                $id_users = Auth::id();

                if(count($datos) > 0){
                    $numero_orden = DB::table('orden_compra')->where('orden_compra_estado','<>',0)->orderBy('orden_compra_numero','desc')->limit(1)->first();
                    if(isset($numero_orden->id_orden_compra)){
                        $orden_compra_numero = $numero_orden->orden_compra_numero + 1;
                    }else{
                        $orden_compra_numero = 100001;
                    }
                    if($_FILES['adjuntar_foto']['name'] != null) {
                        //Conseguimos la extension del archivo y especificamos la ruta
                        $fi = $request->file('adjuntar_foto');
                        $lugardestino = 'ordenCompra/';
                        $fotoDocumento =  $this->general->guardar_documento($fi,$lugardestino);
                    }else {
                        $fotoDocumento = 'sin-fotografia.png';
                    }
                    if($request->id_tipo_venta == 1){
                        $tipoVe = "BOLETA";
                    }elseif($request->id_tipo_venta == 2){
                        $tipoVe = "FACTURA";
                    }elseif($request->id_tipo_venta == 3){
                        $tipoVe = "NOTA DE VENTA";
                    }elseif($request->id_tipo_venta == 4){
                        $tipoVe = "HOJA DE LIQUIDACION";
                    }else{
                        $tipoVe = "RECIBO POR HONORARIOS";
                    }
                    $guardar_orden = DB::table('orden_compra')->insert([
                        'id_solicitante'=>Auth::id(),
                        'id_aprobacion'=>Auth::id(),
                        'id_proveedores'=>$request->id_proveedores,
                        'id_sede'=>1,
                        'id_tipo_pago'=>$request->id_tipo_pago,
//                        'id_almacen'=>$request->id_almacen,
                        'orden_compra_fecha_aprob'=>$fecha,
                        'orden_compra_activo'=>0,
                        'orden_compra_titulo'=>"Registro de Compra",
                        'orden_compra_numero'=>$orden_compra_numero,
                        'orden_compra_estado'=>1,
                        'orden_compra_fecha'=>$fecha,
                        'orden_compra_observacion'=>$request->observaciones_orden_compra != null ? $request->observaciones_orden_compra : "---",
                        'orden_compra_tipo_doc'=>$tipoVe,
                        'orden_compra_numero_doc'=>$request->num_documento_,
                        'orden_compra_doc_adjuntado'=>$fotoDocumento,
                        'orden_compra_fecha_emision_doc'=>$request->fecha_emision,
                        'orden_compra_doc_cuotas'=>null,
                        'orden_compra_fecha_recibida'=>$fecha,
                        'orden_compra_usuario_recibido'=>$id_users,
                        'orden_compra_codigo'=>$microtine,
                        'orden_compra_total'=>$request->total,
//                        'orden_compra_flete'=>$request->total_flete,
//                        'orden_compra_gastos_operativos'=>$request->gastos_op,
                    ]);
                    if ($guardar_orden){
                        $id_orden_compra = DB::table('orden_compra')->where('orden_compra_codigo','=',$microtine)->first();
                        foreach ($datos as $d){
                            $detalle = DB::table('orden_compra_detalle')->insert([
                                'id_orden_compra'=>$id_orden_compra->id_orden_compra,
                                'id_pro'=>$d->id_pro,
                                'detalle_orden_nombre_producto'=>$d->producto_nombre,
                                'detalle_compra_cantidad'=>$d->cantidad,
                                'detalle_compra_cantidad_recibida'=>$d->cantidad,
                                'detalle_compra_precio_compra'=>$d->producto_precio_unit,
                                'detalle_compra_total_pedido'=>$d->precio_total,
                                'detalle_compra_total_pagado'=>$d->precio_total,
                                'detalle_compra_estado'=>1,
                            ]);
                            // vamos a actualizar el stock del producto.
                            /*$datos_productos = DB::table('productos')->where('id_pro','=',$d->id_pro)->first();
                            if ($datos_productos){
                                $nuevo_stock = $datos_productos->pro_stock + $d->cantidad;
                                DB::table('productos')->where('id_pro','=',$d->id_pro)->update(['pro_stock'=>$nuevo_stock]);
                            }*/

                            $producto = DB::table('productos')->where('id_pro', $d->id_pro)->first();

                            // Registrar series si el producto las controla
                            if ($producto->control_serie && !empty($d->series)) {
                                foreach ($d->series as $s) {
                                    Series::create([
                                        'id_pro'           => $d->id_pro,
                                        'numero_serie'     => $s->numero_serie,
                                        'numero_motor'     => $s->numero_motor  ?? null,
                                        'color'            => $s->color         ?? null,
                                        'anio_fabricacion' => $s->anio          ?? null,
                                        'estado'           => 'disponible',
                                        'id_orden_compra'  => $id_orden_compra->id_orden_compra,
                                        'observaciones'    => $s->observaciones ?? null,
                                    ]);
                                }
                            }

                            // Registrar lotes si el producto los controla
                            if ($producto->control_lote && !empty($d->lotes)) {
                                foreach ($d->lotes as $l) {
                                    Lotes::create([
                                        'id_pro'           => $d->id_pro,
                                        'numero_lote'      => $l->numero_lote,
                                        'fecha_vencimiento'=> $l->fecha_vencimiento ?? null,
                                        'cantidad'         => $l->cantidad,
                                        'observaciones'    => $l->observaciones ?? null,
                                        'estado'           => 'disponible',
                                        'id_orden_compra'  => $id_orden_compra->id_orden_compra,
                                    ]);
                                }
                            }

                            // Actualizar stock según el tipo de control
                            if ($producto->control_serie || $producto->control_lote) {
                                $nuevoStock = 0;
                                if ($producto->control_serie) {
                                    $nuevoStock += Series::stockDisponible($d->id_pro);
                                }
                                if ($producto->control_lote) {
                                    $nuevoStock += Lotes::stockDisponible($d->id_pro);
                                }
                            } else {
                                $nuevoStock = $producto->pro_stock + $d->cantidad;
                            }
                            DB::table('productos')->where('id_pro', $d->id_pro)
                                ->update(['pro_stock' => $nuevoStock]);
                        }
                        $result = $detalle ? 1 : 2;
                        if($result == 1){
                            $message = "¡Registro guardado exitoso!";
                        }
                    }
                }else{
                    $result = 3;
                    $message = "Debe ingresar 1 producto como mínimo.";
                }
            }elseif($request->estadoActionFuctionOrdenCompra == 2){
                $result = 1;
                $message = "¡Registro actualizado exitoso!";
            }else{

                $message = "¡Registro eliminado exitoso!";
            }
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));
    }
    public function eliminar_orden_compra(Request $request)
    {
        try {
            $result = 2;
            $message = "Ha ocurrido un error.";

            $idOrdenCompra = $request->id;
            if ($idOrdenCompra){

                $ordenCompra = Orden_compra::find($idOrdenCompra);
                $ordenCompra->orden_compra_estado = 0;
                if ($ordenCompra->save()){
                    $result = 1;

                    $detalles = DB::table('orden_compra_detalle')->where('id_orden_compra','=',$idOrdenCompra)->get();
                    foreach ($detalles as $de){
                        if ($result == 1){
                            $producto = DB::table('productos')->where('id_pro','=',$de->id_pro)->first();

                            if ($producto->control_serie || $producto->control_lote) {
                                // Eliminar series/lotes de esta orden y recalcular stock
                                if ($producto->control_serie) {
                                    Series::where('id_orden_compra', $idOrdenCompra)
                                          ->where('id_pro', $de->id_pro)
                                          ->delete();
                                }
                                if ($producto->control_lote) {
                                    Lotes::where('id_orden_compra', $idOrdenCompra)
                                         ->where('id_pro', $de->id_pro)
                                         ->delete();
                                }
                                $nuevoStock = 0;
                                if ($producto->control_serie) $nuevoStock += Series::stockDisponible($de->id_pro);
                                if ($producto->control_lote)  $nuevoStock += Lotes::stockDisponible($de->id_pro);
                                if (!Productos::where('id_pro', $de->id_pro)->update(['pro_stock' => $nuevoStock])) {
                                    $result = 2;
                                }
                            } else {
                                $updateProducto = Productos::find($de->id_pro);
                                $updateProducto->pro_stock = max(0, $producto->pro_stock - $de->detalle_compra_cantidad);
                                if (!$updateProducto->save()) {
                                    $result = 2;
                                }
                            }
                        }
                    }
                    if ($result == 1){
                        $message = "Orden de Compra eliminado correctamente.";
                    }
                }else{
                    $message = "No se puedo eliminar la orden de compra.";
                }
            }
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));
    }


    public function listar_datos_productos( Request $request){
        try {
            $result = 2;
            $message = "";
            $result =  $this->productos->datos_productos($request->id_pro);

        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));

    }
    public function buscador_productos( Request $request){
        try {
            $result = 2;
            $message = "";
            $result =  $this->productos->sin_bolsa($request->valor,$request->medida);
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));

    }
    public function historial_orden_compra( Request $request){
        try {
            $result = 2;
            $message = "";
            $datos =  DB::table('orden_compra as oc')
                ->join('proveedores as p','p.id_proveedores','=','oc.id_proveedores')
                ->join('tipo_pago as tp','tp.id_tipo_pago','=','oc.id_tipo_pago')
                ->where('oc.orden_compra_estado','=',1);
                if ($request->id_prove){
                    $datos->where('p.id_proveedores','=',$request->id_prove);
                }
            if ($request->desde and $request->hasta){
                $datos->whereBetween(DB::raw('date(orden_compra_fecha)'), [$request->desde, $request->hasta]);
//                $result->where('oc.orden_compra_fecha_emision_doc','=',$request->id_prove);
            }
            $result = $datos->orderBy('oc.id_orden_compra','desc')->get();
            foreach ($result as $r){
                $r->total = DB::table('orden_compra_detalle')->where('id_orden_compra','=',$r->id_orden_compra)->sum('detalle_compra_total_pedido');
            }

        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));

    }
    public function orden_compra_historial_excel( Request $request,$proveedor = null,$fecha_inicio,$fecha_cierre){
        try {

            $query = DB::table('orden_compra as od')
                ->join('tipo_pago as tp','tp.id_tipo_pago','=','od.id_tipo_pago')
                ->join('proveedores as pv','pv.id_proveedores','=','od.id_proveedores')
//                ->join('almacen as a','a.id_almacen','=','od.id_almacen')
                ->where('od.orden_compra_estado','=',1);

            if($proveedor != 0 ){
                $query->where('od.orden_compra_num_document','like','%' . $proveedor . '%');
            }

            if(isset($fecha_inicio,$fecha_cierre)){
                $query->whereDate('od.orden_compra_fecha','>=',$fecha_inicio)
                    ->whereDate('od.orden_compra_fecha','<=',$fecha_cierre);
            }
            $datos = $query->orderBy('od.id_orden_compra','asc')->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $mensaje = "RESULTADO DE LA BUSQUEDA : ";
            if($proveedor != 0 ){
                $mensaje .= "RUC: ".$proveedor;
            }
            if(isset($fecha_inicio,$fecha_cierre)){
                $mensaje.= "DEL ".date("d-m-Y",strtotime($fecha_inicio))." HASTA :".date("d-m-Y",strtotime($fecha_cierre));
            }
            // Agregar título en negritas
            $sheet->setCellValue('A1', $mensaje);
            $titleStyle = $sheet->getStyle('A1');
            $titleStyle->getFont()->setSize(16); // Tamaño de letra 14
            $titleStyle->getFont()->setBold(true); // Hacer el título en negritas

            // Combinar celdas para el título
            $sheet->mergeCells('A1:M1');
            // Agregar datos a las celdas para la cabecera
            $sheet->setCellValue('A2', '#');
            $sheet->setCellValue('B2', 'FECHA DE EMISIÓN');
            $sheet->setCellValue('C2', 'PROVEEDOR');
            $sheet->setCellValue('D2', 'NRO.DOCUMENTO');
            $sheet->setCellValue('E2', 'TIPO DE VENTA');
            $sheet->setCellValue('F2', 'TIPO DE PAGO');

            $sheet->setCellValue('G2', '');
            $sheet->setCellValue('H2', 'NRO.COMPROBANTE');
            $sheet->setCellValue('I2', 'NRO.ORDEN');

            $sheet->setCellValue('J2', 'OBSERVACIÓN');
//            $sheet->setCellValue('K2', 'FLETE');
//            $sheet->setCellValue('L2', 'G.OPERATIVOS');
            $sheet->setCellValue('K2', 'TOTAL');

            // Establecer el ancho de las columnas A a G
            $sheet->getColumnDimension('A')->setWidth(5); // Ancho de la columna A
            $sheet->getColumnDimension('B')->setWidth(24); // Ancho de la columna B
            $sheet->getColumnDimension('C')->setWidth(30); // Ancho de la columna C
            $sheet->getColumnDimension('D')->setWidth(22); // Ancho de la columna D
            $sheet->getColumnDimension('E')->setWidth(18); // Ancho de la columna E
            $sheet->getColumnDimension('F')->setWidth(18); // Ancho de la columna F
            $sheet->getColumnDimension('G')->setWidth(1); // Ancho de la columna G
            $sheet->getColumnDimension('H')->setWidth(25); // Ancho de la columna G
            $sheet->getColumnDimension('I')->setWidth(18); // Ancho de la columna G
            $sheet->getColumnDimension('J')->setWidth(18); // Ancho de la columna G
            $sheet->getColumnDimension('K')->setWidth(12); // Ancho de la columna G
//            $sheet->getColumnDimension('L')->setWidth(20); // Ancho de la columna G
//            $sheet->getColumnDimension('M')->setWidth(12); // Ancho de la columna G
            // Obtener la fila 1 completa (desde A hasta G) como un rango
            $cellRange = 'A2:K2';
            $rowStyle = $sheet->getStyle($cellRange);
            // Establecer el fondo, tamaño de letra y hacer negritas en toda la fila 1 y cambiar color del texto
            $rowStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('399630'); // Fondo
            $rowStyle->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); // color de texto
            $rowStyle->getFont()->setSize(14); // Tamaño de letra 14
            $rowStyle->getFont()->setBold(true); // Hacer negritas
            // contenido de la table
            $row = 3; // Empieza a partir de la terce fila (fila 2 es para encabezados)
            $conteo = 1;
            $total = 0;
            foreach ($datos as $item) {
                $sheet->setCellValue('A' . $row, $conteo);
                $sheet->setCellValue('B' . $row, $item->orden_compra_fecha_emision_doc);
                $sheet->setCellValue('C' . $row, $item->proveedores_nombre);
                $sheet->setCellValue('D' . $row, $item->proveedores_numero_documento);
                $sheet->setCellValue('E' . $row, $item->orden_compra_tipo_doc);
                $sheet->setCellValue('F' . $row, $item->tipo_pago_nombre);

                $sheet->setCellValue('G' . $row, '');
                $sheet->setCellValue('H' . $row, $item->orden_compra_numero_doc);
                $sheet->setCellValue('I' . $row, $item->orden_compra_numero);

                $sheet->setCellValue('J' . $row, $item->orden_compra_observacion);
                $sheet->setCellValue('k' . $row, $item->orden_compra_total);
//                $sheet->setCellValue('L' . $row, $item->orden_compra_gastos_operativos);
//                $sheet->setCellValue('M' . $row, +$item->orden_compra_flete+$item->orden_compra_gastos_operativos);

                $row++; // Moverse a la siguiente fila
                $conteo++;
                $total = $total +$item->orden_compra_total;
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
            $sheet->setCellValue('J' . $row, 'TOTAL');
            $sheet->setCellValue('k' . $row, $total);
//            $sheet->setCellValue('L' . $row, '');
//            $sheet->setCellValue('M' . $row, );
            // Crear una respuesta (response) para el archivo Excel
            $response = response()->stream(
                function () use ($spreadsheet) {
                    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                    $writer->save('php://output');
                },
                200,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename=mi_archivo_excel.xlsx',
                ]
            );

            return $response;
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
        }

    }

    // ─────────────────────────────────────────────────────────────────────
    //  MÓDULO GUÍAS DE REMISIÓN
    // ─────────────────────────────────────────────────────────────────────

    public function guias_remision()
    {
        try {
            $opciones = $this->submenu->optiones_por_vista('guias_remision');
            //$opciones = $this->submenu->optiones_por_vista("compras");
            $pendientes = DB::table('guia_remision')->where('guia_estado_sunat', 0)->count();
            return view('logistica/guias_remision', compact('opciones', 'pendientes'));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>alert('Error al cargar el módulo.'); window.location.href='" . route('admin') . "';</script>";
        }
    }

    public function generar_guia(Request $request)
    {
        try {
            $empresas   = DB::table('empresa')->get();
            $clientes   = DB::table('clientes')->where('cliente_estado', 1)->get();
            $ubigeos    = DB::table('ubigeo')->orderBy('ubigeo_departamento')->get();
            $opciones   = $this->submenu->optiones_por_vista('generar_guia');
            $tipo_docs  = DB::table('tipo_documento')->get();

            return view('logistica/generar_guia', compact('opciones', 'empresas', 'clientes', 'ubigeos', 'tipo_docs'));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>alert('Error al cargar el formulario.'); window.location.href='" . route('admin') . "';</script>";
        }
    }

    public function guardar_guia(Request $request)
    {
        try {
            $id_empresa = $request->input('id_empresa');
            $guia_tipo  = $request->input('guia_tipo');

            // Serie y correlativo automático
            $prefijo     = $guia_tipo === '09' ? 'T001' : 'V001';
            $ultimo_corr = DB::table('guia_remision')
                ->where('id_empresa', $id_empresa)
                ->where('guia_tipo', $guia_tipo)
                ->where('guia_serie', $prefijo)
                ->max('guia_correlativo');
            $correlativo = $ultimo_corr ? intval($ultimo_corr) + 1 : 1;

            $id_guia = DB::table('guia_remision')->insertGetId([
                'id_empresa'                   => $id_empresa,
                'id_clientes'                  => $request->input('id_clientes'),
                'id_venta'                     => $request->input('id_venta') ?: null,
                'id_users'                     => Auth::id(),
                'guia_tipo'                    => $guia_tipo,
                'guia_serie'                   => $prefijo,
                'guia_correlativo'             => str_pad($correlativo, 8, '0', STR_PAD_LEFT),
                'guia_emision'                 => date('Y-m-d'),
                'guia_fecha_traslado'          => $request->input('guia_fecha_traslado'),
                'guia_motivo'                  => $request->input('guia_motivo'),
                'guia_tipo_trans'              => $request->input('guia_tipo_trans'),
                'guia_unidad_medida'           => $request->input('guia_unidad_medida', 'KGM'),
                'guia_peso_bruto'              => $request->input('guia_peso_bruto', 0),
                'guia_n_bulto'                 => $request->input('guia_n_bulto', 1),
                'guia_placa'                   => $request->input('guia_placa'),
                'guia_carreta'                 => $request->input('guia_carreta'),
                'vehiculo_marca'               => $request->input('vehiculo_marca'),
                'guia_certificado_mtc'         => $request->input('guia_certificado_mtc'),
                'guia_licencia_conductor'      => $request->input('guia_licencia_conductor'),
                'guia_conductor_nombre'        => $request->input('guia_conductor_nombre'),
                'guia_conductor_apellidos'     => $request->input('guia_conductor_apellidos'),
                'guia_conductor_documento_tipo'=> $request->input('guia_conductor_documento_tipo', '1'),
                'guia_conductor_numero'        => $request->input('guia_conductor_numero'),
                'guia_tipo_doc_trans'          => $request->input('guia_tipo_doc_trans'),
                'guia_num_doc_trans'           => $request->input('guia_num_doc_trans'),
                'guia_denominacion'            => $request->input('guia_denominacion'),
                'guia_denominacion_desti'      => $request->input('guia_denominacion_desti'),
                'guia_direccion_desti'         => $request->input('guia_direccion_desti'),
                'guia_num_doc_desti'           => $request->input('guia_num_doc_desti'),
                'guia_tipo_doc_desti'          => $request->input('guia_tipo_doc_desti'),
                'guia_direccion_part'          => $request->input('guia_direccion_part'),
                'guia_ubigeo_part'             => $request->input('guia_ubigeo_part'),
                'guia_direccion_llega'         => $request->input('guia_direccion_llega'),
                'guia_ubigeo_llega'            => $request->input('guia_ubigeo_llega'),
                'guia_observacion'             => $request->input('guia_observacion'),
                'guia_estado_sunat'            => 0,
                'created_at'                   => now(),
                'updated_at'                   => now(),
            ]);

            // Guardar detalle
            $descripciones = $request->input('detalle_descripcion', []);
            $cantidades    = $request->input('detalle_cantidad', []);
            $pesos         = $request->input('detalle_peso', []);
            $ums           = $request->input('detalle_um', []);

            foreach ($descripciones as $i => $desc) {
                if (empty($desc)) continue;
                DB::table('guia_remision_detalle')->insert([
                    'id_guia'                           => $id_guia,
                    'guia_remision_detalle_descripcion' => $desc,
                    'guia_remision_detalle_cantidad'    => $cantidades[$i] ?? 1,
                    'guia_remision_peso'                => $pesos[$i] ?? 0,
                    'guia_remision_detalle_um'          => $ums[$i] ?? 'NIU',
                    'created_at'                        => now(),
                    'updated_at'                        => now(),
                ]);
            }

            return response()->json(['result' => 1, 'mensaje' => 'Guía creada correctamente.', 'id_guia' => $id_guia]);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response()->json(['result' => 2, 'mensaje' => 'Error al guardar la guía: ' . $e->getMessage()]);
        }
    }

    public function pendientes_guia(Request $request)
    {
        try {
            $filtro      = false;
            $guias       = collect();
            $guia_tipo   = '';
            $fecha_inicio = date('Y-m-d');
            $fecha_final  = date('Y-m-d');

            if ($request->isMethod('post') && $request->input('enviar_filtro')) {
                $filtro      = true;
                $guia_tipo   = $request->input('guia_tipo', '');
                $fecha_inicio = $request->input('fecha_inicio', date('Y-m-d'));
                $fecha_final  = $request->input('fecha_final', date('Y-m-d'));
                $guias = $this->guiaRemision->listar_guias_pendientes([
                    'guia_tipo'    => $guia_tipo,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_final'  => $fecha_final,
                ]);
            }

            $pendientes_total = DB::table('guia_remision')->where('guia_estado_sunat', 0)->count();
            $opciones = $this->submenu->optiones_por_vista('pendientes_guia');

            return view('logistica/pendientes_guia', compact(
                'opciones', 'guias', 'filtro', 'guia_tipo', 'fecha_inicio', 'fecha_final', 'pendientes_total'
            ));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>alert('Error al cargar pendientes.'); window.location.href='" . route('admin') . "';</script>";
        }
    }

    public function enviar_guia_sunat(Request $request)
    {
        try {
            $result  = 6;
            $baseUrl = env('URL_FACTU');
            $id_guia = $request->input('id_guia');

            $guia = DB::table('guia_remision as gr')
                ->join('clientes as c', 'gr.id_clientes', '=', 'c.id_clientes')
                ->join('tipo_documento as td', 'c.id_tipo_documento', '=', 'td.id_tipo_documento')
                ->where('gr.id_guia', $id_guia)
                ->first();

            if (!$guia) {
                return response()->json(['result' => 2, 'mensaje' => 'Guía no encontrada.']);
            }

            $empresa = DB::table('empresa')->where('id_empresa', $guia->id_empresa)->first();
            if (!$empresa) {
                return response()->json(['result' => 2, 'mensaje' => 'Empresa no encontrada.']);
            }

            $detalle = DB::table('guia_remision_detalle')->where('id_guia', $id_guia)->get();
            $venta   = null;
            if (!empty($guia->id_venta)) {
                $venta = DB::table('ventas')->where('id_venta', $guia->id_venta)->first();
            }

            $nombre           = $empresa->empresa_ruc . '-' . $guia->guia_tipo . '-' . $guia->guia_serie . '-' . $guia->guia_correlativo;
            $rutaDir          = 'ApiFacturacion/xml/';
            $ruta_archivo_cdr = 'ApiFacturacion/cdr/';
            $rutaXml          = $rutaDir . $nombre . '.XML';

            // 1) Generar XML sin firma
            GeneradorXML::CrearXmlGuiaRemision(
                public_path($rutaDir . $nombre),
                $empresa, $guia, $detalle, $venta
            );

            // 2) Obtener token QPSE
            $username    = env('USERS_EMPRESA_NAM');
            $password    = env('USERS_EMPRESA_PAS');
            $tokenAcceso = apiFacturacion::obtenerToken($baseUrl, $username, $password, true);

            // 3) Firmar XML vía QPSE (tipo_integracion: 2 para GRE)
            $firmarXml = apiFacturacion::FirmarXMLGuia($baseUrl, $tokenAcceso, $rutaXml, $nombre);

            DB::table('guia_remision')->where('id_guia', $id_guia)->update(['guia_rutaXML' => $rutaXml]);

            // 4) Enviar XML firmado a SUNAT vía QPSE
            $enviarXml = apiFacturacion::EnviarASunatPri($baseUrl, $tokenAcceso, $firmarXml['xml'], $nombre, true);

            if ($enviarXml['estado'] == 200) {
                $cdr_xml               = base64_decode($enviarXml['raw']['cdr'] ?? '');
                $nombre_xml_cdr        = 'R-' . $nombre . '.XML';
                $ruta_xml_cdr_absoluta = public_path($ruta_archivo_cdr . $nombre_xml_cdr);
                $ruta_xml_cdr_relativa = $ruta_archivo_cdr . $nombre_xml_cdr;

                if (!file_exists(dirname($ruta_xml_cdr_absoluta))) {
                    mkdir(dirname($ruta_xml_cdr_absoluta), 0755, true);
                }

                file_put_contents($ruta_xml_cdr_absoluta, $cdr_xml);

                $descripcion_respuesta = $enviarXml['mensaje'] ?? 'Aceptado por SUNAT';

                if (file_exists($ruta_xml_cdr_absoluta)) {
                    $xml_cdr = @simplexml_load_file($ruta_xml_cdr_absoluta);
                    if ($xml_cdr) {
                        $xml_cdr->registerXPathNamespace('c', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
                        $Description = $xml_cdr->xpath('//c:Description');
                        if (isset($Description[0])) {
                            $descripcion_respuesta = (string)$Description[0];
                        }
                    }
                }

                DB::table('guia_remision')->where('id_guia', $id_guia)->update([
                    'guia_estado_sunat'    => 1,
                    'guia_fecha_envio'     => now(),
                    'guia_respuesta_sunat' => $descripcion_respuesta,
                    'guia_rutaCDR'         => $ruta_xml_cdr_relativa,
                    'updated_at'           => now(),
                ]);

                $result = 1;
            }

            return response()->json($result);

        } catch (\Throwable $e) {
            $this->logs->insertarLog($e);
            return response()->json(['result' => 2, 'mensaje' => $e->getMessage()]);
        }
    }

    public function historial_guia(Request $request)
    {
        try {
            $filtro      = false;
            $guias       = collect();
            $guia_tipo   = '';
            $fecha_inicio = date('Y-m-d');
            $fecha_final  = date('Y-m-d');

            if ($request->isMethod('post') && $request->input('enviar_filtro')) {
                $filtro      = true;
                $guia_tipo   = $request->input('guia_tipo', '');
                $fecha_inicio = $request->input('fecha_inicio', date('Y-m-d'));
                $fecha_final  = $request->input('fecha_final', date('Y-m-d'));
                $guias = $this->guiaRemision->listar_guias_historial([
                    'guia_tipo'    => $guia_tipo,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_final'  => $fecha_final,
                ]);
            }

            $opciones = $this->submenu->optiones_por_vista('historial_guia');

            return view('logistica/historial_guia', compact(
                'opciones', 'guias', 'filtro', 'guia_tipo', 'fecha_inicio', 'fecha_final'
            ));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>alert('Error al cargar historial.'); window.location.href='" . route('admin') . "';</script>";
        }
    }

    public function eliminar_guia(Request $request)
    {
        try {
            $id_guia = $request->input('id_guia');
            $guia = DB::table('guia_remision')->where('id_guia', $id_guia)->first();
            if (!$guia || $guia->guia_estado_sunat == 1) {
                return response()->json(['result' => 2, 'mensaje' => 'No se puede eliminar una guía ya enviada a SUNAT.']);
            }
            DB::table('guia_remision_detalle')->where('id_guia', $id_guia)->delete();
            DB::table('guia_remision')->where('id_guia', $id_guia)->delete();
            return response()->json(['result' => 1, 'mensaje' => 'Guía eliminada correctamente.']);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response()->json(['result' => 2, 'mensaje' => 'Error: ' . $e->getMessage()]);
        }
    }














}
