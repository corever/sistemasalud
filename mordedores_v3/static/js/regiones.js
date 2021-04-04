/* global BASE_URI */

var Region ={
    
    cargarComunasPorRegion : function(region,combo,comuna){
        //console.log(region);
		if(region != 0){
			$.post(BASE_URI+'index.php/Regiones/cargarComunasPorRegion',{region:region},function(response){
				if(response.length > 0){
					var total = response.length;
					var options = '<option value="0">Seleccione una Comuna</option>';
					for(var i=0; i<total; i++){
						if(comuna == response[i].id_comuna){
							options += '<option value="'+response[i].id_comuna+'" id="'+response[i].gl_latitud_comuna+'" name="'+response[i].gl_longitud_comuna+'" selected >'+response[i].nombre_comuna+'</option>';	
						}else{
							options += '<option value="'+response[i].id_comuna+'" id="'+response[i].gl_latitud_comuna+'" name="'+response[i].gl_longitud_comuna+'" >'+response[i].nombre_comuna+'</option>';
						}
						
					}
					$('#'+combo).html(options);
				}
			},'json');
		}else{
                    $('#'+combo).html('<option value="0">Seleccione una Comuna</option>');
		}
	},
    
    cargarServicioPorRegion : function(region,combo,servicio){
        //console.log(region);
		if(region != 0){
			$.post(BASE_URI+'index.php/Regiones/cargarServicioPorRegion',{region:region},function(response){
				if(response.length > 0){
					var total = response.length;
					var options = '<option value="0">Seleccione Servicio</option>';
					for(var i=0; i<total; i++){
						if(servicio == response[i].id_servicio){
							options += '<option value="'+response[i].id_servicio+'">'+response[i].gl_nombre+'</option>';	
						}else{
							options += '<option value="'+response[i].id_servicio+'">'+response[i].gl_nombre+'</option>';
						}
						
					}
					$('#'+combo).html(options);
				}
			},'json');
		}else{
                    $('#'+combo).html('<option value="0">Seleccione Servicio</option>');
		}
	},
    
    cargarOficinaByRegion : function(region,combo,oficina){
        if($('#'+combo).attr("disabled")===undefined){
            $.post(BASE_URI + "index.php/Regiones/cargarOficinasPorRegion",{region:region},function(response){
                if(response.length > 0){
                    var total = response.length;
                    var options = '<option value="0"> Todas </option>';
                    for(var i=0; i<total; i++){
                        if(oficina == response[i].id_oficina){
                            options += '<option value="'+response[i].id_oficina+'"  selected >'+response[i].nombre_oficina+'</option>';	
                        }else{
                            options += '<option value="'+response[i].id_oficina+'" >'+response[i].nombre_oficina+'</option>';
                        }

                    }
                    $('#'+combo).html(options);
                }
            },'json');
            $('#'+combo).html('<option value=""> Todas </option>');
        }
	},
	
    cargarOficinaPorProvincia : function(provincias,combo,oficinas){		 
		if(region != 0){
			$.post(BASE_URI + 'index.php/MantenedorPlanificacion/cargarOficinaPorProvincia',{provincias:provincias},function(response){
				  if(response.length > 0){
					var total = response.length;					
					var options = '<option value="0">-- Seleccione --</option>';
					for(var i=0; i<total; i++){
						if(oficinas == response[i].id_oficina){
							options += '<option value="'+response[i].id_oficina+'" selected >'+response[i].nombre_oficina+'</option>';	
						}else{
							options += '<option value="'+response[i].id_oficina+'">'+response[i].nombre_oficina+'</option>';
						}						
					}
					$('#'+combo).html(options);
				}
			},'json');
		}else{
			$('#'+combo).html('').trigger('onchange');
		}
	},
	
	cargarCentroSaludporComuna: function (comuna, combo, centrosalud, mensaje = 'Todos') {
		if (comuna != 0) {
			$.post(BASE_URI + 'index.php/Paciente/cargarEstablecimientoSaludporComuna', {comuna: comuna}, function (response) {
				var options = '<option value="0"> '+mensaje+' </option>';
				$.each(response, function (i, valor) {
					if (centrosalud == valor.id_establecimiento) {
						options += '<option value="' + valor.id_establecimiento + '" selected >' + valor.gl_nombre_establecimiento + '</option>';
					} else {
						options += '<option value="' + valor.id_establecimiento + '">' + valor.gl_nombre_establecimiento + '</option>';
					}
				});
				$('#' + combo).html(options);

			}, 'json');
		} else {
			$('#' + combo).html('<option value="0"> '+mensaje+' </option>');
		}
	},
	
	cargarEstableSaludporRegion: function (region, combo, establecimientosalud, mensaje = 'Todos') {
		if (region != 0) {
			$.post(BASE_URI + 'index.php/Regiones/cargarEstablecimientoSaludporRegion', {region: region}, function (response) {
				var options = '<option value="0"> '+mensaje+' </option>';
				$.each(response, function (i, valor) {
					if (establecimientosalud == valor.id_establecimiento) {
						options += '<option value="' + valor.id_establecimiento + '" selected >' + valor.gl_nombre_establecimiento + '</option>';
					} else {
						options += '<option value="' + valor.id_establecimiento + '">' + valor.gl_nombre_establecimiento + '</option>';
					}
				});
				$('#' + combo).html(options);

			}, 'json');
		} else {
			$('#' + combo).html('<option value="0"> '+mensaje+' </option>');
		}
	},
	
	cargarEstableSaludporOficina: function (oficina, combo, establecimientosalud) {
		if (oficina != 0) {
			$.post(BASE_URI + 'index.php/Regiones/cargarEstablecimientoSaludporOficina', {oficina: oficina}, function (response) {
				var options = '<option value="0"> Todos </option>';
				$.each(response, function (i, valor) {
					if (establecimientosalud == valor.id_establecimiento) {
						options += '<option value="' + valor.id_establecimiento + '" selected >' + valor.gl_nombre_establecimiento + '</option>';
					} else {
						options += '<option value="' + valor.id_establecimiento + '">' + valor.gl_nombre_establecimiento + '</option>';
					}
				});
				$('#' + combo).html(options);

			}, 'json');
		} else {
			$('#' + combo).html('<option value="0"> Todos </option>');
		}
	},
	
	cargarEstableSaludporServicio: function (servicio, combo, establecimientosalud) {
		if (servicio != 0) {
			$.post(BASE_URI + 'index.php/Regiones/cargarEstablecimientoSaludporServicio', {servicio: servicio}, function (response) {
				var options = '<option value="0"> Todos </option>';
				$.each(response, function (i, valor) {
					if (establecimientosalud == valor.id_establecimiento) {
						options += '<option value="' + valor.id_establecimiento + '" selected >' + valor.gl_nombre_establecimiento + '</option>';
					} else {
						options += '<option value="' + valor.id_establecimiento + '">' + valor.gl_nombre_establecimiento + '</option>';
					}
				});
				$('#' + combo).html(options);

			}, 'json');
		} else {
			$('#' + combo).html('<option value="0"> Todos </option>');
		}
	},
    
    cargarComunaByOficina : function(oficina,combo,comuna){

		$.post(BASE_URI + 'index.php/Regiones/cargarComunaporOficina',{oficina:oficina},function(response){

			if(response.length > 0){
				var total = response.length;
				var options = '<option value=""> Todas </option>';
				for(var i=0; i<total; i++){
					if(comuna == response[i].id_comuna){
						options += '<option value="'+response[i].id_comuna+'"  selected >'+response[i].nombre_comuna+'</option>';	
					}else{
						options += '<option value="'+response[i].id_comuna+'" >'+response[i].nombre_comuna+'</option>';
					}

				}
				$('#'+combo).html(options);
			}
		},'json');
		$('#'+combo).html('<option value=""> Todas </option>');
	},
    
    cargarFiscalizadorPorRegion: function (region, combo, fiscalizador) {
		if (region != 0) {
			$.post(BASE_URI + 'index.php/Regiones/cargarFiscalizadorporRegion', {region: region}, function (response) {
				var options = '<option value="0"> Seleccione un Fiscalizador </option>';
				$.each(response, function (i, valor) {
					if (fiscalizador == valor.id_fiscalizador) {
						options += '<option value="' + valor.id_fiscalizador + '" selected >' + valor.gl_fiscalizador + '</option>';
					} else {
						options += '<option value="' + valor.id_fiscalizador + '">' + valor.gl_fiscalizador + '</option>';
					}
				});
				$('#' + combo).html(options);

			}, 'json');
		} else {
			$('#' + combo).html('<option value="0"> Seleccione un Fiscalizador </option>');
		}
	},
    
    cargarFiscalizadorPorOficina: function (oficina, combo, fiscalizador) {
		if (oficina != 0) {
			$.post(BASE_URI + 'index.php/Regiones/cargarFiscalizadorPorOficina', {oficina: oficina}, function (response) {
				var options = '<option value=""> Seleccione un Fiscalizador </option>';
				$.each(response, function (i, valor) {
					if (fiscalizador == valor.id_fiscalizador) {
						options += '<option value="' + valor.id_fiscalizador + '" selected >' + valor.gl_fiscalizador + '</option>';
					} else {
						options += '<option value="' + valor.id_fiscalizador + '">' + valor.gl_fiscalizador + '</option>';
					}
				});
				$('#' + combo).html(options);

			}, 'json');
		} else {
			$('#' + combo).html('<option value=""> Seleccione un Fiscalizador </option>');
		}
	},
    
    cargarFiscalizadorPorComuna: function (comuna, combo, fiscalizador) {
		if (comuna != 0) {
			$.post(BASE_URI + 'index.php/Regiones/cargarFiscalizadorPorComuna', {comuna: comuna}, function (response) {
				var options = '<option value=""> Seleccione un Fiscalizador </option>';
				$.each(response, function (i, valor) {
					if (fiscalizador == valor.id_fiscalizador) {
						options += '<option value="' + valor.id_fiscalizador + '" selected >' + valor.gl_fiscalizador + '</option>';
					} else {
						options += '<option value="' + valor.id_fiscalizador + '">' + valor.gl_fiscalizador + '</option>';
					}
				});
				$('#' + combo).html(options);

			}, 'json');
		} else {
			$('#' + combo).html('<option value=""> Seleccione un Fiscalizador </option>');
		}
	}

};