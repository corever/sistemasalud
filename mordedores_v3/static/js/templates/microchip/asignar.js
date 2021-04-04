var Fiscalizador ={
    asignarFiscalizador : function(btn){
        btn.disabled = true;
        var btnTexto = $(btn).html();
        $(btn).html('Guardando...');
        
        var token_exp_mor       = $("#token_asignar").val();
        var token_fiscalizador  = $("#fiscalizador").val();
        var bo_reasignar        = $("#bo_reasignar").val();
        var bandeja             = $("#gl_bandeja").val();
        
        if(token_fiscalizador == 0){
            xModal.danger("Debe seleccionar Fiscalizador!",function(){$(btn).html(btnTexto).attr('disabled', false);});
        }else{
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: {token_fiscalizador:token_fiscalizador,token_exp_mor:token_exp_mor,bo_reasignar:bo_reasignar},
                type: "post",
                url: BASE_URI + "index.php/Microchip/asignarFiscalizadorBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.danger('Error: No se pudo Ingresar un nuevo Registro',function(){$(btn).html(btnTexto).attr('disabled', false);});
                },
                success: function (data) {
                    if (data.correcto) {
                        //xModal.success('Éxito: Se Asignó Fiscalizador!');
                        setTimeout(function () {
                            Fiscalizador.recargaGrillaMordedor(bandeja);
                            if($("#btn_buscar").is(":visible")){
                                $("#btn_buscar").trigger("click"); //Recarga Grilla Registros
                            }else if($("#buscar").is(":visible")){
                                $("#buscar").trigger("click"); //Recarga Grilla Registros
                            }else{
                                location.reload();
                            }
                            //Fiscalizador.recargaGrillaRegistros();
                            xModal.close();
                            $(btn).html(btnTexto).attr('disabled', false);
                        }, 500);
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
    
    recargaGrillaRegistros : function(){
        $.ajax({
            data : {},
            url : BASE_URI + "index.php/Paciente/grillaRegistros",
            dataType : 'html',
            type : 'post',
            success : function(response){
                $("#contenedor_grilla_registros").html(response);
            }
        });
    },
}