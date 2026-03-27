function enviar_comprobante_sunat(id_venta) {
    var boton = 'btn_enviar'+id_venta;
    $.ajax({
        type: "POST",
        url: ruta_global + "venta/crear_xml_enviar_sunat",
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
function anular_boleta_cambiarestado(){
    let id_venta = $('#id_venta').val()
    let estado = $('#venta_estado').val()
    let reduccion = document.getElementsByName('reduccion')
    let valorReduccion ;
    for (var i = 0; i < reduccion.length; i++) {
        if(reduccion[i].checked){
            valorReduccion = reduccion[i].value;
        }
    }
    let funcion = estado == 10 ? 'comunicacion_baja' : 'anular_boleta_cambiarestado'
    var boton = 'btn_anular_anular'+id_venta;
    $.ajax({
        type: "POST",
        url: ruta_global + "venta/"+funcion,
        data: {
            id_venta:id_venta,
            estado:estado,
            valorReduccion:valorReduccion,
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
        url: ruta_global + "venta/cambiarestado_enviado",
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
        url: ruta_global + "venta/cambiarestado_enviado",
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
    var cadena = "id_resumen_diario=" + id_resumen_diario;
    var boton = 'btn_consultar'+id_resumen_diario;
    $.ajax({
        type: "POST",
        url: ruta_global + "venta/consultar_ticket_resumen",
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
    if (cont==1){
        respuesta('No hay Registro a Enviar','error');
    }else{
        let val = false;
        for (var i =1; i< parseInt(cont);i++){
            var id= $('#valor_'+i).val();

            enviar_comprobante_sunat_masivo(id);

        }
    }
}
function enviar_comprobante_sunat_masivo(id_venta) {
    var boton = 'btn_enviar'+id_venta;
    $.ajax({
        type: "POST",
        url: ruta_global + "venta/crear_xml_enviar_sunat",
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
    let fecha_post = $('#fecha_post').val();
    var boton = 'boton_enviar_resumen';
    $.ajax({
        type: "POST",
        url: ruta_global + "venta/crear_enviar_resumen_sunat",
        data: {
            fecha:fecha_post,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Enviando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton, "Enviar Comprobantes", false);
            switch (r.resulta) {
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
        url: ruta_global + "venta/comunicacion_baja",
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
        url: ruta_global + "venta/tipo_nota_descripcion",
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
    var concepto = "LISTAR_SERIE";

    $.ajax({
        type: "POST",
        url: ruta_global + "venta/consultar_serie",
        data: {
            tipo_venta:tipo_venta,
            concepto:concepto,
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
        url: ruta_global + "venta/consultar_serie",
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
                    <td><input type="text" style="width: 75%" onchange="guardar_cambios_generar_nota_product(${index})" readonly class="border-none outline-none" name="precio_unit_${index}" id="precio_unit_${index}" value="${el.venta_detalle_precio_unitario}"></td>
                    <td><input type="text" style="width: 75%" onchange="guardar_cambios_generar_nota_product(${index})" name="cantidad_venta_${index}" id="cantidad_venta_${index}" value="${el.venta_detalle_cantidad}"></td>
                    <td><input type="text" style="width: 80%" class="border-none outline-none"  name="total_cal_ge${index}" id="total_cal_ge${index}" value="${el.venta_detalle_valor_total}"></td>
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
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestionventas/buscar_productos",
        data:{
            valor:valor,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function(r){
        let body = "<ul class='lista_buscador w-50'>";
        if(r.length > 0 ){
            r.map(function(el,index){
                body +=
                    `
                        <li class="li_buscador" onclick="capturar_valores_generation_note(${el.id_producto},'${el.recetas_nombre}','${el.id_tipo_afectacion}','${el.impuesto_bolsa}','${el.producto_precios_precio_venta}')" >${el.recetas_nombre}</li>
                    `
            })
        }else{
            body +=
                `
                    <li>Sin Registros existente</li>
                `
        }
        body +=  `</ul>`
        $('#list_producto_generate_note').html(body);
    });
}
function capturar_valores_generation_note(id,nombre,afectacion,bolsa,precio){
    $('#list_producto_generate_note').html(" ");
    $('#agg_generation_product').val(" ");
    let obj = {
        id_producto :id,
        venta_detalle_nombre_producto :nombre,
        id_tipo_afectacion :afectacion,
        impuesto_bolsa :bolsa,
        venta_detalle_precio_unitario :precio,
        venta_detalle_cantidad : 1,
        venta_detalle_valor_total : precio*1
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
    let cantidad = $('#cantidad_venta_'+index).val();
    let precio = $('#precio_unit_'+index).val();
    let resultado = cantidad * precio
    $('#total_cal_ge'+index).val(resultado.toFixed(2));
    arrayGN[`${index}`].venta_detalle_cantidad = cantidad
    arrayGN[`${index}`].venta_detalle_precio_unitario = precio
    arrayGN[`${index}`].venta_detalle_valor_total = resultado
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
    let v3 = 0.00;
    let v4 = 0.00;
    let v5= 0.00;
    let v6= 0.00;
    let v7= 0.00;
    let bolsa = 0.00;
    let desc_total = 0.00;
    if(arrayGN.length > 0) {
        arrayGN.map(function(el, index) {
            desc_total += v7 * desc_porcentaje
            if(el.id_tipo_afectacion == 1){
                v += el.venta_detalle_valor_total * 1;
                sumar_igv += el.venta_detalle_valor_total * 0.18;
                v2 = v.toFixed(2)
                v3 = sumar_igv.toFixed(2)
            }else if(el.id_tipo_afectacion == 2){
                sumar_exo += el.venta_detalle_valor_total * 1 ;
                v4 = (sumar_exo - (sumar_exo * desc_porcentaje * 1)).toFixed(2);
                op_exonerada = v4;
                if(el.impuesto_bolsa == 1){
                    impuesto_bolsa += el.venta_detalle_cantidad * 0.50;
                    bolsa = impuesto_bolsa.toFixed(2)
                }
            }else if(el.id_tipo_afectacion == 3){
                sumar_ina += el.venta_detalle_valor_total * 1;
                v5 = sumar_ina.toFixed(2)
            }else if( el.id_tipo_afectacion == 4){
                sumar_gratuitas += el.venta_detalle_valor_total * 1;
                v6 = (sumar_gratuitas - (sumar_gratuitas * desc_porcentaje * 1)).toFixed(2);

            }
            sumar_total += el.venta_detalle_valor_total * 1;
        })
        total = sumar_igv  + sumar_exo + v + sumar_ina + impuesto_bolsa;
        total_descuento = parseFloat(total * desc_porcentaje)
        v7 = (total - (total * desc_porcentaje * 1)).toFixed(2);
        vuelto = (pago_cliente - v7).toFixed(2);
        $('#icbper_generar_nota').html("+"+bolsa.toFixed(2));
        $('#op_exoneradas_generar_nota').html("+"+v4);
        $('#op_gratuitas_generar_nota').html("+"+v6.toFixed(2));
        $('#total_venta_generar_nota').html("+"+v7);
        $('#op_gravada_generar_nota').html("+"+v2.toFixed(2));
        $('#igv_generar_nota').html("+"+v3.toFixed(2));
    }else{
        $('#icbper_generar_nota').html("+00.00");
        $('#op_exoneradas_generar_nota').html("+00.00");
        $('#op_gratuitas_generar_nota').html("+00.00");
        $('#total_venta_generar_nota').html("+00.00");
        $('#op_gravada_generar_nota').html("+00.00");
        $('#igv_generar_nota').html("+00.00");

    }
    // 0 exo , 1  gratuitas  , 2 inafectada , 3 gravada , 4 igv , 5 icbper , 6 total
    array_calculo_generar_nota = [v4,v6,v5,v2,v3,bolsa,v7]
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
            url: ruta_global + "venta/generar_nota_",
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
                            location.href = ruta_global +  'venta/historial_ventas_sunat';
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
            url: ruta_global + "venta/enviarComprobanteporCorreo",
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
