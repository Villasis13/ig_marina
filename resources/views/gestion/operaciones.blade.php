@extends('layouts.plantilla')
@section('content')

{{-- Modal Crear / Editar Operación --}}
<div class="modal fade" id="modal_crear_operacion" tabindex="-1" aria-labelledby="modalOperacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 modal_title text-dark" id="modalOperacionLabel">Crear / Editar Operación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formularioOperacion" class="mb-3" method="POST" action="{{ route('Gestion.guardar_operacion') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="estadoActionFuctionOperacion" id="estadoActionFuctionOperacion">
                    <input type="hidden" name="id_operacion" id="id_operacion">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="operacion_tipo" class="form-label">Tipo</label>
                            <input type="text" name="operacion_tipo" id="operacion_tipo" class="form-control" placeholder="Tipo de operación">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="operacion_operacion" class="form-label">Operación</label>
                            <select name="operacion_operacion" id="operacion_operacion" class="form-select">
                                <option value="">Seleccionar</option>
                                <option value="entrada">Entrada</option>
                                <option value="salida">Salida</option>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="operacion_descripcion" class="form-label">Descripción</label>
                            <input type="text" name="operacion_descripcion" id="operacion_descripcion" class="form-control" placeholder="Descripción de la operación">
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1">
                            <small class="fw-bold text-secondary text-uppercase">Configuración</small>
                            <hr class="mt-1 mb-2">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="operacion_stock" id="operacion_stock" value="1">
                                <label class="form-check-label" for="operacion_stock">Afecta Stock</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="operacion_compra" id="operacion_compra" value="1">
                                <label class="form-check-label" for="operacion_compra">Afecta Compra</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="operacion_promediar" id="operacion_promediar" value="1">
                                <label class="form-check-label" for="operacion_promediar">Promediar</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" id="btnSaveOperacion">Guardar registro</button>
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
                        <button class="btn btn-sm btn-success" id="btn_crear_operacion"
                                data-bs-toggle="modal" data-bs-target="#modal_crear_operacion">
                            <i class="fa fa-plus"></i> Agregar Operación
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
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>Operación</th>
                                    <th>Stock</th>
                                    <th>Compra</th>
                                    <th>Promediar</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $a = 1 @endphp
                                @foreach($operaciones as $op)
                                    <tr>
                                        <td>{{ $a }}</td>
                                        <td>{{ $op->operacion_tipo }}</td>
                                        <td>{{ $op->operacion_descripcion }}</td>
                                        <td>
                                            @if($op->operacion_operacion === 'entrada')
                                                <span class="badge bg-success">Entrada</span>
                                            @elseif($op->operacion_operacion === 'salida')
                                                <span class="badge bg-danger">Salida</span>
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td><span class="badge {{ $op->operacion_stock ? 'bg-primary' : 'bg-secondary' }}">{{ $op->operacion_stock ? 'Sí' : 'No' }}</span></td>
                                        <td><span class="badge {{ $op->operacion_compra ? 'bg-primary' : 'bg-secondary' }}">{{ $op->operacion_compra ? 'Sí' : 'No' }}</span></td>
                                        <td><span class="badge {{ $op->operacion_promediar ? 'bg-primary' : 'bg-secondary' }}">{{ $op->operacion_promediar ? 'Sí' : 'No' }}</span></td>
                                        <td>
                                            <button class="btn btn-sm bg-primary text-white"
                                                    data-bs-toggle="modal" data-bs-target="#modal_crear_operacion"
                                                    onclick="modificarOperacion({{ $op->id_operacion }})">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm bg-danger text-white"
                                                    id="btnEliminarOperacion_{{ $op->id_operacion }}"
                                                    onclick="preguntar('¿Está seguro que desea eliminar esta operación?','eliminar_operacion','Si','No',{{ $op->id_operacion }})">
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
