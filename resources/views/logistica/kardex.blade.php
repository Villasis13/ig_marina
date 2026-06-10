@extends('layouts.plantilla')
@section('content')
<style>
:root {
  --kx-accent:   #2563eb;
  --kx-success:  #16a34a;
  --kx-surface:  #ffffff;
  --kx-bg:       #f1f5f9;
  --kx-border:   #e2e8f0;
  --kx-text:     #1e293b;
  --kx-muted:    #64748b;
  --kx-radius:   10px;
}

.kx-wrap {
  max-width: 780px;
  margin: 32px auto;
  padding: 0 16px 60px;
}

/* Page title */
.kx-title {
  font-size: 22px;
  font-weight: 700;
  color: var(--kx-text);
  letter-spacing: -.3px;
  margin-bottom: 4px;
}
.kx-subtitle {
  font-size: 13px;
  color: var(--kx-muted);
  margin-bottom: 24px;
}

/* Card */
.kx-card {
  background: var(--kx-surface);
  border: 1px solid var(--kx-border);
  border-radius: var(--kx-radius);
  box-shadow: 0 2px 12px rgba(15,23,42,.06);
  overflow: visible;
}
.kx-card-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--kx-border);
  font-size: 13px;
  font-weight: 600;
  color: var(--kx-muted);
  text-transform: uppercase;
  letter-spacing: .6px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.kx-card-header i { color: var(--kx-accent); font-size: 14px; }
.kx-card-body { padding: 20px 20px 24px; }

/* Field group */
.kx-label {
  display: block;
  font-size: 11.5px;
  font-weight: 600;
  color: var(--kx-muted);
  text-transform: uppercase;
  letter-spacing: .5px;
  margin-bottom: 6px;
}
.kx-input {
  width: 100%;
  padding: 9px 13px;
  font-size: 13.5px;
  border: 1px solid var(--kx-border);
  border-radius: 7px;
  background: var(--kx-bg);
  color: var(--kx-text);
  transition: border-color .15s, box-shadow .15s;
  outline: none;
}
.kx-input:focus {
  border-color: var(--kx-accent);
  box-shadow: 0 0 0 3px rgba(37,99,235,.12);
  background: #fff;
}

/* Product search */
.kx-search-wrap { position: relative; }
.kx-search-icon {
  position: absolute;
  left: 11px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--kx-muted);
  font-size: 13px;
  pointer-events: none;
}
.kx-search-input {
  width: 100%;
  padding: 9px 13px 9px 34px;
  font-size: 13.5px;
  border: 1px solid var(--kx-border);
  border-radius: 7px;
  background: var(--kx-bg);
  color: var(--kx-text);
  transition: border-color .15s, box-shadow .15s;
  outline: none;
}
.kx-search-input:focus {
  border-color: var(--kx-accent);
  box-shadow: 0 0 0 3px rgba(37,99,235,.12);
  background: #fff;
}
.kx-dropdown {
  position: absolute;
  top: calc(100% + 4px);
  left: 0;
  right: 0;
  z-index: 9999;
  background: #fff;
  border: 1px solid var(--kx-border);
  border-radius: 8px;
  box-shadow: 0 8px 28px rgba(15,23,42,.13);
  max-height: 300px;
  overflow-y: auto;
  display: none;
}
.kx-dropdown.open { display: block; }
.kx-drop-item {
  padding: 9px 14px;
  cursor: pointer;
  border-bottom: 1px solid #f1f5f9;
  transition: background .12s;
}
.kx-drop-item:last-child { border-bottom: none; }
.kx-drop-item:hover { background: #eff6ff; }
.kx-drop-name  { font-size: 13px; font-weight: 600; color: var(--kx-text); }
.kx-drop-meta  { font-size: 11px; color: var(--kx-muted); margin-top: 2px; }
.kx-drop-code  { font-family: monospace; color: #6b7280; }
.kx-drop-fam   { color: #2563eb; margin-left: 6px; }
.kx-drop-empty { padding: 12px 14px; font-size: 13px; color: var(--kx-muted); font-style: italic; }

/* Selected product chip */
.kx-selected {
  display: none;
  align-items: center;
  gap: 10px;
  background: #eff6ff;
  border: 1px solid #bfdbfe;
  border-radius: 8px;
  padding: 10px 14px;
  margin-top: 8px;
}
.kx-selected.visible { display: flex; }
.kx-selected-info { flex: 1; min-width: 0; }
.kx-selected-name {
  font-size: 13.5px;
  font-weight: 600;
  color: var(--kx-text);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.kx-selected-meta { font-size: 11.5px; color: var(--kx-muted); margin-top: 1px; }
.kx-selected-badge {
  background: #2563eb;
  color: #fff;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .4px;
  padding: 2px 7px;
  border-radius: 4px;
  flex-shrink: 0;
}
.kx-btn-clear {
  background: none;
  border: none;
  cursor: pointer;
  color: var(--kx-muted);
  font-size: 14px;
  padding: 0;
  line-height: 1;
  flex-shrink: 0;
  transition: color .12s;
}
.kx-btn-clear:hover { color: #dc2626; }

/* Type toggle */
.kx-type-group {
  display: flex;
  gap: 0;
  border: 1px solid var(--kx-border);
  border-radius: 8px;
  overflow: hidden;
}
.kx-type-opt { display: none; }
.kx-type-label {
  flex: 1;
  text-align: center;
  padding: 9px 16px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  color: var(--kx-muted);
  background: var(--kx-bg);
  border-right: 1px solid var(--kx-border);
  transition: background .15s, color .15s;
  user-select: none;
}
.kx-type-label:last-child { border-right: none; }
.kx-type-opt:checked + .kx-type-label {
  background: var(--kx-accent);
  color: #fff !important;
}

/* Date row */
.kx-date-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

/* Divider */
.kx-divider {
  border: none;
  border-top: 1px solid var(--kx-border);
  margin: 20px 0;
}

/* Action buttons */
.kx-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  align-items: center;
  padding-top: 4px;
}
.kx-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 9px 22px;
  font-size: 13.5px;
  font-weight: 600;
  border: none;
  border-radius: 7px;
  cursor: pointer;
  transition: opacity .15s, transform .1s;
}
.kx-btn:active { transform: scale(.97); }
.kx-btn:disabled {
  opacity: .45;
  cursor: not-allowed;
  transform: none;
}
.kx-btn-pdf {
  background: #dc2626;
  color: #fff;
}
.kx-btn-pdf:hover:not(:disabled) { background: #b91c1c; }
.kx-btn-excel {
  background: var(--kx-success);
  color: #fff;
}
.kx-btn-excel:hover:not(:disabled) { background: #15803d; }

/* Required asterisk */
.req { color: #dc2626; margin-left: 2px; }
</style>

<div class="kx-wrap">

  <div class="kx-title"><i class="fa-solid fa-table-list me-2" style="color:#2563eb"></i>Kardex de Productos</div>
  <div class="kx-subtitle">Consulta el movimiento de inventario por producto, tipo y rango de fechas.</div>

  <div class="kx-card">
    <div class="kx-card-header">
      <i class="fa-solid fa-filter"></i>
      Filtros de consulta
    </div>
    <div class="kx-card-body">

      {{-- ── Buscador de producto ── --}}
      <div style="margin-bottom:20px">
        <label class="kx-label">Producto <span class="req">*</span></label>
        <div class="kx-search-wrap">
          <i class="fa-solid fa-magnifying-glass kx-search-icon"></i>
          <input
            type="text"
            id="kx_buscar_input"
            class="kx-search-input"
            placeholder="Buscar por nombre, código o familia…"
            autocomplete="off"
          >
          <div id="kx_dropdown" class="kx-dropdown"></div>
        </div>

        {{-- Producto seleccionado --}}
        <div id="kx_selected" class="kx-selected">
          <span class="kx-selected-badge">Seleccionado</span>
          <div class="kx-selected-info">
            <div class="kx-selected-name" id="kx_selected_name">—</div>
            <div class="kx-selected-meta" id="kx_selected_meta"></div>
          </div>
          <button type="button" class="kx-btn-clear" onclick="kxClearProduct()" title="Quitar producto">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>

        {{-- Hidden inputs --}}
        <input type="hidden" id="kx_id_pro" value="">
      </div>

      <hr class="kx-divider">

      {{-- ── Tipo de kardex ── --}}
      <div style="margin-bottom:20px">
        <label class="kx-label">Tipo de Kardex <span class="req">*</span></label>
        <div class="kx-type-group">
          <input type="radio" name="kx_tipo" id="kx_tipo_fisico" class="kx-type-opt" value="F" checked>
          <label class="kx-type-label" for="kx_tipo_fisico">
            <i class="fa-solid fa-boxes-stacked me-1"></i>Físico
          </label>
          <input type="radio" name="kx_tipo" id="kx_tipo_valorizado" class="kx-type-opt" value="V">
          <label class="kx-type-label" for="kx_tipo_valorizado">
            <i class="fa-solid fa-coins me-1"></i>Valorizado
          </label>
        </div>
      </div>

      <hr class="kx-divider">

      {{-- ── Rango de fechas ── --}}
      <div class="kx-date-row" style="margin-bottom:24px">
        <div>
          <label class="kx-label" for="kx_fecha_desde">Fecha desde <span class="req">*</span></label>
          <input
            type="date"
            id="kx_fecha_desde"
            class="kx-input"
            value="{{ date('Y-m-01') }}"
          >
        </div>
        <div>
          <label class="kx-label" for="kx_fecha_hasta">Fecha hasta <span class="req">*</span></label>
          <input
            type="date"
            id="kx_fecha_hasta"
            class="kx-input"
            value="{{ date('Y-m-d') }}"
          >
        </div>
      </div>

      {{-- ── Botones ── --}}
      <div class="kx-actions">
        <button type="button" class="kx-btn kx-btn-excel" id="kx_btn_excel" disabled onclick="kxExcel()">
          <i class="fa-solid fa-file-excel"></i> Excel
        </button>
        <button type="button" class="kx-btn kx-btn-pdf" id="kx_btn_pdf" disabled onclick="kxPdf()">
          <i class="fa-solid fa-file-pdf"></i> PDF
        </button>
      </div>

    </div>
  </div>

</div>

<script>
/* ── STATE ────────────────────────────────────────────────────── */
let kxSearchTimer = null;
let kxProductSelected = false;

/* ── PRODUCT SEARCH ───────────────────────────────────────────── */
const kxInput    = document.getElementById('kx_buscar_input');
const kxDropdown = document.getElementById('kx_dropdown');

kxInput.addEventListener('input', function () {
  clearTimeout(kxSearchTimer);
  const val = this.value.trim();
  if (val.length < 2) {
    kxDropdown.innerHTML = '';
    kxDropdown.classList.remove('open');
    return;
  }
  kxSearchTimer = setTimeout(() => kxSearch(val), 280);
});

kxInput.addEventListener('focus', function () {
  if (kxDropdown.innerHTML && !kxProductSelected) {
    kxDropdown.classList.add('open');
  }
});

document.addEventListener('click', function (e) {
  if (!e.target.closest('.kx-search-wrap')) {
    kxDropdown.classList.remove('open');
  }
});

function kxSearch(valor) {
  $.ajax({
    type: 'POST',
    url: '{{ route("Gestionventas.buscar_productos") }}',
    data: { valor: valor, _token: $("meta[name='csrf-token']").attr('content') },
    dataType: 'json',
  }).done(function (r) {
    const items = r.result.code;
    let html = '';
    if (items && items.length > 0) {
      items.forEach(function (p) {
        const fam = p.fa_nombre
          ? `<span class="kx-drop-fam">${p.familia_codigo || ''} - ${p.fa_nombre}</span>`
          : '';
        html += `<div class="kx-drop-item" onclick="kxSelect(${p.id_pro}, '${escKx(p.pro_nombre)}', '${escKx(p.pro_codigo || '')}', '${escKx(p.fa_nombre || '')}', '${escKx(p.familia_codigo || '')}')">
          <div class="kx-drop-name">${p.pro_nombre}</div>
          <div class="kx-drop-meta">
            <span class="kx-drop-code">${p.pro_codigo || ''}</span>${fam}
          </div>
        </div>`;
      });
    } else {
      html = '<div class="kx-drop-empty">Sin resultados para "' + $('<div>').text(valor).html() + '"</div>';
    }
    kxDropdown.innerHTML = html;
    kxDropdown.classList.add('open');
  });
}

function escKx(str) {
  return String(str).replace(/'/g, "\\'").replace(/"/g, '&quot;');
}

function kxSelect(id_pro, nombre, codigo, fa_nombre, fa_codigo) {
  document.getElementById('kx_id_pro').value = id_pro;
  document.getElementById('kx_selected_name').textContent = nombre;

  let meta = codigo ? 'Cód: ' + codigo : '';
  if (fa_nombre) meta += (meta ? '  ·  ' : '') + fa_codigo + ' - ' + fa_nombre;
  document.getElementById('kx_selected_meta').textContent = meta;

  document.getElementById('kx_selected').classList.add('visible');
  kxInput.value = '';
  kxInput.placeholder = 'Producto seleccionado — haz clic en × para cambiar';
  kxDropdown.classList.remove('open');
  kxDropdown.innerHTML = '';
  kxProductSelected = true;

  kxUpdateButtons();
}

function kxClearProduct() {
  document.getElementById('kx_id_pro').value = '';
  document.getElementById('kx_selected').classList.remove('visible');
  kxInput.value = '';
  kxInput.placeholder = 'Buscar por nombre, código o familia…';
  kxProductSelected = false;
  kxUpdateButtons();
  kxInput.focus();
}

/* ── BUTTONS ──────────────────────────────────────────────────── */
function kxUpdateButtons() {
  const ok = kxProductSelected &&
             document.getElementById('kx_fecha_desde').value &&
             document.getElementById('kx_fecha_hasta').value;
  document.getElementById('kx_btn_pdf').disabled   = !ok;
  document.getElementById('kx_btn_excel').disabled = !ok;
}

document.getElementById('kx_fecha_desde').addEventListener('change', kxUpdateButtons);
document.getElementById('kx_fecha_hasta').addEventListener('change', kxUpdateButtons);

function kxPdf() {
  const id_pro      = document.getElementById('kx_id_pro').value;
  const tipo        = document.querySelector('input[name="kx_tipo"]:checked').value;
  const fecha_desde = document.getElementById('kx_fecha_desde').value;
  const fecha_hasta = document.getElementById('kx_fecha_hasta').value;

  if (!id_pro) { alert('Selecciona un producto.'); return; }
  if (fecha_desde > fecha_hasta) { alert('La fecha desde no puede ser mayor a la fecha hasta.'); return; }

  const url = '{{ route("logistica.kardex_pdf") }}?id_pro=' + encodeURIComponent(id_pro)
            + '&tipo=' + encodeURIComponent(tipo)
            + '&fecha_desde=' + encodeURIComponent(fecha_desde)
            + '&fecha_hasta=' + encodeURIComponent(fecha_hasta);
  window.open(url, '_blank');
}

function kxExcel() {
  const id_pro      = document.getElementById('kx_id_pro').value;
  const tipo        = document.querySelector('input[name="kx_tipo"]:checked').value;
  const fecha_desde = document.getElementById('kx_fecha_desde').value;
  const fecha_hasta = document.getElementById('kx_fecha_hasta').value;

  if (!id_pro) { alert('Selecciona un producto.'); return; }
  if (fecha_desde > fecha_hasta) { alert('La fecha desde no puede ser mayor a la fecha hasta.'); return; }

  const url = '{{ route("logistica.kardex_excel") }}?id_pro=' + encodeURIComponent(id_pro)
            + '&tipo=' + encodeURIComponent(tipo)
            + '&fecha_desde=' + encodeURIComponent(fecha_desde)
            + '&fecha_hasta=' + encodeURIComponent(fecha_hasta);
  window.location.href = url;
}
</script>
@endsection
