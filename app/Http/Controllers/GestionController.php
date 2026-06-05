<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Medida;
use App\Models\Operacion;
use App\Models\UnidadManejo;
use App\Models\Clasificador;
use App\Models\Familia;
use App\Models\General;
use App\Models\Linea;
use App\Models\Logs;
use App\Models\Menu;
use App\Models\Opciones;
use App\Models\Persona;
use App\Models\Proveedores;
use App\Models\Submenu;
use App\Models\Tipo_documento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class GestionController extends Controller
{
    private $menus;
    private $submenu;
    private $logs;
    private $usuarios;
    private $tipoDocument;
    private $opciones;
    private $persona;
    private $general;
    private $proveedores;
    private $familias;
    private $categorias;
    private $lineas;
    private $clasificadores;
    private $almacenes;
    private $operaciones;
    private $unidadManejos;
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
        $this->proveedores = new Proveedores();
        $this->familias = new Familia();
        $this->categorias = new Categoria();
        $this->lineas = new Linea();
        $this->clasificadores = new Clasificador();
        $this->almacenes = new Almacen();
        $this->operaciones = new Operacion();
        $this->unidadManejos = new UnidadManejo();
//        $this->familias = new Fa
    }
    public function proveedores()
    {
        try {
//            ESTE IF ES PARA VERIFICAR SI ESE ROL TIENE EL PERMISO PARA LA VISTA
            $tipo_documento = $this->tipoDocument->listar_tipo_documento();
            $proveedores = $this->proveedores->listar_proveedores();
            $opciones = $this->submenu->optiones_por_vista("proveedores");
            $departamentos = DB::table('ubigeo_peru_departments')->orderBy('name')->get();
            return view('gestion/proveedores', compact('proveedores','opciones','tipo_documento','departamentos'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }

    }
    public function familias()
    {
        try {
//            ESTE IF ES PARA VERIFICAR SI ESE ROL TIENE EL PERMISO PARA LA VISTA
            $familia = $this->familias->listar_familias();
            foreach ($familia as $f){
                $f->categorias = $this->categorias->listar_categoria_familias($f->id_fa);
            }
            $opciones = $this->submenu->optiones_por_vista("familias");

            return view('gestion/familias', compact('familia','opciones'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }

    }
    public function clientes()
    {
        try {

            $clientes = DB::table('clientes as c')
                ->join('tipo_documento as td','td.id_tipo_documento','=','c.id_tipo_documento')
                ->leftJoin('ubigeo_peru_districts as ud','ud.id','=','c.cliente_ubigeo')
                ->leftJoin('ubigeo_peru_provinces as up','up.id','=','ud.province_id')
                ->leftJoin('ubigeo_peru_departments as udep','udep.id','=','ud.department_id')
                ->where('c.cliente_estado','=',1)
                ->select('c.*','td.tipo_documento_identidad_abr','ud.name as distrito','up.name as provincia','udep.name as departamento')
                ->get();

            $tipoDocumentos = DB::table('tipo_documento')->get();
            $departamentos = DB::table('ubigeo_peru_departments')->orderBy('name')->get();

            $opciones = $this->submenu->optiones_por_vista("clientes");

            return view('gestion/clientes', compact('opciones','tipoDocumentos','clientes','departamentos'));
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }

    }
    public function categoria()
    {
        try {
            $id_fa = $_GET['fa_id'];
            if($id_fa){
                $opciones = $this->submenu->optiones_por_vista("familias");
                $familia = $this->familias->datos_familias($id_fa);
                $categorias = $this->categorias->listar_categoria_familias($id_fa);

                return view('gestion/categorias', compact('categorias','familia','opciones'));
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
    public function proveedores_excel()
    {
        try {
            $proveedores = $this->proveedores->listar_proveedores();
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $mensaje = "LISTAS DE PROVEEDORES : ";
            // Agregar título en negritas
            $sheet->setCellValue('A1', $mensaje);
            $titleStyle = $sheet->getStyle('A1');
            $titleStyle->getFont()->setSize(16); // Tamaño de letra 14
            $titleStyle->getFont()->setBold(true); // Hacer el título en negritas
            // Combinar celdas para el título
            $sheet->mergeCells('A1:T1');
            $sheet->setCellValue('A2', '#');
            $sheet->setCellValue('B2', 'TIPO DE DOCUMENTO');
            $sheet->setCellValue('C2', 'N° DE DOCUMENTO');
            $sheet->setCellValue('D2', 'RAZÓN SOCIAL');
            $sheet->setCellValue('E2', 'DIRECCIÓN');
            $sheet->setCellValue('F2', 'TELÉFONO');
            $sheet->setCellValue('G2', 'CORREO');

            $sheet->getColumnDimension('A')->setWidth(7); // Ancho de la columna A
            $sheet->getColumnDimension('B')->setWidth(30); // Ancho de la columna B
            $sheet->getColumnDimension('C')->setWidth(25); // Ancho de la columna C
            $sheet->getColumnDimension('D')->setWidth(40); // Ancho de la columna D
            $sheet->getColumnDimension('E')->setWidth(40); // Ancho de la columna E
            $sheet->getColumnDimension('F')->setWidth(15); // Ancho de la columna F
            $sheet->getColumnDimension('G')->setWidth(30); // Ancho de la columna G

            // Obtener la fila 1 completa (desde A hasta G) como un rango
            $cellRange = 'A2:G2';
            $rowStyle = $sheet->getStyle($cellRange);
            // Establecer el fondo, tamaño de letra y hacer negritas en toda la fila 1 y cambiar color del texto
            $rowStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('399630'); // Fondo
            $rowStyle->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); // color de texto
            $rowStyle->getFont()->setSize(14); // Tamaño de letra 14
            $rowStyle->getFont()->setBold(true); // Hacer negritas
            $row = 3;
            $conteo = 1;
            foreach ($proveedores as $p){
                $sheet->setCellValue('A' . $row, $conteo);
                $sheet->setCellValue('B' . $row, $p->tipo_documento_identidad_abr);
                $sheet->setCellValue('C' . $row, $p->proveedores_numero_documento);
                $sheet->setCellValue('D' . $row, $p->proveedores_nombre);
                $sheet->setCellValue('E' . $row, $p->proveedores_direccion);
                $sheet->setCellValue('F' . $row, $p->proveedores_telefono);
                $sheet->setCellValue('G' . $row, $p->proveedores_correo);
                $row++;
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
            // Crear una respuesta (response) para el archivo Excel
            $nombreExcel  = "Lista de proveedores ".date('d-m-Y H:i:s').'.xlsx';
            $response = response()->stream(
                function () use ($spreadsheet) {
                    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                    $writer->save('php://output');
                },
                200,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename='.$nombreExcel,
                ]
            );
            return $response;
        }catch (\Exception $e){
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }
    public function guardar_proveedor(Request $request)
    {
        try {
            $result = 2;
            $message = "Ha ocurrido un error.";
            if($request->estadoActionFuction == 1){
                $validar = $this->proveedores->buscarProveedorNumero($request->proveedores_numero_documento);
                if(!$validar){
                    $guardar = DB::table('proveedores')->insert([
                        'id_tipo_documento'=>$request->id_tipo_documento,
                        'proveedores_tipo_persona'=>$request->proveedores_tipo_persona ?: 'juridica',
                        'proveedores_numero_documento'=>$request->proveedores_numero_documento,
                        'proveedores_nombre'=>$request->proveedores_nombre,
                        'proveedores_sexo'=>$request->proveedores_sexo,
                        'proveedores_direccion'=>$request->proveedores_direccion,
                        'proveedores_telefono'=>$request->proveedores_telefono,
                        'proveedores_correo'=>$request->proveedores_correo,
                        'proveedores_nombre_contacto'=>$request->proveedores_nombre_contacto,
                        'proveedores_cargo'=>$request->proveedores_cargo,
                        'proveedores_ubigeo'=>$request->proveedores_ubigeo ?: null,
                        'proveedores_estado'=>1,
                    ]);
                    $result = $guardar ? 1 : 2;
                    $message = "¡Registro guardado exitoso!";
                }else{
                    $result = 3;
                    $message = "Ya hay un proveedor registrado con el número de documento proporcionado.";
                }

                // Subir el archivo
//                $file = $request->file('FileCSV');
//                $path = $file->storeAs('csv_files', 'uploaded_file.csv');  // Guardar el archivo temporalmente
//
//                // Leer el archivo CSV
//                $csvData = file_get_contents(storage_path('app/' . $path));
//                $lines = explode(PHP_EOL, $csvData);
//
//                // Recorrer las líneas y procesar cada una
//                foreach ($lines as $line) {
//                    $columns = str_getcsv($line,';');
//
//                    // Asegurarse de que la línea no esté vacía
//                    if (count($columns) > 0) {
//                        // Reemplazar la coma por punto en el campo decimal
//                        $columns[9] = str_replace(',', '.', $columns[9]); // Cambiar el campo decimal (ajusta el índice si es otro)
//
//                        // Insertar en la base de datos
//                        DB::table('productos')->insert([
//                            'id_ca' => $columns[1],
//                            'id_medida' => $columns[2],
//                            'id_tipo_afectacion' => $columns[3],
//                            'pro_nombre' => $columns[4],
//                            'pro_codigo' => $columns[5],
//                            'pro_descripcion' => $columns[6],
//                            'pro_precio_valor' => $columns[9],
//                            'pro_precio_uni' => $columns[9],
//                            'pro_precio_valor_ma' => $columns[9],
//                            'pro_precio_uni_ma' => $columns[9],
//                            'pro_porcen_igv' => 0,
//                            'pro_stock' => 0,
//                            'pro_estado' => 1,
//                            'impuesto_bolsa' => 0,
//                        ]);
//                    }
//                }
//                // Eliminar el archivo temporal después de procesarlo
//                Storage::delete($path);

            }elseif($request->estadoActionFuction == 2){
                $validar = $this->proveedores->buscarProveedorNumero($request->proveedores_numero_documento);
                if(!$validar || $validar->id_proveedores == $request->id_proveedores){
                    $actualizar = DB::table('proveedores')->where('id_proveedores','=',$request->id_proveedores)->update([
                        'id_tipo_documento'=>$request->id_tipo_documento,
                        'proveedores_tipo_persona'=>$request->proveedores_tipo_persona ?: 'juridica',
                        'proveedores_numero_documento'=>$request->proveedores_numero_documento,
                        'proveedores_nombre'=>$request->proveedores_nombre,
                        'proveedores_sexo'=>$request->proveedores_sexo,
                        'proveedores_direccion'=>$request->proveedores_direccion,
                        'proveedores_telefono'=>$request->proveedores_telefono,
                        'proveedores_correo'=>$request->proveedores_correo,
                        'proveedores_nombre_contacto'=>$request->proveedores_nombre_contacto,
                        'proveedores_cargo'=>$request->proveedores_cargo,
                        'proveedores_ubigeo'=>$request->proveedores_ubigeo ?: null,
                    ]);
                    $result = $actualizar ?1:2;
                    $message = "¡Registro actualizado exitoso!";
                }else{
                    $result = 3;
                    $message = "Ya hay un proveedor registrado con el número de documento proporcionado.";
                }
            }else{
                $delete = DB::table('proveedores')->where('id_proveedores','=',$request->id_proveedores)->update(['proveedores_estado'=>0]);
                $result = $delete ?1:2;
                $message = "¡Registro eliminado exitoso!";
            }
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));
    }
    public function guardar_familia(Request $request)
    {
        try {
            $result = 2;
            $message = "Ha ocurrido un error.";
            if($request->estadoActionFuctionFamilia == 1){
                $validar = $this->familias->familias_x_nombre($request->fa_nombre);
                if(!$validar){
                    $guardar = DB::table('familias')->insert([
                        'fa_nombre'=>$request->fa_nombre,
                        'fa_estado'=>1,
                    ]);
                    $result = $guardar ? 1 : 2;
                    $message = "¡Registro guardado exitoso!";
                }else{
                    $result = 3;
                    $message = "Ya hay una familia registrada con el nombre proporcionado.";

                }
            }elseif($request->estadoActionFuctionFamilia == 2){
                $validar = $this->familias->familias_x_nombre($request->fa_nombre);

                if(!$validar || $validar->id_fa == $request->id_fa){
                    $actualizar = DB::table('familias')->where('id_fa','=',$request->id_fa)->update([
                        'fa_nombre'=>$request->fa_nombre,
                    ]);
                    $result = $actualizar ?1:2;
                    $message = "¡Registro actualizado exitoso!";
                }else{
                    $result = 3;
                    $message = "Ya hay un proveedor registrado con el número de documento proporcionado.";
                }
            }else{
                $delete = DB::table('familias')->where('id_fa','=',$request->id_fa)->update(['fa_estado'=>0]);
                $result = $delete ?1:2;
                $message = "¡Registro eliminado exitoso!";
            }
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));
    }
    public function guardar_cliente(Request $request)
    {
        try {
            $result = 2;
            $message = "Ha ocurrido un error.";
            if($request->estadoActionFuction == 1){ // CREAR

                $validar = DB::table('clientes')->where('cliente_numero','=',$request->cliente_numero)->first();
                if(!$validar){
                    $guardar = DB::table('clientes')->insert([
                        'id_tipo_documento'=>$request->id_tipo_documento,
                        'cliente_tipo_persona'=>$request->cliente_tipo_persona ?: 'natural',
                        'cliente_numero'=>$request->cliente_numero,
                        'cliente_razonsocial'=>$request->cliente_nombre_general,
                        'cliente_nombre'=>$request->cliente_nombre_general,
                        'cliente_sexo'=>$request->cliente_sexo,
                        'cliente_direccion'=>$request->cliente_direccion,
                        'cliente_telefono'=>$request->cliente_telefono,
                        'cliente_correo'=>$request->cliente_correo,
                        'cliente_atencion'=>$request->cliente_atencion,
                        'cliente_ubigeo'=>$request->cliente_ubigeo ?: null,
                        'cliente_contribuyente'=>$request->cliente_contribuyente ?: null,
                        'cliente_fecha'=>date('Y-m-d'),
                        'cliente_estado'=>1,
                    ]);
                    $result = $guardar ? 1 : 2;
                    $message = "¡Registro guardado exitoso!";
                }else{
                    $result = 3;
                    $message = "Ya hay un cliente con ese número de documento.";

                }

            }elseif($request->estadoActionFuction == 2){

                $validar = DB::table('clientes')->where([['cliente_numero','=',$request->cliente_numero],['id_clientes','<>',$request->id_clientes]])->first();

                if(!$validar){
                    $actualizar = DB::table('clientes')->where('id_clientes','=',$request->id_clientes)->update([
                        'id_tipo_documento'=>$request->id_tipo_documento,
                        'cliente_tipo_persona'=>$request->cliente_tipo_persona ?: 'natural',
                        'cliente_numero'=>$request->cliente_numero,
                        'cliente_razonsocial'=>$request->cliente_nombre_general,
                        'cliente_nombre'=>$request->cliente_nombre_general,
                        'cliente_sexo'=>$request->cliente_sexo,
                        'cliente_direccion'=>$request->cliente_direccion,
                        'cliente_telefono'=>$request->cliente_telefono,
                        'cliente_correo'=>$request->cliente_correo,
                        'cliente_atencion'=>$request->cliente_atencion,
                        'cliente_ubigeo'=>$request->cliente_ubigeo ?: null,
                        'cliente_contribuyente'=>$request->cliente_contribuyente ?: null,
                        'cliente_estado'=>1,
                    ]);
                    $result = $actualizar ?1:2;
                    $message = "¡Registro actualizado exitoso!";

                }else{
                    $result = 3;
                    $message = "Ya hay un cliente registrado con el número de documento proporcionado.";
                }

            }else{

                $delete = DB::table('clientes')->where('id_clientes','=',$request->id_clientes)->update(['cliente_estado'=>0]);
                $result = $delete ?1:2;
                $message = "¡Registro eliminado exitoso!";

            }
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));
    }
    public function guardar_categoria(Request $request)
    {
        try {
            $result = 2;
            $message = "Ha ocurrido un error.";
            if($request->estadoActionFuctionCategoria == 1){
                $validar = $this->categorias->categorias_x_nombre($request->ca_nombre);
                if(!$validar){
                    $guardar = DB::table('categorias')->insert([
                        'id_fa'=>$request->id_fa,
                        'ca_nombre'=>$request->ca_nombre,
                        'ca_estado'=>1,
                    ]);
                    $result = $guardar ? 1 : 2;
                    $message = "¡Registro guardado exitoso!";
                }else{
                    $result = 3;
                    $message = "Ya hay una categoria registrada con el nombre proporcionado.";

                }
            }elseif($request->estadoActionFuctionCategoria == 2){
                $validar = $this->categorias->categorias_x_nombre($request->ca_nombre);
                if(!$validar || $validar->id_ca == $request->id_ca){
                    $actualizar = DB::table('categorias')->where('id_ca','=',$request->id_ca)->update([
                        'ca_nombre'=>$request->ca_nombre,
                    ]);
                    $result = $actualizar ? 1 : 2;
                    $message = "¡Registro actualizado exitoso!";
                }else{
                    $result = 3;
                    $message = "Ya hay una categoria registrado con el número de documento proporcionado.";
                }
            }else{
                $delete = DB::table('categorias')->where('id_ca','=',$request->id_ca)->update(['ca_estado'=>0]);
                $result = $delete ?1:2;
                $message = "¡Registro eliminado exitoso!";
            }
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));
    }


    public function listar_datos_proveedor( Request $request){
        try {
            $result = 2;
            $message = "";
            $result =  $this->proveedores->datos_proveeedor($request->id_proveedores);

        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message)));

    }
    public function listarCliente( Request $request){
        try {
            $result = 2;
            $message = "";
            $datos = DB::table('clientes')->where('id_clientes','=',$request->id)->first();
            $ubigeo = null;
            if ($datos){
                $result = 1;
                if ($datos->cliente_ubigeo) {
                    $dist = DB::table('ubigeo_peru_districts')->where('id', $datos->cliente_ubigeo)->first();
                    $prov = $dist ? DB::table('ubigeo_peru_provinces')->where('id', $dist->province_id)->first() : null;
                    $ubigeo = [
                        'dept_id' => $dist ? $dist->department_id : null,
                        'prov_id' => $dist ? $dist->province_id : null,
                        'dist_id' => $datos->cliente_ubigeo,
                    ];
                }
            }
        }catch  (\Exception $e){
            $this->logs->insertarLog($e);
            return response(json_encode($e),200)->header('Content-type','text/plain');
        }
        return json_encode(array("result" => array("code" => $result,'message'=>$message,'datos'=>$datos,'ubigeo'=>$ubigeo)));
    }

    public function ubigeo_provincias(Request $request){
        $provincias = DB::table('ubigeo_peru_provinces')->where('department_id', $request->dept_id)->orderBy('name')->get();
        return response()->json($provincias);
    }

    public function ubigeo_distritos(Request $request){
        $distritos = DB::table('ubigeo_peru_districts')->where('province_id', $request->prov_id)->orderBy('name')->get();
        return response()->json($distritos);
    }

    public function lineas()
    {
        try {
            $lineas = $this->lineas->listar_lineas();
            $opciones = $this->submenu->optiones_por_vista("lineas");
            return view('gestion/lineas', compact('lineas', 'opciones'));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }

    public function guardar_linea(Request $request)
    {
        try {
            $result = 2;
            $message = "Ha ocurrido un error.";

            if ($request->estadoActionFuctionLinea == 1) {
                $validar = $this->lineas->linea_x_codigo($request->linea_codigo);
                if (!$validar) {
                    $guardar = DB::table('lineas')->insert([
                        'id_users'          => \Illuminate\Support\Facades\Auth::id(),
                        'linea_codigo'      => $request->linea_codigo,
                        'linea_descripcion' => $request->linea_descripcion,
                        'linea_tipo'        => $request->linea_tipo ?: null,
                        'linea_estado'      => 1,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);
                    $result = $guardar ? 1 : 2;
                    $message = "¡Registro guardado exitoso!";
                } else {
                    $result = 3;
                    $message = "Ya existe una línea registrada con ese código.";
                }
            } elseif ($request->estadoActionFuctionLinea == 2) {
                $validar = $this->lineas->linea_x_codigo($request->linea_codigo);
                if (!$validar || $validar->id_linea == $request->id_linea) {
                    $actualizar = DB::table('lineas')->where('id_linea', '=', $request->id_linea)->update([
                        'linea_codigo'      => $request->linea_codigo,
                        'linea_descripcion' => $request->linea_descripcion,
                        'linea_tipo'        => $request->linea_tipo ?: null,
                        'updated_at'        => now(),
                    ]);
                    $result = $actualizar ? 1 : 2;
                    $message = "¡Registro actualizado exitoso!";
                } else {
                    $result = 3;
                    $message = "Ya existe una línea registrada con ese código.";
                }
            } else {
                $delete = DB::table('lineas')->where('id_linea', '=', $request->id_linea)->update([
                    'linea_estado' => 0,
                    'updated_at'   => now(),
                ]);
                $result = $delete ? 1 : 2;
                $message = "¡Registro eliminado exitoso!";
            }
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function listar_datos_linea(Request $request)
    {
        try {
            $result = $this->lineas->datos_linea($request->id_linea);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
        return json_encode(array("result" => array("code" => $result)));
    }

    public function clasificadores()
    {
        try {
            $clasificadores = $this->clasificadores->listar_clasificadores();
            $opciones = $this->submenu->optiones_por_vista("clasificadores");
            return view('gestion/clasificadores', compact('clasificadores', 'opciones'));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }

    public function guardar_clasificador(Request $request)
    {
        try {
            $result = 2;
            $message = "Ha ocurrido un error.";

            if ($request->estadoActionFuctionClasificador == 1) {
                $validar = $this->clasificadores->clasificador_x_codigo($request->clasificador_codigo);
                if (!$validar) {
                    $guardar = DB::table('clasificadores')->insert([
                        'id_users'              => Auth::id(),
                        'clasificador_codigo'   => $request->clasificador_codigo,
                        'clasificador_nombre'   => $request->clasificador_nombre,
                        'clasificador_estado'   => 1,
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);
                    $result = $guardar ? 1 : 2;
                    $message = "¡Registro guardado exitoso!";
                } else {
                    $result = 3;
                    $message = "Ya existe un clasificador registrado con ese código.";
                }
            } elseif ($request->estadoActionFuctionClasificador == 2) {
                $validar = $this->clasificadores->clasificador_x_codigo($request->clasificador_codigo);
                if (!$validar || $validar->id_clasificador == $request->id_clasificador) {
                    $actualizar = DB::table('clasificadores')->where('id_clasificador', $request->id_clasificador)->update([
                        'clasificador_codigo' => $request->clasificador_codigo,
                        'clasificador_nombre' => $request->clasificador_nombre,
                        'updated_at'          => now(),
                    ]);
                    $result = $actualizar ? 1 : 2;
                    $message = "¡Registro actualizado exitoso!";
                } else {
                    $result = 3;
                    $message = "Ya existe un clasificador registrado con ese código.";
                }
            } else {
                $delete = DB::table('clasificadores')->where('id_clasificador', $request->id_clasificador)->update([
                    'clasificador_estado' => 0,
                    'updated_at'          => now(),
                ]);
                $result = $delete ? 1 : 2;
                $message = "¡Registro eliminado exitoso!";
            }
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function listar_datos_clasificador(Request $request)
    {
        try {
            $result = $this->clasificadores->datos_clasificador($request->id_clasificador);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
        return json_encode(array("result" => array("code" => $result)));
    }

    public function almacenes()
    {
        try {
            $almacenes = $this->almacenes->listar_almacen();
            $opciones  = $this->submenu->optiones_por_vista("almacenes");
            return view('gestion/almacenes', compact('almacenes', 'opciones'));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }

    public function guardar_almacen(Request $request)
    {
        try {
            $result  = 2;
            $message = "Ha ocurrido un error.";

            if ($request->estadoActionFuctionAlmacen == 1) {
                $validar = $this->almacenes->almacen_x_codigo($request->almacen_codigo);
                if (!$validar) {
                    $guardar = DB::table('almacen')->insert([
                        'almacen_codigo'  => $request->almacen_codigo,
                        'almacen_nombre'  => $request->almacen_nombre,
                        'almacen_sunat'   => $request->almacen_sunat ?: null,
                        'almacen_ap'      => $request->almacen_ap ? 1 : 0,
                        'almacen_estado'  => 1,
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]);
                    $result  = $guardar ? 1 : 2;
                    $message = "¡Registro guardado exitoso!";
                } else {
                    $result  = 3;
                    $message = "Ya existe un almacén registrado con ese código.";
                }
            } elseif ($request->estadoActionFuctionAlmacen == 2) {
                $validar = $this->almacenes->almacen_x_codigo($request->almacen_codigo);
                if (!$validar || $validar->id_almacen == $request->id_almacen) {
                    $actualizar = DB::table('almacen')->where('id_almacen', $request->id_almacen)->update([
                        'almacen_codigo' => $request->almacen_codigo,
                        'almacen_nombre' => $request->almacen_nombre,
                        'almacen_sunat'  => $request->almacen_sunat ?: null,
                        'almacen_ap'     => $request->almacen_ap ? 1 : 0,
                        'updated_at'     => now(),
                    ]);
                    $result  = $actualizar ? 1 : 2;
                    $message = "¡Registro actualizado exitoso!";
                } else {
                    $result  = 3;
                    $message = "Ya existe un almacén registrado con ese código.";
                }
            } else {
                $delete  = DB::table('almacen')->where('id_almacen', $request->id_almacen)->update([
                    'almacen_estado' => 0,
                    'updated_at'     => now(),
                ]);
                $result  = $delete ? 1 : 2;
                $message = "¡Registro eliminado exitoso!";
            }
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function listar_datos_almacen(Request $request)
    {
        try {
            $result = $this->almacenes->datos_almacen($request->id_almacen);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
        return json_encode(array("result" => array("code" => $result)));
    }

    public function operaciones()
    {
        try {
            $operaciones = $this->operaciones->listar_operaciones();
            $opciones    = $this->submenu->optiones_por_vista("operaciones");
            return view('gestion/operaciones', compact('operaciones', 'opciones'));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }

    public function guardar_operacion(Request $request)
    {
        try {
            $result  = 2;
            $message = "Ha ocurrido un error.";

            $datos = [
                'operacion_tipo'        => $request->operacion_tipo,
                'operacion_descripcion' => $request->operacion_descripcion,
                'operacion_operacion'   => $request->operacion_operacion,
                'operacion_stock'       => $request->operacion_stock       ? 1 : 0,
                'operacion_compra'      => $request->operacion_compra      ? 1 : 0,
                'operacion_promediar'   => $request->operacion_promediar   ? 1 : 0,
            ];

            if ($request->estadoActionFuctionOperacion == 1) {
                $guardar = DB::table('operaciones')->insert(array_merge($datos, [
                    'id_users'         => Auth::id(),
                    'operacion_estado' => 1,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]));
                $result  = $guardar ? 1 : 2;
                $message = "¡Registro guardado exitoso!";

            } elseif ($request->estadoActionFuctionOperacion == 2) {
                $actualizar = DB::table('operaciones')
                    ->where('id_operacion', $request->id_operacion)
                    ->update(array_merge($datos, ['updated_at' => now()]));
                $result  = $actualizar ? 1 : 2;
                $message = "¡Registro actualizado exitoso!";

            } else {
                $delete  = DB::table('operaciones')
                    ->where('id_operacion', $request->id_operacion)
                    ->update(['operacion_estado' => 0, 'updated_at' => now()]);
                $result  = $delete ? 1 : 2;
                $message = "¡Registro eliminado exitoso!";
            }
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function listar_datos_operacion(Request $request)
    {
        try {
            $result = $this->operaciones->datos_operacion($request->id_operacion);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
        return json_encode(array("result" => array("code" => $result)));
    }

    public function unidad_manejo()
    {
        try {
            $unidad_manejos = $this->unidadManejos->listar_unidad_manejos();
            $medidas         = Medida::listar_medidas();
            $opciones        = $this->submenu->optiones_por_vista("unidad_manejo");
            return view('gestion/unidad_manejo', compact('unidad_manejos', 'medidas', 'opciones'));
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            echo "<script>
                alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");
                window.location.href = '" . route('admin') . "';
            </script>";
        }
    }

    public function guardar_unidad_manejo(Request $request)
    {
        try {
            $result  = 2;
            $message = "Ha ocurrido un error.";

            if ($request->estadoActionFuctionUM == 1) {
                $validar = $this->unidadManejos->unidad_manejo_x_codigo($request->unidad_manejo_codigo);
                if (!$validar) {
                    $guardar = DB::table('unidad_manejos')->insert([
                        'id_users'              => Auth::id(),
                        'id_medida'             => $request->id_medida,
                        'unidad_manejo_codigo'  => $request->unidad_manejo_codigo,
                        'unidad_manejo_sunat'   => $request->unidad_manejo_sunat ?: null,
                        'unidad_manejo_estado'  => 1,
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);
                    $result  = $guardar ? 1 : 2;
                    $message = "¡Registro guardado exitoso!";
                } else {
                    $result  = 3;
                    $message = "Ya existe una unidad de manejo con ese código.";
                }
            } elseif ($request->estadoActionFuctionUM == 2) {
                $validar = $this->unidadManejos->unidad_manejo_x_codigo($request->unidad_manejo_codigo);
                if (!$validar || $validar->id_unidad_manejo == $request->id_unidad_manejo) {
                    $actualizar = DB::table('unidad_manejos')->where('id_unidad_manejo', $request->id_unidad_manejo)->update([
                        'id_medida'            => $request->id_medida,
                        'unidad_manejo_codigo' => $request->unidad_manejo_codigo,
                        'unidad_manejo_sunat'  => $request->unidad_manejo_sunat ?: null,
                        'updated_at'           => now(),
                    ]);
                    $result  = $actualizar ? 1 : 2;
                    $message = "¡Registro actualizado exitoso!";
                } else {
                    $result  = 3;
                    $message = "Ya existe una unidad de manejo con ese código.";
                }
            } else {
                $delete  = DB::table('unidad_manejos')->where('id_unidad_manejo', $request->id_unidad_manejo)->update([
                    'unidad_manejo_estado' => 0,
                    'updated_at'           => now(),
                ]);
                $result  = $delete ? 1 : 2;
                $message = "¡Registro eliminado exitoso!";
            }
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
        }
        return json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function listar_datos_unidad_manejo(Request $request)
    {
        try {
            $result = $this->unidadManejos->datos_unidad_manejo($request->id_unidad_manejo);
        } catch (\Exception $e) {
            $this->logs->insertarLog($e);
            return response(json_encode($e), 200)->header('Content-type', 'text/plain');
        }
        return json_encode(array("result" => array("code" => $result)));
    }








}
