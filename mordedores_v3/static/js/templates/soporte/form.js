	$(document).ready(function() {
		$("#guardar").on('click', function(e) {
			var button_process = buttonStartProcess($(this), e);
			var parametros = $("#form").serialize();
			$.ajax({         
				dataType: "json",
				cache:false,
				async: true,
				data: parametros,
				type: "post",
				url: BASE_URI + "index.php/Soporte/guardar", 
				error: function(xhr, textStatus, errorThrown){

				},
				success:function(data){
					buttonEndProcess(button_process);
					if(data.correcto){
						alert('Soporte '+data.msg+' ingresado');
						location.href = BASE_URI + "index.php/Soporte/index";
					} else {
						alert(data.msg);
						//procesaErrores(data.error);
						$("#form-error").removeClass("hidden");
					}
				}
			}); 
		});
		
		
		 
	});

	function cargarListadoAdjuntos(){
		$.post(BASE_URI+'index.php/Soporte/cargarListadoAdjuntos',function(response)
		{			
			parent.$("#listado-adjuntos").html(response).show();
		});
	}

	function borrarAdjunto (adjunto){
		$.post(BASE_URI+'index.php/Soporte/borrarAdjunto/'+adjunto,function(response)
		{
			$("#listado-adjuntos").html(response);
		});
	}