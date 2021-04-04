$("#btn_buscar").on('click', function(e) {
    var button_process = buttonStartProcess($(this), e);
    var parametros = $("#form_filtros").serializeArray();
    var url = 'Paciente';
    var bo_microchip = $("#bo_microchip").val();

    if (bo_microchip == 1) {
        url = 'Microchip';
    }

    $.ajax({
        dataType: 'html',
        cache: false,
        async: true,
        data: parametros,
        type: "post",
        url: BASE_URI + "index.php/" + url + "/buscarGrilla",
        error: function(xhr, textStatus, errorThrown) {
            xModal.danger('Error: No se pudo guardar');
        },
        success: function(response) {
            $("#contenedor_grilla_registros").html(response);

            var dataOptions = {
                pageLength: 10,
                language: {
                    "url": url_base + "static/js/plugins/DataTables/lang/es.json"
                },
                fnDrawCallback: function(oSettings) {
                    $(this).fadeIn("slow");
                },
                dom: 'Bflrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    text: 'Exportar a Excel',
                    filename: 'Grilla',
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        }
                    }
                }]
            };

            if ($("#tablaPrincipal").data('sorting')) {
                if ($("#tablaPrincipal").data('sorting-order')) {
                    var order = $("#tablaPrincipal").data('sorting-order');
                } else {
                    var order = "desc";
                }
                var sorting = [
                    [parseInt($("#tablaPrincipal").data('sorting')), order]
                ];
                dataOptions.aaSorting = sorting;
            }

            $("#tablaPrincipal").DataTable(dataOptions);
        }
    });
    buttonEndProcess(button_process);
});

$("#btn_limpia_filtros").on('click', function(e) {
    $("#region option:eq(0)").prop('selected', true);
    $("#id_oficina option:eq(0)").prop('selected', true).trigger("change");
    $("#id_fiscalizador option:eq(0)").prop('selected', true).trigger("change");
    $("#establecimiento_salud").val('0').trigger('change');
    $("#folio_expediente").val('');
    $("#folio_mordedor").val('');
    $("#microchip_mordedor").val('');
    $("#documento").val('');
    $("#btn_buscar").trigger("click");
});

function verAlarma(boton) {
    var parametros = [{
            "name": 'alarma',
            "value": $(boton).data("alarma")
        },
        {
            "name": 'estado',
            "value": $(boton).data("estado")
        },
    ];
    $.ajax({
        dataType: "json",
        cache: false,
        async: true,
        data: parametros,
        type: "post",
        url: BASE_URI + 'index.php/Paciente/cambiarEstadoAlarma',
        error: function(xhr, textStatus, errorThrown) {
            xModal.danger('Error: No se pudo actualizar el estado de la Alarma');
        },
        success: function(data) {
            if (data.correcto) {
                //xModal.success('Éxito: '+data.mensaje);
                //setTimeout(function () {
                location.reload();
                //}, 2000);
            } else {
                xModal.danger('Error: ' + data.mensaje);
            }
        }
    });
};

$(".select2").select2({
    language: "es",
    tags: false
});

$("#fecha_desde").datepicker({
    locale: "es",
    format: "DD/MM/YYYY",
    maxDate: "now",
    useCurrent: false,
    inline: false
});

$("#fecha_hasta").datepicker({
    locale: "es",
    format: "DD/MM/YYYY",
    maxDate: "now",
    useCurrent: false,
    inline: false
});