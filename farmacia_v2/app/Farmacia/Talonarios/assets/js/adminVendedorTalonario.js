var AdminVendedorTalonario = {
    limpiarFiltros: function () {
        // $("#mur_fk_comuna").val("0");
        // $("#mur_fk_region").val("0");
        AdminVendedorTalonario.buscar();
    },
    init: function () {

        grillaVendedoresTalonario = $("#grillaVendedoresTalonario").DataTable({
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
                "url": "grillaVendedoresTalonario",
                "data": function (d) {
                    // d.mur_fk_comuna = $('#mur_fk_comuna').val();
                    // d.mur_fk_region = $('#mur_fk_region').val();
                },
            },
            columns: [
                // { "data": "token", "class": "" },
                { "data": "rut_vendedor", "class": "" },
                { "data": "vendedor", "class": "" },
                // { "data": "localidad", "class": "" },
                { "data": "comuna", "class": "" },
                // { "data": "territorio", "class": "" },
                { "data": "region", "class": "" },
                // { "data": "farmacia", "class": "" },
                // { "data": "local", "class": "" },
                // { "data": "bodega", "class": "" },
                { "data": "bo_crear_medico", "class": "" },
                { "data": "bo_inhabilitar_medico", "class": "" },
                { "data": "bo_editar_medico", "class": "" },
                { "data": "bo_asignarse_talonarios", "class": "" },
                // { "data": "estado", "class": "" },
                { "data": "opciones", "class": "" },
                // { "data": "opciones2", "class": "" }
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


        $("#grillaVendedoresTalonario")
            .on("click", ".btnModificarPermisos", null, function () {
                var self = $(this);
                var rowData = grillaVendedoresTalonario.row(self.parents("tr")).data();

                xModal.open(Base.getBaseDir() + 'Farmacia/Talonarios/AdminVendedorTalonario/formEditarPermisosVendedor/'
                    + rowData.token
                    + ''
                    , Base.traduceTexto("Editar Permisos Vendedor:")
                    + ' <strong>'
                    + rowData.vendedor + '</strong>'
                    , 'lg'
                    , 'idEditarPermisosVendedor'
                    , null
                    , null
                    , '<button type="button" class="btn btn-sm btn-success" id="saveEditarPermisosVendedor" data-toggle="tooltip"'
                    + ' title="Guardar" data-bodegaid="' + rowData.token + '" >'
                    + '<i class="fa fa-save"></i>&nbsp;&nbsp;Guardar</button>'
                    + '<button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip"'
                    + ' title="Cerrar" onclick="xModal.close();">'
                    + '<i class="fa fa-times"></i>&nbsp;&nbsp;Cerrar</button>'
                );
            });

        $("body")
            .on("click", "#saveEditarPermisosVendedor", null, function () {

                $.ajax({
                    url: Base.getBaseUri() + "Farmacia/Talonarios/AdminVendedorTalonario/saveEditarPermisosVendedor",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        "form": $("#formEditarPermisosVendedor").serializeArray()
                        , "token": $("#token").val()
                    },
                    success: function (response) {
                        if (response.correcto) {
                            // recarga DT y recarga el listado para poder seguir agregando
                            AdminVendedorTalonario.buscar();
                            xModal.success(response.mensaje, function () {
                                xModal.closeAll();
                            });
                        } else {
                            xModal.warning(response.mensaje);
                        }
                    }
                });


            });

    },
    buscar: function () {
        grillaVendedoresTalonario.ajax.reload();
    }
}

AdminVendedorTalonario.init();