<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Inventario</title>
<style>
  body{font-family:Arial,sans-serif;font-size:11px;margin:20px}
  h2{color:#0b1892;text-align:center;margin-bottom:4px}
  p.periodo{text-align:center;color:#555;margin-bottom:16px}
  h3{color:#0b1892;margin-top:20px;margin-bottom:6px;border-bottom:2px solid #0b1892;padding-bottom:3px}
  table{width:100%;border-collapse:collapse;margin-bottom:16px}
  th{background:#0b1892;color:#fff;padding:5px 6px;text-align:left}
  td{padding:4px 6px;border-bottom:1px solid #ddd}
  tr:nth-child(even) td{background:#f5f7ff}
  tfoot td{font-weight:bold;background:#e8ecff;border-top:2px solid #0b1892}
  @media print{button{display:none}}
</style>
</head>
<body>
<h2>REPORTE DE INVENTARIO</h2>
<p class="periodo">Del {{ date('d/m/Y',strtotime($fecha_inicio)) }} al {{ date('d/m/Y',strtotime($fecha_fin)) }}</p>
<button onclick="window.print()" style="float:right;margin-bottom:10px;padding:6px 14px;background:#0b1892;color:#fff;border:none;border-radius:4px;cursor:pointer">Imprimir / Guardar PDF</button>

<h3>Stock Actual</h3>
<table>
  <thead><tr><th>#</th><th>Código</th><th>Producto</th><th>Stock</th><th>P.Unitario</th><th>Valor Total</th></tr></thead>
  <tbody>
    @php $n=1; $valorTotal=0; @endphp
    @foreach($stock as $p)
    @php $valorTotal += $p->pro_stock * $p->pro_precio_uni; @endphp
    <tr><td>{{$n++}}</td><td>{{$p->pro_codigo??'—'}}</td><td>{{$p->pro_nombre}}</td><td>{{$p->pro_stock}}</td><td>S/ {{number_format($p->pro_precio_uni,2)}}</td><td>S/ {{number_format($p->pro_stock*$p->pro_precio_uni,2)}}</td></tr>
    @endforeach
  </tbody>
  <tfoot><tr><td colspan="5" style="text-align:right">VALOR TOTAL:</td><td>S/ {{number_format($valorTotal,2)}}</td></tr></tfoot>
</table>

<h3>Productos Vendidos en el Período</h3>
<table>
  <thead><tr><th>#</th><th>Código</th><th>Producto</th><th>Cantidad</th><th>Total S/</th></tr></thead>
  <tbody>
    @php $n=1; @endphp
    @foreach($vendidos as $v)
    <tr><td>{{$n++}}</td><td>{{$v->pro_codigo??'—'}}</td><td>{{$v->pro_nombre}}</td><td>{{$v->total_cantidad}}</td><td>S/ {{number_format($v->total_importe,2)}}</td></tr>
    @endforeach
    @if(count($vendidos)==0)<tr><td colspan="5" style="text-align:center;color:#888">Sin ventas en el período</td></tr>@endif
  </tbody>
  @if(count($vendidos)>0)<tfoot><tr><td colspan="4" style="text-align:right">TOTAL:</td><td>S/ {{number_format($vendidos->sum('total_importe'),2)}}</td></tr></tfoot>@endif
</table>

<h3>Entradas de Inventario (Compras)</h3>
<table>
  <thead><tr><th>#</th><th>Fecha</th><th>Proveedor</th><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Total</th></tr></thead>
  <tbody>
    @php $n=1; @endphp
    @foreach($entradas as $e)
    <tr><td>{{$n++}}</td><td>{{date('d/m/Y',strtotime($e->orden_compra_fecha))}}</td><td>{{$e->proveedores_nombre}}</td><td>{{$e->pro_nombre}}</td><td>{{$e->detalle_compra_cantidad}}</td><td>S/ {{number_format($e->detalle_compra_precio_compra,2)}}</td><td>S/ {{number_format($e->detalle_compra_total_pedido,2)}}</td></tr>
    @endforeach
    @if(count($entradas)==0)<tr><td colspan="7" style="text-align:center;color:#888">Sin entradas en el período</td></tr>@endif
  </tbody>
  @if(count($entradas)>0)<tfoot><tr><td colspan="6" style="text-align:right">TOTAL:</td><td>S/ {{number_format($entradas->sum('detalle_compra_total_pedido'),2)}}</td></tr></tfoot>@endif
</table>

<h3>Salidas de Inventario (Ventas)</h3>
<table>
  <thead><tr><th>#</th><th>Fecha</th><th>Cliente</th><th>Comprobante</th><th>Producto</th><th>Cantidad</th><th>Total S/</th></tr></thead>
  <tbody>
    @php $n=1; @endphp
    @foreach($salidas as $s)
    @php $tipo=$s->venta_tipo=='01'?'F':'B'; $comp=$tipo.' '.$s->venta_serie.'-'.str_pad($s->venta_correlativo,8,'0',STR_PAD_LEFT); @endphp
    <tr><td>{{$n++}}</td><td>{{date('d/m/Y',strtotime($s->venta_fecha))}}</td><td>{{$s->cliente_nombre}}</td><td>{{$comp}}</td><td>{{$s->pro_nombre}}</td><td>{{$s->venta_detalle_cantidad}}</td><td>S/ {{number_format($s->venta_detalle_importe_total,2)}}</td></tr>
    @endforeach
    @if(count($salidas)==0)<tr><td colspan="7" style="text-align:center;color:#888">Sin salidas en el período</td></tr>@endif
  </tbody>
  @if(count($salidas)>0)<tfoot><tr><td colspan="6" style="text-align:right">TOTAL:</td><td>S/ {{number_format($salidas->sum('venta_detalle_importe_total'),2)}}</td></tr></tfoot>@endif
</table>
</body>
</html>
