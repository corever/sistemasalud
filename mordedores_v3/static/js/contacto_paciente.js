var ContactoPaciente = {
	mostrar_tipo: function (id_tipo) {
        $(".tipo_contacto").hide();
        $("#tipo_contacto_"+id_tipo).show();
    },
    guardar_contacto: function(btn){
        var e               = jQuery.Event( "click" );
        var button_process  = buttonStartProcess($(btn), e);
        var params          = $("#form_contacto").serializeArray();
        var tipo_contacto   = $("#tipo_contacto").val();
        
        if(tipo_contacto == 0){
            xModal.danger("Debe ingresar un tipo de contacto!",function(){buttonEndProcess(button_process);});
        }else{
            
            if ($('#chkNoInforma').is(':checked')) {
                params.push({
                    "name": 'chkNoInforma',
                    "value": 1
                });
            } else {
                params.push({
                    "name": 'chkNoInforma',
                    "value": 0
                });
            }
            
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: params,
                type: "post",
                url: BASE_URI + "index.php/Paciente/guardaContactoPaciente",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.danger('Error: No se pudo Ingresar un nuevo Registro',function(){buttonEndProcess(button_process);});
                },
                success: function (data) {
                    if (data.correcto) {
                        //xModal.success('Éxito: Se Ingresó nuevo Contacto!');
                        var imagenMapa      = new EventoReporteMapaImagen('mapContacto');
                        imagenMapa.crearImagen(function () {
                            xModal.closeAll();
                            ContactoPaciente.grillaContactoPacientes(data.gl_token);
                            buttonEndProcess(button_process);
                        });
                    }else{
                        xModal.danger(data.mensaje,function(){buttonEndProcess(button_process);});
                    }
                }
            });
        }
    },
    grillaContactoPacientes : function(gl_token=""){
        $.ajax({
            data : {gl_token:gl_token},
            url : BASE_URI + "index.php/Paciente/grillaContactoPaciente",
            dataType : 'html',
            type : 'post',
            success : function(response){
                $("#grilla-contacto-paciente").html(response);
            }
        });
    },
    eliminarContactoGrilla : function(id_contacto,gl_token=""){
        $.ajax({
            data : {id_contacto:id_contacto,gl_token:gl_token},
            url : BASE_URI + "index.php/Paciente/eliminaContactoPacienteGrilla",
            dataType : 'json',
            type : 'post',
            success : function(data){
                if (data.correcto) {
                    ContactoPaciente.grillaContactoPacientes(data.gl_token);
                }
            }
        });
    },
    noInforma : function(chk){
        if($(chk).is(':checked')){
            $('#region_contacto').val(0).attr("disabled",true);
            $('#comuna_contacto').val(0).attr("disabled",true);
            $('#gl_direccion').val("").attr("disabled",true);
            $('#form_contacto #gl_datos_referencia').val("").attr("disabled",true);
            $('#gl_latitud_contacto').val("").attr("disabled",true);
            $('#gl_longitud_contacto').val("").attr("disabled",true);
        }else{
            $('#region_contacto').attr("disabled",false);
            $('#comuna_contacto').attr("disabled",false);
            $('#gl_direccion').attr("disabled",false);
            $('#form_contacto #gl_datos_referencia').attr("disabled",false);
            $('#gl_latitud_contacto').attr("disabled",false);
            $('#gl_longitud_contacto').attr("disabled",false);
        }
    },
}

