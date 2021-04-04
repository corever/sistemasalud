

// $.datepicker.setDefaults({
//     format: "dd-mm-yyyy",
//     altFormat: "yy-mm-dd",
//     changeMonth: true,
//     changeYear: true,
//     autoclose: true,
//     language: "es"
// });

var ingresarResolucionUrgencia = {


    init: function () {

        $(".card-footer")
            .on("click", "#cancelar", function (event) {
                $("#ingresar").removeAttr("disabled");
                document.getElementById('formIngresarResolucionUrgencia').reset();
            })
            .on("click", "#ingresar", function (event) {
                $(this).prop("disabled", true);
                ingresarResolucionUrgencia.guardar();
            });

        $("#formIngresarResolucionUrgencia")
            .on("change", "#id_region", null, function () {
                Region.cargarComunasConEstablecimientoUrgenciaPorRegion(this.value, 'id_comuna', null);
                $("#id_establecimiento_urgencia")
                    .html("<option value='0'>Seleccione un Establecimiento Urgencia</option>")
                    .val(0);
            })
            .on("change", "#id_comuna", null, function () {
                Region.cargarEstablecimientoUrgenciaPorComuna(this.value, 'id_establecimiento_urgencia', null);
            })
            .on("change", "#id_periodo, #id_anyo", null, function () {
                if (0 === parseInt($("#id_periodo").val())) {
                    $('#fc_inicio').val("La fecha de inicio del Período.");
                    $('#fc_termino').val("La fecha de término del Período.");
                } else {

                    id_periodo = $("#id_periodo :selected");
                    id_anyo_val = $("#id_anyo :selected").val();

                    $('#fc_inicio').val(
                        id_periodo.attr("data-diainicio")
                        + " de "
                        + id_anyo_val
                    );

                    $('#fc_termino').val(
                        id_periodo.attr("data-diatermino")
                        + " de "
                        + id_anyo_val
                    );
                }

            });


    },
    guardar: function () {

        let mensaje = '';

        if ($.trim($("#id_region").val()) == 0) {
            mensaje += "- " + Base.traduceTexto("Por favor, seleccione una Región") + ". <br>";
        }
        if ($.trim($("#id_comuna").val()) == 0) {
            mensaje += "- " + Base.traduceTexto("Por favor, seleccione una Comuna") + ". <br>";
        }
        if ($.trim($("#id_establecimiento_urgencia").val()) == 0) {
            mensaje += "- " + Base.traduceTexto("Por favor, seleccione un Establecimiento Urgencia") + ". <br>";
        }
        if ($.trim($("#id_periodo").val()) == 0) {
            mensaje += "- " + Base.traduceTexto("Por favor, seleccione un Período") + ". <br>";
        }
        if ($.trim($("#id_anyo").val()) == 0) {
            mensaje += "- " + Base.traduceTexto("Por favor, seleccione un Año") + ". <br>";
        }
        if ($.trim($("#fc_inicio").val()) == "") {
            mensaje += "- " + Base.traduceTexto("Por favor, seleccione la Fecha de Inicio") + ". <br>";
        }
        if ($.trim($("#fc_termino").val()) == "") {
            mensaje += "- " + Base.traduceTexto("Por favor, seleccione la Fecha de Término") + ". <br>";
        }
        if ($.trim($("#gl_punto2").val()) == "") {
            mensaje += "- " + Base.traduceTexto("Por favor, ingrese un texto para el segundo punto de la resolución") + ". <br>";
        }

        if (mensaje != '') {
            xModal.warning(mensaje, function () {
                $("#ingresar").removeAttr("disabled");
            });
        } else {

            $.ajax({
                url: Base.getBaseUri() + "Farmacia/Turnos/AdminResolucion/guardarResolucionUrgencia",
                dataType: 'json',
                type: 'post',
                data: {
                    formData: $("#formIngresarResolucionUrgencia").serialize()
                },
                success: function (response) {
                    if (response.correcto) {
                        xModal.success(response.mensaje, function () {
                            // Evaluar redireccionar al listado
                            document.getElementById('formIngresarResolucionUrgencia').reset();
                            $("#ingresar").removeAttr("disabled");
                        });
                    } else {
                        xModal.warning(response.mensaje);
                        $("#ingresar").removeAttr("disabled");
                    }
                }
            });
        }
    }

};

ingresarResolucionUrgencia.init();