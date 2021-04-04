
var AdminBodega = {
    limpiarFiltros: function () {
        $("#fk_region").val("0");
        $("#fk_bodega_tipo").val("0");
        $("#bodega_nombre").val("");
        $("#bodega_direccion").val("");
        AdminBodega.buscar();
    },
    init: function () {

        // var parametros = $("#formBuscar").serializeArray();
        // var arr = new Array();

        // $.each(parametros, function (index, value) {
        //     arr[value.name] = value.value;
        // });


        dt_GrillaBodegas = $("#grilla-bodegas").DataTable({
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
                    }
                }
            }],
            ajax: {
                "method": "POST",
                "url": "grillaBodega",
                "data": function (d) {
                    d.bodega_nombre = $('#bodega_nombre').val();
                    d.fk_bodega_tipo = $('#fk_bodega_tipo').val();
                    d.bodega_direccion = $('#bodega_direccion').val();
                    d.fk_region = $('#fk_region').val();
                },
            },
            columns: [
                // {"data": "gl_token", "class": ""},
                { "data": "bodega_nombre", "class": "" },
                { "data": "bodega_tipo_nombre", "class": "" },
                { "data": "bodega_direccion", "class": "" },
                { "data": "region_nombre", "class": "" },
                { "data": "opciones", "class": "" }
            ]
        });

        $("#grilla-bodegas")
            .on("click", ".verBodega", null, function () {
                var self = $(this);
                var rowData = dt_GrillaBodegas.row(self.parents("tr")).data();

                xModal.open(Base.getBaseDir() + 'Farmacia/Bodegas/AdminBodega/verBodega/'
                    // xModal.open(Base.getBaseDir() + 'Farmacia/Bodegas/AdminBodega/verBodega/?gl_token='
                    + rowData.gl_token
                    + ''
                    , Base.traduceTexto("Ver Bodega:")
                    + ' <strong>'
                    + rowData.bodega_nombre + '</strong>'
                    , 'lg'
                    , 'idVerBodega'
                    , null
                    , null
                    , '<button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Cerrar" onclick="xModal.close();"><i class="fa fa-times"></i>&nbsp;&nbsp;Cerrar</button>'
                );

            })
            .on("click", ".editarBodega", null, function () {
                var self = $(this);
                var rowData = dt_GrillaBodegas.row(self.parents("tr")).data();

                xModal.open(Base.getBaseDir() + 'Farmacia/Bodegas/AdminBodega/editarBodega/'
                    // xModal.open(Base.getBaseDir() + 'Farmacia/Bodegas/AdminBodega/editarBodega/?gl_token='
                    + rowData.gl_token
                    + ''
                    , Base.traduceTexto("Editar Bodega:")
                    + ' <strong>'
                    + rowData.bodega_nombre + '</strong>'
                    , 'lg'
                    , 'idEditarBodega'
                    , null
                    , null
                    , '<button type="button" class="btn btn-sm btn-success" id="saveBodega" data-toggle="tooltip"'
                    + ' title="Guardar" data-bodegaid="' + rowData.gl_token + '" >'
                    + '<i class="fa fa-save"></i>&nbsp;&nbsp;Guardar</button>'
                    + '<button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip"'
                    + ' title="Cerrar" onclick="xModal.close();">'
                    + '<i class="fa fa-times"></i>&nbsp;&nbsp;Cerrar</button>'
                );

                // id,_isIframe,_iframeHeight,_footer
            })
            .on("click", ".inhabilitarBodega", null, function () {
                var self = $(this);
                var rowData = dt_GrillaBodegas.row(self.parents("tr")).data();

                xModal.confirm(
                    Base.traduceTexto("Desea inhabilitar la siguiente Bodega:")
                    + ' <strong>'
                    + rowData.bodega_nombre + '</strong>'
                    , function () {

                        $.ajax({
                            url: Base.getBaseUri() + "Farmacia/Bodegas/AdminBodega/inhabilitarBodega",
                            dataType: 'json',
                            type: 'post',
                            data: {
                                "gl_token": rowData.gl_token
                            },
                            success: function (response) {
                                if (response.correcto) {
                                    // recarga DT y recarga el listado para poder seguir agregando
                                    AdminBodega.buscar();
                                    // dt_GrillaAsignarTalonario.ajax.reload();
                                    xModal.success(response.mensaje, function () {
                                    });
                                } else {
                                    xModal.warning(response.mensaje);
                                }
                            }
                        });

                    }
                    , function () {
                        xModal.close();
                    });
            })
            .on("click", ".habilitarBodega", null, function () {
                var self = $(this);
                var rowData = dt_GrillaBodegas.row(self.parents("tr")).data();

                xModal.confirm(
                    Base.traduceTexto("Desea habilitar la siguiente Bodega:")
                    + ' <strong>'
                    + rowData.bodega_nombre + '</strong>'
                    , function () {

                        $.ajax({
                            url: Base.getBaseUri() + "Farmacia/Bodegas/AdminBodega/habilitarBodega",
                            dataType: 'json',
                            type: 'post',
                            data: {
                                "gl_token": rowData.gl_token
                            },
                            success: function (response) {
                                if (response.correcto) {
                                    // recarga DT y recarga el listado para poder seguir agregando
                                    AdminBodega.buscar();
                                    // dt_GrillaAsignarTalonario.ajax.reload();
                                    xModal.success(response.mensaje, function () {
                                    });
                                } else {
                                    xModal.warning(response.mensaje);
                                }
                            }
                        });

                    }
                    , function () {
                        xModal.close();
                    });
            });


        $("body")
            .on("click", "#saveBodega", null, function () {

                $.ajax({
                    url: Base.getBaseUri() + "Farmacia/Bodegas/AdminBodega/saveBodega",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        "form": $("#formEditarBodega").serializeArray()
                        , "gl_token": $("#gl_token").val()
                    },
                    success: function (response) {
                        if (response.correcto) {
                            // recarga DT y recarga el listado para poder seguir agregando
                            AdminBodega.buscar();
                            // dt_GrillaAsignarTalonario.ajax.reload();
                            xModal.success(response.mensaje, function () {
                            });
                        } else {
                            xModal.warning(response.mensaje);
                        }
                    }
                });


            })
            .on("click", "#btnAgregarBodega", null, function () {

                xModal.open(Base.getBaseDir() + 'Farmacia/Bodegas/AdminBodega/agregarBodega/'
                    , Base.traduceTexto("Agregar Nueva Bodega")
                    , 'lg'
                    , 'idAgregarBodega'
                    , null
                    , null
                    , '<button type="button" class="btn btn-sm btn-success" id="createBodega" data-toggle="tooltip"'
                    + ' title="Agregar">'
                    + '<i class="fa fa-save"></i>&nbsp;&nbsp;Agregar</button>'
                    + '<button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip"'
                    + ' title="Cerrar" onclick="xModal.close();">'
                    + '<i class="fa fa-times"></i>&nbsp;&nbsp;Cerrar</button>'
                );

            })
            .on("click", "#createBodega", null, function () {
                $("#createBodega").attr("disabled", "disabled");

                let formData = $("#formIngresarTalonario").serializeArray();
                let msgError = '';

                if ($.trim($("#fk_bodega_tipo").val()) === "") {
                    msgError += "- " + Base.traduceTexto("Por favor, seleccione un Tipo") + ". <br>";
                }
                if ($.trim($("#fk_region").val()) === "") {
                    msgError += "- " + Base.traduceTexto("Por favor, seleccione un Región") + ". <br>";
                }
                if ($.trim($("#bodega_direccion").val()) === "") {
                    msgError += "- " + Base.traduceTexto("Por favor, ingrese una Dirección") + ". <br>";
                }
                if ($.trim($("#bodega_telefono").val()) === "") {
                    msgError += "- " + Base.traduceTexto("Por favor, ingrese un Teléfono") + ". <br>";
                }

                if (msgError != '') {
                    xModal.warning(msgError, function () {
                        $("#createBodega").removeAttr("disabled");
                    });
                } else {

                    $.ajax({
                        url: Base.getBaseUri() + "Farmacia/Bodegas/AdminBodega/createBodega",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            "form": $("#formAgregarBodega").serializeArray()
                        },
                        success: function (response) {
                            if (response.correcto) {
                                AdminBodega.buscar();
                                xModal.success(response.mensaje, function () {
                                    xModal.close();
                                });
                            } else {
                                xModal.warning(response.mensaje);
                            }
                        }
                    });
                }

            })
            .on("change", "#fk_bodega_tipo", null, function () {
                if (1 === parseInt($("#fk_bodega_tipo :selected").val())) {
                    $("#fk_territorio").attr("disabled", "disabled");
                    $("#fk_territorio").val("");
                    $("#fk_comuna").attr("disabled", "disabled");
                    $("#fk_comuna").val("");

                }
                if (2 === parseInt($("#fk_bodega_tipo :selected").val())) {
                    $("#fk_territorio").removeAttr("disabled");
                    $("#fk_territorio").val("");
                    $("#fk_comuna").attr("disabled", "disabled");
                    $("#fk_comuna").val("");

                }
                if (3 === parseInt($("#fk_bodega_tipo :selected").val())) {
                    $("#fk_comuna").removeAttr("disabled");
                    $("#fk_comuna").val("");
                }

                let bodega_tipo_sigla = $("#fk_bodega_tipo :selected").data("bodegatiposigla");
                if ("" != bodega_tipo_sigla) {
                    $("#bodega_nombre").val($("#fk_bodega_tipo :selected").data("bodegatiposigla"));
                }

            })
            .on("change", "#fk_region", null, function () {

                if ("" != $("#fk_region").val()) {
                    bodega_nombre = $("#fk_region :selected").data("regionnombrecorto");
                    $("#bodega_nombre").val(
                        $("#fk_bodega_tipo :selected").data("bodegatiposigla")
                        + "_"
                        + bodega_nombre
                    );
                }

                if (1 !== parseInt($("#fk_bodega_tipo :selected").val())) {
                    Region.cargarTerritorioPorRegion(this.value, 'fk_territorio', null);
                    $("#fk_comuna").attr("disabled", "disabled");
                    $("#fk_comuna").val("");
                }

            })
            .on("change", "#fk_territorio", null, function () {
                Region.cargarComunasPorTerritorio(this.value, 'fk_comuna', null);

                if ("" != $("#fk_territorio").val()) {
                    bodega_nombre = $("#fk_territorio :selected").text();
                    $("#bodega_nombre").val(
                        $("#fk_bodega_tipo :selected").data("bodegatiposigla")
                        + "_"
                        + bodega_nombre
                    );
                }

                if (3 === parseInt($("#fk_bodega_tipo :selected").val())) {
                    $("#fk_comuna").removeAttr("disabled");
                    $("#fk_comuna").val("");
                }
            })
            .on("change", " #fk_comuna", null, function () {
                let bodega_nombre = "";
                if ("" != $("#fk_comuna").val()) {
                    bodega_nombre = $("#fk_comuna :selected").text();
                }
                $("#bodega_nombre").val(
                    $("#fk_bodega_tipo :selected").data("bodegatiposigla")
                    + "_"
                    + bodega_nombre
                );
            });

    },
    buscar: function () {
        dt_GrillaBodegas.ajax.reload();
    }
}

AdminBodega.init();