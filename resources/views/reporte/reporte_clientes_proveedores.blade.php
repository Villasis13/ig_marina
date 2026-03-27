@extends('layouts.plantilla')
@section('content')
<div class="tab-content">
    <div class="tab-pane fade show active">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="row m-3">
                    <div class="col-lg-12 text-center">
                        <h6 class="m-0 text-primary">REPORTE DE CLIENTES Y PROVEEDORES</h6>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('reporte.reporte_clientes_proveedores') }}" method="POST">
            @csrf
            <input type="hidden" name="enviar" value="1">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-12 mb-2">
                    <div class="card">
                        <div class="card-body">
                            @foreach([['d','Diario'],['s','Semanal'],['q','Quincenal'],['m','Mensual'],['tri','Trimestral'],['sem','Semestral'],['a','Anual']] as $op)
                            <div class="mb-2">
                                <input onclick="cambiar_fec_general()" type="radio" name="opcion" id="op_{{$op[0]}}" value="{{$op[0]}}" {{$check==$op[0]?'checked':''}}>
                                <label for="op_{{$op[0]}}">{{$op[1]}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-10 col-md-9 col-sm-12 mb-2">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row g-2 align-items-end">
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <label>Fecha Inicio:</label>
                                    <input type="date" class="form-control" name="desde" id="desde" value="{{$fecha_inicio}}">
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <label>Fecha Fin:</label>
                                    <input type="date" class="form-control" name="hasta" id="hasta" value="{{$fecha_fin}}">
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-12">
                                    <button type="submit" class="btn btn-info w-100 mt-3"><i class="bx bx-search-alt"></i> Buscar</button>
                                </div>
                                @if($buscado)
                                <div class="col-lg-2 col-md-3 col-sm-12">
                                    <a href="{{ route('reporte.reporte_clientes_proveedores_excel') }}?desde={{$fecha_inicio}}&hasta={{$fecha_fin}}" class="btn btn-success w-100 mt-3" target="_blank"><i class="fa fa-file-excel"></i> Excel</a>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-12">
                                    <a href="{{ route('reporte.reporte_clientes_proveedores_pdf') }}?desde={{$fecha_inicio}}&hasta={{$fecha_fin}}" class="btn btn-danger w-100 mt-3" target="_blank"><i class="fa fa-file-pdf"></i> PDF</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($buscado)
                    <ul class="nav nav-tabs" id="tabsCP">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab_clientes">Clientes ({{count($clientes)}})</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab_proveedores">Proveedores ({{count($proveedores)}})</a></li>
                    </ul>
                    <div class="tab-content border border-top-0 p-3 bg-white">

                        {{-- Clientes --}}
                        <div id="tab_clientes" class="tab-pane fade show active">
                            @if(count($clientes) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="tbl_clientes">
                                    <thead>
                                        <tr class="encabezado_tabla_color">
                                            <th>#</th><th>N° Documento</th><th>Nombre / Razón Social</th><th>Dirección</th><th>Trans. históricas</th><th>Total período S/</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $n=1; @endphp
                                        @foreach($clientes as $c)
                                        @php $nombre = $c->id_tipo_documento == 4 ? $c->cliente_razonsocial : $c->cliente_nombre; @endphp
                                        <tr>
                                            <td>{{$n++}}</td>
                                            <td>{{$c->cliente_numero}}</td>
                                            <td>{{$nombre}}</td>
                                            <td>{{$c->cliente_direccion ?? '—'}}</td>
                                            <td><span class="badge bg-secondary">{{$c->total_transacciones}}</span></td>
                                            <td class="fw-semibold">S/ {{number_format($c->total_compras,2)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="fw-bold">
                                            <td colspan="5" class="text-end">TOTAL PERÍODO:</td>
                                            <td>S/ {{number_format($clientes->sum('total_compras'),2)}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @else <div class="text-center py-4 text-muted">Sin clientes registrados.</div> @endif
                        </div>

                        {{-- Proveedores --}}
                        <div id="tab_proveedores" class="tab-pane fade">
                            @if(count($proveedores) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="tbl_proveedores">
                                    <thead>
                                        <tr class="encabezado_tabla_color">
                                            <th>#</th><th>N° Documento</th><th>Proveedor</th><th>Teléfono</th><th>Órdenes período</th><th>Total período S/</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $n=1; @endphp
                                        @foreach($proveedores as $p)
                                        <tr>
                                            <td>{{$n++}}</td>
                                            <td>{{$p->proveedores_numero_documento ?? '—'}}</td>
                                            <td>{{$p->proveedores_nombre}}</td>
                                            <td>{{$p->proveedores_telefono ?? '—'}}</td>
                                            <td><span class="badge bg-secondary">{{$p->total_ordenes}}</span></td>
                                            <td class="fw-semibold">S/ {{number_format($p->total_compras,2)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="fw-bold">
                                            <td colspan="5" class="text-end">TOTAL PERÍODO:</td>
                                            <td>S/ {{number_format($proveedores->sum('total_compras'),2)}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @else <div class="text-center py-4 text-muted">Sin proveedores registrados.</div> @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{asset('js/domain.js')}}"></script>
<script src="{{asset('js/reporte.js')}}"></script>
<script>
$(document).ready(function(){
    @if($buscado && count($clientes) > 0) $('#tbl_clientes').DataTable({paging:false,info:false,searching:true}); @endif
    @if($buscado && count($proveedores) > 0) $('#tbl_proveedores').DataTable({paging:false,info:false,searching:true}); @endif
});
</script>
@endsection
