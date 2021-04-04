var autocomplete2;
var activo = false;

$("#region_contacto").on('change', function (e) {
	$("#gl_direccion").val("");
	var longitud_region = $("#region_contacto").children(":selected").attr("name");
	var latitud_region	= $("#region_contacto").children(":selected").attr("id");
	
	$("#gl_longitud_contacto").val(longitud_region);
	$("#gl_latitud_contacto").val(latitud_region);
	$("#gl_latitud_contacto").trigger("change");
	
	if($('#centrosalud').is('[disabled=disabled]')){
		$('#form').find('#centrosalud').attr('disabled', false);
		$("#cambio_direccion").val("1"); //variable global JS
	}
	
});
$("#comuna_contacto").on('change', function (e) {
	$("#gl_direccion").val("");
	var longitud_comuna = $("#comuna_contacto").children(":selected").attr("name");
	var latitud_comuna	= $("#comuna_contacto").children(":selected").attr("id");
	
	$("#gl_longitud_contacto").val(longitud_comuna);
	$("#gl_latitud_contacto").val(latitud_comuna);
	$("#gl_latitud_contacto").trigger("change");
	
	if($('#centrosalud').is('[disabled=disabled]')){
		$('#form').find('#centrosalud').attr('disabled', false);
		$("#cambio_direccion").val("1");//variable global JS
	}
});

$(document).ready(function () {
	var isDisabled      = $("#region_contacto").is(':disabled');
	var longitud_region = $("#region_contacto").children(":selected").attr("name");
	var latitud_region  = $("#region_contacto").children(":selected").attr("id");
	if (isDisabled){
		$("#gl_longitud_contacto").val(longitud_region);
		$("#gl_latitud_contacto").val(latitud_region);
		$("#gl_latitud_contacto").trigger("change");
	}
	var mapaContacto = new MapaFormulario("mapContacto");
	mapaContacto.seteaIcono("static/images/markers/persona3.png");
	mapaContacto.seteaLatitudInput("gl_latitud_contacto");
	mapaContacto.seteaLongitudInput("gl_longitud_contacto");
	mapaContacto.seteaLongitud("-70.6504492");
	mapaContacto.seteaLatitud("-33.4378305");
	mapaContacto.seteaZoom(18);
	//mapaContacto.seteaPlaceInput("gl_direccion");
	mapaContacto.inicio();
	mapaContacto.cargaMapa();
	mapaContacto.setMarkerInputs();

		$("#gl_direccion").livequery(function(){
			$("#gl_direccion").keyup(function(e) {
				console.log($("#gl_direccion").val().length);
				//console.log(e.keyCode);
				
				var borrando = false;
				
				if(e.keyCode == 8){
					//google.maps.event.clearInstanceListeners($("#gl_direccion")[0]);
					console.log("Borrando unbind");
					activo = false;
					borrando = true;
				}
				
				if ($("#gl_direccion").val().length > 10 && !activo && !borrando){
					google.maps.event.clearInstanceListeners($("#gl_direccion")[0]);
					lugares(mapaContacto);    
					activo = true;
					google.maps.event.clearInstanceListeners($("#gl_direccion")[0]);
					console.log("iniciar");
				}
			});
		});
    
});



function lugares(mapa){
	
    mapa.seteaPlaceInput("gl_direccion");
    
    var input = document.getElementById('gl_direccion');
    var options = {
      componentRestrictions: {country: 'cl'}
    };

    autocomplete2 = new google.maps.places.Autocomplete(input, options);
    autocomplete2.addListener('place_changed', function () {
		
        var place = autocomplete2.getPlace();
        if(place){
            var lng = place.geometry.location.lng();
            var lat = place.geometry.location.lat();
            //console.log(lng + ' ' + lat);
            
            var marker  = mapa.obtenerMarker();
            var map     = mapa.obtenerMapa();
            marker.setMap(null);
            map.setCenter({lat:parseFloat(lat), lng : parseFloat(lng)})
            mapa.seteaMarker();
            map.setZoom(18);
        }
    });
}