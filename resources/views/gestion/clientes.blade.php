@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
<div class="modal fade" id="modalCrearClientes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formularioCrearCliente" class="mb-3"  method="POST" enctype = "multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="estadoActionFuction" id="estadoActionFuction">
                    <input type="hidden" name="id_clientes" id="id_clientes">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="id_tipo_documento" class="form-label">Tipo Documento</label>
                            <select name="id_tipo_documento" class="form-select" id="id_tipo_documento">
                                @foreach($tipoDocumentos as $tipo)
                                    <option value="{{$tipo->id_tipo_documento}}">{{$tipo->tipo_documento_identidad_abr}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="cliente_numero" class="form-label">Número de Documento</label>
                            <input type="text" name="cliente_numero"  id="cliente_numero" class="form-control w-100 ">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="cliente_nombre_general" class="form-label">Nombre</label>
                            <input type="text" name="cliente_nombre_general"  id="cliente_nombre_general" class="form-control w-100 ">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="cliente_direccion" class="form-label">Dirección</label>
                            <textarea name="cliente_direccion" id="cliente_direccion" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" id="btnSaveCliente">Guardar registro</button>
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
                        <button class="btn  btn-sm btn-success" id="btnCliente" data-bs-toggle="modal" data-bs-target="#modalCrearClientes"><i class="fa fa-plus"></i> Agregar Familia</button>
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
                                        <th>Tipo de Documento</th>
                                        <th>N° de Documento</th>
                                        <th>Nombre o Razon</th>
                                        <th>Dirección</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $a = 1
                                    @endphp
                                    @foreach($clientes as $cli)
                                        <tr>
                                            <td>{{$a}}</td>
                                            <td>{{$cli->tipo_documento_identidad_abr}}</td>
                                            <td>{{$cli->cliente_numero}}</td>
                                            <td>{{$cli->id_tipo_documento == 4 ? $cli->cliente_razonsocial : $cli->cliente_nombre}}</td>
                                            <td>{{$cli->cliente_direccion ? $cli->cliente_direccion : '-'}}</td>
                                            <td>
                                                <button class="btn btn-sm m-1 bg-primary text-white" data-bs-toggle="modal" data-bs-target="#modalCrearClientes" onclick="modificarCliente({{$cli->id_clientes}})"><i class="  fa-solid fa-pencil"></i></button>
                                                <button class="btn btn-sm m-1 bg-danger text-white" id="btnEliminarCliente_{{$cli->id_clientes}}"  onclick="preguntar('¿Está seguro que desea eliminar este cliente?','eliminar_cliente','Si','No',{{$cli->id_clientes}})"><i class="fa-solid fa-trash"></i></button>
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
<script src="{{asset('js/gestion.js')}}"></script>

@endsection
