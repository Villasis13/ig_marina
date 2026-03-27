@extends('layouts.plantilla')
@section('content')
    <div class="tab-content">
        @can($opciones[0]->opciones_funcion)
            <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active  " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" >

                <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                    <div class="card">
                        <form action="{{route('facturacion.historial_envios')}}" method="post">
                            @csrf
                            <div class="row m-2">
                                <input type="hidden" name="enviar_registro2" id="enviar_registro2" value="1">
                                <div class="col-lg-3 col-md-12 col-sm-1 mb-12 ">
                                    <label for="tipo_venta">Tipo de Venta</label>
                                    <select name="tipo_venta" id="tipo_venta" class="form-control ">
                                        <option <?= ($tipo_venta1 == "0")?'selected':''; ?> value="0">TODOS</option>
                                        <option <?= ($tipo_venta1 == "03")?'selected':''; ?> value="03">BOLETA</option>
                                        <option <?= ($tipo_venta1 == "01")?'selected':''; ?> value="01">FACTURA</option>
                                        <option <?= ($tipo_venta1 == "07")?'selected':''; ?> value= "07">NOTA DE CRÉDITO</option>
                                        <option <?= ($tipo_venta1 == "08")?'selected':''; ?> value= "08">NOTA DE DÉBITO</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                                    <label for="fecha_inicio">Desde :</label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control " value="{{$fecha_inicio1}}">
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-1 ">
                                    <label for="fecha_final">Hasta :</label>
                                    <input type="date" name="fecha_final" id="fecha_final" class="form-control " value="{{$fecha_final1}}">
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-1 d-flex align-items-center">
                                    <button class="btn btn-sm text-white bg-primary w-100" type="submit"> <i class="fa fa-search"></i> Buscar Datos</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card ">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card-body table-responsive ">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <table class="table table-hover " id="dataTable1">
                                                <thead>
                                                <tr class="color_tabla">
                                                    <th>#</th>
                                                    <th>Fecha de Emisión</th>
                                                    <th>Tipo de Envío</th>
                                                    <th>Comprobante</th>
                                                    {{--                                                        <th>Serie y Correlativo</th>--}}
                                                    <th>Cliente</th>
                                                    <th>Forma de Pago</th>
                                                    {{--                                                        <th>Tipo de Pago</th>--}}
                                                    {{--                                                        <th>Moneda</th>--}}
                                                    <th>Total</th>
                                                    <th>PDF</th>
                                                    <th>XML</th>
                                                    <th>CDR</th>
                                                    <th>Estado Sunat</th>
                                                    <th>Acción</th>
                                                </tr>
                                                </thead>
                                                @if($filtro2)
                                                    <tbody >
                                                        <?php
                                                        $a = 1;
                                                        $total = 0;
                                                        $total_soles = 0;
                                                    foreach ($ventas2 as $al){
                                                        $stylee="style= 'color:black;text-align: center;'";
                                                        if ($al->anulado_sunat == 1){
                                                            $stylee="style= 'color:black;text-align: center; background: #efa6ad'";
                                                        }

                                                        if($al->venta_tipo == "03"){
                                                            $tipo_comprobante = "BOLETA";
                                                            if($al->anulado_sunat == 0){
                                                                $total_soles = round($total_soles + $al->venta_total, 2);
                                                            }
                                                        }elseif ($al->venta_tipo == "01"){
                                                            $tipo_comprobante = "FACTURA";
                                                            if($al->anulado_sunat == 0){
                                                                $total_soles = round($total_soles + $al->venta_total, 2);
                                                            }
                                                        }elseif($al->venta_tipo == "07"){
                                                            $tipo_comprobante = "NOTA DE CRÉDITO";
                                                        }elseif($al->venta_tipo == "08"){
                                                            $tipo_comprobante = "NOTA DE DÉBITO";
                                                            if($al->anulado_sunat == 0){
                                                                $total_soles = round($total_soles + $al->venta_total, 2);
                                                            }
                                                        }else{
                                                            $tipo_comprobante = "--";
                                                        }

                                                        $estilo_mensaje = "";
                                                        if($al->venta_estado_sunat == 1){
                                                            if($al->venta_respuesta_sunat != ""){
                                                                $mensaje = $al->venta_respuesta_sunat;
                                                            }else{
                                                                $mensaje = 'Aceptado por Resumen Diario';
                                                            }
                                                            $estilo_mensaje = "style= 'color: green; font-size: 14px;'";
                                                        }

                                                        if($al->id_tipo_documento == 4){
                                                            $cliente = $al->cliente_razonsocial;
                                                        }else{
                                                            $cliente = $al->cliente_nombre;
                                                        }

                                                        ?>
                                                    <tr <?= $stylee?>>
                                                        <td><?= $a;?></td>
                                                        <td><?= date('d-m-Y H:i:s', strtotime($al->venta_fecha));?></td>
                                                        @if($al->venta_tipo_envio == 1)
                                                            <td>DIRECTO</td>
                                                        @else
                                                            {{--                                                        {{route('venta.detalle_resumen')}}--}}
                                                            <td><a href="{{route('facturacion.detalle_resumen',$al->resumen->id_envio_resumen)}}" type="button" target="_blank">RESUMEN DIARIO</a></td>
                                                        @endif
                                                        <td><?= $tipo_comprobante;?>
                                                            <br>
                                                                <?= $al->venta_serie. '-' .$al->venta_correlativo;?>
                                                        </td>
                                                        <td>
                                                                <?= $al->cliente_numero;?><br>
                                                                <?= $cliente;?>
                                                        </td>
                                                        <td><?= $al->id_formas_pago == 1 ? 'CONTADO' : 'CREDITO';?></td>
                                                        {{--                                                            <td>--}}
                                                        {{--                                                                @foreach($al->tipo_pago as $d)--}}
                                                        {{--                                                                        <?= $d->tipo_pago_nombre;?>--}}
                                                        {{--                                                                @endforeach--}}
                                                        {{--                                                            </td>--}}
                                                        {{--                                                            <td>{{$al->id_moneda == 1 ? 'SOLES':'DÓLARES'}}</td>--}}
                                                        <td>
                                                                <?= $al->simbolo;?>
                                                                <?= $al->venta_total;?>
                                                        </td>
                                                        <td>
                                                            <a type="button" title="Imprimir PDF" target='_blank' href="{{route('Gestionventas.imprimir_ticket_pdf', ['venta_id'=>$al->id_venta])}}" style="color: red" ><i class="fa-regular fa-file-pdf"></i></a>
                                                        </td>
                                                            <?php
                                                        if($al->venta_tipo_envio == 1){?>
                                                        <td>
                                                            <a type="button"  title="Visualizar XML" target='_blank' href="{{asset($al->venta_rutaXML)}}" style="color: blue;" ><i class="fa fa-file-text"></i></a>
                                                            <a type="button" title="Descargar XML" download="<?= $al->venta_rutaXML;?>" href="{{asset($al->venta_rutaXML)}}" data-toggle="tooltip" ><i class="fa fa-download"></i></a>
                                                        </td>
                                                        <td>
                                                            <a type="button" title="Visualizar XML" target='_blank' href="{{asset($al->venta_rutaCDR)}}" style="color: green" ><i class="fa fa-file"></i></a>
                                                            <a class="text-dark" download="<?= $al->venta_rutaCDR;?>" href="{{asset($al->venta_rutaCDR)}}" data-toggle="tooltip" title="Descargar CDR"><i class="fa fa-download pdf"></i></a>
                                                        </td>

                                                            <?php
                                                        }else{ ?>
                                                        <td>--</td>
                                                        <td>--</td>
                                                            <?php
                                                        }
                                                            ?>

                                                        <td <?= $estilo_mensaje;?>><?= $mensaje;?></td>
                                                        <td style="text-align: left">
                                                            <a target="_blank" type="button" title="Ver detalle" class="btn btn-sm btn-primary" style="color: white" href="{{route('Gestionventas.venta_detalle', ['venta_id'=>$al->id_venta] )}}" ><i class="fa fa-eye ver_detalle"></i></a>
                                                            {{--                                                        <a type="button" title="Enviar Correo" data-toggle="modal" data-target="#enviar_correo_al_cliente" onclick="poner_id_venta(<?= $al->id_venta ;?>);" class="btn btn-sm btn-success" style="color: white"  ><i class="fa fa-envelope-o ver_detalle"></i></a>--}}
                                                                <?php

                                                            if($al->anulado_sunat == 0){
                                                                $date2 = new DateTime(date('Y-m-d H:i:s'));
                                                                $date1 = new DateTime($al->venta_fecha);
                                                                $diff = $date2->diff($date1);
                                                                $dias= $diff->days;

                                                            if($al->venta_tipo != "03"){

                                                            if($dias <= 7) {
                                                            if($al->tipo_documento_modificar != ""){
                                                            if($al->tipo_documento_modificar == "01"){
                                                                ?>
                                                            <a target="_blank" type="button" title="Anular" id="btn_anular_anular<?= $al->id_venta;?>" class="btn btn-sm btn-danger btne" style="color: white" onclick="preguntar('¿Está seguro que desea anular este Comprobante?','comunicacion_baja','Si','No',<?= $al->id_venta;?>)" ><i class="fa fa-ban"></i></a>
                                                                <?php
                                                            }
                                                            }else{
                                                                ?>
                                                            <a target="_blank" type="button" title="Anular" id="btn_anular_anular<?= $al->id_venta;?>" class="btn btn-sm btn-danger btne" style="color: white" onclick="preguntar('¿Está seguro que desea anular este Comprobante?','anular_boleta_cambiarestado','Si','No',<?= $al->id_venta;?>,10)"><i class="fa fa-ban"></i></a>
                                                            {{--                                                                <a target="_blank" type="button" title="Anular" id="btn_anular_anular<?= $al->id_venta;?>" class="btn btn-sm btn-danger btne" style="color: white"  data-bs-toggle="modal" data-bs-target="#modal_anularventa" onclick="llenarcampos_anularventa('<?= $al->id_venta;?>', 10)"><i class="fa fa-ban"></i></a>--}}
                                                                <?php
                                                            }
                                                            }
                                                            }
                                                            else{
                                                            if($al->venta_tipo_envio == "2"){
                                                                ?>
                                                            <a type="button" title="Anular" id="btn_anular_anular<?= $al->id_venta;?>" onclick="preguntar('¿Está seguro que desea anular este Comprobante?','anular_boleta_cambiarestado','Si','No',<?= $al->id_venta;?>,3)"  class="btn btn-sm btn-danger btne" style="color: white" ><i class="fa fa-ban"></i></a>
                                                                <?php
                                                            }
                                                            }
                                                            }


                                                            if($al->anulado_sunat == 0 && ($al->venta_tipo == '01' || $al->venta_tipo == '03')){
                                                                ?>
                                                            <a type="button" style="color: white" class="btn btn-sm btn-success btne" title="GENERAR NOTA" href="{{route('facturacion.generar_nota',$al->id_venta)}}" target="_blank" ><i class="fa fa-clipboard"></i></a>
                                                            {{--                                                                    <a type="button" style="color: white" class="btn btn-sm btn-success btne" title="GENERAR NOTA" href="{{route('venta.generar_nota',$al->id_venta)}}" target="_blank" ><i class="fa fa-clipboard"></i></a>--}}
                                                                <?php
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                        <?php
                                                        $a++;
//                                                    $total = $total + $al->pago_total;
                                                    }
                                                        ?>
                                                    </tbody>
                                                @endif

                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    @if($fecha_inicio1 and $fecha_final1)
                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                {{--                                                    <a class="btn btn-success" id="btn_exportar" target="_blank" href="{{url('facturacion/excel_ventas_enviadas/'.$tipo_venta1.'/'.$fecha_inicio1.'/'.$fecha_final1)}}"><i class="fa fa-file-excel-o"> Descargar Excel </i></a>--}}
                                                <a class="btn btn-success" id="btn_exportar" target="_blank" href="{{route('facturacion.excel_ventas_enviadas',['tipo'=>$tipo_venta1,'fecha_inicio'=>$fecha_inicio1,'fecha_final'=>$fecha_final1,'empresa'=>1])}}"><i class="fa-solid fa-file-excel"></i> Descargar Excel</a>
                                                {{--                                                <a class="btn btn-success" id="btn_exportar" target="_blank" href="{{route('contabilidad.excel_ventas',$tipo_venta,$fecha_inicio,$fecha_final)}}"><i class="fa fa-file-excel-o">Descargar Excel </i></a>--}}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endcan

        @can($opciones[1]->opciones_funcion)
            <div id="vista_para_opciones_{{$opciones[1]->id_opciones}}" class="tab-pane fade show  " role="tabpanel" aria-labelledby="opciones_{{$opciones[1]->id_opciones}}" >
                <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                    <div class="card">
                        <form action="{{route('facturacion.historial_envios')}}" method="post">
                            @csrf
                            <div class="row m-2">
                                <input type="hidden" name="enviar_registro1" id="enviar_registro1" value="1">
                                <div class="col-lg-3 col-md-5 col-sm-12 mb-1 d-flex align-items-center justify-content-around">
                                    <label for="fecha_inicio">Desde :</label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control w-75" value="{{$fecha_ini}}">
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12 mb-1 d-flex align-items-center justify-content-around">
                                    <label for="fecha_final">Hasta :</label>
                                    <input type="date" name="fecha_final" id="fecha_final" class="form-control w-75" value="{{$fecha_fin}}">
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-12 mb-1 d-flex align-items-center">
                                    <button class="btn btn-sm text-white bg-primary w-100" type="submit"> <i class="fa fa-search"></i> Buscar Datos</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card ">
                        <div class="row">

                            @if($filtro1)
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card-body table-responsive ">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <table class="table table-hover " id="dataTable1">
                                                    <thead>
                                                    <tr class="color_tabla">
                                                        <th>#</th>
                                                        <th>Fecha de Emisión</th>
                                                        <th>Fecha de Comprobantes</th>
                                                        <th>Serie Y Correlativo</th>
                                                        <th>XML</th>
                                                        <th>Estado XML</th>
                                                        <th>CDR</th>
                                                        <th>Estado Sunat</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody >
                                                        <?php
                                                        $a = 1;
                                                        $total = 0;
                                                    foreach ($ventas1 as $al){
                                                        $stylee="style= 'text-align: center;'";

                                                        $estilo_mensaje = "style= 'color: red; font-size: 14px;'";
                                                        if($al->envio_resumen_estadosunat == NULL){
                                                            $mensaje = "Sin Enviar a Sunat";
                                                        }else{
                                                            $mensaje = $al->envio_resumen_estadosunat;
                                                            $estilo_mensaje = "style= 'color: green; font-size: 14px;'";
                                                        }

                                                        $estilo_mensaje_consulta = "";
                                                        if($al->envio_resumen_estadosunat_consulta == NULL){
                                                            $mensaje_consulta = "";
                                                        }else{
                                                            $mensaje_consulta = $al->envio_resumen_estadosunat_consulta;
                                                            $estilo_mensaje_consulta = "style= 'color: green; font-size: 14px;'";
                                                        }
                                                        ?>
                                                    <tr <?= $stylee?>>
                                                        <td><?= $a;?></td>
                                                        <td><?= date('d-m-Y H:i:s', strtotime($al->envio_sunat_datetime));?></td>
                                                        <td><?= date('d-m-Y', strtotime($al->envio_resumen_fecha));?></td>
                                                        <td><?= $al->envio_resumen_serie. '-' .$al->envio_resumen_correlativo;?></td>
                                                            <?php
                                                        if(file_exists($al->envio_resumen_nombreXML)){ ?>
                                                        <td><center><a type="button" target='_blank' href="{{asset($al->envio_resumen_nombreXML)}}" style="color: blue" ><i class="fa fa-file-text"></i></a></center></td>
                                                            <?php
                                                        }else{ ?>
                                                        <td>--</td>
                                                            <?php
                                                        }
                                                            ?>
                                                        <td <?= $estilo_mensaje;?>><?= $mensaje;?></td>
                                                            <?php
                                                        if(file_exists($al->envio_resumen_nombreCDR)){ ?>
                                                        <td><center><a type="button" target='_blank' href="{{asset($al->envio_resumen_nombreCDR)}}" style="color: green" ><i class="fa fa-file"></i></a></center></td>
                                                            <?php
                                                        }else{ ?>
                                                        <td>--</td>
                                                            <?php
                                                        }
                                                            ?>
                                                        <td <?= $estilo_mensaje_consulta;?>><?= $mensaje_consulta;?></td>
                                                        <td>
                                                            <a id="btn_consultar<?= $al->id_envio_resumen;?>" type="button" title="Consultar Resumen Diario" class="btn btn-sm btn-success btne" style="color: white" onclick="preguntar('¿Está seguro que desea enviar Consultar este Resumen Diario?','consultar_ticket_resumen','Si','No',<?= $al->id_envio_resumen;?>)"><i class="fa fa-cloud-download"></i></a>
                                                            <a target="_blank" type="button" title="Ver Comprobates" class="btn btn-sm btn-primary btne" href="{{route('facturacion.detalle_resumen',$al->id_envio_resumen)}}" ><i class="fa fa-eye ver_detalle"></i></a>
                                                        </td>
                                                    </tr>
                                                        <?php
                                                        $a++;
                                                    }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
{{--                                        <div class="row" style="display: none">--}}
{{--                                            <div class="col-lg-12 text-center">--}}
{{--                                                <a class="btn btn-success" id="btn_exportar" target="_blank" href="{{url('facturacion/excel_resumen_diario/'.$fecha_inicio1.'/'.$fecha_final1)}}"><i class="fa fa-file-excel-o"> Descargar Excel </i></a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can($opciones[2]->opciones_funcion)
            <div id="vista_para_opciones_{{$opciones[2]->id_opciones}}" class="tab-pane fade show  " role="tabpanel" aria-labelledby="opciones_{{$opciones[2]->id_opciones}}" >

                <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                    <div class="card">
                        <form action="{{route('facturacion.historial_envios')}}" method="post">
                            @csrf
                            <div class="row m-2">
                                <input type="hidden" name="enviar_registro3" id="enviar_registro3" value="1">
                                <div class="col-lg-3 col-md-5 col-sm-12 mb-1 d-flex align-items-center justify-content-around">
                                    <label for="fecha_inicio_bajas">Desde :</label>
                                    <input type="date" name="fecha_inicio_bajas" id="fecha_inicio_bajas" class="form-control w-75" value="{{$fecha_inicio2}}">
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12 mb-1 d-flex align-items-center justify-content-around">
                                    <label for="fecha_final_bajas">Hasta :</label>
                                    <input type="date" name="fecha_final_bajas" id="fecha_final_bajas" class="form-control w-75" value="{{$fecha_final2}}">
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-12 mb-1 d-flex align-items-center">
                                    <button class="btn btn-sm text-white bg-primary w-100" type="submit"> <i class="fa fa-search"></i> Buscar Datos</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card ">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card-body table-responsive ">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <table class="table table-hover " id="dataTable3">
                                                <thead>
                                                <tr class="color_tabla">
                                                    <th>#</th>
                                                    <th>Fecha de Emisión</th>
                                                    <th>Fecha de Comprobantes</th>
                                                    <th>Serie Y Correlativo</th>
                                                    <th>Forma de Pago</th>
{{--                                                    <th>Tipo de Pago</th>--}}
{{--                                                    <th>Moneda</th>--}}
                                                    <th>XML</th>
                                                    <th>CDR</th>
                                                    <th>Estado Sunat</th>
                                                    <th>Datos del Comprobante Anulado</th>
                                                </tr>
                                                </thead>
                                                @if($filtro3)
                                                    <tbody>
                                                        <?php
                                                        $a = 1;
                                                        $total = 0;
                                                        $estilo_mensaje_consulta = "";
                                                    foreach ($ventas3 as $al){
                                                        $stylee="style= 'text-align: center;'";

                                                        if($al->venta_anulado_estado_sunat == NULL){
                                                            $mensaje_consulta = "";
                                                        }else{
                                                            $mensaje_consulta = $al->venta_anulado_estado_sunat;
                                                            $estilo_mensaje_consulta = "style= 'color: green; font-size: 14px;'";
                                                        }
                                                        ?>
                                                    <tr <?= $stylee?>>
                                                        <td><?= $a;?></td>
                                                        <td><?= date('d-m-Y H:i:s', strtotime($al->venta_anulado_datetime));?></td>
                                                        <td><?= date('d-m-Y', strtotime($al->venta_anulado_fecha));?></td>
                                                        <td><?= $al->venta_anulado_serie. '-' .$al->venta_anulado_correlativo;?></td>
                                                        <td><?= $al->id_formas_pago == 1 ? 'CONTADO' : 'CREDITO';?></td>
{{--                                                        <td>--}}
{{--                                                            @foreach($al->tipo_pago as $d)--}}
{{--                                                                    ✅<?= $d->tipo_pago_nombre;?>--}}
{{--                                                            @endforeach--}}
{{--                                                        </td>--}}
{{--                                                        <td>{{$al->id_moneda == 1 ? 'SOLES':'DÓLARES'}}</td>--}}
                                                            <?php
                                                        if(file_exists($al->venta_anulado_rutaXML)){ ?>
                                                        <td><center><a type="button" target='_blank' title="XML" href="{{asset($al->venta_anulado_rutaXML)}}" style="color: blue" ><i class="fa fa-file-text"></i></a></center></td>
                                                            <?php
                                                        }else{ ?>
                                                        <td>--</td>
                                                            <?php
                                                        }
                                                        if(file_exists($al->venta_anulado_rutaCDR)){ ?>
                                                        <td><center><a type="button" target='_blank' title="CDR" href="{{asset($al->venta_anulado_rutaCDR)}}" style="color: green" ><i class="fa fa-file"></i></a></center></td>
                                                            <?php
                                                        }else{ ?>
                                                        <td>--</td>
                                                            <?php
                                                        }
                                                            ?>
                                                        <td <?= $estilo_mensaje_consulta;?>><?= $mensaje_consulta;?></td>
                                                        <td>
                                                            <a target="_blank" type="button" title="Ver detalle" href="{{route('Gestionventas.venta_detalle', ['venta_id'=>$al->id_venta] )}}"><?= $al->venta_serie.'-'.$al->venta_correlativo;?></a>
                                                        </td>
                                                    </tr>
                                                        <?php
                                                        $a++;
                                                    }
                                                        ?>
                                                    </tbody>
                                                @endif

                                            </table>
                                        </div>
                                    </div>
                                    <br>
{{--                                    <div class="row" style="display: none">--}}
{{--                                        <div class="col-lg-12 text-center">--}}
{{--                                            <a class="btn btn-success" id="btn_exportar" target="_blank" href="{{url('facturacion/excel_baja_facturas/'.$fecha_inicio1.'/'.$fecha_final1)}}"><i class="fa fa-file-excel-o"> Descargar Excel </i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endcan

    </div>
    <script src="{{asset('js/domain.js')}}"></script>
    <script src="{{asset('js/facturacion.js')}}"></script>
@endsection
