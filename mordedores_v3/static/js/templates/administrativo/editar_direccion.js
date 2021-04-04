/* global BASE_URI */
$("#id_region_animal").on('change', function (e) {
	$("#gl_direccion").val("");
	var longitud_region = $("#id_region_animal").children(":selected").attr("name");
	var latitud_region	= $("#id_region_animal").children(":selected").attr("id");
	
	$("#gl_longitud_animal").val(longitud_region);
	$("#gl_latitud_animal").val(latitud_region);
	$("#gl_latitud_animal").trigger("change");
	
	if($('#centrosalud').is('[disabled=disabled]')){
		$('#form').find('#centrosalud').attr('disabled', false);
		$("#cambio_direccion").val("1"); //variable global JS
	}
	
});
$("#id_comuna_animal").on('change', function (e) {
	$("#gl_direccion").val("");
	var longitud_comuna = $("#id_comuna_animal").children(":selected").attr("name");
	var latitud_comuna	= $("#id_comuna_animal").children(":selected").attr("id");
	
	$("#gl_longitud_animal").val(longitud_comuna);
	$("#gl_latitud_animal").val(latitud_comuna);
	$("#gl_latitud_animal").trigger("change");
	
	if($('#centrosalud').is('[disabled=disabled]')){
		$('#form').find('#centrosalud').attr('disabled', false);
		$("#cambio_direccion").val("1");//variable global JS
	}
});

$(document).ready(function () {
	var isDisabled      = $("#id_region_animal").is(':disabled');
	var longitud_region = $("#id_region_animal").children(":selected").attr("name");
	var latitud_region  = $("#id_region_animal").children(":selected").attr("id");
	if (isDisabled){
		$("#gl_longitud_animal").val(longitud_region);
		$("#gl_latitud_animal").val(latitud_region);
		$("#gl_latitud_animal").trigger("change");
	}
	var mapaAnimal = new MapaFormulario("mapAnimal");
	mapaAnimal.seteaIcono("static/images/markers/mordedor.png");
	mapaAnimal.seteaLatitudInput("gl_latitud_animal");
	mapaAnimal.seteaLongitudInput("gl_longitud_animal");
	mapaAnimal.seteaLongitud("-70.6504492");
	mapaAnimal.seteaLatitud("-33.4378305");
	mapaAnimal.seteaZoom(18);
	mapaAnimal.seteaPlaceInput("gl_direccion");
	mapaAnimal.inicio();
	mapaAnimal.cargaMapa();
	mapaAnimal.setMarkerInputs();

});

var Animal ={
    guardaAnimalMordedor : function(btn){
        btn.disabled = true;
        var btnTexto = $(btn).html();
        $(btn).html('Guardando...');
        
        var params              = $("#form_animal").serializeArray();
        var bandeja             = $("#gl_bandeja").val();
        var id_region_animal    = $("#id_region_animal").val();
        var id_comuna_animal    = $("#id_comuna_animal").val();
        var gl_direccion        = $("#gl_direccion").val();
        
        if (id_region_animal == 0){
            xModal.danger('Debe seleccionar una Región.',function(){$(btn).html(btnTexto).attr('disabled', false);});
        } else if (id_comuna_animal == 0) {
            xModal.danger('Debe seleccionar una Comuna.',function(){$(btn).html(btnTexto).attr('disabled', false);});
        } else if (gl_direccion === ""){
            xModal.danger('Debe seleccionar una Dirección.',function(){$(btn).html(btnTexto).attr('disabled', false);});
        }else{
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: params,
                type: "post",
                url: BASE_URI + "index.php/Administrativo/editarDireccionBD",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.danger('Error: No se pudo Ingresar un nuevo Registro',function(){$(btn).html(btnTexto).attr('disabled', false);});
                },
                success: function (data) {
                    if (data.correcto) {
                        //xModal.success('Éxito: Se Ingresó nuevo Animal!');
                        setTimeout(function () {
                            xModal.close();
                            Animal.recargaGrillaMordedor(bandeja);
                            $(btn).html(btnTexto).attr('disabled', false);
                            $("#btn_buscar, #buscar").trigger("click");
                        }, 500);
                    }else{
                         xModal.danger(data.mensaje,function(){$(btn).html(btnTexto).attr('disabled', false);});
                    }
                }
            });
        }
    },
    recargaGrillaMordedor : function(bandeja){
        var token_expediente = $("#gl_token_expediente").val();
        $.ajax({
            data : {gl_token:token_expediente,bandeja:bandeja},
            url : BASE_URI + "index.php/Agenda/cabeceraGrillaMordedor",
            dataType : 'html',
            type : 'post',
            success : function(response){
                $("#cabecera_grilla_mordedor").html(response);
            }
        });
    },
}