function enviar_comprobante_sunat(id_venta) {
    var boton = 'btn_enviar'+id_venta;
    $.ajax({
        type: "POST",
        url: ruta_global + "facturacion/crear_xml_enviar_sunatPri",
        data: {
            id_venta:id_venta,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'enviando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "<i style=\"font-size: 16pt;\" class=\"fa fa-check margen\"></i>", false);
            switch (r) {
                case 1:
                    respuesta('¡Comprobante Enviado a Sunat!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al generar el comprobante electronico', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 4:
                    respuesta('Error de comunicacion con Sunat', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 5:
                    respuesta('Error al guardar en base de datos', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
            }
        }

    });
}
function llenarcampos_anularventa(id_venta, estado){
    $('#id_venta').val(id_venta)
    $('#venta_estado').val(estado)

}
function anular_boleta_cambiarestado(id,est){
    let id_venta = id
    let estado = est;
    // let reduccion = document.getElementsByName('reduccion')
    // let valorReduccion ;
    // for (var i = 0; i < reduccion.length; i++) {
    //     if(reduccion[i].checked){
    //         valorReduccion = reduccion[i].value;
    //     }
    // }
    let funcion = estado == 10 ? 'comunicacion_baja' : 'anular_boleta_cambiarestado'
    var boton = 'btn_anular_anular'+id_venta;
    $.ajax({
        type: "POST",
        url: ruta_global + "facturacion/"+funcion,
        data: {
            id_venta:id_venta,
            estado:estado,
            // valorReduccion:valorReduccion,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "<i class=\"fa fa-ban\"></i>", false);
            switch (r) {
                case 1:
                    respuesta('¡Comprobante Anulado!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al anular el comprobante electronico', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}


function cambiarestado_enviado(id){
    var boton = "btn_actualizar_estado" + id;
    var accion = "1033";
    $.ajax({
        type: "POST",
        url: ruta_global + "facturacion/cambiarestado_enviado",
        data: {
            id:id,
            accion:accion,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'actualizando...', true);
        },
        success:function (r) {

            switch (r) {
                case 1:
                    respuesta('¡Fue actualizada como enviada y aceptada!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 300);
                    break;
                case 2:
                    respuesta('Error al actualizar', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 300);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}
function cambiarestado_anulado(id){
    var boton = "btn_actualizar_estado" + id;
    var accion = "1032";
    $.ajax({
        type: "POST",
        url: ruta_global + "facturacion/cambiarestado_enviado",
        data: {
            id:id,
            accion:accion,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'actualizando...', true);
        },
        success:function (r) {

            switch (r) {
                case 1:
                    respuesta('¡Fue actualizada como enviada y aceptada!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 300);
                    break;
                case 2:
                    respuesta('Error al actualizar', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 300);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}

function consultar_ticket_resumen(id_resumen_diario){
    var boton = 'btn_consultar'+id_resumen_diario;
    $.ajax({
        type: "POST",
        url: ruta_global + "facturacion/consultar_ticket_resumen",
        data: {
            id_resumen_diario: id_resumen_diario,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'enviando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "<i style=\"font-size: 16pt;\" class=\"fa fa-check margen\"></i>", false);
            switch (r.result.code) {
                case 1:
                    respuesta('¡CDR descargado con Éxito!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al Consultar', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 4:
                    respuesta('Error de comunicacion con Sunat', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 5:
                    respuesta('Error al guardar en base de datos', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
            }
        }

    });
}

function envio_masivo(){
    let cont = $('#numero_envio').val();
    if (cont == 1){
        respuesta('No hay Registro a Enviar','error');
    }else{
        let val = false;
        for (var i = 1; i < parseInt(cont);i++){
            var id = $('#venta_'+i).val();
            enviar_comprobante_sunat_masivo(id);
        }
    }
}
function enviar_comprobante_sunat_masivo(id_venta) {
    var boton = 'btn_enviar'+id_venta;
    $.ajax({
        type: "POST",
        url: ruta_global + "facturacion/crear_xml_enviar_sunat",
        data: {
            id_venta:id_venta,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'enviando...', true);
        },
        success:function (r) {
            switch (r) {
                case 1:
                    respuesta('¡Comprobante Enviado a Sunat!', 'success');
                    document.getElementById("venta_"+id_venta).style.background = "#82E0AA";
                    document.getElementById("venta_"+id_venta).style.color = "#FFF";
                    cambiar_estado_boton(boton, 'Enviado', true);
                    break;
                case 2:
                    respuesta('Error al generar el comprobante electronico', 'error');
                    document.getElementById("venta_"+id_venta).style.background = "#F1948A";
                    document.getElementById("venta_"+id_venta).style.color = "#FFF";

                    cambiar_estado_boton(boton, 'Error', true);
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    document.getElementById("venta_"+id_venta).style.background = "#F9E79F";
                    document.getElementById("venta_"+id_venta).style.color = "#FFF";

                    cambiar_estado_boton(boton, 'Rechazo', true);
                    break;
                case 4:
                    respuesta('Hubo o existe un problema de conexión', 'error');
                    document.getElementById("venta_"+id_venta).style.background = "#5DADE2";
                    document.getElementById("venta_"+id_venta).style.color = "#FFF";

                    cambiar_estado_boton(boton, 'Error Conexión', true);

                    break;
                case 5:
                    respuesta('Error al guardar en base de datos', 'error');

                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}



function crear_enviar_resumen_sunat(){
    // let id_empre = $('#id_empresaEnvioRe').val();
    let fecha_post = $('#fecha_post').val();
    var boton = 'boton_enviar_resumen';
    $.ajax({
        type: "POST",
        url: ruta_global + "facturacion/crear_enviar_resumen_sunatPri",
        data: {
            // id_empresa:id_empre,
            fecha:fecha_post,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Enviando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "Enviar Comprobantes", false);
            switch (r) {
                case 1:
                    respuesta('¡Resumen Creado y Enviado a Sunat!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al generar el Resumen Diario', 'error');
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    break;
                case 4:
                    respuesta(r.mensaje, 'error');
                    break;
                case 5:
                    respuesta(r.mensaje, 'error');
                    break;
                case 6:
                    respuesta(r.mensaje, 'error');
                    break;
                case 7:
                    respuesta(r.mensaje, 'error');
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}

function comunicacion_baja(id_venta){
    var boton = 'btn_anular'+id_venta;
    $.ajax({
        type: "POST",
        url: ruta_global + "facturacion/comunicacion_baja",
        data: {
            id_venta :id_venta,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "ANULAR", false);
            switch (r) {
                case 1:
                    respuesta('¡Comprobante Enviado a Sunat!', 'success');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al generar el comprobante electronico', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 3:
                    respuesta('Error, Sunat rechazó el comprobante', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 4:
                    respuesta('Error de comunicacion con Sunat', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                case 5:
                    respuesta('Error al guardar en base de datos', 'error');
                    setTimeout(function () {
                        location.reload();
                        //location.href = urlweb +  'Pedido/gestionar';
                    }, 1000);
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }

    });
}


function selecttipoventa(valor){
    Consultar_serie();
    var tipo_comprobante =  valor;
    $.ajax({
        type: "POST",
        url: ruta_global + "facturacion/tipo_nota_descripcion",
        data:{
            tipo_comprobante:tipo_comprobante,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        success:function (r) {
            let body = ` <label for="tipo_moneda">${r.nota}</label>`
            body+=  `<select class='form-control' id='notatipo_descripcion' name="notatipo_descripcion">`
            if(r.dato.length > 0){
                r.dato.map(function(el,index){
                    body+= `<option value="${el.codigo}">${el.tipo_nota_descripcion}</option>`
                })
            }
            $("#descripcion_nota_tipo").html(body);
        }
    });
}
function Consultar_serie(){
    var tipo_documento_modificar = $('#Tipo_documento_modificar').val();
    var tipo_venta =  $("#tipo_venta").val();
    // var id_su =  $("#id_su").val();
    var concepto = "LISTAR_SERIE";

    $.ajax({
        type: "POST",
        url: ruta_global + "facturacion/consultar_serie",
        data: {
            tipo_venta:tipo_venta,
            concepto:concepto,
            // id_su:id_su,
            tipo_documento_modificar:tipo_documento_modificar,
            "_token": $("meta[name='csrf-token']").attr("content")

        },
        dataType: 'json',
        success:function (r) {
            let series = "";
            console.log(r.serie)
            //var series = "<option value='' selected>Seleccione</option>";
            if(r.serie.length > 0){
                r.serie.map(function (el,index){
                    series += `<option value="${el.id_serie}">${el.serie}</option>`
                })
            }

            $("#serie_nota").html(series);
            ConsultarCorrelativo();
        }

    });
}
function ConsultarCorrelativo(){
    var id_serie =  $("#serie_nota").val();
    var concepto = "LISTAR_NUMERO";
    $.ajax({
        type: "POST",
        url: ruta_global + "facturacion/consultar_serie",
        data: {
            concepto:concepto,
            id_serie:id_serie,
            "_token": $("meta[name='csrf-token']").attr("content")

        },
        dataType: 'json',
        success:function (r) {
            $("#numero_nota").val(r.correlativo);
        }

    });
}

function pintar_tabla_detalle_venta_generar_nota(){
    let body = ""
    let num = 1
    if(arrayGN.length > 0) {
        arrayGN.map(function(el,index){
           body +=
               `
               <tr class="">
                    <td>${num}</td>
                    <td>${el.venta_detalle_nombre_producto}</td>
                    <td>
                        <input type="text" style="width: 75%" onchange="guardar_cambios_generar_nota_product(${index})" readonly class="border-none outline-none" name="precio_unit_${index}" id="precio_unit_${index}" value="${el.venta_detalle_precio_unitario}">
                        <input type="text" style="display: none"  readonly class="border-none outline-none" name="id_tipo_afectacion_${index}" id="id_tipo_afectacion_${index}" value="${el.id_tipo_afectacion}">
                        <input type="text" style="display: none"  readonly class="border-none outline-none" name="porcentaje_igv_${index}" id="porcentaje_igv_${index}" value="${el.venta_detalle_porcentaje_igv}">
                    </td>
                    <td><input type="number" style="width: 75%" onchange="guardar_cambios_generar_nota_product(${index});validar_numeros(this.id)"  class="border-none outline-none" name="cantidad_venta_${index}" id="cantidad_venta_${index}" value="${el.venta_detalle_cantidad}"></td>
<!--                    <td  style="display: none" ><input type="text" style="width: 75%;display: none" onchange="guardar_cambios_generar_nota_product(${index})" name="cantidad_venta_${index}" id="cantidad_venta_${index}" value="${el.venta_detalle_cantidad}"></td>-->
                    <td><input type="text" style="width: 80%" class="border-none outline-none"  name="total_cal_ge${index}" id="total_cal_ge${index}" value="${el.venta_detalle_importe_total}"></td>
                    <td>
                        <button class="btn btn-sm bg-danger text-white" type="button" onclick="eliminar_productos_generar_nota(${index})"><i class="fa fa-trash"></i></button>
                    </td>
               </tr>
               `
        });
    }
    $('#detalle_venta_nota').html(body);
    calcular_afectacion_generar_nota()
}

let agg_generation_product = document.getElementById('agg_generation_product');
if(agg_generation_product && agg_generation_product.addEventListener){
    agg_generation_product.addEventListener('keyup',function (){
        buscar_productos_generar_nota(this.id)
    });
}
function buscar_productos_generar_nota(id){
    let valor = $('#'+id).val();
    // let id_su = $('#id_su').val();
    $.ajax({
        type: "POST",
        url: ruta_global + "facturacion/buscar_productos",
        data:{
            valor:valor,
            // id_su:id_su,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function(r){
        let body = "";
        if(r.length > 0 ){
            r.map(function(el,index){
                body +=
                    `
                        <a class="list-group-item list-group-item-action" onclick="capturar_valores_generation_note(${el.id_pro},'${el.pro_nombre}','${el.id_tipo_afectacion}',${el.impuesto_bolsa},'${el.pro_precio_uni}','${el.pro_precio_uni_ma}','${el.pro_porcen_igv}')" >${el.pro_nombre}</a>
                    `
            })
        }else{
            body +=
                `
                    <a class="list-group-item list-group-item-action">Sin Registros existente</a>
                `
        }
        $('#list_producto_generate_note').html(body);
    });
    $(document).click(function() {
        var container = $('#list_producto_generate_note');
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.html("");
        }
    });
}
function capturar_valores_generation_note(id,nombre,afectacion,bolsa,precio,mayorista,porcenta_igv){
    $('#list_producto_generate_note').html(" ");
    $('#agg_generation_product').val(" ");
    let valorUnit = precio - (precio / porcenta_igv);
    let porce = 0;
    if (porcenta_igv == 1.18){
        porce = 18.00;
    }else if (porcenta_igv == 1.10){
        porce = 10.00;
    }else{
        porce = 0.00;
    }
    let obj = {
        id_pro :id,
        venta_detalle_nombre_producto :nombre,
        id_tipo_afectacion :afectacion,
        impuesto_bolsa :bolsa,
        venta_detalle_precio_unitario :precio,
        venta_detalle_precio_may :mayorista,
        venta_detalle_cantidad : 1,
        venta_detalle_valor_total :  valorUnit,
        venta_detalle_importe_total : precio * 1,
        venta_detalle_porcentaje_igv : porce
    }
    arrayGN.push(obj);
    pintar_tabla_detalle_venta_generar_nota()
}

function eliminar_productos_generar_nota(index){
    arrayGN.splice(index,1)
    calcular_afectacion_generar_nota()
    pintar_tabla_detalle_venta_generar_nota()
}
function guardar_cambios_generar_nota_product(index){
    let afectacion = $('#id_tipo_afectacion_'+index).val();
    let porcentaje_igv = $('#porcentaje_igv_'+index).val();
    let cantidad = $('#cantidad_venta_'+index).val();
    let precio = $('#precio_unit_'+index).val();
    let totalTotal = cantidad * precio;
    let totalValor = 0;
    let totalPrecio = 0;
    let calculIgv = 0;
    if (afectacion == 1){
        if (porcentaje_igv == 18){
            calculIgv = 1.18
        }else if(porcentaje_igv == 10){
            calculIgv = 1.10
        }else{
            calculIgv =0.00
        }
        let cantidadIGV = totalTotal - (totalTotal / calculIgv);
        totalValor = totalTotal - cantidadIGV
        totalPrecio = totalTotal
        // arrayGN[`${index}`].venta_detalle_total_igv = cantidadIGV
    }else{
        totalValor = totalTotal
        totalPrecio = totalTotal
    }
    // let  = cantidad * precio
    $('#total_cal_ge'+index).val(totalTotal.toFixed(2));
    arrayGN[`${index}`].venta_detalle_cantidad = cantidad
    arrayGN[`${index}`].venta_detalle_precio_unitario = precio
    arrayGN[`${index}`].venta_detalle_valor_total = totalValor
    arrayGN[`${index}`].venta_detalle_importe_total = totalPrecio
    calcular_afectacion_generar_nota()
}


let array_calculo_generar_nota = [];
function calcular_afectacion_generar_nota(){
    let descuento = 0
    let pago_cliente = 0
    let vuelto = 0.00
    let total_descuento = 0.00
    let desc_porcentaje = descuento / 100 * 1
    let op_exonerada = 0.00
    let op_gratuitas = 0.00
    let sumar_total = 0.00;
    let sumar_igv = 0.00;
    let sumar_exo = 0.00;
    let sumar_ina = 0.00;
    let sumar_gratuitas = 0.00;
    let impuesto_bolsa = 0.00;
    let total = 0.00;
    let total2 = 0.00;
    let v = 0.00;
    let v2 = 0.00;
    let v4 = 0.00;
    let v5= 0.00;
    let v6= 0.00;
    let v7= 0.00;
    let bolsa = 0.00;
    let desc_total = 0.00;
    let v3 = 0;
    let calcIGV = 0;
    if(arrayGN.length > 0) {
        arrayGN.map(function(el, index) {
            let precio_final = 0;
            if (el.venta_detalle_cantidad >= 12){
                if (el.id_venta_detalle){
                    precio_final = el.pro_precio_uni_ma
                }else{
                    precio_final = el.venta_detalle_precio_may;
                }
            }else{
                precio_final = el.venta_detalle_precio_unitario;
            }

            if(el.id_tipo_afectacion == 1){
                if(el.venta_detalle_porcentaje_igv == 18){
                     calcIGV = 1.18;
                }else if(el.venta_detalle_porcentaje_igv == 10){
                     calcIGV = 1.10;
                }
                let menos =  precio_final - (precio_final / calcIGV);
                sumar_igv += menos * el.venta_detalle_cantidad
                v3 += ((precio_final - menos) *el.venta_detalle_cantidad );
                if (el.impuesto_bolsa == 1){
                    impuesto_bolsa+= el.venta_detalle_cantidad * 0.50;
                }
            }else if(el.id_tipo_afectacion == 2){
                v4+=  precio_final * el.venta_detalle_cantidad ;
            }else if(el.id_tipo_afectacion == 3){
                v5 += precio_final * el.venta_detalle_cantidad;
            }else if( el.id_tipo_afectacion == 4){
                v6 +=  precio_final * el.venta_detalle_cantidad;
            }
        })
        total = parseFloat(v3)  + parseFloat(v4)+  parseFloat(v5)  + parseFloat(sumar_igv) + parseFloat(impuesto_bolsa) ;
        $('#op_exoneradas_generar_nota').html(v4.toFixed(2));
        $('#op_inafectada_generar_nota').html(v5.toFixed(2));
        $('#op_gratuitas_generar_nota').html(v6.toFixed(2));
        $('#total_venta_generar_nota').html(total.toFixed(2));
        $('#op_gravada_generar_nota').html(v3.toFixed(2));
        $('#igv_generar_nota').html(sumar_igv.toFixed(2));
        $('#icbper').html("+"+impuesto_bolsa);

    }else{
        // $('#icbper_generar_nota').html("+00.00")
        $('#op_inafectada_generar_nota').html("+00.00");
        $('#op_exoneradas_generar_nota').html("+00.00");
        $('#op_gratuitas_generar_nota').html("+00.00");
        $('#total_venta_generar_nota').html("+00.00");
        $('#op_gravada_generar_nota').html("+00.00");
        $('#igv_generar_nota').html("+00.00");
        $('#icbper').html("+00.00");
    }
    // 0 exo , 1  gratuitas  , 2 inafectada , 3 gravada , 4 igv , 5 icbper , 6 total
    array_calculo_generar_nota = [v4,v6,v5,v3.toFixed(2),sumar_igv.toFixed(2),impuesto_bolsa,total]
}


$("#formulario_generar_nota").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_guardar_registro_generar_nota';
    var id_cliente  = $('#id_cliente').val();
    var id_venta  = $('#id_venta').val();
    var id_tipo_documento_  = $('#id_tipo_documento_').val();
    var cliente_nombre  = $('#cliente_nombre').val();
    var cliente_documento  = $('#cliente_documento').val();
    var tipo_venta  = $('#tipo_venta').val();
    var serie_nota  = $('#serie_nota').val();
    var numero_nota  = $('#numero_nota').val();
    valor = validar_campo_vacio('id_cliente', id_cliente, valor);
    valor = validar_campo_vacio('id_venta', id_venta, valor);
    valor = validar_campo_vacio('id_tipo_documento_', id_tipo_documento_, valor);
    valor = validar_campo_vacio('cliente_nombre', cliente_nombre, valor);
    valor = validar_campo_vacio('cliente_documento', cliente_documento, valor);
    valor = validar_campo_vacio('tipo_venta', tipo_venta, valor);
    valor = validar_campo_vacio('serie_nota', serie_nota, valor);
    valor = validar_campo_vacio('numero_nota', numero_nota, valor);
    let formulario = new FormData(this);
    formulario.append('datos' , JSON.stringify(arrayGN))
    formulario.append('calculo' , JSON.stringify(array_calculo_generar_nota))
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "facturacion/generar_nota_re",
            data:formulario,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                switch (r) {
                    case 1:
                        respuesta('¡Guardado correctamente! Recargando...', 'success');
                        setTimeout(function () {
                            location.href = ruta_global +  'facturacion/pendiente_declarar';
                        }, 1000);
                        break;
                    case 2:respuesta('Ocurrió un error ', 'error');break;
                    // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                    default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
                }
                cambiar_estado_boton(boton, "Guardar Registro", false);
            }
        });
    }
});
$("#FormularioEnviarComprobanteEmail").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'envirMensaje';
    var id_venta  = $('#id_venta').val();
    var correoDestino  = $('#correoDestino').val();
    valor = validar_campo_vacio('id_venta', id_venta, valor);
    valor = validar_campo_vacio('correoDestino', correoDestino, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "facturacion/enviarComprobanteporCorreo",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Enviando...', true);
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
                    case 6:respuesta(r.result.message, 'error');break;
                    // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                    default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
                }
                cambiar_estado_boton(boton, "Guardar Registro", false);
            }
        });
    }
});
