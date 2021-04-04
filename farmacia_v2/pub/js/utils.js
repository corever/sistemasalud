var Utils = {

    cargarPersonaWS : function(rut = '',inputNombre = 'gl_nombres',inputApellido='gl_apellidos',inputApellido2='',boNombreCompleto=0) {

        var respuesta;

		if (rut.trim() !== '') {
            
			$.ajax({
	            data : {rut: rut},
	            url : Base.getBaseUri() + 'Farmacia/Maestro/Usuario/cargarPersonaWSJS',
	            dataType : 'json',
	            type : 'post',
	            success : function(response){
					console.log(response);
	                if (response.persona) {
						//respuesta = response.persona;
                        persona             = response.persona;
                        nombreCompleto      = persona.nombresPersona;
                        apellidos           = persona.primerApellidoPersona + " " + persona.segundoApellidoPersona;
                        apellido_paterno    = persona.primerApellidoPersona;
                        apellido_materno    = persona.segundoApellidoPersona;
                        
                        if(boNombreCompleto == 1){
                            $('#'+inputNombre).val(nombreCompleto + ' ' + apellidos).prop('readonly', true);
                        }else{
                            $('#'+inputNombre).val(nombreCompleto).prop('readonly', true);

                            if(inputApellido2 != ""){
                                $('#'+inputApellido).val(apellido_paterno).prop('readonly', true);
                                $('#'+inputApellido2).val(apellido_materno).prop('readonly', true);
                            }else{
                                $('#'+inputApellido).val(apellidos).prop('readonly', true);
                            }
                            
                        }
                        
	                }else {
                        respuesta = null;
                    }
	            },
				error : function(response){
                    respuesta = null;
                }
            });
            /*
            //Descomentar en caso de necesitar hacer pruebas con el WS y que no funcione
            persona             = 'nombre';
            nombreCompleto      = 'nombre segundo paterno materno';
            apellidos           = 'paterno + " " + 'materno';
            apellido_paterno    = 'paterno';
            apellido_materno    = 'materno';
            $('#'+inputNombre).val(nombreCompleto).prop('readonly', true);

            if(inputApellido2 != ""){
                $('#'+inputApellido).val(apellido_paterno).prop('readonly', true);
                $('#'+inputApellido2).val(apellido_materno).prop('readonly', true);
            }else{
                $('#'+inputApellido).val(apellidos).prop('readonly', true);
            }
            */
            
		}

        return respuesta;
	}
}


