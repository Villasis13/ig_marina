@extends('layouts.plantilla')
@section('content')

{{-- Modal Crear / Editar Unidad de Manejo --}}
<div class="modal fade" id="modal_crear_um" tabindex="-1" aria-labelledby="modalUMLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 modal_title text-dark" id="modalUMLabel">Crear / Editar Unidad de Manejo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formularioUM" class="mb-3" method="POST" action="{{ route('Gestion.guardar_unidad_manejo') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="estadoActionFuctionUM" id="estadoActionFuctionUM">
                    <input type="hidden" name="id_unidad_manejo" id="id_unidad_manejo">

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="um_codigo" class="form-label">Código</label>
                            <input type="text" name="unidad_manejo_codigo" id="um_codigo" class="form-control" placeholder="Ej: UM01">
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 mb-2">
                            <label for="um_sunat" class="form-label">Código SUNAT</label>
                            <input type="text" name="unidad_manejo_sunat" id="um_sunat" class="form-control" placeholder="Código SUNAT">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="um_id_medida" class="form-label">Medida</label>
                            <div class="d-flex align-items-center gap-2">
                                <select name="id_medida" id="um_id_medida" class="form-select"
                                        onchange="um_mostrar_abreviatura(this)">
                                    <option value="">Seleccionar medida</option>
                                    @foreach($medidas as $m)
                                        <option value="{{ $m->id_medida }}"
                                                data-abr="{{ $m->medida_codigo_unidad }}">
                                            {{ $m->medida_nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="badge bg-secondary fs-6 px-3 py-2" id="um_abreviatura" style="min-width:60px; text-align:center;">—</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" id="btnSaveUM">Guardar registro</button>
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
                        <button class="btn btn-sm btn-success" id="btn_crear_um"
                                data-bs-toggle="modal" data-bs-target="#modal_crear_um">
                            <i class="fa fa-plus"></i> Agregar Unidad de Manejo
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
                                    <th>Medida</th>
                                    <th>Cód. SUNAT</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $a = 1 @endphp
                                @foreach($unidad_manejos as $um)
                                    <tr>
                                        <td>{{ $a }}</td>
                                        <td>{{ $um->unidad_manejo_codigo }}</td>
                                        <td>
                                            {{ $um->medida_nombre ?? '-' }}
                                            @if($um->medida_codigo_unidad)
                                                <span class="badge bg-secondary ms-1">{{ $um->medida_codigo_unidad }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $um->unidad_manejo_sunat ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm bg-primary text-white"
                                                    data-bs-toggle="modal" data-bs-target="#modal_crear_um"
                                                    onclick="modificarUM({{ $um->id_unidad_manejo }})">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm bg-danger text-white"
                                                    id="btnEliminarUM_{{ $um->id_unidad_manejo }}"
                                                    onclick="preguntar('¿Está seguro que desea eliminar esta unidad de manejo?','eliminar_um','Si','No',{{ $um->id_unidad_manejo }})">
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
