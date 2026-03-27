@extends('layouts.plantilla')
@section('content')
<div class="container-fluid py-3">

    {{-- Cabecera --}}
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('logistica.guias_remision') }}" class="btn btn-sm btn-outline-secondary me-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h5 class="mb-0 fw-bold">Guías Pendientes de Envío a SUNAT</h5>
        <span class="badge bg-danger ms-2" style="font-size:.85rem;">
            {{ $pendientes_total }} pendiente{{ $pendientes_total != 1 ? 's' : '' }}
        </span>
    </div>

    <div class="alert alert-warning d-flex align-items-center mb-3" style="font-size:.85rem;">
        <i class="fas fa-exclamation-triangle me-2"></i>
        Las guías deben enviarse a SUNAT dentro de los <strong>&nbsp;3 días&nbsp;</strong> siguientes a la fecha de emisión.
    </div>

    {{-- Filtros --}}
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body py-2">
            <form action="{{ route('logistica.pendientes_guia') }}" method="post">
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
                        <label class="form-label mb-1 small fw-semibold">Desde</label>
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

    {{-- Alerta respuesta --}}
    <div id="alerta_envio" class="alert d-none mb-3" role="alert"></div>

    @if($filtro)
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0" id="dataTable_pendientes">
                <thead>
                    <tr class="color_tabla">
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Serie-Correlativo</th>
                        <th>Cliente</th>
                        <th>Traslado</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guias as $i => $g)
                        @php
                            $cliente = $g->cliente_razonsocial ?: $g->cliente_nombre;
                            $tipo_txt = $g->guia_tipo == '09' ? 'REMITENTE' : 'TRANSPORTISTA';
                            $dias = \Carbon\Carbon::parse($g->created_at)->diffInDays(now());
                            $urgente = $dias >= 2;
                        @endphp
                        <tr @if($urgente) style="background:#fff3cd;" @endif>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($g->created_at)->format('d/m/Y') }}</td>
                            <td><span class="badge {{ $g->guia_tipo == '09' ? 'bg-primary' : 'bg-info text-dark' }}">{{ $tipo_txt }}</span></td>
                            <td class="fw-semibold">{{ $g->guia_serie }}-{{ $g->guia_correlativo }}</td>
                            <td>{{ $cliente }}</td>
                            <td>{{ \Carbon\Carbon::parse($g->guia_fecha_traslado)->format('d/m/Y') }}</td>
                            <td>
                                @if($urgente)
                                    <span class="badge bg-danger">¡Urgente! {{ $dias }}d</span>
                                @else
                                    <span class="badge bg-secondary">{{ $dias }}d</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-success me-1"
                                        onclick="enviarGuia({{ $g->id_guia }}, '{{ $g->guia_serie }}-{{ $g->guia_correlativo }}')"
                                        title="Enviar a SUNAT">
                                    <i class="fas fa-paper-plane"></i> Enviar
                                </button>
                                <button class="btn btn-sm btn-outline-danger"
                                        onclick="eliminarGuia({{ $g->id_guia }})"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No hay guías pendientes en el rango seleccionado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Botón nueva guía --}}
    <div class="mt-3">
        <a href="{{ route('logistica.generar_guia') }}" class="btn btn-outline-primary">
            <i class="fas fa-plus"></i> Nueva Guía
        </a>
    </div>
</div>

{{-- Modal confirmación envío --}}
<div class="modal fade" id="modalEnviar" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Confirmar Envío</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mb-1">¿Enviar a SUNAT la guía</p>
                <strong id="modal_serie_corr"></strong>?
                <p class="text-muted small mt-2 mb-0">Este proceso puede tardar unos segundos.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success btn-sm" id="btn_confirmar_envio">
                    <i class="fas fa-paper-plane"></i> Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let guiaIdSeleccionada = null;

function enviarGuia(id, serie_corr) {
    guiaIdSeleccionada = id;
    document.getElementById('modal_serie_corr').textContent = serie_corr;
    const modal = new bootstrap.Modal(document.getElementById('modalEnviar'));
    modal.show();
}

document.getElementById('btn_confirmar_envio').addEventListener('click', function () {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Enviando...';

    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('id_guia', guiaIdSeleccionada);

    fetch('{{ route("logistica.enviar_guia_sunat") }}', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        bootstrap.Modal.getInstance(document.getElementById('modalEnviar')).hide();
        const alerta = document.getElementById('alerta_envio');
        alerta.classList.remove('d-none', 'alert-success', 'alert-danger', 'alert-warning');

        // El controlador devuelve 1 (éxito) o un objeto {result,mensaje} en error
        const esExito = data === 1 || data?.result == 1;
        const esMensajeObjeto = typeof data === 'object' && data?.mensaje;

        if (esExito) {
            alerta.classList.add('alert-success');
            alerta.innerHTML = '<i class="fas fa-check-circle me-1"></i>¡Guía enviada correctamente a SUNAT!';
            setTimeout(() => location.reload(), 1800);
        } else if (esMensajeObjeto) {
            alerta.classList.add('alert-danger');
            alerta.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>' + data.mensaje;
        } else {
            // Respuesta numérica de error (igual que facturacion.js)
            const mensajes = {
                2: 'Error al generar el XML de la guía.',
                3: 'SUNAT rechazó la guía.',
                4: 'Error de comunicación con SUNAT.',
                5: 'Error al guardar en base de datos.',
                6: 'No se pudo procesar la respuesta del servidor.'
            };
            alerta.classList.add('alert-danger');
            alerta.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>' + (mensajes[data] ?? 'Ocurrió un error inesperado. Revise los logs.');
        }

        alerta.scrollIntoView({ behavior: 'smooth' });
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Confirmar';
    })
    .catch(() => {
        bootstrap.Modal.getInstance(document.getElementById('modalEnviar')).hide();
        const alerta = document.getElementById('alerta_envio');
        alerta.classList.remove('d-none');
        alerta.classList.add('alert-danger');
        alerta.textContent = 'Error de conexión. Intente de nuevo.';
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Confirmar';
    });
});

function eliminarGuia(id) {
    if (!confirm('¿Eliminar esta guía? Esta acción no se puede deshacer.')) return;
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('id_guia', id);

    fetch('{{ route("logistica.eliminar_guia") }}', { method: 'POST', body: formData })
    .then(r => r.json())
    .then(data => {
        const alerta = document.getElementById('alerta_envio');
        alerta.classList.remove('d-none', 'alert-success', 'alert-danger');
        if (data.result == 1) {
            alerta.classList.add('alert-success');
            alerta.innerHTML = data.mensaje;
            setTimeout(() => location.reload(), 1200);
        } else {
            alerta.classList.add('alert-danger');
            alerta.innerHTML = data.mensaje;
        }
    });
}
</script>
@endsection
