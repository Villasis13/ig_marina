@extends('layouts.plantilla')
@section('content')
    @php
        $horaActual = \Carbon\Carbon::now()->format('H');
        $rangoManana = [6, 12];
        $rangoTarde = [12, 18];
        if ($horaActual >= $rangoManana[0] && $horaActual < $rangoManana[1]) {
            $mensaje = 'Buenos días';
        } elseif ($horaActual >= $rangoTarde[0] && $horaActual < $rangoTarde[1]) {
            $mensaje = 'Buenas tardes';
        } else {
            $mensaje = 'Buenas noches';
        }
    @endphp
    @php
        $rolId = \Illuminate\Support\Facades\Auth::user()->roles->first()->id ?? null
    @endphp

    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                            <h4 style="font-family:Inter, Courier, monospace">{{$mensaje}},
                                @if(Session::has('persona'))
                                    <span class="fw-800 negroSubtext text-primary">{{ Session::get('persona') }} !</span>
                                @endif
                            </h4>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                            <p class="descripcionText">Estadísticas del mes de <span class="negroSubtext fw-800">{{$nombreMes}}</span></p>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <a href="#">
                                <div class="card h-100" style="background: #0b1892">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <small class="subtext text-white">Compras</small>
                                                        <h4 class="mt-2 fw-800 negroSubtext text-white">{{$compras_mes}}</h4>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center h-100" style="font-size: 30pt">
                                                        <i class="fa-regular fa-rectangle-list text-white"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <a href="#">
                                <div class="card h-100" style="background: #2257f1">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <small class="subtext text-white">Clientes</small>
                                                        <h4 class="mt-2 fw-800 negroSubtext text-white">{{$clientes}}</h4>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center h-100" style="font-size: 30pt">
                                                        <i class="fa-solid fa-users text-white"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @if($rolId != 3)
                            <div class="col-lg-4 col-md-12 col-sm-12 mb-4">
                                <a href="">
                                    <div class="card h-100" style="background: #1eb521">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <small class="subtext text-white">Ventas</small>
                                                            <h4 class="mt-2 fw-800 negroSubtext text-white">S/ {{$ventas_mes}}</h4>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-center h-100" style="font-size: 30pt">
                                                            <i class="fa-solid fa-money-bill-trend-up text-white"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 col-sm-12 mb-4">
            <div class="row h-100">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @if(empty($apertura))
                        <form id="aperturar_caja_formulario" class="h-100" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h5 class="text-primary fw-bold"><i class="fa-solid fa-cash-register"></i> CAJA DEL DÍA</h5>
                                            <hr>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between">
                                            <label for="id_caja_inicio" class="text-dark fw-800">CAJA</label>
                                            <select name="id_caja_inicio" id="id_caja_inicio" class="form-control w-50" style="background:#ecf0f6">
                                                @foreach($caja as $c)
                                                    <option value="{{$c->id_caja_numero}}">{{$c->caja_numero_nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 mt-3 d-flex align-items-center justify-content-between">
                                            <label class="text-dark fw-800" for="monto_apertura">MONTO</label>
                                            <input type="text" class="form-control w-50" onkeyup="validar_numeros(this.id)" style="background:#ecf0f6" id="monto_apertura" name="monto_apertura">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                            <button class="btn bg-primary text-white w-100" type="submit" id="btn_aperturar_caja"><i class="fa fa-save"></i> Aperturar Caja</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <form id="cierre_caja_formulario" class="h-100" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h5 class="text-primary fw-bold"><i class="fa-solid fa-cash-register"></i> {{$apertura->caja_numero_nombre}} - S/ {{$apertura->caja_apertura}}</h5>
                                            <hr>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between mb-3">
                                            <span>Usuario:</span>
                                            <label class="w-50">{{$apertura->persona_nombre}}</label>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-between mb-3">
                                            <span>Cierre de Caja:</span>
                                            <input type="hidden" name="id_caja" id="id_caja" class="w-50" value="{{$apertura->id_caja}}">
                                            <input type="text" class="form-control w-50" onkeyup="validar_numeros(this.id)" style="background:#ecf0f6" id="monto_cierre" name="monto_cierre">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <button class="btn bg-primary text-white w-100" type="submit" id="btn_cierre_caja"><i class="fa fa-save"></i> Guardar Cierre</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        @if($rolId != 3)
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body" id="charteder">
                    </div>
                </div>
            </div>
        @endif

        @if(count($productos_stock_bajo) > 0)
        <div class="col-lg-12 col-md-12 col-sm-12 mt-2 mb-4">
            <div class="card" style="border:1px solid #dc3545">
                <div class="card-header d-flex align-items-center justify-content-between" style="background:#fff3cd">
                    <h5 class="mb-0 text-danger fw-bold">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        ALERTAS DE STOCK BAJO &nbsp;<span class="badge bg-danger">{{count($productos_stock_bajo)}}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-danger">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th class="text-center">Stock Actual</th>
                                    <th class="text-center">Stock Mínimo</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos_stock_bajo as $p)
                                <tr>
                                    <td><code>{{$p->pro_codigo}}</code></td>
                                    <td>{{$p->pro_nombre}}</td>
                                    <td class="text-center fw-bold {{$p->pro_stock == 0 ? 'text-danger' : 'text-warning'}}">{{$p->pro_stock}}</td>
                                    <td class="text-center">{{$p->stock_minimo}}</td>
                                    <td class="text-center">
                                        @if($p->pro_stock == 0)
                                            <span class="badge bg-danger">SIN STOCK</span>
                                        @else
                                            <span class="badge bg-warning text-dark">STOCK BAJO</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(count($lotes_por_vencer) > 0)
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card" style="border:1px solid #fd7e14">
                <div class="card-header d-flex align-items-center justify-content-between" style="background:#fff3cd">
                    <h5 class="mb-0 fw-bold" style="color:#fd7e14">
                        <i class="fa-solid fa-clock"></i>
                        LOTES PRÓXIMOS A VENCER (30 días) &nbsp;<span class="badge" style="background:#fd7e14">{{count($lotes_por_vencer)}}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead style="background:#ffeeba">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>N° Lote</th>
                                    <th class="text-center">Vence</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lotes_por_vencer as $l)
                                @php $dias = \Carbon\Carbon::now()->diffInDays($l->fecha_vencimiento, false); @endphp
                                <tr>
                                    <td><code>{{$l->pro_codigo}}</code></td>
                                    <td>{{$l->pro_nombre}}</td>
                                    <td>{{$l->numero_lote}}</td>
                                    <td class="text-center">{{$l->fecha_vencimiento}}</td>
                                    <td class="text-center fw-bold">{{$l->cantidad}}</td>
                                    <td class="text-center">
                                        @if($dias <= 0)
                                            <span class="badge bg-danger">VENCIDO</span>
                                        @elseif($dias <= 7)
                                            <span class="badge bg-danger">{{$dias}} días</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{$dias}} días</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

    <style>
        .descripcionText { font-size: 16px; color: #9e9ea7; font-weight: 400; }
        .subtext { font-size: 16px; color: #000000; font-weight: 500; font-family: Inter, Courier, monospace; }
        .fw-800 { font-weight: 800; }
        .negroSubtext { color: #0b1892; }
    </style>

    @if($rolId != 3)
        <script src="{{asset('apexcharts/dist/apexcharts.min.js')}}"></script>
        <script src="{{asset('js/moment.js')}}"></script>
        <script>
            let sumarDIas = <?= json_encode($suma_ventas_30dias) ?>;
            let dias30 = <?= json_encode($dia_30dias) ?>;
            let optionseder = {
                series: [{
                    name: 'Cantidad de ventas',
                    type: 'column',
                    data: sumarDIas
                }],
                chart: { height: 350, type: 'line' },
                stroke: { width: [0, 4] },
                title: { text: 'Últimas Ventas' },
                dataLabels: { enabled: true, enabledOnSeries: [1] },
                labels: dias30,
                xaxis: { type: 'text' }
            };
            var charteder = new ApexCharts(document.getElementById("charteder"), optionseder);
            charteder.render();
        </script>
    @endif
@endsection
