var ResultadoVisita ={
    guardarResultadoVisita : function(btn){
        btn.disabled = true;
        var btnTexto = $(btn).html();
        $(btn).html('Guardando...');
        
        var params                      = $("#formResultadoIsp").serializeArray();
        var bandeja                     = $("#gl_bandeja").val();
        var id_tipo_visita_resultado    = $("#id_tipo_visita_resultado").val();
        var gl_observaciones            = $("#gl_observaciones_resultado_visita").val();
        
        if (id_tipo_visita_resultado == 0) {
            xModal.danger('Debe seleccionar un Tipo de Resultado',function(){$(btn).html(btnTexto).attr('disabled', false);});
        } else if (gl_observaciones === ""){
            xModal.danger('Debe ingresar Observaciones',function(){$(btn).html(btnTexto).attr('disabled', false);});
        }else{
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: params,
                type: "post",
                url: BASE_URI + "index.php/Administrativo/editarResultadoVisitaBD",
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
                                xModal.closeAll();
                            }else if($("#buscar").is(":visible")){
                                $("#buscar").trigger("click"); //Recarga Grilla Buscar
                                xModal.closeAll();
                            }else{
                                location.reload();
                            }
                        }, 500);
                    }else{
                         xModal.danger(data.mensaje,function(){$(btn).html(btnTexto).attr('disabled', false);});
                    }
                }
            });
        }
    },
    recargaGrillaMordedor : function(bandeja){
        var token_expediente = $("#gl_token_expediente").val();
        $.ajax({
            data : {gl_token:token_expediente,bandeja:bandeja},
            url : BASE_URI + "index.php/Agenda/cabeceraGrillaMordedor",
            dataType : 'html',
            type : 'post',
            success : function(response){
                $("#cabecera_grilla_mordedor").html(response);
            }
        });
    },
}