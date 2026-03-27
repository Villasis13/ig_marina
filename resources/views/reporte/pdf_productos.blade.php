<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Productos</title>
<style>
  body{font-family:Arial,sans-serif;font-size:11px;margin:20px}
  h2{color:#0b1892;text-align:center;margin-bottom:4px}
  p.periodo{text-align:center;color:#555;margin-bottom:16px}
  table{width:100%;border-collapse:collapse}
  th{background:#0b1892;color:#fff;padding:5px 6px;text-align:left}
  td{padding:4px 6px;border-bottom:1px solid #ddd}
  tr:nth-child(even) td{background:#f5f7ff}
  @media print{button{display:none}}
</style>
</head>
<body>
<h2>REPORTE DE PRODUCTOS</h2>
<p class="periodo">Del {{ date('d/m/Y',strtotime($fi)) }} al {{ date('d/m/Y',strtotime($ff)) }}</p>
<button onclick="window.print()" style="float:right;margin-bottom:10px;padding:6px 14px;background:#0b1892;color:#fff;border:none;border-radius:4px;cursor:pointer">Imprimir / Guardar PDF</button>
<table>
  <thead><tr><th>#</th><th>Código</th><th>Producto</th><th>Stock</th><th>P.Minorista</th><th>P.Mayorista</th><th>Ventas período</th></tr></thead>
  <tbody>
    @php $n=1; @endphp
    @foreach($productos as $p)
    <tr><td>{{$n++}}</td><td>{{$p->pro_codigo??'—'}}</td><td>{{$p->pro_nombre}}</td><td>{{$p->pro_stock}}</td><td>S/ {{number_format($p->pro_precio_uni,2)}}</td><td>S/ {{number_format($p->pro_precio_uni_ma,2)}}</td><td>{{$p->mas_vendidos}}</td></tr>
    @endforeach
  </tbody>
</table>
</body>
</html>
