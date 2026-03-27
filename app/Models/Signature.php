<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//require public_path('ApiFacturacion/api_signature/XMLSecurityKey.php');
//require public_path('ApiFacturacion/api_signature/XMLSecurityDSig.php');
//require public_path('ApiFacturacion/api_signature/XMLSecEnc.php');
require ('api_signature/XMLSecurityKey.php');
require ('api_signature/XMLSecurityDSig.php');
require ('api_signature/XMLSecEnc.php');
use XMLSecEnc;
class Signature extends Model
{
    use HasFactory;
    public static function signature_xml($flg_firma, $ruta, $ruta_firma, $pass_firma) {
        $doc = new \DOMDocument();

        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->load($ruta);

        $objDSig = new \XMLSecurityDSig(FALSE);
        $objDSig->setCanonicalMethod(\XMLSecurityDSig::C14N);
        $options['force_uri'] = TRUE;
        $options['id_name'] = 'ID';
        $options['overwrite'] = FALSE;

        $objDSig->addReference($doc, \XMLSecurityDSig::SHA1, array('http://www.w3.org/2000/09/xmldsig#enveloped-signature'), $options);
        $objKey = new \XMLSecurityKey(\XMLSecurityKey::RSA_SHA1, array('type' => 'private'));

        $pfx = file_get_contents($ruta_firma);
        $key = array();

        openssl_pkcs12_read($pfx, $key, $pass_firma);
        $objKey->loadKey($key["pkey"]);
        $objDSig->add509Cert($key["cert"], TRUE, FALSE);
        $objDSig->sign($objKey, $doc->documentElement->getElementsByTagName("ExtensionContent")->item($flg_firma));

        $atributo = $doc->getElementsByTagName('Signature')->item(0);
        $atributo->setAttribute('Id', 'SignatureSP');

        //===================rescatamos Codigo(HASH_CPE)==================
        $hash_cpe = $doc->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        $firma_cpe = $doc->getElementsByTagName('SignatureValue')->item(0)->nodeValue;

        $doc->save($ruta);
        $resp['respuesta'] = 'ok';
        $resp['hash_cpe'] = $hash_cpe;
        $resp['firma_cpe'] = $firma_cpe;
        return $resp;
    }

    /**
     * Firma XML con archivos PEM (cert.pem + key.pem) para la API GRE de SUNAT.
     */
    public static function signature_xml_new($flg_firma, $ruta, $ruta_cert_pem, $ruta_key_pem)
    {
        try {
            $doc = new \DOMDocument();
            $doc->formatOutput = FALSE;
            $doc->preserveWhiteSpace = TRUE;
            $doc->load($ruta);

            $objDSig = new \XMLSecurityDSig(FALSE);
            $objDSig->setCanonicalMethod(\XMLSecurityDSig::C14N);
            $options['force_uri'] = TRUE;
            $options['id_name']   = 'ID';
            $options['overwrite'] = FALSE;

            $objDSig->addReference($doc, \XMLSecurityDSig::SHA256, ['http://www.w3.org/2000/09/xmldsig#enveloped-signature'], $options);

            $objKey = new \XMLSecurityKey(\XMLSecurityKey::RSA_SHA256, ['type' => 'private']);
            $objKey->loadKey(file_get_contents($ruta_key_pem));

            $objDSig->sign($objKey, $doc->documentElement->getElementsByTagName('ExtensionContent')->item($flg_firma));
            $objDSig->add509Cert(file_get_contents($ruta_cert_pem), TRUE, FALSE);

            $atributo = $doc->getElementsByTagName('Signature')->item(0);
            $atributo->setAttribute('Id', 'SignatureSP');

            $hash_cpe  = $doc->getElementsByTagName('DigestValue')->item(0)->nodeValue;
            $firma_cpe = $doc->getElementsByTagName('SignatureValue')->item(0)->nodeValue;

            $doc->save($ruta);

            return ['respuesta' => 'ok', 'hash_cpe' => $hash_cpe, 'firma_cpe' => $firma_cpe];
        } catch (\Exception $e) {
            return ['respuesta' => $e->getMessage()];
        }
    }

}
