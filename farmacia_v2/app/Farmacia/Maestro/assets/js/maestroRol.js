var MaestroRol = {

    limpiarFiltros: function () {
        $("#gl_nombre").val("");
        MaestroRol.buscar();
    },
    buscar: function () {
        var arr  = $("#formBuscar").serializeArray();
        $.ajax({
            dataType	: "json",
            cache		: false,
            async		: true,
            data		: arr,
            type		: "post",
            url			: Base.getBaseUri() + "Farmacia/Maestro/Rol/buscar",
            error		: function(xhr, textStatus, errorThrown){
                xModal.info(Base.traduceTexto("Error al cargar grilla"));
            },
            success		: function(data){
                $("#contenedor-tabla").html(data.grilla);
                //Base.dataTable1("dataTable");
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
    agregarRol: function (form, btn) {

        var e                   = jQuery.Event( "click" );
        var button_process      = buttonStartProcess($(btn), e);
        var arrOpciones         = $('.chkOpciones').serializeArray();
        var gl_nombre_rol       = $('#gl_nombre_rol').val();
        var gl_nombre_vista_rol	= $('#gl_descripcion_rol').val();
        
        form.push({
            "name": 'arr_opcion',
            "value": JSON.stringify(arrOpciones)
        });

        if (gl_nombre_rol == "") {
            xModal.danger(Base.traduceTexto("Nombre de Rol es obligatorio"),function(){buttonEndProcess(button_process);});
        } else if (gl_nombre_vista_rol == "") {
            xModal.danger(Base.traduceTexto("Nombre Vista es obligatorio"),function(){buttonEndProcess(button_process);});
        } else {
            $.ajax({
                dataType	: "json",
                cache		: false,
                async		: true,
                data		: form,
                type		: "post",
                url             : Base.getBaseUri() + "Farmacia/Maestro/Rol/agregarRolBD",
                error		: function(xhr, textStatus, errorThrown){
                    xModal.info(Base.traduceTexto("Error al Ingresar el rol"),function(){buttonEndProcess(button_process);});
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(data.mensaje,function () {
                            location.href = Base.getBaseUri() + "Farmacia/Maestro/Rol";
                            buttonEndProcess(button_process);
                        });
                    } else {
                        xModal.info(data.mensaje,function(){buttonEndProcess(button_process);});
                    }
                }
            });
        }
    },
    editarRol: function (form, btn) {
        var e                   = jQuery.Event( "click" );
        var button_process      = buttonStartProcess($(btn), e);
        var arrOpciones         = [];
        var gl_nombre_rol       = $('#gl_nombre_rol').val();
        var gl_nombre_vista_rol = $('#gl_nombre_vista_rol').val();
        
        $('.contenedorOpcion').each(function(indexOpcion, valueOpcion){
            
            id_opcion           = $(valueOpcion).data("opcion");
            let boOpcion        = $("#"+id_opcion).is(":checked");
            /*let boPermiso_1     = ($("#chk_permisos_1_"+id_opcion).is(":checked"))?"1":"0";
            let boPermiso_2     = ($("#chk_permisos_2_"+id_opcion).is(":checked"))?"1":"0";
            let boPermiso_3     = ($("#chk_permisos_3_"+id_opcion).is(":checked"))?"1":"0";
            let jsonPermiso     = {1:boPermiso_1,2:boPermiso_2,3:boPermiso_3};
            */
            let jsonPermiso2    = {[id_opcion]:{id_opcion}};
            
            if(boOpcion){
                arrOpciones.push(jsonPermiso2);
            }
        });

        form.push({
            "name": 'arr_opcion',
            "value": JSON.stringify(arrOpciones)
        });

        if (gl_nombre_rol == "") {
            xModal.danger(Base.traduceTexto("Nombre de Rol es obligatorio"),function(){buttonEndProcess(button_process);});
        } else if (gl_nombre_vista_rol == "") {
            xModal.danger(Base.traduceTexto("Nombre de Vista es obligatorio"),function(){buttonEndProcess(button_process);});
        } else {
            $.ajax({
                dataType	: "json",
                cache		: false,
                async		: true,
                data		: form,
                type		: "post",
                url             : Base.getBaseUri() + "Farmacia/Maestro/Rol/editarRolBD",
                error		: function(xhr, textStatus, errorThrown){
                    xModal.info(Base.traduceTexto("Error al Editar el Rol"),function(){buttonEndProcess(button_process);});
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(data.mensaje,function () {
                            MaestroRol.buscar();
                            xModal.closeAll();
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
     * @author		: <david.guzman@cosof.cl> - 22/09/2020
     */
    mostrarHijos: function (check) {

        var id_padre = $(check).attr("id");
        if ($(check).is(':checked')) {
            $(".opcion_hijo_" + id_padre).show(400);
        } else {
            $(".opcion_hijo_" + id_padre).hide(400);
        }
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
    },

    setActivo: function(gl_token,bo_activo){
        var txtActivo   = (bo_activo==1)?"Desactivar":"Activar";
        xModal.confirm(Base.traduceTexto("¿Está Seguro de "+txtActivo+" el Rol seleccionado?"), function () {
            //var btnText     = $(btn).prop('disabled', true).html();
            //$(btn).html('<i class="fa fa-spin fa-spinner"></i>');
            $.ajax({
                url: Base.getBaseUri() + "Farmacia/Maestro/Rol/setActivo",
                type: 'post',
                dataType: 'json',
                data: {gl_token:gl_token,bo_activo:bo_activo},
                success: function (response) {
                    if (response.correcto == true) {
                        MaestroRol.buscar();
                        //$(btn).html(btnText).prop('disabled', false);
                    } else {
                        xModal.danger(response.mensaje, function () {
                            //$(btn).html(btnText).prop('disabled', false);
                        });
                    }
                },
                error: function () {
                    xModal.danger(Base.traduceTexto("Error en sistema") + response, function () {
                        //$(btn).html(btnText).prop('disabled', false);
                    });
                }
            });
        });
    }
}

$(document).ready(function () {
    Base.dataTable1("dataTable");
});