$(document).ready(function () {
    // var isDisabled      = $("#region_contacto").is(':disabled');
    // var longitud_region = $("#region_contacto").children(":selected").attr("name");
    // var latitud_region  = $("#region_contacto").children(":selected").attr("id");
    // if (isDisabled){
    // 	$("#gl_longitud_exp").val(longitud_region);
    // 	$("#gl_latitud_exp").val(latitud_region);
    // 	$("#gl_latitud_exp").trigger("change");
    // }

    // var mapaContacto = new MapaFormulario("map");
    // mapaContacto.seteaIcono("static/images/markers/mordedor3.png");
    // mapaContacto.seteaLatitudInput("gl_latitud");
    // mapaContacto.seteaLongitudInput("gl_longitud");
    // mapaContacto.seteaLongitud("-70.6504492");
    // mapaContacto.seteaLatitud("-33.4378305");
    // mapaContacto.seteaZoom(18);
    // mapaContacto.seteaPlaceInput("dir_lugar_calle");
    // mapaContacto.inicio();
    // mapaContacto.cargaMapa();
    // mapaContacto.setMarkerInputs();

    // TODO: Filtro funciona bien con region-comuna preestablecidas
    var regionDisabled = $("#dir_region").is(':disabled');
    var longitud_region = $("#dir_region").children(":selected").attr("name");
    var latitud_region = $("#dir_region").children(":selected").attr("id");

    var comunaDisabled = $("#dir_comuna").is(':disabled');
    var longitud_comuna = $("#dir_comuna").children(":selected").attr("name");
    var latitud_comuna = $("#dir_comuna").children(":selected").attr("id");

    if (comunaDisabled) {
        $("#gl_longitud").val(longitud_comuna);
        $("#gl_latitud").val(latitud_comuna);
        $("#gl_latitud").trigger("change");
    } else if (regionDisabled) {
        $("#gl_longitud").val(longitud_region);
        $("#gl_latitud").val(latitud_region);
        $("#gl_latitud").trigger("change");
    }

    var mapaMordedura = new MapaFormulario("map");

    mapaMordedura.seteaLatitudInput("gl_latitud");
    mapaMordedura.seteaLongitudInput("gl_longitud");
    mapaMordedura.seteaLongitud("-70.6504492");
    mapaMordedura.seteaLatitud("-33.4378305");
    mapaMordedura.seteaZoom(18);
    mapaMordedura.seteaPlaceInput("dir_calle");
    mapaMordedura.inicio();
    mapaMordedura.cargaMapa();
    mapaMordedura.setMarkerInputs();



    var mapaMedioTransporte = new MapaFormulario("map_medio_transporte");

    mapaMedioTransporte.seteaLatitudInput("gl_latitud_medio_transporte");
    mapaMedioTransporte.seteaLongitudInput("gl_longitud_medio_transporte");
    mapaMedioTransporte.seteaLongitud("-70.6504492");
    mapaMedioTransporte.seteaLatitud("-33.4378305");
    mapaMedioTransporte.seteaZoom(18);
    mapaMedioTransporte.seteaPlaceInput("dir_transporte_calle");
    mapaMedioTransporte.inicio();
    mapaMedioTransporte.cargaMapa();
    mapaMedioTransporte.setMarkerInputs();

});


$("#dir_region").on('change', function (e) {
    // alert("in");
    $("#dir_calle").val("");
    $("#dir_numero").val("");
    var longitud_region = $("#dir_region").children(":selected").attr("name");
    var latitud_region = $("#dir_region").children(":selected").attr("id");

    $("#gl_longitud").val(longitud_region);
    $("#gl_latitud").val(latitud_region);
    $("#gl_latitud").trigger("change");
});


$("#dir_comuna").on('change', function (e) {
    // alert("in");
    $("#dir_calle").val("");
    $("#dir_numero").val("");
    var longitud_comuna = $("#dir_comuna").children(":selected").attr("name");
    var latitud_comuna = $("#dir_comuna").children(":selected").attr("id");

    $("#gl_longitud").val(longitud_comuna);
    $("#gl_latitud").val(latitud_comuna);
    $("#gl_latitud").trigger("change");
});


