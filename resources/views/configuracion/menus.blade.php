@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
<div class="modal fade" id="crear_menu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formulario_crear_menu" class="mb-3"  method="POST" enctype = "multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="editar_menu" id="editar_menu">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="controlador_menu" class="form-label">Controlador</label>
                                <input type="text" name="controlador_menu" id="controlador_menu" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="nombre_menu" class="form-label">Nombre</label>
                                <input type="text" name="nombre_menu" id="nombre_menu" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="icono_menu" class="form-label">Icono</label>
                                <input type="text" name="icono_menu" id="icono_menu" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="orden_menu" class="form-label">Orden</label>
                                <input type="text" name="orden_menu" id="orden_menu" class="form-control w-100 m-1">
                            </div>

                            <div class=" col-lg-6 col-md-12 col-sm-12 d-flex align-items-center">
                                <label for="visible" class="w-50 form-label">Visibilidad</label>
                                <label class="check">
                                    <input type="checkbox" id="visible"  name="visible">
                                    <span class="check1"></span>
                                </label>
                            </div>
                        </div>
                </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_guardar_menu">Guardar Menu</button>
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
                        <button class="btn  btn-sm btn-success" id="btn_crear_menus" data-bs-toggle="modal" data-bs-target="#crear_menu"><i class="fa fa-plus"></i> Agregar Menu</button>
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
                                    <th>Controlador</th>
                                    <th>Icono</th>
                                    <th>Orden</th>
                                    <th>Mostrar</th>
                                    <th>Estado</th>
                                    <th>Submenus</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $a = 1
                                @endphp
                                @foreach($lista_menus as $me)
                                    <tr>
                                        <td>{{$a}}</td>
                                        <td>{{$me->menu_nombre}}</td>
                                        <td>{{$me->menu_controlador}}</td>
                                        <td>{{$me->menu_icono}}</td>
                                        <td>{{$me->menu_orden}}</td>
                                        <td>{{$me->menu_mostrar == 1 ? "Si" : "No"}}</td>
                                        <td style='{{$me->menu_estado == 0 ? "color: #ff015b;" : " color: #018875;"}}'>{{$me->menu_estado == 1 ? "Habilitado" : "Deshabilitar"}}</td>
                                        <td><a href="{{url('configuracion/submenu/'.$me->id_menu)}}" class="btn btn-sm text-white fondo_azul_assu">{{$me->contar}}</a></td>
                                        <td>
                                            <button class="btn btn-sm" title="Editar Menu" data-bs-toggle="modal" data-bs-target="#crear_menu" onclick="editar_menu_({{$me->id_menu}})"><i class=" btn_editar fa fa-pencil"></i></button>
                                            @if($me->menu_estado == 1)
                                                <button class="btn btn-sm" title="Deshabilitar" id="btn_anular{{$me->id_menu}}"  onclick="preguntar('¿Está seguro que desea deshabilitar este menu?','desabilitar_menu','Si','No',{{$me->id_menu}})"><i class="btn_eliminar fa-solid fa-ban"></i></button>
                                            @else
                                                <button class="btn btn-sm" title="Habilitar" id="btn_anular{{$me->id_menu}}"  onclick="preguntar('¿Está seguro que desea habilitar este menu?','habilitar_menu','Si','No',{{$me->id_menu}})"><i class="btn_habilitar fa-regular fa-circle-check"></i></button>
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
