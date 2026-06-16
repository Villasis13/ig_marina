@extends('layouts.plantilla')
@section('content')
<style>
.oc-detail-wrap { max-width: 1100px; margin: 0 auto; }

/* Header card */
.oc-header-card {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    border-radius: 14px;
    padding: 28px 32px;
    color: #fff;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 24px;
    box-shadow: 0 4px 24px rgba(37,99,235,.25);
}
.oc-header-logo {
    /*width: 72px;*/
    height: 50px;
    border-radius: 12px;
    background: rgba(255,255,255,.15);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}
.oc-header-logo img { width: 100%; height: 100%; object-fit: contain; }
.oc-header-info { flex: 1; }
.oc-header-empresa { font-size: 20px; font-weight: 700; margin: 0 0 4px; }
.oc-header-sub { font-size: 13px; opacity: .8; margin: 0; }
.oc-header-badge {
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.3);
    border-radius: 8px;
    padding: 10px 18px;
    text-align: center;
    flex-shrink: 0;
}
.oc-header-badge-label { font-size: 11px; opacity: .75; text-transform: uppercase; letter-spacing: .5px; }
.oc-header-badge-val { font-size: 22px; font-weight: 700; font-family: monospace; }

/* Status strip */
.oc-status-strip {
    display: flex; gap: 12px; flex-wrap: wrap;
    margin-bottom: 20px;
}
.oc-stat {
    flex: 1; min-width: 150px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex; align-items: center; gap: 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.oc-stat-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; flex-shrink: 0;
}
.oc-stat-icon.blue  { background: #eff6ff; color: #2563eb; }
.oc-stat-icon.green { background: #f0fdf4; color: #16a34a; }
.oc-stat-icon.amber { background: #fffbeb; color: #d97706; }
.oc-stat-icon.red   { background: #fef2f2; color: #dc2626; }
.oc-stat-icon.purple{ background: #f5f3ff; color: #7c3aed; }
.oc-stat-label { font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: .4px; font-weight: 600; }
.oc-stat-val   { font-size: 14px; font-weight: 700; color: #1e293b; margin-top: 2px; }

/* Info grid */
.oc-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 20px;
}
@media(max-width:768px){ .oc-info-grid { grid-template-columns: 1fr; } }

.oc-info-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px 24px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.oc-info-card-title {
    font-size: 12px; font-weight: 700; color: #64748b;
    text-transform: uppercase; letter-spacing: .5px;
    margin-bottom: 14px;
    display: flex; align-items: center; gap: 7px;
}
.oc-row { display: flex; justify-content: space-between; align-items: baseline; padding: 6px 0; border-bottom: 1px solid #f1f5f9; }
.oc-row:last-child { border-bottom: none; }
.oc-row-label { font-size: 13px; color: #64748b; }
.oc-row-val   { font-size: 13px; font-weight: 600; color: #1e293b; text-align: right; }

/* Total card */
.oc-total-card {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1.5px solid #86efac;
    border-radius: 12px;
    padding: 18px 24px;
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px;
}
.oc-total-label { font-size: 14px; font-weight: 600; color: #15803d; }
.oc-total-amount { font-size: 28px; font-weight: 800; color: #15803d; font-family: monospace; }

/* Observation */
.oc-obs {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 10px;
    padding: 14px 18px;
    font-size: 13.5px;
    color: #92400e;
    margin-bottom: 20px;
    display: flex; gap: 10px; align-items: flex-start;
}

/* Table */
.oc-table-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    margin-bottom: 20px;
}
.oc-table-title {
    padding: 14px 20px;
    font-size: 13px; font-weight: 700; color: #1e293b;
    border-bottom: 1px solid #e2e8f0;
    display: flex; align-items: center; gap: 8px;
}
.oc-table-card table { margin: 0; }
.oc-table-card thead tr { background: #f8fafc; }
.oc-table-card thead th { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .4px; padding: 10px 14px; border-bottom: 1px solid #e2e8f0; }
.oc-table-card tbody td { font-size: 13.5px; padding: 11px 14px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
.oc-table-card tbody tr:last-child td { border-bottom: none; }
.oc-table-card tbody tr:hover { background: #f8fafc; }
.oc-num { font-family: monospace; }

/* Back button */
.oc-back-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 22px; border-radius: 9px;
    background: #f1f5f9; color: #475569;
    font-size: 13.5px; font-weight: 600;
    text-decoration: none; border: 1px solid #e2e8f0;
    transition: background .15s;
}
.oc-back-btn:hover { background: #e2e8f0; color: #1e293b; text-decoration: none; }
</style>

<div class="tab-content">
@can($opciones[0]->opciones_funcion)
<div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active" role="tabpanel">
<div class="oc-detail-wrap py-3 px-2">

    {{-- HEADER --}}
    <div class="oc-header-card">
        <div class="oc-header-logo">
            <img src="{{ asset($empresa->empresa_foto ?? 'logo_IGLM.png') }}" alt="Logo">
        </div>
        <div class="oc-header-info">
            <p class="oc-header-empresa">{{ $empresa->empresa_nombrecomercial }}</p>
            <p class="oc-header-sub">Detalle de Compra · {{ $orden_compra->orden_compra_tipo_doc }} #{{ $orden_compra->orden_compra_numero_doc }}</p>
        </div>
        <div class="oc-header-badge">
            <div class="oc-header-badge-label">OC N°</div>
            <div class="oc-header-badge-val">{{ $orden_compra->orden_compra_numero }}</div>
            <div style="margin-top:6px">
                @if($orden_compra->orden_compra_estado == 1)
                    <span style="background:rgba(255,255,255,.2);border-radius:20px;padding:3px 10px;font-size:11px;">✓ Activa</span>
                @else
                    <span style="background:rgba(220,38,38,.3);border-radius:20px;padding:3px 10px;font-size:11px;">✗ Anulada</span>
                @endif
            </div>
        </div>
    </div>

    {{-- STAT STRIP --}}
    <div class="oc-status-strip">
        <div class="oc-stat">
            <div class="oc-stat-icon blue"><i class="fa-solid fa-user"></i></div>
            <div>
                <div class="oc-stat-label">Solicitante</div>
                <div class="oc-stat-val">{{ $orden_compra->nombre_users }}</div>
            </div>
        </div>
        <div class="oc-stat">
            <div class="oc-stat-icon green"><i class="fa-solid fa-building"></i></div>
            <div>
                <div class="oc-stat-label">Proveedor</div>
                <div class="oc-stat-val">{{ $orden_compra->proveedores_nombre }}</div>
            </div>
        </div>
        <div class="oc-stat">
            <div class="oc-stat-icon amber"><i class="fa-solid fa-handshake"></i></div>
            <div>
                <div class="oc-stat-label">Condición</div>
                <div class="oc-stat-val">{{ $orden_compra->orden_compra_condicion == 1 ? 'Crédito' : 'Contado' }}</div>
            </div>
        </div>
        <div class="oc-stat">
            <div class="oc-stat-icon purple"><i class="fa-solid fa-wallet"></i></div>
            <div>
                <div class="oc-stat-label">Tipo de Pago</div>
                <div class="oc-stat-val">{{ $orden_compra->tipo_pago_nombre ?? '—' }}</div>
            </div>
        </div>
        <div class="oc-stat">
            <div class="oc-stat-icon blue"><i class="fa-solid fa-boxes-stacked"></i></div>
            <div>
                <div class="oc-stat-label">Productos</div>
                <div class="oc-stat-val">{{ count($detalle_orden_compra) }} ítems</div>
            </div>
        </div>
    </div>

    {{-- INFO GRID --}}
    <div class="oc-info-grid">
        <div class="oc-info-card">
            <div class="oc-info-card-title"><i class="fa-solid fa-calendar-days text-primary"></i> Fechas</div>
            <div class="oc-row">
                <span class="oc-row-label">Fecha de registro</span>
                <span class="oc-row-val">{{ date('d/m/Y H:i', strtotime($orden_compra->orden_compra_fecha)) }}</span>
            </div>
            <div class="oc-row">
                <span class="oc-row-label">Fecha de emisión</span>
                <span class="oc-row-val">{{ $orden_compra->orden_compra_fecha_emision_doc ? date('d/m/Y', strtotime($orden_compra->orden_compra_fecha_emision_doc)) : '—' }}</span>
            </div>
            @if($orden_compra->orden_compra_fecha_vencimiento)
            <div class="oc-row">
                <span class="oc-row-label">Fecha de vencimiento</span>
                <span class="oc-row-val" style="color:#dc2626">{{ date('d/m/Y', strtotime($orden_compra->orden_compra_fecha_vencimiento)) }}</span>
            </div>
            @endif
        </div>

        <div class="oc-info-card">
            <div class="oc-info-card-title"><i class="fa-solid fa-file-lines text-primary"></i> Documentos</div>
            <div class="oc-row">
                <span class="oc-row-label">Tipo comprobante</span>
                <span class="oc-row-val">{{ $orden_compra->orden_compra_tipo_doc }}</span>
            </div>
            <div class="oc-row">
                <span class="oc-row-label">N° comprobante</span>
                <span class="oc-row-val oc-num">#{{ $orden_compra->orden_compra_numero_doc }}</span>
            </div>
            @if($orden_compra->orden_compra_guia_remicion)
            <div class="oc-row">
                <span class="oc-row-label">Guía de remisión</span>
                <span class="oc-row-val oc-num">{{ $orden_compra->orden_compra_guia_remicion }}</span>
            </div>
            @endif
            @if($orden_compra->orden_compra_guia_transportista)
            <div class="oc-row">
                <span class="oc-row-label">Guía transportista</span>
                <span class="oc-row-val oc-num">{{ $orden_compra->orden_compra_guia_transportista }}</span>
            </div>
            @endif
            @if($orden_compra->orden_compra_doc_adjuntado && $orden_compra->orden_compra_doc_adjuntado !== 'sin-fotografia.png')
            <div class="oc-row">
                <span class="oc-row-label">Adjunto</span>
                <a href="{{ asset($orden_compra->orden_compra_doc_adjuntado) }}" target="_blank" class="oc-row-val" style="color:#2563eb">
                    <i class="fa-solid fa-paperclip me-1"></i>Ver documento
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- OBSERVACIÓN --}}
    @if($orden_compra->orden_compra_observacion && $orden_compra->orden_compra_observacion !== '---')
    <div class="oc-obs">
        <i class="fa-solid fa-circle-info" style="margin-top:2px;flex-shrink:0"></i>
        <div><strong>Observación:</strong> {{ $orden_compra->orden_compra_observacion }}</div>
    </div>
    @endif

    {{-- TOTAL --}}
    <div class="oc-total-card">
        <div class="oc-total-label"><i class="fa-solid fa-sack-dollar me-2"></i>Total de la Compra</div>
        <div class="oc-total-amount">S/ {{ number_format($total + $orden_compra->orden_compra_flete + $orden_compra->orden_compra_gastos_operativos, 2, '.', ',') }}</div>
    </div>

    {{-- TABLA PRODUCTOS --}}
    <div class="oc-table-card">
        <div class="oc-table-title"><i class="fa-solid fa-list-ul text-primary"></i> Productos de la compra</div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Familia</th>
                        <th style="text-align:center">Cantidad</th>
                        <th style="text-align:right">Precio Unit.</th>
                        <th style="text-align:right">Total</th>
                    </tr>
                </thead>
                <tbody>
                @php $a = 1; @endphp
                @foreach($detalle_orden_compra as $de)
                    <tr>
                        <td style="color:#94a3b8;font-weight:600">{{ $a }}</td>
                        <td>
                            <div style="font-weight:600;color:#1e293b">{{ $de->detalle_orden_nombre_producto }}</div>
                            @if($de->pro_codigo)
                                <small class="text-muted oc-num">{{ $de->pro_codigo }}</small>
                            @endif
                        </td>
                        <td>
                            @if($de->fa_nombre)
                                <span style="font-size:12px;background:#eff6ff;color:#2563eb;padding:2px 8px;border-radius:20px">{{ $de->familia_codigo }} · {{ $de->fa_nombre }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td style="text-align:center">
                            <span style="font-weight:700;font-size:15px">{{ $de->detalle_compra_cantidad }}</span>
                        </td>
                        <td style="text-align:right" class="oc-num">S/ {{ number_format($de->detalle_compra_precio_compra, 2, '.', ',') }}</td>
                        <td style="text-align:right">
                            <span style="font-weight:700;color:#15803d;font-family:monospace">S/ {{ number_format($de->detalle_compra_total_pedido, 2, '.', ',') }}</span>
                        </td>
                    </tr>
                    @php $a++; @endphp
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- BACK --}}
    <div class="d-flex justify-content-end mb-4">
        <a href="javascript:history.back();" class="oc-back-btn">
            <i class="fa-solid fa-arrow-left"></i> Regresar
        </a>
    </div>

</div>
</div>
@endcan
</div>
@endsection
