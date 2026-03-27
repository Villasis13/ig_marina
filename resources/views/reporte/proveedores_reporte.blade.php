@extends('layouts.plantilla')
@section('content')

    <div class="tab-content">
        @can($opciones[0]->opciones_funcion)
            <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" >
                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                    <div class="card ">
                        <div class="row m-3">
                            <div class="col-lg-12 col-md-12 col-sm-12 text-center ">
                                <h6 class="m-0 me-5 text-primary">REPORTE DE PROVEEDORES</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form id="formulario_vvvv"  action="{{ route('reporte.proveedores_reporte') }}"  method="POST" enctype = "multipart/form-data">
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
                                <div class="card mb-4">
                                    <div class="row m-2">
                                        <input type="hidden" name="enviar" id="enviar" value="1">
                                        <div class="col-lg-3 col-md-4 col-sm-12 mb-1">
                                            <label for="desde">Desde</label>
                                            <input type="date" class="form-control" name="desde" id="desde"  value="{{$fecha_inicio}}" >
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-12 mb-1">
                                            <label for="hasta">Hasta</label>
                                            <input type="date" class="form-control" id="hasta"  name="hasta" value="{{$fecha_fin}}" >
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-12 mb-1 d-flex align-items-center justify-content-center flex-column">
                                            <button type="submit" class="btn btn-info w-100"><i class="bx bx-search-alt"></i> Buscar Registros</button>
                                        </div>
                                        @if(count($proveedores) > 0)
                                        <div class="col-lg-2 col-md-3 col-sm-12 mb-1">
                                            <a href="{{ route('reporte.proveedores_excel') }}?desde={{$fecha_inicio}}&hasta={{$fecha_fin}}" class="btn btn-success w-100" target="_blank"><i class="fa fa-file-excel"></i> Excel</a>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-12 mb-1">
                                            <a href="{{ route('reporte.proveedores_pdf') }}?desde={{$fecha_inicio}}&hasta={{$fecha_fin}}" class="btn btn-danger w-100" target="_blank"><i class="fa fa-file-pdf"></i> PDF</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    @foreach($proveedores as $prove)
                                        <div class="col-md-12 col-lg-12 col-sm-12 mb-3 " >
                                            <div class="card  h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-3"><i class="fa-solid fa-user-tie fa-xl" style="color: #1c4b9b;"></i> {{$prove->proveedores_nombre}}</h5>
                                                    @foreach($prove->productos as $pro)
                                                        <p class="card-text mb-2">{{$pro->pro_nombre}}: <b class="text-primary">S/ {{$pro->ultimo_precio->detalle_compra_precio_compra}}</b></p>
                                                    @endforeach
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
