/* global url_site */

var Region = {

	cargarComunasPorRegion: function (region, combo, comuna) {
		//console.log(region);
		//if(region != 0){
		$.post(Base.getBaseUri() + '_FuncionesGenerales/General/Regiones/cargarComunasPorRegion', { region: region }, function (response) {
			if (response.length > 0) {
				var total = response.length;
				var options = '<option value="0">Seleccione una Comuna</option>';
				for (var i = 0; i < total; i++) {
					if (comuna == response[i].id_comuna) {
						options += '<option value="' + response[i].id_comuna + '" id="' + response[i].gl_latitud_comuna + '" name="' + response[i].gl_longitud_comuna + '" data-region="' + response[i].id_region + '" data-latitud="' + response[i].gl_latitud + '" data-longitud="' + response[i].gl_longitud + '" selected >' + response[i].nombre_comuna + '</option>';
					} else {
						options += '<option value="' + response[i].id_comuna + '" id="' + response[i].gl_latitud_comuna + '" name="' + response[i].gl_longitud_comuna + '" data-region="' + response[i].id_region + '" data-latitud="' + response[i].gl_latitud + '" data-longitud="' + response[i].gl_longitud + '" >' + response[i].nombre_comuna + '</option>';
					}

				}
				$('#' + combo).html(options);
			}
		}, 'json');
		/*}else{
					$('#'+combo).html('<option value="0">Seleccione una Comuna</option>');
		}*/
	},

	cargarOficinasPorRegion: function (region, combo, oficina) {
		if ($('#' + combo).attr("disabled") === undefined) {
			$.post(url_site + "_FuncionesGenerales/General/Regiones/cargarOficinasPorRegion", { region: region }, function (response) {
				if (response.length > 0) {
					var total = response.length;
					var options = '<option value="0"> Todas </option>';
					for (var i = 0; i < total; i++) {
						if (oficina == response[i].id_oficina) {
							options += '<option value="' + response[i].id_oficina + '"  selected >' + response[i].nombre_oficina + '</option>';
						} else {
							options += '<option value="' + response[i].id_oficina + '" >' + response[i].nombre_oficina + '</option>';
						}

					}
					$('#' + combo).html(options);
				}
			}, 'json');
			$('#' + combo).html('<option value=""> Todas </option>');
		}
	},

	cargarComunasPorOficina: function (oficina, combo, comuna) {

		$.post(url_site + '_FuncionesGenerales/General/Regiones/cargarComunasPorOficina', { oficina: oficina }, function (response) {

			if (response.length > 0) {
				var total = response.length;
				var options = '<option value=""> Todas </option>';
				for (var i = 0; i < total; i++) {
					if (comuna == response[i].id_comuna) {
						options += '<option value="' + response[i].id_comuna + '"  selected >' + response[i].nombre_comuna + '</option>';
					} else {
						options += '<option value="' + response[i].id_comuna + '" >' + response[i].nombre_comuna + '</option>';
					}

				}
				$('#' + combo).html(options);
			}
		}, 'json');
		$('#' + combo).html('<option value=""> Todas </option>');
	},

	cargarFiscalizadorPorRegion: function (region, combo, fiscalizador) {
		if (region != 0) {
			$.post(url_site + '_FuncionesGenerales/General/Regiones/cargarFiscalizadorporRegion', { region: region }, function (response) {
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
			$.post(url_site + '_FuncionesGenerales/General/Regiones/cargarFiscalizadorPorOficina', { oficina: oficina }, function (response) {
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
			$.post(url_site + '_FuncionesGenerales/General/Regiones/cargarFiscalizadorPorComuna', { comuna: comuna }, function (response) {
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

	cambioRegionPorComuna: function (comuna, region) {
		let id_region_comuna = $("#" + comuna).find(":selected").data('region');
		let id_region = $("#" + region).val();

		if (id_region_comuna > 0 && id_region != id_region_comuna) {
			$("#" + region).val(id_region_comuna);
		}
	},

	cargarTerritorioPorRegion: function (region, combo, territorio) {
		//console.log(region);
		//if(region != 0){
		$.post(Base.getBaseUri() + '_FuncionesGenerales/General/Regiones/cargarTerritorioPorRegion', { region: region }, function (response) {
			if (response.length > 0) {
				var total = response.length;
				var options = '<option value="0">Seleccione un Territorio</option>';
				for (var i = 0; i < total; i++) {
					if (territorio == response[i].id_territorio) {
						options += '<option value="' + response[i].id_territorio + '" data-region="' + response[i].id_region + '" selected >' + response[i].nombre_territorio + '</option>';
					} else {
						options += '<option value="' + response[i].id_territorio + '" data-region="' + response[i].id_region + '" >' + response[i].nombre_territorio + '</option>';
					}

				}
				$('#' + combo).html(options);
			}
		}, 'json');
		/*}else{
					$('#'+combo).html('<option value="0">Seleccione una Comuna</option>');
		}*/
	},

	cargarBodegaPorTerritorio: function (territorio, combo, bodega, region = 0) {
		//console.log(region);
		//if(region != 0){
		$.post(Base.getBaseUri() + '_FuncionesGenerales/General/Regiones/cargarBodegaPorTerritorio', { territorio: territorio, region: region }, function (response) {
			if (response.length > 0) {
				var total = response.length;
				var options = '<option value="0">Seleccione una Bodega</option>';
				for (var i = 0; i < total; i++) {
					if (bodega == response[i].id_bodega) {
						options += '<option value="' + response[i].id_bodega + '" data-territorio="' + response[i].id_territorio + '" selected >' + response[i].nombre_bodega + '</option>';
					} else {
						options += '<option value="' + response[i].id_bodega + '" data-territorio="' + response[i].id_territorio + '" >' + response[i].nombre_bodega + '</option>';
					}

				}
				$('#' + combo).html(options);
			}
		}, 'json');
		/*}else{
					$('#'+combo).html('<option value="0">Seleccione una Comuna</option>');
		}*/
	},

	cargarFarmaciasPorRegion: function (region, combo, farmacia) {
		//console.log(region);
		//if(region != 0){
		$.post(Base.getBaseUri() + '_FuncionesGenerales/General/Regiones/cargarFarmaciasPorRegion', { region: region }, function (response) {
			if (response.length > 0) {
				var total = response.length;
				var options = '<option value="0">Seleccione una Farmacia</option>';
				for (var i = 0; i < total; i++) {
					if (farmacia == response[i].id_farmacia) {
						options += '<option value="' + response[i].id_farmacia + '" data-region="' + response[i].id_region + '" selected >' + response[i].nombre_farmacia + '</option>';
					} else {
						options += '<option value="' + response[i].id_farmacia + '" data-region="' + response[i].id_region + '" >' + response[i].nombre_farmacia + '</option>';
					}

				}
				$('#' + combo).html(options);
			}
		}, 'json');
		/*}else{
					$('#'+combo).html('<option value="0">Seleccione una Farmacia</option>');
		}*/
	},

	cargarCodigosFonoPorRegion: function (region, combo, codigo) {
		$.post(Base.getBaseUri() + '_FuncionesGenerales/General/Regiones/cargarCodigosFonoPorRegion', { region: region }, function (response) {
			if (response.length > 0) {
				var total = response.length;
				var options = '<option value="0">Seleccione</option>';
				for (var i = 0; i < total; i++) {
					if (codigo == response[i].codfono_id) {
						options += '<option value="' + response[i].codfono_id + '" selected >' + response[i].codigo_formato + '</option>';
					} else {
						options += '<option value="' + response[i].codfono_id + '">' + response[i].codigo_formato + '</option>';
					}
				}
				$('#' + combo).html(options);
			}
		}, 'json');
	},

	cargarLocalidadPorComuna: function (comuna, combo, localidad) {
		if (comuna != 0) {
			$.post(Base.getBaseUri() + '_FuncionesGenerales/General/Regiones/cargarLocalidadPorComuna', { comuna: comuna }, function (response) {
				var options = '<option value=""> Seleccione una Localidad </option>';
				$.each(response, function (i, valor) {
					if (localidad == valor.localidad_id) {
						options += '<option value="' + valor.localidad_id + '" selected >' + valor.localidad_nombre + '</option>';
					} else {
						options += '<option value="' + valor.localidad_id + '">' + valor.localidad_nombre + '</option>';
					}
				});
				$('#' + combo).html(options);
			}, 'json');
		} else {
			$('#' + combo).html('<option value=""> Seleccione una Localidad </option>');
		}
	},

	cargarComunasPorTerritorio: function (territorio, combo, comuna) {

		$.post(Base.getBaseUri() + '_FuncionesGenerales/General/Regiones/cargarComunasPorTerritorio', { territorio: territorio }, function (response) {

			if (response.length > 0) {
				var total = response.length;
				var options = '<option value=""> Seleccione una comuna </option>';
				for (var i = 0; i < total; i++) {
					if (comuna == response[i].comuna_id) {
						options += '<option value="' + response[i].comuna_id + '"  selected >' + response[i].comuna_nombre + '</option>';
					} else {
						options += '<option value="' + response[i].comuna_id + '" >' + response[i].comuna_nombre + '</option>';
					}

				}
				$('#' + combo).html(options);
			}
		}, 'json');
		$('#' + combo).html('<option value=""> Seleccione una comuna </option>');
	},

	cargarComunasConEstablecimientoUrgenciaPorRegion: function (region, combo, comuna) {

		if (region != 0) {
			$.post(Base.getBaseUri() + '_FuncionesGenerales/General/Regiones/cargarComunasConEstablecimientoUrgenciaPorRegion', { region: region }, function (response) {
				if (response.length > 0) {
					var total = response.length;
					var options = '<option value="0">Seleccione una Comuna</option>';
					for (var i = 0; i < total; i++) {
						if (comuna == response[i].id_comuna) {
							options += '<option value="' + response[i].id_comuna + '" id="' + response[i].gl_latitud_comuna + '" name="' + response[i].gl_longitud_comuna + '" selected >' + response[i].nombre_comuna + '</option>';
						} else {
							options += '<option value="' + response[i].id_comuna + '" id="' + response[i].gl_latitud_comuna + '" name="' + response[i].gl_longitud_comuna + '" >' + response[i].nombre_comuna + '</option>';
						}

					}
					$('#' + combo).html(options);
				} else {
					var options = '<option value="0">No existen Comunas para ' + $('#id_region :selected').text() + '.</option>';
					$('#' + combo).html(options);
				}
			}, 'json');
		} else {
			$('#' + combo).html('<option value="0">Seleccione una Comuna</option>');
		}
	},
	/**
	 * <ricardo.munoz at cosof> 29/09/2020
	 * @param {int} comuna 
	 * @param {elem} combo 
	 * @param {int} establecimiento 
	 */
	cargarEstablecimientoUrgenciaPorComuna: function (comuna, combo, establecimiento) {

		if (comuna != 0) {
			$.post(Base.getBaseUri() + '_FuncionesGenerales/General/Regiones/cargarListaEstablecimientoUrgenciaByComunaActivo'
				, { comuna: comuna }, function (response) {
					if (response.length > 0) {
						var total = response.length;
						var options = '<option value="0">Seleccione un Establecimiento Urgencia</option>';
						for (var i = 0; i < total; i++) {
							options += '<option value="'
								+ response[i].local_id
								+ '"';
							if (establecimiento == response[i].id_comuna) {
								options += ' selected ';
							}
							options += ' >'
								+ response[i].local_nombre
								+ ' - '
								+ response[i].local_direccion
								+ '</option>';

						}
						$('#' + combo).html(options);
					} else {
						var options = '<option value="0">No existen Establecimientos Urgencia para ' + $('#id_comuna :selected').text() + '.</option>';
						$('#' + combo).html(options);
					}
				}, 'json');
		} else {
			$('#' + combo).html('<option value="0">Seleccione un Establecimiento Urgencia</option>');
		}
	},
};