@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
    <div class="modal fade" id="modal_clientes_general_generar_nota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Lista de Clientes</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Dni / Ruc</th>
                                    <th>Dirección</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clientes as $c)
                                    <tr>
                                        <th>{{$c->id_tipo_documento == 2 ? $c->cliente_nombre :  $c->cliente_razonsocial}}</th>
                                        <th>{{$c->cliente_numero}}</th>
                                        <th>{{$c->cliente_direccion}}</th>
                                        <th>
                                            <button class="btn btn-primary text-white btn-sm"type="button" onclick="agregar_cliente_venta_generar_nota({{$c->id_tipo_documento}},'{{$c->cliente_nombre}}','{{$c->cliente_razonsocial}}','{{$c->cliente_numero}}','{{$c->cliente_direccion}}','{{$c->id_clientes}}')"><i class="fa fa-check"></i></button>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                            <p style="color: green; margin: 0px"><i class="fa fa-check-circle"></i> Notas de Crédito/Débito</p>
                        </div>
                    </div>
                </div>
            </div>
            <form id="formulario_generar_nota" class="mb-3"  method="POST" enctype = "multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p class="linea_titulo_general d-flex justify-content-between align-items-center">Cliente
                                                    <button class="btn btn-primary text-white btn-sm" type="button" style="margin-bottom: 2px" data-bs-toggle="modal" data-bs-target="#modal_clientes_general_generar_nota"><i class="fa fa-search"></i> Buscar Cliente</button>
                                                </p>
                                            </div>
                                            <input type="hidden" id="id_cliente" name="id_cliente" value="{{$venta->id_clientes}}">
                                            <input type="hidden" id="id_venta" name="id_venta" value="{{$venta->id_venta}}">
                                            <input type="hidden" id="id_tipo_documento_" name="id_tipo_documento_" value="{{$venta->id_tipo_documento}}">
                                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2 mb-3">
                                                <label for="cliente_nombre">Nombre</label>
                                                <input type="text" name="cliente_nombre" id="cliente_nombre" class="form-control" value="{{$venta->id_tipo_documento == 2 ? $venta->cliente_nombre : $venta->cliente_razonsocial}}">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2 mb-3">
                                                <label for="cliente_documento">DNI o RUC</label>
                                                <input type="text" name="cliente_documento" id="cliente_documento" class="form-control" value="<?= $venta->cliente_numero;?>">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2 mb-2">
                                                <label for="cliente_direccion">Dirección</label>
                                                <textarea name="cliente_direccion" id="cliente_direccion" class="form-control" cols="30" rows="2"><?= $venta->cliente_direccion;?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                            <p class="linea_titulo_general ">Datos de Nota</p>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12  mb-2 mt-2">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-12 col-sm-12">
                                                    <label for="tipo_venta">Tipo de Comprobante</label>
                                                    <select name="tipo_venta" id="tipo_venta" class="form-control" onchange = "selecttipoventa(this.value)">
                                                        <option value= "">Seleccionar...</option>
                                                        <option value= "07">NOTA DE CREDITO</option>
                                                        <option value= "08">NOTA DE DEBITO</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-md-12 col-sm-12">
                                                    <label for="serie_nota">Serie</label>
                                                    <select name="serie_nota" id="serie_nota" class="form-control">
                                                        <option value="">Seleccionar</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-md-12 col-sm-12">
                                                    <label for="numero_nota">Número</label>
                                                    <input type="text" class="form-control" name="numero_nota" id="numero_nota" readonly>
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12" id="descripcion_nota_tipo">

                                                </div>
                                                <div class="col-lg-2 col-md-12 col-sm-12">
                                                    <label for="tipo_moneda">Moneda</label>
                                                    <select class="form-control" id="tipo_moneda" name="tipo_moneda">
                                                        <option value="1">SOLES</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p class="linea_titulo_general ">Datos a Modificar</p>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                                            <div class="row mt-3 mb-3">
                                                <div class="col-lg-3 col-md-12 col-sm-12 ">
                                                    <label for="id_tipo_pago">Tipo de Pago</label>
                                                    <select name="id_tipo_pago" id="id_tipo_pago" class="form-control">
                                                        <option value= "">Seleccionar...</option>
                                                        @foreach($tipo_pagos as $t)
                                                            <option value= "{{$t->id_tipo_pago}}" {{$t->id_tipo_pago == 1 ? "selected" : ""}}>{{$t->tipo_pago_nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12 ">
                                                    <label for="Tipo_documento_modificar">Documento a Modificar</label>
                                                    <select name="Tipo_documento_modificar" id="Tipo_documento_modificar" class="form-control">
                                                        <option <?= $venta->venta_tipo == '03'?'selected':'' ?> value="03">BOLETA</option>
                                                        <option <?= $venta->venta_tipo == '01'?'selected':'' ?> value="01">FACTURA</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 col-md-12 col-sm-12 ">
                                                    <label for="serie_modificar">Serie</label>
                                                    <input type="text" class="form-control" name="serie_modificar" id="serie_modificar" value="<?= $venta->venta_serie;?>" readonly>
                                                </div>

                                                <div class="col-lg-3 col-md-12 col-sm-12 ">
                                                    <label for="numero_modificar">Número</label><br>
                                                    <input type="text" class="form-control" name="numero_modificar" id="numero_modificar" value="<?= $venta->venta_correlativo;?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-md-12 ">
                                            <textarea name="pago_observacion" id="pago_observacion" class="form-control" placeholder="Observación" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2 mt-2">
                                        <input type="text" name="agg_generation_product" id="agg_generation_product" placeholder="Buscar Productos" class="form-control w-50 p-1">
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 mt-1">
                                        <div class="shadow" style="z-index: 999;position: absolute; width: 90%">
                                            <div class="list-group list-group-flush bg-white " id="list_producto_generate_note">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr class="color_tabla">
                                                <td>#</td>
                                                <td>PRODUCTO</td>
                                                <td>VALOR U.</td>
                                                <td>CANTIDAD</td>
                                                <td>TOTAL</td>
                                                <td>ACCIÓN</td>
                                            </tr>
                                            </thead>
                                            <tbody id="detalle_venta_nota">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="p-0 m-0">
                                    <li class="d-flex pb-1">
                                        <small class="text-muted d-block mb-1">Operaciones</small>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Op. Gravada</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="op_gravada_generar_nota">+00.0</h6>
                                                <span class="text-muted generar_nota_moneda">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">IGV</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="igv_generar_nota">+00.0</h6>
                                                <span class="text-muted generar_nota_moneda">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Op. Exoneradas</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="op_exoneradas_generar_nota">+00.0</h6>
                                                <span class="text-muted generar_nota_moneda">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Op. Inafectada</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="op_inafectada_generar_nota">+00.0</h6>
                                                <span class="text-muted generar_nota_moneda">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Op. Gratuitas</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="op_gratuitas_generar_nota">+00.0</h6>
                                                <span class="text-muted generar_nota_moneda">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">ICBPER</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="icbper">+0.00</h6>
                                                <span class="text-muted">PEN</span>
                                            </div>
                                        </div>
                                    </li>
{{--                                    <li class="d-flex mb-4 pb-1">--}}
{{--                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">--}}
{{--                                            <div class="me-2">--}}
{{--                                                <h6 class="mb-0">ICBPER</h6>--}}
{{--                                            </div>--}}
{{--                                            <div class="user-progress d-flex align-items-center gap-1">--}}
{{--                                                <h6 class="mb-0 color_negro" id="icbper_generar_nota">+0.00</h6>--}}
{{--                                                <span class="text-muted generar_nota_moneda">PEN</span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}

                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0 text-danger">TOTAL</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h4 class="mb-0 text-danger" id="total_venta_generar_nota">+00.00</h4>
                                                <span class="text-muted generar_nota_moneda">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <button class="btn w-100 bg-primary text-white" id="btn_guardar_registro_generar_nota">Guardar Registro</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endcan
    </div>
    <script src="{{asset('js/domain.js')}}"></script>
    <script src="{{asset('js/facturacion.js')}}"></script>
    <script>

        let arrayGN = JSON.parse('<?= $detalle_venta ?>')
        $(document).ready(function(){
            pintar_tabla_detalle_venta_generar_nota()
        })
        let tipo_moneda = document.getElementById('tipo_moneda');
        if(tipo_moneda && tipo_moneda.addEventListener){
            tipo_moneda.addEventListener('change',function (){
                    cambiar_no_moneda(this.id)
            });
        }
        function cambiar_no_moneda(id){
            let valor = $('#'+id).val();
            if(valor == 1){
                $('.generar_nota_moneda').html("PEN")
            }else{
                $('.generar_nota_moneda').html("USD")
            }
        }
        function agregar_cliente_venta_generar_nota(tipo_documento,nombre,razonsocial,num_docu = null,direccion = null ,id_cliente = null){
            // $('#tipo_comprobante').val(tipo_documento == 2 ? "03" : "01");
            $('#cliente_nombre').val(tipo_documento == 2 ? nombre : razonsocial);
            $('#id_tipo_documento_').val(tipo_documento);
            $('#cliente_documento').val(num_docu);
            $('#cliente_direccion').val(direccion);
            $('#id_cliente').val(id_cliente);
            $('#modal_clientes_general_generar_nota').modal('hide');
            Consultar_serie()

        }
    </script>
@endsection

