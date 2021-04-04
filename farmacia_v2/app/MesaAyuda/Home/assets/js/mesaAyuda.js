var MesaAyuda = {

    agregarTicket : function(){
        if($("#registroTicket").is(":visible")){
            $("#registroTicket").hide(200);
        }else{
            $("#registroTicket").show(200);
        }
    },

    cargarGrilla : function(){

		$.ajax({
			processData : false,
			cache       : false,
			async       : true,
			type        : 'post',
			dataType    : 'text',
			contentType : false,
			url: Base.getBaseUri() + "MesaAyuda/Home/MisTickets/cargarGrilla",
			error: function(xhr, textStatus, errorThrown){
				alert("Error");
			},
			success: function (response) {
				$("#dvGrillaMesaAyuda").html(response);				
				$("#grillaMesaAyuda").dataTable({
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
    
    enviarTicket : function(btn){
        
        Base.buttonProccessStart(btn);

        var parametros 		= $("#form").serialize();
        var recaptcha 		= $('#form textarea[name="g-recaptcha-response"]').val(); //Soporte_Externo
        var mensaje_error	= "";
        var bo_externo		= 0; //var bo_externo		= $('#bo_externo').val(); //Soporte_Externo
        
        //var rut				= $('#rut').val(); To do, revisar si aplica para ops
        //var nombre			= $('#nombre').val(); //Soporte_Externo
        var email			= $('#gl_email').val();
        var telefono		= $('#gl_telefono').val();
        var asunto			= $('#gl_asunto').val();
        var mensaje			= $('#gl_mensaje').val();
        //var region			= $('#region_soporte').val(); //Soporte_Externo

        //Validaciones//
        if(email == '' || email == null){
            mensaje_error += '- El campo <b>Email</b> es requerido. <br/>';
        }
        if(telefono == '' || telefono == null){
            mensaje_error += '- El campo <b>Telefono</b> es requerido. <br/>';
        }
        if(asunto == '' || asunto == null){
            mensaje_error += '- El campo <b>Asunto</b> es requerido. <br/>';
        }
        if(mensaje == '' || mensaje == null){
            mensaje_error += '- El campo <b>Mensaje</b> es requerido. <br/>';
        }
        
        if(bo_externo){
            if(run == '' || run == null){
                mensaje_error += '- El campo <b>RUN</b> es requerido. <br/>';
            }
            if(nombre == '' || nombre == null){
                mensaje_error += '- El campo <b>Nombre</b> es requerido. <br/>';
            }
            if(region == '' || region == null || region == 0){
                mensaje_error += '- El campo <b>Región</b> es requerido. <br/>';
            }
            if(recaptcha == ""){
                mensaje_error += '<br/><b>Captcha</b> <br/> - Debe seleccionar la opción <b>"No soy un robot"</b>.';
            }
        }

        if(mensaje_error != ""){
            xModal.danger(mensaje_error,function(){
                Base.buttonProccessEnd(btn);
            },'md');
        }else{
            $.ajax({
                dataType : "json",
                cache    :false,
                async    : true,
                data     : parametros,
                type     : "post",
                url      : Base.getBaseDir() + "MesaAyuda/Home/MisTickets/guardar",
                error    : function(xhr, textStatus, errorThrown){

                },
                success:function(data){
                    console.log(data.respuesta);
                    Base.buttonProccessEnd(btn);
                    if(data.correcto){
                            xModal.success('Su Ticket '+data.msg+' ha sido ingresado.', function(){
                                Base.buttonProccessEnd(btn);
                                location.href = Base.getBaseDir() + "MesaAyuda/Home/MisTickets/";
                            });
                        // if(bo_externo){
                        //     xModal.close();
                        // }
                    } else {
                        xModal.danger(data.msg,function(){
                            Base.buttonProccessEnd(btn);
                        },'md');
                    }
                }
            });
        }

    },
}
