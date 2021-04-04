var Talonario = {
    fun_sumaCantidadTalonarios: function () {
        let nrCantidadTalonario = parseInt($("#nr_cantidadTalonario").val());
        $("#nr_folioFinal").val(
            // 50
            nrCantidadTalonario
            * 50
            + parseInt($("#nr_folioInicial").val())
            - 1
        );
    },
    init: function () {

        Talonario.fun_sumaCantidadTalonarios();

        $("#fc_documento")
            .datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                endDate: new Date,
                language: "es",
            });

        $(".card-footer")
            .on("click", "#cancelarIngresarTalonarios", function (event) {
                $("#ingresarTalonarios").removeAttr("disabled");
                document.getElementById('formIngresarTalonario').reset();
            })
            .on("click", "#ingresarTalonarios", function (event) {
                $(this).prop("disabled", true);
                Talonario.guardarTalonario();
            });

        $("#formIngresarTalonario")
            .on("keypress keyup blur", "#gl_serie", function (event) {
                $(this).val(
                    $(this).val().replace(/[^a-zA-Z]/g, '')
                );
            })
            .on("keypress keyup blur", "#nr_folioInicial", function (event) {
                return soloNumeros(event);
            })
            .on("blur", "#nr_folioInicial", function (event) {
                Talonario.fun_sumaCantidadTalonarios();
            })
            .on("keypress keyup blur", "#nr_cantidadTalonario", function (event) {
                return soloNumeros(event);
            })
            .on("keypress keyup blur", "#nr_documento", function (event) {
                return soloNumeros(event);
            });

    },
    guardarTalonario: function () {

        Talonario.fun_sumaCantidadTalonarios();

        let formData = $("#formIngresarTalonario").serializeArray();
        let msgError = '';

        if ($.trim($("#gl_serie").val()) == "") {
            msgError += "- " + Base.traduceTexto("Por favor, ingrese una Serie") + ". <br>";
        }
        if ($.trim($("#nr_folioInicial").val()) == "") {
            msgError += "- " + Base.traduceTexto("Por favor, ingrese un Folio inicial") + ". <br>";
        }
        if ($.trim($("#nr_cantidadTalonario").val()) == "") {
            msgError += "- " + Base.traduceTexto("Por favor, ingrese la cantidad de Talonarios") + ". <br>";
        }
        if (0 === parseInt($("#nr_cantidadTalonario").val())) {
            msgError += "- " + Base.traduceTexto("Por favor, la cantidad de Talonarios debe ser mayor a 0") + ". <br>";
        }
        if ($.trim($("#id_proveedor").val()) == "0") {
            msgError += "- " + Base.traduceTexto("Por favor, seleccione un Proveedor") + ". <br>";
        }
        if ($.trim($("#id_documento").val()) == "0") {
            msgError += "- " + Base.traduceTexto("Por favor, seleccione un Documento") + ". <br>";
        }
        if ($.trim($("#nr_documento").val()) == "") {
            msgError += "- " + Base.traduceTexto("Por favor, ingrese el N&uacute;mero de Documento") + ". <br>";
        }
        if ($.trim($("#fc_documento").val()) == "") {
            msgError += "- " + Base.traduceTexto("Por favor, seleccione la Fecha de Documento") + ". <br>";
        }

        let nro_folioInicial_val = $("#nr_folioInicial").val();
        let arrResultado = new Array();
        arrResultado[0] = 0;
        arrResultado = nro_folioInicial_val.match("1$") || 0;
        if (1 !== parseInt(arrResultado[0])) {
            msgError += "- " + Base.traduceTexto("Por favor, el Folio inicial debe terminar en 1, por ejemplo 1091") + ". <br>";
        }

        if (msgError != '') {
            xModal.warning(msgError, function () {
                $("#ingresarTalonarios").removeAttr("disabled");
            });
        } else {

            /**
             * validar folio inicial y
             * folio final no existe en el sistema
             */
            $.when(Talonario.validarFolioExiste())
                .done(function (responseValidarFolioExiste) { 
                    
                    if (true === responseValidarFolioExiste.correcto) {

                        $.ajax({
                            url: Base.getBaseUri() + "Farmacia/Talonarios/Talonario/guardarTalonario",
                            dataType: 'json',
                            type: 'post',
                            data: formData,
                            success: function (response) {
                                if (response.correcto) {
                                    xModal.success(response.mensaje, function () {
                                        // console.log("success");
                                        // document.location.reload(true);
                                        // Evaluar redireccionar al listado
                                        document.getElementById('formIngresarTalonario').reset();
                                        $("#ingresarTalonarios").removeAttr("disabled");
                                    });
                                } else {
                                    xModal.warning(response.mensaje);
                                    $("#ingresarTalonarios").removeAttr("disabled");
                                }
                            }
                        });

                    } else {
                        xModal.warning(responseValidarFolioExiste.mensaje, function () {
                            $("#ingresarTalonarios").removeAttr("disabled");
                        });
                    }



                });

        }

    },
    validarFolioExiste: function () {

        // Talonario.fun_sumaCantidadTalonarios();

        return $.ajax({
            url: Base.getBaseUri() + "Farmacia/Talonarios/Talonario/validarFolioExiste",
            dataType: 'json',
            type: 'post',
            data: {
                "nr_folioInicial": $.trim($("#nr_folioInicial").val()),
                "gl_serie": $.trim($("#gl_serie").val()),
                "nr_folioFinal": $.trim($("#nr_folioFinal").val())
            }
        });
    }

};

Talonario.init();