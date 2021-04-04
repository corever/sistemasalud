var MantenedorMedico = {
    limpiarFiltros: function () {
        $("#id_pais").val("0");
        $("#id_perfil").val("0");
        $("#bo_activo").val("-1");
        $("#gl_nombre").val("");
        $("#gl_email").val("");
        MantenedorMedico.buscar();
    },
    buscar: function () {
        var parametros  = $("#formBuscar").serializeArray();
        var arr         = new Array();
        $.each(parametros, function (index, value) {
            arr[value.name] = value.value;
        });

        $("#grilla-medicos").dataTable({
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
                "url": "Medico/grillaMedico",
                "data": arr,
            },
            columns: [
                {"data": "rut", "class": ""},
                {"data": "nombre", "class": ""},
                {"data": "email", "class": ""},
                {"data": "telefono", "class": ""},
                {"data": "genero", "class": ""},
                {"data": "direccion", "class": ""},
                {"data": "opciones", "class": ""}
            ]
        });

        //btnExcelGrilla();
    },
    editarMedico: function (form, btn) {
        var e               = jQuery.Event("click");
        var button_process  = buttonStartProcess($(btn), e);
        var msgError        = "";

        if ($.trim($("#gl_rut_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Rut es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_nombre_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Nombre es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_paterno_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Paterno es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_materno_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Materno es Obligatorio")+". <br>";
        }
        if ($("#id_profesion_medico").val() == "0") {
            //msgError += "- "+Base.traduceTexto("Profesión es Obligatorio")+". <br>";
        }
        if ($("#id_especialidad_medico").val() == "0") {
            //msgError += "- "+Base.traduceTexto("Profesión es Obligatorio")+". <br>";
        }
        if ($("input[name='chk_genero_medico']:checked").val() === undefined) {
            msgError += "- "+Base.traduceTexto("Género es Obligatorio")+". <br>";
        }
        if ($.trim($("#fc_nacimiento_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Fecha Nacimiento es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_email_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Email es Obligatorio")+". <br>";
        }
        if ($("#gl_email_medico").parent().hasClass("has-error")) {
            msgError += "- "+Base.traduceTexto("Email es Inválido")+". <br>";
        }
        if ($("#id_region_medico").val() == "0") {
            msgError += "- "+Base.traduceTexto("Región es Obligatorio")+". <br>";
        }
        if ($("#id_comuna_medico").val() == "0") {
            msgError += "- "+Base.traduceTexto("Comuna es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_direccion_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Dirección es Obligatorio")+". <br>";
        }
        if ($("#id_codregion_medico").val() == "0") {
            msgError += "- "+Base.traduceTexto("Código Teléfono es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_telefono_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Teléfono es Obligatorio")+". <br>";
        }

        if (msgError != "") {
            xModal.danger(msgError, function () {
                buttonEndProcess(button_process);
            });
        } else {
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: form,
                type: "post",
                url: Base.getBaseUri() + "Farmacia/Mantenedor/Medico/editarMedicoBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error al Actualizar"), function () {
                        buttonEndProcess(button_process);
                    });
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(Base.traduceTexto("Actualizado con Éxito"),function () {
                            MantenedorMedico.buscar();
                            xModal.closeAll();
                            buttonEndProcess(button_process);
                        });
                    } else {
                        xModal.info(Base.traduceTexto("Error al Actualizar"), function () {
                            buttonEndProcess(button_process);
                        });
                    }
                }
            });
        }
        btn.disabled = false;
    },
    agregarMedico: function (form, btn) {
        var e               = jQuery.Event("click");
        var button_process  = buttonStartProcess($(btn), e);
        var msgError        = "";

        if ($.trim($("#gl_rut_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Rut es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_nombre_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Nombre es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_paterno_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Paterno es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_materno_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Materno es Obligatorio")+". <br>";
        }
        if ($("#id_profesion_medico").val() == "0") {
            //msgError += "- "+Base.traduceTexto("Profesión es Obligatorio")+". <br>";
        }
        if ($("#id_especialidad_medico").val() == "0") {
            //msgError += "- "+Base.traduceTexto("Profesión es Obligatorio")+". <br>";
        }
        if ($("input[name='chk_genero_medico']:checked").val() === undefined) {
            msgError += "- "+Base.traduceTexto("Género es Obligatorio")+". <br>";
        }
        if ($.trim($("#fc_nacimiento_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Fecha Nacimiento es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_email_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Email es Obligatorio")+". <br>";
        }
        if ($("#gl_email_medico").parent().hasClass("has-error")) {
            msgError += "- "+Base.traduceTexto("Email es Inválido")+". <br>";
        }
        if ($("#id_region_medico").val() == "0") {
            msgError += "- "+Base.traduceTexto("Región es Obligatorio")+". <br>";
        }
        if ($("#id_comuna_medico").val() == "0") {
            msgError += "- "+Base.traduceTexto("Comuna es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_direccion_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Dirección es Obligatorio")+". <br>";
        }
        if ($("#id_codregion_medico").val() == "0") {
            msgError += "- "+Base.traduceTexto("Código Teléfono es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_telefono_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Teléfono es Obligatorio")+". <br>";
        }
        if ($("#id_region_consulta").val() == "0") {
            msgError += "- "+Base.traduceTexto("Región de Consulta es Obligatorio")+". <br>";
        }
        if ($("#id_comuna_consulta").val() == "0") {
            msgError += "- "+Base.traduceTexto("Comuna de Consulta es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_direccion_consulta").val()) == "") {
            msgError += "- "+Base.traduceTexto("Dirección de Consulta es Obligatorio")+". <br>";
        }
        if ($("#id_codregion_consulta").val() == "0") {
            msgError += "- "+Base.traduceTexto("Código Teléfono de Consulta es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_telefono_consulta").val()) == "") {
            msgError += "- "+Base.traduceTexto("Teléfono de Consulta es Obligatorio")+". <br>";
        }

        if (msgError != "") {
            xModal.danger(msgError, function () {
                buttonEndProcess(button_process);
            });
        } else {
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: form,
                type: "post",
                url: Base.getBaseUri() + "Farmacia/Mantenedor/Medico/agregarMedicoBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error en el ingreso"), function () {
                        buttonEndProcess(button_process);
                    });
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(Base.traduceTexto("Ingresado con Éxito"),function () {
                            MantenedorMedico.buscar();
                            xModal.closeAll();
                            buttonEndProcess(button_process);
                        });
                    } else {
                        xModal.info(data.msgError, function () {
                            buttonEndProcess(button_process);
                        });
                    }
                }
            });
        }
        btn.disabled = false;
    },

    cambioChk: function (check) {
        $(".chk_principal").parent().removeClass("label-success");
        $(".chk_principal").parent().addClass("label-danger");
        $(check).parent().removeClass("label-danger");
        $(check).parent().addClass("label-success");
    },

    cancelarSecundario: function () {
        $("#btn_guarda_secundario").attr("disabled", false);
        $("#btn_nuevo_secundario").show();
        $("#div_nuevo_secundario").hide();
        $("#id_perfil_secundario").val("");
        //$("#id_region_secundaria option:eq(0)").prop('selected', true);
        $("#id_oficina_secundario option:eq(0)").prop('selected', true);
        $("#id_comuna_secundaria option:eq(0)").prop('selected', true);
        $("#id_establecimiento_secundario option:eq(0)").prop('selected', true);
        $("#id_rol_secundario").attr("disabled", false);
        $("#id_region_secundaria").attr("disabled", false);
        $("#id_oficina_secundario").attr("disabled", false);
    },

    eliminaPerfil: function (btn, id) {
        xModal.confirm(Base.traduceTexto("¿Está Seguro de Eliminar el Perfil seleccionado?"), function () {
            var gl_token    = $("#gl_token_medico").val();
            var btnText     = $(btn).prop('disabled', true).html();
            $(btn).html('<i class="fa fa-spin fa-spinner"></i>');
            $.ajax({
                url: Base.getBaseUri() + "Farmacia/Mantenedor/Usuario/eliminaPerfilUsuario",
                type: 'post',
                dataType: 'json',
                data: {id: id},
                success: function (response) {
                    if (response.correcto == true) {
                        MantenedorUsuario.grillaPerfilesUsuario(gl_token);
                        $(btn).html(btnText).prop('disabled', false);
                    } else {
                        xModal.danger(response.mensaje, function () {
                            $(btn).html(btnText).prop('disabled', false);
                        });
                    }
                },
                error: function () {
                    xModal.danger(Base.traduceTexto("Error en sistema") + response, function () {
                        $(btn).html(btnText).prop('disabled', false);
                    });
                }
            });
        });
    },
    grillaPerfilesMedico: function (gl_token) {
        $.ajax({
            data: {gl_token: gl_token},
            url: Base.getBaseUri() + "Farmacia/Mantenedor/Medico/grillaPerfilesMedico",
            dataType: 'html',
            type: 'post',
            success: function (response) {
                $("#contenedor-grilla-perfiles").html(response);
            }
        });
    },

    seleccionaTodo: function () {
        $('.chkOpciones:enabled').prop("checked", "checked");
    },

    deseleccionaTodo: function () {
        $('.chkOpciones:enabled').prop("checked", "");
    },

    editarPerfiles: function () {
        alert("En proceso!");
    },

    initTablaHistorial: function () {


        var aoColumns = [
            {"sClass": "center", "sType": "date-euro"},
            {"sClass": "center"},
            {"sClass": "center"},
            {"sClass": "center"},
        ];
        //var columnDefs = [{ 'targets': 0, type: 'date-euro' }];
        Base.dataTable2('grilla-perfiles-usuario', null, aoColumns);

    },
    habilitarMedico: function (gl_token,bo_activo) {
        var texto = (bo_activo == 0)?"des":"";
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: {gl_token:gl_token,bo_activo:bo_activo},
            type: "post",
            url: Base.getBaseUri() + "Farmacia/Mantenedor/Medico/habilitarMedico",
            error: function (xhr, textStatus, errorThrown) {
                xModal.info(Base.traduceTexto("Error al "+texto+"habilitar medico"));
            },
            success: function (data) {
                if (data.correcto) {
                    xModal.success(Base.traduceTexto("El medico se ha "+texto+"habilitado"),function () {
                        MantenedorMedico.buscar();
                        xModal.closeAll();
                    });
                } else {
                    xModal.info(Base.traduceTexto("Error al "+texto+"habilitar medico"));
                }
            }
        });
    },
    habilitarSucursal: function (gl_token,bo_activo) {
        var texto = (bo_activo == 0)?"des":"";
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: {gl_token:gl_token,bo_activo:bo_activo},
            type: "post",
            url: Base.getBaseUri() + "Farmacia/Mantenedor/Medico/habilitarSucursal",
            error: function (xhr, textStatus, errorThrown) {
                xModal.info(Base.traduceTexto("Error al "+texto+"habilitar consulta"));
            },
            success: function (data) {
                if (data.correcto) {
                    xModal.success(Base.traduceTexto("La consulta se ha "+texto+"habilitado"),function () {
                        MantenedorMedico.buscar();
                        xModal.closeAll();
                    });
                } else {
                    xModal.info(Base.traduceTexto("Error al "+texto+"habilitar consulta"));
                }
            }
        });
    },

    seleccionarModulo: function (modulo) {
        var id_modulo = $(modulo).data("id_modulo");

        if($(modulo).is(":checked")){
            $('#div_modulo_color_'+id_modulo).removeClass("default");
            $('#div_modulo_color_'+id_modulo).addClass($('#div_modulo_color_'+id_modulo).data("color"));
            $('#label_modulo_'+id_modulo).html(Base.traduceTexto("Seleccionado"));
        }else{
            $('#div_modulo_color_'+id_modulo).addClass("default");
            $('#div_modulo_color_'+id_modulo).removeClass($('#div_modulo_color_'+id_modulo).data("color"));
            $('#label_modulo_'+id_modulo).html(Base.traduceTexto("Seleccionar"));
        }

    },
    seleccionBoNacional: function (input) {
        let boPerfilNacional        = $(input).is(":checked");
        let id_modulo               = $("#id_modulo_seleccionado").val();
        arrBoNacional[id_modulo]    = boPerfilNacional;
    },
    seleccionPerfiles: function (select) {

        let perfiles            = $(select).val();
        let id_modulo           = $("#id_modulo_seleccionado").val();
        let id_opcion           = 0;
        let txt_personalizado   = $("#id_perfil_usuario > option[value=99]").text();

        arrPerfilUsuario[id_modulo] = perfiles;

        $(".chkOpciones").prop("checked",false);
        $(".chkPermisos").prop("checked",false).prop("disabled",true);

        if($.inArray('99',perfiles) > -1){
            $(".select2-selection__choice[title!='"+txt_personalizado+"']").remove();
            $("#id_perfil_usuario > option[value!=99]").prop("selected",false);

            $('.contenedorOpcion[data-modulo='+id_modulo+']').each(function(indexOpcion, valueOpcion){

                id_opcion   = $(valueOpcion).data("opcion");
                $(".opcion_hijo_"+id_opcion).hide();

                if(arrPermisoUsuario[id_modulo] && arrPermisoUsuario[id_modulo][id_opcion]){
                    $("#"+id_opcion).prop("checked",true);
                    $(".opcion_hijo_"+id_opcion).show();
                    $("#chk_permisos_1_"+id_opcion).prop("checked",(arrPermisoUsuario[id_modulo][id_opcion][1] == 1)?true:false).prop("disabled",false);
                    $("#chk_permisos_2_"+id_opcion).prop("checked",(arrPermisoUsuario[id_modulo][id_opcion][2] == 1)?true:false).prop("disabled",false);
                    $("#chk_permisos_3_"+id_opcion).prop("checked",(arrPermisoUsuario[id_modulo][id_opcion][3] == 1)?true:false).prop("disabled",false);
                }

            });

        }else{

            $(".select2-selection__choice[title='"+txt_personalizado+"']").remove();
            $("#id_perfil_usuario > option[value=99]").prop("selected",false);

            $('.contenedorOpcion[data-modulo='+id_modulo+']').each(function(indexOpcion, valueOpcion){

                id_opcion   = $(valueOpcion).data("opcion");
                $(".opcion_hijo_"+id_opcion).hide();
                $.each(perfiles,function(indexPerfil, valuePerfil){
                    //Actualizar selecciones menu
                    if(arrPerfilOpcion[id_modulo] && arrPerfilOpcion[id_modulo][valuePerfil]){
                        if(arrPerfilOpcion[id_modulo][valuePerfil]['opciones'][id_opcion]){
                            $("#"+id_opcion).prop("checked",true);
                            $(".opcion_hijo_"+id_opcion).show();
                            $("#chk_permisos_1_"+id_opcion).prop("checked",(arrPerfilOpcion[id_modulo][valuePerfil]['opciones'][id_opcion][1] == 1)?true:false).prop("disabled",false);
                            $("#chk_permisos_2_"+id_opcion).prop("checked",(arrPerfilOpcion[id_modulo][valuePerfil]['opciones'][id_opcion][2] == 1)?true:false).prop("disabled",false);
                            $("#chk_permisos_3_"+id_opcion).prop("checked",(arrPerfilOpcion[id_modulo][valuePerfil]['opciones'][id_opcion][3] == 1)?true:false).prop("disabled",false);
                        }
                    }
                });
            });

        }
    },
    editarOpcionesModulo: function (id_modulo,nombre_modulo,color_modulo) {

        $("#id_modulo_seleccionado").val(id_modulo);
        $(".btnModuloEditar").prop('disabled', false);
        $("#btnModuloEditar"+id_modulo).prop('disabled', true);
        $("#nombreModuloEditar").html("Módulo "+nombre_modulo);
        $("#moduloEditar").removeClass();
        $("#moduloEditar").addClass("card card-default "+color_modulo);

        //Actualizar opciones
        $('.contenedorOpcion').hide();
        $('.contenedorOpcion[data-modulo='+id_modulo+']').show();

        //Actualizar select2 perfil
        $("#id_perfil_usuario > option").prop("selected","");
        $.each(arrPerfilUsuario[id_modulo],function( index, value ) {
            $("#id_perfil_usuario > option[value="+value+"]").prop("selected","selected");
        });

        $("#id_perfil_usuario").trigger("change");

        //Actualizar check Nacional
        if(arrBoNacional[id_modulo]){
            $("#bo_nacional").prop("checked","checked");
        }else{
            $("#bo_nacional").prop("checked","");
        }
    },
    editarModulo: function (gl_token,bo_activo) {
        var arr     = $("#formModulo").serializeArray();

        arr.push({
            name:   "arrPermisoUsuario",
            value:  JSON.stringify(arrPermisoUsuario)
        });
        arr.push({
            name:   "arrPerfilOpcion",
            value:  JSON.stringify(arrPerfilOpcion)
        });
        arr.push({
            name:   "arrPerfilUsuario",
            value:  JSON.stringify(arrPerfilUsuario)
        });
        arr.push({
            name:   "arrBoNacional",
            value:  JSON.stringify(arrBoNacional)
        });

        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: arr,
            type: "post",
            url: Base.getBaseUri() + "Farmacia/Mantenedor/Usuario/editarModuloBD",
            error: function (xhr, textStatus, errorThrown) {
                xModal.info(Base.traduceTexto("Error al editar"));
            },
            success: function (data) {
                if (data.correcto) {
                    xModal.success(Base.traduceTexto("Editado con éxito"),function () {
                        MantenedorUsuario.buscar();
                        xModal.closeAll();
                    });
                } else {
                    xModal.info(Base.traduceTexto("Error al editar"));
                }
            }
        });
    },

    cargarActividad : function(){

        let dataIn = new FormData();
        dataIn.append('id', 1);

		$.ajax({
			processData : false,
			cache       : false,
			async       : true,
			type        : 'post',
			dataType    : 'text',
			data        : dataIn,
			contentType : false,
			url: Base.getBaseUri() + "Farmacia/Mantenedor/Usuario/cargarGrillaActividad",
			error: function(xhr, textStatus, errorThrown){
				alert("Error");
			},
			success: function (response) {
				$("#dvGrillaActividad").html(response);
				$("#grillaActividad").dataTable({
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
    mostrarMedico: function (form, btn) {
        var e               = jQuery.Event("click");
        var button_process  = buttonStartProcess($(btn), e);
        var msgError        = "";

        if ($.trim($("#gl_rut_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Rut es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_nombre_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Nombre es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_paterno_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Paterno es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_materno_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Materno es Obligatorio")+". <br>";
        }
        if ($("#id_profesion_medico").val() == "0") {
            //msgError += "- "+Base.traduceTexto("Profesión es Obligatorio")+". <br>";
        }
        if ($("#id_especialidad_medico").val() == "0") {
            //msgError += "- "+Base.traduceTexto("Profesión es Obligatorio")+". <br>";
        }
        if ($("input[name='chk_genero_medico']:checked").val() === undefined) {
            msgError += "- "+Base.traduceTexto("Género es Obligatorio")+". <br>";
        }
        if ($.trim($("#fc_nacimiento_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Fecha Nacimiento es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_email_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Email es Obligatorio")+". <br>";
        }
        if ($("#gl_email_medico").parent().hasClass("has-error")) {
            msgError += "- "+Base.traduceTexto("Email es Inválido")+". <br>";
        }
        if ($("#id_region_medico").val() == "0") {
            msgError += "- "+Base.traduceTexto("Región es Obligatorio")+". <br>";
        }
        if ($("#id_comuna_medico").val() == "0") {
            msgError += "- "+Base.traduceTexto("Comuna es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_direccion_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Dirección es Obligatorio")+". <br>";
        }
        if ($("#id_codregion_medico").val() == "0") {
            msgError += "- "+Base.traduceTexto("Código Teléfono es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_telefono_medico").val()) == "") {
            msgError += "- "+Base.traduceTexto("Teléfono es Obligatorio")+". <br>";
        }

        if (msgError != "") {
            xModal.danger(msgError, function () {
                buttonEndProcess(button_process);
            });
        } else {
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: form,
                type: "post",
                url: Base.getBaseUri() + "Farmacia/Mantenedor/Medico/editarMedicoBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error al Actualizar"), function () {
                        buttonEndProcess(button_process);
                    });
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(Base.traduceTexto("Actualizado con Éxito"),function () {
                            MantenedorMedico.buscar();
                            xModal.closeAll();
                            buttonEndProcess(button_process);
                        });
                    } else {
                        xModal.info(Base.traduceTexto("Error al Actualizar"), function () {
                            buttonEndProcess(button_process);
                        });
                    }
                }
            });
        }
        btn.disabled = false;
    },
	agregarSucursal: function (form, btn) {
        var e               = jQuery.Event("click");
        var button_process  = buttonStartProcess($(btn), e);
        var msgError        = "";

        if ($("#id_region_consulta").val() == "0") {
            msgError += "- "+Base.traduceTexto("Región de Consulta es Obligatorio")+". <br>";
        }
        if ($("#id_comuna_consulta").val() == "0") {
            msgError += "- "+Base.traduceTexto("Comuna de Consulta es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_direccion_consulta").val()) == "") {
            msgError += "- "+Base.traduceTexto("Dirección de Consulta es Obligatorio")+". <br>";
        }
        if ($("#id_codregion_consulta").val() == "0") {
            msgError += "- "+Base.traduceTexto("Código Teléfono de Consulta es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_telefono_consulta").val()) == "") {
            msgError += "- "+Base.traduceTexto("Teléfono de Consulta es Obligatorio")+". <br>";
        }

        if (msgError != "") {
            xModal.danger(msgError, function () {
                buttonEndProcess(button_process);
            });
        } else {
            $.ajax({
                dataType: "json",
                cpublic function editarMedico($gl_token){

			$arrUsuario     = $this->_DAOMedico->getByTokenMedico($gl_token);
			$arrProfesion   = $this->_DAOProfesion->getListaOrdenada();
			$arrEspecialidad = $this->_DAOEspecialidad->getListaOrdenada();
			$arrRegion      = $this->_DAORegion->getLista();
			$arrComuna      = $this->_DAOComuna->getLista();
			$arrCodRegion   = $this->_DAOCodigoRegion->getLista();

	$this->view->addJS('$("#fc_nacimiento_medico").datepicker({language:"es", format: "dd/mm/yyyy", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
	$this->view->addJS('$(".labelauty").labelauty();');
	$this->view->set('arrProfesion', $arrProfesion);
	$this->view->set('arrEspecialidad', $arrEspecialidad);
	$this->view->set('arrRegion', $arrRegion);
	$this->view->set('arrComuna', $arrComuna);
	$this->view->set('arrCodRegion', $arrCodRegion);
	$this->view->set('arr', $arrUsuario);
	$this->view->set('boEditar', 1);
	$this->view->set('gl_token', 1);

	$this->view->set('datosMedico',   $this->view->fetchIt('medico/actualizar_medico'));
			$this->view->render('medico/agregar_medico.php');

}

/**
* Descripción : Guardar Datos Editados de Medico
* @author Felipe Bocaz <felipe.bocaz@cosof.cl> - 05/08/2020
*/
public function editarMedicoBD(){

	$params         = $this->request->getParametros();
	$correcto       = false;
	$error          = false;
			$gl_rut         = trim($params['gl_rut_medico']);
			$gl_email       = trim($params['gl_email_medico']);
			$idMedico      = (isset($_SESSION[\Constantes::SESSION_BASE]['id']))?$_SESSION[\Constantes::SESSION_BASE]['id']:0;
			$msgError       = "";
			$arrMedico     = $this->_DAOMedico->getByTokenMedico($params['gl_token_medico']);

			if ($gl_rut == "") {
					$msgError .= "- Rut es Obligatorio. <br>";
			}
			if (!\Validar::validarRutPersona($gl_rut)) {
					$msgError .= "- Rut es Incorrecto. <br>";
			}
			if ($gl_email == "") {
					$msgError .= "- Email es Obligatorio. <br>";
			}
			if (!\Email::validar_email($gl_email)) {
					$msgError .= "- Email es Incorrecto. <br>";
			}
			if (trim($params['gl_nombre_medico']) == "") {
					$msgError .= "- Nombre es Obligatorio. <br>";
			}
			if (trim($params['gl_apellido_paterno_medico']) == "") {
					$msgError .= "- Apellido Paterno es Obligatorio. <br>";
			}
			if (trim($params['gl_apellido_materno_medico']) == "") {
					$msgError .= "- Apellido Materno es Obligatorio. <br>";
			}
			if ($params['id_profesion_medico'] == 0) {
					//$msgError .= "- Profesión es Obligatorio. <br>";
			}
			if ($params['id_especialidad_medico'] == 0) {
					//$msgError .= "- Profesión es Obligatorio. <br>";
			}
			if (!isset($params['chk_genero_medico'])) {
					$msgError .= "- Género es Obligatorio. <br>";
			}
			if (trim($params['fc_nacimiento_medico']) == "") {
					$msgError .= "- Fecha Nacimiento es Obligatorio. <br>";
			}
			if ($params['id_region_medico'] == 0) {
					$msgError .= "- Región es Obligatorio. <br>";
			}
			if ($params['id_comuna_medico'] == 0) {
					$msgError .= "- Comuna es Obligatorio. <br>";
			}
			if (trim($params['gl_direccion_medico']) == "") {
					$msgError .= "- Dirección es Obligatorio. <br>";
			}

			if ($msgError == "") {

					$datosMedico   = array(
																	trim($params['gl_nombre_medico']),
																	trim($params['gl_apellido_paterno_medico']),
																	trim($params['gl_apellido_materno_medico']),
																	//intval($params['id_profesion_usuario']),
																	($params['chk_genero_medico']=="M")?"Masculino":"Femenino",
																	(!empty($params['fc_nacimiento_medico']))?\Fechas::formatearBaseDatosSinComilla($params['fc_nacimiento_medico']):"0000-00-00 00:00:00",
																	$gl_email,
																	$params['id_region_medico'],
																	$params['id_comuna_medico'],
																	$params['gl_direccion_medico'],
																	$params['id_codregion_medico'],
																	$params['gl_telefono_medico']
					);

					$correcto       = $this->_DAOMedico->modificarMedico($params['gl_token_medico'],$datosMedico);

					if($correcto){
							$arr_tag        = array("[TAG_NOMBRE_CREADOR]");
							$arr_replace    = array($_SESSION[\Constantes::SESSION_BASE]['gl_nombre_completo']);
					}
			}else{
					$error      = true;
					$msgError   = "Hubo un problema al guardar. Favor Comunicarse con Mesa de Ayuda.";
			}

	$json			= array("correcto" => $correcto, "error" => $error);

			echo json_encode($json);
}ache: false,
                async: true,
                data: form,
                type: "post",
                url: Base.getBaseUri() + "Farmacia/Mantenedor/Medico/agregarSucursalBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error en el ingreso"), function () {
                        buttonEndProcess(button_process);
                    });
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(Base.traduceTexto("Ingresado con Éxito"),function () {
                            MantenedorMedico.buscar();
                            xModal.closeAll();
                            buttonEndProcess(button_process);
                        });
                    } else {
                        xModal.info(data.msgError, function () {
                            buttonEndProcess(button_process);
                        });
                    }
                }
            });
        }
        btn.disabled = false;
    },


    cambioCheckPermiso :function(boPermiso,checkOpcion,id_opcion_check){

        let id_modulo           = $("#id_modulo_seleccionado").val();
        let check_1             = ($("#chk_permisos_1_"+id_opcion_check).is(":checked"))?"1":"0";
        let check_2             = ($("#chk_permisos_2_"+id_opcion_check).is(":checked"))?"1":"0";
        let check_3             = ($("#chk_permisos_3_"+id_opcion_check).is(":checked"))?"1":"0";
        let json                = {1:check_1,2:check_2,3:check_3};
        let json2               = {[id_opcion_check]:{1:check_1,2:check_2,3:check_3}};
        let jsonAux             = {};
        let txt_personalizado   = $("#id_perfil_usuario > option[value=99]").text();

        //Actualizo opciones
        $('.contenedorOpcion[data-modulo='+id_modulo+']').each(function(indexOpcion, valueOpcion){

            id_opcion   = $(valueOpcion).data("opcion");
            $(".opcion_hijo_"+id_opcion).hide();

            let boOpcion        = $("#"+id_opcion).is(":checked");
            let boPermiso_1     = ($("#chk_permisos_1_"+id_opcion).is(":checked"))?"1":"0";
            let boPermiso_2     = ($("#chk_permisos_2_"+id_opcion).is(":checked"))?"1":"0";
            let boPermiso_3     = ($("#chk_permisos_3_"+id_opcion).is(":checked"))?"1":"0";
            let jsonPermiso     = {1:boPermiso_1,2:boPermiso_2,3:boPermiso_3};
            let jsonPermiso2    = {[id_opcion]:{1:boPermiso_1,2:boPermiso_2,3:boPermiso_3}};

            if(boOpcion){
                if(arrPermisoUsuario[id_modulo]){
                    arrPermisoUsuario[id_modulo][id_opcion] = jsonPermiso;
                }else{
                    arrPermisoUsuario[id_modulo] = jsonPermiso2;
                }
            }else{
                if(arrPermisoUsuario[id_modulo]){
                    jsonAux = {};
                    $.each(arrPermisoUsuario[id_modulo],function(key,value){
                        if(key != id_opcion){
                            jsonAux[key] = value;
                        }
                    });
                    arrPermisoUsuario[id_modulo] = jsonAux;
                }
            }

        });

        //seleccionar perfil _Personalizado
        $("#id_perfil_usuario > option[value!=99]").prop("selected",false);
        $("#id_perfil_usuario > option[value=99]").prop("selected",true);
        $("#id_perfil_usuario").trigger("change");

    }

};

$("#btnCambioUsuario").livequery(function () {
    btn = this;
    $(btn).click(function (e) {
        btn.disabled = true;
        var btnTexto = $(btn).html();
        $(btn).html('Cambiando...');

        var parametros = $("#formCambioUsuario").serialize();
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: Base.getBaseUri() + "Mantenedor/procesarCambio",
            error: function (xhr, textStatus, errorThrown) {
                xModal.info(Base.traduceTexto("Error al Cambiar de Usuario"));
            },
            success: function (data) {
                if (data.correcto) {
                    xModal.success(Base.traduceTexto("Se procederá con el Cambio de Usuario"),function () {
                        location.href = Base.getBaseUri()+"Farmacia/Home/MisSistemas";
                    });
                } else {
                    xModal.info(data.mensaje);
                }
            }
        });

        $(btn).html(btnTexto).attr('disabled', false);
    });

});

$("#chk_ver_password").on('click', function (e) {
    if ($("#chk_ver_password").is(':checked')) {
        $("#gl_password").prop('type', 'text');
    } else {
        $("#gl_password").prop('type', 'password');
    }
});

function mostrarHijos(check) {
    var id_padre = $(check).attr("id");
    if ($(check).is(':checked')) {
        $(".opcion_hijo_" + id_padre).show(400);
    } else {
        $(".opcion_hijo_" + id_padre).hide(400);
    }
}

function mostrarPermisos(check) {
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

MantenedorMedico.buscar();
