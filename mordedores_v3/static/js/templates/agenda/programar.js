var Fiscalizador ={
    programarVisita : function(){
        var token_exp_mor       = $("#token_expediente_mordedor").val();
        var fecha               = $("#fc_programado").val();
        var hora                = $("#hora_programado").val();
        var reprogramar         = $("#bo_reprogramar").val();
        var bandeja             = $("#gl_bandeja").val();
        
        if(fecha == "" || hora == ""){
            xModal.danger("Por favor, Ingrese todos los campos!");
        }else{
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: {token_exp_mor:token_exp_mor,fecha:fecha,hora:hora,reprogramar:reprogramar},
                type: "post",
                url: BASE_URI + "index.php/Agenda/programarVisitaBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.danger('Error: No se pudo Ingresar un nuevo Registro');
                },
                success: function (data) {
                    if (data.correcto) {
                        //xModal.success('Éxito: '+data.mensaje);
                        setTimeout(function () {
                            Fiscalizador.recargaGrillaMordedor(bandeja);
                            xModal.close();
                        }, 500);
                    }
                }
            });
        }
	},
    devolverSupervisor: function(token_exp_mor){
        var bandeja             = "devolver";
        //xModal.confirm('¿Está Seguro de que desea devolver a supervisor?',function(){
            bootbox.dialog({
                message: "  Ingrese Motivo:\n\
                            <br><textarea style='margin: 0px; width: 100%; height: 80px; max-width: 100%; min-width:100%; min-height:80px;' id='gl_motivo_devuelto'></textarea>",
                title: "Confirmar acción - Ingrese Motivo",
                buttons: {
                    success: {
                        label: "<i class=\"fa fa-save\"></i> Aceptar",
                        className: "btn-success",
                        callback: function() {
                            if($("#gl_motivo_devuelto").val()==""){
                                bootbox.dialog({
                                    message: "- Por favor, Ingresar un Motivo.",
                                    title: "Error",
                                    buttons: {
                                        cerrar: {
                                            label: "<i class=\"fa fa-close\"></i>  Cerrar",
                                            className: "btn-default",
                                            callback: function() {}
                                        }
                                    }
                                });
                            }else{
                                //var token_exp_mor    = $("#token_expediente_mordedor").val();
                                $.ajax({
                                    url : BASE_URI + "index.php/Agenda/devolverProgramacionBD",
                                    type : 'post',
                                    dataType : 'json',
                                    data : {token_exp_mor:token_exp_mor,gl_motivo:$("#gl_motivo_devuelto").val()},
                                    success : function(response){
                                        if(response.correcto == true){
                                            xModal.success('Caso devuelto a supervisor.');
                                            setTimeout(function() { 
                                                Fiscalizador.recargaGrillaMordedor(bandeja);
                                                $("#btn_buscar, #buscar").trigger("click");
                                            }, 500);
                                        }
                                    },
                                    error : function(){
                                        xModal.danger('Error en sistema. Intente nuevamente o comuníquese con Soporte --> ' + response);
                                    }
                                });
                            }
                        }
                    },
                    cerrar: {
                        label: "<i class=\"fa fa-close\"></i> Cerrar ventana",
                        className: "btn-default",
                        callback: function() {}
                    }        
                }
            });
        //});
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

$("#fc_programado").datetimepicker({
	locale: "es",
	format: "DD/MM/YYYY",
	minDate: $.now(),
	useCurrent: false,
    inline: false
});

$("#hora_programado").timepicker({});