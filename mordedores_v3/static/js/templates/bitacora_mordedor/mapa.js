$(document).ready(function () {
	var isDisabled      = $("#region_contacto").is(':disabled');
	var longitud_region = $("#region_contacto").children(":selected").attr("name");
	var latitud_region  = $("#region_contacto").children(":selected").attr("id");
	if (isDisabled){
		$("#gl_longitud_exp").val(longitud_region);
		$("#gl_latitud_exp").val(latitud_region);
		$("#gl_latitud_exp").trigger("change");
	}
	
	var mapaContacto = new MapaFormulario("mapExp");
	mapaContacto.seteaIcono("static/images/markers/mordedor3.png");
	mapaContacto.seteaLatitudInput("gl_latitud_exp");
	mapaContacto.seteaLongitudInput("gl_longitud_exp");
	mapaContacto.seteaLongitud("-70.6504492");
	mapaContacto.seteaLatitud("-33.4378305");
	mapaContacto.seteaZoom(18);
	mapaContacto.seteaPlaceInput("gl_direccion");
	mapaContacto.inicio();
	mapaContacto.cargaMapa();
	mapaContacto.setMarkerInputs();

});