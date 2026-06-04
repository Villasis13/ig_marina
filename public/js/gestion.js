// ── Ubigeo cascade ────────────────────────────────────────────────────────
function ubigeo_cargar_provincias(dept_id, prov_select_id, dist_select_id) {
    $('#' + prov_select_id).html('<option value="">Cargando...</option>');
    $('#' + dist_select_id).html('<option value="">Distrito</option>');
    if (!dept_id) { $('#' + prov_select_id).html('<option value="">Provincia</option>'); return; }
    $.get(ruta_global + 'Gestion/ubigeo/provincias', { dept_id: dept_id }, function(data) {
        let opts = '<option value="">Provincia</option>';
        data.forEach(p => opts += `<option value="${p.id}">${p.name}</option>`);
        $('#' + prov_select_id).html(opts);
    });
}
function ubigeo_cargar_distritos(prov_id, dist_select_id) {
    $('#' + dist_select_id).html('<option value="">Cargando...</option>');
    if (!prov_id) { $('#' + dist_select_id).html('<option value="">Distrito</option>'); return; }
    $.get(ruta_global + 'Gestion/ubigeo/distritos', { prov_id: prov_id }, function(data) {
        let opts = '<option value="">Distrito</option>';
        data.forEach(d => opts += `<option value="${d.id}">${d.name}</option>`);
        $('#' + dist_select_id).html(opts);
    });
}
function ubigeo_preseleccionar(dept_id, prov_id, dist_id, dept_sel, prov_sel, dist_sel) {
    if (!dept_id) return;
    $('#' + dept_sel).val(dept_id);
    $.get(ruta_global + 'Gestion/ubigeo/provincias', { dept_id: dept_id }, function(data) {
        let opts = '<option value="">Provincia</option>';
        data.forEach(p => opts += `<option value="${p.id}">${p.name}</option>`);
        $('#' + prov_sel).html(opts).val(prov_id);
        $.get(ruta_global + 'Gestion/ubigeo/distritos', { prov_id: prov_id }, function(data2) {
            let opts2 = '<option value="">Distrito</option>';
            data2.forEach(d => opts2 += `<option value="${d.id}">${d.name}</option>`);
            $('#' + dist_sel).html(opts2).val(dist_id);
        });
    });
}
// ── fin ubigeo ─────────────────────────────────────────────────────────────

let btn_crear_proveedor = document.getElementById('btn_crear_proveedor');
if(btn_crear_proveedor && btn_crear_proveedor.addEventListener){
    btn_crear_proveedor.addEventListener('click',function (){
        limpiarCampos('formularioAgregarProveedor')
        $('#estadoActionFuction').val(1);
        $('#id_tipo_documento').val(4);
    });
}
let proveedores_numero_documento = document.getElementById('proveedores_numero_documento');
if(proveedores_numero_documento && proveedores_numero_documento.addEventListener){
    proveedores_numero_documento.addEventListener('change',function (){
        consultarNumdocumento('id_tipo_documento',this.id,'proveedores_nombre','proveedores_direccion')
    });
}

let id_tipo_documento = document.getElementById('id_tipo_documento');
if(id_tipo_documento && id_tipo_documento.addEventListener){
    id_tipo_documento.addEventListener('change',function (){
        $('#proveedores_numero_documento').val('');
        $('#proveedores_nombre').val('');
        $('#proveedores_direccion').val('');
    });
}


$("#formularioAgregarProveedor").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btnSaveProveedor';
    var id_tipo_documento  = $('#id_tipo_documento').val();
    var proveedores_numero_documento  = $('#proveedores_numero_documento').val();
    var proveedores_nombre  = $('#proveedores_nombre').val();
    valor = validar_campo_vacio('id_tipo_documento', id_tipo_documento, valor);
    valor = validar_campo_vacio('proveedores_numero_documento', proveedores_numero_documento, valor);
    valor = validar_campo_vacio('proveedores_nombre', proveedores_nombre, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestion/guardar_proveedor",
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
                    case 3:$('#mensajeErrorProve').html(r.result.message);break;
                    case 4:respuesta(r.result.message, 'error');break;
                    // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                    default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
                }
                cambiar_estado_boton(boton, "Guardar registro", false);
            }
        });
    }
});

function eliminar_proveedor(id){
    var boton = "btnEliminarProveedor_"+id
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestion/guardar_proveedor",
        data:{
            id_proveedores:id,
            estadoActionFuction:3,
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
function modificarProveedor(id){
    $.ajax({
        url:ruta_global+"Gestion/listar_datos_proveedor",
        method: 'post',
        data:{
            id_proveedores: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function(r){
        let datos =  r.result.code;
        $('#estadoActionFuction').val(2);
        $('#id_proveedores').val(datos.id_proveedores);
        $('#id_tipo_documento').val(datos.id_tipo_documento);
        $('#proveedores_nombre').val(datos.proveedores_nombre);
        $('#proveedores_numero_documento').val(datos.proveedores_numero_documento);
        $('#proveedores_direccion').val(datos.proveedores_direccion);
        $('#proveedores_tipo_persona').val(datos.proveedores_tipo_persona || 'juridica');
        $('#proveedores_sexo').val(datos.proveedores_sexo || '');
        $('#proveedores_telefono').val(datos.proveedores_telefono);
        $('#proveedores_correo').val(datos.proveedores_correo);
        $('#proveedores_nombre_contacto').val(datos.proveedores_nombre_contacto || '');
        $('#proveedores_cargo').val(datos.proveedores_cargo || '');
        // Ubigeo
        if (datos.proveedores_ubigeo) {
            let dist_id = datos.proveedores_ubigeo;
            let dept_id = dist_id.substring(0, 2);
            let prov_id = dist_id.substring(0, 4);
            ubigeo_preseleccionar(dept_id, prov_id, dist_id, 'prov_dept', 'prov_prov', 'prov_dist');
        } else {
            $('#prov_dept').val(''); $('#prov_prov').html('<option value="">Provincia</option>'); $('#prov_dist').html('<option value="">Distrito</option>');
        }

    });
}


let btn_crear_familia = document.getElementById('btn_crear_familia');
if(btn_crear_familia && btn_crear_familia.addEventListener){
    btn_crear_familia.addEventListener('click',function (){
        limpiarCampos('formularioAgregarFamilia')
        $('#estadoActionFuctionFamilia').val(1);
    });
}
$("#formularioAgregarFamilia").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btnSaveFamilia';
    var fa_nombre  = $('#fa_nombre').val();
    valor = validar_campo_vacio('fa_nombre', fa_nombre, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestion/guardar_familia",
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


function modificarFamilia(id,nombre){
    $('#estadoActionFuctionFamilia').val(2);
    $('#id_fa').val(id);
    $('#fa_nombre').val(nombre);
}
function eliminar_familia(id){
    var boton = "btnEliminarFamilia_"+id
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestion/guardar_familia",
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


let btn_crear_categoria = document.getElementById('btn_crear_categoria');
if(btn_crear_categoria && btn_crear_categoria.addEventListener){
    btn_crear_categoria.addEventListener('click',function (){
        limpiarCampos('formulario_categoria')
        let valor = $('#btn_crear_categoria').attr('data_id_familia');
        $('#estadoActionFuctionCategoria').val(1);
        $('#id_fa').val(valor);
    });
}

$("#formulario_categoria").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btnSaveCategoria';
    var ca_nombre  = $('#ca_nombre').val();
    valor = validar_campo_vacio('ca_nombre', ca_nombre, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestion/guardar_categoria",
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
function modificarCategoria(id,nombre){
    $('#estadoActionFuctionCategoria').val(2);
    $('#id_ca').val(id);
    $('#ca_nombre').val(nombre);
}
function eliminar_categoria(id){
    var boton = "btnEliminarCategoria_"+id
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestion/guardar_categoria",
        data:{
            id_ca:id,
            estadoActionFuctionCategoria:3,
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

function modificarCliente(idCliente){
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestion/listarCliente",
        data:{
            id:idCliente,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        success:function (r) {
            if (r.result.code == 1){
                let datos = r.result.datos;
                if (datos){
                    $('#estadoActionFuction').val(2);
                    $('#id_clientes').val(datos.id_clientes);
                    $('#cliente_tipo_persona').val(datos.cliente_tipo_persona || 'natural');
                    $('#id_tipo_documento').val(datos.id_tipo_documento);
                    $('#cliente_numero').val(datos.cliente_numero);
                    if (datos.id_tipo_documento == 4){
                        $('#cliente_nombre_general').val(datos.cliente_razonsocial);
                    }else{
                        $('#cliente_nombre_general').val(datos.cliente_nombre);
                    }
                    $('#cliente_sexo').val(datos.cliente_sexo || '');
                    $('#cliente_atencion').val(datos.cliente_atencion || '');
                    $('#cliente_direccion').val(datos.cliente_direccion);
                    $('#cliente_telefono').val(datos.cliente_telefono || '');
                    $('#cliente_correo').val(datos.cliente_correo || '');
                    $('#cliente_contribuyente').val(datos.cliente_contribuyente || '');
                    // Ubigeo (viene en r.result.ubigeo)
                    let ub = r.result.ubigeo;
                    if (ub && ub.dept_id) {
                        ubigeo_preseleccionar(ub.dept_id, ub.prov_id, ub.dist_id, 'cli_dept', 'cli_prov', 'cli_dist');
                    } else {
                        $('#cli_dept').val(''); $('#cli_prov').html('<option value="">Provincia</option>'); $('#cli_dist').html('<option value="">Distrito</option>');
                    }
                }
            }else{

            }
        }
    });
}

let btnCliente = document.getElementById('btnCliente');
if(btnCliente && btnCliente.addEventListener){
    btnCliente.addEventListener('click',function (){
        limpiarCampos('formularioCrearCliente')
        $('#estadoActionFuction').val(1);
        $('#id_tipo_documento').val(2);
    });
}
$("#formularioCrearCliente").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btnSaveCliente';
    var id_tipo_documento  = $('#id_tipo_documento').val();
    var cliente_numero  = $('#cliente_numero').val();
    var cliente_nombre_general  = $('#cliente_nombre_general').val();
    valor = validar_campo_vacio('id_tipo_documento', id_tipo_documento, valor);
    valor = validar_campo_vacio('cliente_numero', cliente_numero, valor);
    valor = validar_campo_vacio('cliente_nombre_general', cliente_nombre_general, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestion/guardar_cliente",
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

let cliente_numero = document.getElementById('cliente_numero');
if(cliente_numero && cliente_numero.addEventListener){
    cliente_numero.addEventListener('change',function (){
        consultarNumdocumento('id_tipo_documento',this.id,'cliente_nombre_general','cliente_direccion')
    });
}

function eliminar_cliente(id){
    var boton = "btnEliminarCliente_"+id
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestion/guardar_cliente",
        data:{
            id_clientes:id,
            estadoActionFuction:3,
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

// ── LÍNEAS ────────────────────────────────────────────────────────────────────
let btn_crear_linea = document.getElementById('btn_crear_linea');
if (btn_crear_linea && btn_crear_linea.addEventListener) {
    btn_crear_linea.addEventListener('click', function () {
        limpiarCampos('formularioLinea');
        $('#estadoActionFuctionLinea').val(1);
    });
}

$("#formularioLinea").on('submit', function (e) {
    e.preventDefault();
    var valor = true;
    var boton = 'btnSaveLinea';
    var linea_codigo = $('#linea_codigo').val();
    var linea_descripcion = $('#linea_descripcion').val();
    valor = validar_campo_vacio('linea_codigo', linea_codigo, valor);
    valor = validar_campo_vacio('linea_descripcion', linea_descripcion, valor);
    if (valor) {
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestion/guardar_linea",
            data: new FormData(this),
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
                        setTimeout(function () { location.reload(); }, 1000);
                        break;
                    case 2: respuesta(r.result.message, 'error'); break;
                    case 3: respuesta(r.result.message, 'error'); break;
                    default: respuesta('¡Algo catastrofico ha ocurrido!', 'error'); break;
                }
                cambiar_estado_boton(boton, "Guardar registro", false);
            }
        });
    }
});

function modificarLinea(id) {
    $.ajax({
        url: ruta_global + "Gestion/listar_datos_linea",
        method: 'post',
        data: {
            id_linea: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function (r) {
        let datos = r.result.code;
        $('#estadoActionFuctionLinea').val(2);
        $('#id_linea').val(datos.id_linea);
        $('#linea_codigo').val(datos.linea_codigo);
        $('#linea_descripcion').val(datos.linea_descripcion);
        $('#linea_tipo').val(datos.linea_tipo || '');
    });
}

function eliminar_linea(id) {
    var boton = "btnEliminarLinea_" + id;
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestion/guardar_linea",
        data: {
            id_linea: id,
            estadoActionFuctionLinea: 3,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Eliminando...', true);
        },
        success: function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta(r.result.message, 'success');
                    setTimeout(function () { location.reload(); }, 1000);
                    break;
                case 2: respuesta(r.result.message, 'error'); break;
                case 3: respuesta(r.result.message, 'error'); break;
                default: respuesta('¡Algo catastrofico ha ocurrido!', 'error'); break;
            }
            cambiar_estado_boton(boton, "<i class=\"fa-solid fa-trash\"></i>", false);
        }
    });
}
// ── fin LÍNEAS ────────────────────────────────────────────────────────────────

// ── CLASIFICADORES ────────────────────────────────────────────────────────────
let btn_crear_clasificador = document.getElementById('btn_crear_clasificador');
if (btn_crear_clasificador && btn_crear_clasificador.addEventListener) {
    btn_crear_clasificador.addEventListener('click', function () {
        limpiarCampos('formularioClasificador');
        $('#estadoActionFuctionClasificador').val(1);
    });
}

$("#formularioClasificador").on('submit', function (e) {
    e.preventDefault();
    var valor = true;
    var boton = 'btnSaveClasificador';
    var clasificador_codigo = $('#clasificador_codigo').val();
    var clasificador_nombre = $('#clasificador_nombre').val();
    valor = validar_campo_vacio('clasificador_codigo', clasificador_codigo, valor);
    valor = validar_campo_vacio('clasificador_nombre', clasificador_nombre, valor);
    if (valor) {
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestion/guardar_clasificador",
            data: new FormData(this),
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
                        setTimeout(function () { location.reload(); }, 1000);
                        break;
                    case 2: respuesta(r.result.message, 'error'); break;
                    case 3: respuesta(r.result.message, 'error'); break;
                    default: respuesta('¡Algo catastrofico ha ocurrido!', 'error'); break;
                }
                cambiar_estado_boton(boton, "Guardar registro", false);
            }
        });
    }
});

function modificarClasificador(id) {
    $.ajax({
        url: ruta_global + "Gestion/listar_datos_clasificador",
        method: 'post',
        data: {
            id_clasificador: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function (r) {
        let datos = r.result.code;
        $('#estadoActionFuctionClasificador').val(2);
        $('#id_clasificador').val(datos.id_clasificador);
        $('#clasificador_codigo').val(datos.clasificador_codigo);
        $('#clasificador_nombre').val(datos.clasificador_nombre);
    });
}

function eliminar_clasificador(id) {
    var boton = "btnEliminarClasificador_" + id;
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestion/guardar_clasificador",
        data: {
            id_clasificador: id,
            estadoActionFuctionClasificador: 3,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Eliminando...', true);
        },
        success: function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta(r.result.message, 'success');
                    setTimeout(function () { location.reload(); }, 1000);
                    break;
                case 2: respuesta(r.result.message, 'error'); break;
                case 3: respuesta(r.result.message, 'error'); break;
                default: respuesta('¡Algo catastrofico ha ocurrido!', 'error'); break;
            }
            cambiar_estado_boton(boton, "<i class=\"fa-solid fa-trash\"></i>", false);
        }
    });
}
// ── fin CLASIFICADORES ────────────────────────────────────────────────────────

// ── ALMACENES ─────────────────────────────────────────────────────────────────
let btn_crear_almacen = document.getElementById('btn_crear_almacen');
if (btn_crear_almacen && btn_crear_almacen.addEventListener) {
    btn_crear_almacen.addEventListener('click', function () {
        limpiarCampos('formularioAlmacen');
        $('#estadoActionFuctionAlmacen').val(1);
        $('#almacen_ap').prop('checked', false);
    });
}

$("#formularioAlmacen").on('submit', function (e) {
    e.preventDefault();
    var valor = true;
    var boton = 'btnSaveAlmacen';
    var almacen_codigo = $('#almacen_codigo').val();
    var almacen_nombre = $('#almacen_nombre').val();
    valor = validar_campo_vacio('almacen_codigo', almacen_codigo, valor);
    valor = validar_campo_vacio('almacen_nombre', almacen_nombre, valor);
    if (valor) {
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestion/guardar_almacen",
            data: new FormData(this),
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
                        setTimeout(function () { location.reload(); }, 1000);
                        break;
                    case 2: respuesta(r.result.message, 'error'); break;
                    case 3: respuesta(r.result.message, 'error'); break;
                    default: respuesta('¡Algo catastrofico ha ocurrido!', 'error'); break;
                }
                cambiar_estado_boton(boton, "Guardar registro", false);
            }
        });
    }
});

function modificarAlmacen(id) {
    $.ajax({
        url: ruta_global + "Gestion/listar_datos_almacen",
        method: 'post',
        data: {
            id_almacen: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function (r) {
        let datos = r.result.code;
        $('#estadoActionFuctionAlmacen').val(2);
        $('#id_almacen').val(datos.id_almacen);
        $('#almacen_codigo').val(datos.almacen_codigo || '');
        $('#almacen_nombre').val(datos.almacen_nombre);
        $('#almacen_sunat').val(datos.almacen_sunat || '');
        $('#almacen_ap').prop('checked', datos.almacen_ap == 1);
    });
}

function eliminar_almacen(id) {
    var boton = "btnEliminarAlmacen_" + id;
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestion/guardar_almacen",
        data: {
            id_almacen: id,
            estadoActionFuctionAlmacen: 3,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Eliminando...', true);
        },
        success: function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta(r.result.message, 'success');
                    setTimeout(function () { location.reload(); }, 1000);
                    break;
                case 2: respuesta(r.result.message, 'error'); break;
                case 3: respuesta(r.result.message, 'error'); break;
                default: respuesta('¡Algo catastrofico ha ocurrido!', 'error'); break;
            }
            cambiar_estado_boton(boton, "<i class=\"fa-solid fa-trash\"></i>", false);
        }
    });
}
// ── fin ALMACENES ─────────────────────────────────────────────────────────────

// ── OPERACIONES ───────────────────────────────────────────────────────────────
let btn_crear_operacion = document.getElementById('btn_crear_operacion');
if (btn_crear_operacion && btn_crear_operacion.addEventListener) {
    btn_crear_operacion.addEventListener('click', function () {
        limpiarCampos('formularioOperacion');
        $('#estadoActionFuctionOperacion').val(1);
        $('#operacion_operacion').val('');
        $('#operacion_stock').prop('checked', false);
        $('#operacion_compra').prop('checked', false);
        $('#operacion_promediar').prop('checked', false);
    });
}

$("#formularioOperacion").on('submit', function (e) {
    e.preventDefault();
    var valor = true;
    var boton = 'btnSaveOperacion';
    valor = validar_campo_vacio('operacion_tipo', $('#operacion_tipo').val(), valor);
    valor = validar_campo_vacio('operacion_descripcion', $('#operacion_descripcion').val(), valor);
    valor = validar_campo_vacio('operacion_operacion', $('#operacion_operacion').val(), valor);
    if (valor) {
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestion/guardar_operacion",
            data: new FormData(this),
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
                        setTimeout(function () { location.reload(); }, 1000);
                        break;
                    case 2: respuesta(r.result.message, 'error'); break;
                    case 3: respuesta(r.result.message, 'error'); break;
                    default: respuesta('¡Algo catastrofico ha ocurrido!', 'error'); break;
                }
                cambiar_estado_boton(boton, "Guardar registro", false);
            }
        });
    }
});

function modificarOperacion(id) {
    $.ajax({
        url: ruta_global + "Gestion/listar_datos_operacion",
        method: 'post',
        data: {
            id_operacion: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function (r) {
        let datos = r.result.code;
        $('#estadoActionFuctionOperacion').val(2);
        $('#id_operacion').val(datos.id_operacion);
        $('#operacion_tipo').val(datos.operacion_tipo);
        $('#operacion_descripcion').val(datos.operacion_descripcion);
        $('#operacion_operacion').val(datos.operacion_operacion);
        $('#operacion_stock').prop('checked', datos.operacion_stock == 1);
        $('#operacion_compra').prop('checked', datos.operacion_compra == 1);
        $('#operacion_promediar').prop('checked', datos.operacion_promediar == 1);
    });
}

function eliminar_operacion(id) {
    var boton = "btnEliminarOperacion_" + id;
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestion/guardar_operacion",
        data: {
            id_operacion: id,
            estadoActionFuctionOperacion: 3,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Eliminando...', true);
        },
        success: function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta(r.result.message, 'success');
                    setTimeout(function () { location.reload(); }, 1000);
                    break;
                case 2: respuesta(r.result.message, 'error'); break;
                case 3: respuesta(r.result.message, 'error'); break;
                default: respuesta('¡Algo catastrofico ha ocurrido!', 'error'); break;
            }
            cambiar_estado_boton(boton, "<i class=\"fa-solid fa-trash\"></i>", false);
        }
    });
}
// ── fin OPERACIONES ───────────────────────────────────────────────────────────

// ── UNIDAD DE MANEJO ──────────────────────────────────────────────────────────
function um_mostrar_abreviatura(sel) {
    var abr = $(sel).find('option:selected').data('abr') || '—';
    $('#um_abreviatura').text(abr);
}

let btn_crear_um = document.getElementById('btn_crear_um');
if (btn_crear_um && btn_crear_um.addEventListener) {
    btn_crear_um.addEventListener('click', function () {
        limpiarCampos('formularioUM');
        $('#estadoActionFuctionUM').val(1);
        $('#um_id_medida').val('');
        $('#um_abreviatura').text('—');
    });
}

$("#formularioUM").on('submit', function (e) {
    e.preventDefault();
    var valor = true;
    var boton = 'btnSaveUM';
    valor = validar_campo_vacio('um_codigo', $('#um_codigo').val(), valor);
    valor = validar_campo_vacio('um_id_medida', $('#um_id_medida').val(), valor);
    if (valor) {
        $.ajax({
            type: "POST",
            url: ruta_global + "Gestion/guardar_unidad_manejo",
            data: new FormData(this),
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
                        setTimeout(function () { location.reload(); }, 1000);
                        break;
                    case 2: respuesta(r.result.message, 'error'); break;
                    case 3: respuesta(r.result.message, 'error'); break;
                    default: respuesta('¡Algo catastrofico ha ocurrido!', 'error'); break;
                }
                cambiar_estado_boton(boton, "Guardar registro", false);
            }
        });
    }
});

function modificarUM(id) {
    $.ajax({
        url: ruta_global + "Gestion/listar_datos_unidad_manejo",
        method: 'post',
        data: {
            id_unidad_manejo: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function (r) {
        let datos = r.result.code;
        $('#estadoActionFuctionUM').val(2);
        $('#id_unidad_manejo').val(datos.id_unidad_manejo);
        $('#um_codigo').val(datos.unidad_manejo_codigo);
        $('#um_sunat').val(datos.unidad_manejo_sunat || '');
        $('#um_id_medida').val(datos.id_medida);
        // actualizar abreviatura
        var abr = $('#um_id_medida option:selected').data('abr') || '—';
        $('#um_abreviatura').text(abr);
    });
}

function eliminar_um(id) {
    var boton = "btnEliminarUM_" + id;
    $.ajax({
        type: "POST",
        url: ruta_global + "Gestion/guardar_unidad_manejo",
        data: {
            id_unidad_manejo: id,
            estadoActionFuctionUM: 3,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Eliminando...', true);
        },
        success: function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta(r.result.message, 'success');
                    setTimeout(function () { location.reload(); }, 1000);
                    break;
                case 2: respuesta(r.result.message, 'error'); break;
                case 3: respuesta(r.result.message, 'error'); break;
                default: respuesta('¡Algo catastrofico ha ocurrido!', 'error'); break;
            }
            cambiar_estado_boton(boton, "<i class=\"fa-solid fa-trash\"></i>", false);
        }
    });
}
// ── fin UNIDAD DE MANEJO ──────────────────────────────────────────────────────
