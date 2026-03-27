<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Caja</title>
<style>
  body{font-family:Arial,sans-serif;font-size:11px;margin:20px}
  h2{color:#0b1892;text-align:center;margin-bottom:4px}
  p.periodo{text-align:center;color:#555;margin-bottom:16px}
  .caja-card{border:1px solid #0b1892;border-radius:6px;margin-bottom:16px;padding:10px}
  .caja-header{background:#0b1892;color:#fff;padding:6px 10px;border-radius:4px;margin-bottom:8px}
  .caja-header span{margin-right:16px}
  table{width:100%;border-collapse:collapse}
  th{background:#3a5aba;color:#fff;padding:4px 6px;text-align:left}
  td{padding:3px 6px;border-bottom:1px solid #ddd}
  @media print{button{display:none}}
</style>
</head>
<body>
<h2>REPORTE DE CAJA</h2>
<p class="periodo">Del {{ date('d/m/Y',strtotime($fi)) }} al {{ date('d/m/Y',strtotime($ff)) }}</p>
<button onclick="window.print()" style="float:right;margin-bottom:10px;padding:6px 14px;background:#0b1892;color:#fff;border:none;border-radius:4px;cursor:pointer">Imprimir / Guardar PDF</button>

@foreach($cajas as $c)
<div class="caja-card">
  <div class="caja-header">
    <span><strong>{{ $c->persona_nombre ?? 'Usuario' }}</strong></span>
    <span>Apertura: {{ date('d/m/Y H:i', strtotime($c->caja_fecha_apertura)) }}</span>
    <span>Total ventas: S/ {{ number_format($c->sumventas,2) }}</span>
    <span>Efectivo: S/ {{ number_format($c->montoEfectivo,2) }}</span>
  </div>
  <table>
    <thead><tr><th>Método de Pago</th><th>Monto S/</th></tr></thead>
    <tbody>
      @foreach($c->pagos as $p)
      @if($p->sum_pago > 0)
      <tr><td>{{ $p->tipo_pago_nombre ?? 'Pago' }}</td><td>S/ {{ number_format($p->sum_pago,2) }}</td></tr>
      @endif
      @endforeach
    </tbody>
  </table>
</div>
@endforeach
@if(count($cajas)==0)
<p style="text-align:center;color:#888">Sin registros de caja en el período.</p>
@endif
</body>
</html>
