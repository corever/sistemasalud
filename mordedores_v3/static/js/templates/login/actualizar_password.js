$(document).ready(function() {

    $("#guardar").on('click', function(e) {
        var button_process	= buttonStartProcess($(this), e);
        var parametros = $("#form").serialize();
		var id = $("#id").val();
        $.ajax({         
            dataType	: "json",
            cache		: false,
            async		: true,
            data		: parametros,
            type		: "post",
            url			: BASE_URI + "index.php/Login/ajax_guardar_nuevo_password", 
            error		: function(xhr, textStatus, errorThrown){
							buttonEndProcess(button_process);
							xModal.info('Error al Actualizar la Contraseña.');
            },
            success		: function(data){
							buttonEndProcess(button_process);
							if(data.correcto){
								$("#password").val("");
								$("#password_repetido").val("");
								$("#password_ant").val("");
								limpiaErrores(data.error);
								$("#form-error").addClass("hidden");
								xModal.success('Éxito: Se actualizo su contraseña.');
									setTimeout(function () {
										location.href = BASE_URI + "index.php/Home/dashboard";
									}, 2000);
								//xModal.info('Contraseña Actualizada');
								//location.href = BASE_URI + "index.php/Home/dashboard";
							} else {
								procesaErrores(data.error);
								xModal.info('Error al Actualizar la Contraseña.');
								$("#form-error").removeClass("hidden");
							}
            }
        }); 
    });

});