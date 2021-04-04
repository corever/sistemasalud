
var AdminVentaCheque = {

    limpiarFiltros: function () {
        $("#fc_venta_talonario").val("0");
        $("#gl_nombre_medico").val("");
        $("#gl_codigo_recaudacion").val("");
        AdminVentaCheque.buscar();
    },
    buscar: function () {
        var parametros  = $("#formBuscar").serializeArray();
        var arr         = new Array();
        $.each(parametros, function (index, value) {
            arr[value.name] = value.value;
        });
        
        $("#grilla-talonariosAsignados").dataTable({
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
                    }
                }
            }],
            ajax: {
                "method": "POST",
                "url": "AdminVentaCheque/grillaTalonariosAsignados",
                "data": arr,
            },
            columns: [
                {"data": "id", "class": "text-center"},
                {"data": "fecha_venta", "class": "text-center"},
                {"data": "medico", "class": "text-center"},
                {"data": "serie", "class": "text-center"},
                {"data": "codigo", "class": "text-center"},
                {"data": "estado", "class": "text-center"},
                {"data": "acciones", "class": "text-center"}
            ]
        });
    },

    anularTalonario: function (id_venta) {
        $.ajax({
            url: Base.getBaseUri() + "Farmacia/Talonarios/AdminVentaCheque/anularTalonario",
            dataType: 'json',
            type: 'post',
            data: {id_venta:id_venta},
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
    }
    
};

AdminVentaCheque.buscar();

$('#fc_venta_talonario').daterangepicker({
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Deciembre"
        ],
        "firstDay": 1
    }
});