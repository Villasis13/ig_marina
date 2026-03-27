@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->

    <div class="tab-content">
        @can($opciones[0]->opciones_funcion)
        {{-- tab 1--}}
        <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" >
            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="card">
                    <div class="row m-2">
                        <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-center">
                            <p style="color: green; margin: 0px"><b>Serie y Correlativo  <?= $resumen->envio_resumen_serie .'-'. $resumen->envio_resumen_correlativo;?></b></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col--md12 col-sm-12">
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 text-center">
                                <p>Fecha de Comprobantes</p>
                                <p><?= date('m-d-Y', strtotime($resumen->envio_resumen_fecha));?></p>
                            </div>
                            <div class="col-lg-4 text-center">
                                <p>Fecha de Emisión</p>
                                <p><?= date('m-d-Y', strtotime($resumen->envio_sunat_datetime));?></p>
                            </div>
                            <div class="col-lg-4 text-center">
                                <p>Nº Ticket: <?= $resumen->envio_resumen_ticket;?></p>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
                                <table class="table table-hover " id="dataTable1">
                                    <thead>
                                    <tr class="color_tabla">
                                        <th>#</th>
                                        <th>Fecha de Emision</th>
                                        <th>Comprobante</th>
                                        <th>Serie y Correlativo</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Condición de Comprobante</th>
                                        <th>PDF</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a = 1;
                                        $total = 0;
                                    foreach ($detalle as $al){

                                        $stylee="style= 'text-align: center;'";

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
                                        if($al->venta_condicion_resumen == 1){
                                            $estilo_mensaje = "style= 'color: green; font-size: 14px;'";
                                            $mensaje = "REGISTRADO";
                                        }elseif($al->venta_condicion_resumen == 2){
                                            $estilo_mensaje = "style= 'color: blue; font-size: 14px;'";
                                            $mensaje = "MODIFICADO";
                                        }else{
                                            $mensaje = "ANULADO";
                                        }
                                        if($al->ven->id_tipo_documento == 4){
                                            $cliente = $al->ven->cliente_razonsocial;
                                        }else{
                                            $cliente = $al->ven->cliente_nombre;
                                        }                                            ?>
                                    <tr <?= $stylee?>>
                                        <td><?= $a;?></td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($al->venta_fecha));?></td>
                                        <td><?= $tipo_comprobante;?></td>
                                        <td><?= $al->venta_serie. '-' .$al->venta_correlativo;?></td>
                                        <td>
                                                <?=  $al->ven->cliente_numero;?><br>
                                                <?= $cliente;?>
                                        </td>
                                        <td>
                                                <?=  $al->ven->simbolo.' '.$al->venta_total;?>
                                        </td>
                                        <td <?= $estilo_mensaje;?>><?= $mensaje;?></td>
                                        <td><center><a type="button" target='_blank' title="Imprimir PDF" href="{{route('Gestionventas.imprimir_ticket_pdf', ['venta_id'=>$al->id_venta])}}" style="color: red" ><i class="fa fa-file-pdf"></i></a></center></td>
                                        <td>
                                            <a target="_blank" type="button" title="Ver detalle" class="btn btn-sm btn-primary btne" href="{{route('Gestionventas.venta_detalle',['venta_id'=> $al->id_venta])}}" ><i class="fa fa-eye ver_detalle"></i></a>
                                        </td>
                                    </tr>
                                        <?php
                                        $a++;
//                                            $total = $total + $al->pago_total;
                                    }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
@endsection

