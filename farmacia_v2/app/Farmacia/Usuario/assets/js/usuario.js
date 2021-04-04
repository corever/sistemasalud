

var Usuario = {
    
    init : function(){
        selectChosen.initChosen('cambioUsuario');
	},

    actualizarPassword : function(form, btn){
        var btnText = $(btn).attr('disabled',true).html();
        $(btn).html('Actualizando... <i class="fa fa-spin fa-spinner"></i>');

        var msgerror = '';
        var error = false;

        if(form.nueva_pass.value == ""){
            msgerror += '- La nueva contraseña no puede quedar vacía<br/>';
            error = true;
        }
        if(form.nueva_pass.value != form.repetir_pass.value){
            msgerror += '- Las contraseñas no coinciden<br/>';
            error = true;
        }


        if(error){
            Modal.danger(msgerror, function(){
                $(btn).html(btnText).attr('disabled',false);
            });
        }else{
            $.post(Base.getBaseUri() + 'Usuarios/Usuario/actualizarPassword',{pass:form.nueva_pass.value},function(response){
                if(response.estado == true){
                    Modal.success(response.mensaje,function(){
                        form.nueva_pass.value = "";
                        form.repetir_pass.value = "";
                    });
                }else{
                    Modal.danger(response.mensaje);
                }
                $(btn).html(btnText).attr('disabled',false);
            },'json').fail(function(){
                Modal.danger('Fallo en el sistema. Intente nuevamente o comuníquese con Soporte', function(){
                    $(btn).html(btnText).attr('disabled',false);
                });
            });
        }

    },


    editarMisDatos : function(form, btn){
        var btnText = $(btn).attr('disabled',true).html();
        $(btn).html('Actualizando... <i class="fa fa-spin fa-spinner"></i>');

        var msgerror = '';
        var error = false;

        if(form.nombres.value == ""){
            msgerror += '- Su nombre no puede quedar vacío<br/>';
            error = true;
        }
        if(form.apellido_paterno.value == ""){
            msgerror += '- Debe ingresar su apellido paterno<br/>';
            error = true;
        }
        if(form.rut.value == ""){
            msgerror += '- Su rut debe ser válido<br/>';
            error = true;
        }
        if(form.email.value == ""){
            msgerror += '- Debe ingresar su email<br/>';
            error = true;
        }

        if(error){
            Modal.danger(msgerror, function(){
                $(btn).html(btnText).attr('disabled',false);
            });
        }else{
            var parametros = $(form).serialize();
            $.post(Base.getBaseUri() + 'Usuarios/Usuario/guardarMisDatos',{parametros:parametros}, function(response){
                if(response.estado == true){
                    Modal.success(response.mensaje, function(){
                        Modal.closeAll();
                    });
                }else{
                    Modal.danger(response.mensaje,function(){
                        $(btn).html(btnText).attr('disabled',false);
                    });
                }
            },'json').fail(function(){
                Modal.danger("Fallo en el sistema. Intente nuevamente o comuníquese con Soporte",function(){
                    $(btn).html(btnText).attr('disabled',false);
                });
            });
        }

    },


    cargarCalendarioTrabajo : function(usuario){
        moment.locale('es');
        Base.loadingStart("contenedor-calendario-trabajo");
        setTimeout(function(){
            $("#calendario-trabajo").fullCalendar({
                eventSources: [

                    // your event source
                    {
                        url: Base.getBaseUri() + 'Fechas/Feriados/getFeriadosJson',
                        type: 'POST',
                        data: {
                            custom_param1: 'something',
                            custom_param2: 'somethingelse'
                        },
                        error: function() {
                            alert('there was an error while fetching events!');
                        },
                        className : 'feriado',
                        borderColor : 'red'
                    }

                    // any other sources...

                ]
            });
        },500);
        Base.loadingStop(function(){$("#calendario-trabajo").fadeIn();});

    },

    cambiarAvatar : function(item){
        if(item.value == ""){
            Modal.danger('Debe seleccionar una imagen');
        }else{
            $("#progreso-avatar").fadeIn(function(){
                var formData = new FormData();
                formData.append('avatar_usuario', $(item)[0].files[0]);
                
                var file = $(item)[0].files[0];                
                if((file.size/1204) > 1024){
                    Modal.success('El archivo ingresado no puede ser mayor a 1MB', function(){
                        
                    });
                }else{
                    $.ajax({
                        url: Base.getBaseUri() +  "Usuarios/Avatar/cambiarAvatar",
                        type: "post",
                        dataType: "json",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
                    }).done(function(response){
                        if(response.estado == true){
                            var func = function(){
                                Modal.success(response.mensaje, function(){
                                    $("#imagen-avatar, #imagen-usuario").prop('src', response.img_src);
                                });
                            };
                        }else{
                            var func = function(){Modal.danger(response.mensaje)};
                        }
                        $("#progreso-avatar").fadeOut(func);
                    }).fail(function(){
                        Modal.danger('Error en sistema. Intente nuevamente o comuniquese con Soporte', function(){
                            $('#progreso-avatar').fadeOut();
                        });
                    });
                }
            });
        }
    },
    
    cambiarUsuario : function(form, btn){
        var btnText = $(btn).attr('disabled',true).html();
        $(btn).html('Cargando... <i class="fa fa-spin fa-spinner"></i>');

        var msgerror = '';
        var error = false;

        if(form.cambioUsuario.value == ""){
            msgerror += '- Debe Seleccionar un usuario<br/>';
            error = true;
        }
        var usuario = form.cambioUsuario.value.split("-");
        var id_usuario = usuario[0];

        if(error){
            Modal.danger(msgerror, function(){
                $(btn).html(btnText).attr('disabled',false);
            });
        }else{
            $.post(Base.getBaseUri() + 'Usuarios/Usuario/cambiaUsuario/'+id_usuario,'',function(response){                
                if(response.estado === true){
                    window.location.href = Base.getBaseUri() + response.redirect;
                }else{
                    Modal.danger(response.mensaje,function(){
                        $(btn).html(btnText).attr('disabled',false);
                    });
                }               
                $(btn).html(btnText).attr('disabled',false);
            },'json').fail(function(){
                Modal.danger('Fallo en el sistema. Intente nuevamente o comuníquese con Soporte', function(){
                    $(btn).html(btnText).attr('disabled',false);
                });
            });
        }
    }
}