/* global Base.getBaseUri() */

var Region = {

	cargarComunasPorRegion: function (region, combo, comuna) {
		//console.log(region);
		if (region != 0) {
			$.post(Base.getBaseUri() + 'index.php/General/Regiones/cargarComunasPorRegion', { region: region }, function (response) {
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
				}
			}, 'json');
		} else {
			$('#' + combo).html('<option value="0">Seleccione una Comuna</option>');
		}
	},

	cargarServicioPorRegion: function (region, combo, servicio) {
		//console.log(region);
		if (region != 0) {
			$.post(Base.getBaseUri() + 'index.php/General/Regiones/cargarServicioPorRegion', { region: region }, function (response) {
				if (response.length > 0) {
					var total = response.length;
					var options = '<option value="0">Seleccione Servicio</option>';
					for (var i = 0; i < total; i++) {
						if (servicio == response[i].id_servicio) {
							options += '<option value="' + response[i].id_servicio + '">' + response[i].gl_nombre + '</option>';
						} else {
							options += '<option value="' + response[i].id_servicio + '">' + response[i].gl_nombre + '</option>';
						}

					}
					$('#' + combo).html(options);
				}
			}, 'json');
		} else {
			$('#' + combo).html('<option value="0">Seleccione Servicio</option>');
		}
	},

	cargarOficinaByRegion: function (region, combo, oficina, callback = null) {

		if ($('#' + combo).attr("disabled") === undefined) {
			$.post(Base.getBaseUri() + "index.php/General/Regiones/cargarOficinasPorRegion", { region: region }, function (response) {

				if (response.length > 0) {
					var total = response.length;
					var options = '<option value="0">-- Seleccione --</option>';
					for (var i = 0; i < total; i++) {
						if (oficina == response[i].id_oficina) {
							options += '<option value="' + response[i].id_oficina + '"  selected >' + response[i].nombre_oficina + '</option>';
						} else {
							options += '<option value="' + response[i].id_oficina + '" >' + response[i].nombre_oficina + '</option>';
						}

					}
					$('#' + combo).html(options);
					if (callback && typeof callback === "function") {
						callback();
					}
				}
			}, 'json');
			$('#' + combo).html('<option value="0">-- Seleccione --</option>');
		}
	},

	cargarOficinaPorProvincia: function (provincias, combo, oficinas) {
		if (region != 0) {
			$.post(Base.getBaseUri() + 'index.php/MantenedorPlanificacion/cargarOficinaPorProvincia', { provincias: provincias }, function (response) {
				if (response.length > 0) {
					var total = response.length;
					var options = '<option value="0">-- Seleccione --</option>';
					for (var i = 0; i < total; i++) {
						if (oficinas == response[i].id_oficina) {
							options += '<option value="' + response[i].id_oficina + '" selected >' + response[i].nombre_oficina + '</option>';
						} else {
							options += '<option value="' + response[i].id_oficina + '">' + response[i].nombre_oficina + '</option>';
						}
					}
					$('#' + combo).html(options);
				}
			}, 'json');
		} else {
			$('#' + combo).html('').trigger('onchange');
		}
	},

	cargarCentroSaludporComuna: function (comuna, combo, centrosalud) {
		if (comuna != 0) {
			$.post(Base.getBaseUri() + 'index.php/Paciente/cargarEstablecimientoSaludporComuna', { comuna: comuna }, function (response) {
				var options = '<option value="0"> Todos </option>';
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
			$('#' + combo).html('<option value="0"> Todos </option>');
		}
	},

	cargarFarmaceuticoPorComuna: function (comuna, combo, farmaceutico) {
		if (comuna != 0) {
			$.post(Base.getBaseUri() + 'index.php/General/Regiones/cargarFarmaceuticoPorComuna', { comuna: comuna }, function (response) {
				var options = '<option value="0"> Seleccione un Establecimiento </option>';
				$.each(response, function (i, valor) {
					if (farmaceutico == valor.id_establecimiento) {
						options += '<option value="' + valor.id_establecimiento + '" selected >' + valor.gl_nombre_establecimiento + '</option>';
					} else {
						options += '<option value="' + valor.id_establecimiento + '">' + valor.gl_nombre_establecimiento + '</option>';
					}
				});
				$('#' + combo).html(options);

			}, 'json');
		} else {
			$('#' + combo).html('<option value="0"> Seleccione un Establecimiento </option>');
		}
	},

	cargarEstableSaludporRegion: function (region, combo, establecimientosalud) {
		if (region != 0) {
			$.post(Base.getBaseUri() + 'index.php/General/Regiones/cargarEstablecimientoSaludporRegion', { region: region }, function (response) {
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

	cargarEstableSaludporOficina: function (oficina, combo, establecimientosalud) {
		if (oficina != 0) {
			$.post(Base.getBaseUri() + 'index.php/General/Regiones/cargarEstablecimientoSaludporOficina', { oficina: oficina }, function (response) {
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
	cargarComunaByOficina: function (oficina, combo, comuna, callback = null) {
		if ($('#' + combo).attr("disabled") === undefined) {
			$.post(Base.getBaseUri() + 'index.php/General/Regiones/cargarComunaporOficina', { oficina: oficina }, function (response) {
				if (response.length > 0) {
					var total = response.length;
					var options = '<option value="0"> -- Seleccione -- </option>';
					for (var i = 0; i < total; i++) {
						if (comuna == response[i].id_comuna) {
							options += '<option value="' + response[i].id_comuna + '"  selected >' + response[i].nombre_comuna + '</option>';
						} else {
							options += '<option value="' + response[i].id_comuna + '" >' + response[i].nombre_comuna + '</option>';
						}

					}
					$('#' + combo).html(options);
					if (callback && typeof callback === "function") {
						callback();
					}
				}
			}, 'json');
			$('#' + combo).html('<option value="0"> -- Seleccione -- </option>');
		}
	},

	cargarComisionesporRegion: function (region, combo, comision) {
		if (region != 0) {
			$.post(Base.getBaseUri() + 'index.php/General/Regiones/cargarComisionesporRegion', { region: region }, function (response) {
				var options = '<option value="0"> -- Todas -- </option>';
				$.each(response, function (i, valor) {
					if (comision == valor.id_comision) {
						options += '<option value="' + valor.id_comision + '" selected >' + valor.gl_nombre + '</option>';
					} else {
						options += '<option value="' + valor.id_comision + '">' + valor.gl_nombre + '</option>';
					}
				});
				$('#' + combo).html(options);

			}, 'json');
		} else {
			$('#' + combo).html('<option value="0"> -- Todas -- </option>');
		}
	},

};
