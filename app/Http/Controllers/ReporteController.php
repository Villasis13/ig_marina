<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Cita;
use App\Models\Empresa;
use App\Models\General;
use App\Models\Logs;
use App\Models\Opciones;
use App\Models\Paciente_sucursal;
use App\Models\Reporte;
use App\Models\Serie;
use App\Models\Submenu;
use App\Models\Sucursal;
use App\Models\Tipo_documento;
use App\Models\Tipo_pago;
use App\Models\Tratamientos_sucursal;
use App\Models\User;
use App\Models\User_sucursal;
use App\Models\Ventas;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReporteController extends Controller
{
    private $logs;
    private $general;
    private $usuarios;
    private $empresas;
    private $opciones;
    private $submenu;
    private $caja;
    private $serie;
    private $tipos_de_pago;
    private $tipo_documento;
    private $ventas;
    private $cliente;
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


    public function ventas_por_caja(Request $request)
    {
        try {
            $check         = 'd';
            $fecha_inicio  = date('Y-m-d');
            $fecha_fin     = date('Y-m-d');
            $id_caja_numero = null;
            $reporte       = null;
            $searched      = false;

            $cajas_disponibles = DB::table('caja_numero')
                ->orderBy('caja_numero_nombre')
                ->get();

            if (isset($request->enviar)) {
                $request->validate(['desde' => 'required', 'hasta' => 'required', 'opcion' => 'required']);
                $fecha_inicio   = $request->desde;
                $fecha_fin      = $request->hasta;
                $check          = $request->opcion;
                $id_caja_numero = $request->input('id_caja_numero') ? (int)$request->input('id_caja_numero') : null;
                $searched       = true;
                $reporte        = $this->_calcular_reporte_caja($fecha_inicio, $fecha_fin, $id_caja_numero);
            }

            $opciones = $this->submenu->optiones_por_vista("ventas_por_caja");
            return view('reporte/ventas_por_caja', compact(
                'opciones', 'fecha_inicio', 'fecha_fin', 'check',
                'cajas_disponibles', 'id_caja_numero', 'reporte', 'searched'
            ));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }

    private function _calcular_reporte_caja(string $desde, string $hasta, ?int $id_caja_numero): ?array
    {
        $q = DB::table('caja as c')
            ->join('caja_numero as cn', 'cn.id_caja_numero', '=', 'c.id_caja_numero')
            ->join('users as ua', 'ua.id_users', '=', 'c.id_users_apertura')
            ->join('persona as pa', 'pa.id_persona', '=', 'ua.id_persona')
            ->leftJoin('users as uc', 'uc.id_users', '=', 'c.id_users_cierre')
            ->leftJoin('persona as pc', 'pc.id_persona', '=', 'uc.id_persona')
            ->where('c.caja_fecha', '>=', $desde)
            ->where('c.caja_fecha', '<=', $hasta);
        if ($id_caja_numero) $q->where('c.id_caja_numero', $id_caja_numero);

        $turnos = $q->select(
            'c.*',
            'cn.caja_numero_nombre',
            DB::raw("CONCAT(pa.persona_nombre, ' ', pa.persona_apellido_paterno) as nombre_apertura"),
            DB::raw("TRIM(CONCAT(IFNULL(pc.persona_nombre,''), ' ', IFNULL(pc.persona_apellido_paterno,''))) as nombre_cierre")
        )->orderBy('c.caja_fecha')->orderBy('c.caja_fecha_apertura')->get();

        if ($turnos->isEmpty()) return null;

        $idsCaja = $id_caja_numero
            ? [$id_caja_numero]
            : $turnos->pluck('id_caja_numero')->unique()->values()->toArray();

        $ventasPorMedio = DB::table('ventas_detalle_pagos as vdp')
            ->select('tp.tipo_pago_nombre', DB::raw('SUM(vdp.venta_detalle_pago_monto) as total'))
            ->join('ventas as v', 'v.id_venta', '=', 'vdp.id_venta')
            ->join('tipo_pago as tp', 'tp.id_tipo_pago', '=', 'vdp.id_tipo_pago')
            ->whereIn('v.id_caja_numero', $idsCaja)
            ->whereDate('v.venta_fecha', '>=', $desde)
            ->whereDate('v.venta_fecha', '<=', $hasta)
            ->where([['v.anulado_sunat', 0], ['v.venta_cancelar', 1], ['v.id_formas_pago', 1]])
            ->whereIn('v.venta_tipo', ['01', '03'])
            ->groupBy('tp.id_tipo_pago', 'tp.tipo_pago_nombre')
            ->orderByDesc('total')
            ->get();

        $totalVentas   = round((float)$ventasPorMedio->sum('total'), 2);
        $montoApertura = round((float)$turnos->sum('caja_apertura'), 2);
        $montoCierre   = round((float)$turnos->sum('caja_cierre'), 2);

        $tipoEfectivo = DB::table('tipo_pago')
            ->where('tipo_pago_estado', 1)
            ->where('tipo_pago_nombre', 'like', '%efectivo%')
            ->first();
        $ventasEfectivo = $tipoEfectivo
            ? round((float) DB::table('ventas_detalle_pagos as vdp')
                ->join('ventas as v', 'v.id_venta', '=', 'vdp.id_venta')
                ->whereIn('v.id_caja_numero', $idsCaja)
                ->whereDate('v.venta_fecha', '>=', $desde)
                ->whereDate('v.venta_fecha', '<=', $hasta)
                ->where([['v.anulado_sunat', 0], ['v.venta_cancelar', 1], ['v.id_formas_pago', 1]])
                ->whereIn('v.venta_tipo', ['01', '03'])
                ->where('vdp.id_tipo_pago', $tipoEfectivo->id_tipo_pago)
                ->sum('vdp.venta_detalle_pago_monto'), 2)
            : 0.0;

        $notasCredito = round((float) DB::table('ventas as v')
            ->whereIn('v.id_caja_numero', $idsCaja)
            ->whereDate('v.venta_fecha', '>=', $desde)
            ->whereDate('v.venta_fecha', '<=', $hasta)
            ->where('v.venta_tipo', '07')
            ->sum('v.venta_total'), 2);

        $totalSistema = round($montoApertura + $ventasEfectivo - $notasCredito, 2);
        $diferencia   = round($montoCierre - $totalSistema, 2);

        $comprobantes = DB::table('ventas as v')
            ->select(
                'v.id_venta', 'v.venta_tipo', 'v.venta_serie', 'v.venta_correlativo',
                'v.venta_total', 'v.venta_fecha', 'cn2.caja_numero_nombre',
                DB::raw("CASE WHEN cl.id_tipo_documento = 4 THEN cl.cliente_razonsocial ELSE cl.cliente_nombre END as cliente_nombre"),
                'cl.cliente_numero'
            )
            ->join('clientes as cl', 'cl.id_clientes', '=', 'v.id_clientes')
            ->join('caja_numero as cn2', 'cn2.id_caja_numero', '=', 'v.id_caja_numero')
            ->whereIn('v.id_caja_numero', $idsCaja)
            ->whereDate('v.venta_fecha', '>=', $desde)
            ->whereDate('v.venta_fecha', '<=', $hasta)
            ->where([['v.anulado_sunat', 0], ['v.venta_cancelar', 1], ['v.id_formas_pago', 1]])
            ->whereIn('v.venta_tipo', ['01', '03'])
            ->orderBy('v.venta_fecha')
            ->orderBy('v.venta_serie')
            ->orderBy('v.venta_correlativo')
            ->get();

        $nombreCaja = $id_caja_numero
            ? ($turnos->first()->caja_numero_nombre ?? 'Caja')
            : 'Todas las cajas';

        $resumen = (object)[
            'monto_apertura'  => $montoApertura,
            'total_ventas'    => $totalVentas,
            'ventas_efectivo' => $ventasEfectivo,
            'notas_credito'   => $notasCredito,
            'total_sistema'   => $totalSistema,
            'monto_cierre'    => $montoCierre,
            'diferencia'      => $diferencia,
            'total_turnos'    => $turnos->count(),
            'turnos_abiertos' => $turnos->where('caja_estado', 1)->count(),
        ];

        return compact('turnos', 'resumen', 'ventasPorMedio', 'comprobantes', 'nombreCaja');
    }
    public function reporte_de_productos(Request $request)
    {
        try {
            $datos_usuario  = $this->usuarios->listar_datos_usuario(Auth::id());
            $check          = "d";
            $fecha_inicio   = date('Y-m-d');
            $fecha_fin      = date('Y-m-d');
            $consultorios   = "";
            $productos      = [];
            $searched       = false;
            $id_pro_filtro  = null;
            $pro_filtro_nombre = null;
            $pro_filtro_codigo = null;

            if (isset($request->enviar)) {
                $request->validate(['desde' => 'required', 'hasta' => 'required', 'opcion' => 'required']);

                $fecha_inicio  = $request->desde;
                $fecha_fin     = $request->hasta;
                $check         = $request->opcion;
                $id_pro_filtro = $request->input('id_pro_filtro') ?: null;
                $searched      = true;

                $query = DB::table('productos')->where([['impuesto_bolsa', '=', 0], ['pro_estado', '=', 1]]);
                if ($id_pro_filtro) {
                    $query->where('id_pro', $id_pro_filtro);
                }
                $productos = $query->get()->all();

                foreach ($productos as $pro) {
                    $pro->mas_vendidos = DB::table('ventas as v')
                        ->join('ventas_detalle as vd', 'vd.id_venta', '=', 'v.id_venta')
                        ->whereDate('v.venta_fecha', '>=', $fecha_inicio)
                        ->whereDate('v.venta_fecha', '<=', $fecha_fin)
                        ->where([['vd.id_pro', '=', $pro->id_pro], ['v.anulado_sunat', '=', 0], ['v.venta_cancelar', '=', 1], ['v.id_formas_pago', '=', 1]])
                        ->count();
                }
                usort($productos, fn($a, $b) => $b->mas_vendidos <=> $a->mas_vendidos);

                if ($id_pro_filtro) {
                    $pro_info = DB::table('productos')->where('id_pro', $id_pro_filtro)->first();
                    $pro_filtro_nombre = $pro_info->pro_nombre ?? null;
                    $pro_filtro_codigo = $pro_info->pro_codigo ?? null;
                }
            }

            $opciones = $this->submenu->optiones_por_vista("reporte_de_productos");
            return view('reporte/reporte_de_productos', compact(
                'opciones', 'productos', 'check', 'fecha_inicio', 'fecha_fin',
                'datos_usuario', 'consultorios', 'searched',
                'id_pro_filtro', 'pro_filtro_nombre', 'pro_filtro_codigo'
            ));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }
    public function buscar_clientes_reporte(Request $request)
    {
        $q = trim($request->input('q', ''));
        $clientes = DB::table('clientes')
            ->where('cliente_estado', 1)
            ->where(function ($query) use ($q) {
                $query->where('cliente_nombre',      'like', '%' . $q . '%')
                      ->orWhere('cliente_razonsocial','like', '%' . $q . '%')
                      ->orWhere('cliente_numero',     'like', '%' . $q . '%');
            })
            ->select('id_clientes', 'cliente_nombre', 'cliente_razonsocial', 'cliente_numero', 'id_tipo_documento')
            ->limit(15)
            ->get();
        return response()->json($clientes);
    }

    public function reporte_de_ventas(Request $request)
    {
        try {
            $datos_usuario = $this->usuarios->listar_datos_usuario(Auth::id());
            $empresas      = "";
            $infoEmpre     = "";
            $datos         = [];
            $sumast        = [];
            $fechasVent    = [];
            $id_empresa    = "";
            $check         = "d";
            $fechas        = [];
            $fecha_inicio  = date('Y-m-d');
            $fecha_fin     = date('Y-m-d');
            $consultorios  = "";

            // Variables para filtro por cliente
            $ventas_cliente      = null;   // null = no se aplicó filtro de cliente
            $cliente_seleccionado = null;
            $id_cliente_filtro   = null;

            if (isset($request->enviar)) {
                $request->validate([
                    'desde'  => 'required',
                    'hasta'  => 'required',
                    'opcion' => 'required',
                ]);

                $fecha_inicio      = $request->desde;
                $fecha_fin         = $request->hasta;
                $check             = $request->opcion;
                $id_cliente_filtro = $request->input('id_cliente_filtro') ?: null;

                if ($id_cliente_filtro) {
                    // ── Reporte por cliente ───────────────────────────────
                    $cliente_seleccionado = DB::table('clientes')
                        ->where('id_clientes', $id_cliente_filtro)
                        ->first();
                    $ventas_cliente = $this->ventas->listar_ventas_cliente(
                        $id_cliente_filtro, $fecha_inicio, $fecha_fin, 1
                    );
                } else {
                    // ── Reporte general por día ───────────────────────────
                    $fecha1       = new \DateTime($fecha_inicio);
                    $fecha_actual = new \DateTime($fecha_fin);
                    $fecha1->modify('-1 day');
                    $fecha_actual->modify('-1 day');
                    $cantidad_dias = $fecha_actual->diff($fecha1)->days;

                    for ($da = 0; $da <= $cantidad_dias; $da++) {
                        $fecha_actual = $fecha1->modify('+1 day');
                        $dia          = $fecha_actual->format('Y-m-d');
                        $ventas       = $this->ventas->listar_ventas_Reporte($dia, 1);
                        $cantidad     = 0;
                        $sumaTotal    = 0;
                        foreach ($ventas as $c) {
                            $sumaTotal += $c->venta_total;
                            $cantidad++;
                        }
                        $fechas[] = [
                            'dia'          => $dia,
                            'ConteoVentas' => $cantidad,
                            'sumVentas'    => $sumaTotal,
                        ];
                    }
                    foreach ($fechas as $f) {
                        $sumast[]    = date('d-m-Y', strtotime($f['dia']));
                        $fechasVent[] = $f['sumVentas'];
                    }
                }
            }

            $opciones = $this->submenu->optiones_por_vista("reporte_de_ventas");
            return view('reporte/reporte_de_ventas', compact(
                'opciones', 'sumast', 'fechasVent', 'check', 'fechas',
                'fecha_inicio', 'infoEmpre', 'datos', 'fecha_fin',
                'datos_usuario', 'empresas', 'id_empresa', 'consultorios',
                'ventas_cliente', 'cliente_seleccionado', 'id_cliente_filtro'
            ));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }

    }
    public function proveedores_reporte(Request $request)
    {
        try {
            // Sacamos la información del dueño
            $datos_usuario = $this->usuarios->listar_datos_usuario(Auth::id());
            $proveedores = [];
            $check = "d";
            $fecha_inicio = date('Y-m-d');
            $fecha_fin = date('Y-m-d');


            if (isset($request->enviar)){
                $validateData = $request->validate([
                    'desde'=>'required',
                    'hasta'=>'required',
                    'opcion'=>'required',
                ]);
                if ($validateData){
                    $fecha_inicio = $_POST['desde'];
                    $fecha_fin = $_POST['hasta'];
                    $check = $_POST['opcion'];

                    $proveedores = DB::table('proveedores')
                        ->where('proveedores_estado', '=', 1)
                        ->get();

                    foreach ($proveedores as $pro) {
                        $pro->productos = DB::table('productos as p')
                            ->join('orden_compra_detalle as od', 'p.id_pro', '=', 'od.id_pro')
                            ->join('orden_compra as oc', 'oc.id_orden_compra', '=', 'od.id_orden_compra')
                            ->where('oc.orden_compra_fecha','>=',$fecha_inicio)
                            ->where('oc.orden_compra_fecha','<=',$fecha_fin)
                            ->where([['p.pro_estado','=',1], ['oc.orden_compra_estado','=',1], ['oc.id_proveedores','=',$pro->id_proveedores]])
                            ->groupBy('p.id_pro','p.pro_nombre')
                            ->select('p.id_pro','p.pro_nombre')->get();
                        foreach ($pro->productos as $pr){
                            $pr->ultimo_precio = DB::table('orden_compra_detalle as od')
                                ->join('orden_compra as oc','oc.id_orden_compra','=','od.id_orden_compra')
                                ->where([['od.id_pro','=',$pr->id_pro],['oc.orden_compra_estado','=',1]])->orderBy('od.id_detalle_compra','desc')->first();
                        }
                    }

                }
            }

            $opciones = $this->submenu->optiones_por_vista("proveedores_reporte");
            return view('reporte/proveedores_reporte', compact('opciones','check','fecha_inicio','proveedores','fecha_fin','datos_usuario'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }

    }






    public function reporteCitas_excel(Request $request )
    {
        $id_empresa = $_GET['empresa_id'];
        $inicio = $_GET['inicio'];
        $final = $_GET['final'];

        $datos = $this->sucursal->listarSucursalesEmpresa($id_empresa);
        foreach ($datos as $d){
            $a = 0;
            $d->citas = $this->citas->listar_citas_id_su($d->id_su,$inicio,$final);
            foreach ($d->citas as $c){
                $validarNC = DB::table('ventas')->where([['venta_tipo','=','07'],['serie_modificar','=',$c->venta_serie],['correlativo_modificar','=',$c->venta_correlativo],['tipo_documento_modificar','=',$c->venta_tipo],['id_su','=',$c->id_su]])->first();
                $validarND = DB::table('ventas')->where([['venta_tipo','=','08'],['serie_modificar','=',$c->venta_serie],['correlativo_modificar','=',$c->venta_correlativo],['tipo_documento_modificar','=',$c->venta_tipo],['id_su','=',$c->id_su]])->first();
                $sumarSub = $c->venta_total;
                if($validarNC){
                    $sumarSub = $sumarSub - $validarNC->venta_total;
                }
                if($validarND){
                    $sumarSub = $sumarSub + $validarND->venta_total;
                }
                $c->venta_total = $sumarSub;
                $a+= $sumarSub;
            }
            $d->conteo_citas = count($this->citas->listar_citas_id_su($d->id_su,$inicio,$final));
            $d->totalC = $a;
        }


        $spreadsheet = new Spreadsheet();
        $sheet1  = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Reporte General');
        // Hoja 2: Reporte Detallado
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Reporte Detallado');

        $mensaje = "RESULTADO DE LA BUSQUEDA : ";
        if(isset($inicio,$final)){
            $mensaje.= "DEL ".date("d-m-Y",strtotime($inicio))." HASTA : ".date("d-m-Y",strtotime($final));
        }
        // Agregar título en negritas
        $sheet1->setCellValue('A1', 'REPORTE DE CITAS');
        $titleStyle = $sheet1->getStyle('A1');
        $titleStyle->getFont()->setSize(16); // Tamaño de letra 14
        $titleStyle->getFont()->setBold(true); // Hacer el título en negritas
        // Combinar celdas para el título
        $sheet1->mergeCells('A1:E1');
        // Agregar título en negritas
        $sheet1->setCellValue('A2', $mensaje);
        $titleStyle = $sheet1->getStyle('A2');
        $titleStyle->getFont()->setSize(12); // Tamaño de letra 14
        $titleStyle->getFont()->setBold(true); // Hacer el título en negritas
        // Combinar celdas para el título
        $sheet1->mergeCells('A2:E2');
        // Agregar datos a las celdas para la cabecera
        $row = 3;
        foreach ( $datos as $d){
            $sheet1->setCellValue('A'.$row, $d->su_nombre_comercial);
            $sheet1->setCellValue('B'.$row, 'N° DE CITAS : '.$d->conteo_citas);
            $sheet1->setCellValue('C'.$row, 'MONTO RECAUDADO : S/'.$d->totalC);
            $sheet1->setCellValue('D'.$row, '');
            $sheet1->setCellValue('E'.$row, '');
            $sheet1->setCellValue('F'.$row, '');
            $sheet1->setCellValue('G'.$row, '');

            // Establecer el ancho de las columnas A a E
            $sheet1->getColumnDimension('A')->setWidth(35); // Ancho de la columna A
            $sheet1->getColumnDimension('B')->setWidth(25); // Ancho de la columna B
            $sheet1->getColumnDimension('C')->setWidth(40); // Ancho de la columna C
            $sheet1->getColumnDimension('D')->setWidth(40); // Ancho de la columna D
            $sheet1->getColumnDimension('E')->setWidth(40); // Ancho de la columna E
            $sheet1->getColumnDimension('F')->setWidth(40); // Ancho de la columna F
            $sheet1->getColumnDimension('G')->setWidth(40); // Ancho de la columna G
            $sheet1->getColumnDimension('H')->setWidth(40); // Ancho de la columna H
            $sheet1->getColumnDimension('I')->setWidth(40); // Ancho de la columna I
            // Obtener la fila 1 completa (desde A hasta E) como un rango
            $cellRange = 'A'.$row.':I'.$row;
            $rowStyle = $sheet1->getStyle($cellRange);
            // Establecer el fondo, tamaño de letra y hacer negritas en toda la fila 1 y cambiar color del texto
            $rowStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0b1892'); // Fondo
            $rowStyle->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); // color de texto
            $rowStyle->getFont()->setSize(14); // Tamaño de letra 14
            $rowStyle->getFont()->setBold(true); // Hacer negritas
            $row++;
            if (count($d->citas) > 0){
                foreach ($d->citas as $c){
                    $sheet1->setCellValue('A' . $row, '');
                    $sheet1->setCellValue('B' . $row, 'N° DE CITA : ');
                    $sheet1->setCellValue('C' . $row, $c->ci_serie.' - '.$c->ci_correlativo);
                    $sheet1->setCellValue('D' . $row, 'MÉDICO : ');
                    $sheet1->setCellValue('E' . $row, $c->persona_nombre);
                    $sheet1->setCellValue('F' . $row, 'PACIENTE : ');
                    $sheet1->setCellValue('G' . $row, $c->pa_razon_social);
                    $sheet1->setCellValue('H' . $row, 'TOTAL : ');
                    $sheet1->setCellValue('I' . $row, $c->venta_total);
                    $row++;
                }
                $row++;
                $sheet1->setCellValue('A' . $row, '');
                $sheet1->setCellValue('B' . $row, '');
                $sheet1->setCellValue('C' . $row, '');
                $sheet1->setCellValue('D' . $row, '');
                $sheet1->setCellValue('E' . $row, '');
                $sheet1->setCellValue('F' . $row, '');
                $sheet1->setCellValue('G' . $row, '');
                $sheet1->setCellValue('H' . $row, '');
                $sheet1->setCellValue('I' . $row, '');
            }
        }

        // HOJA 2 EXCEL
        $mensaje2 = "RESULTADO DE LA BUSQUEDA : ";
        if(isset($inicio,$final)){
            $mensaje2.= "DEL ".date("d-m-Y",strtotime($inicio))." HASTA : ".date("d-m-Y",strtotime($final));
        }
        // Agregar título en negritas
        $sheet2->setCellValue('A1', 'REPORTE DE CITAS');
        $titleStyle = $sheet2->getStyle('A1');
        $titleStyle->getFont()->setSize(16); // Tamaño de letra 14
        $titleStyle->getFont()->setBold(true); // Hacer el título en negritas
        // Combinar celdas para el título
        $sheet2->mergeCells('A1:E1');
        // Agregar título en negritas
        $sheet2->setCellValue('A2', $mensaje2);
        $titleStyle = $sheet2->getStyle('A2');
        $titleStyle->getFont()->setSize(12); // Tamaño de letra 14
        $titleStyle->getFont()->setBold(true); // Hacer el título en negritas
        // Combinar celdas para el título
        $sheet2->mergeCells('A2:E2');
        // Agregar datos a las celdas para la cabecera
        $row2 = 3;
        foreach ( $datos as $d){
            $sheet2->setCellValue('A'.$row2, $d->su_nombre_comercial);
            $sheet2->setCellValue('B'.$row2, '');
            $sheet2->setCellValue('C'.$row2, 'MONTO RECAUDADO : S/'.$d->totalC);
            $sheet2->setCellValue('D'.$row2, '');
            $sheet2->setCellValue('E'.$row2, '');
            $sheet2->setCellValue('F'.$row2, '');
            $sheet2->setCellValue('G'.$row2, '');
            $sheet2->setCellValue('H'.$row2, '');
            $sheet2->setCellValue('I'.$row2, '');

            // Establecer el ancho de las columnas A a E
            $sheet2->getColumnDimension('A')->setWidth(35); // Ancho de la columna A
            $sheet2->getColumnDimension('B')->setWidth(25); // Ancho de la columna B
            $sheet2->getColumnDimension('C')->setWidth(40); // Ancho de la columna C
            $sheet2->getColumnDimension('D')->setWidth(40); // Ancho de la columna D
            $sheet2->getColumnDimension('E')->setWidth(40); // Ancho de la columna E
            $sheet2->getColumnDimension('F')->setWidth(40); // Ancho de la columna E
            $sheet2->getColumnDimension('G')->setWidth(40); // Ancho de la columna E
            $sheet2->getColumnDimension('H')->setWidth(40); // Ancho de la columna E
            $sheet2->getColumnDimension('I')->setWidth(40); // Ancho de la columna E
            // Obtener la fila 1 completa (desde A hasta E) como un rango
            $cellRange = 'A'.$row2.':I'.$row2;
            $rowStyle = $sheet2->getStyle($cellRange);
            // Establecer el fondo, tamaño de letra y hacer negritas en toda la fila 1 y cambiar color del texto
            $rowStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0b1892'); // Fondo
            $rowStyle->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); // color de texto
            $rowStyle->getFont()->setSize(14); // Tamaño de letra 14
            $rowStyle->getFont()->setBold(true); // Hacer negritas
            $row2++;
            if (count($d->citas) > 0){
                foreach ($d->citas as $c){
                    $sheet2->setCellValue('A' . $row2, '');
                    $sheet2->setCellValue('B' . $row2, 'N° DE CITA : ');
                    $sheet2->setCellValue('C' . $row2, $c->ci_serie.' - '.$c->ci_correlativo);
                    $sheet2->setCellValue('D' . $row2, 'MÉDICO : ');
                    $sheet2->setCellValue('E' . $row2, $c->persona_nombre);
                    $sheet2->setCellValue('F' . $row2, 'PACIENTE : ');
                    $sheet2->setCellValue('G' . $row2, $c->pa_razon_social);
                    $sheet2->setCellValue('H' . $row2, '');
                    $sheet2->setCellValue('I' . $row2, '');
                    $row2++;
                    foreach ($c->detalle as $deta){
                        $sheet2->setCellValue('A' . $row2, '');
                        $sheet2->setCellValue('B' . $row2, '');
                        $sheet2->setCellValue('C' . $row2, '');
                        $sheet2->setCellValue('D' . $row2, 'TRATAMIENTO : ');
                        $sheet2->setCellValue('E' . $row2, $deta->venta_detalle_tratamiento);
                        $sheet2->setCellValue('F' . $row2, 'CANTIDAD : ');
                        $sheet2->setCellValue('G' . $row2, $deta->venta_detalle_cantidad);
                        $sheet2->setCellValue('H' . $row2, 'SUBTOTAL : S/ ');
                        $sheet2->setCellValue('I' . $row2, $deta->venta_detalle_importe_total);
                        $row2++;
                    }
                }
                $row2++;
                $sheet2->setCellValue('A' . $row2, '');
                $sheet2->setCellValue('B' . $row2, '');
                $sheet2->setCellValue('C' . $row2, '');
                $sheet2->setCellValue('D' . $row2, '');
                $sheet2->setCellValue('E' . $row2, '');
                $sheet2->setCellValue('F' . $row2, '');
                $sheet2->setCellValue('G' . $row2, '');
                $sheet2->setCellValue('H' . $row2, '');
                $sheet2->setCellValue('I' . $row2, '');
            }
        }
        $nombre_excel = "Reporte_general_detallado_" . date('d-m-Y') . '.xlsx';
        $response = response()->stream(
            function () use ($spreadsheet) {
                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename=' . $nombre_excel,
            ]
        );
        return $response;
    }
    public function reporteCitasMedico_excel(Request $request )
    {
        $id_empresa = $_GET['empresa_id'];
        $inicio = $_GET['inicio'];
        $final = $_GET['final'];
        $doctores = $this->user_sucursal->listar_doctores_empresa($id_empresa);
        foreach ($doctores as $do){
            $e = 0;
            $conteoC = 0;
            $do->consultorios = $this->citas->listar_citas_x_medico($do->id_users,$id_empresa,$inicio,$final);
            foreach ($do->consultorios as $co){
//                            $e+= $co->total_ventas;
                $ventas_sucursal = DB::table('ventas')
                    ->whereBetween(DB::raw('DATE(venta_fecha)'), [$inicio, $final])
                    ->where([['id_su','=',$co->id_su],['anulado_sunat','=',0],['venta_cancelar','=',1]])->whereIn('venta_tipo', ['01', '03'])->get();

//                $ventas_sucursal = DB::table('ventas')->where([['id_su','=',$co->id_su],['anulado_sunat','=',0],['venta_cancelar','=',1],['venta_tipo','!=','07'],['venta_tipo','!=','08']])->get();
                $totalConsul = 0;
                $conteoC+= count($ventas_sucursal);
                foreach ($ventas_sucursal as $v){
                    $validarNC = DB::table('ventas')->where([['venta_tipo','=','07'],['serie_modificar','=',$v->venta_serie],['correlativo_modificar','=',$v->venta_correlativo],['tipo_documento_modificar','=',$v->venta_tipo],['id_su','=',$v->id_su]])->first();
                    $validarND = DB::table('ventas')->where([['venta_tipo','=','08'],['serie_modificar','=',$v->venta_serie],['correlativo_modificar','=',$v->venta_correlativo],['tipo_documento_modificar','=',$v->venta_tipo],['id_su','=',$v->id_su]])->first();
                    $subTotalConsul = $v->venta_total;
                    if($validarNC){
                        $subTotalConsul = $subTotalConsul - $validarNC->venta_total;
                    }
                    if($validarND){
                        $subTotalConsul = $subTotalConsul + $validarND->venta_total;
                    }
                    $totalConsul += $subTotalConsul;
                }
                $co->total_ventas = $totalConsul;
                $e+= $co->total_ventas;
            }
            $do->ciCon = $conteoC;
            $do->ciSum = $e;
        }

        $spreadsheet = new Spreadsheet();
        $sheet1  = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Reporte General');
        $mensaje = "RESULTADO DE LA BUSQUEDA : ";
        if(isset($inicio,$final)){
            $mensaje.= "DEL ".date("d-m-Y",strtotime($inicio))." HASTA : ".date("d-m-Y",strtotime($final));
        }
        // Agregar título en negritas
        $sheet1->setCellValue('A1', 'REPORTE DE CITAS');
        $titleStyle = $sheet1->getStyle('A1');
        $titleStyle->getFont()->setSize(16); // Tamaño de letra 14
        $titleStyle->getFont()->setBold(true); // Hacer el título en negritas
        // Combinar celdas para el título
        $sheet1->mergeCells('A1:H1');
        // Agregar título en negritas
        $sheet1->setCellValue('A2', $mensaje);
        $titleStyle = $sheet1->getStyle('A2');
        $titleStyle->getFont()->setSize(12); // Tamaño de letra 14
        $titleStyle->getFont()->setBold(true); // Hacer el título en negritas
        // Combinar celdas para el título
        $sheet1->mergeCells('A2:H2');
        // hoja 1
        $row = 3;
        foreach ($doctores as $d){
            // Agregar datos a las celdas para la cabecera
            $sheet1->setCellValue('A'.$row, 'MÉDICO : ');
            $sheet1->setCellValue('B'.$row, $d->persona_nombre . ' ' .$d->persona_apellido_paterno.'  '.$d->persona_apellido_materno);
            $sheet1->setCellValue('C'.$row, 'N° DE CITAS : ');
            $sheet1->setCellValue('D'.$row, $d->ciCon);
            $sheet1->setCellValue('E'.$row, 'TOTAL : S/');
            $sheet1->setCellValue('F'.$row, $d->ciSum);
            $sheet1->setCellValue('G'.$row, '');
            $sheet1->setCellValue('H'.$row, '');

            // Establecer el ancho de las columnas A a E
            $sheet1->getColumnDimension('A')->setWidth(35); // Ancho de la columna A
            $sheet1->getColumnDimension('B')->setWidth(40); // Ancho de la columna B
            $sheet1->getColumnDimension('C')->setWidth(20); // Ancho de la columna C
            $sheet1->getColumnDimension('D')->setWidth(10); // Ancho de la columna D
            $sheet1->getColumnDimension('E')->setWidth(20); // Ancho de la columna E
            $sheet1->getColumnDimension('F')->setWidth(25); // Ancho de la columna F
            $sheet1->getColumnDimension('G')->setWidth(40); // Ancho de la columna G
            $sheet1->getColumnDimension('H')->setWidth(40); // Ancho de la columna H
            // Obtener la fila 1 completa (desde A hasta E) como un rango
            $cellRange = 'A'.$row.':H'.$row;
            $rowStyle = $sheet1->getStyle($cellRange);
            // Establecer el fondo, tamaño de letra y hacer negritas en toda la fila 1 y cambiar color del texto
            $rowStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0b1892'); // Fondo
            $rowStyle->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); // color de texto
            $rowStyle->getFont()->setSize(14); // Tamaño de letra 14
            $rowStyle->getFont()->setBold(true); // Hacer negritas
            $row++;
            if (count($d->consultorios) > 0){
                foreach ($d->consultorios as $c){
                    $sheet1->setCellValue('A' . $row, '');
                    $sheet1->setCellValue('B' . $row, 'CONSULTORIO : ');
                    $sheet1->setCellValue('C' . $row, $c->su_nombre_comercial);
                    $sheet1->setCellValue('D' . $row, 'TOTAL : ');
                    $sheet1->setCellValue('E' . $row, $c->total_ventas);
                    $sheet1->setCellValue('F' . $row, '');
                    $sheet1->setCellValue('G' . $row, '');
                    $sheet1->setCellValue('H' . $row, '');
                    $row++;
                }
                $row++;
                $sheet1->setCellValue('A' . $row, '');
                $sheet1->setCellValue('B' . $row, '');
                $sheet1->setCellValue('C' . $row, '');
                $sheet1->setCellValue('D' . $row, '');
                $sheet1->setCellValue('E' . $row, '');
                $sheet1->setCellValue('F' . $row, '');
                $sheet1->setCellValue('G' . $row, '');
                $sheet1->setCellValue('H' . $row, '');
            }
        }

        $nombre_excel = "Reporte_medico_detallado_" . date('d-m-Y') . '.xlsx';
        $response = response()->stream(
            function () use ($spreadsheet) {
                $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename=' . $nombre_excel,
            ]
        );

        return $response;
    }


    // ── REPORTE INVENTARIO ────────────────────────────────────────────
    public function reporte_inventario(Request $request)
    {
        try {
            $check = 'd'; $fecha_inicio = date('Y-m-d'); $fecha_fin = date('Y-m-d');
            $stock = []; $vendidos = []; $entradas = []; $salidas = []; $buscado = false;
            $id_pro_filtro = null; $pro_filtro_nombre = null; $pro_filtro_codigo = null;
            if (isset($request->enviar)) {
                $request->validate(['desde'=>'required','hasta'=>'required','opcion'=>'required']);
                $fecha_inicio = $request->desde; $fecha_fin = $request->hasta; $check = $request->opcion; $buscado = true;
                $id_pro_filtro = $request->input('id_pro_filtro') ?: null;
                $d = $this->_inventarioData($fecha_inicio, $fecha_fin, $id_pro_filtro ? (int)$id_pro_filtro : null);
                $stock = $d['stock']; $vendidos = $d['vendidos']; $entradas = $d['entradas']; $salidas = $d['salidas'];
                if ($id_pro_filtro) {
                    $pro_info = DB::table('productos')->where('id_pro', $id_pro_filtro)->first();
                    $pro_filtro_nombre = $pro_info->pro_nombre ?? null;
                    $pro_filtro_codigo = $pro_info->pro_codigo ?? null;
                }
            }
            $opciones = $this->submenu->optiones_por_vista("proveedores_reporte");
            return view('reporte/reporte_inventario', compact('opciones','check','fecha_inicio','fecha_fin','stock','vendidos','entradas','salidas','buscado','id_pro_filtro','pro_filtro_nombre','pro_filtro_codigo'));
        } catch (\Exception $e) { $this->logs->insertarLog($e); echo "<script>alert('Error al mostrar inventario'); window.location.href='".route('admin')."';</script>"; }
    }

    public function reporte_inventario_excel(Request $request)
    {
        $fi = $request->get('desde', date('Y-m-d')); $ff = $request->get('hasta', date('Y-m-d'));
        $id_pro = $request->get('id_pro') ? (int)$request->get('id_pro') : null;
        $d  = $this->_inventarioData($fi, $ff, $id_pro);
        $spreadsheet = new Spreadsheet(); $hc = '0b1892';
        $msg = 'Del '.date('d/m/Y',strtotime($fi)).' al '.date('d/m/Y',strtotime($ff));

        $s1 = $spreadsheet->getActiveSheet()->setTitle('Stock Actual');
        $s1->setCellValue('A1','REPORTE DE INVENTARIO - STOCK ACTUAL'); $s1->mergeCells('A1:F1');
        $s1->setCellValue('A2',$msg); $s1->mergeCells('A2:F2');
        $s1->getStyle('A1:A2')->getFont()->setBold(true)->setSize(13);
        foreach (['#','Código','Producto','Stock','P.Unitario','Valor Total'] as $i=>$h) $s1->setCellValue(chr(65+$i).'3',$h);
        $s1->getStyle('A3:F3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc);
        $s1->getStyle('A3:F3')->getFont()->getColor()->setARGB('FFFFFFFF'); $s1->getStyle('A3:F3')->getFont()->setBold(true);
        $row=4; $n=1;
        foreach ($d['stock'] as $p) { $s1->setCellValue('A'.$row,$n++); $s1->setCellValue('B'.$row,$p->pro_codigo??''); $s1->setCellValue('C'.$row,$p->pro_nombre); $s1->setCellValue('D'.$row,$p->pro_stock); $s1->setCellValue('E'.$row,$p->pro_precio_uni); $s1->setCellValue('F'.$row,round($p->pro_stock*$p->pro_precio_uni,2)); $row++; }
        foreach (['A'=>8,'B'=>15,'C'=>35,'D'=>10,'E'=>15,'F'=>15] as $c=>$w) $s1->getColumnDimension($c)->setWidth($w);

        $s2 = $spreadsheet->createSheet()->setTitle('Vendidos');
        $s2->setCellValue('A1','PRODUCTOS VENDIDOS EN EL PERÍODO'); $s2->mergeCells('A1:E1');
        $s2->setCellValue('A2',$msg); $s2->mergeCells('A2:E2');
        foreach (['#','Código','Producto','Cant.Vendida','Total S/'] as $i=>$h) $s2->setCellValue(chr(65+$i).'3',$h);
        $s2->getStyle('A3:E3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc);
        $s2->getStyle('A3:E3')->getFont()->getColor()->setARGB('FFFFFFFF'); $s2->getStyle('A3:E3')->getFont()->setBold(true);
        $row=4; $n=1;
        foreach ($d['vendidos'] as $v) { $s2->setCellValue('A'.$row,$n++); $s2->setCellValue('B'.$row,$v->pro_codigo??''); $s2->setCellValue('C'.$row,$v->pro_nombre); $s2->setCellValue('D'.$row,$v->total_cantidad); $s2->setCellValue('E'.$row,number_format($v->total_importe,2)); $row++; }
        foreach (['A'=>8,'B'=>15,'C'=>35,'D'=>15,'E'=>15] as $c=>$w) $s2->getColumnDimension($c)->setWidth($w);

        $s3 = $spreadsheet->createSheet()->setTitle('Entradas');
        $s3->setCellValue('A1','ENTRADAS DE INVENTARIO (COMPRAS)'); $s3->mergeCells('A1:H1');
        $s3->setCellValue('A2',$msg); $s3->mergeCells('A2:H2');
        foreach (['#','Fecha','Proveedor','Código','Producto','Cantidad','Precio','Total'] as $i=>$h) $s3->setCellValue(chr(65+$i).'3',$h);
        $s3->getStyle('A3:H3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc);
        $s3->getStyle('A3:H3')->getFont()->getColor()->setARGB('FFFFFFFF'); $s3->getStyle('A3:H3')->getFont()->setBold(true);
        $row=4; $n=1;
        foreach ($d['entradas'] as $e) { $s3->setCellValue('A'.$row,$n++); $s3->setCellValue('B'.$row,date('d/m/Y',strtotime($e->orden_compra_fecha))); $s3->setCellValue('C'.$row,$e->proveedores_nombre); $s3->setCellValue('D'.$row,$e->pro_codigo??''); $s3->setCellValue('E'.$row,$e->pro_nombre); $s3->setCellValue('F'.$row,$e->detalle_compra_cantidad); $s3->setCellValue('G'.$row,$e->detalle_compra_precio_compra); $s3->setCellValue('H'.$row,$e->detalle_compra_total_pedido); $row++; }
        foreach (['A'=>6,'B'=>12,'C'=>25,'D'=>12,'E'=>35,'F'=>12,'G'=>12,'H'=>12] as $c=>$w) $s3->getColumnDimension($c)->setWidth($w);

        $s4 = $spreadsheet->createSheet()->setTitle('Salidas');
        $s4->setCellValue('A1','SALIDAS DE INVENTARIO (VENTAS)'); $s4->mergeCells('A1:H1');
        $s4->setCellValue('A2',$msg); $s4->mergeCells('A2:H2');
        foreach (['#','Fecha','Cliente','Comprobante','Código','Producto','Cantidad','Total S/'] as $i=>$h) $s4->setCellValue(chr(65+$i).'3',$h);
        $s4->getStyle('A3:H3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc);
        $s4->getStyle('A3:H3')->getFont()->getColor()->setARGB('FFFFFFFF'); $s4->getStyle('A3:H3')->getFont()->setBold(true);
        $row=4; $n=1;
        foreach ($d['salidas'] as $s) { $tipo=$s->venta_tipo=='01'?'F':'B'; $comp=$tipo.' '.$s->venta_serie.'-'.str_pad($s->venta_correlativo,8,'0',STR_PAD_LEFT); $s4->setCellValue('A'.$row,$n++); $s4->setCellValue('B'.$row,date('d/m/Y',strtotime($s->venta_fecha))); $s4->setCellValue('C'.$row,$s->cliente_nombre); $s4->setCellValue('D'.$row,$comp); $s4->setCellValue('E'.$row,$s->pro_codigo??''); $s4->setCellValue('F'.$row,$s->pro_nombre); $s4->setCellValue('G'.$row,$s->venta_detalle_cantidad); $s4->setCellValue('H'.$row,number_format($s->venta_detalle_importe_total,2)); $row++; }
        foreach (['A'=>6,'B'=>12,'C'=>25,'D'=>18,'E'=>12,'F'=>35,'G'=>12,'H'=>12] as $c=>$w) $s4->getColumnDimension($c)->setWidth($w);

        $nombre = 'Reporte_Inventario_'.date('d-m-Y').'.xlsx';
        return response()->stream(function() use($spreadsheet){ IOFactory::createWriter($spreadsheet,'Xlsx')->save('php://output'); },200,['Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','Content-Disposition'=>'attachment; filename='.$nombre]);
    }

    public function reporte_inventario_pdf(Request $request)
    {
        $fi=$request->get('desde',date('Y-m-d')); $ff=$request->get('hasta',date('Y-m-d'));
        $id_pro=$request->get('id_pro') ? (int)$request->get('id_pro') : null;
        $d=$this->_inventarioData($fi,$ff,$id_pro);
        return view('reporte/pdf_inventario', array_merge($d,['fecha_inicio'=>$fi,'fecha_fin'=>$ff]));
    }

    private function _inventarioData($fi,$ff,?int $id_pro=null)
    {
        $q = DB::table('productos')->where([['pro_estado',1],['impuesto_bolsa',0]]);
        if ($id_pro) $q->where('id_pro',$id_pro);
        $stock = $q->orderByDesc('pro_stock')->get();
        $qv = DB::table('ventas_detalle as vd')->join('ventas as v','v.id_venta','=','vd.id_venta')->join('productos as p','p.id_pro','=','vd.id_pro')
            ->whereDate('v.venta_fecha','>=',$fi)->whereDate('v.venta_fecha','<=',$ff)
            ->where([['v.anulado_sunat',0],['v.venta_cancelar',1]])->whereIn('v.venta_tipo',['01','03']);
        if ($id_pro) $qv->where('vd.id_pro',$id_pro);
        $vendidos = $qv->groupBy('vd.id_pro','p.pro_nombre','p.pro_codigo')
            ->selectRaw('vd.id_pro,p.pro_nombre,p.pro_codigo,SUM(vd.venta_detalle_cantidad) as total_cantidad,SUM(vd.venta_detalle_importe_total) as total_importe')
            ->orderByDesc('total_cantidad')->get();

        $qe = DB::table('orden_compra_detalle as od')->join('orden_compra as oc','oc.id_orden_compra','=','od.id_orden_compra')
            ->join('productos as p','p.id_pro','=','od.id_pro')->join('proveedores as pv','pv.id_proveedores','=','oc.id_proveedores')
            ->whereDate('oc.orden_compra_fecha','>=',$fi)->whereDate('oc.orden_compra_fecha','<=',$ff)->where('oc.orden_compra_estado',1);
        if ($id_pro) $qe->where('od.id_pro',$id_pro);
        $entradas = $qe->select('oc.orden_compra_fecha','p.pro_nombre','p.pro_codigo','od.detalle_compra_cantidad','od.detalle_compra_precio_compra','od.detalle_compra_total_pedido','pv.proveedores_nombre')
            ->orderByDesc('oc.orden_compra_fecha')->get();

        $qs = DB::table('ventas_detalle as vd')->join('ventas as v','v.id_venta','=','vd.id_venta')
            ->join('productos as p','p.id_pro','=','vd.id_pro')->join('clientes as c','c.id_clientes','=','v.id_clientes')
            ->whereDate('v.venta_fecha','>=',$fi)->whereDate('v.venta_fecha','<=',$ff)
            ->where([['v.anulado_sunat',0],['v.venta_cancelar',1]])->whereIn('v.venta_tipo',['01','03']);
        if ($id_pro) $qs->where('vd.id_pro',$id_pro);
        $salidas = $qs->selectRaw("v.venta_fecha,p.pro_nombre,p.pro_codigo,vd.venta_detalle_cantidad,vd.venta_detalle_precio_unitario,vd.venta_detalle_importe_total,CASE WHEN c.id_tipo_documento=4 THEN c.cliente_razonsocial ELSE c.cliente_nombre END as cliente_nombre,c.cliente_numero,v.venta_serie,v.venta_correlativo,v.venta_tipo")
            ->orderByDesc('v.venta_fecha')->get();
        return compact('stock','vendidos','entradas','salidas');
    }

    // ── REPORTE CLIENTES Y PROVEEDORES ────────────────────────────────
    public function reporte_clientes_proveedores(Request $request)
    {
        try {
            $check='d'; $fecha_inicio=date('Y-m-d'); $fecha_fin=date('Y-m-d');
            $clientes=[]; $proveedores=[]; $buscado=false;
            if (isset($request->enviar)) {
                $request->validate(['desde'=>'required','hasta'=>'required','opcion'=>'required']);
                $fecha_inicio=$request->desde; $fecha_fin=$request->hasta; $check=$request->opcion; $buscado=true;
                $d=$this->_clientesProveedoresData($fecha_inicio,$fecha_fin);
                $clientes=$d['clientes']; $proveedores=$d['proveedores'];
            }
            $opciones = $this->submenu->optiones_por_vista("proveedores_reporte");
            return view('reporte/reporte_clientes_proveedores', compact('opciones','check','fecha_inicio','fecha_fin','clientes','proveedores','buscado'));
        } catch (\Exception $e) { $this->logs->insertarLog($e); echo "<script>alert('Error'); window.location.href='".route('admin')."';</script>"; }
    }

    public function reporte_clientes_proveedores_excel(Request $request)
    {
        $fi=$request->get('desde',date('Y-m-d')); $ff=$request->get('hasta',date('Y-m-d'));
        $d=$this->_clientesProveedoresData($fi,$ff);
        $spreadsheet=new Spreadsheet(); $hc='0b1892';
        $msg='Del '.date('d/m/Y',strtotime($fi)).' al '.date('d/m/Y',strtotime($ff));

        $s1=$spreadsheet->getActiveSheet()->setTitle('Clientes');
        $s1->setCellValue('A1','REPORTE DE CLIENTES'); $s1->mergeCells('A1:F1');
        $s1->setCellValue('A2',$msg); $s1->mergeCells('A2:F2');
        $s1->getStyle('A1:A2')->getFont()->setBold(true)->setSize(13);
        foreach (['#','N° Documento','Nombre / Razón Social','Dirección','Trans. Históricas','Total período S/'] as $i=>$h) $s1->setCellValue(chr(65+$i).'3',$h);
        $s1->getStyle('A3:F3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc);
        $s1->getStyle('A3:F3')->getFont()->getColor()->setARGB('FFFFFFFF'); $s1->getStyle('A3:F3')->getFont()->setBold(true);
        $row=4; $n=1;
        foreach ($d['clientes'] as $c) { $nombre=$c->id_tipo_documento==4?$c->cliente_razonsocial:$c->cliente_nombre; $s1->setCellValue('A'.$row,$n++); $s1->setCellValue('B'.$row,$c->cliente_numero); $s1->setCellValue('C'.$row,$nombre); $s1->setCellValue('D'.$row,$c->cliente_direccion??''); $s1->setCellValue('E'.$row,$c->total_transacciones); $s1->setCellValue('F'.$row,number_format($c->total_compras,2)); $row++; }
        foreach (['A'=>6,'B'=>15,'C'=>40,'D'=>30,'E'=>20,'F'=>20] as $c=>$w) $s1->getColumnDimension($c)->setWidth($w);

        $s2=$spreadsheet->createSheet()->setTitle('Proveedores');
        $s2->setCellValue('A1','REPORTE DE PROVEEDORES'); $s2->mergeCells('A1:F1');
        $s2->setCellValue('A2',$msg); $s2->mergeCells('A2:F2');
        $s2->getStyle('A1:A2')->getFont()->setBold(true)->setSize(13);
        foreach (['#','N° Documento','Proveedor','Teléfono','Órdenes período','Total período S/'] as $i=>$h) $s2->setCellValue(chr(65+$i).'3',$h);
        $s2->getStyle('A3:F3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc);
        $s2->getStyle('A3:F3')->getFont()->getColor()->setARGB('FFFFFFFF'); $s2->getStyle('A3:F3')->getFont()->setBold(true);
        $row=4; $n=1;
        foreach ($d['proveedores'] as $p) { $s2->setCellValue('A'.$row,$n++); $s2->setCellValue('B'.$row,$p->proveedores_numero_documento??''); $s2->setCellValue('C'.$row,$p->proveedores_nombre); $s2->setCellValue('D'.$row,$p->proveedores_telefono??''); $s2->setCellValue('E'.$row,$p->total_ordenes); $s2->setCellValue('F'.$row,number_format($p->total_compras,2)); $row++; }
        foreach (['A'=>6,'B'=>15,'C'=>40,'D'=>15,'E'=>20,'F'=>20] as $c=>$w) $s2->getColumnDimension($c)->setWidth($w);

        $nombre='Reporte_Clientes_Proveedores_'.date('d-m-Y').'.xlsx';
        return response()->stream(function() use($spreadsheet){ IOFactory::createWriter($spreadsheet,'Xlsx')->save('php://output'); },200,['Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','Content-Disposition'=>'attachment; filename='.$nombre]);
    }

    public function reporte_clientes_proveedores_pdf(Request $request)
    {
        $fi=$request->get('desde',date('Y-m-d')); $ff=$request->get('hasta',date('Y-m-d'));
        $d=$this->_clientesProveedoresData($fi,$ff);
        return view('reporte/pdf_clientes_proveedores', array_merge($d,['fecha_inicio'=>$fi,'fecha_fin'=>$ff]));
    }

    private function _clientesProveedoresData($fi,$ff)
    {
        $clientes=DB::table('clientes as c')->where('c.cliente_estado',1)
            ->selectRaw('c.*,(SELECT COUNT(*) FROM ventas v WHERE v.id_clientes=c.id_clientes AND v.anulado_sunat=0 AND v.venta_cancelar=1) as total_transacciones,(SELECT COALESCE(SUM(v2.venta_total),0) FROM ventas v2 WHERE v2.id_clientes=c.id_clientes AND v2.anulado_sunat=0 AND v2.venta_cancelar=1 AND DATE(v2.venta_fecha)>=? AND DATE(v2.venta_fecha)<=?) as total_compras',[$fi,$ff])
            ->orderByDesc('total_compras')->get();
        $proveedores=DB::table('proveedores as pv')->where('pv.proveedores_estado',1)
            ->selectRaw('pv.*,(SELECT COUNT(*) FROM orden_compra oc WHERE oc.id_proveedores=pv.id_proveedores AND oc.orden_compra_estado=1 AND DATE(oc.orden_compra_fecha)>=? AND DATE(oc.orden_compra_fecha)<=?) as total_ordenes,(SELECT COALESCE(SUM(od.detalle_compra_total_pedido),0) FROM orden_compra_detalle od JOIN orden_compra oc2 ON oc2.id_orden_compra=od.id_orden_compra WHERE oc2.id_proveedores=pv.id_proveedores AND oc2.orden_compra_estado=1 AND DATE(oc2.orden_compra_fecha)>=? AND DATE(oc2.orden_compra_fecha)<=?) as total_compras',[$fi,$ff,$fi,$ff])
            ->orderByDesc('total_compras')->get();
        return compact('clientes','proveedores');
    }

    // ── EXPORTS REPORTES EXISTENTES ───────────────────────────────────
    public function reporte_ventas_excel(Request $request)
    {
        $fi=$request->get('desde',date('Y-m-d')); $ff=$request->get('hasta',date('Y-m-d'));
        $id_cli=$request->get('id_cliente',null);
        $spreadsheet=new Spreadsheet(); $hc='0b1892';
        $msg='Del '.date('d/m/Y',strtotime($fi)).' al '.date('d/m/Y',strtotime($ff));

        if ($id_cli) {
            $cliente=DB::table('clientes')->where('id_clientes',$id_cli)->first();
            $ventas=$this->ventas->listar_ventas_cliente($id_cli,$fi,$ff,1);
            $nombre_c=$cliente?($cliente->id_tipo_documento==4?$cliente->cliente_razonsocial:$cliente->cliente_nombre):'';
            $sh=$spreadsheet->getActiveSheet()->setTitle('Ventas Cliente');
            $sh->setCellValue('A1','REPORTE DE VENTAS — '.$nombre_c); $sh->mergeCells('A1:G1');
            $sh->setCellValue('A2',$msg); $sh->mergeCells('A2:G2');
            $sh->getStyle('A1:A2')->getFont()->setBold(true)->setSize(13);
            foreach (['#','Fecha','Comprobante','Tipo Pago','Subtotal','Descuento','Total'] as $i=>$h) $sh->setCellValue(chr(65+$i).'3',$h);
            $sh->getStyle('A3:G3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc);
            $sh->getStyle('A3:G3')->getFont()->getColor()->setARGB('FFFFFFFF'); $sh->getStyle('A3:G3')->getFont()->setBold(true);
            $row=4; $n=1;
            foreach ($ventas as $v) { $tipo=$v->venta_tipo=='01'?'Factura':($v->venta_tipo=='03'?'Boleta':$v->venta_tipo); $comp=$tipo.' '.$v->venta_serie.'-'.str_pad($v->venta_correlativo,8,'0',STR_PAD_LEFT); $sh->setCellValue('A'.$row,$n++); $sh->setCellValue('B'.$row,date('d/m/Y',strtotime($v->venta_fecha))); $sh->setCellValue('C'.$row,$comp); $sh->setCellValue('D'.$row,$v->venta_pago_tipo??'—'); $sh->setCellValue('E'.$row,number_format($v->venta_total+$v->venta_totaldescuento,2)); $sh->setCellValue('F'.$row,$v->venta_totaldescuento>0?'-'.number_format($v->venta_totaldescuento,2):'—'); $sh->setCellValue('G'.$row,number_format($v->venta_total,2)); $row++; }
            $sh->setCellValue('F'.$row,'TOTAL:'); $sh->setCellValue('G'.$row,number_format($ventas->sum('venta_total'),2)); $sh->getStyle('F'.$row.':G'.$row)->getFont()->setBold(true);
            foreach (['A'=>6,'B'=>12,'C'=>25,'D'=>15,'E'=>15,'F'=>15,'G'=>15] as $c=>$w) $sh->getColumnDimension($c)->setWidth($w);
        } else {
            $fecha1=new \DateTime($fi); $fFin=new \DateTime($ff); $fecha1->modify('-1 day'); $fFin->modify('-1 day');
            $dias=$fFin->diff($fecha1)->days; $fechas=[]; $totalG=0;
            for ($i=0;$i<=$dias;$i++) { $fecha1->modify('+1 day'); $dia=$fecha1->format('Y-m-d'); $vs=$this->ventas->listar_ventas_Reporte($dia,1); $sum=0; $cnt=0; foreach($vs as $v){$sum+=$v->venta_total;$cnt++;} $fechas[]=['dia'=>$dia,'ConteoVentas'=>$cnt,'sumVentas'=>$sum]; }
            $sh=$spreadsheet->getActiveSheet()->setTitle('Ventas por Día');
            $sh->setCellValue('A1','REPORTE DE VENTAS GENERAL'); $sh->mergeCells('A1:D1');
            $sh->setCellValue('A2',$msg); $sh->mergeCells('A2:D2');
            $sh->getStyle('A1:A2')->getFont()->setBold(true)->setSize(13);
            foreach (['#','Día','Cant. Ventas','Total S/'] as $i=>$h) $sh->setCellValue(chr(65+$i).'3',$h);
            $sh->getStyle('A3:D3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc);
            $sh->getStyle('A3:D3')->getFont()->getColor()->setARGB('FFFFFFFF'); $sh->getStyle('A3:D3')->getFont()->setBold(true);
            $row=4; $n=1;
            foreach ($fechas as $f) { $sh->setCellValue('A'.$row,$n++); $sh->setCellValue('B'.$row,date('d/m/Y',strtotime($f['dia']))); $sh->setCellValue('C'.$row,$f['ConteoVentas']); $sh->setCellValue('D'.$row,number_format($f['sumVentas'],2)); $totalG+=$f['sumVentas']; $row++; }
            $sh->setCellValue('C'.$row,'TOTAL:'); $sh->setCellValue('D'.$row,number_format($totalG,2)); $sh->getStyle('C'.$row.':D'.$row)->getFont()->setBold(true);
            foreach (['A'=>6,'B'=>15,'C'=>15,'D'=>15] as $c=>$w) $sh->getColumnDimension($c)->setWidth($w);
        }
        $nombre='Reporte_Ventas_'.date('d-m-Y').'.xlsx';
        return response()->stream(function() use($spreadsheet){ IOFactory::createWriter($spreadsheet,'Xlsx')->save('php://output'); },200,['Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','Content-Disposition'=>'attachment; filename='.$nombre]);
    }

    public function reporte_ventas_pdf(Request $request)
    {
        $fi=$request->get('desde',date('Y-m-d')); $ff=$request->get('hasta',date('Y-m-d'));
        $id_cli=$request->get('id_cliente',null); $ventas_cliente=null; $cliente=null; $fechas=[];
        if ($id_cli) {
            $cliente=DB::table('clientes')->where('id_clientes',$id_cli)->first();
            $ventas_cliente=$this->ventas->listar_ventas_cliente($id_cli,$fi,$ff,1);
        } else {
            $fecha1=new \DateTime($fi); $fFin=new \DateTime($ff); $fecha1->modify('-1 day'); $fFin->modify('-1 day'); $dias=$fFin->diff($fecha1)->days;
            for ($i=0;$i<=$dias;$i++) { $fecha1->modify('+1 day'); $dia=$fecha1->format('Y-m-d'); $vs=$this->ventas->listar_ventas_Reporte($dia,1); $sum=0;$cnt=0; foreach($vs as $v){$sum+=$v->venta_total;$cnt++;} $fechas[]=['dia'=>$dia,'ConteoVentas'=>$cnt,'sumVentas'=>$sum]; }
        }
        return view('reporte/pdf_ventas', compact('fi','ff','ventas_cliente','cliente','fechas'));
    }

    public function reporte_productos_excel(Request $request)
    {
        $fi = $request->get('desde', date('Y-m-d'));
        $ff = $request->get('hasta', date('Y-m-d'));
        $id_pro = $request->get('id_pro') ?: null;
        $query = DB::table('productos')->where([['impuesto_bolsa', 0], ['pro_estado', 1]]);
        if ($id_pro) $query->where('id_pro', $id_pro);
        $productos = $query->get()->all();
        foreach ($productos as $p) { $p->mas_vendidos=DB::table('ventas as v')->join('ventas_detalle as vd','vd.id_venta','=','v.id_venta')->whereDate('v.venta_fecha','>=',$fi)->whereDate('v.venta_fecha','<=',$ff)->where([['vd.id_pro',$p->id_pro],['v.anulado_sunat',0],['v.venta_cancelar',1],['v.id_formas_pago',1]])->count(); }
        usort($productos, fn($a,$b)=>$b->mas_vendidos<=>$a->mas_vendidos);
        $spreadsheet=new Spreadsheet(); $hc='0b1892'; $msg='Del '.date('d/m/Y',strtotime($fi)).' al '.date('d/m/Y',strtotime($ff));
        $sh=$spreadsheet->getActiveSheet()->setTitle('Productos');
        $sh->setCellValue('A1','REPORTE DE PRODUCTOS'); $sh->mergeCells('A1:G1');
        $sh->setCellValue('A2',$msg); $sh->mergeCells('A2:G2');
        $sh->getStyle('A1:A2')->getFont()->setBold(true)->setSize(13);
        foreach (['#','Código','Producto','Stock','P.Minorista','P.Mayorista','Ventas período'] as $i=>$h) $sh->setCellValue(chr(65+$i).'3',$h);
        $sh->getStyle('A3:G3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc);
        $sh->getStyle('A3:G3')->getFont()->getColor()->setARGB('FFFFFFFF'); $sh->getStyle('A3:G3')->getFont()->setBold(true);
        $row=4; $n=1;
        foreach ($productos as $p) { $sh->setCellValue('A'.$row,$n++); $sh->setCellValue('B'.$row,$p->pro_codigo??''); $sh->setCellValue('C'.$row,$p->pro_nombre); $sh->setCellValue('D'.$row,$p->pro_stock); $sh->setCellValue('E'.$row,number_format($p->pro_precio_uni,2)); $sh->setCellValue('F'.$row,number_format($p->pro_precio_uni_ma,2)); $sh->setCellValue('G'.$row,$p->mas_vendidos); $row++; }
        foreach (['A'=>6,'B'=>15,'C'=>35,'D'=>10,'E'=>15,'F'=>15,'G'=>15] as $c=>$w) $sh->getColumnDimension($c)->setWidth($w);
        $nombre='Reporte_Productos_'.date('d-m-Y').'.xlsx';
        return response()->stream(function() use($spreadsheet){ IOFactory::createWriter($spreadsheet,'Xlsx')->save('php://output'); },200,['Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','Content-Disposition'=>'attachment; filename='.$nombre]);
    }

    public function reporte_productos_pdf(Request $request)
    {
        $fi = $request->get('desde', date('Y-m-d'));
        $ff = $request->get('hasta', date('Y-m-d'));
        $id_pro = $request->get('id_pro') ?: null;
        $query = DB::table('productos')->where([['impuesto_bolsa', 0], ['pro_estado', 1]]);
        if ($id_pro) $query->where('id_pro', $id_pro);
        $productos = $query->get()->all();
        foreach ($productos as $p) { $p->mas_vendidos=DB::table('ventas as v')->join('ventas_detalle as vd','vd.id_venta','=','v.id_venta')->whereDate('v.venta_fecha','>=',$fi)->whereDate('v.venta_fecha','<=',$ff)->where([['vd.id_pro',$p->id_pro],['v.anulado_sunat',0],['v.venta_cancelar',1],['v.id_formas_pago',1]])->count(); }
        usort($productos, fn($a,$b)=>$b->mas_vendidos<=>$a->mas_vendidos);
        return view('reporte/pdf_productos', compact('productos','fi','ff'));
    }

    public function pdf_report_caja(Request $request)
    {
        $fi             = $request->get('desde', date('Y-m-d'));
        $ff             = $request->get('hasta', date('Y-m-d'));
        $id_caja_numero = $request->get('id_caja_numero') ? (int)$request->get('id_caja_numero') : null;
        $reporte        = $this->_calcular_reporte_caja($fi, $ff, $id_caja_numero);
        return view('reporte/pdf_caja', compact('reporte', 'fi', 'ff'));
    }

    public function ventas_caja_excel(Request $request)
    {
        $fi             = $request->get('desde', date('Y-m-d'));
        $ff             = $request->get('hasta', date('Y-m-d'));
        $id_caja_numero = $request->get('id_caja_numero') ? (int)$request->get('id_caja_numero') : null;
        $reporte        = $this->_calcular_reporte_caja($fi, $ff, $id_caja_numero);
        $hc = '0b1892'; $msg = 'Del ' . date('d/m/Y', strtotime($fi)) . ' al ' . date('d/m/Y', strtotime($ff));

        $spreadsheet = new Spreadsheet();

        // ── Hoja 1: Resumen ──────────────────────────────────────────────
        $s1 = $spreadsheet->getActiveSheet()->setTitle('Resumen');
        $s1->setCellValue('A1', 'REPORTE DE CAJA'); $s1->mergeCells('A1:D1');
        $s1->setCellValue('A2', $msg);               $s1->mergeCells('A2:D2');
        $s1->getStyle('A1:A2')->getFont()->setBold(true)->setSize(14);
        $s1->getStyle('A1:D2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc);
        $s1->getStyle('A1:D2')->getFont()->getColor()->setARGB('FFFFFFFF');

        if (!$reporte) {
            $s1->setCellValue('A3', 'Sin registros en el período.');
        } else {
            $r = $reporte['resumen'];
            $row = 3;
            $s1->setCellValue('A'.$row, 'CUADRE DE CAJA'); $s1->mergeCells('A'.$row.':D'.$row);
            $s1->getStyle('A'.$row.':D'.$row)->getFont()->setBold(true);
            $s1->getStyle('A'.$row.':D'.$row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3a5aba');
            $s1->getStyle('A'.$row.':D'.$row)->getFont()->getColor()->setARGB('FFFFFFFF');
            $row++;
            $filas_cuadre = [
                ['Caja', $reporte['nombreCaja']],
                ['Período', $msg],
                ['Turnos registrados', $r->total_turnos],
                ['Turnos abiertos', $r->turnos_abiertos],
                ['Monto apertura (soles)', 'S/ ' . number_format($r->monto_apertura, 2)],
                ['Total ventas (contado)', 'S/ ' . number_format($r->total_ventas, 2)],
                ['  de las cuales — Efectivo', 'S/ ' . number_format($r->ventas_efectivo, 2)],
                ['Notas de crédito', 'S/ -' . number_format($r->notas_credito, 2)],
                ['Total en sistema', 'S/ ' . number_format($r->total_sistema, 2)],
                ['Monto cierre (contado)', 'S/ ' . number_format($r->monto_cierre, 2)],
                ['Diferencia', 'S/ ' . number_format($r->diferencia, 2)],
            ];
            foreach ($filas_cuadre as [$label, $val]) {
                $s1->setCellValue('A'.$row, $label); $s1->setCellValue('B'.$row, $val); $row++;
            }
            $row++;

            // Ventas por medio de pago
            $s1->setCellValue('A'.$row, 'VENTAS POR MEDIO DE PAGO'); $s1->mergeCells('A'.$row.':D'.$row);
            $s1->getStyle('A'.$row.':D'.$row)->getFont()->setBold(true);
            $s1->getStyle('A'.$row.':D'.$row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3a5aba');
            $s1->getStyle('A'.$row.':D'.$row)->getFont()->getColor()->setARGB('FFFFFFFF');
            $row++;
            $s1->setCellValue('A'.$row, 'Medio'); $s1->setCellValue('B'.$row, 'Total S/');
            $s1->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
            $row++;
            foreach ($reporte['ventasPorMedio'] as $vm) {
                $s1->setCellValue('A'.$row, $vm->tipo_pago_nombre); $s1->setCellValue('B'.$row, number_format((float)$vm->total, 2)); $row++;
            }
            foreach (['A'=>30,'B'=>20,'C'=>20,'D'=>20] as $c=>$w) $s1->getColumnDimension($c)->setWidth($w);
        }

        // ── Hoja 2: Turnos ───────────────────────────────────────────────
        $s2 = $spreadsheet->createSheet()->setTitle('Turnos');
        $s2->setCellValue('A1', 'TURNOS DE CAJA'); $s2->mergeCells('A1:G1');
        $s2->setCellValue('A2', $msg);             $s2->mergeCells('A2:G2');
        $s2->getStyle('A1:G2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc);
        $s2->getStyle('A1:G2')->getFont()->getColor()->setARGB('FFFFFFFF');
        $s2->getStyle('A1:A2')->getFont()->setBold(true)->setSize(13);
        foreach (['#','Caja','Cajero','Apertura','Cierre','M.Apertura','Estado'] as $i=>$h) $s2->setCellValue(chr(65+$i).'3',$h);
        $s2->getStyle('A3:G3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3a5aba');
        $s2->getStyle('A3:G3')->getFont()->getColor()->setARGB('FFFFFFFF');
        $s2->getStyle('A3:G3')->getFont()->setBold(true);
        $row=4; $n=1;
        if ($reporte) {
            foreach ($reporte['turnos'] as $t) {
                $s2->setCellValue('A'.$row,$n++);
                $s2->setCellValue('B'.$row,$t->caja_numero_nombre);
                $s2->setCellValue('C'.$row,$t->nombre_apertura);
                $s2->setCellValue('D'.$row,date('d/m/Y H:i',strtotime($t->caja_fecha_apertura)));
                $s2->setCellValue('E'.$row,$t->caja_estado==0?date('d/m/Y H:i',strtotime($t->caja_fecha_cierre)):'Abierto');
                $s2->setCellValue('F'.$row,'S/ '.number_format((float)$t->caja_apertura,2));
                $s2->setCellValue('G'.$row,$t->caja_estado==0?'CERRADO':'ABIERTO');
                $row++;
            }
        }
        foreach (['A'=>6,'B'=>18,'C'=>28,'D'=>20,'E'=>20,'F'=>16,'G'=>12] as $c=>$w) $s2->getColumnDimension($c)->setWidth($w);

        // ── Hoja 3: Comprobantes ─────────────────────────────────────────
        $s3 = $spreadsheet->createSheet()->setTitle('Comprobantes');
        $s3->setCellValue('A1','COMPROBANTES EMITIDOS'); $s3->mergeCells('A1:G1');
        $s3->setCellValue('A2',$msg);                   $s3->mergeCells('A2:G2');
        $s3->getStyle('A1:G2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc);
        $s3->getStyle('A1:G2')->getFont()->getColor()->setARGB('FFFFFFFF');
        $s3->getStyle('A1:A2')->getFont()->setBold(true)->setSize(13);
        foreach (['#','Tipo','Comprobante','Caja','Cliente','Fecha','Total S/'] as $i=>$h) $s3->setCellValue(chr(65+$i).'3',$h);
        $s3->getStyle('A3:G3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3a5aba');
        $s3->getStyle('A3:G3')->getFont()->getColor()->setARGB('FFFFFFFF');
        $s3->getStyle('A3:G3')->getFont()->setBold(true);
        $row=4; $n=1; $totalComprobantes=0;
        if ($reporte) {
            foreach ($reporte['comprobantes'] as $v) {
                $tipo = $v->venta_tipo=='01'?'Factura':'Boleta';
                $comp = $v->venta_serie.'-'.str_pad($v->venta_correlativo,8,'0',STR_PAD_LEFT);
                $s3->setCellValue('A'.$row,$n++);
                $s3->setCellValue('B'.$row,$tipo);
                $s3->setCellValue('C'.$row,$comp);
                $s3->setCellValue('D'.$row,$v->caja_numero_nombre);
                $s3->setCellValue('E'.$row,$v->cliente_nombre);
                $s3->setCellValue('F'.$row,date('d/m/Y H:i',strtotime($v->venta_fecha)));
                $s3->setCellValue('G'.$row,number_format((float)$v->venta_total,2));
                $totalComprobantes += (float)$v->venta_total;
                $row++;
            }
            $s3->setCellValue('F'.$row,'TOTAL:'); $s3->setCellValue('G'.$row,number_format($totalComprobantes,2));
            $s3->getStyle('F'.$row.':G'.$row)->getFont()->setBold(true);
        }
        foreach (['A'=>6,'B'=>12,'C'=>22,'D'=>18,'E'=>35,'F'=>18,'G'=>14] as $c=>$w) $s3->getColumnDimension($c)->setWidth($w);

        $spreadsheet->setActiveSheetIndex(0);
        $nombre = 'Reporte_Caja_' . date('d-m-Y') . '.xlsx';
        return response()->stream(
            function () use ($spreadsheet) { IOFactory::createWriter($spreadsheet, 'Xlsx')->save('php://output'); },
            200,
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
             'Content-Disposition' => 'attachment; filename=' . $nombre]
        );
    }

    public function proveedores_excel(Request $request)
    {
        $fi=$request->get('desde',date('Y-m-d')); $ff=$request->get('hasta',date('Y-m-d'));
        $proveedores=DB::table('proveedores')->where('proveedores_estado',1)->get();
        foreach ($proveedores as $pro) { $pro->productos=DB::table('productos as p')->join('orden_compra_detalle as od','p.id_pro','=','od.id_pro')->join('orden_compra as oc','oc.id_orden_compra','=','od.id_orden_compra')->where('oc.orden_compra_fecha','>=',$fi)->where('oc.orden_compra_fecha','<=',$ff)->where([['p.pro_estado',1],['oc.orden_compra_estado',1],['oc.id_proveedores',$pro->id_proveedores]])->groupBy('p.id_pro','p.pro_nombre')->select('p.id_pro','p.pro_nombre')->get(); foreach($pro->productos as $pr){$pr->ultimo_precio=DB::table('orden_compra_detalle as od')->join('orden_compra as oc','oc.id_orden_compra','=','od.id_orden_compra')->where([['od.id_pro',$pr->id_pro],['oc.orden_compra_estado',1]])->orderBy('od.id_detalle_compra','desc')->first();} }
        $spreadsheet=new Spreadsheet(); $hc='0b1892'; $msg='Del '.date('d/m/Y',strtotime($fi)).' al '.date('d/m/Y',strtotime($ff));
        $sh=$spreadsheet->getActiveSheet()->setTitle('Proveedores');
        $sh->setCellValue('A1','REPORTE DE PROVEEDORES'); $sh->mergeCells('A1:D1');
        $sh->setCellValue('A2',$msg); $sh->mergeCells('A2:D2');
        $sh->getStyle('A1:A2')->getFont()->setBold(true)->setSize(13);
        $row=3; $n=1;
        foreach ($proveedores as $prov) { if(count($prov->productos)==0) continue; $sh->setCellValue('A'.$row,$n++); $sh->setCellValue('B'.$row,$prov->proveedores_nombre); $sh->setCellValue('C'.$row,$prov->proveedores_numero_documento??''); $sh->setCellValue('D'.$row,$prov->proveedores_telefono??''); $sh->getStyle('A'.$row.':D'.$row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($hc); $sh->getStyle('A'.$row.':D'.$row)->getFont()->getColor()->setARGB('FFFFFFFF'); $sh->getStyle('A'.$row.':D'.$row)->getFont()->setBold(true); $row++; foreach($prov->productos as $pr){ $precio=$pr->ultimo_precio?'S/ '.number_format($pr->ultimo_precio->detalle_compra_precio_compra,2):'—'; $sh->setCellValue('B'.$row,$pr->pro_nombre); $sh->setCellValue('C'.$row,'Último precio: '.$precio); $row++; } $row++; }
        foreach (['A'=>6,'B'=>40,'C'=>25,'D'=>15] as $c=>$w) $sh->getColumnDimension($c)->setWidth($w);
        $nombre='Reporte_Proveedores_'.date('d-m-Y').'.xlsx';
        return response()->stream(function() use($spreadsheet){ IOFactory::createWriter($spreadsheet,'Xlsx')->save('php://output'); },200,['Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','Content-Disposition'=>'attachment; filename='.$nombre]);
    }

    public function proveedores_pdf(Request $request)
    {
        $fi=$request->get('desde',date('Y-m-d')); $ff=$request->get('hasta',date('Y-m-d'));
        $proveedores=DB::table('proveedores')->where('proveedores_estado',1)->get();
        foreach ($proveedores as $pro) { $pro->productos=DB::table('productos as p')->join('orden_compra_detalle as od','p.id_pro','=','od.id_pro')->join('orden_compra as oc','oc.id_orden_compra','=','od.id_orden_compra')->where('oc.orden_compra_fecha','>=',$fi)->where('oc.orden_compra_fecha','<=',$ff)->where([['p.pro_estado',1],['oc.orden_compra_estado',1],['oc.id_proveedores',$pro->id_proveedores]])->groupBy('p.id_pro','p.pro_nombre')->select('p.id_pro','p.pro_nombre')->get(); foreach($pro->productos as $pr){$pr->ultimo_precio=DB::table('orden_compra_detalle as od')->join('orden_compra as oc','oc.id_orden_compra','=','od.id_orden_compra')->where([['od.id_pro',$pr->id_pro],['oc.orden_compra_estado',1]])->orderBy('od.id_detalle_compra','desc')->first();} }
        return view('reporte/pdf_proveedores', compact('proveedores','fi','ff'));
    }

    public function listar_citas_paciente( Request $request){
        try {
            $result = 2;
            $message = "";
//
            $result =  $this->paciente_sucursal->paciente_citas($request->id_pa);
            foreach ($result as $r){
                $r->detalle = $this->citas->listar_tratamientos_citas($r->id_ci);
            }

        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));

    }

}
