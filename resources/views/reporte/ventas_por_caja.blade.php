@extends('layouts.plantilla')
@section('content')
<style>
.vc-stat-card { border-radius:10px; padding:16px 20px; color:#fff; }
.vc-stat-label { font-size:11px; font-weight:600; letter-spacing:.5px; text-transform:uppercase; opacity:.85; }
.vc-stat-value { font-size:22px; font-weight:700; margin-top:4px; }
.vc-section-title {
  font-size:12px; font-weight:700; letter-spacing:.6px; text-transform:uppercase;
  color:#1e3a5f; border-left:3px solid #0b1892; padding-left:10px; margin-bottom:12px;
}
.vc-table thead th { background:#0b1892; color:#fff; font-size:11.5px; font-weight:600; white-space:nowrap; }
.vc-table td { font-size:12.5px; vertical-align:middle; }
.vc-badge-open  { background:#d1fae5; color:#065f46; font-size:10px; font-weight:700; padding:2px 8px; border-radius:10px; }
.vc-badge-close { background:#fee2e2; color:#991b1b; font-size:10px; font-weight:700; padding:2px 8px; border-radius:10px; }
.vc-cuadre-row { display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid #f1f5f9; font-size:13px; }
.vc-cuadre-row:last-child { border-bottom:none; }
.vc-cuadre-label { color:#475569; }
.vc-cuadre-val   { font-weight:600; color:#1e293b; }
.vc-cuadre-total { background:#eff6ff; border-radius:6px; padding:8px 12px; }
.vc-cuadre-total .vc-cuadre-label { font-weight:700; color:#1e3a5f; }
.vc-cuadre-total .vc-cuadre-val   { font-size:16px; color:#0b1892; }
.vc-dif-ok   .vc-cuadre-val { color:#15803d; }
.vc-dif-bad  .vc-cuadre-val { color:#dc2626; }
</style>

<div class="tab-content">
    @can($opciones[0]->opciones_funcion)
    <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active" role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}">

        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="card">
                <div class="row m-3">
                    <div class="col-lg-12 text-center">
                        <h6 class="m-0 text-primary">REPORTE DE CAJA</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form id="formulario_caja" action="{{ route('reporte.ventas_por_caja') }}" method="POST">
                @csrf
                <input type="hidden" name="enviar" value="1">

                <div class="row">
                    {{-- Columna período --}}
                    <div class="col-lg-2 col-md-3 col-sm-12 mb-2">
                        <div class="card h-100">
                            <div class="card-body">
                                @foreach([['d','Diario'],['s','Semanal'],['q','Quincenal'],['m','Mensual'],['tri','Trimestral'],['sem','Semestral'],['a','Anual']] as [$val,$label])
                                <div class="mb-2">
                                    <input onclick="cambiar_fec_general()" type="radio" name="opcion"
                                           id="vc_op_{{$val}}" value="{{$val}}" {{ $check == $val ? 'checked' : '' }}>
                                    <label for="vc_op_{{$val}}">{{$label}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Columna filtros + resultados --}}
                    <div class="col-lg-10 col-md-9 col-sm-12 mb-2">

                        {{-- Filtros --}}
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row g-2 align-items-end">

                                    <div class="col-lg-3 col-md-12 col-sm-12">
                                        <label class="form-label fw-semibold" style="font-size:12px">
                                            <i class="fa fa-cash-register me-1"></i> Caja
                                        </label>
                                        <select name="id_caja_numero" class="form-select form-select-sm">
                                            <option value="">Todas las cajas</option>
                                            @foreach($cajas_disponibles as $cn)
                                            <option value="{{ $cn->id_caja_numero }}"
                                                {{ $id_caja_numero == $cn->id_caja_numero ? 'selected' : '' }}>
                                                {{ $cn->caja_numero_nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-sm-12">
                                        <label class="form-label fw-semibold" style="font-size:12px">Desde</label>
                                        <input type="date" class="form-control form-control-sm" name="desde" id="desde" value="{{ $fecha_inicio }}">
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-sm-12">
                                        <label class="form-label fw-semibold" style="font-size:12px">Hasta</label>
                                        <input type="date" class="form-control form-control-sm" name="hasta" id="hasta" value="{{ $fecha_fin }}">
                                    </div>

                                    <div class="col-lg-2 col-md-4 col-sm-12">
                                        <button type="submit" class="btn btn-info btn-sm w-100">
                                            <i class="bx bx-search-alt"></i> Buscar
                                        </button>
                                    </div>

                                    @if($reporte)
                                    @php $qStr = '?desde='.$fecha_inicio.'&hasta='.$fecha_fin.($id_caja_numero?'&id_caja_numero='.$id_caja_numero:''); @endphp
                                    <div class="col-lg-auto col-md-4 col-sm-12">
                                        <a href="{{ route('reporte.ventas_caja_excel') }}{{$qStr}}" class="btn btn-success btn-sm" target="_blank">
                                            <i class="fa fa-file-excel"></i> Excel
                                        </a>
                                    </div>
                                    <div class="col-lg-auto col-md-4 col-sm-12">
                                        <a href="{{ route('reporte.pdf_report_caja') }}{{$qStr}}" class="btn btn-danger btn-sm" target="_blank">
                                            <i class="fa fa-file-pdf"></i> PDF
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Sin resultados --}}
                        @if($searched && !$reporte)
                        <div class="alert alert-info d-flex align-items-center gap-2">
                            <i class="fa fa-info-circle fa-lg"></i>
                            No se encontraron turnos de caja en el período seleccionado.
                        </div>
                        @endif

                        @if($reporte)
                        @php
                            $r  = $reporte['resumen'];
                            $nc = $reporte['nombreCaja'];
                        @endphp

                        {{-- Tarjetas resumen --}}
                        <div class="row g-2 mb-3">
                            <div class="col-6 col-lg-3">
                                <div class="vc-stat-card" style="background:#0b1892">
                                    <div class="vc-stat-label">Total Ventas</div>
                                    <div class="vc-stat-value">S/ {{ number_format($r->total_ventas,2) }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="vc-stat-card" style="background:#15803d">
                                    <div class="vc-stat-label">Efectivo</div>
                                    <div class="vc-stat-value">S/ {{ number_format($r->ventas_efectivo,2) }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="vc-stat-card" style="background:#7c3aed">
                                    <div class="vc-stat-label">Turnos</div>
                                    <div class="vc-stat-value">{{ $r->total_turnos }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="vc-stat-card" style="background:{{ $r->diferencia == 0 ? '#15803d' : ($r->diferencia > 0 ? '#b45309' : '#dc2626') }}">
                                    <div class="vc-stat-label">Diferencia</div>
                                    <div class="vc-stat-value">S/ {{ number_format($r->diferencia,2) }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Turnos + Cuadre --}}
                        <div class="row g-3 mb-3">

                            {{-- Turnos --}}
                            <div class="col-lg-8">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="vc-section-title">
                                            <i class="fa fa-list-alt me-1"></i> Turnos registrados
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered vc-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Caja</th>
                                                        <th>Cajero</th>
                                                        <th>Apertura</th>
                                                        <th>Cierre</th>
                                                        <th>M.Apertura</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($reporte['turnos'] as $i => $t)
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    <td><b>{{ $t->caja_numero_nombre }}</b></td>
                                                    <td>{{ $t->nombre_apertura }}</td>
                                                    <td>{{ date('d/m/Y H:i', strtotime($t->caja_fecha_apertura)) }}</td>
                                                    <td>
                                                        @if($t->caja_estado == 0)
                                                            {{ date('d/m/Y H:i', strtotime($t->caja_fecha_cierre)) }}
                                                        @else
                                                            <span class="text-muted fst-italic">Pendiente</span>
                                                        @endif
                                                    </td>
                                                    <td>S/ {{ number_format((float)$t->caja_apertura,2) }}</td>
                                                    <td>
                                                        @if($t->caja_estado == 1)
                                                            <span class="vc-badge-open">ABIERTO</span>
                                                        @else
                                                            <span class="vc-badge-close">CERRADO</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr><td colspan="7" class="text-center text-muted">Sin turnos</td></tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Cuadre --}}
                            <div class="col-lg-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="vc-section-title">
                                            <i class="fa fa-balance-scale me-1"></i> Cuadre de caja
                                        </div>
                                        <div style="font-size:11px;color:#64748b;margin-bottom:10px">{{ $nc }}</div>

                                        <div class="vc-cuadre-row">
                                            <span class="vc-cuadre-label">Monto apertura</span>
                                            <span class="vc-cuadre-val">S/ {{ number_format($r->monto_apertura,2) }}</span>
                                        </div>
                                        <div class="vc-cuadre-row">
                                            <span class="vc-cuadre-label">+ Ventas efectivo</span>
                                            <span class="vc-cuadre-val">S/ {{ number_format($r->ventas_efectivo,2) }}</span>
                                        </div>
                                        @if($r->notas_credito > 0)
                                        <div class="vc-cuadre-row">
                                            <span class="vc-cuadre-label">− Notas de crédito</span>
                                            <span class="vc-cuadre-val text-danger">S/ {{ number_format($r->notas_credito,2) }}</span>
                                        </div>
                                        @endif
                                        <div class="vc-cuadre-row vc-cuadre-total mt-2">
                                            <span class="vc-cuadre-label">Total en sistema</span>
                                            <span class="vc-cuadre-val">S/ {{ number_format($r->total_sistema,2) }}</span>
                                        </div>
                                        <div class="vc-cuadre-row mt-2">
                                            <span class="vc-cuadre-label">Monto cierre</span>
                                            <span class="vc-cuadre-val">S/ {{ number_format($r->monto_cierre,2) }}</span>
                                        </div>
                                        <div class="vc-cuadre-row {{ $r->diferencia == 0 ? '' : ($r->diferencia > 0 ? 'vc-dif-ok' : 'vc-dif-bad') }}">
                                            <span class="vc-cuadre-label fw-bold">Diferencia</span>
                                            <span class="vc-cuadre-val">
                                                S/ {{ number_format($r->diferencia,2) }}
                                                @if($r->diferencia == 0) <i class="fa fa-check text-success ms-1"></i>
                                                @elseif($r->diferencia > 0) <i class="fa fa-arrow-up text-warning ms-1"></i>
                                                @else <i class="fa fa-arrow-down text-danger ms-1"></i>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Ventas por medio de pago + Comprobantes --}}
                        <div class="row g-3">

                            {{-- Ventas por medio de pago --}}
                            <div class="col-lg-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="vc-section-title">
                                            <i class="fa fa-credit-card me-1"></i> Ventas por medio de pago
                                        </div>
                                        <table class="table table-sm table-hover vc-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Medio de pago</th>
                                                    <th class="text-end">Total S/</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($reporte['ventasPorMedio'] as $vm)
                                            <tr>
                                                <td>{{ $vm->tipo_pago_nombre }}</td>
                                                <td class="text-end fw-semibold">{{ number_format((float)$vm->total,2) }}</td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="2" class="text-center text-muted">Sin datos</td></tr>
                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr style="background:#eff6ff">
                                                    <th>TOTAL</th>
                                                    <th class="text-end">{{ number_format($r->total_ventas,2) }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Comprobantes --}}
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="vc-section-title">
                                            <i class="fa fa-receipt me-1"></i> Comprobantes emitidos
                                            <span class="badge bg-secondary ms-2" style="font-weight:500">{{ count($reporte['comprobantes']) }}</span>
                                        </div>
                                        <div class="table-responsive" style="max-height:380px;overflow-y:auto">
                                            <table class="table table-sm table-hover table-bordered vc-table mb-0">
                                                <thead style="position:sticky;top:0;z-index:1">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tipo</th>
                                                        <th>Comprobante</th>
                                                        <th>Caja</th>
                                                        <th>Cliente</th>
                                                        <th>Fecha</th>
                                                        <th class="text-end">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($reporte['comprobantes'] as $i => $v)
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    <td>
                                                        @if($v->venta_tipo=='01')
                                                            <span class="badge bg-primary" style="font-size:10px">F</span>
                                                        @else
                                                            <span class="badge bg-success" style="font-size:10px">B</span>
                                                        @endif
                                                    </td>
                                                    <td style="font-family:monospace;font-size:12px">
                                                        {{ $v->venta_serie }}-{{ str_pad($v->venta_correlativo,8,'0',STR_PAD_LEFT) }}
                                                    </td>
                                                    <td>{{ $v->caja_numero_nombre }}</td>
                                                    <td>{{ $v->cliente_nombre }}</td>
                                                    <td>{{ date('d/m/Y H:i', strtotime($v->venta_fecha)) }}</td>
                                                    <td class="text-end fw-semibold">{{ number_format((float)$v->venta_total,2) }}</td>
                                                </tr>
                                                @empty
                                                <tr><td colspan="7" class="text-center text-muted py-3">Sin comprobantes</td></tr>
                                                @endforelse
                                                </tbody>
                                                @if(count($reporte['comprobantes']) > 0)
                                                <tfoot>
                                                    <tr style="background:#eff6ff">
                                                        <th colspan="6">TOTAL</th>
                                                        <th class="text-end">S/ {{ number_format($r->total_ventas,2) }}</th>
                                                    </tr>
                                                </tfoot>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>{{-- /row comprobantes --}}
                        @endif{{-- /if reporte --}}

                    </div>{{-- /col-lg-10 --}}
                </div>{{-- /row --}}
            </form>
        </div>

    </div>
    @endcan
</div>

<script src="{{ asset('js/domain.js') }}"></script>
<script src="{{ asset('js/reporte.js') }}"></script>
@endsection
