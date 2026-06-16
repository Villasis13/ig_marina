
@extends('layouts.plantilla')
@section('content')
<style>
.oc-search-label {
  display: block;
  font-size: 11.5px;
  font-weight: 600;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: .5px;
  margin-bottom: 6px;
}
.oc-search-wrap { position: relative; }
.oc-search-icon {
  position: absolute;
  left: 11px;
  top: 50%;
  transform: translateY(-50%);
  color: #64748b;
  font-size: 13px;
  pointer-events: none;
}
.oc-search-input {
  width: 100%;
  padding: 9px 13px 9px 34px;
  font-size: 13.5px;
  border: 1px solid #e2e8f0;
  border-radius: 7px;
  background: #f1f5f9;
  color: #1e293b;
  transition: border-color .15s, box-shadow .15s;
  outline: none;
}
.oc-search-input:focus {
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37,99,235,.12);
  background: #fff;
}
.oc-dropdown {
  position: absolute;
  top: calc(100% + 4px);
  left: 0;
  right: 0;
  z-index: 9999;
  background: #fff;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  box-shadow: 0 8px 28px rgba(15,23,42,.13);
  max-height: 300px;
  overflow-y: auto;
  display: none;
}
.oc-dropdown.open { display: block; }
.oc-drop-item {
  padding: 9px 14px;
  cursor: pointer;
  border-bottom: 1px solid #f1f5f9;
  transition: background .12s;
}
.oc-drop-item:last-child { border-bottom: none; }
.oc-drop-item:hover { background: #eff6ff; }
.oc-drop-name  { font-size: 13px; font-weight: 600; color: #1e293b; }
.oc-drop-meta  { font-size: 11px; color: #64748b; margin-top: 2px; }
.oc-drop-code  { font-family: monospace; color: #6b7280; }
.oc-drop-fam   { color: #2563eb; margin-left: 6px; }
.oc-drop-empty { padding: 12px 14px; font-size: 13px; color: #64748b; font-style: italic; }
</style>
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
                                                        <label class="form-label">Condición</label>
                                                        <select name="orden_compra_condicion" id="orden_compra_condicion" class="form-control w-50 m-1">
                                                            <option value="0">Contado</option>
                                                            <option value="1">Crédito</option>
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
                                                                <option value="4">Ticket</option>
                                                                <option value="5">Guía</option>
                                                        </select>
                                                    </div>
                                                    <div id="div_tipo_pago" class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between">
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
                                                        <input type="text" readonly="" id="total" class="form-control w-50 m-1">
                                                        <input type="hidden" id="total_raw" name="total">
                                                        <input type="hidden" value="1" id="estadoActionFuctionOrdenCompra" name="estadoActionFuctionOrdenCompra" class="form-control w-50 m-1">
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between">
                                                        <label for="fecha_emision" class="form-label">Fecha de Emisión</label>
                                                        <input type="date" id="fecha_emision" name="fecha_emision" class="form-control w-50 m-1" value="{{ date('Y-m-d') }}" onchange="actualizarFechaVencimiento()">
                                                    </div>
                                                    <div id="div_fecha_vencimiento" class="col-lg-12 col-md-12 col-sm-12 align-items-center justify-content-between" style="display:none">
                                                        <label for="fecha_vencimiento" class="form-label">Fecha Vencimiento</label>
                                                        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control w-50 m-1" value="{{ date('Y-m-d', strtotime('+1 month')) }}">
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
                                                        <label for="guia_remision" class="form-label">Guía de Remisión</label>
                                                        <input type="text" id="guia_remision" name="guia_remision" class="form-control w-100 m-1" placeholder="Nro. guía">
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <label for="guia_transportista" class="form-label">Guía Transportista</label>
                                                        <input type="text" id="guia_transportista" name="guia_transportista" class="form-control w-100 m-1" placeholder="Transportista">
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <label for="adjuntar_foto">Adjuntar Documentos</label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="adjuntar_foto" name="adjuntar_foto" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <label class="oc-search-label"><i class="fa-solid fa-magnifying-glass"></i> Buscar Productos</label>
                                                        <div class="oc-search-wrap">
                                                            <i class="fa-solid fa-magnifying-glass oc-search-icon"></i>
                                                            <input type="text" name="productos_orden_compra" id="productos_orden_compra"
                                                                   class="oc-search-input" placeholder="Buscar por nombre o código…" autocomplete="off">
                                                            <div id="oc_productos_dropdown" class="oc-dropdown"></div>
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
    function toggleCondicionCompra(val) {
        if (val === '1') { // Crédito
            $('#div_tipo_pago').removeClass('d-flex').addClass('d-none');
            $('#id_tipo_pago').val('');
            $('#div_fecha_vencimiento').css('display', 'flex');
        } else { // Contado
            $('#div_tipo_pago').removeClass('d-none').addClass('d-flex');
            $('#div_fecha_vencimiento').css('display', 'none');
        }
    }
    function actualizarFechaVencimiento() {
        var emision = $('#fecha_emision').val();
        if (emision) {
            var d = new Date(emision);
            d.setMonth(d.getMonth() + 1);
            var yyyy = d.getFullYear();
            var mm   = String(d.getMonth() + 1).padStart(2, '0');
            var dd   = String(d.getDate()).padStart(2, '0');
            $('#fecha_vencimiento').val(yyyy + '-' + mm + '-' + dd);
        }
    }
    $('#orden_compra_condicion').on('change', function() {
        toggleCondicionCompra($(this).val());
    });
    toggleCondicionCompra($('#orden_compra_condicion').val());
</script>
@endsection
