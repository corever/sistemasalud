
var Mapa = {

	init : function (delay = 1500) {

        setTimeout(Mapa.crearMapa, delay);
        // $("#id_comuna_direccion").on('change', Mapa.cambiarLatitudLongitud);
	},

    crearMapa : function () {
        var mapaContacto = new MapaFormulario("mapaDireccion");
        mapaContacto.seteaIcono("/images/images/persona3.png");
        mapaContacto.seteaLatitudInput("gl_latitud_direccion");
        mapaContacto.seteaLongitudInput("gl_longitud_direccion");
        mapaContacto.seteaLongitud("-70.6504492");
        mapaContacto.seteaLatitud("-33.4378305");
        mapaContacto.seteaZoom(18);
        mapaContacto.seteaPlaceInput("gl_calle_direccion");
        mapaContacto.seteaPlaceInputNro("nr_direccion");
        mapaContacto.inicio();
        mapaContacto.cargaMapa();
        mapaContacto.setMarkerInputs();
        //lugares(mapaContacto);
    },

    cambiarLatitudLongitud : function (id_comuna = 'id_comuna_direccion') {

        var longitud_comuna = $("#"+id_comuna).children(":selected").data('longitud');
        var latitud_comuna	= $("#"+id_comuna).children(":selected").data('latitud');
		
        $("#gl_direccion").val("");
        $("#gl_longitud_direccion").val(longitud_comuna);
        $("#gl_latitud_direccion").val(latitud_comuna);
        $("#gl_latitud_direccion").trigger("change");
    },

	lugares : function (mapa){
	    mapa.seteaPlaceInput("gl_direccion");

	    var input = document.getElementById('gl_direccion');
	    var options = {
	      componentRestrictions: {country: 'cl'}
	    };

	    autocomplete = new google.maps.places.Autocomplete(input, options);

	    autocomplete.addListener('place_changed', function () {
	        var place = autocomplete.getPlace();
	        if(place){
	            var lng = place.geometry.location.lng();
	            var lat = place.geometry.location.lat();
	            //console.log(lng + ' ' + lat);

	            var marker  = mapa.obtenerMarker();
	            var map     = mapa.obtenerMapa();
	            marker.setMap(null);
	            map.setCenter({lat:parseFloat(lat), lng : parseFloat(lng)});
	            mapa.seteaMarker();
	            map.setZoom(18);
	        }
	    });
	}
};

// Mapa.init();
