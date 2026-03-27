$("#formulario_crear_menu").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_guardar_menu';
    var controlador_menu  = $('#controlador_menu').val();
    var nombre_menu  = $('#nombre_menu').val();
    var nombre_menu  = $('#nombre_menu').val();
    var orden_menu  = $('#orden_menu').val();
    valor = validar_campo_vacio('controlador_menu', controlador_menu, valor);
    valor = validar_campo_vacio('nombre_menu', nombre_menu, valor);
    valor = validar_campo_vacio('orden_menu', orden_menu, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "configuracion/crear_menu",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                if ( r == true){
                    respuesta('Registro Guardado Correctamente!', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }else{
                    respuesta('Error al Guardar Registro', 'error')
                }
                cambiar_estado_boton(boton, "Guardar Menu", false);
            }
        });
    }
});
$("#formulario_crear_submenu").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_guardar_submenu';
    var controlador_submenu  = $('#controlador_submenu').val();
    var nombre_submenu  = $('#nombre_submenu').val();
    var orden_submenu  = $('#orden_submenu').val();
    valor = validar_campo_vacio('controlador_submenu', controlador_submenu, valor);
    valor = validar_campo_vacio('nombre_submenu', nombre_submenu, valor);
    valor = validar_campo_vacio('orden_submenu', orden_submenu, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "configuracion/crear_submenu",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                if ( r == true){
                    respuesta('Registro Guardado Correctamente!', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }else{
                    respuesta('Error al Guardar Registro', 'error')
                }
                cambiar_estado_boton(boton, "Guardar Menu", false);
            }
        });
    }
});
$("#formulario_crear_opciones").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_guardar_opciones';
    var nombre_opciones  = $('#nombre_opciones').val();
    var funcion_opciones  = $('#funcion_opciones').val();
    var orden_opciones  = $('#orden_opciones').val();
    valor = validar_campo_vacio('nombre_opciones', nombre_opciones, valor);
    valor = validar_campo_vacio('funcion_opciones', funcion_opciones, valor);
    valor = validar_campo_vacio('orden_opciones', orden_opciones, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "configuracion/crear_opciones",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                if ( r == true){
                    respuesta('Registro Guardado Correctamente!', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }else{
                    respuesta('Error al Guardar Registro', 'error')
                }
                cambiar_estado_boton(boton, "Guardar Opción", false);
            }
        });
    }
});
$("#formulario_crear_usuario").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_guardar_usuarios';
    var nombre_persona  = $('#nombre_persona').val();
    var username  = $('#username').val();
    var persona_apellido_paterno  = $('#persona_apellido_paterno').val();
    var persona_apellido_materno  = $('#persona_apellido_materno').val();
    var persona_fecha_nacimiento  = $('#persona_fecha_nacimiento').val();
    var email  = $('#email').val();
    var tipo_documento  = $('#tipo_documento').val();
    var numero_doc  = $('#numero_doc').val();
    var password  = $('#password').val();
    var repetir_contrasena  = $('#repetir_contrasena').val();
    var id_roles  = $('#id_roles').val();
    var telefono  = $('#telefono').val();
    if(password != repetir_contrasena){
        respuesta('Las Contraseñas no coinciden', 'error')
    }
    valor = validar_campo_vacio('nombre_persona', nombre_persona, valor);
    valor = validar_campo_vacio('username', username, valor);
    valor = validar_campo_vacio('persona_apellido_paterno', persona_apellido_paterno, valor);
    valor = validar_campo_vacio('persona_apellido_materno', persona_apellido_materno, valor);
    valor = validar_campo_vacio('persona_fecha_nacimiento', persona_fecha_nacimiento, valor);
    valor = validar_campo_vacio('email', email, valor);
    valor = validar_campo_vacio('tipo_documento', tipo_documento, valor);
    valor = validar_campo_vacio('numero_doc', numero_doc, valor);
    // valor = validar_campo_vacio('password', password, valor);
    // valor = validar_campo_vacio('repetir_contrasena', repetir_contrasena, valor);
    valor = validar_campo_vacio('id_roles', id_roles, valor);
    valor = validar_campo_vacio('telefono', telefono, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "configuracion/crear_usuarios",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                if ( r == true){
                    respuesta('Registro Guardado Correctamente!', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }else{
                    respuesta('Error al Guardar Registro', 'error')
                }
                cambiar_estado_boton(boton, "Guardar Opción", false);
            }
        });
    }
});
$("#formulario_crear_rol").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_guardar_rol';
    var nombre_rol  = $('#nombre_rol').val();
    var descripcion_rol  = $('#descripcion_rol').val();
    valor = validar_campo_vacio('nombre_rol', nombre_rol, valor);
    valor = validar_campo_vacio('descripcion_rol', descripcion_rol, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "configuracion/crear_rol",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                if ( r == true){
                    respuesta('Registro Guardado Correctamente!', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }else{
                    respuesta('Error al Guardar Registro', 'error')
                }
                cambiar_estado_boton(boton, "Guardar Opción", false);
            }
        });
    }
});
$("#formulario_permisos_rol").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_guardar_permisos';
    var id_rol_editar  = $('#id_rol_editar').val();
    valor = validar_campo_vacio('id_rol_editar', id_rol_editar, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "configuracion/crear_permisos_rol",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                if ( r == true){
                    respuesta('Registro Guardado Correctamente!', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }else{
                    respuesta('Error al Guardar Registro', 'error')
                }
                cambiar_estado_boton(boton, "Guardar Opción", false);
            }
        });
    }
});
$("#formulario_crear_permisos").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_guardar_permisos';
    var id_rol_editar  = $('#id_rol_editar').val();
    valor = validar_campo_vacio('id_rol_editar', id_rol_editar, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "configuracion/crear_permisos_rol",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                if ( r == true){
                    respuesta('Registro Guardado Correctamente!', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }else{
                    respuesta('Error al Guardar Registro', 'error')
                }
                cambiar_estado_boton(boton, "Guardar Opción", false);
            }
        });
    }
});



$("#formulario_permisos_opciones").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_guardar_permiso_tab';
    var nombre_permiso__  = $('#nombre_permiso__').val();
    var id  = $('#id_opciones_permisos').val();
    valor = validar_campo_vacio('nombre_permiso__', nombre_permiso__, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "configuracion/crear_permisos_opciones",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                if ( r == 1){
                    respuesta('Registro Guardado Correctamente!', 'success');
                    $('#nombre_permiso__').val(" ");
                    permisos_tab_acciones(id);
                }else if(r == 2){
                    respuesta('Error al Guardar Registro', 'error')
                }else{
                    respuesta('El Permiso ya se encuentra registrado', 'error')
                }
                cambiar_estado_boton(boton, "Guardar Opción", false);
            }
        });
    }
});



let btn_crear_menus = document.getElementById('btn_crear_menus');
if(btn_crear_menus && btn_crear_menus.addEventListener){
    btn_crear_menus.addEventListener('click',function (){
        limpiarFormulario('formulario_crear_menu')
    });
}

let btn_crear_submenus = document.getElementById('btn_crear_submenus');
if(btn_crear_submenus && btn_crear_submenus.addEventListener){
    btn_crear_submenus.addEventListener('click',function (){
        limpiarFormulario_sin_input('formulario_crear_submenu','id_menu')
    });
}
let btn_crear_opciones = document.getElementById('btn_crear_opciones');
if(btn_crear_opciones && btn_crear_opciones.addEventListener){
    btn_crear_opciones.addEventListener('click',function (){
        limpiarFormulario_sin_input('formulario_crear_opciones','id_submenu')
    });
}
let btn_crear_usuario = document.getElementById('btn_crear_usuario');
if(btn_crear_usuario && btn_crear_usuario.addEventListener){
    btn_crear_usuario.addEventListener('click',function (){
        limpiarFormulario('formulario_crear_usuario')
        $('#contrasena_div').show(100);
        $('#contrasena_div2').show(100);
    });
}
let btn_crear_rol = document.getElementById('btn_crear_rol');
if(btn_crear_rol && btn_crear_rol.addEventListener){
    btn_crear_rol.addEventListener('click',function (){
        limpiarFormulario('formulario_crear_rol')
    });
}

// let theme_toggle = document.getElementById('theme-toggle');
// if(theme_toggle && theme_toggle.addEventListener){
//     theme_toggle.addEventListener('change',function (){
//         dark_mode()
//     });
// }
// function dark_mode(){
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $.ajax({
//         url:ruta_global+"configuracion/listar_datos_menu",
//         method: 'post',
//         data:{
//             id: id,
//             "_token": $("meta[name='csrf-token']").attr("content")
//         }
//     }).done(function(r){
//         let resul = JSON.parse(r);
//         $('#editar_menu').val(id);
//         $('#controlador_menu').val(resul.menu_controlador);
//         $('#nombre_menu').val(resul.menu_nombre);
//         $('#icono_menu').val(resul.menu_icono);
//         $('#orden_menu').val(resul.menu_orden);
//         if(resul.menu_mostrar == 1){
//             $('#visible').prop('checked', true);
//         }
//     });
// }





function editar_menu_(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:ruta_global+"configuracion/listar_datos_menu",
        method: 'post',
        data:{
            id: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        }
    }).done(function(r){
        let resul = JSON.parse(r);
        $('#editar_menu').val(id);
        $('#controlador_menu').val(resul.menu_controlador);
        $('#nombre_menu').val(resul.menu_nombre);
        $('#icono_menu').val(resul.menu_icono);
        $('#orden_menu').val(resul.menu_orden);
        if(resul.menu_mostrar == 1){
            $('#visible').prop('checked', true);
        }
    });
}
function editar_submenu(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:ruta_global+"configuracion/listar_datos_submenu",
        method: 'post',
        data:{
            id: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        }
    }).done(function(r){
        let resul = JSON.parse(r);
        $('#id_submenu').val(id);
        $('#controlador_submenu').val(resul.submenu_funcion);
        $('#nombre_submenu').val(resul.submenu_nombre);
        $('#orden_submenu').val(resul.submenu_orden);
        if(resul.submenu_mostrar == 1){
            $('#visible_submenu').prop('checked', true);
        }
    });
}

// function permisos(id){
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $.ajax({
//         url:ruta_global+"configuracion/listar_datos_submenu",
//         method: 'post',
//         data:{
//             id: id,
//             "_token": $("meta[name='csrf-token']").attr("content")
//         }
//     }).done(function(r){
//         let resul = JSON.parse(r);
//         $('#id_submenu').val(id);
//         $('#controlador_submenu').val(resul.submenu_funcion);
//         $('#nombre_submenu').val(resul.submenu_nombre);
//         $('#orden_submenu').val(resul.submenu_orden);
//         if(resul.submenu_mostrar == 1){
//             $('#visible_submenu').prop('checked', true);
//         }
//     });
// }





function editar_opciones(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:ruta_global+"configuracion/listar_datos_opciones",
        method: 'post',
        data:{
            id: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        }
    }).done(function(r){
        let resul = JSON.parse(r);
        $('#id_opciones').val(id);
        $('#nombre_opciones').val(resul.opciones_nombre);
        $('#funcion_opciones').val(resul.opciones_funcion);
        $('#orden_opciones').val(resul.opciones_orden);
        if(resul.opciones_mostrar == 1){
            $('#visible_opciones').prop('checked', true);
        }
    });
}


function permisos_tab_acciones(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:ruta_global+"configuracion/listar_acciones_opciones",
        method: 'post',
        data:{
            id: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        }

    }).done(function(r){
        $('#id_opciones_permisos').val(id);
        let datos = JSON.parse(r);
        let body = "";
        if(datos.length > 0) {
            datos.map(function(el,index){
                body +=
                    `
                         <tr>
                            <td>${el.id}</td>
                            <td>${el.name}</td>
                            <td>
                            <button class="btn btn-sm text-white  bg-danger" id="btn_eliminar_${el.id}" onclick="eliminar_permiso(${el.id},${id})"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>

                    `
            })
        }
        $('#tabla_permisos_id').html(body);

    });
}
function eliminar_permiso(id,id_opcion){
    let estado = 0;
    var boton = "btn_eliminar_"+id
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/eliminar_permiso",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Eliminando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Eliminado Correctamente!', 'success');
                permisos_tab_acciones(id_opcion);
            }else{
                respuesta('Error al eliminar Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"fa fa-trash\"></i>", false);

        }
    });
}


function editar_usuario(id){
    $('#contrasena_div').hide(100);
    $('#contrasena_div2').hide(100);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:ruta_global+"configuracion/listar_datos_usuario",
        method: 'post',
        data:{
            id: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        }
    }).done(function(r){
        let resul = JSON.parse(r);
        $('#id_users').val(id);
        $('#nombre_persona').val(resul.persona_nombre);
        $('#username').val(resul.username);
        $('#persona_apellido_paterno').val(resul.persona_apellido_paterno);
        $('#persona_apellido_materno').val(resul.persona_apellido_materno);
        $('#persona_fecha_nacimiento').val(resul.persona_nacimiento);
        $('#email').val(resul.email);
        $('#tipo_documento').val(resul.persona_tipo_documento);
        $('#id_roles').val(resul.id);
        $('#numero_doc').val(resul.persona_dni);
        $('#telefono').val(resul.persona_telefono);
        if(resul.user_fotografia != null){
            $('#imagen_usuario').attr('src',ruta_global+resul.user_fotografia);
        }else{
            $('#imagen_usuario').attr('src',ruta_global+'sin-fotografia.png');

        }

    });
}
function editar_rol(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:ruta_global+"configuracion/listar_datos_rol",
        method: 'post',
        data:{
            id: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        }
    }).done(function(r){
        let resul = JSON.parse(r);
        $('#id_rol').val(id);
        $('#nombre_rol').val(resul.name);
        $('#descripcion_rol').val(resul.rol_descripcion);
    });
}

function editar_permisos_por_rol(id){
    quoteCheckboxesInContainer();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:ruta_global+'configuracion/listar_datos_permisos_por_rol',
        method: 'POST',
        data:{
            id: id,
            "_token": $("meta[name='csrf-token']").attr("content")
        }
    }).done(function(r){
        let datos = JSON.parse(r);
        $("#id_rol_editar").val(id);
        if(datos.length > 0) {
            datos.map( el => {
                $("#edit_check_permisos_"+el.id).attr('checked',true);
            }  )
        }
    });
}




function desabilitar_opcion(id){
    var boton = "btn_anular"+id
    let estado = 0;
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/deshabilitar_opcion",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Deshabilitado Correctamente!', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }else{
                respuesta('Error al Deshabilitar Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"btn_eliminar fa-solid fa-ban\"></i>", false);
        }
    });
}
function habilitar_opciones(id){
    var boton = "btn_anular"+id
    let estado = 1;
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/deshabilitar_opcion",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Habilitando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Habilitado Correctamente!', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }else{
                respuesta('Error al Habilitado Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"btn_habilitar fa-regular fa-circle-check\"></i>", false);
        }
    });

}




function desabilitar_submenu(id){
    var boton = "btn_anular"+id
    let estado = 0;
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/deshabilitar_submenu",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Deshabilitado Correctamente!', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }else{
                respuesta('Error al Deshabilitar Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"btn_eliminar fa-solid fa-ban\"></i>", false);
        }
    });
}
function habilitar_submenu(id){
    var boton = "btn_anular"+id
    let estado = 1;
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/deshabilitar_submenu",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Habilitando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Habilitado Correctamente!', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }else{
                respuesta('Error al Habilitado Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"btn_habilitar fa-regular fa-circle-check\"></i>", false);
        }
    });

}

function desabilitar_menu(id){
    var boton = "btn_anular"+id
    let estado = 0;
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/deshabilitar_menu",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Deshabilitado Correctamente!', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }else{
                respuesta('Error al Deshabilitar Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"btn_eliminar fa-solid fa-ban\"></i>", false);
        }
    });
}
function habilitar_menu(id){
    var boton = "btn_anular"+id
    let estado = 1;
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/deshabilitar_menu",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Habilitando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Habilitado Correctamente!', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }else{
                respuesta('Error al Habilitado Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"btn_habilitar fa-regular fa-circle-check\"></i>", false);
        }
    });

}


function desabilitar_usuario(id){
    var boton = "btn_anular"+id
    let estado = 0;
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/deshabilitar_usuario",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Deshabilitado Correctamente!', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }else{
                respuesta('Error al Deshabilitar Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"btn_eliminar fa-solid fa-ban\"></i>", false);
        }
    });
}
function habilitar_usuario(id){
    var boton = "btn_anular"+id
    let estado = 1;
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/deshabilitar_usuario",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Habilitando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Habilitado Correctamente!', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }else{
                respuesta('Error al Habilitado Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"btn_habilitar fa-regular fa-circle-check\"></i>", false);
        }
    });

}

function desabilitar_rol(id){
    var boton = "btn_anular"+id
    let estado = 0;
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/deshabilitar_rol",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Deshabilitado Correctamente!', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }else{
                respuesta('Error al Deshabilitar Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"btn_eliminar fa-solid fa-ban\"></i>", false);
        }
    });
}
function habilitar_rol(id){
    var boton = "btn_anular"+id
    let estado = 1;
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/deshabilitar_rol",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Habilitando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Habilitado Correctamente!', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }else{
                respuesta('Error al Habilitado Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"btn_habilitar fa-regular fa-circle-check\"></i>", false);
        }
    });

}


function desabilitar_permiso(id){
    var boton = "btn_anular"+id
    let estado = 0;
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/deshabilitar_permiso",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Anulando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Deshabilitado Correctamente!', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }else{
                respuesta('Error al Deshabilitar Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"btn_eliminar fa-solid fa-ban\"></i>", false);
        }
    });
}
function habilitar_permiso(id){
    var boton = "btn_anular"+id
    let estado = 1;
    $.ajax({
        type: "POST",
        url: ruta_global + "configuracion/deshabilitar_permiso",
        data:{
            id:id,
            estado:estado,
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: 'json',
        beforeSend: function () {
            cambiar_estado_boton(boton, 'Habilitando...', true);
        },
        success:function (r) {
            if ( r == true){
                respuesta('Registro Habilitado Correctamente!', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }else{
                respuesta('Error al Habilitado Registro', 'error')
            }
            cambiar_estado_boton(boton, "<i class=\"btn_habilitar fa-regular fa-circle-check\"></i>", false);
        }
    });

}

