var RegistroDT = {

    pressEnter: function(e) {
        var yo = this;
        if (e.keyCode === 13) {
            $("#btn_ingresar").click();
        }
    },

    ingresarSolicitud: function(form, btn) {
        var btnText = $(btn).attr('disabled', true).html();
        var e               = jQuery.Event("click");
        var button_process  = buttonStartProcess($(btn),e);

        var msgError = '';

        if ($.trim($("#email").val()) == "") {
            msgError += "- " + "Debe ingresar su email. <br>";
        }


        if ($.trim($("#rut").val()) == "") {
            msgError += "- " + "Debe ingresar su RUT. <br>";
        }

        if ($.trim($("#select_solicitud_region_dt").val()) == "0") {
            msgError += "- " + " Debe seleccionar una Región. <br>";
        }


        if ($('#email').parent().hasClass('has-error')) {
            msgError += 'Email Incorrecto<br/>';
        }

        if (msgError !== "") {
            Modal.danger(msgError, function() {
                $(btn).html(btnText).attr('disabled', false);
            });
        } else {            
            var parametros = $(form).serialize();
            
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: { email : $("#email").val() , rut: $("#rut").val(), id_region: $("#select_solicitud_region_dt").val()},
                type: "post",
                url: Base.getBaseUri() + "Farmacia/Farmacias/SolicitudRegistroDT/enviarMailValidacion",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info("Error al Actualizar", function () {
                        xModal.closeAll();
                        buttonEndProcess(button_process);
                    });
                },
                beforeSend: function() {                    
                    $(btn).html('<i id="cargando_boton" class="fa fa-spin fa-spinner"></i>');
                },
                success: function (data) {    
                    $(btn).html('Ingresar');
                    if (data.correcto=="OK") {
                        xModal.success("Se ha enviado la solicitud correctamente.\nEspere el correo de Registro de Director Técnico para continuar con el proceso.",function () {
                            xModal.closeAll();
                            $("#ver_correo").show();
                            buttonEndProcess(button_process);
                        });
                    } else {
                        if(data.correcto!=null){
                            // se mostrara el mensaje personalizado de error
                            xModal.info(data.correcto, function () {
                                xModal.closeAll();
                                buttonEndProcess(button_process);
                            });

                        }else{
                            xModal.info("Los datos ingresados no son válidos. Favor reintente registrarse nuevamente.", function () {
                                xModal.closeAll();
                                buttonEndProcess(button_process);
                            });
                        }
                    }
                }
            });

        }
    },
    motivoAsume: function(id_select){        
        if($("#"+id_select).val()!="Otro"){            
            $('#contenedor_input_otro_motivo_asume').hide();
        }else{            
            $('#contenedor_input_otro_motivo_asume').show();
        }
    },
    motivoCese: function(id_select){        
        if($("#"+id_select).val()!="Otro"){            
            $('#contenedor_input_otro_motivo_cese').hide();
        }else{            
            $('#contenedor_input_otro_motivo_cese').show();
        }
    },

    guardarInscripcion: function(btn){

        var btnText = $(btn).attr('disabled', true).html();
        var e               = jQuery.Event("click");        
        var bo_motivo = null;
        var msgError = '';
        var json_motivo_solicitud = "";

        if ($.trim($("#gl_rut").val()) == "") {
            msgError += "- " + "DATOS PERSONALES : Debe ingresar un RUT. <br>";
        }

        if ($.trim($("#gl_nombre").val()) == "") {
            msgError += "- " + "DATOS PERSONALES : Debe ingresar un nombre. <br>";
        }

        if ($.trim($("#gl_apellido_paterno").val()) == "") {
            msgError += "- " + "DATOS PERSONALES: Debe ingresar un apeliido paterno. <br>";
        }

        if ($.trim($("#gl_apellido_materno").val()) == "") {
            msgError += "- " + "DATOS PERSONALES : Debe ingresar un apellido materno. <br>";
        }

        if ($.trim($("#fc_nacimiento").val()) == "") {
            msgError += "- " + "DATOS PERSONALES : Debe ingresar una fecha de nacimiento. <br>";
        }
        
        if ($.trim($("#gl_email").val()) == "") {
            msgError += "- " + "DATOS PERSONALES : Debe ingresar un email. <br>";
        } 

        if ($.trim($("#id_profesion_dt").val()) == "0") {
            msgError += "- " + "DATOS PERSONALES : Debe seleccionar una profesión. <br>";
        }

        if ($.trim($("#id_comuna_dt").val()) == "0") {
            msgError += "- " + "DATOS PERSONALES : Debe seleccionar una Comuna. <br>";
        }

        if ($.trim($("#direccion_dt").val()) == "") {
            msgError += "- " + "DATOS PERSONALES: Debe ingresar una dirección. <br>";
        } 

        if ($.trim($("#telefono_dt").val()) == "") {
            msgError += "- " + "DATOS PERSONALES: Debe ingresar un teléfono. <br>";
        }         
        if ($("input[name='chk_certificado_titulo']:checked").val() === undefined) {
            msgError += "- DATOS PERSONALES : Certificado de título es Obligatorio. <br>";
        }else{
            if ($("input[name='chk_certificado_titulo']:checked").val() === "A") { //es un archivo        
                if ($("#grillaTituloDT table").find('tr').length<2) {
                    msgError += "- " + "DATOS PERSONALES : Debe cargar un archivo de certificado de Título. <br>";
                } 
            }
            if ($("input[name='chk_certificado_titulo']:checked").val() === "N") { //es un numero         
                if ($.trim($("#nr_titulo").val()) == "") {
                    msgError += "- " + "DATOS PERSONALES : Debe ingresar Número identificador de certificado de Título. <br>";
                } 
            }
        }        
        if ($.trim($("#id_region_farmacia").val()) == "0") {
            msgError += "- " + "DATOS FARMACIA : Debe seleccionar una Región. <br>";
        }

        if ($.trim($("#id_comuna_farmacia").val()) == "0") {
            msgError += "- " + "DATOS FARMACIA : Debe seleccionar una Comuna. <br>";
        }

        if ($.trim($("#gl_direccion_farmacia").val()) == "") {
            msgError += "- " + "DATOS FARMACIA : Debe ingresar direccion. <br>";
        } 

        if ($.trim($("#gl_nombre_farmacia").val()) == "") {
            msgError += "- " + "DATOS FARMACIA : Debe ingresar nombre. <br>";
        } 

        if ($.trim($("#gl_rut_farmacia").val()) == "") {
            msgError += "- " + "DATOS FARMACIA : Debe ingresar un RUT. <br>";
        } 

        if ($.trim($("#nr_local_farmacia").val()) == "") {
            msgError += "- " + "DATOS FARMACIA : Debe ingresar número de local. <br>";
        } 

        if ($.trim($("#gl_email_farmacia").val()) == "") {
            msgError += "- " + "DATOS FARMACIA : Debe ingresar email. <br>";
        }         
        if ($.trim($("#gl_telefono_farmacia").val()) == "") {
            msgError += "- " + "DATOS FARMACIA : Debe ingresar teléfono. <br>";
        }         
        if ($("input[name='chk_dt_motivo']:checked").val() === undefined) {
            msgError += "- Motivo de solicitud es obligatorio. <br>";
        }else{
            if($("input[name='chk_dt_motivo']:checked").val()=="CESE"){                
                bo_motivo = 0; // cese
                json_motivo_solicitud = JSON.stringify($("#form_cese_dt").serializeArray());

                //validacion de formulario "cese funciones"

                if ($.trim($("#id_cese_funciones").val()) == "0") {
                    msgError += "- " + "MOTIVO SOLICITUD CESE: Debe seleccionar una función. <br>";
                } 

                if ($.trim($("#id_fecha_cese").val()) == "0") {
                    msgError += "- " + "MOTIVO SOLICITUD CESE: Debe seleccionar un periodo de cese. <br>";
                } 

                if ($.trim($("#fc_cese_desde").val()) == "") {
                    msgError += "- " + "MOTIVO SOLICITUD CESE: Debe ingresar una fecha de INICIO de cese. <br>";
                } 

                //no se obliga a hacer fecha desde porque puede ser que cese de manera permanente

                if ($.trim($("#id_motivo_cese").val()) == "0") {
                    msgError += "- " + "MOTIVO SOLICITUD CESE: Debe seleccionar un motivo. <br>";
                } 

                if ($("input[name='cese_saldos_productos']:checked").val() === undefined) {
                    msgError += "- MOTIVO SOLICITUD CESE : Confirme a 'Dejo los saldos y registros de productos Estupefacientes y Psicotrópicos'. <br>";
                }

            }else{                
                bo_motivo = 1;//asume
                json_motivo_solicitud = JSON.stringify($("#form_asume_dt").serializeArray()); 

                //validacion de formulario "asume funciones"
                if ($("#grillaDeclaracionDT table").find('tr').length<2) {
                    msgError += "- " + "MOTIVO SOLICITUD ASUME: Debe adjuntar Declaración. <br>";
                }   
                
                if ($.trim($("#id_funcion_asume").val()) == "0") {
                    msgError += "- " + "MOTIVO SOLICITUD ASUME: Debe seleccionar una función. <br>";
                } 

                if ($.trim($("#id_motivo_asume").val()) == "0") {
                    msgError += "- " + "MOTIVO SOLICITUD ASUME: Debe seleccionar motivo de solicitud. <br>";
                }
                
                if ($.trim($("#id_fecha_asume").val()) == "0") {
                    msgError += "- " + "MOTIVO SOLICITUD ASUME: Debe seleccionar Periodo de función. <br>";
                }

                if ($.trim($("#fc_asume_desde").val()) == "") {
                    msgError += "- " + "MOTIVO SOLICITUD ASUME: Debe seleccionar FECHA DE INICIO de función. <br>";
                }

                if ($.trim($("#fc_asume_hasta").val()) == "") {
                    msgError += "- " + "MOTIVO SOLICITUD ASUME: Debe seleccionar FECHA DE TERMINO de función. <br>";
                }
                var dias = ["lunes","martes","miercoles","jueves","viernes","sabados","domingos"];
                for(var i=0;i<8;i++){ 
                    if($("#gl_hora_desde_"+dias[i]).prop("disabled")==false){
                        if($("#gl_hora_desde_"+dias[i]).val()==""){   
                            msgError += "- " + "MOTIVO SOLICITUD ASUME: Debe indicar un horario de INICIO para día: "+dias[i]+". <br>";
                        } 
                    }
                }

                for(i=0;i<8;i++){                    
                    if($("#gl_hora_hasta_"+dias[i]).prop("disabled")==false){
                            if($("#gl_hora_hasta_"+dias[i]).val()==""){   
                            msgError += "- " + "MOTIVO SOLICITUD ASUME: Debe indicar un horario de FIN para día: "+dias[i]+". <br>";
                            } 
                    }
                }
 

            }
        }

        if (msgError !== "") {
            xModal.danger(msgError, function () {
                xModal.closeAll();                
                buttonEndProcess(btnText);
                $(btn).attr('disabled', false).html();
            });
        } else {   
            var json_cese  = "";
            var json_datos_personales = JSON.stringify($("#form_datos_personales").serializeArray());
            var json_datos_farmacia = JSON.stringify($("#form_datos_farmacia").serializeArray());                 
            //capturo los valores del formulario de cese
            if($("input[name='chk_dt_motivo']:checked").val()=="CESE"){
                var json_cese = '['+
                    '{"name": "id_cese_funciones" , "value":"'+$("#id_cese_funciones").val()+'"},'+
                    '{"name":"id_fecha_cese" , "value" : "'+$("#id_fecha_cese").val()+'"},'+
                    '{"name":"fc_cese_desde" , "value" : "'+$("#fc_cese_desde").val()+'"},'+
                    '{"name":"fc_cese_hasta" , "value" : "'+$("#fc_cese_hasta").val()+'"},'+
                    '{"name":"id_motivo_cese" , "value": "'+$("#id_motivo_cese").val()+'"},'+
                    '{"name":"cese_saldos_productos" , "value":"'+$("input[name='chk_dt_motivo']:checked").val()+'"}]';                
            }

            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: {
                    datos_personales : json_datos_personales,
                    datos_farmacia   : json_datos_farmacia, 
                    json_motivo      : json_motivo_solicitud, 
                    bo_motivo        : bo_motivo,
                    observacion      : $("#gl_observaciones_registro").val(),
                    adjunto_titulo   : $("#adjunto_certificado_titulo_dt").val(),
                    json_cese        : json_cese
                },
                type: "post",
                url: Base.getBaseUri() + "Farmacia/Farmacias/RegistroDT/registraDTBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.danger("Error al registrar director técnico");
                    $(btn).attr('disabled', false).html();
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success("Su registro se ha efectuado exitósamente",function () {
                            xModal.closeAll();
                            location.href = Base.getBaseUri()+"Farmacia/Farmacias/RegistroDT/finalizaRegistro";
                        });
                    } else {
                        $(btn).attr('disabled', false).html();
                        xModal.danger("Error al registrar los datos, verifique la informacion ingresada, y vuelva a intentarlo.");
                    }
                }
            });

        }
    },
    cargarComunasPorRegion: function (region, combo, comuna) {		
		if (region != 0) {			
			$.post(Base.getBaseUri() + 'Farmacia/Farmacias/RegistroDT/cargarComunasPorRegion', { region: region }, function (response) {
				if (response.length > 0) {
					var total = response.length;
					var options = '<option value="0">Seleccione una Comuna</option>';
					for (var i = 0; i < total; i++) {
						if (comuna == response[i].id_comuna) {
							options += '<option value="' + response[i].id_comuna + '" id="' + response[i].gl_latitud_comuna + '" name="' + response[i].gl_longitud_comuna + '" selected >' + response[i].nombre_comuna + '</option>';
						} else {
							options += '<option value="' + response[i].id_comuna + '" id="' + response[i].gl_latitud_comuna + '" name="' + response[i].gl_longitud_comuna + '" >' + response[i].nombre_comuna + '</option>';
						}

					}
					$('#' + combo).html(options);
				}
			}, 'json');
		} else {
			$('#' + combo).html('<option value="0">Seleccione una Comuna</option>');
		}
    },
     Valida_Rut: function( rut ){
        var intlargo = rut.value;
        var tmpstr = "";
        if (intlargo.length> 0)
        {
            var re = /^[1-9]{1}[0-9]{0,7}\-([0-9]|[kK]){1}$/;
            crut = rut.value;
            if(!this.validaRut(crut)){
                if(typeof Modal != "undefined"){
                    Modal.danger('El RUT ingresado no es válido');
                    $("#gl_rut_farmacia").val('');
                }
                if(typeof xModal != "undefined"){
                    xModal.danger('El RUT ingresado no es válido');
                    $("#gl_rut_farmacia").val('');
                }
                $(rut).parent().addClass('has-error');
                return false;
            }

            if(!re.test(crut)){
                if(typeof Modal != "undefined"){
                    Modal.danger('El RUT ingresado no es válido');
                    $("#gl_rut_farmacia").val('');
                }
                if(typeof xModal != "undefined"){
                    xModal.danger('El RUT ingresado no es válido');
                    $("#gl_rut_farmacia").val('');
                }
                $(rut).parent().addClass('has-error');
                return false;
            }
    
            for ( i=0; i <crut.length ; i++ )
            {
            if ( crut.charAt(i) != ' ' && crut.charAt(i) != '.' && crut.charAt(i) != '-' )
                {
                tmpstr = tmpstr + crut.charAt(i);
                }
            }
            largo = tmpstr.length;
    
            if ( largo <8 )
            {   
                if(typeof Modal != "undefined"){
                    Modal.danger('El RUT ingresado no es válido (muy corto)');
                    $("#gl_rut_farmacia").val('');
                }
                if(typeof xModal != "undefined"){
                    xModal.danger('El RUT ingresado no es válido (muy corto)');
                    $("#gl_rut_farmacia").val('');
                }
                $(rut).parent().addClass('has-error');
                return false;
            }else if(largo > 9){
                if(typeof Modal != "undefined"){
                    Modal.danger('El RUT ingresado no es válido (muy largo)');
                    $("#gl_rut_farmacia").val('');
                }
                if(typeof xModal != "undefined"){
                    xModal.danger('El RUT ingresado no es válido (muy largo)');
                    $("#gl_rut_farmacia").val('');
                }
                $(rut).parent().addClass('has-error');
                return false;
            }
            rut1 = tmpstr;
            crut= tmpstr;
            largo = crut.length;
    
            if ( largo> 2 )
                rut1 = crut.substring(0, largo - 1);
            else
                rut1 = crut.charAt(0);
    
            dv = crut.charAt(largo-1);
    
            if ( rut1 == null || dv == null )
            return 0;
    
            var dvr = '0';
            suma = 0;
            mul  = 2;
    
            for (i= rut1.length-1 ; i>= 0; i--)
            {
                suma = suma + rut1.charAt(i) * mul;
                if (mul == 7)
                    mul = 2;
                else
                    mul++;
            }
    
            res = suma % 11;
            if (res==1)
                dvr = 'k';
            else if (res==0)
                dvr = '0';
            else
            {
                dvi = 11-res;
                dvr = dvi + "";
            }
    
            if ( dvr != dv.toLowerCase() )
            {
                if(typeof Modal != "undefined"){
                    if(typeof Modal != "undefined"){
                        Modal.danger('El RUT ingresado no es válido');
                        $("#gl_rut_farmacia").val('');
                    }
                    if(typeof xModal != "undefined"){
                        xModal.danger('El RUT ingresado no es válido');
                        $("#gl_rut_farmacia").val('');
                    }
                }
            
                $(rut).parent().addClass('has-error');
                return false;
            }
    
            if ($(rut).parent().hasClass('has-error')) {
                $(rut).parent().removeClass('has-error');
            }
            $(rut).parent().addClass('has-success');
            return true;
        }
    
    },
    validaRut : function (rutCompleto) {
        if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
            return false;
        var tmp 	= rutCompleto.split('-');
        var digv	= tmp[1]; 
        var rut 	= tmp[0];
        if ( digv == 'K' ) digv = 'k' ;
        return (this.dv(rut) == digv );
    },
    dv : function(T){
        var M=0,S=1;
        for(;T;T=Math.floor(T/10))
            S=(S+T%10*(9-M++%6))%11;
        return S?S-1:'k';
    }

};


$("#chk_certificado_s").click( function(){
    if( $(this).is(':checked') ) {
        $("#div_n_registro").hide();
        $("#div_archivo_titulo").show();
    }
 });

 $("#chk_certificado_n").click( function(){
    if( $(this).is(':checked') ){
        $("#div_archivo_titulo").hide();
        $("#div_n_registro").show();
    }
 });


 $("#chk_direccion_tecnica_asume").click( function(){
    if( $(this).is(':checked') ){
        $("#div_cese_dt").hide();
        $("#div_asume_dt").show();
    }
 });


 
$("#chk_direccion_tecnica_cese").click( function(){
    if( $(this).is(':checked') ) {
        $("#div_asume_dt").hide();
        $("#div_cese_dt").show();
    }
 });

 $(".chk_dia_ejercicio").click( function(){
    if( $(this).is(':checked') ) {
        $("#gl_hora_desde_"+$(this).prop('id')+"").prop('disabled',false);
        $("#gl_hora_hasta_"+$(this).prop('id')+"").prop('disabled',false);
    }else{
        $("#gl_hora_desde_"+$(this).prop('id')+"").val('');
        $("#gl_hora_desde_"+$(this).prop('id')+"").prop('disabled',true);
        $("#gl_hora_hasta_"+$(this).prop('id')+"").val('');
        $("#gl_hora_hasta_"+$(this).prop('id')+"").prop('disabled',true);
    }
 });



$( document ).ready(function() {
    
    if ($(window).width() < 960) {
        var recaptcha = $(".g-recaptcha");
        if(recaptcha.css('margin') == '1px') {
            var newScaleFactor = recaptcha.parent().innerWidth() / 304;
            recaptcha.css('transform', 'scale(' + newScaleFactor + ')');
            recaptcha.css('transform-origin', '0 0');
        }
        else {
            recaptcha.css('transform', 'scale(1)');
            recaptcha.css('transform-origin', '0 0');
        }        
     }  

     Utils.cargarPersonaWS($("#gl_rut").val(),'gl_nombre','gl_apellido_paterno','gl_apellido_materno');

});

$(window).resize(function() {
    var recaptcha = $(".g-recaptcha");
    if(recaptcha.css('margin') == '1px') {
        var newScaleFactor = recaptcha.parent().innerWidth() / 304;
        recaptcha.css('transform', 'scale(' + newScaleFactor + ')');
        recaptcha.css('transform-origin', '0 0');
    }
    else {
        recaptcha.css('transform', 'scale(1)');
        recaptcha.css('transform-origin', '0 0');
    }    
});

