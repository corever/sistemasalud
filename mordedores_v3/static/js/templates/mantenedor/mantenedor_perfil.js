
var Mantenedor_perfil = {

	agregarPerfil : function(form,btn){
		//$(form).submit();
        var parametros			= $("#formAgregarPerfil").serializeArray();
		var arrOpciones			= $('input[type=checkbox]:checked').serializeArray();
		var gl_nombre_perfil	= $('#gl_nombre_perfil').val();
		var gl_descripcion		= $('#gl_descripcion').val();
		parametros.push({
			"name": 'arr_opcion',
			"value": JSON.stringify(arrOpciones)
		});
		if(gl_nombre_perfil == "")		{xModal.danger("Nombre Perfil es Obligatorio");}
		else if(gl_descripcion == "")	{xModal.danger("Descripcion es Obligatorio");}
		else {
			$.ajax({         
				dataType	: "json",
				cache		: false,
				async		: true,
				data		: parametros,
				type		: "post",
				url			: BASE_URI + "index.php/Mantenedor/agregarPerfilBD", 
				error		: function(xhr, textStatus, errorThrown){
								xModal.info('Error al Actualizar el perfil.');
				},
				success		: function(data){
								if(data.correcto){
									xModal.success(data.mensaje);
									setTimeout(function () {
										location.href = BASE_URI + "index.php/Mantenedor/perfil";
									}, 2000);
								} else {
									xModal.info(data.mensaje);
								}
				}
			}); 
		}
	},
	editarPerfil : function(form,btn){
		//$(form).submit();
        var parametros = $("form").serializeArray();
		var arrOpciones = $('input[type=checkbox]:checked').serializeArray();
		parametros.push({
			"name": 'arr_opcion',
			"value": JSON.stringify(arrOpciones)
		});
        $.ajax({         
            dataType	: "json",
            cache		: false,
            async		: true,
            data		: parametros,
            type		: "post",
            url			: BASE_URI + "index.php/Mantenedor/editarPerfilBD", 
            error		: function(xhr, textStatus, errorThrown){
							xModal.info('Error al Editar el perfil.');
            },
            success		: function(data){
							if(data.correcto){
								xModal.success(data.mensaje);
								setTimeout(function () {
									location.href = BASE_URI + "index.php/Mantenedor/perfil";
								}, 2000);
							} else {
								xModal.info(data.mensaje);
							}
            }
        }); 
	}	
}

function mostrarHijos(check){
	var id_padre = $(check).attr("id");
	if($(check).is(':checked')){
		$("#opcion_hijo_"+id_padre).show();
	} else {
		$("#opcion_hijo_"+id_padre).hide();
	}
}