var asignarTalonario = {
    limpiarFiltros: function () {
        asignarTalonario.buscar();
    },
    init: function () {

        // var parametros = $("#formBuscar").serializeArray();
        // var arr = new Array();

        // $.each(parametros, function (index, value) {
        //     arr[value.name] = value.value;
        // });

        dt_GrillaAsignarTalonario = $("#grilla-asignarTalonario")
            .DataTable({
                "lengthMenu": [5, 10, 20, 25, 50, 100],
                "pageLength": 10,
                "destroy": true,
                "aaSorting": [],
                "deferRender": true,
                // "language": {
                //     "url": Base.getBaseDir() + "pub/js/plugins/DataTables/lang/" + Base.traduceTexto("es.json")
                // },
                dom: 'Bflrtip',
                columnDefs: [{
                    orderable: false,
                    targets: 5,
                    'searchable': false,
                    'orderable': false,
                }],
                select: {
                    style: 'multi',
                    selector: 'td:last-child'
                },
                order: [[0, 'asc']],
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
                },
                {
                    className: 'btn btn-default btn-xs',
                    text: '<i class=\"fa fa-check-double\"></i> ' + Base.traduceTexto("Seleccionar todos"),
                    action: function (e, dt, node, config) {
                        dt_GrillaAsignarTalonario.rows().select();
                        $('#grilla-asignarTalonario tbody').find(".form-check-input")
                            .attr("checked", "checked")
                            .prop("checked", true);
                    }

                },
                {
                    className: 'btn btn-default btn-xs',
                    text: '<i class=\"fa fa-times\"></i> ' + Base.traduceTexto("Deseleccionar todos"),
                    action: function (e, dt, node, config) {
                        dt_GrillaAsignarTalonario.rows().deselect();
                        $('#grilla-asignarTalonario tbody').find(".form-check-input")
                            .removeAttr("checked")
                            .prop("checked", false);
                    }

                },
                {
                    className: 'btn btn-default btn-xs',
                    text: '<i class=\"fa fa-check\"></i> ' + Base.traduceTexto("Seleccionar filas que cumplen el filtro"),
                    action: function (e, dt, node, config) {
                        dt_GrillaAsignarTalonario.rows().deselect();
                        dt_GrillaAsignarTalonario.rows({ search: 'applied' }).select();
                        $('#grilla-asignarTalonario tbody').find(".form-check-input")
                            .attr("checked", "checked")
                            .prop("checked", true);
                    }

                }

                ]
                ,
                ajax: {
                    "method": "POST",
                    "url": Base.getBaseUri() + "index.php/Farmacia/Talonarios/AsignarTalonario/grillaAsignarTalonarioDisponible",
                    "data": function (d) {
                        // d.bodega_nombre = $('#bodega_nombre').val();
                        // d.fk_bodega_tipo = $('#fk_bodega_tipo').val();
                        // d.bodega_direccion = $('#bodega_direccion').val();
                        // d.fk_region = $('#fk_region').val();
                    },
                },
                columns: [
                    // {"data": "bodega_id", "class": ""},
                    { "data": "talonario_serie", "class": "" },
                    { "data": "talonario_folio_inicial", "class": "" },
                    { "data": "talonario_folio_final", "class": "" },
                    { "data": "cantidad_cheque_por_talonario", "class": "" },
                    { "data": "bodega_nombre", "class": "" },
                    { "data": "opciones", "class": "" }
                ],
                language: {
                    buttons: {
                        selectAll: Base.traduceTexto("Selecciona todos"),
                        selectNone: Base.traduceTexto("Limpia seleccionados")
                    },
                    "url": Base.getBaseDir() + "pub/js/plugins/DataTables/lang/" + jsonTraductor.urlJsonDataTable,
                    select: {
                        rows: {
                            _: "%d Registros seleccionados",
                            1: "%d Registro seleccionado"
                        }
                    }
                }
            });

        $('#grilla-asignarTalonario tbody').on('click', 'td:not(:last-child)', function () {
            var tr = $(this).closest('tr');
            if (tr.hasClass('selected')) {
                tr.find(".form-check-input")
                    .removeAttr("checked")
                    .prop("checked", false);
                dt_GrillaAsignarTalonario.row(tr).deselect();
            } else {
                tr.find(".form-check-input")
                    .attr("checked", "checked")
                    .prop("checked", true);
                dt_GrillaAsignarTalonario.row(tr).select();
            }
        });


    },
    buscar: function () {
        dt_GrillaAsignarTalonario.ajax.reload();
    },
    asignarTalonariosSeleccionados: function () {
        // talonarioSeleccionado
        // let formData = $("#formAsignarTalonario").serializeArray();
        let msgError = '';

        if (0 === dt_GrillaAsignarTalonario.rows('.selected').data().length) {
            msgError += "- " + Base.traduceTexto("Por favor, debe seleccionar un registro") + ". <br>";
        }

        if (msgError != '') {
            xModal.warning(msgError);
        } else {

            let arrAsignarTalonarios = new Array();
            dt_GrillaAsignarTalonario.rows('.selected').every(function (rowIdx, tableLoop, rowLoop) {
                arrAsignarTalonarios.push(this.data().asignacion_id);
            }); 

            $.ajax({
                url: Base.getBaseUri() + "Farmacia/Talonarios/AsignarTalonario/asignarTalonariosSeleccionados",
                dataType: 'json',
                type: 'post',
                data: {
                    "bodega_id": $("#bodega_id").val(),
                    "talonarioSeleccionado[]": arrAsignarTalonarios
                },
                success: function (response) {
                    if (response.correcto) {
                        // recarga DT y recarga el listado para poder seguir agregando
                        asignarTalonario.buscar();
                        // dt_GrillaAsignarTalonario.ajax.reload();
                        xModal.success(response.mensaje, function () {
                        });
                    } else {
                        xModal.warning(response.mensaje);
                    }
                }
            });
        }

    }
}

asignarTalonario.init();