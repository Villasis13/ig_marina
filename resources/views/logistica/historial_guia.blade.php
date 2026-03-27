@extends('layouts.plantilla')
@section('content')
<div class="container-fluid py-3">

    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('logistica.guias_remision') }}" class="btn btn-sm btn-outline-secondary me-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h5 class="mb-0 fw-bold">Historial de Envíos a SUNAT</h5>
    </div>

    {{-- Filtros --}}
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body py-2">
            <form action="{{ route('logistica.historial_guia') }}" method="post">
                @csrf
                <input type="hidden" name="enviar_filtro" value="1">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label mb-1 small fw-semibold">Tipo de Guía</label>
                        <select name="guia_tipo" class="form-select form-select-sm">
                            <option value="" <?= ($guia_tipo == '') ? 'selected' : '' ?>>TODOS</option>
                            <option value="09" <?= ($guia_tipo == '09') ? 'selected' : '' ?>>REMITENTE</option>
                            <option value="31" <?= ($guia_tipo == '31') ? 'selected' : '' ?>>TRANSPORTISTA</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label mb-1 small fw-semibold">Desde (fecha envío)</label>
                        <input type="date" name="fecha_inicio" class="form-control form-control-sm" value="{{ $fecha_inicio }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label mb-1 small fw-semibold">Hasta</label>
                        <input type="date" name="fecha_final" class="form-control form-control-sm" value="{{ $fecha_final }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100">
                            <i class="fa fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($filtro)
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0" id="dataTable_historial">
                <thead>
                    <tr class="color_tabla">
                        <th>#</th>
                        <th>Fecha Emisión</th>
                        <th>Fecha Envío</th>
                        <th>Tipo</th>
                        <th>Serie-Correlativo</th>
                        <th>Cliente</th>
                        <th>Traslado</th>
                        <th>Respuesta SUNAT</th>
                        <th class="text-center">CDR / PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guias as $i => $g)
                        @php
                            $cliente  = $g->cliente_razonsocial ?: $g->cliente_nombre;
                            $tipo_txt = $g->guia_tipo == '09' ? 'REMITENTE' : 'TRANSPORTISTA';
                        @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($g->created_at)->format('d/m/Y') }}</td>
                            <td>{{ $g->guia_fecha_envio ? \Carbon\Carbon::parse($g->guia_fecha_envio)->format('d/m/Y H:i') : '—' }}</td>
                            <td>
                                <span class="badge {{ $g->guia_tipo == '09' ? 'bg-primary' : 'bg-info text-dark' }}">
                                    {{ $tipo_txt }}
                                </span>
                            </td>
                            <td class="fw-semibold">{{ $g->guia_serie }}-{{ $g->guia_correlativo }}</td>
                            <td>{{ $cliente }}</td>
                            <td>{{ \Carbon\Carbon::parse($g->guia_fecha_traslado)->format('d/m/Y') }}</td>
                            <td>
                                @if($g->guia_respuesta_sunat)
                                    <span class="text-success small">
                                        <i class="fas fa-check-circle me-1"></i>{{ $g->guia_respuesta_sunat }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($g->guia_rutaCDR)
                                    <span class="badge bg-success me-1" title="CDR generado">CDR</span>
                                @endif
                                @if($g->guia_linkpdf_sunat)
                                    <a href="{{ $g->guia_linkpdf_sunat }}" target="_blank"
                                       class="badge bg-secondary text-decoration-none" title="PDF SUNAT">
                                        PDF
                                    </a>
                                @endif
                                @if($g->guia_remision_numTicket)
                                    <span class="text-muted d-block" style="font-size:.7rem;" title="Ticket">
                                        #{{ $g->guia_remision_numTicket }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                No hay guías enviadas en el rango seleccionado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($guias->isNotEmpty())
                <tfoot>
                    <tr>
                        <td colspan="9" class="text-end text-muted small py-2 pe-3">
                            Total: {{ $guias->count() }} guía{{ $guias->count() != 1 ? 's' : '' }}
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
    @else
    <div class="text-center py-5 text-muted">
        <i class="fas fa-search fa-2x mb-3 d-block"></i>
        Selecciona un rango de fechas y haz clic en <strong>Buscar</strong>.
    </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('logistica.generar_guia') }}" class="btn btn-outline-primary me-2">
            <i class="fas fa-plus"></i> Nueva Guía
        </a>
        <a href="{{ route('logistica.pendientes_guia') }}" class="btn btn-outline-warning">
            <i class="fas fa-clock"></i> Ver Pendientes
        </a>
    </div>
</div>
@endsection
