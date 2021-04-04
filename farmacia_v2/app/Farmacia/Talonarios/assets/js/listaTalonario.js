var ListaTalonario = {
    limpiarFiltros: function () {
        // $("#fk_region").val("0");
        // $("#fk_bodega_tipo").val("0");
        // $("#bodega_nombre").val("");
        // $("#bodega_direccion").val("");
        ListaTalonario.buscar();
    },
    init: function () {

        // var parametros = $("#formBuscar").serializeArray();
        // var arr = new Array();

        // $.each(parametros, function (index, value) {
        //     arr[value.name] = value.value;
        // }); 

        dt_GrillaTalonario = $("#grilla-listaTalonarios").DataTable({
            "lengthMenu": [5, 10, 20, 25, 50, 100],
            "pageLength": 10,
            "destroy": true,
            "aaSorting": [],
            "deferRender": true,
            "language": {
                "url": Base.getBaseDir() + "pub/js/plugins/DataTables/lang/" + jsonTraductor.urlJsonDataTable
            },
            dom: 'Bflrtip',
            ajax: {
                "method": "POST",
                "url": "ListaTalonario/grillaTalonariosCreados",
                "data": function (d) {
                    // d.bodega_nombre = $('#bodega_nombre').val();
                    // d.fk_bodega_tipo = $('#fk_bodega_tipo').val();
                    // d.bodega_direccion = $('#bodega_direccion').val();
                    // d.fk_region = $('#fk_region').val();
                },
            },
            columns: [
                // {"data": "bodega_id", "class": ""},
                { "data": "serie", "class": "" },
                { "data": "cantidad", "class": "" },
                { "data": "folio_inicial", "class": "" },
                { "data": "folio_final", "class": "" },
                { "data": "proveedor", "class": "" },
                { "data": "documento", "class": "" },
                { "data": "nr_documento", "class": "" },
                { "data": "fc_documento", "class": "" },
                { "data": "opciones", "class": "" }
            ],
            buttons: [{
                extend: 'excelHtml5',
                className: 'btn btn-default btn-xs',
                text: '<i class=\"fa fa-download\"></i> ' + Base.traduceTexto("Exportar a Excel"),
                filename: 'Grilla',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            }]
        });


        $("#grilla-listaTalonarios")
            .on("click", ".inhabilitarLoteTalonarios", null, function () {
                var self = $(this);
                var rowData = dt_GrillaTalonario.row(self.parents("tr")).data();

                xModal.open(Base.getBaseDir() + 'Farmacia/Talonarios/ListaTalonario/formInhabilitarLoteTalonarios/'
                    + rowData.gl_token
                    + ''
                    , Base.traduceTexto("&iquest;Desea eliminar los siguientes Talonarios?")
                    , 'lg'
                    , 'mdlInhabilitarTalonarios'
                    , null
                    , null
                    , '<button type="button" class="btn btn-sm btn-danger" id="inhabilitarTalonarios" data-toggle="tooltip"'
                    + ' title="Eliminar" >'
                    + '<i class="fa fa-save"></i>&nbsp;&nbsp;Eliminar</button>'
                    + '<button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip"'
                    + ' title="Cerrar" onclick="xModal.close();">'
                    + '<i class="fa fa-times"></i>&nbsp;&nbsp;Cerrar</button>'
                );

            });

        $("body")
            .on("click", "#inhabilitarTalonarios", null, function () {

                let msgError = '';

                if ($.trim($("#id_motivo").val()) == 0) {
                    msgError += "- " + Base.traduceTexto("Por favor, seleccione un Motivo") + ". <br>";
                }
                if ($.trim($("#gl_observacion").val()) == "") {
                    msgError += "- " + Base.traduceTexto("Por favor, ingrese una Observación") + ". <br>";
                }

                if (msgError != '') {
                    xModal.warning(msgError, function () {
                        $("#ingresarTalonarios").removeAttr("disabled");
                    });
                } else {

                    $.ajax({
                        url: "ListaTalonario/inhabilitarLoteTalonarios/",
                        dataType: 'json',
                        type: 'post',
                        data: $("#formInhabilitarLoteTalonarios").serialize(),
                        success: function (response) {
                            if (response.correcto) {
                                // recarga DT y recarga el listado para poder seguir agregando
                                ListaTalonario.buscar();
                                // dt_GrillaAsignarTalonario.ajax.reload();
                                xModal.success(response.mensaje, function () {
                                    xModal.closeAll();
                                });
                            } else {
                                xModal.warning(response.mensaje);
                            }
                        }
                    });

                }

            });


    },
    buscar: function () {
        dt_GrillaTalonario.ajax.reload();
    }
}

ListaTalonario.init();