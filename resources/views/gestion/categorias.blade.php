@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
<div class="modal fade" id="modal_crear_categoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formulario_categoria" class="mb-3"  method="POST" enctype = "multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="estadoActionFuctionCategoria" id="estadoActionFuctionCategoria">
                    <input type="hidden" name="id_ca" id="id_ca">
                    <input type="hidden" name="id_fa" id="id_fa">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="ca_nombre" class="form-label">Nombre</label>
                            <input type="text" name="ca_nombre"  id="ca_nombre" class="form-control w-100 ">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" id="btnSaveCategoria">Guardar registro</button>
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
                    <div class="col-lg-10 col-md-10 col-sm-12 ">
                        <h5 class="mb-1">Lista de categorias de la familia : <b class="text-primary">{{$familia->fa_nombre}}</b></h5>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 ">
                        <button class="btn  btn-sm btn-success mb-1 w-100" data_id_familia = "{{$familia->id_fa}}" id="btn_crear_categoria" data-bs-toggle="modal" data-bs-target="#modal_crear_categoria"><i class="fa fa-plus"></i> Agregar categoria</button>
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
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $a = 1
                                    @endphp
                                    @foreach($categorias as $me)
                                        <tr>
                                            <td>{{$a}}</td>
                                            <td>{{$me->ca_nombre}}</td>
                                            <td>
                                                <button class="btn btn-sm bg-primary text-white" data-bs-toggle="modal" data-bs-target="#modal_crear_categoria" onclick="modificarCategoria({{$me->id_ca}},'{{$me->ca_nombre}}')"><i class="  fa-solid fa-pencil"></i></button>
                                                <button class="btn btn-sm bg-danger text-white" id="btnEliminarCategoria_{{$me->id_ca}}"  onclick="preguntar('¿Está seguro que desea eliminar este categoria?','eliminar_categoria','Si','No',{{$me->id_ca}})"><i class="fa-solid fa-trash"></i></button>
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
