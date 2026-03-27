@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
<div class="modal fade" id="modal_crear_proveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formularioAgregarProveedor" class="mb-3"  method="POST" enctype = "multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="estadoActionFuction" id="estadoActionFuction">
                        <input type="hidden" name="id_proveedores" id="id_proveedores">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <label for="id_tipo_documento" class="form-label">Tipo de Documento</label>
                                <select name="id_tipo_documento" class="form-control" id="id_tipo_documento">
                                    <option value="">Seleccionar</option>
                                    @foreach($tipo_documento as $t)
                                        <option value="{{$t->id_tipo_documento}}">{{$t->tipo_documento_identidad_abr}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <label for="proveedores_numero_documento" class="form-label">N° Documento</label>
                                <input type="text" name="proveedores_numero_documento" onkeyup="validar_numeros(this.id)"  id="proveedores_numero_documento" class="form-control w-100 ">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <label for="proveedores_nombre" class="form-label">Razón Social</label>
                                <input type="text" name="proveedores_nombre" id="proveedores_nombre" class="form-control w-100 ">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <label for="proveedores_direccion" class="form-label">Dirección</label>
                                <textarea name="proveedores_direccion" id="proveedores_direccion" class="form-control w-100 "  rows="4"></textarea>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <label for="proveedores_telefono" class="form-label">Teléfono</label>
                                <input type="text" name="proveedores_telefono" onkeyup="validar_numeros(this.id)" id="proveedores_telefono" class="form-control w-100 ">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <label for="proveedores_correo" class="form-label">Correo electrónico</label>
                                <input type="text" name="proveedores_correo" id="proveedores_correo" class="form-control w-100">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100" id="btnSaveProveedor">Guardar registro</button>
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
                        <button class="btn  btn-sm btn-success" id="btn_crear_proveedor" data-bs-toggle="modal" data-bs-target="#modal_crear_proveedor"><i class="fa fa-plus"></i> Agregar Proveedor</button>
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
                                    <th>Documento</th>
                                    <th>Razón Social</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $a = 1
                                @endphp
                                @foreach($proveedores as $me)
                                    <tr>
                                        <td>{{$a}}</td>
                                        <td>{{$me->tipo_documento_identidad_abr}}: {{$me->proveedores_numero_documento}}</td>
                                        <td>{{$me->proveedores_nombre}}</td>
                                        <td>{{$me->proveedores_direccion}}</td>
                                        <td>{{$me->proveedores_telefono}}</td>
                                        <td>{{$me->proveedores_correo}}</td>
                                        <td>
                                            <button class="btn btn-sm bg-primary text-white" data-bs-toggle="modal" data-bs-target="#modal_crear_proveedor" onclick="modificarProveedor({{$me->id_proveedores}})"><i class="  fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-sm bg-danger text-white" id="btnEliminarProveedor_{{$me->id_proveedores}}"  onclick="preguntar('¿Está seguro que desea eliminar este proveedor?','eliminar_proveedor','Si','No',{{$me->id_proveedores}})"><i class="fa-solid fa-trash"></i></button>
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
        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
            <a class="btn btn-warning text-white" href="{{route('Gestion.proveedores_excel')}}">Generar Excel <i class="fa fa-file-excel"></i></a>
        </div>
    </div>
</div>
<script src="{{asset('js/domain.js')}}"></script>
<script src="{{asset('js/gestion.js')}}"></script>

@endsection
