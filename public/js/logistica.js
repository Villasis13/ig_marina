let array_orden_compra = [];
let ocSearchTimer = null;
let btn_crear_productos = document.getElementById('btn_crear_productos');
if(btn_crear_productos && btn_crear_productos.addEventListener){
    btn_crear_productos.addEventListener('click',function (){
        limpiarCampos('formularioAgregarProductos')
        $('#estadoActionFuctionProductos').val(1);
        $('#tipoAfectacion').val(2);
        $('#unidadMedida').val(58);
        $('#id_moneda').val(1);
        $('#stock_minimo').val(0);
        $('#stock_maximo').val(0);
        $('#pro_precio_costo').val('');
        $('#pro_valor_costo').val('');
        $('#pro_costo_promedio').val('');
        $('#pro_fecha_adquisicion').val('');
        $('#pro_codigo_barra').val('');
        $('#id_fa_selector').val('');
        filtrarCategorias(''); // muestra todas las categorías
        $('#imagen_producto').attr('src', ruta_global+'sin-fotografia.png');
        $('#ids_proveedores option').prop('selected', false);
    });
}

$("#formularioAgregarProductos").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btnSaveProductos';
    var pro_nombre  = $('#pro_nombre').val();
    var pro_codigo  = $('#pro_codigo').val();
    var pro_precio_uni  = $('#pro_precio_uni').val();
    var pro_precio_uni_ma  = $('#pro_precio_uni_ma').val();
    var tipoAfectacion  = $('#tipoAfectacion').val();
    // var pro_foto  = $('#pro_foto').val();
    var id_ca  = $('#id_ca').val();
    var unidadMedida  = $('#unidadMedida').val();
    valor = validar_campo_vacio('pro_nombre', pro_nombre, valor);
    valor = validar_campo_vacio('pro_codigo', pro_codigo, valor);
    valor = validar_campo_vacio('pro_precio_uni', pro_precio_uni, valor);
    valor = validar_campo_vacio('pro_precio_uni_ma', pro_precio_uni_ma, valor);
    valor = validar_campo_vacio('tipoAfectacion', tipoAfectacion, valor);
    // valor = validar_campo_vacio('pro_foto', pro_foto, valor);
    valor = validar_campo_vacio('id_ca', id_ca, valor);
    valor = validar_campo_vacio('unidadMedida', unidadMedida, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "logistica/guardar_producto",
            data:new FormData(this),
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
                    case 4:respuesta(r.result.message, 'error');break;
                    // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                    default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
                }
                cambiar_estado_boton(boton, "Guardar registro", false);
            }
        });
    }
});

// Cascade: filtra categorías según la línea (familia) seleccionada
function filtrarCategorias(idFa) {
    var cats = typeof _categorias_data !== 'undefined' ? _categorias_data : [];
    var select = document.getElementById('id_ca');
    var valorActual = select.value;
    select.innerHTML = '<option value="">Seleccionar categoría</option>';
    cats.forEach(function(c) {
        if (!idFa || String(c.id_fa) === String(idFa)) {
            var opt = document.createElement('option');
            opt.value = c.id_ca;
            opt.text = c.ca_nombre;
            opt.dataset.fa = c.id_fa;
            if (String(c.id_ca) === String(valorActual)) opt.selected = true;
            select.appendChild(opt);
        }
    });
}

function modificarProductos(id){
    $.ajax({
        url:ruta_global+"logistica/listar_datos_productos",
        method: 'post',
        data:{
            id_pro: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function(r){
        let resul = r.result.code;
        $('#id_pro').val(id);
        $('#estadoActionFuctionProductos').val(2);
        $('#pro_nombre').val(resul.pro_nombre);
        $('#pro_codigo').val(resul.pro_codigo);
        $('#pro_codigo_barra').val(resul.pro_codigo_barra || '');
        $('#pro_descripcion').val(resul.pro_descripcion);
        $('#pro_presentacion').val(resul.pro_presentacion);
        $('#pro_medida').val(resul.pro_medida);
        $('#pro_precio_uni').val(resul.pro_precio_uni);
        $('#pro_precio_uni_ma').val(resul.pro_precio_uni_ma);
        $('#pro_precio_costo').val(resul.pro_precio_costo || '0.00');
        $('#pro_valor_costo').val(resul.pro_valor_costo || '0.00');
        $('#pro_costo_promedio').val(resul.pro_costo_promedio || '0.00');
        $('#pro_fecha_adquisicion').val(resul.pro_fecha_adquisicion || '');
        $('#tipoAfectacion').val(resul.id_tipo_afectacion);
        $('#unidadMedida').val(resul.id_medida);
        $('#id_moneda').val(resul.id_moneda || 1);
        $('#control_serie').prop('checked', resul.control_serie == 1);
        $('#control_lote').prop('checked', resul.control_lote == 1);
        $('#stock_minimo').val(resul.stock_minimo || 0);
        $('#stock_maximo').val(resul.stock_maximo || 0);
        $('#impuesto_bolsa').prop('checked', resul.impuesto_bolsa == 1);

        // Cascade: detectar la familia de la categoría y preseleccionar línea
        var cats = typeof _categorias_data !== 'undefined' ? _categorias_data : [];
        var catEncontrada = cats.find(c => String(c.id_ca) === String(resul.id_ca));
        if (catEncontrada) {
            $('#id_fa_selector').val(catEncontrada.id_fa);
            filtrarCategorias(catEncontrada.id_fa);
        }
        $('#id_ca').val(resul.id_ca);

        // Proveedores asociados
        let provIds = r.result.proveedores_ids || [];
        $('#ids_proveedores option').each(function(){
            $(this).prop('selected', provIds.includes(parseInt($(this).val())));
        });

        if(resul.pro_foto){
            $('#imagen_producto').attr('src', ruta_global+resul.pro_foto);
        }else{
            $('#imagen_producto').attr('src', ruta_global+'sin-fotografia.png');
        }
    });
}

function eliminar_producto(id){
    var boton = "btnEliminarProducto_"+id
    $.ajax({
        type: "POST",
        url: ruta_global + "logistica/guardar_producto",
        data:{
            id_pro:id,
            estadoActionFuctionProductos:3,
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
                case 4:respuesta(r.result.message, 'error');break;
                // case 3:$('#mensajeguardar').html(r.result.message);break;
                case 5:respuesta(r.result.message, 'error');break;
                // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
            }
            cambiar_estado_boton(boton, "<i class=\"fa-solid fa-trash\"></i>", false);
        }
    });
}

let productos_orden_compra = document.getElementById('productos_orden_compra');
if (productos_orden_compra && productos_orden_compra.addEventListener) {
    productos_orden_compra.addEventListener('input', function () {
        clearTimeout(ocSearchTimer);
        const val = this.value.trim();
        const dd = document.getElementById('oc_productos_dropdown');
        if (val.length < 2) {
            dd.innerHTML = '';
            dd.classList.remove('open');
            return;
        }
        ocSearchTimer = setTimeout(() => listar_productos_orden_compra(val), 280);
    });
    productos_orden_compra.addEventListener('focus', function () {
        const dd = document.getElementById('oc_productos_dropdown');
        if (dd.innerHTML) dd.classList.add('open');
    });
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.oc-search-wrap')) {
            const dd = document.getElementById('oc_productos_dropdown');
            if (dd) dd.classList.remove('open');
        }
    });
}

function listar_productos_orden_compra(valor) {
    $.ajax({
        type: "POST",
        url: ruta_global + "logistica/buscador_productos",
        data: {
            valor: valor,
            medida: 58,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function (r) {
        const dd = document.getElementById('oc_productos_dropdown');
        if (!dd) return;
        let datos = r.result.code;
        let html = '';
        if (datos && datos.length > 0) {
            datos.forEach(function (p) {
                const nombre    = (p.pro_nombre || '').replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const codigo    = p.pro_codigo || '';
                const faNombre  = p.fa_nombre || '';
                const faCodigo  = p.familia_codigo || '';
                const cs        = p.control_serie || 0;
                const cl        = p.control_lote  || 0;
                const famHtml   = faNombre
                    ? `<span class="oc-drop-fam">${faCodigo} - ${faNombre}</span>`
                    : '';
                html += `<div class="oc-drop-item"
                    onclick="capturar_datos_orden_compra(${p.id_pro},'${nombre}','${codigo}','${faNombre}','${faCodigo}',${cs},${cl})">
                    <div class="oc-drop-name">${p.pro_nombre}</div>
                    <div class="oc-drop-meta"><span class="oc-drop-code">${codigo}</span>${famHtml}</div>
                </div>`;
            });
        } else {
            html = `<div class="oc-drop-empty">Sin resultados para "${$('<div>').text(valor).html()}"</div>`;
        }
        dd.innerHTML = html;
        dd.classList.add('open');
    });
}

function capturar_datos_orden_compra(id, producto, codigo, fa_nombre, familia_codigo, control_serie, control_lote) {
    $('#productos_orden_compra').val('');
    const dd = document.getElementById('oc_productos_dropdown');
    if (dd) { dd.innerHTML = ''; dd.classList.remove('open'); }
    let yaExiste = array_orden_compra.some(p => p.id_pro == id);
    if (yaExiste) {
        respuesta('No es posible ingresar un recurso más de una vez.', 'error');
        return;
    }
    let obj = {
        id_pro: id,
        producto_nombre: producto,
        producto_codigo: codigo || '',
        producto_familia: fa_nombre || '',
        producto_familia_codigo: familia_codigo || '',
        producto_precio_unit: 0,
        cantidad: (control_serie || control_lote) ? 0 : 1,
        precio_total: 0,
        control_serie: control_serie || 0,
        control_lote: control_lote || 0,
        series: [],
        lotes: [],
    };
    array_orden_compra.push(obj);
    respuesta('Producto agregado.', 'success');
    localStorage.setItem('productos_orden_compra', JSON.stringify(array_orden_compra));
    dibujar_tabla_productos_orden_compra();
}
function dibujar_tabla_productos_orden_compra(){
    let num = 1;
    let body = `<table class="table table-hover table-bordered">
                  <thead>
                    <tr class="encabezado_tabla_color">
                        <th>#</th>
                        <th>Producto</th>
                        <th>Familia</th>
                        <th>U. Medida</th>
                        <th>Cantidad</th>
                        <th>Precio de Compra</th>
                        <th>Total</th>
                        <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>`;

    if(array_orden_compra.length > 0){
        array_orden_compra.map(function(el, index){
            let esControlado = el.control_serie || el.control_lote;
            let cantidadInput = esControlado
                ? `<input type="number" class="form-control w-px-100 border-none outline-none" readonly id="cantiad__${index}" name="cantiad__${index}" value="${el.cantidad}">`
                : `<input type="number" class="form-control w-px-100 border-none outline-none" onkeyup="validar_numeros(this.id)" onchange="calcular_precio_total_recurso_orden_compra(${index})" id="cantiad__${index}" name="cantiad__${index}" value="${el.cantidad}">`;

            body += `
                <tr>
                    <td>${num}</td>
                    <td>${el.producto_nombre}<br><small class="text-muted">${el.producto_codigo||''}</small></td>
                    <td><small>${el.producto_familia ? `${el.producto_familia_codigo||''} - ${el.producto_familia}` : '-'}</small></td>
                    <td>UNIDAD (BIENES)</td>
                    <td>${cantidadInput}</td>
                    <td><input type="text" onkeyup="validar_numeros(this.id)" id="precio_compra_${index}" class="form-control w-px-100 border-none outline-none" onchange="calcular_precio_total_recurso_orden_compra(${index})" name="precio_compra_${index}" value="${el.producto_precio_unit}"></td>
                    <td><input type="text" readonly id="total_recursos_${index}" class="form-control w-px-100 border-none outline-none" name="total_recursos_${index}" value="${el.precio_total}"></td>
                    <td><a class="btn btn-sm text-white bg-danger" type="button" onclick="eliminar_recurso_orden_compra(${index})"><i class="fa fa-trash"></i></a></td>
                </tr>`;

            if (el.control_serie) {
                body += generarSeccionSeries(index, el.series || []);
            }
            if (el.control_lote) {
                body += generarSeccionLotes(index, el.lotes || []);
            }

            num++;
        });
    }

    body += `</tbody></table>`;
    $('#tabla_productos_orden_compra').html(body);
    total_orden_compra();
}

function generarSeccionSeries(index, series) {
    let lista = '';
    if (series.length > 0) {
        lista = `<table class="table table-sm table-bordered mt-2 mb-0">
            <thead><tr class="table-primary"><th>N° Serie</th><th>N° Motor</th><th>Color</th><th>Año</th><th>Obs.</th><th></th></tr></thead>
            <tbody>`;
        series.forEach(function(s, si) {
            lista += `<tr>
                <td>${s.numero_serie}</td>
                <td>${s.numero_motor || '-'}</td>
                <td>${s.color || '-'}</td>
                <td>${s.anio || '-'}</td>
                <td>${s.observaciones || '-'}</td>
                <td><button class="btn btn-sm btn-danger py-0" type="button" onclick="eliminarSerie(${index},${si})"><i class="fa fa-trash"></i></button></td>
            </tr>`;
        });
        lista += `</tbody></table>`;
    }
    return `<tr>
        <td colspan="7" class="p-1">
            <div class="border-start border-4 border-primary ps-3 py-2 bg-light mx-2 rounded">
                <b class="text-primary small"><i class="fa fa-barcode me-1"></i>Series registradas: ${series.length}</b>
                <div class="d-flex flex-wrap gap-1 mt-2 align-items-center">
                    <input type="text" id="ns_serie_${index}" placeholder="N° serie *" class="form-control form-control-sm" style="width:130px">
                    <input type="text" id="ns_motor_${index}" placeholder="N° motor" class="form-control form-control-sm" style="width:130px">
                    <input type="text" id="ns_color_${index}" placeholder="Color" class="form-control form-control-sm" style="width:90px">
                    <input type="text" id="ns_anio_${index}" placeholder="Año fab." class="form-control form-control-sm" style="width:80px">
                    <input type="text" id="ns_obs_${index}" placeholder="Observaciones" class="form-control form-control-sm" style="width:150px">
                    <button class="btn btn-sm btn-primary" type="button" onclick="agregarSerie(${index})"><i class="fa fa-plus"></i> Agregar</button>
                </div>
                ${lista}
            </div>
        </td>
    </tr>`;
}

function generarSeccionLotes(index, lotes) {
    let lista = '';
    if (lotes.length > 0) {
        lista = `<table class="table table-sm table-bordered mt-2 mb-0">
            <thead><tr class="table-warning"><th>N° Lote</th><th>Vencimiento</th><th>Cantidad</th><th>Obs.</th><th></th></tr></thead>
            <tbody>`;
        lotes.forEach(function(l, li) {
            lista += `<tr>
                <td>${l.numero_lote}</td>
                <td>${l.fecha_vencimiento || 'Sin venc.'}</td>
                <td>${l.cantidad}</td>
                <td>${l.observaciones || '-'}</td>
                <td><button class="btn btn-sm btn-danger py-0" type="button" onclick="eliminarLote(${index},${li})"><i class="fa fa-trash"></i></button></td>
            </tr>`;
        });
        lista += `</tbody></table>`;
    }
    return `<tr>
        <td colspan="7" class="p-1">
            <div class="border-start border-4 border-warning ps-3 py-2 bg-light mx-2 rounded">
                <b class="text-warning small"><i class="fa fa-layer-group me-1"></i>Lotes registrados: ${lotes.length}</b>
                <div class="d-flex flex-wrap gap-1 mt-2 align-items-center">
                    <input type="text" id="nl_numero_${index}" placeholder="N° lote *" class="form-control form-control-sm" style="width:130px">
                    <input type="date" id="nl_vence_${index}" class="form-control form-control-sm" style="width:150px">
                    <input type="number" id="nl_cantidad_${index}" placeholder="Cant." class="form-control form-control-sm" style="width:80px" min="1" value="1">
                    <input type="text" id="nl_obs_${index}" placeholder="Observaciones" class="form-control form-control-sm" style="width:150px">
                    <button class="btn btn-sm btn-warning" type="button" onclick="agregarLote(${index})"><i class="fa fa-plus"></i> Agregar</button>
                </div>
                ${lista}
            </div>
        </td>
    </tr>`;
}

function agregarSerie(index) {
    let numero_serie = $('#ns_serie_' + index).val().trim();
    if (!numero_serie) {
        respuesta('El número de serie es obligatorio.', 'error');
        return;
    }
    let duplicado = array_orden_compra[index].series.some(function(s) { return s.numero_serie === numero_serie; });
    if (duplicado) {
        respuesta('Ya existe esa serie en este producto.', 'error');
        return;
    }
    array_orden_compra[index].series.push({
        numero_serie:  numero_serie,
        numero_motor:  $('#ns_motor_' + index).val().trim() || null,
        color:         $('#ns_color_' + index).val().trim() || null,
        anio:          $('#ns_anio_' + index).val().trim()  || null,
        observaciones: $('#ns_obs_' + index).val().trim()   || null,
    });
    recalcularCantidad(index);
    localStorage.setItem('productos_orden_compra', JSON.stringify(array_orden_compra));
    dibujar_tabla_productos_orden_compra();
}

function agregarLote(index) {
    let numero_lote = $('#nl_numero_' + index).val().trim();
    let cantidad    = parseInt($('#nl_cantidad_' + index).val());
    if (!numero_lote) {
        respuesta('El número de lote es obligatorio.', 'error');
        return;
    }
    if (!cantidad || cantidad < 1) {
        respuesta('La cantidad del lote debe ser mayor a 0.', 'error');
        return;
    }
    array_orden_compra[index].lotes.push({
        numero_lote:       numero_lote,
        fecha_vencimiento: $('#nl_vence_' + index).val() || null,
        cantidad:          cantidad,
        observaciones:     $('#nl_obs_' + index).val().trim() || null,
    });
    recalcularCantidad(index);
    localStorage.setItem('productos_orden_compra', JSON.stringify(array_orden_compra));
    dibujar_tabla_productos_orden_compra();
}

function eliminarSerie(productoIndex, serieIndex) {
    array_orden_compra[productoIndex].series.splice(serieIndex, 1);
    recalcularCantidad(productoIndex);
    localStorage.setItem('productos_orden_compra', JSON.stringify(array_orden_compra));
    dibujar_tabla_productos_orden_compra();
}

function eliminarLote(productoIndex, loteIndex) {
    array_orden_compra[productoIndex].lotes.splice(loteIndex, 1);
    recalcularCantidad(productoIndex);
    localStorage.setItem('productos_orden_compra', JSON.stringify(array_orden_compra));
    dibujar_tabla_productos_orden_compra();
}

function recalcularCantidad(index) {
    let el = array_orden_compra[index];
    if (!el.control_serie && !el.control_lote) return;
    let cantidad = 0;
    if (el.control_serie) cantidad += el.series.length;
    if (el.control_lote)  cantidad += el.lotes.reduce(function(sum, l) { return sum + l.cantidad; }, 0);
    el.cantidad     = cantidad;
    el.precio_total = (cantidad * parseFloat(el.producto_precio_unit || 0)).toFixed(2);
    array_orden_compra[index] = el;
}
function calcular_precio_total_recurso_orden_compra(index){
    let precio = parseFloat($('#precio_compra_' + index).val());
    let el = array_orden_compra[index];
    el.producto_precio_unit = precio;

    if (el.control_serie || el.control_lote) {
        // La cantidad ya está fijada por series/lotes; solo recalcula el total
        el.precio_total = (el.cantidad * precio).toFixed(2);
        array_orden_compra[index] = el;
    } else {
        let cantidad = parseFloat($('#cantiad__' + index).val());
        if (cantidad >= 0) {
            el.cantidad     = cantidad;
            el.precio_total = (cantidad * precio).toFixed(2);
            array_orden_compra[index] = el;
        }
    }
    total_orden_compra();
    dibujar_tabla_productos_orden_compra();
    localStorage.setItem('productos_orden_compra', JSON.stringify(array_orden_compra));
}
function total_orden_compra(){
    let total = 0;
    let sum = 0;
    if(array_orden_compra.length > 0){
        array_orden_compra.map(function(el,index){
            total += el.precio_total * 1;
        })
        $('#total').val(total.toFixed(2))
    }
}

function validar_campo_table(campo,index,mensaje){
    var objeto = document.getElementById(campo+index);
    respuesta(mensaje, 'error');
    /*objeto.style.border = 'solid #ff4d4d !important';*/
    objeto.style.setProperty("border", "2px solid #ff4d4d", "important");
}
$("#formulario_orden_compra").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_guardar_orden_compra';
    var id_proveedores  = $('#id_proveedores').val();
    var id_tipo_venta  = $('#id_tipo_venta').val();
    var fecha_emision  = $('#fecha_emision').val();
    var id_tipo_pago  = $('#id_tipo_pago').val();
    // var id_almacen  = $('id_almacen').val();
    var num_documento_  = $('#num_documento_').val();
    var total  = $('#total').val();
    valor = validar_campo_vacio('id_proveedores', id_proveedores, valor);
    valor = validar_campo_vacio('id_tipo_venta', id_tipo_venta, valor);
    valor = validar_campo_vacio('fecha_emision', fecha_emision, valor);
    valor = validar_campo_vacio('id_tipo_pago', id_tipo_pago, valor);
    // valor = validar_campo_vacio('id_almacen', id_almacen, valor);
    valor = validar_campo_vacio('num_documento_', num_documento_, valor);
    valor = validar_campo_vacio('total', total, valor);
    // valor = validar_campo_vacio('total', total, valor);
    // valor = validar_campo_vacio('gastos_op', gastos_op, valor);
    // valor = validar_campo_vacio('total_flete', total_flete, valor);
    let orden_compra_rapido = new FormData(this);

    orden_compra_rapido.append('datos' , JSON.stringify(array_orden_compra))
    var objetos= array_orden_compra
    /* funcion para validad campos vacios dentro del array de envio de recursos */
    objetos.map((objeto, index) => {
        if (parseFloat(objeto.precio_total) === 0 || parseFloat(objeto.precio_total) === null) {
            validar_campo_table('precio_compra_', index, 'El siguiente Campo Resaltado no puede estar vacío');
            valor = false;
        }
        if (!objeto.control_serie && !objeto.control_lote) {
            if (parseFloat(objeto.cantidad) === 0 || parseFloat(objeto.cantidad) === null) {
                validar_campo_table('cantiad__', index, 'Ingrese una Cantidad');
                valor = false;
            }
        }
        if (objeto.control_serie && objeto.series.length === 0) {
            respuesta('"' + objeto.producto_nombre + '" requiere al menos una serie.', 'error');
            valor = false;
        }
        if (objeto.control_lote && objeto.lotes.length === 0) {
            respuesta('"' + objeto.producto_nombre + '" requiere al menos un lote.', 'error');
            valor = false;
        }
    });

    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "logistica/crear_orden_compra",
            data:orden_compra_rapido,
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
                        // Limpiar los datos almacenados en el LocalStorage
                        localStorage.removeItem('productos_orden_compra');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    case 2:respuesta(r.result.message, 'error');break;
                    case 3:respuesta(r.result.message, 'error');break;
                    case 4:respuesta(r.result.message, 'error');break;
                    // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                    default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
                }
                cambiar_estado_boton(boton, "Guardar Registro", false);
            }
        });
    }
});


// bur historial de compras!
let btn_buscarOrdenCompra = document.getElementById('btn_buscarOrdenCompra');
if(btn_buscarOrdenCompra && btn_buscarOrdenCompra.addEventListener){
    btn_buscarOrdenCompra.addEventListener('click',function (){
        buscar_historial_orden_compras()
    });
}
function buscar_historial_orden_compras(){
    let desde = $('#desde_historial_compra').val();
    let hasta = $('#hasta_historial_compra').val();
    let id_proveedores = $('#id_proveedores_search').val();
    var boton = "btn_buscarOrdenCompra";
    $.ajax({
        type: "POST",
        url: ruta_global + "logistica/historial_orden_compra",
        data:{
            id_prove:id_proveedores,
            desde:desde,
            hasta:hasta,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Buscando...', true);
        },
    }).done(function(r){
        let datos = r.result.code;
        cambiar_estado_boton(boton, "<i class=\"fa-solid fa-magnifying-glass\"></i> Buscar Registros", false);
        let body_table = ""
        let correlativo_aumentar = 1
        let container_excel = "";
        if(datos.length > 0) {
            let val_excel = "";
            if (!id_proveedores ){
                val_excel = 0;
            }else{
                val_excel = id_proveedores
            }
            container_excel = `<a href="${ruta_global+'logistica/orden_compra_historial_excel/'+val_excel+'/'+desde+'/'+hasta}" class="btn btn-sm bg-success text-white" target="_blank">Generar Excel <i class="fa-solid fa-file-excel"></i></a>`
            datos.map(function (el , index){
                let enlace = ""
                let eliminar_orden = ""
                if(el.orden_compra_doc_adjuntado != null){
                    enlace += ` <a href="${ruta_global+el.orden_compra_doc_adjuntado}" target="_blank" >${el.orden_compra_tipo_doc}</a>`
                }else{
                    enlace += `<a href="#" target="_blank">Sin Documento</a>`
                }
                let FechaActual = new Date(); // Se crea un objeto Date con la fecha actual
                let FechaAnterior = new Date(el.orden_compra_fecha); // Se crea un objeto Date con la fecha anterior
                let horasPasadas = (FechaActual - FechaAnterior) / (1000 * 60 * 60); // Se calculan las horas pasadas entre las dos fechas

                if (horasPasadas < 24) {
                    eliminar_orden+= ` <a class="text-danger btn btn-sm m-1 bg-danger text-white"  id="eliminarOrdenComprabtn_${el.id_orden_compra}" onclick="preguntar('¿Está seguro de que desea eliminar esta orden de compra?','eliminar_ordenCompra','Si','No',${el.id_orden_compra})"><i class="fa-solid fa-trash "></i></a>`;
                }

                body_table +=
                    `
                        <tr >
                            <td>${correlativo_aumentar}</td>
                            <td>${el.orden_compra_fecha}</td>
                            <td>${el.proveedores_nombre} <br> ${el.proveedores_numero_documento}</td>
                            <td>${el.orden_compra_numero_doc == null ? '--' : el.orden_compra_numero_doc}</td>
                            <td>${enlace}</td>
                            <td>${el.orden_compra_numero}</td>
                            <td>
                                S/${el.total}
                               <b class="text-success">${el.tipo_pago_nombre}</b>
                            </td>
                            <td>
                                <a href="${ruta_global+'logistica/ordenCompraDetalle/'+'?ordenCompra='+encodeURIComponent(el.id_orden_compra)}"   class="btn btn-sm btn-primary text-white m-1 " ><i class="fa fa-eye menu_editar"></i></a>
                                <a href="${ruta_global+'logistica/compras_pdf/'+'?ordenCompra='+encodeURIComponent(el.id_orden_compra)}"  target="_blank" id="btn_pdf" class="btn btn-sm btn-warning text-white  m-1" ><i class="fa-regular fa-file-pdf"></i></a>
                                ${eliminar_orden}
                            </td>
                        </tr>
                    `
                correlativo_aumentar++
            })
            $('#buscar_ver_facturas').html(body_table)
            $('#btn_genExcelHistory').html(container_excel)
            $('#tablaHistorialCompras').DataTable()
        }
    });

}
function eliminar_ordenCompra(idOrdenCompra){
    $.ajax({
        type: "POST",
        url: ruta_global + "logistica/eliminar_orden_compra",
        data:{
            id:idOrdenCompra,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        success:function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta(r.result.message, 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                    break;
                case 2:respuesta(r.result.message, 'error');break;
                default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
            }
        }
    });
}
function eliminar_recurso_orden_compra(index){
    array_orden_compra.splice(index,1)
    dibujar_tabla_productos_orden_compra()
    total_orden_compra()
    localStorage.setItem('productos_orden_compra', JSON.stringify(array_orden_compra));

}

// ── IMPORTAR PRODUCTOS DESDE EXCEL ────────────────────────────────────────────
$("#formularioImportarExcel").on('submit', function (e) {
    e.preventDefault();
    var boton = 'btnImportarExcel';
    var archivo = $('#archivo_excel').val();
    if (!archivo) {
        respuesta('Debe seleccionar un archivo Excel.', 'error');
        return;
    }
    $.ajax({
        type: "POST",
        url: ruta_global + "logistica/importar_productos_excel",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, '<i class="fa-solid fa-spinner fa-spin"></i> Importando...', true);
        },
        success: function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta(r.result.message, 'success');
                    setTimeout(function () { location.reload(); }, 2000);
                    break;
                case 2:
                    respuesta('Error: ' + r.result.message, 'error');
                    break;
                default:
                    respuesta('¡Algo catastrófico ha ocurrido!', 'error');
                    break;
            }
            cambiar_estado_boton(boton, '<i class="fa-solid fa-upload"></i> Importar', false);
        },
        error: function (xhr) {
            respuesta('Error inesperado: ' + xhr.statusText, 'error');
            cambiar_estado_boton(boton, '<i class="fa-solid fa-upload"></i> Importar', false);
        }
    });
});
// ── fin IMPORTAR EXCEL ────────────────────────────────────────────────────────

