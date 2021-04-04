var MantenedorMedico = {

    buscar: function() {
        var parametros = $("#formBuscar").serializeArray();
        var arr = new Array();
        $.each(parametros, function(index, value) {
            arr[value.name] = value.value;
        });
        $("#grilla-medicos").dataTable({
            "lengthMenu": [5, 10, 20, 25, 50, 100],
            "pageLength": 10,
            "destroy": true,
            "aaSorting": [],
            "deferRender": true,
            "language": {
                "url": Base.getBaseDir() + "pub/js/plugins/DataTables/lang/" + Base.traduceTexto("es.json")
            },
            dom: 'Bflrtip',
            buttons: [{
                extend: 'excelHtml5',
                className: 'btn btn-default btn-xs',
                text: '<i class=\"fa fa-download\"></i> ' + Base.traduceTexto("Exportar a Excel"),
                filename: 'Grilla',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    },
                    columns: [0, 1, 2]
                }
            }],
            ajax: {
                "method": "POST",
                "url": "AdminMedico/grillaMedicos",
                "data": arr,
            },
            columns: [{
                    "data": "nombre",
                    "class": ""
                },
                {
                    "data": "rut",
                    "class": ""
                },
                {
                    "data": "email",
                    "class": ""
                },
                {
                    "data": "opciones",
                    "class": ""
                }
            ]
        });

    },
    limpiarFiltros: function() {
        $("#gl_rut_medico").val("");
        $("#gl_email_medico").val("");
        $("#fc_nacimiento_medico").val("");
        $("#id_especialidad_medico").val("0");
        $("#id_profesion_medico").val("0");
        $("#gl_nombre_medico").val("");
        $("#gl_apellido_paterno_medico").val("");
        $("#gl_apellido_materno_medico").val("");


        for (i = 0; i < $("#dynamicInput p").length; i++) {
            $("#div_general_" + (i) + "").find('#selectRegion_' + (i) + '').val("0");
            $("#div_general_" + (i) + "").find('#selectComuna_' + (i) + '').val("0");
            $("#div_general_" + (i) + "").find('#direccion_' + (i) + '').val("");
            $("#div_general_" + (i) + "").find('#telefono_' + (i) + '').val("");
        }
    },
    habilitarMedico: function(id_medico, bo_activo) {
        var texto = (bo_activo == 0) ? "des" : "";
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: {
                id_medico: id_medico,
                bo_activo: bo_activo
            },
            type: "post",
            url: Base.getBaseUri() + "Farmacia/Medico/AdminMedico/habilitarMedico",
            error: function(xhr, textStatus, errorThrown) {
                xModal.info(Base.traduceTexto("Error al " + texto + "habilitar Medico"));
            },
            success: function(data) {
                if (data.correcto) {
                    xModal.success(Base.traduceTexto("El Medico se ha " + texto + "habilitado"), function() {
                        MantenedorMedico.buscar();
                        xModal.closeAll();
                    });
                } else {
                    xModal.info(Base.traduceTexto("Error al " + texto + "habilitar Medico"));
                }
            }
        });
    },


    addInput: function(divName) {
        var inputCount = $('#' + divName + ' p').length;
        $('#div_general_' + (inputCount - 1) + '').clone().attr('id', 'div_general_' + (inputCount)).insertAfter('#div_general_' + (inputCount - 1) + '');
        $("#div_general_" + inputCount + "").find('#eliminarConsulta_' + (inputCount - 1) + '').attr('id', 'eliminarConsulta_' + inputCount + '');
        $("#div_general_" + inputCount + "").find('#eliminarConsulta_' + (inputCount) + '').show();
        $("#div_general_" + inputCount + "").find('#selectRegion_' + (inputCount - 1) + '').attr('id', 'selectRegion_' + inputCount + '');
        $("#div_general_" + inputCount + "").find('#selectComuna_' + (inputCount - 1) + '').attr('id', 'selectComuna_' + inputCount + '');
        $("#div_general_" + inputCount + "").find('#direccion_' + (inputCount - 1) + '').attr('id', 'direccion_' + inputCount + '');
        $("#div_general_" + inputCount + "").find('#gl_consulta_' + (inputCount - 1) + '').attr('id', 'gl_consulta_' + inputCount + '');
        $("#div_general_" + inputCount + "").find('#gl_consulta_' + (inputCount) + '').text("Datos Consulta " + (inputCount + 1) + " :");
        $("#div_general_" + inputCount + "").find('#telefono_' + (inputCount - 1) + '').attr('id', 'telefono_' + inputCount + '');
        //limpio el valor interno de los clonados
        $("#div_general_" + inputCount + "").find('#selectRegion_' + (inputCount) + '').val('0');
        $("#div_general_" + inputCount + "").find('#selectComuna_' + (inputCount) + '').val('0');
        $("#div_general_" + inputCount + "").find('#direccion_' + (inputCount) + '').val('');
        $("#div_general_" + inputCount + "").find('#telefono_' + (inputCount) + '').val('');
    },

    removeInput: function(divName) {
        var identificador = $(divName).attr('id');
        var indice = identificador.substr(17); //obtengo el numero de indice del nombre "eliminarConsulta_"
        $("#div_general_" + indice + "").remove();
        var i = 0;
        var ind = parseInt(indice++, 10);
        // se reajustan los indices del resto de los elementos, tras eliminacion
        for (i = ind; i <= $("#dynamicInput p").length; i++) {
            $("#div_general_" + i + "").attr('id', 'div_general_' + (i - 1) + '');
            $("#div_general_" + (i - 1) + "").find('#eliminarConsulta_' + (i) + '').attr('id', 'eliminarConsulta_' + (i - 1) + '');
            $("#div_general_" + (i - 1) + "").find('#selectRegion_' + (i) + '').attr('id', 'selectRegion_' + (i - 1) + '');
            $("#div_general_" + (i - 1) + "").find('#selectComuna_' + (i) + '').attr('id', 'selectComuna_' + (i - 1) + '');
            $("#div_general_" + (i - 1) + "").find('#gl_consulta_' + (i) + '').attr('id', 'gl_consulta_' + (i - 1) + '');
            $("#div_general_" + (i - 1) + "").find('#gl_consulta_' + (i - 1) + '').text("Datos Consulta " + (i) + " :");
            $("#div_general_" + (i - 1) + "").find('#direccion_' + (i) + '').attr('id', 'direccion_' + (i - 1) + '');
            $("#div_general_" + (i - 1) + "").find('#telefono_' + (i) + '').attr('id', 'telefono_' + (i - 1) + '');
        }
    },
    agregarMedico: function(form, btn) {

        var e = jQuery.Event("click");
        var button_process = buttonStartProcess($(btn), e);
        var msgError = "";
        var cantidad_consultas = $("#dynamicInput p").length;

        if ($.trim($("#gl_rut_medico").val()) == "") {
            msgError += "- " + Base.traduceTexto("Rut es Obligatorio") + ". <br>";
        }
        if ($.trim($("#gl_nombre_medico").val()) == "") {
            msgError += "- " + Base.traduceTexto("Nombre es Obligatorio") + ". <br>";
        }
        if ($.trim($("#gl_apellido_paterno_medico").val()) == "") {
            msgError += "- " + Base.traduceTexto("Apellido Paterno es Obligatorio") + ". <br>";
        }
        if ($.trim($("#gl_apellido_materno_medico").val()) == "") {
            msgError += "- " + Base.traduceTexto("Apellido Materno es Obligatorio") + ". <br>";
        }
        if ($("input[name='chk_genero_medico']:checked").val() === undefined) {
            msgError += "- " + Base.traduceTexto("Género es Obligatorio") + ". <br>";
        }
        if ($.trim($("#fc_nacimiento_medico").val()) == "") {
            msgError += "- " + Base.traduceTexto("Fecha Nacimiento es Obligatorio") + ". <br>";
        }
        if ($.trim($("#gl_email_medico").val()) == "") {
            msgError += "- " + Base.traduceTexto("Email es Obligatorio") + ". <br>";
        }
        if ($("#gl_email_medico").parent().hasClass("has-error")) {
            msgError += "- " + Base.traduceTexto("Email es Inválido") + ". <br>";
        }

        if ($.trim($("#id_especialidad_medico").val()) == "0") {
            msgError += "- " + Base.traduceTexto("Especialidad es Obligatorio") + ". <br>";
        }

        if ($.trim($("#id_profesion_medico").val()) == "0") {
            msgError += "- " + Base.traduceTexto("Profesion es Obligatorio") + ". <br>";
        }

        for (i = 0; i < $("#dynamicInput p").length; i++) {
            if ($("#div_general_" + (i) + "").find('#selectRegion_' + (i) + '').val() == "0") {
                msgError += "- Seleccion de Region en Consulta " + (i + 1) + " es Obligatorio. <br>";
            }
            if ($("#div_general_" + (i) + "").find('#selectComuna_' + (i) + '').val() == "0") {
                msgError += "- Seleccion de Comuna en Consulta " + (i + 1) + " es Obligatorio. <br>";
            }
            if ($("#div_general_" + (i) + "").find('#direccion_' + (i) + '').val() == "") {
                msgError += "- Dirección en Consulta " + (i + 1) + " es Obligatorio. <br>";
            }
            if ($("#div_general_" + (i) + "").find('#telefono_' + (i) + '').val() == "") {
                msgError += "- Teléfono en Consulta " + (i + 1) + " es Obligatorio. <br>";
            }
        }

        let consultas = [];
        let direcciones = [];
        let telefonos = [];
        let regiones = [];
        let comunas = [];

        for (var i = 0; i < cantidad_consultas; i++) {
            region = $.trim($("#selectRegion_" + i + "").val());
            regiones.push(region);
            comuna = $.trim($("#selectComuna_" + i + "").val());
            comunas.push(comuna);
            direccion = $.trim($("#direccion_" + i + "").val());
            direcciones.push(direccion);
            telefono = $.trim($("#telefono_" + i + "").val());
            telefonos.push(telefono);
            consultas[i] = [
                regiones[i],
                comunas[i],
                direcciones[i],
                telefonos[i]
            ];
        }

        if (msgError != "") {
            xModal.danger(msgError, function() {
                buttonEndProcess(button_process);
            });
        } else {
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: {
                    consultas: consultas,
                    form: form
                },
                type: "post",
                url: Base.getBaseUri() + "Farmacia/Medico/AdminMedico/crearMedicoBD",
                error: function(xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error en el ingreso"), function() {
                        buttonEndProcess(button_process);
                    });
                },
                success: function(data) {
                    if (data.correcto) {
                        if (data.correcto == 'OK') {
                            xModal.success(Base.traduceTexto("Ingresado con Éxito"), function() {
                                MantenedorMedico.limpiarFiltros();
                                MantenedorMedico.buscar();
                                xModal.closeAll();
                                buttonEndProcess(button_process);
                            });
                        } else {
                            if(data.correcto == "RUT"){
                                xModal.info("Ya existe un Médico para el RUT ingresado", function() {
                                    buttonEndProcess(button_process);
                                });
                            }else{
                                xModal.info(data.correcto, function() {
                                    buttonEndProcess(button_process);
                                });
                            }
                            
                        }
                    } else {

                        xModal.info(data.msgError, function() {
                            buttonEndProcess(button_process);
                        });
                    }
                }
            });
        }


    },
    editarMedico: function (form, btn) {
        var e               = jQuery.Event("click");
        var button_process  = buttonStartProcess($(btn), e);
        var msgError        = "";
        var cantidad_consultas = $("#dynamicInput p").length;

        if ($.trim($("#gl_rut_medico").val()) == "") {
            msgError += "- " + Base.traduceTexto("Rut es Obligatorio") + ". <br>";
        }
        if ($.trim($("#gl_nombre_medico").val()) == "") {
            msgError += "- " + Base.traduceTexto("Nombre es Obligatorio") + ". <br>";
        }
        if ($.trim($("#gl_apellido_paterno_medico").val()) == "") {
            msgError += "- " + Base.traduceTexto("Apellido Paterno es Obligatorio") + ". <br>";
        }
        if ($.trim($("#gl_apellido_materno_medico").val()) == "") {
            msgError += "- " + Base.traduceTexto("Apellido Materno es Obligatorio") + ". <br>";
        }
        if ($("input[name='chk_genero_medico']:checked").val() === undefined) {
            msgError += "- " + Base.traduceTexto("Género es Obligatorio") + ". <br>";
        }
        if ($.trim($("#fc_nacimiento_medico").val()) == "") {
            msgError += "- " + Base.traduceTexto("Fecha Nacimiento es Obligatorio") + ". <br>";
        }
        if ($.trim($("#gl_email_medico").val()) == "") {
            msgError += "- " + Base.traduceTexto("Email es Obligatorio") + ". <br>";
        }
        if ($("#gl_email_medico").parent().hasClass("has-error")) {
            msgError += "- " + Base.traduceTexto("Email es Inválido") + ". <br>";
        }

        if ($.trim($("#id_especialidad_medico").val()) == "0") {
            msgError += "- " + Base.traduceTexto("Especialidad es Obligatorio") + ". <br>";
        }

        if ($.trim($("#id_profesion_medico").val()) == "0") {
            msgError += "- " + Base.traduceTexto("Profesion es Obligatorio") + ". <br>";
        }

        for (i = 0; i < $("#dynamicInput p").length; i++) {
            if ($("#div_general_" + (i) + "").find('#selectRegion_' + (i) + '').val() == "0") {
                msgError += "- Seleccion de Region en Consulta " + (i + 1) + " es Obligatorio. <br>";
            }
            if ($("#div_general_" + (i) + "").find('#selectComuna_' + (i) + '').val() == "0") {
                msgError += "- Seleccion de Comuna en Consulta " + (i + 1) + " es Obligatorio. <br>";
            }
            if ($("#div_general_" + (i) + "").find('#direccion_' + (i) + '').val() == "") {
                msgError += "- Dirección en Consulta " + (i + 1) + " es Obligatorio. <br>";
            }
            if ($("#div_general_" + (i) + "").find('#telefono_' + (i) + '').val() == "") {
                msgError += "- Teléfono en Consulta " + (i + 1) + " es Obligatorio. <br>";
            }
        }
        var id_medico = $("#id_medico").val();
        let consultas = [];
        let direcciones = [];
        let telefonos = [];
        let regiones = [];
        let comunas = [];

        for (var i = 0; i < cantidad_consultas; i++) {
            region = $.trim($("#selectRegion_" + i + "").val());
            regiones.push(region);
            comuna = $.trim($("#selectComuna_" + i + "").val());
            comunas.push(comuna);
            direccion = $.trim($("#direccion_" + i + "").val());
            direcciones.push(direccion);
            telefono = $.trim($("#telefono_" + i + "").val());
            telefonos.push(telefono);
            consultas[i] = [
                regiones[i],
                comunas[i],
                direcciones[i],
                telefonos[i]
            ];
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
                data: {
                    consultas: consultas,
                    form: form,
                    id_medico: id_medico
                },
                type: "post",
                url: Base.getBaseUri() + "Farmacia/Medico/AdminMedico/editarMedicoBD",
                error: function(xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error en el ingreso"), function() {
                        buttonEndProcess(button_process);
                    });

                },
                success: function(data) {
                    if (data.correcto) {
                        if (data.correcto == 'OK') {
                            xModal.success(Base.traduceTexto("Actualizado con Éxito"), function() {
                                MantenedorMedico.limpiarFiltros();
                                MantenedorMedico.buscar();
                                xModal.closeAll();
                                buttonEndProcess(button_process);
                            });
                        } else {
                            xModal.info(data.correcto, function() {
                                buttonEndProcess(button_process);
                            });
                        }
                    } else {

                        xModal.info(data.msgError, function() {
                            buttonEndProcess(button_process);
                        });
                    }
                }
            });
        }
        btn.disabled = false;
    }
};

MantenedorMedico.buscar();