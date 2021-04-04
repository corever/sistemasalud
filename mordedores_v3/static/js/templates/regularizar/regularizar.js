var Regularizar = {
    limpiarDatos: function () {
        //Limpia filtros
        $("#input_codigo").val("");
		$("#archivo_adjunto").val("");
		$(".eliminar-respaldo").trigger( "click" ); //borrar archivo subido
		$("#contenedor-fiscalizacion-tabla").hide();
		if($("input:checked").val() == "adjunto") $("#contenedor-archivo-adjunto").show();
		$("#contenedor-expediente").hide();
		$("#subir").prop('disabled',true);
    },

    habilitarBtnSubir: function() {
        $("#subir").prop('disabled',false);
	},
	
    leerAdjunto: function(btn) {
        var btnText = $(btn).prop('disabled',true).html();
		$(btn).html('Leyendo... <i class="fa fa-spin fa-spinner"></i>');
		var archivo = $("#archivo_adjunto").val();
		var error = '';

		if (archivo == "") {
			error += "- No ha adjuntado archivo";
		}
		
		if(error != "") {
			xModal.danger(error, function(){
				$(btn).html(btnText).prop('disabled', false);
			});
		} else {
			var archivo = document.getElementById('archivo_adjunto');
			var file = archivo.files[0];
			var extension = file.name.split(".")[1].toLowerCase();


			if(extension == "txt") {
				/* Validar si nombre coincide con uno ya subido */
				var existe = false;
				$("#body-respaldo tr").each(function() {
					$(this).children("td").each(function(index) {
						switch(index) {
							case 0:
									if(typeof $(this).data('nombre') !== 'undefined' && $(this).data('nombre').length > 0) existe = true;
									break;
							case 1:
									break;
							default:
									console.log("error leerAdjunto");
									break;
						}
					});
				});

				if(!existe) {
					if((file.size/1204) > 20480) {
						xModal.danger('El archivo ingresado no puede ser mayor a 20MB', function(){
							$(btn).html(btnText).prop('disabled', false); 
						});
					} else {
						var formData = new FormData();
						formData.append('archivo', file);
						//formData.append('id', form.archivo_adjunto.value);
						if (!file) {return;}
						var lector = new FileReader();
						lector.onload = function(e) {
							try {
								var content = JSON.parse(e.target.result);
							
								//setear datos innecesarios en null
								if('json_direccion_mordedura' in content)
									content.json_direccion_mordedura.img_direccion = null;

								if('datos_cabecera' in content) {
									content.datos_cabecera = null;
								}

								if('pacientes' in content) {
									content.pacientes = null;
								}
									
								content.mordedores.map(
									(mordedor) =>
									{
										if('img_direccion' in mordedor) mordedor.img_direccion = null;
										return
									}
								);

								//console.log(content);
								var fila_respaldo = '<tr>'
														+ '<td class="text-center" data-respaldo=\'' + JSON.stringify(content) + '\' data-nombre="' + file.name + '">' + file.name + '</td>'
														+ '<td class="text-center">'
																+ '<button id="procesar" type="button" class="btn btn-success procesar-archivos" data-toggle="tooltip" '
																			+ 'data-title="Procesar archivo" onClick="campos_regularizar.procesarAdjunto(this)" >'
																		+ '<i class="fa fa-gears" aria-hidden="true"></i>'
																+ '</button>'
																+ '<button type="button" class="btn btn-danger eliminar-respaldo" data-toggle="tooltip" data-title="Eliminar" style="margin-left:2px;">'
																	+ '<i class="fa fa-trash-o" aria-hidden="true"></i>'
																+ '</button>'
														+ '</td>'
													+ '</tr>';

								$("#respaldoNodata").remove();
								$("#tabla-respaldos").append(fila_respaldo);
								$(btn).html(btnText).prop('disabled', false);
								$("#subir").prop('disabled',true);
								$("#archivo_adjunto").val("");
							} catch (e) {
								console.log('error json');
								xModal.info('El archivo adjuntado no tiene el formato requerido', function() {
									$(btn).html(btnText).prop('disabled', false);
								});
							}
							
						};
						lector.readAsText(file);
					}
				} else {
					xModal.info('Ya subió un archivo, elíminelo si desea subir otro.', function() {
						$(btn).html(btnText).prop('disabled', false);
					});
				}
			} else {
				xModal.danger('El archivo ingresado debe tener extensión .txt', function() {
					$(btn).html(btnText).prop('disabled', false);
				});
			}
		}
    },

    buscar: function(btn) {
        var btnText = $(btn).prop('disabled',true).html();
		$(btn).html('Procesando... <i class="fa fa-spin fa-spinner"></i>');
        
        var input_codigo = $("#input_codigo").val();
        
		$.ajax({
			url		: BASE_URI + 'index.php/Regularizar/buscar',
			dataType: 'json',
			type	: 'post',
			data	: {codigo: input_codigo},
			success	: function(response) {
				$(btn).html(btnText).prop('disabled', false);
				
				if(response.correcto){
					$("#contenedor-archivo-adjunto").hide();
					$("#contenedor-fiscalizacion-tabla").show();
					$("#contenedor-fiscalizacion-tabla").html(response.grilla);
				}else{
					$("#contenedor-archivo-adjunto").hide();
					$("#contenedor-fiscalizacion-tabla").hide();
					$("#contenedor-fiscalizacion-tabla").html('');
					xModal.danger(response.mensaje);
				}
			},
			error: function(e) {
                //console.log(e);
				xModal.danger("Error. No se pudo realizar la acción.");
				$(btn).html(btnText).prop('disabled', false);
			}
		});
    },

    procesarAdjunto: function(btn) {
        var btnText = $(btn).prop('disabled',true).html();
		$(btn).html('Procesando... <i class="fa fa-spin fa-spinner"></i>');
        var data = null;

        $("#body-respaldo tr").each(function() {
			$(this).children("td").each(function(index) {
				switch(index) {
                    case 0:
                        data = $(this).data('respaldo');

                        if(typeof data !== 'object') {
							//console.log("no es objeto.... parseando");
							//console.log(data);
                            data = JSON.parse(data);
                        }
                    case 1:
                    break;
                    default:
                            console.log("error procesarAdjunto");
                            break;
                }
            });

            $("#body-respaldo tr").remove();
            $("#body-respaldo").append("<tr id='respaldoNodata' data-info='nodata'><td class='text-center' colspan='3' data-datos='nodatos'> No hay respaldos para mostrar</td></tr>");
        });

        //console.log(data);
		$.ajax({
			url : BASE_URI + 'index.php/Regularizar/datosRespaldo',
			dataType : 'json',
			type : 'post',
			data: {entrada: "respaldo", data_from_file: JSON.stringify(data)},
			success : function(response) {
				$("#contenedor-archivo-adjunto").hide();
				$(btn).html(btnText).prop('disabled', false);
				//$("#guardarActividad").prop("disabled", false);
				$("#contenedor-fiscalizacion-tabla").show();
				$("#contenedor-fiscalizacion-tabla").html(response.grilla);
			},
			error: function(err) {
				console.log(err);
				xModal.danger(err.responseText, function(){});
				$(btn).html(btnText).prop('disabled', false);
			}
		});
    },

	llenarFormulario: function(desde, actividad_id = null, folio = null) {
		$("#btnRegularizar").prop('disabled',true);
		$.ajax({
			url		: BASE_URI + 'index.php/Regularizar/llenarFormulario',
			dataType: 'json',
			type	: 'post',
			data	: {input_codigo: desde, codigo: $("#input_codigo").val(), actividad_id: actividad_id, folio: folio},
			success	: function(response) {
				
				if(response.correcto){
					$("#contenedor-fiscalizacion-tabla").hide();
					$("#contenedor-buscar").hide();
					$("#contenedor-expediente").show();
					$("#contenedor-formulario-expediente").html(response.formulario);
					setTimeout(function() {
						//llenar select comunas
						for(var i = 0; i < parseInt($("#cantidad_mordedores").val()); i++) {
							$("#region_propietario"+i).trigger("change");
							$("#id_region_animal"+i).trigger("change");
							$("#id_animal_especie"+i).trigger("change");
							$("#id_laboratorio"+i).trigger("change");
							$("input.bo_sintomas_rabia"+i).trigger("change");
						}
					}, 300);
					
					$(".fc_clase").datepicker({
						locale: "es",
						format: "DD/MM/YYYY",
						useCurrent: false,
						inline: false
					});

					$(":checkbox").labelauty();
					$(":radio").labelauty();
				}else{
					$("#contenedor-fiscalizacion-tabla").show();
					$("#contenedor-expediente").hide();
					xModal.danger(response.mensaje);
				}
				

			},
			error: function(err) {
				console.log(err);
				xModal.danger(err.responseText, function(){});
			}
		});
	},

    validarCampos: function() {

    },

    guardarFiscalizacion : function(btn) {
        var e               = jQuery.Event( "click" );
        var button_process  = buttonStartProcess($(btn), e);

        var parametros_regularizar  = $("#form-regularizar").serializeArray();
        var parametros_visita  		= $("#form-fiscalizacion").serializeArray();
        var parametros = parametros_regularizar.concat(parametros_visita);

        var mensaje_error   = "";

        if($("#ingresa_datos_visita").val() == 1){
	        if ($("#fecha_inspeccion").val() == '') {
	            mensaje_error += '- Debe ingresar la Fecha de visita<br>';
	        }
	        if ($('input:radio[name=id_visita_estado]:checked').val() == undefined) {
	            mensaje_error += '- Debe indicar estado de visita<br>';
	        }
	        if ($('input:radio[name=bo_se_niega_visita]:checked').val() == undefined) {
	            mensaje_error += '- Debe indicar si se niega a la visita<br>';
	        }
        }


        /*if ($("#establecimientosalud option:selected").val() === "0") {
            mensaje_error += '- Debe seleccionar un Centro de Salud<br>';
        }
        if ($("#fechaingreso").val() == '') {
            mensaje_error += '- El campo Fecha de Atención a Paciente es Obligatorio<br>';
        }
        if ($("#fechanotificacion").val() == '') {
            mensaje_error += '- El campo Fecha de Notificación a SEREMI es Obligatorio<br>';
        }
        if ((!$("#chk_no_informado").is(":checked") && !$("#chkextranjero").is(":checked")) && $("#rut").val() == '') {
            mensaje_error += '- El campo RUT es Obligatorio<br>';
        }
        if ($("#nombres").val() == '') {
            mensaje_error += '- El campo Nombres es Obligatorio<br>';
        }
        if ($("#apellido_paterno").is(":checked") && $("#rut").val() == '') {
            mensaje_error += '- El campo Apellido Paterno es Obligatorio<br>';
        }
        if (fc_nacimiento == '') {
            mensaje_error += '- El campo Fecha de Nacimiento es Obligatorio<br>';
        }
        if ($("#id_pais_origen option:selected").val() === "0") {
            mensaje_error += '- Debe seleccionar el País de origen del Paciente<br>';
        }
        if ($("#fc_mordedura").val() == '') {
            mensaje_error += '- Debe ingresar Fecha de Mordedura<br>';
        }
        if ($("#region option:selected").val() === "0") {
            mensaje_error += '- Debe seleccionar la region de Mordedura<br>';
        }
        if ($("#comuna option:selected").val() === "0") {
            mensaje_error += '- Debe seleccionar la comuna de Mordedura<br>';
        }
        if ($("#direccion").val() == "") {
            mensaje_error += '- Debe seleccionar la Dirección de Mordedura<br>';
        }
        if ($("#id_lugar_mordedura option:selected").val() === "0") {
            mensaje_error += '- Debe seleccionar lugar de Mordedura<br>';
        }
        if ($('input:radio[name=id_inicia_vacuna]:checked').val() === undefined) {
            mensaje_error += '- Debe informar si Inicia Vacuna (Si/No)<br>';
        }
        if ($("#id_animal_grupo option:selected").val() === "0") {
            mensaje_error += '- Debe seleccionar un grupo de Animal<br>';
        }*/

        if(mensaje_error != ""){
            xModal.danger(mensaje_error,function(){buttonEndProcess(button_process);});
        }else {
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: parametros,
                type: "post",
                url: BASE_URI + "index.php/Regularizar/guardarFiscalizacion",
                error: function (xhr, textStatus, errorThrown) {
                    buttonEndProcess(button_process);
                    xModal.danger('Error: No se pudo Ingresar un nuevo Registro');
                },
                success: function (data) {
                    buttonEndProcess(button_process);
                    if (data.correcto) {
                        xModal.success('Éxito: ' + data.mensaje,function(){ location.reload(); });
                    } else {
                        xModal.danger('Error: ' + data.mensaje_error,function(){buttonEndProcess(button_process);});
                    }
                }
            });
        }
    },

	//Es extranjero
	extranjeroRadioBtn: function(radio_input) {
		var num = $(radio_input).data('cant');
		var x = document.getElementsByName("emitidoChile"+num);
		x[0].checked = true;
		if(radio_input.value == "1") {
			$("#div-nacionalidad"+num).show();
			$("#div-bo_extranjero"+num).show();
		
		}
		if(radio_input.value == "0") {
			$("#div-nacionalidad"+num).hide();
			$("#div-bo_extranjero"+num).hide();
			$("#div-gl_rut"+num).show();
			$("#div-gl_pasaporte"+num).hide();
			//$("input.emitidoChile"+num).prop("checked", false);
        }
	},

	//RUT emitido en chile
	emitidoChileRadioBtn: function(radio_input) {
		var num = $(radio_input).data('cant');
		if(radio_input.value == "1") {
            $("#div-gl_rut"+num).show();
			$("#div-gl_pasaporte"+num).hide();
        }else{
			$("#div-gl_rut"+num).hide();
			$("#div-gl_pasaporte"+num).show();
        }
	},

	// presenta sintomas de rabia (si/no)
	sintomatologiaRadioBtn: function(radio_input) {
		var num = $(radio_input).data('cant');

		if($("input.bo_sintomas_rabia"+num+":checked").val() == "1") {
			$(".sintoma_si"+num).show();
			$(".sintoma_no"+num).hide();
		} else if($("input.bo_sintomas_rabia"+num+":checked").val() == "0") {
			$(".sintoma_si"+num).hide();
			$(".sintoma_no"+num).show();
		}
	},
	
	visitaEstadoBtn: function(radio_input) {
		if(radio_input.value == "2") {
			$('#accordion').show();
			$('#div_datos_realizada').show();
			$('#div_datos_perdida').hide();
		}else{
			$('#accordion').hide();
			$('#div_datos_realizada').hide();
			$('#div_datos_perdida').show();
		}
	},
	
	visitaPerdidaMotivo: function(select_input) {
		if(select_input.value == "4") {
			$('#input_otro_perdida').show();
		}else{
			$('#input_otro_perdida').hide();
		}
	},
	
	niegaVisitaBtn: function(radio_input) {
		var num = $(radio_input).data('cant');
		if(radio_input.value == "1") {
			$('#div_mordedor_'+num).hide();
			$('#div_sumario_'+num).show();
		}else{
			$('#div_mordedor_'+num).show();
			$('#div_sumario_'+num).hide();
		}
	},
	
	iniciaSumarioBtn: function(radio_input) {
		var num = $(radio_input).data('cant');
		if(radio_input.value == "1") {
			$('#descargos_'+num).show();
		}else{
			$('#descargos_'+num).hide();
		}
	},
	estadoAnimalBtn: function(radio_input) {
		var num = $(radio_input).data('cant');
		$('#div_microchip_mordedor'+num).hide();
		if(radio_input.value == "1") {
			$('#div_microchip_mordedor'+num).show();
			$('#div_motivo_muerte_mordedor'+num).hide();
			$('#div_informacion_mordedor'+num).show();
			$('#div_direccon_mordedor'+num).show();
			
			var x = document.getElementsByName("bo_sintomas_rabia"+num);
			var y = document.getElementsByName("gl_motivo_muerte"+num);
			x[1].disabled	= false;
			x[1].checked	= true;
			$(x).trigger("change");
			
			y[1].checked	= true;
			$('#div_motivo_muerte_mordedor_otro'+num).show();
		}if(radio_input.value == "0") {
			$('#div_motivo_muerte_mordedor'+num).show();
			$('#div_microchip_mordedor'+num).hide();
			$('#div_informacion_mordedor'+num).hide();
			$('#div_direccon_mordedor'+num).hide();
		}
	},
	motivoMuerteBtn: function(radio_input) {
		var num = $(radio_input).data('cant');
		if(radio_input.value == "1") {
			$('#div_motivo_muerte_mordedor_otro'+num).hide();
			$('#div_informacion_mordedor'+num).show();
			$('#div_direccon_mordedor'+num).show();
			$(".sintoma_si"+num).show();
			$("div_eutanasia_modedor"+num).show();
			$(".sintoma_no"+num).hide();

			//$("input.bo_sintomas_rabia"+num+":checked");
			var x = document.getElementsByName("bo_sintomas_rabia"+num);
			x[0].checked	= true;
			x[1].disabled	= true;
		}else{
			$('#div_motivo_muerte_mordedor_otro'+num).show();
			$('#div_informacion_mordedor'+num).hide();
			$('#div_direccon_mordedor'+num).hide();
			
		}
	},
	duracionInmunidad: function(radio_input,combo) {
		var num = $(radio_input).data('cant');
		var aum = $('#id_duracion_inmunidad'+num).val();
		var vec	= radio_input.value.split('/');
		var year= parseInt(vec[2])+parseInt(aum);
		var fc	= vec[0]+'/'+vec[1]+'/'+year;
		
		$('#'+combo).val(fc);
	}
}


var AdjuntoRegularizar={
    guardarAdjunto: function(form,btn){
        var e               = jQuery.Event( "click" );
        var button_process  = buttonStartProcess($(btn), e);
        var error           = false;
        var msg_error       = '';
        var path            = form.adjunto.value;
        var id_tipo_adjunto = $("#id_tipo_adjunto").val();
        var cont_mordedor   = $("#cont_mordedor").val();
        
        if (path == "") {
            msg_error += 'Seleccione Archivo<br/>';
            error = true;
        }
        
        if (error) {
            xModal.danger(msg_error,function(){
            });
        } else {
			extensiones_permitidas = new Array('.jpeg', '.jpg', '.png', '.gif',
											   '.JPEG', '.JPG', '.PNG', '.GIF');
            permitida   = false;
            string      = path;
            extension   = (string.substring(string.lastIndexOf("."))).toLowerCase();
             for(var i = 0; i < extensiones_permitidas.length; i++) {
                if (extensiones_permitidas[i] == extension){
                    permitida = true;
                    break;
                }
            }
            if (!permitida) {
                msg_error += 'El Tipo de archivo que intenta subir no está permitido.<br><br>'
                msg_error += 'Favor elija un archivo con las siguientes extensiones: <br>'
                msg_error += extensiones_permitidas.join(' ')+'<br/>';
                xModal.warning(msg_error,function(){buttonEndProcess(button_process);});
            } else {
                //$(form).submit();
                
                var formulario      = new FormData();                
                var inputFileImage  = document.getElementById("adjunto");
                var file            = inputFileImage.files[0];
                formulario.append('archivo',file);
                formulario.append('id_tipo_adjunto',id_tipo_adjunto);
                formulario.append('cont_mordedor',cont_mordedor);
                
                $.ajax({
                    url			: BASE_URI + "index.php/Regularizar/guardarNuevoAdjunto",
                    data		: formulario,
                    processData	: false,
                    cache		: false,
                    async		: true,
                    type		: 'post',
                    dataType	: 'json',
                    contentType	: false,
                    success		: function(response){
                        if(response.correcto == true){
                            xModal.success("OK: El archivo fue guardado", function(){
                                $("#grilla-adjunto"+id_tipo_adjunto+"-"+cont_mordedor).html(response.grilla);
                                xModal.closeAll();
                            });
                        }else{
                            xModal.danger(response.mensaje,function(){buttonEndProcess(button_process);});
                        }
                    }, 
                    error		: function(){
                        xModal.danger('Error: Intente nuevamente',function(){buttonEndProcess(button_process);});
                    }
                });
            }
        }
    },
    borrarAdjunto : function(adjunto) {
        $.post(BASE_URI + 'index.php/Vacuna/borrarAdjunto/' + adjunto, function (response){
            $("#grilla-carnet-adjunto").html(response);
        });
    }
}



$(document).ready(function() {
    //Selección de método de regularización
    $("input[name='origen']").on( "click", function() {
        if($("input:checked").val() == "codigo") {
            $("#archivo_adjunto").val("");
            $("#div_input_codigo").show();
            $("#div_input_adjunto").hide();
            $("#subir").hide();
            $("#buscar").show();
            $("#contenedor-archivo-adjunto").hide();
        } if($("input:checked").val() == "adjunto") {
            $("#input_codigo").val("");
            $("#div_input_codigo").hide();
            $("#div_input_adjunto").show();
            $("#subir").show();
            $("#buscar").hide();
            $("#contenedor-archivo-adjunto").show();
        }
    });

    /**
	 * Eliminar respaldo de tabla
	 */
	$(document).on('click', ".eliminar-respaldo",function() {
		event.preventDefault();
		var fila = $(this).closest('tr');
		if(fila.siblings().length == 0) {
			var tr = "<tr id='respaldoNodata' data-info='nodata'><td class='text-center' colspan='3' data-datos='nodatos'> No hay respaldos para mostrar</td></tr>";
			fila.remove();
			$("#body-respaldo").append(tr);
		} else fila.remove();
	});
});

