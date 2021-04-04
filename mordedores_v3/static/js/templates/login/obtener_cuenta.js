$(document).ready(function() {
    $("#crear").on('click', function(e) {
        var button_process = buttonStartProcess($(this), e);
        //var parametros = $("#form").serialize();
        var parametros = new FormData(document.getElementById('form'));
        //console.log(parametros);
        $.ajax({         
            dataType: "json",
            cache:false,
            contentType: false,
            processData:false,
            async: true,
            data: parametros,
            type: "post",
            url: BASE_URI + "index.php/Login/crear_cuenta_nueva", 
            error: function(xhr, textStatus, errorThrown){

            },
            success:function(data){
                buttonEndProcess(button_process);
                if(data.correcto){
                    $("#form-contenedor").addClass("hidden");
                    $("#form-success").removeClass("hidden");
                    $("#mensaje-modificacion").html("Se han enviado los datos para crear una cuenta con el correo <strong>" + data.email + "</strong>")
                } else {
                    procesaErrores(data.error);
                    $("#form-error").removeClass("hidden");
                }
            }
        }); 
    }); 
});

