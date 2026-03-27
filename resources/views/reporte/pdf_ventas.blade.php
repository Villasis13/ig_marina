<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Ventas</title>
<style>
  body{font-family:Arial,sans-serif;font-size:11px;margin:20px}
  h2{color:#0b1892;text-align:center;margin-bottom:4px}
  p.periodo{text-align:center;color:#555;margin-bottom:16px}
  table{width:100%;border-collapse:collapse;margin-bottom:16px}
  th{background:#0b1892;color:#fff;padding:5px 6px;text-align:left}
  td{padding:4px 6px;border-bottom:1px solid #ddd}
  tr:nth-child(even) td{background:#f5f7ff}
  tfoot td{font-weight:bold;background:#e8ecff;border-top:2px solid #0b1892}
  @media print{button{display:none}}
</style>
</head>
<body>
<h2>REPORTE DE VENTAS</h2>
<p class="periodo">Del {{ date('d/m/Y',strtotime($fi)) }} al {{ date('d/m/Y',strtotime($ff)) }}</p>
<button onclick="window.print()" style="float:right;margin-bottom:10px;padding:6px 14px;background:#0b1892;color:#fff;border:none;border-radius:4px;cursor:pointer">Imprimir / Guardar PDF</button>

@if($ventas_cliente !== null)
  <p><strong>Cliente:</strong> {{ $cliente ? ($cliente->id_tipo_documento==4?$cliente->cliente_razonsocial:$cliente->cliente_nombre) : '' }} — {{ $cliente->cliente_numero ?? '' }}</p>
  <table>
    <thead><tr><th>#</th><th>Fecha</th><th>Comprobante</th><th>Tipo Pago</th><th>Subtotal</th><th>Descuento</th><th>Total S/</th></tr></thead>
    <tbody>
      @php $n=1; @endphp
      @foreach($ventas_cliente as $v)
      @php $tipo=$v->venta_tipo=='01'?'Factura':($v->venta_tipo=='03'?'Boleta':$v->venta_tipo); $comp=$tipo.' '.$v->venta_serie.'-'.str_pad($v->venta_correlativo,8,'0',STR_PAD_LEFT); @endphp
      <tr><td>{{$n++}}</td><td>{{date('d/m/Y',strtotime($v->venta_fecha))}}</td><td>{{$comp}}</td><td>{{$v->venta_pago_tipo??'—'}}</td><td>S/ {{number_format($v->venta_total+$v->venta_totaldescuento,2)}}</td><td>{{$v->venta_totaldescuento>0?'-S/ '.number_format($v->venta_totaldescuento,2):'—'}}</td><td>S/ {{number_format($v->venta_total,2)}}</td></tr>
      @endforeach
    </tbody>
    <tfoot><tr><td colspan="6" style="text-align:right">TOTAL:</td><td>S/ {{number_format($ventas_cliente->sum('venta_total'),2)}}</td></tr></tfoot>
  </table>
@else
  <table>
    <thead><tr><th>#</th><th>Día</th><th>Cantidad de Ventas</th><th>Total S/</th></tr></thead>
    <tbody>
      @php $n=1; $totalG=0; @endphp
      @foreach($fechas as $f)
      @php $totalG+=$f['sumVentas']; @endphp
      <tr><td>{{$n++}}</td><td>{{date('d/m/Y',strtotime($f['dia']))}}</td><td>{{$f['ConteoVentas']}}</td><td>S/ {{number_format($f['sumVentas'],2)}}</td></tr>
      @endforeach
    </tbody>
    <tfoot><tr><td colspan="3" style="text-align:right">TOTAL:</td><td>S/ {{number_format($totalG,2)}}</td></tr></tfoot>
  </table>
@endif
</body>
</html>
