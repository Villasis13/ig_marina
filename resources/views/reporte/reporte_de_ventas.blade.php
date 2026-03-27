@extends('layouts.plantilla')
@section('content')

<div class="tab-content">
    @can($opciones[0]->opciones_funcion)
    <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active" role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="card">
                    <div class="row m-1">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1 d-flex align-items-center justify-content-center">
                            <h6 class="m-0 me-5 text-primary">REPORTE DE VENTAS</h6>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{route('reporte.reporte_de_ventas')}}" method="post">
                @csrf
                <input type="hidden" name="enviar" value="1">
                <input type="hidden" name="id_cliente_filtro" id="id_cliente_filtro" value="{{$id_cliente_filtro}}">

                <div class="row">
                    {{-- Columna izquierda: período --}}
                    <div class="col-lg-2 col-md-3 col-sm-12 mb-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                        <input onclick="cambiar_fec_general()" type="radio" name="opcion" id="diario" value="d" {{$check == 'd' ? 'checked' : ''}}>
                                        <label for="diario">Diario</label>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                        <input onclick="cambiar_fec_general()" type="radio" name="opcion" id="semanal" value="s" {{$check == 's' ? 'checked' : ''}}>
                                        <label for="semanal">Semanal</label>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                        <input onclick="cambiar_fec_general()" type="radio" name="opcion" id="quincenal" value="q" {{$check == 'q' ? 'checked' : ''}}>
                                        <label for="quincenal">Quincenal</label>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                        <input onclick="cambiar_fec_general()" type="radio" name="opcion" id="mensual" value="m" {{$check == 'm' ? 'checked' : ''}}>
                                        <label for="mensual">Mensual</label>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                        <input onclick="cambiar_fec_general()" type="radio" name="opcion" id="trimestral" value="tri" {{$check == 'tri' ? 'checked' : ''}}>
                                        <label for="trimestral">Trimestral</label>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                        <input onclick="cambiar_fec_general()" type="radio" name="opcion" id="semestral" value="sem" {{$check == 'sem' ? 'checked' : ''}}>
                                        <label for="semestral">Semestral</label>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                        <input onclick="cambiar_fec_general()" type="radio" name="opcion" id="anual" value="a" {{$check == 'a' ? 'checked' : ''}}>
                                        <label for="anual">Anual</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Columna derecha: filtros + resultados --}}
                    <div class="col-lg-10 col-md-9 col-sm-12 mb-2">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="row g-2 align-items-end">

                                    {{-- Fechas --}}
                                    <div class="col-lg-2 col-md-4 col-sm-12">
                                        <small class="col-form-label">Fecha Inicio:</small>
                                        <input type="date" id="desde" class="form-control" name="desde" value="{{$fecha_inicio}}">
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-12">
                                        <small class="col-form-label">Fecha Fin:</small>
                                        <input type="date" id="hasta" name="hasta" class="form-control" value="{{$fecha_fin}}">
                                    </div>

                                    {{-- Buscador de cliente --}}
                                    <div class="col-lg-5 col-md-8 col-sm-12">
                                        <small class="col-form-label">Filtrar por cliente <span class="text-muted">(opcional)</span>:</small>
                                        <div class="position-relative">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                                                <input type="text" id="buscador_cliente_reporte"
                                                       class="form-control"
                                                       placeholder="Buscar por nombre o N° documento..."
                                                       autocomplete="off"
                                                       value="@if($cliente_seleccionado){{ $cliente_seleccionado->id_tipo_documento == 4 ? $cliente_seleccionado->cliente_razonsocial : $cliente_seleccionado->cliente_nombre }} — {{ $cliente_seleccionado->cliente_numero }}@endif">
                                                @if($cliente_seleccionado)
                                                    <button type="button" class="btn btn-outline-secondary" id="btn_limpiar_cliente" title="Quitar filtro de cliente">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <div id="dropdown_clientes_reporte"
                                                 class="list-group shadow"
                                                 style="position:absolute;z-index:9999;width:100%;display:none;max-height:220px;overflow-y:auto">
                                            </div>
                                        </div>
                                        @if($cliente_seleccionado)
                                            <span class="badge bg-primary mt-1">
                                                <i class="fa fa-user me-1"></i>
                                                {{ $cliente_seleccionado->id_tipo_documento == 4 ? $cliente_seleccionado->cliente_razonsocial : $cliente_seleccionado->cliente_nombre }}
                                                — {{ $cliente_seleccionado->cliente_numero }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Botón buscar --}}
                                    <div class="col-lg-2 col-md-4 col-sm-12">
                                        <button id="btn_search_data" type="submit" class="btn btn-info w-100 mt-3">
                                            <i class="bx bx-search-alt"></i> Buscar
                                        </button>
                                    </div>
                                    @if(isset($fechas) && count($fechas) > 0 || $ventas_cliente !== null)
                                    <div class="col-lg-auto col-sm-12">
                                        <a href="{{ route('reporte.reporte_ventas_excel') }}?desde={{$fecha_inicio}}&hasta={{$fecha_fin}}@if($id_cliente_filtro)&id_cliente={{$id_cliente_filtro}}@endif"
                                           class="btn btn-success w-100 mt-3" target="_blank">
                                            <i class="fa fa-file-excel"></i> Excel
                                        </a>
                                    </div>
                                    <div class="col-lg-auto col-sm-12">
                                        <a href="{{ route('reporte.reporte_ventas_pdf') }}?desde={{$fecha_inicio}}&hasta={{$fecha_fin}}@if($id_cliente_filtro)&id_cliente={{$id_cliente_filtro}}@endif"
                                           class="btn btn-danger w-100 mt-3" target="_blank">
                                            <i class="fa fa-file-pdf"></i> PDF
                                        </a>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        {{-- ── Resultado: reporte por CLIENTE ─────────────────────── --}}
                        @if($ventas_cliente !== null)
                            <div class="card mt-2">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <span class="fw-semibold">
                                        Ventas de:
                                        <span class="text-primary">
                                            {{ $cliente_seleccionado->id_tipo_documento == 4
                                                ? $cliente_seleccionado->cliente_razonsocial
                                                : $cliente_seleccionado->cliente_nombre }}
                                        </span>
                                        <small class="text-muted ms-1">{{ $cliente_seleccionado->cliente_numero }}</small>
                                    </span>
                                    <span class="badge bg-secondary">
                                        {{ count($ventas_cliente) }} venta(s)
                                        &nbsp;|&nbsp;
                                        Total: S/ {{ number_format($ventas_cliente->sum('venta_total'), 2) }}
                                    </span>
                                </div>
                                <div class="card-body p-0">
                                    @if(count($ventas_cliente) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0" id="tablaVentasCliente">
                                                <thead>
                                                    <tr class="encabezado_tabla_color">
                                                        <th>#</th>
                                                        <th>Fecha</th>
                                                        <th>Comprobante</th>
                                                        <th>Tipo pago</th>
                                                        <th>Subtotal</th>
                                                        <th>Descuento</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $n = 1; @endphp
                                                    @foreach($ventas_cliente as $v)
                                                        <tr>
                                                            <td>{{ $n }}</td>
                                                            <td>{{ date('d/m/Y', strtotime($v->venta_fecha)) }}</td>
                                                            <td>
                                                                <span class="badge {{ $v->venta_tipo == '01' ? 'bg-primary' : 'bg-info' }}">
                                                                    {{ $v->venta_tipo == '01' ? 'Factura' : ($v->venta_tipo == '03' ? 'Boleta' : $v->venta_tipo) }}
                                                                </span>
                                                                {{ $v->venta_serie }}-{{ str_pad($v->venta_correlativo, 8, '0', STR_PAD_LEFT) }}
                                                            </td>
                                                            <td>{{ $v->venta_pago_tipo ?? '—' }}</td>
                                                            <td>S/ {{ number_format($v->venta_total + $v->venta_totaldescuento, 2) }}</td>
                                                            <td class="text-danger">
                                                                @if($v->venta_totaldescuento > 0)
                                                                    -S/ {{ number_format($v->venta_totaldescuento, 2) }}
                                                                    <small class="text-muted">({{ number_format($v->venta_descuento_global, 1) }}%)</small>
                                                                @else
                                                                    —
                                                                @endif
                                                            </td>
                                                            <td class="fw-semibold">S/ {{ number_format($v->venta_total, 2) }}</td>
                                                        </tr>
                                                        @php $n++; @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4 text-muted">
                                            <i class="fa fa-inbox fa-2x mb-2"></i><br>
                                            No hay ventas para este cliente en el período seleccionado.
                                        </div>
                                    @endif
                                </div>
                            </div>

                        {{-- ── Resultado: reporte general por día ──────────────────── --}}
                        @elseif(count($fechas) > 0)
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="tablaVentas">
                                                    <thead>
                                                        <tr class="encabezado_tabla_color">
                                                            <th>#</th>
                                                            <th>Día</th>
                                                            <th>Cantidad de ventas</th>
                                                            <th>Total de ventas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $a = 1; @endphp
                                                        @foreach($fechas as $f)
                                                            <tr>
                                                                <th>{{$a}}</th>
                                                                <th>{{date('d-m-Y', strtotime($f['dia']))}}</th>
                                                                <th>{{ $f['ConteoVentas'] }}</th>
                                                                <th>S/ {{ $f['sumVentas'] }}</th>
                                                            </tr>
                                                            @php $a++; @endphp
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>{{-- fin col-lg-10 --}}

                    @if($ventas_cliente === null)
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                            <div class="card" id="chartVentas"></div>
                        </div>
                    @endif

                </div>{{-- fin .row --}}
            </form>
        </div>
    </div>
    @endcan
</div>

<script src="{{asset('js/domain.js')}}"></script>
<script src="{{asset('js/reporte.js')}}"></script>
<script src="{{asset('apexcharts/dist/apexcharts.min.js')}}"></script>
<script>
$(document).ready(function () {
    @if($ventas_cliente === null && count($fechas) > 0)
        $('#tablaVentas').DataTable({ paging: false, info: false, searching: true });
    @endif
    @if($ventas_cliente !== null && count($ventas_cliente) > 0)
        $('#tablaVentasCliente').DataTable({ paging: false, info: false, searching: true });
    @endif

    // ── Buscador de clientes ──────────────────────────────────────────
    let timer;
    $('#buscador_cliente_reporte').on('input', function () {
        clearTimeout(timer);
        let q = $(this).val().trim();
        if (q.length < 2) {
            $('#dropdown_clientes_reporte').hide().empty();
            return;
        }
        timer = setTimeout(function () {
            $.getJSON('{{ route("reporte.buscar_clientes_reporte") }}', { q: q }, function (data) {
                let html = '';
                if (data.length > 0) {
                    data.forEach(function (c) {
                        let nombre = c.id_tipo_documento == 4 ? c.cliente_razonsocial : c.cliente_nombre;
                        html += `<a href="#" class="list-group-item list-group-item-action py-2 seleccionar_cliente_reporte"
                                    data-id="${c.id_clientes}"
                                    data-nombre="${nombre}"
                                    data-numero="${c.cliente_numero}">
                                    <span class="fw-semibold">${nombre}</span>
                                    <small class="text-muted ms-2">${c.cliente_numero}</small>
                                 </a>`;
                    });
                } else {
                    html = '<div class="list-group-item text-muted">Sin resultados</div>';
                }
                $('#dropdown_clientes_reporte').html(html).show();
            });
        }, 300);
    });

    // Seleccionar un cliente del dropdown
    $(document).on('click', '.seleccionar_cliente_reporte', function (e) {
        e.preventDefault();
        let id     = $(this).data('id');
        let nombre = $(this).data('nombre');
        let numero = $(this).data('numero');
        $('#id_cliente_filtro').val(id);
        $('#buscador_cliente_reporte').val(nombre + ' — ' + numero);
        $('#dropdown_clientes_reporte').hide().empty();
    });

    // Limpiar filtro de cliente
    $('#btn_limpiar_cliente').on('click', function () {
        $('#id_cliente_filtro').val('');
        $('#buscador_cliente_reporte').val('');
        $('#dropdown_clientes_reporte').hide().empty();
    });

    // Cerrar dropdown al hacer clic fuera
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#buscador_cliente_reporte, #dropdown_clientes_reporte').length) {
            $('#dropdown_clientes_reporte').hide();
        }
    });
});

@if($ventas_cliente === null)
var options = {
    series: [{ name: "Ventas", data: <?= json_encode($fechasVent) ?> }],
    chart: { height: 350, type: 'line', zoom: { enabled: true, type: 'x' } },
    dataLabels: { enabled: false },
    stroke: { curve: 'straight' },
    title: { text: 'Lista de ventas', align: 'left' },
    grid: { row: { colors: ['#f3f3f3', 'transparent'], opacity: 0.5 } },
    xaxis: { categories: <?= json_encode($sumast) ?> }
};
var chart = new ApexCharts(document.querySelector("#chartVentas"), options);
chart.render();
@endif
</script>
@endsection
