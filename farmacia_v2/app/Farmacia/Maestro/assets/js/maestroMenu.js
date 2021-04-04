var MaestroMenu = {

    limpiarFiltros: function () {
        $("#gl_nombre").val("");
        $("#gl_url").val("");
        $("#id_modulo").val("0");
        MaestroMenu.buscar();
    },
    buscar: function () {
        var arr  = $("#formBuscar").serializeArray();
        $.ajax({
            dataType	: "json",
            cache		: false,
            async		: true,
            data		: arr,
            type		: "post",
            url			: Base.getBaseUri() + "Farmacia/Maestro/Menu/buscar",
            error		: function(xhr, textStatus, errorThrown){
                xModal.info(Base.traduceTexto("Error al cargar grilla"));
            },
            success		: function(data){
                $("#contenedor-tabla").html(data.grilla);
                $("#grilla").dataTable({
					"lengthMenu": [10, 20, 25, 50, 100],
					"pageLength": 10,
					"destroy" : true,
					"aaSorting": [],
					"deferRender": true,
					"language": {
						"url": Base.getBaseDir() + "/pub/js/plugins/DataTables/lang/"+Base.traduceTexto("es.json")
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
				}).show(800);	
            }
        });
    },

	agregarMenu : function(form,btn){
            var params		    = $("#formAgregar").serializeArray();
            var id_modulo		= $('#formAgregar').find('input[name="id_modulo_opcion"]').val();
            var gl_nombre		= $('#formAgregar').find('input[name="gl_nombre_opcion"]').val();
            var gl_url  		= $('#formAgregar').find('input[name="gl_url_opcion"]').val();
            var msgError  		= "";

            if (id_modulo == "0"){
                msgError += "<br>"+Base.traduceTexto("Módulo es Obligatorio");
            }
            if (gl_nombre == ""){
                msgError += "<br>"+Base.traduceTexto("Nombre es Obligatorio");
            }
            if (gl_url == ""){
                msgError += "<br>"+Base.traduceTexto("URL es Obligatorio");
            }
            
            if(msgError != ""){
                xModal.danger(msgError);
            } else {
                $.ajax({
                    dataType	: "json",
                    cache		: false,
                    async		: true,
                    data		: params,
                    type		: "post",
                    url			: Base.getBaseUri() + "Farmacia/Maestro/Menu/agregarMenuBD",
                    error		: function(xhr, textStatus, errorThrown){
                        xModal.info(Base.traduceTexto("Error al Agregar Opción"));
                    },
                    success		: function(data){
                        if(data.correcto){
                            xModal.success(data.mensaje,function () {
                                MaestroMenu.buscar();
                                xModal.closeAll();
                            });
                        } else {
                            xModal.info(data.mensaje);
                        }
                    }
                });
            }
	},
	editarOpcion : function(form,btn){
            var params		    = $("#formEditarOpcion").serializeArray();
            var datosBase		= $("#datosBase").serializeArray();
            var id_modulo		= $('#id_modulo_opcion').val();
            var gl_nombre		= $('#gl_nombre_opcion').val();
            var gl_url		    = $('#gl_url_opcion').val();

            if (id_modulo == "0"){
                    xModal.danger(Base.traduceTexto("Módulo es Obligatorio"));
            }else if(gl_nombre == ""){
                xModal.danger(Base.traduceTexto("Nombre es Obligatorio"));
            }else if(gl_url == ""){
                xModal.danger(Base.traduceTexto("URL es Obligatorio"));
            }else if (  params[0].value == datosBase[0].value &&
                        params[1].value == datosBase[1].value &&
                        params[2].value == datosBase[2].value &&
                        params[3].value == datosBase[4].value &&
                        params[4].value == datosBase[3].value &&
                        params[5].value == datosBase[5].value   ) {
                xModal.danger(Base.traduceTexto("No se pueden guardar los mismos datos"));
            }else {
                $.ajax({
                    dataType    : "json",
                    cache		: false,
                    async		: true,
                    data		: params,
                    type		: "post",
                    url			: Base.getBaseUri() + "Farmacia/Maestro/Menu/editarMenuBD",
                    error		: function(xhr, textStatus, errorThrown){
                        xModal.info(Base.traduceTexto("Error al Editar Opción"));
                    },
                    success		: function(data){
                        if(data.correcto){
                            xModal.success(data.mensaje,function () {
                                MaestroMenu.buscar();
                                xModal.closeAll();
                            });
                        } else {
                            xModal.info(data.mensaje);
                        }
                    }
                });
            }
	}
}

$(document).ready(function() {
    Base.dataTable1("dataTable");
});
