@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
    <style>
        .ancho_card_{
            height: 200px;
            width: 60%;
            border-radius: 24px;
            background: white;
            margin-top: -30px;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        }
        .border_numero{
            position: absolute;
            width: 50px!important;
            height: 50px!important;
            background: #ecf0f6!important;
            border-radius: 50px!important;
            display: flex!important;
            justify-content: center!important;
            align-items: center;
            font-size: 20px!important;
            font-weight: 600;
            margin-left: -25px;
            bottom: 65px;
        }
    </style>


    <div class="modal fade" id="modalCorreoVenta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Envío del comprobante por correo electrónico.</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormularioEnviarComprobanteEmail"  method="POST" enctype = "multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="correoDestino"><i class="fa-solid fa-envelope"></i> Correo de destino</label>
                                <input type="email" name="correoDestino" id="correoDestino" class="form-control" placeholder="Ingrese Información...">
                                <input type="hidden" name="id_venta" id="id_venta" class="form-control" value="{{$venta->id_venta}}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="envirMensaje">Enviar <i class="fa-regular fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="tab-content">
        @can($opciones[0]->opciones_funcion)
        {{-- tab 1--}}
        <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" >
            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="card">
                    <div class="row m-2">
                        <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-center">
                            <?php if($venta->venta_cancelar == 1){
                            ?>
                            <p style="color: green; margin: 0px"><i class="fa fa-check-circle"></i> Pago Realizado Correctamente</p>
                                <?php
                                $fecha_hoy = date('Y-m-d');
                                $fecha_creacion = date('Y-m-d H:i:s', strtotime($venta->venta_fecha));
                            } else {
                                ?>
                            <p style="color: red; float: right;margin: 0px"><i class="fa fa-times-circle"></i> Esta Venta fue ANULADA</p>
                                <?php
                            }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                   <div class="card-body">
                       <div class="row mt-5 mb-5  justify-content-center" >
                           <div class="col-lg-5 col-md-12 col-sm-12 ">
                               <div style="background: #ecf0f6;height: auto;border-radius: 24px;">
                                   <div class="d-flex justify-content-center ">
                                       <div class="ancho_card_" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;height: auto">
                                           <div class="card-body">
                                               <div class="row">
                                                   <div class="col-lg-12 col-md-12 col-sm-12 mt-3" id="nombre_client_web" style="color: #3cb815">
                                                       <i class="fa fa-user"></i > {{$venta->id_tipo_documento == 4 ?  $venta->cliente_razonsocial : $venta->cliente_nombre}}
                                                   </div>
                                                   <div class="col-lg-12 col-md-12 col-sm-12 mt-3" id="num_document_client_web" style="color: #3cb815">
                                                       <i class="fa fa-credit-card-alt"></i > <?= $venta->cliente_numero;?>
                                                   </div>
                                                   <div class="col-lg-12 col-md-12 col-sm-12 mt-3" id="phone_client_web" style="color: #3cb815">
                                                       <i class="fa fa-map-location"></i > <?= $venta->cliente_direccion;?>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="card-body">
                                       <div class="row">
                                           <div class="col-lg-12 col-md-12 col-sm-12 mt-1 mb-1">
                                               <div class="row "  >
                                                   <div class="col-lg-12 d-flex align-items-center justify-content-center mt-1 mb-1">
                                                       <h4>{{$empresa->empresa_nombrecomercial}}</h4>
                                                   </div>
                                                   <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                       <label class="venta_titulo_tich">Numero de orden</label>
                                                       <p style="margin: 0px"><b><?= $venta->venta_serie. "-" .$venta->venta_correlativo; ?></b></p>
                                                   </div>
                                                   <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                       <label class="venta_titulo_tich">Moneda</label>
                                                       <b class="cambiar_tipo_moneda_nombre">{{$venta->id_moneda == 1 ? 'Soles' : 'Dolar'}}</b>
                                                   </div>
                                                   <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                       <label class="venta_titulo_tich">Fecha de Pago:</label>
                                                       <b class="cambiar_tipo_moneda_nombre"><?= date("d-m-Y H:i:s", strtotime($venta->venta_fecha));?></b>
                                                   </div>
                                                   <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                       <label class="venta_titulo_tich">Forma de Pago:</label>
                                                       <b class="cambiar_tipo_moneda_nombre"><?= $venta->id_formas_pago == 1 ?  'CONTADO' : 'CREDITO' ?></b>
                                                   </div>
                                                   @if($venta->venta_totaldescuento > 0)
                                                       <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                           <label class="venta_titulo_tich">Porcentaje de Descuento :</label>
                                                           @php $e = explode('.',$venta->venta_descuento_global) @endphp
                                                           <b class="cambiar_tipo_moneda_nombre"><?= $e[1]?>%</b>
                                                       </div>
                                                       <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                           <label class="venta_titulo_tich">Descuento Total :</label>
                                                           <b class="cambiar_tipo_moneda_nombre"><?= $venta->venta_totaldescuento ?></b>
                                                       </div>
                                                   @endif
                                                   @if(count($cuotas) > 0)
                                                       <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                           <label class="venta_titulo_tich">Cantidad de cuotas :</label>
                                                           <b class="cambiar_tipo_moneda_nombre"><?= count($cuotas)?></b>
                                                       </div>
                                                       <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                           <label class="venta_titulo_tich">Estado de venta :</label>
                                                           @if($venta->venta_estado_pago == 0)
                                                               <b class="cambiar_tipo_moneda_nombre text-danger">Sin Pago</b>
                                                           @elseif($venta->venta_estado_pago == 1)
                                                               <b class="cambiar_tipo_moneda_nombre text-warning">Parcialmente pagado</b>
                                                           @else
                                                               <b class="cambiar_tipo_moneda_nombre text-success">Pagado</b>
                                                           @endif
                                                       </div>
                                                   @endif
                                                   {{--                                                <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">--}}
                                                   {{--                                                    <label class="venta_titulo_tich">Costo de envío a agencia</label>--}}
                                                   {{--                                                    <b id="costo_envio_agencia">Gratis</b>--}}
                                                   {{--                                                </div>--}}
                                                   <div class="col-lg-12 d-flex align-items-center mt-2 mb-2">
                                                       <label class="venta_titulo_tich">Productos :</label>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-lg-12 col-md-12 col-sm-12">
                                               <div class="row h-auto" id="con_items_product">
                                                   @php $a = 0.00 @endphp
                                                   @foreach($detalle_venta as $item)
                                                       <div class="col-lg-12 d-flex align-items-center justify-content-between mt-1 mb-1">
                                                           <label class="venta_titulo_tich">{{$item->venta_detalle_nombre_producto}}</label>
                                                           <b>{{$item->venta_detalle_precio_unitario}} <b style="font-size: 11px">x {{$item->venta_detalle_cantidad}}</b></b>
                                                       </div>
                                                       @php
                                                           $a += $item->venta_detalle_cantidad * $item->venta_detalle_precio_unitario
                                                       @endphp
                                                   @endforeach
                                               </div>
                                           </div>
                                           <div class="col-lg-12 col-md-12 col-sm-12">
                                               <div class="row" >
                                                   <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                       <div class="redondos_ti"></div>
                                                       <div class="fi"></div>
                                                       <div class="redondos_ti_r"></div>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-lg-12 col-md-12 col-sm-12">
                                               <div class="row" >
                                                   <div class="col-lg-7 col-md-5 col-sm-6" style="flex-direction: column;display: flex;justify-content: center">
                                                       <label class="venta_titulo_tich" >Monto Pagado</label>
                                                       <div class="d-flex align-items-center">
                                                           @if($venta->venta_totaldescuento > 0)
                                                               <b class="me-1" style="font-size: 30px;color: #3cb815" id="total_cantidad__moneda">{{number_format($venta->venta_total, 2, '.', '')}}</b><del>{{number_format($venta->venta_total+$venta->venta_totaldescuento, 2, '.', '')}}</del>
                                                           @else
                                                               <b class="me-1" style="font-size: 30px;color: #3cb815" id="total_cantidad__moneda">{{number_format($venta->venta_total, 2, '.', '')}}</b>
                                                           @endif
                                                           <label class="venta_titulo_tich cambiar_tipo_moneda">{{$venta->id_moneda == 1 ? 'PEN' : 'USD'}} </label>
                                                       </div>
                                                   </div>
                                                   <div class="col-lg-5 col-md-7 col-sm-6 text-end">
                                                       <img src="{{asset($ruta_qr)}}" alt="" class="w-50">
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="col-lg-5 col-md-12 col-sm-12 d-flex align-items-center justify-content-center flex-column">
                               <div class="container">
                                   <div class="row">
                                       @if(count($cuotas) > 0)
                                           <div class="col-lg-12 col-md-12 col-sm-12">
                                               <div class="row">
                                                   <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                                       <div class="card-header w-100">
                                                           <h3 class="text-primary">Cantidad de cuotas <b>{{count($cuotas)}}</b></h3>
                                                           <div class="d-flex align-items-center justify-content-between mt-3">
                                                               <div class="d-flex align-items-center">
                                                                   <div class="circulo_div bg-danger me-2"></div> Sin Pago
                                                               </div>
                                                               <div class="d-flex align-items-center">
                                                                   <div class="circulo_div bg-success me-2"></div> Pagado
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                                       <div class="card-body w-100">
                                                           <div class="row">
                                                               @php $a=1; @endphp
                                                               @foreach($cuotas as $cu)
                                                                   <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                                                       <div class="card {{$cu->venta_cuota_pago == 1 ? 'bg-success' : 'bg-danger'}} w-100" >
                                                                           <div class="border_numero">{{$a}}</div>
                                                                           <div class="card-body ">
                                                                               <h3 class="text-white m-0 mb-2">{{$venta->id_moneda == 1 ? 'S/' : '$'}} {{$cu->venta_cuota_importe}}</h3>
                                                                               <span class="text-white mt-4"><i class="fa-solid fa-clock  text-white"></i> {{date('d-m-Y', strtotime( $cu->venta_cuota_fecha))}}</span>
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                                   @php $a++ @endphp
                                                               @endforeach
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       @endif
                                       <div class="col-lg-12 col-md-12 col-sm-12">
                                           <div class="row mt-4 mb-3" style="background: #ecf0f6;border-radius: 24px">
                                               <div class="card-body">
                                                   <div class="row">
                                                       @if($venta->venta_totalgratuita > 0)
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h6 style="margin: 0px">OP. GRATUITA:</h6>
                                                           </div>
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h5>S/. <?php echo number_format($venta->venta_totalgratuita ,2);?></h5>
                                                           </div>
                                                       @endif
                                                       @if($venta->venta_totalinafecta > 0)
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h6 style="margin: 0px">OP. INAFECTA:</h6>
                                                           </div>
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h5>S/. <?php echo number_format($venta->venta_totalinafecta ,2);?></h5>
                                                           </div>
                                                       @endif
                                                       @if($venta->venta_totalgravada > 0)
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h6 style="margin: 0px">OP. GRAVADA:</h6>
                                                           </div>
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h5>S/. <?php echo number_format($venta->venta_totalgravada , 2);?></h5>
                                                           </div>
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h6 style="margin: 0px">IGV:</h6>
                                                           </div>
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h5>S/. <?php echo number_format($venta->venta_totaligv , 2);?>
                                                               </h5>
                                                           </div>
                                                       @endif
                                                       <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                           <h6 style="margin: 0px">OP. EXONERADA:</h6>
                                                       </div>
                                                       <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                           <h5>{{$venta->id_moneda == 1 ? 'S/.' : '$'}} <?php echo number_format($venta->venta_totalexonerada ,2);?></h5>
                                                       </div>
                                                       @if($venta->venta_icbper > 0)
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h6 style="margin: 0px">OP. ICBPER:</h6>
                                                           </div>
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h5>{{$venta->id_moneda == 1 ? 'S/.' : '$'}} <?php echo number_format($venta->venta_icbper , 2);?></h5>
                                                           </div>
                                                       @endif

                                                       <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                           <h6 style="margin: 0px">PRECIO TOTAL:</h6>
                                                       </div>
                                                       <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                           <h4 class="text-danger">{{$venta->id_moneda == 1 ? 'S/.' : '$'}} <?php echo number_format($venta->venta_total ,2);?></h4>
                                                       </div>
                                                       @if($venta->venta_pago_cliente > 0)
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h6 style="margin: 0px">PAGÓ CON:</h6>
                                                           </div>
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h4 >{{$venta->id_moneda == 1 ? 'S/.' : '$'}} <?php echo number_format($venta->venta_pago_cliente ,2);?></h4>
                                                           </div>
                                                       @endif
                                                       @if($venta->venta_pago_cliente > 0)
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h6 style="margin: 0px">VUELTO:</h6>

                                                           </div>
                                                           <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                                               <h5>{{$venta->id_moneda == 1 ? 'S/.' : '$'}} <?php echo number_format($venta->venta_vuelto , 2);?></h5>
                                                           </div>
                                                       @endif


                                                           <?php
                                                       if($venta->venta_tipo == "07" || $venta->venta_tipo == "08"){
                                                           if($venta->venta_tipo == "07"){
                                                               $descripcion_nota = $venta->des;
                                                           }else{
                                                               $descripcion_nota = $venta->des;
                                                           }
                                                           if($venta->tipo_documento_modificar == "03"){
                                                               $tipo = "BOLETA";
                                                           }else{
                                                               $tipo = "FACTURA";
                                                           }
                                                           ?>
                                                       <div id="espacio" class = "col-lg-12 col-sm-6 col-md-6" style="font-size: 12px;">
                                                           <label for="">TIPO DE COMPROBANTE AFECTADA: <span><?= $tipo;?></span></label><br>
                                                           <label for="">SERIE AFECTADA: <span><?= $venta->serie_modificar;?></span></label><br>
                                                           <label for="">CORRELATIVO AFECTADO: <span><?= $venta->correlativo_modificar;?></span></label><br>
                                                           <label for="">MOTIVO: <span><?= $descripcion_nota;?></span></label>
                                                       </div>
                                                           <?php
                                                       } ?>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-lg-12 col-md-12 col-sm-12">
                                           <div class="d-flex align-items-center justify-content-center flex-column w-100">
                                               <a class="btn text-white bg-primary w-50 mb-2" href="{{route('Gestionventas.imprimir_ticket_pdf',['venta_id'=>$venta->id_venta])}}" target="_blank"><i class="fa-solid fa-file-pdf"></i> Imprimir en PDF</a>
                                               <a class="btn text-white bg-success w-50 mb-2" href="{{route('Gestionventas.imprimir_ticketera_venta',['venta_id'=>$venta->id_venta])}}"  target="_blank"><i class="fa-solid fa-ticket"></i> Ticketera</a>
{{--                                               <button class="btn text-white bg-info w-50 mb-2"   data-bs-toggle="modal" data-bs-target="#modalCorreoVenta" ><i class="fa-solid fa-envelope"></i> Enviar por correo</button>--}}
                                               <a class="btn text-white bg-warning w-50 mb-2" href="{{route('Gestionventas.realizar_ventas')}}"  ><i class="fa-solid fa-arrow-rotate-left"></i> Regresar</a>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
    <script src="{{asset('js/domain.js')}}"></script>
    <script src="{{asset('js/gestionventas.js')}}"></script>
@endsection

