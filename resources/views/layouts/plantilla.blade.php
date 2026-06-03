<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================
By: Eder Alfredo
=========================================================
 -->
<!-- beautify ignore:start -->
<html
    lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>INVERSIONES GENERALES LA MARINA S.R.L.</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"  href="{{asset('isologoIGLM.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href=" https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    {{-- ICONOS    --}}
    <link rel="stylesheet" href="{{asset('fontawasone/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-icons.css')}}">
    {{-- FIN DE ICONOS    --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    <link rel="stylesheet" href="{{asset('css/datatable.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin_global.css')}}?v=6">
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/helpers.js')}}"></script>
    <script src="{{ asset('assets/js/config.js')}}"></script>
    <script src="{{asset('js/jquery-3.6.3.min.js')}}"></script>
    <style>
        p{
            margin: 0px;
        }
    </style>
</head>

<body>

<div class="modal fade" id="modificarDatosPersonales" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Datos Personales</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formularioDatosPersonalesLogueado"  method="POST" enctype = "multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="nombre_persona_editarDatosPersonales" class="form-label">Nombre</label>
                            <input type="text" name="nombre_persona_editarDatosPersonales" id="nombre_persona_editarDatosPersonales" class="form-control w-100">
                            <input type="hidden" name="estado_accion_editar_usuario" id="estado_accion_editar_usuario" class="form-control w-100">
                            <input type="hidden" name="id_persona_editarLogueado" id="id_persona_editarLogueado" class="form-control w-100">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <label for="apellido_paterno_editarDatosPersonales" class="form-label">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno_editarDatosPersonales" id="apellido_paterno_editarDatosPersonales" class="form-control w-100">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <label for="apellido_materno_editarDatosPersonales" class="form-label">Apellido Materno</label>
                            <input type="text" name="apellido_materno_editarDatosPersonales" id="apellido_materno_editarDatosPersonales" class="form-control w-100">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <label for="fecha_nacimiento_editarDatosPersonales" class="form-label">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nacimiento_editarDatosPersonales" id="fecha_nacimiento_editarDatosPersonales" class="form-control w-100">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <label for="numero_telefono_editarDatosPersonales" class="form-label">Número de Teléfono </label>
                            <input type="text" name="numero_telefono_editarDatosPersonales" id="numero_telefono_editarDatosPersonales" class="form-control w-100">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col sm-12">
                        <p id="mensajeErrorDatosPersonales" class="text-danger"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnModificarUsuarioPersona"><i class="fa-solid fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modificarDatosUsuarioLogueado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Datos del Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formularioDatosUsuarioLogueado"  method="POST" enctype = "multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="nombre_usuario_editarDatosLogueado" class="form-label">Nombre</label>
                            <input type="text" name="nombre_usuario_editarDatosLogueado" id="nombre_usuario_editarDatosLogueado" class="form-control w-100">
                            <input type="hidden" name="estado_accion_editar_usuario" id="estado_accion_editar_usuario2" class="form-control w-100">
                            <input type="hidden" name="id_usuario_editarLogueado2" id="id_usuario_editarLogueado2" class="form-control w-100">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="email_usuario_editarDatosLogueado" class="form-label">Email </label>
                            <input type="text" name="email_usuario_editarDatosLogueado" id="email_usuario_editarDatosLogueado" class="form-control w-100">
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="modificarFotoUsuarioLogueado" class="form-label">Foto de Perfil</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="modificarFotoUsuarioLogueado" id="modificarFotoUsuarioLogueado" aria-describedby="modificarFotoUsuarioLogueado" >
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col sm-12">
                        <p id="mensajeErrorDatosUsuariosLogueado" class="text-danger"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnModificarUsuarioLogueado"><i class="fa-solid fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modificarContrasenasUsuarioLogueado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar Contraseña</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formularioContrasenaNueva"  method="POST" enctype = "multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <label for="contraseñaUsuarioLogueadoNuevo" class="form-label">Nueva Contraseña</label>
                            <input type="password" name="contraseñaUsuarioLogueadoNuevo" id="contraseñaUsuarioLogueadoNuevo" class="form-control w-100">
                            <input type="hidden" name="estado_accion_editar_usuario" value="3" id="estado_accion_editar_usuario3" class="form-control w-100">
                            <input type="hidden" name="id_usuarioLogueadoContrasenaNueva" value="{{\Illuminate\Support\Facades\Auth::id()}}" id="id_usuarioLogueadoContrasenaNueva" class="form-control w-100">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <label for="repetContrasenaNuevaUsuario" class="form-label">Repetir Contraseña </label>
                            <input type="password" name="repetContrasenaNuevaUsuario" id="repetContrasenaNuevaUsuario" class="form-control w-100">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col sm-12">
                        <p id="mensajeErrorDatosUsuariosContrasena" class="text-danger"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnModificarContrasenaUsuarioLogueado"><i class="fa-solid fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--<body class="{{ cookie('dark_mode', 'false') ? 'dark-mode' : '' }}">--}}
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu navbar-->
       @include('layouts.navbar')
        <!-- / Menu navbar-->
        <!-- Layout container -->
        <div class="layout-page">
            <!-- header navbar -->
            @include('layouts.header')
            <!-- / header navbar -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        @if(Request::route()->getName() != "admin")
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                            <div class="card">
                                <div class="row nav nav-tabs" id="myTab" role="tablist">
                                    @php $a = 1 @endphp
                                        @if(isset($opciones))
                                            @if($opciones != null)
                                                @if(count($opciones) > 0)
                                                @foreach($opciones as $op)
                                                    @if($a === 1)
                                                        @can($op->opciones_funcion)
                                                            <div class="col-lg-3 col-md-6 col-sm-12 nav-item d-flex align-items-center justify-content-center">
                                                                <a class="btn btn-sm w-100 m-2 nav-link  active" id="opciones_{{$op->id_opciones}}" data-bs-toggle="tab"   href="#vista_para_opciones_{{$op->id_opciones}}"  role="tab" aria-controls="#vista_para_opciones_{{$op->id_opciones}}" aria-selected="true"  style="font-size: 14px;color: black;border-right: 20px!important;">
                                                                    {{ $op->opciones_nombre }}
                                                                </a>
                                                            </div>
                                                        @endcan
                                                            <?php $a++; ?>
                                                    @else
                                                        @can($op->opciones_funcion)
                                                            <div class="col-lg-3 col-md-6 col-sm-12 nav-item d-flex align-items-center justify-content-center">
                                                                <a class="btn btn-sm  w-100 m-2 nav-link " id="opciones_{{$op->id_opciones}}" data-bs-toggle="tab" href="#vista_para_opciones_{{$op->id_opciones}}"  role="tab" aria-controls="#vista_para_opciones_{{$op->id_opciones}}" aria-selected="false"  style="font-size: 14px;color: black;border-right: 20px!important;">
                                                                    {{ $op->opciones_nombre }}
                                                                </a>
                                                            </div>
                                                        @endcan
                                                    @endif
                                                @endforeach
                                            @endif
                                            @endif
                                        @else
                                        <div class="col-lg-3 col-md-6 col-sm-12 d-flex align-items-center justify-content-center">
                                            <button class="btn btn-sm w-100 m-2 " role="tab"  aria-selected="true" type="button" style="font-size: 14px;opacity: 0">
                                            </button>
                                        </div>
                                        @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
                <div class="content-backdrop fade"></div>
            </div>

            @include('layouts.footer')

        </div>
        <!-- / Layout page -->
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<script src="{{asset('js/jquery-3.6.3.min.js')}}"></script>
{{--<script src="{{asset('js/jquery-ui.min.js')}}"></script>--}}
{{--<script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>--}}
<script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/vendor/js/menu.js')}}"></script>
{{--<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>--}}
<script src="{{asset('assets/js/main.js')}}"></script>
{{--<script src="{{asset('assets/js/ui-toasts.js')}}"></script>--}}
<script src="{{asset('js/domain.js')}}"></script>
<script src="{{asset('js/tours.js')}}"></script>
<script src="{{asset('js/datatable.js')}}"></script>
<script src="{{asset('js/datatable/datatable_1.js')}}"></script>
<script src="{{asset('js/datatable/datatable_2.js')}}"></script>
<script src="{{asset('js/datatable/datatable_3.js')}}"></script>
<script src="{{asset('js/admin.js')}}"></script>

{{--<script src="{{asset('js/configuracion.js')}}"></script>--}}
{{--<script src="{{asset('js/select2.min.js')}}"></script>--}}

<script >
    // Obtén el tab activo almacenado en localStorage o utiliza el primero como predeterminado
   $(document).ready(function() {
       var activeTab = localStorage.getItem('activeTab') || 'opciones_{{ $opciones != null ? $opciones[0]->id_opciones : ' '}}';
       // Activa la pestaña correspondiente
       $('#myTab a[href="#' + activeTab + '"]').tab('show');
       // Guarda el estado del tab activo cuando se cambia de pestaña
       $('#myTab a').on('shown.bs.tab', function (e) {
           var tabId = e.target.getAttribute('href').substr(1); // Obtén el id de la pestaña
           localStorage.setItem('activeTab', tabId); // Almacena el id en localStorage
       });
})
</script>
</body>
</html>
