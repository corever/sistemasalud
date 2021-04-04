var EventoReporteMapaImagen = Class({
    
    /**
     * Contenedor del mapa
     */
    div : null,
    
    /**
     * Funciones que se ejecutan
     * despues de sacar foto del mapa
     */
    on_ready_functions : {},
    
    /**
    * Carga de dependencias
    * @returns void
    */
    __construct : function(div) {
        this.div = div;
    },
    
     /**
     * Añade funciones a ejecutar cuando la imagen esta cargada
     * @param {string} index identificador de la funcion para debug
     * @param {function} funcion funcion a ejecutar
     * @returns {void}
     */
    addOnReadyFunction : function(index, funcion, parametros){
        this.on_ready_functions[index] = {"funcion" : funcion,
                                          "parametros" : parametros};
    },
    
    /**
     * Captura imagen del mapa
     * @returns {undefined}
     */
    crearImagen : function(_callback=''){
        var yo = this;
        
        /*html2canvas(document.getElementById(yo.div)).then(function (canvas) {
            var base64encodedstring = canvas.toDataURL("image/jpeg", 1);
            console.log(base64encodedstring);
        });*/
        
        html2canvas(document.getElementById(yo.div),
        {
            //proxy : BASE_URI + "html2canvas.proxy.php",
            useCORS: true,
            onrendered: function(canvas)
            {
                var dataUrl = canvas.toDataURL("image/jpeg");
                var img = dataUrl.replace('data:image/jpeg;base64,', '');
                var finalImageSrc = 'data:image/jpeg;base64,' + img;
                //var img = dataUrl.replace(/^data:image\/(png|jpg);base64,/, "");
                return yo.crearImagenTemporal(finalImageSrc,yo.div,_callback);
                
            }
        });
        
        
    },
    
    /**
     * Guarda captura en archivo temporal
     * @param {type} img
     * @returns {Array.hash|currentData.hash}
     */
    crearImagenTemporal : function(img,mapa,_callback=''){
        var data = {"imagen" : img, "id_mapa" : mapa};
        
        $.ajax({         
            dataType: "json",
            cache: false,
            async: true,
            data: data,
            type: "post",
            url: BASE_URI + "index.php/Paciente/creaImagenMapa", 
            error: function(xhr, textStatus, errorThrown){
                console.log("Ha ocurrido un problema", errorThrown);
            },
            success:function(data){
                if(data.correcto){
                   if(_callback && (typeof _callback === "function")){
                        _callback();
                    }
                   return true;
                } else {
                    console.log("Ha ocurrido un problema", data.error);
                }
            }
        });
        return true;
    }
});


