@extends('layouts.plantilla')
@section('content')

{{-- Modal Crear / Editar Almacén --}}
<div class="modal fade" id="modal_crear_almacen" tabindex="-1" aria-labelledby="modalAlmacenLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 modal_title text-dark" id="modalAlmacenLabel">Crear / Editar Almacén</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formularioAlmacen" class="mb-3" method="POST" action="{{ route('Gestion.guardar_almacen') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="estadoActionFuctionAlmacen" id="estadoActionFuctionAlmacen">
                    <input type="hidden" name="id_almacen" id="id_almacen">

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="almacen_codigo" class="form-label">Código</label>
                            <input type="text" name="almacen_codigo" id="almacen_codigo" class="form-control" placeholder="Ej: ALM01">
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 mb-2">
                            <label for="almacen_nombre" class="form-label">Nombre</label>
                            <input type="text" name="almacen_nombre" id="almacen_nombre" class="form-control" placeholder="Nombre del almacén">
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 mb-2">
                            <label for="almacen_sunat" class="form-label">Código SUNAT</label>
                            <input type="text" name="almacen_sunat" id="almacen_sunat" class="form-control" placeholder="Código establecimiento SUNAT">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2 d-flex flex-column justify-content-end">
                            {{--<label class="form-label">Almacén Principal (AP)</label>--}}
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="almacen_ap" id="almacen_ap" value="1">
                                <label class="form-check-label" for="almacen_ap">AP</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" id="btnSaveAlmacen">Guardar registro</button>
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
                        <button class="btn btn-sm btn-success" id="btn_crear_almacen"
                                data-bs-toggle="modal" data-bs-target="#modal_crear_almacen">
                            <i class="fa fa-plus"></i> Agregar Almacén
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
                                    <th>Cód. SUNAT</th>
                                    <th>Principal</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $a = 1 @endphp
                                @foreach($almacenes as $al)
                                    <tr>
                                        <td>{{ $a }}</td>
                                        <td>{{ $al->almacen_codigo ?? '-' }}</td>
                                        <td>{{ $al->almacen_nombre }}</td>
                                        <td>{{ $al->almacen_sunat ?? '-' }}</td>
                                        <td>
                                            @if($al->almacen_ap)
                                                <span class="badge bg-success">Sí</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm bg-primary text-white"
                                                    data-bs-toggle="modal" data-bs-target="#modal_crear_almacen"
                                                    onclick="modificarAlmacen({{ $al->id_almacen }})">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm bg-danger text-white"
                                                    id="btnEliminarAlmacen_{{ $al->id_almacen }}"
                                                    onclick="preguntar('¿Está seguro que desea eliminar este almacén?','eliminar_almacen','Si','No',{{ $al->id_almacen }})">
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
