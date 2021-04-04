var lista_markers = [];

var markerCluster;

var MapaMarcador = Class({

    /**
     * Google Maps
     */
    mapa : null,

    /**
     * Si puede moverse el pin o no
     */
    draggable : false,

    /**
     * Si el elemento tiene clave en BD
     */
    clave_primaria : null,

    /**
     * String de relacion con otro elemento (KML u otro)
     */
    relacion: null,

    /**
     * El Z-index del marcador
     */
    z_index : 1,

    /**
     * Map-Icons font por defecto
     */
    mapIcon_label : '',

    /**
     * Map-Icons font por defecto
     */
    mapIcon_icon : {
        fillColor: '#00CCBB',
        fillOpacity: 1,
        strokeColor: '',
        strokeWeight: 0
    },

    /**
     * Setea mapa
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },

    /**
     *
     * @param {type} id
     * @returns {undefined}
     */
    seteaClavePrimaria : function(id){
        this.clave_primaria = id;
    },

    /**
     * @param {int} id
     */
    seteaRelacion : function(relacion){
        this.relacion = relacion;
    },

    /**
     *
     * @param {int} zindex
     * @returns {undefined}
     */
    seteaZIndex : function(zindex){
        this.z_index = zindex;
    },
    /**
     * 
     * @param {String} label
     * @returns {void}
     */
    setLabel : function(label){
        this.mapIcon_label = label;
    },
    /**
     * 
     * @param {JSON} props
     * @returns {void}
     */
    setIcon : function(props){
        this.mapIcon_icon = jQuery.extend(this.mapIcon_icon , props );
    },
    /**
     * Quita marcadores de acuerdo al parametro que se quiere buscar
     * @param {string} atributo parametro a buscar
     * @param {int} valor valor del parametro a buscar
     * @returns {void}
     */
    removerMarcadores : function(atributo, valor){

        var arr = jQuery.grep(lista_markers, function( a ) {
            if(a[atributo] == valor){
                return true;
            }
        });

        //se quita marcador del mapa
        $.each(arr, function(i, marcador){            
            marcador.setMap(null);
            lista_markers = jQuery.grep(lista_markers, function( a ) {
                if(a[atributo] != valor){
                    return true;
                }
            });


        });



    },

    limpiar: function(){
        for (var i = 0; i < lista_markers.length; i++) {
            lista_markers[i].setMap(null);
        }
        lista_markers = [];
    },

    listar: function(){
        console.log(lista_markers);
    },

    /**
     * Posiciona un marcador
     * @param {float} lon
     * @param {float} lat
     * @param {string} zona
     * @returns {void}
     */
    posicionarMarcador : function(id, capa, lon, lat, propiedades, zona, icono, imagen, zIndex){
        var yo = this;

        if(lat > 0 && lon > 0){
            var coordenadas = GeoEncoder.utmToDecimalDegree(lon,lat,'19H');
            console.log(coordenadas);
            lat = coordenadas[0];
            lon = coordenadas[1];
        }

        if (!zIndex){
            var zIndex = yo.z_index;
        }
        var posicion = new google.maps.LatLng(parseFloat(lat), parseFloat(lon));

        /*var image = {
            url: icono,
            scaledSize: new google.maps.Size(20, 24),
            size: new google.maps.Size(20, 24),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(0, 24)
        };*/

        marker = new google.maps.Marker({
            zIndex: zIndex,
            clave_primaria : yo.clave_primaria,
            relacion: yo.relacion,
            position: posicion,
            custom : false,
            identificador: id,
            clave : "marcador_" + id,
            capa: capa,
            tipo: "PUNTO",
            informacion : propiedades,
            draggable: yo.draggable,
            map: yo.mapa,
            icon: icono,
            imagen_marcador: imagen
        });

        lista_markers.push(marker);

        this.informacionMarcador(marker);

        google.maps.event.trigger(yo.mapa, 'marcador_cargado');

        return marker;
    },

    /**
     * Posiciona un marcador
     * @param {float} lon
     * @param {float} lat
     * @param {string} zona
     * @returns {void}
     */
    posicionarMapIcon : function(id, capa, lon, lat, propiedades, zona, icono, imagen, zIndex){
        var yo = this;

        if(lat > 0 && lon > 0){
            var coordenadas = GeoEncoder.utmToDecimalDegree(lon,lat,'19H');
            console.log(coordenadas);
            lat = coordenadas[0];
            lon = coordenadas[1];
        }

        if (!zIndex){
            var zIndex = yo.z_index;
        }
        var posicion = new google.maps.LatLng(parseFloat(lat), parseFloat(lon));

        marker = new mapIcons.Marker({
            //zIndex: zIndex,
            clave_primaria : yo.clave_primaria,
            relacion: yo.relacion,
            position: posicion,
            custom : false,
            identificador: id,
            clave : "marcador_" + id,
            capa: capa,
            tipo: "PUNTO",
            informacion : propiedades,
            draggable: yo.draggable,
            map: yo.mapa,
            //icon: icono,
            //imagen_marcador: imagen,
            icon: yo.mapIcon_icon,
            map_icon_label: yo.mapIcon_label
        });

        lista_markers.push(marker);

        this.informacionMarcador(marker);

        google.maps.event.trigger(yo.mapa, 'marcador_cargado');

        return marker;
    },


    posicionarMarcadorLabel : function(id, capa, lon, lat, propiedades, zona, imagen, content, title){
        var yo = this;
        
        var posicion = new google.maps.LatLng(parseFloat(lat), parseFloat(lon));

        marker = new MarkerWithLabel({
            zIndex: yo.z_index,
            clave_primaria : yo.clave_primaria,
            relacion: yo.relacion,
            position: posicion,
            custom : false,
            identificador: id,
            clave : "marcador_" + id,
            capa: capa,
            tipo: "PUNTO",
            informacion : propiedades,
            draggable: yo.draggable,
            map: yo.mapa,
            icon: imagen,
            title: title,
            labelContent: content,
            labelAnchor: new google.maps.Point(80, 60),
            labelClass: "labels"
        });  

        lista_markers.push(marker);
        
        this.informacionMarcador(marker);

        google.maps.event.trigger(yo.mapa, 'marcador_cargado');

        return marker;
    },
    



    /**
     * Popup con informacion
     * @param {marker} marker
     * @returns {void}
     */
    informacionMarcador : function(marker){

        if(marker["infoWindow"]){
            marker["infoWindow"].setMap(null);
        }

        var yo = this;
        if(marker.informacion_html && marker.informacion_html != ""){
            var markerContent =  marker.informacion_html + imagen;
            marker.html = marker.informacion_html;
        } else {
            var markerContent = '<table class="table table-bordered table-stripped table-condensed small">';
            var propiedades = marker.informacion;

            $.each(propiedades, function(i, data){

                //parche para marcadores antiguos
                var result = false;
                if(data){
                    result = data.hasOwnProperty("nombre");
                }
                if(result){
                    var nombre = data.nombre;
                    var valor  = data.valor;
                } else {
                    var nombre = i;
                    var valor = data;
                }

                markerContent += '<tr><td width="50%">' + nombre +':</td><td> ' + ((valor == 'null')? 'No identificado': valor) + '</td></tr>';
            });
            markerContent += '</table>';
        }

        marker["infoWindow"] = new google.maps.InfoWindow({
            content: markerContent
        });

        google.maps.event.addListener(marker, 'click', function () {
            marker["infoWindow"].open(yo.mapa, this);

            var _info_window = marker["infoWindow"];

            google.maps.event.addListener(_info_window, 'domready', function(){


                if ($(this).data("loaded") != true) {

                    var _markerContent = '<div class="info_content">';
    
                    for(var i = 0; i<lista_markers.length; i++){
                        if(lista_markers[i].getVisible() == true && (lista_markers[i].getPosition().lat() === marker.getPosition().lat() && lista_markers[i].getPosition().lng() === marker.getPosition().lng()) ){
                            _markerContent += lista_markers[i]["infoWindow"].getContent();                       
                        }
                    }
    
                    _markerContent += '</div>';
                    _info_window.setContent(_markerContent);

                    $(this).data("loaded", true);
                }
                

            });
        });
    },


    agruparMarcadores : function(){

        if(lista_markers.length > 0){

            var yo = this;
            markerCluster = new MarkerClusterer(yo.mapa, lista_markers,
                {
                    imagePath: staticsURLs.imagePathIcon,
                    maxZoom : 12
                }
            );
        }

    },

    zoomMarcadores : function(){

        var bounds = new google.maps.LatLngBounds();
        for (var i = 0; i < lista_markers.length; i++) {
            bounds.extend(lista_markers[i].getPosition());
        }

        map.fitBounds(bounds);

    },

    desagruparMarcadores : function(){

        var yo = this;

        markerCluster.clearMarkers();

    }


});