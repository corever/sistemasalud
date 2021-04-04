var AplicarVacuna ={
    aplicar : function(){
        /*var token_exp_mor       = $("#token_expediente_mordedor").val();
        var fecha               = $("#fc_vacuna_aplicada").val();
        var hora                = $("#hora_vacuna_aplicada").val();
        
        if(fecha == "" || hora == ""){
            xModal.danger("Por favor, Ingrese todos los campos!");
        }else{
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: {token_exp_mor:token_exp_mor,fecha:fecha,hora:hora},
                type: "post",
                url: BASE_URI + "index.php/AgendaPacientes/aplicarVacunaBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.danger('Error: No se pudo Guardar');
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.close();
                    }
                }
            });
        }*/
	}
}

$("#fc_vacuna_aplicada").datepicker({
    locale: "es",
    format: "DD/MM/YYYY",
    maxDate: "now",
    useCurrent: false,
    inline: false,
    beforeShow: function() {
        //Para que aparezca en Modal
        setTimeout(function(){
            $('.ui-datepicker').css('z-index', 99999999999999);
        }, 0);
    }
});

$("#hora_vacuna_aplicada").timepicker({});