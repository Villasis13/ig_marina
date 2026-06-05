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
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-5">
                            <h5 style="text-align: center">{{$orden_compra->orden_compra_titulo}}</h5>
                        </div>
                        <div class="col-md-4">
                            @if($orden_compra->orden_compra_estado == 1)
                                <h5 style="text-align: center">OC <?= $orden_compra->orden_compra_numero; ?></h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card ">
                    <div class="row p-3 mt-3">
                        <div class="col-lg-2 d-flex justify-content-center align-items-center">
                            <img alt="logo" src="{{asset($empresa->empresa_foto != null ? $empresa->empresa_foto : "sin-fotografia.png")}}" class="w-50">
                        </div>
                        <div class="col-lg-10">
                            <div class="row">
                                @if($orden_compra->orden_compra_estado==0)
                                    <h5 class="card-title">Detalle de Orden de Compra: Solicitante: <b><?= $orden_compra->nombre_users ?></b> | Fecha de Solicitud: <b><?= date("d-m-Y",strtotime($orden_compra->orden_compra_fecha)); ?></b>
                                        <br> | Descripción de la Solicitud: <?= $orden_compra->orden_compra_titulo?> | Total: <?= $total ?></h5>
                                @else
                                    <h3 class="card-title mb-4 mt-4">Empresa: <b class="text-primary"><?= $empresa->empresa_nombrecomercial;?></b></h3>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                                <h5 class="card-title "><i class="fa-solid fa-user text-primary"></i> Solicitante: </h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                                <b class="text-success"><?= $orden_compra->nombre_users;?></b>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                                <h5 class="card-title "><i class="fa-solid fa-list-check text-primary"></i> N° de Comprobante: </h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                                <b class="text-success">#<?= $orden_compra->orden_compra_numero_doc;?></b>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                                <h5 class="card-title "><i class="fa-solid fa-clock text-primary"></i> Fecha de emisión: </h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                                <b class="text-success"><?= date("d-m-Y H:i:s",strtotime($orden_compra->orden_compra_fecha)); ?></b>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                                <h5 class="card-title "><i class="fa-solid fa-person text-primary"></i> Proveedor: </h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                                <b class="text-success"><?= $orden_compra->proveedores_nombre;?></b>
                                            </div>
                                            @if($orden_compra->orden_compra_fecha_vencimiento)
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                                <h5 class="card-title "><i class="fa-solid fa-calendar-xmark text-primary"></i> Fecha de Vencimiento: </h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                                <b class="text-success"><?= date("d-m-Y", strtotime($orden_compra->orden_compra_fecha_vencimiento)); ?></b>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                            <h5 class="card-title "><i class="fa-solid fa-clipboard-list text-primary"></i> Comprobante: </h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                            <a href="{{asset($orden_compra->orden_compra_doc_adjuntado)}}">{{$orden_compra->orden_compra_tipo_doc}}</a>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                            <h5 class="card-title"><i class="fa-solid fa-handshake text-primary"></i> Condición: </h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                            <b class="text-success">{{ $orden_compra->orden_compra_condicion == 1 ? 'Crédito' : 'Contado' }}</b>
                                        </div>
                                        @if($orden_compra->orden_compra_guia_remicion)
                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                            <h5 class="card-title"><i class="fa-solid fa-file-lines text-primary"></i> Guía de Remisión: </h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                            <b class="text-success">{{ $orden_compra->orden_compra_guia_remicion }}</b>
                                        </div>
                                        @endif
                                        @if($orden_compra->orden_compra_guia_transportista)
                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                            <h5 class="card-title"><i class="fa-solid fa-truck text-primary"></i> Guía Transportista: </h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                                            <b class="text-success">{{ $orden_compra->orden_compra_guia_transportista }}</b>
                                        </div>
                                        @endif
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2 ">
                                            <h5 class="card-title"><i class="fa-solid fa-sack-dollar text-primary"></i> Total En <b class="text-warning">{{$orden_compra->tipo_pago_nombre}}</b>: </h5>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2 ">
                                            <h3 class="text-danger">S/ {{ number_format($total + $orden_compra->orden_compra_flete + $orden_compra->orden_compra_gastos_operativos, 2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <h5 class="card-title"><i class="fa-solid fa-comment text-primary"></i> Observación:</h5>
                                    <h3 class="">{{$orden_compra->orden_compra_observacion}}</h3>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-3 table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th>Familia</th>
                                        <th>Cantidad Solicitada</th>
                                        <th>Precio Unit</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $a =1; @endphp
                                @foreach($detalle_orden_compra as $de)
                                    <tr>
                                        <td>{{ $a }}</td>
                                        <td>
                                            {{ $de->detalle_orden_nombre_producto }}
                                            @if($de->pro_codigo)
                                                <br><small class="text-muted">{{ $de->pro_codigo }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($de->fa_nombre)
                                                {{ $de->familia_codigo }} - {{ $de->fa_nombre }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $de->detalle_compra_cantidad }}</td>
                                        <td>S/ {{ number_format($de->detalle_compra_precio_compra, 2) }}</td>
                                        <td>S/ {{ number_format($de->detalle_compra_total_pedido, 2) }}</td>
                                    </tr>
                                    @php $a++; @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <a href="javascript:history.back();" class="btn btn-warning text-left-white float-end"><i class="fa fa-history"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>

    <style>
        .button_dis{
            background: #0b1892;
            width: 50%;
            height: 20px;
            color: white;
            border-radius: 3px;
        }

        .button_regresar_a_insumos_normal{
            float: left;
            width: 24%;
            background: #009c8e;
            border-radius: 4px;
            text-align: center;
            color: white;
            text-decoration: none;
            margin-right: 18%;
        }
        .button_regresar_a_insumos_normal:hover{
            color: white
        }
        .button_agregar_stock{
            width: 6%;
            height: 20px;
            background: #0b1892;
            color: white;
            border-radius: 4px;
        }

    </style>

    <script>

        function validar_convertir(){
            let va = $('#convertir_producto').is(':checked')
            if(va == true)
            {
                $('#convertir_si').show();
            }
            else {
                $('#convertir_si').hide();
            }
        }
        function  convertir_cantidad(){
            let elegir = $('#elegir_convertir').val()
            if(elegir == "18")
            {
                $('.ver_1').show();
                $('.ver_2').hide();
                var cantidad = $('#cantidad_general').val();
                var convertir = cantidad * 1000;
                $('#resultado_final').val(convertir);
                $('.convertir_si').show();
            }else if(elegir == "41")
            {
                $('.ver_1').show();
                $('.ver_2').show();
                var cantidad = $('#cantidad_mililitros').val();
                var convertir = cantidad * 1;
                var resul = convertir / 30.00
                $('#resultado_final').val(resul);
                $('.convertir_si').show();
            }else if(elegir == "35")
            {
                $('.ver_1').show();
                $('.ver_2').hide();
                var cantidad = $('#cantidad_general').val();
                var convertir = cantidad * 1000;
                $('#resultado_final').val(convertir);
                $('.convertir_si').show();
            }else if(elegir == "58")
            {
                $('.ver_1').show();
                $('.ver_2').hide();
                $('.convertir_si').show();
            }
        }
        function spam_resta(id){
            var spam_auto = $('#'+id);
            var valor = spam_auto.val()
            if(valor > 1){
                valor--
            }else{
                valor = 1;
            }
            spam_auto.val(valor)
        }
        function spam_sumar(id){
            var spam_auto= $('#'+id);
            var valor = spam_auto.val()
            valor++
            spam_auto.val(valor)

        }
    </script>

@endsection

