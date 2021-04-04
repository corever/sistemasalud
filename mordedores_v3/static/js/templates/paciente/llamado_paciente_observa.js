var LlamadoPaciente ={
    guardarLlamado : function(btn){
        btn.disabled = true;
        var btnTexto = $(btn).html();
        $(btn).html('Guardando...');
        
        var params  = $("#formPacienteObserva").serializeArray();
        
        if (!$("#id_quien_llama_1").is(":checked") && !$("#id_quien_llama_2").is(":checked")) {
            xModal.danger('Debe seleccionar Quién llama',function(){$(btn).html(btnTexto).attr('disabled', false);});
        } else if ($("#id_quien_llama_2").is(":checked") && !$("#bo_paciente_contesta_1").is(":checked") && !$("#bo_paciente_contesta_0").is(":checked")){
            xModal.danger('Debe seleccionar si paciente contesta',function(){$(btn).html(btnTexto).attr('disabled', false);});
        } else if (($("#id_quien_llama_1").is(":checked") || $("#bo_paciente_contesta_1").is(":checked"))
                    && !$("#bo_sintomas_rabia_1").is(":checked") && !$("#bo_sintomas_rabia_0").is(":checked")){
            xModal.danger('Debe seleccionar si presenta síntomas de rabia',function(){$(btn).html(btnTexto).attr('disabled', false);});
        }else{
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: params,
                type: "post",
                url: BASE_URI + "index.php/Paciente/llamadoPacienteObservaBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.danger('Error: No se pudo Ingresar un nuevo Registro',function(){$(btn).html(btnTexto).attr('disabled', false);});
                },
                success: function (data) {
                    if (data.correcto) {
                        setTimeout(function () {
                            xModal.close();
                            $(btn).html(btnTexto).attr('disabled', false);
                            if($("#btn_buscar").is(":visible")){
                                $("#btn_buscar").trigger("click"); //Recarga Grilla Registros
                            }else if($("#buscar").is(":visible")){
                                $("#buscar").trigger("click"); //Recarga Grilla Buscar
                            }else{
                                location.reload();
                            }
                            //ResultadoVisita.recargaGrillaMordedor(bandeja);
                        }, 500);
                    }else{
                         xModal.danger(data.mensaje,function(){$(btn).html(btnTexto).attr('disabled', false);});
                    }
                }
            });
        }
    },
    cambioLlamador : function(){
        if($("#id_quien_llama_1").is(":checked")){
            $("#div_paciente_contesta").hide();
            $("#bo_paciente_contesta_1").prop("checked",false);
            $("#bo_paciente_contesta_0").prop("checked",false);
            $("#div_sintomas_rabia").show();
        }else if($("#id_quien_llama_2").is(":checked")){
            $("#div_paciente_contesta").show();
            $("#div_sintomas_rabia").hide();
            $("#bo_sintomas_rabia_1").prop("checked",false);
            $("#bo_sintomas_rabia_0").prop("checked",false);
        }
    },
    cambioPacienteContesta : function(){
        if($("#bo_paciente_contesta_1").is(":checked")){
            $("#div_sintomas_rabia").show();
        }else if($("#bo_paciente_contesta_0").is(":checked")){
            $("#div_sintomas_rabia").hide();
        }
    },
}