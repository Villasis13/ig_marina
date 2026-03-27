



@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
    <div class="modal fade" id="modal_cuotas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Medio de Pago - Crédito</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 d-flex align-items-center justify-content-around">
                            <label >Total importe de cuotas :</label>
                            <h4 id="monto_total_venta"></h4>
                            <input type="hidden" id="calcular_monto_total_">
                        </div>
                            <div class="col-lg-4 col-md-12 col-sm-12 d-flex align-items-center justify-content-around">
                                <label for="cantidad_cuota__">N° de cuotas :</label>
                                <input type="text"  class="form-control w-50" name="cantidad_cuota__" id="cantidad_cuota__">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" id="contenido_cuotas_">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal_clientes_general" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Lista de Clientes</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 table-responsive">
                              <table class="table table-hover table-bordered" id="dataTable">
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
                                                  <button class="btn btn-primary text-white btn-sm" onclick="agregar_cliente_venta({{$c->id_tipo_documento}},'{{$c->cliente_nombre}}','{{$c->cliente_razonsocial}}','{{$c->cliente_numero}}','{{$c->cliente_direccion}}')"><i class="fa fa-check"></i></button>
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
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <b class="text-primary">VENTA DE PRODUCTOS</b>
                        </div>
                    </div>
                </div>
            </div>
            <form id="formulario_generar_venta" class="mb-3"  method="POST" enctype = "multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    @if(!$validar_caja)
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                            <div class="alert alert-danger" role="alert">
                                                Antes de continuar con la venta, es necesario que proceda a <a href="{{route('admin')}}" class="alert-link">abrir la caja</a>.
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p class="linea_titulo_general">Datos de venta</p>
                                            </div>
                                            <input type="hidden" name="tipo_venta__" id="tipo_venta__" value="1">
                                            <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between mt-3 mb-1">
                                                <label for="habilitarCheckMoto" class="text-uppercase">Habilitar Serie Vehículo</label>
                                                <div class="theme-switch">
                                                    <input type="checkbox" id="habilitarCheckMoto" name="habilitarCheckMoto">
                                                    <label for="habilitarCheckMoto"></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between mt-1  mb-1">
                                                <label for="tipo_comprobante">Tipo de Comprobante</label>
                                                <select name="tipo_comprobante" id="tipo_comprobante" class="form-control w-50">
                                                    <option value="03">Boleta</option>
                                                    <option value="01">Factura</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 d-flex align-items-center justify-content-between mt-1 mb-1">
                                                <label for="serie">Serie</label>
                                                <select name="serie" id="serie" readonly class="form-control w-50">

                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 d-flex align-items-center justify-content-between mt-1 mb-1">
                                                <label for="numero_correlativo">Numero</label>
                                                <input type="text" readonly class="form-control w-50" id="numero_correlativo" name="numero_correlativo">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between mt-1 mb-1">
                                                <label for="id_moneda">Moneda</label>
                                                <select name="id_moneda" id="id_moneda" class="form-control w-50">
                                                        <option value="1">SOLES</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12"  id="contanierTableDebito">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between mt-1 mb-1">
                                                        <label for="partir_pago_check">Partir Pago</label>
                                                        <div class="theme-switch">
                                                            <input type="checkbox" id="partir_pago_check" name="partir_pago_check">
                                                            <label for="partir_pago_check"></label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="vali_partir_total" id="vali_partir_total">
                                                    <div class="col-lg-12 col-md-12 col-sm-12  ">
                                                        <div class="d-flex align-items-center justify-content-between mt-1 mb-1">
                                                            <label for="id_tipo_pago">Tipo de Pago</label>
                                                            <select name="id_tipo_pago" id="id_tipo_pago" class="form-control w-50"  >
                                                                <option value="">Seleccionar</option>
                                                                @foreach($tipo_pago as $t)
                                                                    <option value="{{$t->id_tipo_pago}}">{{$t->tipo_pago_nombre}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12  ">
                                                        <div class="d-flex align-items-center justify-content-between mt-1 mb-1">
                                                            <label for="pago_cliente">Monto</label>
                                                            <input type="text" name="pago_cliente" id="pago_cliente"  class="form-control w-50 p-1" onkeyup="validar_numeros(this.id)" onchange="dar_sobras_pago2()">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12  contenedorPago2" style="display: none" >
                                                        <div class="d-flex align-items-center justify-content-between mt-1 mb-1">
                                                            <label for="id_tipo_pago_2">Tipo de Pago 2</label>
                                                            <select name="id_tipo_pago_2" id="id_tipo_pago_2" class="form-control w-50" >
                                                                <option value="">Seleccionar</option>
                                                                @foreach($tipo_pago as $t)
                                                                    <option value="{{$t->id_tipo_pago}}">{{$t->tipo_pago_nombre}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12   contenedorPago2" style="display: none" >
                                                        <div class="d-flex align-items-center justify-content-between mt-1 mb-1">
                                                            <label for="pago_cliente_2">Monto 2</label>
                                                            <input type="text" readonly name="pago_cliente_2" id="pago_cliente_2"  class="form-control w-50 p-1"  onkeyup="validar_numeros(this.id)" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12  d-flex align-items-center justify-content-between mt-1 mb-1">
                                                <label for="id_formas_pago">Formas de pago</label>
                                                <select name="id_formas_pago" id="id_formas_pago" class="form-control w-50">
                                                        <option value="1">CONTADO</option>
                                                        <option value="2">CRÉDITO</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                                <button class="btn btn-sm bg-primary text-white w-100" style="display: none" data-bs-toggle="modal" data-bs-target="#modal_cuotas" type="button" id="btn_credito_venta" ><i class="fa fa-list"></i> Lista de cuotas</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-7">
                                        <div class="row ">
                                            <div class="col-lg-12 mt-2 mb-2">
                                                <p class="linea_titulo_general d-flex justify-content-between align-items-center">
                                                    Cliente
                                                    <button class="btn btn-primary text-white btn-sm " type="button" style="margin-bottom: 2px" data-bs-toggle="modal" data-bs-target="#modal_clientes_general"><i class="fa fa-search"></i> Buscar Cliente</button>
                                                </p>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                                                            <label for="id_tipo_documento__" class="m-0">Tipo Documento</label>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                                                            <select name="id_tipo_documento__" id="id_tipo_documento__" class="form-control ">
                                                                @foreach($documento as $t)
                                                                    <option value="{{$t->id_tipo_documento}}" {{$t->id_tipo_documento == 2 ? "selected" : "" }}>{{$t->tipo_documento_identidad}}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="id_tipo_documento" id="id_tipo_documento" value="2">
                                                        </div>
                                                        <div class="col-lg-2 col-md-6 col-sm-12  mb-1">
                                                            <label for="numero_documento">N° Doc</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                                                            <input type="text" id="numero_documento" name="numero_documento" class="form-control " value="1111111">
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                                                            <label for="nombre_cliente" id="nombre_tipo_documento">Nombre</label>
                                                        </div>
                                                        <div class="col-lg-9 col-md-6 col-sm-12 mb-1">
                                                            <input type="text" value="ANONIMO"  class="form-control "   id="nombre_cliente" name="nombre_cliente">
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                                                            <label for="telefono_cliente">Teléfono</label>
                                                        </div>
                                                        <div class="col-lg-9 col-md-6 col-sm-12 mb-1">
                                                            <input type="text"  class="form-control"  onkeyup="validar_numeros(this.id)" id="telefono_cliente"  name="telefono_cliente">
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                                            <textarea name="direccion_cliente" id="direccion_cliente" cols="30" rows="3" class="form-control" placeholder="Dirección"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2 mb-2">
                                                <p style="font-size: 11px;font-weight: 600" class="text-primary">* Para ventas que superen los S/ 700.00, se requerirá el registro de datos del cliente. *</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-12 mb-4">
                        <div class="card h-100">
                            <div class="row row-bordered g-0 card h-100">
                                <div class="col-lg-12 card h-100">
                                    <h5 class="card-header m-0 me-2 pb-3">
                                        Productos
                                        <p class="text-danger m-0 mt-2" id="mensaje_producto_insuficientes" style="font-size: 12px"></p>
                                        <p class="text-danger m-0 mt-2" id="mensaje_error_cuotas" style="font-size: 12px"></p>
                                    </h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="buscar_productos_ventas" class="text-primary mb-2"><i class="fa-solid fa-search "></i> Codigo de barra / Nombre de producto</label>
                                                <input type="text" name="buscar_productos_ventas" id="buscar_productos_ventas" placeholder="Ingrese Información ..." class="form-control rounded-pill border-primary">

                                                <div class="shadow mt-3 mb-5" style="z-index: 11111111111111;position: absolute; width: 90%;">
                                                    <div class="list-group list-group-flush bg-white  " style="overflow: auto;" id="lista_productos_ventas">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 mt-3 table-responsive">
                                                <table class="table table-hover table-bordered" id="tablaProductoVentas">
                                                    <thead>
                                                    <tr class="color_tabla">
                                                        <th>Item</th>
                                                        <th>Descripción</th>
                                                        <th>Stock Actual</th>
                                                        <th>Precio Unit</th>
                                                        <th>Cantidad</th>
                                                        <th>Total</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody  id="tabla_productos_ventas">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h5 class="card-title m-0 me-2">DETALLE DE CUENTA</h5>
                            </div>
                            <div class="card-body">
                                <ul class="p-0 m-0">
                                    <li class="d-flex pb-1">
                                        <small class="d-block mb-1" style="color: #a1acb8 !important;opacity: 1">Operaciones</small>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Op. Gravada</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="op_gravada">+00.0</h6>
                                                <span class="text-muted">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">IGV</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="totaligv">+00.0</h6>
                                                <span class="text-muted">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Op. Inafectada</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="op_inafectada">+00.0</h6>
                                                <span class="text-muted">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Op. Exoneradas</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="op_exoneradas">+00.0</h6>
                                                <span class="text-muted">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Op. Gratuitas</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="op_gratuitas">+00.0</h6>
                                                <span class="text-muted">PEN</span>
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
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Descuento</h6>
                                            </div>
                                            <div class="d-flex align-items-center gap-1">
                                                <select id="tipo_descuento" name="descuento_tipo" class="form-select form-select-sm" style="width:62px" onchange="calcular_afectacion()">
                                                    <option value="pct">%</option>
                                                    <option value="monto">S/.</option>
                                                </select>
                                                <input type="text" id="valor_descuento" name="descuento_valor" value="0" class="form-control form-control-sm text-end" style="width:72px" onkeyup="validar_numeros(this.id)" onchange="calcular_afectacion()">
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0 text-danger">Desc. aplicado</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 text-danger" id="descuento_total_display">-0.00</h6>
                                                <span class="text-muted">PEN</span>
                                            </div>
                                        </div>
                                    </li>



                                    <li class="d-flex mb-2 pb-1"  id="cantidad_en_cuotas" style="display: none!important;">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <input type="hidden" name="venta_total_ver" id="venta_total_ver">
                                                <h6 class="mb-0">Monto por cuota</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="monto_cuota_a_pagaar">00.00</h6>
                                                <span class="text-muted">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Pago con</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="pago_con_cliente">00.00</h6>
                                                <span class="text-muted">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Vuelto</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="vuelto_">00.00</h6>
                                                <span class="text-muted">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h4 class="mb-0 text-danger">TOTAL</h4>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h5 class="mb-0 text-danger" id="total_venta">+00.00</h5>
                                                <span class="text-muted">PEN</span>
                                            </div>
                                        </div>
                                    </li>
                                    @if($validar_caja)
                                        <li class="d-flex mb-2 pb-1">
                                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-center ">
                                                <button class="btn bg-primary text-white w-100" type="submit" id="btn_realizar_venta__"><i class="fa fa-money-bill"></i> Cobrar</button>
                                            </div>
                                        </li>
                                    @endif
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
    <script src="{{asset('js/gestionventas.js')}}"></script>
    <script>

        $(document).ready(function(){
            Consultar_serie_()
            $('.input-number').on('input', function() {
                var valor = $(this).val();
                if (valor < 0) {
                    $(this).val(0);
                }
            });
            // Recuperar datos del LocalStorage al cargar la página

        });
        window.addEventListener('load', function() {
            if(localStorage.getItem('ventas_productos')) {
                ventas_prtoductos = JSON.parse(localStorage.getItem('ventas_productos'));
                dibujar_tabla_ventas_productos(); // Esto asegura que se dibuje la tabla con los datos recuperados
            }
        });
        $('input[type="number"]').on('input', function() {
            var valor = $(this).val();
            if (valor < 0) {
                $(this).val(0);
            }
        });
        let id_tipo_documento__ = document.getElementById('id_tipo_documento__');
        if(id_tipo_documento__ && id_tipo_documento__.addEventListener) {
            id_tipo_documento__.addEventListener('change', function () {
                cambiar_tipo_comprobante(this.id)
            });
        }
        let habilitarCheckMoto = document.getElementById('habilitarCheckMoto');
        if(habilitarCheckMoto && habilitarCheckMoto.addEventListener) {
            habilitarCheckMoto.addEventListener('change', function () {
                Consultar_serie_()
            });
        }

        function cambiar_tipo_comprobante(id){
            let valor = $('#'+id).val();
            if(valor == 4 ){
                $('#tipo_comprobante').val('01');
            }else{
                $('#tipo_comprobante').val('03');
            }
            $('#id_tipo_documento').val(valor);
            Consultar_serie_();
        }
        let numero_documento = document.getElementById('numero_documento');
        if(numero_documento && numero_documento.addEventListener) {
            numero_documento.addEventListener('change', function () {
                validar_tipo_documento_venta_local(this.id)
            });
        }
        function validar_tipo_documento_venta_local(id){
            let valor = $('#'+id).val();
            if ($('#id_tipo_documento').val() == 2) {
                limit_input(id, 8)

                ObtenerDatosDni(valor)
            }else if($('#id_tipo_documento').val() == 4){
                limit_input(id, 11)
                ObtenerDatosRuc(valor)
            }
        }
        function limit_input(inputId, cantidad){
            const input = document.getElementById(inputId);
            const maxLength = cantidad;
            const currentValue = input.value;

            // Eliminamos cualquier caracter que no sea número
            input.value = currentValue.replace(/\D/g, '');

            // Verificar si se supera el límite de caracteres
            if (currentValue.length > maxLength) {
                input.value = currentValue.slice(0, maxLength);
            } else {

            }
        }

        function ObtenerDatosDni(valor){
            if(valor.length == 8){
                respuesta("Buscando...",'info')
                var numero_dni =  valor;
                var formData = new FormData();
                formData.append("token", "uTZu2aTvMPpqWFuzKATPRWNujUUe7Re1scFlRsTy9Q15k1sjdJVAc9WGy57m");
                formData.append("dni", numero_dni);
                var request = new XMLHttpRequest();
                request.open("POST", "https://api.migo.pe/api/v1/dni");
                request.setRequestHeader("Accept", "application/json");
                request.send(formData);
                //$('.loader').show();
                request.onload = function() {
                    var data = JSON.parse(this.response);
                    if(data.success){
                        respuesta("Datos encontrados.",'success')
                        $("#nombre_cliente").val(data.nombre);
                        $("#nombre_cliente").attr('readonly',true)
                    }else{
                        $("#nombre_cliente").val('');
                        respuesta("Datos no encontrados.",'error')
                        console.log(data.message);
                    }
                };
            }

        }
        function ObtenerDatosRuc(valor){
            respuesta("Buscando...",'info')

            var numero_ruc =  valor;

            var formData = new FormData();
            formData.append("token", "uTZu2aTvMPpqWFuzKATPRWNujUUe7Re1scFlRsTy9Q15k1sjdJVAc9WGy57m");
            formData.append("ruc", numero_ruc);
            var request = new XMLHttpRequest();
            request.open("POST", "https://api.migo.pe/api/v1/ruc");
            request.setRequestHeader("Accept", "application/json");
            request.send(formData);
            $('.loader').show();
            request.onload = function() {
                var data = JSON.parse(this.response);
                if(data.success){
                    //$('.loader').hide();
                    // console.log("Datos Encontrados");
                    //$('#cotizacion_beneficiario').val(data.nombre_o_razon_social);
                    respuesta("Datos encontrados.",'success')
                    $("#nombre_cliente").val(data.nombre_o_razon_social);
                    $('#direccion_cliente').val(data.direccion_simple);
                }else{
                    //$('.loader').hide();
                    respuesta("Datos no encontrados.",'error')
                    $("#nombre_cliente").val(' ');
                    $('#direccion_cliente').val(' ');
                    console.log(data.message);
                }
            };
        }
    </script>

@endsection

