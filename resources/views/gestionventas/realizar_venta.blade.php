@extends('layouts.plantilla')
@section('content')

    {{-- Modal Cuotas --}}
    <div class="modal fade" id="modal_cuotas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Medio de Pago - Crédito</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 d-flex align-items-center justify-content-around">
                            <label>Total importe de cuotas:</label>
                            <h4 id="monto_total_venta"></h4>
                            <input type="hidden" id="calcular_monto_total_">
                        </div>
                        <div class="col-lg-4 col-md-12 d-flex align-items-center justify-content-around">
                            <label for="cantidad_cuota__">N° de cuotas:</label>
                            <input type="text" class="form-control w-50" name="cantidad_cuota__" id="cantidad_cuota__">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12" id="contenido_cuotas_"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Series Vehículo --}}
    <div class="modal fade" id="modal_series_vehiculo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-motorcycle"></i> Seleccionar Series</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-2">Producto: <strong id="serie_modal_producto_nombre"></strong></p>
                    <p class="mb-2" style="font-size:13px;">
                        <i class="fa fa-info-circle text-primary"></i>
                        Marca una o varias series y presiona <strong>Confirmar</strong>.
                        <span id="serie_contador" class="badge bg-primary ms-2">0 seleccionada(s)</span>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th style="width:40px;text-align:center;">
                                        <input type="checkbox" id="chk_series_all" title="Seleccionar todas" onchange="toggleTodasSeries(this)">
                                    </th>
                                    <th>N° Serie</th><th>N° Motor</th><th>Color</th><th>Año</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_series_vehiculo">
                                <tr><td colspan="5" class="text-center text-muted">Cargando series...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <p id="msg_sin_series" class="text-danger d-none">No hay series disponibles para este producto.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="confirmarSeleccionSeries()">
                        <i class="fa fa-check"></i> Confirmar selección
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Lista de Clientes --}}
    <div class="modal fade" id="modal_clientes_general" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-dark">Lista de Clientes</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Cliente</th><th>Dni / Ruc</th><th>Dirección</th><th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientes as $c)
                                <tr>
                                    <th>{{ $c->id_tipo_documento == 2 ? $c->cliente_nombre : $c->cliente_razonsocial }}</th>
                                    <th>{{ $c->cliente_numero }}</th>
                                    <th>{{ $c->cliente_direccion }}</th>
                                    <th>
                                        <button class="btn btn-primary text-white btn-sm"
                                            onclick="agregar_cliente_venta({{ $c->id_tipo_documento }},'{{ $c->cliente_nombre }}','{{ $c->cliente_razonsocial }}','{{ $c->cliente_numero }}','{{ $c->cliente_direccion }}')">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content">
        @can($opciones[0]->opciones_funcion)
        <div id="vista_para_opciones_{{ $opciones[0]->id_opciones }}" class="tab-pane fade show active"
             role="tabpanel" aria-labelledby="opciones_{{ $opciones[0]->id_opciones }}">

            {{-- Título de vista --}}
            <div class="rv-view-title mb-3">
                <h1>VENTA DE PRODUCTOS</h1>
            </div>

            @if(!$validar_caja)
            <div class="alert alert-danger mb-3" role="alert">
                Antes de continuar con la venta, es necesario que proceda a
                <a href="{{ route('admin') }}" class="alert-link">abrir la caja</a>.
            </div>
            @endif

            <form id="formulario_generar_venta" class="rv-layout mb-4" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tipo_venta__"  id="tipo_venta__"  value="1">
                <input type="hidden" name="id_formas_pago" id="id_formas_pago" value="1">

                {{-- ═══ COLUMNA IZQUIERDA ═══ --}}
                <div>

                    {{-- Card: Datos del Comprobante --}}
                    <section class="rv-card">
                        <header class="rv-card-header">
                            <h2>Datos del Comprobante</h2>
                        </header>
                        <div class="rv-card-body">
                            <div class="rv-grid-4">
                                <div class="rv-field">
                                    <label>Fecha de Emisión</label>
                                    <input type="date" name="fecha_emision" id="fecha_emision" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="rv-field">
                                    <label>Motivo</label>
                                    <select name="venta_motivo" id="venta_motivo">
                                        <option value="ventas">Ventas</option>
                                        <option value="exportacion">Exportación</option>
                                    </select>
                                </div>
                                <div class="rv-field">
                                    <label>Tipo Comprobante</label>
                                    <select name="tipo_comprobante" id="tipo_comprobante">
                                        <option value="03">Boleta</option>
                                        <option value="01">Factura</option>
                                    </select>
                                </div>
                                <div class="rv-field">
                                    <label>Moneda</label>
                                    <select name="id_moneda" id="id_moneda">
                                        @foreach($monedas as $m)
                                        <option value="{{ $m->id_moneda }}">{{ $m->simbolo }} {{ $m->moneda }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="rv-grid-4 rv-row-gap">
                                <div class="rv-field">
                                    <label>Serie</label>
                                    <select name="serie" id="serie"></select>
                                </div>
                                <div class="rv-field">
                                    <label>Número</label>
                                    <input type="text" readonly id="numero_correlativo" name="numero_correlativo">
                                </div>
                                <div class="rv-field">
                                    <label>Vendedor</label>
                                    <select name="id_vendedor" id="id_vendedor">
                                        @foreach($vendedores as $v)
                                        <option value="{{ $v->id_users }}" {{ $v->id_users == Auth::id() ? 'selected' : '' }}>
                                            {{ $v->nombre_users ?: $v->username }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="rv-inline-check">
                                    <input type="checkbox" id="habilitarCheckMoto" name="habilitarCheckMoto">
                                    <label for="habilitarCheckMoto">Serie Vehículo</label>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Card: Datos del Cliente --}}
                    <section class="rv-card">
                        <header class="rv-card-header">
                            <h2>Datos del Cliente</h2>
                            <button class="rv-btn-search" type="button"
                                    data-bs-toggle="modal" data-bs-target="#modal_clientes_general">
                                <i class="fa fa-search"></i> Buscar Cliente
                            </button>
                        </header>
                        <div class="rv-card-body">
                            <div class="rv-grid-4">
                                <div class="rv-field">
                                    <label>Tipo Documento</label>
                                    <select name="id_tipo_documento__" id="id_tipo_documento__">
                                        @foreach($documento as $t)
                                        <option value="{{ $t->id_tipo_documento }}"
                                            {{ $t->id_tipo_documento == 2 ? 'selected' : '' }}>
                                            {{ $t->tipo_documento_identidad }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="id_tipo_documento" id="id_tipo_documento" value="2">
                                </div>
                                <div class="rv-field">
                                    <label>N° Documento</label>
                                    <input type="text" id="numero_documento" name="numero_documento" value="1111111">
                                </div>
                                <div class="rv-field" style="grid-column:span 2">
                                    <label id="nombre_tipo_documento">Nombre</label>
                                    <input type="text" value="ANONIMO" id="nombre_cliente" name="nombre_cliente">
                                </div>
                            </div>
                            <div class="rv-grid-4 rv-row-gap">
                                <div class="rv-field">
                                    <label>Teléfono</label>
                                    <input type="text" onkeyup="validar_numeros(this.id)"
                                           id="telefono_cliente" name="telefono_cliente">
                                </div>
                                <div class="rv-field" style="grid-column:span 3">
                                    <label>Dirección</label>
                                    <input type="text" name="direccion_cliente" id="direccion_cliente"
                                           placeholder="Dirección del cliente">
                                </div>
                            </div>
                            <p class="rv-help-text">
                                * Para ventas que superen los S/ 700.00, se requerirá el registro de datos del cliente. *
                            </p>
                        </div>
                    </section>

                    {{-- Card: Información de Pago --}}
                    <section class="rv-card">
                        <header class="rv-card-header">
                            <h2>Información de Pago</h2>
                            <div style="display:flex;align-items:center;gap:8px">
                                <input type="checkbox" id="partir_pago_check" name="partir_pago_check" style="display:none">
                                <label for="partir_pago_check" class="rv-partir-label" id="rv_partir_label">
                                    ✂ Partir Pago
                                </label>
                            </div>
                        </header>
                        <div class="rv-card-body">

                            {{-- Condición + Fecha (siempre visibles) --}}
                            <div class="rv-grid-4">
                                <div class="rv-field" style="grid-column:span 2">
                                    <label>Condición de Pago</label>
                                    <select name="venta_condicion_pago" id="venta_condicion_pago"
                                            onchange="actualizarCondicionPago(this.value)">
                                        <option value="contado">Contado</option>
                                        <option value="contra_entrega">Contra entrega</option>
                                        <option value="5">Crédito 5 días</option>
                                        <option value="10">Crédito 10 días</option>
                                        <option value="15">Crédito 15 días</option>
                                        <option value="30">Crédito 30 días</option>
                                        <option value="45">Crédito 45 días</option>
                                        <option value="custom">Crédito (personalizado)</option>
                                    </select>
                                </div>
                                <div class="rv-field" style="grid-column:span 2">
                                    <label>Fecha de Vencimiento</label>
                                    <input type="date" name="venta_fecha_vencimiento"
                                           id="venta_fecha_vencimiento" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            {{-- Bloque contado: tipo pago + monto (se oculta en crédito) --}}
                            <div id="contanierTableDebito" class="rv-row-gap">
                                <input type="hidden" name="vali_partir_total" id="vali_partir_total">
                                <div class="rv-grid-4">
                                    <div class="rv-field" style="grid-column:span 2">
                                        <label>Tipo de Pago</label>
                                        <select name="id_tipo_pago" id="id_tipo_pago">
                                            <option value="">Seleccionar</option>
                                            @foreach($tipo_pago as $t)
                                            <option value="{{ $t->id_tipo_pago }}">{{ $t->tipo_pago_nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="rv-field" style="grid-column:span 2">
                                        <label>Monto Recibido</label>
                                        <input type="text" name="pago_cliente" id="pago_cliente"
                                               onkeyup="validar_numeros(this.id)"
                                               onchange="dar_sobras_pago2()" placeholder="0.00">
                                    </div>
                                </div>

                                {{-- Segundo pago (oculto por defecto) --}}
                                <div class="contenedorPago2" style="display:none">
                                    <div style="padding:10px 0 6px;border-top:2px dashed #e2e8f0;margin-top:12px">
                                        <span style="font-size:11px;font-weight:700;text-transform:uppercase;
                                                     color:#615fff;background:rgba(97,95,255,.15);
                                                     padding:3px 10px;border-radius:20px">✦ Pago 2</span>
                                    </div>
                                    <div class="rv-grid-4 rv-row-gap">
                                        <div class="rv-field" style="grid-column:span 2">
                                            <label>Tipo de Pago 2</label>
                                            <select name="id_tipo_pago_2" id="id_tipo_pago_2">
                                                <option value="">Seleccionar</option>
                                                @foreach($tipo_pago as $t)
                                                <option value="{{ $t->id_tipo_pago }}">{{ $t->tipo_pago_nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="rv-field" style="grid-column:span 2">
                                            <label>Monto 2</label>
                                            <input type="text" readonly name="pago_cliente_2" id="pago_cliente_2"
                                                   onkeyup="validar_numeros(this.id)" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Botón lista de cuotas (crédito personalizado) --}}
                            <div class="mt-2">
                                <button class="btn btn-sm bg-primary text-white w-100" style="display:none"
                                        data-bs-toggle="modal" data-bs-target="#modal_cuotas"
                                        type="button" id="btn_credito_venta">
                                    <i class="fa fa-list"></i> Lista de cuotas
                                </button>
                            </div>
                            <div id="info_credito_automatico" class="mt-1" style="display:none">
                                <small class="text-info">
                                    <i class="fa fa-info-circle"></i> Se generará 1 cuota automática al vencimiento.
                                </small>
                            </div>
                        </div>
                    </section>

                    {{-- Card: Detalles de Entrega --}}
                    <section class="rv-card">
                        <header class="rv-card-header">
                            <h2><i class="fa-solid fa-truck"></i> Detalles de Entrega
                                <span style="font-weight:400;text-transform:none;letter-spacing:0;
                                             font-size:11px;color:#9aa8ba"> (opcional)</span>
                            </h2>
                        </header>
                        <div class="rv-card-body">
                            <div class="rv-grid-2">
                                <div class="rv-field">
                                    <label>Método de Entrega</label>
                                    <select name="metodo_envio" id="metodo_envio">
                                        <option value="">-- Sin envío --</option>
                                        <option value="Recojo en tienda">Recojo en tienda</option>
                                        <option value="Delivery">Delivery</option>
                                        <option value="Envío por transporte">Envío por transporte</option>
                                        <option value="Envío nacional">Envío nacional</option>
                                    </select>
                                </div>
                                <div class="rv-field">
                                    <label>Dirección de Entrega</label>
                                    <input type="text" name="direccion_entrega" id="direccion_entrega"
                                           placeholder="Dirección (si aplica)">
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Card: Productos de la Venta --}}
                    <section class="rv-card">
                        <header class="rv-card-header">
                            <h2>Productos de la Venta</h2>
                        </header>
                        <div class="rv-card-body">
                            <p class="text-danger m-0 mb-1" id="mensaje_producto_insuficientes" style="font-size:12px"></p>
                            <p class="text-danger m-0 mb-2" id="mensaje_error_cuotas" style="font-size:12px"></p>

                            {{-- Buscador --}}
                            <div style="position:relative;margin-bottom:24px">
                                <label class="rv-search-label">
                                    <i class="fa-solid fa-search"></i> Nombre de producto
                                </label>
                                <input type="text" name="buscar_productos_ventas" id="buscar_productos_ventas"
                                       placeholder="Ingrese información..." class="rv-search-input">
                                <div style="z-index:9999;position:absolute;width:65%;max-height:320px;
                                            overflow-y:auto;top:calc(100% + 4px);left:0;
                                            border-radius:8px;box-shadow:0 8px 24px rgba(15,23,42,.12)">
                                    <div class="list-group list-group-flush bg-white" id="lista_productos_ventas"></div>
                                </div>
                            </div>

                            {{-- Tabla de productos --}}
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="tablaProductoVentas">
                                    <thead>
                                        <tr class="color_tabla">
                                            <th>Producto</th>
                                            <th>Descripción</th>
                                            <th>Stock</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unit.</th>
                                            <th>Desc. %</th>
                                            <th>Venta Neta</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla_productos_ventas"></tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                </div>{{-- fin columna izquierda --}}

                {{-- ═══ SIDEBAR DERECHO: DETALLE DE CUENTA ═══ --}}
                <aside class="rv-summary">
                    <h2>DETALLE DE CUENTA</h2>

                    <p class="rv-summary-label">Operaciones</p>

                    <div class="rv-summary-line">
                        <span>Op. Gravada</span>
                        <strong><span id="op_gravada">+00.0</span> <small>PEN</small></strong>
                    </div>
                    <div class="rv-summary-line">
                        <span>IGV</span>
                        <strong><span id="totaligv">+00.0</span> <small>PEN</small></strong>
                    </div>
                    <div class="rv-summary-line">
                        <span>Op. Inafectada</span>
                        <strong><span id="op_inafectada">+00.0</span> <small>PEN</small></strong>
                    </div>
                    <div class="rv-summary-line">
                        <span>Op. Exoneradas</span>
                        <strong><span id="op_exoneradas">+00.0</span> <small>PEN</small></strong>
                    </div>
                    <div class="rv-summary-line">
                        <span>Op. Gratuitas</span>
                        <strong><span id="op_gratuitas">+00.0</span> <small>PEN</small></strong>
                    </div>
                    <div class="rv-summary-line" style="margin-bottom:16px">
                        <span>ICBPER</span>
                        <strong><span id="icbper">+0.00</span> <small>PEN</small></strong>
                    </div>

                    <div class="rv-summary-line">
                        <span>Descuento</span>
                        <div style="display:flex;gap:4px">
                            <select id="tipo_descuento" name="descuento_tipo"
                                    class="rv-mini-select" onchange="calcular_afectacion()">
                                <option value="pct">%</option>
                                <option value="monto">S/.</option>
                            </select>
                            <input type="text" id="valor_descuento" name="descuento_valor" value="0"
                                   class="rv-mini-input"
                                   onkeyup="validar_numeros(this.id)" onchange="calcular_afectacion()">
                        </div>
                    </div>
                    <div class="rv-summary-line rv-desc-applied">
                        <span>Desc. aplicado</span>
                        <strong><span id="descuento_total_display">-0.00</span> <small>PEN</small></strong>
                    </div>

                    <div id="cantidad_en_cuotas" style="display:none!important">
                        <input type="hidden" name="venta_total_ver" id="venta_total_ver">
                        <div class="rv-summary-line">
                            <span>Monto por cuota</span>
                            <strong><span id="monto_cuota_a_pagaar">00.00</span> <small>PEN</small></strong>
                        </div>
                    </div>

                    <div class="rv-summary-line">
                        <span>Pago con</span>
                        <strong><span id="pago_con_cliente">00.00</span> <small>PEN</small></strong>
                    </div>
                    <div class="rv-summary-line">
                        <span>Vuelto</span>
                        <strong><span id="vuelto_">00.00</span> <small>PEN</small></strong>
                    </div>

                    <div class="rv-summary-total">
                        <span>TOTAL</span>
                        <strong><span id="total_venta">+00.00</span> <small>PEN</small></strong>
                    </div>

                    @if($validar_caja)
                    <button class="rv-btn-cobrar" type="submit" id="btn_realizar_venta__">
                        <i class="fa fa-money-bill"></i> Cobrar
                    </button>
                    @endif
                </aside>

            </form>
        </div>
        @endcan
    </div>

    <style>
        /* ── Variables ── */
        :root {
            --rv-primary:      #07149b;
            --rv-primary-glow: rgba(7,20,155,.12);
            --rv-purple:       #615fff;
            --rv-border:       #e2e8f0;
            --rv-bg-subtle:    #f6f8fb;
            --rv-text:         #1f2937;
            --rv-text-sec:     #475569;
            --rv-muted:        #6b7280;
            --rv-radius:       12px;
            --rv-radius-sm:    6px;
            --rv-shadow:       0 4px 16px rgba(15,23,42,.08),0 1px 4px rgba(15,23,42,.04);
        }

        /* ── Layout grid ── */
        .rv-layout {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 20px;
            align-items: start;
        }

        /* ── Título ── */
        .rv-view-title {
            background: #fff;
            border-radius: var(--rv-radius);
            box-shadow: 0 1px 4px rgba(15,23,42,.06);
            padding: 13px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .rv-view-title::before {
            content: '';
            position: absolute;
            inset: 0 0 auto 0;
            height: 3px;
            background: linear-gradient(90deg, var(--rv-primary), var(--rv-purple));
        }
        .rv-view-title h1 {
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: var(--rv-primary);
            margin: 0;
        }

        /* ── Card ── */
        .rv-card {
            background: #fff;
            border: 1px solid var(--rv-border);
            border-radius: var(--rv-radius);
            box-shadow: var(--rv-shadow);
            margin-bottom: 18px;
            overflow: visible;
        }
        .rv-card-header {
            padding: 12px 18px;
            border-bottom: 1px solid var(--rv-border);
            background: var(--rv-bg-subtle);
            border-radius: var(--rv-radius) var(--rv-radius) 0 0;
            border-left: 3px solid var(--rv-primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }
        .rv-card-header h2 {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--rv-text-sec);
            margin: 0;
        }
        .rv-card-body { padding: 18px 20px; }

        /* ── Grids ── */
        .rv-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; }
        .rv-grid-2 { display: grid; grid-template-columns: repeat(2,1fr); gap: 14px; }
        .rv-row-gap { margin-top: 14px; }

        /* ── Field ── */
        .rv-field { display: flex; flex-direction: column; gap: 5px; }
        .rv-field > label {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: var(--rv-text-sec);
            margin: 0;
        }
        .rv-field input,
        .rv-field select {
            width: 100%;
            height: 40px;
            border: 1.5px solid var(--rv-border);
            border-radius: var(--rv-radius-sm);
            padding: 0 12px;
            font-size: 13.5px;
            font-family: inherit;
            color: var(--rv-text);
            background: #fff;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            -webkit-appearance: none;
            appearance: none;
        }
        .rv-field input:focus,
        .rv-field select:focus {
            border-color: var(--rv-primary);
            box-shadow: 0 0 0 3px var(--rv-primary-glow);
        }
        .rv-field input[readonly] {
            background: var(--rv-bg-subtle);
            color: var(--rv-muted);
        }
        .rv-field input.is-invalid,
        .rv-field select.is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 3px rgba(220,53,69,.15) !important;
        }
        .rv-field select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 34px;
        }

        /* ── Checkbox inline (Serie Vehículo) ── */
        .rv-inline-check {
            display: flex;
            align-items: center;
            gap: 8px;
            padding-top: 20px;
            font-size: 13px;
            color: var(--rv-text-sec);
        }
        .rv-inline-check input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--rv-primary);
            cursor: pointer;
        }

        /* ── Buscar cliente ── */
        .rv-btn-search {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 34px;
            padding: 0 14px;
            background: linear-gradient(135deg, var(--rv-purple) 0%, #7c7bff 100%);
            color: #fff;
            border: none;
            border-radius: var(--rv-radius-sm);
            font-family: inherit;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            white-space: nowrap;
            box-shadow: 0 3px 10px rgba(97,95,255,.25);
        }

        /* ── Partir Pago toggle ── */
        .rv-partir-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            color: var(--rv-primary);
            padding: 5px 14px;
            border: 1.5px solid var(--rv-primary);
            border-radius: 20px;
            transition: background .15s, color .15s;
            user-select: none;
            white-space: nowrap;
        }
        .rv-partir-label.rv-partir-active {
            background: var(--rv-primary);
            color: #fff !important;
        }

        /* ── Help text ── */
        .rv-help-text {
            font-size: 11px;
            font-weight: 600;
            color: var(--rv-primary);
            margin-top: 10px;
            margin-bottom: 0;
        }

        /* ── Buscador de productos ── */
        .rv-search-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--rv-text-sec);
            margin-bottom: 6px;
        }
        .rv-search-input {
            width: 100%;
            height: 42px;
            border: 1.5px solid var(--rv-border);
            border-radius: var(--rv-radius-sm);
            padding: 0 14px;
            font-size: 14px;
            font-family: inherit;
            color: var(--rv-text);
            background: #fff;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .rv-search-input:focus {
            border-color: var(--rv-primary);
            box-shadow: 0 0 0 3px var(--rv-primary-glow);
        }

        /* ── Sidebar Detalle de Cuenta ── */
        .rv-summary {
            position: sticky;
            top: 88px;
            background: #fff;
            border-radius: var(--rv-radius-sm);
            padding: 20px 18px 16px;
            box-shadow: var(--rv-shadow);
            border: 1px solid var(--rv-border);
        }
        .rv-summary h2 {
            font-size: 15px;
            font-weight: 800;
            color: #566b86;
            margin-bottom: 18px;
            letter-spacing: .02em;
        }
        .rv-summary-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #9aa8ba;
            margin-bottom: 8px;
        }
        .rv-summary-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 9px;
            font-size: 13px;
        }
        .rv-summary-line > span  { color: #566b86; font-weight: 600; }
        .rv-summary-line > strong { color: #111827; font-weight: 500; }
        .rv-summary-line small   { color: #94a3b8; font-size: 11px; }

        .rv-desc-applied > span,
        .rv-desc-applied > strong,
        .rv-desc-applied small { color: #dc2626 !important; }

        .rv-summary-total {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 12px;
            margin-bottom: 12px;
            padding-top: 10px;
            border-top: 1px solid var(--rv-border);
        }
        .rv-summary-total > span   { color: #dc2626; font-size: 18px; font-weight: 700; }
        .rv-summary-total > strong { color: #dc2626; font-size: 15px; font-weight: 600; }
        .rv-summary-total small    { color: #dc2626; font-size: 12px; }

        /* ── Miniformatos en sidebar ── */
        .rv-mini-select {
            width: 58px; height: 30px;
            padding: 0 6px;
            font-size: 12px;
            border: 1.5px solid var(--rv-border);
            border-radius: var(--rv-radius-sm);
            font-family: inherit;
            outline: none;
            -webkit-appearance: none;
            appearance: none;
            background: #fff;
        }
        .rv-mini-input {
            width: 70px; height: 30px;
            text-align: right;
            font-size: 12px;
            border: 1.5px solid var(--rv-border);
            border-radius: var(--rv-radius-sm);
            padding: 0 8px;
            font-family: inherit;
            outline: none;
        }

        /* ── Botón Cobrar ── */
        .rv-btn-cobrar {
            width: 100%;
            height: 42px;
            border: none;
            border-radius: var(--rv-radius-sm);
            background: linear-gradient(135deg, var(--rv-primary) 0%, #1a2fd4 100%);
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            font-family: inherit;
            box-shadow: 0 4px 12px var(--rv-primary-glow);
            transition: opacity .15s;
        }
        .rv-btn-cobrar:hover { opacity: .9; }

        /* ── Responsive ── */
        @media (max-width: 1200px) {
            .rv-layout { grid-template-columns: 1fr; }
            .rv-summary { position: static; }
        }
        @media (max-width: 800px) {
            .rv-grid-4 { grid-template-columns: repeat(2,1fr); }
        }
        @media (max-width: 500px) {
            .rv-grid-4, .rv-grid-2 { grid-template-columns: 1fr; }
        }
    </style>

    <script src="{{ asset('js/domain.js') }}"></script>
    <script src="{{ asset('js/gestionventas.js') }}"></script>
    <script>
        $(document).ready(function(){
            Consultar_serie_();
            $('.input-number').on('input', function() {
                if ($(this).val() < 0) $(this).val(0);
            });
        });


        $('input[type="number"]').on('input', function() {
            if ($(this).val() < 0) $(this).val(0);
        });

        /* Partir pago: sincronizar estado visual del label */
        let _partirCheck = document.getElementById('partir_pago_check');
        if(_partirCheck){
            _partirCheck.addEventListener('change', function(){
                let lbl = document.getElementById('rv_partir_label');
                if(lbl) lbl.classList.toggle('rv-partir-active', this.checked);
            });
        }

        /* Tipo documento → tipo comprobante */
        let id_tipo_documento__ = document.getElementById('id_tipo_documento__');
        if(id_tipo_documento__ && id_tipo_documento__.addEventListener){
            id_tipo_documento__.addEventListener('change', function(){
                cambiar_tipo_comprobante(this.id);
            });
        }

        /* Serie vehículo */
        let habilitarCheckMoto = document.getElementById('habilitarCheckMoto');
        if(habilitarCheckMoto && habilitarCheckMoto.addEventListener){
            habilitarCheckMoto.addEventListener('change', function(){ Consultar_serie_(); });
        }

        function cambiar_tipo_comprobante(id){
            let valor = $('#'+id).val();
            if(valor == 4){
                $('#tipo_comprobante').val('01');
            }else{
                $('#tipo_comprobante').val('03');
            }
            $('#id_tipo_documento').val(valor);
            Consultar_serie_();
        }

        let numero_documento = document.getElementById('numero_documento');
        if(numero_documento && numero_documento.addEventListener){
            numero_documento.addEventListener('change', function(){
                validar_tipo_documento_venta_local(this.id);
            });
        }
        function validar_tipo_documento_venta_local(id){
            let valor = $('#'+id).val();
            if ($('#id_tipo_documento').val() == 2) {
                limit_input(id, 8);
                ObtenerDatosDni(valor);
            } else if($('#id_tipo_documento').val() == 4){
                limit_input(id, 11);
                ObtenerDatosRuc(valor);
            }
        }
        function limit_input(inputId, cantidad){
            const input = document.getElementById(inputId);
            input.value = input.value.replace(/\D/g, '');
            if (input.value.length > cantidad) input.value = input.value.slice(0, cantidad);
        }
        function ObtenerDatosDni(valor){
            if(valor.length == 8){
                respuesta("Buscando...",'info');
                var formData = new FormData();
                formData.append("token","uTZu2aTvMPpqWFuzKATPRWNujUUe7Re1scFlRsTy9Q15k1sjdJVAc9WGy57m");
                formData.append("dni", valor);
                var request = new XMLHttpRequest();
                request.open("POST","https://api.migo.pe/api/v1/dni");
                request.setRequestHeader("Accept","application/json");
                request.send(formData);
                request.onload = function(){
                    var data = JSON.parse(this.response);
                    if(data.success){
                        respuesta("Datos encontrados.",'success');
                        $("#nombre_cliente").val(data.nombre);
                        $("#nombre_cliente").attr('readonly',true);
                    }else{
                        $("#nombre_cliente").val('');
                        respuesta("Datos no encontrados.",'error');
                    }
                };
            }
        }
        function ObtenerDatosRuc(valor){
            respuesta("Buscando...",'info');
            var formData = new FormData();
            formData.append("token","uTZu2aTvMPpqWFuzKATPRWNujUUe7Re1scFlRsTy9Q15k1sjdJVAc9WGy57m");
            formData.append("ruc", valor);
            var request = new XMLHttpRequest();
            request.open("POST","https://api.migo.pe/api/v1/ruc");
            request.setRequestHeader("Accept","application/json");
            request.send(formData);
            request.onload = function(){
                var data = JSON.parse(this.response);
                if(data.success){
                    respuesta("Datos encontrados.",'success');
                    $("#nombre_cliente").val(data.nombre_o_razon_social);
                    $('#direccion_cliente').val(data.direccion_simple);
                }else{
                    respuesta("Datos no encontrados.",'error');
                    $("#nombre_cliente").val(' ');
                    $('#direccion_cliente').val(' ');
                }
            };
        }
    </script>

@endsection
