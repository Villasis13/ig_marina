$("#formAuthentication").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = 'btn_iniciar_sesion';
    var username  = $('#username').val();
    var password  = $('#password').val();
    valor = validar_campo_vacio('username', username, valor);
    valor = validar_campo_vacio('password', password, valor);
    if (valor){
        $.ajax({
            type: "POST",
            url: ruta_global + "Login-in",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Entrando...', true);
            },
            success:function (r) {
                if ( r == true){
                    respuesta('Ingreso exitoso, redireccionando...', 'success');
                    setTimeout(
                        function(){
                            location.href = ruta_global+"admin"
                        }
                        ,1000);
                }else{
                    respuesta('Error al validar inicio de sesión', 'error')
                }
                cambiar_estado_boton(boton, "Iniciar Sesión", false);
            }
        });
    }
});


