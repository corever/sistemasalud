/**
 * Clase para agregar mapa a formulario.
 * 
 * @requires 
 * 
 * @type MapaFormulario
 */
var infoWindow;

var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
var boIniciado = false; 
var MapaFormulario = Class({
    
    /**
     * Nombre del input de busqueda de direccion
     */
    places_input : null,
    search_places_input : null,
    
    /**
     * Nombre del input de busqueda de pais
     */
    country_input : null,

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

    /**
     * Id del input para rescatar coordenada utm
     */
    input_utm  : "gl_utm",
    
    zoom : 4,

    min_zoom: 3,

    tipo_mapa: 'hybrid',

    /**
     * Área circular
     */
    area_circular: null,

    polygons : [],
    drawingManager : null,
    
    auto_close_info: true,
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function(id_mapa) {
        this.id_div_mapa = id_mapa;
    },

    getEditing : function (){
        return this.drawingManager == null
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

    seteaAutoCloseInfo: function (auto_close_info){
        this.auto_close_info = auto_close_info;
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
     * 
     * @param {string} nombre
     * @returns {undefined}
     */
    seteaUtmInput : function(nombre){
        this.input_utm = nombre
    },
    /**
     * Setea el id del input de busqueda de direcciones
     * @param {string} place
     * @returns {void}
     */
    seteaPlaceInput : function(place){
        this.places_input = place;
    },
    seteaSearchPlaceInput : function(place){
        this.search_places_input = place;
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

    closeInfoWindow(){
    	infoWindow.close(this.mapa);
    },


    seteaMarker : function(){
        var yo = this;       
        var draggable = false;
        //console.log($("#" + this.id_div_mapa).data("editable"));
        if($("#" + this.id_div_mapa).data("editable") == 1){
            draggable = true;
        }

        var options = {
            position: yo.mapa.getCenter(),
            draggable: draggable,
            map: yo.mapa
        }
        
        if(this.icon != null && this.icon != ''){
        	options.icon = baseUrl + yo.icon;
        }else{
        	options.custom = false;
        }

        marker = new google.maps.Marker(options);  
        
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

        google.maps.event.addListener(yo.mapa, 'mousedown', function(e){
            
            if(yo.drawingManager != null){
                console.log(e);
                $.each(yo.polygons, function (indexInArray, valueOfElement) { 
                    if (google.maps.geometry.poly.containsLocation(e.latLng, valueOfElement)) {
                        e.stop();
                        event.preventDefault();
                        return false;
                    }
                });
            }
            
        });
        infoWindow = new google.maps.InfoWindow;
                
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

        $("#" + this.input_utm).typing({
            stop: function (event, $elem) {
                yo.setMarkerInputs();
            },
            delay: 600
        });

        $("#" + this.input_utm).change(function(){
            yo.setMarkerInputs();
        });
        
        if(this.search_places_input !== null){
            this.searchPlaces();
        }
        else{
            this.places();
        }
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
		//$("#" + yo.places_input).livequery(function(){
			$("#" + yo.places_input).keypress(function() {
			
				if(yo.places_input != null && $("#" + yo.places_input).val().length >= 5){
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
                    
                    //https://en.wikipedia.org/wiki/ISO_3166-1
                    //https://developers.google.com/maps/documentation/javascript/geocoding#ComponentFiltering
					var country_search = 'cl';
                    debugger;
                    if(this.country_input != null){
                        var extras = $("#"+this.country_input).find(':selected').data('extras');
                        var alpha2_code = extras.codigo_alpha2;
                        if(alpha2_code){
                            country_search = alpha2_code;
                        }
                    }else{
                        var extras = $("#id_pais").find(':selected').data('extras');
                        var alpha2_code = extras.codigo_alpha2;
                        if(alpha2_code){
                            country_search = alpha2_code;
                        }
                    }
					ac = new google.maps.places.Autocomplete((direccion), {
						componentRestrictions: {country: country_search}
					});

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
		//});

    },

    searchPlaces : function(){
        var yo = this;
        $("#" + yo.places_input).keypress(function(){
            if(yo.places_input != null && $("#" + yo.places_input).val().length >= 5){
                if(!boIniciado){
                    boIniciado = true;

                    var direccion = document.getElementById(yo.places_input); 

                    var country_search = 'cl';
                    
                    if(this.country_input != null){
                        var alpha2_code = $("#"+this.country_input).find(':selected').data('codigo_alpha2');
                        if(alpha2_code){
                            country_search = alpha2_code;
                        }
                    }else{
                        var alpha2_code = $("#id_pais").find(':selected').data('codigo_alpha2');
                        if(alpha2_code){
                            country_search = alpha2_code;
                        }
                    }
                    ac = new google.maps.places.Autocomplete((direccion), {
                        componentRestrictions: {country: country_search}
                    });
                    
                
                    ac.addListener('place_changed', function () {
                        var place_form = acomplete.getPlace();
                        if (place_form && place_form.length === 0) {
                            return;
                        }
                        if(place !== undefined){
                            if(place.address_components !== undefined){
                                //var index        = place.address_components.length - 2;
                                var calle        = place.address_components[1].long_name;
                                var numero        = place.address_components[0].long_name;
                                var callenro    = calle+" "+numero;
                                
                                if (isNaN(numero)){
                                    callenro = numero;
                                }

                                $("#" + yo.places_input).val(callenro);   
                                $("#" + yo.input_longitud).val(parseFloat(place.geometry.location.lng()));
                                $("#" + yo.input_latitud).val(parseFloat(place.geometry.location.lat()));
                                $("#" + yo.input_longitud).trigger("change");
                            }
                        }
                    });
                
                }   
            }
        });
    },
    
    /**
     * Cambia posicion en los input
     * @param {type} posicion
     * @returns {void}
     */
    setInputs : function(posicion){

        var ll4 = new LatLng(parseFloat(posicion.lat()), parseFloat(posicion.lng()));
        var utm2 = ll4.toUTMRef();

        $("#" + this.input_longitud).val(parseFloat(posicion.lng()));
        $("#" + this.input_latitud).val(parseFloat(posicion.lat()));
        $("." + this.input_longitud + "html").html(parseFloat(posicion.lng()));
        $("." + this.input_latitud + "html").html(parseFloat(posicion.lat()));
        $("#" + this.input_utm).val(utm2.toString());

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
            url     : 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+parseFloat(posicion.lat())+','+parseFloat(posicion.lng()), 
            error   : function(xhr, textStatus, errorThrown){},
            success : function(data){
                if(data.status == "OK"){
					//console.log(data.results[0].address_components[1].long_name + " - " +data.results[0].address_components[0].short_name);
                    gl_direccion = data.results[0].address_components[1].long_name + " " +data.results[0].address_components[0].short_name;
                }else{
                    //alertify.error('Direccion no disponible en google maps');
                    console.log('Direccion no disponible en google maps');
                }
            }
        });

        if(gl_direccion != ''){
            //Unnamed Road,
            gl_direccion = gl_direccion.replace('Unnamed Road,','');
            $("#" + this.places_input).val(gl_direccion.trim());
            $("." + this.places_input + "html").html(gl_direccion.trim());
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

            var options = {
                draggable: draggable,
                map: yo.mapa
            }

            if(this.icon != null && this.icon != ''){
	        	options.icon = baseUrl + yo.icon;
	        }else{
	        	options.custom = false;
	        }

            var marker = new google.maps.Marker(options);  


            google.maps.event.addListener(marker, 'dragend', function (){
                yo.setInputs(marker.getPosition());
            });

            this.marker = marker;

            let point = new google.maps.LatLng( parseFloat($("#" + this.input_latitud).val()), parseFloat($("#" + this.input_longitud).val()));

            this.marker.setPosition(point);
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
    },

    /**
     * Crear area circular 
     */
    setRoundArea: function(radio = 200, edit = true, opacity = 0.35) {

        this.area_circular = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: opacity,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: opacity,
            map: this.mapa,
            center: this.mapa.center,
            editable: edit,
            radius: radio
        });

        return this.area_circular;
    },

    updateRoundArea: function(){
        this.area_circular.setCenter(new google.maps.LatLng( parseFloat($("#" + this.input_latitud).val()), parseFloat($("#" + this.input_longitud).val())) );
    },

    /**
     * Crear area perzonalizada
     */
    setCustomArea: function(settings) {

        var yo = this;
        yo.drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: google.maps.drawing.OverlayType.POLYGON
            },
            markerOptions: {icon: staticsURLs.markerOptionsIcon},
            polygonOptions: {
                fillOpacity: 0.5,
                strokeWeight: 2,
                strokeOpacity : 0.5,
                clickable: true,
                editable: true,
                _id : yo.uniqID(20),
            }
            });

            google.maps.event.addListener(yo.drawingManager, 'polygoncomplete', function(polygon) {

                yo.polygons.push(polygon);

                //_padre =  polygon;
                if(typeof(settings.onComplete) == "function"){
                    settings.onComplete(polygon);
                }

                var calls = {
                    onClick : settings.onClick,
                    onDblClick : settings.onDblClick,
                    onRightClick : settings.onRightClick,
                    onChange : settings.onChange,
                }

                polygon.setOptions({zIndex: yo.polygons.length})
                yo.setPolygonListener(polygon,calls);

                yo.unsetActiveClass(polygon._id);

                yo.drawingManager.setMap(null);
                yo.drawingManager = null;

            });

            yo.drawingManager.setMap(this.mapa);
    },
    
    stopDrawing: function() {
        var yo = this;
        if (yo.drawingManager != null) {
            
            yo.drawingManager.setMap(null);
            yo.drawingManager = null;
        }
    },
    setPolygonListener: function(polygon, callbacks){
        var yo = this;
        google.maps.event.addListener(polygon, 'dblclick', function(ev) {
            
            if (typeof(callbacks.onDblClick) == "function") {
                if (!polygon.getEditable() && polygon != null) {    
                    callbacks.onDblClick(ev, polygon);
                }
                
            }

        });        
        
        google.maps.event.addListener(polygon, 'click', function(ev) {

            if (typeof(callbacks.onClick) == "function") {
                if (!polygon.getEditable() && polygon != null) {    
                    callbacks.onClick(ev, polygon);
                }
                
            }

        });
        
        google.maps.event.addListener(polygon, 'rightclick', function(ev) {

            if (typeof(callbacks.onRightClick) == "function") {
                if (!polygon.getEditable() && polygon != null) {    
                    callbacks.onRightClick(ev, polygon);
                }
            }
            if (ev.vertex != undefined) {
                if (polygon.getEditable()) {    
                    polygon.getPath().removeAt(ev.vertex); 
                }
               
            }

        });
        
        google.maps.event.addListener(polygon, 'mouseout', function(ev) {

            if (typeof(callbacks.onMouseout) == "function") {
                callbacks.onMouseout(ev, polygon);
            }

            
            if(this.auto_close_info)
            	infoWindow.close(map);

        });


        polygon.getPaths().forEach(function(path, index){
            
            google.maps.event.addListener(path, 'insert_at', function(ev){
              // New point
              if (typeof(callbacks.onChange) == "function") {
                callbacks.onChange(ev, polygon);
            }
            });
          
            google.maps.event.addListener(path, 'remove_at', function(ev){
              // Point was removed
              if (typeof(callbacks.onChange) == "function") {
                callbacks.onChange(ev, polygon);
            }
            });
          
            google.maps.event.addListener(path, 'set_at', function(ev){
                // Point was moved
                if (typeof(callbacks.onChange) == "function") {
                  callbacks.onChange(ev, polygon);
              }
              });
            
          
          });
          
          google.maps.event.addListener(polygon, 'dragend', function(ev){
            // Polygon was dragged
            if (typeof(callbacks.onChange) == "function") {
                callbacks.onChange(ev, polygon);
            }
          });

    },
    getPolygonById : function(_id){
        var yo = this;

        var _polygon = null;
        $.each(yo.polygons, function (indexInArray, valueOfElement) { 
            if (valueOfElement._id && valueOfElement._id == _id) {
                _polygon = valueOfElement;
                return false;
            }
        });
        return _polygon;
    },

    getLastPolygon : function(){
        var yo = this;        
        return (yo.polygons.length >= 0)?yo.polygons[yo.polygons.length - 1 ]:false;
    },

    editPolygonById: function(_id){
        var yo = this;

        var _polygon = yo.getPolygonById(_id);

        if (_polygon != null) {    
            yo.setActiveClass(_polygon._id);
            _polygon.setEditable(true);
        }
    },

    setEditing: function(_id){
        var yo = this;

        var _polygon = yo.getPolygonById(_id);

        if (!_polygon.getEditable() && _polygon != null) {    
            _polygon.setOptions({zIndex: 99999999,fillColor: '#00A6A6'});
        }
    },

    setActiveClass: function(_id){
        var yo = this;

        var _polygon = yo.getPolygonById(_id);

        if (!_polygon.getEditable() && _polygon != null) {    
            _polygon.setOptions({zIndex: 99999999,fillColor: '#F9AE16'});
        }
    },

    unsetActiveClass: function(_id){
        var yo = this;

        var _polygon = yo.getPolygonById(_id);

        if (!_polygon.getEditable() && _polygon != null) {    
            _polygon.setOptions({zIndex: 99999999,fillColor: '#00A6A6'});
        }
    },

    setPolygon: function(poly, callbacks){
        var yo = this;

        // Define the LatLng coordinates for the polygon's path.
        var _path = poly.path;
  
        // Construct the polygon.
        var _polygon = new google.maps.Polygon({
            paths: _path,
            fillOpacity: 0.5,
            strokeWeight: 2,
            strokeColor: "#FDFFFC",
            strokeOpacity: 0.5,
            id : poly.id,
            _id : yo.uniqID(20),
        });

        //console.log(yo.mapa);
        
        yo.setPolygonListener(_polygon,callbacks);
        yo.polygons.push(_polygon);
        //_polygon.setMap(yo.mapa);
        _polygon.setMap(yo.obtenerMapa());
        yo.unsetActiveClass(_polygon._id);

        return _polygon;

    },
    getPolygonBounds: function(poly){
        
        var yo = this;

        // Define the LatLng coordinates for the polygon's path.
        var _path = poly.getPaths();
  
        var bounds=new google.maps.LatLngBounds();
          
        _path.forEach(function(path){
          
             path.forEach(function(latLng){bounds.extend(latLng);})
          
          });
        return bounds;

    },
    getPolygonCenter: function(poly){
        
        var yo = this;

  
        var bounds=yo.getPolygonBounds(poly);
        /*
        var x = bounds.b.b + ((bounds.b.f - bounds.b.b) / 2);
        var y = bounds.f.b + ((bounds.f.f - bounds.f.b) / 2);

        var myLatlng = new google.maps.LatLng(parseFloat(y),parseFloat(x));
        */
        return bounds.getCenter();
        
        //return myLatlng;

    },

    getPolygonPath: function(id){
        var yo = this;
        var _polygon = yo.getPolygonById(id);

        return _polygon.getPath();
    },
    
    /**
     * Genera id unico
     * @param {type} len
     * @param {type} charSet
     * @returns {String|editorAnonym$0@call;uniqID}
     */
    uniqID : function (len, charSet) {
        var yo = this;
        charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var randomString = '';
        for (var i = 0; i < len; i++) {
            var randomPoz = Math.floor(Math.random() * charSet.length);
            randomString += charSet.substring(randomPoz,randomPoz+1);
        }
        
        var elementos = jQuery.grep(yo.polygons, function( a ) {
            if(a.clave == randomString){
                return true;
            }
        });
        
        if(elementos.length > 0){
            return this.uniqID(20);
        } else {
            
            var poligonos = jQuery.grep(yo.polygons, function( a ) {
                if(a["clave"] == randomString){
                    return true;
                }
            });
            
            if(poligonos.lenght > 0){
                return this.uniqID(20);
            } else {
                return randomString;
            }
        }
    },

    getCurrentPolygons(){
    	return this.polygons;
    },

    clearPolygons(){
    	$.each(this.polygons, function (indexInArray, valueOfElement) { 
    		valueOfElement.setMap(null);
        });
        this.polygons = [];
    }
});