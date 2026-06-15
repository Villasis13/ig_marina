@extends('layouts.plantilla')
@section('content')
<style>
:root {
  --bg: #f0f2f7;
  --surface: #ffffff;
  --surface-2: #f8f9fc;
  --border: #e2e6f0;
  --border-focus: #3b6cf8;
  --accent: #3b6cf8;
  --accent-dark: #2952d9;
  --accent-light: #eef2ff;
  --success: #16a34a;
  --success-bg: #f0fdf4;
  --success-border: #86efac;
  --error: #dc2626;
  --error-bg: #fef2f2;
  --error-border: #fca5a5;
  --text: #111827;
  --text-2: #4b5563;
  --text-3: #9ca3af;
  --shadow-sm: 0 1px 3px rgba(0,0,0,0.06),0 1px 2px rgba(0,0,0,0.04);
  --shadow: 0 4px 16px rgba(0,0,0,0.07),0 1px 3px rgba(0,0,0,0.04);
  --shadow-lg: 0 12px 40px rgba(0,0,0,0.12);
  --radius: 12px;
  --radius-sm: 8px;
}

/* ── LAYOUT ── */
.guia-wrap { max-width: 1060px; margin: 0 auto; padding: 24px 16px 80px; display: flex; flex-direction: column; gap: 0; }

/* ── TOP BAR ── */
.guia-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.guia-topbar-left { display: flex; align-items: center; gap: 10px; }
.guia-topbar h5 { font-size: 18px; font-weight: 700; letter-spacing: -0.3px; margin: 0; color: var(--text); }
.guia-topbar-sub { font-size: 12.5px; color: var(--text-3); margin-top: 2px; }

/* ── VINCULAR BUTTON ── */
.btn-vincular-fact {
  display: flex; align-items: center; gap: 8px;
  background: var(--accent); color: #fff; border: none;
  border-radius: var(--radius-sm); padding: 9px 16px;
  font-size: 13px; font-weight: 600; cursor: pointer;
  box-shadow: 0 2px 8px rgba(59,108,248,0.25);
  transition: background .15s, box-shadow .15s, transform .1s;
}
.btn-vincular-fact:hover { background: var(--accent-dark); box-shadow: 0 4px 14px rgba(59,108,248,0.35); transform: translateY(-1px); }
.btn-vincular-fact:active { transform: translateY(0); }

/* ── INVOICE BANNER ── */
.invoice-banner {
  display: none; align-items: center; gap: 12px;
  background: var(--success-bg); border: 1px solid var(--success-border);
  border-radius: var(--radius-sm); padding: 11px 16px;
  margin-bottom: 14px; font-size: 13px; color: var(--success); font-weight: 500;
}
.invoice-banner.visible { display: flex; }
.invoice-banner-remove {
  margin-left: auto; background: none; border: none; cursor: pointer;
  color: var(--success); font-size: 15px; opacity: 0.7; transition: opacity .15s;
}
.invoice-banner-remove:hover { opacity: 1; }

/* ── SECTION CARD ── */
.guia-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow-sm); overflow: hidden; margin-bottom: 14px; transition: box-shadow .2s; }
.guia-card:hover { box-shadow: var(--shadow); }
.guia-card-header { display: flex; align-items: center; gap: 12px; padding: 14px 22px; border-bottom: 1px solid var(--border); background: var(--surface-2); }
.guia-card-num { width: 24px; height: 24px; background: var(--accent); color: #fff; border-radius: 50%; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-family: monospace; }
.guia-card-title { font-size: 13.5px; font-weight: 600; color: var(--text); }
.guia-card-desc { font-size: 11.5px; color: var(--text-3); margin-top: 1px; }
.guia-card-body { padding: 20px 22px; }

/* ── SUBSECTION ── */
.guia-sub { margin-bottom: 18px; }
.guia-sub:last-child { margin-bottom: 0; }
.guia-sub-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--text-3); margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px dashed var(--border); }
.guia-divider { height: 1px; background: var(--border); margin: 16px 0; }

/* ── FIELD ── */
.gf { display: flex; flex-direction: column; gap: 5px; }
.gf label { font-size: 11.5px; font-weight: 600; color: var(--text-2); }
.gf label .req { color: var(--error); margin-left: 3px; }
.gf label .opt { color: var(--text-3); font-weight: 400; font-size: 10.5px; margin-left: 3px; }
.gf input, .gf select, .gf textarea {
  background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius-sm);
  padding: 8px 11px; font-size: 13px; color: var(--text); outline: none; width: 100%;
  transition: border-color .18s, box-shadow .18s; appearance: none; -webkit-appearance: none;
}
.gf select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca3af' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 10px center; padding-right: 28px; cursor: pointer;
}
.gf textarea { resize: vertical; min-height: 68px; }
.gf input:focus, .gf select:focus, .gf textarea:focus { border-color: var(--border-focus); box-shadow: 0 0 0 3px rgba(59,108,248,.1); }
.gf input.autofilled { background: #f0fdf4; border-color: #86efac; color: #166534; }

/* ── SERIE BADGE ── */
.serie-badge {
  display: flex; align-items: center; gap: 8px;
  background: var(--accent-light); border: 1.5px solid #c7d7fd;
  border-radius: var(--radius-sm); padding: 8px 12px;
  font-family: monospace; font-size: 13.5px; font-weight: 700; color: var(--accent); letter-spacing: 1px;
  min-height: 38px;
}

/* ── GRID ── */
.gg2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.gg3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }
.gg4 { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 14px; }
.gc2 { grid-column: span 2; }
.gc3 { grid-column: span 3; }
.gc4 { grid-column: span 4; }

/* ── FIELD WITH BUTTON ── */
.gf-btn { display: flex; gap: 8px; align-items: flex-end; }
.gf-btn .gf { flex: 1; }
.btn-srch {
  flex-shrink: 0; height: 37px; padding: 0 13px;
  background: var(--accent-light); border: 1.5px solid #c7d7fd;
  border-radius: var(--radius-sm); color: var(--accent); font-size: 12px; font-weight: 600;
  cursor: pointer; transition: background .15s, border-color .15s;
  display: flex; align-items: center; gap: 5px; white-space: nowrap;
}
.btn-srch:hover { background: #dce8ff; border-color: var(--accent); }

/* ── CLIENT SEARCH BTN ── */
.btn-client-srch {
  display: inline-flex; align-items: center; gap: 7px;
  background: none; border: 1.5px solid var(--border); border-radius: var(--radius-sm);
  padding: 7px 13px; font-size: 12px; font-weight: 600; color: var(--text-2);
  cursor: pointer; transition: border-color .15s, color .15s, background .15s; margin-bottom: 14px;
}
.btn-client-srch:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-light); }

/* ── ITEMS TABLE ── */
.items-hdr { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
.items-count { font-size: 12.5px; color: var(--text-2); }
.items-count span { font-weight: 700; color: var(--accent); }
.btn-add-item {
  display: flex; align-items: center; gap: 6px;
  background: var(--accent); color: #fff; border: none; border-radius: var(--radius-sm);
  padding: 7px 13px; font-size: 12.5px; font-weight: 600; cursor: pointer;
  box-shadow: 0 2px 6px rgba(59,108,248,0.2); transition: background .15s, box-shadow .15s;
}
.btn-add-item:hover { background: var(--accent-dark); box-shadow: 0 4px 12px rgba(59,108,248,0.3); }
.table-wrap { border: 1.5px solid var(--border); border-radius: var(--radius-sm); overflow: hidden; }
.items-tbl { width: 100%; border-collapse: collapse; font-size: 12.5px; }
.items-tbl thead tr { background: var(--surface-2); border-bottom: 1.5px solid var(--border); }
.items-tbl th { padding: 9px 8px; text-align: left; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-3); white-space: nowrap; }
.items-tbl td { padding: 6px 7px; border-bottom: 1px solid var(--border); vertical-align: middle; }
.items-tbl tbody tr:last-child td { border-bottom: none; }
.items-tbl tbody tr:hover { background: var(--surface-2); }
.items-tbl input, .items-tbl select {
  width: 100%; background: transparent; border: 1.5px solid transparent; border-radius: 6px;
  padding: 4px 7px; font-size: 12.5px; color: var(--text); outline: none;
  transition: border-color .15s, background .15s; appearance: none; -webkit-appearance: none;
}
.items-tbl input:focus, .items-tbl select:focus { border-color: var(--border-focus); background: #fff; box-shadow: 0 0 0 2px rgba(59,108,248,.08); }
.items-tbl input.autofilled { background: #f0fdf4; border-color: #86efac; color: #166534; }
.col-pt { font-family: monospace; font-size: 12px; font-weight: 600; color: var(--accent); text-align: right; white-space: nowrap; }
.btn-del-row { background: none; border: none; cursor: pointer; color: var(--text-3); width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; border-radius: 5px; transition: background .15s, color .15s; font-size: 13px; }
.btn-del-row:hover { background: var(--error-bg); color: var(--error); }
.empty-tbl { text-align: center; padding: 28px 16px; color: var(--text-3); font-size: 13px; }

/* ── PESO SUMMARY ── */
.peso-summary { margin-top: 8px; display: flex; justify-content: flex-end; gap: 20px; }
.peso-summary span { font-size: 12px; color: var(--text-3); }
.peso-summary strong { font-size: 13px; font-weight: 700; color: var(--accent); font-family: monospace; }

/* ── FOOTER ── */
.guia-footer { display: flex; align-items: center; justify-content: flex-end; gap: 12px; padding: 18px 0 0; border-top: 1px solid var(--border); margin-top: 4px; }
.btn-cancel-guia { padding: 10px 22px; background: none; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 600; color: var(--text-2); cursor: pointer; transition: border-color .15s, background .15s, color .15s; }
.btn-cancel-guia:hover { border-color: var(--error); background: var(--error-bg); color: var(--error); }
.btn-save-guia { padding: 10px 26px; background: var(--accent); border: none; border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 700; color: #fff; cursor: pointer; box-shadow: 0 4px 14px rgba(59,108,248,0.3); display: flex; align-items: center; gap: 7px; transition: background .15s, box-shadow .15s, transform .1s; }
.btn-save-guia:hover { background: var(--accent-dark); box-shadow: 0 6px 20px rgba(59,108,248,0.4); transform: translateY(-1px); }
.btn-save-guia:active { transform: translateY(0); }

/* ── MODAL ── */
.modal-ov { display: none; position: fixed; inset: 0; background: rgba(15,23,42,.45); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 16px; }
.modal-ov.open { display: flex; }
.modal-box { background: var(--surface); border-radius: var(--radius); box-shadow: var(--shadow-lg); width: 100%; animation: mIn .2s cubic-bezier(.34,1.56,.64,1); }
.modal-box.modal-sm { max-width: 460px; }
.modal-box.modal-lg { max-width: 720px; }
@keyframes mIn { from { opacity:0; transform: scale(.92) translateY(12px); } to { opacity:1; transform: scale(1) translateY(0); } }
.modal-hdr { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--border); }
.modal-ttl { font-size: 14.5px; font-weight: 700; color: var(--text); }
.modal-cls { background: none; border: none; cursor: pointer; color: var(--text-3); font-size: 17px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 6px; transition: background .15s, color .15s; }
.modal-cls:hover { background: var(--surface-2); color: var(--text); }
.modal-bdy { padding: 20px; }
.modal-ftr { padding: 13px 20px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }
.modal-fields { display: grid; grid-template-columns: 130px 1fr; gap: 12px; margin-bottom: 14px; }
.btn-modal-search { width: 100%; padding: 10px; background: var(--accent); border: none; border-radius: var(--radius-sm); color: #fff; font-size: 13.5px; font-weight: 600; cursor: pointer; transition: background .15s; display: flex; align-items: center; justify-content: center; gap: 8px; }
.btn-modal-search:hover { background: var(--accent-dark); }
.btn-sm-ghost { padding: 7px 16px; border-radius: var(--radius-sm); font-size: 12.5px; font-weight: 600; cursor: pointer; transition: background .15s, border-color .15s; background: none; border: 1.5px solid var(--border); color: var(--text-2); }
.btn-sm-ghost:hover { border-color: var(--text-3); background: var(--surface-2); }

/* ── SEARCH RESULTS TABLE (modal) ── */
.results-tbl { width: 100%; border-collapse: collapse; font-size: 12.5px; margin-top: 14px; }
.results-tbl th { padding: 8px 10px; background: var(--surface-2); border-bottom: 1.5px solid var(--border); font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-3); text-align: left; }
.results-tbl td { padding: 8px 10px; border-bottom: 1px solid var(--border); vertical-align: top; }
.results-tbl tbody tr:last-child td { border-bottom: none; }
.results-tbl tbody tr:hover { background: var(--accent-light); }
.btn-vincular-row { padding: 5px 12px; background: var(--accent); border: none; border-radius: 6px; color: #fff; font-size: 12px; font-weight: 600; cursor: pointer; transition: background .15s; white-space: nowrap; }
.btn-vincular-row:hover { background: var(--accent-dark); }
.modal-msg { padding: 10px 14px; border-radius: var(--radius-sm); font-size: 12.5px; font-weight: 500; margin-top: 12px; display: none; }
.modal-msg.success { display: block; background: var(--success-bg); border: 1px solid var(--success-border); color: var(--success); }
.modal-msg.error { display: block; background: var(--error-bg); border: 1px solid var(--error-border); color: var(--error); }

/* ── CLIENT SEARCH MODAL ── */
.client-row { padding: 9px 12px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); cursor: pointer; transition: border-color .15s, background .15s; margin-top: 7px; }
.client-row:hover { border-color: var(--accent); background: var(--accent-light); }
.client-row-name { font-size: 13px; font-weight: 600; color: var(--text); }
.client-row-doc  { font-size: 11.5px; color: var(--text-3); font-family: monospace; }

/* ── TOAST ── */
.guia-toast { position: fixed; bottom: 22px; right: 22px; z-index: 10000; background: var(--text); color: #fff; padding: 12px 18px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500; box-shadow: var(--shadow-lg); display: flex; align-items: center; gap: 9px; opacity: 0; transform: translateY(10px); transition: opacity .25s, transform .25s; pointer-events: none; max-width: 340px; }
.guia-toast.show { opacity: 1; transform: translateY(0); }
.guia-toast.success { background: #166534; }
.guia-toast.error   { background: #991b1b; }

/* ── ALERT ── */
#alerta_guia { border-radius: var(--radius-sm); margin-bottom: 12px; }

/* ── RESPONSIVE ── */
@media (max-width: 680px) {
  .gg2, .gg3, .gg4 { grid-template-columns: 1fr; }
  .gc2, .gc3, .gc4 { grid-column: span 1; }
  .guia-topbar { flex-direction: column; align-items: flex-start; gap: 10px; }
}
</style>

{{-- TOAST --}}
<div class="guia-toast" id="guia_toast"></div>

{{-- MODAL: VINCULAR FACTURA --}}
<div class="modal-ov" id="modalFactura">
  <div class="modal-box modal-lg">
    <div class="modal-hdr">
      <span class="modal-ttl">Vincular Factura</span>
      <button class="modal-cls" onclick="cerrarModal('modalFactura')">✕</button>
    </div>
    <div class="modal-bdy">
      <p style="font-size:12.5px;color:var(--text-2);margin-bottom:14px;">Ingresa la serie y/o correlativo de la factura a vincular.</p>
      <div class="modal-fields">
        <div class="gf">
          <label>Serie <span class="req">*</span></label>
          <input type="text" id="factSerie" placeholder="F001" maxlength="10" style="text-transform:uppercase;font-family:monospace;"
                 onkeydown="if(event.key==='Enter') buscarFactura()">
        </div>
        <div class="gf">
          <label>Correlativo <span class="req">*</span></label>
          <input type="text" id="factCorrelativo" placeholder="00000001" maxlength="10" style="font-family:monospace;"
                 onkeydown="if(event.key==='Enter') buscarFactura()">
        </div>
      </div>
      <button class="btn-modal-search" onclick="buscarFactura()">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        Buscar factura
      </button>
      <div class="modal-msg" id="factMsg"></div>
      <div id="factResultados" style="max-height:320px;overflow-y:auto;"></div>
    </div>
    <div class="modal-ftr">
      <button class="btn-sm-ghost" onclick="cerrarModal('modalFactura')">Cancelar</button>
    </div>
  </div>
</div>

{{-- MODAL: BUSCAR CLIENTE --}}
<div class="modal-ov" id="modalCliente">
  <div class="modal-box modal-sm">
    <div class="modal-hdr">
      <span class="modal-ttl">Buscar Cliente</span>
      <button class="modal-cls" onclick="cerrarModal('modalCliente')">✕</button>
    </div>
    <div class="modal-bdy">
      <div class="gf-btn" style="align-items:flex-end;">
        <div class="gf" style="flex:1;">
          <label>Nombre o N° Documento</label>
          <input type="text" id="clienteBusqInput" placeholder="Buscar por nombre o documento..."
                 onkeydown="if(event.key==='Enter') buscarCliente()">
        </div>
        <button class="btn-srch" onclick="buscarCliente()">
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          Buscar
        </button>
      </div>
      <div id="clienteResultados" style="margin-top:10px;max-height:280px;overflow-y:auto;"></div>
    </div>
    <div class="modal-ftr">
      <button class="btn-sm-ghost" onclick="cerrarModal('modalCliente')">Cerrar</button>
    </div>
  </div>
</div>

<div class="guia-wrap">

  {{-- TOP BAR --}}
  <div class="guia-topbar">
    <div class="guia-topbar-left">
      <a href="{{ route('logistica.guias_remision') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:var(--radius-sm);">
        <i class="fas fa-arrow-left"></i>
      </a>
      <div>
        <h5>Nueva Guía de Remisión</h5>
        <div class="guia-topbar-sub">Complete los campos requeridos para generar la guía.</div>
      </div>
    </div>
    <button class="btn-vincular-fact" id="btnVincular" onclick="abrirModal('modalFactura')">
      <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
      Vincular factura
    </button>
  </div>

  {{-- INVOICE BANNER --}}
  <div class="invoice-banner" id="invoiceBanner">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/></svg>
    <span id="invoiceBannerText">Factura vinculada</span>
    <button class="invoice-banner-remove" onclick="desvincularFactura()" title="Desvincular">✕ Desvincular</button>
  </div>

  {{-- ALERTA --}}
  <div id="alerta_guia" class="alert d-none" role="alert"></div>

  <form id="form_guia">
    @csrf
    <input type="hidden" name="id_clientes" id="input_id_clientes">
    <input type="hidden" name="id_venta" id="input_id_venta">

    {{-- ── SECCIÓN 1: INFORMACIÓN DE LA GUÍA ── --}}
    <div class="guia-card">
      <div class="guia-card-header">
        <div class="guia-card-num">1</div>
        <div>
          <div class="guia-card-title">Información de la Guía</div>
          <div class="guia-card-desc">Datos generales del documento de remisión</div>
        </div>
      </div>
      <div class="guia-card-body">
        <div class="gg3">
          <div class="gf">
            <label>Fecha de emisión <span class="req">*</span></label>
            <input type="date" name="guia_emision" id="guia_emision" required value="{{ date('Y-m-d') }}">
          </div>
          <div class="gf">
            <label>Tipo de guía <span class="req">*</span></label>
            <select name="guia_tipo" id="guia_tipo" required onchange="onTipoGuiaChange()">
              <option value="09">Guía Remitente</option>
              <option value="31">Guía Transportista</option>
            </select>
          </div>
          <div class="gf">
            <label>Serie</label>
            <div class="serie-badge" id="serieGuia">T001</div>
          </div>
          <div class="gf">
            <label>Fecha de traslado <span class="req">*</span></label>
            <input type="date" name="guia_fecha_traslado" required value="{{ date('Y-m-d') }}">
          </div>
          <div class="gf gc2">
            <label>Motivo de traslado <span class="req">*</span></label>
            <select name="guia_motivo" required>
              <option value="01">01 – Venta</option>
              <option value="02">02 – Compra</option>
              <option value="03">03 – Venta con entrega a terceros</option>
              <option value="04">04 – Traslado entre establecimientos</option>
              <option value="05">05 – Consignación</option>
              <option value="06">06 – Devolución</option>
              <option value="13">13 – Otros</option>
            </select>
          </div>
          <div class="gf gc3">
            <label>Observación <span class="opt">(opcional)</span></label>
            <textarea name="guia_observacion" placeholder="Observación o referencia adicional..."></textarea>
          </div>
        </div>
      </div>
    </div>

    {{-- ── SECCIÓN 2: DATOS DEL CLIENTE / DESTINATARIO ── --}}
    <div class="guia-card">
      <div class="guia-card-header">
        <div class="guia-card-num">2</div>
        <div>
          <div class="guia-card-title">Datos del Cliente / Destinatario</div>
          <div class="guia-card-desc">Información del receptor de los bienes</div>
        </div>
      </div>
      <div class="guia-card-body">
        <button type="button" class="btn-client-srch" onclick="abrirModal('modalCliente')">
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          Buscar cliente registrado
        </button>
        <div class="gg3">
          <div class="gf">
            <label>Tipo de documento <span class="req">*</span></label>
            <select name="guia_cliente_tipo_doc" id="guia_cliente_tipo_doc">
              <option value="">— Seleccionar —</option>
              @foreach($tipo_docs as $td)
                <option value="{{ $td->id_tipo_documento }}">{{ $td->tipo_documento_identidad }}</option>
              @endforeach
            </select>
          </div>
          <div class="gf">
            <label>N.º Documento <span class="req">*</span></label>
            <input type="text" name="guia_cliente_num_doc" id="guia_cliente_num_doc" placeholder="RUC / DNI" style="font-family:monospace;" maxlength="15">
          </div>
          <div class="gf">
            <label>Nombre / Razón Social <span class="req">*</span></label>
            <input type="text" name="guia_cliente_nombre" id="guia_cliente_nombre" placeholder="Razón social o nombre completo">
          </div>
        </div>
      </div>
    </div>

    {{-- ── SECCIÓN 3: DATOS DEL TRANSPORTE ── --}}
    <div class="guia-card">
      <div class="guia-card-header">
        <div class="guia-card-num">3</div>
        <div>
          <div class="guia-card-title">Datos del Transporte</div>
          <div class="guia-card-desc">Transportista, vehículo y conductor</div>
        </div>
      </div>
      <div class="guia-card-body">

        {{-- 3.1 Transportista --}}
        <div class="guia-sub">
          <div class="guia-sub-title">3.1 · Información del Transportista</div>
          <div class="gg3">
            <div class="gf">
              <label>RUC Transportista</label>
              {{-- input oculto fijo tipo RUC=4 para que consultarNumdocumento entre al branch de RUC --}}
              <input type="hidden" id="_trans_tipo_doc" value="4">
              <input type="text" name="guia_num_doc_trans" id="guia_num_doc_trans" placeholder="20xxxxxxxxx" maxlength="11" style="font-family:monospace;"
                     oninput="if(this.value.length===11) consultarNumdocumento('_trans_tipo_doc','guia_num_doc_trans','guia_denominacion',null,null)">
            </div>
            <div class="gf">
              <label>Razón Social Transportista</label>
              <input type="text" name="guia_denominacion" id="guia_denominacion" placeholder="Nombre de la empresa de transporte">
            </div>
            <div class="gf">
              <label>Tipo de Transporte <span class="req">*</span></label>
              <select name="guia_tipo_trans" id="guia_tipo_trans" required onchange="onTipoTransChange()">
                <option value="02">02 – Privado</option>
                <option value="01">01 – Público</option>
              </select>
            </div>
          </div>
        </div>

        {{-- Transportista público (tipo_trans=01) --}}
        <div id="seccion_trans_pub" style="display:none;">
          <div class="guia-divider"></div>
          <div class="guia-sub">
            <div class="guia-sub-title">Transportista Público – Datos adicionales</div>
            <div class="gg3">
              <div class="gf">
                <label>Tipo Documento Trans.</label>
                <select name="guia_tipo_doc_trans">
                  <option value="6">RUC</option>
                  <option value="1">DNI</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="guia-divider"></div>

        {{-- 3.2 Vehículo --}}
        <div class="guia-sub">
          <div class="guia-sub-title">3.2 · Información del Vehículo</div>
          <div class="gg4">
            <div class="gf">
              <label>Placa del Vehículo <span class="req">*</span></label>
              <input type="text" name="guia_placa" placeholder="ABC-123" style="text-transform:uppercase;font-family:monospace;" maxlength="8" required>
            </div>
            <div class="gf">
              <label>Marca del Vehículo</label>
              <input type="text" name="vehiculo_marca" placeholder="Ej. Toyota">
            </div>
            <div class="gf">
              <label>Placa de Carreta</label>
              <input type="text" name="guia_carreta" placeholder="Opcional" style="font-family:monospace;" maxlength="8">
            </div>
            <div class="gf">
              <label>Certificado MTC</label>
              <input type="text" name="guia_certificado_mtc" placeholder="N.º certificado" style="font-family:monospace;">
            </div>
            <div class="gf">
              <label>Peso Bruto (KG) <span class="req">*</span></label>
              <input type="number" name="guia_peso_bruto" step="0.001" min="0" value="0" required>
            </div>
            <div class="gf">
              <label>Unidad de Medida</label>
              <select name="guia_unidad_medida">
                <option value="KGM">KGM – Kilogramo</option>
                <option value="TNE">TNE – Tonelada</option>
                <option value="GRM">GRM – Gramo</option>
              </select>
            </div>
            <div class="gf">
              <label>N.º de Bultos</label>
              <input type="number" name="guia_n_bulto" min="0" value="1">
            </div>
          </div>
        </div>

        <div class="guia-divider"></div>

        {{-- 3.3 Conductor --}}
        <div class="guia-sub">
          <div class="guia-sub-title">3.3 · Datos del Conductor</div>
          <div class="gg4">
            <div class="gf">
              <label>Tipo Documento <span class="req">*</span></label>
              <select name="guia_conductor_documento_tipo">
                <option value="1" selected>DNI</option>
                <option value="4">C.E.</option>
                <option value="7">Pasaporte</option>
              </select>
            </div>
            <div class="gf">
              <label>N.º Documento <span class="req">*</span></label>
              <input type="text" name="guia_conductor_numero" placeholder="DNI del conductor" maxlength="15" style="font-family:monospace;">
            </div>
            <div class="gf">
              <label>Nombres</label>
              <input type="text" name="guia_conductor_nombre" placeholder="Nombres">
            </div>
            <div class="gf">
              <label>Apellidos</label>
              <input type="text" name="guia_conductor_apellidos" placeholder="Apellidos">
            </div>
            <div class="gf">
              <label>Licencia de Conducir <span class="req">*</span></label>
              <input type="text" name="guia_licencia_conductor" placeholder="Ej. Q12345678" maxlength="12" style="font-family:monospace;">
            </div>
          </div>
        </div>

        {{-- Destinatario (tipo guía 31) --}}
        <div id="seccion_destinatario" style="display:none;">
          <div class="guia-divider"></div>
          <div class="guia-sub">
            <div class="guia-sub-title">Destinatario – Guía Transportista</div>
            <div class="gg4">
              <div class="gf">
                <label>Tipo Documento</label>
                <select name="guia_tipo_doc_desti">
                  <option value="6">RUC</option>
                  <option value="1">DNI</option>
                </select>
              </div>
              <div class="gf">
                <label>N.º Documento</label>
                <input type="text" name="guia_num_doc_desti" class="form-control" style="font-family:monospace;">
              </div>
              <div class="gf gc2">
                <label>Denominación</label>
                <input type="text" name="guia_denominacion_desti" placeholder="Razón social o nombre">
              </div>
              <div class="gf gc4">
                <label>Dirección</label>
                <input type="text" name="guia_direccion_desti" placeholder="Dirección del destinatario">
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    {{-- ── SECCIÓN 4: PUNTOS DE PARTIDA Y LLEGADA ── --}}
    <div class="guia-card">
      <div class="guia-card-header">
        <div class="guia-card-num">4</div>
        <div>
          <div class="guia-card-title">Punto de Partida y Llegada</div>
          <div class="guia-card-desc">Direcciones y ubigeos del traslado</div>
        </div>
      </div>
      <div class="guia-card-body">
        <div class="gg2">
          <div class="gf">
            <label>Dirección de Partida <span class="req">*</span></label>
            <input type="text" name="guia_direccion_part" placeholder="Av. / Jr. / Calle, N.º, distrito" required>
          </div>
          <div class="gf">
            <label>Ubigeo de Partida <span class="req">*</span></label>
            <select name="guia_ubigeo_part" required>
              <option value="">— Seleccionar ubigeo —</option>
              @foreach($ubigeos as $u)
                <option value="{{ $u->ubigeo_cod }}">
                  {{ $u->ubigeo_departamento }} / {{ $u->ubigeo_provincia }} / {{ $u->ubigeo_distrito }} ({{ $u->ubigeo_cod }})
                </option>
              @endforeach
            </select>
          </div>
          <div class="gf">
            <label>Dirección de Llegada <span class="req">*</span></label>
            <input type="text" name="guia_direccion_llega" placeholder="Av. / Jr. / Calle, N.º, distrito" required>
          </div>
          <div class="gf">
            <label>Ubigeo de Llegada <span class="req">*</span></label>
            <select name="guia_ubigeo_llega" required>
              <option value="">— Seleccionar ubigeo —</option>
              @foreach($ubigeos as $u)
                <option value="{{ $u->ubigeo_cod }}">
                  {{ $u->ubigeo_departamento }} / {{ $u->ubigeo_provincia }} / {{ $u->ubigeo_distrito }} ({{ $u->ubigeo_cod }})
                </option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>

    {{-- ── SECCIÓN 5: BIENES A TRASLADAR ── --}}
    <div class="guia-card">
      <div class="guia-card-header">
        <div class="guia-card-num">5</div>
        <div>
          <div class="guia-card-title">Bienes a Trasladar</div>
          <div class="guia-card-desc">Detalle de los productos y mercancías</div>
        </div>
      </div>
      <div class="guia-card-body">
        {{-- BUSCADOR DE PRODUCTOS --}}
        <div style="position:relative;margin-bottom:14px;">
          <div class="gf">
            <label>
              <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-right:4px;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
              Buscar producto
            </label>
            <input type="text" id="buscar_bienes_input" placeholder="Ingrese nombre o código del producto..." autocomplete="off">
          </div>
          <div style="position:absolute;z-index:9999;width:100%;max-height:310px;overflow-y:auto;top:calc(100% + 2px);left:0;border-radius:8px;box-shadow:0 8px 24px rgba(15,23,42,.13);">
            <div class="list-group list-group-flush bg-white" id="lista_bienes_dropdown"></div>
          </div>
        </div>

        <div class="items-hdr">
          <div class="items-count"><span id="itemCount">0</span> ítem(s) registrado(s)</div>
        </div>
        <div class="table-wrap">
          <table class="items-tbl">
            <thead>
              <tr>
                <th style="width:80px;">Código</th>
                <th>Producto</th>
                <th style="width:70px;">U.M.</th>
                <th style="width:70px;">Cantidad</th>
                <th style="width:88px;">Peso Unit. KG</th>
                <th style="width:88px;">Peso Total KG</th>
                <th>Observación</th>
                <th style="width:34px;"></th>
              </tr>
            </thead>
            <tbody id="itemsBody">
              <tr id="emptyRow">
                <td colspan="8">
                  <div class="empty-tbl">
                    <div style="font-size:26px;margin-bottom:6px;opacity:.4;">📦</div>
                    <div>No hay bienes registrados. Haz clic en <strong>Agregar ítem</strong>.</div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="peso-summary">
          <span>Peso total estimado:</span>
          <strong id="pesoTotalGlobal">0.000 KG</strong>
        </div>
      </div>
    </div>

    {{-- FOOTER --}}
    <div class="guia-footer">
      <a href="{{ route('logistica.guias_remision') }}" class="btn-cancel-guia">Cancelar</a>
      <button type="button" class="btn-save-guia" onclick="guardarGuia()">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Guardar Guía
      </button>
    </div>

  </form>
</div>{{-- guia-wrap --}}

<script>
let itemIdCounter = 0;
let toastTimeout;

/* ── MODAL ── */
function abrirModal(id) { document.getElementById(id).classList.add('open'); }
function cerrarModal(id) {
  document.getElementById(id).classList.remove('open');
  if (id === 'modalFactura') resetFacturaModal();
  if (id === 'modalCliente') { document.getElementById('clienteResultados').innerHTML = ''; document.getElementById('clienteBusqInput').value = ''; }
}

/* ── TIPO GUÍA ── */
function onTipoGuiaChange() {
  const v = document.getElementById('guia_tipo').value;
  document.getElementById('serieGuia').textContent = v === '31' ? 'V001' : 'T001';
  document.getElementById('seccion_destinatario').style.display = v === '31' ? '' : 'none';
}

/* ── TIPO TRANSPORTE ── */
function onTipoTransChange() {
  const v = document.getElementById('guia_tipo_trans').value;
  document.getElementById('seccion_trans_pub').style.display = v === '01' ? '' : 'none';
}

/* ── TOAST ── */
function showToast(msg, type) {
  const t = document.getElementById('guia_toast');
  t.textContent = msg;
  t.className = 'guia-toast ' + (type||'') + ' show';
  clearTimeout(toastTimeout);
  toastTimeout = setTimeout(() => t.classList.remove('show'), 3500);
}

/* ── AUTOFILL ── */
function setAutofill(id, val) {
  const el = document.getElementById(id);
  if (!el) return;
  el.value = val;
  el.classList.add('autofilled');
  setTimeout(() => el.classList.remove('autofilled'), 3000);
}

/* ── BUSCAR FACTURA (AJAX) ── */
function resetFacturaModal() {
  document.getElementById('factSerie').value = '';
  document.getElementById('factCorrelativo').value = '';
  const msg = document.getElementById('factMsg');
  msg.className = 'modal-msg'; msg.textContent = '';
  document.getElementById('factResultados').innerHTML = '';
}

function buscarFactura() {
  const serie = document.getElementById('factSerie').value.trim().toUpperCase();
  const corr  = document.getElementById('factCorrelativo').value.trim();
  const msg   = document.getElementById('factMsg');
  const res   = document.getElementById('factResultados');

  if (!serie && !corr) {
    msg.className = 'modal-msg error'; msg.textContent = 'Ingresa la serie o correlativo.'; return;
  }

  msg.className = 'modal-msg'; msg.textContent = '';
  res.innerHTML = '<p style="color:var(--text-3);font-size:12.5px;margin-top:12px;">Buscando...</p>';

  fetch('{{ route("logistica.buscar_venta_guia") }}', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
    body: 'serie=' + encodeURIComponent(serie) + '&correlativo=' + encodeURIComponent(corr)
  })
  .then(r => r.json())
  .then(data => {
    if (data.result === 2) {
      msg.className = 'modal-msg error'; msg.textContent = data.mensaje;
      res.innerHTML = ''; return;
    }
    if (data.result === 0 || !data.data || !data.data.length) {
      msg.className = 'modal-msg error'; msg.textContent = 'No se encontraron facturas con esos datos.';
      res.innerHTML = ''; return;
    }
    renderFacturaResultados(data.data);
  })
  .catch(() => {
    msg.className = 'modal-msg error'; msg.textContent = 'Error de conexión. Intente de nuevo.';
    res.innerHTML = '';
  });
}

function renderFacturaResultados(rows) {
  const res = document.getElementById('factResultados');
  let html = '<table class="results-tbl"><thead><tr><th>Total</th><th>Cliente</th><th>Productos</th><th></th></tr></thead><tbody>';
  rows.forEach(r => {
    const prods = r.productos.map(p => `<span style="display:block;font-size:11.5px;color:var(--text-2);">${p.codigo ? p.codigo + ' – ' : ''}${p.nombre}</span>`).join('');
    const dataAttr = encodeURIComponent(JSON.stringify(r));
    html += `<tr>
      <td><strong style="font-family:monospace;color:var(--accent);">S/ ${r.total}</strong><br><span style="font-size:11px;color:var(--text-3);">${r.serie}-${r.correlativo}</span></td>
      <td><strong style="font-size:12.5px;">${r.cliente_nombre}</strong><br><span style="font-family:monospace;font-size:11px;color:var(--text-3);">${r.cliente_numero}</span></td>
      <td>${prods || '<span style="color:var(--text-3);font-size:11.5px;">Sin productos</span>'}</td>
      <td><button class="btn-vincular-row" onclick='vincularFactura(${JSON.stringify(r)})'>Vincular</button></td>
    </tr>`;
  });
  html += '</tbody></table>';
  res.innerHTML = html;
}

function vincularFactura(data) {
  // Fill client card
  setAutofill('guia_cliente_tipo_doc', data.id_tipo_documento || '');
  setAutofill('guia_cliente_num_doc',  data.cliente_numero || '');
  setAutofill('guia_cliente_nombre',   data.cliente_nombre || '');

  // Set hidden fields
  document.getElementById('input_id_clientes').value = data.id_clientes || '';
  document.getElementById('input_id_venta').value    = data.id_venta || '';

  // Cargar productos en bienes table
  limpiarItems();
  if (data.productos && data.productos.length) {
    data.productos.forEach(p => agregarItemDesdeFactura(p));
  }

  // Show banner, hide button
  document.getElementById('invoiceBannerText').textContent =
    'Factura vinculada: ' + data.serie + '-' + data.correlativo + ' · ' + data.cliente_nombre;
  document.getElementById('invoiceBanner').classList.add('visible');
  document.getElementById('btnVincular').style.display = 'none';

  cerrarModal('modalFactura');
  showToast('Factura ' + data.serie + '-' + data.correlativo + ' vinculada correctamente.', 'success');
}

function desvincularFactura() {
  // Clear client fields
  ['guia_cliente_tipo_doc','guia_cliente_num_doc','guia_cliente_nombre'].forEach(id => {
    const el = document.getElementById(id);
    if (el) { el.value = ''; el.classList.remove('autofilled'); }
  });
  document.getElementById('input_id_clientes').value = '';
  document.getElementById('input_id_venta').value = '';

  // Eliminar productos cargados desde la factura
  limpiarItems();

  // Hide banner, show button
  document.getElementById('invoiceBanner').classList.remove('visible');
  document.getElementById('btnVincular').style.display = '';

  showToast('Factura desvinculada.', '');
}

/* ── BUSCAR CLIENTE ── */
function buscarCliente() {
  const q = document.getElementById('clienteBusqInput').value.trim().toLowerCase();
  const container = document.getElementById('clienteResultados');
  if (!q) { container.innerHTML = '<p style="font-size:12px;color:var(--text-3);">Ingresa un término de búsqueda.</p>'; return; }

  const clientes = @json($clientes);
  const res = clientes.filter(c =>
    (c.cliente_nombre || '').toLowerCase().includes(q) ||
    (c.cliente_razonsocial || '').toLowerCase().includes(q) ||
    (c.cliente_numero || '').includes(q)
  ).slice(0, 10);

  if (!res.length) {
    container.innerHTML = '<p style="font-size:12.5px;color:var(--error);">No se encontraron clientes.</p>'; return;
  }
  container.innerHTML = res.map(c => `
    <div class="client-row" onclick="seleccionarCliente('${c.id_tipo_documento}','${c.cliente_numero}','${(c.cliente_razonsocial||c.cliente_nombre||'').replace(/'/g,'&apos;')}','${c.id_clientes}')">
      <div class="client-row-name">${c.cliente_razonsocial || c.cliente_nombre}</div>
      <div class="client-row-doc">${c.cliente_numero}</div>
    </div>`).join('');
}

function seleccionarCliente(tipoDoc, numDoc, nombre, idClientes) {
  setAutofill('guia_cliente_tipo_doc', tipoDoc);
  setAutofill('guia_cliente_num_doc',  numDoc);
  setAutofill('guia_cliente_nombre',   nombre);
  document.getElementById('input_id_clientes').value = idClientes;
  cerrarModal('modalCliente');
  showToast('Cliente seleccionado: ' + nombre, 'success');
}

/* ── BUSCADOR DE PRODUCTOS ── */
document.getElementById('buscar_bienes_input').addEventListener('keyup', function () {
  buscarBienes(this.value);
});

function buscarBienes(valor) {
  const lista = document.getElementById('lista_bienes_dropdown');
  if (!valor || valor.length < 2) { lista.innerHTML = ''; return; }

  $.ajax({
    type: 'POST',
    url: '{{ route("Gestionventas.buscar_productos") }}',
    data: { valor: valor, _token: '{{ csrf_token() }}' },
    dataType: 'json',
    success: function (r) {
      const datos = r.result.code;
      if (!datos || !datos.length) {
        lista.innerHTML = '<a class="list-group-item" style="font-size:13px;color:var(--text-3);">Sin resultados</a>';
        return;
      }
      lista.innerHTML = datos.map(el => {
        const obj = {
          id_pro: el.id_pro,
          codigo: el.pro_codigo || '',
          nombre: el.pro_nombre || '',
        };
        const jsonStr = JSON.stringify(obj).replace(/'/g, '&apos;');
        const familia = el.fa_nombre
          ? `<small style="color:var(--accent);margin-left:6px;">${el.familia_codigo||''} ${el.fa_nombre}</small>`
          : '';
        return `<a class="list-group-item list-group-item-action" style="cursor:pointer;padding:8px 12px;"
            data-bien='${jsonStr}' onclick="seleccionarBien(this)">
            <div style="font-weight:600;font-size:13px;">${el.pro_nombre}</div>
            <small style="font-family:monospace;color:var(--text-3);">${el.pro_codigo||''}</small>${familia}
          </a>`;
      }).join('');
    },
    error: function () {
      lista.innerHTML = '<a class="list-group-item" style="font-size:12.5px;color:var(--error);">Error al buscar</a>';
    }
  });
}

function seleccionarBien(el) {
  const data = JSON.parse(el.getAttribute('data-bien'));
  document.getElementById('buscar_bienes_input').value = '';
  document.getElementById('lista_bienes_dropdown').innerHTML = '';

  hideEmptyRow();
  const id = ++itemIdCounter;
  const row = document.createElement('tr');
  row.id = 'item-' + id;
  row.innerHTML = itemRowHTML(id, data.codigo, data.nombre, 'NIU', '1', '', true, data.id_pro);
  document.getElementById('itemsBody').appendChild(row);
  actualizarContador();
  const cantInput = row.querySelector('input[name="detalle_cantidad[]"]');
  if (cantInput) cantInput.focus();
}

/* ── ITEMS TABLE ── */
function limpiarItems() {
  const body = document.getElementById('itemsBody');
  body.innerHTML = `<tr id="emptyRow"><td colspan="8"><div class="empty-tbl"><div style="font-size:26px;margin-bottom:6px;opacity:.4;">📦</div><div>No hay bienes registrados. Haz clic en <strong>Agregar ítem</strong>.</div></div></td></tr>`;
  itemIdCounter = 0;
  actualizarContador();
  calcularPesoGlobal();
}

function agregarItemDesdeFactura(item) {
  hideEmptyRow();
  const id = ++itemIdCounter;
  const row = document.createElement('tr');
  row.id = 'item-' + id;
  // id_pro se envía pero el controller NO descuenta stock porque hay id_venta vinculado
  row.innerHTML = itemRowHTML(id, item.codigo || '', item.nombre || '', 'NIU', item.cantidad || 1, '', true, item.id_pro || '');
  document.getElementById('itemsBody').appendChild(row);
  actualizarContador();
}

function itemRowHTML(id, codigo, producto, unidad, cantidad, obs, autofilled, idPro) {
  const af = autofilled ? 'autofilled' : '';
  const ums = ['NIU','KGM','TNE','LTR','MTR','BOL','CJA','PAR','ZZ'].map(u =>
    `<option value="${u}" ${u===unidad?'selected':''}>${u}</option>`).join('');
  return `
    <input type="hidden" name="detalle_id_pro[]" value="${idPro||''}">
    <td><input type="text" name="detalle_codigo[]" value="${escHtml(codigo)}" class="${af}" placeholder="SKU" style="font-family:monospace;"></td>
    <td><input type="text" name="detalle_descripcion[]" value="${escHtml(producto)}" class="${af}" placeholder="Nombre del producto" required></td>
    <td><select name="detalle_um[]" class="${af}">${ums}</select></td>
    <td><input type="number" name="detalle_cantidad[]" value="${cantidad||''}" class="${af}" placeholder="0" min="0" step="1" oninput="calcularPesoTotal(${id})"></td>
    <td><input type="number" name="detalle_peso[]" placeholder="0.000" min="0" step="0.001" oninput="calcularPesoTotal(${id})"></td>
    <td><span class="col-pt" id="pt-${id}">0.000</span></td>
    <td><input type="text" name="detalle_observacion[]" value="${escHtml(obs)}" placeholder="Opcional"></td>
    <td><button type="button" class="btn-del-row" onclick="eliminarItem(${id})" title="Eliminar">✕</button></td>`;
}

function escHtml(s) { return (s||'').toString().replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

function hideEmptyRow() { const e = document.getElementById('emptyRow'); if (e) e.remove(); }

function actualizarContador() {
  document.getElementById('itemCount').textContent = document.querySelectorAll('#itemsBody tr:not(#emptyRow)').length;
}

function calcularPesoTotal(id) {
  const row = document.getElementById('item-' + id);
  if (!row) return;
  const inputs = row.querySelectorAll('input[type="number"]');
  const qty  = parseFloat(inputs[0]?.value) || 0;
  const peso = parseFloat(inputs[1]?.value) || 0;
  const total = (qty * peso).toFixed(3);
  document.getElementById('pt-' + id).textContent = total;
  calcularPesoGlobal();
}

function calcularPesoGlobal() {
  let total = 0;
  document.querySelectorAll('[id^="pt-"]').forEach(el => { total += parseFloat(el.textContent) || 0; });
  document.getElementById('pesoTotalGlobal').textContent = total.toFixed(3) + ' KG';
}

function eliminarItem(id) {
  const row = document.getElementById('item-' + id);
  if (row) row.remove();
  actualizarContador();
  calcularPesoGlobal();
  if (!document.querySelector('#itemsBody tr:not(#emptyRow)')) {
    document.getElementById('itemsBody').insertAdjacentHTML('beforeend',
      `<tr id="emptyRow"><td colspan="8"><div class="empty-tbl"><div style="font-size:26px;margin-bottom:6px;opacity:.4;">📦</div><div>No hay bienes registrados. Haz clic en <strong>Agregar ítem</strong>.</div></div></td></tr>`);
  }
}

/* ── GUARDAR ── */
function guardarGuia() {
  const alerta = document.getElementById('alerta_guia');
  const form   = document.getElementById('form_guia');

  // Validate items
  const items = document.querySelectorAll('#itemsBody tr:not(#emptyRow)');
  if (!items.length) { showToast('Debes agregar al menos un bien a trasladar.', 'error'); return; }

  if (!form.checkValidity()) { form.reportValidity(); return; }

  const formData = new FormData(form);

  fetch('{{ route("logistica.guardar_guia") }}', {
    method: 'POST',
    body: formData,
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(r => r.json())
  .then(data => {
    alerta.classList.remove('d-none', 'alert-success', 'alert-danger');
    if (data.result == 1) {
      alerta.classList.add('alert-success');
      alerta.innerHTML = '<i class="fas fa-check-circle me-1"></i>' + data.mensaje +
        ' <a href="{{ route("logistica.pendientes_guia") }}" class="ms-3 btn btn-sm btn-success">Ver pendientes</a>';
      form.reset();
      limpiarItems();
      document.getElementById('invoiceBanner').classList.remove('visible');
      document.getElementById('btnVincular').style.display = '';
      document.getElementById('input_id_clientes').value = '';
      document.getElementById('input_id_venta').value = '';
      document.getElementById('serieGuia').textContent = 'T001';
      showToast(data.mensaje, 'success');
      window.open('{{ route("logistica.imprimir_guia_pdf") }}?id_guia=' + data.id_guia, '_blank');
    } else {
      alerta.classList.add('alert-danger');
      alerta.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>' + data.mensaje;
      showToast('Error al guardar. Revisa los campos.', 'error');
    }
    alerta.scrollIntoView({ behavior: 'smooth' });
  })
  .catch(() => {
    alerta.classList.remove('d-none');
    alerta.classList.add('alert-danger');
    alerta.textContent = 'Error de conexión. Intente de nuevo.';
  });
}

/* ── INIT ── */
document.addEventListener('DOMContentLoaded', function () {
  onTipoGuiaChange();
  onTipoTransChange();
  // Close modals on overlay click
  document.querySelectorAll('.modal-ov').forEach(ov => {
    ov.addEventListener('click', function (e) {
      if (e.target === ov) cerrarModal(ov.id);
    });
  });
  // Close product dropdown on outside click
  document.addEventListener('click', function (e) {
    if (!e.target.closest('#buscar_bienes_input') && !e.target.closest('#lista_bienes_dropdown')) {
      document.getElementById('lista_bienes_dropdown').innerHTML = '';
    }
  });
});
</script>
@endsection
