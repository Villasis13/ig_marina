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
use App\Utils\CustomFpdf;
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
            $cate = $this->categorias->listar_categoria();
            $opciones = $this->submenu->optiones_por_vista("gestionar_productos");
            $tipoAfectacion = DB::table('tipo_afectacion')->get();
            $proveedores = $this->proveedores->listar_proveedores();
            $familias = DB::table('familias')->where('fa_estado', 1)->get();
            $monedas = DB::table('monedas')->where('activo', 1)->get();
            return view('logistica/gestionar_productos', compact('opciones','cate','tipoAfectacion','proveedores','familias','monedas'));
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
                $pdf = new CustomFpdf('P');
                $pdf->SetMargins(5, 7, 5);
                $pdf->AddPage();
                $pdf->AliasNbPages();
                $pdf->SetFillColor(220, 220, 220);
                //CABECERA DEL ARCHIVO
                if (file_exists($empresa->empresa_foto)) {
                    $pdf->Image("$empresa->empresa_foto", 20, 5, 70,32);
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


    public function importar_productos_excel(Request $request)
    {
        try {
            if (!$request->hasFile('archivo_excel')) {
                return json_encode(['result' => ['code' => 2, 'message' => 'No se recibió ningún archivo.']]);
            }

            $archivo     = $request->file('archivo_excel');
            $spreadsheet = IOFactory::load($archivo->getRealPath());
            $hoja        = $spreadsheet->getActiveSheet();

            $actualizados = 0;
            $no_encontrados = 0;
            $errores = [];
            $fila    = 4; // registros desde fila 4

            while (true) {
                $codigo        = trim((string) $hoja->getCell('A' . $fila)->getValue());
                $nombre        = trim((string) $hoja->getCell('C' . $fila)->getValue());
                $fa_codigo_val = trim((string) $hoja->getCell('F' . $fila)->getValue());

                // fin de datos si A y C están vacías
                if ($codigo === '' && $nombre === '') break;

                // fila incompleta
                if ($codigo === '' || $nombre === '') {
                    $errores[] = "Fila $fila: código o nombre vacío, se omitió.";
                    $fila++;
                    continue;
                }

                // buscar id_fa a partir del código de familia (celda F)
                $id_fa = null;
                if ($fa_codigo_val !== '') {
                    $familia = DB::table('familias')
                        ->where('fa_codigo', $fa_codigo_val)
                        ->where('fa_estado', 1)
                        ->first();
                    if ($familia) {
                        $id_fa = $familia->id_fa;
                    }
                }

                // buscar el producto por código (A) Y nombre (C)
                $producto = DB::table('productos')
                    ->where('pro_codigo', $codigo)
                    ->where('pro_nombre', $nombre)
                    ->where('pro_estado', 1)
                    ->first();

                if ($producto) {
                    // actualizar solo id_fa (null si no se encontró familia)
                    DB::table('productos')
                        ->where('id_pro', $producto->id_pro)
                        ->update([
                            'id_fa'      => $id_fa,
                            'updated_at' => now(),
                        ]);
                    $actualizados++;
                } else {
                    // producto no encontrado, se omite
                    $no_encontrados++;
                }

                $fila++;
            }

            $mensaje = "✔ Actualizados: $actualizados | ✘ No encontrados: $no_encontrados";
            if (!empty($errores)) {
                $mensaje .= ' | ⚠ Advertencias: ' . implode('; ', $errores);
            }

            return json_encode(['result' => ['code' => 1, 'message' => $mensaje]]);

        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return json_encode(['result' => ['code' => 2, 'message' => 'Error: ' . $e->getMessage()]]);
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
                    if($request->hasFile('pro_foto')){
                        $fi = $request->file('pro_foto');
                        $lugardestino = 'productos/';
                        $foto_productos = $this->general->convertir_webp($fi, $lugardestino);
                    } else {
                        $foto_productos = 'sin-fotografia.png';
                    }

                    if ($request->tipoAfectacion == 1){
                        $valorunit = $request->pro_precio_uni / 1.18;
                        $valormayo = $request->pro_precio_uni_ma / 1.18;
                    }else{
                        $valorunit = $request->pro_precio_uni;
                        $valormayo = $request->pro_precio_uni_ma;
                    }

                    $guardar = DB::table('productos')->insert([
                        'id_ca'=>$request->id_ca,
                        'id_medida'=>$request->unidadMedida,
                        'id_tipo_afectacion'=>$request->tipoAfectacion,
                        'id_moneda'=>$request->input('id_moneda', 1),
                        'pro_nombre'=>$request->pro_nombre,
                        'pro_codigo'=>$request->pro_codigo,
                        'pro_codigo_barra'=>$request->pro_codigo_barra,
                        'pro_descripcion'=>$request->pro_descripcion,
                        'pro_presentacion'=>$request->pro_presentacion,
                        'pro_medida'=>$request->pro_medida,
                        'pro_precio_valor'=>$valorunit,
                        'pro_precio_uni'=>$request->pro_precio_uni,
                        'pro_precio_valor_ma'=>$valormayo,
                        'pro_precio_uni_ma'=>$request->pro_precio_uni_ma,
                        'pro_precio_costo'=>$request->input('pro_precio_costo', 0),
                        'pro_valor_costo'=>$request->input('pro_valor_costo', 0),
                        'pro_costo_promedio'=>$request->input('pro_precio_costo', 0),
                        'pro_fecha_adquisicion'=>$request->pro_fecha_adquisicion ?: null,
                        'pro_porcen_igv'=>$request->tipoAfectacion == 1 ? 1.18 : 0,
                        'pro_stock'=>0,
                        'stock_minimo'=>$request->input('stock_minimo', 0),
                        'stock_maximo'=>$request->input('stock_maximo', 0),
                        'pro_foto'=>$foto_productos,
                        'pro_estado'=>1,
                        'impuesto_bolsa'=>$request->has('impuesto_bolsa') ? 1 : 0,
                        'control_serie' => $request->has('control_serie') ? 1 : 0,
                        'control_lote'  => $request->has('control_lote')  ? 1 : 0,
                    ]);
                    if ($guardar && $request->filled('ids_proveedores')) {
                        $nuevo = DB::table('productos')->where('pro_codigo', $request->pro_codigo)->first();
                        foreach ($request->ids_proveedores as $id_prov) {
                            DB::table('producto_proveedor')->insertOrIgnore(['id_pro'=>$nuevo->id_pro,'id_proveedores'=>$id_prov]);
                        }
                    }
                    $result = $guardar ? 1 : 2;
                    $message = "¡Registro guardado exitoso!";
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
                        'id_moneda'=>$request->input('id_moneda', 1),
                        'pro_nombre'=>$request->pro_nombre,
                        'pro_codigo'=>$request->pro_codigo,
                        'pro_codigo_barra'=>$request->pro_codigo_barra,
                        'pro_descripcion'=>$request->pro_descripcion,
                        'pro_presentacion'=>$request->pro_presentacion,
                        'pro_medida'=>$request->pro_medida,
                        'pro_precio_valor'=>$valorunit,
                        'pro_precio_uni'=>$request->pro_precio_uni,
                        'pro_precio_valor_ma'=>$valormayo,
                        'pro_precio_uni_ma'=>$request->pro_precio_uni_ma,
                        'pro_precio_costo'=>$request->input('pro_precio_costo', 0),
                        'pro_valor_costo'=>$request->input('pro_valor_costo', 0),
                        'pro_fecha_adquisicion'=>$request->pro_fecha_adquisicion ?: null,
                        'pro_porcen_igv'=>$request->tipoAfectacion == 1 ? 1.18 : 0,
                        'pro_foto'=>$foto_productos,
                        'stock_minimo'=>$request->input('stock_minimo', 0),
                        'stock_maximo'=>$request->input('stock_maximo', 0),
                        'impuesto_bolsa'=>$request->has('impuesto_bolsa') ? 1 : 0,
                        'control_serie' => $request->has('control_serie') ? 1 : 0,
                        'control_lote'  => $request->has('control_lote')  ? 1 : 0,
                    ]);
                    // Sincronizar proveedores asociados
                    DB::table('producto_proveedor')->where('id_pro', $request->id_pro)->delete();
                    if ($request->filled('ids_proveedores')) {
                        foreach ($request->ids_proveedores as $id_prov) {
                            DB::table('producto_proveedor')->insertOrIgnore(['id_pro'=>$request->id_pro,'id_proveedores'=>$id_prov]);
                        }
                    }
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

    public function toggle_producto(Request $request)
    {
        try {
            $producto = DB::table('productos')->where('id_pro', $request->id_pro)->first();
            if (!$producto) return response()->json(['result'=>['code'=>2,'message'=>'Producto no encontrado']]);
            $nuevoEstado = $producto->pro_estado == 1 ? 0 : 1;
            DB::table('productos')->where('id_pro', $request->id_pro)->update(['pro_estado' => $nuevoEstado]);
            $message = $nuevoEstado == 1 ? '¡Producto habilitado correctamente!' : '¡Producto deshabilitado correctamente!';
            return response()->json(['result'=>['code'=>1,'message'=>$message,'nuevo_estado'=>$nuevoEstado]]);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response()->json(['result'=>['code'=>2,'message'=>'Error al cambiar estado']]);
        }
    }

    public function filtrar_productos(Request $request)
    {
        try {
            $estado  = $request->input('estado', 1);    // 1=habilitado, 0=deshabilitado
            $stock   = $request->input('stock', '');    // 'con', 'sin', ''
            $nombre  = $request->input('nombre', '');

            $query = DB::table('productos as p')
                ->join('tipo_afectacion as ta', 'ta.id_tipo_afectacion', '=', 'p.id_tipo_afectacion')
                ->leftJoin('familias as f', 'f.id_fa', '=', 'p.id_fa')
                ->leftJoin('categorias as ca', 'ca.id_ca', '=', 'p.id_ca')
                ->addSelect(DB::raw('p.*'), DB::raw('ta.*'), DB::raw('f.fa_nombre'), DB::raw('ca.ca_nombre'),
                    DB::raw('(SELECT COUNT(*) FROM series WHERE series.id_pro = p.id_pro AND series.estado = "disponible") as stock_series'))
                ->where('p.pro_estado', $estado);

            if ($nombre !== '') {
                $query->where(function($q) use ($nombre) {
                    $q->where('p.pro_nombre', 'like', '%'.$nombre.'%')
                      ->orWhere('p.pro_codigo', 'like', '%'.$nombre.'%');
                });
            }

            if ($stock === 'con') {
                $query->where(function($q) {
                    $q->whereRaw('(SELECT COUNT(*) FROM series WHERE series.id_pro = p.id_pro AND series.estado = "disponible") > 0')
                      ->orWhere(function($q2) {
                          $q2->where('p.control_serie', 0)->where('p.pro_stock', '>', 0);
                      });
                });
            } elseif ($stock === 'sin') {
                $query->where(function($q) {
                    $q->whereRaw('(SELECT COUNT(*) FROM series WHERE series.id_pro = p.id_pro AND series.estado = "disponible") = 0')
                      ->where(function($q2) {
                          $q2->where('p.control_serie', 1)
                             ->orWhere('p.pro_stock', '<=', 0);
                      });
                });
            }

            $productos = $query->orderBy('p.pro_nombre')->get();
            return response()->json(['result'=>['code'=>1,'data'=>$productos]]);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response()->json(['result'=>['code'=>2,'data'=>[]]]);
        }
    }

    public function exportar_productos_excel(Request $request)
    {
        try {
            $estado = $request->input('estado', 1);
            $stock  = $request->input('stock', '');
            $nombre = $request->input('nombre', '');

            $query = DB::table('productos as p')
                ->join('tipo_afectacion as ta', 'ta.id_tipo_afectacion', '=', 'p.id_tipo_afectacion')
                ->leftJoin('familias as f', 'f.id_fa', '=', 'p.id_fa')
                ->leftJoin('categorias as ca', 'ca.id_ca', '=', 'p.id_ca')
                ->addSelect(DB::raw('p.*'), DB::raw('f.fa_nombre'), DB::raw('ca.ca_nombre'),
                    DB::raw('(SELECT COUNT(*) FROM series WHERE series.id_pro = p.id_pro AND series.estado = "disponible") as stock_series'))
                ->where('p.pro_estado', $estado);

            if ($nombre !== '') {
                $query->where(function($q) use ($nombre) {
                    $q->where('p.pro_nombre', 'like', '%'.$nombre.'%')
                      ->orWhere('p.pro_codigo', 'like', '%'.$nombre.'%');
                });
            }
            if ($stock === 'con') {
                $query->where(function($q) {
                    $q->whereRaw('(SELECT COUNT(*) FROM series WHERE series.id_pro = p.id_pro AND series.estado = "disponible") > 0')
                      ->orWhere(function($q2){ $q2->where('p.control_serie',0)->where('p.pro_stock','>',0); });
                });
            } elseif ($stock === 'sin') {
                $query->where(function($q) {
                    $q->whereRaw('(SELECT COUNT(*) FROM series WHERE series.id_pro = p.id_pro AND series.estado = "disponible") = 0')
                      ->where(function($q2){ $q2->where('p.control_serie',1)->orWhere('p.pro_stock','<=',0); });
                });
            }
            $productos = $query->orderBy('p.pro_nombre')->get();

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Productos');

            $headers = ['#','Código','Nombre','Línea','Categoría','Unidad Medida','Precio Unit.','Precio Mayorista','Costo','Stock','Bolsa','Estado'];
            foreach ($headers as $i => $h) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
                $sheet->setCellValue($col.'1', $h);
                $sheet->getStyle($col.'1')->getFont()->setBold(true);
                $sheet->getStyle($col.'1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF1E3A8A');
                $sheet->getStyle($col.'1')->getFont()->getColor()->setARGB('FFFFFFFF');
            }

            foreach ($productos as $k => $p) {
                $row = $k + 2;
                $stock_show = $p->control_serie ? $p->stock_series : $p->pro_stock;
                $sheet->setCellValue('A'.$row, $k+1);
                $sheet->setCellValue('B'.$row, $p->pro_codigo);
                $sheet->setCellValue('C'.$row, $p->pro_nombre);
                $sheet->setCellValue('D'.$row, $p->fa_nombre ?? '');
                $sheet->setCellValue('E'.$row, $p->ca_nombre ?? '');
                $sheet->setCellValue('F'.$row, $p->id_medida == 58 ? 'UNIDAD (BIENES)' : 'UNIDAD (SERVICIOS)');
                $sheet->setCellValue('G'.$row, $p->pro_precio_uni);
                $sheet->setCellValue('H'.$row, $p->pro_precio_uni_ma);
                $sheet->setCellValue('I'.$row, $p->pro_precio_costo);
                $sheet->setCellValue('J'.$row, $stock_show);
                $sheet->setCellValue('K'.$row, $p->impuesto_bolsa ? 'Sí' : 'No');
                $sheet->setCellValue('L'.$row, $p->pro_estado ? 'Habilitado' : 'Deshabilitado');
                if (!$p->pro_estado) {
                    $sheet->getStyle('A'.$row.':L'.$row)->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FFFEE2E2');
                }
            }
            foreach (range('A','L') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $filename = 'productos_'.date('Ymd_His').'.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit;
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            abort(500);
        }
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
                        'id_tipo_pago'=>$request->id_tipo_pago ?: null,
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
                        'orden_compra_fecha_emision_doc'   => $request->fecha_emision,
                        'orden_compra_fecha_vencimiento'   => $request->fecha_vencimiento ?: null,
                        'orden_compra_guia_remicion'       => $request->guia_remision ?: null,
                        'orden_compra_guia_transportista'  => $request->guia_transportista ?: null,
                        'orden_compra_condicion'           => $request->input('orden_compra_condicion', 0),
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
                            // Calcular costo promedio ponderado
                            $costo_unitario_entrada = floatval($d->producto_precio_unit ?? 0);
                            if ($costo_unitario_entrada > 0) {
                                $stock_anterior = floatval($producto->pro_stock);
                                $costo_promedio_anterior = floatval($producto->pro_costo_promedio ?? 0);
                                $cantidad_entrada = floatval($d->cantidad);
                                if ($stock_anterior + $cantidad_entrada > 0) {
                                    $nuevo_promedio = ($stock_anterior * $costo_promedio_anterior + $cantidad_entrada * $costo_unitario_entrada)
                                        / ($stock_anterior + $cantidad_entrada);
                                } else {
                                    $nuevo_promedio = $costo_unitario_entrada;
                                }
                                DB::table('productos')->where('id_pro', $d->id_pro)
                                    ->update(['pro_stock' => $nuevoStock, 'pro_costo_promedio' => round($nuevo_promedio, 4)]);
                            } else {
                                DB::table('productos')->where('id_pro', $d->id_pro)
                                    ->update(['pro_stock' => $nuevoStock]);
                            }
                            DB::table('productos_log')->insert([
                                'id_pro'                      => $d->id_pro,
                                'id_tipo_movimiento_producto' => 1,
                                'productos_log_fecha'         => $id_orden_compra->orden_compra_fecha ?? date('Y-m-d'),
                                'productos_log_cantidad'      => floatval($d->cantidad),
                                'productos_log_costo_unitario'=> $costo_unitario_entrada,
                                'productos_log_documento'     => ($id_orden_compra->orden_compra_tipo_doc ?? 'OC') . '-' . ($id_orden_compra->orden_compra_numero_doc ?? ''),
                                'productos_log_referencia_id' => $id_orden_compra->id_orden_compra,
                                'productos_log_estado'        => 1,
                            ]);
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

                    // Marcar detalles como inactivos
                    DB::table('orden_compra_detalle')
                        ->where('id_orden_compra', $idOrdenCompra)
                        ->update(['detalle_compra_estado' => 0]);

                    // Desactivar entradas del Kardex de esta compra (soft delete)
                    DB::table('productos_log')
                        ->where('id_tipo_movimiento_producto', 1)
                        ->where('productos_log_referencia_id', $idOrdenCompra)
                        ->update(['productos_log_estado' => 0]);

                    $detalles = DB::table('orden_compra_detalle')->where('id_orden_compra','=',$idOrdenCompra)->get();
                    foreach ($detalles as $de){
                        if ($result == 1){
                            $producto = DB::table('productos')->where('id_pro','=',$de->id_pro)->first();

                            if ($producto->control_serie || $producto->control_lote) {
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
                        $message = "Orden de Compra eliminada correctamente.";
                    }
                }else{
                    $message = "No se pudo eliminar la orden de compra.";
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
            $proveedores_ids = DB::table('producto_proveedor')
                ->where('id_pro', $request->id_pro)
                ->pluck('id_proveedores');
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message,'proveedores_ids'=>$proveedores_ids ?? [])));

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
                ->leftJoin('tipo_pago as tp','tp.id_tipo_pago','=','oc.id_tipo_pago')
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
                ->leftJoin('tipo_pago as tp','tp.id_tipo_pago','=','od.id_tipo_pago')
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

    public function kardex(Request $request)
    {
        try {
            $opciones = $this->submenu->optiones_por_vista('kardex');
            return view('logistica/kardex', compact('opciones'));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>alert('Error al cargar Kardex.'); window.location.href='" . route('admin') . "';</script>";
        }
    }

    public function kardex_pdf(Request $request)
    {
        try {
            $id_pro      = (int)$request->input('id_pro');
            $tipo        = strtoupper($request->input('tipo', 'F'));
            $fecha_desde = $request->input('fecha_desde');
            $fecha_hasta = $request->input('fecha_hasta');

            if (!$id_pro || !$fecha_desde || !$fecha_hasta) {
                return response('Parámetros incompletos.', 400);
            }

            $producto = DB::table('productos')->where('id_pro', $id_pro)->first();
            if (!$producto) {
                return response('Producto no encontrado.', 404);
            }

            $empresa = DB::table('empresa')->first();

            $movimientos = DB::table('productos_log as pl')
                ->join('tipo_movimiento_producto as tm', 'pl.id_tipo_movimiento_producto', '=', 'tm.id_tipo_movimiento_producto')
                ->where('pl.id_pro', $id_pro)
                ->where('pl.productos_log_estado', 1)
                ->whereBetween('pl.productos_log_fecha', [$fecha_desde, $fecha_hasta])
                ->select('pl.*', 'tm.tipo_movimiento_descripcion', 'tm.tipo_movimiento_tipo')
                ->orderBy('pl.productos_log_fecha')
                ->orderBy('pl.id_productos_log')
                ->get();

            $titulo = $tipo === 'F' ? 'KARDEX ' . utf8_decode('FÍSICO') : 'KARDEX VALORIZADO';

            if ($tipo === 'F') {
                // ── KARDEX FÍSICO ─────────────────────────────────────────────
                $saldo_anterior = DB::table('productos_log as pl')
                    ->join('tipo_movimiento_producto as tm', 'pl.id_tipo_movimiento_producto', '=', 'tm.id_tipo_movimiento_producto')
                    ->where('pl.id_pro', $id_pro)
                    ->where('pl.productos_log_estado', 1)
                    ->where('pl.productos_log_fecha', '<', $fecha_desde)
                    ->selectRaw("COALESCE(
                        SUM(CASE WHEN tm.tipo_movimiento_tipo='E' THEN pl.productos_log_cantidad ELSE 0 END) -
                        SUM(CASE WHEN tm.tipo_movimiento_tipo='S' THEN pl.productos_log_cantidad ELSE 0 END)
                    , 0) AS saldo")
                    ->value('saldo');
                $saldo_anterior = floatval($saldo_anterior);

                $pdf = new CustomFpdf('P', 'mm', 'A4');
                $pdf->SetMargins(10, 10, 10);
                $pdf->SetAutoPageBreak(true, 15);
                $pdf->AddPage();

                $this->_kx_cabecera($pdf, $empresa, $titulo, $producto, $fecha_desde, $fecha_hasta);

                // Cabecera de columnas (190mm usable)
                // FECHA(22)|TIPO MOV.(47)|DOCUMENTO(33)|ENTRADA(29)|SALIDA(29)|SALDO(30) = 190
                $pdf->SetFillColor(30, 60, 130);
                $pdf->SetTextColor(255, 255, 255);
                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->SetX(10);
                $pdf->Cell(22, 6, 'FECHA',           1, 0, 'C', true);
                $pdf->Cell(47, 6, 'TIPO MOVIMIENTO', 1, 0, 'C', true);
                $pdf->Cell(33, 6, 'DOCUMENTO',       1, 0, 'C', true);
                $pdf->Cell(29, 6, 'ENTRADA',         1, 0, 'C', true);
                $pdf->Cell(29, 6, 'SALIDA',          1, 0, 'C', true);
                $pdf->Cell(30, 6, 'SALDO',           1, 1, 'C', true);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetTextColor(0, 0, 0);

                // Fila saldo anterior
                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->SetX(10);
                $pdf->Cell(22, 5, '',                                            1, 0, 'C');
                $pdf->Cell(47, 5, utf8_decode('SALDO ANTERIOR'),                 1, 0, 'L');
                $pdf->Cell(33, 5, '',                                            1, 0, 'C');
                $pdf->Cell(29, 5, '',                                            1, 0, 'R');
                $pdf->Cell(29, 5, '',                                            1, 0, 'R');
                $pdf->Cell(30, 5, number_format($saldo_anterior, 2, '.', ','),  1, 1, 'R');

                // Filas de movimientos
                $saldo       = $saldo_anterior;
                $tot_entrada = 0.0;
                $tot_salida  = 0.0;
                $fill        = false;

                foreach ($movimientos as $mov) {
                    $cant = floatval($mov->productos_log_cantidad);
                    if ($mov->tipo_movimiento_tipo === 'E') {
                        $saldo       += $cant;
                        $tot_entrada += $cant;
                        $col_e = number_format($cant, 2, '.', ',');
                        $col_s = '';
                    } else {
                        $saldo      -= $cant;
                        $tot_salida += $cant;
                        $col_e = '';
                        $col_s = number_format($cant, 2, '.', ',');
                    }
                    $pdf->CheckPageBreak(5);
                    $pdf->SetFillColor($fill ? 240 : 255, $fill ? 244 : 255, $fill ? 255 : 255);
                    $pdf->SetFont('Helvetica', '', 7.5);
                    $pdf->SetX(10);
                    $pdf->Cell(22, 5, date('d/m/Y', strtotime($mov->productos_log_fecha)),  1, 0, 'C', $fill);
                    $pdf->Cell(47, 5, utf8_decode($mov->tipo_movimiento_descripcion),         1, 0, 'L', $fill);
                    $pdf->Cell(33, 5, utf8_decode($mov->productos_log_documento ?? ''),        1, 0, 'C', $fill);
                    $pdf->Cell(29, 5, $col_e,                                                 1, 0, 'R', $fill);
                    $pdf->Cell(29, 5, $col_s,                                                 1, 0, 'R', $fill);
                    $pdf->Cell(30, 5, number_format($saldo, 2, '.', ','),                     1, 1, 'R', $fill);
                    $fill = !$fill;
                }

                // Fila totales
                $pdf->SetFillColor(210, 218, 240);
                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->SetX(10);
                $pdf->Cell(102, 5, utf8_decode('TOTALES'),                     1, 0, 'R', true);
                $pdf->Cell(29,  5, number_format($tot_entrada, 2, '.', ','),   1, 0, 'R', true);
                $pdf->Cell(29,  5, number_format($tot_salida,  2, '.', ','),   1, 0, 'R', true);
                $pdf->Cell(30,  5, number_format($saldo,       2, '.', ','),   1, 1, 'R', true);

            } else {
                // ── KARDEX VALORIZADO ─────────────────────────────────────────
                // Reconstruir promedio ponderado desde el inicio hasta fecha_desde
                $historial = DB::table('productos_log as pl')
                    ->join('tipo_movimiento_producto as tm', 'pl.id_tipo_movimiento_producto', '=', 'tm.id_tipo_movimiento_producto')
                    ->where('pl.id_pro', $id_pro)
                    ->where('pl.productos_log_estado', 1)
                    ->where('pl.productos_log_fecha', '<', $fecha_desde)
                    ->select('pl.productos_log_cantidad', 'pl.productos_log_costo_unitario', 'tm.tipo_movimiento_tipo')
                    ->orderBy('pl.productos_log_fecha')
                    ->orderBy('pl.id_productos_log')
                    ->get();

                $saldo_cant = 0.0;
                $saldo_prom = 0.0;
                foreach ($historial as $h) {
                    $hq = floatval($h->productos_log_cantidad);
                    $hc = floatval($h->productos_log_costo_unitario);
                    if ($h->tipo_movimiento_tipo === 'E') {
                        if ($saldo_cant + $hq > 0) {
                            $saldo_prom = ($saldo_cant * $saldo_prom + $hq * $hc) / ($saldo_cant + $hq);
                        } else {
                            $saldo_prom = $hc;
                        }
                        $saldo_cant += $hq;
                    } else {
                        $saldo_cant = max(0.0, $saldo_cant - $hq);
                    }
                }

                // Landscape A4: 297mm ancho - 20mm márgenes = 277mm usable
                // FECHA(20)|TIPO(38)|DOC(27)|E-CANT(19)|E-CU(22)|E-TOT(22)|S-CANT(19)|S-CU(22)|S-TOT(22)|SD-CANT(19)|SD-CU(22)|SD-TOT(25)
                $wF=20; $wT=38; $wD=27;
                $wEC=19; $wEU=22; $wET=22;
                $wSC=19; $wSU=22; $wST=22;
                $wDC=19; $wDU=22; $wDT=25;

                $pdf = new CustomFpdf('L', 'mm', 'A4');
                $pdf->SetMargins(10, 10, 10);
                $pdf->SetAutoPageBreak(true, 15);
                $pdf->AddPage();

                $this->_kx_cabecera($pdf, $empresa, $titulo, $producto, $fecha_desde, $fecha_hasta);

                // Fila 1: grupos (colores por sección)
                $pdf->SetTextColor(255, 255, 255);
                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->SetX(10);
                $pdf->SetFillColor(61, 68, 81);
                $pdf->Cell($wF, 6, '', 1, 0, 'C', true);
                $pdf->Cell($wT, 6, '', 1, 0, 'C', true);
                $pdf->Cell($wD, 6, '', 1, 0, 'C', true);
                $pdf->SetFillColor(21, 128, 61);
                $pdf->Cell($wEC+$wEU+$wET, 6, 'ENTRADAS', 1, 0, 'C', true);
                $pdf->SetFillColor(185, 28, 28);
                $pdf->Cell($wSC+$wSU+$wST, 6, 'SALIDAS',  1, 0, 'C', true);
                $pdf->SetFillColor(30, 60, 130);
                $pdf->Cell($wDC+$wDU+$wDT, 6, 'SALDO',    1, 1, 'C', true);

                // Fila 2: subcolumnas (mismo esquema de color)
                $pdf->SetX(10);
                $pdf->SetFillColor(61, 68, 81);
                $pdf->Cell($wF,  5, 'FECHA',     1, 0, 'C', true);
                $pdf->Cell($wT,  5, 'TIPO MOV.', 1, 0, 'C', true);
                $pdf->Cell($wD,  5, 'DOCUMENTO', 1, 0, 'C', true);
                $pdf->SetFillColor(21, 128, 61);
                $pdf->Cell($wEC, 5, 'CANT.',     1, 0, 'C', true);
                $pdf->Cell($wEU, 5, 'C. UNIT.',  1, 0, 'C', true);
                $pdf->Cell($wET, 5, 'TOTAL',     1, 0, 'C', true);
                $pdf->SetFillColor(185, 28, 28);
                $pdf->Cell($wSC, 5, 'CANT.',     1, 0, 'C', true);
                $pdf->Cell($wSU, 5, 'C. UNIT.',  1, 0, 'C', true);
                $pdf->Cell($wST, 5, 'TOTAL',     1, 0, 'C', true);
                $pdf->SetFillColor(30, 60, 130);
                $pdf->Cell($wDC, 5, 'CANT.',     1, 0, 'C', true);
                $pdf->Cell($wDU, 5, 'C. UNIT.',  1, 0, 'C', true);
                $pdf->Cell($wDT, 5, 'TOTAL',     1, 1, 'C', true);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetTextColor(0, 0, 0);

                // Fila saldo anterior
                $pdf->SetFont('Helvetica', 'B', 7.5);
                $pdf->SetX(10);
                $pdf->Cell($wF,  5, '',                                                       1, 0, 'C');
                $pdf->Cell($wT,  5, utf8_decode('SALDO ANTERIOR'),                            1, 0, 'L');
                $pdf->Cell($wD,  5, '',                                                       1, 0, 'C');
                $pdf->Cell($wEC, 5, '',                                                       1, 0, 'R');
                $pdf->Cell($wEU, 5, '',                                                       1, 0, 'R');
                $pdf->Cell($wET, 5, '',                                                       1, 0, 'R');
                $pdf->Cell($wSC, 5, '',                                                       1, 0, 'R');
                $pdf->Cell($wSU, 5, '',                                                       1, 0, 'R');
                $pdf->Cell($wST, 5, '',                                                       1, 0, 'R');
                $pdf->Cell($wDC, 5, number_format($saldo_cant, 2, '.', ','),                  1, 0, 'R');
                $pdf->Cell($wDU, 5, number_format($saldo_prom, 4, '.', ','),                  1, 0, 'R');
                $pdf->Cell($wDT, 5, number_format($saldo_cant * $saldo_prom, 2, '.', ','),    1, 1, 'R');

                // Filas de movimientos
                $fill   = false;
                $tot_ec = 0.0; $tot_et = 0.0;
                $tot_sc = 0.0; $tot_st = 0.0;
                $fmt = function($v, $d = 2) {
                    return $v === '' ? '' : number_format((float)$v, $d, '.', ',');
                };

                foreach ($movimientos as $mov) {
                    $cant  = floatval($mov->productos_log_cantidad);
                    $costo = floatval($mov->productos_log_costo_unitario);

                    if ($mov->tipo_movimiento_tipo === 'E') {
                        if ($saldo_cant + $cant > 0) {
                            $saldo_prom = ($saldo_cant * $saldo_prom + $cant * $costo) / ($saldo_cant + $cant);
                        } else {
                            $saldo_prom = $costo;
                        }
                        $saldo_cant += $cant;
                        $tot_entrada = $cant * $costo;
                        $tot_ec     += $cant;
                        $tot_et     += $tot_entrada;
                        $row = ['ec' => $cant, 'eu' => $costo, 'et' => $tot_entrada, 'sc' => '', 'su' => '', 'st' => ''];
                    } else {
                        $costo_salida = floatval($mov->productos_log_costo_unitario);
                        $tot_salida   = $cant * $costo_salida;
                        $saldo_cant   = max(0.0, $saldo_cant - $cant);
                        $tot_sc      += $cant;
                        $tot_st      += $tot_salida;
                        $row = ['ec' => '', 'eu' => '', 'et' => '', 'sc' => $cant, 'su' => $costo_salida, 'st' => $tot_salida];
                    }

                    $pdf->CheckPageBreak(5);
                    $pdf->SetFillColor($fill ? 240 : 255, $fill ? 244 : 255, $fill ? 255 : 255);
                    $pdf->SetFont('Helvetica', '', 7);
                    $pdf->SetX(10);
                    $pdf->Cell($wF,  5, date('d/m/Y', strtotime($mov->productos_log_fecha)),  1, 0, 'C', $fill);
                    $pdf->Cell($wT,  5, utf8_decode($mov->tipo_movimiento_descripcion),         1, 0, 'L', $fill);
                    $pdf->Cell($wD,  5, utf8_decode($mov->productos_log_documento ?? ''),        1, 0, 'C', $fill);
                    $pdf->Cell($wEC, 5, $fmt($row['ec']),                                        1, 0, 'R', $fill);
                    $pdf->Cell($wEU, 5, $fmt($row['eu'], 4),                                     1, 0, 'R', $fill);
                    $pdf->Cell($wET, 5, $fmt($row['et']),                                        1, 0, 'R', $fill);
                    $pdf->Cell($wSC, 5, $fmt($row['sc']),                                        1, 0, 'R', $fill);
                    $pdf->Cell($wSU, 5, $fmt($row['su'], 4),                                     1, 0, 'R', $fill);
                    $pdf->Cell($wST, 5, $fmt($row['st']),                                        1, 0, 'R', $fill);
                    $pdf->Cell($wDC, 5, number_format($saldo_cant, 2, '.', ','),                 1, 0, 'R', $fill);
                    $pdf->Cell($wDU, 5, number_format($saldo_prom, 4, '.', ','),                 1, 0, 'R', $fill);
                    $pdf->Cell($wDT, 5, number_format($saldo_cant * $saldo_prom, 2, '.', ','),   1, 1, 'R', $fill);
                    $fill = !$fill;
                }

                // Fila totales
                $pdf->SetFillColor(210, 218, 240);
                $pdf->SetFont('Helvetica', 'B', 7.5);
                $pdf->SetX(10);
                $pdf->Cell($wF+$wT+$wD, 5, utf8_decode('TOTALES'),                          1, 0, 'R', true);
                $pdf->Cell($wEC, 5, number_format($tot_ec, 2, '.', ','),                     1, 0, 'R', true);
                $pdf->Cell($wEU, 5, '',                                                       1, 0, 'R', true);
                $pdf->Cell($wET, 5, number_format($tot_et, 2, '.', ','),                     1, 0, 'R', true);
                $pdf->Cell($wSC, 5, number_format($tot_sc, 2, '.', ','),                     1, 0, 'R', true);
                $pdf->Cell($wSU, 5, '',                                                       1, 0, 'R', true);
                $pdf->Cell($wST, 5, number_format($tot_st, 2, '.', ','),                     1, 0, 'R', true);
                $pdf->Cell($wDC, 5, number_format($saldo_cant, 2, '.', ','),                 1, 0, 'R', true);
                $pdf->Cell($wDU, 5, number_format($saldo_prom, 4, '.', ','),                 1, 0, 'R', true);
                $pdf->Cell($wDT, 5, number_format($saldo_cant * $saldo_prom, 2, '.', ','),   1, 1, 'R', true);
            }

            $pdf->Output('I', 'kardex_' . ($tipo === 'F' ? 'fisico' : 'valorizado') . '_' . date('Ymd') . '.pdf');
            exit;

        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response('Error al generar Kardex PDF: ' . $e->getMessage(), 500);
        }
    }

    public function kardex_excel(Request $request)
    {
        try {
            $id_pro      = (int)$request->input('id_pro');
            $tipo        = strtoupper($request->input('tipo', 'F'));
            $fecha_desde = $request->input('fecha_desde');
            $fecha_hasta = $request->input('fecha_hasta');

            if (!$id_pro || !$fecha_desde || !$fecha_hasta) {
                return response('Parámetros incompletos.', 400);
            }

            $producto = DB::table('productos')->where('id_pro', $id_pro)->first();
            if (!$producto) return response('Producto no encontrado.', 404);

            $empresa = DB::table('empresa')->first();

            $movimientos = DB::table('productos_log as pl')
                ->join('tipo_movimiento_producto as tm', 'pl.id_tipo_movimiento_producto', '=', 'tm.id_tipo_movimiento_producto')
                ->where('pl.id_pro', $id_pro)
                ->where('pl.productos_log_estado', 1)
                ->whereBetween('pl.productos_log_fecha', [$fecha_desde, $fecha_hasta])
                ->select('pl.*', 'tm.tipo_movimiento_descripcion', 'tm.tipo_movimiento_tipo')
                ->orderBy('pl.productos_log_fecha')
                ->orderBy('pl.id_productos_log')
                ->get();

            $spreadsheet = new Spreadsheet();
            $sheet       = $spreadsheet->getActiveSheet();

            // ── Helpers de estilo ────────────────────────────────────────
            $sCenter = ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]];
            $sLeft   = ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,   'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]];
            $sRight  = ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]];
            $sBorder = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]]];
            $sFill   = fn($argb) => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => $argb]]];
            $nFmt    = fn($sheet, $range, $fmt) => $sheet->getStyle($range)->getNumberFormat()->setFormatCode($fmt);

            // ── Cabecera común (empresa + producto + periodo) ─────────────
            $lastCol = $tipo === 'F' ? 'F' : 'L';
            $writeHeader = function() use ($sheet, $empresa, $producto, $fecha_desde, $fecha_hasta, &$lastCol, $sCenter, $sLeft) {
                $row = 1;
                $sheet->setCellValue("A{$row}", $empresa->empresa_razon_social ?? '');
                $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
                $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(11);
                $sheet->getStyle("A{$row}")->applyFromArray($sCenter);
                $row++;

                $sheet->setCellValue("A{$row}", 'RUC: ' . ($empresa->empresa_ruc ?? ''));
                $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
                $sheet->getStyle("A{$row}")->getFont()->setSize(9);
                $sheet->getStyle("A{$row}")->applyFromArray($sCenter);
                $row++;

                $titulo = $lastCol === 'F' ? 'KARDEX FÍSICO' : 'KARDEX VALORIZADO';
                $sheet->setCellValue("A{$row}", $titulo);
                $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
                $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(13);
                $sheet->getStyle("A{$row}")->applyFromArray($sCenter);
                $row++;

                $sheet->setCellValue("A{$row}", 'Producto: ' . ($producto->pro_nombre ?? '') . '  |  Código: ' . ($producto->pro_codigo ?? ''));
                $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
                $sheet->getStyle("A{$row}")->getFont()->setSize(9);
                $sheet->getStyle("A{$row}")->applyFromArray($sLeft);
                $row++;

                $sheet->setCellValue("A{$row}", 'Período: ' . date('d/m/Y', strtotime($fecha_desde)) . ' — ' . date('d/m/Y', strtotime($fecha_hasta)));
                $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
                $sheet->getStyle("A{$row}")->getFont()->setSize(9);
                $sheet->getStyle("A{$row}")->applyFromArray($sLeft);
                $row++;

                $row++; // separador vacío
                return $row;
            };

            if ($tipo === 'F') {
                // ── KARDEX FÍSICO ─────────────────────────────────────────
                $saldo_anterior = floatval(
                    DB::table('productos_log as pl')
                        ->join('tipo_movimiento_producto as tm', 'pl.id_tipo_movimiento_producto', '=', 'tm.id_tipo_movimiento_producto')
                        ->where('pl.id_pro', $id_pro)
                        ->where('pl.productos_log_estado', 1)
                        ->where('pl.productos_log_fecha', '<', $fecha_desde)
                        ->selectRaw("COALESCE(
                            SUM(CASE WHEN tm.tipo_movimiento_tipo='E' THEN pl.productos_log_cantidad ELSE 0 END) -
                            SUM(CASE WHEN tm.tipo_movimiento_tipo='S' THEN pl.productos_log_cantidad ELSE 0 END)
                        , 0) AS saldo")
                        ->value('saldo')
                );

                $sheet->setTitle('Kardex Fisico');
                foreach (['A' => 14, 'B' => 32, 'C' => 22, 'D' => 14, 'E' => 14, 'F' => 14] as $col => $w) {
                    $sheet->getColumnDimension($col)->setWidth($w);
                }

                $row = $writeHeader();

                // Encabezado columnas
                foreach (['A' => 'FECHA', 'B' => 'TIPO MOVIMIENTO', 'C' => 'DOCUMENTO', 'D' => 'ENTRADA', 'E' => 'SALIDA', 'F' => 'SALDO'] as $col => $label) {
                    $sheet->setCellValue("{$col}{$row}", $label);
                }
                $sheet->getStyle("A{$row}:F{$row}")->applyFromArray(['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]]);
                $sheet->getStyle("A{$row}:F{$row}")->applyFromArray($sFill('FF1E3C82'));
                $sheet->getStyle("A{$row}:F{$row}")->applyFromArray($sBorder);
                $sheet->getRowDimension($row)->setRowHeight(16);
                $row++;

                // Saldo anterior
                $sheet->setCellValue("B{$row}", 'SALDO ANTERIOR');
                $sheet->setCellValue("F{$row}", $saldo_anterior);
                $sheet->getStyle("A{$row}:F{$row}")->applyFromArray($sBorder);
                $sheet->getStyle("B{$row}")->getFont()->setBold(true);
                $sheet->getStyle("F{$row}")->applyFromArray($sRight);
                $nFmt($sheet, "F{$row}", '#,##0.00');
                $row++;

                $saldo = $saldo_anterior;
                $tot_e = 0.0; $tot_s = 0.0; $alt = false;

                foreach ($movimientos as $mov) {
                    $cant = floatval($mov->productos_log_cantidad);
                    if ($mov->tipo_movimiento_tipo === 'E') {
                        $saldo += $cant; $tot_e += $cant;
                        $sheet->setCellValue("D{$row}", $cant);
                    } else {
                        $saldo -= $cant; $tot_s += $cant;
                        $sheet->setCellValue("E{$row}", $cant);
                    }
                    $sheet->setCellValue("A{$row}", date('d/m/Y', strtotime($mov->productos_log_fecha)));
                    $sheet->setCellValue("B{$row}", $mov->tipo_movimiento_descripcion);
                    $sheet->setCellValue("C{$row}", $mov->productos_log_documento ?? '');
                    $sheet->setCellValue("F{$row}", $saldo);
                    $bg = $alt ? 'FFF0F4FF' : 'FFFFFFFF';
                    $sheet->getStyle("A{$row}:F{$row}")->applyFromArray($sBorder);
                    $sheet->getStyle("A{$row}:F{$row}")->applyFromArray($sFill($bg));
                    $sheet->getStyle("A{$row}")->applyFromArray($sCenter);
                    $sheet->getStyle("D{$row}:F{$row}")->applyFromArray($sRight);
                    $nFmt($sheet, "D{$row}:F{$row}", '#,##0.00');
                    $alt = !$alt; $row++;
                }

                // Totales
                $sheet->setCellValue("A{$row}", 'TOTALES');
                $sheet->mergeCells("A{$row}:C{$row}");
                $sheet->setCellValue("D{$row}", $tot_e);
                $sheet->setCellValue("E{$row}", $tot_s);
                $sheet->setCellValue("F{$row}", $saldo);
                $sheet->getStyle("A{$row}:F{$row}")->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle("A{$row}:F{$row}")->applyFromArray($sFill('FFD2DAF0'));
                $sheet->getStyle("A{$row}:F{$row}")->applyFromArray($sBorder);
                $sheet->getStyle("A{$row}")->applyFromArray($sRight);
                $sheet->getStyle("D{$row}:F{$row}")->applyFromArray($sRight);
                $nFmt($sheet, "D{$row}:F{$row}", '#,##0.00');

            } else {
                // ── KARDEX VALORIZADO ─────────────────────────────────────
                $historial = DB::table('productos_log as pl')
                    ->join('tipo_movimiento_producto as tm', 'pl.id_tipo_movimiento_producto', '=', 'tm.id_tipo_movimiento_producto')
                    ->where('pl.id_pro', $id_pro)
                    ->where('pl.productos_log_estado', 1)
                    ->where('pl.productos_log_fecha', '<', $fecha_desde)
                    ->select('pl.productos_log_cantidad', 'pl.productos_log_costo_unitario', 'tm.tipo_movimiento_tipo')
                    ->orderBy('pl.productos_log_fecha')->orderBy('pl.id_productos_log')
                    ->get();

                $saldo_cant = 0.0; $saldo_prom = 0.0;
                foreach ($historial as $h) {
                    $hq = floatval($h->productos_log_cantidad);
                    $hc = floatval($h->productos_log_costo_unitario);
                    if ($h->tipo_movimiento_tipo === 'E') {
                        $saldo_prom = ($saldo_cant + $hq > 0) ? ($saldo_cant * $saldo_prom + $hq * $hc) / ($saldo_cant + $hq) : $hc;
                        $saldo_cant += $hq;
                    } else {
                        $saldo_cant = max(0.0, $saldo_cant - $hq);
                    }
                }

                $sheet->setTitle('Kardex Valorizado');
                $lastCol = 'L';
                foreach (['A' => 14, 'B' => 26, 'C' => 18, 'D' => 12, 'E' => 14, 'F' => 14, 'G' => 12, 'H' => 14, 'I' => 14, 'J' => 12, 'K' => 14, 'L' => 14] as $col => $w) {
                    $sheet->getColumnDimension($col)->setWidth($w);
                }

                $row = $writeHeader();

                // Colores
                $cGray  = 'FF3D4451'; $cGreen = 'FF15803D'; $cRed = 'FFB91C1C'; $cBlue = 'FF1E3C82';
                $whiteFont = ['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]];

                // Fila 1: grupos
                foreach (['A', 'B', 'C'] as $col) { $sheet->setCellValue("{$col}{$row}", ''); $sheet->getStyle("{$col}{$row}")->applyFromArray($sFill($cGray)); }
                $sheet->setCellValue("D{$row}", 'ENTRADAS'); $sheet->mergeCells("D{$row}:F{$row}"); $sheet->getStyle("D{$row}:F{$row}")->applyFromArray($sFill($cGreen));
                $sheet->setCellValue("G{$row}", 'SALIDAS');  $sheet->mergeCells("G{$row}:I{$row}"); $sheet->getStyle("G{$row}:I{$row}")->applyFromArray($sFill($cRed));
                $sheet->setCellValue("J{$row}", 'SALDO');    $sheet->mergeCells("J{$row}:L{$row}"); $sheet->getStyle("J{$row}:L{$row}")->applyFromArray($sFill($cBlue));
                $sheet->getStyle("A{$row}:L{$row}")->applyFromArray($whiteFont);
                $sheet->getStyle("A{$row}:L{$row}")->applyFromArray($sBorder);
                $sheet->getRowDimension($row)->setRowHeight(16);
                $row++;

                // Fila 2: sub-columnas
                $subMap = ['A' => ['FECHA', $cGray], 'B' => ['TIPO MOV.', $cGray], 'C' => ['DOCUMENTO', $cGray], 'D' => ['CANT.', $cGreen], 'E' => ['C. UNIT.', $cGreen], 'F' => ['TOTAL', $cGreen], 'G' => ['CANT.', $cRed], 'H' => ['C. UNIT.', $cRed], 'I' => ['TOTAL', $cRed], 'J' => ['CANT.', $cBlue], 'K' => ['C. UNIT.', $cBlue], 'L' => ['TOTAL', $cBlue]];
                foreach ($subMap as $col => [$label, $color]) {
                    $sheet->setCellValue("{$col}{$row}", $label);
                    $sheet->getStyle("{$col}{$row}")->applyFromArray($sFill($color));
                    $sheet->getStyle("{$col}{$row}")->applyFromArray($whiteFont);
                }
                $sheet->getStyle("A{$row}:L{$row}")->applyFromArray($sBorder);
                $sheet->getRowDimension($row)->setRowHeight(16);
                $row++;

                // Saldo anterior
                $sheet->setCellValue("B{$row}", 'SALDO ANTERIOR');
                $sheet->setCellValue("J{$row}", $saldo_cant);
                $sheet->setCellValue("K{$row}", $saldo_prom);
                $sheet->setCellValue("L{$row}", $saldo_cant * $saldo_prom);
                $sheet->getStyle("A{$row}:L{$row}")->applyFromArray($sBorder);
                $sheet->getStyle("B{$row}")->getFont()->setBold(true);
                $sheet->getStyle("J{$row}:L{$row}")->applyFromArray($sRight);
                $nFmt($sheet, "J{$row}:L{$row}", '#,##0.00');
                $nFmt($sheet, "K{$row}", '#,##0.0000');
                $row++;

                $tot_ec = 0.0; $tot_et = 0.0; $tot_sc = 0.0; $tot_st = 0.0; $alt = false;

                foreach ($movimientos as $mov) {
                    $cant  = floatval($mov->productos_log_cantidad);
                    $costo = floatval($mov->productos_log_costo_unitario);

                    if ($mov->tipo_movimiento_tipo === 'E') {
                        $saldo_prom = ($saldo_cant + $cant > 0) ? ($saldo_cant * $saldo_prom + $cant * $costo) / ($saldo_cant + $cant) : $costo;
                        $saldo_cant += $cant;
                        $tot_entrada = $cant * $costo;
                        $tot_ec += $cant; $tot_et += $tot_entrada;
                        $sheet->setCellValue("D{$row}", $cant);
                        $sheet->setCellValue("E{$row}", $costo);
                        $sheet->setCellValue("F{$row}", $tot_entrada);
                    } else {
                        $costo_s = floatval($mov->productos_log_costo_unitario);
                        $tot_s   = $cant * $costo_s;
                        $saldo_cant = max(0.0, $saldo_cant - $cant);
                        $tot_sc += $cant; $tot_st += $tot_s;
                        $sheet->setCellValue("G{$row}", $cant);
                        $sheet->setCellValue("H{$row}", $costo_s);
                        $sheet->setCellValue("I{$row}", $tot_s);
                    }

                    $sheet->setCellValue("A{$row}", date('d/m/Y', strtotime($mov->productos_log_fecha)));
                    $sheet->setCellValue("B{$row}", $mov->tipo_movimiento_descripcion);
                    $sheet->setCellValue("C{$row}", $mov->productos_log_documento ?? '');
                    $sheet->setCellValue("J{$row}", $saldo_cant);
                    $sheet->setCellValue("K{$row}", $saldo_prom);
                    $sheet->setCellValue("L{$row}", $saldo_cant * $saldo_prom);

                    $bg = $alt ? 'FFF0F4FF' : 'FFFFFFFF';
                    $sheet->getStyle("A{$row}:L{$row}")->applyFromArray($sBorder);
                    $sheet->getStyle("A{$row}:L{$row}")->applyFromArray($sFill($bg));
                    $sheet->getStyle("A{$row}")->applyFromArray($sCenter);
                    $sheet->getStyle("D{$row}:L{$row}")->applyFromArray($sRight);
                    $nFmt($sheet, "D{$row}:L{$row}", '#,##0.00');
                    $nFmt($sheet, "E{$row}", '#,##0.0000');
                    $nFmt($sheet, "H{$row}", '#,##0.0000');
                    $nFmt($sheet, "K{$row}", '#,##0.0000');
                    $alt = !$alt; $row++;
                }

                // Totales
                $sheet->setCellValue("A{$row}", 'TOTALES');
                $sheet->mergeCells("A{$row}:C{$row}");
                $sheet->setCellValue("D{$row}", $tot_ec); $sheet->setCellValue("E{$row}", ''); $sheet->setCellValue("F{$row}", $tot_et);
                $sheet->setCellValue("G{$row}", $tot_sc); $sheet->setCellValue("H{$row}", ''); $sheet->setCellValue("I{$row}", $tot_st);
                $sheet->setCellValue("J{$row}", $saldo_cant); $sheet->setCellValue("K{$row}", $saldo_prom); $sheet->setCellValue("L{$row}", $saldo_cant * $saldo_prom);
                $sheet->getStyle("A{$row}:L{$row}")->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle("A{$row}:L{$row}")->applyFromArray($sFill('FFD2DAF0'));
                $sheet->getStyle("A{$row}:L{$row}")->applyFromArray($sBorder);
                $sheet->getStyle("A{$row}")->applyFromArray($sRight);
                $sheet->getStyle("D{$row}:L{$row}")->applyFromArray($sRight);
                $nFmt($sheet, "D{$row}:L{$row}", '#,##0.00');
                $nFmt($sheet, "K{$row}", '#,##0.0000');
            }

            $writer   = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $filename = 'kardex_' . ($tipo === 'F' ? 'fisico' : 'valorizado') . '_' . date('Ymd') . '.xlsx';

            return response()->streamDownload(function () use ($writer) {
                $writer->save('php://output');
            }, $filename, [
                'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Cache-Control'       => 'max-age=0',
            ]);

        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response('Error al generar Kardex Excel: ' . $e->getMessage(), 500);
        }
    }

    private function _kx_cabecera(CustomFpdf $pdf, $empresa, string $titulo, $producto, string $desde, string $hasta): void
    {
        $uw = $pdf->GetPageWidth() - 20;

        $logo    = $empresa->empresa_foto_ticket ?? '';
        $hasLogo = $logo && file_exists($logo);
        if ($hasLogo) {
            $pdf->Image($logo, 15, 6, 45, 20);
        }
        $xT = $hasLogo ? 43 : 10;
        $wT = $hasLogo ? $uw - 33 : $uw;

        $pdf->SetXY($xT, 11);
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->SetTextColor(26, 26, 26);
        $pdf->MultiCell($wT, 6, utf8_decode($empresa->empresa_razon_social ?? ''), 0, 'C');
        $pdf->SetX($xT);
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetTextColor(60, 60, 60);
        $pdf->MultiCell($wT, 4, utf8_decode(($empresa->empresa_domiciliofiscal ?? '') . '  |  RUC: ' . ($empresa->empresa_ruc ?? '')), 0, 'C');

        $pdf->Ln(5);
        $pdf->SetFillColor(30, 60, 130);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->SetX(10);
        $pdf->Cell($uw, 7, $titulo, 0, 1, 'C', true);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);

        $half = $uw / 2;
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetX(10);
        $pdf->Cell(28, 5, 'PRODUCTO:', 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->Cell($half - 28, 5, utf8_decode($producto->pro_nombre ?? ''), 0, 0, 'L');
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Cell(24, 5, utf8_decode('PERÍODO:'), 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->Cell(0, 5, date('d/m/Y', strtotime($desde)) . ' al ' . date('d/m/Y', strtotime($hasta)), 0, 1, 'L');

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetX(10);
        $pdf->Cell(28, 5, utf8_decode('CÓDIGO:'), 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->Cell($half - 28, 5, $producto->pro_codigo ?? '', 0, 0, 'L');
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Cell(24, 5, 'TIPO:', 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->Cell(0, 5, $titulo, 0, 1, 'L');

        $pdf->SetDrawColor(30, 60, 130);
        $pdf->SetLineWidth(0.4);
        $pdf->Line(10, $pdf->GetY() + 1, 10 + $uw, $pdf->GetY() + 1);
        $pdf->SetLineWidth(0.3);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Ln(4);
    }

    public function guardar_guia(Request $request)
    {
        try {
            $id_empresa = $request->input('id_empresa') ?: DB::table('empresa')->value('id_empresa');
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
                'id_clientes'                  => $request->input('id_clientes') ?: null,
                'guia_cliente_tipo_doc'        => $request->input('guia_cliente_tipo_doc'),
                'guia_cliente_num_doc'         => $request->input('guia_cliente_num_doc'),
                'guia_cliente_nombre'          => $request->input('guia_cliente_nombre'),
                'id_venta'                     => $request->input('id_venta') ?: null,
                'id_users'                     => Auth::id(),
                'guia_tipo'                    => $guia_tipo,
                'guia_serie'                   => $prefijo,
                'guia_correlativo'             => str_pad($correlativo, 8, '0', STR_PAD_LEFT),
                'guia_emision'                 => $request->input('guia_emision', date('Y-m-d')),
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
            $id_venta       = $request->input('id_venta') ?: null;
            $descripciones  = $request->input('detalle_descripcion', []);
            $id_pros        = $request->input('detalle_id_pro', []);
            $codigos        = $request->input('detalle_codigo', []);
            $cantidades     = $request->input('detalle_cantidad', []);
            $pesos          = $request->input('detalle_peso', []);
            $ums            = $request->input('detalle_um', []);
            $observaciones  = $request->input('detalle_observacion', []);

            foreach ($descripciones as $i => $desc) {
                if (empty($desc)) continue;
                DB::table('guia_remision_detalle')->insert([
                    'id_guia'                             => $id_guia,
                    'id_pro'                              => $id_pros[$i] ?: null,
                    'guia_remision_detalle_codigo'        => $codigos[$i] ?? null,
                    'guia_remision_detalle_descripcion'   => $desc,
                    'guia_remision_detalle_cantidad'      => $cantidades[$i] ?? 1,
                    'guia_remision_peso'                  => $pesos[$i] ?? 0,
                    'guia_remision_detalle_um'            => $ums[$i] ?? 'NIU',
                    'guia_remision_detalle_observacion'   => $observaciones[$i] ?? null,
                    'created_at'                          => now(),
                    'updated_at'                          => now(),
                ]);
            }

            // Descontar stock solo cuando la guía NO está vinculada a una venta
            if (!$id_venta) {
                $serie_guia = $prefijo . '-' . str_pad($correlativo, 8, '0', STR_PAD_LEFT);
                foreach ($descripciones as $i => $desc) {
                    if (empty($desc)) continue;
                    $id_pro   = $id_pros[$i] ?: null;
                    $cantidad = floatval($cantidades[$i] ?? 1);
                    if (!$id_pro || $cantidad <= 0) continue;

                    $producto = DB::table('productos')->where('id_pro', $id_pro)->first();
                    if (!$producto) continue;

                    $nuevo_stock = $producto->pro_stock - $cantidad;
                    DB::table('productos')
                        ->where('id_pro', $id_pro)
                        ->update(['pro_stock' => $nuevo_stock]);

                    DB::table('productos_log')->insert([
                        'id_pro'                      => $id_pro,
                        'id_tipo_movimiento_producto' => 5,
                        'productos_log_fecha'         => $request->input('guia_emision', date('Y-m-d')),
                        'productos_log_cantidad'      => $cantidad,
                        'productos_log_costo_unitario'=> floatval($producto->pro_costo_promedio ?? 0),
                        'productos_log_documento'     => $serie_guia,
                        'productos_log_referencia_id' => $id_guia,
                        'productos_log_estado'        => 1,
                    ]);
                }
            }

            return response()->json(['result' => 1, 'mensaje' => 'Guía creada correctamente.', 'id_guia' => $id_guia]);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response()->json(['result' => 2, 'mensaje' => 'Error al guardar la guía: ' . $e->getMessage()]);
        }
    }

    public function buscar_venta_guia(Request $request)
    {
        try {
            $serie       = trim($request->input('serie', ''));
            $correlativo = trim($request->input('correlativo', ''));

            $soloUltimas = $request->input('last') == '5';

            if ($serie === '' && $correlativo === '' && !$soloUltimas) {
                return response()->json(['result' => 2, 'mensaje' => 'Ingresa la serie o correlativo.']);
            }

            $query = DB::table('ventas as v')
                ->join('clientes as c', 'c.id_clientes', '=', 'v.id_clientes')
                ->leftJoin('tipo_documento as td', 'td.id_tipo_documento', '=', 'c.id_tipo_documento')
                ->select(
                    'v.id_venta', 'v.venta_serie', 'v.venta_correlativo', 'v.venta_total',
                    'c.id_clientes', 'c.cliente_nombre', 'c.cliente_razonsocial', 'c.cliente_numero',
                    'c.id_tipo_documento', 'td.tipo_documento_identidad'
                );

            if ($serie !== '') {
                $query->where('v.venta_serie', 'like', '%' . $serie . '%');
            }
            if ($correlativo !== '') {
                $query->where('v.venta_correlativo', 'like', '%' . $correlativo . '%');
            }

            $limit  = $soloUltimas ? 5 : 15;
            $ventas = $query->orderByDesc('v.id_venta')->limit($limit)->get();

            if ($ventas->isEmpty()) {
                return response()->json(['result' => 0, 'mensaje' => 'No se encontraron facturas.', 'data' => []]);
            }

            $data = $ventas->map(function ($v) {
                $productos = DB::table('ventas_detalle as vd')
                    ->leftJoin('productos as p', 'p.id_pro', '=', 'vd.id_pro')
                    ->where('vd.id_venta', $v->id_venta)
                    ->select('vd.id_pro', 'p.pro_codigo', 'p.pro_nombre', 'vd.venta_detalle_nombre_producto', 'vd.venta_detalle_cantidad')
                    ->get();

                return [
                    'id_venta'          => $v->id_venta,
                    'serie'             => $v->venta_serie,
                    'correlativo'       => $v->venta_correlativo,
                    'total'             => number_format($v->venta_total, 2, '.', ','),
                    'id_clientes'       => $v->id_clientes,
                    'cliente_nombre'    => $v->cliente_razonsocial ?: $v->cliente_nombre,
                    'cliente_numero'    => $v->cliente_numero,
                    'id_tipo_documento' => $v->id_tipo_documento,
                    'productos'         => $productos->map(fn($p) => [
                        'id_pro'    => $p->id_pro ?? null,
                        'codigo'    => $p->pro_codigo ?? '',
                        'nombre'    => $p->pro_nombre ?: $p->venta_detalle_nombre_producto,
                        'cantidad'  => $p->venta_detalle_cantidad ?? 1,
                    ])->toArray(),
                ];
            });

            return response()->json(['result' => 1, 'data' => $data]);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response()->json(['result' => 2, 'mensaje' => 'Error: ' . $e->getMessage()]);
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















    public function imprimir_guia_pdf(Request $request)
    {
        try {
            $id_guia = (int)$request->input('id_guia');

            $guia = DB::table('guia_remision as gr')
                ->leftJoin('empresa as e',         'gr.id_empresa',       '=', 'e.id_empresa')
                ->leftJoin('clientes as c',        'gr.id_clientes',      '=', 'c.id_clientes')
                ->leftJoin('tipo_documento as td', 'c.id_tipo_documento', '=', 'td.id_tipo_documento')
                ->leftJoin('ventas as v',          'gr.id_venta',         '=', 'v.id_venta')
                ->select(
                    'gr.*',
                    'e.empresa_razon_social', 'e.empresa_ruc',
                    'e.empresa_domiciliofiscal', 'e.empresa_telefono1',
                    'e.empresa_foto_ticket',
                    'c.cliente_nombre', 'c.cliente_razonsocial', 'c.cliente_numero',
                    'c.cliente_direccion',
                    'td.tipo_documento_identidad as cliente_tipo_doc_nombre',
                    'v.venta_serie', 'v.venta_correlativo'
                )
                ->where('gr.id_guia', $id_guia)
                ->first();

            if (!$guia) {
                abort(404, 'Guia no encontrada.');
            }

            $detalle = DB::table('guia_remision_detalle')->where('id_guia', $id_guia)->get();

            // Datos del destinatario
            if ($guia->id_clientes) {
                $dest_nombre    = $guia->cliente_razonsocial ?: ($guia->cliente_nombre ?? '-');
                $dest_ruc       = $guia->cliente_numero ?? '-';
                $dest_direccion = $guia->cliente_direccion ?? '';
            } else {
                $dest_nombre    = $guia->guia_cliente_nombre ?? '-';
                $dest_ruc       = $guia->guia_cliente_num_doc ?? '-';
                $dest_direccion = $guia->guia_direccion_desti ?? '';
            }

            // Motivo traslado
            $motivos = [
                '01' => '01 - Venta',
                '02' => '02 - Compra',
                '03' => '03 - Venta con entrega a terceros',
                '04' => '04 - Traslado entre establecimientos',
                '05' => '05 - Consignacion',
                '06' => '06 - Devolucion',
                '13' => '13 - Otros',
                '18' => '18 - Importacion',
                '19' => '19 - Exportacion',
            ];
            $motivo = $motivos[$guia->guia_motivo] ?? (($guia->guia_motivo ?? '') . ' - Otro');

            // Modalidad
            $mod_upper = strtoupper($guia->guia_tipo_trans ?? '');
            $es_publico = (strpos($mod_upper, 'PUBLI') !== false);

            // Conductor
            $tipo_doc_map = ['1' => 'DNI', '6' => 'RUC', 'A' => 'CE', '7' => 'Pasaporte'];
            $cond_tipo    = $tipo_doc_map[$guia->guia_conductor_documento_tipo ?? '1'] ?? 'DNI';
            $cond_nombre  = trim(($guia->guia_conductor_nombre ?? '') . ' ' . ($guia->guia_conductor_apellidos ?? ''));

            // Fechas
            $f_emision  = $guia->guia_emision        ? date('d/m/Y', strtotime($guia->guia_emision))        : '-';
            $f_traslado = $guia->guia_fecha_traslado  ? date('d/m/Y', strtotime($guia->guia_fecha_traslado)) : '-';

            // Serie completa
            $serie_completa = ($guia->guia_serie ?? 'T001') . '-' . ($guia->guia_correlativo ?? '00000001');

            // Ubigeos (lookup text from table)
            $ub_part  = $guia->guia_ubigeo_part  ? DB::table('ubigeo')->where('ubigeo_cod', $guia->guia_ubigeo_part)->first()  : null;
            $ub_llega = $guia->guia_ubigeo_llega ? DB::table('ubigeo')->where('ubigeo_cod', $guia->guia_ubigeo_llega)->first() : null;
            $ciu_part  = $ub_part  ? ($ub_part->ubigeo_departamento  . ' / ' . $ub_part->ubigeo_provincia  . ' / ' . $ub_part->ubigeo_distrito)  : ($guia->guia_ubigeo_part  ?? '');
            $ciu_llega = $ub_llega ? ($ub_llega->ubigeo_departamento . ' / ' . $ub_llega->ubigeo_provincia . ' / ' . $ub_llega->ubigeo_distrito) : ($guia->guia_ubigeo_llega ?? '');

            // ─────────────────────────────────────────────────────────
            // PDF
            // ─────────────────────────────────────────────────────────
            $pdf = new CustomFpdf('P', 'mm', 'A4');
            $pdf->SetMargins(10, 10, 10);
            $pdf->SetAutoPageBreak(true, 15);
            $pdf->AddPage();

            // ── HEADER ────────────────────────────────────────────────
            $ys = $pdf->GetY(); // 10mm
            $logo_path = $guia->empresa_foto_ticket ?? '';
            if ($logo_path && file_exists($logo_path)) {
                $pdf->Image($logo_path, 10, $ys, 58, 30);
            }

            // Company name + address (center)
            $pdf->SetXY(70, $ys + 3);
            $pdf->SetFont('Helvetica', 'B', 10.5);
            $pdf->SetTextColor(26, 26, 26);
            $pdf->MultiCell(73, 6, utf8_decode($guia->empresa_razon_social ?? ''), 0, 'C');
            $pdf->SetX(70);
            $pdf->SetFont('Helvetica', '', 6.5);
            $pdf->SetTextColor(60, 60, 60);
            $pdf->MultiCell(73, 4, utf8_decode($guia->empresa_domiciliofiscal ?? ''), 0, 'C');
            $y_company = $pdf->GetY();

            // Right box: RUC / tipo / serie
            $rx = 145; $rw = 55;
            $pdf->SetDrawColor(80, 80, 80);
            $pdf->SetLineWidth(0.4);

            $pdf->SetXY($rx, $ys);
            $pdf->SetFont('Helvetica', 'B', 11);
            $pdf->SetTextColor(26, 26, 26);
            $pdf->Cell($rw, 10, 'RUC ' . ($guia->empresa_ruc ?? ''), 1, 1, 'C');

            $pdf->SetX($rx);
            $pdf->SetFont('Helvetica', 'B', 7);
            $pdf->SetFillColor(230, 230, 230);
            $pdf->Cell($rw, 4, utf8_decode('GUIA DE REMISION ELECTRONICA'), 1, 1, 'C', true);
            $pdf->SetX($rx);
            $pdf->Cell($rw, 4, 'REMITENTE', 1, 1, 'C', true);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetX($rx);
            $pdf->SetFont('Helvetica', 'B', 14);
            $pdf->Cell($rw, 13, $serie_completa, 1, 1, 'C');

            $y_right = $pdf->GetY();
            $y_now   = max($y_company + 4, $y_right) + 4;

            // Header bottom line
            $pdf->SetDrawColor(26, 26, 26);
            $pdf->SetLineWidth(0.5);
            $pdf->Line(10, $y_now - 2, 200, $y_now - 2);
            $pdf->SetY($y_now);
            $pdf->SetLineWidth(0.3);
            $pdf->SetDrawColor(0, 0, 0);

            // Section bar helper (gray bg, white text)
            $bar = function(string $label) use ($pdf) {
                $pdf->SetFillColor(80, 80, 80);
                $pdf->SetTextColor(255, 255, 255);
                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->SetX(10);
                $pdf->Cell(190, 6, utf8_decode(' ' . $label), 0, 1, 'L', true);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Ln(2);
            };

            // ── SECTION 1: DATOS DEL DESTINATARIO ────────────────────
            $bar('DATOS DEL DESTINATARIO');

            // Left: DESTINATARIO name + city + RUC
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(30, 5, 'DESTINATARIO:', 0, 0, 'L');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->MultiAlignCell(85, 5, utf8_decode($dest_nombre), 0, 0, 'L');

            // Right: N° TRANSFERENCIA
            $pdf->SetFont('Helvetica', 'B', 7.5);
            $pdf->Cell(33, 5, utf8_decode('N° DE TRANSFERENCIA:'), 0, 0, 'L');
            $pdf->SetFont('Helvetica', 'B', 8.5);
            $pdf->SetTextColor(180, 50, 30);
            $pdf->Cell(54, 5, $serie_completa, 0, 1, 'L');
            $pdf->SetTextColor(0, 0, 0);

            // City line (destinatario — only address, no ubigeo)
            if ($dest_direccion) {
                $pdf->SetX(28);
                $pdf->SetFont('Helvetica', '', 7.5);
                $pdf->Cell(75, 4, utf8_decode($dest_direccion), 0, 0, 'L');
            }
            // FECHA EMISIÓN (right)
            $pdf->SetXY(143, $pdf->GetY() ?: ($y_now + 15));
            $pdf->SetFont('Helvetica', 'B', 7.5);
            $pdf->Cell(22, 4, utf8_decode('FECHA EMISION:'), 0, 0, 'L');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(35, 4, $f_emision, 0, 1, 'L');

            // RUC destinatario
            $pdf->SetX(10);
            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->Cell(10, 5, 'RUC:', 0, 0, 'L');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(60, 5, $dest_ruc, 0, 1, 'L');
            $pdf->Ln(2);

            // Separator
            $pdf->SetDrawColor(180, 180, 180);
            $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
            $pdf->Ln(3);
            $pdf->SetDrawColor(0, 0, 0);

            // ── SECTION 2: DATOS DEL TRASLADO ────────────────────────
            $bar('DATOS DEL TRASLADO');

            // Table header
            $pdf->SetFillColor(220, 220, 220);
            $pdf->SetFont('Helvetica', 'B', 7.5);
            $pdf->SetX(10);
            $pdf->Cell(50, 6, 'Punto Partida', 1, 0, 'C', true);
            $pdf->Cell(50, 6, 'Punto Llegada', 1, 0, 'C', true);
            $pdf->Cell(30, 6, 'Fecha Traslado', 1, 0, 'C', true);
            $pdf->Cell(60, 6, 'Motivo', 1, 1, 'C', true);
            $pdf->SetFillColor(255, 255, 255);

            // Table data row
            $y_row = $pdf->GetY();
            $pdf->SetFont('Helvetica', '', 7.5);

            // Calculate max row height
            $txt_part  = utf8_decode(($guia->guia_direccion_part ?? '-') . "\n" . $ciu_part);
            $txt_llega = utf8_decode(($guia->guia_direccion_llega ?? '-') . "\n" . $ciu_llega);
            $txt_mot   = utf8_decode($motivo);

            $pdf->SetWidths([50, 50, 30, 60]);
            $pdf->SetAligns(['L', 'L', 'C', 'L']);
            $pdf->SetX(10);
            $pdf->Row([$txt_part, $txt_llega, $f_traslado, $txt_mot], 4);
            $pdf->Ln(3);

            // ── SECTION 3: RELACIÓN DE BIENES ────────────────────────
            $bar('RELACION DE BIENES A TRANSPORTAR');

            // Table header
            $pdf->SetFillColor(220, 220, 220);
            $pdf->SetFont('Helvetica', 'B', 7.5);
            $pdf->SetX(10);
            $pdf->Cell(10, 6, utf8_decode('N°'), 1, 0, 'C', true);
            $pdf->Cell(28, 6, utf8_decode('CODIGO'), 1, 0, 'C', true);
            $pdf->Cell(102, 6, utf8_decode('DESCRIPCION'), 1, 0, 'C', true);
            $pdf->Cell(25, 6, 'CANTIDAD', 1, 0, 'C', true);
            $pdf->Cell(25, 6, 'UNIDAD', 1, 1, 'C', true);
            $pdf->SetFillColor(255, 255, 255);

            // Table rows
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetWidths([10, 28, 102, 25, 25]);
            $pdf->SetAligns(['C', 'L', 'L', 'C', 'C']);
            $n = 0;
            foreach ($detalle as $item) {
                $n++;
                $pdf->SetX(10);
                $pdf->Row([
                    $n,
                    $item->guia_remision_detalle_codigo ?? '-',
                    utf8_decode($item->guia_remision_detalle_descripcion ?? '-'),
                    number_format((float)($item->guia_remision_detalle_cantidad ?? 0), 2),
                    $item->guia_remision_detalle_um ?? 'NIU',
                ], 5);
            }
            if ($n === 0) {
                $pdf->SetX(10);
                $pdf->SetFont('Helvetica', 'I', 8);
                $pdf->SetTextColor(130, 130, 130);
                $pdf->Cell(190, 6, utf8_decode('Sin bienes registrados.'), 1, 1, 'C');
                $pdf->SetTextColor(0, 0, 0);
            }
            $pdf->Ln(3);

            // ── SECTION 4: DATOS DE TRANSPORTE Y CONFORMIDAD ─────────
            $bar('DATOS DE TRANSPORTE Y CONFORMIDAD');

            $y_s4 = $pdf->GetY();
            $col  = 62; // each of 3 columns width (3×62 + 2×1gap + 2×margins = 190mm)
            $x1 = 10; $x2 = 10 + $col + 1; $x3 = 10 + ($col + 1) * 2;

            // Sub-headers (small gray bar)
            $pdf->SetFillColor(200, 200, 200);
            $pdf->SetFont('Helvetica', 'B', 7);
            $pdf->SetX($x1);
            $pdf->Cell($col, 5, 'UNIDAD DE TRANSPORTE / CONDUCTOR', 1, 0, 'C', true);
            $pdf->Cell(1, 5, '', 0, 0);
            $pdf->Cell($col, 5, 'MODALIDAD DE TRANSPORTE', 1, 0, 'C', true);
            $pdf->Cell(1, 5, '', 0, 0);
            $pdf->Cell($col, 5, 'CONFORMIDAD DEL RECEPTOR', 1, 1, 'C', true);
            $pdf->SetFillColor(255, 255, 255);

            $y_sub = $pdf->GetY();

            // ── Col 1: Conductor ─────────────────────────────────────
            $cond_label_w = 28;
            $cond_val_w   = $col - $cond_label_w;

            $pdf->SetFont('Helvetica', '', 7.5);

            // Conductor name (MultiCell so long names wrap inside the column)
            $pdf->SetXY($x1, $y_sub + 3);
            $pdf->Cell($cond_label_w, 5, 'Conductor:', 0, 0, 'L');
            $pdf->MultiCell($cond_val_w, 5, utf8_decode($cond_nombre ?: ''), 'B', 'L');

            // DNI Conductor
            $pdf->SetX($x1);
            $pdf->Cell($cond_label_w, 5, $cond_tipo . ' Conductor:', 0, 0, 'L');
            $pdf->Cell($cond_val_w, 5, $guia->guia_conductor_numero ?? '', 'B', 1, 'L');

            // Placa
            $pdf->SetX($x1);
            $pdf->Cell($cond_label_w, 5, utf8_decode('Placa Vehiculo:'), 0, 0, 'L');
            $pdf->Cell($cond_val_w, 5, $guia->guia_placa ?? '', 'B', 1, 'L');

            // Licencia
            $pdf->SetX($x1);
            $pdf->Cell($cond_label_w, 5, 'Licencia:', 0, 0, 'L');
            $pdf->Cell($cond_val_w, 5, $guia->guia_licencia_conductor ?? '', 'B', 1, 'L');

            $y_col1_end = $pdf->GetY();

            // ── Col 2: Modalidad ─────────────────────────────────────
            $pdf->SetXY($x2, $y_sub + 3);
            $pdf->SetFont('Helvetica', '', 8);

            // Checkboxes Público / Privado
            $pub_mark = $es_publico ? 'X' : ' ';
            $pri_mark = $es_publico ? ' ' : 'X';
            $pdf->Cell($col, 6, utf8_decode("Publico ($pub_mark)     Privado ($pri_mark)"), 0, 1, 'L');
            $pdf->SetX($x2);

            // Cantidad bultos
            $pdf->SetFont('Helvetica', 'B', 7.5);
            $pdf->Cell(32, 5, 'Cantidad de Bultos:', 0, 0, 'L');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell($col - 32, 5, (string)($guia->guia_n_bulto ?? ''), 'B', 1, 'L');
            $pdf->SetX($x2);

            // Peso total
            $pdf->SetFont('Helvetica', 'B', 7.5);
            $pdf->Cell(32, 5, 'Peso Total (kg):', 0, 0, 'L');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell($col - 32, 5, number_format((float)($guia->guia_peso_bruto ?? 0), 2), 'B', 1, 'L');

            $y_col2_end = $pdf->GetY();

            // ── Col 3: Conformidad ───────────────────────────────────
            $pdf->SetXY($x3, $y_sub + 3);
            $pdf->SetFont('Helvetica', '', 7.5);

            // Nombre
            $pdf->Cell(14, 5, 'Nombre:', 0, 0, 'L');
            $pdf->Cell($col - 14, 5, '', 'B', 1, 'L');
            $pdf->SetX($x3);

            // DNI
            $pdf->Cell(10, 5, 'DNI:', 0, 0, 'L');
            $pdf->Cell($col - 10, 5, '', 'B', 1, 'L');
            $pdf->SetX($x3);

            // Firma y sello blank area
            $pdf->Ln(2);
            $pdf->SetX($x3);
            $pdf->Cell($col, 12, '', 0, 1, 'C'); // blank area for signature
            $pdf->SetX($x3);
            $pdf->SetFont('Helvetica', 'B', 7.5);
            $pdf->Cell($col, 4, 'Firma y Sello', 0, 1, 'C');

            $y_col3_end = $pdf->GetY();

            // Draw vertical dividers for section 4
            $y_s4_end = max($y_col1_end, $y_col2_end, $y_col3_end) + 2;
            $pdf->SetDrawColor(180, 180, 180);
            $pdf->SetLineWidth(0.3);
            $pdf->Line(10,       $y_s4,    10,       $y_s4_end);
            $pdf->Line(10+$col,  $y_s4,    10+$col,  $y_s4_end);
            $pdf->Line(10+$col+1,$y_s4,    10+$col+1,$y_s4_end);
            $pdf->Line(10+$col*2+1,$y_s4,  10+$col*2+1,$y_s4_end);
            $pdf->Line(10+$col*2+2,$y_s4,  10+$col*2+2,$y_s4_end);
            $pdf->Line(10+$col*3+2,$y_s4,  10+$col*3+2,$y_s4_end);
            $pdf->Line(10, $y_s4_end, 10+$col*3+2, $y_s4_end);
            $pdf->SetDrawColor(0, 0, 0);

            $pdf->SetY($y_s4_end + 5);

            // ── FOOTER ────────────────────────────────────────────────
            $pdf->SetFont('Helvetica', 'I', 7.5);
            $pdf->SetTextColor(60, 60, 60);
            $pdf->Cell(190, 5, utf8_decode('"BIENES TRANSFERIDOS EN LA AMAZONIA PARA SER CONSUMIDOS EN LA MISMA."'), 0, 1, 'C');
            $fecha_gen = date('d/m/Y H:i:s');
            $pdf->SetFont('Helvetica', 'I', 7);
            $pdf->Cell(190, 4, utf8_decode("Documento generado por Sistema | $fecha_gen"), 0, 1, 'C');

            // QR code (bottom-left if file exists)
            $qr_ruc   = $guia->empresa_ruc ?? '';
            $qr_tipo  = $guia->guia_tipo ?? '09';
            $qr_serie = $guia->guia_serie ?? 'T001';
            $qr_corr  = $guia->guia_correlativo ?? '';
            $qr_path  = public_path('ApiFacturacion/imagenqr/' . $qr_ruc . '-' . $qr_tipo . '-' . $qr_serie . '-' . $qr_corr . '.png');
            if (file_exists($qr_path)) {
                $y_qr = $pdf->GetY() + 3;
                $pdf->Image($qr_path, 10, $y_qr, 28, 28);
            }

            $nombre = 'Guia_' . ($guia->guia_serie ?? 'T001') . '-' . ($guia->guia_correlativo ?? '') . '.pdf';
            $pdf->Output('I', $nombre);
            exit;

        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response('Error al generar PDF: ' . $e->getMessage(), 500);
        }
    }

    public function verificar_serie(Request $request)
    {
        try {
            $numero_serie = trim($request->input('numero_serie', ''));
            if ($numero_serie === '') {
                return response()->json(['existe' => false]);
            }
            $existe = DB::table('series')->where('numero_serie', $numero_serie)->exists();
            return response()->json(['existe' => $existe]);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response()->json(['existe' => false]);
        }
    }

    public function series_por_producto(Request $request)
    {
        try {
            $series = \App\Models\Series::where('id_pro', $request->id_pro)
                ->orderByRaw("FIELD(estado,'disponible','vendido') ASC")
                ->get(['id_serie', 'numero_serie', 'numero_motor', 'color', 'anio_fabricacion', 'estado']);
            return response()->json(['code' => 1, 'data' => $series]);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response()->json(['code' => 0, 'data' => []]);
        }
    }

    public function lotes_por_producto(Request $request)
    {
        try {
            $lotes = \App\Models\Lotes::where('id_pro', $request->id_pro)
                ->orderByRaw("FIELD(estado,'disponible','agotado') ASC")
                ->get(['id_lote', 'numero_lote', 'fecha_vencimiento', 'cantidad', 'estado', 'observaciones']);
            return response()->json(['code' => 1, 'data' => $lotes]);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response()->json(['code' => 0, 'data' => []]);
        }
    }

}
