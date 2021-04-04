var cerrarNotificacion ={
    guardarBD : function(btn){
        btn.disabled = true;
        var btnTexto = $(btn).html();
        $(btn).html('Guardando...');
        
        var token_expediente    = $("#token_expediente").val();
        var txt_motivo_cerrado  = $("#txt_motivo_cerrado").val();
        
        if(txt_motivo_cerrado == ""){
            xModal.danger("Debe Ingresar un Motivo!",function(){$(btn).html(btnTexto).attr('disabled', false);});
        }else{
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: {token_expediente:token_expediente,txt_motivo_cerrado:txt_motivo_cerrado},
                type: "post",
                url: BASE_URI + "index.php/Microchip/cerrarNotificacionBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.danger('Error: No se pudo Ingresar un nuevo Registro',function(){$(btn).html(btnTexto).attr('disabled', false);});
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success('Éxito: Se Cerró Notificación Correctamente!',function () {
                            if($("#btn_buscar").is(":visible")){
                                $("#btn_buscar").trigger("click"); //Recarga Grilla Registros
                            }else if($("#buscar").is(":visible")){
                                $("#buscar").trigger("click"); //Recarga Grilla Buscar
                            }else{
                                location.reload();
                            }
                            xModal.closeAll();
                        });
                    }
                }
            });
        }
	}
}