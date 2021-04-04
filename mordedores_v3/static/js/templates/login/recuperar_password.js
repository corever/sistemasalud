$(document).ready(function() {
	
    $("#enviar").on('click', function(e) {
        var button_process	= buttonStartProcess($(this), e);
        var parametros		= $('#form').serialize();
		var gl_rut			= $("#rut").val();

		if (gl_rut == '') {
			xModal.danger('- El campo RUT es Obligatorio');
		} else{
			while (parametros.indexOf(".") != -1)
				parametros = parametros.replace(".","");
			$.ajax({
				dataType: "json",
				cache	: false,
				async	: true,
				data	: parametros,
				type	: "post",
				url		: BASE_URI + "index.php/Login/recuperar_password_rut",
				error	: function(xhr, textStatus, errorThrown){

						},
				success	: function(data){
							if(data.correcto){
								$("#form-contenedor").addClass("hidden");
								$("#form-success").removeClass("hidden");
								correo = data.correo;
								correo = correo.substring(0,3)+"xxxxx"+correo.substring(correo.lastIndexOf('@'));
								$("#mensaje-modificacion").html("Se han enviado los datos para recuperar contraseña al correo: <strong>" + correo + "</strong>");

							} else {
								procesaErrores(data.error);
								$("#form-error").removeClass("hidden");
							}
						}
			});
		}
		buttonEndProcess(button_process);
    });

});
