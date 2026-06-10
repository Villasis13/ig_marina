<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Caja</title>
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:Arial,sans-serif;font-size:11px;padding:20px;color:#1e293b}
  h2{color:#0b1892;text-align:center;font-size:18px;margin-bottom:4px}
  .periodo{text-align:center;color:#64748b;font-size:12px;margin-bottom:20px}
  .btn-print{display:block;margin:0 auto 18px;padding:6px 18px;background:#0b1892;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:12px}
  @media print{.btn-print{display:none}}

  /* ── Stats strip ── */
  .stats{display:flex;gap:10px;margin-bottom:18px;flex-wrap:wrap}
  .stat-box{flex:1;min-width:120px;background:#0b1892;color:#fff;border-radius:8px;padding:10px 14px}
  .stat-box.green{background:#15803d}
  .stat-box.purple{background:#7c3aed}
  .stat-label{font-size:9px;font-weight:700;letter-spacing:.4px;text-transform:uppercase;opacity:.85}
  .stat-val{font-size:17px;font-weight:700;margin-top:3px}

  /* ── Section title ── */
  .sec-title{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;
    color:#0b1892;border-left:3px solid #0b1892;padding-left:8px;margin-bottom:8px;margin-top:16px}

  /* ── Tables ── */
  table{width:100%;border-collapse:collapse;margin-bottom:14px}
  thead th{background:#0b1892;color:#fff;padding:5px 7px;font-size:10.5px;text-align:left}
  tfoot th{background:#eff6ff;color:#0b1892;padding:5px 7px;font-size:10.5px;font-weight:700}
  td{padding:4px 7px;border-bottom:1px solid #e2e8f0;font-size:11px}
  tr:nth-child(even) td{background:#f8fafc}
  .badge-open{background:#d1fae5;color:#065f46;border-radius:8px;padding:1px 6px;font-size:9px;font-weight:700}
  .badge-close{background:#fee2e2;color:#991b1b;border-radius:8px;padding:1px 6px;font-size:9px;font-weight:700}
  .text-right{text-align:right}
  .text-center{text-align:center}

  /* ── Cuadre ── */
  .cuadre-wrap{display:flex;gap:14px;margin-bottom:14px;flex-wrap:wrap}
  .cuadre-box{flex:1;min-width:200px;border:1px solid #e2e8f0;border-radius:8px;padding:12px}
  .cuadre-row{display:flex;justify-content:space-between;padding:4px 0;border-bottom:1px solid #f1f5f9;font-size:11px}
  .cuadre-row:last-child{border-bottom:none}
  .cuadre-total{background:#eff6ff;border-radius:4px;padding:6px 8px;margin-top:6px;display:flex;justify-content:space-between;font-weight:700}
  .c-label{color:#64748b}
  .c-val{font-weight:600;color:#1e293b}
</style>
</head>
<body>

<button class="btn-print" onclick="window.print()">Imprimir / Guardar PDF</button>

<h2>REPORTE DE CAJA</h2>
<p class="periodo">Del {{ date('d/m/Y', strtotime($fi)) }} al {{ date('d/m/Y', strtotime($ff)) }}</p>

@if(!$reporte)
<p class="text-center" style="color:#888;margin-top:40px">Sin registros de caja en el período seleccionado.</p>
@else
@php $r = $reporte['resumen']; @endphp

{{-- Stats --}}
<div class="stats">
    <div class="stat-box">
        <div class="stat-label">Total Ventas</div>
        <div class="stat-val">S/ {{ number_format($r->total_ventas, 2) }}</div>
    </div>
    <div class="stat-box green">
        <div class="stat-label">Efectivo</div>
        <div class="stat-val">S/ {{ number_format($r->ventas_efectivo, 2) }}</div>
    </div>
    <div class="stat-box purple">
        <div class="stat-label">Turnos</div>
        <div class="stat-val">{{ $r->total_turnos }}</div>
    </div>
    <div class="stat-box" style="background:{{ $r->diferencia == 0 ? '#15803d' : ($r->diferencia > 0 ? '#b45309' : '#dc2626') }}">
        <div class="stat-label">Diferencia</div>
        <div class="stat-val">S/ {{ number_format($r->diferencia, 2) }}</div>
    </div>
</div>

{{-- Cuadre + Ventas por medio --}}
<div class="cuadre-wrap">
    <div class="cuadre-box">
        <div class="sec-title" style="margin-top:0">Cuadre — {{ $reporte['nombreCaja'] }}</div>
        <div class="cuadre-row">
            <span class="c-label">Monto apertura</span>
            <span class="c-val">S/ {{ number_format($r->monto_apertura,2) }}</span>
        </div>
        <div class="cuadre-row">
            <span class="c-label">+ Ventas efectivo</span>
            <span class="c-val">S/ {{ number_format($r->ventas_efectivo,2) }}</span>
        </div>
        @if($r->notas_credito > 0)
        <div class="cuadre-row">
            <span class="c-label">− Notas de crédito</span>
            <span class="c-val" style="color:#dc2626">S/ {{ number_format($r->notas_credito,2) }}</span>
        </div>
        @endif
        <div class="cuadre-total">
            <span>Total en sistema</span>
            <span>S/ {{ number_format($r->total_sistema,2) }}</span>
        </div>
        <div class="cuadre-row" style="margin-top:6px">
            <span class="c-label">Monto cierre (contado)</span>
            <span class="c-val">S/ {{ number_format($r->monto_cierre,2) }}</span>
        </div>
        <div class="cuadre-row">
            <span class="c-label" style="font-weight:700">Diferencia</span>
            <span class="c-val" style="color:{{ $r->diferencia==0?'#15803d':($r->diferencia>0?'#b45309':'#dc2626') }}">
                S/ {{ number_format($r->diferencia,2) }}
            </span>
        </div>
    </div>

    <div class="cuadre-box">
        <div class="sec-title" style="margin-top:0">Ventas por medio de pago</div>
        <table style="margin:0">
            <thead><tr><th>Medio de pago</th><th class="text-right">Total S/</th></tr></thead>
            <tbody>
            @foreach($reporte['ventasPorMedio'] as $vm)
            <tr>
                <td>{{ $vm->tipo_pago_nombre }}</td>
                <td class="text-right">{{ number_format((float)$vm->total,2) }}</td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr><th>TOTAL</th><th class="text-right">{{ number_format($r->total_ventas,2) }}</th></tr>
            </tfoot>
        </table>
    </div>
</div>

{{-- Turnos --}}
<div class="sec-title">Turnos registrados</div>
<table>
    <thead>
        <tr>
            <th>#</th><th>Caja</th><th>Cajero</th>
            <th>Apertura</th><th>Cierre</th><th>M.Apertura</th><th>Estado</th>
        </tr>
    </thead>
    <tbody>
    @foreach($reporte['turnos'] as $i => $t)
    <tr>
        <td>{{ $i+1 }}</td>
        <td><b>{{ $t->caja_numero_nombre }}</b></td>
        <td>{{ $t->nombre_apertura }}</td>
        <td>{{ date('d/m/Y H:i', strtotime($t->caja_fecha_apertura)) }}</td>
        <td>{{ $t->caja_estado==0 ? date('d/m/Y H:i', strtotime($t->caja_fecha_cierre)) : '—' }}</td>
        <td>S/ {{ number_format((float)$t->caja_apertura,2) }}</td>
        <td>
            @if($t->caja_estado==1)<span class="badge-open">ABIERTO</span>
            @else<span class="badge-close">CERRADO</span>@endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

{{-- Comprobantes --}}
<div class="sec-title">Comprobantes emitidos ({{ count($reporte['comprobantes']) }})</div>
<table>
    <thead>
        <tr>
            <th>#</th><th>Tipo</th><th>Comprobante</th>
            <th>Caja</th><th>Cliente</th><th>Fecha</th><th class="text-right">Total S/</th>
        </tr>
    </thead>
    <tbody>
    @foreach($reporte['comprobantes'] as $i => $v)
    <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $v->venta_tipo=='01' ? 'Factura' : 'Boleta' }}</td>
        <td style="font-family:monospace">{{ $v->venta_serie }}-{{ str_pad($v->venta_correlativo,8,'0',STR_PAD_LEFT) }}</td>
        <td>{{ $v->caja_numero_nombre }}</td>
        <td>{{ $v->cliente_nombre }}</td>
        <td>{{ date('d/m/Y H:i', strtotime($v->venta_fecha)) }}</td>
        <td class="text-right">{{ number_format((float)$v->venta_total,2) }}</td>
    </tr>
    @endforeach
    </tbody>
    @if(count($reporte['comprobantes']) > 0)
    <tfoot>
        <tr>
            <th colspan="6">TOTAL</th>
            <th class="text-right">S/ {{ number_format($r->total_ventas,2) }}</th>
        </tr>
    </tfoot>
    @endif
</table>
@endif

</body>
</html>
