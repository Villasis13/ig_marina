@extends('layouts.plantilla')
@section('content')
    <!-- Modal -->
<div class="modal fade" id="modal_crear_productos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formularioAgregarProductos" class="mb-3"  method="POST" enctype = "multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="estadoActionFuctionProductos" id="estadoActionFuctionProductos">
                    <input type="hidden" name="id_pro" id="id_pro">
                    {{-- Datos del producto en JSON para cascade JS --}}
                    <script>
                        var _categorias_data = @json($cate);
                    </script>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center mb-2">
                            <small class="text-primary">Los campos marcados con (*) son obligatorios.</small>
                        </div>

                        {{-- IDENTIFICACIÓN --}}
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1"><small class="fw-bold text-secondary text-uppercase">Identificación</small><hr class="mt-1 mb-2"></div>
                        <div class="col-lg-5 col-md-5 col-sm-12 mb-2">
                            <label for="pro_nombre" class="form-label">Nombre (*)</label>
                            <input type="text" name="pro_nombre" id="pro_nombre" class="form-control">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="pro_codigo" class="form-label">Código (*)</label>
                            <input type="text" name="pro_codigo" id="pro_codigo" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 mb-2">
                            <label for="pro_codigo_barra" class="form-label">Código de Barra</label>
                            <input type="text" name="pro_codigo_barra" id="pro_codigo_barra" class="form-control" placeholder="EAN-13...">
                        </div>

                        {{-- CLASIFICACIÓN --}}
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1"><small class="fw-bold text-secondary text-uppercase">Clasificación</small><hr class="mt-1 mb-2"></div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="id_fa_selector" class="form-label">Línea (*)</label>
                            <select id="id_fa_selector" class="form-select" onchange="filtrarCategorias(this.value)">
                                <option value="">Seleccionar línea</option>
                                @foreach($familias as $fa)
                                    <option value="{{$fa->id_fa}}">{{$fa->fa_nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="id_ca" class="form-label">Clase / Categoría (*)</label>
                            <select name="id_ca" id="id_ca" class="form-select">
                                <option value="">Seleccione línea primero</option>
                                @foreach($cate as $c)
                                    <option value="{{$c->id_ca}}" data-fa="{{$c->id_fa}}">{{$c->ca_nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="tipoAfectacion" class="form-label">Tipo de Afectación</label>
                            <select name="tipoAfectacion" id="tipoAfectacion" class="form-select">
                                <option value="">Seleccionar</option>
                                @foreach($tipoAfectacion as $ti)
                                    <option value="{{$ti->id_tipo_afectacion}}">{{$ti->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="unidadMedida" class="form-label">Unidad de Medida (*)</label>
                            <select name="unidadMedida" id="unidadMedida" class="form-select">
                                <option value="">Seleccionar</option>
                                <option value="58">UNIDAD (BIENES)</option>
                                <option value="59">UNIDAD (SERVICIOS)</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="id_moneda" class="form-label">Moneda</label>
                            <select name="id_moneda" id="id_moneda" class="form-select">
                                @foreach($monedas as $m)
                                    <option value="{{$m->id_moneda}}">{{$m->simbolo}} {{$m->moneda}} ({{$m->abrstandar}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="pro_fecha_adquisicion" class="form-label">Fecha de Adquisición</label>
                            <input type="date" name="pro_fecha_adquisicion" id="pro_fecha_adquisicion" class="form-control">
                        </div>

                        {{-- PRECIOS DE VENTA --}}
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1"><small class="fw-bold text-secondary text-uppercase">Precios de Venta</small><hr class="mt-1 mb-2"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="pro_precio_uni" class="form-label">Precio Unitario (*) <small class="text-muted">(con IGV)</small></label>
                            <input type="text" name="pro_precio_uni" id="pro_precio_uni" class="form-control" onkeyup="validar_numeros(this.id)">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="pro_precio_uni_ma" class="form-label">Precio Mayorista (*) <small class="text-muted">(con IGV)</small></label>
                            <input type="text" name="pro_precio_uni_ma" id="pro_precio_uni_ma" class="form-control" onkeyup="validar_numeros(this.id)">
                        </div>

                        {{-- PRECIOS DE COSTO --}}
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1"><small class="fw-bold text-secondary text-uppercase">Precios de Costo</small><hr class="mt-1 mb-2"></div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="pro_precio_costo" class="form-label">Precio Costo <small class="text-muted">(con IGV)</small></label>
                            <input type="text" name="pro_precio_costo" id="pro_precio_costo" class="form-control" onkeyup="validar_numeros(this.id)" placeholder="0.00">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="pro_valor_costo" class="form-label">Valor Costo <small class="text-muted">(sin IGV)</small></label>
                            <input type="text" name="pro_valor_costo" id="pro_valor_costo" class="form-control" onkeyup="validar_numeros(this.id)" placeholder="0.00">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label for="pro_costo_promedio" class="form-label">
                                Costo Promedio Pond.
                                <i class="fa-solid fa-circle-info text-primary" title="Calculado automáticamente al registrar compras"></i>
                            </label>
                            <input type="text" name="pro_costo_promedio" id="pro_costo_promedio" class="form-control bg-light" readonly placeholder="0.00">
                        </div>

                        {{-- CONTROL DE STOCK --}}
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1"><small class="fw-bold text-secondary text-uppercase">Control de Stock</small><hr class="mt-1 mb-2"></div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-2 d-flex align-items-center">
                            <label for="stock_minimo" class="me-2 form-label m-0">Cantidad Mínima</label>
                            <input type="number" min="0" class="form-control" id="stock_minimo" name="stock_minimo" value="0">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-2 d-flex align-items-center">
                            <label for="stock_maximo" class="me-2 form-label m-0">Cantidad Máxima</label>
                            <input type="number" min="0" class="form-control" id="stock_maximo" name="stock_maximo" value="0">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-2 d-flex align-items-center">
                            <label for="impuesto_bolsa" class="me-2 form-label m-0">Impuesto a Bolsa</label>
                            <label class="check">
                                <input type="checkbox" id="impuesto_bolsa" name="impuesto_bolsa">
                                <span class="check1"></span>
                            </label>
                        </div>

                        {{-- CONTROL DE INVENTARIO --}}
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label class="form-label">Control de Inventario</label>
                            <div class="d-flex flex-wrap gap-4 mt-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="control_serie" name="control_serie" value="1">
                                    <label class="form-check-label" for="control_serie">
                                        Por número de serie <small class="text-muted">(motos, trimotos)</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="control_lote" name="control_lote" value="1">
                                    <label class="form-check-label" for="control_lote">
                                        Por lote <small class="text-muted">(repuestos con vencimiento)</small>
                                    </label>
                                </div>
                            </div>
                            <small class="text-muted">Si ninguno está marcado, el stock se maneja por unidades simples.</small>
                        </div>

                        {{-- PROVEEDORES Y DESCRIPCIÓN --}}
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1"><small class="fw-bold text-secondary text-uppercase">Datos adicionales</small><hr class="mt-1 mb-2"></div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label class="form-label">Proveedores asociados</label>
                            <select name="ids_proveedores[]" id="ids_proveedores" class="form-select" multiple style="height:80px">
                                @foreach($proveedores as $prov)
                                    <option value="{{$prov->id_proveedores}}">{{$prov->proveedores_nombre}}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Ctrl+clic para seleccionar varios</small>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <label for="pro_descripcion" class="form-label">Descripción</label>
                            <textarea name="pro_descripcion" id="pro_descripcion" class="form-control w-100" rows="3"></textarea>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center ">
                            <label for="">Imagen (*)</label>
                            <div class="d-flex align-items-center justify-content-center">
                                <label for="pro_foto" class="contenedor_previsualizacion mt-3 cursor-pointer">
                                    <img src="{{asset('sin-fotografia.png')}}" alt="" id="imagen_producto" style="width: 100%">
                                </label>
                                <input type="file" name="pro_foto" id="pro_foto" class="d-none" onchange="previewImage(this ,'imagen_producto')">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" id="btnSaveProductos">Guardar registro</button>
                </div>
            </form>
        </div>
    </div>
</div>

    {{-- Modal Importar Excel --}}
    <div class="modal fade" id="modal_importar_excel" tabindex="-1" aria-labelledby="modalImportarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="modalImportarLabel">Importar Productos desde Excel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formularioImportarExcel" method="POST" action="{{ route('logistica.importar_productos_excel') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label for="archivo_excel" class="form-label">Seleccionar archivo Excel <span class="text-danger">(*)</span></label>
                                <input type="file" name="archivo_excel" id="archivo_excel" class="form-control" accept=".xlsx,.xls">
                                <small class="text-muted">Formatos permitidos: .xlsx, .xls</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning text-white" id="btnImportarExcel">
                            <i class="fa-solid fa-upload"></i> Importar
                        </button>
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
                        <button class="btn  btn-sm btn-success" id="btn_crear_productos" data-bs-toggle="modal" data-bs-target="#modal_crear_productos"><i class="fa fa-plus"></i> Agregar Productos</button>
                    </div>
                    {{--<div class="col-lg-3 col-md-12 col-sm-12 d-flex align-items-center">
                        <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#modal_importar_excel"><i class="fa-solid fa-file-excel"></i> Importar Excel</button>
                    </div>--}}
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
                                        <th>Nombre</th>
                                        <th>Impuesto a bolsa</th>
                                        <th>Unidad de Medida</th>
                                        <th>Valor Unit</th>
                                        <th>Precio Unit</th>
{{--                                        <th>Porcentaje de igv</th>--}}
                                        <th>Stock</th>
                                        <th>Foto</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $a = 1
                                    @endphp
                                    @foreach($productos as $me)
                                        <tr>
                                            <td>{{$a}}</td>
                                            <td>
                                                {{$me->pro_nombre}}
                                                <br>
                                                CÓDIGO: <b>{{$me->pro_codigo}}</b>
                                                <br>
                                                @if($me->control_serie)
                                                    <span class="badge bg-primary" role="button"
                                                          style="cursor:pointer"
                                                          onclick="verSeries({{$me->id_pro}},'{{addslashes($me->pro_nombre)}}')">
                                                        <i class="fa fa-list-ul me-1"></i>Serie
                                                    </span>
                                                @endif
                                                @if($me->control_lote)
                                                    <span class="badge bg-warning text-dark" role="button"
                                                          style="cursor:pointer"
                                                          onclick="verLotes({{$me->id_pro}},'{{addslashes($me->pro_nombre)}}')">
                                                        <i class="fa fa-boxes-stacked me-1"></i>Lote
                                                    </span>
                                                @endif
                                                @if(!$me->control_serie && !$me->control_lote)
                                                    <span class="badge bg-secondary">Unidad</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{$me->impuesto_bolsa == 1 ? 'SI' : 'NO'}}
                                            </td>
                                            <td>
                                               {{$me->id_medida == 58 ? 'UNIDAD (BIENES)' : 'UNIDAD (SERVICIOS)'}}
                                                <br>
                                                Código: {{$me->id_medida == 58 ? 'NIU' : 'ZZ'}}
                                            </td>
                                            <td>
                                                VALOR UNIT: <br>
                                                <b>{{$me->pro_precio_valor}}</b> <br>
                                                VALOR MAYO: <br>
                                                <b>{{$me->pro_precio_valor_ma}}</b>
                                            </td>
                                            <td>
                                                PRECIO UNIT: <br>
                                                <b>{{$me->pro_precio_uni}}</b> <br>
                                                PRECIO MAYO: <br>
                                                <b>{{$me->pro_precio_uni_ma}}</b>
                                            </td>
{{--                                            <td>{{$me->pro_porcen_igv}}</td>--}}
                                            <td>
                                                @if($me->control_serie)
                                                    {{ $me->stock_series }}
                                                @elseif($me->id_medida == 58)
                                                    {{ $me->pro_stock }}
                                                @else
                                                    ∞
                                                @endif
                                            </td>
                                            <td>
                                                @if(file_exists($me->pro_foto))
                                                    <img src="{{asset($me->pro_foto)}}" class="w-50 h-50"  style="border-radius: 10px" alt="">
                                                @else
                                                    <img src="{{asset('sin-fotografia.png')}}" class="w-50 h-50"  style="border-radius: 10px" alt="">
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm bg-primary text-white m-1" data-bs-toggle="modal" data-bs-target="#modal_crear_productos" onclick="modificarProductos({{$me->id_pro}})"><i class="  fa-solid fa-pencil"></i></button>
                                                <button class="btn btn-sm bg-danger text-white m-1" id="btnEliminarProducto_{{$me->id_pro}}"  onclick="preguntar('¿Está seguro que desea eliminar este producto?','eliminar_producto','Si','No',{{$me->id_pro}})"><i class="fa-solid fa-trash"></i></button>
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

{{-- Modal Series --}}
<div class="modal fade" id="modal_ver_series" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Series — <span id="ms_nombre_producto" class="text-primary"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nº Serie</th>
                                <th>Nº Motor</th>
                                <th>Color</th>
                                <th>Año Fab.</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="ms_tbody">
                            <tr><td colspan="6" class="text-center text-muted">Cargando…</td></tr>
                        </tbody>
                    </table>
                </div>
                <div id="ms_sin_datos" class="text-center text-muted d-none">No hay series registradas para este producto.</div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Lotes --}}
<div class="modal fade" id="modal_ver_lotes" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lotes — <span id="ml_nombre_producto" class="text-warning"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nº Lote</th>
                                <th>Vencimiento</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody id="ml_tbody">
                            <tr><td colspan="6" class="text-center text-muted">Cargando…</td></tr>
                        </tbody>
                    </table>
                </div>
                <div id="ml_sin_datos" class="text-center text-muted d-none">No hay lotes registrados para este producto.</div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/domain.js')}}"></script>
<script src="{{asset('js/logistica.js')}}"></script>
<script>
const _csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function verSeries(id_pro, nombre) {
    document.getElementById('ms_nombre_producto').textContent = nombre;
    document.getElementById('ms_sin_datos').classList.add('d-none');
    document.getElementById('ms_tbody').innerHTML = '<tr><td colspan="6" class="text-center text-muted">Cargando…</td></tr>';
    const modal = new bootstrap.Modal(document.getElementById('modal_ver_series'));
    modal.show();
    fetch(ruta_global + 'logistica/series_por_producto', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _csrfToken },
        body: JSON.stringify({ id_pro })
    })
    .then(r => r.json())
    .then(r => {
        const rows = r.data || [];
        if (!rows.length) {
            document.getElementById('ms_tbody').innerHTML = '';
            document.getElementById('ms_sin_datos').classList.remove('d-none');
            return;
        }
        const estadoBadge = e => e === 'disponible'
            ? '<span class="badge bg-success">Disponible</span>'
            : '<span class="badge bg-secondary">Vendido</span>';
        document.getElementById('ms_tbody').innerHTML = rows.map((s, i) => `
            <tr>
                <td>${i+1}</td>
                <td><strong>${s.numero_serie}</strong></td>
                <td>${s.numero_motor || '---'}</td>
                <td>${s.color || '---'}</td>
                <td>${s.anio_fabricacion || '---'}</td>
                <td>${estadoBadge(s.estado)}</td>
            </tr>`).join('');
    });
}

function verLotes(id_pro, nombre) {
    document.getElementById('ml_nombre_producto').textContent = nombre;
    document.getElementById('ml_sin_datos').classList.add('d-none');
    document.getElementById('ml_tbody').innerHTML = '<tr><td colspan="6" class="text-center text-muted">Cargando…</td></tr>';
    const modal = new bootstrap.Modal(document.getElementById('modal_ver_lotes'));
    modal.show();
    fetch(ruta_global + 'logistica/lotes_por_producto', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _csrfToken },
        body: JSON.stringify({ id_pro })
    })
    .then(r => r.json())
    .then(r => {
        const rows = r.data || [];
        if (!rows.length) {
            document.getElementById('ml_tbody').innerHTML = '';
            document.getElementById('ml_sin_datos').classList.remove('d-none');
            return;
        }
        const estadoBadge = e => e === 'disponible'
            ? '<span class="badge bg-success">Disponible</span>'
            : '<span class="badge bg-secondary">Agotado</span>';
        document.getElementById('ml_tbody').innerHTML = rows.map((l, i) => `
            <tr>
                <td>${i+1}</td>
                <td><strong>${l.numero_lote}</strong></td>
                <td>${l.fecha_vencimiento || '---'}</td>
                <td>${l.cantidad}</td>
                <td>${estadoBadge(l.estado)}</td>
                <td>${l.observaciones || '---'}</td>
            </tr>`).join('');
    });
}
</script>

@endsection
