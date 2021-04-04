var SolicitudesDT = {
    limpiarFiltros: function () {
        $("#id_estado").val("");
        $("#gl_tipo").val("");
        $("#fc_desde").val("");
        $("#fc_hasta").val("");
        SolicitudesDT.buscar();
    },
    buscar: function () {
        var parametros  = $("#formBuscar").serializeArray();
        var arr         = new Array();
        $.each(parametros, function (index, value) {
            arr[value.name] = value.value;
        });    
        
        $("#grilla-usuarios").dataTable({
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
                "url": "AdminSolicitudesDT/grillaSolicitudes",
                "data": arr,
            },
            columns: [
                {"data": "solicitud", "class": ""},
                {"data": "fecha", "class": ""},
                {"data": "tipo", "class": ""},
                {"data": "estado", "class": ""},
                {"data": "opciones", "class": ""}
            ]
        });

    },
    aprobarSolicitud :function(form){
        alert("Funcionalidad en desarrollo");
    },
    rechazarSolicitud :function(form){
        alert("Funcionalidad en desarrollo");
    },
    solicitarDocumento :function(form){
        alert("Funcionalidad en desarrollo");
    }
}
  
SolicitudesDT.buscar();