<?php

namespace App\Models;

use App\Models\Signature;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

//use App\Models\Signature;
class apiFacturacion extends Model
{
    use HasFactory;

    public static function EnviarComprobanteElectronico($emisor, $nombre, $rutacertificado, $ruta_archivo_xml, $ruta_archivo_cdr,$id_venta,$estado = null)
    {
        //require 'app/models/Ventas.php';
        $objfirma = new Signature();
        $objventa = new Ventas();
        $flg_firma = 0; //Posicion del XML: 0 para firma
        // $ruta_xml_firmar = $ruta . '.XML'; //es el archivo XML que se va a firmar
        $ruta = $ruta_archivo_xml . $nombre . '.XML';
//        Log::info($ruta.'enviarPr');

        //variable para seguir un orden del proceso,
        $result = 2; //result 2 es error y 1 es ok

        $consultaEmpresa =  DB::table('ventas as v')
            ->join('empresa as em','em.id_empresa','=','v.id_empresa')
            ->where('v.id_venta','=',$id_venta)->first();
        if($consultaEmpresa){
            $ruta_firma = $consultaEmpresa->empresa_ruta_certificado; //ruta del archivo del certicado para firmar
            $pass_firma = $consultaEmpresa->empresa_clave_certificado; //contraseña del certificado
            if ($estado == 1){
                $ruta_firma  = public_path($consultaEmpresa->empresa_ruta_certificado);
                $ruta = public_path($ruta_archivo_xml . $nombre . '.XML');
//                Log::info($ruta);
            }
        }else{
            $ruta_firma = $rutacertificado. 'certificado_20607850179.pfx'; //ruta del archivo del certicado para firmar
            $pass_firma = 'zwnjiptg99E4XDg'; //contraseña del certificado
        }
//        Log::info($result);


        $resp = Signature::signature_xml($flg_firma, $ruta, $ruta_firma, $pass_firma);
//        Log::info($resp);
//        $objfirma->signature_xml($flg_firma, $ruta, $ruta_firma, $pass_firma);
        //print_r($resp);
        if($resp['respuesta'] == 'ok'){
            $ruta_xml = $ruta_archivo_xml.$nombre.'.XML';
            $result = DB::table('ventas')->where('id_venta','=',$id_venta)->update(['venta_rutaXML'=>$ruta_xml]);
            if ($result == 1 || $result == 0){
                $result = 1;
            }
//            Log::info($result);
//            Log::info("Se actualizo");
        }
        //echo '</br> XML FIRMADO';

        //FIRMAR XML - FIN
        if($result == 1){
            //CONVERTIR A ZIP - INICIO
            $zip = new \ZipArchive();

            $nombrezip = $nombre.".ZIP";
            $rutazip = $ruta_archivo_xml . $nombre.".ZIP";
//            Log::info("antes de crear el zip");
//            Log::info($rutazip);
            if ($estado == 1){
                $rutazip  = public_path($ruta_archivo_xml . $nombre.".ZIP");
            }
            if($zip->open($rutazip, \ZipArchive::CREATE) === TRUE)
            {
                $zip->addFile($ruta, $nombre . '.XML');
                $zip->close();
                $result = 1;
//                Log::info("Creacion archivo zip");

            }else{
//                Log::info("no se creo :(");

                $result = 2;
            }

            //echo '</br>XML ZIPEADO';
            //CONVERTIR A ZIP - FIN
            if($result == 1){

                //ENVIAR EL ZIP A LOS WS DE SUNAT - INICIO
                $ws = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService'; //ruta del servicio web de pruebad e SUNAT para enviar documentos
                //$ws = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService'; //Modo produccion
                $ruta_archivo = $rutazip;
                $nombre_archivo = $nombrezip;

                $contenido_del_zip = base64_encode(file_get_contents($ruta_archivo)); //codificar y convertir en texto el .zip

                //echo '</br> '. $contenido_del_zip;
                $xml_envio ='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                        <soapenv:Header>
                        <wsse:Security>
                            <wsse:UsernameToken>
                                <wsse:Username>'.$emisor->empresa_ruc.$emisor->empresa_usuario_sol.'</wsse:Username>
                                <wsse:Password>'.$emisor->empresa_clave_sol.'</wsse:Password>
                            </wsse:UsernameToken>
                        </wsse:Security>
                        </soapenv:Header>
                        <soapenv:Body>
                        <ser:sendBill>
                            <fileName>'.$nombre_archivo.'</fileName>
                            <contentFile>'.$contenido_del_zip.'</contentFile>
                        </ser:sendBill>
                        </soapenv:Body>
                    </soapenv:Envelope>';

                $header = array(
                    "Content-type: text/xml; charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "SOAPAction: ",
                    "Content-lenght: ".strlen($xml_envio)
                );

                $ch = curl_init(); //iniciar la llamada
                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 1); //
                curl_setopt($ch,CURLOPT_URL, $ws);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch,CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($ch,CURLOPT_TIMEOUT, 30);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_POSTFIELDS, $xml_envio);
                curl_setopt($ch,CURLOPT_HTTPHEADER, $header);

                //para ejecutar los procesos de forma local en windows
                //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
                curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem"); //solo en local, si estas en el servidor web con ssl comentar esta línea

                $response = curl_exec($ch); // ejecucion del llamado y respuesta del WS SUNAT.

                $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE); // objten el codigo de respuesta de la peticion al WS SUNAT
                $estadofe = "0"; //inicializo estado de operación interno

                if($httpcode == 200)//200: La comunicacion fue satisfactoria
                {
//                    Log::info("CONEXION CON SERVIDOR");
                    $doc = new \DOMDocument();//clase que nos permite crear documentos XML
                    $doc->loadXML($response); //cargar y crear el XML por medio de text-xml response

                    if( isset( $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue ) ) // si en la etique de rpta hay valor entra
                    {
                        $cdr = $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue; //guadarmos la respuesta(text-xml) en la variable
                        $cdr = base64_decode($cdr); //decodificando el xml
                        if ($estado == 1){
                            $guar  = public_path($ruta_archivo_cdr . 'R-' . $nombrezip );
                            file_put_contents($guar,$cdr); //guardo el CDR zip en la carpeta cdr
//                            Log::info("$guar");
                            $ruta_cdr__ = public_path($ruta_archivo_cdr. 'R-' . $nombrezip);
                        }else{
                            file_put_contents($ruta_archivo_cdr . 'R-' . $nombrezip, $cdr ); //guardo el CDR zip en la carpeta cdr
                            $ruta_cdr__ = $ruta_archivo_cdr. 'R-' . $nombrezip;
                        }
//                        Log::info("eder2");
                        $zip = new \ZipArchive();
                        if($zip->open($ruta_cdr__ ) === true ) //rpta es identica existe el archivo
                        {
//                            Log::info("entro a cdr");
                            $zip->extractTo($ruta_archivo_cdr, 'R-' . $nombre . '.XML');
                            $zip->close();
                            if ($estado == 1) {
                                $ruta_cdr = public_path($ruta_archivo_cdr.'R-' . $nombre . '.XML');
                            }else{
                                $ruta_cdr = $ruta_archivo_cdr.'R-' . $nombre . '.XML';
                            }
//                            Log::info("eder");
//                            Log::info($ruta_cdr);
                            $result = DB::table('ventas')->where('ventas.id_venta','=',$id_venta)->update(['venta_rutaCDR'=>$ruta_cdr]);
                            if($result == 1 || $result == 0){
                                //INICIO - VERIFICAR RESPUESTA DEL CDR
                                if ($estado == 1) {
                                    $ruta_cdr = $ruta_archivo_cdr.'R-' . $nombre . '.XML';
                                }else{
                                    $ruta_cdr = $ruta_archivo_cdr.'R-' . $nombre . '.XML';
                                }
                                $xml_cdr = simplexml_load_file($ruta_cdr);
                                $xml_cdr->registerXPathNamespace('c', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

                                $DocumentResponse = array();

                                $ReferenceID    = $xml_cdr->xpath('///c:ReferenceID');
                                $ResponseCode   = $xml_cdr->xpath('///c:ResponseCode');
                                $Description    = $xml_cdr->xpath('///c:Description');
                                $Notes          = $xml_cdr->xpath('///c:Note');

                                $DocumentResponse['RefenceID']      = (string)$ReferenceID[0];
                                $DocumentResponse['ResponseCode']   = (string)$ResponseCode[0];
                                $DocumentResponse['Description']    = (string)$Description[0];

                                if(count($Notes) > 0){
                                    foreach ($Notes as $note){
                                        $DocumentResponse['Notes'][] = (string)$Notes[0];
                                    }
                                }
                                //FIN - VERIFICAR RESPUESTA DEL CDR

                                $estado_sunat = $DocumentResponse['Description'];
                                $result = DB::table('ventas')->where('id_venta','=',$id_venta)->update(['venta_respuesta_sunat'=>$estado_sunat]);
                                if ($result == 1 || $result == 0){
                                    $result  = 1;
                                }
                            }
                            //$estadofe = '1';
                            //echo 'Procesado correctamente, OK';
                        }else{
                            $result = 2;
                        }

                    }
                    else {
                        $estadofe = '2';
                        $result = 3; //error de envio comprobante
                        $codigo = $doc->getElementsByTagName('faultcode')->item(0)->nodeValue;
                        $mensaje = $doc->getElementsByTagName('faultstring')->item(0)->nodeValue;
                        //LOG DE TRAX ERRORES DB
                        $estado_sunat = 'Ocurrio un error con código: ' . $codigo . ' Msje:' . $mensaje;
                        $result = DB::table('ventas')->where('id_venta','=',$id_venta)->update(['venta_respuesta_sunat'=>$estado_sunat]);
                        //echo 'Ocurrio un error con código: ' . $codigo . ' Msje:' . $mensaje;
                    }
                }
                else { //Problemas de comunicacion
                    Log::info("Problemas de comunicacionR");
                    $estadofe = "3";
                    $result = 4; //error de comunicacion(internet o sunat)
                    //LOG DE TRAX ERRORES DB
                    echo curl_error($ch);
                    $estado_sunat = 'Hubo o existe un problema de conexión';
                    $result = DB::table('ventas')->where('id_venta','=',$id_venta)->update(['venta_respuesta_sunat'=>$estado_sunat]);

//                    $objventa->guardar_repuesta_venta($id_venta, $estado_sunat);
                    //echo 'Hubo existe un problema de conexión';
                }

                curl_close($ch);

                //ENVIAR EL ZIP A LOS WS DE SUNAT - FIN
            }

        }
//        Log::info("finalizo");
//        Log::info($result);
        return $result;

    }
    public static function FirmarXMLPRI(string $baseUrl, string $tokenAcceso, string $rutaXml, string $nombreArchivo, bool $insecure = false)
    {
        if (!file_exists($rutaXml)) {
            throw new \RuntimeException("No existe el XML sin firma en: {$rutaXml}");
        }

        $tokenAcceso = trim($tokenAcceso ?? '');
        if (stripos($tokenAcceso, 'Bearer ') === 0) {
            $tokenAcceso = trim(substr($tokenAcceso, 7));
        }
        if ($tokenAcceso === '') {
            throw new \RuntimeException('token_acceso vacío.');
        }

        $xmlBase64 = base64_encode(file_get_contents($rutaXml));
        $payload = [
            'tipo_integracion'  => 0,
            'nombre_archivo'    => $nombreArchivo,
            'contenido_archivo' => $xmlBase64,
        ];


        $client = new Client([
            'base_uri' => rtrim($baseUrl, '/'),
            'timeout'  => 30,
            'verify'   => !$insecure, // EN PRODUCCIÓN: SIEMPRE true
        ]);

        try {
            $res = $client->post('/api/cpe/generar', [
                'headers' => [
                    'Authorization' => 'Bearer '.$tokenAcceso,
                    'Accept'        => 'application/json',
                ],
                'json' => $payload,
            ]);
        } catch (RequestException $e) {
            $status = $e->getResponse() ? $e->getResponse()->getStatusCode() : 0;
            $body   = $e->getResponse() ? (string) $e->getResponse()->getBody() : $e->getMessage();
            throw new \RuntimeException("Error HTTP al firmar XML (QPSE): {$status} {$body}");
        }

        $statusCode = $res->getStatusCode();
        $body       = (string) $res->getBody();
        $data       = json_decode($body, true);

        if ($statusCode >= 400) {
            throw new \RuntimeException("Error al firmar XML (QPSE): {$statusCode} {$body}");
        }

        $okByEstado  = isset($data['estado']) && (int)$data['estado'] === 200;
        $okBySuccess = isset($data['success']) && $data['success'] === true;

        if (!($okByEstado || $okBySuccess)) {
            $msg = $data['mensaje'] ?? $data['message'] ?? 'Respuesta no exitosa';
            throw new \RuntimeException("Firmado no aceptado: {$msg} | body={$body}");
        }

        $xmlFirmadoB64 = $data['xml'] ?? $data['contenido_xml_firmado'] ?? null;
        if (!$xmlFirmadoB64) {
            throw new \RuntimeException('La respuesta no contiene el campo "xml" firmado.');
        }

        return [
            'estado'      => $data['estado']      ?? null,
            'success'     => $data['success']     ?? null,
            'xml'         => $xmlFirmadoB64,
            'codigo_hash' => $data['codigo_hash'] ?? null,
            'mensaje'     => $data['mensaje']     ?? ($data['message'] ?? null),
            'external_id' => $data['external_id'] ?? null,
            'raw'         => $data,
        ];
    }
    public static function EnviarResumenComprobantes($emisor,$nombre, $rutacertificado, $ruta_archivo_xml,$id_empresa = null,$estado = null)
    {
        //firma del documento
        $objSignature = new Signature();
        $result = 2;
        $flg_firma = "0";
        //$ruta_archivo_xml = "xml/";
        $ruta = $ruta_archivo_xml.$nombre.'.XML';
        if ($id_empresa){
            $datos_empresa = DB::table('empresa')->where('id_empresa','=',$id_empresa)->first();
            $ruta_firma  = $datos_empresa->empresa_ruta_certificado;
            $pass_firma  = $datos_empresa->empresa_clave_certificado;
            if ($estado == 1){
                $ruta_firma  = public_path($datos_empresa->empresa_ruta_certificado);
            }
        }else{
            $ruta_firma = $rutacertificado. 'certificado_20607850179.pfx'; //ruta del archivo del certicado para firmar
            //$ruta_firma = $rutacertificado. 'certificado_20607850179.pfx';
            $pass_firma = 'zwnjiptg99E4XDg'; //contraseña del certificado
            //$pass_firma = 'zwnjiptg99E4XDg';
        }

        $resp = Signature::signature_xml($flg_firma, $ruta, $ruta_firma, $pass_firma);
//        $resp = $objSignature->signature_xml($flg_firma, $ruta, $ruta_firma, $pass_firma);
        //print_r($resp); //hash
        if($resp['respuesta'] == 'ok'){
            //Generar el .zip
            $zip = new \ZipArchive();
            $nombrezip = $nombre.".ZIP";
            $rutazip = $ruta_archivo_xml.$nombre.".ZIP";

            if($zip->open($rutazip,\ZIPARCHIVE::CREATE)===true){
                $zip->addFile($ruta, $nombre.'.XML');
                $zip->close();
                $result = 1;
            }else{
                $result = 2;
            }
        }
        $ticket = "0";
        $mensaje = "";
        if($result == 1){
            //Enviamos el archivo a sunat

            $ws = "https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService";
//            $ws = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService'; //Modo produccion


            $ruta_archivo = $ruta_archivo_xml.$nombrezip;
            $nombre_archivo = $nombrezip;
            $ruta_archivo_cdr = "public/ApiFacturacion/cdr/";
            // Para registrar un mensaje simple:
            $contenido_del_zip = base64_encode(file_get_contents($ruta_archivo));

            $xml_envio ='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				 <soapenv:Header>
				 	<wsse:Security>
				 		<wsse:UsernameToken>
				 			<wsse:Username>'.$emisor->empresa_ruc.$emisor->empresa_usuario_sol.'</wsse:Username>
				 			<wsse:Password>'.$emisor->empresa_clave_sol.'</wsse:Password>
				 		</wsse:UsernameToken>
				 	</wsse:Security>
				 </soapenv:Header>
				 <soapenv:Body>
				 	<ser:sendSummary>
				 		<fileName>'.$nombre_archivo.'</fileName>
				 		<contentFile>'.$contenido_del_zip.'</contentFile>
				 	</ser:sendSummary>
				 </soapenv:Body>
				</soapenv:Envelope>';


            $header = array(
                "Content-type: text/xml; charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: ",
                "Content-lenght: ".strlen($xml_envio)
            );


            $ch = curl_init();
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);
            curl_setopt($ch,CURLOPT_URL,$ws);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_ANY);
            curl_setopt($ch,CURLOPT_TIMEOUT,55);
            curl_setopt($ch,CURLOPT_POST,true);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$xml_envio);
            curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
            //para ejecutar los procesos de forma local en windows
            //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
            curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem");


            $response = curl_exec($ch);

            $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
            $estadofe = "0";

            $ticket = "0";
            if($httpcode == 200){
                $doc = new \DOMDocument();
                $doc->loadXML($response);
                if (isset($doc->getElementsByTagName('ticket')->item(0)->nodeValue)) {
                    $ticket = $doc->getElementsByTagName('ticket')->item(0)->nodeValue;
                    //echo "TODO OK NRO TK: ".$ticket;
                    $result = 1;
                    $mensaje = "TICKET ENVIADO";
                }else{
                    $codigo = $doc->getElementsByTagName("faultcode")->item(0)->nodeValue;
                    $mensaje = $doc->getElementsByTagName("faultstring")->item(0)->nodeValue;
                    //echo "error ".$codigo.": ".$mensaje;
                    $mensaje = "error ".$codigo.": ".$mensaje;
                    $result = 4;
                }

            }else{
                echo curl_error($ch);
                //echo "Problema de conexión";
                $mensaje = "Problema de conexión";
                $result = 3;
            }

            curl_close($ch);
            //return $ticket;
        }
        $resultado = array(
            "result" => $result,
            "ticket" => $ticket,
            "mensaje" => $mensaje
        );
        return $resultado;

    }
    public static function ConsultarTicket($emisor, $cabecera, $ticket, $ruta_archivo_cdr, $tipo,$id_empresa = null)
    {
        $objventa = new Ventas();
        $ws = "https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService"; //modo beta
        //$ws = "https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService"; //modo produccion
        $ruta_archivo_xml = "public/ApiFacturacion/xml/";
        $nombre	= $emisor->empresa_ruc.'-'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];
        $nombre_xml	= $nombre.".XML";

        //===============================================================//
        //FIRMADO DEL cpe CON CERTIFICADO DIGITAL
        $objSignature = new Signature();
        $flg_firma = "0";
        $ruta = $ruta_archivo_xml.$nombre_xml;
        if($id_empresa){

        }else{
            $ruta_firma = "certificado_20607850179.pfx";
            $pass_firma = "zwnjiptg99E4XDg";
        }


        //===============================================================//

        //ALMACENAR EL ARCHIVO EN UN ZIP
        $zip = new \ZipArchive();

        $nombrezip = $nombre.".ZIP";

        /*if($zip->open($nombrezip,ZIPARCHIVE::CREATE)===true){
            $zip->addFile($ruta, $nombre_xml);
            $zip->close();
        }*/

        //===============================================================//

        //ENVIAR ZIP A SUNAT
        $ruta_archivo = $nombre;
        $nombre_archivo = $nombre;
        //$ruta_archivo_cdr = "cdr/";

        //$contenido_del_zip = base64_encode(file_get_contents($ruta_archivo.'.ZIP'));
        //FIN ZIP

        $xml_envio = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <soapenv:Header>
                <wsse:Security>
                    <wsse:UsernameToken>
                    <wsse:Username>'.$emisor->empresa_ruc.$emisor->empresa_usuario_sol.'</wsse:Username>
                    <wsse:Password>'.$emisor->empresa_clave_sol.'</wsse:Password>
                    </wsse:UsernameToken>
                </wsse:Security>
            </soapenv:Header>
            <soapenv:Body>
                <ser:getStatus>
                    <ticket>' . $ticket . '</ticket>
                </ser:getStatus>
            </soapenv:Body>
        </soapenv:Envelope>';


        $header = array(
            "Content-type: text/xml; charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: ",
            "Content-lenght: ".strlen($xml_envio)
        );


        $ch = curl_init();
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);
        curl_setopt($ch,CURLOPT_URL,$ws);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_ANY);
        curl_setopt($ch,CURLOPT_TIMEOUT,60);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$xml_envio);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        //para ejecutar los procesos de forma local en windows
        //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem");

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);

        //echo "codigo:".$httpcode;

        if($httpcode == 200){
            $doc = new \DOMDocument();
            $doc->loadXML($response);

            if(isset($doc->getElementsByTagName('content')->item(0)->nodeValue)){
                $cdr = $doc->getElementsByTagName('content')->item(0)->nodeValue;
                $cdr = base64_decode($cdr);
                file_put_contents($ruta_archivo_cdr."R-".$nombre_archivo.".ZIP", $cdr);
                $zip = new \ZipArchive();
                if($zip->open($ruta_archivo_cdr."R-".$nombre_archivo.".ZIP")===true){
                    $zip->extractTo($ruta_archivo_cdr,'R-'.$nombre_archivo.'.XML');
                    $zip->close();
                }
                $mensaje_consulta = "Ha sido aceptado";
                $nombre_ruta_cdr = $ruta_archivo_cdr.'R-'.$nombre_archivo.'.XML';
                //INICIO - VERIFICAR RESPUESTA DEL CDR
//                $filePath = public_path($nombre_ruta_cdr);
                $xml_cdr = simplexml_load_file($nombre_ruta_cdr);
                $xml_cdr->registerXPathNamespace('c', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

                $DocumentResponse = array();

                $ReferenceID    = $xml_cdr->xpath('///c:ReferenceID');
                $ResponseCode   = $xml_cdr->xpath('///c:ResponseCode');
                $Description    = $xml_cdr->xpath('///c:Description');
                $Notes          = $xml_cdr->xpath('///c:Note');

                $DocumentResponse['RefenceID']      = (string)$ReferenceID[0];
                $DocumentResponse['ResponseCode']   = (string)$ResponseCode[0];
                $DocumentResponse['Description']    = (string)$Description[0];

                if(count($Notes) > 0){
                    foreach ($Notes as $note){
                        $DocumentResponse['Notes'][] = (string)$Notes[0];
                    }
                }
                //FIN - VERIFICAR RESPUESTA DEL CDR
                $mensaje_consulta = $DocumentResponse['Description'];
                if($tipo == 1){
                    DB::table('envio_resumen')->where('envio_resumen_ticket','=',$ticket)
                        ->update([
                            'envio_resumen_nombreCDR' => $nombre_ruta_cdr,
                            'envio_resumen_estadosunat_consulta'=>$mensaje_consulta
                        ]);
                }else{
                    DB::table('ventas_anulados')->where('venta_anulacion_ticket','=',$ticket)
                        ->update([
                            'venta_anulado_rutaCDR'=>$nombre_ruta_cdr,
                            'venta_anulado_estado_sunat'=>$mensaje_consulta
                        ]);
                }
                //echo "TODO OK";
                $result = 1;
            }else{
                $codigo = $doc->getElementsByTagName("faultcode")->item(0)->nodeValue;
                $mensaje = $doc->getElementsByTagName("faultstring")->item(0)->nodeValue;
                //echo "error ".$codigo.": ".$mensaje;
                $mensaje_consulta = "error ".$codigo.": ".$mensaje;
                $nombre_ruta_cdr = '';
                if($tipo == 1){
                    DB::table('envio_resumen')->where('envio_resumen_ticket','=',$ticket)
                        ->update([
                            'envio_resumen_nombreCDR' => $nombre_ruta_cdr,
                            'envio_resumen_estadosunat_consulta'=>$mensaje_consulta
                        ]);

                }else{
                    DB::table('ventas_anulados')->where('venta_anulacion_ticket','=',$ticket)
                        ->update([
                            'venta_anulado_rutaCDR'=>$nombre_ruta_cdr,
                            'venta_anulado_estado_sunat'=>$mensaje_consulta
                        ]);

                }
                $result = 4;
            }

        }else{
            echo curl_error($ch);
            echo "Problema de conexión";
            $result = 3;
        }

        curl_close($ch);
        return $result;
    }
//    public static function ConsultarTicketPri($baseUrl, $tokenAcceso, $nombreArchivo)
//    {
//        try {
//            $client = new Client(['verify' => false]);
//
//            $response = $client->get($baseUrl . '/api/cpe/consultar/' . $nombreArchivo, [
//                'headers' => [
//                    'Accept' => 'application/json',
//                    'Content-Type' => 'application/json',
//                    'Authorization' => 'Bearer ' . $tokenAcceso
//                ]
//            ]);
//
//            $respuesta = json_decode($response->getBody(), true);
//
//            return [
//                'success' => true,
//                'data' => $respuesta,
//                'mensaje' => 'Consulta realizada correctamente'
//            ];
//
//        } catch (\GuzzleHttp\Exception\RequestException $e) {
//            $errorResponse = $e->getResponse();
//            $errorBody = $errorResponse ? json_decode($errorResponse->getBody(), true) : ['mensaje' => $e->getMessage()];
//
//            return [
//                'success' => false,
//                'error' => $errorBody,
//                'mensaje' => 'Error al consultar ticket'
//            ];
//        } catch (\Exception $e) {
//            return [
//                'success' => false,
//                'error' => $e->getMessage(),
//                'mensaje' => 'Error inesperado al consultar ticket'
//            ];
//        }
//    }
    public static function ConsultarTicketPri($baseUrl, $tokenAcceso, $nombreArchivo, $ticket, $tipo = 1)
    {
        try {
            $client = new Client(['verify' => true]);

            $response = $client->get($baseUrl . '/api/cpe/consultar/' . $nombreArchivo, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $tokenAcceso
                ]
            ]);

            $httpcode = $response->getStatusCode();

            if($httpcode == 200) {
                $respuesta = json_decode($response->getBody(), true);

                // Asumiendo que la respuesta contiene el CDR en base64 similar al ejemplo
                if(isset($respuesta['cdr'])) {
                    $cdr = $respuesta['cdr'];
                    $cdr = base64_decode($cdr);

                    $ruta_archivo_cdr = public_path('ApiFacturacion/cdr/');
                    file_put_contents($ruta_archivo_cdr . "R-" . $nombreArchivo . ".ZIP", $cdr);

                    $zip = new \ZipArchive();
                    if($zip->open($ruta_archivo_cdr . "R-" . $nombreArchivo . ".ZIP") === true) {
                        $zip->extractTo($ruta_archivo_cdr, 'R-' . $nombreArchivo . '.XML');
                        $zip->close();
                    }

                    $mensaje_consulta = $respuesta['mensaje'];
                    $nombre_ruta_cdr = $ruta_archivo_cdr . 'R-' . $nombreArchivo . '.XML';

                    if($tipo == 1) {
                        DB::table('envio_resumen')->where('envio_resumen_ticket', '=', $ticket)
                            ->update([
                                'envio_resumen_nombreCDR' => $nombre_ruta_cdr,
                                'envio_resumen_estadosunat_consulta' =>  $mensaje_consulta
                            ]);
                    } else {
//                        DB::table('ventas_anulados')->where('venta_anulacion_ticket', '=', $ticket)
//                            ->update([
//                                'venta_anulado_rutaCDR' => $nombre_ruta_cdr,
//                                'venta_anulado_estado_sunat' => $mensaje_consulta
//                            ]);
                    }

                    return [
                        'success' => true,
                        'result' => 1,
                        'mensaje' => $mensaje_consulta,
                        'data' => ""
                    ];

                } else {
                    // Manejar errores de la API
                    $codigo = isset($respuesta['faultcode']) ? $respuesta['faultcode'] : 'Desconocido';
                    $mensaje = isset($respuesta['faultstring']) ? $respuesta['faultstring'] : 'Error desconocido';

                    $mensaje_consulta = "error " . $codigo . ": " . $mensaje;
                    $nombre_ruta_cdr = '';

                    if($tipo == 1) {
                        DB::table('envio_resumen')->where('envio_resumen_ticket', '=', $ticket)
                            ->update([
                                'envio_resumen_nombreCDR' => $nombre_ruta_cdr,
                                'envio_resumen_estadosunat_consulta' => $mensaje_consulta
                            ]);
                    } else {
                        DB::table('ventas_anulados')->where('venta_anulacion_ticket', '=', $ticket)
                            ->update([
                                'venta_anulado_rutaCDR' => $nombre_ruta_cdr,
                                'venta_anulado_estado_sunat' => $mensaje_consulta
                            ]);
                    }

                    return [
                        'success' => false,
                        'result' => 4,
                        'mensaje' => $mensaje_consulta,
                        'error' => $respuesta
                    ];
                }

            } else {
                return [
                    'success' => false,
                    'result' => 3,
                    'mensaje' => 'Problema de conexión: HTTP Code ' . $httpcode,
                    'error' => 'HTTP Error'
                ];
            }

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $errorResponse = $e->getResponse();
            $errorBody = $errorResponse ? json_decode($errorResponse->getBody(), true) : ['mensaje' => $e->getMessage()];

            return [
                'success' => false,
                'result' => 3,
                'error' => $errorBody,
                'mensaje' => 'Error al consultar ticket'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'result' => 3,
                'error' => $e->getMessage(),
                'mensaje' => 'Error inesperado al consultar ticket'
            ];
        }
    }
    public static function crearEmpresa(string $baseUrl, string $panelToken, string $ruc, string $razonSocial, bool $insecure=false): array
    {
        $baseUrl    = rtrim(trim($baseUrl), '/');
        $panelToken = trim(preg_replace('/^Bearer\s+/i', '', (string)$panelToken));
        $host       = parse_url($baseUrl, PHP_URL_HOST);

        if (!in_array($host, ['demo-cpe.qpse.pe', 'cpe.qpse.pe'], true)) {
            return ['success'=>false, 'error'=>"Host inválido: {$host}. Usa https://demo-cpe.qpse.pe o https://cpe.qpse.pe"];
        }

        $client = new Client([
            'base_uri'        => $baseUrl,
            'connect_timeout' => 15,
            'timeout'         => 60,
            'verify'          => true, // en prod: true
            'headers'         => ['User-Agent' => 'Guzzle/7 PHP/'.PHP_VERSION],
            'curl'            => [
                CURLOPT_IPRESOLVE     => CURL_IPRESOLVE_V4,
                CURLOPT_HTTP_VERSION  => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSLVERSION    => CURL_SSLVERSION_TLSv1_2,
                CURLOPT_HTTPHEADER    => ['Expect:'],
                CURLOPT_TCP_KEEPALIVE => 1,
                CURLOPT_TCP_KEEPIDLE  => 30,
                CURLOPT_TCP_KEEPINTVL => 15,
            ],
        ]);

        try {
            $res = $client->post('/api/empresa/crear', [
                'http_errors' => false,
                'headers'     => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer '.$panelToken,
                ],
                'json' => [
                    'ruc'          => (string)$ruc,
                    'razon_social' => (string)$razonSocial,
                ],
            ]);

            $status      = $res->getStatusCode();
            $contentType = $res->getHeaderLine('Content-Type');
            $body        = (string)$res->getBody();

            // Intenta parsear JSON si viene JSON
            $asJson = stripos($contentType, 'application/json') !== false ? json_decode($body, true) : null;

            if ($status >= 400) {
                // pistas útiles
                $hint = '';
                if ($status === 401) {
                    $hint = ' (token de PANEL inválido/ambiente incorrecto)';
                } elseif ($status === 500) {
                    $hint = ' (posible RUC ya registrado o error interno del backend)';
                }
                // devuelve el HTML recortado si no es JSON
                $shortBody = $asJson ? json_encode($asJson) : mb_substr(preg_replace('/\s+/', ' ', strip_tags($body)), 0, 300).'...';
                return [
                    'success'     => false,
                    'http_status' => $status,
                    'content_type'=> $contentType,
                    'error'       => "HTTP {$status}{$hint} body={$shortBody}",
                ];
            }

            $data = $asJson ?? json_decode($body, true) ?? [];
            return [
                'success'   => $data['success'] ?? (($data['estado'] ?? null) === 200),
                'username'  => $data['username']   ?? $data['user']        ?? null,
                'password'  => $data['password']   ?? $data['contraseña']  ?? null,
                'client_id' => $data['client_id']  ?? $data['cliente_id']  ?? null,
                'raw'       => $data,
            ];

        } catch (RequestException $e) {
            $status = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 0;
            $resp   = $e->hasResponse() ? (string)$e->getResponse()->getBody() : '';
            return [
                'success'     => false,
                'http_status' => $status,
                'error'       => "Fallo red: {$e->getMessage()}",
                'body'        => $resp,
            ];
        }
    }
    public static function obtenerToken(string $baseUrl, string $usuario, string $password, bool $insecure = false): string
    {
        $client = new Client([
            'base_uri' => rtrim($baseUrl, '/'),
            'timeout'  => 180,
            'verify'   => !$insecure,
        ]);

        try {
            $res = $client->post('/api/auth/cpe/token', [
                'headers' => [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'usuario'    => $usuario,
                    'contraseña' => $password,
                ],
            ]);

            $status = $res->getStatusCode();
            $body   = (string)$res->getBody();
            if ($status !== 200) {
                throw new \RuntimeException("HTTP {$status}: {$body}");
            }

            $data  = json_decode($body, true) ?: [];
            $token = $data['token_acceso'] ?? $data['token'] ?? $data['access_token'] ?? null;
            if (!$token) {
                $msg = $data['mensaje'] ?? $data['message'] ?? 'No se recibió token';
                throw new \RuntimeException("Error al obtener token: {$msg}");
            }
            return trim($token);

        } catch (RequestException $e) {
            $status = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 0;
            $resp   = $e->hasResponse() ? (string)$e->getResponse()->getBody() : '';
            throw new \RuntimeException("Fallo red (status={$status}): {$e->getMessage()} {$resp}");
        }
    }
    private static function procesarRespuesta($res, string $tipo): array
    {
        $status = $res->getStatusCode();
        $body = (string)$res->getBody();
        $data = json_decode($body, true) ?: [];

        Log::info("QPSE respuesta {$tipo}", [
            'http_status' => $status,
            'respuesta' => $data
        ]);

        if ($status >= 400) {
            $mensajeError = $data['message'] ?? $data['mensaje'] ?? $body;

            // Si es error 0161, la API espera ZIP pero sabemos que no funciona
            if (str_contains($mensajeError, '0161') || str_contains($mensajeError, 'ZIP')) {
                return [
                    'success' => false,
                    'error' => 'La API reporta inconsistencia con ZIP, pero el ZIP no funciona',
                    'mensaje' => $mensajeError,
                    'raw' => $data
                ];
            }

            return [
                'success' => false,
                'http_status' => $status,
                'error' => "HTTP {$status}",
                'mensaje' => $mensajeError,
                'raw' => $data
            ];
        }

        return [
            'success' => ($data['success'] ?? false) === true || ($data['estado'] ?? null) === 200,
            'estado' => $data['estado'] ?? null,
            'mensaje' => $data['mensaje'] ?? ($data['message'] ?? null),
            'codigo_hash' => $data['codigo_hash'] ?? null,
            'external_id' => $data['external_id'] ?? null,
            'xml_cdr' => $data['xml_cdr'] ?? ($data['cdr'] ?? null),
            'ticket' => $data['ticket'] ?? null,
            'raw' => $data,
        ];
    }
    public static function EnviarASunatPri(string $baseUrl, string $tokenAcceso, string $xmlFirmadoB64, string $nombreArchivo, bool $insecure = false): array
    {
        $tokenAcceso = trim($tokenAcceso ?? '');
        if (stripos($tokenAcceso, 'Bearer ') === 0) {
            $tokenAcceso = trim(substr($tokenAcceso, 7));
        }
        if ($tokenAcceso === '') {
            throw new \RuntimeException('token_acceso vacío para envío a SUNAT.');
        }

        if (!$xmlFirmadoB64) {
            throw new \RuntimeException('No hay XML firmado para enviar a SUNAT.');
        }

        $nombreSinExtension = pathinfo($nombreArchivo, PATHINFO_FILENAME);
        $payload = [
            'nombre_xml_firmado' => $nombreSinExtension,
            'contenido_xml_firmado' => $xmlFirmadoB64,
        ];

        $client = new Client([
            'base_uri' => rtrim($baseUrl, '/'),
            'timeout'  => 180,
            'connect_timeout' => 30,
            'verify'   => !$insecure,
        ]);

        $res = $client->post('/api/cpe/enviar', [
            'headers' => [
                'Authorization' => 'Bearer '.$tokenAcceso,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ],
            'json' => $payload,
        ]);

        $statusCode = $res->getStatusCode();
        $body       = (string) $res->getBody();
        $data       = json_decode($body, true);

        if ($statusCode >= 400) {
            throw new \RuntimeException("Error al enviar a SUNAT: {$statusCode} {$body}");
        }

        $okByEstado  = isset($data['estado']) && (int)$data['estado'] === 200;
        $okBySuccess = isset($data['success']) && $data['success'] === true;

        if (!($okByEstado || $okBySuccess)) {
            $msg = $data['mensaje'] ?? $data['message'] ?? 'Respuesta no exitosa de SUNAT';
            throw new \RuntimeException("Envío a SUNAT rechazado: {$msg}");
        }

        return [
            'estado'          => $data['estado'] ?? null,
            'success'         => $data['success'] ?? null,
            'mensaje'         => $data['mensaje'] ?? ($data['message'] ?? null),
            'codigo_hash'     => $data['codigo_hash'] ?? null,
            'external_id'     => $data['external_id'] ?? null,
            'numero_ticket'   => $data['numero_ticket'] ?? null,
            'fecha_recepcion' => $data['fecha_recepcion'] ?? null,
            'sunat_response'  => $data['sunat_response'] ?? null,
            'raw'             => $data,
        ];
    }

    /**
     * Firma un XML de Guía de Remisión vía el servidor QPSE.
     * Igual que FirmarXMLPRI pero usa tipo_integracion: 2 (GRE).
     */
    public static function FirmarXMLGuia(string $baseUrl, string $tokenAcceso, string $rutaXml, string $nombreArchivo, bool $insecure = false): array
    {
        if (!file_exists($rutaXml)) {
            throw new \RuntimeException("No existe el XML de guía en: {$rutaXml}");
        }

        $tokenAcceso = trim($tokenAcceso ?? '');
        if (stripos($tokenAcceso, 'Bearer ') === 0) {
            $tokenAcceso = trim(substr($tokenAcceso, 7));
        }
        if ($tokenAcceso === '') {
            throw new \RuntimeException('token_acceso vacío.');
        }

        $xmlBase64 = base64_encode(file_get_contents($rutaXml));
        $payload = [
            'tipo_integracion'  => 2,   // 2 = GRE (Guía de Remisión Electrónica)
            'nombre_archivo'    => $nombreArchivo,
            'contenido_archivo' => $xmlBase64,
        ];

        $client = new Client([
            'base_uri' => rtrim($baseUrl, '/'),
            'timeout'  => 60,
            'verify'   => !$insecure,
        ]);

        try {
            $res = $client->post('/api/cpe/generar', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $tokenAcceso,
                    'Accept'        => 'application/json',
                ],
                'json' => $payload,
            ]);
        } catch (RequestException $e) {
            $status = $e->getResponse() ? $e->getResponse()->getStatusCode() : 0;
            $body   = $e->getResponse() ? (string)$e->getResponse()->getBody() : $e->getMessage();
            throw new \RuntimeException("Error HTTP al firmar XML de guía (QPSE): {$status} {$body}");
        }

        $statusCode = $res->getStatusCode();
        $body       = (string)$res->getBody();
        $data       = json_decode($body, true);

        if ($statusCode >= 400) {
            throw new \RuntimeException("Error al firmar XML de guía (QPSE): {$statusCode} {$body}");
        }

        $okByEstado  = isset($data['estado']) && (int)$data['estado'] === 200;
        $okBySuccess = isset($data['success']) && $data['success'] === true;

        if (!($okByEstado || $okBySuccess)) {
            $msg = $data['mensaje'] ?? $data['message'] ?? 'Respuesta no exitosa';
            throw new \RuntimeException("Firmado de guía no aceptado: {$msg} | body={$body}");
        }

        $xmlFirmadoB64 = $data['xml'] ?? $data['contenido_xml_firmado'] ?? null;
        if (!$xmlFirmadoB64) {
            throw new \RuntimeException('La respuesta no contiene el campo "xml" firmado para la guía.');
        }

        return [
            'estado'      => $data['estado']      ?? null,
            'success'     => $data['success']     ?? null,
            'xml'         => $xmlFirmadoB64,
            'codigo_hash' => $data['codigo_hash'] ?? null,
            'mensaje'     => $data['mensaje']     ?? ($data['message'] ?? null),
            'external_id' => $data['external_id'] ?? null,
            'raw'         => $data,
        ];
    }
}
