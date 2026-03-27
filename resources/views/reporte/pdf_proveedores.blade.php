<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Proveedores</title>
<style>
  body{font-family:Arial,sans-serif;font-size:11px;margin:20px}
  h2{color:#0b1892;text-align:center;margin-bottom:4px}
  p.periodo{text-align:center;color:#555;margin-bottom:16px}
  .prov-card{border:1px solid #0b1892;border-radius:6px;margin-bottom:14px;padding:10px}
  .prov-header{background:#0b1892;color:#fff;padding:6px 10px;border-radius:4px;margin-bottom:8px;font-weight:bold}
  table{width:100%;border-collapse:collapse}
  th{background:#3a5aba;color:#fff;padding:4px 6px;text-align:left}
  td{padding:3px 6px;border-bottom:1px solid #ddd}
  @media print{button{display:none}}
</style>
</head>
<body>
<h2>REPORTE DE PROVEEDORES</h2>
<p class="periodo">Del {{ date('d/m/Y',strtotime($fi)) }} al {{ date('d/m/Y',strtotime($ff)) }}</p>
<button onclick="window.print()" style="float:right;margin-bottom:10px;padding:6px 14px;background:#0b1892;color:#fff;border:none;border-radius:4px;cursor:pointer">Imprimir / Guardar PDF</button>

@foreach($proveedores as $prov)
@if(count($prov->productos) > 0)
<div class="prov-card">
  <div class="prov-header">{{ $prov->proveedores_nombre }} — {{ $prov->proveedores_numero_documento ?? '' }} &nbsp;|&nbsp; Tel: {{ $prov->proveedores_telefono ?? '—' }}</div>
  <table>
    <thead><tr><th>Producto</th><th>Último precio</th></tr></thead>
    <tbody>
      @foreach($prov->productos as $pr)
      <tr>
        <td>{{ $pr->pro_nombre }}</td>
        <td>{{ $pr->ultimo_precio ? 'S/ '.number_format($pr->ultimo_precio->detalle_compra_precio_compra,2) : '—' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif
@endforeach
@if(count($proveedores)==0)
<p style="text-align:center;color:#888">Sin proveedores registrados.</p>
@endif
</body>
</html>
