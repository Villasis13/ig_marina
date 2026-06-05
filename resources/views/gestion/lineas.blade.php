@extends('layouts.plantilla')
@section('content')

{{-- Modal Crear / Editar Línea --}}
<div class="modal fade" id="modal_crear_linea" tabindex="-1" aria-labelledby="modalLineaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 modal_title text-dark" id="modalLineaLabel">Crear / Editar Línea</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formularioLinea" class="mb-3" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="estadoActionFuctionLinea" id="estadoActionFuctionLinea">
                    <input type="hidden" name="id_linea" id="id_linea">

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="linea_codigo" class="form-label">Código</label>
                            <input type="text" name="linea_codigo" id="linea_codigo" class="form-control" placeholder="Ej: L001">
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 mb-2">
                            <label for="linea_descripcion" class="form-label">Descripción</label>
                            <input type="text" name="linea_descripcion" id="linea_descripcion" class="form-control" placeholder="Descripción de la línea">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="linea_tipo" class="form-label">Tipo <small class="text-muted">(opcional)</small></label>
                            <input type="text" name="linea_tipo" id="linea_tipo" class="form-control" placeholder="Tipo de línea">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" id="btnSaveLinea">Guardar registro</button>
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
                        <button class="btn btn-sm btn-success" id="btn_crear_linea"
                                data-bs-toggle="modal" data-bs-target="#modal_crear_linea">
                            <i class="fa fa-plus"></i> Agregar Línea
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
                                    <th>Descripción</th>
                                    <th>Tipo</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $a = 1 @endphp
                                @foreach($lineas as $l)
                                    <tr>
                                        <td>{{ $a }}</td>
                                        <td>{{ $l->linea_codigo }}</td>
                                        <td>{{ $l->linea_descripcion }}</td>
                                        <td>{{ $l->linea_tipo ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm bg-primary text-white" data-bs-toggle="modal" data-bs-target="#modal_crear_linea" onclick="modificarLinea({{ $l->id_linea }})">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>

                                            <button class="btn btn-sm bg-danger text-white" id="btnEliminarLinea_{{ $l->id_linea }}" onclick="preguntar('¿Está seguro que desea eliminar esta línea?','eliminar_linea','Si','No',{{ $l->id_linea }})">
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
