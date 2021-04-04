var Dashboard = {

    entrarModulo: function (modulo) {
        var url         = $(modulo).data("url");
        var id_modulo   = $(modulo).data("id_modulo");
        
        $.ajax({
            dataType	: "json",
            cache		: false,
            async		: true,
            data		: {id_modulo:id_modulo},
            type		: "post",
            url			: Base.getBaseUri() + "Farmacia/Home/MisSistemas/entrarModulo",
            error		: function(xhr, textStatus, errorThrown){
                xModal.info('Error al cargar grilla.');
            },
            success		: function(data){
                location.href = Base.getBaseUri() + url;
            }
        });
    }
};