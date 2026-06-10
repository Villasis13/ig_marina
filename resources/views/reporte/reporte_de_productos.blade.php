@extends('layouts.plantilla')
@section('content')
<style>
.rp-search-label {
  display: block;
  font-size: 11.5px;
  font-weight: 600;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: .5px;
  margin-bottom: 6px;
}
.rp-search-wrap { position: relative; }
.rp-search-icon {
  position: absolute;
  left: 11px;
  top: 50%;
  transform: translateY(-50%);
  color: #64748b;
  font-size: 13px;
  pointer-events: none;
}
.rp-search-input {
  width: 100%;
  padding: 9px 13px 9px 34px;
  font-size: 13.5px;
  border: 1px solid #e2e8f0;
  border-radius: 7px;
  background: #f1f5f9;
  color: #1e293b;
  transition: border-color .15s, box-shadow .15s;
  outline: none;
}
.rp-search-input:focus {
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37,99,235,.12);
  background: #fff;
}
.rp-dropdown {
  position: absolute;
  top: calc(100% + 4px);
  left: 0;
  right: 0;
  z-index: 9999;
  background: #fff;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  box-shadow: 0 8px 28px rgba(15,23,42,.13);
  max-height: 280px;
  overflow-y: auto;
  display: none;
}
.rp-dropdown.open { display: block; }
.rp-drop-item {
  padding: 9px 14px;
  cursor: pointer;
  border-bottom: 1px solid #f1f5f9;
  transition: background .12s;
}
.rp-drop-item:last-child { border-bottom: none; }
.rp-drop-item:hover { background: #eff6ff; }
.rp-drop-name  { font-size: 13px; font-weight: 600; color: #1e293b; }
.rp-drop-meta  { font-size: 11px; color: #64748b; margin-top: 2px; }
.rp-drop-code  { font-family: monospace; color: #6b7280; }
.rp-drop-fam   { color: #2563eb; margin-left: 6px; }
.rp-drop-empty { padding: 12px 14px; font-size: 13px; color: #64748b; font-style: italic; }

.rp-selected {
  display: none;
  align-items: center;
  gap: 10px;
  background: #eff6ff;
  border: 1px solid #bfdbfe;
  border-radius: 8px;
  padding: 8px 14px;
  margin-top: 8px;
}
.rp-selected.visible { display: flex; }
.rp-selected-badge {
  background: #2563eb;
  color: #fff;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .4px;
  padding: 2px 7px;
  border-radius: 4px;
  flex-shrink: 0;
}
.rp-selected-info { flex: 1; min-width: 0; }
.rp-selected-name {
  font-size: 13px;
  font-weight: 600;
  color: #1e293b;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.rp-selected-meta { font-size: 11.5px; color: #64748b; margin-top: 1px; }
.rp-btn-clear {
  background: none;
  border: none;
  cursor: pointer;
  color: #64748b;
  font-size: 14px;
  padding: 0;
  flex-shrink: 0;
  transition: color .12s;
}
.rp-btn-clear:hover { color: #dc2626; }
</style>

<div class="tab-content">
    @can($opciones[0]->opciones_funcion)
        <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active" role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="card">
                    <div class="row m-3">
                        <div class="col-lg-12 text-center">
                            <h6 class="m-0 text-primary">REPORTE DE PRODUCTOS</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <form id="formulario_vvvv" action="{{ route('reporte.reporte_de_productos') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="enviar" value="1">
                    <input type="hidden" name="id_pro_filtro" id="rp_id_pro" value="{{ $id_pro_filtro ?? '' }}">

                    <div class="row">
                        {{-- Columna izquierda: filtros de periodo --}}
                        <div class="col-lg-2 col-md-3 col-sm-12 mb-2">
                            <div class="card">
                                <div class="card-body">
                                    @foreach([['d','Diario'],['s','Semanal'],['q','Quincenal'],['m','Mensual'],['tri','Trimestral'],['sem','Semestral'],['a','Anual']] as [$val,$label])
                                    <div class="mb-2">
                                        <input onclick="cambiar_fec_general()" type="radio" name="opcion" id="op_{{$val}}" value="{{$val}}" {{ $check == $val ? 'checked' : '' }}>
                                        <label for="op_{{$val}}">{{$label}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Columna derecha: filtros + resultados --}}
                        <div class="col-lg-10 col-md-9 col-sm-12 mb-2">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row g-2 align-items-end">

                                        {{-- Buscador de producto --}}
                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                            <label class="rp-search-label"><i class="fa-solid fa-magnifying-glass"></i> Producto (opcional)</label>
                                            <div class="rp-search-wrap">
                                                <i class="fa-solid fa-magnifying-glass rp-search-icon"></i>
                                                <input type="text" id="rp_buscar_input" class="rp-search-input"
                                                       placeholder="Todos los productos…" autocomplete="off">
                                                <div id="rp_dropdown" class="rp-dropdown"></div>
                                            </div>
                                            <div id="rp_selected" class="rp-selected {{ ($id_pro_filtro ?? '') ? 'visible' : '' }}">
                                                <span class="rp-selected-badge">Filtro</span>
                                                <div class="rp-selected-info">
                                                    <div class="rp-selected-name" id="rp_selected_name">{{ $pro_filtro_nombre ?? '' }}</div>
                                                    <div class="rp-selected-meta" id="rp_selected_meta">{{ $pro_filtro_codigo ?? '' }}</div>
                                                </div>
                                                <button type="button" class="rp-btn-clear" onclick="rpClearProduct()" title="Quitar filtro">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Fecha desde --}}
                                        <div class="col-lg-2 col-md-4 col-sm-12">
                                            <label for="desde">Desde</label>
                                            <input type="date" class="form-control" name="desde" id="desde" value="{{ $fecha_inicio }}">
                                        </div>

                                        {{-- Fecha hasta --}}
                                        <div class="col-lg-2 col-md-4 col-sm-12">
                                            <label for="hasta">Hasta</label>
                                            <input type="date" class="form-control" id="hasta" name="hasta" value="{{ $fecha_fin }}">
                                        </div>

                                        {{-- Buscar --}}
                                        <div class="col-lg-2 col-md-4 col-sm-12">
                                            <button type="submit" class="btn btn-info w-100">
                                                <i class="bx bx-search-alt"></i> Buscar
                                            </button>
                                        </div>

                                        {{-- Excel --}}
                                        @if(count($productos) > 0)
                                        <div class="col-lg-1 col-md-3 col-sm-6">
                                            <a href="{{ route('reporte.reporte_productos_excel') }}?desde={{ $fecha_inicio }}&hasta={{ $fecha_fin }}{{ ($id_pro_filtro ?? '') ? '&id_pro='.$id_pro_filtro : '' }}"
                                               class="btn btn-success w-100" target="_blank">
                                                <i class="fa fa-file-excel"></i> Excel
                                            </a>
                                        </div>
                                        <div class="col-lg-1 col-md-3 col-sm-6">
                                            <a href="{{ route('reporte.reporte_productos_pdf') }}?desde={{ $fecha_inicio }}&hasta={{ $fecha_fin }}{{ ($id_pro_filtro ?? '') ? '&id_pro='.$id_pro_filtro : '' }}"
                                               class="btn btn-danger w-100" target="_blank">
                                                <i class="fa fa-file-pdf"></i> PDF
                                            </a>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            {{-- Resultados --}}
                            <div class="row mt-1">
                                @forelse($productos as $c)
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3" style="margin-top:2%">
                                        <div class="card h-100">
                                            <img src="{{ asset($c->pro_foto) }}" style="border-radius:50%;width:19%;margin-top:-24px;" class="card-img-top" alt="">
                                            <div class="card-body">
                                                <h5 class="card-title mb-2">{{ $c->pro_nombre }}</h5>
                                                <p class="card-text mb-2">Código: <b class="text-secondary">{{ $c->pro_codigo ?? '—' }}</b></p>
                                                <p class="card-text mb-2">Precio Minorista: <b class="text-primary">S/ {{ $c->pro_precio_uni }}</b></p>
                                                <p class="card-text mb-2">Precio Mayorista: <b class="text-primary">S/ {{ $c->pro_precio_uni_ma }}</b></p>
                                                <p class="card-text mb-2">Stock Actual:
                                                    <b class="{{ $c->pro_stock > 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ $c->pro_stock }}
                                                        @php echo $c->pro_stock > 0 ? '<i class="fa-solid fa-arrow-up"></i>' : '<i class="fa-solid fa-arrow-down"></i>' @endphp
                                                    </b>
                                                </p>
                                                <p class="card-text mb-2">Ventas en período: <b class="text-primary" style="font-size:16pt">{{ $c->mas_vendidos }}</b></p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    @if(isset($searched) && $searched)
                                    <div class="col-12 text-center text-muted py-4">
                                        <i class="fa-solid fa-box-open fa-2x mb-2"></i>
                                        <p>Sin resultados para el período seleccionado.</p>
                                    </div>
                                    @endif
                                @endforelse
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endcan
</div>

<script src="{{ asset('js/domain.js') }}"></script>
<script src="{{ asset('js/reporte.js') }}"></script>
<script>
let rpSearchTimer = null;
let rpProductSelected = {{ ($id_pro_filtro ?? '') ? 'true' : 'false' }};

const rpInput    = document.getElementById('rp_buscar_input');
const rpDropdown = document.getElementById('rp_dropdown');

rpInput.addEventListener('input', function () {
    clearTimeout(rpSearchTimer);
    const val = this.value.trim();
    if (val.length < 2) {
        rpDropdown.innerHTML = '';
        rpDropdown.classList.remove('open');
        return;
    }
    rpSearchTimer = setTimeout(() => rpSearch(val), 280);
});

rpInput.addEventListener('focus', function () {
    if (rpDropdown.innerHTML && !rpProductSelected) rpDropdown.classList.add('open');
});

document.addEventListener('click', function (e) {
    if (!e.target.closest('.rp-search-wrap')) rpDropdown.classList.remove('open');
});

function rpSearch(valor) {
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
                const famHtml  = faNombre ? `<span class="rp-drop-fam">${faCodigo} - ${faNombre}</span>` : '';
                html += `<div class="rp-drop-item" onclick="rpSelect(${p.id_pro},'${nombre}','${codigo}','${faNombre}','${faCodigo}')">
                    <div class="rp-drop-name">${p.pro_nombre}</div>
                    <div class="rp-drop-meta"><span class="rp-drop-code">${codigo}</span>${famHtml}</div>
                </div>`;
            });
        } else {
            html = `<div class="rp-drop-empty">Sin resultados para "${$('<div>').text(valor).html()}"</div>`;
        }
        rpDropdown.innerHTML = html;
        rpDropdown.classList.add('open');
    });
}

function rpSelect(id, nombre, codigo, faNombre, faCodigo) {
    document.getElementById('rp_id_pro').value = id;
    document.getElementById('rp_selected_name').textContent = nombre;
    let meta = codigo ? 'Cód: ' + codigo : '';
    if (faNombre) meta += (meta ? '  ·  ' : '') + faCodigo + ' - ' + faNombre;
    document.getElementById('rp_selected_meta').textContent = meta;
    document.getElementById('rp_selected').classList.add('visible');
    rpInput.value = '';
    rpInput.placeholder = 'Producto seleccionado — haz clic en × para todos';
    rpDropdown.classList.remove('open');
    rpDropdown.innerHTML = '';
    rpProductSelected = true;
}

function rpClearProduct() {
    document.getElementById('rp_id_pro').value = '';
    document.getElementById('rp_selected').classList.remove('visible');
    rpInput.value = '';
    rpInput.placeholder = 'Todos los productos…';
    rpProductSelected = false;
    rpInput.focus();
}
</script>
@endsection
