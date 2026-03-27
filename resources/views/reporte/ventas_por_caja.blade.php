@extends('layouts.plantilla')
@section('content')

    <div class="tab-content">
        @can($opciones[0]->opciones_funcion)
            <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" >
                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                    <div class="card ">
                        <div class="row m-3">
                            <div class="col-lg-12 col-md-12 col-sm-12 text-center ">
                                <h6 class="m-0 me-5 text-primary">REPORTE DE CAJA</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form id="formulario_vvvv"  action="{{ route('reporte.ventas_por_caja') }}"  method="POST" enctype = "multipart/form-data">
                        @csrf
                        <div class="row">
                            {{--                                <input type="text" id="id_empresa" name="id_empresa" value="{{$id_empresa}}">--}}
                            <div class="col-lg-2 col-md-3 col-sm-12 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                                <input onclick="cambiar_fec_general()" type="radio" name="opcion" id="diario" value="d"  {{$check == 'd' ? 'checked' : ''}}>
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
                            <div class="col-lg-10 col-md-9 col-sm-12 mb-2">
                                <div class="card mb-3">
                                    <div class="row m-2">
                                        <input type="hidden" name="enviar" id="enviar" value="1">
                                        <div class="col-lg-3 col-md-4 col-sm-12 mb-1"><input type="date" class="form-control" name="desde" id="desde"  value="{{$fecha_inicio}}" > </div>
                                        <div class="col-lg-3 col-md-4 col-sm-12 mb-1"><input type="date" class="form-control" id="hasta"  name="hasta" value="{{$fecha_fin}}" > </div>
                                        <div class="col-lg-3 col-md-4 col-sm-12 mb-1">
                                            <button type="submit" class="btn btn-info w-100"><i class="bx bx-search-alt"></i> Buscar</button>
                                        </div>
                                        @if(count($cajas) > 0)
                                        <div class="col-lg-2 col-md-3 col-sm-12 mb-1">
                                            <a href="{{ route('reporte.ventas_caja_excel') }}?desde={{$fecha_inicio}}&hasta={{$fecha_fin}}" class="btn btn-success w-100" target="_blank"><i class="fa fa-file-excel"></i> Excel</a>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-12 mb-1">
                                            <a href="{{ route('reporte.pdf_report_caja') }}?desde={{$fecha_inicio}}&hasta={{$fecha_fin}}" class="btn btn-danger w-100" target="_blank"><i class="fa fa-file-pdf"></i> PDF</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
{{--                                <div class="row">--}}
{{--                                    <div class="col-lg-12 col-md-12 col-sm-12">--}}
{{--                                        <div class="card p-3 ">--}}
{{--                                            <h5 class="text-primary "><i class="bx bx-store-alt"></i> VENTAS POR CAJA</h5>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="row mt-2">
                                    @foreach($cajas as $c)
                                        <div class="col-md-12 col-lg-12 col-sm-12">
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                                            <h6 class="card-title text-uppercase"><i class="bx bx-user"></i> <b class="text-primary">{{$c->persona_nombre.' '.$c->persona_apellido_paterno}}</b></h6>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                            <h6 class="card-title text-uppercase"><i class="bx bx-receipt"></i>CAJA:  <b class="text-primary">{{$c->caja_numero_nombre}}</b></h6>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                                            <p class="card-text mb-2"><i class="bx bx-lock-open-alt text-success"></i>Apertura: {{$c->caja_fecha_apertura}} </p>
                                                            <p class="card-text mb-2"><i class="bx bx-wallet text-success"></i> Monto Apertura: {{$c->caja_apertura}} </p>
                                                            <p class="card-text mb-2"><i class="fa-solid fa-money-bill-wave text-success"></i> Ventas Efectivo: {{$c->montoEfectivo}} </p>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                            <p class="card-text mb-2"><i class="bx bx-lock-alt text-danger"></i>Cierre: {{ ($c->caja_fecha_cierre) ? $c->caja_fecha_cierre  : 'Pendiente de cierre'  }} </p>
                                                            <p class="card-text mb-2"><i class="bx bx-wallet-alt text-danger"></i> Monto Cierre: {{$c->caja_cierre}} </p>
                                                            <p class="card-text mb-2"> <i class="fa-solid fa-money-bill-trend-up text-danger"></i> Total Caja: <b class="text-primary">{{$c->sumventas  +  $c->caja_apertura}}</b> </p>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                                                    <p class="text-secondary">METODOS DE PAGO</p>
                                                                </div>

                                                                @foreach($c->pagos as $p)
                                                                    <div class="col-lg-8 col-md-8 col-sm-8 mb-1">{{ $p->tipo_pago_nombre  }}</div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-4 mb-1"><i class="bx bx-right-arrow text-secondary"></i> {{$p->sum_pago}}</div>
                                                                @endforeach
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="d-flex justify-content-between">
                                                                        <a target="_blank"  class="btn btn-sm rounded-pill {{ ($c->caja_estado==1)? 'btn-info':'btn-danger'  }}  text-white text-end"  >{{ ($c->caja_estado==1)? 'ABIERTO':'CERRADO'  }}</a>
                                                                        {{--                                                                                <a target="_blank" href="{{ route('reporte.pdf_report_caja',['caja_id'=>$c->id_caja,'empresa_id'=>$id_empresa])}}" class="btn btn-sm rounded-pill btn-success text-end" data-bs-toggle="tooltip" data-bs-title="Descargar PDF" ><i class="bx bxs-file-pdf"></i> Descargar en PDF </a>--}}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    {{--                                                                        <p class="card-text"><i class="bx bx-store-alt text-info"></i>Ventas: {{ $c->sumventas }} </p>--}}
                                                    {{--                                                    <p class="card-text"><i class="bx bx-arrow-from-bottom text-danger"></i>Egresos: {{ $c->egreso  }} </p>--}}
                                                    {{--                                                    <p class="card-text"><i class="bx bx-arrow-from-top text-success"></i>Ingresos: {{ $c->ingreso  }} </p>--}}




                                                    {{--                                                                        <h5 class="text-center ">Total en Caja:  {{  ($c->caja_apertura+$c->sumventas)  }} </h5>--}}
                                                    {{--                                                        <h5 class="text-center ">Total en Caja:  {{  ($c->caja_apertura+$c->sumventas + $c->ingreso)-($c->egreso )   }} </h5>--}}
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endcan
    </div>

    <script src="{{asset('js/domain.js')}}"></script>
    <script src="{{asset('js/reporte.js')}}"></script>
    <script>

    </script>
@endsection
