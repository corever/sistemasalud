var MantenedorPerfil = {

    limpiarFiltros: function () {
        $("#gl_nombre").val("");
        MantenedorPerfil.buscar();
    },
    buscar: function () {
        var arr  = $("#formBuscar").serializeArray();
        $.ajax({
            dataType	: "json",
            cache		: false,
            async		: true,
            data		: arr,
            type		: "post",
            url			: Base.getBaseUri() + "Farmacia/Mantenedor/Perfil/buscar",
            error		: function(xhr, textStatus, errorThrown){
                xModal.info(Base.traduceTexto("Error al cargar grilla"));
            },
            success		: function(data){
                $("#contenedor-tabla").html(data.grilla);
                Base.dataTable1("dataTable");
            }
        });
    },
    agregarPerfil: function (form, btn) {

        var e                           = jQuery.Event( "click" );
        var button_process              = buttonStartProcess($(btn), e);
        var arrOpciones			        = $('.chkOpciones').serializeArray();
        var gl_nombre_perfil            = $('#gl_nombre_perfil').val();
        var gl_descripcion		        = $('#gl_descripcion_perfil').val();
        
        form.push({
            "name": 'arr_opcion',
            "value": JSON.stringify(arrOpciones)
        });

        if (gl_nombre_perfil == "") {
            xModal.danger(Base.traduceTexto("Nombre de Perfil es obligatorio"),function(){buttonEndProcess(button_process);});
        } else if (gl_descripcion == "") {
            xModal.danger(Base.traduceTexto("Descripción es obligatorio"),function(){buttonEndProcess(button_process);});
        } else {
            $.ajax({
                dataType	: "json",
                cache		: false,
                async		: true,
                data		: form,
                type		: "post",
                url             : Base.getBaseUri() + "Farmacia/Mantenedor/Perfil/agregarPerfilBD",
                error		: function(xhr, textStatus, errorThrown){
                    xModal.info(Base.traduceTexto("Error al Ingresar el perfil"),function(){buttonEndProcess(button_process);});
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(data.mensaje,function () {
                            location.href = Base.getBaseUri() + "Farmacia/Mantenedor/Perfil";
                            buttonEndProcess(button_process);
                        });
                    } else {
                        xModal.info(data.mensaje,function(){buttonEndProcess(button_process);});
                    }
                }
            });
        }
    },
    editarPerfil: function (form, btn) {
        var e                   = jQuery.Event( "click" );
        var button_process      = buttonStartProcess($(btn), e);
        var arrOpciones         = [];
        var gl_nombre_perfil    = $('#gl_nombre_perfil').val();
        var gl_descripcion      = $('#gl_descripcion').val();
        
        $('.contenedorOpcion').each(function(indexOpcion, valueOpcion){
            
            id_opcion           = $(valueOpcion).data("opcion");
            let boOpcion        = $("#"+id_opcion).is(":checked");
            let boPermiso_1     = ($("#chk_permisos_1_"+id_opcion).is(":checked"))?"1":"0";
            let boPermiso_2     = ($("#chk_permisos_2_"+id_opcion).is(":checked"))?"1":"0";
            let boPermiso_3     = ($("#chk_permisos_3_"+id_opcion).is(":checked"))?"1":"0";
            let jsonPermiso     = {1:boPermiso_1,2:boPermiso_2,3:boPermiso_3};
            let jsonPermiso2    = {[id_opcion]:{1:boPermiso_1,2:boPermiso_2,3:boPermiso_3}};
            
            if(boOpcion){
                arrOpciones.push(jsonPermiso2);
            }
        });

        form.push({
            "name": 'arr_opcion',
            "value": JSON.stringify(arrOpciones)
        });

        if (gl_nombre_perfil == "") {
            xModal.danger(Base.traduceTexto("Nombre de Perfil es obligatorio"),function(){buttonEndProcess(button_process);});
        } else if (gl_descripcion == "") {
            xModal.danger(Base.traduceTexto("Descripción es obligatorio"),function(){buttonEndProcess(button_process);});
        } else {
            $.ajax({
                dataType	: "json",
                cache		: false,
                async		: true,
                data		: form,
                type		: "post",
                url             : Base.getBaseUri() + "Farmacia/Mantenedor/Perfil/editarPerfilBD",
                error		: function(xhr, textStatus, errorThrown){
                    xModal.info(Base.traduceTexto("Error al Editar el Perfil"),function(){buttonEndProcess(button_process);});
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(data.mensaje,function () {
                            location.href = Base.getBaseUri() + "Farmacia/Mantenedor/Perfil";
                            buttonEndProcess(button_process);
                        });
                    } else {
                        xModal.info(data.mensaje,function(){buttonEndProcess(button_process);});
                    }
                }
            });
        }
    },
    /**
     * Descripción	: Muestra/Oculta hijos; Cuando se ocultan los hijos, a su vez los deselecciona
     * @author		: <sebastian.Carroza@cosof.cl> - 23/07/2019
     */
    mostrarHijos: function (check) {

        var id_padre = $(check).attr("id");
        if ($(check).is(':checked')) {
            $(".opcion_hijo_" + id_padre).show(400);
        } else {
            $(".opcion_hijo_" + id_padre).hide(400);
        }

        /*
        var id_padre = $(check).attr("id");
        if ($(check).is(':checked')) {
            $("#opcion_hijo_" + id_padre).show();
        } else {
            $("#opcion_hijo_" + id_padre).hide();

            var hijos_largo = $("#opcion_hijo_" + id_padre + " input").length;
            for (var i = 1; i <= hijos_largo; i++) {
                id_padre++;
                $('#' + id_padre).attr('checked', false);
            }
        }
        */
    },
    
    seleccionaTodo : function () {
        $('.chkOpciones').prop("checked","checked");
    },
    
    deseleccionaTodo : function () {
        $('.chkOpciones').prop("checked","");
    },
    
    mostrarMenuByModulo : function (id_modulo) {
        $('.contenedorOpcion').hide();
        $('.contenedorOpcion[data-modulo='+id_modulo+']').show();

        let gl_color = $("#btnModulo"+id_modulo).data("color");
        $(".btnModulo").prop("class","btnModulo btn btn-xs");
        $("#btnModulo"+id_modulo).prop("class","btnModulo btn btn-xs "+gl_color);
    },

    mostrarPermisos: function(check) {
        var id_opcion = $(check).attr("id");
        if ($(check).is(':checked')) {
            $("#chk_permisos_1_" + id_opcion).prop("disabled",false);
            $("#chk_permisos_2_" + id_opcion).prop("disabled",false);
            $("#chk_permisos_3_" + id_opcion).prop("disabled",false);
        } else {
            $("#chk_permisos_1_" + id_opcion).prop("checked",false).prop("disabled",true);
            $("#chk_permisos_2_" + id_opcion).prop("checked",false).prop("disabled",true);
            $("#chk_permisos_3_" + id_opcion).prop("checked",false).prop("disabled",true);
        }
    }
}

$(document).ready(function () {
    Base.dataTable1("dataTable");
});