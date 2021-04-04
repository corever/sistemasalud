var Bitacora = {   

    loadBitacoraModulo : function(data){
        console.log(data);
        let modulo = data.modulo;
        let dataIn = new FormData();
    
        $.each( data, function( key, value ) {
            dataIn.append(key, value);
        });
        
        $.ajax({
            dataType   : "html",
            cache      : false,
            async      : true,
            data       : dataIn,
            processData: false,
            contentType: false,
            type       : "post",
            url        : Base.getBaseUri() + modulo+"/Bitacora/AdministrarBitacora/cargarModulo",
            error: function (xhr, textStatus, errorThrown) {
                xModal.danger('Error', function () {});
            },
            success: function (response) {
               
                $('#BitacoraModuloSection').html(response);   
            }
        });
    }

}