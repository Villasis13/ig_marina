<!DOCTYPE html>
<html>
<head>
    <title>Comprobante de Venta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        /* CLIENT-SPECIFIC STYLES */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }
        /* RESET STYLES */
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
        .blanquito { background-color: #ffffff !important; }
        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }
        /* MEDIA QUERIES */
        @media screen and (max-width: 480px) {
            .mobile-hide { display: none !important; }
            .mobile-center { text-align: center !important; }
        }
        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] { margin: 0 !important; }
    </style>
</head>
<body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">
<!-- HIDDEN PREHEADER TEXT -->
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Open Sans, Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
{{--    Consulta desde Web--}}
</div>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                <!-- Título en rojo (Agrega aquí el fragmento de código que falta) -->
                <tr>
                    <td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff;" bgcolor="#ffffff">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                            <tr>
                                <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                                    <!-- Agrega la URL de la imagen del logo en src -->
                                    <img src="https://miskyselva.com/inicio/img/logo.png" alt="" style="display: block; border: 0px;width: 200px;">
                                    <br>
                                    <h4 style="font-size: 20px; font-weight: 800; line-height: 25px; color: #333333; margin: 0;">
                                        Estado de la orden
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                                    <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
{{--                                        La siguiente {{$datos['tipo'] == 2  ? 'persona' : 'entidad'}}  solicitó identificada con el  {{$datos['tipo']}} con el numero {{$datos['numero_doc']}}  solicita mayor información a través de la página web <br>--}}
                                        Hola, {{$persona}} <br> <br>
{{--                                        Celular : {{$datos['telefono']}} <br>--}}
                                        @php echo $mensaje @endphp <br>
{{--                                        {{$datos['mensaje']}}--}}
                                        <br><br><br>
{{--                                        *No responder a este correo en la brevedad posible para una buena atención.--}}
{{--                                        *No responder a este correo--}}
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Cuerpo del mensaje -->

                <!-- Publicidad a Bufeo -->
                <tr>
                    <td align="center" style="padding: 35px; background: linear-gradient(to bottom, #283890, #fd3164);" bgcolor="#139a43">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                            <tr>
                                <td align="center">
                                    <img src="https://bufeotec.com/archivos_clientes/logo_bufeo_nuevo.png" width="100" style="display: block; border: 0px;"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 24px; padding: 5px 0 10px 0;">
                                    <p style="font-size: 14px; font-weight: 800; line-height: 18px; color: white;">
                                        Desarrollado por BufeoTEC
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 24px;">
                                    <p style="font-size: 14px; font-weight: 400; line-height: 20px; color: white;">
                                        <a href="https://bufeotec.com" target="_blank" style="color: white;">¿Interesado? Visita nuestro sitio web</a>.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Publicidad a Bufeo -->
            </table>
        </td>
    </tr>
</table>
</body>
</html>
