@extends('layouts.plantilla')
@section('content')
<div class="tab-content">
    <div class="tab-pane fade show active">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="row m-3">
                    <div class="col-lg-12 text-center">
                        <h6 class="m-0 text-primary">REPORTE DE INVENTARIO</h6>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('reporte.reporte_inventario') }}" method="POST">
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
                                    <a href="{{ route('reporte.reporte_inventario_excel') }}?desde={{$fecha_inicio}}&hasta={{$fecha_fin}}" class="btn btn-success w-100 mt-3" target="_blank"><i class="fa fa-file-excel"></i> Excel</a>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-12">
                                    <a href="{{ route('reporte.reporte_inventario_pdf') }}?desde={{$fecha_inicio}}&hasta={{$fecha_fin}}" class="btn btn-danger w-100 mt-3" target="_blank"><i class="fa fa-file-pdf"></i> PDF</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($buscado)
                    <ul class="nav nav-tabs" id="tabsInventario">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab_stock">Stock Actual ({{count($stock)}})</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab_vendidos">Vendidos ({{count($vendidos)}})</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab_entradas">Entradas ({{count($entradas)}})</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab_salidas">Salidas ({{count($salidas)}})</a></li>
                    </ul>
                    <div class="tab-content border border-top-0 p-3 bg-white">

                        {{-- Stock Actual --}}
                        <div id="tab_stock" class="tab-pane fade show active">
                            @if(count($stock) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="tbl_stock">
                                    <thead><tr class="encabezado_tabla_color"><th>#</th><th>Código</th><th>Producto</th><th>Stock</th><th>P. Unitario</th><th>Valor Total</th></tr></thead>
                                    <tbody>
                                        @php $n=1; $valorTotal=0; @endphp
                                        @foreach($stock as $p)
                                        @php $valorTotal += $p->pro_stock * $p->pro_precio_uni; @endphp
                                        <tr>
                                            <td>{{$n++}}</td>
                                            <td>{{$p->pro_codigo ?? '—'}}</td>
                                            <td>{{$p->pro_nombre}}</td>
                                            <td><span class="badge {{$p->pro_stock > 0 ? 'bg-success' : 'bg-danger'}}">{{$p->pro_stock}}</span></td>
                                            <td>S/ {{number_format($p->pro_precio_uni,2)}}</td>
                                            <td>S/ {{number_format($p->pro_stock * $p->pro_precio_uni,2)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot><tr class="fw-bold"><td colspan="5" class="text-end">VALOR TOTAL INVENTARIO:</td><td>S/ {{number_format($valorTotal,2)}}</td></tr></tfoot>
                                </table>
                            </div>
                            @else <div class="text-center py-4 text-muted">Sin productos en stock.</div> @endif
                        </div>

                        {{-- Vendidos --}}
                        <div id="tab_vendidos" class="tab-pane fade">
                            @if(count($vendidos) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="tbl_vendidos">
                                    <thead><tr class="encabezado_tabla_color"><th>#</th><th>Código</th><th>Producto</th><th>Cantidad Vendida</th><th>Total S/</th></tr></thead>
                                    <tbody>
                                        @php $n=1; @endphp
                                        @foreach($vendidos as $v)
                                        <tr><td>{{$n++}}</td><td>{{$v->pro_codigo??'—'}}</td><td>{{$v->pro_nombre}}</td><td>{{$v->total_cantidad}}</td><td>S/ {{number_format($v->total_importe,2)}}</td></tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot><tr class="fw-bold"><td colspan="4" class="text-end">TOTAL:</td><td>S/ {{number_format($vendidos->sum('total_importe'),2)}}</td></tr></tfoot>
                                </table>
                            </div>
                            @else <div class="text-center py-4 text-muted">Sin ventas en el período.</div> @endif
                        </div>

                        {{-- Entradas --}}
                        <div id="tab_entradas" class="tab-pane fade">
                            @if(count($entradas) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="tbl_entradas">
                                    <thead><tr class="encabezado_tabla_color"><th>#</th><th>Fecha</th><th>Proveedor</th><th>Código</th><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Total</th></tr></thead>
                                    <tbody>
                                        @php $n=1; @endphp
                                        @foreach($entradas as $e)
                                        <tr><td>{{$n++}}</td><td>{{date('d/m/Y',strtotime($e->orden_compra_fecha))}}</td><td>{{$e->proveedores_nombre}}</td><td>{{$e->pro_codigo??'—'}}</td><td>{{$e->pro_nombre}}</td><td>{{$e->detalle_compra_cantidad}}</td><td>S/ {{number_format($e->detalle_compra_precio_compra,2)}}</td><td>S/ {{number_format($e->detalle_compra_total_pedido,2)}}</td></tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot><tr class="fw-bold"><td colspan="7" class="text-end">TOTAL:</td><td>S/ {{number_format($entradas->sum('detalle_compra_total_pedido'),2)}}</td></tr></tfoot>
                                </table>
                            </div>
                            @else <div class="text-center py-4 text-muted">Sin entradas en el período.</div> @endif
                        </div>

                        {{-- Salidas --}}
                        <div id="tab_salidas" class="tab-pane fade">
                            @if(count($salidas) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="tbl_salidas">
                                    <thead><tr class="encabezado_tabla_color"><th>#</th><th>Fecha</th><th>Cliente</th><th>Comprobante</th><th>Código</th><th>Producto</th><th>Cantidad</th><th>Total S/</th></tr></thead>
                                    <tbody>
                                        @php $n=1; @endphp
                                        @foreach($salidas as $s)
                                        @php $tipo=$s->venta_tipo=='01'?'Factura':'Boleta'; $comp=$tipo.' '.$s->venta_serie.'-'.str_pad($s->venta_correlativo,8,'0',STR_PAD_LEFT); @endphp
                                        <tr><td>{{$n++}}</td><td>{{date('d/m/Y',strtotime($s->venta_fecha))}}</td><td>{{$s->cliente_nombre}}</td><td>{{$comp}}</td><td>{{$s->pro_codigo??'—'}}</td><td>{{$s->pro_nombre}}</td><td>{{$s->venta_detalle_cantidad}}</td><td>S/ {{number_format($s->venta_detalle_importe_total,2)}}</td></tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot><tr class="fw-bold"><td colspan="7" class="text-end">TOTAL:</td><td>S/ {{number_format($salidas->sum('venta_detalle_importe_total'),2)}}</td></tr></tfoot>
                                </table>
                            </div>
                            @else <div class="text-center py-4 text-muted">Sin salidas en el período.</div> @endif
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
    @if($buscado && count($stock) > 0) $('#tbl_stock').DataTable({paging:false,info:false,searching:true}); @endif
    @if($buscado && count($vendidos) > 0) $('#tbl_vendidos').DataTable({paging:false,info:false,searching:true}); @endif
    @if($buscado && count($entradas) > 0) $('#tbl_entradas').DataTable({paging:false,info:false,searching:true}); @endif
    @if($buscado && count($salidas) > 0) $('#tbl_salidas').DataTable({paging:false,info:false,searching:true}); @endif
});
</script>
@endsection
