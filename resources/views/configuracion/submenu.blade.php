@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
<div class="modal fade" id="crear_submenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formulario_crear_submenu" class="mb-3"  method="POST" enctype = "multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_submenu" id="id_submenu">
                        <input type="hidden" name="id_menu" id="id_menu" value="{{$ID}}">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="nombre_submenu" class="form-label">Nombre</label>
                                <input type="text" name="nombre_submenu" id="nombre_submenu" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <label for="controlador_submenu" class="form-label">Función</label>
                                <input type="text" name="controlador_submenu" id="controlador_submenu" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="orden_submenu" class="form-label">Orden</label>
                                <input type="text" name="orden_submenu" id="orden_submenu" class="form-control w-100 m-1">
                            </div>

                            <div class=" col-lg-6 col-md-12 col-sm-12 d-flex align-items-center">
                                <label for="visible_submenu" class="w-50 form-label">Visibilidad</label>
                                <label class="check">
                                    <input type="checkbox" id="visible_submenu"  name="visible_submenu">
                                    <span class="check1"></span>
                                </label>
                            </div>
                        </div>
                </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_guardar_submenu">Guardar Submenu</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<div class="modal fade" id="permisos_por_vista" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Permisos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn_guardar_submenu">Guardar Submenu</button>
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
                    <div class="col-lg-2 col-md-6 col-sm-6 d-flex align-items-center">
                        <button class="btn btn-sm btn-success" id="btn_crear_submenus" data-bs-toggle="modal" data-bs-target="#crear_submenu"><i class="fa fa-plus"></i> Agregar Submenu</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card ">
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
                                    <th>Mostrar</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $a = 1
                                @endphp
                                @foreach($listar_submenu as $me)
                                    <tr>
                                        <td>{{$a}}</td>
                                        <td>{{$me->submenu_nombre}}</td>
                                        <td>{{$me->submenu_funcion}}</td>
                                        <td>{{$me->submenu_orden}}</td>
                                        <td>{{$me->submenu_mostrar == 1 ? "Si" : "No"}}</td>
                                        <td style='{{$me->submenu_estado == 0 ? "color: #ff015b;" : " color: #018875;"}}'>{{$me->submenu_estado == 1 ? "Habilitado" : "Deshabilitar"}}</td>
                                        <td><a href="{{url('configuracion/opciones/'.$me->id_submenu)}}" class="btn btn-sm text-white fondo_azul_assu">{{$me->contar}}</a></td>
                                        <td>
                                            <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#crear_submenu" onclick="editar_submenu({{$me->id_submenu}})"><i class=" btn_editar fa fa-pencil"></i></button>
                                            @if($me->submenu_estado == 1)
                                                <button class="btn btn-sm" id="btn_anular{{$me->id_submenu}}"  onclick="preguntar('¿Está seguro que desea deshabilitar este submenu?','desabilitar_submenu','Si','No',{{$me->id_submenu}})"><i class="btn_eliminar fa-solid fa-ban"></i></button>
                                            @else
                                                <button class="btn btn-sm" id="btn_anular{{$me->id_submenu}}"  onclick="preguntar('¿Está seguro que desea habilitar este submenu?','habilitar_submenu','Si','No',{{$me->id_submenu}})"><i class="btn_habilitar fa-regular fa-circle-check"></i></button>
                                            @endif

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
