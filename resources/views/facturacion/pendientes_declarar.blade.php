@extends('layouts.plantilla')
@section('content')
    <div class="tab-content">
        @can($opciones[0]->opciones_funcion)
            {{-- tab 1--}}
            <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" >
                <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                    <div class="card">
                        <form action="{{route('facturacion.pendiente_declarar')}}" method="post">
                            @csrf
                            <div class="row m-2">
                                <input type="hidden" name="enviar_registro" id="enviar_registro" value="1">
                                <div class="col-lg-2 col-md-3 col-sm-12 mb-1">
                                    <small >Tipo de Venta</small>
                                    <select name="tipo_venta" id="tipo_venta" class="form-control ">
                                        <option <?= ($tipo_venta == "")?'selected':''; ?> value="">TODOS</option>
                                        <option <?= ($tipo_venta == "03")?'selected':''; ?> value="03">BOLETA</option>
                                        <option <?= ($tipo_venta == "01")?'selected':''; ?> value="01">FACTURA</option>
                                        <option <?= ($tipo_venta == "07")?'selected':''; ?> value= "07">NOTA DE CRÉDITO</option>
                                        <option <?= ($tipo_venta == "08")?'selected':''; ?> value= "08">NOTA DE DÉBITO</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-12 mb-1">
                                    <label for="fecha_inicio">Desde :</label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control " value="{{$fecha_inicio}}">
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-12 mb-1">
                                    <small >Hasta :</small>
                                    <input type="date" name="fecha_final" id="fecha_final" class="form-control " value="{{$fecha_final}}">
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-12 d-flex align-items-center">
                                    <button class="btn btn-sm text-white bg-primary w-100" type="submit"> <i class="fa fa-search"></i> Buscar Datos</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card ">
                        <div class="row">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-sm-12 mt-3 mb-3">
                                        <label for="" style="color: black;">COMPROBANTES SIN ENVIAR: <span style="color: red;"><?= $ventas_cant ;?></span><br>
                                            <span style="font-size: 12px;">* ENVIAR MÁXIMO 3 DIAS DESPUES LA FECHA DE EMISIÓN</span></label>
                                    </div>
                                </div>
                            </div>
                            @if($filtro)
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card-header py-3">
                                        <h5>TIPO COMPROBANTE: <span class='text-uppercase font-weight-bold'>
                                <?php
                                                    if($tipo_venta == "03"){
                                                        echo "BOLETA";
                                                    }elseif($tipo_venta == "01"){
                                                        echo "FACTURA";
                                                    }elseif($tipo_venta == "07"){
                                                        echo "NOTA DE CRÉDITO";
                                                    }elseif($tipo_venta == "08"){
                                                        echo "NOTA DE DÉBITO";
                                                    }else{
                                                        echo 'TODOS';
                                                    }
                                                    ?></span>
                                            | FECHA DEL: <span><?= (($fecha_inicio != ""))?date('d-m-Y', strtotime($fecha_inicio)):'--'; ?></span> AL <span><?= (($fecha_final != ""))?date('d-m-Y', strtotime($fecha_final)):'--'; ?></span>
{{--                                            | Total SOLES: <span id="total_soles"></span>--}}
                                        </h5>
                                    </div>
                                    <div class="card-body table-responsive ">
                                        <div class="row">

                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <table class="table table-hover " id="dataTable1">
                                                    <thead>
                                                    <tr class="color_tabla">
                                                        <th>#</th>
                                                        <th>Fecha de Emisión</th>
                                                        <th>Comprobante</th>
                                                        <th>Serie y Correlativo</th>
                                                        <th>Cliente</th>
                                                        <th>Forma de Pago</th>
                                                        <th>Tipo de Pago</th>
{{--                                                            <th>Moneda</th>--}}
                                                        <th>Total</th>
                                                        <th>PDF</th>
                                                        <th>Estado Sunat</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody >
                                                        <?php
                                                        $a = 1;
                                                        $total = 0;
                                                        $total_soles = 0;
                                                    foreach ($ventas as $al){
                                                        $stylee="style= 'text-align: center;'";
                                                        if ($al->anulado_sunat == 1){
                                                            $stylee="style= 'text-align: center; text-decoration: line-through'";
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
                                                            /*if(($al->anulado_sunat == 0 AND $al->venta_codigo_motivo_nota != "01")){
                                                                $total_soles = round($total_soles - $al->venta_total, 2);
                                                            }*/
                                                        }elseif($al->venta_tipo == "08"){
                                                            $tipo_comprobante = "NOTA DE DÉBITO";
                                                            if($al->anulado_sunat == 0){
                                                                $total_soles = round($total_soles + $al->venta_total, 2);
                                                            }
                                                        }else{
                                                            $tipo_comprobante = "--";
                                                        }
                                                        $estilo_mensaje = "style= 'color: red; font-size: 14px;'";
                                                        if($al->venta_respuesta_sunat == NULL){
                                                            $mensaje = "Sin Enviar a Sunat";

                                                        }else{
                                                            $mensaje = $al->venta_respuesta_sunat;
                                                        }
                                                        if($al->id_tipo_documento == 4){
                                                            $cliente = $al->cliente_razonsocial;
                                                        }else{
                                                            $cliente = $al->cliente_nombre;
                                                        }
                                                        ?>
                                                    <tr id="venta_<?= $al->id_venta ;?>" <?= $stylee?>>
                                                        <td><?= $a;?> <input type="hidden" id="valor_<?= $a;?>" value="<?= $al->id_venta;?>"> </td>
                                                        <td>
                                                                <?= date('d-m-Y', strtotime($al->venta_fecha));?><br>
                                                                <?= date('H:i:s', strtotime($al->venta_fecha));?>
                                                        </td>
                                                        <td><?= $tipo_comprobante;?></td>
                                                        <td><?= $al->venta_serie. '-' .$al->venta_correlativo;?></td>
                                                        <td>
                                                                <?= $al->cliente_numero;?><br>
                                                                <?= $cliente;?>
                                                        </td>
                                                        <td><?= $al->id_formas_pago == 1 ? 'CONTADO' : 'CREDITO';?></td>
                                                        <td>
                                                            @if(count($al->tipo_pago) > 0)
                                                                @foreach($al->tipo_pago as $d)
                                                                    ✅<?= $d->tipo_pago_nombre;?>
                                                                @endforeach
                                                            @else
                                                                --
                                                            @endif
                                                        </td>
{{--                                                            <td>{{$al->id_moneda == 1 ? 'SOLES':'DÓLARES'}}</td>--}}
                                                        <td>
                                                            <?= $al->simbolo.' '.$al->venta_total;?>
                                                        </td>
                                                        <td>
                                                            <a type="button" target='_blank' href="{{route('Gestionventas.imprimir_ticket_pdf', ['venta_id'=>$al->id_venta])}}" style="color: red" ><i class="fa-regular fa-file-pdf"></i> </a>
                                                        </td>
                                                        <td <?= $estilo_mensaje;?>><?= $mensaje;?></td>
                                                        <td style="text-align: left">
                                                            <a target="_blank" type="button" title="Ver detalle" class="btn btn-sm btn-primary" style="color: white" href="{{route('Gestionventas.venta_detalle', ['venta_id'=>$al->id_venta])}}" ><i class="fa fa-eye ver_detalle"></i></a>
                                                            {{--                                                            <a type="button" title="Enviar Correo" data-toggle="modal" data-target="#enviar_correo_al_cliente" onclick="poner_id_venta(<?= $al->id_venta ;?>);" class="btn btn-sm btn-success" style="color: white"  ><i class="fa fa-envelope-o ver_detalle"></i></a>--}}
                                                                <?php
                                                            if($al->anulado_sunat == "0" && ($al->venta_tipo_envio == "0" || $al->venta_tipo_envio == "1") && $al->venta_tipo != '03'){ ?>
                                                            <a id="btn_enviar<?= $al->id_venta;?>" type="button" title="Enviar a Sunat" class="btn btn-sm btn-success btne" style="color: white" onclick="preguntar('¿Está seguro que desea enviar a la Sunat este Comprobante?','enviar_comprobante_sunat','Si','No',<?= $al->id_venta ;?>)"><i class="fa fa-check margen"></i></a>
                                                                <?php
                                                            }
                                                            if(($al->venta_tipo == "03" || $al->venta_tipo == "01") and $al->anulado_sunat == "0"){
                                                                ?>
                                                                <a type="button" title="Anular" id="btn_anular_anular_<?= $al->id_venta;?>" onclick="preguntar('¿Está seguro que desea anular este Comprobante?','anular_boleta_cambiarestado','Si','No',<?= $al->id_venta ;?>,1)" class="btn btn-sm btn-danger btne" style="color: white" ><i class="fa fa-ban"></i></a>
{{--                                                                <a type="button" title="Anular" id="btn_anular_anular<?= $al->id_venta;?>" data-bs-toggle="modal" data-bs-target="#modal_anularventa" onclick="llenarcampos_anularventa('<?= $al->id_venta;?>', 1)" class="btn btn-sm btn-danger btne" style="color: white" ><i class="fa fa-ban"></i></a>--}}
                                                                <?php
//                                                                $buscar_cant_pago = $this->ventas->buscar_cant_pago($al->id_venta);
//                                                            if($al->cant_pago==1){
                                                                ?>
                                                            {{--                                                            <a id="btn_edittp<?= $al->id_venta;?>" class="btn btn-sm btn-secondary" onclick="id_venta_(<?= $al->id_venta;?>,'<?= $al->tipo_pago_nombre?>')" type="button" data-toggle="modal" data-target="#editar_tipo_pago" title="EDITAR TIPO PAGO"><i class="fa fa-edit text-white"></i></a>--}}
                                                                <?php
//                                                            }
                                                                ?>
                                                                <?php
                                                            }else{
                                                            if($al->anulado_sunat == "1"){ ?>
                                                            <h5 style="color: red">ANULADO, ir a resumen diario para enviar a sunat</h5>
                                                                <?php
                                                            }
                                                            }
                                                                //boton para cambiar de estado si sale error 1033 (informado anteriormente)
                                                                $error1 = '1033';
                                                                $error2 = '1032';
                                                                $respuesta = $al->venta_respuesta_sunat;
                                                                $error1033 = strrpos($respuesta, $error1);
                                                                $error1032 = strrpos($respuesta, $error2);
                                                            if(!empty($error1033)){
                                                                ?>
                                                            <a target="_blank" type="button" id="btn_actualizar_estado<?= $al->id_venta;?>" title="Cambiar Estado" class="btn btn-sm btn-warning btne" style="color: white" onclick="cambiarestado_enviado(<?= $al->id_venta ?>)" ><i class="fa fa-circle-o-notch"></i></a>
                                                                <?php
                                                            }elseif(!empty($error1032)){
                                                                ?>
                                                            <a target="_blank" type="button" title="Cambiar Estado" id="btn_actualizar_estado<?= $al->id_venta;?>" class="btn btn-sm btn-warning btne" style="color: white" onclick="cambiarestado_anulado(<?= $al->id_venta ?>)" ><i class="fa fa-circle-o-notch"></i></a>
                                                                <?php
                                                            }
                                                                ?>
                                                        </td>
                                                    </tr>
                                                        <?php
                                                        $a++;
                                                        $total = $total + $al->venta_total;
                                                    }
                                                        ?>
                                                    </tbody>

                                                </table>
                                                <input type="hidden" id="numero_envio" value="<?= $a ?>">

                                            </div>

                                            <?php if ($tipo_venta =='01'){ ?>
                                            <div class="col-lg-12 text-center mt-4">
                                                <a style="color: white" class="btn btn-success" title="Envio masivo" onclick="preguntar('¿Esta seguro que desea enviar todo el Registro?','envio_masivo','SI','NO')"><i class="fa fa-upload"></i> Enviar ventas a Sunat</a>
                                            </div>
                                            <?php } ?>


                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can($opciones[1]->opciones_funcion)
         <div id="vista_para_opciones_{{$opciones[1]->id_opciones}}" class="tab-pane fade show  " role="tabpanel" aria-labelledby="opciones_{{$opciones[1]->id_opciones}}" >
             <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                 <div class="card">
                     <form action="{{route('facturacion.pendiente_declarar')}}" method="post">
                         @csrf
                         <div class="row m-2">
                             <input type="hidden" name="enviar_registro2" id="enviar_registro2" value="1">
                             <div class="col-lg-3 col-md-4 col-sm-6 mb-2 d-flex align-items-center justify-content-around">
                                 <label for="fecha_hoy">Desde :</label>
                                 <input type="date" name="fecha_hoy" id="fecha_hoy" class="form-control w-75" value="{{$fecha_hoy}}">
                             </div>
                             <div class="col-lg-2 col-md-4 col-sm-4 mb-2 d-flex align-items-center">
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
                                                 <th>Comprobante</th>
                                                 <th>Serie y Correlativo</th>
                                                 <th>Cliente</th>
                                                 <th>Forma de Pago</th>
                                                 <th>Tipo de Pago</th>
                                                 {{--                                                    <th>Moneda</th>--}}
                                                 <th>Total</th>
                                                 <th>PDF</th>
                                                 <th>Estado</th>
                                                 <th>Acción</th>
                                             </tr>
                                             </thead>
                                             @if($filtro2)
                                                 <tbody>
                                                     <?php
                                                     $a = 1;
                                                     $total = 0;
                                                 foreach ($ventas2 as $al){
                                                     $stylee="style= 'text-align: center;'";
                                                     if ($al->anulado_sunat == 1){
                                                         $stylee="style= 'text-align: center; text-decoration: line-through'";
                                                     }
                                                     if($al->venta_tipo == "03"){
                                                         $tipo_comprobante = "BOLETA";
                                                     }elseif ($al->venta_tipo == "01"){
                                                         $tipo_comprobante = "FACTURA";
                                                     }elseif($al->venta_tipo == "07"){
                                                         $tipo_comprobante = "NOTA DE CRÉDITO";
                                                     }elseif($al->venta_tipo == "08"){
                                                         $tipo_comprobante = "NOTA DE DÉBITO";
                                                     }else{
                                                         $tipo_comprobante = "--";
                                                     }
                                                     $estilo_mensaje = "style= 'color: red; font-size: 14px;'";
                                                     if($al->venta_respuesta_sunat == NULL){
                                                         $mensaje = "Sin Enviar a Sunat";

                                                     }else{
                                                         $mensaje = $al->venta_respuesta_sunat;
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
                                                     <td><?= $tipo_comprobante;?></td>
                                                     <td><?= $al->venta_serie. '-' .$al->venta_correlativo;?></td>
                                                     <td>
                                                             <?= $al->cliente_numero;?><br>
                                                             <?= $cliente;?>
                                                     </td>
                                                     <td><?= $al->id_formas_pago == 1 ? 'CONTADO' : 'CREDITO';?></td>
                                                     <td>
                                                         @foreach($al->tipo_pago as $d2)
                                                             ✅<?= $d2->tipo_pago_nombre ;?>
                                                         @endforeach
                                                     </td>
                                                     {{--                                                        <td>{{$al->id_moneda == 1 ? 'SOLES':'DÓLARES'}}</td>--}}
                                                     <td><?= $al->simbolo.' '.$al->venta_total;?></td>
                                                     <td>
                                                         <a type="button" target='_blank' href="{{route('Gestionventas.imprimir_ticket_pdf', ['venta_id'=>$al->id_venta])}}" style="color: red" ><i class="fa-regular fa-file-pdf"></i> </a>
                                                     </td>
                                                     <td <?= $estilo_mensaje;?>><?= $mensaje;?></td>
                                                     <td>
                                                         <a target="_blank" type="button" class="btn btn-sm btn-primary btne" title="Ver detalle" href="{{route('Gestionventas.venta_detalle', ['venta_id'=>$al->id_venta])}}" ><i class="fa fa-eye ver_detalle"></i></a>
                                                     </td>
                                                 </tr>
                                                     <?php

                                                 }
                                                     ?>
                                                 </tbody>
                                             @endif

                                         </table>
                                     </div>
                                 </div>
                             </div>
                             @if($filtro2)
                                 <div class="card-footer">
                                     <div class="row">
                                         <div class="col-lg-12" style="text-align: right;">
                                             <input type="hidden" id="fecha_post" name="fecha_post" value="<?= $fecha_hoy ?>">
                                             <a type="button" style="margin-top: 10px; color: white;" id="boton_enviar_resumen" class="btn btn-success " onclick="preguntar('¿Está seguro que desea enviar a la Sunat este Comprobante?','crear_enviar_resumen_sunat','Si','No')">Enviar Resumen Diario</a>
                                         </div>
                                     </div>
                                 </div>
                             @endif
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

