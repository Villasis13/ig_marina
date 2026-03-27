<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use BaconQrCode\Encoder\QrCode;
use BaconQrCode\Renderer\Image\Png;
use Illuminate\Support\Facades\File;
use Luecano\NumeroALetras\NumeroALetras;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

require ('phpqrcode/qrlib.php');
class General extends Model
{
    private $ventas;
    public function __construct()
    {
        parent::__construct();
        $this->ventas =  new Ventas();
    }

    use HasFactory;
    public  function convertir_webp($imagen , $ruta){
        $fi = $imagen;
        $lugardestino = $ruta;
        $filename = time(). "-" . $fi->getClientOriginalName();
        // Convierte la imagen a formato WebP
        $webpFilename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
        $webpFilePath = $lugardestino . $webpFilename;
        $img = Image::make($fi)->encode('webp', 80);
        $img->save($webpFilePath);
        $ruta_foto = $webpFilePath;
        return $ruta_foto;

    }

    public   function guardar_documento($doc,$ruta){
            $documento =$doc;
            $destinationPath = $ruta;
            $nombreConExtension = $documento->getClientOriginalName();
            // Obtén el nombre del archivo sin la extensión
            $nombreArchivo = pathinfo($nombreConExtension, PATHINFO_FILENAME);
            $extension = $documento->getClientOriginalExtension();
            $nombreDocumento = $nombreArchivo.'-'.date('YmdHis').'.'.$extension; // Puedes generar un nombre único
            // Mueve el archivo a la ruta especificada
            $documento->move($destinationPath, $nombreDocumento);
            $rutaDocumento = $destinationPath . $nombreDocumento; // Ruta del documento
            return $rutaDocumento;
    }


    public  function generar_qr($id){
        // consulta para el contenido del codigo qr
        $venta = $this->ventas->listar_venta_x_id($id);
        $cliente = DB::table('clientes')->join('tipo_documento','clientes.id_tipo_documento','=','tipo_documento.id_tipo_documento')->where('clientes.id_clientes','=',$venta->id_clientes)->first();
        $empresa = DB::table('empresa')->where('id_empresa','=',1)->first();
        //  Nombre y contenido del qr
        $nombre_qr = $empresa->empresa_ruc. '-' .$venta->venta_tipo. '-' .$venta->venta_serie. '-' .$venta->venta_correlativo;
        $contenido_qr = $empresa->empresa_ruc.'|'.$venta->venta_tipo.'|'.$venta->venta_serie.'|'.$venta->venta_correlativo. '|'.
        $venta->venta_totaligv.'|'.$venta->venta_total.'|'.date('Y-m-d', strtotime($venta->venta_fecha)).'|'.
        $cliente->tipodocumento_codigo.'|'.$cliente->cliente_numero;

        $ruta = 'ApiFacturacion/imagenqr/';
        $ruta_qr = $ruta.$nombre_qr.'.png';
        if (!file_exists($ruta_qr)){
            \QRcode::png($contenido_qr, $ruta_qr, 'H - mejor', '3');
        }
        return $ruta_qr;

    }

    public static function imprimir_ticketera($venta,$venta_detalle,$empresa,$nombre_impresora){
        if($venta->venta_tipo == "03"){
            $venta_tipo = "BOLETA DE VENTA ELECTRÓNICA";
        }elseif($venta->venta_tipo == "01"){
            $venta_tipo = "FACTURA DE VENTA ELECTRÓNICA";
        }elseif($venta->venta_tipo == "07"){
            $venta_tipo = "NOTA DE CRÉDITO ELECTRÓNICO";
            $motivo = DB::table('tipo_ncreditos')->where('codigo','=',$venta->venta_codigo_motivo_nota)->first();
        }elseif($venta->venta_tipo == "08"){
            $venta_tipo = "NOTA DE DÉBITO ELECTRÓNICO";
            $motivo = DB::table('tipo_ndebitos')->where('codigo','=',$venta->venta_codigo_motivo_nota)->first();
        }

        $iso_venta = DB::table('users')->join('persona','users.id_persona','=','persona.id_persona')->where('users.id_users','=',$venta->id_users)->first();
        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);
        $printer->initialize();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $logo_empresa = public_path($empresa->empresa_foto_ticket);

        try {
            $logo_e = EscposImage::load($logo_empresa, false);
            $printer->bitImage($logo_e);
        } catch (\Exception $q) {
        }
        $printer->text("$empresa->empresa_nombrecomercial" . "\n");
        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(1, 1);
        $printer->text("RUC Nº $empresa->empresa_ruc" . "\n");
        $printer->text("$empresa->empresa_domiciliofiscal" . "\n");
        $printer->text("$empresa->empresa_departamento-$empresa->empresa_provincia-$empresa->empresa_distrito" . "\n");
        if ($empresa->empresa_telefono1 != NULL) {
            $printer->text("Tel. $empresa->empresa_telefono1" . "\n");
        }
        if ($empresa->empresa_correo != NULL) {
            $printer->text("E-emails: $empresa->empresa_correo" . "\n");
        }
        $printer->setFont(Printer::FONT_B);
        $printer->setTextSize(2, 2);
        $printer->text("$venta_tipo" . "\n");
        $printer->text("$venta->venta_serie - $venta->venta_correlativo" . "\n\n");
        $printer->setFont(Printer::FONT_B);
        $printer->setTextSize(1, 1);
        $printer->text(date("Y-m-d H:i:s") . "\n");
        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(1, 1);
        $printer->text("------------------------------------------------" . "\n");
        $printer->text("DATOS DEL CLIENTE" . "\n");
//
        $nombre = $venta->id_tipo_documento == 4 ? $venta->cliente_razonsocial : $venta->cliente_nombre;
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("RAZÓN SOCIAL : ".$nombre."\n");
        $printer->text("Nro. Doc     : $venta->cliente_numero" . "\n");
        $printer->text("FECHA        : " . date('d-m-Y', strtotime($venta->venta_fecha)) . "\n");
        //                $printer->text("FECHA        : " .date('d-m-Y', strtotime($venta->venta_fecha)) . "\n");
        $printer->text("DIRECCIÓN    : $venta->cliente_direccion" . "\n");
//            $printer->text("Nro. Mesa    : $nombre_mesa - "."$sacar_serie->serie"."-"."$sumar_correlativo" . "\n");
        $printer->text("ATENDIDO POR : $iso_venta->persona_nombre"." "."$iso_venta->persona_apellido_paterno "."\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("------------------------------------------------" . "\n");
//        $total = 0;
//            if ($request->concepto_cobrar == true) {
//                $printer->setJustification(Printer::JUSTIFY_LEFT);
//                $printer->text($request->mostrar_concepto . "\n");
//                $printer->setJustification(Printer::JUSTIFY_CENTER);
//                $printer->text(1 . "      x      " . $request->precio_total_calculado . '      S/ ' . $request->precio_total_calculado . "\n");
//            } else {
//                foreach ($cobrar as $dp) {
//                    if($dp->valor_check == true){
//                        $total += $dp->comanda_detalle_cantidad * $dp->comanda_detalle_precio;
//                        $printer->setJustification(Printer::JUSTIFY_LEFT);
//                        $printer->text($dp->recetas_nombre . "\n");
//                        $printer->setJustification(Printer::JUSTIFY_CENTER);
//                        $printer->text($dp->comanda_detalle_cantidad . "      x      " . $dp->comanda_detalle_precio . '      S/ ' . $dp->comanda_detalle_total . "\n");
//                    }
//
//                }
//            }
        $total = 0;
        foreach ($venta_detalle as $dp) {
            $total += $dp->venta_detalle_cantidad * $dp->venta_detalle_precio_unitario;
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text($dp->venta_detalle_nombre_producto . "\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text($dp->venta_detalle_cantidad . "      x      " . $dp->venta_detalle_precio_unitario . '      S/ ' . $dp->venta_detalle_importe_total . "\n");
        }
        $printer->text("------------------------------------------------" . "\n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        if ($venta->venta_totalgratuita > 0) {
            $printer->text("              OP. GRAT: S/ " . $venta->venta_totalgratuita . "\n");
        }
        $printer->text("              OP. EXON: S/ " . $venta->venta_totalexonerada . "\n");
        if ($venta->venta_totalinafecta > 0) {
            $printer->text("              OP. INAF: S/ " . $venta->venta_totalinafecta . "\n");
        }
        $printer->text("              OP. GRAV: S/ " . $venta->venta_totalgravada . "\n");
        $printer->text("              IGV: S/ " . $venta->venta_totaligv . "\n");
        if ($venta->venta_icbper > 0) {
            $printer->text("              ICBPER: S/ " . $venta->venta_icbper . "\n");
        }

        $printer->text("              TOTAL: S/ " . $venta->venta_total . "\n");
        $printer->setFont(Printer::FONT_B);
        $printer->setTextSize(1, 1);
        $printer->text("              PAGÓ CON: S/ ". $venta->venta_pago_cliente ."\n");
        $printer->text("              Vuelto: S/ " . $venta->venta_vuelto . "\n");
        if($venta->venta_totaldescuento > 0){
            $printer->text("                       DESCUENTO(-): S/ ". $venta->venta_totaldescuento ."\n");
        }
        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(1, 1);
        $da = new NumeroALetras();
        $es = $da->toInvoice($venta->venta_total,'2','soles');
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text($es ."\n");
        $printer->text("------------------------------------------------" . "\n");
        $printer->setFont(Printer::FONT_B);
        $printer->setTextSize(1, 1);
        if($venta->venta_tipo == "07" || $venta->venta_tipo == "08"){
            if($venta->tipo_documento_modificar == "03"){
                $documento = "BOLETA";
            }else{
                $documento = "FACTURA";
            }
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("DOCUMENTO:              $documento" . "\n");
            $printer->text("SERIE MODIFICADA:       $venta->serie_modificar" . "\n");
            $printer->text("CORRELATIVO MODIFICADO: $venta->correlativo_modificar" . "\n");
            $printer->text("MOTIVO: $motivo->tipo_nota_descripcion" . "\n");
        }
//        try{
//            $logo = EscposImage::load($imagen, false);
//            $printer->bitImage($logo);
//        }catch(\Exception $e){/*No hacemos nada si hay error*/}
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setFont(Printer::FONT_C);
        $printer->setTextSize(1, 1);
        $printer->text("BIENES TRANSFERIDOS EN LA AMAZONIA PARA SER" . "\n");
        $printer->text("CONSUMIDOS EN LA MISMA" . "\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(1, 1);
        $printer->text("---------------------------------" . "\n");
        $printer->setFont(Printer::FONT_B);
        $printer->setTextSize(1, 1);
        $printer->text("Digitaliza tu negocio, sistemas a medida con " . "\n");
        $printer->text("Facturación Electrónica... Whatsapp Business +51925642418 " . "\n");
        $printer->text("bufeotec.com" . "\n");
        $printer->feed(2);
        $printer->cut();
        $printer->pulse();
        $printer->close();
//        return
    }
}
