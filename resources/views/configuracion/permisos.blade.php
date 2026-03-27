@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
<div class="modal fade" id="crear_permisos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title " id="exampleModalLabel">Crear / Editar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formulario_crear_permisos" class="mb-3"  method="POST" enctype = "multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="nombre_permisos" class="form-label">Nombre de Permisos</label>
                                <input type="text" name="nombre_permisos" id="nombre_permisos" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 ">
                                <button type="submit" class="btn btn-primary m-1" id="btn_guardar_permisos">Guardar Permiso</button>
                            </div>
                        </div>
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
                            <button class="btn  btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#crear_permisos"><i class="fa fa-plus"></i> Agregar Permisos</button>
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
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $a = 1 @endphp
                                    @foreach($lista_permisos as $l)
                                        <tr>
                                            <td>{{$a}}</td>
                                            <td>{{$l->name}}</td>
                                            <td class="{{$l->permiso_estado == 1 ? 'color_habilitado' : 'color_eliminar'}}">{{$l->permiso_estado == 1 ? 'Habilitado' : 'Deshabilitado'}}</td>
                                            <td>
                                                @if($l->permiso_estado == 1)
                                                    <button class="btn btn-sm" id="btn_anular{{$l->id}}"  onclick="preguntar('¿Está seguro que desea deshabilitar este permiso?','desabilitar_permiso','Si','No',{{$l->id}})"><i class="btn_eliminar fa-solid fa-ban"></i></button>
                                                @else
                                                    <button class="btn btn-sm" id="btn_anular{{$l->id}}"  onclick="preguntar('¿Está seguro que desea habilitar este permiso?','habilitar_permiso','Si','No',{{$l->id}})"><i class="btn_habilitar fa-regular fa-circle-check"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                        @php $a++ @endphp
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
