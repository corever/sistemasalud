/* global BASE_URI */
$("#chkextranjero").on('click', function (e) {
	if ($('#chkextranjero').is(':checked')) {
		$('#nacional').hide();
		$('#rut').val("");
		$('#extranjero').show();
        $("#div_rut_no_informado").hide();
        $("#chk_no_informado").prop("checked",false);
	} else {
		$('#nacional').show();
		$('#extranjero').hide();
		$('#inputextranjero').val(""); 
        $('#listado-adjuntos-fonasa').html("");
        $("#div_rut_no_informado").show();
	}
});

$("#bo_direccion_mordedura").on('click', function (e) {
	if ($('#bo_direccion_mordedura').is(':checked')) {
		$("#id_region_animal").val($("#region").val());
        $("#id_region_animal").trigger("change");
        $("#gl_direccion").val($("#direccion").val());
        $("#gl_latitud_animal").val($("#gl_latitud").val());
        $("#gl_longitud_animal").val($("#gl_longitud").val());
        $("#gl_referencias_animal").val($("#gl_datos_referencia").val());
        setTimeout(function(){$("#id_comuna_animal").val($("#comuna").val());},500);
	} else {
		$("#id_region_animal").val(0);
        $("#gl_direccion").val("");
        $("#gl_latitud_animal").val("");
        $("#gl_longitud_animal").val("");
        $("#id_comuna_animal").val(0);
        $("#gl_referencias_animal").val("");
	}
});

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
	//mapaAnimal.seteaPlaceInput("gl_direccion");
	mapaAnimal.inicio();
	mapaAnimal.cargaMapa();
	mapaAnimal.setMarkerInputs();

    lugares(mapaAnimal);
});

function lugares(mapa){
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
            map.setCenter({lat:parseFloat(lat), lng : parseFloat(lng)})
            mapa.seteaMarker();
            map.setZoom(18);
        }
    });
}

var Animal ={
    cargarRazaporEspecie : function(especie,combo,raza){
        $("#raza").val(0);
		if(especie != 0){
			$.post(BASE_URI+'index.php/Paciente/cargarRazasporEspecie',{especie:especie},function(response){
				if(response.length > 0){
					var total = response.length;
					var options = '<option value="0">Seleccione una Raza</option>';
					for(var i=0; i<total; i++){
						if(raza == response[i].id_animal_raza){
							options += '<option value="'+response[i].id_animal_raza+'" selected >'+response[i].gl_nombre+'</option>';	
						}else{
							options += '<option value="'+response[i].id_animal_raza+'" >'+response[i].gl_nombre+'</option>';
						}
						
					}
					$('#'+combo).html(options);
				}else{
                    $('#'+combo).html('<option value="0">Seleccione una Raza</option>');
                }
			},'json');
		}else{
            $('#'+combo).html('<option value="0">Seleccione una Raza</option>');
		}
	},
    muestraOtro : function(){
        if ($("#id_animal_especie").val() == 4){
            $("#div_otra_especie").show();
        }else{
            $("#div_otra_especie").hide();
        }
        if ($("#id_animal_especie").val() == 1 || $("#id_animal_especie").val() == 2){
            $("#div_raza_animal").show();
        }else{
            $("#div_raza_animal").hide();
        }
    },
    guardaAnimalMordedor : function(btn){
        var e                   = jQuery.Event( "click" );
        var button_process      = buttonStartProcess($(btn), e);
        var params              = $("#form_animal").serializeArray();
        var id_animal_especie   = $("#id_animal_especie").val();
        
        if($("#id_region_animal").hasAttr("disabled")){
            params.push({
                "name": 'id_region_animal',
                "value": $("#id_region_animal").val()
            });
        }
        if($("#id_comuna_animal").hasAttr("disabled")){
            params.push({
                "name": 'id_comuna_animal',
                "value": $("#id_comuna_animal").val()
            });
        }
        if($("#bo_ubicable_1").is(":checked")){
            params.push({
                "name": 'bo_ubicable',
                "value": 1
            });
        }else{
            params.push({
                "name": 'bo_ubicable',
                "value": 0
            });
        }
        
        if(id_animal_especie == 0){
            xModal.danger("Debe ingresar una Especie de Animal!",function(){buttonEndProcess(button_process);});
        }else{
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: params,
                type: "post",
                url: BASE_URI + "index.php/Paciente/guardaAnimalMordedor",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.danger('Error: No se pudo Ingresar un nuevo Registro',function(){buttonEndProcess(button_process);});
                },
                success: function (data) {
                    if (data.correcto) {
                        //xModal.success('Éxito: Se Ingresó nuevo Animal!');
                        var imagenMapa      = new EventoReporteMapaImagen('mapAnimal');
                        imagenMapa.crearImagen(function(){
                            xModal.closeAll();
                            Animal.grillaAnimalMordedor();
                            buttonEndProcess(button_process);
                        });
                    }else{
                         xModal.danger(data.mensaje,function(){buttonEndProcess(button_process);});
                    }
                }
            });
        }
    },
    grillaAnimalMordedor : function(){
        $.ajax({
            data : {},
            url : BASE_URI + "index.php/Paciente/grillaAnimalMordedor",
            dataType : 'html',
            type : 'post',
            success : function(response){
                $("#grilla-animal-mordedor").html(response);
            }
        });
    },
    eliminarAnimalGrilla : function(id_animal){
        $.ajax({
            data : {id_animal:id_animal},
            url : BASE_URI + "index.php/Paciente/eliminarAnimalGrilla",
            dataType : 'json',
            type : 'post',
            success : function(data){
                if (data.correcto) {
                    Animal.grillaAnimalMordedor(data.gl_token);
                }
            }
        });
    },
    viveConPaciente : function(){
        if($("#bo_vive_con_paciente_1").is(":checked")){
            
            $("#bo_domicilio_conocido_1").prop("checked",true);
            $(".bo_domicilio_conocido").prop("disabled",true);
            $("#id_region_animal").attr("disabled",true);
            $("#id_comuna_animal").attr("disabled",true);
            $("#gl_direccion").attr("readonly",true);
            $("#gl_referencias_animal").attr("readonly",true);
            $("#gl_latitud_animal").attr("readonly",true);
            $("#gl_longitud_animal").attr("readonly",true);
            $("#div_direccion_mordedura").hide();
            
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: {},
                type: "post",
                url: BASE_URI + "index.php/Paciente/mordedorViveConPaciente",
                error: function (xhr, textStatus, errorThrown) {
                    //xModal.danger('Error: No se pudo Ingresar un nuevo Registro');
                },
                success: function (data) {
                    if (data.correcto) {
                        $("#mapAnimal").data("editable",0);
                        var mapaAnimal = new MapaFormulario("mapAnimal");
                        mapaAnimal.seteaIcono("static/images/markers/mordedor.png");
                        mapaAnimal.seteaLatitudInput("gl_latitud_animal");
                        mapaAnimal.seteaLongitudInput("gl_longitud_animal");
                        mapaAnimal.seteaLongitud("-70.6504492");
                        mapaAnimal.seteaLatitud("-33.4378305");
                        mapaAnimal.seteaZoom(18);
                        mapaAnimal.inicio();
                        mapaAnimal.cargaMapa();
                        mapaAnimal.setMarkerInputs(0);
                        lugares(mapaAnimal);
                        
                        $("#id_region_animal").val(data.region);
                        $("#id_region_animal").trigger("change").attr("disabled",true);
                        $("#gl_direccion").val(data.direccion).attr("readonly",true);
                        $("#gl_referencias_animal").val(data.referencia).attr("readonly",true);
                        $("#gl_latitud_animal").val(data.latitud).attr("readonly",true);
                        $("#gl_longitud_animal").val(data.longitud).attr("readonly",true);
                        setTimeout(function(){$("#id_comuna_animal").val(data.comuna).attr("disabled",true);$("#gl_latitud_animal").trigger("change");},500);
                    }else{
                        xModal.info(data.mensaje);
                        $("#div_direccion_animal").hide();
                        $("#bo_vive_con_paciente_1").prop("checked",false);
                        $("#bo_domicilio_conocido_1").prop("checked",false);
                        $(".bo_domicilio_conocido").prop("disabled",false);
                    }
                }
            });
        }else{
            $("#mapAnimal").data("editable",1);
            var mapaAnimal = new MapaFormulario("mapAnimal");
            mapaAnimal.seteaIcono("static/images/markers/mordedor.png");
            mapaAnimal.seteaLatitudInput("gl_latitud_animal");
            mapaAnimal.seteaLongitudInput("gl_longitud_animal");
            mapaAnimal.seteaLongitud("-70.6504492");
            mapaAnimal.seteaLatitud("-33.4378305");
            mapaAnimal.seteaZoom(18);
            mapaAnimal.inicio();
            mapaAnimal.cargaMapa();
            mapaAnimal.setMarkerInputs();
            lugares(mapaAnimal);
            
            //Vaciar datos direccion
            var region_establecimiento = 0;
            if($("#establecimientosalud").val()>0){
                region_establecimiento = $("#establecimientosalud option:selected").attr("region_establecimiento");
                console.log(region_establecimiento);
            }
            $("#id_region_animal").val(region_establecimiento).attr("disabled",false);
            $("#gl_direccion").val("").attr("readonly",false);
            $("#gl_referencias_animal").val("").attr("readonly",false);
            $("#gl_latitud_animal").val("").attr("readonly",false);
            $("#gl_longitud_animal").val("").attr("readonly",false);
            $("#id_comuna_animal").val(0).attr("disabled",false);
            $("#bo_domicilio_conocido_1").prop("checked",false);
            $(".bo_domicilio_conocido").prop("disabled",false);
        }
        Animal.mostrarDireccion();
    },
    mostrarDireccion : function(){
        if($("#bo_domicilio_conocido_1").is(":checked")){
            
            $("#div_direccion_animal").show();
            
            if($("#bo_vive_con_paciente_0").is(":checked")){
                $("#div_direccion_mordedura").show();
            }
            
            $("#div_ubicable").hide();
            $("#bo_ubicable_1").prop("checked",false);
            $("#bo_ubicable_0").prop("checked",false);

        }else{
            var region_establecimiento = 0;
            if($("#establecimientosalud").val()>0){
                region_establecimiento = $("#establecimientosalud option:selected").attr("region_establecimiento");
                console.log(region_establecimiento);
            }
            $("#id_region_animal").val(region_establecimiento);
            $("#div_direccion_animal").hide();
            $("#id_region_animal").trigger("change").attr("disabled",false);
            $("#gl_direccion").val("").attr("readonly",false);
            $("#gl_referencias_animal").val("").attr("readonly",false);
            $("#gl_latitud_animal").val("").attr("readonly",false);
            $("#gl_longitud_animal").val("").attr("readonly",false);
            $("#id_comuna_animal").val(0).attr("disabled",false);
            $("#div_direccion_mordedura").hide();
            
            if($("#bo_domicilio_conocido_0").is(":checked")){
                $("#div_ubicable").show();
            }
            
            Animal.mostrarDireccionUbicable();
        }        
    },
    mostrarDireccionUbicable : function(){
        if($("#bo_ubicable_1").is(":checked")){
            $("#div_direccion_animal").show();
        }else{
            $("#div_direccion_animal").hide();
        }
        
        var region_establecimiento = 0;
        if($("#establecimientosalud").val()>0){
            region_establecimiento = $("#establecimientosalud option:selected").attr("region_establecimiento");
        }
        $("#id_region_animal").val(region_establecimiento);
        $("#id_region_animal").trigger("change").attr("disabled",false);
        $("#gl_direccion").val("").attr("readonly",false);
        $("#gl_referencias_animal").val("").attr("readonly",false);
        $("#gl_latitud_animal").val("").attr("readonly",false);
        $("#gl_longitud_animal").val("").attr("readonly",false);
        $("#id_comuna_animal").val(0).attr("disabled",false);
    },
}