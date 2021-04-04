var MantenedorUsuario = {
    limpiarFiltros: function () {
        $("#id_pais").val("0");
        $("#id_perfil").val("0");
        $("#bo_activo").val("-1");
        $("#gl_nombre").val("");
        $("#gl_email").val("");
        MantenedorUsuario.buscar();
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
                "url": "Usuario/grillaUsuarios",
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
    editarUsuario: function (form, btn) {
        var e               = jQuery.Event("click");
        var button_process  = buttonStartProcess($(btn), e);
        var msgError        = "";
        
        if ($.trim($("#gl_rut_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Rut es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_nombre_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Nombre es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_paterno_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Paterno es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_materno_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Materno es Obligatorio")+". <br>";
        }
        if ($("#id_profesion_usuario").val() == "0") {
            //msgError += "- "+Base.traduceTexto("Profesión es Obligatorio")+". <br>";
        }
        if ($("input[name='chk_genero_usuario']:checked").val() === undefined) {
            msgError += "- "+Base.traduceTexto("Género es Obligatorio")+". <br>";
        }
        if ($.trim($("#fc_nacimiento_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Fecha Nacimiento es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_email_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Email es Obligatorio")+". <br>";
        }
        if ($("#gl_email_usuario").parent().hasClass("has-error")) {
            msgError += "- "+Base.traduceTexto("Email es Inválido")+". <br>";
        }
        if ($("#id_region_usuario").val() == "0") {
            msgError += "- "+Base.traduceTexto("Región es Obligatorio")+". <br>";
        }
        if ($("#id_comuna_usuario").val() == "0") {
            msgError += "- "+Base.traduceTexto("Comuna es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_direccion_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Dirección es Obligatorio")+". <br>";
        }
        if ($("#id_codregion_usuario").val() == "0") {
            msgError += "- "+Base.traduceTexto("Código Teléfono es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_telefono_usuario").val()) == "") {
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
                url: Base.getBaseUri() + "Farmacia/Maestro/Usuario/editarUsuarioBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error al Actualizar"), function () {
                        buttonEndProcess(button_process);
                    });
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(Base.traduceTexto("Actualizado con Éxito"),function () {
                            MantenedorUsuario.buscar();
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
    agregarUsuario: function (form, btn) {
        var e               = jQuery.Event("click");
        var button_process  = buttonStartProcess($(btn), e);
        var msgError        = "";

        if ($.trim($("#gl_rut_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Rut es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_nombre_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Nombre es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_paterno_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Paterno es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_apellido_materno_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Apellido Materno es Obligatorio")+". <br>";
        }
        if ($("#id_profesion_usuario").val() == "0") {
            //msgError += "- "+Base.traduceTexto("Profesión es Obligatorio")+". <br>";
        }
        if ($("input[name='chk_genero_usuario']:checked").val() === undefined) {
            msgError += "- "+Base.traduceTexto("Género es Obligatorio")+". <br>";
        }
        if ($.trim($("#fc_nacimiento_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Fecha Nacimiento es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_email_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Email es Obligatorio")+". <br>";
        }
        if ($("#gl_email_usuario").parent().hasClass("has-error")) {
            msgError += "- "+Base.traduceTexto("Email es Inválido")+". <br>";
        }
        if ($("#id_region_usuario").val() == "0") {
            msgError += "- "+Base.traduceTexto("Región es Obligatorio")+". <br>";
        }
        if ($("#id_comuna_usuario").val() == "0") {
            msgError += "- "+Base.traduceTexto("Comuna es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_direccion_usuario").val()) == "") {
            msgError += "- "+Base.traduceTexto("Dirección es Obligatorio")+". <br>";
        }
        if ($("#id_codregion_usuario").val() == "0") {
            msgError += "- "+Base.traduceTexto("Código Teléfono es Obligatorio")+". <br>";
        }
        if ($.trim($("#gl_telefono_usuario").val()) == "") {
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
                url: Base.getBaseUri() + "Farmacia/Maestro/Usuario/agregarUsuarioBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error en el ingreso"), function () {
                        buttonEndProcess(button_process);
                    });
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(Base.traduceTexto("Ingresado con Éxito"),function () {
                            MantenedorUsuario.buscar();
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
    cancelarAgregaRol: function () {
        $('#agregarRolDiv').hide(200);
        $('#btnNuevoRol').show(200);
        $('#contenedor-grilla-roles').show(200);
    },
    nuevoRol: function () {
        if($('#agregarRolDiv').is(':visible')){
            $('#agregarRolDiv').hide(200);
            $('#contenedor-grilla-roles').show(200);
        }else{
            $('#agregarRolDiv').show(200);
            $('#btnNuevoRol').hide(200);
            $('#contenedor-grilla-roles').hide(200);
        }
        //$("#panel_perfiles").show();
        //$("#panel_heading_perfiles").text("Agregar Perfil");
        //setTimeout(function(){$('#id_centro_salud_secundario').select2();},200);
    },
    resetAgregarRol: function(verificarRol=0){
        $('#div_region_usuario').hide(200);
        $('#div_territorio_usuario').hide(200);
        $('#div_local_venta_usuario').hide(200);
        $('#div_profesiones').hide(200);
        $('#div_local_farmaceutico').hide(200);
        $('#div_fecha_inicio_termino').hide(200);
        $('#div_empresa_farmaceutica_usuario').hide(200);
        
        if(verificarRol == 1){
            if($("input[name='chk_institucional']:checked").val() == 1){
                if($("#id_rol_institucional_usuario").val() > 0){
                    $("#id_rol_institucional_usuario").val("0");
                }
            }
            if($("input[name='chk_institucional']:checked").val() == 2){
                if($("#id_rol_no_institucional_usuario").val() > 0){
                    $("#id_rol_no_institucional_usuario").val("0");
                }
            }
        }
    },
    cambioRol: function (inputRol) {

        MantenedorUsuario.resetAgregarRol();

        // Roles con sus id
        // (9) Administrador de Maestro, (11) Encargado Nacional, (2) Encargado Regional
        // (3) Encargado Territorial   , (5) Vendedor Talonario,  (12) Secretaría Regional
        // (14) Coordinador Farmacia Nacional, (15) Coordinador Farmacia Regional, (4) Director Técnico
        // (6) Químico Recepcionante, (10) Médico, (13) Secretaría Territorial

        //MOSTRAR REGION PARA SIGUIENTES CASOS
        if($(inputRol).val() == 9 || $(inputRol).val() == 2 || $(inputRol).val() == 3 || $(inputRol).val() == 15 ||
            $(inputRol).val() == 5 || $(inputRol).val() == 12 || $(inputRol).val() == 13){
            $('#div_region_usuario').show(200);
        }
        //MOSTRAR TERRITORIO SEGUN CORRESPONDE
        if($(inputRol).val() == 3 || $(inputRol).val() == 13 || $(inputRol).val() == 5){
            $('#div_territorio_usuario').show(200);
        }
        //MOSTRAR LOCAL DE VENTA
        if($(inputRol).val() == 5){
            $('#div_local_venta_usuario').show(200);
        }
        //MOSTRAR PROFESIONES, LOCAL FARMACEUTICO Y FECHAS INICIO Y TERMINO
        if($(inputRol).val() == 4 || $(inputRol).val() == 6){
            $('#div_profesiones').show(200);
            $('#div_local_farmaceutico').show(200);
            if($(inputRol).val() == 4){
                $('#div_fecha_inicio_termino').show(200);
            }
        }
        //MOSTRAR EMPRESA FARMACEUTICA
        if($(inputRol).val() == 14 || $(inputRol).val() == 15){
            $('#div_empresa_farmaceutica_usuario').show(200);
        }
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
    guardarRol: function (form, btn) {
        var e                   = jQuery.Event("click");
        var button_process      = buttonStartProcess($(btn), e);
        var msgError            = "";
        var gl_token            = $("#gl_token_usuario").val();
        let chk_institucional   = $("input[name='chk_institucional']:checked").val();

        if(chk_institucional === undefined){
            msgError += "- "+Base.traduceTexto("Seleccione Rol Institucional o No Institucional")+". <br>";
        }else if ((chk_institucional == 1 && $("#id_rol_institucional_usuario").val() == "0") ||
            (chk_institucional == 2 && $("#id_rol_no_institucional_usuario").val() == "0")) {
            msgError += "- "+Base.traduceTexto("Rol es Obligatorio")+". <br>";
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
                url: Base.getBaseUri() + "Farmacia/Maestro/Usuario/agregarRolUsuarioBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error en el ingreso"), function () {
                        buttonEndProcess(button_process);
                    });
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(Base.traduceTexto("Guardado con Éxito"),function () {
                            $('#agregarRolDiv').hide(200);
                            $('#btnNuevoRol').show(200);
                            $('#contenedor-grilla-roles').show(200);
                            MantenedorUsuario.grillaRolesUsuario(gl_token);
                            //setTimeout(function(){xModal.close();},400);
                            buttonEndProcess(button_process);
                        });
                    } else {
                        xModal.info(data.mensaje, function () {
                            buttonEndProcess(button_process);
                        });
                    }
                }
            });
        }
        btn.disabled = false;
    },
    eliminaRol: function (btn, id) {
        xModal.confirm(Base.traduceTexto("¿Está Seguro de Eliminar el Rol seleccionado?"), function () {
            var gl_token    = $("#gl_token_usuario").val();
            var btnText     = $(btn).prop('disabled', true).html();
            $(btn).html('<i class="fa fa-spin fa-spinner"></i>');
            $.ajax({
                url: Base.getBaseUri() + "Farmacia/Maestro/Usuario/eliminaRolUsuario",
                type: 'post',
                dataType: 'json',
                data: {id: id},
                success: function (response) {
                    if (response.correcto == true) {
                        MantenedorUsuario.grillaRolesUsuario(gl_token);
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
    grillaRolesUsuario: function (gl_token) {
        $.ajax({
            data: {gl_token: gl_token},
            url: Base.getBaseUri() + "Farmacia/Maestro/Usuario/grillaRolesUsuario",
            dataType: 'html',
            type: 'post',
            success: function (response) {
                $("#grilla-roles-usuario").html(response);
            }
        });
    },
    editarMenu: function (form, btn) {
        var e = jQuery.Event("click");
        var button_process = buttonStartProcess($(btn), e);
        var msgError = "";
        var arrOpciones = $('.chkOpciones').serializeArray();

        form.push({
            "name": 'arr_opcion',
            "value": JSON.stringify(arrOpciones)
        });

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
                url: Base.getBaseUri() + "Mantenedor/Usuario/editarMenuBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error al Actualizar"), function () {
                        buttonEndProcess(button_process);
                    });
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(Base.traduceTexto("Guardado con Éxito"), function () {
                            //MantenedorUsuario.buscar();
                            xModal.closeAll();
                            buttonEndProcess(button_process);
                        });
                    } else {
                        xModal.info(data.mensaje, function () {
                            buttonEndProcess(button_process);
                        });
                    }
                }
            });
        }
        btn.disabled = false;
    },
    cambioPerfil: function (rol, region, oficina, establecimiento, comuna, servicio) {
        var bo_nacional = $("#" + rol.id).children(":selected").attr("nacional");
        var bo_regional = $("#" + rol.id).children(":selected").attr("regional");
        var bo_comunal = $("#" + rol.id).children(":selected").attr("comunal");
        //var bo_oficina     = $("#"+rol.id).children(":selected").attr("oficina");

        if (bo_nacional == 1) {
            $("#" + region).append('<option value="0">-- Todas --</option>');
            $("#" + region).val(0);
            $("#" + region).attr("disabled", true);
            $("#" + oficina).append('<option value="0">-- Todas --</option>');
            $("#" + oficina).val(0);
            $("#" + oficina).attr("disabled", true);
            $("#" + establecimiento).append('<option value="0">-- Todas --</option>');
            $("#" + establecimiento).val(0);
            $("#" + establecimiento).attr("disabled", true);
        } else {
            $("#" + region).val("");
            $("#" + region).attr("disabled", false);
            if (bo_regional == 1) {
                $("#" + region + " option[value='0']").remove();
                $("#" + oficina).append('<option value="0">-- Todas --</option>');
                $("#" + oficina).val(0);
                $("#" + oficina).attr("disabled", true);
                $("#" + establecimiento).append('<option value="0">-- Todas --</option>');
                $("#" + establecimiento).val(0);
                $("#" + establecimiento).attr("disabled", true);
            } else {
                $("#" + oficina).val("");
                $("#" + oficina).attr("disabled", false);
                $("#" + establecimiento).val("");
                $("#" + establecimiento).attr("disabled", false);
                $("#" + region + " option[value='0']").remove();
                $("#" + oficina + " option[value='0']").remove();
                $("#" + establecimiento + " option[value='0']").remove();
            }
            $("#" + region + " option:eq(0)").prop("selected", true);

            if (rol.value == 3) { //SI ES ESTABLECIMIENTO = SE MUESTRA ESTABLECIMIENTO PARA SELECCIONAR
                $("#div_comuna_perfil").show();
                $("#div_oficina_perfil").hide();
                $("#div_establecimiento_perfil").show();
                $("#" + establecimiento).attr("disabled", false);
            } else { //SI NO ES ESTABLECIMIENTO = SE ESCONDE ESTABLECIMIENTO
                $("#div_comuna_perfil").hide();
                $("#div_oficina_perfil").show();
                $("#div_establecimiento_perfil").hide();
                $("#" + establecimiento).val(0);

                if (rol.value == 15) { //SI ES ENCARGADO SERVICIO
                    $("#div_oficina_perfil").hide();
                    $("#div_servicio_perfil").show();
                    $("#" + servicio).val(0);
                }
            }

            if (rol.value == 13) { //SI ES ENCARGADO_COMUNAL = SE MUESTRA COMUNA
                $("#div_comuna_perfil").show();
            }
        }

        $("#" + region).trigger("change");
    },

    cambiarUsuario: function (gl_token) {
        if (gl_token != "") {
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: {gl_token: gl_token},
                type: "post",
                url: Base.getBaseUri() + "Farmacia/Usuario/Login/cambioUsuario",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.info(Base.traduceTexto("Error al Cambiar de Usuario"));
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(Base.traduceTexto("Se procederá con el Cambio de Usuario"),function () {
                            location.href = Base.getBaseUri() + 'Farmacia/Home/Dashboard';
                        });
                    } else {
                        xModal.info(data.mensaje);
                    }
                }
            });
        }
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
    habilitarUsuario: function (gl_token,bo_activo) {
        var texto = (bo_activo == 0)?"des":"";
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: {gl_token:gl_token,bo_activo:bo_activo},
            type: "post",
            url: Base.getBaseUri() + "Farmacia/Maestro/Usuario/habilitarUsuario",
            error: function (xhr, textStatus, errorThrown) {
                xModal.info(Base.traduceTexto("Error al "+texto+"habilitar usuario"));
            },
            success: function (data) {
                if (data.correcto) {
                    xModal.success(Base.traduceTexto("El usuario se ha "+texto+"habilitado"),function () {
                        MantenedorUsuario.buscar();
                        xModal.closeAll();
                    });
                } else {
                    xModal.info(Base.traduceTexto("Error al "+texto+"habilitar usuario"));
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
			url: Base.getBaseUri() + "Farmacia/Maestro/Usuario/cargarGrillaActividad",
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
};

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

//MantenedorUsuario.buscar();