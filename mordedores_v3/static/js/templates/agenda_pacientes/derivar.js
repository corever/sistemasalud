var AgendaDerivar ={
    derivar : function(){
        var token_exp_mor       = $("#token_expediente_mordedor").val();
        var fecha               = $("#fc_programado").val();
        var hora                = $("#hora_programado").val();
        var reprogramar         = $("#bo_reprogramar").val();
        var bandeja             = $("#gl_bandeja").val();
        
        if(fecha == "" || hora == ""){
            xModal.danger("Por favor, Ingrese todos los campos!");
        }else{
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: {token_exp_mor:token_exp_mor,fecha:fecha,hora:hora,reprogramar:reprogramar},
                type: "post",
                url: BASE_URI + "index.php/AgendaPacientes/derivarBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.danger('Error: No se pudo Ingresar un nuevo Registro');
                },
                success: function (data) {
                    if (data.correcto) {
                        //xModal.success('Éxito: '+data.mensaje);
                        xModal.close();
                    }
                }
            });
        }
	},
}

setTimeout(function(){
    $("#id_establecimiento_derivar").select2({
        language: "es",
        tags: false

    });
},300);
