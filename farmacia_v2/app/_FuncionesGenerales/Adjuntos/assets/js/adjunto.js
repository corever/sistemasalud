var Adjunto = {
    cargarAdjunto: function(btn, bo_comentario, idTipo = 0, ext = null, idForm = null,idGrillaAdjunto=null){
        Base.buttonProccessStart(btn);
        var params = {"bo_comentario": bo_comentario, "idTipo": idTipo, "ext": ext, "idForm": idForm, "idGrillaAdjunto":idGrillaAdjunto};
        $.ajax({
                data : params,
                url : Base.getBaseUri() + '_FuncionesGenerales/Adjuntos/Adjuntos/nuevoAdjunto',
                type : 'post',
                dataType : 'html',
                //processData : false,
                //contentType : false,
                cache : false,
                success : function(vista){
                    Base.buttonProccessEnd(btn);
                    xModal.openSC($(vista),'Agregar Adjunto',50);
                },
                error : function(response){
                    xModal.danger('Error en sistema. Intente nuevamente o comuníquese con Soporte', function(){
                        //$(btn).prop('disabled', false);
                        Base.buttonProccessEnd(btn);
                    });
                }
            });
    },

	guardar : function(form, btn){
        Base.buttonProccessStart(btn);

        let mensaje			= "";
		let path 			= $("#adjunto").val();
		var idGrillaAdjunto = ($("#nombreGrilla").val() != "")?$("#nombreGrilla").val():"adjuntos";
        //console.log("idGrillaAdjunto: "+idGrillaAdjunto);
        /*
        if (form.id_tipo_adjunto.value === "") {
            mensaje += '<p>Debe indicar el tipo de documento</p>';
        }
        */

        if (form.adjunto.value === "") {
            mensaje += '<p>Debe adjuntar un archivo</p>';
        }

        //mensaje = Adjunto.validar(path);
        //console.log(mensaje);

        if(mensaje !== ""){
            xModal.danger(mensaje ,function(){
                Base.buttonProccessEnd(btn);
            });
        }else{
            let formulario	= new FormData(document.getElementById(form.id));
            $.ajax({
                data : formulario,
                url : Base.getBaseUri() + '_FuncionesGenerales/Adjuntos/Adjuntos/guardarTemporal',
                type : 'post',
                dataType : 'json',
                processData : false,
                contentType : false,
                cache : false,
                success : function(response){
                    if (response.correcto) {
                        if(response.cantAdjuntados >= parseInt($("#cantAdjuntos").val())){
                            $("#btnAdjuntar"+idGrillaAdjunto).prop("disabled",true);
                        }else{
                            $("#btnAdjuntar"+idGrillaAdjunto).prop("disabled",false);
                        }
                        $("#"+idGrillaAdjunto).html(response.tabla).show(200);
                        xModal.close();
                    } else {
                        xModal.info(response.mensaje);
                        // 1Modal.info(response.mensaje);
                    }
                    Base.buttonProccessEnd(btn);
                    // 1$(btn).prop('disabled', false);
                },
                error : function(response){
                    xModal.danger('Error en sistema. Intente nuevamente o comuníquese con Soporte', function(){
                        //$(btn).prop('disabled', false);
                        Base.buttonProccessEnd(btn);
                    });
                }
            });
        }
	},

    validar : function(path) {

		let msj = '';
		let tipoAdjunto = $('#id_tipo_adjunto').val();
		let extensiones_permitidas;

		extensiones_permitidas = {
					office          : ['.doc', '.docx', '.ppt', '.pptx', '.xls', '.xlsx'],
                    imagen          : ['.jpeg', '.jpg', '.png', '.gif', '.tiff', '.bmp'],
                    otros_formatos  : ['.pdf', '.txt','.csv']
		};


		if (path.trim() === '') {

			msj = '<h4>Debe ingresar un archivo</h4>';
		}
		else if (tipoAdjunto == 0) {
			msj = '<h4>Debe seleccionar un tipo de archivo</h4>';
		}
		else {

	        let permitida   = false;
	        let string      = path;
	        let extension   = (string.substring(string.lastIndexOf("."))).toLowerCase();

	        $.each(extensiones_permitidas,function(tipo,arrExtensiones){
	        	if($.inArray(extension,arrExtensiones) !== -1){name
	        	}
	        });


			if (!permitida) {
				msj  = "Estimado Usuario<br><br>";
                msj += "El archivo que intenta adjuntar no está permitido. Los archivos permitidos son:<br><br>";
                msj += "<table>";

                $.each(extensiones_permitidas,function(tipo,arrExtensiones){
                	titulo = tipo.replace("_"," ");
                	titulo = titulo.toLowerCase().replace(/\b[a-z]/g, function(letra){
							    return letra.toUpperCase();
							});
                    msj += "<tr><td width='30%'>- " + titulo +  "</td><td width='1%'></td><td> [" + arrExtensiones.join(" - ") + "]</td></tr>";
                });

                msj += "</table>";

			}
		}

        return msj;
    },

    cargarGrilla : function(id_formulario = 'adjuntos', bo_editar = 0) {
        console.log("Cargando Grilla");
		var idGrillaAdjunto = ($("#idGrillaAdjunto").val() != "")?$("#idGrillaAdjunto").val():"adjuntos";
        $.ajax({
            data : {"idForm": id_formulario, "bo_editar": bo_editar},
            url : Base.getBaseDir() + '_FuncionesGenerales/Adjuntos/Adjuntos/cargarGrilla',
            dataType : 'html',
            type : 'post',
            success : function(response){
                $("#"+idGrillaAdjunto).html(response);
            }
        });
	},

    descargar : function(btn, key, bo_temporal = 1) {
        //debugger;
        Base.buttonProccessStart(btn);
        if(bo_temporal){
            var idForm = $(btn).closest('table').data( "idform" );
            var url = Base.getBaseDir() + '_FuncionesGenerales/Adjuntos/Adjuntos/verTemporal/';
            window.open(url +idForm+'/'+key, '_blank');
            Base.buttonProccessEnd(btn);
        }
        else{
            var url = Base.getBaseDir() + '_FuncionesGenerales/Adjuntos/Adjuntos/verAdjuntoDisco/';
		    window.open(url +key, '_blank');
            Base.buttonProccessEnd(btn);
        }
        
	},

    eliminar : function(btn, key, idGrillaAdjunto='adjuntos') {
        var idForm  = $(btn).closest('table').data( "idform" );        
		let msj     = '<h4>¿Desea eliminar este adjunto?<h4>';

		xModal.confirm(msj, function(){

			$.ajax({
	            data : {"key" : key, "idForm": idForm},
                url : Base.getBaseDir() + '_FuncionesGenerales/Adjuntos/Adjuntos/eliminarTemporal',
	            dataType : 'json',
	            type : 'post',
	            success : function(response){
	                if (response.correcto) {
                        if(response.cantAdjuntados >= parseInt($("#cantAdjuntos").val())){
                            $("#btnAdjuntar"+idGrillaAdjunto).prop("disabled",true);
                        }else{
                            $("#btnAdjuntar"+idGrillaAdjunto).prop("disabled",false);
                        }
                        $("#"+idGrillaAdjunto).html(response.tabla);
                        xModal.success(response.mensaje);
						//Adjunto.cargarGrilla();
						//if(response.sinAdjuntos) FormBase.ocultaMuestraVista('panel_body_adjuntos');
	                }
	            }
	        });
		});
    },
    
    validarAdjuntoExt	:	function(adjunto,tipo=1){
        let msj		=	'';
        let extensiones_permitidas;
		console.log(adjunto)
		extensiones_permitidas = {
					office          : ['.doc', '.docx'],
                    imagen          : ['.jpeg', '.jpg', '.png'],
                    otros_formatos  : ['.pdf']
		};

		if (adjunto[0].value.trim() === '') {

			msj = '<h4>Debe ingresar un archivo</h4>';
		}
		else if (tipo == 0) {
			msj = '<h4>Debe seleccionar un tipo de archivo</h4>';
		}else{

			let permitida   = false;
	        let string      = adjunto[0].value;
	        let extension   = (string.substring(string.lastIndexOf("."))).toLowerCase();

	        $.each(extensiones_permitidas,function(tipo,arrExtensiones){
	        	if($.inArray(extension,arrExtensiones) !== -1){
	        		permitida = true;
	        		return false;
	        	}
	        });

			if (!permitida) {
				msj  = "Estimado Usuario<br><br>";
                msj += "El archivo que intenta adjuntar no está permitido. Los archivos permitidos son:<br><br>";
                msj += "<table>";

                $.each(extensiones_permitidas,function(tipo,arrExtensiones){
                	titulo = tipo.replace("_"," ");
                	titulo = titulo.toLowerCase().replace(/\b[a-z]/g, function(letra){
							    return letra.toUpperCase();
							});
                    msj += "<tr><td width='30%'>- " + titulo +  "</td><td width='1%'></td><td> [" + arrExtensiones.join(" - ") + "]</td></tr>";
                });

                msj += "</table>";

			}
		}

        return msj;
    },
}
