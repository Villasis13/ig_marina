<?php

namespace App\Console\Commands;

use App\Models\apiFacturacion;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\GeneradorXML;
use App\Models\Logs;
use App\Models\Tipo_ncredito;
use App\Models\Tipo_ndebito;
use App\Models\Ventas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutomaticticketSendingFac extends Command
{
    private $empresas;
    private $ventas;
    private $cliente;
    private $logs;
    public function __construct()
    {
        parent::__construct(); // Llama al constructor de la clase padre

        $this->logs = new Logs(); // Inicializa el objeto Logs
        $this->empresas = new Empresa();
        $this->ventas =  new Ventas();
        $this->cliente =  new Cliente();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sunatFac:enviar-comprobantes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envios de facturas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $ventasFacturas = $this->ventas->listar_ventas_facturas(1);
            if (count($ventasFacturas) > 0){
                foreach ($ventasFacturas as $v){
                    $id = $v->id_venta;
                    $venta = $this->ventas->listar_soloventa_x_id($id);
                    $detalle_venta = $this->ventas->listar_venta_detalle_x_id_venta($id);
                    $empresa = $this->empresas->listar_datos_empresa();
                    $cliente = $this->cliente->listar_clienteventa_x_id($venta->id_clientes);
                    $nombre = $empresa->empresa_ruc.'-'.$venta->venta_tipo.'-'.$venta->venta_serie.'-'.$venta->venta_correlativo;
                    $ruta = "ApiFacturacion/xml/"; // servidor
                    //$ruta = public_path('ApiFacturacion/xml/'); // local

                    if($venta->venta_tipo == '01' || $venta->venta_tipo == '03') {
                        GeneradorXML::CrearXMLFactura($ruta.$nombre, $empresa, $cliente, $venta, $detalle_venta);
//                            Log::info("salio");
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
//                        Log::info("entrada a api facturacion");
                    $result = apiFacturacion::EnviarComprobanteElectronico($empresa,$nombre,"ApiFacturacion/","ApiFacturacion/xml/","ApiFacturacion/cdr/", $id,1);
//                        Log::info($result);
                    if($result == 1){
//                            Log::info('TERMINADO');
                        $actualizar = DB::table('ventas')->where('id_venta','=',$id)
                            ->update([
                                'venta_tipo_envio'=>1,
                                'venta_estado_sunat'=>1,
                                'venta_fecha_envio'=>date('Y-m-d H:i:s')
                            ]);
                        $result = 1;
                    }
                }
            }

        }catch (\Exception $e) {
            $this->logs->insertarLog($e);
        }
    }
}
