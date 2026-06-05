let movimientos_productos =  [];
let ventas_prtoductos =  [];
let cuotas_venta = [];
let proformas_productos = [];
let proformas_productosEdit = [];
let partir_pago = [{'tipo_pago': 0, 'monto': 0}];
let btn_realizar_busqueda_movimientos_productos = document.getElementById('btn_realizar_busqueda_movimientos_productos');
if(btn_realizar_busqueda_movimientos_productos && btn_realizar_busqueda_movimientos_productos.addEventListener){
    btn_realizar_busqueda_movimientos_productos.addEventListener('click',function (){
        buscar_movientos_productos();
    });
}
function buscar_movientos_productos(){
    let tipo = $('#tipoMovimientoFiltro').val();
    let desde = $('#desde_producto').val();
    let hasta = $('#hasta_producto').val();
    var boton = "btn_realizar_busqueda_movimientos_productos";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestionventas/buscar_movimientos_productos",
        data:{
            tipo:tipo,
            desde:desde,
            hasta:hasta,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Buscando...', true);
        },
    }).done(function(r){
        cambiar_estado_boton(boton, "<i class=\"fa fa-search\"></i> Buscar Datos", false);
        let body = ""
        let datosIn = r.result.code;
        let a = 1;
        if (datosIn.length > 0){
            datosIn.map(function(el,index){
                let tipo_movimiento =  `SALIDA <i class="fa-solid fa-arrow-down text-danger"></i>`;
                if(el.movimientos_productos_tipo == 1){
                    tipo_movimiento = `INGRESO <i class="fa-solid fa-arrow-up text-success"></i>`;
                }
                body+=
                    `
                    <tr class="contenido_tabla_">
                        <th>${a}</th>
                        <th>${el.nombre_users}</th>
                        <th>${el.movimientos_productos_fecha_creacion}</th>
                        <th>${tipo_movimiento}</th>
                        <th>${el.movimientos_productos_motivo != null ? el.movimientos_productos_motivo : "-----"}</th>
                        <th>
                            <a class="btn btn-sm bg-primary text-white" title="Ver Detalle" onclick="detalle_movimientos(${el.id_movimientos_productos})"><i class="fa fa-eye"></i></a>
                        </th>
                    </tr>

                `
                a++
            })
        }else{
            body+=
                `
                    <tr>
                        <th></th>
                        <th></th>
                        <th class="text-center">SIN REGISTROS </th>
                        <th></th>
                        <th></th>
                        <th>
                        </th>
                    </tr>

                `
        }
        $('#tabla_resultado_busqueda_moviemtos_productos').html(body)
        $('#tablaMoviProductoVi').DataTable()
    });
}

let buscar_productos_movientos = document.getElementById('buscar_productos_movientos');
if(buscar_productos_movientos && buscar_productos_movientos.addEventListener){
    buscar_productos_movientos.addEventListener('keyup',function (){
        buscador_productos_movimientos(this.id)
    });
}
let arrRecursos = []
function buscador_productos_movimientos(id){
    let valor = $('#'+id).val();
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestionventas/buscar_productos",
        data:{
            valor:valor,
            medida:58,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function(r){
        arrRecursos = '';
        let datos = r.result.code
        arrRecursos = [];
        let body = "";
        if(datos.length > 0 ){
            datos.map(function(el,index){
                body +=
                    `
                        <a class="list-group-item list-group-item-action" style="cursor: pointer!important;" onclick="capturar_valor_movimientos_productos(${el.id_pro},'${el.pro_nombre}')" >${el.pro_nombre}</a>
                    `
            })
        }else{
            body +=
                `
                    <a class="list-group-item list-group-item-action">Sin Registros existente</a>
                `
        }
        $('#lista_productos_movimientos').html(body);
    });

    $(document).click(function() {
        var container = $('#lista_productos_movimientos');
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.html("");
        }
    });
}

function capturar_valor_movimientos_productos(id,nombre ){
    // $('#lista_productos_movimientos').html(" ");
    $('#buscar_productos_movientos').val("");
    let conteo = 1;
    if(movimientos_productos.length > 0){
        for(let i = 0; i < movimientos_productos.length; i++){
            if(movimientos_productos[i].id_producto == id){
                conteo++;
            }
        }
        if(conteo == 1){
            let obj = {
                id_producto :id,
                nombre_producto :nombre,
                cantidad : 1,
            }
            movimientos_productos.push(obj);
            dibujar_tabla_productos_()
        }else{
            respuesta('No es posible ingresar un producto más de una vez.', 'error')
        }
    }else{
        let obj = {
            id_producto :id,
            nombre_producto :nombre,
            cantidad : 1,
        }
        movimientos_productos.push(obj);
        dibujar_tabla_productos_()
    }
}
function dibujar_tabla_productos_(){
    let tipoMovimiento = $('#tipo_movimiento').val() * 1;
    let validarStock = 0
    let num = 1;
    let body = ''
    if(tipoMovimiento == 1){
        body = `<h6><span style="color: red">* Rojo si no hay stock de un recurso y no permitirá ingresar stock de producto</span></h6>
                      <table class="table table-hover table-bordered">
                      <thead>
                        <tr class="encabezado_tabla_color">
                            <th>#</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                     <tbody>`;
        if(movimientos_productos.length > 0){
            movimientos_productos.map(function(el, index){
                body+=
                    `
                             <tr>
                                <td>${num}</td>
                                <td>${el.nombre_producto}</td>
                                <td style="width: 70px;"><input type="number" style="width: 70px;" id="cantidad_stock_${index}" class="border-none outline-none"  name="cantidad_stock_${index}" value="${el.cantidad}" onchange="guardar_cantidad_stock_producto(${index})" onkeyup="validar_numeros(this.id)"></td>
                `
                //body+= `<td><ul>`
                // arrRecursos.map(function (el2, index){
                //     if (){
                // let spanStyle = '';
                // let list_recursos = ""
                // let list_can_req = ""
                // let list_can_stock = ""
                // let newCantidad = 0
                // arrRecursos.map(function(el2,index){
                //     if (el2.id_producto == el.id_producto){
                //         newCantidad = el2.detalle_recetas_cantidad * el.cantidad
                //         spanStyle = "style='color: black;'"
                //         if(newCantidad > el2.cantidad_convertida){
                //             spanStyle = "style='color: red;'"
                //             validarStock++;
                //         }
                //         list_recursos +=  `<span ${spanStyle}>- ${el2.recursos_nombre}</span><br>`
                //         list_can_req +=  `<span ${spanStyle}>- ${newCantidad}</span><br>`
                //         list_can_stock +=  `<span ${spanStyle}>- ${el2.cantidad_convertida}</span><br>`
                //
                //     }
                // });
                //
                // body += `
                //             <td style="width: 170px">
                //                 ${list_recursos}
                //             </td>
                //
                //             <td>
                //                 ${list_can_req}
                //             </td>
                //             <td>
                //                 ${list_can_stock}
                //             </td>
                //             `
                // }
                // })
                // arrRecursos.forEach(function (rec){
                //     if(rec.id_producto === el.id_producto){
                //         body+= ``
                //         body+= ``
                //         body+= ``
                //     }
                //
                // });
                //body+= `</ul></td>`
                body+= `
                                <td style="width: 60px; text-align: center">
                                    <a class="btn btn-sm text-white bg-danger" title="Eliminar" type="button" onclick="eliminar_movimientos_productos(${index})"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        `
                num++
            })
        }
        body+=
            `</tbody>
                </table>`
        if(validarStock>0){
            $('#btn_guardar_movimientos_formu').hide();
        }

    }else {
        body = `
                      <table class="table table-hover table-bordered">
                      <thead>
                        <tr class="encabezado_tabla_color">
                            <th>#</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                     <tbody>`;
        if(movimientos_productos.length > 0){
            movimientos_productos.map(function(el, index){
                body+=
                    `
                             <tr>
                                <td>${num}</td>
                                <td>${el.nombre_producto}</td>
                                <td style="width: 70px;"><input type="number" style="width: 70px;" id="cantidad_stock_${index}" class="border-none outline-none"  name="cantidad_stock_${index}" value="${el.cantidad}" onchange="guardar_cantidad_stock_producto(${index})" onkeyup="validar_numeros(this.id)"></td>
                                <td style="width: 60px; text-align: center">
                                    <a class="btn btn-sm text-white bg-danger" title="Eliminar" type="button" onclick="eliminar_movimientos_productos(${index})"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        `
                num++
            })
        }
        body+=
            `</tbody>
                </table>`
        $('#btn_guardar_movimientos_formu').show();

    }

    $('#tabla_productos_realizar_movimientos').html(body);
}

function eliminar_movimientos_productos(index){
    movimientos_productos.splice(index,1)
    dibujar_tabla_productos_()
}
function guardar_cantidad_stock_producto(index){
    movimientos_productos[`${index}`].cantidad = $('#cantidad_stock_' + index).val()
    $('#tabla_productos_realizar_movimientos').html('');
    dibujar_tabla_productos_()
}

function activarMotivimiento(){
    let valor = $('#tipo_movimiento').val();
    if (valor == 1){
        $('#containerMotivo').hide();
    }else{
        $('#containerMotivo').show();
    }
}
$("#formulario_realizar_movimiento_producto").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    let tipoMo = $('#tipo_movimiento').val();
    if (tipoMo == 2){
        var motivo_operacion  = $('#motivo_operacion').val();
        valor = validar_campo_vacio('motivo_operacion', motivo_operacion, valor);
    }
    var boton = 'btn_guardar_movimientos_formu';
    let formulario = new FormData(this);
    formulario.append('datos' , JSON.stringify(movimientos_productos))
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestionventas/realizar_movimientos",
            data:formulario,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta(r.result.message, 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:respuesta(r.result.message, 'error');break;
                    case 3:respuesta(r.result.message, 'error');break;
                    // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                    default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
                }
                cambiar_estado_boton(boton, "Guardar Registro", false);
            }
        });
    }
});


function detalle_movimientos(id_movimiento){
    $('#modal_detalle_movimientos_productos').modal('show');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestionventas/detalle_movimientos_productos",
        data:{
            id_movimiento:id_movimiento,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function(r){
        let body = ""
        let a = 1;
        let datos = r.result.code
        if (datos.length > 0){
            datos.map(function(el,index){
                body+=
                    `
                    <tr>
                        <td>${a}</td>
                        <td>${el.pro_nombre}</td>
                        <td>${el.movimientos_productos_detalle_cantidad}</td>
                    </tr>

                `
                a++
            })
        }else{
            body+=
                `
                    <tr>
                        <td></td>
                        <td class="text-center">SIN REGISTROS </td>
                        <td></td>
                    </tr>

                `
        }
        $('#tabla_detalle_movimiento_producto').html(body)
    });
}



// ── Condición de pago ─────────────────────────────────────────────────────
function actualizarCondicionPago(condicion) {
    let hoy = new Date();
    let fechaVenc = new Date(hoy);

    if (condicion === 'contado') {
        // Contado: muestra panel de pago inmediato
        $('#id_formas_pago').val(1);
        $('#contanierTableDebito').show();
        $('#btn_credito_venta').hide();
        $('#info_credito_automatico').hide();
        fechaVenc = hoy;
    } else if (condicion === 'contra_entrega') {
        // Contra entrega: crédito, 1 cuota en fecha de hoy
        $('#id_formas_pago').val(2);
        $('#contanierTableDebito').hide();
        $('#btn_credito_venta').hide();
        $('#info_credito_automatico').show();
        fechaVenc = hoy;
    } else if (condicion === 'custom') {
        // Crédito libre: abre modal de cuotas manualmente
        $('#id_formas_pago').val(2);
        $('#contanierTableDebito').hide();
        $('#btn_credito_venta').show();
        $('#info_credito_automatico').hide();
    } else {
        // Crédito con días predefinidos: auto-genera 1 cuota
        let dias = parseInt(condicion);
        fechaVenc.setDate(fechaVenc.getDate() + dias);
        $('#id_formas_pago').val(2);
        $('#contanierTableDebito').hide();
        $('#btn_credito_venta').hide();
        $('#info_credito_automatico').show();
    }

    // Actualizar fecha vencimiento
    if (condicion !== 'custom') {
        let y = fechaVenc.getFullYear();
        let m = String(fechaVenc.getMonth() + 1).padStart(2, '0');
        let d = String(fechaVenc.getDate()).padStart(2, '0');
        $('#venta_fecha_vencimiento').val(y + '-' + m + '-' + d);
    }
}

// Auto-genera cuotas cuando la condición es predefinida (no custom)
function generarCuotasAutomaticas() {
    let condicion = $('#venta_condicion_pago').val();
    let total = parseFloat($('#calcular_monto_total_').val()) || 0;
    let fechaVenc = $('#venta_fecha_vencimiento').val();

    if (condicion !== 'contado' && condicion !== 'custom' && total > 0 && fechaVenc) {
        cuotas_venta = [{
            cuota: 1,
            monto: total,
            fecha_pago: new Date(fechaVenc + 'T00:00:00').toLocaleDateString(),
        }];
    }
}
// ── fin condición de pago ──────────────────────────────────────────────────

let tipo_comprobante = document.getElementById('tipo_comprobante');
if(tipo_comprobante && tipo_comprobante.addEventListener){
    tipo_comprobante.addEventListener('change',function (){
        Consultar_serie_();
    });
}
function Consultar_serie_(){
    let  habilitarCheckMoto =  $("#habilitarCheckMoto").is(':checked');
    let  tipo_venta =  $("#tipo_comprobante").val();
    let vll = 0;
    if(tipo_venta == "01"){
        $("#id_tipo_documento").val('4');
        $("#id_tipo_documento__").attr('disabled',true);
        $("#id_tipo_documento__").val(4);
        $("#numero_documento").val('');
        $("#nombre_cliente").val('');
        $("#nombre_tipo_documento").html("Razon Social");
    }else if(tipo_venta == "03"){
        // $("#id_tipo_documento").val(2);
        vll = $('#id_tipo_documento__').val();
        if (vll == 4){
            $('#id_tipo_documento__').val(2);
            $('#id_tipo_documento').val(2);
        }
        $("#id_tipo_documento__").attr('disabled',false);
        // $("#id_tipo_documento__").val(2);
        $("#numero_documento").val('11111111');
        $("#nombre_cliente").val('ANONIMO');
        $("#nombre_tipo_documento").html("Nombre");
    }
    let  concepto = "LISTAR_SERIE";
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestionventas/consultar_serie",
        data: {
            concepto:concepto,
            tipo_venta:tipo_venta,
            checkMoto:habilitarCheckMoto,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        success:function (r) {
            let datos = r.serie;
            let body = "";
            if(datos.length > 0){
                datos.map(function (el,index){
                    body +=
                        `
                        <option value="${el.id_serie}">${el.serie}</option>
                        `
                })
            }
            $("#serie").html(body);
            ConsultarCorrelativo__();
        }

    });
}
function agregar_cliente_venta(tipo_documento,nombre,razonsocial,num_docu,direccion){
    $('#tipo_comprobante').val(tipo_documento == 2 ? "03" : "01");
    Consultar_serie_()
    $('#nombre_cliente').val(tipo_documento == 2 ? nombre : razonsocial);
    $('#id_tipo_documento').val(tipo_documento);
    $('#numero_documento').val(num_docu);
    $('#direccion_cliente').val(direccion);
    $('#modal_clientes_general').modal('hide');
}

function ConsultarCorrelativo__(){
    let id_serie =  $("#serie").val();
    let concepto = "LISTAR_NUMERO";
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestionventas/consultar_serie",
        data: {
            id_serie:id_serie,
            concepto:concepto,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        success:function (r) {
            $("#numero_correlativo").val(r.correlativo);
        }
    });
}
let partir_pago_check = document.getElementById('partir_pago_check');
if(partir_pago_check && partir_pago_check.addEventListener){
    partir_pago_check.addEventListener('change',function (){
        habilitar_partir_pago()
    });
}
function habilitar_partir_pago(){
    let valorCheck = $('#partir_pago_check').is(':checked');
    if(valorCheck){
        $('.contenedorPago2').show(1000);
        // partir_pago.push({'tipo_pago': 0, 'monto': 0});
    }else{
        $('.contenedorPago2').hide(1000);
        // partir_pago.splice(1,1)
    }
    // partir_pago[0].tipo_pago = 0;
    // partir_pago[0].monto = 0;
    $('#id_tipo_pago_2').val("");
    $('#pago_cliente_2').val('');
    $('#pago_cliente').val('');
    $('#id_tipo_pago').val("");
    $('#pago_con_cliente').val(" ");
    calcular_afectacion();
}

let cal_datos_result = [];


// function calcular_afectacion(){
//     let descuento = $('#descuento_global').val()
//     let moneda =  $('#id_moneda').val();
//     let tipo_cambio = 0;
//     let total_pago_cliente = 0;
//     let total_pagoCliete_2 = 0;
//     // VAMOS A AGREGAR EL TEMA DEL VUELTO
//     let pago_cliente = $('#pago_cliente').val()
//     let pa2 = $('#pago_cliente_2').val()
//     if(pa2 == ""){
//         total_pagoCliete_2 = 0;
//     }else{
//         total_pagoCliete_2 = pa2;
//     }
//     total_pago_cliente = parseFloat(pago_cliente) + parseFloat(total_pagoCliete_2);
//     let vuelto = 0.00;
//     let total_descuento = 0.00
//     let desc_porcentaje = descuento / 100 * 1
//     let op_exonerada = 0.00
//     let op_gratuitas = 0.00
//     let sumar_total = 0.00;
//     let sumar_igv = 0.00;
//     let sumar_exo = 0.00;
//     let sumar_ina = 0.00;
//     let sumar_gratuitas = 0.00;
//     let impuesto_bolsa = 0.00;
//     let total = 0.00;
//     let total2 = 0.00;
//     let v = 0.00;
//     let v2 = 0.00;
//     let v3 = 0.00;
//     let v4 = 0.00;
//     let v5= 0.00;
//     let v6= 0.00;
//     let v7= 0.00;
//     let bolsa = 0.00;
//     let desc_total = 0.00;
//     let total_dolar = 0.00;
//     if(moneda == 1){
//         // soles
//         if(ventas_prtoductos.length > 0){
//             ventas_prtoductos.map(function(el, index) {
//                 desc_total += v7 * desc_porcentaje
//                 if(el.id_tipo_afectacion == 1){
//                     v += el.total * 1;
//                     sumar_igv += el.total * 0.18;
//                     v2 = v.toFixed(2)
//                     v3 = sumar_igv.toFixed(2)
//                 }else if(el.id_tipo_afectacion == 2){
//                     sumar_exo += el.total * 1 ;
//                     v4 = (sumar_exo - (sumar_exo * desc_porcentaje * 1)).toFixed(2);
//                     op_exonerada = v4;
//                     if(el.impuesto_bolsa == 1){
//                         impuesto_bolsa += el.cantidad * 0.50;
//                         bolsa = impuesto_bolsa.toFixed(2)
//                     }
//                 }else if(el.id_tipo_afectacion == 3){
//                     sumar_ina += el.total * 1;
//                     v5 = sumar_ina.toFixed(2)
//                 }else if( el.id_tipo_afectacion == 4){
//                     sumar_gratuitas += el.total * 1;
//                     v6 = (sumar_gratuitas - (sumar_gratuitas * desc_porcentaje * 1)).toFixed(2);
//
//                 }
//                 sumar_total += el.total * 1;
//             });
//             total = sumar_igv  + sumar_exo + v + sumar_ina + impuesto_bolsa;
//             total_descuento = parseFloat(total * desc_porcentaje)
//             v7 = (total - (total * desc_porcentaje * 1)).toFixed(2);
//             vuelto = total_pago_cliente - v7;
//             $('#icbper').html("+"+bolsa.toFixed(2));
//             $('#op_exoneradas').html("+"+v4);
//             $('#op_gratuitas').html("+"+v6.toFixed(2));
//             $('#total_venta').html(v7);
//             $('#descuento_global_').html(descuento);
//             $('#descuento_item').html(desc_porcentaje);
//             $('#vuelto_').html(vuelto);
//             $('#pago_con_cliente').html(pago_cliente);
//             $('#descuento_total').html(total_descuento);
//             $('#venta_total_ver').val(v7);
//             $('#monto_total_venta').html("S/"+v7);
//             $('#calcular_monto_total_').val(v7);
//             $('#vali_partir_total').val(v7);
//             cal_datos_result = [v4,v6,v5,v2,descuento,bolsa,total_descuento,v7,vuelto,desc_porcentaje]
//
//         }else{
//             $('#icbper').html("+00.0");
//             $('#op_exoneradas').html("+00.0");
//             $('#op_gratuitas').html("+00.0");
//             $('#total_venta').html("+00.0");
//             $('#descuento_global_').html(" 0 ");
//             $('#descuento_item').html(" 0 ");
//             $('#vuelto_').html("0.00");
//             $('#pago_con_cliente').html("0.00");
//             $('#pago_cliente').val(0);
//             $('#descuento_global').val(0);
//             $('#descuento_total').html("0.00");
//             $('#vali_partir_total').val(0);
//         }
//     }
// }
let buscar_productos_ventas = document.getElementById('buscar_productos_ventas');
if(buscar_productos_ventas && buscar_productos_ventas.addEventListener){
    buscar_productos_ventas.addEventListener('keyup',function (){
        buscar_producto_generar_ventas(this.id)
    });
}
function buscar_producto_generar_ventas(id){
    let valor = $('#'+id).val();
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestionventas/buscar_productos",
        data:{
            valor:valor,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function(r){
        let datos = r.result.code;
        let body = '';
        if(datos.length > 0 ){
            datos.map(function(el,index){
                let familiaTxt = el.fa_nombre
                    ? `<small style="color:#07149b;margin-left:8px">${el.familia_codigo || ''} - ${el.fa_nombre}</small>`
                    : '';
                let serieBadge = el.control_serie ? `<span class='badge bg-primary ms-1' style='font-size:10px'>Serie</span>` : '';
                body += `<a class="list-group-item list-group-item-action" style="cursor:pointer;padding:8px 12px" onclick="capturar_valores_ventas_productos(${el.id_pro},'${el.pro_nombre}','${el.id_tipo_afectacion}','${el.impuesto_bolsa}','${el.pro_precio_uni}','${el.pro_precio_uni_ma}',${el.pro_porcen_igv},${el.pro_stock},${el.id_medida},'${encodeURIComponent(el.pro_descripcion || '')}',${el.control_serie || 0},'${encodeURIComponent(el.pro_codigo || '')}','${encodeURIComponent(el.fa_nombre || '')}','${encodeURIComponent(el.familia_codigo || '')}')">
                    <div style="font-weight:600;font-size:13px">${el.pro_nombre}${serieBadge}</div>
                    <div style="margin-top:2px"><small style="font-family:monospace;color:#6b7280;font-size:11px">${el.pro_codigo || ''}</small>${familiaTxt}</div>
                </a>`
            })
        }else{
            body += `<a class="list-group-item list-group-item-action">Sin Registros existente</a>`
        }
        $('#lista_productos_ventas').html(body);
    });
    $(document).click(function() {
        var container = $('#lista_productos_ventas');
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.html("");
        }
    });
}


let _pendingProductoSerie = null;

function capturar_valores_ventas_productos(id,nombre,afectacion,bolsa,precio,precio_ma,porce_igv,stock,idmedida,descr = null, control_serie = 0, pro_codigo = '', fa_nombre = '', fa_codigo = ''){

    descr = descr || '';
    descr = decodeURIComponent(descr);
    pro_codigo = pro_codigo ? decodeURIComponent(pro_codigo) : '';
    fa_nombre  = fa_nombre  ? decodeURIComponent(fa_nombre)  : '';
    fa_codigo  = fa_codigo  ? decodeURIComponent(fa_codigo)  : '';

    $('#buscar_productos_ventas').val('');
    $('#lista_productos_ventas').html('');
    let conteo = 1;

    for(let i = 0; i < ventas_prtoductos.length; i++){
        if(ventas_prtoductos[i].id_pro == id){
            conteo++;
        }
    }

    if(conteo > 1){
        respuesta('No es posible ingresar un producto más de una vez.', 'error');
        return;
    }

    let obj = {
        id_pro: id,
        id_medida: idmedida,
        nombre_producto: nombre,
        pro_codigo: pro_codigo,
        fa_nombre: fa_nombre,
        fa_codigo: fa_codigo,
        id_tipo_afectacion: afectacion,
        impuesto_bolsa: bolsa,
        precio_venta: precio,
        precio_mayor: precio_ma,
        cantidad: 1,
        descuento: 0,
        total: precio * 1,
        porcentaje_igv: porce_igv,
        stock_actual: stock,
        descripcion: descr,
        control_serie: control_serie,
        id_serie_producto: null,
        numero_serie: null,
    };

    if(parseInt(control_serie) === 1){
        _pendingProductoSerie = obj;
        $('#serie_modal_producto_nombre').text(nombre);
        $('#tbody_series_vehiculo').html('<tr><td colspan="5" class="text-center text-muted">Cargando...</td></tr>');
        $('#msg_sin_series').addClass('d-none');
        $('#modal_series_vehiculo').modal('show');
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestionventas/buscar_series_producto",
            data: { id_pro: id, "_token": $("meta[name='csrf-token']").attr("content") },
            dataType: 'json',
        }).done(function(r){
            let series = r.result.data;
            if(series.length > 0){
                let body = '';
                series.map(function(s){
                    body += `<tr>
                        <td><strong>${s.numero_serie}</strong></td>
                        <td>${s.numero_motor || '---'}</td>
                        <td>${s.color || '---'}</td>
                        <td>${s.anio_fabricacion || '---'}</td>
                        <td><button class="btn btn-sm btn-primary" onclick="seleccionar_serie(${s.id_serie_producto},'${s.numero_serie}')"><i class="fa fa-check"></i> Seleccionar</button></td>
                    </tr>`;
                });
                $('#tbody_series_vehiculo').html(body);
            } else {
                $('#tbody_series_vehiculo').html('');
                $('#msg_sin_series').removeClass('d-none');
            }
        });
    } else {
        ventas_prtoductos.push(obj);
        respuesta('Producto agregado.', 'success');
        localStorage.setItem('ventas_productos', JSON.stringify(ventas_prtoductos));
        dibujar_tabla_ventas_productos();
    }
}

function seleccionar_serie(id_serie_producto, numero_serie){
    if(_pendingProductoSerie){
        _pendingProductoSerie.id_serie_producto = id_serie_producto;
        _pendingProductoSerie.numero_serie = numero_serie;
        ventas_prtoductos.push(_pendingProductoSerie);
        _pendingProductoSerie = null;
        localStorage.setItem('ventas_productos', JSON.stringify(ventas_prtoductos));
        dibujar_tabla_ventas_productos();
        $('#modal_series_vehiculo').modal('hide');
        respuesta('Producto con serie ' + numero_serie + ' agregado.', 'success');
    }
}
function dibujar_tabla_ventas_productos(){
    let num = 1;
    let body = "";
    if(ventas_prtoductos.length > 0){
        ventas_prtoductos.map(function(el, index){
            let serieInfo = '';
            if(parseInt(el.control_serie) === 1 && el.numero_serie){
                serieInfo = `<br><small class="badge bg-primary">Serie: ${el.numero_serie}</small>`;
            }
            let familiaInfo = (el.fa_nombre)
                ? `<br><small style="color:#07149b;font-size:10px">${el.fa_codigo || ''} - ${el.fa_nombre}</small>`
                : '';
            let codigoInfo = (el.pro_codigo)
                ? `<br><small style="font-family:monospace;color:#6b7280;font-size:10px">${el.pro_codigo}</small>`
                : '';
            let cantidadInput = parseInt(el.control_serie) === 1
                ? `<input type="number" style="width:80px;background:#f6f8fb" id="cantidad_producto${index}" class="outline-none form-control" name="cantidad_producto${index}" value="1" readonly>`
                : `<input type="number" style="width:80px;background:#fff" id="cantidad_producto${index}" class="outline-none form-control" name="cantidad_producto${index}" value="${el.cantidad}" onchange="guardar_cambios_venta_productos(${index},'${el.id_pro}',${el.precio_venta},${el.precio_mayor})" onkeyup="validar_numeros(this.id)">`;
            let ventaNeta = fmtMonto(el.total || 0);
            body+=
                `<tr>
                    <td>
                        <span style="font-weight:600">${el.nombre_producto}</span>${serieInfo}${codigoInfo}${familiaInfo}
                    </td>
                    <td>
                        <textarea class="form-control" name="descripcionDatos_${index}" id="descripcionDatos_${index}" onchange="cambiarDescripcion(${index})" rows="3" style="min-width:120px">${el.descripcion && el.descripcion != 'null' ? el.descripcion : ''}</textarea>
                    </td>
                    <td style="text-align:center">${el.id_medida == 58 ? el.stock_actual : '∞'}</td>
                    <td>${cantidadInput}</td>
                    <td>
                        <input type="text" style="width:85px" class="outline-none form-control" onchange="cambiarPrecioVenta(${index})" onkeyup="validar_numeros(this.id)" id="precio_venta_${index}" value="${el.cantidad >= 12 ? el.precio_mayor : el.precio_venta}">
                    </td>
                    <td>
                        <input type="number" style="width:70px" min="0" max="100" class="outline-none form-control" onchange="cambiarDescuento(${index})" onkeyup="validar_numeros(this.id)" id="descuento_prod_${index}" value="${el.descuento || 0}">
                    </td>
                    <td>
                        <input type="text" style="width:85px;background:none" id="total_venta_producto_${index}" disabled class="border-none outline-none form-control" name="total_venta_producto_${index}" value="${ventaNeta}">
                    </td>
                    <td>
                        <a class="btn btn-sm text-white bg-danger" title="Eliminar" type="button" onclick="eliminar_productos_ventas(${index})"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>`
            num++
        })
    }
    $('#tabla_productos_ventas').html(body);
    calcular_afectacion();
    $(document).ready(function(){
        $('input[type="number"]').on('input', function() {
            var valor = $(this).val();
            if (valor < 0) {
                $(this).val(0);
            }
        });
    });
}
function  cambiarPrecioVenta(index){
    let cantidad = parseFloat($('#cantidad_producto'+index).val()) || 1;
    let precio = parseFloat($('#precio_venta_'+index).val()) || 0;
    let desc = parseFloat(ventas_prtoductos[index].descuento || 0);
    if (cantidad >= 12){
        ventas_prtoductos[`${index}`].precio_mayor = precio;
    }else{
        ventas_prtoductos[`${index}`].precio_venta = precio;
    }
    ventas_prtoductos[`${index}`].total = parseFloat((precio * cantidad * (1 - desc / 100)).toFixed(2));
    calcular_afectacion();
    dibujar_tabla_ventas_productos();
    localStorage.setItem('ventas_productos', JSON.stringify(ventas_prtoductos));
}

function cambiarDescuento(index){
    let desc = parseFloat($('#descuento_prod_'+index).val());
    if (isNaN(desc)) desc = 0;
    if (desc > 100) {
        respuesta('El descuento no puede superar el 100%.', 'error');
        desc = 0;
        $('#descuento_prod_'+index).val(0);
    }
    ventas_prtoductos[index].descuento = desc;
    let cantidad = parseFloat(ventas_prtoductos[index].cantidad) || 1;
    let precio = parseFloat(ventas_prtoductos[index].cantidad >= 12 ? ventas_prtoductos[index].precio_mayor : ventas_prtoductos[index].precio_venta) || 0;
    let total = parseFloat((precio * cantidad * (1 - desc / 100)).toFixed(2));
    ventas_prtoductos[index].total = total;
    $('#total_venta_producto_'+index).val(fmtMonto(total));
    calcular_afectacion();
    localStorage.setItem('ventas_productos', JSON.stringify(ventas_prtoductos));
}
function  cambiarDescripcion(index){
    let cantidad = $('#descripcionDatos_'+index).val();
    ventas_prtoductos[`${index}`].descripcion = cantidad;
    localStorage.setItem('ventas_productos', JSON.stringify(ventas_prtoductos));
    dibujar_tabla_ventas_productos()
}
function eliminar_productos_ventas(index){
    ventas_prtoductos.splice(index,1)
    calcular_afectacion()
    dibujar_tabla_ventas_productos()
    localStorage.setItem('ventas_productos', JSON.stringify(ventas_prtoductos));

}

function guardar_cambios_venta_productos(index,id_producto,precio_uni,precio_mayo){
    let precio = 0;
    let cantidad = parseFloat($('#cantidad_producto'+index).val()) || 1;
    if (cantidad >= 12){
        precio = precio_mayo;
    }else{
        precio = precio_uni;
    }
    $('#precio_venta_'+index).val(precio);
    let desc = parseFloat(ventas_prtoductos[index].descuento || 0);
    let resultado = (parseFloat(cantidad) * parseFloat(precio) * (1 - desc / 100)).toFixed(2);
    $('#total_venta_producto_'+index).val(fmtMonto(parseFloat(resultado)));
    ventas_prtoductos[`${index}`].cantidad = cantidad;
    ventas_prtoductos[`${index}`].total = parseFloat(resultado);
    calcular_afectacion();
    localStorage.setItem('ventas_productos', JSON.stringify(ventas_prtoductos));
}
function fmtMonto(n) {
    let parts = parseFloat(n || 0).toFixed(2).split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    return parts.join('.');
}
function calcular_afectacion(){
    // VAMOS A AGREGAR EL TEMA DEL VUELTO
    let total_pago_cliente = 0;
    let total_pagoCliete_2 = 0;
    let pago_cliente = $('#pago_cliente').val()
    let pa2 = $('#pago_cliente_2').val()
    if(pa2){
        total_pagoCliete_2 = pa2;
    }
    total_pago_cliente = parseFloat(pago_cliente) + parseFloat(total_pagoCliete_2);

    let vuelto = 0.00;
    let op_exonerada = 0.00
    let op_gratuitas = 0.00
    let sumar_total = 0.00;
    let sumar_igv = 0.00;
    let sumar_exo = 0.00;
    let sumar_ina = 0.00;
    let sumar_gratuitas = 0.00;
    let total = 0.00;
    let v = 0.00;
    let igv = 0.00;
    let v2 = 0.00;
    let v3 = 0.00;
    let v4 = 0.00;
    let v5= 0.00;
    let v6= 0.00;
    let v7= 0.00;
    // let bolsa = 0.00;
    // let desc_total = 0.00;
    let impuesto_bolsa = 0.00;
    if(ventas_prtoductos.length > 0){
        ventas_prtoductos.map(function(el, index) {
            let precio_final = 0;
            if (el.cantidad >= 12){
                precio_final = el.precio_mayor;
            }else{
                precio_final = el.precio_venta;
            }
            // aplicar descuento por producto
            precio_final = precio_final * (1 - (parseFloat(el.descuento || 0) / 100));
            if(el.id_tipo_afectacion == 1){
                v += precio_final * 1;
                let menosC = precio_final - (precio_final / el.porcentaje_igv);
                sumar_igv += (menosC * el.cantidad);
                v3 += ((precio_final - menosC) *  el.cantidad);
                if (el.impuesto_bolsa == 1){
                    impuesto_bolsa+= el.cantidad * 0.50;
                }
            }else if(el.id_tipo_afectacion == 2){
                v4 += parseFloat((precio_final * 1) * el.cantidad);
            }else if(el.id_tipo_afectacion == 3){
                v5 += parseFloat((precio_final * 1) * el.cantidad);
            }else if( el.id_tipo_afectacion == 4){
                v6 += parseFloat((precio_final * 1) * el.cantidad);
            }
        });
        total = parseFloat(v3) + parseFloat(v4) + parseFloat(v5) + parseFloat(sumar_igv) + parseFloat(impuesto_bolsa);

        // ── Descuento global ──────────────────────────────────────────────
        let tipo_desc   = $('#tipo_descuento').val()  || 'pct';
        let valor_desc  = parseFloat($('#valor_descuento').val()) || 0;
        let descuento_monto = 0;
        let total_afectable = parseFloat(v3) + parseFloat(v4) + parseFloat(v5) + parseFloat(sumar_igv);

        if (valor_desc > 0 && total_afectable > 0) {
            if (tipo_desc === 'pct') {
                descuento_monto = total_afectable * (valor_desc / 100);
            } else {
                descuento_monto = Math.min(valor_desc, total_afectable);
            }
            let factor = (total_afectable - descuento_monto) / total_afectable;
            v3        *= factor;
            sumar_igv *= factor;
            v4        *= factor;
            v5        *= factor;
            v6        *= factor;
            total = v3 + v4 + v5 + sumar_igv + parseFloat(impuesto_bolsa);
        }
        // ── fin descuento ─────────────────────────────────────────────────

        v7 = total.toFixed(2);
        vuelto = total_pago_cliente - v7;
        $('#op_exoneradas').html("+"+fmtMonto(v4));
        $('#op_gratuitas').html("+"+fmtMonto(v6));
        $('#op_inafectada').html("+"+fmtMonto(v5));
        $('#op_gravada').html("+"+fmtMonto(v3));
        $('#totaligv').html("+"+fmtMonto(sumar_igv));
        $('#icbper').html("+"+fmtMonto(impuesto_bolsa));
        $('#descuento_total_display').html("-"+fmtMonto(descuento_monto));
        $('#total_venta').html(fmtMonto(v7));
        $('#vali_partir_total').val(v7);
        $('#monto_total_venta').html(fmtMonto(v7));
        $('#calcular_monto_total_').val(v7);
        if (!isNaN(vuelto)) {
            $('#vuelto_').html(fmtMonto(vuelto));
        } else {
            $('#vuelto_').html(fmtMonto(0));
        }

    }else{
        $('#op_exoneradas').html("+0.00");
        $('#op_gratuitas').html("+0.00");
        $('#total_venta').html("0.00");
        $('#op_inafectada').html("+0.00");
        $('#op_gravada').html("+0.00");
        $('#icbper').html("+0.00");
        $('#totaligv').html("+0.00");
        $('#descuento_total_display').html("-0.00");
        $('#vuelto_').html("0.00");
        $('#vali_partir_total').val(0);
        $('#monto_total_venta').html("0.00");
        $('#calcular_monto_total_').val(0);
        // $('#descuento_global_').html(" 0 ");
        // $('#descuento_item').html(" 0 ");
        // $('#vuelto_').html("0.00");
        // $('#pago_con_cliente').html("0.00");
        // $('#pago_cliente').val(0);
        // $('#descuento_global').val(0);
        // $('#descuento_total').html("0.00");
        // $('#vali_partir_total').val(0);
        // cal_datos_result = [v4,v6,v5,v2,impuesto_bolsa,total_descuento,v7,vuelto,desc_porcentaje]
    }
    var resultado = sumar_igv;
    resultado = Math.round(resultado * 100) / 100; // Redondeo convencional
    resultado = resultado.toFixed(2);
    let obj = {
        op_exo:          v4,
        op_gratu:        v6,
        op_inafec:       v5,
        op_grava:        v3.toFixed(2),
        icbper:          impuesto_bolsa,
        total_igv:       resultado,
        total:           v7,
        vuelto:          typeof vuelto !== 'undefined' ? vuelto.toFixed(2) : '0.00',
        pago_cliente:    total_pago_cliente,
        descuento_tipo:  typeof tipo_desc  !== 'undefined' ? tipo_desc  : 'pct',
        descuento_valor: typeof valor_desc !== 'undefined' ? valor_desc : 0,
        descuento_monto: typeof descuento_monto !== 'undefined' ? descuento_monto.toFixed(2) : '0.00',
    }
    cal_datos_result = obj
}
function dar_sobras_pago2(){
    let total = $('#vali_partir_total').val();
    let checkPago = $('#partir_pago_check').is(':checked');
    let resultado = 0;
    let monto1 = $('#pago_cliente').val();
    if(checkPago){
        if(monto1 > total){
            respuesta('Monto es mayor al total a pagar', 'error')
        }else{
            resultado = (total -  monto1).toFixed(2)
            $('#pago_cliente_2').val(resultado);
            $('#pago_con_cliente').html(total);
        }
    }else{
        $('#pago_con_cliente').html(monto1);
    }
    calcular_afectacion();
}
let id_formas_pago = document.getElementById('id_formas_pago');
if(id_formas_pago && id_formas_pago.addEventListener){
    id_formas_pago.addEventListener('change',function (){
        habilitar_cuotas(this.id)
    });
}
function habilitar_cuotas(id){
    let valor = $('#'+id).val();
    if(valor == 2){
        $('#btn_credito_venta').show(1000);
        $('#contanierTableDebito').hide(1000);
        $('#vuelto_').html(0)
        $('#partir_pago_check').prop('checked',false)
        habilitar_partir_pago()
    }else{
        $('#btn_credito_venta').hide(1000);
        $('#contanierTableDebito').show(1000);

    }
}


let cantidad_cuota__ = document.getElementById('cantidad_cuota__');
if(cantidad_cuota__ && cantidad_cuota__.addEventListener){
    cantidad_cuota__.addEventListener('change',function (){
        listar_cuotas_venta(this.id)
    });
}
function listar_cuotas_venta(id){
    let va = $('#'+id).val();
    cuotas_venta = [];
    for (let i=1; i<=va; i++){
        let obje = {
            cuota: i,
            monto: 0,
            fecha_pago:' ',
        }
        cuotas_venta.push(obje);

    }
    dibujar_input_cuota();
}
function dibujar_input_cuota(){
    if(cuotas_venta.length > 0){
        let conteo = 1;
        let body =`
                            <p id="mensaje_error_cantidad_cuota" class="text-danger"></p>
                            <p id="mensaje_error_fechas_cuotas" class="text-danger"></p>
                            <table class="table table-hover">
                            <thead>
                                <tr>
                                      <th>Cuota</th>
                                      <th>Monto</th>
                                      <th>Fecha de pago</th>
                                      <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            `
        cuotas_venta.map(function (el,index){
            body +=
                `
                <tr>
                      <td>${conteo}</td>
                      <td>
                        <input type="text" class="form-control" name="monto_cantidad_${index}" id="monto_cantidad_${index}" value="${el.monto}" onchange="cambiar_monto_pago(${index})">
                      </td>
                      <td>
                            <input type="date" class="form-control" name="fecha_pago_${index}" id="fecha_pago_${index}" onchange="agregarFecha(${index})" value="${el.fecha_pago}" >
                      </td>
                      <td>
                            <button class="btn btn-sm text-white bg-danger" onclick="eliminar_cuota_(${index})"><i class="fa fa-trash"></i></button>
                      </td>
                </tr>
                `
            conteo++
        });

        body +=`
            </tbody>
            </table>`
        $('#contenido_cuotas_').html(body);
    }
}
function  eliminar_cuota_(index){
    cuotas_venta.splice(index,1)
    $('#cantidad_cuota__').val(cuotas_venta.length)
    dibujar_input_cuota();
}
function sumar_todo (){
    let tb = 0
    cuotas_venta.map(function(el){
        tb += el.monto
    });
    return  tb;
}
function cambiar_monto_pago(index){
    let total_pagar = $('#calcular_monto_total_').val();
    let monto_t = $('#monto_cantidad_'+index).val();
    cuotas_venta[`${index}`].monto = parseFloat(monto_t)
    let suma = sumar_todo();
    if(suma > total_pagar){
        cuotas_venta[`${index}`].monto = 0
        $('#monto_cantidad_'+index).val(0);
        $('#mensaje_error_cantidad_cuota').html("La suma total de las cuotas excede el monto total a pagar.");
        $('#mensaje_error_cantidad_cuota').removeClass("text-warning")
        $('#mensaje_error_cantidad_cuota').addClass("text-danger")
    }else{
        if(total_pagar == suma ){
            $('#mensaje_error_cantidad_cuota').html("");
        }else{
            $('#mensaje_error_cantidad_cuota').html("La suma total de las cuotas debe ser igual al monto a pagar");
            $('#mensaje_error_cantidad_cuota').removeClass("text-danger")
            $('#mensaje_error_cantidad_cuota').addClass("text-warning")
        }

    }
}

function agregarFecha(index){
    let fecha_nueva = $('#fecha_pago_' + index).val();
    let fecha_actual = new Date(); // Obtener la fecha actual
    fecha_actual.setHours(0, 0, 0, 0); // Establecer la hora a las 00:00:00

    if (cuotas_venta.some(cuota => cuota.fecha_pago instanceof Date)) {
        if (!validarFechasAnteriores(fecha_nueva)) {
            $('#mensaje_error_fechas_cuotas').html("Las fechas de las cuotas deben ser posteriores a las fechas anteriores.");
            $('#fecha_pago_' + index).val("");
        } else {
            let fecha_nueva_obj = new Date(fecha_nueva);
            fecha_nueva_obj.setHours(0, 0, 0, 0); // Establecer la hora a las 00:00:00

            if (fecha_nueva_obj <= fecha_actual) { // Validar si es menor o igual a la fecha actual
                $('#mensaje_error_fechas_cuotas').html("La fecha debe ser posterior a la fecha actual.");
                $('#fecha_pago_' + index).val("");
            } else {
                cuotas_venta[`${index}`].fecha_pago = fecha_nueva_obj.toLocaleDateString(); // Cambio aquí para guardar la fecha en formato legible
                $('#mensaje_error_fechas_cuotas').html("");
            }
        }
    } else {
        let fecha_nueva_obj = new Date(fecha_nueva);
        fecha_nueva_obj.setHours(0, 0, 0, 0); // Establecer la hora a las 00:00:00

        if (fecha_nueva_obj <= fecha_actual) { // Validar si es menor o igual a la fecha actual
            $('#mensaje_error_fechas_cuotas').html("La fecha debe ser posterior a la fecha actual.");
            $('#fecha_pago_' + index).val("");
        } else {
            cuotas_venta[`${index}`].fecha_pago = fecha_nueva_obj.toLocaleDateString(); // Cambio aquí para guardar la fecha en formato legible
        }
    }
    // let fecha_nueva = $('#fecha_pago_'+index).val();
    // let fecha_actual = new Date(); // Obtener la fecha actual
    // if (cuotas_venta.some(cuota => cuota.fecha_pago instanceof Date)) {
    //     if (!validarFechasAnteriores(fecha_nueva)) {
    //         $('#mensaje_error_fechas_cuotas').html("Las fechas de las cuotas deben ser posteriores a las fechas anteriores.");
    //         $('#fecha_pago_' + index).val("");
    //     } else if (new Date(fecha_nueva) <= fecha_actual) { // Validar si es menor o igual a la fecha actual
    //         $('#mensaje_error_fechas_cuotas').html("La fecha debe ser posterior a la fecha actual.");
    //         $('#fecha_pago_' + index).val("");
    //     } else {
    //         cuotas_venta[`${index}`].fecha_pago = new Date(fecha_nueva);
    //         $('#mensaje_error_fechas_cuotas').html("");
    //     }
    // } else if (new Date(fecha_nueva) <= fecha_actual) { // Validar si es menor o igual a la fecha actual
    //     $('#mensaje_error_fechas_cuotas').html("La fecha debe ser posterior a la fecha actual.");
    //     $('#fecha_pago_' + index).val("");
    // } else {
    //     cuotas_venta[`${index}`].fecha_pago = new Date(fecha_nueva);
    // }
    // // let validar = validarFechasAnteriores(fecha_nueva);
    // if (cuotas_venta.some(cuota => cuota.fecha_pago instanceof Date)) {
    //     if (!validarFechasAnteriores(fecha_nueva)) {
    //         $('#mensaje_error_fechas_cuotas').html("Las fechas de las cuotas deben ser posteriores a las fechas anteriores.");
    //         $('#fecha_pago_'+index).val("");
    //     }else{
    //         cuotas_venta[`${index}`].fecha_pago = new Date(fecha_nueva);
    //         $('#mensaje_error_fechas_cuotas').html("");
    //     }
    // }else{
    //     cuotas_venta[`${index}`].fecha_pago = new Date(fecha_nueva);
    // }
}
function validarFechasAnteriores(fecha_nueva){
    const fechasAnteriores = cuotas_venta.map(cuota => cuota.fecha_pago);

    const fechaNuevaObjeto = new Date(fecha_nueva); // Convertir a objeto Date

    if (fechasAnteriores.some(fecha => fechaNuevaObjeto <= fecha)) {
        return false; // Hay una fecha menor o igual
    }

    return true; // Todas las fechas anteriores son mayores
}
$("#formulario_generar_venta").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_realizar_venta__';
    var id_tipo_documento  = $('#id_tipo_documento__').val();
    var nombre_cliente  = $('#nombre_cliente').val();
    var numero_documento  = $('#numero_documento').val();
    var pago_cliente  = $('#pago_cliente').val();
    var id_tipo_pago  = $('#id_tipo_pago').val();
    var id_formas_pago  = $('#id_formas_pago').val();
    valor = validar_campo_vacio('nombre_cliente', nombre_cliente, valor);
    if (id_formas_pago == 1){
        valor = validar_campo_vacio('pago_cliente', pago_cliente, valor);
        valor = validar_campo_vacio('id_tipo_pago', id_tipo_pago, valor);
    }

    if(id_tipo_documento == 2){
        if (numero_documento.length == 8){
            valor == true
        }else{
            valor == false
            respuesta('El numero de documento debe tener 8 caracteres', 'error')
        }
    }
    if(id_tipo_documento == 4){
        if (numero_documento.length == 11){
            valor == true
        }else{
            valor == false
            respuesta('El numero de documento debe tener 11 caracteres', 'error')
        }
    }
    // Auto-generar cuotas para condiciones predefinidas
    generarCuotasAutomaticas();

    let formulario = new FormData(this);
    formulario.append('datos' , JSON.stringify(ventas_prtoductos))
    formulario.append('calculo' , JSON.stringify(cal_datos_result))
    formulario.append('cuotas' , JSON.stringify(cuotas_venta))
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestionventas/generar_venta",
            data:formulario,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta(r.result.message, 'success');
                        // Limpiar el array ventas_prtoductos
                        // ventas_prtoductos = [];
                        // Limpiar los datos almacenados en el LocalStorage
                        localStorage.removeItem('ventas_productos');
                        setTimeout(function () {
                            window.open(ruta_global + 'Gestionventas/venta_detalle/'+'?venta_id=' + encodeURIComponent(r.result.id_venta), '_self');
                        }, 2000);
                        break;
                    case 2:respuesta(r.result.message, 'error');break;
                    case 3:respuesta(r.result.message, 'error');break;
                    case 4:respuesta(r.result.message, 'error');break;
                    case 5:respuesta(r.result.message, 'error');break;
                    case 6:respuesta(r.result.message, 'error');break;
                    case 7:respuesta(r.result.message, 'error');break;
                    case 8:respuesta(r.result.message, 'error');break;
                    case 9:respuesta(r.result.message, 'error');break;
                    case 10:respuesta(r.result.message, 'error');break;
                    case 11:respuesta(r.result.message, 'error');break;
                    case 12:respuesta(r.result.message, 'error');break;
                    case 13:respuesta(r.result.message, 'error');break;
                    case 14:respuesta(r.result.message, 'error');break;
                    // case 6:respuesta('Algún dato NO fue ingresado  correctamente', 'error');break;
                    default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
                }
                cambiar_estado_boton(boton, "<i class='fa fa-money-bill'></i> Cobrar", false);
            }
        });
    }
});


$("#FormularioEnviarComprobanteEmail").on('submit', function (e) {
    e.preventDefault();
    var valor = true;
    var boton = 'envirMensaje';
    var id_venta = $('#id_venta').val();
    var correoDestino = $('#correoDestino').val();
    valor = validar_campo_vacio('id_venta', id_venta, valor);
    valor = validar_campo_vacio('correoDestino', correoDestino, valor);
    if (valor) {
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestionventas/enviarComprobanteporCorreo",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Enviando...', true);
            },
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta(r.result.message, 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta(r.result.message, 'error');
                        break;
                    case 3:
                        respuesta(r.result.message, 'error');
                        break;
                    case 6:
                        respuesta(r.result.message, 'error');
                        break;
                    // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
                cambiar_estado_boton(boton, "Guardar Registro", false);
            }
        });
    }
});

let productos_proformas = document.getElementById('productos_proformas');
if(productos_proformas && productos_proformas.addEventListener){
    productos_proformas.addEventListener('keyup',function (){
        listar_productos_proformas(this.id)
    });
}

function listar_productos_proformas(id){
    let valor = $('#'+id).val();
    // let estado = $('#id_tipo_venta').val();
    if(valor.length>0){
        $.ajax({
            type: "POST",
            url: ruta_global + "logistica/buscador_productos",
            data:{
                valor:valor,
                "_token": $("meta[name='csrf-token']").attr("content")
            },
            dataType: 'json',
        }).done(function(r){
            let datos = r.result.code;
            let body = "";
            if(datos.length > 0 ){
                datos.map(function(el,index){
                    body +=
                        `
                            <a class="list-group-item list-group-item-action"  style="cursor: pointer!important;" onclick="capturar_productos_proformas(${el.id_pro},'${el.pro_nombre}',${el.pro_precio_uni},${el.pro_precio_uni_ma},${el.pro_stock},'${el.pro_codigo}' )" >${el.pro_nombre}</a>
                            `
                })
            }else{
                body +=
                    `
                        <a class="list-group-item list-group-item-action" >Sin Registros existente</a>
                    `
            }
            $('#listar_productos_proformas').html(body);
        });
    }else{
        $('#listar_productos_proformas').html('');
    }
    $(document).click(function() {
        var container = $('#listar_productos_proformas');
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.html("");
        }
    });

}

function capturar_productos_proformas(id,producto,precio_unit,precio_mayor,stock,codigo){
    // $('#listar_productos_proformas').html(" ");
    // $('#productos_proformas').val(" ");
    $('#mensajeErrorProforma').html(" ");

    let conteo = 1;
    if(proformas_productos.length > 0){
        for(let i = 0; i < proformas_productos.length; i++){
            if(proformas_productos[i].id_pro == id){
                conteo++;
            }
        }
        if(conteo == 1){
            let obj = {
                id_pro :id,
                producto_nombre: producto,
                producto_precio_unit : precio_unit,
                producto_precio_mayo : precio_mayor,
                producto_precio_final: precio_unit,
                comentarios: "",
                stock_actual : stock,
                producto_codigo : codigo,
                cantidad : 1,
                precio_subtotal : precio_unit * 1,
            }
            proformas_productos.push(obj);
            localStorage.setItem('productos_proforma', JSON.stringify(proformas_productos));
            dibujar_tabla_productos_proformas()
        }else{
            respuesta('No es posible ingresar un recurso más de una vez.', 'error')
        }
    }else{
        let obj = {
            id_pro :id,
            producto_nombre: producto,
            producto_precio_unit : precio_unit,
            producto_precio_mayo : precio_mayor,
            producto_precio_final: precio_unit,
            comentarios: "",
            stock_actual : stock,
            producto_codigo : codigo,
            cantidad : 1,
            precio_subtotal : precio_unit * 1,
        }
        proformas_productos.push(obj);
        localStorage.setItem('productos_proforma', JSON.stringify(proformas_productos));
        dibujar_tabla_productos_proformas()
    }
}
function dibujar_tabla_productos_proformas(){
    let num = 1;
    let total = 0;
    let body = `<table class="table table-hover table-bordered">
                      <thead>
                        <tr class="encabezado_tabla_color">
                            <th>Item</th>
<!--                            <th>Código</th>-->
                            <th>Descripción</th>
                            <th>Comentario</th>
                            <th>P. referencia</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Total</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                     <tbody>`;
    if(proformas_productos.length > 0){
        proformas_productos.map(function(el, index){
            body+=
                `
                             <tr style="background: ${el.stock_actual == 0 ? '#F85464' : 'none'};color: ${el.stock_actual == 0 ? 'white' : 'black'}">
                                <td>${num}</td>
                                <td>
                                    <p> ${el.producto_nombre} </p> <br>
                                    <p> CODIGO: ${el.producto_codigo}</p> <br>
                                    <p>STOCK: <b> ${el.stock_actual}</b></p>
                                </td>
                                <td>
                                    <textarea  id="descripcion_producto_${index}" class="form-control" rows="4" onchange="guardar_descripcion(${index})">
                                        ${el.comentarios ? el.comentarios:''}
                                    </textarea>
                                </td>

                                 <td>
                                    <p>P. Unit: <b>S/ ${el.producto_precio_unit}</b></p> <br>
                                    <p>P. Mayo: <b>S/ ${el.producto_precio_mayo}</b></p>
                                </td>
                                <td><input type="number" class="form-control w-px-100 border-none outline-none " onkeyup="validar_numeros(this.id)" onchange="guardarCambiosProformas(${index},'${el.stock_actual}')" id="cantiad__${index}" name="cantiad__${index}" value="${el.cantidad}"></td>
                                <td><input type="text" onkeyup="validar_numeros(this.id)"  id="precio_final_compra_${index}" class="form-control w-px-100 border-none outline-none" onchange="guardarCambiosProformas(${index},'${el.stock_actual}')" name="precio_final_compra_${index}" value="${el.producto_precio_final}"></td>
                                <td><input type="text" readonly id="subtotal_${index}" class="form-control w-px-100  border-none outline-none" name="subtotal_${index}" value="${el.precio_subtotal}"></td>
                                <td>
                                    <a class="btn btn-sm text-white bg-danger" type="button" onclick="eliminar_producto_proforma(${index})"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        `
            total= total + parseFloat(el.precio_subtotal)
            num++
        })
    }
    body+= `
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>TOTAL</td>
            <td><h4 class="text-danger">S/${total}</h4></td>
            <td></td>
        </tr>
    `
    body+=
        `</tbody>
                </table>`

    $('#container_table_proformas_productos').html(body);
    // total_orden_compra();
}
function listarDatosProforma(id){
    $.ajax({
        type: "POST",
        url: ruta_global + "logistica/listarInformacionProforma",
        data:{
            data:id,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function(r){
        let datos = r.result.code;
        let detalle = r.result.detalle;

    });
}
function eliminar_producto_proforma(index){
    proformas_productos.splice(index,1)
    localStorage.setItem('productos_proforma', JSON.stringify(proformas_productos));
    dibujar_tabla_productos_proformas()
    // localStorage.setItem('productos_proformas', JSON.stringify(proformas_productos));
}
function guardarCambiosProformas(index,stock){
    let stockActual = parseFloat(stock);
    let precio = parseFloat($('#precio_final_compra_'+index).val());
    let cantidad = parseFloat($('#cantiad__'+index).val());
    if(cantidad >= 0  && cantidad <= stockActual){
        let total = (cantidad * precio).toFixed(2)
        proformas_productos[`${index}`].cantidad = cantidad;
        proformas_productos[`${index}`].precio_subtotal = total
    }else{
        $('#mensajeErrorProforma').html("Por favor, asegúrese de que la cantidad solicitada no exceda el stock disponible del producto en este momento.")
    }
    proformas_productos[`${index}`].producto_precio_final = precio
    // total_orden_compra()
    localStorage.setItem('productos_proforma', JSON.stringify(proformas_productos));
    dibujar_tabla_productos_proformas()
}
function guardar_descripcion(index){
    let coment = $('#descripcion_producto_'+index).val();
    proformas_productos[`${index}`].comentarios = coment
    localStorage.setItem('productos_proforma', JSON.stringify(proformas_productos));
    dibujar_tabla_productos_proformas()
}



let btn_save_proformas = document.getElementById('btn_save_proformas');
if(btn_save_proformas && btn_save_proformas.addEventListener){
    btn_save_proformas.addEventListener('click',function (){
        limpiarCampos('formulario_registro_proformas')
        $('#id_tipo_documento').val(4);
        $('#forma_pago').val(1);
        $('#action_proforma_register').val(1);
        proformas_productos = []
        $('#container_table_proformas_productos').html(' ');
        $('#lugar_entrega').val('Previa Coordinacion');
        $('#observaciones_proforma').val('Los precios estan sujetos a variaciones');

    });
}

let num_documento = document.getElementById('num_documento');
if(num_documento && num_documento.addEventListener){
    num_documento.addEventListener('change',function (){
        consultarNumdocumento('id_tipo_documento','num_documento','razon_social_cliente','direccion_cliente')
    });
}

$("#formulario_registro_proformas").on('submit', function (e) {
    e.preventDefault();
    var valor = true;
    var boton = 'btn_guardar_proformas';
    var id_tipo_documento = $('#id_tipo_documento').val();
    var num_documento = $('#num_documento').val();
    var razon_social_cliente = $('#razon_social_cliente').val();
    var forma_pago = $('#forma_pago').val();
    var lugar_entrega = $('#lugar_entrega').val();
    valor = validar_campo_vacio('id_tipo_documento', id_tipo_documento, valor);
    valor = validar_campo_vacio('num_documento', num_documento, valor);
    valor = validar_campo_vacio('razon_social_cliente', razon_social_cliente, valor);
    valor = validar_campo_vacio('forma_pago', forma_pago, valor);
    valor = validar_campo_vacio('lugar_entrega', lugar_entrega, valor);
    let proforma = new FormData(this);
    proforma.append('datos' , JSON.stringify(proformas_productos))
    if (valor) {
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestionventas/realizar_proforma",
            data: proforma,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success: function (r) {
                switch (r.result.code) {
                    case 1:
                        respuesta(r.result.message, 'success');
                        localStorage.removeItem('productos_proforma');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:
                        respuesta(r.result.message, 'error');
                        break;
                    case 3:
                        respuesta(r.result.message, 'error');
                        break;
                    case 4:
                        respuesta(r.result.message, 'error');
                        break;
                    case 5:
                        respuesta(r.result.message, 'error');
                        break;
                    case 6:
                        respuesta(r.result.message, 'error');
                        break;
                    case 7:
                        respuesta(r.result.message, 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
                cambiar_estado_boton(boton, "<i class=\"fa-solid fa-check\"></i> Guardar Registro", false);
            }
        });
    }
});


function eliminar_proforma(id){
    var boton = "btnEliminarProforma_"+id
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestionventas/guardar_familia",
        data:{
            id_fa:id,
            estadoActionFuctionFamilia:3,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Eliminando...', true);
        },
        success:function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta(r.result.message, 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                    break;
                case 2:respuesta(r.result.message, 'error');break;
                case 3:respuesta(r.result.message, 'error');break;
                // case 3:$('#mensajeguardar').html(r.result.message);break;
                case 4:respuesta(r.result.message, 'error');break;
                // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
            }
            cambiar_estado_boton(boton, "<i class=\"fa-solid fa-trash\"></i>", false);
        }
    });
}
