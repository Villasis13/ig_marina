@extends('layouts.plantilla')
@section('content')
<style>
    .section-title { font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#4451B6; border-bottom:2px solid #4451B6; padding-bottom:4px; margin-bottom:1rem; }
    .tabla-detalle th { background:#f1f3fb; font-size:.8rem; }
    .tabla-detalle td { vertical-align: middle; }
    .btn-agregar-item { font-size:.82rem; }
</style>

<div class="container-fluid py-3">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('logistica.guias_remision') }}" class="btn btn-sm btn-outline-secondary me-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h5 class="mb-0 fw-bold">Generar Guía de Remisión</h5>
    </div>

    {{-- Alertas --}}
    <div id="alerta_guia" class="alert d-none" role="alert"></div>

    <form id="form_guia">
        @csrf
        <div class="row g-3">

            {{-- ── DATOS GENERALES ── --}}
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="section-title">Datos Generales</p>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Empresa <span class="text-danger">*</span></label>
                                <select name="id_empresa" id="id_empresa" class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($empresas as $e)
                                        <option value="{{ $e->id_empresa }}">{{ $e->empresa_razon_social }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tipo de Guía <span class="text-danger">*</span></label>
                                <select name="guia_tipo" id="guia_tipo" class="form-select" required>
                                    <option value="09">GUÍA REMITENTE (T001-...)</option>
                                    <option value="31">GUÍA TRANSPORTISTA (V001-...)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Fecha de Traslado <span class="text-danger">*</span></label>
                                <input type="date" name="guia_fecha_traslado" class="form-control" required value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Motivo de Traslado</label>
                                <select name="guia_motivo" class="form-select">
                                    <option value="01">01 - VENTA</option>
                                    <option value="02">02 - COMPRA</option>
                                    <option value="03">03 - VENTA CON ENTREGA A TERCEROS</option>
                                    <option value="04">04 - TRASLADO ENTRE ESTABLECIMIENTOS</option>
                                    <option value="05">05 - CONSIGNACIÓN</option>
                                    <option value="06">06 - DEVOLUCIÓN</option>
                                    <option value="13">13 - OTROS</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Cliente / Destinatario <span class="text-danger">*</span></label>
                                <select name="id_clientes" id="id_clientes" class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($clientes as $c)
                                        <option value="{{ $c->id_clientes }}">
                                            {{ $c->cliente_razonsocial ?: $c->cliente_nombre }} - {{ $c->cliente_numero }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Observación</label>
                                <input type="text" name="guia_observacion" class="form-control" placeholder="Opcional">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── TRANSPORTE ── --}}
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="section-title">Datos del Transporte</p>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tipo de Transporte</label>
                                <select name="guia_tipo_trans" id="guia_tipo_trans" class="form-select">
                                    <option value="02">02 - PRIVADO</option>
                                    <option value="01">01 - PÚBLICO</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Placa del Vehículo</label>
                                <input type="text" name="guia_placa" class="form-control" placeholder="Ej: ABC-123">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Marca del Vehículo</label>
                                <input type="text" name="vehiculo_marca" class="form-control" placeholder="Ej: Toyota">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Placa de Carreta</label>
                                <input type="text" name="guia_carreta" class="form-control" placeholder="Opcional">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Peso Bruto (kg)</label>
                                <input type="number" step="0.001" name="guia_peso_bruto" class="form-control" value="0">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Unidad de Medida</label>
                                <select name="guia_unidad_medida" class="form-select">
                                    <option value="KGM">KGM - Kilogramo</option>
                                    <option value="TNE">TNE - Tonelada</option>
                                    <option value="GRM">GRM - Gramo</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">N° Bultos</label>
                                <input type="number" name="guia_n_bulto" class="form-control" value="1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Certificado MTC</label>
                                <input type="text" name="guia_certificado_mtc" class="form-control" placeholder="Opcional">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── CONDUCTOR ── --}}
            <div class="col-12" id="seccion_conductor">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="section-title">Datos del Conductor</p>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Tipo Documento</label>
                                <select name="guia_conductor_documento_tipo" class="form-select">
                                    <option value="1">DNI</option>
                                    <option value="4">CE</option>
                                    <option value="7">PASAPORTE</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">N° Documento</label>
                                <input type="text" name="guia_conductor_numero" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Nombres</label>
                                <input type="text" name="guia_conductor_nombre" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Apellidos</label>
                                <input type="text" name="guia_conductor_apellidos" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Licencia de Conducir</label>
                                <input type="text" name="guia_licencia_conductor" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── TRANSPORTISTA PÚBLICO (solo visible cuando tipo_trans=01) ── --}}
            <div class="col-12" id="seccion_transportista" style="display:none;">
                <div class="card shadow-sm border-0 border-start border-3 border-warning">
                    <div class="card-body">
                        <p class="section-title">Datos del Transportista (Transporte Público)</p>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Tipo Documento</label>
                                <select name="guia_tipo_doc_trans" class="form-select">
                                    <option value="6">RUC</option>
                                    <option value="1">DNI</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">N° Documento</label>
                                <input type="text" name="guia_num_doc_trans" class="form-control">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Denominación / Razón Social</label>
                                <input type="text" name="guia_denominacion" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── DESTINATARIO ADICIONAL (solo tipo 31 transportista) ── --}}
            <div class="col-12" id="seccion_destinatario" style="display:none;">
                <div class="card shadow-sm border-0 border-start border-3 border-info">
                    <div class="card-body">
                        <p class="section-title">Datos del Destinatario (Guía Transportista)</p>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Tipo Documento</label>
                                <select name="guia_tipo_doc_desti" class="form-select">
                                    <option value="6">RUC</option>
                                    <option value="1">DNI</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">N° Documento</label>
                                <input type="text" name="guia_num_doc_desti" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Denominación</label>
                                <input type="text" name="guia_denominacion_desti" class="form-control">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Dirección</label>
                                <input type="text" name="guia_direccion_desti" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── PUNTOS DE TRASLADO ── --}}
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="section-title">Puntos de Partida y Llegada</p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Dirección de Partida</label>
                                <input type="text" name="guia_direccion_part" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ubigeo de Partida</label>
                                <select name="guia_ubigeo_part" class="form-select" required>
                                    <option value="">Seleccionar ubigeo...</option>
                                    @foreach($ubigeos as $u)
                                        <option value="{{ $u->ubigeo_cod }}">
                                            {{ $u->ubigeo_departamento }} / {{ $u->ubigeo_provincia }} / {{ $u->ubigeo_distrito }} ({{ $u->ubigeo_cod }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Dirección de Llegada</label>
                                <input type="text" name="guia_direccion_llega" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ubigeo de Llegada</label>
                                <select name="guia_ubigeo_llega" class="form-select" required>
                                    <option value="">Seleccionar ubigeo...</option>
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
            </div>

            {{-- ── DETALLE DE BIENES ── --}}
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <p class="section-title mb-0">Bienes a Trasladar</p>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-agregar-item" onclick="agregarItem()">
                                <i class="fas fa-plus"></i> Agregar ítem
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table tabla-detalle" id="tabla_detalle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="min-width:250px;">Descripción *</th>
                                        <th style="min-width:90px;">Cantidad</th>
                                        <th style="min-width:90px;">Peso (kg)</th>
                                        <th style="min-width:80px;">U.M.</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_detalle">
                                    <tr id="fila_1">
                                        <td>1</td>
                                        <td><input type="text" name="detalle_descripcion[]" class="form-control form-control-sm" required></td>
                                        <td><input type="number" step="0.01" min="0" name="detalle_cantidad[]" class="form-control form-control-sm" value="1"></td>
                                        <td><input type="number" step="0.001" min="0" name="detalle_peso[]" class="form-control form-control-sm" value="0"></td>
                                        <td>
                                            <select name="detalle_um[]" class="form-select form-select-sm">
                                                <option value="NIU">NIU</option>
                                                <option value="KGM">KGM</option>
                                                <option value="ZZ">ZZ</option>
                                                <option value="TNE">TNE</option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BOTÓN GUARDAR --}}
            <div class="col-12 text-end">
                <a href="{{ route('logistica.guias_remision') }}" class="btn btn-secondary me-2">Cancelar</a>
                <button type="button" class="btn btn-primary px-4" onclick="guardarGuia()">
                    <i class="fas fa-save"></i> Guardar Guía
                </button>
            </div>

        </div>{{-- row --}}
    </form>
</div>

<script>
    let filaCount = 1;

    function agregarItem() {
        filaCount++;
        const tbody = document.getElementById('tbody_detalle');
        const tr = document.createElement('tr');
        tr.id = 'fila_' + filaCount;
        tr.innerHTML = `
            <td>${filaCount}</td>
            <td><input type="text" name="detalle_descripcion[]" class="form-control form-control-sm" required></td>
            <td><input type="number" step="0.01" min="0" name="detalle_cantidad[]" class="form-control form-control-sm" value="1"></td>
            <td><input type="number" step="0.001" min="0" name="detalle_peso[]" class="form-control form-control-sm" value="0"></td>
            <td>
                <select name="detalle_um[]" class="form-select form-select-sm">
                    <option value="NIU">NIU</option>
                    <option value="KGM">KGM</option>
                    <option value="ZZ">ZZ</option>
                    <option value="TNE">TNE</option>
                </select>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarFila('fila_${filaCount}')">
                    <i class="fas fa-trash"></i>
                </button>
            </td>`;
        tbody.appendChild(tr);
    }

    function eliminarFila(id) {
        const fila = document.getElementById(id);
        if (fila) fila.remove();
    }

    // Mostrar/ocultar secciones según tipo de guía y tipo de transporte
    document.getElementById('guia_tipo').addEventListener('change', function () {
        const esTransportista = this.value === '31';
        document.getElementById('seccion_destinatario').style.display = esTransportista ? '' : 'none';
    });

    document.getElementById('guia_tipo_trans').addEventListener('change', function () {
        const esPublico = this.value === '01';
        document.getElementById('seccion_transportista').style.display = esPublico ? '' : 'none';
    });

    function guardarGuia() {
        const alerta = document.getElementById('alerta_guia');
        const form   = document.getElementById('form_guia');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

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
                document.getElementById('tbody_detalle').innerHTML = `
                    <tr id="fila_1">
                        <td>1</td>
                        <td><input type="text" name="detalle_descripcion[]" class="form-control form-control-sm" required></td>
                        <td><input type="number" step="0.01" min="0" name="detalle_cantidad[]" class="form-control form-control-sm" value="1"></td>
                        <td><input type="number" step="0.001" min="0" name="detalle_peso[]" class="form-control form-control-sm" value="0"></td>
                        <td><select name="detalle_um[]" class="form-select form-select-sm"><option value="NIU">NIU</option></select></td>
                        <td></td>
                    </tr>`;
                filaCount = 1;
            } else {
                alerta.classList.add('alert-danger');
                alerta.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>' + data.mensaje;
            }
            alerta.scrollIntoView({ behavior: 'smooth' });
        })
        .catch(() => {
            alerta.classList.remove('d-none');
            alerta.classList.add('alert-danger');
            alerta.textContent = 'Error de conexión. Intente de nuevo.';
        });
    }
</script>
@endsection
