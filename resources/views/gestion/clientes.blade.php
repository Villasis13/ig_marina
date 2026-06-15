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
                        {{-- Tipo persona + Tipo documento --}}
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="cliente_tipo_persona" class="form-label">Tipo de Persona</label>
                            <select name="cliente_tipo_persona" id="cliente_tipo_persona" class="form-select">
                                <option value="natural">Persona Natural</option>
                                <option value="juridica">Persona Jurídica</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="id_tipo_documento" class="form-label">Tipo Documento</label>
                            <select name="id_tipo_documento" class="form-select" id="id_tipo_documento">
                                @foreach($tipoDocumentos as $tipo)
                                    <option value="{{$tipo->id_tipo_documento}}">{{$tipo->tipo_documento_identidad_abr}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Documento + Nombre --}}
                        <div class="col-lg-5 col-md-5 col-sm-12 mb-2">
                            <label for="cliente_numero" class="form-label">N° Documento</label>
                            <input type="text" name="cliente_numero" id="cliente_numero" class="form-control">
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12 mb-2">
                            <label for="cliente_nombre_general" class="form-label">Nombre Completo</label>
                            <input type="text" name="cliente_nombre_general" id="cliente_nombre_general" class="form-control">
                        </div>
                        {{-- Sexo + Atención --}}
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="cliente_sexo" class="form-label">Sexo</label>
                            <select name="cliente_sexo" id="cliente_sexo" class="form-select">
                                <option value="">-- No aplica --</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 mb-2">
                            <label for="cliente_atencion" class="form-label">Atención (Contacto)</label>
                            <input type="text" name="cliente_atencion" id="cliente_atencion" class="form-control" placeholder="Nombre de la persona de contacto">
                        </div>
                        {{-- Teléfono + Email --}}
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="cliente_telefono" class="form-label">Teléfono</label>
                            <input type="text" name="cliente_telefono" id="cliente_telefono" onkeyup="validar_numeros(this.id)" class="form-control">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="cliente_correo" class="form-label">Correo electrónico</label>
                            <input type="email" name="cliente_correo" id="cliente_correo" class="form-control">
                        </div>
                        {{-- Dirección --}}
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="cliente_direccion" class="form-label">Dirección</label>
                            <textarea name="cliente_direccion" id="cliente_direccion" rows="2" class="form-control"></textarea>
                        </div>
                        {{-- Contribuyente --}}
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="cliente_contribuyente" class="form-label">Tipo de Contribuyente</label>
                            <select name="cliente_contribuyente" id="cliente_contribuyente" class="form-select">
                                <option value="">Seleccionar</option>
                                <option value="1">01 Cliente</option>
                                <option value="2">02 Empleado</option>
                                <option value="3">03 Transporte</option>
                                <option value="4">04 Sujeto ND</option>
                            </select>
                        </div>
                        {{-- Ubigeo: Departamento → Provincia → Distrito --}}
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1"><small class="text-muted">Ubigeo</small></div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <select id="cli_dept" class="form-select" onchange="ubigeo_cargar_provincias(this.value,'cli_prov','cli_dist')">
                                <option value="">Departamento</option>
                                @foreach($departamentos as $d)
                                    <option value="{{$d->id}}">{{$d->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <select id="cli_prov" class="form-select" onchange="ubigeo_cargar_distritos(this.value,'cli_dist')">
                                <option value="">Provincia</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <select id="cli_dist" name="cliente_ubigeo" class="form-select">
                                <option value="">Distrito</option>
                            </select>
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
                        <button class="btn  btn-sm btn-success" id="btnCliente" data-bs-toggle="modal" data-bs-target="#modalCrearClientes"><i class="fa fa-plus"></i> Agregar Contribuyente</button>
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
                                        <th>Tipo</th>
                                        <th>Documento</th>
                                        <th>Nombre / Razón</th>
                                        <th>Sexo</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Ubigeo</th>
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
                                            <td><span class="badge {{$cli->cliente_tipo_persona == 'juridica' ? 'bg-primary' : 'bg-success'}}">{{ucfirst($cli->cliente_tipo_persona ?? 'natural')}}</span><br><small>{{$cli->tipo_documento_identidad_abr}}</small></td>
                                            <td>{{$cli->cliente_numero}}</td>
                                            <td>{{$cli->id_tipo_documento == 4 ? $cli->cliente_razonsocial : $cli->cliente_nombre}}</td>
                                            <td>{{$cli->cliente_sexo == 'M' ? 'Masc.' : ($cli->cliente_sexo == 'F' ? 'Fem.' : '-')}}</td>
                                            <td>{{$cli->cliente_telefono ?? '-'}}</td>
                                            <td>{{$cli->cliente_correo ?? '-'}}</td>
                                            <td>{{$cli->distrito ? $cli->distrito.', '.$cli->provincia : '-'}}</td>
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
