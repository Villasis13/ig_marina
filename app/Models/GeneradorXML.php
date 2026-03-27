<?php

namespace App\Models;
require ('cantidad_en_letras.php');
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Luecano\NumeroALetras\NumeroALetras;

class GeneradorXML extends Model
{
    use HasFactory;
    public static function  CrearXMLFactura($nombrexml, $emisor, $cliente, $comprobante, $detalle)
    {

        $doc = new \DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';
        $cuotas = DB::table('ventas_cuotas')->where([['id_venta','=',$comprobante->id_venta],['venta_cuota_estado','=',1]])->get();
        $da = new NumeroALetras();
        $total_letras = $da->toInvoice($comprobante->venta_total,'2','soles');
        $tipo_documento_emisor = "6";
        if($cliente->id_tipo_documento== 4){
            $razon_social = $cliente->cliente_razonsocial;
        }else{
            $razon_social = $cliente->cliente_nombre;
        }
        $anho = date('Y');
        if($anho == "2021"){
            $icbper = "0.30";
        }elseif($anho == "2022"){
            $icbper = "0.40";
        }else{
            $icbper = "0.50";
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
      <Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
         <ext:UBLExtensions>
            <ext:UBLExtension>
               <ext:ExtensionContent />
            </ext:UBLExtension>
         </ext:UBLExtensions>
         <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
         <cbc:CustomizationID>2.0</cbc:CustomizationID>
         <cbc:ID>'.$comprobante->venta_serie.'-'.$comprobante->venta_correlativo.'</cbc:ID>
         <cbc:IssueDate>'.date('Y-m-d', strtotime($comprobante->venta_fecha)).'</cbc:IssueDate>
         <cbc:IssueTime>'.date('H:i:s', strtotime($comprobante->venta_fecha)).'</cbc:IssueTime>
         <cbc:DueDate>'.date('Y-m-d', strtotime($comprobante->venta_fecha)).'</cbc:DueDate>
         <cbc:InvoiceTypeCode listID="0101">'.$comprobante->venta_tipo.'</cbc:InvoiceTypeCode>
         <cbc:Note languageLocaleID="1000"><![CDATA['.$total_letras.']]></cbc:Note>
         <cbc:DocumentCurrencyCode>'.$comprobante->abrstandar.'</cbc:DocumentCurrencyCode>
         <cac:Signature>
            <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
            <cbc:Note><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Note>
            <cac:SignatoryParty>
               <cac:PartyIdentification>
                  <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_razon_social.']]></cbc:Name>
               </cac:PartyName>
            </cac:SignatoryParty>
            <cac:DigitalSignatureAttachment>
               <cac:ExternalReference>
                  <cbc:URI>#SIGN-EMPRESA</cbc:URI>
               </cac:ExternalReference>
            </cac:DigitalSignatureAttachment>
         </cac:Signature>
         <cac:AccountingSupplierParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="'.$tipo_documento_emisor.'">'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Name>
               </cac:PartyName>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$emisor->empresa_razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cbc:ID>'.$emisor->ubigeo_cod.'</cbc:ID>
                     <cbc:AddressTypeCode>0000</cbc:AddressTypeCode>
                     <cbc:CitySubdivisionName>NONE</cbc:CitySubdivisionName>
                     <cbc:CityName>'.$emisor->ubigeo_provincia.'</cbc:CityName>
                     <cbc:CountrySubentity>'.$emisor->ubigeo_departamento.'</cbc:CountrySubentity>
                     <cbc:District>'.$emisor->ubigeo_distrito.'</cbc:District>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$emisor->empresa_domiciliofiscal.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>'.$emisor->empresa_pais.'</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingSupplierParty>
         <cac:AccountingCustomerParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="'.$cliente->tipodocumento_codigo.'">'.$cliente->cliente_numero.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$cliente->cliente_direccion.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>PE</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingCustomerParty>';
        //tipo de pago
//        $xml.='<cac:PaymentTerms>
//                    <cbc:ID>FormaPago</cbc:ID>
//                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
//                   </cac:PaymentTerms>';

        if($comprobante->id_formas_pago == 1){
            $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';
        }else{
            $xml.='<cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Credito</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                     </cac:PaymentTerms>';
            $a = 1;

            foreach ($cuotas as $cu){
                $num = $a > 9 ? $a : '0'.$a;
                $xml.=
                    '<cac:PaymentTerms>
                            <cbc:ID>FormaPago</cbc:ID>
                            <cbc:PaymentMeansID>Cuota0'.$num.'</cbc:PaymentMeansID>
                            <cbc:Amount currencyID="PEN">'.$cu->venta_cuota_importe.'</cbc:Amount>
                            <cbc:PaymentDueDate>'.$cu->venta_cuota_fecha.'</cbc:PaymentDueDate>
                        </cac:PaymentTerms>';
                $a++;
            }

        }
        $impuesto = $comprobante->venta_totaligv + $comprobante->venta_icbper;
        $xml.='<cac:TaxTotal>
            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$impuesto.'</cbc:TaxAmount>
            <cac:TaxSubtotal>
               <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgravada.'</cbc:TaxableAmount>
               <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>
               <cac:TaxCategory>
                  <cac:TaxScheme>
                     <cbc:ID>1000</cbc:ID>
                     <cbc:Name>IGV</cbc:Name>
                     <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                  </cac:TaxScheme>
               </cac:TaxCategory>
            </cac:TaxSubtotal>';


        if($comprobante->venta_totalexonerada > 0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalexonerada.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9997</cbc:ID>
                        <cbc:Name>EXO</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }

        if($comprobante->venta_totalinafecta>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalinafecta.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID>
                        <cbc:Name>INA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalgratuita>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgratuita.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9996</cbc:ID>
                        <cbc:Name>GRA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_icbper>0){
            $xml.='<cac:TaxSubtotal>
                      <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_icbper.'</cbc:TaxAmount>
                      <cac:TaxCategory>
                         <cac:TaxScheme>
                            <cbc:ID>7152</cbc:ID>
                            <cbc:Name>ICBPER</cbc:Name>
                            <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                         </cac:TaxScheme>
                      </cac:TaxCategory>
                   </cac:TaxSubtotal>';
        }

        $total_antes_de_impuestos = $comprobante->venta_totalgravada+$comprobante->venta_totalexonerada+$comprobante->venta_totalinafecta;

        $xml.='</cac:TaxTotal>
         <cac:LegalMonetaryTotal>
            <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$total_antes_de_impuestos.'</cbc:LineExtensionAmount>
            <cbc:TaxInclusiveAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:TaxInclusiveAmount>
            <cbc:PayableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:PayableAmount>
         </cac:LegalMonetaryTotal>';
        $item = 1;
        foreach($detalle as $v){
            $xml.='<cac:InvoiceLine>
               <cbc:ID>'.$item.'</cbc:ID>
               <cbc:InvoicedQuantity unitCode="NIU">'.$v->venta_detalle_cantidad.'</cbc:InvoicedQuantity>
               <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:LineExtensionAmount>
               <cac:PricingReference>';
            if($v->codigo == "21"){
                $xml.= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_precio_unitario.'</cbc:PriceAmount>
                     <cbc:PriceTypeCode>02</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }else {
                $xml .= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="' . $comprobante->abrstandar . '">' . $v->venta_detalle_precio_unitario . '</cbc:PriceAmount>
                     <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }
            $total_impuesto_bolsa = 0;
            if($v->impuesto_bolsa ==     "1"){$total_impuesto_bolsa = number_format($v->venta_detalle_cantidad * $icbper, 2);}

            $impuesto_items = ($v->venta_detalle_total_igv) + ($total_impuesto_bolsa) * 1;
//            $nn = $v->venta_detalle_total_igv * $v->venta_detalle_cantidad;
            $xml.= '</cac:PricingReference>
               <cac:TaxTotal>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$impuesto_items.'</cbc:TaxAmount>
                  <cac:TaxSubtotal>
                     <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:TaxableAmount>
                     <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_total_igv.'</cbc:TaxAmount>
                     <cac:TaxCategory>
                        <cbc:Percent>'.$v->venta_detalle_porcentaje_igv.'</cbc:Percent>
                        <cbc:TaxExemptionReasonCode>'.$v->codigo.'</cbc:TaxExemptionReasonCode>
                        <cac:TaxScheme>
                           <cbc:ID>'.$v->codigo_afectacion.'</cbc:ID>
                           <cbc:Name>'.$v->nombre_afectacion.'</cbc:Name>
                           <cbc:TaxTypeCode>'.$v->tipo_afectacion.'</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                     </cac:TaxCategory>
                  </cac:TaxSubtotal>';

            if($v->impuesto_bolsa == "1"){

                $xml.= '<cac:TaxSubtotal>
                            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$total_impuesto_bolsa.'</cbc:TaxAmount>
                            <cbc:BaseUnitMeasure unitCode="NIU">'.$v->venta_detalle_cantidad.'</cbc:BaseUnitMeasure>
                        <cac:TaxCategory>
                        <cbc:PerUnitAmount currencyID="PEN">'.$icbper.'</cbc:PerUnitAmount>
                            <cac:TaxScheme>
                                <cbc:ID>7152</cbc:ID>
                                <cbc:Name>ICBPER</cbc:Name>
                                <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                        </cac:TaxCategory>
                        </cac:TaxSubtotal>';
            }

            $xml.=
                '</cac:TaxTotal>';

            $xml.= '<cac:Item>
                      <cbc:Description><![CDATA['.$v->venta_detalle_nombre_producto.']]></cbc:Description>
                      <cac:SellersItemIdentification>
                         <cbc:ID>'.$v->id_pro.'</cbc:ID>
                      </cac:SellersItemIdentification>
                   </cac:Item>';

            if($v->codigo == "21"){
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:PriceAmount>
               </cac:Price>
            </cac:InvoiceLine>';
            }else{
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_unitario.'</cbc:PriceAmount>
               </cac:Price>
            </cac:InvoiceLine>';
            }

            $item++;
        }

        $xml.="</Invoice>";

        $doc->loadXML($xml);
        $doc->save($nombrexml.'.XML');
    }
    public static function CrearXMLFacturaPri($nombrexml, $emisor, $cliente, $comprobante, $detalle)
    {
        $doc = new \DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';

        $cuotas = DB::table('ventas_cuotas')
            ->where([['id_venta', '=', $comprobante->id_venta], ['venta_cuota_estado', '=', 1]])
            ->get();

        $da = new NumeroALetras();
        $total_letras = $da->toInvoice($comprobante->venta_total, '2', 'soles');

        $tipo_documento_emisor = "6";
        if ($cliente->id_tipo_documento == 4) {
            $razon_social = $cliente->cliente_razonsocial;
        } else {
            $razon_social = $cliente->cliente_nombre;
        }

        // ICBPER por año
        $anho = date('Y');
        if ($anho == "2021") {
            $icbper = "0.30";
        } elseif ($anho == "2022") {
            $icbper = "0.40";
        } else {
            $icbper = "0.50";
        }

        // Helper 2 decimales
        $n2 = fn($x) => number_format((float)$x, 2, '.', '');

        // Totales formateados
        $gravada2   = $n2($comprobante->venta_totalgravada);
        $exonerada2 = $n2($comprobante->venta_totalexonerada);
        $inafecta2  = $n2($comprobante->venta_totalinafecta);
        $gratuita2  = $n2($comprobante->venta_totalgratuita);
        $icbper2    = $n2($comprobante->venta_icbper);
        $igv2       = $n2($comprobante->venta_totaligv);
        $total2     = $n2($comprobante->venta_total);
        $antesImp2  = $n2($comprobante->venta_totalgravada + $comprobante->venta_totalexonerada + $comprobante->venta_totalinafecta);
        $impuesto2  = $n2($comprobante->venta_totaligv + $comprobante->venta_icbper);

        // === XML ===
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '  <Invoice' . "\n";
        $xml .= '    xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2"' . "\n";
        $xml .= '    xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"' . "\n";
        $xml .= '    xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"' . "\n";
        $xml .= '    xmlns:ds="http://www.w3.org/2000/09/xmldsig#"' . "\n";
        $xml .= '    xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"' . "\n";
        $xml .= '    xmlns:sac="urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1">' . "\n";

        // UBLExtensions con sac:AdditionalInformation
        $xml .= '    <ext:UBLExtensions>' . "\n";
        $xml .= '      <ext:UBLExtension>' . "\n";
        $xml .= '        <ext:ExtensionContent>' . "\n";
        $xml .= '          <sac:AdditionalInformation>' . "\n";
        $xml .= '            <sac:AdditionalMonetaryTotal>' . "\n";
        $xml .= '              <cbc:ID>1001</cbc:ID>' . "\n"; // Operaciones gravadas
        $xml .= '              <cbc:PayableAmount currencyID="' . $comprobante->abrstandar . '">' . $gravada2 . '</cbc:PayableAmount>' . "\n";
        $xml .= '            </sac:AdditionalMonetaryTotal>' . "\n";
        $xml .= '            <sac:AdditionalProperty>' . "\n";
        $xml .= '              <cbc:ID>1000</cbc:ID>' . "\n"; // Monto en letras
        $xml .= '              <cbc:Value><![CDATA[' . $total_letras . ']]></cbc:Value>' . "\n";
        $xml .= '            </sac:AdditionalProperty>' . "\n";
        $xml .= '          </sac:AdditionalInformation>' . "\n";
        $xml .= '        </ext:ExtensionContent>' . "\n";
        $xml .= '      </ext:UBLExtension>' . "\n";
        $xml .= '    </ext:UBLExtensions>' . "\n";

        // Cabecera básica
        $xml .= '    <cbc:UBLVersionID>2.1</cbc:UBLVersionID>' . "\n";
        $xml .= '    <cbc:CustomizationID>2.0</cbc:CustomizationID>' . "\n";
        $xml .= '    <cbc:ProfileID>0101</cbc:ProfileID>' . "\n";
        $xml .= '    <cbc:ID>' . $comprobante->venta_serie . '-' . $comprobante->venta_correlativo . '</cbc:ID>' . "\n";
        $xml .= '    <cbc:IssueDate>' . date('Y-m-d', strtotime($comprobante->venta_fecha)) . '</cbc:IssueDate>' . "\n";
        $xml .= '    <cbc:IssueTime>' . date('H:i:s', strtotime($comprobante->venta_fecha)) . '</cbc:IssueTime>' . "\n";
        $xml .= '    <cbc:DueDate>' . date('Y-m-d', strtotime($comprobante->venta_fecha)) . '</cbc:DueDate>' . "\n";
        $xml .= '    <cbc:InvoiceTypeCode listID="0101">' . $comprobante->venta_tipo . '</cbc:InvoiceTypeCode>' . "\n";
        $xml .= '    <cbc:Note languageLocaleID="1000"><![CDATA[' . $total_letras . ']]></cbc:Note>' . "\n";
        $xml .= '    <cbc:DocumentCurrencyCode>' . $comprobante->abrstandar . '</cbc:DocumentCurrencyCode>' . "\n";

        // Firma (referencia)
        $xml .= '    <cac:Signature>' . "\n";
        $xml .= '      <cbc:ID>' . $emisor->empresa_ruc . '</cbc:ID>' . "\n";
        $xml .= '      <cbc:Note><![CDATA[' . $emisor->empresa_nombrecomercial . ']]></cbc:Note>' . "\n";
        $xml .= '      <cac:SignatoryParty>' . "\n";
        $xml .= '        <cac:PartyIdentification><cbc:ID>' . $emisor->empresa_ruc . '</cbc:ID></cac:PartyIdentification>' . "\n";
        $xml .= '        <cac:PartyName><cbc:Name><![CDATA[' . $emisor->empresa_razon_social . ']]></cbc:Name></cac:PartyName>' . "\n";
        $xml .= '      </cac:SignatoryParty>' . "\n";
        $xml .= '      <cac:DigitalSignatureAttachment>' . "\n";
        $xml .= '        <cac:ExternalReference><cbc:URI>#SignatureSP</cbc:URI></cac:ExternalReference>' . "\n";
        $xml .= '      </cac:DigitalSignatureAttachment>' . "\n";
        $xml .= '    </cac:Signature>' . "\n";

        // Emisor
        $xml .= '    <cac:AccountingSupplierParty>' . "\n";
        $xml .= '      <cac:Party>' . "\n";
        $xml .= '        <cac:PartyIdentification><cbc:ID schemeID="' . $tipo_documento_emisor . '">' . $emisor->empresa_ruc . '</cbc:ID></cac:PartyIdentification>' . "\n";
        $xml .= '        <cac:PartyName><cbc:Name><![CDATA[' . $emisor->empresa_nombrecomercial . ']]></cbc:Name></cac:PartyName>' . "\n";
        $xml .= '        <cac:PartyLegalEntity>' . "\n";
        $xml .= '          <cbc:RegistrationName><![CDATA[' . $emisor->empresa_razon_social . ']]></cbc:RegistrationName>' . "\n";
        $xml .= '          <cac:RegistrationAddress>' . "\n";
        $xml .= '            <cbc:ID>' . $emisor->ubigeo_cod . '</cbc:ID>' . "\n";
        $xml .= '            <cbc:AddressTypeCode>0000</cbc:AddressTypeCode>' . "\n";
        $xml .= '            <cbc:CitySubdivisionName>NONE</cbc:CitySubdivisionName>' . "\n";
        $xml .= '            <cbc:CityName>' . $emisor->ubigeo_provincia . '</cbc:CityName>' . "\n";
        $xml .= '            <cbc:CountrySubentity>' . $emisor->ubigeo_departamento . '</cbc:CountrySubentity>' . "\n";
        $xml .= '            <cbc:District>' . $emisor->ubigeo_distrito . '</cbc:District>' . "\n";
        $xml .= '            <cac:AddressLine><cbc:Line><![CDATA[' . $emisor->empresa_domiciliofiscal . ']]></cbc:Line></cac:AddressLine>' . "\n";
        $xml .= '            <cac:Country><cbc:IdentificationCode>' . $emisor->empresa_pais . '</cbc:IdentificationCode></cac:Country>' . "\n";
        $xml .= '          </cac:RegistrationAddress>' . "\n";
        $xml .= '        </cac:PartyLegalEntity>' . "\n";
        $xml .= '      </cac:Party>' . "\n";
        $xml .= '    </cac:AccountingSupplierParty>' . "\n";

        // Cliente
        $xml .= '    <cac:AccountingCustomerParty>' . "\n";
        $xml .= '      <cac:Party>' . "\n";
        $xml .= '        <cac:PartyIdentification><cbc:ID schemeID="' . $cliente->tipodocumento_codigo . '">' . $cliente->cliente_numero . '</cbc:ID></cac:PartyIdentification>' . "\n";
        $xml .= '        <cac:PartyLegalEntity>' . "\n";
        $xml .= '          <cbc:RegistrationName><![CDATA[' . $razon_social . ']]></cbc:RegistrationName>' . "\n";
        $xml .= '          <cac:RegistrationAddress>' . "\n";
        $xml .= '            <cac:AddressLine><cbc:Line><![CDATA[' . $cliente->cliente_direccion . ']]></cbc:Line></cac:AddressLine>' . "\n";
        $xml .= '            <cac:Country><cbc:IdentificationCode>PE</cbc:IdentificationCode></cac:Country>' . "\n";
        $xml .= '          </cac:RegistrationAddress>' . "\n";
        $xml .= '        </cac:PartyLegalEntity>' . "\n";
        $xml .= '      </cac:Party>' . "\n";
        $xml .= '    </cac:AccountingCustomerParty>' . "\n";

        // Forma de pago
        if ($comprobante->id_formas_pago == 1) {
            // Contado
            $xml .= '    <cac:PaymentTerms>' . "\n";
            $xml .= '      <cbc:ID>FormaPago</cbc:ID>' . "\n";
            $xml .= '      <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>' . "\n";
            $xml .= '    </cac:PaymentTerms>' . "\n";
        } else {
            // Crédito + cuotas
            $xml .= '    <cac:PaymentTerms>' . "\n";
            $xml .= '      <cbc:ID>FormaPago</cbc:ID>' . "\n";
            $xml .= '      <cbc:PaymentMeansID>Credito</cbc:PaymentMeansID>' . "\n";
            $xml .= '      <cbc:Amount currencyID="PEN">' . $total2 . '</cbc:Amount>' . "\n";
            $xml .= '    </cac:PaymentTerms>' . "\n";

            $a = 1;
            foreach ($cuotas as $cu) {
                $num = str_pad($a, 2, '0', STR_PAD_LEFT);
                $xml .= '    <cac:PaymentTerms>' . "\n";
                $xml .= '      <cbc:ID>FormaPago</cbc:ID>' . "\n";
                $xml .= '      <cbc:PaymentMeansID>Cuota' . $num . '</cbc:PaymentMeansID>' . "\n";
                $xml .= '      <cbc:Amount currencyID="PEN">' . $n2($cu->venta_cuota_importe) . '</cbc:Amount>' . "\n";
                $xml .= '      <cbc:PaymentDueDate>' . $cu->venta_cuota_fecha . '</cbc:PaymentDueDate>' . "\n";
                $xml .= '    </cac:PaymentTerms>' . "\n";
                $a++;
            }
        }

        // Impuestos cabecera
        $xml .= '    <cac:TaxTotal>' . "\n";
        $xml .= '      <cbc:TaxAmount currencyID="' . $comprobante->abrstandar . '">' . $impuesto2 . '</cbc:TaxAmount>' . "\n";
        // IGV
        $xml .= '      <cac:TaxSubtotal>' . "\n";
        $xml .= '        <cbc:TaxableAmount currencyID="' . $comprobante->abrstandar . '">' . $gravada2 . '</cbc:TaxableAmount>' . "\n";
        $xml .= '        <cbc:TaxAmount currencyID="' . $comprobante->abrstandar . '">' . $igv2 . '</cbc:TaxAmount>' . "\n";
        $xml .= '        <cac:TaxCategory><cac:TaxScheme><cbc:ID>1000</cbc:ID><cbc:Name>IGV</cbc:Name><cbc:TaxTypeCode>VAT</cbc:TaxTypeCode></cac:TaxScheme></cac:TaxCategory>' . "\n";
        $xml .= '      </cac:TaxSubtotal>' . "\n";

        // Exonerada
        if ((float)$comprobante->venta_totalexonerada > 0) {
            $xml .= '      <cac:TaxSubtotal>' . "\n";
            $xml .= '        <cbc:TaxableAmount currencyID="' . $comprobante->abrstandar . '">' . $exonerada2 . '</cbc:TaxableAmount>' . "\n";
            $xml .= '        <cbc:TaxAmount currencyID="' . $comprobante->abrstandar . '">0.00</cbc:TaxAmount>' . "\n";
            $xml .= '        <cac:TaxCategory>' .
                '<cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>' .
                '<cac:TaxScheme><cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9997</cbc:ID><cbc:Name>EXO</cbc:Name><cbc:TaxTypeCode>VAT</cbc:TaxTypeCode></cac:TaxScheme>' .
                '</cac:TaxCategory>' . "\n";
            $xml .= '      </cac:TaxSubtotal>' . "\n";
        }

        // Inafecta
        if ((float)$comprobante->venta_totalinafecta > 0) {
            $xml .= '      <cac:TaxSubtotal>' . "\n";
            $xml .= '        <cbc:TaxableAmount currencyID="' . $comprobante->abrstandar . '">' . $inafecta2 . '</cbc:TaxableAmount>' . "\n";
            $xml .= '        <cbc:TaxAmount currencyID="' . $comprobante->abrstandar . '">0.00</cbc:TaxAmount>' . "\n";
            $xml .= '        <cac:TaxCategory>' .
                '<cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>' .
                '<cac:TaxScheme><cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID><cbc:Name>INA</cbc:Name><cbc:TaxTypeCode>FRE</cbc:TaxTypeCode></cac:TaxScheme>' .
                '</cac:TaxCategory>' . "\n";
            $xml .= '      </cac:TaxSubtotal>' . "\n";
        }

        // Gratuita
        if ((float)$comprobante->venta_totalgratuita > 0) {
            $xml .= '      <cac:TaxSubtotal>' . "\n";
            $xml .= '        <cbc:TaxableAmount currencyID="' . $comprobante->abrstandar . '">' . $gratuita2 . '</cbc:TaxableAmount>' . "\n";
            $xml .= '        <cbc:TaxAmount currencyID="' . $comprobante->abrstandar . '">0.00</cbc:TaxAmount>' . "\n";
            $xml .= '        <cac:TaxCategory>' .
                '<cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>' .
                '<cac:TaxScheme><cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9996</cbc:ID><cbc:Name>GRA</cbc:Name><cbc:TaxTypeCode>FRE</cbc:TaxTypeCode></cac:TaxScheme>' .
                '</cac:TaxCategory>' . "\n";
            $xml .= '      </cac:TaxSubtotal>' . "\n";
        }

        // ICBPER cabecera
        if ((float)$comprobante->venta_icbper > 0) {
            $xml .= '      <cac:TaxSubtotal>' . "\n";
            $xml .= '        <cbc:TaxAmount currencyID="' . $comprobante->abrstandar . '">' . $icbper2 . '</cbc:TaxAmount>' . "\n";
            $xml .= '        <cac:TaxCategory><cac:TaxScheme><cbc:ID>7152</cbc:ID><cbc:Name>ICBPER</cbc:Name><cbc:TaxTypeCode>OTH</cbc:TaxTypeCode></cac:TaxScheme></cac:TaxCategory>' . "\n";
            $xml .= '      </cac:TaxSubtotal>' . "\n";
        }

        $xml .= '    </cac:TaxTotal>' . "\n";

        // Totales monetarios
        $xml .= '    <cac:LegalMonetaryTotal>' . "\n";
        $xml .= '      <cbc:LineExtensionAmount currencyID="' . $comprobante->abrstandar . '">' . $antesImp2 . '</cbc:LineExtensionAmount>' . "\n";
        $xml .= '      <cbc:TaxInclusiveAmount currencyID="' . $comprobante->abrstandar . '">' . $total2 . '</cbc:TaxInclusiveAmount>' . "\n";
        $xml .= '      <cbc:PayableAmount currencyID="' . $comprobante->abrstandar . '">' . $total2 . '</cbc:PayableAmount>' . "\n";
        $xml .= '    </cac:LegalMonetaryTotal>' . "\n";

        // Líneas
        $item = 1;
        foreach ($detalle as $v) {
            $precioConIgv2   = $n2($v->venta_detalle_precio_unitario); // precio con IGV (referencial)
            $valorTotal2     = $n2($v->venta_detalle_valor_total);     // sin IGV (total línea)
            $igvLinea2       = $n2($v->venta_detalle_total_igv);
            $valorUnitario2  = $n2($v->venta_detalle_valor_unitario);  // sin IGV
            $cantidad2       = $n2($v->venta_detalle_cantidad);
            $totalImpBolsa2  = ($v->impuesto_bolsa == "1") ? $n2($v->venta_detalle_cantidad * $icbper) : '0.00';
            $impuestoItems2  = $n2($v->venta_detalle_total_igv + (float)$totalImpBolsa2);
            $porcIgv2        = $n2($v->venta_detalle_porcentaje_igv);

            $xml .= '    <cac:InvoiceLine>' . "\n";
            $xml .= '      <cbc:ID>' . $item . '</cbc:ID>' . "\n";
            $xml .= '      <cbc:InvoicedQuantity unitCode="'.$v->medida_codigo_unidad.'">' . $cantidad2 . '</cbc:InvoicedQuantity>' . "\n";
            $xml .= '      <cbc:LineExtensionAmount currencyID="' . $comprobante->abrstandar . '">' . $valorTotal2 . '</cbc:LineExtensionAmount>' . "\n";
            $xml .= '      <cac:PricingReference>' . "\n";
            if ($v->codigo == "21") {
                // Gratuito
                $xml .= '        <cac:AlternativeConditionPrice>' . "\n";
                $xml .= '          <cbc:PriceAmount currencyID="' . $comprobante->abrstandar . '">' . $precioConIgv2 . '</cbc:PriceAmount>' . "\n";
                $xml .= '          <cbc:PriceTypeCode>02</cbc:PriceTypeCode>' . "\n";
                $xml .= '        </cac:AlternativeConditionPrice>' . "\n";
            } else {
                // Gravado/otros
                $xml .= '        <cac:AlternativeConditionPrice>' . "\n";
                $xml .= '          <cbc:PriceAmount currencyID="' . $comprobante->abrstandar . '">' . $precioConIgv2 . '</cbc:PriceAmount>' . "\n";
                $xml .= '          <cbc:PriceTypeCode>01</cbc:PriceTypeCode>' . "\n";
                $xml .= '        </cac:AlternativeConditionPrice>' . "\n";
            }
            $xml .= '      </cac:PricingReference>' . "\n";

            // Impuestos por línea
            $xml .= '      <cac:TaxTotal>' . "\n";
            $xml .= '        <cbc:TaxAmount currencyID="' . $comprobante->abrstandar . '">' . $impuestoItems2 . '</cbc:TaxAmount>' . "\n";
            $xml .= '        <cac:TaxSubtotal>' . "\n";
            $xml .= '          <cbc:TaxableAmount currencyID="' . $comprobante->abrstandar . '">' . $valorTotal2 . '</cbc:TaxableAmount>' . "\n";
            $xml .= '          <cbc:TaxAmount currencyID="' . $comprobante->abrstandar . '">' . $igvLinea2 . '</cbc:TaxAmount>' . "\n";
            $xml .= '          <cac:TaxCategory>' . "\n";
            $xml .= '            <cbc:Percent>' . $porcIgv2 . '</cbc:Percent>' . "\n";
            $xml .= '            <cbc:TaxExemptionReasonCode>' . $v->codigo . '</cbc:TaxExemptionReasonCode>' . "\n";
            $xml .= '            <cac:TaxScheme>' . "\n";
            $xml .= '              <cbc:ID>' . $v->codigo_afectacion . '</cbc:ID>' . "\n";
            $xml .= '              <cbc:Name>' . $v->nombre_afectacion . '</cbc:Name>' . "\n";
            $xml .= '              <cbc:TaxTypeCode>' . $v->tipo_afectacion . '</cbc:TaxTypeCode>' . "\n";
            $xml .= '            </cac:TaxScheme>' . "\n";
            $xml .= '          </cac:TaxCategory>' . "\n";
            $xml .= '        </cac:TaxSubtotal>' . "\n";

            // ICBPER por línea (si aplica)
            if ($v->impuesto_bolsa == "1") {
                $xml .= '        <cac:TaxSubtotal>' . "\n";
                $xml .= '          <cbc:TaxAmount currencyID="' . $comprobante->abrstandar . '">' . $totalImpBolsa2 . '</cbc:TaxAmount>' . "\n";
                $xml .= '          <cbc:BaseUnitMeasure unitCode="NIU">' . $cantidad2 . '</cbc:BaseUnitMeasure>' . "\n";
                $xml .= '          <cac:TaxCategory>' . "\n";
                $xml .= '            <cbc:PerUnitAmount currencyID="PEN">' . $n2($icbper) . '</cbc:PerUnitAmount>' . "\n";
                $xml .= '            <cac:TaxScheme><cbc:ID>7152</cbc:ID><cbc:Name>ICBPER</cbc:Name><cbc:TaxTypeCode>OTH</cbc:TaxTypeCode></cac:TaxScheme>' . "\n";
                $xml .= '          </cac:TaxCategory>' . "\n";
                $xml .= '        </cac:TaxSubtotal>' . "\n";
            }

            $xml .= '      </cac:TaxTotal>' . "\n";

            // Ítem
            $xml .= '      <cac:Item>' . "\n";
            $xml .= '        <cbc:Description><![CDATA[' . $v->venta_detalle_nombre_producto . ']]></cbc:Description>' . "\n";
            $xml .= '        <cac:SellersItemIdentification><cbc:ID>' . $v->id_pro . '</cbc:ID></cac:SellersItemIdentification>' . "\n";
            $xml .= '      </cac:Item>' . "\n";

            // Precio unitario (sin IGV)
            if ($v->codigo == "21") {
                $xml .= '      <cac:Price><cbc:PriceAmount currencyID="' . $comprobante->abrstandar . '">0.00</cbc:PriceAmount></cac:Price>' . "\n";
            } else {
                $xml .= '      <cac:Price><cbc:PriceAmount currencyID="' . $comprobante->abrstandar . '">' . $valorUnitario2 . '</cbc:PriceAmount></cac:Price>' . "\n";
            }

            $xml .= '    </cac:InvoiceLine>' . "\n";
            $item++;
        }

        $xml .= '  </Invoice>';

        // Guardar .xml (minúsculas)
        $doc->loadXML($xml);
        $doc->save($nombrexml . '.XML');
    }
    public static function CrearXMLNotaCredito($nombrexml, $emisor, $cliente, $comprobante, $detalle, $descripcion_nota)
    {
        $doc = new \DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';
//        $total_letras = CantidadEnLetra($comprobante->venta_total);
//        $total_letras  = General::numeroALetras($comprobante->venta_total);
        $da = new NumeroALetras();
        $total_letras = $da->toInvoice($comprobante->venta_total,'2','soles');

        if($cliente->id_tipo_documento == 4){
            $razon_social = $cliente->cliente_razonsocial;
        }else{
            $razon_social = $cliente->cliente_nombre;
        }
        $anho = date('Y');
        if($anho == "2021"){
            $icbper = "0.30";
        }elseif($anho == "2022"){
            $icbper = "0.40";
        }else{
            $icbper = "0.50";
        }


        $xml = '<?xml version="1.0" encoding="UTF-8"?>
      <CreditNote xmlns="urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
         <ext:UBLExtensions>
            <ext:UBLExtension>
               <ext:ExtensionContent />
            </ext:UBLExtension>
         </ext:UBLExtensions>
         <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
         <cbc:CustomizationID>2.0</cbc:CustomizationID>
         <cbc:ID>'.$comprobante->venta_serie.'-'.$comprobante->venta_correlativo.'</cbc:ID>
         <cbc:IssueDate>'.date('Y-m-d', strtotime($comprobante->venta_fecha)).'</cbc:IssueDate>
         <cbc:IssueTime>'.date('H:i:s', strtotime($comprobante->venta_fecha)).'</cbc:IssueTime>
         <cbc:Note languageLocaleID="1000"><![CDATA['.$total_letras.']]></cbc:Note>
         <cbc:DocumentCurrencyCode>'.$comprobante->abrstandar.'</cbc:DocumentCurrencyCode>
         <cac:DiscrepancyResponse>
            <cbc:ReferenceID>'.$comprobante->serie_modificar.'-'.$comprobante->correlativo_modificar.'</cbc:ReferenceID>
            <cbc:ResponseCode>'.$comprobante->venta_codigo_motivo_nota.'</cbc:ResponseCode>
            <cbc:Description>'.$descripcion_nota->tipo_nota_descripcion.'</cbc:Description>
         </cac:DiscrepancyResponse>
         <cac:BillingReference>
            <cac:InvoiceDocumentReference>
               <cbc:ID>'.$comprobante->serie_modificar.'-'.$comprobante->correlativo_modificar.'</cbc:ID>
               <cbc:DocumentTypeCode>'.$comprobante->tipo_documento_modificar.'</cbc:DocumentTypeCode>
            </cac:InvoiceDocumentReference>
         </cac:BillingReference>
         <cac:Signature>
            <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
            <cbc:Note><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Note>
            <cac:SignatoryParty>
               <cac:PartyIdentification>
                  <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_razon_social.']]></cbc:Name>
               </cac:PartyName>
            </cac:SignatoryParty>
            <cac:DigitalSignatureAttachment>
               <cac:ExternalReference>
                  <cbc:URI>#SIGN-EMPRESA</cbc:URI>
               </cac:ExternalReference>
            </cac:DigitalSignatureAttachment>
         </cac:Signature>
         <cac:AccountingSupplierParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="6">'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Name>
               </cac:PartyName>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$emisor->empresa_razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cbc:ID>'.$emisor->ubigeo_cod.'</cbc:ID>
                     <cbc:AddressTypeCode>0000</cbc:AddressTypeCode>
                     <cbc:CitySubdivisionName>NONE</cbc:CitySubdivisionName>
                      <cbc:CityName>'.$emisor->ubigeo_provincia.'</cbc:CityName>
                     <cbc:CountrySubentity>'.$emisor->ubigeo_departamento.'</cbc:CountrySubentity>
                     <cbc:District>'.$emisor->ubigeo_distrito.'</cbc:District>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$emisor->empresa_domiciliofiscal.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>'.$emisor->empresa_pais.'</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingSupplierParty>
         <cac:AccountingCustomerParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="'.$cliente->tipodocumento_codigo.'">'.$cliente->cliente_numero.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$cliente->cliente_direccion.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>PE</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingCustomerParty>';
        if($comprobante->venta_codigo_motivo_nota == 13){
            $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';
        }


        /*if($comprobante->id_tipo_pago != "5"){
            $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';
        }else{
            $xml.='<cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Credito</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                     </cac:PaymentTerms>

                     <cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Cuota001</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                        <cbc:PaymentDueDate>'.date('Y-m-d').'</cbc:PaymentDueDate>
                    </cac:PaymentTerms>';
        }*/
        $impuesto = $comprobante->venta_totaligv + $comprobante->venta_icbper;
        $xml.='<cac:TaxTotal>
            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$impuesto.'</cbc:TaxAmount>
            <cac:TaxSubtotal>
               <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgravada.'</cbc:TaxableAmount>
               <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>
               <cac:TaxCategory>
                  <cac:TaxScheme>
                     <cbc:ID>1000</cbc:ID>
                     <cbc:Name>IGV</cbc:Name>
                     <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                  </cac:TaxScheme>
               </cac:TaxCategory>
            </cac:TaxSubtotal>';

        if($comprobante->venta_totalexonerada>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalexonerada.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9997</cbc:ID>
                        <cbc:Name>EXO</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalinafecta>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalinafecta.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID>
                        <cbc:Name>INA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalgratuita>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgratuita.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9996</cbc:ID>
                        <cbc:Name>GRA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_icbper>0){
            $xml.='<cac:TaxSubtotal>
                      <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_icbper.'</cbc:TaxAmount>
                      <cac:TaxCategory>
                         <cac:TaxScheme>
                            <cbc:ID>7152</cbc:ID>
                            <cbc:Name>ICBPER</cbc:Name>
                            <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                         </cac:TaxScheme>
                      </cac:TaxCategory>
                   </cac:TaxSubtotal>';
        }

        $total_antes_de_impuestos = $comprobante->venta_totalgravada+$comprobante->venta_totalexonerada+$comprobante->venta_totalinafecta;

        $xml.='</cac:TaxTotal>
         <cac:LegalMonetaryTotal>
            <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$total_antes_de_impuestos.'</cbc:LineExtensionAmount>
            <cbc:TaxInclusiveAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:TaxInclusiveAmount>
            <cbc:PayableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:PayableAmount>
         </cac:LegalMonetaryTotal>';
        $item = 1;

        foreach($detalle as $v){
            $xml.='<cac:CreditNoteLine>
               <cbc:ID>'.$item.'</cbc:ID>
               <cbc:CreditedQuantity unitCode="NIU">'.$v->venta_detalle_cantidad.'</cbc:CreditedQuantity>
               <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:LineExtensionAmount>
               <cac:PricingReference>';
            if($v->codigo == "21"){
                $xml.= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_precio_unitario.'</cbc:PriceAmount>
                     <cbc:PriceTypeCode>02</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }else {
                $xml .= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="' . $comprobante->abrstandar . '">' . $v->venta_detalle_precio_unitario . '</cbc:PriceAmount>
                     <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }
            $total_impuesto_bolsa = 0;
            if($v->impuesto_bolsa == "1"){$total_impuesto_bolsa = number_format($v->venta_detalle_cantidad * $icbper, 2);}

            $impuesto_items = ($v->venta_detalle_total_igv) + ($total_impuesto_bolsa) * 1;
            $xml.= '</cac:PricingReference>
               <cac:TaxTotal>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$impuesto_items.'</cbc:TaxAmount>
                  <cac:TaxSubtotal>
                     <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:TaxableAmount>
                     <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_total_igv.'</cbc:TaxAmount>
                     <cac:TaxCategory>
                        <cbc:Percent>'.$v->venta_detalle_porcentaje_igv.'</cbc:Percent>
                        <cbc:TaxExemptionReasonCode>'.$v->codigo.'</cbc:TaxExemptionReasonCode>
                        <cac:TaxScheme>
                           <cbc:ID>'.$v->codigo_afectacion.'</cbc:ID>
                           <cbc:Name>'.$v->nombre_afectacion.'</cbc:Name>
                           <cbc:TaxTypeCode>'.$v->tipo_afectacion.'</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                     </cac:TaxCategory>
                  </cac:TaxSubtotal>';

            if($v->impuesto_bolsa == "1"){
                $xml.= '<cac:TaxSubtotal>
                            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$total_impuesto_bolsa.'</cbc:TaxAmount>
                            <cbc:BaseUnitMeasure unitCode="NIU">'.$v->venta_detalle_cantidad.'</cbc:BaseUnitMeasure>
                        <cac:TaxCategory>
                        <cbc:PerUnitAmount currencyID="PEN">'.$icbper.'</cbc:PerUnitAmount>
                            <cac:TaxScheme>
                                <cbc:ID>7152</cbc:ID>
                                <cbc:Name>ICBPER</cbc:Name>
                                <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                        </cac:TaxCategory>
                        </cac:TaxSubtotal>';
            }

            $xml.=
                '</cac:TaxTotal>';

            $xml.= '<cac:Item>
                      <cbc:Description><![CDATA['.$v->venta_detalle_nombre_producto.']]></cbc:Description>
                      <cac:SellersItemIdentification>
                         <cbc:ID>'.$v->id_pro.'</cbc:ID>
                      </cac:SellersItemIdentification>
                   </cac:Item>';

            if($v->codigo == "21"){
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:PriceAmount>
               </cac:Price>
            </cac:CreditNoteLine>';
            }else{
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_unitario.'</cbc:PriceAmount>
               </cac:Price>
            </cac:CreditNoteLine>';
            }

            $item++;
        }
        $xml.='</CreditNote>';

        $doc->loadXML($xml);
        $doc->save($nombrexml.'.XML');
    }
    public static function CrearXMLNotaCreditoPRI($nombrexml, $emisor, $cliente, $comprobante, $detalle, $descripcion_nota)
    {
        $doc = new \DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';
//        $total_letras = CantidadEnLetra($comprobante->venta_total);
//        $total_letras  = General::numeroALetras($comprobante->venta_total);
        $da = new NumeroALetras();
        $total_letras = $da->toInvoice($comprobante->venta_total,'2','soles');

        if($cliente->id_tipo_documento == 4){
            $razon_social = $cliente->cliente_razonsocial;
        }else{
            $razon_social = $cliente->cliente_nombre;
        }
        $anho = date('Y');
        if($anho == "2021"){
            $icbper = "0.30";
        }elseif($anho == "2022"){
            $icbper = "0.40";
        }else{
            $icbper = "0.50";
        }


        $xml = '<?xml version="1.0" encoding="UTF-8"?>
      <CreditNote xmlns="urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
         <ext:UBLExtensions>
            <ext:UBLExtension>
               <ext:ExtensionContent />
            </ext:UBLExtension>
         </ext:UBLExtensions>
         <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
         <cbc:CustomizationID>2.0</cbc:CustomizationID>
         <cbc:ID>'.$comprobante->venta_serie.'-'.$comprobante->venta_correlativo.'</cbc:ID>
         <cbc:IssueDate>'.date('Y-m-d', strtotime($comprobante->venta_fecha)).'</cbc:IssueDate>
         <cbc:IssueTime>'.date('H:i:s', strtotime($comprobante->venta_fecha)).'</cbc:IssueTime>
         <cbc:Note languageLocaleID="1000"><![CDATA['.$total_letras.']]></cbc:Note>
         <cbc:DocumentCurrencyCode>'.$comprobante->abrstandar.'</cbc:DocumentCurrencyCode>
         <cac:DiscrepancyResponse>
            <cbc:ReferenceID>'.$comprobante->serie_modificar.'-'.$comprobante->correlativo_modificar.'</cbc:ReferenceID>
            <cbc:ResponseCode>'.$comprobante->venta_codigo_motivo_nota.'</cbc:ResponseCode>
            <cbc:Description>'.$descripcion_nota->tipo_nota_descripcion.'</cbc:Description>
         </cac:DiscrepancyResponse>
         <cac:BillingReference>
            <cac:InvoiceDocumentReference>
               <cbc:ID>'.$comprobante->serie_modificar.'-'.$comprobante->correlativo_modificar.'</cbc:ID>
               <cbc:DocumentTypeCode>'.$comprobante->tipo_documento_modificar.'</cbc:DocumentTypeCode>
            </cac:InvoiceDocumentReference>
         </cac:BillingReference>
         <cac:Signature>
            <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
            <cbc:Note><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Note>
            <cac:SignatoryParty>
               <cac:PartyIdentification>
                  <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_razon_social.']]></cbc:Name>
               </cac:PartyName>
            </cac:SignatoryParty>
            <cac:DigitalSignatureAttachment>
               <cac:ExternalReference>
                  <cbc:URI>#SIGN-EMPRESA</cbc:URI>
               </cac:ExternalReference>
            </cac:DigitalSignatureAttachment>
         </cac:Signature>
         <cac:AccountingSupplierParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="6">'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Name>
               </cac:PartyName>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$emisor->empresa_razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cbc:ID>'.$emisor->ubigeo_cod.'</cbc:ID>
                     <cbc:AddressTypeCode>0000</cbc:AddressTypeCode>
                     <cbc:CitySubdivisionName>NONE</cbc:CitySubdivisionName>
                      <cbc:CityName>'.$emisor->ubigeo_provincia.'</cbc:CityName>
                     <cbc:CountrySubentity>'.$emisor->ubigeo_departamento.'</cbc:CountrySubentity>
                     <cbc:District>'.$emisor->ubigeo_distrito.'</cbc:District>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$emisor->empresa_domiciliofiscal.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>'.$emisor->empresa_pais.'</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingSupplierParty>
         <cac:AccountingCustomerParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="'.$cliente->tipodocumento_codigo.'">'.$cliente->cliente_numero.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$cliente->cliente_direccion.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>PE</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingCustomerParty>';
        if($comprobante->venta_codigo_motivo_nota == 13){
            $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';
        }


        /*if($comprobante->id_tipo_pago != "5"){
            $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';
        }else{
            $xml.='<cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Credito</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                     </cac:PaymentTerms>

                     <cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Cuota001</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                        <cbc:PaymentDueDate>'.date('Y-m-d').'</cbc:PaymentDueDate>
                    </cac:PaymentTerms>';
        }*/
        $impuesto = $comprobante->venta_totaligv + $comprobante->venta_icbper;
        $xml.='<cac:TaxTotal>
            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$impuesto.'</cbc:TaxAmount>
            <cac:TaxSubtotal>
               <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgravada.'</cbc:TaxableAmount>
               <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>
               <cac:TaxCategory>
                  <cac:TaxScheme>
                     <cbc:ID>1000</cbc:ID>
                     <cbc:Name>IGV</cbc:Name>
                     <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                  </cac:TaxScheme>
               </cac:TaxCategory>
            </cac:TaxSubtotal>';

        if($comprobante->venta_totalexonerada>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalexonerada.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9997</cbc:ID>
                        <cbc:Name>EXO</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalinafecta>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalinafecta.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID>
                        <cbc:Name>INA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalgratuita>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgratuita.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9996</cbc:ID>
                        <cbc:Name>GRA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_icbper>0){
            $xml.='<cac:TaxSubtotal>
                      <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_icbper.'</cbc:TaxAmount>
                      <cac:TaxCategory>
                         <cac:TaxScheme>
                            <cbc:ID>7152</cbc:ID>
                            <cbc:Name>ICBPER</cbc:Name>
                            <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                         </cac:TaxScheme>
                      </cac:TaxCategory>
                   </cac:TaxSubtotal>';
        }

        $total_antes_de_impuestos = $comprobante->venta_totalgravada+$comprobante->venta_totalexonerada+$comprobante->venta_totalinafecta;

        $xml.='</cac:TaxTotal>
         <cac:LegalMonetaryTotal>
            <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$total_antes_de_impuestos.'</cbc:LineExtensionAmount>
            <cbc:TaxInclusiveAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:TaxInclusiveAmount>
            <cbc:PayableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:PayableAmount>
         </cac:LegalMonetaryTotal>';
        $item = 1;

        foreach($detalle as $v){
            $xml.='<cac:CreditNoteLine>
               <cbc:ID>'.$item.'</cbc:ID>
               <cbc:CreditedQuantity unitCode="'.$v->medida_codigo_unidad.'">'.$v->venta_detalle_cantidad.'</cbc:CreditedQuantity>
               <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:LineExtensionAmount>
               <cac:PricingReference>';
            if($v->codigo == "21"){
                $xml.= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_precio_unitario.'</cbc:PriceAmount>
                     <cbc:PriceTypeCode>02</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }else {
                $xml .= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="' . $comprobante->abrstandar . '">' . $v->venta_detalle_precio_unitario . '</cbc:PriceAmount>
                     <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }
            $total_impuesto_bolsa = 0;
            if($v->impuesto_bolsa == "1"){$total_impuesto_bolsa = number_format($v->venta_detalle_cantidad * $icbper, 2);}

            $impuesto_items = ($v->venta_detalle_total_igv) + ($total_impuesto_bolsa) * 1;
            $xml.= '</cac:PricingReference>
               <cac:TaxTotal>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$impuesto_items.'</cbc:TaxAmount>
                  <cac:TaxSubtotal>
                     <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:TaxableAmount>
                     <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_total_igv.'</cbc:TaxAmount>
                     <cac:TaxCategory>
                        <cbc:Percent>'.$v->venta_detalle_porcentaje_igv.'</cbc:Percent>
                        <cbc:TaxExemptionReasonCode>'.$v->codigo.'</cbc:TaxExemptionReasonCode>
                        <cac:TaxScheme>
                           <cbc:ID>'.$v->codigo_afectacion.'</cbc:ID>
                           <cbc:Name>'.$v->nombre_afectacion.'</cbc:Name>
                           <cbc:TaxTypeCode>'.$v->tipo_afectacion.'</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                     </cac:TaxCategory>
                  </cac:TaxSubtotal>';

            if($v->impuesto_bolsa == "1"){
                $xml.= '<cac:TaxSubtotal>
                            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$total_impuesto_bolsa.'</cbc:TaxAmount>
                            <cbc:BaseUnitMeasure unitCode="NIU">'.$v->venta_detalle_cantidad.'</cbc:BaseUnitMeasure>
                        <cac:TaxCategory>
                        <cbc:PerUnitAmount currencyID="PEN">'.$icbper.'</cbc:PerUnitAmount>
                            <cac:TaxScheme>
                                <cbc:ID>7152</cbc:ID>
                                <cbc:Name>ICBPER</cbc:Name>
                                <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                        </cac:TaxCategory>
                        </cac:TaxSubtotal>';
            }

            $xml.=
                '</cac:TaxTotal>';

            $xml.= '<cac:Item>
                      <cbc:Description><![CDATA['.$v->venta_detalle_nombre_producto.']]></cbc:Description>
                      <cac:SellersItemIdentification>
                         <cbc:ID>'.$v->id_pro.'</cbc:ID>
                      </cac:SellersItemIdentification>
                   </cac:Item>';

            if($v->codigo == "21"){
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:PriceAmount>
               </cac:Price>
            </cac:CreditNoteLine>';
            }else{
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_unitario.'</cbc:PriceAmount>
               </cac:Price>
            </cac:CreditNoteLine>';
            }

            $item++;
        }
        $xml.='</CreditNote>';

        $doc->loadXML($xml);
        $doc->save($nombrexml.'.XML');
    }

    public static function CrearXMLNotaDebito($nombrexml, $emisor, $cliente, $comprobante, $detalle, $descripcion_nota)
    {

        $doc = new \DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';

//        $total_letras = CantidadEnLetra($comprobante->venta_total);
//        $total_letras  = General::numeroALetras($comprobante->venta_total);
        $da = new NumeroALetras();
        $total_letras = $da->toInvoice($comprobante->venta_total,'2','soles');
        if($cliente->id_tipo_documento == 4){
            $razon_social = $cliente->cliente_razonsocial;
        }else{
            $razon_social = $cliente->cliente_nombre;
        }
        $anho = date('Y');
        if($anho == "2021"){
            $icbper = "0.30";
        }elseif($anho == "2022"){
            $icbper = "0.40";
        }else{
            $icbper = "0.50";
        }


        $xml = '<?xml version="1.0" encoding="UTF-8"?>
      <DebitNote xmlns="urn:oasis:names:specification:ubl:schema:xsd:DebitNote-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
         <ext:UBLExtensions>
            <ext:UBLExtension>
               <ext:ExtensionContent />
            </ext:UBLExtension>
         </ext:UBLExtensions>
         <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
         <cbc:CustomizationID>2.0</cbc:CustomizationID>
         <cbc:ID>'.$comprobante->venta_serie.'-'.$comprobante->venta_correlativo.'</cbc:ID>
         <cbc:IssueDate>'.date('Y-m-d', strtotime($comprobante->venta_fecha)).'</cbc:IssueDate>
         <cbc:IssueTime>'.date('H:i:s', strtotime($comprobante->venta_fecha)).'</cbc:IssueTime>
         <cbc:Note languageLocaleID="1000"><![CDATA['.$total_letras.']]></cbc:Note>
         <cbc:DocumentCurrencyCode>'.$comprobante->abrstandar.'</cbc:DocumentCurrencyCode>
         <cac:DiscrepancyResponse>
            <cbc:ReferenceID>'.$comprobante->serie_modificar.'-'.$comprobante->correlativo_modificar.'</cbc:ReferenceID>
            <cbc:ResponseCode>'.$comprobante->venta_codigo_motivo_nota.'</cbc:ResponseCode>
            <cbc:Description>'.$descripcion_nota->tipo_nota_descripcion.'</cbc:Description>
         </cac:DiscrepancyResponse>
         <cac:BillingReference>
            <cac:InvoiceDocumentReference>
               <cbc:ID>'.$comprobante->serie_modificar.'-'.$comprobante->correlativo_modificar.'</cbc:ID>
               <cbc:DocumentTypeCode>'.$comprobante->tipo_documento_modificar.'</cbc:DocumentTypeCode>
            </cac:InvoiceDocumentReference>
         </cac:BillingReference>
         <cac:Signature>
            <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
            <cbc:Note><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Note>
            <cac:SignatoryParty>
               <cac:PartyIdentification>
                  <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_razon_social.']]></cbc:Name>
               </cac:PartyName>
            </cac:SignatoryParty>
            <cac:DigitalSignatureAttachment>
               <cac:ExternalReference>
                  <cbc:URI>#SIGN-EMPRESA</cbc:URI>
               </cac:ExternalReference>
            </cac:DigitalSignatureAttachment>
         </cac:Signature>
         <cac:AccountingSupplierParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="6">'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Name>
               </cac:PartyName>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$emisor->empresa_razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cbc:ID>'.$emisor->ubigeo_cod.'</cbc:ID>
                     <cbc:AddressTypeCode>0000</cbc:AddressTypeCode>
                     <cbc:CitySubdivisionName>NONE</cbc:CitySubdivisionName>
                     <cbc:CityName>'.$emisor->ubigeo_provincia.'</cbc:CityName>
                     <cbc:CountrySubentity>'.$emisor->ubigeo_departamento.'</cbc:CountrySubentity>
                     <cbc:District>'.$emisor->ubigeo_distrito.'</cbc:District>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$emisor->empresa_domiciliofiscal.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>'.$emisor->empresa_pais.'</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingSupplierParty>
         <cac:AccountingCustomerParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="'.$cliente->tipodocumento_codigo.'">'.$cliente->cliente_numero.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$cliente->cliente_direccion.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>PE</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingCustomerParty>';

        $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';

        /*if($comprobante->id_tipo_pago != "5"){
            $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';
        }else{
            $xml.='<cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Credito</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                     </cac:PaymentTerms>

                     <cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Cuota001</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                        <cbc:PaymentDueDate>'.date('Y-m-d').'</cbc:PaymentDueDate>
                    </cac:PaymentTerms>';
        }*/
        $impuesto = $comprobante->venta_totaligv + $comprobante->venta_icbper;

        $xml.='<cac:TaxTotal>
                <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$impuesto.'</cbc:TaxAmount>';
        $xml .= '<cac:TaxSubtotal>
                   <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgravada.'</cbc:TaxableAmount>
                   <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>
                   <cac:TaxCategory>
                      <cac:TaxScheme>
                         <cbc:ID>1000</cbc:ID>
                         <cbc:Name>IGV</cbc:Name>
                         <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                      </cac:TaxScheme>
                   </cac:TaxCategory>
                </cac:TaxSubtotal>';
        /*if($comprobante->venta_totalgravada>0){
            $xml .= '<cac:TaxSubtotal>
                   <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgravada.'</cbc:TaxableAmount>
                   <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>
                   <cac:TaxCategory>
                      <cac:TaxScheme>
                         <cbc:ID>1000</cbc:ID>
                         <cbc:Name>IGV</cbc:Name>
                         <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                      </cac:TaxScheme>
                   </cac:TaxCategory>
                </cac:TaxSubtotal>';
        }*/

        if($comprobante->venta_totalexonerada>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalexonerada.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9997</cbc:ID>
                        <cbc:Name>EXO</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalinafecta>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalinafecta.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID>
                        <cbc:Name>INA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalgratuita>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgratuita.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9996</cbc:ID>
                        <cbc:Name>GRA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_icbper>0){
            $xml.='<cac:TaxSubtotal>
                      <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_icbper.'</cbc:TaxAmount>
                      <cac:TaxCategory>
                         <cac:TaxScheme>
                            <cbc:ID>7152</cbc:ID>
                            <cbc:Name>ICBPER</cbc:Name>
                            <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                         </cac:TaxScheme>
                      </cac:TaxCategory>
                   </cac:TaxSubtotal>';
        }

        $total_antes_de_impuestos = $comprobante->venta_totalgravada+$comprobante->venta_totalexonerada+$comprobante->venta_totalinafecta;

        $xml.='</cac:TaxTotal>
         <cac:RequestedMonetaryTotal>

            <cbc:PayableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:PayableAmount>
         </cac:RequestedMonetaryTotal>';
        $item = 1;

        foreach($detalle as $v){
            $xml.='<cac:DebitNoteLine>
               <cbc:ID>'.$item.'</cbc:ID>
               <cbc:DebitedQuantity unitCode="'.$v->medida_codigo_unidad.'">'.$v->venta_detalle_cantidad.'</cbc:DebitedQuantity>
               <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:LineExtensionAmount>
               <cac:PricingReference>';
            if($v->codigo == "21"){
                $xml.= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_precio_unitario.'</cbc:PriceAmount>
                     <cbc:PriceTypeCode>02</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }else {
                $xml .= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="' . $comprobante->abrstandar . '">' . $v->venta_detalle_precio_unitario . '</cbc:PriceAmount>
                     <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }
            $total_impuesto_bolsa = 0;
            if($v->impuesto_bolsa == "1"){$total_impuesto_bolsa = number_format($v->venta_detalle_cantidad * $icbper, 2);}

            $impuesto_items = ($v->venta_detalle_total_igv) + ($total_impuesto_bolsa) * 1;
            $xml.= '</cac:PricingReference>
               <cac:TaxTotal>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$impuesto_items.'</cbc:TaxAmount>
                  <cac:TaxSubtotal>
                     <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:TaxableAmount>
                     <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_total_igv.'</cbc:TaxAmount>
                     <cac:TaxCategory>';
            if($v->codigo == "10"){
                $xml.= '<cbc:Percent>'.$v->venta_detalle_porcentaje_igv.'</cbc:Percent>';
            }else{
                $xml.= '<cbc:Percent>0.00</cbc:Percent>';
            }
            $xml.= '<cbc:TaxExemptionReasonCode>'.$v->codigo.'</cbc:TaxExemptionReasonCode>
                        <cac:TaxScheme>
                           <cbc:ID>'.$v->codigo_afectacion.'</cbc:ID>
                           <cbc:Name>'.$v->nombre_afectacion.'</cbc:Name>
                           <cbc:TaxTypeCode>'.$v->tipo_afectacion.'</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                     </cac:TaxCategory>
                  </cac:TaxSubtotal>';

            if($v->impuesto_bolsa == "1"){

                $xml.= '<cac:TaxSubtotal>
                            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$total_impuesto_bolsa.'</cbc:TaxAmount>
                            <cbc:BaseUnitMeasure unitCode="NIU">'.$v->venta_detalle_cantidad.'</cbc:BaseUnitMeasure>
                        <cac:TaxCategory>
                        <cbc:PerUnitAmount currencyID="PEN">'.$icbper.'</cbc:PerUnitAmount>
                            <cac:TaxScheme>
                                <cbc:ID>7152</cbc:ID>
                                <cbc:Name>ICBPER</cbc:Name>
                                <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                        </cac:TaxCategory>
                        </cac:TaxSubtotal>';
            }
//            if($v->impuesto_bolsa == "1"){
//                $total_impuesto_bolsa = number_format($v->venta_detalle_cantidad * $icbper, 2);
//                $xml.= '<cac:TaxSubtotal>
//                            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$total_impuesto_bolsa.'</cbc:TaxAmount>
//                            <cbc:BaseUnitMeasure unitCode="'.$v->medida_codigo_unidad.'">'.$v->venta_detalle_cantidad.'</cbc:BaseUnitMeasure>
//                        <cbc:PerUnitAmount currencyID="PEN">'.$icbper.'</cbc:PerUnitAmount>
//                        <cac:TaxCategory>
//                            <cac:TaxScheme>
//                                <cbc:ID>7152</cbc:ID>
//                                <cbc:Name>ICBPER</cbc:Name>
//                                <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
//                            </cac:TaxScheme>
//                        </cac:TaxCategory>
//                        </cac:TaxSubtotal>';
//            }

            $xml.=
                '</cac:TaxTotal>';

            $xml.= '<cac:Item>
                      <cbc:Description><![CDATA['.$v->venta_detalle_nombre_producto.']]></cbc:Description>
                      <cac:SellersItemIdentification>
                         <cbc:ID>'.$v->id_pro.'</cbc:ID>
                      </cac:SellersItemIdentification>
                   </cac:Item>';

            if($v->codigo == "21"){
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:PriceAmount>
               </cac:Price>
            </cac:CreditNoteLine>';
            }else{
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_unitario.'</cbc:PriceAmount>
               </cac:Price>
            </cac:DebitNoteLine>';
            }

            $item++;
        }
        $xml.='</DebitNote>';

        $doc->loadXML($xml);
        $doc->save($nombrexml.'.XML');
    }
    public static function CrearXMLNotaDebitoPRI($nombrexml, $emisor, $cliente, $comprobante, $detalle, $descripcion_nota)
    {

        $doc = new \DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';

//        $total_letras = CantidadEnLetra($comprobante->venta_total);
//        $total_letras  = General::numeroALetras($comprobante->venta_total);
        $da = new NumeroALetras();
        $total_letras = $da->toInvoice($comprobante->venta_total,'2','soles');
        if($cliente->id_tipo_documento == 4){
            $razon_social = $cliente->cliente_razonsocial;
        }else{
            $razon_social = $cliente->cliente_nombre;
        }
        $anho = date('Y');
        if($anho == "2021"){
            $icbper = "0.30";
        }elseif($anho == "2022"){
            $icbper = "0.40";
        }else{
            $icbper = "0.50";
        }


        $xml = '<?xml version="1.0" encoding="UTF-8"?>
      <DebitNote xmlns="urn:oasis:names:specification:ubl:schema:xsd:DebitNote-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
         <ext:UBLExtensions>
            <ext:UBLExtension>
               <ext:ExtensionContent />
            </ext:UBLExtension>
         </ext:UBLExtensions>
         <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
         <cbc:CustomizationID>2.0</cbc:CustomizationID>
         <cbc:ID>'.$comprobante->venta_serie.'-'.$comprobante->venta_correlativo.'</cbc:ID>
         <cbc:IssueDate>'.date('Y-m-d', strtotime($comprobante->venta_fecha)).'</cbc:IssueDate>
         <cbc:IssueTime>'.date('H:i:s', strtotime($comprobante->venta_fecha)).'</cbc:IssueTime>
         <cbc:Note languageLocaleID="1000"><![CDATA['.$total_letras.']]></cbc:Note>
         <cbc:DocumentCurrencyCode>'.$comprobante->abrstandar.'</cbc:DocumentCurrencyCode>
         <cac:DiscrepancyResponse>
            <cbc:ReferenceID>'.$comprobante->serie_modificar.'-'.$comprobante->correlativo_modificar.'</cbc:ReferenceID>
            <cbc:ResponseCode>'.$comprobante->venta_codigo_motivo_nota.'</cbc:ResponseCode>
            <cbc:Description>'.$descripcion_nota->tipo_nota_descripcion.'</cbc:Description>
         </cac:DiscrepancyResponse>
         <cac:BillingReference>
            <cac:InvoiceDocumentReference>
               <cbc:ID>'.$comprobante->serie_modificar.'-'.$comprobante->correlativo_modificar.'</cbc:ID>
               <cbc:DocumentTypeCode>'.$comprobante->tipo_documento_modificar.'</cbc:DocumentTypeCode>
            </cac:InvoiceDocumentReference>
         </cac:BillingReference>
         <cac:Signature>
            <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
            <cbc:Note><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Note>
            <cac:SignatoryParty>
               <cac:PartyIdentification>
                  <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_razon_social.']]></cbc:Name>
               </cac:PartyName>
            </cac:SignatoryParty>
            <cac:DigitalSignatureAttachment>
               <cac:ExternalReference>
                  <cbc:URI>#SIGN-EMPRESA</cbc:URI>
               </cac:ExternalReference>
            </cac:DigitalSignatureAttachment>
         </cac:Signature>
         <cac:AccountingSupplierParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="6">'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Name>
               </cac:PartyName>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$emisor->empresa_razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cbc:ID>'.$emisor->ubigeo_cod.'</cbc:ID>
                     <cbc:AddressTypeCode>0000</cbc:AddressTypeCode>
                     <cbc:CitySubdivisionName>NONE</cbc:CitySubdivisionName>
                     <cbc:CityName>'.$emisor->ubigeo_provincia.'</cbc:CityName>
                     <cbc:CountrySubentity>'.$emisor->ubigeo_departamento.'</cbc:CountrySubentity>
                     <cbc:District>'.$emisor->ubigeo_distrito.'</cbc:District>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$emisor->empresa_domiciliofiscal.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>'.$emisor->empresa_pais.'</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingSupplierParty>
         <cac:AccountingCustomerParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="'.$cliente->tipodocumento_codigo.'">'.$cliente->cliente_numero.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$cliente->cliente_direccion.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>PE</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingCustomerParty>';

        $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';

        /*if($comprobante->id_tipo_pago != "5"){
            $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';
        }else{
            $xml.='<cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Credito</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                     </cac:PaymentTerms>

                     <cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Cuota001</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                        <cbc:PaymentDueDate>'.date('Y-m-d').'</cbc:PaymentDueDate>
                    </cac:PaymentTerms>';
        }*/
        $impuesto = $comprobante->venta_totaligv + $comprobante->venta_icbper;

        $xml.='<cac:TaxTotal>
                <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$impuesto.'</cbc:TaxAmount>';
        $xml .= '<cac:TaxSubtotal>
                   <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgravada.'</cbc:TaxableAmount>
                   <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>
                   <cac:TaxCategory>
                      <cac:TaxScheme>
                         <cbc:ID>1000</cbc:ID>
                         <cbc:Name>IGV</cbc:Name>
                         <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                      </cac:TaxScheme>
                   </cac:TaxCategory>
                </cac:TaxSubtotal>';
        /*if($comprobante->venta_totalgravada>0){
            $xml .= '<cac:TaxSubtotal>
                   <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgravada.'</cbc:TaxableAmount>
                   <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>
                   <cac:TaxCategory>
                      <cac:TaxScheme>
                         <cbc:ID>1000</cbc:ID>
                         <cbc:Name>IGV</cbc:Name>
                         <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                      </cac:TaxScheme>
                   </cac:TaxCategory>
                </cac:TaxSubtotal>';
        }*/

        if($comprobante->venta_totalexonerada>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalexonerada.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9997</cbc:ID>
                        <cbc:Name>EXO</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalinafecta>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalinafecta.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID>
                        <cbc:Name>INA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalgratuita>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgratuita.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9996</cbc:ID>
                        <cbc:Name>GRA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_icbper>0){
            $xml.='<cac:TaxSubtotal>
                      <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_icbper.'</cbc:TaxAmount>
                      <cac:TaxCategory>
                         <cac:TaxScheme>
                            <cbc:ID>7152</cbc:ID>
                            <cbc:Name>ICBPER</cbc:Name>
                            <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                         </cac:TaxScheme>
                      </cac:TaxCategory>
                   </cac:TaxSubtotal>';
        }

        $total_antes_de_impuestos = $comprobante->venta_totalgravada+$comprobante->venta_totalexonerada+$comprobante->venta_totalinafecta;

        $xml.='</cac:TaxTotal>
         <cac:RequestedMonetaryTotal>

            <cbc:PayableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:PayableAmount>
         </cac:RequestedMonetaryTotal>';
        $item = 1;

        foreach($detalle as $v){
            $xml.='<cac:DebitNoteLine>
               <cbc:ID>'.$item.'</cbc:ID>
               <cbc:DebitedQuantity unitCode="'.$v->medida_codigo_unidad.'">'.$v->venta_detalle_cantidad.'</cbc:DebitedQuantity>
               <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:LineExtensionAmount>
               <cac:PricingReference>';
            if($v->codigo == "21"){
                $xml.= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_precio_unitario.'</cbc:PriceAmount>
                     <cbc:PriceTypeCode>02</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }else {
                $xml .= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="' . $comprobante->abrstandar . '">' . $v->venta_detalle_precio_unitario . '</cbc:PriceAmount>
                     <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }
            $total_impuesto_bolsa = 0;
            if($v->impuesto_bolsa == "1"){$total_impuesto_bolsa = number_format($v->venta_detalle_cantidad * $icbper, 2);}

            $impuesto_items = ($v->venta_detalle_total_igv) + ($total_impuesto_bolsa) * 1;
            $xml.= '</cac:PricingReference>
               <cac:TaxTotal>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$impuesto_items.'</cbc:TaxAmount>
                  <cac:TaxSubtotal>
                     <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:TaxableAmount>
                     <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_total_igv.'</cbc:TaxAmount>
                     <cac:TaxCategory>';
            if($v->codigo == "10"){
                $xml.= '<cbc:Percent>'.$v->venta_detalle_porcentaje_igv.'</cbc:Percent>';
            }else{
                $xml.= '<cbc:Percent>0.00</cbc:Percent>';
            }
            $xml.= '<cbc:TaxExemptionReasonCode>'.$v->codigo.'</cbc:TaxExemptionReasonCode>
                        <cac:TaxScheme>
                           <cbc:ID>'.$v->codigo_afectacion.'</cbc:ID>
                           <cbc:Name>'.$v->nombre_afectacion.'</cbc:Name>
                           <cbc:TaxTypeCode>'.$v->tipo_afectacion.'</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                     </cac:TaxCategory>
                  </cac:TaxSubtotal>';

            if($v->impuesto_bolsa == "1"){

                $xml.= '<cac:TaxSubtotal>
                            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$total_impuesto_bolsa.'</cbc:TaxAmount>
                            <cbc:BaseUnitMeasure unitCode="NIU">'.$v->venta_detalle_cantidad.'</cbc:BaseUnitMeasure>
                        <cac:TaxCategory>
                        <cbc:PerUnitAmount currencyID="PEN">'.$icbper.'</cbc:PerUnitAmount>
                            <cac:TaxScheme>
                                <cbc:ID>7152</cbc:ID>
                                <cbc:Name>ICBPER</cbc:Name>
                                <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                        </cac:TaxCategory>
                        </cac:TaxSubtotal>';
            }
//            if($v->impuesto_bolsa == "1"){
//                $total_impuesto_bolsa = number_format($v->venta_detalle_cantidad * $icbper, 2);
//                $xml.= '<cac:TaxSubtotal>
//                            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$total_impuesto_bolsa.'</cbc:TaxAmount>
//                            <cbc:BaseUnitMeasure unitCode="'.$v->medida_codigo_unidad.'">'.$v->venta_detalle_cantidad.'</cbc:BaseUnitMeasure>
//                        <cbc:PerUnitAmount currencyID="PEN">'.$icbper.'</cbc:PerUnitAmount>
//                        <cac:TaxCategory>
//                            <cac:TaxScheme>
//                                <cbc:ID>7152</cbc:ID>
//                                <cbc:Name>ICBPER</cbc:Name>
//                                <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
//                            </cac:TaxScheme>
//                        </cac:TaxCategory>
//                        </cac:TaxSubtotal>';
//            }

            $xml.=
                '</cac:TaxTotal>';

            $xml.= '<cac:Item>
                      <cbc:Description><![CDATA['.$v->venta_detalle_nombre_producto.']]></cbc:Description>
                      <cac:SellersItemIdentification>
                         <cbc:ID>'.$v->id_pro.'</cbc:ID>
                      </cac:SellersItemIdentification>
                   </cac:Item>';

            if($v->codigo == "21"){
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:PriceAmount>
               </cac:Price>
            </cac:CreditNoteLine>';
            }else{
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_unitario.'</cbc:PriceAmount>
               </cac:Price>
            </cac:DebitNoteLine>';
            }

            $item++;
        }
        $xml.='</DebitNote>';

        $doc->loadXML($xml);
        $doc->save($nombrexml.'.XML');
    }
    public static function CrearXMLResumenDocumentos($emisor, $cabecera, $detalle, $nombrexml, $fecha_emision)
    {
        $doc = new \DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
           <SummaryDocuments xmlns="urn:sunat:names:specification:ubl:peru:schema:xsd:SummaryDocuments-1" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:sac="urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1" xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2" xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2">
          <ext:UBLExtensions>
              <ext:UBLExtension>
                  <ext:ExtensionContent />
              </ext:UBLExtension>
          </ext:UBLExtensions>
          <cbc:UBLVersionID>2.0</cbc:UBLVersionID>
          <cbc:CustomizationID>1.1</cbc:CustomizationID>
          <cbc:ID>'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'].'</cbc:ID>
          <cbc:ReferenceDate>'.$fecha_emision.'</cbc:ReferenceDate>
          <cbc:IssueDate>'.date('Y-m-d').'</cbc:IssueDate>
          <cac:Signature>
              <cbc:ID>'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'].'</cbc:ID>
              <cac:SignatoryParty>
                  <cac:PartyIdentification>
                      <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
                  </cac:PartyIdentification>
                  <cac:PartyName>
                      <cbc:Name><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Name>
                  </cac:PartyName>
              </cac:SignatoryParty>
              <cac:DigitalSignatureAttachment>
                  <cac:ExternalReference>
                      <cbc:URI>'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'].'</cbc:URI>
                  </cac:ExternalReference>
              </cac:DigitalSignatureAttachment>
          </cac:Signature>
          <cac:AccountingSupplierParty>
              <cbc:CustomerAssignedAccountID>'.$emisor->empresa_ruc.'</cbc:CustomerAssignedAccountID>
              <cbc:AdditionalAccountID>6</cbc:AdditionalAccountID>
              <cac:Party>
                  <cac:PartyLegalEntity>
                      <cbc:RegistrationName><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:RegistrationName>
                  </cac:PartyLegalEntity>
              </cac:Party>
          </cac:AccountingSupplierParty>';
        $item = 1;
        foreach ($detalle as $v) {

            if($v->venta_totalgravada != 0){
                $tipo_total = "01"; //gravada
            }elseif($v->venta_totalexonerada != 0){
                $tipo_total = "02"; //exonerada
            }
            else{
                $tipo_total = "03"; //inafecta
            }
            $xml.='<sac:SummaryDocumentsLine>
                 <cbc:LineID>'.$item.'</cbc:LineID>
                 <cbc:DocumentTypeCode>'.$v->venta_tipo.'</cbc:DocumentTypeCode>
                 <cbc:ID>'.$v->venta_serie.'-'.$v->venta_correlativo.'</cbc:ID>';
            if($v->venta_total > 700){
                $xml .= '<cac:AccountingCustomerParty>
                             <cbc:CustomerAssignedAccountID>'.$v->cliente_numero.'</cbc:CustomerAssignedAccountID>
                             <cbc:AdditionalAccountID>'.$v->tipodocumento_codigo.'</cbc:AdditionalAccountID>
                         </cac:AccountingCustomerParty>';
            }

            if($v->venta_tipo == "07" || $v->venta_tipo == "08"){
                $xml .= '<cac:BillingReference>
                         <cac:InvoiceDocumentReference>
                            <cbc:ID>'.$v->serie_modificar.'-'.$v->correlativo_modificar.'</cbc:ID>
                            <cbc:DocumentTypeCode>'.$v->tipo_documento_modificar.'</cbc:DocumentTypeCode>
                         </cac:InvoiceDocumentReference>
                     </cac:BillingReference>';
            }

            $xml.= '<cac:Status>
                    <cbc:ConditionCode>'.$v->venta_condicion_resumen.'</cbc:ConditionCode>
                 </cac:Status>
                 <sac:TotalAmount currencyID="'.$v->abrstandar.'">'.$v->venta_total.'</sac:TotalAmount>';

            $xml.='<sac:BillingPayment>
                           <cbc:PaidAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totalgravada.'</cbc:PaidAmount>
                           <cbc:InstructionID>01</cbc:InstructionID>
                       </sac:BillingPayment>';

            if($v->venta_totalexonerada != 0){
                $xml.=
                    '<sac:BillingPayment>
                           <cbc:PaidAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totalexonerada.'</cbc:PaidAmount>
                           <cbc:InstructionID>02</cbc:InstructionID>
                       </sac:BillingPayment>';
            }
            if($v->venta_totalinafecta != 0){
                $xml.=
                    '<sac:BillingPayment>
                           <cbc:PaidAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totalinafecta.'</cbc:PaidAmount>
                           <cbc:InstructionID>03</cbc:InstructionID>
                       </sac:BillingPayment>';
            }
            if($v->venta_totalgratuita != 0){
                $xml.=
                    '<sac:BillingPayment>
                           <cbc:PaidAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totalgratuita.'</cbc:PaidAmount>
                           <cbc:InstructionID>05</cbc:InstructionID>
                       </sac:BillingPayment>';
            }

            $xml.='<cac:TaxTotal>
                     <cbc:TaxAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totaligv.'</cbc:TaxAmount>';


            $xml.='<cac:TaxSubtotal>
                         <cbc:TaxAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totaligv.'</cbc:TaxAmount>
                         <cac:TaxCategory>
                             <cac:TaxScheme>
                                 <cbc:ID>1000</cbc:ID>
                                 <cbc:Name>IGV</cbc:Name>
                                 <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                             </cac:TaxScheme>
                         </cac:TaxCategory>
                     </cac:TaxSubtotal>';

            $xml.='</cac:TaxTotal>
             </sac:SummaryDocumentsLine>';
            $item++;
        }

        $xml.='</SummaryDocuments>';

        $doc->loadXML($xml);
        $doc->save($nombrexml.'.XML');
    }

    public static function CrearXmlBajaDocumentos($emisor, $cabecera, $detalle, $nombrexml)
    {
        $doc = new \DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <VoidedDocuments xmlns="urn:sunat:names:specification:ubl:peru:schema:xsd:VoidedDocuments-1" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:sac="urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
          <ext:UBLExtensions>
              <ext:UBLExtension>
                  <ext:ExtensionContent     />
              </ext:UBLExtension>
          </ext:UBLExtensions>
          <cbc:UBLVersionID>2.0</cbc:UBLVersionID>
          <cbc:CustomizationID>1.0</cbc:CustomizationID>
          <cbc:ID>'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'].'</cbc:ID>
          <cbc:ReferenceDate>'.date('Y-m-d', strtotime($detalle->venta_fecha)).'</cbc:ReferenceDate>
          <cbc:IssueDate>'.date('Y-m-d').'</cbc:IssueDate>
          <cac:Signature>
              <cbc:ID>'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'].'</cbc:ID>
              <cac:SignatoryParty>
                  <cac:PartyIdentification>
                      <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
                  </cac:PartyIdentification>
                  <cac:PartyName>
                      <cbc:Name><![CDATA['.$emisor->empresa_razon_social.']]></cbc:Name>
                  </cac:PartyName>
              </cac:SignatoryParty>
              <cac:DigitalSignatureAttachment>
                  <cac:ExternalReference>
                      <cbc:URI>'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'].'</cbc:URI>
                  </cac:ExternalReference>
              </cac:DigitalSignatureAttachment>
          </cac:Signature>
          <cac:AccountingSupplierParty>
              <cbc:CustomerAssignedAccountID>'.$emisor->empresa_ruc.'</cbc:CustomerAssignedAccountID>
              <cbc:AdditionalAccountID>6</cbc:AdditionalAccountID>
              <cac:Party>
                  <cac:PartyLegalEntity>
                      <cbc:RegistrationName><![CDATA['.$emisor->empresa_razon_social.']]></cbc:RegistrationName>
                  </cac:PartyLegalEntity>
              </cac:Party>
          </cac:AccountingSupplierParty>';


        $xml.='<sac:VoidedDocumentsLine>
                 <cbc:LineID>1</cbc:LineID>
                 <cbc:DocumentTypeCode>'.$detalle->venta_tipo.'</cbc:DocumentTypeCode>
                 <sac:DocumentSerialID>'.$detalle->venta_serie.'</sac:DocumentSerialID>
                 <sac:DocumentNumberID>'.$detalle->venta_correlativo.'</sac:DocumentNumberID>
                 <sac:VoidReasonDescription><![CDATA[Error en Documento]]></sac:VoidReasonDescription>
             </sac:VoidedDocumentsLine>';


        $xml.='</VoidedDocuments>';

        $doc->loadXML($xml);
        $doc->save($nombrexml.'.XML');
    }


    /**
     * Genera el XML de Guía de Remisión (DespatchAdvice) para la API GRE de SUNAT.
     * Adaptado para los campos de la base de datos local del proyecto.
     */
    public static function CrearXmlGuiaRemision($nombrexml, $emisor, $guia, $detalle_guia, $venta)
    {
        $doc = new \DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';

        $exis_relacion = false;
        $venta_s_c = '';
        $tipo = '';
        $venta_tipo = '';

        if (!empty($guia->id_venta) && $venta) {
            $exis_relacion = true;
            $venta_s_c = $venta->venta_serie . '-' . $venta->venta_correlativo;
            if ($venta->venta_tipo == '01') {
                $tipo = 'FACTURA';
                $venta_tipo = '01';
            } elseif ($venta->venta_tipo == '03') {
                $tipo = 'BOLETA';
                $venta_tipo = '03';
            }
        }

        $observacion = !empty($guia->guia_observacion) ? $guia->guia_observacion : '-';
        $tipo_guia   = $guia->guia_tipo;

        // Nombre comercial — adaptar al campo real de la tabla empresa
        $empresa_nombre_comercial = $emisor->empresa_nombrecomercial ?? $emisor->empresa_razon_social;

        // Destinatario
        $tipo_destinatario       = $guia->guia_tipo_doc_desti ?? '6';
        $numero_destinatario     = $guia->guia_num_doc_desti ?? '';
        $denominacion_destinatario = $guia->guia_denominacion_desti ?? '';

        if ($tipo_guia == '09') {
            // Remitente: el destinatario es la propia empresa
            $tipo_destinatario       = '6';
            $numero_destinatario     = $emisor->empresa_ruc;
            $denominacion_destinatario = $emisor->empresa_razon_social;
        }

        $fecha_emision = date('Y-m-d', strtotime($guia->created_at));
        $hora_emision  = date('H:i:s', strtotime($guia->created_at));

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<DespatchAdvice xmlns="urn:oasis:names:specification:ubl:schema:xsd:DespatchAdvice-2"
    xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
    xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
    xmlns:ds="http://www.w3.org/2000/09/xmldsig#"
    xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
 <ext:UBLExtensions>
    <ext:UBLExtension>
       <ext:ExtensionContent />
    </ext:UBLExtension>
 </ext:UBLExtensions>
 <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
 <cbc:CustomizationID>2.0</cbc:CustomizationID>
 <cbc:ID>' . $guia->guia_serie . '-' . $guia->guia_correlativo . '</cbc:ID>
 <cbc:IssueDate>' . $fecha_emision . '</cbc:IssueDate>
 <cbc:IssueTime>' . $hora_emision . '</cbc:IssueTime>
 <cbc:DespatchAdviceTypeCode>' . $tipo_guia . '</cbc:DespatchAdviceTypeCode>
 <cbc:Note>' . htmlspecialchars($observacion, ENT_XML1) . '</cbc:Note>';

        if ($exis_relacion) {
            $xml .= '<cac:AdditionalDocumentReference>
     <cbc:ID>' . $venta_s_c . '</cbc:ID>
     <cbc:DocumentTypeCode>' . $venta_tipo . '</cbc:DocumentTypeCode>
     <cbc:DocumentType>' . $tipo . '</cbc:DocumentType>
     <cac:IssuerParty>
        <cac:PartyIdentification>
           <cbc:ID schemeID="6" schemeAgencyName="PE:SUNAT"
               schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">' . $emisor->empresa_ruc . '</cbc:ID>
        </cac:PartyIdentification>
     </cac:IssuerParty>
</cac:AdditionalDocumentReference>';
        }

        $xml .= '<cac:Signature>
    <cbc:ID>' . $emisor->empresa_ruc . '</cbc:ID>
    <cac:SignatoryParty>
       <cac:PartyIdentification>
          <cbc:ID>' . $emisor->empresa_ruc . '</cbc:ID>
       </cac:PartyIdentification>
       <cac:PartyName>
          <cbc:Name>' . htmlspecialchars($emisor->empresa_razon_social, ENT_XML1) . '</cbc:Name>
       </cac:PartyName>
    </cac:SignatoryParty>
    <cac:DigitalSignatureAttachment>
       <cac:ExternalReference>
          <cbc:URI>' . $emisor->empresa_ruc . '</cbc:URI>
       </cac:ExternalReference>
    </cac:DigitalSignatureAttachment>
 </cac:Signature>';

        // Remitente
        $xml .= '<cac:DespatchSupplierParty>
    <cbc:CustomerAssignedAccountID schemeID="6">' . $emisor->empresa_ruc . '</cbc:CustomerAssignedAccountID>
    <cac:Party>
       <cac:PartyIdentification>
          <cbc:ID schemeID="6" schemeName="Documento de Identidad" schemeAgencyName="PE:SUNAT"
              schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">' . $emisor->empresa_ruc . '</cbc:ID>
       </cac:PartyIdentification>
       <cac:PartyLegalEntity>
          <cbc:RegistrationName>' . htmlspecialchars($empresa_nombre_comercial, ENT_XML1) . '</cbc:RegistrationName>
       </cac:PartyLegalEntity>
    </cac:Party>
 </cac:DespatchSupplierParty>';

        // Destinatario
        $xml .= '<cac:DeliveryCustomerParty>
    <cac:Party>
       <cac:PartyIdentification>
          <cbc:ID schemeID="' . $tipo_destinatario . '" schemeName="Documento de Identidad" schemeAgencyName="PE:SUNAT"
              schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">' . $numero_destinatario . '</cbc:ID>
       </cac:PartyIdentification>
       <cac:PartyLegalEntity>
          <cbc:RegistrationName><![CDATA[' . $denominacion_destinatario . ']]></cbc:RegistrationName>
       </cac:PartyLegalEntity>
    </cac:Party>
 </cac:DeliveryCustomerParty>';

        // Motivo
        switch ($guia->guia_motivo) {
            case '01': $motivo = 'VENTA'; break;
            case '02': $motivo = 'COMPRA'; break;
            case '03': $motivo = 'VENTA CON ENTREGA A TERCEROS'; break;
            case '04': $motivo = 'TRASLADO ENTRE ESTABLECIMIENTOS'; break;
            case '05': $motivo = 'CONSIGNACIÓN'; break;
            case '06': $motivo = 'DEVOLUCIÓN'; break;
            case '07': $motivo = 'RECOJO DE BIENES TRANSFORMADOS'; break;
            case '08': $motivo = 'IMPORTACION'; break;
            case '09': $motivo = 'EXPORTACION'; break;
            case '13': $motivo = 'OTROS'; break;
            case '14': $motivo = 'VENTA SUJETA A CONFIRMACION DEL COMPRADOR'; break;
            case '17': $motivo = 'TRASLADO DE BIENES PARA TRANSFORMACIÓN'; break;
            case '18': $motivo = 'TRASLADO EMISOR ITINERANTE CP'; break;
            default:   $motivo = 'OTROS';
        }

        $p_bulto           = $guia->guia_peso_bruto ?? 0;
        $guia_unidad_medida = $guia->guia_unidad_medida ?? 'KGM';
        $n_bulto           = !empty($guia->guia_n_bulto) ? $guia->guia_n_bulto : 1;

        $xml .= '<cac:Shipment>
    <cbc:ID>SUNAT_Envio</cbc:ID>';

        if ($tipo_guia == '09') {
            $xml .= '<cbc:HandlingCode>' . $guia->guia_motivo . '</cbc:HandlingCode>
    <cbc:HandlingInstructions><![CDATA[' . $motivo . ']]></cbc:HandlingInstructions>';
        }

        $xml .= '<cbc:GrossWeightMeasure unitCode="' . $guia_unidad_medida . '">' . $p_bulto . '</cbc:GrossWeightMeasure>
    <cbc:TotalTransportHandlingUnitQuantity>' . $n_bulto . '</cbc:TotalTransportHandlingUnitQuantity>
    <cac:ShipmentStage>
       <cbc:ID>1</cbc:ID>';

        if ($tipo_guia == '09') {
            $xml .= '<cbc:TransportModeCode>' . ($guia->guia_tipo_trans ?? '02') . '</cbc:TransportModeCode>';
        }

        $xml .= '<cac:TransitPeriod>
          <cbc:StartDate>' . date('Y-m-d', strtotime($guia->guia_fecha_traslado)) . '</cbc:StartDate>
       </cac:TransitPeriod>';

        // Transportista público
        if ($guia->guia_tipo_trans == '01' && !empty($guia->guia_num_doc_trans)) {
            $xml .= '<cac:CarrierParty>
          <cac:PartyIdentification>
             <cbc:ID schemeID="' . $guia->guia_tipo_doc_trans . '">' . $guia->guia_num_doc_trans . '</cbc:ID>
          </cac:PartyIdentification>
          <cac:PartyLegalEntity>
             <cbc:RegistrationName>' . htmlspecialchars($guia->guia_denominacion ?? '', ENT_XML1) . '</cbc:RegistrationName>
          </cac:PartyLegalEntity>
       </cac:CarrierParty>';
        }

        // Transporte privado o tipo 31
        if ($guia->guia_tipo_trans == '02' || $tipo_guia == '31') {
            $xml .= '<cac:TransportMeans>
          <cac:RoadTransport>
             <cbc:LicensePlateID>' . ($guia->guia_placa ?? '') . '</cbc:LicensePlateID>
          </cac:RoadTransport>
       </cac:TransportMeans>';

            if (!empty($guia->guia_conductor_numero)) {
                $xml .= '<cac:DriverPerson>
          <cbc:ID schemeID="' . ($guia->guia_conductor_documento_tipo ?? '1') . '">' . $guia->guia_conductor_numero . '</cbc:ID>
          <cbc:FirstName>' . htmlspecialchars($guia->guia_conductor_nombre ?? '', ENT_XML1) . '</cbc:FirstName>
          <cbc:FamilyName>' . htmlspecialchars($guia->guia_conductor_apellidos ?? '', ENT_XML1) . '</cbc:FamilyName>
          <cbc:JobTitle>Principal</cbc:JobTitle>
          <cac:IdentityDocumentReference>
             <cbc:ID>' . ($guia->guia_licencia_conductor ?? '') . '</cbc:ID>
          </cac:IdentityDocumentReference>
       </cac:DriverPerson>';
            }
        }

        $xml .= '</cac:ShipmentStage>
    <cac:Delivery>
       <cac:DeliveryAddress>
          <cbc:ID schemeAgencyName="PE:INEI" schemeName="Ubigeos">' . ($guia->guia_ubigeo_llega ?? '') . '</cbc:ID>
          <cac:AddressLine>
             <cbc:Line><![CDATA[' . ($guia->guia_direccion_llega ?? '') . ']]></cbc:Line>
          </cac:AddressLine>
       </cac:DeliveryAddress>
       <cac:Despatch>
          <cac:DespatchAddress>
             <cbc:ID schemeAgencyName="PE:INEI" schemeName="Ubigeos">' . ($guia->guia_ubigeo_part ?? '') . '</cbc:ID>
             <cac:AddressLine>
                <cbc:Line><![CDATA[' . ($guia->guia_direccion_part ?? '') . ']]></cbc:Line>
             </cac:AddressLine>
          </cac:DespatchAddress>';

        if ($tipo_guia == '31' && !empty($guia->cliente_numero)) {
            $xml .= '<cac:DespatchParty>
             <cac:PartyIdentification>
                <cbc:ID schemeID="' . ($guia->tipodocumento_codigo ?? '6') . '" schemeName="Documento de Identidad"
                    schemeAgencyName="PE:SUNAT"
                    schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">' . $guia->cliente_numero . '</cbc:ID>
             </cac:PartyIdentification>
             <cac:PartyLegalEntity>
                <cbc:RegistrationName>' . htmlspecialchars($guia->cliente_razonsocial ?? $guia->cliente_nombre, ENT_XML1) . '</cbc:RegistrationName>
             </cac:PartyLegalEntity>
          </cac:DespatchParty>';
        }

        $xml .= '</cac:Despatch>
    </cac:Delivery>';

        if ($guia->guia_tipo_trans == '02' && !empty($guia->guia_placa)) {
            $xml .= '<cac:TransportHandlingUnit>
       <cac:TransportEquipment>
          <cbc:ID>' . $guia->guia_placa . '</cbc:ID>
       </cac:TransportEquipment>
    </cac:TransportHandlingUnit>';
        }

        $xml .= '</cac:Shipment>';

        // Items
        $item = 1;
        foreach ($detalle_guia as $det) {
            $codigo_producto = 'C00' . $item;
            $xml .= '<cac:DespatchLine>
    <cbc:ID>' . $item . '</cbc:ID>
    <cbc:DeliveredQuantity unitCode="' . $det->guia_remision_detalle_um . '">' . $det->guia_remision_detalle_cantidad . '</cbc:DeliveredQuantity>
    <cac:OrderLineReference>
       <cbc:LineID>' . $item . '</cbc:LineID>
    </cac:OrderLineReference>
    <cac:Item>
       <cbc:Description>' . htmlspecialchars($det->guia_remision_detalle_descripcion, ENT_XML1) . '</cbc:Description>
       <cac:SellersItemIdentification>
          <cbc:ID>' . $codigo_producto . '</cbc:ID>
       </cac:SellersItemIdentification>
    </cac:Item>
 </cac:DespatchLine>';
            $item++;
        }

        $xml .= '</DespatchAdvice>';

        $doc->loadXML($xml);
        $doc->save($nombrexml . '.XML');
    }


}
