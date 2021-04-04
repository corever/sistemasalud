
var VentaTalonario = {


    init : function(){
        
    },

    verificarPyme : function(){
        if($("input[name='chk_es_pyme']:checked").val() == 1){
            $("#div_es_pyme").show(200);
        }else{
            $("#div_es_pyme").hide(200);
        }
    },

    guardarVenta: function (form, btn) {
        var e               = jQuery.Event("click");
        var button_process  = buttonStartProcess($(btn), e);
        var msgError        = "";

        if ($("#id_profesional_medico").val() == "0") {
            msgError += "- "+Base.traduceTexto("Profesional Médico es Obligatorio")+". <br>";
        }
        if ($("#id_talonarios_disponibles").val() == "") {
            msgError += "- "+Base.traduceTexto("Talonarios es Obligatorio")+". <br>";
        }
        if ($("input[name='chk_es_pyme']:checked").val() === undefined) {
            msgError += "- "+Base.traduceTexto("Seleccione ¿Es PYME?")+". <br>";
        }
        if ($("input[name='chk_es_pyme']:checked").val() === "1" && $("#tabla-adjuntos tbody>tr").length == 0) {
            msgError += "- "+Base.traduceTexto("Si selecciona es PYME debe adjuntar documento")+". <br>";
        }

        if (msgError != "") {
            xModal.danger(msgError, function () {
                buttonEndProcess(button_process);
            });
        } else {
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: form,
                type: "post",
                url: Base.getBaseUri() + "Farmacia/Talonarios/Talonario/guardarVenta",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error en el ingreso"), function () {
                        buttonEndProcess(button_process);
                    });
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(Base.traduceTexto("Ingresado con Éxito"),function () {
                            if(data.url){
                                location.href = Base.getBaseUri() + data.url;
                            }else{
                                location.href = Base.getBaseUri() + "Farmacia/Home/Dashboard";
                            }
                        });
                    } else {
                        xModal.info(data.msgError, function () {
                            buttonEndProcess(button_process);
                        });
                    }
                }
            });
        }
        btn.disabled = false;
    },

    realizarVentaBD: function (form, btn) {
        var e               = jQuery.Event("click");
        var button_process  = buttonStartProcess($(btn), e);
        var msgError        = "";

        if (msgError != "") {
            xModal.danger(msgError, function () {
                buttonEndProcess(button_process);
            });
        } else {
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: form,
                type: "post",
                url: Base.getBaseUri() + "Farmacia/Talonarios/Talonario/realizaVentaTalonarioBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error en el ingreso"), function () {
                        buttonEndProcess(button_process);
                    });
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(Base.traduceTexto("Ingresado con Éxito"),function () {
                            location.href = Base.getBaseUri() + "Farmacia/Talonarios/Talonario/ventaTalonarioRealizada";
                        });
                    } else {
                        xModal.info(data.msgError, function () {
                            buttonEndProcess(button_process);
                        });
                    }
                }
            });
        }
        btn.disabled = false;
    }
    
};
