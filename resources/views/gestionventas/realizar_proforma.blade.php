@extends('layouts.plantilla')
@section('content')

    <div class="tab-content">
        <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" tabindex="0">
            <form id="formulario_registro_proformas" class="mb-3"  method="POST" enctype = "multipart/form-data">
                @csrf
                <input type="hidden" name="action_proforma_register" id="action_proforma_register" value="1" >
                <input type="hidden" name="id_profo" id="id_profo" value="" >
                <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 mb-3" >
                    <div class="card ">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                            <h6 class="text-primary">Información del cliente</h6>
                                            <hr>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                            <label for="id_tipo_documento">Documento (*)</label>
                                            <select name="id_tipo_documento" id="id_tipo_documento" class="form-control">
                                                <option value="4" >RUC</option>
                                                <option value="2" >DNI</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                            <label for="num_documento">N° Documento (*)</label>
                                            <input type="text" class="form-control" value="" name="num_documento" id="num_documento" onkeyup="validar_numeros(this.id)">
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12 mb-3">
                                            <label for="tel_cliente">Teléfono</label>
                                            <input type="text" class="form-control" name="tel_cliente" id="tel_cliente"  value="" onkeyup="validar_numeros(this.id)">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <label for="razon_social_cliente">Razón Social (*) </label>
                                            <input type="text" class="form-control" name="razon_social_cliente" value="" id="razon_social_cliente" >
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                                            <label for="direccion_cliente">Dirección </label>
                                            <textarea name="direccion_cliente" id="direccion_cliente" rows="2" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                            <h6 class="text-primary">Información adicional</h6>
                                            <hr>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <label for="forma_pago">Forma de pago  (*) </label>
                                            <select name="forma_pago" id="forma_pago" class="form-control">
                                                <option value="1">CONTADO</option>
                                                <option value="2" >CREDITO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <label for="lugar_entrega">Lugar de entrega (*) </label>
                                            <input type="text" class="form-control" value="Previa Coordinación" name="lugar_entrega" id="lugar_entrega" >
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                            <label for="observaciones_proforma">Observaciones</label>
                                            <textarea name="observaciones_proforma" id="observaciones_proforma"  rows="2" class="form-control">
                                                Los precios están sujetos a variaciones
                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 mb-3" >
                    <div class="card ">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
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
                                <div class="col-lg-12 col-md-12 col-sm-12 mt-5 text-end">
                                    <button type="submit" class="btn btn-primary m-1 " id="btn_guardar_proformas"><i class="fa-solid fa-check"></i> Guardar Registro</button>
                                    <a href="{{route('Gestionventas.proformas')}}" class="btn btn-secondary m-1 " ><i class="fa-solid fa-arrow-rotate-left"></i> Regresar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <script src="{{asset('js/domain.js')}}"></script>
    <script src="{{asset('js/gestionventas.js')}}"></script>
    <script>
        window.addEventListener('load', function() {
            if(localStorage.getItem('productos_proforma')) {
                proformas_productos = JSON.parse(localStorage.getItem('productos_proforma'));
                dibujar_tabla_productos_proformas();
            }
        });
    </script>
@endsection
