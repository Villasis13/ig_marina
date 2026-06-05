@extends('layouts.plantilla')
@section('content')

{{-- Modal Crear / Editar Clasificador --}}
<div class="modal fade" id="modal_crear_clasificador" tabindex="-1" aria-labelledby="modalClasificadorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 modal_title text-dark" id="modalClasificadorLabel">Crear / Editar Clasificador</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formularioClasificador" class="mb-3" method="POST"  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="estadoActionFuctionClasificador" id="estadoActionFuctionClasificador">
                    <input type="hidden" name="id_clasificador" id="id_clasificador">

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="clasificador_codigo" class="form-label">Código</label>
                            <input type="text" name="clasificador_codigo" id="clasificador_codigo" class="form-control" placeholder="Ej: C001">
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 mb-2">
                            <label for="clasificador_nombre" class="form-label">Nombre</label>
                            <input type="text" name="clasificador_nombre" id="clasificador_nombre" class="form-control" placeholder="Nombre del clasificador">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" id="btnSaveClasificador">Guardar registro</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="tab-content">
    <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active" role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" tabindex="0">

        {{-- Botón agregar --}}
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card">
                <div class="row m-2">
                    <div class="col-lg-3 col-md-12 col-sm-12 d-flex align-items-center">
                        <button class="btn btn-sm btn-success" id="btn_crear_clasificador"
                                data-bs-toggle="modal" data-bs-target="#modal_crear_clasificador">
                            <i class="fa fa-plus"></i> Agregar Clasificador
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="card">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card-body table-responsive">
                            <table class="pt-2 pb-2 w-100 h-100 table table-hover" id="dataTable13">
                                <thead>
                                <tr class="encabezado_tabla_color">
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $a = 1 @endphp
                                @foreach($clasificadores as $cl)
                                    <tr>
                                        <td>{{ $a }}</td>
                                        <td>{{ $cl->clasificador_codigo }}</td>
                                        <td>{{ $cl->clasificador_nombre }}</td>
                                        <td>
                                            <button class="btn btn-sm bg-primary text-white"
                                                    data-bs-toggle="modal" data-bs-target="#modal_crear_clasificador"
                                                    onclick="modificarClasificador({{ $cl->id_clasificador }})">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm bg-danger text-white"
                                                    id="btnEliminarClasificador_{{ $cl->id_clasificador }}"
                                                    onclick="preguntar('¿Está seguro que desea eliminar este clasificador?','eliminar_clasificador','Si','No',{{ $cl->id_clasificador }})">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
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

<script src="{{ asset('js/domain.js') }}"></script>
<script src="{{ asset('js/gestion.js') }}"></script>

@endsection
