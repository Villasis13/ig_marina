@extends('layouts.plantilla')
@section('content')
<style>
.ri-search-label { display:block; font-size:11.5px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px; }
.ri-search-wrap  { position:relative; }
.ri-search-icon  { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#64748b; font-size:13px; pointer-events:none; }
.ri-search-input {
  width:100%; padding:9px 13px 9px 34px; font-size:13.5px;
  border:1px solid #e2e8f0; border-radius:7px; background:#f1f5f9; color:#1e293b;
  transition:border-color .15s,box-shadow .15s; outline:none;
}
.ri-search-input:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.12); background:#fff; }
.ri-dropdown {
  position:absolute; top:calc(100% + 4px); left:0; right:0; z-index:9999;
  background:#fff; border:1px solid #e2e8f0; border-radius:8px;
  box-shadow:0 8px 28px rgba(15,23,42,.13); max-height:280px; overflow-y:auto; display:none;
}
.ri-dropdown.open  { display:block; }
.ri-drop-item      { padding:9px 14px; cursor:pointer; border-bottom:1px solid #f1f5f9; transition:background .12s; }
.ri-drop-item:last-child { border-bottom:none; }
.ri-drop-item:hover { background:#eff6ff; }
.ri-drop-name  { font-size:13px; font-weight:600; color:#1e293b; }
.ri-drop-meta  { font-size:11px; color:#64748b; margin-top:2px; }
.ri-drop-code  { font-family:monospace; color:#6b7280; }
.ri-drop-fam   { color:#2563eb; margin-left:6px; }
.ri-drop-empty { padding:12px 14px; font-size:13px; color:#64748b; font-style:italic; }

.ri-selected {
  display:none; align-items:center; gap:10px;
  background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px;
  padding:8px 14px; margin-top:8px;
}
.ri-selected.visible { display:flex; }
.ri-selected-badge { background:#2563eb; color:#fff; font-size:10px; font-weight:700; letter-spacing:.4px; padding:2px 7px; border-radius:4px; flex-shrink:0; }
.ri-selected-info  { flex:1; min-width:0; }
.ri-selected-name  { font-size:13px; font-weight:600; color:#1e293b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.ri-selected-meta  { font-size:11.5px; color:#64748b; margin-top:1px; }
.ri-btn-clear      { background:none; border:none; cursor:pointer; color:#64748b; font-size:14px; padding:0; flex-shrink:0; transition:color .12s; }
.ri-btn-clear:hover { color:#dc2626; }
</style>

<div class="tab-content">
    <div class="tab-pane fade show active">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="row m-3">
                    <div class="col-lg-12 text-center">
                        <h6 class="m-0 text-primary">REPORTE DE INVENTARIO</h6>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('reporte.reporte_inventario') }}" method="POST">
            @csrf
            <input type="hidden" name="enviar" value="1">
            <input type="hidden" name="id_pro_filtro" id="ri_id_pro" value="{{ $id_pro_filtro ?? '' }}">

            <div class="row">
                {{-- Período --}}
                <div class="col-lg-2 col-md-3 col-sm-12 mb-2">
                    <div class="card">
                        <div class="card-body">
                            @foreach([['d','Diario'],['s','Semanal'],['q','Quincenal'],['m','Mensual'],['tri','Trimestral'],['sem','Semestral'],['a','Anual']] as $op)
                            <div class="mb-2">
                                <input onclick="cambiar_fec_general()" type="radio" name="opcion"
                                       id="op_{{$op[0]}}" value="{{$op[0]}}" {{$check==$op[0]?'checked':''}}>
                                <label for="op_{{$op[0]}}">{{$op[1]}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-10 col-md-9 col-sm-12 mb-2">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row g-2 align-items-end">

                                {{-- Buscador de producto --}}
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label class="ri-search-label">
                                        <i class="fa-solid fa-magnifying-glass"></i> Producto (opcional)
                                    </label>
                                    <div class="ri-search-wrap">
                                        <i class="fa-solid fa-magnifying-glass ri-search-icon"></i>
                                        <input type="text" id="ri_buscar_input" class="ri-search-input"
                                               placeholder="Todos los productos…" autocomplete="off">
                                        <div id="ri_dropdown" class="ri-dropdown"></div>
                                    </div>
                                    <div id="ri_selected" class="ri-selected {{ ($id_pro_filtro ?? '') ? 'visible' : '' }}">
                                        <span class="ri-selected-badge">Filtro</span>
                                        <div class="ri-selected-info">
                                            <div class="ri-selected-name" id="ri_selected_name">{{ $pro_filtro_nombre ?? '' }}</div>
                                            <div class="ri-selected-meta" id="ri_selected_meta">{{ $pro_filtro_codigo ?? '' }}</div>
                                        </div>
                                        <button type="button" class="ri-btn-clear" onclick="riClearProduct()" title="Quitar filtro">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-4 col-sm-12">
                                    <label>Fecha Inicio:</label>
                                    <input type="date" class="form-control" name="desde" id="desde" value="{{$fecha_inicio}}">
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-12">
                                    <label>Fecha Fin:</label>
                                    <input type="date" class="form-control" name="hasta" id="hasta" value="{{$fecha_fin}}">
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-12">
                                    <button type="submit" class="btn btn-info w-100"><i class="bx bx-search-alt"></i> Buscar</button>
                                </div>
                                @if($buscado)
                                @php $qStr = '?desde='.$fecha_inicio.'&hasta='.$fecha_fin.($id_pro_filtro?'&id_pro='.$id_pro_filtro:''); @endphp
                                <div class="col-lg-auto col-md-3 col-sm-12">
                                    <a href="{{ route('reporte.reporte_inventario_excel') }}{{$qStr}}" class="btn btn-success" target="_blank"><i class="fa fa-file-excel"></i> Excel</a>
                                </div>
                                <div class="col-lg-auto col-md-3 col-sm-12">
                                    <a href="{{ route('reporte.reporte_inventario_pdf') }}{{$qStr}}" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf"></i> PDF</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($buscado)
                    <ul class="nav nav-tabs" id="tabsInventario">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab_stock">Stock Actual ({{count($stock)}})</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab_vendidos">Vendidos ({{count($vendidos)}})</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab_entradas">Entradas ({{count($entradas)}})</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab_salidas">Salidas ({{count($salidas)}})</a></li>
                    </ul>
                    <div class="tab-content border border-top-0 p-3 bg-white">

                        {{-- Stock Actual --}}
                        <div id="tab_stock" class="tab-pane fade show active">
                            @if(count($stock) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="tbl_stock">
                                    <thead><tr class="encabezado_tabla_color"><th>#</th><th>Código</th><th>Producto</th><th>Stock</th><th>P. Unitario</th><th>Valor Total</th></tr></thead>
                                    <tbody>
                                        @php $n=1; $valorTotal=0; @endphp
                                        @foreach($stock as $p)
                                        @php $valorTotal += $p->pro_stock * $p->pro_precio_uni; @endphp
                                        <tr>
                                            <td>{{$n++}}</td>
                                            <td>{{$p->pro_codigo ?? '—'}}</td>
                                            <td>{{$p->pro_nombre}}</td>
                                            <td><span class="badge {{$p->pro_stock > 0 ? 'bg-success' : 'bg-danger'}}">{{$p->pro_stock}}</span></td>
                                            <td>S/ {{number_format($p->pro_precio_uni,2)}}</td>
                                            <td>S/ {{number_format($p->pro_stock * $p->pro_precio_uni,2)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot><tr class="fw-bold"><td colspan="5" class="text-end">VALOR TOTAL INVENTARIO:</td><td>S/ {{number_format($valorTotal,2)}}</td></tr></tfoot>
                                </table>
                            </div>
                            @else <div class="text-center py-4 text-muted">Sin productos en stock.</div> @endif
                        </div>

                        {{-- Vendidos --}}
                        <div id="tab_vendidos" class="tab-pane fade">
                            @if(count($vendidos) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="tbl_vendidos">
                                    <thead><tr class="encabezado_tabla_color"><th>#</th><th>Código</th><th>Producto</th><th>Cantidad Vendida</th><th>Total S/</th></tr></thead>
                                    <tbody>
                                        @php $n=1; @endphp
                                        @foreach($vendidos as $v)
                                        <tr><td>{{$n++}}</td><td>{{$v->pro_codigo??'—'}}</td><td>{{$v->pro_nombre}}</td><td>{{$v->total_cantidad}}</td><td>S/ {{number_format($v->total_importe,2)}}</td></tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot><tr class="fw-bold"><td colspan="4" class="text-end">TOTAL:</td><td>S/ {{number_format($vendidos->sum('total_importe'),2)}}</td></tr></tfoot>
                                </table>
                            </div>
                            @else <div class="text-center py-4 text-muted">Sin ventas en el período.</div> @endif
                        </div>

                        {{-- Entradas --}}
                        <div id="tab_entradas" class="tab-pane fade">
                            @if(count($entradas) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="tbl_entradas">
                                    <thead><tr class="encabezado_tabla_color"><th>#</th><th>Fecha</th><th>Proveedor</th><th>Código</th><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Total</th></tr></thead>
                                    <tbody>
                                        @php $n=1; @endphp
                                        @foreach($entradas as $e)
                                        <tr><td>{{$n++}}</td><td>{{date('d/m/Y',strtotime($e->orden_compra_fecha))}}</td><td>{{$e->proveedores_nombre}}</td><td>{{$e->pro_codigo??'—'}}</td><td>{{$e->pro_nombre}}</td><td>{{$e->detalle_compra_cantidad}}</td><td>S/ {{number_format($e->detalle_compra_precio_compra,2)}}</td><td>S/ {{number_format($e->detalle_compra_total_pedido,2)}}</td></tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot><tr class="fw-bold"><td colspan="7" class="text-end">TOTAL:</td><td>S/ {{number_format($entradas->sum('detalle_compra_total_pedido'),2)}}</td></tr></tfoot>
                                </table>
                            </div>
                            @else <div class="text-center py-4 text-muted">Sin entradas en el período.</div> @endif
                        </div>

                        {{-- Salidas --}}
                        <div id="tab_salidas" class="tab-pane fade">
                            @if(count($salidas) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="tbl_salidas">
                                    <thead><tr class="encabezado_tabla_color"><th>#</th><th>Fecha</th><th>Cliente</th><th>Comprobante</th><th>Código</th><th>Producto</th><th>Cantidad</th><th>Total S/</th></tr></thead>
                                    <tbody>
                                        @php $n=1; @endphp
                                        @foreach($salidas as $s)
                                        @php $tipo=$s->venta_tipo=='01'?'Factura':'Boleta'; $comp=$tipo.' '.$s->venta_serie.'-'.str_pad($s->venta_correlativo,8,'0',STR_PAD_LEFT); @endphp
                                        <tr><td>{{$n++}}</td><td>{{date('d/m/Y',strtotime($s->venta_fecha))}}</td><td>{{$s->cliente_nombre}}</td><td>{{$comp}}</td><td>{{$s->pro_codigo??'—'}}</td><td>{{$s->pro_nombre}}</td><td>{{$s->venta_detalle_cantidad}}</td><td>S/ {{number_format($s->venta_detalle_importe_total,2)}}</td></tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot><tr class="fw-bold"><td colspan="7" class="text-end">TOTAL:</td><td>S/ {{number_format($salidas->sum('venta_detalle_importe_total'),2)}}</td></tr></tfoot>
                                </table>
                            </div>
                            @else <div class="text-center py-4 text-muted">Sin salidas en el período.</div> @endif
                        </div>

                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{asset('js/domain.js')}}"></script>
<script src="{{asset('js/reporte.js')}}"></script>
<script>
$(document).ready(function(){
    @if($buscado && count($stock) > 0)    $('#tbl_stock').DataTable({paging:false,info:false,searching:true}); @endif
    @if($buscado && count($vendidos) > 0) $('#tbl_vendidos').DataTable({paging:false,info:false,searching:true}); @endif
    @if($buscado && count($entradas) > 0) $('#tbl_entradas').DataTable({paging:false,info:false,searching:true}); @endif
    @if($buscado && count($salidas) > 0)  $('#tbl_salidas').DataTable({paging:false,info:false,searching:true}); @endif
});

let riSearchTimer = null;
let riProductSelected = {{ ($id_pro_filtro ?? '') ? 'true' : 'false' }};

const riInput    = document.getElementById('ri_buscar_input');
const riDropdown = document.getElementById('ri_dropdown');

riInput.addEventListener('input', function () {
    clearTimeout(riSearchTimer);
    const val = this.value.trim();
    if (val.length < 2) {
        riDropdown.innerHTML = '';
        riDropdown.classList.remove('open');
        return;
    }
    riSearchTimer = setTimeout(() => riSearch(val), 280);
});

riInput.addEventListener('focus', function () {
    if (riDropdown.innerHTML && !riProductSelected) riDropdown.classList.add('open');
});

document.addEventListener('click', function (e) {
    if (!e.target.closest('.ri-search-wrap')) riDropdown.classList.remove('open');
});

function riSearch(valor) {
    $.ajax({
        type: 'POST',
        url: ruta_global + 'Gestionventas/buscar_productos',
        data: { valor: valor, _token: $("meta[name='csrf-token']").attr('content') },
        dataType: 'json',
    }).done(function (r) {
        const items = r.result.code;
        let html = '';
        if (items && items.length > 0) {
            items.forEach(function (p) {
                const nombre   = (p.pro_nombre || '').replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const codigo   = p.pro_codigo || '';
                const faNombre = p.fa_nombre || '';
                const faCodigo = p.familia_codigo || '';
                const famHtml  = faNombre ? `<span class="ri-drop-fam">${faCodigo} - ${faNombre}</span>` : '';
                html += `<div class="ri-drop-item" onclick="riSelect(${p.id_pro},'${nombre}','${codigo}','${faNombre}','${faCodigo}')">
                    <div class="ri-drop-name">${p.pro_nombre}</div>
                    <div class="ri-drop-meta"><span class="ri-drop-code">${codigo}</span>${famHtml}</div>
                </div>`;
            });
        } else {
            html = `<div class="ri-drop-empty">Sin resultados para "${$('<div>').text(valor).html()}"</div>`;
        }
        riDropdown.innerHTML = html;
        riDropdown.classList.add('open');
    });
}

function riSelect(id, nombre, codigo, faNombre, faCodigo) {
    document.getElementById('ri_id_pro').value = id;
    document.getElementById('ri_selected_name').textContent = nombre;
    let meta = codigo ? 'Cód: ' + codigo : '';
    if (faNombre) meta += (meta ? '  ·  ' : '') + faCodigo + ' - ' + faNombre;
    document.getElementById('ri_selected_meta').textContent = meta;
    document.getElementById('ri_selected').classList.add('visible');
    riInput.value = '';
    riInput.placeholder = 'Producto seleccionado — haz clic en × para todos';
    riDropdown.classList.remove('open');
    riDropdown.innerHTML = '';
    riProductSelected = true;
}

function riClearProduct() {
    document.getElementById('ri_id_pro').value = '';
    document.getElementById('ri_selected').classList.remove('visible');
    riInput.value = '';
    riInput.placeholder = 'Todos los productos…';
    riProductSelected = false;
    riInput.focus();
}
</script>
@endsection
