@extends('layouts.plantilla')
@section('content')
<style>
.mv-search-label {
  display: block;
  font-size: 11.5px;
  font-weight: 600;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: .5px;
  margin-bottom: 6px;
}
.mv-search-wrap { position: relative; }
.mv-search-icon {
  position: absolute;
  left: 11px;
  top: 50%;
  transform: translateY(-50%);
  color: #64748b;
  font-size: 13px;
  pointer-events: none;
}
.mv-search-input {
  width: 100%;
  padding: 9px 13px 9px 34px;
  font-size: 13.5px;
  border: 1px solid #e2e8f0;
  border-radius: 7px;
  background: #f1f5f9;
  color: #1e293b;
  transition: border-color .15s, box-shadow .15s;
  outline: none;
}
.mv-search-input:focus {
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37,99,235,.12);
  background: #fff;
}
.mv-dropdown {
  position: absolute;
  top: calc(100% + 4px);
  left: 0;
  right: 0;
  z-index: 9999;
  background: #fff;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  box-shadow: 0 8px 28px rgba(15,23,42,.13);
  max-height: 280px;
  overflow-y: auto;
  display: none;
}
.mv-dropdown.open { display: block; }
.mv-drop-item {
  padding: 9px 14px;
  cursor: pointer;
  border-bottom: 1px solid #f1f5f9;
  transition: background .12s;
}
.mv-drop-item:last-child { border-bottom: none; }
.mv-drop-item:hover { background: #eff6ff; }
.mv-drop-name  { font-size: 13px; font-weight: 600; color: #1e293b; }
.mv-drop-meta  { font-size: 11px; color: #64748b; margin-top: 2px; }
.mv-drop-code  { font-family: monospace; color: #6b7280; }
.mv-drop-fam   { color: #2563eb; margin-left: 6px; }
.mv-drop-empty { padding: 12px 14px; font-size: 13px; color: #64748b; font-style: italic; }
</style>
    <div class="modal fade" id="modal_realizar_movimiento_producto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Crear / Editar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formulario_realizar_movimiento_producto" class="mb-3"  method="POST" enctype = "multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12  ">
                                <label for="tipo_movimiento">Tipo de movimientos</label>
                                <select name="tipo_movimiento" onchange="activarMotivimiento()" id="tipo_movimiento" class="form-control">
                                    <option value="1" selected>Ingreso</option>
                                    <option value="2" >Salida</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12" style="display: none"  id="containerMotivo" >
                                <label for="motivo_operacion">Motivo</label>
                                <textarea name="motivo_operacion" id="motivo_operacion" cols="30" rows="1" class="form-control"></textarea>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 mt-3 mb-3">
                                <label class="mv-search-label"><i class="fa-solid fa-magnifying-glass"></i> Buscar Productos</label>
                                <div class="mv-search-wrap">
                                    <i class="fa-solid fa-magnifying-glass mv-search-icon"></i>
                                    <input type="text" name="buscar_productos_movientos" id="buscar_productos_movientos"
                                           class="mv-search-input" placeholder="Buscar por nombre o código…" autocomplete="off">
                                    <div id="mv_productos_dropdown" class="mv-dropdown"></div>
                                </div>
                            </div>
{{--                            <div class="col-lg-12 d-flex justify-content-center mt-3">--}}
{{--                                <input type="text" name="" id="buscar_productos_moviemtos" placeholder="Buscar Productos" class="form-control w-50 p-1">--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-12 col-sm-12 col-sm-12 d-flex justify-content-center mt-1" id="">--}}

{{--                            </div>--}}
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2 table-responsive" id="tabla_productos_realizar_movimientos">

                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 ">
                                <button type="submit" class="btn btn-primary m-1 w-100" id="btn_guardar_movimientos_formu">Guardar Registro</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_detalle_movimientos_productos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal_title text-dark" id="exampleModalLabel">Detalles del movimiento de productos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 table-responsive  ">
                            <table class="table table-hover table-bordered" >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                </tr>
                                </thead>
                                <tbody id="tabla_detalle_movimiento_producto">

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="tab-content">
        <div id="vista_para_opciones_{{$opciones[0]->id_opciones}}" class="tab-pane fade show active " role="tabpanel" aria-labelledby="opciones_{{$opciones[0]->id_opciones}}" tabindex="0">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="card">
                    <div class="row m-2">
                        <div class="col-lg-10 col-md-9 col-sm-12 mb-1">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12 mb-1 ">
                                    <label for="tipoMovimientoFiltro" class="form-label">Tipo de Movimiento : </label>
                                    <select name="tipoMovimientoFiltro" id="tipoMovimientoFiltro" class="form-select">
                                        <option value="">Seleccionar..</option>
                                        <option value="1">Ingreso</option>
                                        <option value="2">Salida</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 mb-1 ">
                                    <label for="desde_producto" class="form-label">Desde : </label>
                                    <input type="date" name="desde_producto" id="desde_producto" class="form-control w-100" value="{{date('Y-m-d')}}">
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 mb-1 ">
                                    <label for="hasta_producto" class="form-label">Hasta : </label>
                                    <input type="date" name="hasta_producto" id="hasta_producto" class="form-control w-100" value="{{date('Y-m-d')}}">
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12 mb-1 d-flex align-items-center">
                                    <button class="btn btn-sm text-white bg-primary w-100" id="btn_realizar_busqueda_movimientos_productos"> <i class="fa fa-search"></i> Buscar Datos</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-12 mb-1 d-flex align-items-center">
                            <button class="btn  btn-sm btn-success w-100"  data-bs-toggle="modal" data-bs-target="#modal_realizar_movimiento_producto"><i class="fa fa-plus"></i> Realizar Movimientos</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 table-responsive">
                                <table class="table table-hover" id="tablaMoviProductoVi">
                                        <thead>
                                        <tr class="color_tabla">
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Fecha de operación</th>
                                            <th>Tipo de Movimiento</th>
                                            <th>Motivo</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tabla_resultado_busqueda_moviemtos_productos">

                                        </tbody>

                                    </table>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12 text-center" id="pptt">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/domain.js')}}"></script>
    <script src="{{asset('js/gestionventas.js')}}"></script>

@endsection
