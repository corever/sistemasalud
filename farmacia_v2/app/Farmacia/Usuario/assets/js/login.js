
var Login = {


    pressEnter : function(e){
        var yo = this;
        if(e.keyCode === 13){
            $("#btn_ingresar").click();
        }
    },

    loginUsuario : function(form,btn){
        var btnText = $(btn).attr('disabled',true).html();
        $(btn).html('<i class="fa fa-spin fa-spinner"></i>');

        //Captcha//
		// if(grecaptcha.getResponse() == ""){
		// 	Modal.danger("Debe seleccionar la opción 'No soy un robot' ",function(){
		// 		$(btn).html(btnText).attr('disabled',false);
		// 	});
		// 	return false;
		// }

        var error = '';
        if($(form.email).val() === ""){
            error += 'Debe ingresar su Email.<br/>';
        }
        if($(form.password).val() === ""){
            error += 'Debe ingresar su CONTRASEÑA.<br/>';
        }

        if ($('#email').parent().hasClass('has-error')){
            error += 'Email Incorrecto<br/>';
        }

        if(error !== ""){
            Modal.danger(error,function(){
                $(btn).html(btnText).attr('disabled',false);
            });
        }else{ 
            var parametros = $(form).serialize();
			console.log(Base.getBaseUri() + 'Farmacia/Usuario/Login/procesar');
            $.post(Base.getBaseUri() + 'Farmacia/Usuario/Login/procesar',{rut:form.rut.value,password:form.password.value,captcha:grecaptcha.getResponse()},function(response){
                if(response.error === false){
                    window.location.href = Base.getBaseUri() + response.redirect;
                }else{
                    Modal.danger(response.texto_error,function(){
						             grecaptcha.reset();
                        $(btn).html(btnText).attr('disabled',false);
                    });
                }
            },'json').fail(function(){
                $(btn).html(btnText).attr('disabled',false);
            }); 
        }
    },

    /**
     * Funcion para solicitar nueva contraseña
     * @param form
     * @param btn
     */
    solicitarPassword : function(form,btn){
        var btnText = $(btn).attr('disabled',true).html();
        $(btn).html('Solicitando... <i class="fa fa-spin fa-spinner"></i>');

        var error = '';
        if(!Base.validarEmail($(form.email).val())){
            error += 'Debe ingresar su correo electrónico válido';
        }

        if(error){
            Modal.danger(error, function(){
                $(btn).html(btnText).attr('disabled',false);
            });
        }else{
            var parametros = $(form).serialize();
            $.post(Base.getBaseUri() + 'Usuario/LoginUsuario/enviarPassword',parametros,function(response){
                if(response.estado){
                    Modal.success(response.mensaje,function(){
                        Modal.closeAll();
                    });
                }else{
                    Modal.danger(response.mensaje, function(){
                        $(btn).html(btnText).attr('disabled',false);
                    });
                }
            },'json').fail(function(){
                Modal.danger('Error',function(){
                    $(btn).html(btnText).attr('disabled',false);
                });
            });
        }
    },


    solicitarRegistro : function(form,btn){
        var btnText = $(btn).attr('disabled',true).html();
        $(btn).html('Solicitando... <i class="fa fa-spin fa-spinner"></i>');
    }

};
