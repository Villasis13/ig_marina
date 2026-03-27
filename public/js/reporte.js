function search_docs(id_producto,fecha_inicio, fecha_fin){
    let boton = 'btn_search'+id_producto
    $.ajax({
        type: "POST",
        url: ruta_global + "Reporte/report_list_product",
        data: {
            id_producto:id_producto,
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Buscando...', true);
        },
        success:function (r) {
            cambiar_estado_boton(boton,' <i class="bx bxs-show"></i> ',false)
            if(r.length >0){
                let a =1
                let body = ''
                r.map(function (el,index){
                    body += ` <li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge bg-secondary">${el.venta_serie +'-'+ el.venta_correlativo}</span> <span class="badge bg-primary">${el.venta_detalle_cantidad}</span> ${el.venta_detalle_importe_total} <a href="${ruta_global+'venta/imprimir_ticket_pdf/'+el.id_venta}" target="_blank" class="text-white badge bg-danger"><i class="bx bxs-file-pdf"></i></a>   </li>`
                    a++
                })
                console.log(body)
                $('#data_docs_product').html(body)

            }else{
                $('#data_docs_product').html('Sin Documentos')
            }

        }

    });
}
function cambiar_fec_general(){
    var valorcito = $("input:radio[name=opcion]:checked").val();
    const fecha = new Date();
    if(valorcito=="d"){
        var mees=fecha.getMonth()+1;
        if(mees<10){mees="0"+mees;}
        var dia=fecha.getDate();
        if(dia<10){dia="0"+dia;}
        $("#desde").val(fecha.getFullYear()+"-"+mees+"-"+dia);
        $("#hasta").val(fecha.getFullYear()+"-"+mees+"-"+dia);
    }else{
        var mees=fecha.getMonth()+1;
        if(mees<10){mees="0"+mees;}
        var dia=fecha.getDate();
        if(dia<10){dia="0"+dia;}
        var hoy = fecha.getFullYear()+"-"+mees+"-"+dia;
        if(valorcito=="s") {
            var fecha_2 = calcular_general(hoy,"restar",7);
        }else{
            if(valorcito=="q") {
                var fecha_2 = calcular_general(hoy,"restar",15);
            }else{
                if(valorcito=="m") {
                    var fecha_2 = calcular_general(hoy,"restar",30);
                }else{
                    if(valorcito=="tri") {
                        var fecha_2 = calcular_general(hoy,"restar",90);
                    }else{
                        if(valorcito=="sem") {
                            var fecha_2 = calcular_general(hoy,"restar",180);
                        }else{
                            var fecha_2 = calcular_general(hoy,"restar",365);
                        }
                    }
                }

            }
        }
        var date2 = fecha_2.split("-");
        var meeees=date2[1] -1 + 1;
        if(meeees<10){meeees="0"+meeees;}
        $("#hasta").val(hoy);
        $("#desde").val(date2[0]+"-"+meeees+"-"+date2[2]);
    }
}
function calcular_general(fecha, operacion, dias) {
    var date = fecha.split("-"), hoy = new Date(date[0], date[1], date[2]), dias = parseInt(dias), calculado = new Date(), dateResul = operacion == "sumar" ? hoy.getDate() + dias : hoy.getDate() - dias;
    calculado.setDate(dateResul);
    var mees=calculado.getMonth()+1;
    var diias=calculado.getDate();
    if(mees<10){mees="0"+mees;}
    if(diias<10){diias="0"+diias;}
    return calculado.getFullYear() + "-" + mees + "-" + diias;
}

let namePaciente_buscar = document.getElementById('namePaciente_buscar');
if(namePaciente_buscar && namePaciente_buscar.addEventListener){
    namePaciente_buscar.addEventListener('keyup',function (){
        filtrar_paciente_nombre();
    });
}
function filtrar_paciente_nombre() {
    var value = namePaciente_buscar.value.toLowerCase();
    var tarjetas = document.querySelectorAll('#containerPaciente .cp');

    tarjetas.forEach(function (tarjeta) {
        var textoH5 = tarjeta.querySelector('.titleNombre b').textContent.toLowerCase();
        tarjeta.style.display = (textoH5.indexOf(value) > -1) ? '' : 'none';
    });
}
function listar_citas_paciente(id,nombre){
    $.ajax({
        url:ruta_global+"reporte/listar_citas_paciente",
        method: 'post',
        data:{
            id_pa: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function(r){
        let datos = r.result.code;
        let conteo = 1;
        let html = ""
        if (datos.length > 0) {
            datos.map(function(el,index){
                let html2 = ""
                if(el.detalle.length > 0) {
                    el.detalle.map(function(el2,index2){
                        html2+=
                            `
                            <p>- ${el2.tra_nombre}</p>
                            `
                    });
                }
                html+=
                    `
                         <tr>
                            <td>${conteo}</td>
                            <td>${el.ci_serie} - ${el.ci_correlativo}</td>
                            <td>${el.ci_fecha} - ${el.ci_hora}</td>
                            <td>${el.persona_nombre}</td>
                            <td>${html2}</td>
                            <td>S/ ${el.ci_costo}</td>
                        </tr>
                    `
                conteo++;
            });
        }
        $('#containerCitasPacientes').html(html);
        $('#nombrPaci').html(nombre);
        $('#tablaCitasPaciente').dataTable();
    });
}

