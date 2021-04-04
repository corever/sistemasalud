
var AdministradorTurnos = {

    init: function () {


        dt_grillaAdministrarTurnos = $("#grillaAdministrarTurnos").DataTable({
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
                filename: 'Turnos',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            }],
            ajax: {
                "method": "POST",
                "url": "grillaTurnos",
                "data": function (d) {
                    d.buscar = 1;
                    // d.fk_bodega_tipo = $('#fk_bodega_tipo').val();
                    // d.bodega_direccion = $('#bodega_direccion').val();
                    // d.fk_region = $('#fk_region').val();
                },
            },
            columns: [
                // {"data": "gl_token", "class": ""},
                // { "data": "region_id", "class": "" },
                { "data": "region_nombre", "class": "" },
                // { "data": "comuna_id", "class": "" },
                { "data": "comuna_nombre", "class": "" },
                { "data": "local_nombre", "class": "" },
                { "data": "local_direccion", "class": "" },
                { "data": "local_telefono", "class": "" },
                { "data": "hora_inicio", "class": "" },
                { "data": "hora_termino", "class": "" },
                { "data": "opciones", "class": "" }
            ]
        });

        $("#grillaAdministrarTurnos")
            .on("click", ".verResolucion", null, function () {
                var self = $(this);
                var rowData = dt_grillaAdministrarTurnos.row(self.parents("tr")).data();

                xModal.open(Base.getBaseDir() + 'Farmacia/Turnos/AdminTurnos/verResolucion/'
                    + rowData.gl_token
                    + ''
                    , Base.traduceTexto("Ver Resolución:")
                    , 'lg'
                    , 'idVerResolucion'
                    , null
                    , null
                    , '<button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Cerrar" onclick="xModal.close();">'
                    + '<i class="fa fa-times"></i>&nbsp;&nbsp;Cerrar</button>'
                );

            })
            .on("click", ".descargarExcel", null, function () {
                var self = $(this);
                var rowData = dt_grillaAdministrarTurnos.row(self.parents("tr")).data();

                xModal.open(Base.getBaseDir() + 'Farmacia/Turnos/AdminTurnos/descargarExcel/'
                    + rowData.gl_token
                    + ''
                    , Base.traduceTexto("Descargar Excel:")
                    , 'lg'
                    , 'idDescargarExcel'
                    , null
                    , null
                    , '<button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Cerrar" onclick="xModal.close();">'
                    + '<i class="fa fa-times"></i>&nbsp;&nbsp;Cerrar</button>'
                )

            })
            .on("click", ".visarResolucion", null, function () {
                var self = $(this);
                var rowData = dt_grillaAdministrarTurnos.row(self.parents("tr")).data();

                xModal.open(Base.getBaseDir() + 'Farmacia/Turnos/AdminTurnos/visarResolucion/'
                    + rowData.gl_token
                    + ''
                    , Base.traduceTexto("Visar Resolucion:")
                    , 'lg'
                    , 'idvisarResolucion'
                    , null
                    , null
                    , '<button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" title="Visar" onclick="xModal.close();">'
                    + '<i class="fa fa-times"></i>&nbsp;&nbsp;Visar</button>'
                    + '<button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Cerrar" onclick="xModal.close();">'
                    + '<i class="fa fa-times"></i>&nbsp;&nbsp;Cerrar</button>'
                );

            })
            .on("click", ".editarResolucion", null, function () {
                var self = $(this);
                var rowData = dt_grillaAdministrarTurnos.row(self.parents("tr")).data();

                // xModal.open(Base.getBaseDir() + 'Farmacia/Turnos/AdminTurnos/visarResolucion/'
                //     + rowData.gl_token
                //     + ''
                //     , Base.traduceTexto("Vedtr Resolucion:")
                //     , 'lg'
                //     , 'idvisarResolucion'
                //     , null
                //     , null
                //     , '<button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" title="Visar" onclick="xModal.close();">'
                //     + '<i class="fa fa-times"></i>&nbsp;&nbsp;Visar</button>'
                //     + '<button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Cerrar" onclick="xModal.close();">'
                //     + '<i class="fa fa-times"></i>&nbsp;&nbsp;Cerrar</button>'
                // );

            });


    }

};

AdministradorTurnos.init();