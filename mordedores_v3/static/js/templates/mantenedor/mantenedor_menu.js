var Mantenedor_menu = {

	agregarMenuPadre : function(form,btn){
        var parametros		= $("#formAgregarPadre").serializeArray();
		var gl_nombre		= $('#gl_nombre').val();
		
		if (gl_nombre == ""){xModal.danger("Nombre es Obligatorio");}
		else {
			$.ajax({         
				dataType	: "json",
				cache		: false,
				async		: true,
				data		: parametros,
				type		: "post",
				url			: BASE_URI + "index.php/Mantenedor/agregarMenuPadreBD", 
				error		: function(xhr, textStatus, errorThrown){
								xModal.info('Error al Agregar Opción.');
				},
				success		: function(data){
								if(data.correcto){
									xModal.success(data.mensaje);
									setTimeout(function () {
										location.href = BASE_URI + "index.php/Mantenedor/menu";
									}, 2000);
								} else {
									xModal.info(data.mensaje);
								}
				}
			}); 
		}
	},
	agregarMenuOpcion : function(form,btn){
		var parametros		= $("#formAgregarHijo").serializeArray();
		var gl_nombre		= $('#gl_nombre_opcion').val();
		var gl_url			= $('#gl_url').val();
		
		if (gl_nombre == "")	{xModal.danger("Nombre es Obligatorio");}
		else if (gl_url == "")		{xModal.danger("URL es Obligatorio");}
		else {
			$.ajax({         
				dataType	: "json",
				cache		: false,
				async		: true,
				data		: parametros,
				type		: "post",
				url			: BASE_URI + "index.php/Mantenedor/agregarMenuOpcionBD", 
				error		: function(xhr, textStatus, errorThrown){
								xModal.info('Error al Agregar Opción.');
				},
				success		: function(data){
								if(data.correcto){
									xModal.success(data.mensaje);
									setTimeout(function () {
										location.href = BASE_URI + "index.php/Mantenedor/menu";
									}, 2000);
								} else {
									xModal.info(data.mensaje);
								}
				}
			});
		}
	},
	editarOpcion : function(form,btn){
		var parametros		= $("#formEditarOpcion").serializeArray();
		var gl_nombre		= $('#gl_nombre_opcion').val();
		var id_padre		= $('#id_padre').val();
		var bo_hijo         = $('#bo_hijo_1').is(":checked");
		
		if      (gl_nombre == "")           {xModal.danger("Nombre es Obligatorio");}
		else if (bo_hijo && id_padre == 0)  {xModal.danger("Si selecciona Menú Hijo debe seleccionar un Padre!");}
		else {
			$.ajax({         
				dataType	: "json",
				cache		: false,
				async		: true,
				data		: parametros,
				type		: "post",
				url			: BASE_URI + "index.php/Mantenedor/editarOpcionBD", 
				error		: function(xhr, textStatus, errorThrown){
								xModal.info('Error al Editar Opción.');
				},
				success		: function(data){
								if(data.correcto){
									xModal.success(data.mensaje);
									setTimeout(function () {
										location.href = BASE_URI + "index.php/Mantenedor/menu";
									}, 2000);
								} else {
									xModal.info(data.mensaje);
								}
				}
			});
		}
	},
    mostrarPadre: function (valor){
        if(valor==1){
            $("#div_select_padre").show();
        }else{
            $("#div_select_padre").hide();
        }
    }
}
//Solucionar
/*
$("#id_padre").on('change', function (e) {
	var gl_url_padre	= $('#id_padre option:selected').attr('id');
	var mensaje			= "Esta Opción Padre está enlazada a una URL: "+gl_url_padre+". Si le agrega una Opción Hijo se eliminará esta URL.";
	if (gl_url_padre != "") {
		$("#alerta_padre").show();
		$(".info_padre").attr("data-texto",mensaje);
	} else {
		$("#alerta_padre").hide();
	}
});
*/