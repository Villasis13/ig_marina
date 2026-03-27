@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
<div class="modal fade" id="crear_rol_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formulario_crear_rol" class="mb-3"  method="POST" enctype = "multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_rol" id="id_rol">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="nombre_rol" class="form-label">Nombre de Rol</label>
                                <input type="text" name="nombre_rol" id="nombre_rol" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="descripcion_rol" class="form-label">Descripción de Rol</label>
                                <input type="text" name="descripcion_rol" id="descripcion_rol" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 ">
                                <button type="submit" class="btn btn-primary m-1" id="btn_guardar_rol">Guardar Rol</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<div class="modal fade" id="permisos_por_rol_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Permisos por rol</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formulario_permisos_rol" class="mb-3"  method="POST" enctype = "multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_rol_editar" name="id_rol_editar">
                    <div class="modal-body">
                        <div class="row p-3">
                            @foreach($listar_permisos as $v)
                                <div class="col-lg-6">
                                    <ul class="lista_permisos_ul">
                                             <li class="lista_permisos_li"><input type="checkbox" name="check[]" class="me-2 " id="edit_check_permisos_{{ $v->id }}" value="{{ $v->id }}"><label for="edit_check_permisos_{{ $v->id }}" class="text-lowercase">{{ $v->name }}</label>
                                                <ul class="lista_permisos_ul">
                                                    @foreach($v->sub as $s)
                                                        <li class="lista_permisos_li"><input type="checkbox" name="check[]" class="me-2 " id="edit_check_permisos_{{ $s->id }}" value="{{ $s->id }}"><label for="edit_check_permisos_{{ $s->id }}" class="text-lowercase">{{ $s->name }}</label>
                                                            <ul class="lista_permisos_ul">
                                                                @foreach($s->opciones as $o)
                                                                    <li class="lista_permisos_li"><input type="checkbox" name="check[]" class="me-2 " id="edit_check_permisos_{{ $o->id }}" value="{{ $o->id }}"><label for="edit_check_permisos_{{ $o->id }}" class="text-lowercase">{{ $o->name }}</label>
                                                                        <ul class="lista_permisos_ul">
                                                                            @foreach($o->permisos as $p)
                                                                                <li class="lista_permisos_li"><input type="checkbox" name="check[]" class="me-2 " id="edit_check_permisos_{{ $p->id }}" value="{{ $p->id }}"><label for="edit_check_permisos_{{ $p->id }}" class="text-lowercase">{{ $p->name }}</label></li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                    </ul>
                                </div>
                            @endforeach




{{--                            <div class="col-lg-4 col-md-6 col-sm-12" id="contenedor_check_permisos_rol">--}}
{{--                                <?php--}}
{{--                                $contador = 1;--}}
{{--                                ?>--}}
{{--                                @foreach ($listar_permisos as $v)--}}
{{--                                    <div class="d-flex align-items-center mb-2 nombre_check ">--}}
{{--                                        <input type="checkbox" name="check[]" class="me-2 " id="edit_check_permisos_{{ $v->id }}" value="{{ $v->id }}"><label for="edit_check_permisos_{{ $v->id }}" class="text-lowercase">{{ $v->name }}</label>--}}
{{--                                    </div>--}}
{{--                                        <?php if($contador %10==0){--}}
{{--                                        echo '</div><div class="col-4 espacio_left_right">';--}}
{{--                                    }--}}
{{--                                        ?>--}}
{{--                                        <?php $contador++; ?>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn fondo_azul_assu text-white w-50"  id="btn_guardar_permisos" type="submit"><i class="fa fa-save"></i> Guardar Permisos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="tab-content">
        <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="card">
                    <div class="row m-2">
                        <div class="col-lg-2 col-md-12 col-sm-12 d-flex align-items-center">
                            <button class="btn  btn-sm btn-success" id="btn_crear_rol" data-bs-toggle="modal" data-bs-target="#crear_rol_modal"><i class="fa fa-plus"></i> Agregar Rol</button>
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
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Permisos</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $a = 1
                                    @endphp
                                    @foreach($listar_roles as $me)
                                        <tr>
                                            <td>{{$a}}</td>
                                            <td>{{$me->name}}</td>
                                            <td>{{$me->rol_descripcion}}</td>
                                            <td class="{{$me->rol_estado == 1  ? 'color_habilitado' :'color_eliminar'}}">{{$me->rol_estado == 1  ? 'Habilitado' :'Deshabilitado'}}</td>
                                            <td><a data-bs-toggle="modal" data-bs-target="#permisos_por_rol_modal" onclick="editar_permisos_por_rol({{$me->id}})" class="btn btn-sm text-white fondo_azul_assu">{{$me->permisos}}</a></td>
                                            <td>
                                                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#crear_rol_modal" onclick="editar_rol({{$me->id}})"><i class=" btn_editar fa fa-pencil"></i></button>
                                                @if($me->id != 1)
                                                    @if($me->rol_estado == 1)
                                                        <button class="btn btn-sm" id="btn_anular{{$me->id}}"  onclick="preguntar('¿Está seguro que desea deshabilitar este rol?','desabilitar_rol','Si','No',{{$me->id}})"><i class="btn_eliminar fa-solid fa-ban"></i></button>
                                                    @else
                                                        <button class="btn btn-sm" id="btn_anular{{$me->id}}"  onclick="preguntar('¿Está seguro que desea habilitar este rol?','habilitar_rol','Si','No',{{$me->id}})"><i class="btn_habilitar fa-regular fa-circle-check"></i></button>
                                                    @endif
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
    <script>
        let datos = JSON.parse('<?= $listar_permisos ?>');
        console.log(datos);
    </script>
@endsection
