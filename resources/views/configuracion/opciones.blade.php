@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
<div class="modal fade" id="crear_opciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formulario_crear_opciones" class="mb-3"  method="POST" enctype = "multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_opciones" id="id_opciones">
                        <input type="hidden" name="id_submenu" id="id_submenu" value="{{$ID}}">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="nombre_opciones" class="form-label">Nombre</label>
                                <input type="text" name="nombre_opciones" onkeyup="mayuscula(this.id)" id="nombre_opciones" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <label for="funcion_opciones" class="form-label">Función</label>
                                <input type="text" name="funcion_opciones" id="funcion_opciones" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="orden_opciones" class="form-label">Orden</label>
                                <input type="text" name="orden_opciones" id="orden_opciones" class="form-control w-100 m-1">
                            </div>

                            <div class=" col-lg-6 col-md-12 col-sm-12 d-flex align-items-center">
                                <label for="visible_opciones" class="w-50 form-label">Visibilidad</label>
                                <label class="check">
                                    <input type="checkbox" id="visible_opciones"  name="visible_opciones">
                                    <span class="check1"></span>
                                </label>
                            </div>
                        </div>
                </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_guardar_opciones">Guardar Opción</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<div class="modal fade" id="crear_permisos_modal" tabindex="-1" aria-labelledby="crear_permisos_modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Permisos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <form id="formulario_permisos_opciones" class="mb-3"  method="POST" enctype = "multipart/form-data">
                            @csrf
                        <div class="row">
                                <input type="hidden" name="id_opciones_permisos" id="id_opciones_permisos">
                                <div class="col-lg-1">
                                    <b>Función : </b>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 ">
                                    <input type="text" name="nombre_permiso__" id="nombre_permiso__" class="form-control w-100 ">
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <button class="btn  bg-success text-white" id="btn_guardar_permiso_tab" type="submit"><i class="fa fa-save"></i> Guardar Permiso</button>
                                </div>

                        </div>
                        </form>
                        <div class="row mt-2">
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Permiso</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tabla_permisos_id">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>


            </div>
        </div>
    </div>

<div class="tab-content">
    <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" tabindex="0">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card">
                <div class="row m-2">
                    <div class="col-lg-2 col-md-12 col-sm-12 d-flex align-items-center">
                        <a href="javascript:history.back();" class="btn btn-sm w-100 btn-warning text-left-white"><i class="fa fa-history"></i> Regresar</a>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 d-flex align-items-center">
                        <button class="btn btn-sm w-100 btn-success" id="btn_crear_opciones" data-bs-toggle="modal" data-bs-target="#crear_opciones"><i class="fa fa-plus"></i> Agregar Opción</button>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 d-flex align-items-center justify-content-center">
                        <h5 class="text-primary">Gestión de Opciones</h5>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card alto_card">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card-body table-responsive ">
                            <table class="pt-2 pb-2 w-100 h-100 table  table-hover" id="dataTable13">
                                <thead>
                                <tr class="encabezado_tabla_color">
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Función</th>
                                    <th>Orden</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $a = 1
                                @endphp
                                @foreach($listar_opciones as $me)
                                    <tr>
                                        <td>{{$a}}</td>
                                        <td>{{$me->opciones_nombre}}</td>
                                        <td>{{$me->opciones_funcion}}</td>
                                        <td>{{$me->opciones_orden}}</td>
                                        <td style='{{$me->opciones_estado == 0 ? "color: #ff015b;" : " color: #018875;"}}'>{{$me->opciones_estado == 1 ? "Habilitado" : "Deshabilitado"}}</td>
                                        <td>
                                            <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#crear_opciones" onclick="editar_opciones({{$me->id_opciones}})"><i class=" btn_editar fa fa-pencil"></i></button>
                                            @if($me->opciones_estado == 1)
                                                <button class="btn btn-sm" id="btn_anular{{$me->id_opciones}}"  onclick="preguntar('¿Está seguro que desea deshabilitar esta opción?','desabilitar_opcion','Si','No',{{$me->id_opciones}})"><i class="btn_eliminar fa-solid fa-ban"></i></button>
                                            @else
                                                <button class="btn btn-sm" id="btn_anular{{$me->id_opciones}}"  onclick="preguntar('¿Está seguro que desea habilitar esta opción?','habilitar_opciones','Si','No',{{$me->id_opciones}})"><i class="btn_habilitar fa-regular fa-circle-check"></i></button>
                                            @endif
                                            <button class="btn btn-sm  text-white" data-bs-toggle="modal" data-bs-target="#crear_permisos_modal" onclick="permisos_tab_acciones({{$me->id_opciones}})"><i class=" btn_editar fa-solid fa-list"></i></button>

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
<script src="{{asset('js/configuracion.js')}}"></script>
@endsection
