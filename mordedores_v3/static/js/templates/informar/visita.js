var Visita = {
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
																			+ 'data-title="Procesar archivo" onClick="Visita.procesarAdjunto(this)" >'
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
			url		: BASE_URI + 'index.php/Informar/buscar',
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
			url : BASE_URI + 'index.php/Informar/datosRespaldo',
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
			url		: BASE_URI + 'index.php/Informar/llenarFormulario',
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
					
					/*
					$(".fc_clase").datepicker({
						locale: "es",
						format: "DD/MM/YYYY",
						useCurrent: false,
						inline: false
					});
					*/

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

        var parametros		= $("#form-fiscalizacion-web").serializeArray();
        var cantidad		= $("#cantidad_mordedores").val();
        var mensaje         = '';
        var mensaje_error   = '';
        var folio_mordedor  = '';

        if($("#ingresa_datos_visita").val() == 1){
	        if ($("#fecha_inspeccion").val() == '') {
	            mensaje_error += '- Debe ingresar la Fecha de Visita<br>';
	        }
	        if ($('input:radio[name=id_visita_estado]:checked').val() == undefined) {
	            mensaje_error += '- Debe Seleccionar el Estado de la Visita<br>';
	        }
        }

		if($('input:radio[name=id_visita_estado]:checked').val() == 1){

			if($("#id_tipo_perdida").val()== 0 || $("#id_tipo_perdida").val()== ''){
				mensaje_error += '- Debe Seleccionar el Motivo de la Visita Perdida<br>';
			}

		}else if($('input:radio[name=id_visita_estado]:checked').val() == 2){
			for(var i=0; i<=cantidad-1; i++){
				folio_mordedor = 'Folio Mordedor: <strong>' + $('#gl_folio_mordedor'+i).val() + '</strong><br>';

				if ($('input:radio[name=bo_se_niega_visita'+i+']:checked').val() == undefined) {
					mensaje += '- Debe indicar si <b>Se niega a la Visita</b>.<br>';
				}
				if ($('input:radio[name=id_animal_estado'+i+']:checked').val() == undefined) {
					mensaje += '- Debe Seleccionar <b>Estado de Animal</b>.<br>';
				}
				
				/* Se Niega a Visita*/
				if ($('input:radio[name=bo_se_niega_visita'+i+']:checked').val() == 1) {
					if ($('input:radio[name=bo_inicia_sumario'+i+']:checked').val() == 1) {
						if ($.trim($("#fecha_descargos_"+i).val()) == '') {
							mensaje += '- El campo <b>Fecha de Descargos</b> es Obligatorio.<br>';
						}if ($.trim($("#gl_observacion_sumario_"+i).val()) == '') {
							mensaje += '- El campo <b>Observación</b> es Obligatorio.<br>';
						}
						/* 
						if ($.trim($("#grilla-adjunto8-"+i).html()) == '') {
							mensaje += '- El adjunto <b>Acta</b> es Obligatorio.<br>';
						} 
						*/
					}
				}else{
				
					/* Animal Vivo */
					if($('input:radio[name=id_animal_estado'+i+']:checked').val() == 1) {
          /*
						if ($.trim($("#gl_microchip"+i).val()) == '') {
							mensaje += '- El campo <b>Microchip</b> es Obligatorio.<br>';
						}
            */
						if ($("input.bo_microchipInstalado"+i+":checked").val() == 1 && $("#instalador_microchip"+i).val() == 0) {
                            mensaje += '- Debe seleccionar <b>¿Quién instaló el microchip?</b>.<br>';
						}
						if ($("#instalador_microchip"+i).val() == 4 && $.trim($("#gl_otro_instalador_microchip"+i).val()) == '') {
                            mensaje += '- Debe ingresar <b>Otro Instalador de Microchip</b>.<br>';
						}
						if ($.trim($("#gl_microchip"+i).val()) != '') {
							if ($.trim($("#gl_microchip"+i).val().length) != 15) {
								mensaje += '- El campo <b>Microchip</b> debe contener 15 caracteres.<br>';
							}
						}
                        if ($.trim($("#gl_microchip"+i).val()) == '' && $('input:radio[name=bo_sintomas_rabia'+i+']:checked').val() == 0) {
                            mensaje += '- El campo <b>Microchip</b> es Obligatorio.<br>';
                        }
                        if ($.trim($("#grilla-adjunto5-"+i).html()) == "" && $('input:radio[name=bo_sintomas_rabia'+i+']:checked').val() == 0) {
                            mensaje += '- El Certificado de <b>Microchip</b> es Obligatorio.<br>';
                        }
            /*
						if ($.trim($("#fc_microchip"+i).val()) == '') {
							mensaje += '- El campo <b>Fecha de Microchip</b> es Obligatorio.<br>';
						}
            */
						if ($.trim($("#id_animal_especie"+i).val()) == '') {
							mensaje += '- El campo <b>Especie</b> es Obligatorio.<br>';
						}
						/* 
						if ($.trim($("#grilla-adjunto5-"+i).html()) == '') {
							mensaje += '- El campo <b>Certificado Microchip</b> es Obligatorio.<br>';
						}
						if ($("#id_animal_raza"+i+" option:selected").val() === "0") {
							mensaje += '- Debe seleccionar <b>Raza</b> de Mordedor.<br>';
						}
						if ($.trim($("#nombre_mordedor"+i).val()) == '') {
							mensaje += '- El campo <b>Nombre</b> de Mordedor es Obligatorio.<br>';
						}
						if ($.trim($("#gl_color_animal"+i).val()) == '') {
							mensaje += '- El campo <b>Color</b> de Mordedor es Obligatorio.<br>';
						}
						if ($("#id_animal_tamano"+i+" option:selected").val() === "0") {
							mensaje += '- Debe seleccionar <b>Tamaño</b> de Mordedor.<br>';
						}
						if($('input:radio[name=id_estado_productivo'+i+']:checked').val() == null) {
							mensaje += '- Debe indicar <b>Estado Reproductivo</b> de Mordedor.<br>';						
						}
						*/
						if ($("#id_region_animal"+i+" option:selected").val() === "0") {
							mensaje += '- Debe seleccionar <b>Región</b> de Mordedor.<br>';
						}
						if ($("#id_comuna_animal"+i+" option:selected").val() === "0") {
							mensaje += '- Debe seleccionar <b>Comuna</b> de Mordedor.<br>';
						}
						if ($.trim($("#gl_direccion_mordedor"+i).val()) == '') {
							mensaje += '- El campo <b>Dirección</b> de Mordedor es Obligatorio.<br>';
						}
					
						if($('input:radio[name=bo_sintomas_rabia'+i+']:checked').val() == 0) {
							/* SINTOMAS RABIA NO */
							if ($("#bo_antirrabica_vigente"+i+" option:selected").val() === "-1") {
								mensaje += '- Debe seleccionar condición de la Vacuna Antirrábica <b>Al Momento de la Visita</b>.<br>';
							}
                            
                            if ($("#bo_antirrabica_vigente"+i).val() != 2 && $("#bo_antirrabica_vigente"+i).val() != 3 && $("#bo_antirrabica_vigente"+i).val() != 4) {
                                if ($("#bo_antirrabica_vigente"+i+" option:selected").val() === "4" && $.trim($("#gl_otro_vigencia"+i).val()) == '') {
                                    mensaje += '- Debe ingresar <b>Otra Vigencia</b>.<br>';
                                }
                                if ($("#id_laboratorio"+i+" option:selected").val() === "0") {
                                    mensaje += '- Debe seleccionar <b>Laboratorio</b>.<br>';
                                }
                                if ($("#id_medicamento"+i+" option:selected").val() === "0") {
                                    mensaje += '- Debe seleccionar el <b>Nombre Comercial de la Vacuna</b>.<br>';
                                }
                                if ($.trim($("#numero_certificado"+i).val()) == '') {
                                    mensaje += '- El campo <b>Número de Certificado</b> es Obligatorio.<br>';
                                }
                                if ($.trim($("#gl_numero_serie_vacuna"+i).val()) == '') {
                                    mensaje += '- El campo <b>Número de Serie</b> es Obligatorio.<br>';
                                }
                                if ($("#id_duracion_inmunidad"+i+" option:selected").val() === "0") {
                                    mensaje += '- Debe seleccionar <b>Duración Inmunidad</b>.<br>';
                                }
                                if ($.trim($("#fc_vacunacion"+i).val()) == '') {
                                    mensaje += '- El campo <b>Fecha Vacunación</b> es Obligatorio.<br>';
                                }
                            }
							/* 
							if ($.trim($("#grilla-adjunto6-"+i).html()) == '') {
								mensaje += '- El campo <b>Certificado Vacuna Antirrábica</b> es Obligatorio.<br>';
							} 
							*/
						}else{
							/* SINTOMAS RABIA SI */
							var val = [];
							$('input:checkbox[name="chk-sintomas'+i+'[]" ]:checked').each(function(idx){
								val[idx] = $(this).val();
							});
							if(val.length == 0) {
								mensaje += '- Debe seleccionar al menos un <b>Síntoma</b> de Rabia.<br>';
							}
							
							if ($.trim($("#grilla-adjunto3-"+i).html()) == '') {
								mensaje += '- El campo <b>Certificado Eutanasia</b> es Obligatorio.<br>';
							} 
							
						}
					}else{
						//console.log('gl_motivo_muerte '+$('input:radio[name=gl_motivo_muerte'+i+']:checked').val());
						/* Animal Muerto */
						if($('input:radio[name=gl_motivo_muerte'+i+']:checked').val() == undefined) {
							mensaje += '- Debe seleccionar el <b>Motivo de muerte</b><br>';
						}else if($('input:radio[name=gl_motivo_muerte'+i+']:checked').val() == 2) {
							var val = [];
							$('input:checkbox[name="chk-sintomas'+i+'[]" ]:checked').each(function(idx){
								val[idx] = $(this).val();
							});
							if(val.length == 0) {
								mensaje += '- Debe seleccionar al menos un <b>Síntoma</b> de Rabia.<br>';
							}
						}
					}
					
					
					/* Dueño */
					if($('input:radio[name=bo_extranjero'+i+']:checked').val() == 0) {
						if ($.trim($("#gl_rut"+i).val()) == '') {
							mensaje += '- El campo <b>RUT</b> del Propietario es Obligatorio.<br>';
						}
					}else{
						if($('input:radio[name=emitidoChile'+i+']:checked').val() == 1) {
							if ($.trim($("#gl_rut"+i).val()) == '') {
								mensaje += '- El campo <b>RUT</b> del Propietario es Obligatorio.<br>';
							}
						}else{
							if ($.trim($("#gl_pasaporte"+i).val()) == '') {
								mensaje += '- El campo <b>Identificación (PASAPORTE)</b> es Obligatorio.<br>';
							}
						}
					}
					if ($("#region_propietario"+i).val() == 0) {
						mensaje += '- El campo <b>Región Propietario</b> es Obligatorio.<br>';
					}
					if ($("#comuna_propietario"+i).val() == 0) {
						mensaje += '- El campo <b>Comuna Propietario</b> es Obligatorio.<br>';
					}
					if ($.trim($("#direccion_propietario"+i).val()) == '') {
						mensaje += '- El campo <b>Dirección Propietario</b> es Obligatorio.<br>';
					}
				   
					if(mensaje != ''){
						mensaje         = folio_mordedor + mensaje + '<br>';
						mensaje_error   += mensaje;
					}
					mensaje         = '';
				}
			}
        }

        if(mensaje_error != ""){
            xModal.danger(mensaje_error,function(){buttonEndProcess(button_process);});
        }else {
            $.ajax({
                dataType: "json",
                cache	: false,
                async	: true,
                data	: parametros,
                type	: "post",
                url		: BASE_URI + "index.php/Informar/guardarFiscalizacion",
                error	: function (xhr, textStatus, errorThrown) {
							buttonEndProcess(button_process);
							xModal.danger('Error: No se pudo Ingresar un nuevo Registro');
						},
                success	: function (data) {
							buttonEndProcess(button_process);
							if (data.correcto) {
								xModal.success('Éxito: ' + data.mensaje,function(){ 
									//location.reload();
									location.href = BASE_URI + "index.php/Paciente/index";
								});
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
            $("#lbl_fecha_eutanasia"+num).html("Fecha Eutanasia");
            $("#lbl_certificado_eutanasia"+num).html("Certificado Eutanasia");
            $("#lbl_certificado_eutanasia"+num).addClass("required");
		} else if($("input.bo_sintomas_rabia"+num+":checked").val() == "0") {
			$(".sintoma_si"+num).hide();
			$(".sintoma_no"+num).show();
		}
	},
	
	visitaEstadoBtn: function(radio_input) {
		if(radio_input.value == "2") {
			$('#div_mordedores').show();
			$('#div_datos_realizada').show();
			$('#div_datos_perdida').hide();
		}else{
			$('#div_mordedores').hide();
			$('#div_datos_realizada').hide();
			$('#div_datos_perdida').show();
		}
	},
	
	visitaPerdidaMotivo: function(select_input) {
		if(select_input.value == "4") { //OTRO
			$('#input_otro_perdida').show();
			$('#div_volvera_visitar').show();
        }else if(select_input.value == "2" || select_input.value == "5") { //SIN MORADORES O ANIMAL NO ENCONTRADO
			$('#div_volvera_visitar').show();
		}else{
			$('#input_otro_perdida').hide();
			$('#div_volvera_visitar').hide();
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
            $("#lbl_fecha_eutanasia"+num).html("Fecha Eutanasia");
            $("#lbl_certificado_eutanasia"+num).html("Certificado Eutanasia");
            $("#lbl_certificado_eutanasia"+num).addClass("required");
		}if(radio_input.value == "2") {
			$('#div_motivo_muerte_mordedor'+num).show();
			$('#div_microchip_mordedor'+num).hide();
			$('#div_informacion_mordedor'+num).hide();
			$('#div_direccon_mordedor'+num).hide();
            $("#lbl_fecha_eutanasia"+num).html("Fecha de Muerte");
            $("#lbl_certificado_eutanasia"+num).html('Certificado Entrega Cuerpo &nbsp; <i class="fa fa-question-circle" title="Adjuntar solo si se cuenta con el cadaver."></i>');
            $("#lbl_certificado_eutanasia"+num).removeClass("required");
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
			
			var x = document.getElementsByName("bo_sintomas_rabia"+num);
			x[1].checked	= true;
			x[1].disabled	= false;
			
		}
	},
	duracionInmunidad: function(radio_input,combo) {
		if(radio_input.val() != ''){
			var num		= $(radio_input).data('cant');
			var vec		= radio_input.val().split('/');
			var aum		= 0;

			if($('#id_duracion_inmunidad'+num).val() == 4){
				aum		= $('#gl_duracion_inmunidad_otro'+num).val();
			}else{
				aum		= $('#id_duracion_inmunidad'+num).val();
			}

			var year	= parseInt(vec[2]) + parseInt(aum);
			var fc		= vec[0]+'/'+vec[1]+'/'+year;

			$('#'+combo).val(fc);
		}
	},
	mostrar_divOtroLaboratorio: function(id_laboratorio,cont) {
		if(id_laboratorio == 1) {
			$('#div_laboratorio_otro'+cont).show();
		}else{
			$('#div_laboratorio_otro'+cont).hide();
		}
	},
	mostrar_divOtroMedicamento: function(id_medicamento,cont) {
		if(id_medicamento == 1) {
			$('#div_medicamento_otro'+cont).show();
		}else{
			$('#div_medicamento_otro'+cont).hide();
		}
	},
	mostrar_divOtroDuracionInmunidad: function(id_duracion_inmunidad,cont) {
		if(id_duracion_inmunidad == 4) {
			$('#div_duracion_inmunidad_otro'+cont).show();
		}else{
			$('#div_duracion_inmunidad_otro'+cont).hide();
		}
	},
    cambioVacunaVigencia : function(id,cont) {
        
        $("#div_preguntas_vacuna_pt1"+cont).show();
        $("#div_preguntas_vacuna_pt2"+cont).show();
        
        if(id == 4){
            $("#div_otro_vigencia"+cont).show();
        }else{
            $("#div_otro_vigencia"+cont).hide();
            $("#gl_otro_vigencia"+cont).val("");
        }
        
        if(id == 2 || id == 3 || id == 4){ //Pendiente oculta las demás preguntas de vacuna
            $("#div_preguntas_vacuna_pt1"+cont).hide();
            $("#div_preguntas_vacuna_pt2"+cont).hide();
            
            //Limpiar datos vacuna
            $("#id_laboratorio"+cont).val("0");
            $("#id_medicamento"+cont).val("0");
            $("#numero_certificado"+cont).val("");
            $("#gl_numero_serie_vacuna"+cont).val("");
            $("#id_duracion_inmunidad"+cont).val("0");
            $("#id_duracion_inmunidad"+cont).val("0");
            $("#fc_vacunacion"+cont).val("");
            $("#fc_proxima_vacunacion"+cont).val("");
        }
        
        if(id == 0){
            $("#fc_vacunacion"+cont).datepicker("destroy");
            $("#fc_vacunacion"+cont).datepicker({
                locale: "es",
                format: "DD/MM/YYYY",
                useCurrent: false,
                inline: false
            });
        }else{
            $("#fc_vacunacion"+cont).datepicker("destroy");
            $("#fc_vacunacion"+cont).datepicker({
                locale: "es",
                format: "DD/MM/YYYY",
                useCurrent: false,
                inline: false,
                maxDate: 'now'
            });
        }
    },
    cambioInstaladorMicrochip : function(id,cont) {
        if(id == 4){
            $("#div_otro_instalador_microchip"+cont).show();
        }else{
            $("#div_otro_instalador_microchip"+cont).hide();
            $("#gl_otro_instalador_microchip"+cont).val("");
        }
    },
    tieneMicrochipInstalado : function(cont) {
        if($("input.bo_microchipInstalado"+cont+":checked").val() == "1") {
			$("#div_instalador_microchip"+cont).show();
            //$("#fc_microchip"+cont).prop("disabled",false);
            $("#fc_microchip"+cont).datepicker({
                locale: "es",
                format: "DD/MM/YYYY",
                useCurrent: false,
                inline: false
            });
		} else if($("input.bo_microchipInstalado"+cont+":checked").val() == "0") {
			$("#div_instalador_microchip"+cont).hide();
            $("#instalador_microchip"+cont).val("0");
            //$("#fc_microchip"+cont).prop("disabled",true);
            $("#fc_microchip"+cont).datepicker("destroy");
		}
    },
    cambiaEdad : function(cont) {
        if($("#nr_edad"+cont).val() == 0 && $("#nr_edad_meses"+cont).val() < 2) {
			$("#bo_antirrabica_vigente"+cont).val("3").trigger("change");
		} else {
			$("#bo_antirrabica_vigente"+cont).val("-1").trigger("change");
		}
    },
    revisarPropietario: function (cont) {
        var rut = $("#gl_rut"+cont).val();
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: {rut: rut},
            type: "post",
            url: BASE_URI + "index.php/Paciente/revisarExistePaciente",
            error: function (xhr, textStatus, errorThrown) {
                //xModal.danger('Error al Buscar');
            },
            success: function (data) {
                $("#gl_nombre_propietario"+cont).val(data.gl_nombres);
                $("#apell_paterno_propietario"+cont).val(data.gl_apellido_paterno);
                $("#apell_materno_propietario"+cont).val(data.gl_apellido_materno);
            }
        });
    },
    buscarMicrochip: function (cont) {
        var gl_microchip        = $("#gl_microchip"+cont).val();
        var gl_folio_mordedor   = $("#gl_folio_mordedor"+cont).val();
        
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: {gl_microchip: gl_microchip, gl_folio_mordedor: gl_folio_mordedor},
            type: "post",
            url: BASE_URI + "index.php/Informar/revisarMicrochip",
            error: function (xhr, textStatus, errorThrown) {
                //xModal.danger('Error al Buscar');
            },
            success: function (data) {
                if(data.correcto){
                    $("#fc_microchip"+cont).val(data.fc_microchip);
                    $("#id_animal_especie"+cont).val(data.id_animal_especie);
                    $("#id_animal_raza"+cont).val(data.id_animal_raza);
                    $("#nombre_mordedor"+cont).val(data.gl_nombre);
                    $("#gl_color_animal"+cont).val(data.gl_color_animal);
                    $("#id_animal_tamano"+cont).val(data.id_animal_tamano);
                    $("#nr_edad"+cont).val(data.nr_edad);
                    $("#nr_edad_meses"+cont).val(data.nr_edad_meses).trigger("change");
                    $("#nr_peso"+cont).val(data.nr_peso);
                    $("#gl_apariencia"+cont).val(data.gl_apariencia);
                    $('input:radio[name=id_animal_sexo0]').prop("checked",false);
                    $('input:radio[name=id_animal_sexo0][value='+data.id_animal_sexo+']').prop("checked",true);
                    $('input:radio[name=id_estado_productivo0]').prop("checked",false);
                    $('input:radio[name=id_estado_productivo0][value='+data.id_estado_productivo+']').prop("checked",true);
                    $("#id_region_animal"+cont).val(data.id_region).trigger("change");
                    setTimeout(function(){$("#id_comuna_animal"+cont).val(data.id_comuna);},500);
                    $("#gl_direccion_animal"+cont).val(data.gl_direccion);
                    $("#gl_referencias_animal"+cont).val(data.gl_direccion_detalle);
                }else{
                    var d       = new Date();
                    var month   = d.getMonth()+1;
                    var day     = d.getDate();
                    var fecha   = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear();

                    $("#fc_microchip"+cont).val(fecha);
                    $("#id_animal_especie"+cont).val(data.id_animal_especie);
                    $("#id_animal_raza"+cont).val(data.id_animal_raza);
                    $("#nombre_mordedor"+cont).val(data.gl_nombre);
                    $("#gl_color_animal"+cont).val(data.gl_color_animal);
                    $("#id_animal_tamano"+cont).val(data.id_animal_tamano);
                    $("#nr_edad"+cont).val("");
                    $("#nr_edad_meses"+cont).val("").trigger("change");
                    $("#nr_peso"+cont).val("");
                    $("#gl_apariencia"+cont).val("");
                    $('input:radio[name=id_animal_sexo0]').prop("checked",false);
                    $('input:radio[name=id_estado_productivo0]').prop("checked",false);
                    $("#id_region_animal"+cont).val(data.id_region).trigger("change");
                    setTimeout(function(){$("#id_comuna_animal"+cont).val(data.id_comuna);},500);
                    $("#gl_direccion_animal"+cont).val(data.gl_direccion);
                    $("#gl_referencias_animal"+cont).val(data.gl_direccion_detalle);
                }
            }
        });
    },
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
			extensiones_permitidas = new Array('.jpeg', '.jpg', '.png', '.gif', '.pdf', '.doc', '.docx',
											   '.JPEG', '.JPG', '.PNG', '.GIF', '.PDF', '.DOC', '.DOCX');
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
                    url			: BASE_URI + "index.php/Informar/guardarNuevoAdjunto",
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
	$(":checkbox").labelauty();
	$(":radio").labelauty();

	//setTimeout(function() {
		$(".fc_clase").datepicker({
			locale: "es",
			format: "DD/MM/YYYY",
			useCurrent: false,
			inline: false
		});
		$(".fc_vacunacion_clase").datepicker({
			locale: "es",
			format: "DD/MM/YYYY",
			useCurrent: false,
			inline: false,
            maxDate: 'now'
		});
	//}, 300);

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

