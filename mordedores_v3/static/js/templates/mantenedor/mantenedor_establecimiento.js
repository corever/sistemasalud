
var Mantenedor_establecimiento = {
    buscar: function() {
        var parametros  = $("#formBuscar").serializeArray();
        var arr         = new Array();
        $.each(parametros, function( index, value ) {
            arr[value.name] = value.value;
        });
        /*$.ajax({
            dataType: "html",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: BASE_URI + "index.php/Mantenedor/buscarEstablecimiento",
            success : function(response){
                $("#contenedor-establecimiento").html(response);
                var dataOptions = {
                    pageLength: 10,
                    language: {
                        "url": url_base + "static/js/plugins/DataTables/lang/es.json"
                    },
                    fnDrawCallback: function (oSettings) {
                        $(this).fadeIn("slow");
                    },
                    dom: 'Bflrtip',
                    buttons: 
                        [{
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
                $("#grilla-establecimiento").DataTable(dataOptions);
            }
        });*/
        
        $("#grilla-establecimiento").dataTable({
            "lengthMenu": [5,10, 20, 25, 50, 100],
            "pageLength": 10,
            "destroy" : true,
            "aaSorting": [],
            "deferRender": true,
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
            }],
            ajax: {
                "method": "POST",
                "url": BASE_URI + "index.php/Mantenedor/buscarEstablecimiento",
                "data" : arr,
            },
            columns: [
                    { "data": "establecimiento",    "class": "text-center"},
                    { "data": "dir_establecimiento","class": "text-center"},
                    { "data": "estado",             "class": "text-center"},
                    { "data": "opciones",           "class": "text-center"}
                ]
        });
    },
    agregarEstablecimiento: function (form, btn) {
        var e                       = jQuery.Event( "click" );
        var button_process          = buttonStartProcess($(btn), e);
        var parametros              = $("#formAgregarEstablecimiento").serializeArray();
        var gl_nombre               = $('#gl_nombre').val();
        var tipo_establecimiento    = $('#tipo_establecimiento').val();
        var region                  = $('#region_establecimiento').val();
        var comuna                  = $('#comuna_establecimiento').val();
        var direccion               = $('#gl_direccion').val();
        var servicio_salud          = $('#servicio').val();
        
        if (gl_nombre == "") {
            xModal.danger("Nombre Establecimiento es Obligatorio",function(){buttonEndProcess(button_process);});
        }else if(tipo_establecimiento == 0){
            xModal.danger("Tipo Establecimiento es Obligatorio",function(){buttonEndProcess(button_process);});
        }else if(region == 0){
            xModal.danger("Región es Obligatorio",function(){buttonEndProcess(button_process);});
        }else if(comuna == 0){
            xModal.danger("Comuna es Obligatorio",function(){buttonEndProcess(button_process);});
        }else if(direccion == ""){
            xModal.danger("Dirección es Obligatorio",function(){buttonEndProcess(button_process);});
        }else if(servicio_salud == 0){
            xModal.danger("Servicio Salud es Obligatorio",function(){buttonEndProcess(button_process);});
        }else{
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: parametros,
                type: "post",
                url: BASE_URI + "index.php/Mantenedor/agregarEstablecimientoBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info('Error al Actualizar el Establecimiento.',function(){buttonEndProcess(button_process);});
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(data.mensaje);
                        setTimeout(function () {
                            Mantenedor_establecimiento.buscar();
                            buttonEndProcess(button_process);
                            xModal.closeAll();
                        }, 2000);
                    } else {
                        xModal.info(data.mensaje,function(){buttonEndProcess(button_process);});
                    }
                }
            });
        }
    },
    editarEstablecimiento: function (form, btn) {
        
        var e                       = jQuery.Event( "click" );
        var button_process          = buttonStartProcess($(btn), e);
        var parametros              = $("#formEditarEstablecimiento").serializeArray();
        var gl_nombre               = $('#gl_nombre').val();
        var tipo_establecimiento    = $('#tipo_establecimiento').val();
        var region                  = $('#region_establecimiento').val();
        var comuna                  = $('#comuna_establecimiento').val();
        var direccion               = $('#gl_direccion').val();
        var servicio_salud          = $('#servicio').val();
        
        if (gl_nombre == "") {
            xModal.danger("Nombre Establecimiento es Obligatorio",function(){buttonEndProcess(button_process);});
        }else if(tipo_establecimiento == 0){
            xModal.danger("Tipo Establecimiento es Obligatorio",function(){buttonEndProcess(button_process);});
        }else if(region == 0){
            xModal.danger("Región es Obligatorio",function(){buttonEndProcess(button_process);});
        }else if(comuna == 0){
            xModal.danger("Comuna es Obligatorio",function(){buttonEndProcess(button_process);});
        }else if(direccion == ""){
            xModal.danger("Dirección es Obligatorio",function(){buttonEndProcess(button_process);});
        }else if(servicio_salud == 0){
            xModal.danger("Servicio Salud es Obligatorio",function(){buttonEndProcess(button_process);});
        }else{
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: parametros,
                type: "post",
                url: BASE_URI + "index.php/Mantenedor/editarEstablecimientoBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info('Error al Editar el establecimiento.',function(){buttonEndProcess(button_process);});
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(data.mensaje);
                        setTimeout(function () {
                            Mantenedor_establecimiento.buscar();
                            buttonEndProcess(button_process);
                            xModal.closeAll();
                        }, 2000);
                    } else {
                        xModal.info(data.mensaje,function(){buttonEndProcess(button_process);});
                    }
                }
            });
        }
    }
}