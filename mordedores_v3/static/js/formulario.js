/**
 * Clase para agregar mapa a formulario.
 * 
 * @requires 
 * 
 * @type MapaFormulario
 */


var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1]+"/";
 
var MapaFormulario = Class({
    
    /**
     * Nombre del input de busqueda de direccion
     */
	GMKey : "AIzaSyA0EStNKp8SbPYpeJliwv8hiLUMriqte1g",
    places_input : null,
    
    /**
     * Icono utilizado para el marcador
     */
    icon : "",
    
    /**
     * googleMaps
     */
    mapa : null,
    
    /**
     * Marcador en el mapa
     */
    marker : null,

    /**
     * Identificador del contenedor html del mapa
     */
    id_div_mapa : "",
    
    /**
     * Latitud por defecto
     */
    latitud : -33.04864,
    
    /**
     * Longitud por defecto
     */
    longitud : -71.613353,
    
    /**
     * Id del input para rescatar longitud
     */
    input_longitud : "gl_longitud",
    
    /**
     * Id del input para rescatar latitud
     */
    input_latitud  : "gl_latitud",
    autocompleteActivo  : false,
    zoom : 4,

    min_zoom: 3,

    tipo_mapa: 'hybrid',
    
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function(id_mapa) {
        this.id_div_mapa = id_mapa;
    },

    /**
    * Setea el mínimo zoom posible
    * @param {string} min_zoom
    * @return {undefined}
    */
    seteaMinZoom: function(minzoom) {
        this.min_zoom = minzoom;    
    },

    /**
    * Setea el tipo de mapa
    * @param {string} tipo_mapa
    * @return {undefined}
    */
    seteaMapa: function (tipo_mapa){
        this.tipo_mapa = tipo_mapa;
    },
    
    /**
     * Setea el icono para el marcador
     * @param {string} icono
     * @returns {undefined}
     */
    seteaIcono : function (icono){
        this.icon = icono;
    },
    
    /**
     * 
     * @param {string} nombre
     * @returns {undefined}
     */
    seteaLatitudInput : function(nombre){
        this.input_latitud = nombre;
    },
    
    /**
     * 
     * @param {string} nombre
     * @returns {undefined}
     */
    seteaLongitudInput : function(nombre){
        this.input_longitud = nombre
    },
    
    /**
     * Setea el id del input de busqueda de direcciones
     * @param {string} place
     * @returns {void}
     */
    seteaPlaceInput : function(place){
        this.places_input = place;
    },
    
    /**
     * 
     * @param {type} zoom
     * @returns {undefined}
     */
    seteaZoom : function(zoom){
        this.zoom = zoom;
    },
    
    /**
     * Setea el valor de la latitud del centro del mapa
     * @param {string} latitud
     * @returns {undefined}
     */
    seteaLatitud : function(latitud){
        if(latitud != ""){
            this.latitud = latitud;
        }
    },
    
    /**
     * Setea el valor de la longitud del centro del mapa
     * @param {string} longitud
     * @returns {undefined}
     */
    seteaLongitud : function(longitud){
        if(longitud != ""){
            this.longitud = longitud;
        }
    },


    seteaMarker : function(){
        var yo = this;       
        var draggable = false;
        //console.log($("#" + this.id_div_mapa).data("editable"));
        if($("#" + this.id_div_mapa).data("editable") == 1){
            draggable = true;
        }
        
        marker = new google.maps.Marker({
            position: yo.mapa.getCenter(),
            draggable: draggable,
            map: yo.mapa,
            icon: baseUrl + yo.icon
        });  
        
        google.maps.event.addListener(marker, 'dragend', function (){
            yo.setInputs(marker.getPosition());
        });
        
        this.marker = marker;

    },
    
    /**
     * 
     * @returns {undefined}
     */
    inicio : function(){
        var yo = this;

        google.maps.event.addDomListener(window, 'load', this.initialize());
        google.maps.event.addDomListener(window, "resize", this.resizeMap());
                
        $("#" + this.input_latitud).typing({
            stop: function (event, $elem) {
                yo.setMarkerInputs();
            },
            delay: 600
        });
        
        $("#" + this.input_latitud).change(function(){
            yo.setMarkerInputs();
        });
        
        
        $("#" + this.input_longitud).typing({
            stop: function (event, $elem) {
                yo.setMarkerInputs();
            },
            delay: 600
        });
        
        $("#" + this.input_longitud).change(function(){
            yo.setMarkerInputs();
        });
        
        this.places();
    },
    
    /**
     * 
     * @returns {void}
     */
    cargaMapa : function(){
        //se dispara evento lazy
        google.maps.event.trigger(this.mapa, "resize");
    },
    
    /**
     * Setea el marcador
     */
    setMarker : function (posicion){
        var yo = this;       
        
        var draggable = false;
        //console.log("setMarker -> editable:" + $("#" + this.id_div_mapa).data("editable"));
        if($("#" + this.id_div_mapa).data("editable") == 1){
            draggable = true;
        }
        
        marker = new google.maps.Marker({
            position: posicion,
            draggable: draggable,
            map: yo.mapa,
            icon: baseUrl + yo.icon
        });  
        
        google.maps.event.addListener(marker, 'dragend', function (){
            yo.setInputs(marker.getPosition());
        });
        
        this.marker = marker;
        
    },
    
    /**
     * Inicia el mapa
     * @returns {void}
     */
    initialize : function(){
        
        var yo = this;

        var myLatlng = new google.maps.LatLng(parseFloat(yo.latitud),parseFloat(yo.longitud));

        var mapOptions = {
          zoom: yo.zoom,
          center: myLatlng,
          disableDoubleClickZoom: true,
          mapTypeId: yo.tipo_mapa
        };

        map = new google.maps.Map(document.getElementById(yo.id_div_mapa), mapOptions);

        //console.log("initialize -> editable:" + $("#" + this.id_div_mapa).data("editable"));
        if($("#" + this.id_div_mapa).data("editable") == 1){
            google.maps.event.addListener(map, "dblclick", function (e) { 
                var lat = e.latLng.lat();
                var lon = e.latLng.lng();
                $("#" + yo.input_latitud).val(lat);
                $("#" + yo.input_longitud).val(lon);
                $("#" + yo.input_longitud).trigger("change");
            });
        }

        // Bounds
        var strictBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(-84.243341, -178.111279),
        new google.maps.LatLng(84.891602, 177.185937));

        // Listen for the dragend event
        google.maps.event.addListener(map, 'dragend', function () {
         if (strictBounds.contains(map.getCenter())) return;

         // We're out of bounds - Move the map back within the bounds

         var c = map.getCenter(),
             x = c.lng(),
             y = c.lat(),
             maxX = strictBounds.getNorthEast().lng(),
             maxY = strictBounds.getNorthEast().lat(),
             minX = strictBounds.getSouthWest().lng(),
             minY = strictBounds.getSouthWest().lat();

         if (x < minX) x = minX;
         if (x > maxX) x = maxX;
         if (y < minY) y = minY;
         if (y > maxY) y = maxY;

         map.setCenter(new google.maps.LatLng(y, x));

        });

        // Limit the zoom level
        google.maps.event.addListener(map, 'zoom_changed', function () {
         if (map.getZoom() < yo.min_zoom) map.setZoom(yo.min_zoom);
        });

        this.mapa = map;
    },
    
    /**
     * Configuracion de busqueda de direcciones
     * @returns {void}
     */
    places : function(){
        var yo = this;

		$("#" + yo.places_input).livequery(function(){
			$("#" + yo.places_input).keyup(function(e) {

				console.log($("#" + yo.places_input).val().length);

				var borrando = false;
				
				if(e.keyCode == 8){
					//google.maps.event.clearInstanceListeners($("#" + yo.places_input)[0]);
					console.log("Borrando unbind");
					this.autocompleteActivo = false;
					borrando = true;
				}

				if(yo.places_input != null && $("#" + yo.places_input).val().length >= 10 && !this.autocompleteActivo && !borrando ){
					var direccion = document.getElementById(yo.places_input);
					
					/*
					//Ver forma de filtrar por Region y Comuna
					var comuna = $("#comuna option:selected").text();
					var region = $("#region option:selected").text();
					if (comuna.indexOf("Seleccione") > 0){
						direccion = document.getElementById(yo.places_input+" "+comuna);
					}
					if (region.indexOf("Seleccione") > 0){
						direccion = document.getElementById(yo.places_input+" "+region);
					}
					*/
					
					ac = new google.maps.places.Autocomplete((direccion), {
						componentRestrictions: {country: 'cl'}
					});
					
					this.autocompleteActivo = true;
					
					ac.addListener('place_changed', function () {
						var place = ac.getPlace();
						
						if(place && place.length === 0) {
							return;
						}
						
						if(place !== undefined){
							if(place.address_components !== undefined){
								var index		= place.address_components.length - 2;
								var region		= place.address_components[index].long_name;
								var calle		= place.address_components[1].long_name;
								var numero		= place.address_components[0].long_name;
								var callenro	= calle+" "+numero;
								
								if (isNaN(numero)){
									callenro = numero;
								}

								$("#" + yo.places_input).val(callenro);
								$("#" + yo.input_longitud).val(parseFloat(place.geometry.location.lng()));
								$("#" + yo.input_latitud).val(parseFloat(place.geometry.location.lat()));
								$("#" + yo.input_longitud).trigger("change");
							}
						}
						
						yo.mapa.setZoom(17);
					});
				}
			});
		});

    },
    
    /**
     * Cambia posicion en los input
     * @param {type} posicion
     * @returns {void}
     */
    setInputs : function(posicion){
        $("#" + this.input_longitud).val(parseFloat(posicion.lng()));
        $("#" + this.input_latitud).val(parseFloat(posicion.lat()));
        $("#" + this.input_longitud).trigger('blur');
		if($('#centrosalud').is('[disabled=disabled]')){
			$('#centrosalud').attr('disabled', false);
		}
        $("#" + this.input_latitud).trigger('blur');
        
        // Actualizar input de dirección (places_input) al mover el pin 
        var gl_direccion = '';
        $.ajax({
            dataType: "json",
            cache   : false,
            async   : false,
            type    : "post",
            url     : 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+parseFloat(posicion.lat())+','+parseFloat(posicion.lng())+'&key='+this.GMKey, 
            error   : function(xhr, textStatus, errorThrown){},
            success : function(data){
                if(data.status == "OK"){
					//console.log(data.results[0].address_components[1].long_name + " - " +data.results[0].address_components[0].short_name);
                    gl_direccion = data.results[0].address_components[1].long_name + " " +data.results[0].address_components[0].short_name;
                }else{
                    //alertify.error('Direccion no disponible en google maps');
                    console.log('Direccion no disponible en google maps');
                    console.log(data);
                }
            }
        });

        if(gl_direccion != ''){
            //Unnamed Road,
            gl_direccion = gl_direccion.replace('Unnamed Road,','');
            $("#" + this.places_input).val(gl_direccion.trim());
        }
    },
    
    /**
     * Actualiza posicion de marcador y mapa de acuerdo
     * a los input de latitud y longitud
     * @returns {undefined}
     */
    setMarkerInputs : function(){
        if($("#" + this.input_latitud).val() != "" && $("#" + this.input_longitud).val() != ""){
            var yo = this;

            if(this.marker != null){
                this.marker.setMap(null);
                this.marker = null;
            }
            
            var draggable = false;
            //console.log("setMarkerInputs ->editable:" + $("#" + this.id_div_mapa).data("editable"));
            if($("#" + this.id_div_mapa).data("editable") == 1){
                 var draggable = true;
            }

            var marker = new google.maps.Marker({
                draggable: draggable,
                map: yo.mapa,
                icon: baseUrl + yo.icon
            });  

            google.maps.event.addListener(marker, 'dragend', function (){
                yo.setInputs(marker.getPosition());
            });

            this.marker = marker;

            this.marker.setPosition( new google.maps.LatLng( parseFloat($("#" + this.input_latitud).val()), parseFloat($("#" + this.input_longitud).val())) );
            //this.mapa.setZoom(10);
            
            this.mapa.panTo( new google.maps.LatLng(parseFloat($("#" + this.input_latitud).val()), parseFloat($("#" + this.input_longitud).val())) );
        }
    },
    
    /**
     * 
     * @returns {void}
     */
    resizeMap : function(){
        var yo = this;
        if(typeof this.mapa =="undefined") return;
        setTimeout( function(){yo.resize();} , 400);
    },
    
    /**
     * Centra el mapa
     * @returns {void}
     */
    resize : function (){
        var center = this.mapa.getCenter();
        google.maps.event.trigger(this.mapa, "resize");
        this.mapa.setCenter(center); 
    },
    
    
    
    obtenerMapa : function(){
        return this.mapa;
    },
    
    obtenerMarker : function(){
        return this.marker;
    }

});