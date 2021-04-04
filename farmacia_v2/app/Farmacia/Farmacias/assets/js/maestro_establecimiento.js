var maestro_establecimiento = {
	init					:	function(){
		iniciarMapa();
	},

	editarEstablecimiento	:	function(id){
		
		$.ajax({
			url     : Base.getBaseUri() + "Farmacia/Farmacias/establecimiento/editarEstablecimiento",
			dataType : 'json',
			type : 'post',
			data : id,
			success : function(response){
				if(response.estado){
					xModal.open(response.html,'Editar establecimiento', 90, 'modal_editarEstablecimiento');
				}else{
					xModal.danger(response.mensaje);
				}
			}
		});
	},

	agregarRecetario		:	function(btn){
		if($("#div_form_recetario").is(":visible")){
			$("#div_form_recetario").hide("medium");
			var	cam		=	'<i class="fa fa-plus"></i>&nbsp;&nbsp;<b>Agregar Recetario</b>';
			$(btn).html(cam);
			$("#bo_recetario").val("0");
		}else{
			$("#div_form_recetario").show("medium");
			var	cam		=	'<i class="fa fa-minus"></i>&nbsp;&nbsp;<b>Quitar Recetario</b>';
			$(btn).html(cam);
			$("#bo_recetario").val("1");
		}
	},

	guardarEstablecimiento	:	function(){
		let formData			=	$("#formEstablecimiento").serializeArray();
		var	error				=	Base.verificarRequeridos();
		error					+=	Horario.validar();
		
		$.map($("input[name='arr_clasificacion']") ,function(clasif) {
			checked		=	clasif.checked;
			value		=	clasif.value;
			id			=	clasif.id;
			formData.push({"name":id, "value": checked});
		});

		$.map($("input[name='chk_tipo_recetas']") ,function(clasif) {
			checked		=	clasif.checked;
			value		=	clasif.value;
			id			=	clasif.id;
			formData.push({"name":id, "value": checked});
		});

		if($("#bo_movil").is(":checked") &&  arr_recorrido.length == 0){
			error		+=	"Debe ingresar <b> Direccion(es) del Recorrido</b> realizado. <br/>";
		}
		
		formData.push({"name":"bo_franquicia",			"value": $("#bo_franquicia").is(":checked")});
		formData.push({"name":"bo_impide_turno",		"value": $("#bo_impide_turno").is(":checked")});
		formData.push({"name":"bo_ver_mapa",			"value": $("#bo_ver_mapa").is(":checked")});
		formData.push({"name":"bo_recetario_en_local",	"value": $("#bo_recetario_en_local").is(":checked")});
		formData.push({"name":"arr_recorrido",			"value": JSON.stringify(arr_recorrido)});
		
		if(error	!= ""){
			xModal.warning(error);
		}else{
			$.ajax({
				url			:	Base.getBaseUri() + "Farmacia/Farmacias/establecimiento/guardarNueva",
				dataType	:	'json',
				type		:	'post',
				data		:	formData,
				error		:	function(){
					xModal.danger("Ha ocurrido un Error, si este persiste favor contactar con <b>Mesa de Ayuda</b>.");
				},
				success		:	function(response){
					if(response.correcto){
						rci						=	response.cod_rci;
						msg						=	"";
						if(response.bo_edicion){
							msg					=	"El Establecimiento Farmacéutico con Número RCI <b>"+rci+"</b> ha sido <b>Editado</b> Exitosamente.";
						}else{
							msg					=	"El Establecimiento Farmacéutico con Número RCI <b>"+rci+"</b> ha sido <b>Creado</b> Exitosamente.";
						}
						xModal.success(msg, function () {
							setTimeout(() => {
								location.href	=	Base.getBaseUri() + "Farmacia/Farmacias/establecimiento/crearEstablecimiento";
							}, 300);
						});
					}else{
						xModal.danger(response.mensaje_error);
					}
				}
			});
		}
	},

	habilitar				:	function(btn){
		btn.disabled						=	true;
		var btnTexto						=	$(btn).html();
		$(btn).html('Habilitando...');
		
		var	fc_habilita						=	$("#fc_habilitacion").val();
		var	gl_token						=	$("#gl_token_habilitar").val();
		var	error							=	"";

		if(fc_habilita	==	""){
			error	+=	"	-	El campo <b>Fecha de Habilitación</b> es requerido.";
		}

		if(error	!=	""){
			xModal.danger(error,function(){
				$(btn).html(btnTexto).attr('disabled', false);
			});
		}else{
			$.ajax({
				url			:	Base.getBaseUri() + "Farmacia/Farmacias/establecimiento/habilitar",
				dataType	:	'json',
				type		:	'post',
				data		:	{
					gl_token		:	gl_token,
					fc_habilita		:	fc_habilita,
				},
				error		:	function(){
					xModal.danger("Ha ocurrido un Error, si este persiste favor contactar con <b>Mesa de Ayuda</b>.",function(){
						$(btn).html(btnTexto).attr('disabled', false);
					});
				},
				success		:	function(response){
					if(response.correcto){
						xModal.success(response.mensaje_exito,function(){
							$(btn).html(btnTexto).attr('disabled', false);
							location.href	=	Base.getBaseUri()	+	"Farmacia/Farmacias/establecimiento/";
						});
					}else{
						xModal.danger(response.mensaje_error);
					}
				}
			});
		}
		
		$(btn).html(btnTexto).attr('disabled', false);
	}
};

$("#id_recetario_tipo").on("change",function(){
	id	=	$("#id_recetario_tipo").val();
	if(id == 1){
		$("#div_chk_recetario_centralizado").show("medium");
	}else{
		$("#div_chk_recetario_centralizado").hide("medium");
	}
});

$(document).ready(function () {
	setTimeout(() => {
		$('.timepicker').timepicker({
			timeFormat		:	'HH:mm',
			interval		:	15,
			// minTime			:	'0',
			// maxTime		:	'6:00pm',
			// defaultTime		:	'0',
			// startTime		:	'00:00',
			dynamic			:	false,
			dropdown		:	true,
			scrollbar		:	false,
		});
	}, 50);
});

const arr_dias	=	["lunes","martes","miercoles","jueves","viernes","sabado","domingo","festivo"];

var	Horario		=	{
	copiarHorario		:	function(dia_copiar,dia_pegar=0){
		if(dia_pegar == 0){ //Por boton arrow
			dia_pegar = $("#"+dia_copiar).closest('th').nextAll("th:visible").attr("id");
		}
		$("#man_inicio_"+dia_pegar).val(
			$("#man_inicio_"+dia_copiar).val()
		);
		$("#man_fin_"+dia_pegar).val(
			$("#man_fin_"+dia_copiar).val()
		);
		$("#tar_inicio_"+dia_pegar).val(
			$("#tar_inicio_"+dia_copiar).val()
		);
		$("#tar_fin_"+dia_pegar).val(
			$("#tar_fin_"+dia_copiar).val()
		);
	},
	cambioHorario		:	function(e){
		var	btn		=	$(e);
		
		if($(".no_continuado").is(":visible")){
			var	cam		=	'<i class="far fa-calendar-alt"></i>&nbsp;&nbsp;<b>Seleccionar - Horario No Continuado</b>';
			btn.removeClass("btn-primary");
			btn.addClass("btn-success");
			btn.html(cam);
			
			$(".no_continuado").hide("medium");
			$(".ipt_no_continuado").val("");
			$("#bo_horario_continuado").val("1");
		}else{
			var	cam		=	'<i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;<b>Seleccionar - Horario Continuado</b>';
			btn.removeClass("btn-success");
			btn.addClass("btn-primary");
			btn.html(cam);

			$(".no_continuado").show("medium");
			$("#bo_horario_continuado").val("0");
		}
	},
	deshabilitar_dia	:	function(e,dia){
		var	btn		=	$(e);
		if($(".row_"+dia).is(":visible")){
			btn.removeClass("btn-outline-success");
			btn.addClass("btn-outline-danger");
			// btn.addClass("active");
			
			$(".row_"+dia).hide("fast");
			$("#bo_horario_"+dia).val("0");
		}else{
			btn.addClass("btn-outline-success");
			btn.removeClass("btn-outline-danger");
			// btn.removeClass("active");

			$(".row_"+dia).show("fast");
			$("#bo_horario_"+dia).val("1");
		}

	},
	cambio_rango		:	function(dia_desde,dia_hasta){

		var	elem_inicio				=	(element)	=>	element	==	dia_desde;
		var	elem_fin				=	(element)	=>	element	==	dia_hasta;
		
		var	indice_inicio			=	arr_dias.findIndex(elem_inicio);
		var	indice_fin				=	arr_dias.findIndex(elem_fin);
		// var	arr_slice				=	arr_dias.slice(indice_inicio, (indice_fin)+1);

		if(indice_fin < indice_inicio){
			$('#horario_copiar_hasta option[id="hasta_'+dia_desde+'"]').prop("selected",true);
		}

		var horario_copiar_hasta	=	$('#horario_copiar_hasta option');
		/*	días dentro de lo seleccionado	*/
		$.map(horario_copiar_hasta ,function(option) {
			idx		=	parseInt($(option).data("idx"));
			if(idx < indice_inicio){
				$(option).prop("disabled",true)
				.css('backgroundColor','#B7BFCD');
			}else{
				$(option).prop("disabled",false)
				.css('backgroundColor','white');
			}
		});
	},
	copiar_rango		:	function(e){
		var	copiar_desde			=	$('#horario_copiar_desde').val();
		var	copiar_hasta			=	$('#horario_copiar_hasta').val();
	
		var	elem_inicio				=	(element)	=>	element	==	copiar_desde;
		var	elem_fin				=	(element)	=>	element	==	copiar_hasta;
		
		var	indice_inicio			=	arr_dias.findIndex(elem_inicio);
		var	indice_fin				=	arr_dias.findIndex(elem_fin);
		var	arr_slice				=	arr_dias.slice((indice_inicio)+1, (indice_fin)+1);
		var	man_inicio				=	$("#man_inicio_"	+	copiar_desde).val();
		var	man_fin					=	$("#man_fin_"		+	copiar_desde).val();
		var	tar_inicio				=	$("#tar_inicio_"	+	copiar_desde).val();
		var	tar_fin					=	$("#tar_fin_"		+	copiar_desde).val();

		$.map(arr_slice ,function(option) {
			$("#man_inicio_"+option).val(man_inicio);
			$("#man_fin_"+option).val(man_fin);
			$("#tar_inicio_"+option).val(tar_inicio);
			$("#tar_fin_"+option).val(tar_fin);
		});
	},
	validar				:	function(){
		var	error				=	"";

		var	required_lunes		=	$('input').filter('[required_lunes]').filter(function() { return (this.value == "" || this.value == 0); });
		var	required_martes		=	$('input').filter('[required_martes]').filter(function() { return (this.value == "" || this.value == 0); });
		var	required_miercoles	=	$('input').filter('[required_miercoles]').filter(function() { return (this.value == "" || this.value == 0); });
		var	required_jueves		=	$('input').filter('[required_jueves]').filter(function() { return (this.value == "" || this.value == 0); });
		var	required_viernes	=	$('input').filter('[required_viernes]').filter(function() { return (this.value == "" || this.value == 0); });
		var	required_sabado		=	$('input').filter('[required_sabado]').filter(function() { return (this.value == "" || this.value == 0); });
		var	required_domingo	=	$('input').filter('[required_domingo]').filter(function() { return (this.value == "" || this.value == 0); });
		var	required_festivo	=	$('input').filter('[required_festivo]').filter(function() { return (this.value == "" || this.value == 0); });

		error					+=	evaluarRequired(required_lunes,		"Lunes");
		error					+=	evaluarRequired(required_martes,	"Martes");
		error					+=	evaluarRequired(required_miercoles,	"Miércoles");
		error					+=	evaluarRequired(required_jueves,	"Jueves");
		error					+=	evaluarRequired(required_viernes,	"Viernes");
		error					+=	evaluarRequired(required_sabado,	"Sábado");
		error					+=	evaluarRequired(required_domingo,	"Domingo");
		error					+=	evaluarRequired(required_festivo,	"Festivo");

		return error;
	}
};

function evaluarRequired(req,dia){
	var	correcto		=	true;
	var	error			=	"";
	req.each((index,item)=>{
		if($("#" + item.id).is(":visible")){
			correcto	=	false;
		}
	});
	if(!correcto){
		return	"	-	Debe completar <b>Horario</b> para día <b>"+dia+"</b>.<br/>";
	}else{
		return	"";
	}
}

$('#horario_copiar_desde').on("change",function(){
	var	horario_copiar_desde		=	$('#horario_copiar_desde').val();
	var	horario_copiar_hasta		=	$('#horario_copiar_hasta').val();
	Horario.cambio_rango(horario_copiar_desde,horario_copiar_hasta);
});

$("#id_farmacia").select2({ 
    width				:	'100%',
    minimumInputLength	:	3,
    ajax				:	{
        url					:	Base.getBaseUri()	+	'Farmacia/Farmacias/Empresa/listaSelect2/',
        dataType			:	'json',
        data				:	function(params) {
            var queryParameters	=	{
                q				:	params.term
            }
            return	queryParameters;
        },
        processResults		:	function(data){
            return	{
                results			:	data
            };
		},
        delay			:	450
    }
});

$("#id_tipo_establecimiento").on("change",function(){
	var	id		=	$("#id_tipo_establecimiento").val();
	if(id	==	4){
		$("#div_ver_mapa").show("medium");
	}else if($("#div_ver_mapa").is(":visible")){
		$("#div_ver_mapa").hide("medium");
		$("#bo_ver_mapa").prop("checked",false);
	}
});

$("#fc_resolucion").datepicker({
    useCurrent	:	false,
	inline		:	false,
	language	:	"es",
	endDate		:	new Date,
	autoclose	:	true,
    beforeShow	:	function () { //Para que aparezca en Modal
        setTimeout(function () {
            $('.ui-datepicker').css('z-index', 99999999999999);
        }, 0);
    }
});

function iniciarMapa(div_mapa = "mapaDireccion",inp_latitud = 'gl_latitud_direccion', inp_longitud = 'gl_longitud_direccion', inp_direccion = 'gl_direccion'){
	var	mapa	=	new MapaFormulario(div_mapa);
	mapa.seteaLatitudInput(inp_latitud);
	mapa.seteaLongitudInput(inp_longitud);
	mapa.seteaZoom(19);
	//mapa.seteaIcono("/web/assets/img/persona3.png"),
	mapa.seteaPlaceInput(inp_direccion);
	// mapa.seteaSearchPlaceInput("direccion_hidden");
	mapa.inicio();
	mapa.setMarkerInputs();
	mapa.cargaMapa();
	mapa.seteaAutoCloseInfo(false);
	
	mapa.getMapa().setZoom(19);
	$("#"+inp_latitud).trigger("change");
	//mapa.seteaMarker();
}

function cambiarLatitudLongitud(select,inp_direccion='gl_direccion',inp_lat='gl_latitud_direccion',inp_long='gl_longitud_direccion') {
	var longitud	=	$("#"+select).children(":selected").data('longitud');
	var latitud		=	$("#"+select).children(":selected").data('latitud');

	$("#"+inp_direccion).val("");
	$("#"+inp_long).val(longitud);
	$("#"+inp_lat).val(latitud);
	$("#"+inp_lat).trigger("change");
};

$("#bo_movil").on("change",function(e){
	if($("#bo_movil").is(":checked")){
		$("#div_direccion_tradicional").hide("medium");
		$("#div_direccion_recorrido").show("medium");
	}else{
		$("#div_direccion_tradicional").show("medium");
		$("#div_direccion_recorrido").hide("medium");
	}
});
$("#id_region").on("change",function(e){
	if($("#id_region").val() == 5){
		$("#div_rci").show("medium");
	}else{
		$("#div_rci").hide("medium");
	}
});

var	arr_recorrido	=	[];

/*	Est Farm Móvil	*/
var	Recorrido		=	{
	agregar				:	function(e){
		xModal.open(Base.getBaseUri() + "Farmacia/Farmacias/establecimiento/ingresarRecorridoMapa","Ingresar punto de Recorrido",80);
	},
	guardarPunto		:	function(e){
		var	error				=	Base.verificarRequeridos("required_mapa");

		if(error	!=	""){
			xModal.danger(error);
		}else{
			var	id_reg			=	$("#id_region_recorrido").val();
			var	gl_reg			=	$("#id_region_recorrido option:selected" ).text().trim();
			var	id_com			=	$("#id_comuna_recorrido").val();
			var	gl_com			=	$("#id_comuna_recorrido option:selected" ).text().trim();
			var	id_loc			=	$("#id_localidad_recorrido").val();
			var	gl_loc			=	$("#id_localidad_recorrido option:selected" ).text().trim();
			var	dir				=	$("#gl_direccion_recorrido").val();
			var	lat				=	$("#gl_latitud_recorrido").val();
			var	long			=	$("#gl_longitud_recorrido").val();
			var	correcto		=	true;

			var	hash			=	btoa(JSON.stringify({
				id_region			:	id_reg,
				gl_region			:	gl_reg,
				id_comuna			:	id_com,
				gl_comuna			:	gl_com,
				id_localidad		:	id_loc,
				gl_localidad		:	gl_loc,
				gl_direccion		:	dir,
				gl_latitud			:	lat,
				gl_longitud			:	long,
			}));

			arr_recorrido.forEach(rec => {
				if(hash == rec.hash){
					correcto	=	false;
				}
			});

			if(correcto){
				var	recorrido		=	{
					id_region			:	id_reg,
					gl_region			:	gl_reg,
					id_comuna			:	id_com,
					gl_comuna			:	gl_com,
					id_localidad		:	id_loc,
					gl_localidad		:	gl_loc,
					gl_direccion		:	dir,
					gl_latitud			:	lat,
					gl_longitud			:	long,
					hash				:	hash,
				};
	
				arr_recorrido.push(recorrido);
	
				Recorrido.cargarGrilla();
			}else{
				xModal.danger("Dirección ya ingresada.");
			}
		}
	},

	cargarGrilla		:	function(){
		var punto		=	'';
		var	total		=	arr_recorrido.length;

		if(total > 0){
			if(!$("div_direccion_recorrido").is(":visible")){
				$("div_direccion_recorrido").show("medium");
			}
			for (var i = 0; i < total; i++) {
				var	item	=	arr_recorrido[i];
				punto		+=	'<tr data-hash="'+item.hash+'" data-idx="'+i+'">';
				punto		+=	'	<td class="text-center">' + (i+1)	+ '</td>';
				punto		+=	'	<td class="text-center">' + item.gl_region	+ '</td>';
				punto		+=	'	<td class="text-center">' + item.gl_comuna	+ '</td>';
				punto		+=	'	<td class="text-center">' + item.gl_localidad	+ '</td>';
				punto		+=	'	<td class="text-center">' + item.gl_direccion	+ '</td>';
				punto		+=	'	<td class="text-center accion">	<button type="button" class="btn-d" onclick="Recorrido.borrarPunto(\''+item.hash+'\');"><i class="fa fa-trash"></i></button></td>';
				punto		+=	'</tr>';
			}
			$('#tabla_recorrido tbody').html(punto);
		}else{
			$('#tabla_recorrido tbody').html("Sin Registros.");
			$("div_direccion_recorrido").hide("medium");
		}
	},
	borrarPunto 		:	function(hash){
		arr_recorrido.forEach(rec => {
			if(hash == rec.hash){
				var index = arr_recorrido.indexOf(rec);
				arr_recorrido.splice(index, 1);
			}
		});
		Recorrido.cargarGrilla();
	}
	
}