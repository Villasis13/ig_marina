
$("#aperturar_caja_formulario").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_aperturar_caja';
    var id_caja_inicio  = $('#id_caja_inicio').val();
    var monto_apertura  = $('#monto_apertura').val();
    valor = validar_campo_vacio('id_caja_inicio', id_caja_inicio, valor);
    valor = validar_campo_vacio('monto_apertura', monto_apertura, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "admin/aperturar_caja",
            data:new FormData(this),
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
                            location.reload();
                        }, 1000);
                        break;
                    case 2:respuesta('Ocurrió un error ', 'error');break;
                    case 3:respuesta('Esta caja ya ha sido abierta.', 'error');break;
                    case 4:respuesta('Ya posee una caja abierta.', 'error');break;
                    // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                    default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
                }
                cambiar_estado_boton(boton, "Apertura existosa!", false);
            }
        });
    }
});
$("#cierre_caja_formulario").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_cierre_caja';
    var id_caja  = $('#id_caja').val();
    var monto_cierre  = $('#monto_cierre').val();
    valor = validar_campo_vacio('id_caja', id_caja, valor);
    valor = validar_campo_vacio('monto_cierre', monto_cierre, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "admin/cerrar_caja",
            data:new FormData(this),
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
                            location.reload();
                        }, 1000);
                        break;
                    case 2:respuesta('Ocurrió un error ', 'error');break;
                    // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                    default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
                }
                cambiar_estado_boton(boton, "Apertura existosa!", false);
            }
        });
    }
});

function listar_datos_usuarioLogueado(){
    $.ajax({
        type: "POST",
        url: ruta_global + "admin/informacionusuario",
        data:{
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function(r){
        let informacion = r;
        $('#nombre_persona_editarDatosPersonales').val(informacion.persona_nombre);
        $('#apellido_paterno_editarDatosPersonales').val(informacion.persona_apellido_paterno);
        $('#apellido_materno_editarDatosPersonales').val(informacion.persona_apellido_materno);
        $('#fecha_nacimiento_editarDatosPersonales').val(informacion.persona_nacimiento);
        $('#numero_telefono_editarDatosPersonales').val(informacion.persona_telefono);
        $('#estado_accion_editar_usuario').val(1);
        $('#id_persona_editarLogueado').val(informacion.id_persona);
    });
}
function listar_datos_usuarioLogueado2(){
    $.ajax({
        type: "POST",
        url: ruta_global + "admin/informacionusuario",
        data:{
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
    }).done(function(r){
        let informacion = r;
        $('#nombre_usuario_editarDatosLogueado').val(informacion.nombre_users);
        $('#email_usuario_editarDatosLogueado').val(informacion.email);
        $('#estado_accion_editar_usuario2').val(2);
        $('#id_usuario_editarLogueado2').val(informacion.id_users);
    });
}


$("#formularioDatosPersonalesLogueado").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btnModificarUsuarioPersona';
    var nombre_persona_editarDatosPersonales  = $('#nombre_persona_editarDatosPersonales').val();
    var estado_accion_editar_usuario  = $('#estado_accion_editar_usuario').val();
    var id_persona_editarLogueado  = $('#id_persona_editarLogueado').val();
    var apellido_paterno_editarDatosPersonales  = $('#apellido_paterno_editarDatosPersonales').val();
    var apellido_materno_editarDatosPersonales  = $('#apellido_materno_editarDatosPersonales').val();
    var fecha_nacimiento_editarDatosPersonales  = $('#fecha_nacimiento_editarDatosPersonales').val();
    var numero_telefono_editarDatosPersonales  = $('#numero_telefono_editarDatosPersonales').val();
    valor = validar_campo_vacio('nombre_persona_editarDatosPersonales', nombre_persona_editarDatosPersonales, valor);
    valor = validar_campo_vacio('estado_accion_editar_usuario', estado_accion_editar_usuario, valor);
    valor = validar_campo_vacio('id_persona_editarLogueado', id_persona_editarLogueado, valor);
    valor = validar_campo_vacio('apellido_paterno_editarDatosPersonales', apellido_paterno_editarDatosPersonales, valor);
    valor = validar_campo_vacio('apellido_materno_editarDatosPersonales', apellido_materno_editarDatosPersonales, valor);
    valor = validar_campo_vacio('fecha_nacimiento_editarDatosPersonales', fecha_nacimiento_editarDatosPersonales, valor);
    valor = validar_campo_vacio('numero_telefono_editarDatosPersonales', numero_telefono_editarDatosPersonales, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "admin/modificarInformacionusuarioLogueado",
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
                    case 6:respuesta(r.result.message, 'error');$('#mensajeErrorDatosPersonales').html(r.result.message);break;
                    // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                    default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
                }
                cambiar_estado_boton(boton, "<i class=\"fa-solid fa-save\"></i> Guardar", false);
            }
        });
    }
});
$("#formularioDatosUsuarioLogueado").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btnModificarUsuarioLogueado';
    var nombre_usuario_editarDatosLogueado  = $('#nombre_usuario_editarDatosLogueado').val();
    var id_usuario_editarLogueado2  = $('#id_usuario_editarLogueado2').val();
    var email_usuario_editarDatosLogueado  = $('#email_usuario_editarDatosLogueado').val();
    valor = validar_campo_vacio('nombre_usuario_editarDatosLogueado', nombre_usuario_editarDatosLogueado, valor);
    valor = validar_campo_vacio('id_usuario_editarLogueado2', id_usuario_editarLogueado2, valor);
    valor = validar_campo_vacio('email_usuario_editarDatosLogueado', email_usuario_editarDatosLogueado, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "admin/modificarInformacionusuarioLogueado",
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
                    case 6:respuesta(r.result.message, 'error');$('#mensajeErrorDatosUsuariosLogueado').html(r.result.message);break;
                    // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                    default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
                }
                cambiar_estado_boton(boton, "<i class=\"fa-solid fa-save\"></i> Guardar", false);
            }
        });
    }
});
$("#formularioContrasenaNueva").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btnModificarContrasenaUsuarioLogueado';
    var contraseñaUsuarioLogueadoNuevo  = $('#contraseñaUsuarioLogueadoNuevo').val();
    var id_usuarioLogueadoContrasenaNueva  = $('#id_usuarioLogueadoContrasenaNueva').val();
    var repetContrasenaNuevaUsuario  = $('#repetContrasenaNuevaUsuario').val();
    valor = validar_campo_vacio('contraseñaUsuarioLogueadoNuevo', contraseñaUsuarioLogueadoNuevo, valor);
    valor = validar_campo_vacio('id_usuarioLogueadoContrasenaNueva', id_usuarioLogueadoContrasenaNueva, valor);
    valor = validar_campo_vacio('repetContrasenaNuevaUsuario', repetContrasenaNuevaUsuario, valor);
    if (contraseñaUsuarioLogueadoNuevo != repetContrasenaNuevaUsuario){
        respuesta('Las contraseñas no coinciden', 'error');
        valor = false;
    }
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "admin/modificarInformacionusuarioLogueado",
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
                    case 6:respuesta(r.result.message, 'error');$('#mensajeErrorDatosUsuariosContrasena').html(r.result.message);break;
                    // case 6:respuesta('Algún dato NO fue ingresado correctamente', 'error');break;
                    default:respuesta('¡Algo catastrofico ha ocurrido!', 'error');break;
                }
                cambiar_estado_boton(boton, "<i class=\"fa-solid fa-save\"></i> Guardar", false);
            }
        });
    }
});

