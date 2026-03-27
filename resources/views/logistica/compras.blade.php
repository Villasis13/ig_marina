
@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
{{--<div class="modal fade" id="modal_crear_productos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--    <div class="modal-dialog">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>--}}
{{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--            </div>--}}
{{--            <form id="formularioAgregarProductos" class="mb-3"  method="POST" enctype = "multipart/form-data">--}}
{{--                @csrf--}}
{{--                <div class="modal-body">--}}
{{--                    <input type="hidden" name="estadoActionFuctionProductos" id="estadoActionFuctionProductos">--}}
{{--                    <input type="hidden" name="id_pro" id="id_pro">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-3">--}}
{{--                            <small class="text-primary">Por favor, complete los campos obligatorios marcados con asterisco ().*</small>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-8 col-md-8 col-sm-12 mb-2">--}}
{{--                            <label for="pro_nombre" class="form-label">Nombre (*)</label>--}}
{{--                            <input type="text" name="pro_nombre"  id="pro_nombre" class="form-control w-100 ">--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">--}}
{{--                            <label for="pro_codigo" class="form-label">Código (*)</label>--}}
{{--                            <input type="text" name="pro_codigo"  id="pro_codigo" class="form-control w-100 ">--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">--}}
{{--                            <label for="pro_precio_uni" class="form-label">Precio Unitario (*)</label>--}}
{{--                            <input type="text" name="pro_precio_uni"  id="pro_precio_uni" class="form-control w-100 ">--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">--}}
{{--                            <label for="pro_precio_uni_ma" class="form-label">Precio Mayorista (*)</label>--}}
{{--                            <input type="text" name="pro_precio_uni_ma"  id="pro_precio_uni_ma" class="form-control w-100 ">--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">--}}
{{--                            <label for="pro_medida" class="form-label">Porcentaje IGV (*) </label>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-lg-6">--}}
{{--                                    <input type="radio" name="pro_porcen_igv" id="pro_porcen_igv_18" value="0.18" >--}}
{{--                                    <label for="pro_porcen_igv_18">18%</label>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-6">--}}
{{--                                    <input type="radio" name="pro_porcen_igv" id="pro_porcen_igv_10" value="0.10">--}}
{{--                                    <label for="pro_porcen_igv_10">10%</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">--}}
{{--                            <label for="id_ca" class="form-label">Categoría (*)</label>--}}
{{--                            <select name="id_ca" id="id_ca" class="form-control">--}}
{{--                                <option value="">Seleccionar</option>--}}
{{--                                @foreach($cate as $c)--}}
{{--                                    <option value="{{$c->id_ca}}">{{$c->ca_nombre}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">--}}
{{--                            <label for="pro_presentacion" class="form-label">Presentación</label>--}}
{{--                            <input type="text" name="pro_presentacion"  id="pro_presentacion" class="form-control w-100 ">--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">--}}
{{--                            <label for="pro_medida" class="form-label">Medida</label>--}}
{{--                            <input type="text" name="pro_medida"  id="pro_medida" class="form-control w-100 ">--}}
{{--                        </div>--}}

{{--                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">--}}
{{--                            <label for="pro_descripcion" class="form-label">Descripción</label>--}}
{{--                            <textarea name="pro_descripcion" id="pro_descripcion" class="form-control w-100" rows="4"></textarea>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-12 col-md-12 col-sm-12 text-center ">--}}
{{--                            <label for="">Imagen (*)</label>--}}
{{--                            <div class="d-flex align-items-center justify-content-center">--}}
{{--                                <label for="pro_foto" class="contenedor_previsualizacion mt-3 cursor-pointer">--}}
{{--                                    <img src="{{asset('sin-fotografia.png')}}" alt="" id="imagen_producto" style="width: 100%">--}}
{{--                                </label>--}}
{{--                                <input type="file" name="pro_foto" id="pro_foto" class="d-none" onchange="previewImage(this ,'imagen_producto')">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="submit" class="btn btn-primary w-100" id="btnSaveProductos">Guardar registro</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="tab-content">
    <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" tabindex="0">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card">
                <div class="row m-2">
                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center">
                        <b class="text-primary">Iniciar solicitud de orden de compra</b>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <form id="formulario_orden_compra" class="mb-3" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                        <div class="card ">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between">
                                                        <label for="id_proveedores" class="form-label">Proveedor</label>
                                                        <select name="id_proveedores" id="id_proveedores" class="form-control w-50 m-1">
                                                            <option value="">Seleccionar</option>
                                                            @foreach($proveedores as $t)
                                                                <option value="{{$t->id_proveedores}}">{{$t->proveedores_nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between">
                                                        <label for="id_tipo_venta" class="form-label">Tipo de Venta</label>
                                                        <select name="id_tipo_venta" id="id_tipo_venta" class="form-control w-50 m-1">
                                                            <option value="">Seleccionar</option>
                                                            @foreach($tipo_venta as $t)
                                                                <option value="{{$t->id_tipo_venta}}">{{$t->tipo_venta_nombre}}</option>
                                                            @endforeach
                                                                <option value="3">Nota de venta</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between">
                                                        <label for="id_tipo_pago" class="form-label">Tipo de Pago</label>
                                                        <select name="id_tipo_pago" id="id_tipo_pago" class="form-control w-50 m-1">
                                                            <option value="">Seleccionar</option>
                                                            @foreach($tipo_pago as $t)
                                                                <option value="{{$t->id_tipo_pago}}">{{$t->tipo_pago_nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <div class="row">

                                                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between">
                                                        <label for="num_documento" class="form-label">Nro. de documento</label>
                                                        <input type="text" id="num_documento_" onkeyup="mayuscula(this.id)" name="num_documento_" class="form-control w-50 m-1">
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between">
                                                        <label for="total" class="form-label">Total</label>
                                                        <input type="text" readonly="" id="total" name="total" class="form-control w-50 m-1">
                                                        <input type="hidden" value="1" id="estadoActionFuctionOrdenCompra" name="estadoActionFuctionOrdenCompra" class="form-control w-50 m-1">
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between">
                                                        <label for="fecha_emision" class="form-label">Fecha de Emision</label>
                                                        <input type="date" id="fecha_emision" name="fecha_emision" class="form-control w-50 m-1" value="2024-01-20">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <label for="observaciones_orden_compra">Observaciones</label>
                                                        <textarea name="observaciones_orden_compra" id="observaciones_orden_compra" cols="30" rows="2" class="form-control w-100 m-1"></textarea>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <label for="adjuntar_foto">Adjuntar Foto</label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="adjuntar_foto" name="adjuntar_foto" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <label for="productos_orden_compra" class="fw-semibold"><i class="bx bx-search"></i> Buscar Productos</label>
                                                        <input type="text" name="productos_orden_compra" id="productos_orden_compra" placeholder="Ingrese Información..." class="form-control  p-1">
                                                        <div class="shadow" style="z-index: 999;position: absolute; width: 90%">
                                                            <div class="list-group list-group-flush bg-white  " style="overflow: auto;" id="listar_productos_orden_compra">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2 table-responsive" id="tabla_productos_orden_compra">

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-3 ">
                        <button class="btn btn-primary text-white w-100" id="btn_guardar_orden_compra" type="submit">Guardar Registro</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="vista_para_opciones_{{$opciones[1]->id_opciones}}" class="tab-pane fade  " role="tabpanel" aria-labelledby="opciones_{{$opciones[1]->id_opciones}}" tabindex="0">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card">
                <div class="row m-2">
                    <div class="col-lg-3 col-md-3 col-sm-4  mb-2">
                        <small class="form-label">Proveedor</small>
                        <select name="id_proveedores_search" id="id_proveedores_search" class="form-control ">
                            <option value="">Seleccionar</option>
                            @foreach($proveedores as $t)
                                <option value="{{$t->id_proveedores}}">{{$t->proveedores_nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 mb-2 ">
                        <small >Desde :</small>
                        <input type="date" class="form-control" id="desde_historial_compra" name="desde_historial_compra" value="{{date('Y-m-d')}}">
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4  mb-2">
                        <small >Hasta :</small>
                        <input type="date" class="form-control " id="hasta_historial_compra" name="hasta_historial_compra" value="{{date('Y-m-d')}}">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 mb-2 d-flex align-items-center  justify-content-center flex-column">
                        <button class="btn  text-white bg-primary w-100" id="btn_buscarOrdenCompra"><i class="fa-solid fa-magnifying-glass"></i> Buscar Registros</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card ">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card-body table-responsive ">
                            <table class="table table-hover " id="tablaHistorialCompras">
                                <thead>
                                <tr class="encabezado_tabla_color">
                                    <th>#</th>
                                    <th>Fecha de registro</th>
                                    <th>Proveedor</th>
{{--                                    <th>Categoria</th>--}}
                                    <th>Nro.comprobante</th>
                                    <th>Comprobante</th>
                                    <th>Nro.orden</th>
                                    <th>Total</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody id="buscar_ver_facturas">

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-center " id="btn_genExcelHistory">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/domain.js')}}"></script>
<script src="{{asset('js/logistica.js')}}"></script>
    <script>
        window.addEventListener('load', function() {
            if(localStorage.getItem('productos_orden_compra')) {
                array_orden_compra = JSON.parse(localStorage.getItem('productos_orden_compra'));
                dibujar_tabla_productos_orden_compra(); // Esto asegura que se dibuje la tabla con los datos recuperados
            }
        });
    </script>
@endsection
