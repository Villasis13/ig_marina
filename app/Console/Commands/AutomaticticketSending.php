<?php

namespace App\Console\Commands;

use App\Models\apiFacturacion;
use App\Models\Empresa;
use App\Models\Envio_resumen;
use App\Models\Envio_resumen_detalle;
use App\Models\GeneradorXML;
use App\Models\Logs;
use App\Models\Ventas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutomaticticketSending extends Command
{
    private $empresa;
    private $ventas;
    public function __construct()
    {
        parent::__construct(); // Llama al constructor de la clase padre

        $this->logs = new Logs(); // Inicializa el objeto Logs
        $this->empresa = new Empresa();
        $this->ventas =  new Ventas();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sunat:enviar-comprobantes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sunat envio de comprobantes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            Log::info("INICIO");
            $emisor = $this->empresa->listar_datos_empresa();
            $fecha = date('Y-m-d');
            if($emisor->empresa_ruta_certificado != null and $emisor->empresa_clave_certificado != null ){
                $ventas =$this->ventas->listar_venta_x_fecha($fecha,"01");
                if (count($ventas) > 0){
                    $serie = date('Ymd');
                    $fila_serie = DB::table('serie as s')->where('s.tipocomp','=','RC')->first();
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
                        //$ruta = 'ApiFacturacion/xml';// servidor
                        $nombrexml = $emisor->empresa_ruc.'-'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];
                        $nom = $ruta."/".$nombrexml;
                        //CREAMOS EL XML DEL RESUMEN
                        GeneradorXML::CrearXMLResumenDocumentos($emisor, $cabecera, $items, $nom, $fecha);
                        Log::info("eder");
                        Log::info("Se creo");
                        $result = apiFacturacion::EnviarResumenComprobantes($emisor,$nombrexml,'empresas/certificado/','public/ApiFacturacion/xml/',1,1);
                        $ticket = $result['ticket'];
                        $message = $result['mensaje'];
                        Log::info($result);
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
                                            Log::info("listo");
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
                                    $result = apiFacturacion::ConsultarTicket($emisor, $cabecera, $ticket,"public/ApiFacturacion/cdr/", 1,1);
                                }
                            }
                        }elseif($result['result'] == 4){
                            $result = 4;
                        }elseif($result['result'] == 3){
                            $result = 3;
                        }
                    }
                }
            }else{
                $result = 7;
                $message = "La empresa actualmente no dispone de certificado ni clave para llevar a cabo la facturación electrónica.";
            }
        }catch (\Exception $e) {
            $this->logs->insertarLog($e);
        }
    }
}
