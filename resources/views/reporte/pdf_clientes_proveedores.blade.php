<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte Clientes y Proveedores</title>
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
<h2>REPORTE DE CLIENTES Y PROVEEDORES</h2>
<p class="periodo">Del {{ date('d/m/Y',strtotime($fecha_inicio)) }} al {{ date('d/m/Y',strtotime($fecha_fin)) }}</p>
<button onclick="window.print()" style="float:right;margin-bottom:10px;padding:6px 14px;background:#0b1892;color:#fff;border:none;border-radius:4px;cursor:pointer">Imprimir / Guardar PDF</button>

<h3>Clientes</h3>
<table>
  <thead><tr><th>#</th><th>N° Documento</th><th>Nombre / Razón Social</th><th>Dirección</th><th>Trans. históricas</th><th>Total período S/</th></tr></thead>
  <tbody>
    @php $n=1; @endphp
    @foreach($clientes as $c)
    @php $nombre=$c->id_tipo_documento==4?$c->cliente_razonsocial:$c->cliente_nombre; @endphp
    <tr><td>{{$n++}}</td><td>{{$c->cliente_numero}}</td><td>{{$nombre}}</td><td>{{$c->cliente_direccion??'—'}}</td><td>{{$c->total_transacciones}}</td><td>S/ {{number_format($c->total_compras,2)}}</td></tr>
    @endforeach
    @if(count($clientes)==0)<tr><td colspan="6" style="text-align:center;color:#888">Sin clientes</td></tr>@endif
  </tbody>
  @if(count($clientes)>0)<tfoot><tr><td colspan="5" style="text-align:right">TOTAL PERÍODO:</td><td>S/ {{number_format($clientes->sum('total_compras'),2)}}</td></tr></tfoot>@endif
</table>

<h3>Proveedores</h3>
<table>
  <thead><tr><th>#</th><th>N° Documento</th><th>Proveedor</th><th>Teléfono</th><th>Órdenes período</th><th>Total período S/</th></tr></thead>
  <tbody>
    @php $n=1; @endphp
    @foreach($proveedores as $p)
    <tr><td>{{$n++}}</td><td>{{$p->proveedores_numero_documento??'—'}}</td><td>{{$p->proveedores_nombre}}</td><td>{{$p->proveedores_telefono??'—'}}</td><td>{{$p->total_ordenes}}</td><td>S/ {{number_format($p->total_compras,2)}}</td></tr>
    @endforeach
    @if(count($proveedores)==0)<tr><td colspan="6" style="text-align:center;color:#888">Sin proveedores</td></tr>@endif
  </tbody>
  @if(count($proveedores)>0)<tfoot><tr><td colspan="5" style="text-align:right">TOTAL PERÍODO:</td><td>S/ {{number_format($proveedores->sum('total_compras'),2)}}</td></tr></tfoot>@endif
</table>
</body>
</html>
