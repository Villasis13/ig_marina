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
