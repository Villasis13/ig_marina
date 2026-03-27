@extends('layouts.plantilla')
@section('content')

    <div class="modal fade" id="realizar_proformasmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formulario_registro_proformas" class="mb-3"  method="POST" enctype = "multipart/form-data">
                    @csrf
                    <input type="hidden" name="action_proforma_register" id="action_proforma_register" >
                    <input type="hidden" name="id_profo" id="id_profo" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <h6 class="text-primary">Información del cliente</h6>
                                <hr>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                <label for="id_tipo_documento">Tipo de Documento (*)</label>
                                <select name="id_tipo_documento" id="id_tipo_documento" class="form-control">
                                    <option value="4">RUC</option>
                                    <option value="2">DNI</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                <label for="num_documento">N° Documento (*)</label>
                                <input type="text" class="form-control" name="num_documento" id="num_documento" onkeyup="validar_numeros(this.id)">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                <label for="tel_cliente">Teléfono</label>
                                <input type="text" class="form-control" name="tel_cliente" id="tel_cliente" onkeyup="validar_numeros(this.id)">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <label for="razon_social_cliente">Razón Social (*) </label>
                                <input type="text" class="form-control" name="razon_social_cliente" id="razon_social_cliente" >
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <label for="direccion_cliente">Dirección </label>
                                <textarea name="direccion_cliente" id="direccion_cliente" rows="2" class="form-control"></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <h6 class="text-primary">Información adicional</h6>
                                <hr>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                <label for="forma_pago">Forma de pago  (*) </label>
                                <select name="forma_pago" id="forma_pago" class="form-control">
                                    <option value="1">CONTADO</option>
                                    <option value="2">CREDITO</option>
                                </select>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 mb-2">
                                <label for="lugar_entrega">Lugar de entrega (*) </label>
                                <input type="text" class="form-control" name="lugar_entrega" id="lugar_entrega" >
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <label for="observaciones_proforma">Observaciones</label>
                                <textarea name="observaciones_proforma" id="observaciones_proforma"  rows="2" class="form-control"></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <hr>
                                <h6 class="text-primary">Lista de productos</h6>
                                <hr>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="productos_proformas" class="fw-semibold"><i class="bx bx-search"></i> Buscar Productos</label>
                                <input type="text" name="productos_proformas" id="productos_proformas" placeholder="Ingrese Información..." class="form-control  p-1">
                                <div class="shadow" style="z-index: 999;position: absolute; width: 90%">
                                    <div class="list-group list-group-flush bg-white  " style="overflow: auto;" id="listar_productos_proformas">

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-4 mb-4 ">
                                <p id="mensajeErrorProforma" class="text-danger"></p>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2 table-responsive" id="container_table_proformas_productos">

                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-5">
                                <button type="submit" class="btn btn-primary m-1 w-100" id="btn_guardar_proformas"><i class="fa-solid fa-check"></i> Guardar Registro</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="tab-content">
        <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" tabindex="0">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="card">
                    <div class="row m-2">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <form action="{{route('Gestionventas.proformas')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                        <small>Desde</small>
                                        <input type="date" class="form-control" name="proforma_search_desde" id="proforma_search_desde" value="{{$desde}}" >
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                        <small>Hasta</small>
                                        <input type="date" class="form-control" name="proforma_search_hasta" id="proforma_search_hasta" value="{{$hasta}}" >
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2 d-flex align-items-center justify-content-center flex-column">
                                        <button class="btn btn-sm bg-warning text-white w-100"><i class="fa-solid fa-magnifying-glass"></i> Buscar Registros</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-2 col-md-12 col-sm-12 mb-2 d-flex align-items-center justify-content-center flex-column">
                            <a class=" btn bg-primary  btn-sm text-white cursor-pointer w-100" href="{{route('Gestionventas.gestion_proforma')}}"  ><i class="fa-solid fa-check"></i> Crear Registro</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3" id="my_div">
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 table-responsive">
                                <table class="table table-hover" id="dataTable3">
                                    <thead>
                                        <tr class="encabezado_tabla_color">
                                            <th>Serie y Correlativo</th>
                                            <th>Cliente</th>
                                            <th>Forma de pago</th>
                                            <th>Lugar de entrega</th>
                                            <th>Observación</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($proformas as $p)

                                            @php
                                                if ($p->profo_acti_estado == 0){
                                                    $estado_proforma = "Pendiente de aprobación";
                                                    $style = "text-danger";
                                                }elseif ($p->profo_acti_estado == 1){
                                                    $estado_proforma = "Aprobada";
                                                    $style = "text-info";
                                                }else{
                                                    $estado_proforma = "Despachada";
                                                    $style = "text-success";
                                                }
                                            @endphp

                                            <tr>
                                                <td>
                                                    <b style="font-size: 12pt">{{$p->profo_serie}}00{{$p->profo_correlativo}}</b>
                                                </td>
                                                <td>
                                                    <b class="text-primary">{{$p->id_tipo_documento == 4 ? 'RUC : '.$p->cliente_numero: 'DNI : '.$p->cliente_numero}}</b> <br>
                                                    <b class="text-primary">{{$p->cliente_razonsocial}}</b>
                                                </td>
                                                <td>{{$p->profo_forma_pago == 1 ? 'CONTADO' :'CRÉDITO'}}</td>
                                                <td><b class="text-warning">{{$p->profo_lugar_entrega}}</b></td>
                                                <td>{{$p->profo_observacion}}</td>
                                                <td><b>S/ {{$p->total}}</b></td>
                                                <td>Estado</td>
                                                <td>
                                                    <a href="{{route('Gestionventas.imprimir_proforma',['data'=>$p->id_profo])}}" target="_blank" class="btn btn-warning text-white btn-sm m-1">
                                                        <i class="fa-solid fa-file-pdf"></i>
                                                    </a>
                                                    <button  onclick="listarDatosProforma({{$p->id_profo}})" data-bs-toggle="modal" data-bs-target="#realizar_proformasmodal" class="btn btn-sm text-white bg-primary m-1">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <button  class="btn btn-sm text-white bg-danger m-1"
                                                             id="btnEliminarProforma_{{$p->id_profo}}"
                                                             onclick="preguntar('¿Está seguro que desea eliminar este familia?','eliminar_proforma','Si','No',{{$p->id_profo}})">
                                                            <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/domain.js')}}"></script>
    <script src="{{asset('js/gestionventas.js')}}"></script>
{{--    <script src="{{asset('js/html2pdf.bundle.min.js')}}"></script>--}}
    <script>
        // function imprimir() {
        //     $('#containerFoto').css('margin-top','24%')
        //     const $elementoParaConvertir = $('#my_div').html();
        //     html2pdf()
        //         .set({
        //             margin: 0.5,
        //             filename: 'Proforma.pdf',
        //             image: {
        //                 type: 'jpeg',
        //                 quality: 0.98
        //             },
        //             html2canvas: {
        //                 scale: 3,
        //                 letterRendering: true
        //             },
        //             jsPDF: {
        //                 unit: 'in',
        //                 format: 'a3',
        //                 orientation: 'portrait'
        //             }
        //         })
        //         .from($elementoParaConvertir)
        //         .save()
        //         .catch(err=>console.log(err));
        //
        //     $('#containerFoto').css('margin-top','0%')
        //
        //
        // }

    </script>
@endsection
