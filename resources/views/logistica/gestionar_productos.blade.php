@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
<div class="modal fade" id="modal_crear_productos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formularioAgregarProductos" class="mb-3"  method="POST" enctype = "multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="estadoActionFuctionProductos" id="estadoActionFuctionProductos">
                    <input type="hidden" name="id_pro" id="id_pro">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-3">
                            <small class="text-primary">Por favor, complete los campos obligatorios marcados con asterisco ().*</small>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 mb-2">
                            <label for="pro_nombre" class="form-label">Nombre (*)</label>
                            <input type="text" name="pro_nombre"  id="pro_nombre" class="form-control w-100 ">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="pro_codigo" class="form-label">Código (*)</label>
                            <input type="text" name="pro_codigo"  id="pro_codigo" class="form-control w-100 ">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="pro_precio_uni" class="form-label">Precio Unitario (*)</label>
                            <input type="text" name="pro_precio_uni"  id="pro_precio_uni" class="form-control w-100 ">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="pro_precio_uni_ma" class="form-label">Precio Mayorista (*)</label>
                            <input type="text" name="pro_precio_uni_ma"  id="pro_precio_uni_ma" class="form-control w-100 ">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="tipoAfectacion" class="form-label">Tipo de Afectación</label>
                            <select name="tipoAfectacion" id="tipoAfectacion" class="form-select">
                                <option value="">Seleccionar..</option>
                                @foreach($tipoAfectacion as $ti)
                                    <option value="{{$ti->id_tipo_afectacion}}">{{$ti->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
{{--                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">--}}
{{--                            <label for="pro_medida" class="form-label">Porcentaje IGV (*) </label>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-lg-6">--}}
{{--                                    <input type="radio" name="pro_porcen_igv" id="pro_porcen_igv_18" value="1.18" >--}}
{{--                                    <label for="pro_porcen_igv_18">18%</label>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-6">--}}
{{--                                    <input type="radio" name="pro_porcen_igv" id="pro_porcen_igv_10" value="1.10">--}}
{{--                                    <label for="pro_porcen_igv_10">10%</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="id_ca" class="form-label">Categoría (*)</label>
                            <select name="id_ca" id="id_ca" class="form-select">
                                <option value="">Seleccionar</option>
                                @foreach($cate as $c)
                                    <option value="{{$c->id_ca}}">{{$c->ca_nombre}}</option>
                                @endforeach
                            </select>
                        </div>
{{--                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">--}}
{{--                            <label for="pro_presentacion" class="form-label">Presentación</label>--}}
{{--                            <input type="text" name="pro_presentacion"  id="pro_presentacion" class="form-control w-100 ">--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">--}}
{{--                            <label for="pro_medida" class="form-label">Medida</label>--}}
{{--                            <input type="text" name="pro_medida"  id="pro_medida" class="form-control w-100 ">--}}
{{--                        </div>--}}
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3 mb-3 ">
                            <label for="unidadMedida" class="form-label">Medida (*)</label>
                            <select name="unidadMedida" id="unidadMedida" class="form-select">
                                <option value="">Seleccionar</option>
                                <option value="58">UNIDAD (BIENES)</option>
                                <option value="59">UNIDAD (SERVICIOS)</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3 mb-3 d-flex align-items-center">
                            <label for="impuesto_bolsa" class="w-50 form-label m-0">IMPUESTO A BOLSA</label>
                            <label class="check">
                                <input type="checkbox" id="impuesto_bolsa"  name="impuesto_bolsa">
                                <span class="check1"></span>
                            </label>
                        </div>
                        <!-- Control de inventario (checkboxes, no excluyentes) -->
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-3 mb-3">
                            <label class="form-label">Control de inventario</label>
                            <div class="d-flex flex-wrap gap-4 mt-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="control_serie" name="control_serie" value="1">
                                    <label class="form-check-label" for="control_serie">
                                        Por número de serie <small class="text-muted">(motos, trimotos)</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="control_lote" name="control_lote" value="1">
                                    <label class="form-check-label" for="control_lote">
                                        Por lote <small class="text-muted">(repuestos con vencimiento)</small>
                                    </label>
                                </div>
                            </div>
                            <small class="text-muted">Si ninguno está marcado, el stock se maneja por unidades simples.</small>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="pro_descripcion" class="form-label">Descripción</label>
                            <textarea name="pro_descripcion" id="pro_descripcion" class="form-control w-100" rows="4"></textarea>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center ">
                            <label for="">Imagen (*)</label>
                            <div class="d-flex align-items-center justify-content-center">
                                <label for="pro_foto" class="contenedor_previsualizacion mt-3 cursor-pointer">
                                    <img src="{{asset('sin-fotografia.png')}}" alt="" id="imagen_producto" style="width: 100%">
                                </label>
                                <input type="file" name="pro_foto" id="pro_foto" class="d-none" onchange="previewImage(this ,'imagen_producto')">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" id="btnSaveProductos">Guardar registro</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="tab-content">
    <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" tabindex="0">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card">
                <div class="row m-2">
                    <div class="col-lg-2 col-md-12 col-sm-12 d-flex align-items-center">
                        <button class="btn  btn-sm btn-success" id="btn_crear_productos" data-bs-toggle="modal" data-bs-target="#modal_crear_productos"><i class="fa fa-plus"></i> Agregar Productos</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="card ">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card-body table-responsive ">
                            <table class="pt-2 pb-2 w-100 h-100 table  table-hover" id="dataTable13">
                                <thead>
                                    <tr class="encabezado_tabla_color">
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Impuesto a bolsa</th>
                                        <th>Unidad de Medida</th>
                                        <th>Valor Unit</th>
                                        <th>Precio Unit</th>
{{--                                        <th>Porcentaje de igv</th>--}}
                                        <th>Stock</th>
                                        <th>Foto</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $a = 1
                                    @endphp
                                    @foreach($productos as $me)
                                        <tr>
                                            <td>{{$a}}</td>
                                            <td>
                                                {{$me->pro_nombre}}
                                                <br>
                                                CÓDIGO: <b>{{$me->pro_codigo}}</b>
                                                <br>
                                                @if($me->control_serie)
                                                    <span class="badge bg-primary">Serie</span>
                                                @endif
                                                @if($me->control_lote)
                                                    <span class="badge bg-warning text-dark">Lote</span>
                                                @endif
                                                @if(!$me->control_serie && !$me->control_lote)
                                                    <span class="badge bg-secondary">Unidad</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{$me->impuesto_bolsa == 1 ? 'SI' : 'NO'}}
                                            </td>
                                            <td>
                                               {{$me->id_medida == 58 ? 'UNIDAD (BIENES)' : 'UNIDAD (SERVICIOS)'}}
                                                <br>
                                                Código: {{$me->id_medida == 58 ? 'NIU' : 'ZZ'}}
                                            </td>
                                            <td>
                                                VALOR UNIT: <br>
                                                <b>{{$me->pro_precio_valor}}</b> <br>
                                                VALOR MAYO: <br>
                                                <b>{{$me->pro_precio_valor_ma}}</b>
                                            </td>
                                            <td>
                                                PRECIO UNIT: <br>
                                                <b>{{$me->pro_precio_uni}}</b> <br>
                                                PRECIO MAYO: <br>
                                                <b>{{$me->pro_precio_uni_ma}}</b>
                                            </td>
{{--                                            <td>{{$me->pro_porcen_igv}}</td>--}}
                                            <td>
                                                {{$me->id_medida == 58 ? $me->pro_stock : '∞'}}
                                            </td>
                                            <td>
                                                @if(file_exists($me->pro_foto))
                                                    <img src="{{asset($me->pro_foto)}}" class="w-50 h-50"  style="border-radius: 10px" alt="">
                                                @else
                                                    <img src="{{asset('sin-fotografia.png')}}" class="w-50 h-50"  style="border-radius: 10px" alt="">
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm bg-primary text-white m-1" data-bs-toggle="modal" data-bs-target="#modal_crear_productos" onclick="modificarProductos({{$me->id_pro}})"><i class="  fa-solid fa-pencil"></i></button>
                                                <button class="btn btn-sm bg-danger text-white m-1" id="btnEliminarProducto_{{$me->id_pro}}"  onclick="preguntar('¿Está seguro que desea eliminar este producto?','eliminar_producto','Si','No',{{$me->id_pro}})"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @php
                                            $a++
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/domain.js')}}"></script>
<script src="{{asset('js/logistica.js')}}"></script>

@endsection
