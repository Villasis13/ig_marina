@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
<div class="modal fade" id="crear_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title" id="exampleModalLabel">Crear / Editar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formulario_crear_usuario" class="mb-3"  method="POST" enctype = "multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_users" id="id_users">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <label for="nombre_persona" class="form-label">Nombre</label>
                                <input type="text" name="nombre_persona" id="nombre_persona" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="username" class="form-label">Nombre de Usuario</label>
                                <input type="text" name="username" id="username" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="persona_apellido_paterno" class="form-label">Apellido Paterno</label>
                                <input type="text" name="persona_apellido_paterno" id="persona_apellido_paterno" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="persona_apellido_materno" class="form-label">Apellido Materno</label>
                                <input type="text" name="persona_apellido_materno" id="persona_apellido_materno" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="persona_fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
                                <input type="date" name="persona_fecha_nacimiento" id="persona_fecha_nacimiento" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="tipo_documento" class="form-label">Tipo Documento</label>
                                <select name="tipo_documento" id="tipo_documento" class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listar_tipo_documento as $l)
                                        <option value="{{$l->id_tipo_documento}}">{{$l->tipo_documento_identidad_abr}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="id_roles" class="form-label">Roles</label>
                                <select name="id_roles" id="id_roles" class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($roles as $l)
                                        <option value="{{$l->id}}">{{$l->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="numero_doc" class="form-label">N° Documento</label>
                                <input type="text" name="numero_doc" id="numero_doc" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <label for="telefono" class="form-label">N° Telefono</label>
                                <input type="text" name="telefono" id="telefono" class="form-control w-100 m-1">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 " id="contrasena_div">
                                <div class="form-password-toggle">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password">Contraseña</label>
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="password"
                                            id="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password"
                                        />
                                        <span class="input-group-text cursor-pointer -1"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 " id="contrasena_div2">
                                <div class="form-password-toggle">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="repetir_contrasena">Repetir Contraseña</label>
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="password"
                                            id="repetir_contrasena"
                                            class="form-control "
                                            name="repetir_contrasena"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password"
                                        />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-center">
                                <label for="foto_users" class="contenedor_previsualizacion mt-3 cursor-pointer">
                                    <img src="{{asset('sin-fotografia.png')}}" alt="" id="imagen_usuario" style="width: 100%">
                                </label>
                                <input type="file" name="foto_users" id="foto_users" class="d-none" onchange="previewImage(this ,'imagen_usuario')">
                            </div>


{{--                            <div class=" col-lg-6 col-md-12 col-sm-12 d-flex align-items-center">--}}
{{--                                <label for="visible" class="w-50 form-label">Visibilidad</label>--}}
{{--                                <label class="check">--}}
{{--                                    <input type="checkbox" id="visible"  name="visible">--}}
{{--                                    <span class="check1"></span>--}}
{{--                                </label>--}}
{{--                            </div>--}}
                        </div>
                </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_guardar_usuarios">Guardar Usuario</button>
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
                            <button class="btn  btn-sm btn-success" id="btn_crear_usuario" data-bs-toggle="modal" data-bs-target="#crear_usuario"><i class="fa fa-plus"></i> Agregar Usuarios</button>
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
                                        <th>Usuario</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Correo</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $a = 1
                                    @endphp
                                    @foreach($listar_usuarios as $me)
                                        <tr>
                                            <td>{{$a}}</td>
                                            <td>{{$me->nombre_users}}</td>
                                            <td>{{$me->name}}</td>
                                            <td class="{{$me->users_estado == 1  ? 'color_habilitado' :'color_eliminar'}}">{{$me->users_estado == 1  ? 'Habilitado' :'Deshabilitado'}}</td>
                                            <td>{{$me->email}}</td>
                                            <td>{{$me->persona_nombre}}</td>
                                            <td>{{$me->persona_apellido_paterno." ".$me->persona_apellido_materno}}</td>
                                            <td>
                                                @if($a != 1)
                                                    <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#crear_usuario" onclick="editar_usuario({{$me->id_users}})"><i class=" btn_editar fa fa-pencil"></i></button>
                                                    @if($me->users_estado == 1)
                                                        <button class="btn btn-sm" id="btn_anular{{$me->id_users}}"  onclick="preguntar('¿Está seguro que desea deshabilitar este usuario?','desabilitar_usuario','Si','No',{{$me->id_users}})"><i class="btn_eliminar fa-solid fa-ban"></i></button>
                                                    @else
                                                        <button class="btn btn-sm" id="btn_anular{{$me->id_users}}"  onclick="preguntar('¿Está seguro que desea habilitar este usuario?','habilitar_usuario','Si','No',{{$me->id_users}})"><i class="btn_habilitar fa-regular fa-circle-check"></i></button>
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
@endsection
