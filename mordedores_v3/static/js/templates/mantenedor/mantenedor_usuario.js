
var Mantenedor_usuario = {
    buscar: function() {
        var parametros = $("#formBuscar").serializeArray();
        var arr = new Array();
        $.each(parametros, function( index, value ) {
            arr[value.name] = value.value;
        });
        /*$.ajax({
            dataType: "html",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: BASE_URI + "index.php/Mantenedor/buscarUsuario",
            success : function(response){
                $("#contenedor-tabla-usuario").html(response);
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
                $("#grilla").DataTable(dataOptions);
            }
        });*/
        
        $("#grilla").dataTable({
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
                "url": BASE_URI + "index.php/Mantenedor/buscarUsuario",
                "data" : arr,
            },
            columns: [
                    { "data": "rut",        "class": "text-center"},
                    { "data": "nombre",     "class": "text-center"},
                    { "data": "email",      "class": "text-center"},
                    { "data": "estado",     "class": "text-center"},
                    { "data": "opciones",   "class": "text-center"}
                ]
        });
    },
	editarUsuario : function(form,btn){
		var e                   = jQuery.Event( "click" );
        var button_process      = buttonStartProcess($(btn), e);
        var parametros          = $(form).serializeArray();
		if($("#gl_nombres").val()==''){
			parametros.push({
			"name": 'gl_nombres',
			"value": 'NULL'
			});
		} else {
			parametros.push({
				"name": 'gl_nombres',
				"value": "'"+$("#gl_nombres").val()+"'"
			});
		}
		if($("#gl_apellidos").val()==''){
			parametros.push({
			"name": 'gl_apellidos',
			"value": 'NULL'
			});
		} else {
			parametros.push({
				"name": 'gl_apellidos',
				"value": "'"+$("#gl_apellidos").val()+"'"
			});
		}
		if($("#gl_email").val()==''){
			parametros.push({
			"name": 'gl_email',
			"value": 'NULL'
			});
		} else {
			parametros.push({
				"name": 'gl_email',
				"value": "'"+$("#gl_email").val()+"'"
			});
		}
		if($("#region").val()==0){
			parametros.push({
			"name": 'region',
			"value": 'NULL'
			});
		} else {
			parametros.push({
				"name": 'region',
				"value": $("#region").val()
			});
		}
		if($("#comuna").val()==0){
			parametros.push({
			"name": 'comuna',
			"value": 'NULL'
			});
		} else {
			parametros.push({
				"name": 'comuna',
				"value": $("#comuna").val()
			});
		}
		if($("#id_centro_salud").val()==0){
			parametros.push({
			"name": 'id_centro_salud',
			"value": 'NULL'
			});
		} else {
			parametros.push({
				"name": 'id_centro_salud',
				"value": $("#id_centro_salud").val()
			});
		}
		if($("#bo_estado").val()==0){
			parametros.push({
			"name": 'bo_estado',
			"value": 0
			});
		} else {
			parametros.push({
				"name": 'bo_estado',
				"value": 1
			});
		}
		if($('input[name=chk_principal]:checked').val()>0){
			parametros.push({
			"name": 'id_principal',
			"value": $('input[name=chk_principal]:checked').val()
			});
		}
        var id_principal    = $('input[name=chk_principal]:checked').val();
		if (id_principal == "" || id_principal == undefined){xModal.danger("- Debe seleccionar un Perfil Principal<br>",function(){buttonEndProcess(button_process);});
        }else {
			$.ajax({
				dataType	: "json",
				cache		: false,
				async		: true,
				data		: parametros,
				type		: "post",
				url			: BASE_URI + "index.php/Mantenedor/editarUsuarioBD", 
				error		: function(xhr, textStatus, errorThrown){
								xModal.info('Error al Actualizar el usuario.',function(){buttonEndProcess(button_process);});
				},
				success		: function(data){
								if(data.correcto){
									xModal.success("Usuario Actualizado con Éxito!");
									setTimeout(function () {
										//location.href = BASE_URI + "index.php/Mantenedor/usuario";
                                        Mantenedor_usuario.buscar();
                                        xModal.closeAll();
                                        buttonEndProcess(button_process);
									}, 2000);
								} else {
									xModal.info('Error al Actualizar el usuario.',function(){buttonEndProcess(button_process);});
								}
				}
			}); 
		}
		btn.disabled	= false;
	},
	agregarUsuario : function(form,btn){
		var e                   = jQuery.Event( "click" );
        var button_process      = buttonStartProcess($(btn), e);
        var gl_rut              = $("#gl_rut").val();
        var gl_nombres          = $("#gl_nombres").val();
        var gl_apellidos        = $("#gl_apellidos").val();
        var gl_email            = $("#gl_email").val();
        //var id_region           = $("#id_region").val();
        var id_perfil           = $("#id_perfil_usuario").val();
        var id_region_perfil    = $("#id_region_perfil").val();
        var id_oficina          = $("#id_oficina_perfil").val();
        var id_comuna           = $("#id_comuna_perfil").val();
        var id_establecimiento  = $("#id_establecimiento_perfil").val();
        var id_servicio         = $("#id_servicio_perfil").val();
        var bo_cambio_usuario   = $("#bo_cambio_usuario").val();
        var bo_informar_web     = $("#bo_informar_web").val();

		if      (gl_rut == "")      {xModal.danger("El Campo Rut/Pasaporte es Obligatorio",function(){buttonEndProcess(button_process);});}
		else if (gl_nombres == "")  {xModal.danger("El Campo Nombres es Obligatorio",function(){buttonEndProcess(button_process);});}
		else if (gl_email == "")    {xModal.danger("El Campo Email es Obligatorio",function(){buttonEndProcess(button_process);});}
		//else if (id_region == 0)    {xModal.danger("El Campo Región es Obligatorio",function(){buttonEndProcess(button_process);});}
		else if (id_perfil == 0)    {xModal.danger("El Campo Perfil",function(){buttonEndProcess(button_process);});
        }else if ((id_perfil == 2 || id_perfil == 3 || id_perfil == 4 || id_perfil == 5 || id_perfil == 6 || id_perfil == 10 || id_perfil == 12 || id_perfil == 14) && id_region_perfil == 0){
            xModal.danger("El Campo Región es Obligatorio para este perfil",function(){buttonEndProcess(button_process);});
        }else if ((id_perfil == 3 || id_perfil == 4) && id_establecimiento == 0){
            xModal.danger("El Campo Establecimiento es obligatorio para este perfil",function(){buttonEndProcess(button_process);});
        }else if ((id_perfil == 15) && id_servicio == 0){
            xModal.danger("El Campo Servicio Salud es obligatorio para este perfil", function(){$(btn).html(btnText).prop('disabled', false);});
        }else if ((id_perfil == 10 || id_perfil == 12 || id_perfil == 6 || id_perfil == 14) && id_oficina == 0){
            xModal.danger("El Campo Oficina es obligatorio para este perfil",function(){buttonEndProcess(button_process);});
        }else if ((id_perfil == 13) && id_comuna == 0){
            xModal.danger("El Campo Comuna es obligatorio para este perfil",function(){buttonEndProcess(button_process);});
        }else{
			$.ajax({
				dataType	: "json",
				cache		: false,
				async		: true,
				data		: {gl_rut:gl_rut,gl_nombres:gl_nombres,gl_apellidos:gl_apellidos,gl_email:gl_email,bo_cambio_usuario:bo_cambio_usuario,bo_informar_web:bo_informar_web,
                                id_perfil:id_perfil,id_region_perfil:id_region_perfil,id_oficina:id_oficina,id_comuna:id_comuna,id_establecimiento:id_establecimiento,id_servicio:id_servicio},
				type		: "post",
				url			: BASE_URI + "index.php/Mantenedor/agregarUsuarioBD", 
				error		: function(xhr, textStatus, errorThrown){
								xModal.info('Error al Ingresar Usuario.',function(){buttonEndProcess(button_process);});
				},
				success		: function(data){
								if(data.correcto){
									xModal.success("Usuario Ingresado con Éxito!");
									setTimeout(function () {
										//location.href = BASE_URI + "index.php/Mantenedor/usuario";
                                        Mantenedor_usuario.buscar();
                                        xModal.closeAll();
                                        buttonEndProcess(button_process);
									}, 2000);
								} else {
									xModal.info('Error al Ingresar Usuario.',function(){buttonEndProcess(button_process);});
								}
				}
			});
		}
		btn.disabled		= false;
	},
    cambioChk : function(check){
        $(".chk_principal").parent().removeClass("label-success");
        $(".chk_principal").parent().addClass("label-danger");
        $(check).parent().removeClass("label-danger");
        $(check).parent().addClass("label-success");
    },
    nuevoPerfil: function(){
        $("#btn_nuevo_secundario").hide();
        $("#div_nuevo_secundario").show();
        //setTimeout(function(){$('#id_centro_salud_secundario').select2();},200);
    },
    cancelarSecundario : function(){
        $("#btn_guarda_secundario").attr("disabled",false);
        $("#btn_nuevo_secundario").show();
        $("#div_nuevo_secundario").hide();
        $("#id_perfil_secundario").val("");
        //$("#id_region_secundaria option:eq(0)").prop('selected', true);
        $("#id_oficina_secundario option:eq(0)").prop('selected', true);
        $("#id_comuna_secundaria option:eq(0)").prop('selected', true);
        $("#id_establecimiento_secundario option:eq(0)").prop('selected', true);
        $("#id_rol_secundario").attr("disabled",false);
        $("#id_region_secundaria").attr("disabled",false);
        $("#id_oficina_secundario").attr("disabled",false);
    },
    guardaPerfilUsuario : function(btn){
        var gl_token            = $("#gl_token").val();
        var id_perfil           = $("#id_perfil_secundario").val();
        var id_region           = $("#id_region_secundaria").val();
        var id_oficina          = $("#id_oficina_secundario").val();
        var id_comuna           = $("#id_comuna_secundaria").val();
        var id_establecimiento  = $("#id_establecimiento_secundario").val();
        var id_servicio         = $("#id_servicio_secundario").val();
        var id_ambito           = $("#id_ambito_secundario").val();
        var btnText             = $(btn).prop('disabled',true).html();
        $(btn).html('Guardando... <i class="fa fa-spin fa-spinner"></i>');
        if(id_perfil == 0){
            xModal.danger("Debe seleccionar un perfil", function(){$(btn).html(btnText).prop('disabled', false);});
        }else if ((id_perfil == 2 || id_perfil == 3 || id_perfil == 4 || id_perfil == 5 || id_perfil == 6 || id_perfil == 10 || id_perfil == 12 || id_perfil == 14) && id_region == 0){
            xModal.danger("El Campo Región es Obligatorio para este perfil", function(){$(btn).html(btnText).prop('disabled', false);});
        }else if ((id_perfil == 3 || id_perfil == 4) && id_establecimiento == 0){
            xModal.danger("El Campo Establecimiento es obligatorio para este perfil", function(){$(btn).html(btnText).prop('disabled', false);});
        }else if ((id_perfil == 15) && id_servicio == 0){
            xModal.danger("El Campo Servicio Salud es obligatorio para este perfil", function(){$(btn).html(btnText).prop('disabled', false);});
        }else if ((id_perfil == 10 || id_perfil == 12 || id_perfil == 6 || id_perfil == 14) && id_oficina == 0){
            xModal.danger("El Campo Oficina es obligatorio para este perfil", function(){$(btn).html(btnText).prop('disabled', false);});
        }else if ((id_perfil == 13) && id_comuna == 0){
            xModal.danger("El Campo Comuna es obligatorio para este perfil", function(){$(btn).html(btnText).prop('disabled', false);});
        }else{
            $.ajax({
                url : BASE_URI + "index.php/Mantenedor/guardaPerfilUsuario",
                type : 'post',
                dataType : 'json',
                data : {gl_token:gl_token,id_perfil:id_perfil,id_region:id_region,id_oficina:id_oficina,id_comuna:id_comuna,
                        id_establecimiento:id_establecimiento,id_servicio:id_servicio,id_ambito:id_ambito},
                success : function(response){
                    if(response.correcto == true){
                        Mantenedor_usuario.cancelarSecundario();
                        Mantenedor_usuario.grillaPerfilesUsuario(gl_token);
                        $(btn).html(btnText).prop('disabled', false);
                    }else{
                        xModal.danger(response.mensaje, function(){
                            $(btn).html(btnText).prop('disabled', false);
                        });
                    }
                },
                error : function(){
                    xModal.danger('Error en sistema. Intente nuevamente o comuníquese con Soporte --> ' + response, function(){
                        $(btn).html(btnText).prop('disabled', false);
                    });
                }
            });
        }
    },
    deleteRol : function(btn,id){
        xModal.confirm('¿Está Seguro de que desea Eliminar el Perfil seleccionado?',function(){
            var gl_token      = $("#gl_token").val();
            var btnText         = $(btn).prop('disabled',true).html();
            $(btn).html('<i class="fa fa-spin fa-spinner"></i>');
            $.ajax({
                url : BASE_URI + "index.php/Mantenedor/eliminaPerfilUsuario",
                type : 'post',
                dataType : 'json',
                data : {gl_token:gl_token,id:id},
                success : function(response){
                    if(response.correcto == true){
                        Mantenedor_usuario.grillaPerfilesUsuario(gl_token);
                        $(btn).html(btnText).prop('disabled', false);
                    }else{
                        xModal.danger(response.mensaje, function(){
                            $(btn).html(btnText).prop('disabled', false);
                        });
                    }
                },
                error : function(){
                    xModal.danger('Error en sistema. Intente nuevamente o comuníquese con Soporte --> ' + response, function(){
                        $(btn).html(btnText).prop('disabled', false);
                    });
                }
            });
        });
    },
    grillaPerfilesUsuario : function(id){
        $.ajax({
            data : {gl_token:id},
            url : BASE_URI + "index.php/Mantenedor/grillaPerfilesUsuario",
            dataType : 'html',
            type : 'post',
            success : function(response){
                $("#contenedor-grilla-perfiles").html(response);
            }
        });
    },
    cambioPerfil : function(rol,region,oficina,establecimiento,comuna,servicio){
        var bo_nacional = $("#"+rol.id).children(":selected").attr("nacional");
        var bo_regional = $("#"+rol.id).children(":selected").attr("regional");
        var bo_comunal  = $("#"+rol.id).children(":selected").attr("comunal");
        //var bo_oficina     = $("#"+rol.id).children(":selected").attr("oficina");
        
        if(bo_nacional == 1){
            $("#"+region).append('<option value="0">-- Todas --</option>');
            $("#"+region).val(0);
            $("#"+region).attr("disabled",true);
            $("#"+oficina).append('<option value="0">-- Todas --</option>');
            $("#"+oficina).val(0);
            $("#"+oficina).attr("disabled",true);
            $("#"+establecimiento).append('<option value="0">-- Todas --</option>');
            $("#"+establecimiento).val(0);
            $("#"+establecimiento).attr("disabled",true);
        }else{
            $("#"+region).val("");
            $("#"+region).attr("disabled",false);
            if(bo_regional == 1){
                $("#"+region+" option[value='0']").remove();
                $("#"+oficina).append('<option value="0">-- Todas --</option>');
                $("#"+oficina).val(0);
                $("#"+oficina).attr("disabled",true);
                $("#"+establecimiento).append('<option value="0">-- Todas --</option>');
                $("#"+establecimiento).val(0);
                $("#"+establecimiento).attr("disabled",true);
            }else{
                $("#"+oficina).val("");
                $("#"+oficina).attr("disabled",false);
                $("#"+establecimiento).val("");
                $("#"+establecimiento).attr("disabled",false);
                $("#"+region+" option[value='0']").remove();
                $("#"+oficina+" option[value='0']").remove();
                $("#"+establecimiento+" option[value='0']").remove();
            }
            $("#"+region+" option:eq(0)").prop("selected", true);
            
            if(rol.value == 3){ //SI ES ESTABLECIMIENTO = SE MUESTRA ESTABLECIMIENTO PARA SELECCIONAR
                $("#div_comuna_perfil").show();
                $("#div_oficina_perfil").hide();
                $("#div_establecimiento_perfil").show();
                $("#"+establecimiento).attr("disabled",false);
            }else{ //SI NO ES ESTABLECIMIENTO = SE ESCONDE ESTABLECIMIENTO
                $("#div_comuna_perfil").hide();
                $("#div_oficina_perfil").show();
                $("#div_establecimiento_perfil").hide();
                $("#"+establecimiento).val(0);
                
                if(rol.value == 15){ //SI ES ENCARGADO SERVICIO
                    $("#div_oficina_perfil").hide();
                    $("#div_servicio_perfil").show();
                    $("#"+servicio).val(0);
                }
            }
            
            if(rol.value == 13){ //SI ES ENCARGADO_COMUNAL = SE MUESTRA COMUNA
                $("#div_comuna_perfil").show();
            }
        }
        
        $("#"+region).trigger("change");
    },

}

	$("#btnCambioUsuario").livequery(function(){
		btn	= this;
        $(btn).click(function(e){
			btn.disabled = true;
			var btnTexto = $(btn).html();
			$(btn).html('Cambiando...');

			var parametros = $("#formCambioUsuario").serialize();
			$.ajax({
				dataType	: "json",
				cache		: false,
				async		: true,
				data		: parametros,
				type		: "post",
				url			: BASE_URI + "index.php/Mantenedor/procesarCambio", 
				error		: function(xhr, textStatus, errorThrown){
								xModal.info('Error al cambiar de usuario.');
				},
				success		: function(data){
								if(data.correcto){
									xModal.success('Se procederá con el Cambio de Usuario');
									setTimeout(function () {
										location.href = BASE_URI;
									}, 2000);
								}else{
									xModal.info(data.mensaje);
								}
				}
			});

			$(btn).html(btnTexto).attr('disabled', false);
        });

	});

	$("#btnCambioPerfil").livequery(function(){
		btn	= this;
        $(btn).click(function(e){
			btn.disabled = true;
			var btnTexto = $(btn).html();
			$(btn).html('Cambiando...');

			var parametros = $("#formCambioPerfil").serialize();
			$.ajax({
				dataType	: "json",
				cache		: false,
				async		: true,
				data		: parametros,
				type		: "post",
				url			: BASE_URI + "index.php/Mantenedor/procesarCambioPerfil", 
				error		: function(xhr, textStatus, errorThrown){
								xModal.info('Error al cambiar de perfil.');
				},
				success		: function(data){
								if(data.correcto){
									xModal.success('Se procederá con el Cambio de Perfil');
									setTimeout(function () {
										location.href = BASE_URI;
									}, 2000);
								}else{
									xModal.info(data.mensaje);
								}
				}
			});

			$(btn).html(btnTexto).attr('disabled', false);
        });

	});

	/*
	$(".select2").select2({
							language: "es",
							//tags: false,
							//placeholder: "Seleccione",
							//theme: "classic",
							//minimumResultsForSearch: -1
							dropdownParent: $(".modal.fade.in")
						});
						*/
					   
$("#chk_ver_password").on('click', function (e) {
	if ($("#chk_ver_password").is(':checked'))	{
		$("#gl_password").prop('type','text');
	} else {
		$("#gl_password").prop('type','password');
	}
});

/* Ver Si se puede registrar extranjero
$("#chk_extranjero").on('click', function (e) {
	if ($("#chk_extranjero").is(':checked'))	{
		$("#gl_rut").hide();
		$("#lbl_rut").hide();
		$("#gl_pasaporte").show();
		$("#lbl_pas").show();
	} else {
		$("#gl_pasaporte").hide();
		$("#lbl_pas").hide();
		$("#gl_rut").show();
		$("#lbl_rut").show();
	}
});
*/

$("#gl_rut").on('change', function (e) {
    var rut = $("#gl_rut").val();
    if ($("#gl_rut").val() != "") {
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: {rut: rut},
            type: "post",
            url: BASE_URI + "index.php/Mantenedor/existeUsuario",
            error: function (xhr, textStatus, errorThrown) {

            },
            success: function (data) {
                var mensaje = "";
                if (data.correcto) {
                    mensaje = "Usuario ya Existe!";
                }
                if (data.no_valido) {
                    mensaje = "Rut NO válido!";
                }
                if (mensaje != "") {
                    xModal.danger(mensaje);
                    $("#gl_rut").val("");
                } else {
                    $("#gl_nombres").val(data.gl_nombres);
                    $("#gl_apellidos").val(data.gl_apellidos);
                }
            }
        });
    }
});

$("#id_usuario_cambio").select2({
	language: "es",
	tags: false

});