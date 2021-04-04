
var AdminUsuario = {
    limpiarFiltros: function () {
        $("#gl_rut_usuario").val("");
        $("#gl_nombres_apellidos").val("");
        $("#fk_region").val("0");
        $("#fk_estado").val("0");
        $("#bo_institucional_1").removeAttr("checked");
        $("#bo_institucional_0").removeAttr("checked");
        $("#fk_roles").val("0");
        $("#fk_profesiones").val("0");

        $("#bo_buscar").val(1);

        AdminUsuario.buscar();
    },
    init: function () {

        // var parametros = $("#formBuscar").serializeArray();
        // var arr = new Array();

        // $.each(parametros, function (index, value) {
        //     arr[value.name] = value.value;
        // });


        grillaInformacionUsuario = $("#grillaInformacionUsuario").DataTable({
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
                "url": "grillaInformacionUsuario",
                "data": function (d) {
                    d.bo_buscar = $("#bo_buscar").val();
                    d.gl_rut_usuario = $("#gl_rut_usuario").val();
                    d.gl_nombres_apellidos = $("#gl_nombres_apellidos").val();
                    d.hola = "hola";
                    d.fk_region = $("#fk_region").val();
                    d.fk_estado = $("#fk_estado").val();
                    d.fk_roles = $("#fk_roles").val();
                    d.fk_profesiones = $("#fk_profesiones").val();
                    d.bo_institucional = $("input[name=bo_institucional] :checked").val();
                },
            },
            columns: [
                // {"data": "token", "class": ""},
                { "data": "rut", "class": "" },
                { "data": "usuario", "class": "" },
                { "data": "region_nombre", "class": "" },
                { "data": "estado", "class": "" },
                // { "data": "institucional", "class": "" },
                { "data": "rol", "class": "" },
                { "data": "profesion", "class": "" },
                { "data": "opciones", "class": "" }
            ]
        });

        $("#formInfoUsuario")
            .on("click", "#buscar", null, function () {

                AdminUsuario.buscar();

                //         var self = $(this);
                //         var rowData = grillaInformacionUsuario.row(self.parents("tr")).data();

                //         xModal.open(Base.getBaseDir() + 'Farmacia/Bodegas/AdminUsuario/verBodega/'
                //             // xModal.open(Base.getBaseDir() + 'Farmacia/Bodegas/AdminUsuario/verBodega/?gl_token='
                //             + rowData.gl_token
                //             + ''
                //             , Base.traduceTexto("Ver Bodega:")
                //             + ' <strong>'
                //             + rowData.bodega_nombre + '</strong>'
                //             , 'lg'
                //             , 'idVerBodega'
                //             , null
                //             , null
                //             , '<button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Cerrar" onclick="xModal.close();"><i class="fa fa-times"></i>&nbsp;&nbsp;Cerrar</button>'
                //         );

            });


        // $("body")
        //     .on("click", "#createBodega", null, function () {
        //         $("#createBodega").attr("disabled", "disabled");

        //         let formData = $("#formIngresarTalonario").serializeArray();
        //         let msgError = '';

        //         if ($.trim($("#fk_bodega_tipo").val()) === "") {
        //             msgError += "- " + Base.traduceTexto("Por favor, seleccione un Tipo") + ". <br>";
        //         }
        //         if ($.trim($("#fk_region").val()) === "") {
        //             msgError += "- " + Base.traduceTexto("Por favor, seleccione un Región") + ". <br>";
        //         }
        //         if ($.trim($("#bodega_direccion").val()) === "") {
        //             msgError += "- " + Base.traduceTexto("Por favor, ingrese una Dirección") + ". <br>";
        //         }
        //         if ($.trim($("#bodega_telefono").val()) === "") {
        //             msgError += "- " + Base.traduceTexto("Por favor, ingrese un Teléfono") + ". <br>";
        //         }

        //         if (msgError != '') {
        //             xModal.warning(msgError, function () {
        //                 $("#createBodega").removeAttr("disabled");
        //             });
        //         } else {

        //             $.ajax({
        //                 url: Base.getBaseUri() + "Farmacia/Bodegas/AdminUsuario/createBodega",
        //                 dataType: 'json',
        //                 type: 'post',
        //                 data: {
        //                     "form": $("#formAgregarBodega").serializeArray()
        //                 },
        //                 success: function (response) {
        //                     if (response.correcto) {
        //                         AdminUsuario.buscar();
        //                         xModal.success(response.mensaje, function () {
        //                             xModal.close();
        //                         });
        //                     } else {
        //                         xModal.warning(response.mensaje);
        //                     }
        //                 }
        //             });
        //         }

        //     });

    },
    buscar: function () {
        $("#bo_buscar").val(1);
        grillaInformacionUsuario.ajax.reload();
    }
}

AdminUsuario.init();