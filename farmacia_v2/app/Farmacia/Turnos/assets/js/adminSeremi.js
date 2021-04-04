
var MantenedorSeremi = {
    limpiarFiltros: function () {
        $("#id_region").val("0");                
        $("#gl_nombre").val("");
        $("#gl_email").val("");        
        MantenedorSeremi.buscar();
    },
    mostarInputsDelegado: function (valor){
        // 1 corresponde a firma delegada
        if(valor==1){
            $("#form_firma_delegada").show();
        }else{
            $("#form_firma_delegada").hide();
        }
        
    },
    borrarCacheFirma: function (){
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: null,
            type: "post",
            url: Base.getBaseUri() + "Farmacia/Turnos/AdminSeremi/limpiarCacheFirma",
            error: function (xhr, textStatus, errorThrown) {
                console.log("Error al borrar caché de firma");
            },
            success: function (data) {
                
            }
        });
    },
    buscar: function () {
        var parametros  = $("#formBuscar").serializeArray();
        var arr         = new Array();
        $.each(parametros, function (index, value) {
            arr[value.name] = value.value;
        });        
        $("#grilla-seremis").dataTable({
            "lengthMenu": [5, 10, 20, 25, 50, 100],
            "pageLength": 10,
            "destroy": true,
            "aaSorting": [],
            "deferRender": true,
            "language": {
                "url": Base.getBaseDir() + "pub/js/plugins/DataTables/lang/"+Base.traduceTexto("es.json")
            },
            dom: 'Bflrtip',
            buttons: [{
                extend: 'excelHtml5',
                className: 'btn btn-default btn-xs',
                text: '<i class=\"fa fa-download\"></i> '+Base.traduceTexto("Exportar a Excel"),
                filename: 'Grilla',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    },
                        columns: [0,1,2]
                }
            }],
            ajax: {
                "method": "POST",
                "url": "AdminSeremi/grillaSeremis",
                "data": arr,
            },
            columns: [
                {"data": "nombre", "class": ""},
                {"data": "telefono", "class": ""},
                {"data": "email", "class": ""},
                {"data": "opciones", "class": ""}
            ]
        });
console.log(arr);
        
    },
    editarSeremi: function (form, btn) {
        var e               = jQuery.Event("click");
        var button_process  = buttonStartProcess($(btn), e);
        var msgError        = "";
        
        if ($("#id_tipo_firmante").val() == "0") {
            msgError += "- "+Base.traduceTexto("Tipo Firmante es Obligatorio")+". <br>";
        }
        // valida en caso de firma delegada 
        if ($("#id_tipo_firmante").val() == "1") {
            if ($.trim($("#gl_ds_decreto_delegado").val()) == "") {
                msgError += "- "+Base.traduceTexto("N° D.S Delegado es Obligatorio")+". <br>";
            }
            if ($.trim($("#fc_ds_delegado").val()) == "") {
                msgError += "- "+Base.traduceTexto("Fecha D.S Delegada es Obligatorio")+". <br>";
            }
            
        }
        
        if ($.trim($("#gl_rut_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Rut es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_nombre_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Nombre es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_paterno_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Paterno es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_materno_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Materno es Obligatorio")+". <br>";
        }
        if ($("input[name='chk_genero_seremi']:checked").val() === undefined) {
            msgError += "- "+Base.traduceTexto("Género es Obligatorio")+". <br>";
        }
        if ($.trim($("#fc_nacimiento_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Fecha Nacimiento es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_email_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Email es Obligatorio")+". <br>";
        }
        if ($("#gl_email_seremi").parent().hasClass("has-error")) {
            msgError += "- "+Base.traduceTexto("Email es Inválido")+". <br>";
        }
        if ($("#id_region_seremi").val() == "0") {
            msgError += "- "+Base.traduceTexto("Región es Obligatorio")+". <br>";
        }
        if ($("#id_territorio_seremi").val() == "0") {
            msgError += "- "+Base.traduceTexto("Territorio es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_direccion_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Dirección es Obligatorio")+". <br>";
        }

        if ($.trim($("#id_codregion_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("C+odigo de área es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_telefono_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Teléfono es Obligatorio")+". <br>";
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
                url: Base.getBaseUri() + "Farmacia/Turnos/AdminSeremi/editarSeremiBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error al Actualizar"), function () {
                        buttonEndProcess(button_process);
                    });
                },
                success: function (data) {
                    if (data.correcto=="OK") {
                        xModal.success(Base.traduceTexto("Actualizado con Éxito"),function () {
                            MantenedorSeremi.buscar();
                            xModal.closeAll();
                            buttonEndProcess(button_process);
                        });
                    } else {
                        if(data.correcto!=null){
                            // se mostrara el mensaje personalizado de error
                            xModal.info(data.correcto, function () {
                                buttonEndProcess(button_process);
                            });
                        }else{
                            xModal.info(Base.traduceTexto("Error al Actualizar"), function () {
                                buttonEndProcess(button_process);
                            });
                        }
                    }
                }
            });
        }
        btn.disabled = false;
    },
    agregarSeremi: function (form, btn) {
        var e               = jQuery.Event("click");
        var button_process  = buttonStartProcess($(btn), e);
        var msgError        = "";

        if ($.trim($("#gl_rut_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Rut es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_nombre_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Nombre es Obligatorio")+". <br>";
        }
        
        
        if ($("#id_tipo_firmante").val() == "0") {
            msgError += "- "+Base.traduceTexto("Tipo Firmante es Obligatorio")+". <br>";
        }
        // valida en caso de firma delegada 
        if ($("#id_tipo_firmante").val() == "1") {
            if ($.trim($("#gl_ds_decreto_delegado").val()) == "") {
                msgError += "- "+Base.traduceTexto("N° D.S Delegado es Obligatorio")+". <br>";
            }
            if ($.trim($("#fc_ds_delegado").val()) == "") {
                msgError += "- "+Base.traduceTexto("Fecha D.S Delegada es Obligatorio")+". <br>";
            }
            
        }

        if ($.trim($("#id_trato_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Trato de Seremi es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_paterno_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Paterno es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_materno_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Materno es Obligatorio")+". <br>";
        }
        if ($("input[name='chk_genero_seremi']:checked").val() === undefined) {
            msgError += "- "+Base.traduceTexto("Género es Obligatorio")+". <br>";
        }
        if ($.trim($("#fc_nacimiento_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Fecha Nacimiento es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_email_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Email es Obligatorio")+". <br>";
        }
        if ($("#gl_email_seremi").parent().hasClass("has-error")) {
            msgError += "- "+Base.traduceTexto("Email es Inválido")+". <br>";
        }
        if ($("#id_region_seremi").val() == "0") {
            msgError += "- "+Base.traduceTexto("Región es Obligatorio")+". <br>";
        }
        if ($("#id_territorio_seremi").val() == "0") {
            msgError += "- "+Base.traduceTexto("Territorio es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_direccion_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Dirección es Obligatorio")+". <br>";
        }

        if ($.trim($("#id_codregion_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("C+odigo de área es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_telefono_seremi").val()) == "") {
            msgError += "- "+Base.traduceTexto("Teléfono es Obligatorio")+". <br>";
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
                url: Base.getBaseUri() + "Farmacia/Turnos/AdminSeremi/agregarSeremiBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error en el ingreso"), function () {
                        buttonEndProcess(button_process);
                    });
                },
                success: function (data) {
                    if (data.correcto) {
                        if(data.correcto=='OK'){
                            xModal.success(Base.traduceTexto("Ingresado con Éxito"),function () {
                                MantenedorSeremi.buscar();
                                xModal.closeAll();
                                buttonEndProcess(button_process);
                            });
                         }else{
                            xModal.info(data.correcto, function () {
                                buttonEndProcess(button_process);
                            });     
                         }
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
  
 
    habilitarSeremi: function (id_seremi,bo_activo) {
        var texto = (bo_activo == 0)?"des":"";
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: {id_seremi:id_seremi,bo_activo:bo_activo},
            type: "post",
            url: Base.getBaseUri() + "Farmacia/Turnos/AdminSeremi/habilitarSeremi",
            error: function (xhr, textStatus, errorThrown) {
                xModal.info(Base.traduceTexto("Error al "+texto+"habilitar seremi"));
            },
            success: function (data) {
                if (data.correcto) {
                    xModal.success(Base.traduceTexto("El seremi se ha "+texto+"habilitado"),function () {
                        MantenedorSeremi.buscar();
                        xModal.closeAll();
                    });
                } else {
                    xModal.info(Base.traduceTexto("Error al "+texto+"habilitar seremi"));
                }
            }
        });
    }
    
};



$("#chk_ver_password").on('click', function (e) {
    if ($("#chk_ver_password").is(':checked')) {
        $("#gl_password").prop('type', 'text');
    } else {
        $("#gl_password").prop('type', 'password');
    }
});


//funcion que borra la cache de firma en caso de cerrar el modal desde X de arriba
$(".after-close").on('click', function (e) {
    $.ajax({
        dataType: "json",
        cache: false,
        async: true,
        data: {},
        type: "post",
        url: Base.getBaseUri() + "Farmacia/Turnos/AdminSeremi/limpiarCacheFirma",
        error: function (xhr, textStatus, errorThrown) {
            console.log("Error al borrar caché de firma");
        },
        success: function (data) {
            
        }
    });
});



MantenedorSeremi.buscar();
