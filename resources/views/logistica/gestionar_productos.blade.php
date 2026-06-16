@extends('layouts.plantilla')
@section('content')

{{-- Modal Crear / Editar Producto --}}
<div class="modal fade" id="modal_crear_productos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formularioAgregarProductos" class="mb-3" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="estadoActionFuctionProductos" id="estadoActionFuctionProductos">
                    <input type="hidden" name="id_pro" id="id_pro">
                    <script>var _categorias_data = @json($cate);</script>
                    <div class="row">
                        <div class="col-lg-12 mb-2 text-center">
                            <small class="text-primary">Los campos marcados con (*) son obligatorios.</small>
                        </div>

                        {{-- IDENTIFICACIÓN --}}
                        <div class="col-lg-12 mb-1"><small class="fw-bold text-secondary text-uppercase">Identificación</small><hr class="mt-1 mb-2"></div>
                        <div class="col-lg-5 col-md-5 col-sm-12 mb-2">
                            <label class="form-label">Nombre (*)</label>
                            <input type="text" name="pro_nombre" id="pro_nombre" class="form-control">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label class="form-label">Código (*)</label>
                            <input type="text" name="pro_codigo" id="pro_codigo" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 mb-2">
                            <label class="form-label">Código de Barra</label>
                            <input type="text" name="pro_codigo_barra" id="pro_codigo_barra" class="form-control" placeholder="EAN-13...">
                        </div>

                        {{-- CLASIFICACIÓN --}}
                        <div class="col-lg-12 mb-1"><small class="fw-bold text-secondary text-uppercase">Clasificación</small><hr class="mt-1 mb-2"></div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label class="form-label">Línea (*)</label>
                            <select id="id_fa_selector" class="form-select" onchange="filtrarCategorias(this.value)">
                                <option value="">Seleccionar línea</option>
                                @foreach($familias as $fa)
                                    <option value="{{$fa->id_fa}}">{{$fa->fa_nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label class="form-label">Clase / Categoría (*)</label>
                            <select name="id_ca" id="id_ca" class="form-select">
                                <option value="">Seleccione línea primero</option>
                                @foreach($cate as $c)
                                    <option value="{{$c->id_ca}}" data-fa="{{$c->id_fa}}">{{$c->ca_nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label class="form-label">Tipo de Afectación</label>
                            <select name="tipoAfectacion" id="tipoAfectacion" class="form-select">
                                <option value="">Seleccionar</option>
                                @foreach($tipoAfectacion as $ti)
                                    <option value="{{$ti->id_tipo_afectacion}}">{{$ti->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label class="form-label">Unidad de Medida (*)</label>
                            <select name="unidadMedida" id="unidadMedida" class="form-select">
                                <option value="">Seleccionar</option>
                                <option value="58">UNIDAD (BIENES)</option>
                                <option value="59">UNIDAD (SERVICIOS)</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label class="form-label">Moneda</label>
                            <select name="id_moneda" id="id_moneda" class="form-select">
                                @foreach($monedas as $m)
                                    <option value="{{$m->id_moneda}}">{{$m->simbolo}} {{$m->moneda}} ({{$m->abrstandar}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label class="form-label">Fecha de Adquisición</label>
                            <input type="date" name="pro_fecha_adquisicion" id="pro_fecha_adquisicion" class="form-control">
                        </div>

                        {{-- PRECIOS DE VENTA --}}
                        <div class="col-lg-12 mb-1"><small class="fw-bold text-secondary text-uppercase">Precios de Venta</small><hr class="mt-1 mb-2"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label class="form-label">Precio Unitario (*) <small class="text-muted">(con IGV)</small></label>
                            <input type="text" name="pro_precio_uni" id="pro_precio_uni" class="form-control" onkeyup="validar_numeros(this.id)">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label class="form-label">Precio Mayorista (*) <small class="text-muted">(con IGV)</small></label>
                            <input type="text" name="pro_precio_uni_ma" id="pro_precio_uni_ma" class="form-control" onkeyup="validar_numeros(this.id)">
                        </div>

                        {{-- PRECIOS DE COSTO --}}
                        <div class="col-lg-12 mb-1"><small class="fw-bold text-secondary text-uppercase">Precios de Costo</small><hr class="mt-1 mb-2"></div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label class="form-label">Precio Costo <small class="text-muted">(con IGV)</small></label>
                            <input type="text" name="pro_precio_costo" id="pro_precio_costo" class="form-control" onkeyup="validar_numeros(this.id)" placeholder="0.00">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label class="form-label">Valor Costo <small class="text-muted">(sin IGV)</small></label>
                            <input type="text" name="pro_valor_costo" id="pro_valor_costo" class="form-control" onkeyup="validar_numeros(this.id)" placeholder="0.00">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label class="form-label">Costo Promedio Pond. <i class="fa-solid fa-circle-info text-primary" title="Calculado automáticamente al registrar compras"></i></label>
                            <input type="text" name="pro_costo_promedio" id="pro_costo_promedio" class="form-control bg-light" readonly placeholder="0.00">
                        </div>

                        {{-- CONTROL DE STOCK --}}
                        <div class="col-lg-12 mb-1"><small class="fw-bold text-secondary text-uppercase">Control de Stock</small><hr class="mt-1 mb-2"></div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-2 d-flex align-items-center">
                            <label class="me-2 form-label m-0">Cantidad Mínima</label>
                            <input type="number" min="0" class="form-control" id="stock_minimo" name="stock_minimo" value="0">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-2 d-flex align-items-center">
                            <label class="me-2 form-label m-0">Cantidad Máxima</label>
                            <input type="number" min="0" class="form-control" id="stock_maximo" name="stock_maximo" value="0">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-2 d-flex align-items-center">
                            <label class="me-2 form-label m-0">Impuesto a Bolsa</label>
                            <label class="check">
                                <input type="checkbox" id="impuesto_bolsa" name="impuesto_bolsa">
                                <span class="check1"></span>
                            </label>
                        </div>

                        {{-- CONTROL DE INVENTARIO --}}
                        <div class="col-lg-12 mb-2">
                            <label class="form-label">Control de Inventario</label>
                            <div class="d-flex flex-wrap gap-4 mt-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="control_serie" name="control_serie" value="1">
                                    <label class="form-check-label" for="control_serie">Por número de serie <small class="text-muted">(motos, trimotos)</small></label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="control_lote" name="control_lote" value="1">
                                    <label class="form-check-label" for="control_lote">Por lote <small class="text-muted">(repuestos con vencimiento)</small></label>
                                </div>
                            </div>
                            <small class="text-muted">Si ninguno está marcado, el stock se maneja por unidades simples.</small>
                        </div>

                        {{-- DATOS ADICIONALES --}}
                        <div class="col-lg-12 mb-1"><small class="fw-bold text-secondary text-uppercase">Datos adicionales</small><hr class="mt-1 mb-2"></div>
                        <div class="col-lg-12 mb-2">
                            <label class="form-label">Proveedores asociados</label>
                            <select name="ids_proveedores[]" id="ids_proveedores" class="form-select" multiple style="height:80px">
                                @foreach($proveedores as $prov)
                                    <option value="{{$prov->id_proveedores}}">{{$prov->proveedores_nombre}}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Ctrl+clic para seleccionar varios</small>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <label class="form-label">Descripción</label>
                            <textarea name="pro_descripcion" id="pro_descripcion" class="form-control w-100" rows="3"></textarea>
                        </div>
                        <div class="col-lg-12 text-center">
                            <label class="form-label">Imagen <small class="text-muted">(opcional)</small></label>
                            <div class="d-flex align-items-center justify-content-center">
                                <label for="pro_foto" class="contenedor_previsualizacion mt-3 cursor-pointer">
                                    <img src="{{asset('sin-fotografia.png')}}" alt="" id="imagen_producto" style="width:100%">
                                </label>
                                <input type="file" name="pro_foto" id="pro_foto" class="d-none" onchange="previewImage(this,'imagen_producto')">
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
<div class="modal fade" id="modal_importar_excel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-dark">Importar Productos desde Excel</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formularioImportarExcel" method="POST" action="{{ route('logistica.importar_productos_excel') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12 mb-3">
                        <label class="form-label">Seleccionar archivo Excel <span class="text-danger">(*)</span></label>
                        <input type="file" name="archivo_excel" id="archivo_excel" class="form-control" accept=".xlsx,.xls">
                        <small class="text-muted">Formatos permitidos: .xlsx, .xls</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning text-white"><i class="fa-solid fa-upload"></i> Importar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="tab-content">
    <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active" role="tabpanel">

        {{-- Acciones y filtros --}}
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="card">
                <div class="card-body py-2">
                    <div class="row g-2 align-items-end">
                        {{-- Botones de acción --}}
                        <div class="col-auto">
                            <button class="btn btn-sm btn-success" id="btn_crear_productos" data-bs-toggle="modal" data-bs-target="#modal_crear_productos">
                                <i class="fa fa-plus"></i> Agregar Producto
                            </button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-success" id="btn_exportar_excel" onclick="exportarProductosExcel()">
                                <i class="fa-solid fa-file-excel"></i> Exportar Excel
                            </button>
                        </div>
                        {{-- Separador visual --}}
                        <div class="col-auto d-none d-md-block"><div style="width:1px;height:32px;background:#dee2e6"></div></div>
                        {{-- Filtros --}}
                        <div class="col-sm-auto col-12">
                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;color:#64748b">ESTADO</label>
                            <select id="filtro_estado" class="form-select form-select-sm" style="min-width:160px">
                                <option value="1">HABILITADO</option>
                                <option value="0">DESHABILITADO</option>
                            </select>
                        </div>
                        <div class="col-sm-auto col-12">
                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;color:#64748b">STOCK</label>
                            <select id="filtro_stock" class="form-select form-select-sm" style="min-width:140px">
                                <option value="">TODOS</option>
                                <option value="con">CON STOCK</option>
                                <option value="sin">SIN STOCK</option>
                            </select>
                        </div>
                        <div class="col-sm col-12">
                            <label class="form-label mb-1" style="font-size:12px;font-weight:600;color:#64748b">BUSCAR</label>
                            <input type="text" id="filtro_nombre" class="form-control form-control-sm" placeholder="Nombre o código..." onkeydown="if(event.key==='Enter') buscarProductos()">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-primary" onclick="buscarProductos()" id="btn_buscar_productos" style="margin-top:20px">
                                <i class="fa fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="card">
                <div class="card-body table-responsive p-2">
                    <table class="table table-hover w-100 mb-0" id="dataTable13">
                        <thead>
                            <tr class="encabezado_tabla_color">
                                <th>#</th>
                                <th>Nombre / Código</th>
                                <th>Bolsa</th>
                                <th>Unidad Medida</th>
                                <th>Valor Unit.</th>
                                <th>Precio Unit.</th>
                                <th>Stock</th>
                                <th>Foto</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_productos_tbody"></tbody>
                    </table>
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
                            <tr><th>#</th><th>Nº Serie</th><th>Nº Motor</th><th>Color</th><th>Año Fab.</th><th>Estado</th></tr>
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
                    <table class="table table-bordered table-hover table-sm" id="dataTable13">
                        <thead class="table-dark">
                            <tr><th>#</th><th>Nº Lote</th><th>Vencimiento</th><th>Cantidad</th><th>Estado</th><th>Observaciones</th></tr>
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

// Limpiar modal al cerrar (imagen + file input)
document.getElementById('modal_crear_productos').addEventListener('hidden.bs.modal', function () {
    document.getElementById('imagen_producto').src = ruta_global + 'sin-fotografia.png';
    document.getElementById('pro_foto').value = '';
});

const _dtLang = {
    sEmptyTable:    "Usa los filtros y presiona Buscar para ver los productos.",
    sZeroRecords:   "No se encontraron productos con los filtros aplicados.",
    sInfo:          "Mostrando _START_ de _END_ de _TOTAL_ entradas",
    sInfoEmpty:     "0 de 0 de 0 entradas",
    sInfoFiltered:  "(filtrado de _MAX_ totales)",
    sLengthMenu:    "<span style='color:#666'>Mostrar _MENU_ resultados</span>",
    sSearch:        "", sSearchPlaceholder: "Buscar",
    sLoadingRecords:"Cargando...", sProcessing: "Espere...",
    oPaginate:{ sFirst:"Primero", sPrevious:"Anterior", sNext:"Siguiente", sLast:"Último" }
};

function _dtInit() {
    if (!$.fn.DataTable.isDataTable('#dataTable13')) {
        $('#dataTable13').DataTable({ responsive: true, language: _dtLang });
    }
}
function _dtDestroy() {
    if ($.fn.DataTable.isDataTable('#dataTable13')) {
        $('#dataTable13').DataTable().destroy();
    }
}

function buscarProductos() {
    const estado  = document.getElementById('filtro_estado').value;
    const stock   = document.getElementById('filtro_stock').value;
    const nombre  = document.getElementById('filtro_nombre').value.trim();
    const btn     = document.getElementById('btn_buscar_productos');

    _dtDestroy();
    document.getElementById('tabla_productos_tbody').innerHTML = '';
    _dtInit();
    btn.disabled = true;

    fetch(ruta_global + 'logistica/filtrar_productos', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _csrfToken },
        body: JSON.stringify({ estado, stock, nombre })
    })
    .then(r => r.json())
    .then(r => {
        btn.disabled = false;
        const productos = r.result.data || [];
        dibujarTablaProductos(productos);
    })
    .catch(() => {
        btn.disabled = false;
    });
}

function dibujarTablaProductos(productos) {
    _dtDestroy();
    const tbody = document.getElementById('tabla_productos_tbody');
    let html = '';
    productos.forEach(function(p, i) {
        const stockVal   = p.control_serie ? p.stock_series : (p.id_medida == 58 ? p.pro_stock : '∞');
        const foto       = (p.pro_foto && p.pro_foto !== 'sin-fotografia.png')
                           ? `<img src="${ruta_global}${p.pro_foto}" style="width:40px;height:40px;object-fit:cover;border-radius:6px">`
                           : `<img src="${ruta_global}sin-fotografia.png" style="width:40px;height:40px;object-fit:cover;border-radius:6px">`;
        const deshabBg   = p.pro_estado == 0 ? 'style="background:#fef2f2"' : '';
        const deshabBadge = p.pro_estado == 0
            ? '<br><span class="badge bg-danger mt-1">Deshabilitado</span>'
            : '';
        const toggleIcon = p.pro_estado == 0
            ? '<i class="fa-solid fa-toggle-off"></i>'
            : '<i class="fa-solid fa-toggle-on"></i>';
        const toggleClass = p.pro_estado == 0 ? 'btn-success' : 'btn-warning';
        const toggleTitle = p.pro_estado == 0 ? 'Habilitar' : 'Deshabilitar';

        let badgeCtrl = '';
        if (p.control_serie) {
            badgeCtrl = `<span class="badge bg-primary ms-1" role="button" style="cursor:pointer" onclick="verSeries(${p.id_pro},'${(p.pro_nombre||'').replace(/'/g,"\\'")}')"><i class="fa fa-list-ul me-1"></i>Serie</span>`;
        } else if (p.control_lote) {
            badgeCtrl = `<span class="badge bg-warning text-dark ms-1" role="button" style="cursor:pointer" onclick="verLotes(${p.id_pro},'${(p.pro_nombre||'').replace(/'/g,"\\'")}')"><i class="fa fa-boxes-stacked me-1"></i>Lote</span>`;
        } else {
            badgeCtrl = '<span class="badge bg-secondary ms-1">Unidad</span>';
        }

        html += `<tr ${deshabBg}>
            <td>${i+1}</td>
            <td>
                <span class="fw-semibold">${p.pro_nombre}</span>${deshabBadge}
                <br><small class="text-muted">Cód: <b>${p.pro_codigo}</b></small>
                ${badgeCtrl}
            </td>
            <td>${p.impuesto_bolsa == 1 ? 'SÍ' : 'NO'}</td>
            <td>${p.id_medida == 58 ? 'UNIDAD (BIENES)' : 'UNIDAD (SERVICIOS)'}</td>
            <td>
                <small>Unit: <b>${p.pro_precio_valor ?? ''}</b></small><br>
                <small>Mayo: <b>${p.pro_precio_valor_ma ?? ''}</b></small>
            </td>
            <td>
                <small>Unit: <b>${p.pro_precio_uni}</b></small><br>
                <small>Mayo: <b>${p.pro_precio_uni_ma}</b></small>
            </td>
            <td class="text-center fw-bold">${stockVal}</td>
            <td>${foto}</td>
            <td>
                <button class="btn btn-sm bg-primary text-white m-1" title="Editar"
                    data-bs-toggle="modal" data-bs-target="#modal_crear_productos"
                    onclick="modificarProductos(${p.id_pro})">
                    <i class="fa-solid fa-pencil"></i>
                </button>
                <button class="btn btn-sm ${toggleClass} text-white m-1" title="${toggleTitle}"
                    id="btnToggleProducto_${p.id_pro}"
                    onclick="toggleProducto(${p.id_pro}, this)">
                    ${toggleIcon}
                </button>
            </td>
        </tr>`;
    });
    tbody.innerHTML = html;
    _dtInit();
}

function exportarProductosExcel() {
    const estado = document.getElementById('filtro_estado').value;
    const stock  = document.getElementById('filtro_stock').value;
    const nombre = document.getElementById('filtro_nombre').value.trim();
    window.open(`${ruta_global}logistica/exportar_productos_excel?estado=${estado}&stock=${stock}&nombre=${encodeURIComponent(nombre)}`, '_blank');
}

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
        const badge = e => e === 'disponible'
            ? '<span class="badge bg-success">Disponible</span>'
            : '<span class="badge bg-secondary">Vendido</span>';
        document.getElementById('ms_tbody').innerHTML = rows.map((s, i) => `
            <tr>
                <td>${i+1}</td>
                <td><strong>${s.numero_serie}</strong></td>
                <td>${s.numero_motor||'---'}</td>
                <td>${s.color||'---'}</td>
                <td>${s.anio_fabricacion||'---'}</td>
                <td>${badge(s.estado)}</td>
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
        const badge = e => e === 'disponible'
            ? '<span class="badge bg-success">Disponible</span>'
            : '<span class="badge bg-secondary">Agotado</span>';
        document.getElementById('ml_tbody').innerHTML = rows.map((l, i) => `
            <tr>
                <td>${i+1}</td>
                <td><strong>${l.numero_lote}</strong></td>
                <td>${l.fecha_vencimiento||'---'}</td>
                <td>${l.cantidad}</td>
                <td>${badge(l.estado)}</td>
                <td>${l.observaciones||'---'}</td>
            </tr>`).join('');
    });
}
</script>
@endsection
