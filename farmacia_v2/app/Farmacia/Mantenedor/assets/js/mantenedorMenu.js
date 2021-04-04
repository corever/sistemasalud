var MantenedorMenu = {

    limpiarFiltros: function () {
        $("#gl_nombre").val("");
        $("#gl_url").val("");
        $("#id_modulo").val("0");
        MantenedorMenu.buscar();
    },
    buscar: function () {
        var arr  = $("#formBuscar").serializeArray();
        $.ajax({
            dataType	: "json",
            cache		: false,
            async		: true,
            data		: arr,
            type		: "post",
            url			: Base.getBaseUri() + "Farmacia/Mantenedor/Menu/buscar",
            error		: function(xhr, textStatus, errorThrown){
                xModal.info(Base.traduceTexto("Error al cargar grilla"));
            },
            success		: function(data){
                $("#contenedor-tabla").html(data.grilla);
                Base.dataTable1("dataTable");
            }
        });
    },

	agregarMenu : function(form,btn){
            var parametros		= $("#formAgregar").serializeArray();
            var gl_nombre		= $('#formAgregar').find('input[name="gl_nombre"]').val();
            var id_padre		= $('#formAgregar').find('input[name="id_padre"]').val();
            var gl_url  		= $('#formAgregar').find('input[name="gl_url"]').val();
            var msgError  		= "";

            if (gl_nombre == ""){
                msgError += "<br>"+Base.traduceTexto("Nombre es Obligatorio");
            }
            if (id_padre > 0 && gl_url == ""){
                msgError += "<br>"+Base.traduceTexto("URL es Obligatorio");
            }
            
            if(msgError != ""){
                xModal.danger(msgError);
            } else {
                $.ajax({
                    dataType	: "json",
                    cache		: false,
                    async		: true,
                    data		: parametros,
                    type		: "post",
                    url			: Base.getBaseUri() + "Farmacia/Mantenedor/Menu/agregarMenuBD",
                    error		: function(xhr, textStatus, errorThrown){
                        xModal.info(Base.traduceTexto("Error al Agregar Opción"));
                    },
                    success		: function(data){
                        if(data.correcto){
                            xModal.success(data.mensaje,function () {
                                location.href = Base.getBaseUri() + "Farmacia/Mantenedor/Menu";
                            });
                        } else {
                            xModal.info(data.mensaje);
                        }
                    }
                });
            }
	},
	editarOpcion : function(form,btn){
            var parametros		= $("#formEditarOpcion").serializeArray();
            var datosBase		= $("#datosBase").serializeArray();
            var gl_nombre		= $('#gl_nombre_opcion').val();

            if (gl_nombre == ""){
                    xModal.danger(Base.traduceTexto("Nombre es Obligatorio"));
            }else if (  parametros[0].value == datosBase[0].value &&
                        parametros[1].value == datosBase[1].value &&
                        parametros[2].value == datosBase[2].value &&
                        parametros[3].value == datosBase[4].value &&
                        parametros[4].value == datosBase[3].value &&
                        parametros[5].value == datosBase[5].value   ) {
                xModal.danger(Base.traduceTexto("No se pueden guardar los mismos datos"));
            }else {
                $.ajax({
                    dataType            : "json",
                    cache		: false,
                    async		: true,
                    data		: parametros,
                    type		: "post",
                    url			: Base.getBaseUri() + "Farmacia/Mantenedor/Menu/editarMenuBD",
                    error		: function(xhr, textStatus, errorThrown){
                        xModal.info(Base.traduceTexto("Error al Editar Opción"));
                    },
                    success		: function(data){
                        if(data.correcto){
                            xModal.success(data.mensaje,function () {
                                location.href = Base.getBaseUri() + "Farmacia/Mantenedor/Menu";
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
