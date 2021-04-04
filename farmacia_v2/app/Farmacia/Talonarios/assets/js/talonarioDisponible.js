var talonarioDisponible = {
    limpiarFiltros: function () {
        talonarioDisponible.buscar();
    },
    init: function () {

        // var parametros = $("#formBuscar").serializeArray();
        // var arr = new Array();

        // $.each(parametros, function (index, value) {
        //     arr[value.name] = value.value;
        // });

        dt_GrillaTalonarioDisponible = $("#grilla-talonarioDisponible")
            .DataTable({
                "lengthMenu": [5, 10, 20, 25, 50, 100],
                "pageLength": 10,
                "destroy": true,
                "aaSorting": [],
                "deferRender": true,
                dom: 'Bflrtip',
                ajax: {
                    "method": "POST",
                    "url": Base.getBaseUri() + "index.php/Farmacia/Talonarios/TalonarioDisponible/grillaTalonarioDisponible",
                    "data": function (d) {
                        d.tc_id = $('#tc_id').val();
                    },
                },
                columns: [
                    // {"data": "bodega_id", "class": ""},
                    { "data": "talonario_serie", "class": "" },
                    { "data": "talonario_folio_inicial", "class": "" },
                    { "data": "talonario_folio_final", "class": "" },
                    { "data": "local_venta", "class": "" },
                    { "data": "fecha_creacion_talonario", "class": "" },
                    { "data": "talonario_estado", "class": "" },
                    { "data": "opciones", "class": "" }
                ],
                columnDefs: [{
                    orderable: false,
                    targets: 6,
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
                    className: 'btn btn-outline-success btn-xs',
                    text: '<i class=\"fa fa-check-double\"></i> ' + Base.traduceTexto("Seleccionar todos"),
                    action: function (e, dt, node, config) {
                        dt_GrillaTalonarioDisponible.rows().select();
                        $('#grilla-talonarioDisponible tbody').find(".form-check-input")
                            .attr("checked", "checked")
                            .prop("checked", true);
                    }

                },
                {
                    className: 'btn btn-outline-danger btn-xs',
                    text: '<i class=\"fa fa-times\"></i> ' + Base.traduceTexto("Deseleccionar todos"),
                    action: function (e, dt, node, config) {
                        dt_GrillaTalonarioDisponible.rows().deselect();
                        $('#grilla-talonarioDisponible tbody').find(".form-check-input")
                            .removeAttr("checked")
                            .prop("checked", false);
                    }

                },
                {
                    className: 'btn btn-outline-info btn-xs',
                    text: '<i class=\"fa fa-check\"></i> ' + Base.traduceTexto("Seleccionar filas que cumplen el filtro"),
                    action: function (e, dt, node, config) {
                        dt_GrillaTalonarioDisponible.rows().deselect();
                        dt_GrillaTalonarioDisponible.rows({ search: 'applied' }).select();
                        $('#grilla-talonarioDisponible tbody').find(".form-check-input")
                            .attr("checked", "checked")
                            .prop("checked", true);
                    }

                }

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

        $('#grilla-talonarioDisponible tbody').on('click', 'td:not(:last-child)', function () {
            var tr = $(this).closest('tr');
            if (tr.hasClass('selected')) {
                tr.find(".form-check-input")
                    .removeAttr("checked")
                    .prop("checked", false);
                dt_GrillaTalonarioDisponible.row(tr).deselect();
            } else {
                tr.find(".form-check-input")
                    .attr("checked", "checked")
                    .prop("checked", true);
                dt_GrillaTalonarioDisponible.row(tr).select();
            }
        });


    },
    buscar: function () {
        dt_GrillaTalonarioDisponible.ajax.reload();
    },
    transferirTalonarioSeleccionados: function () {
        // talonarioSeleccionado
        // let formData = $("#formTalonarioDisponible").serializeArray();
        let msgError = '';

        if (0 === dt_GrillaTalonarioDisponible.rows('.selected').data().length) {
            msgError += "- " + Base.traduceTexto("Por favor, debe seleccionar un registro") + ". <br>";
        }

        // console.log(dt_GrillaTalonarioDisponible.rows('.selected').data().length + ' row(s) selected');

        if (msgError != '') {
            xModal.warning(msgError);
        } else {

            let arrTalonarios = new Array();
            dt_GrillaTalonarioDisponible.rows('.selected').every(function (rowIdx, tableLoop, rowLoop) {
                arrTalonarios.push(this.data().asignacion_id);
            });

            $.ajax({
                url: Base.getBaseUri() + "Farmacia/Talonarios/TalonarioDisponible/transferirTalonario",
                dataType: 'json',
                type: 'post',
                data: {
                    "arrTalonarios[]": arrTalonarios
                    , "id_motivo": 1 // $("#id_motivo").val()
                    , "gl_observacion": $("#gl_observacion").val()
                },
                success: function (response) {
                    if (response.correcto) {
                        // recarga DT y recarga el listado para poder seguir agregando
                        talonarioDisponible.buscar();
                        // dt_GrillaTalonarioDisponible.ajax.reload();
                        xModal.success(response.mensaje, function () {
                        });
                    } else {
                        xModal.warning(response.mensaje);
                    }
                }
            });
        }

    },
    eliminarTalonarioSeleccionados: function () {
        // talonarioSeleccionado
        // let formData = $("#formTalonarioDisponible").serializeArray();
        let msgError = '';

        if (0 === dt_GrillaTalonarioDisponible.rows('.selected').data().length) {
            msgError += "- " + Base.traduceTexto("Por favor, debe seleccionar un registro") + ". <br>";
        }

        // console.log(dt_GrillaTalonarioDisponible.rows('.selected').data().length + ' row(s) selected');

        if (msgError != '') {
            xModal.warning(msgError);
        } else {

            let arrTalonarios = new Array();
            dt_GrillaTalonarioDisponible.rows('.selected').every(function (rowIdx, tableLoop, rowLoop) {
                arrTalonarios.push(this.data().asignacion_id);
            });

            $.ajax({
                url: Base.getBaseUri() + "Farmacia/Talonarios/TalonarioDisponible/eliminarTalonario",
                dataType: 'json',
                type: 'post',
                data: {
                    "arrTalonarios[]": arrTalonarios
                    , "id_motivo": 2 // $("#id_motivo").val()
                    , "gl_observacion": $("#gl_observacion").val()
                },
                success: function (response) {
                    if (response.correcto) {
                        // recarga DT y recarga el listado para poder seguir agregando
                        talonarioDisponible.buscar();
                        // dt_GrillaTalonarioDisponible.ajax.reload();
                        xModal.success(response.mensaje, function () {
                        });
                    } else {
                        xModal.warning(response.mensaje);
                    }
                }
            });
        }

    },
    mermaTalonarioSeleccionados: function () {
        // talonarioSeleccionado
        // let formData = $("#formTalonarioDisponible").serializeArray();
        let msgError = '';

        if (0 === dt_GrillaTalonarioDisponible.rows('.selected').data().length) {
            msgError += "- " + Base.traduceTexto("Por favor, debe seleccionar un registro") + ". <br>";
        }
        if (1 === parseInt($("#id_motivo").val()) || 2 === parseInt($("#id_motivo").val())) {
            msgError += "- " + Base.traduceTexto("Por favor, debe seleccionar un motivo: Dañado, Perdido, Robado u otro") + ". <br>";
        }

        // console.log(dt_GrillaTalonarioDisponible.rows('.selected').data().length + ' row(s) selected');

        if (msgError != '') {
            xModal.warning(msgError);
        } else {

            let arrTalonarios = new Array();
            dt_GrillaTalonarioDisponible.rows('.selected').every(function (rowIdx, tableLoop, rowLoop) {
                arrTalonarios.push(this.data().asignacion_id);
            });

            $.ajax({
                url: Base.getBaseUri() + "Farmacia/Talonarios/TalonarioDisponible/mermaTalonario",
                dataType: 'json',
                type: 'post',
                data: {
                    "arrTalonarios[]": arrTalonarios
                    , "id_motivo": $("#id_motivo").val()
                    , "gl_observacion": $("#gl_observacion").val()
                },
                success: function (response) {
                    if (response.correcto) {
                        // recarga DT y recarga el listado para poder seguir agregando
                        talonarioDisponible.buscar();
                        // dt_GrillaTalonarioDisponible.ajax.reload();
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

talonarioDisponible.init();