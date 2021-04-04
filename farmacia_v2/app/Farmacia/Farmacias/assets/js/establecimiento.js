/*	Bonotes Abreviados	*/

//	Deshabilitar
function est(e){
	token	=	$(e).closest('tr').data("token");
	estado	=	$(e).closest('tr').data("estado");
	titulo	=	(estado == "1")	?	"Inhabilitar Establecimiento Farmacéutico"	:	"Habilitar Establecimiento Farmacéutico";
	if(token != ""){
		xModal.open(Base.getBaseUri()   +   'Farmacia/Farmacias/Establecimiento/cambiar_estado/'+token, titulo, '90');
		var d = new Date();
		// d.setMonth(d.getMonth() + 1);

		setTimeout(() => {
			$("#fc_inicio").datepicker({
				useCurrent	:	false,
				inline		:	false,
				language	:	"es",
				startDate	:	new Date(d.getFullYear(), d.getMonth() - 1, d.getDate()),
				autoclose	:	true,
				beforeShow	:	function () { //Para que aparezca en Modal
					setTimeout(function () {
						$('.ui-datepicker').css('z-index', 99999999999999);
					}, 0);
				}
			}).on('hide', function(e) {
				e.stopPropagation();
				deshabilitar_fechas();
			});

			$("#fc_termino").datepicker({
				useCurrent	:	false,
				inline		:	false,
				language	:	"es",
				startDate	:	new Date(d.getFullYear(), d.getMonth() - 1, d.getDate()),
				autoclose	:	true,
				beforeShow	:	function () { //Para que aparezca en Modal
					setTimeout(function () {
						$('.ui-datepicker').css('z-index', 99999999999999);
					}, 0);
				}
			}).on('hide', function(e) {
				e.stopPropagation();
			});
		}, 1500);
	}else{
		xModal.warning("Ha ocurrido un problema, si este persiste favor contactar con <b>Mesa de Ayuda</b>.");
	}
}
//	Editar
function ed(e){
	token	=	$(e).closest('tr').data("token");
	if(token != ""){
		window.open(Base.getBaseUri()	+   'Farmacia/Farmacias/Establecimiento/editar/'+token,	"_blank");
	}else{
		xModal.warning("Ha ocurrido un problema, si este persiste favor contactar con <b>Mesa de Ayuda</b>.");
	}
}
//	Agregar DT
function dt(e){
	token	=	$(e).closest('tr').data("token");
	if(token != ""){
		xModal.open(Base.getBaseUri()   +   'Farmacia/Farmacias/empresa/editarEmpresa/'+token, 'Editar Empresa', '90');
	}else{
		xModal.warning("Ha ocurrido un problema, si este persiste favor contactar con <b>Mesa de Ayuda</b>.");
	}
}
//	Detalle Horario Funcionamiento - Quimicos
function hq(e){
	token	=	$(e).closest('tr').data("token");
	if(token != ""){
		xModal.open(Base.getBaseUri()   +   'Farmacia/Farmacias/establecimiento/verHorario/'+token, 'Horario Establecimiento', '90');
		// window.open(Base.getBaseUri()   +   'Farmacia/Farmacias/establecimiento/verHorario/'+token, '_blank');
	}else{
		xModal.warning("Ha ocurrido un problema, si este persiste favor contactar con <b>Mesa de Ayuda</b>.");
	}
}

//	Personas Asignadas a Farmacia
function paf(e){
	token	=	$(e).closest('tr').data("token");
	if(token != ""){
		xModal.open(Base.getBaseUri()   +   'Farmacia/Farmacias/empresa/editarEmpresa/'+token, 'Editar Empresa', '90');
	}else{
		xModal.warning("Ha ocurrido un problema, si este persiste favor contactar con <b>Mesa de Ayuda</b>.");
	}
}						
//	Ver Establecimiento
function ver(e){
	token	=	$(e).closest('tr').data("token");
	if(token != ""){
		xModal.open(Base.getBaseUri()   +   'Farmacia/Farmacias/Establecimiento/ver/'+token, 'Editar Empresa', '90');
	}else{
		xModal.warning("Ha ocurrido un problema, si este persiste favor contactar con <b>Mesa de Ayuda</b>.");
	}
}	

/*	INDEX	-	Filtro/Grilla	*/
var	Grilla		=	{
	cargar			:	function(btn){
		btn.disabled						=	true;
		var btnTexto						=	$(btn).html();
		$(btn).html('Cargando...');
		formData							=	$("#formMaestroEstablecimiento").serializeArray();

		console.log(formData);

		
		$.ajax({
			data		:	formData,
			url			:	Base.getBaseUri() + "Farmacia/Farmacias/Establecimiento/cargarGrilla",
			dataType	:	'json',
			type		:	'post',
			error		:	function(){
				xModal.danger("Ha ocurrido un error, si este persiste favor contactar con <b>Mesa de Ayuda</b>.",function(){
					$(btn).html(btnTexto).attr('disabled', false);
				});
			},
			success		:	function(response){
				if(response.correcto){
					$("#contenedor_grilla_establecimiento").html(response.html);
					$("#grillaEstablecimiento").dataTable(dataOptions);
					$(btn).html(btnTexto).attr('disabled', false);

				}else{
					xModal.warning(response.mensaje,function(){
						$("#contenedor_grilla_establecimiento").html("Sin Registros. . .");
						$(btn).html(btnTexto).attr('disabled', false);
					});
				}
			}
		});


	},
	limpiar_filtros	:	function(){
		$("#id_local_tipo").val("0").trigger("change");
		$("#id_region").val();
		$("#id_comuna").val("0").trigger("change");
		$("#local_estado").val("99").trigger("change");
		$("#id_movil").val("99").trigger("change");
		$("#id_popular").val("99").trigger("change");
		$("#dt_asignado").val("99").trigger("change");
		$("#sel_turno").val("99").trigger("change");
	}
};

var	Opciones	=	{
	cambiarEstado			:	function(id,estado){
		var	token		=	$("#gl_token").val().trim();
		var	id_motivo	=	$("#id_motivo").val().trim();
		var	fc_inicio	=	$("#fc_inicio").val().trim();
		var	fc_termino	=	$("#fc_termino").val().trim();
		var	gl_motivo	=	$("#gl_motivo").val().trim();
		var	error		=	"";
		
		if(token == ""){
			error		+=	"Ha ocurrido un error, si este persiste favor contactar con <b>Mesa de Ayuda</b>.";
		}else{
			if(id_motivo == ""){
				error		+=	"	-	El campo <b>Motivo Inhabilitación</b> es requerido. <br/>";
			}
			if(fc_inicio == ""){
				error		+=	"	-	El campo <b>Fecha Inhabilitación</b> es requerido. <br/>";
			}
			if(fc_termino == ""	&&	$("#fc_termino").is(":visible")){
				error		+=	"	-	El campo <b>Fecha Término Inhabilitación</b> es requerido. <br/>";
			}
			// if(gl_motivo == ""	&&	$("#gl_motivo").is(":visible")){
			// 	error		+=	"	-	El campo <b>Especifique Motivo</b> es requerido. <br/>";
			// }
		}

		if(error != ""){
			xModal.danger(error);
		}else{
			xModal.confirm('Se deshabilitará el Establecimiento Farmacéutico. <br/><br/>¿Desea continuar?', function(){
				$.ajax({
					url			:	Base.getBaseUri() + "Farmacia/Farmacias/Establecimiento/deshabilitar",
					dataType	:	'json',
					type		:	'post',
					data		:	{
						gl_token	:	token,
						id_motivo	:	id_motivo,
						fc_inicio	:	fc_inicio,
						fc_termino	:	fc_termino,
						gl_motivo	:	gl_motivo,
					},
					error		:	function(){
						xModal.danger("Ha ocurrido un error, si este persiste favor contactar con <b>Mesa de Ayuda</b>.");
					},
					success		:	function(response){
						if(response.correcto){
							xModal.success(response.mensaje_exito, function(){
								setTimeout(() => {
									location.href	=	Base.getBaseUri()	+	"Farmacia/Farmacias/Establecimiento/";
								}, 350);
							});
						}else{
							msg			=	"Ha ocurrido un error, si este persiste favor contactar con <b>Mesa de Ayuda</b>.";
							if(response.mensaje){
								msg		=	response.mensaje;
							}
							xModal.danger(msg);
						}
					}
				});
			});
		}


	},
}

/*	Inhabilitar	*/
function deshabilitar_fechas(){
	var	fc_inicio			=	$("#fc_inicio").datepicker('getDate');
	var	fc_termino			=	$("#fc_termino").datepicker('getDate');

	if(fc_termino < fc_inicio){
		$("#fc_termino").datepicker('setDate',fc_inicio);
	}
	$("#fc_termino").datepicker('setStartDate',fc_inicio);
}
function cambio_motivo(e){
	id	=	e.value;
	if(id == 1){
		$("#div_termino").hide("medium");
		$(".bo_temporal").hide("medium");
	}
	else if(id == 2){
		$("#div_termino").show("medium");
		$(".bo_temporal").hide("medium");
	}
	else if( id == 3 || id == 5 || id == 7){
		$("#div_termino").hide("medium");
		$(".bo_temporal").show("medium");
	}
	else{
		$("#div_termino").hide("medium");
		$(".bo_temporal").hide("medium");
	}
}

function ver_chk_temporal(){
	console.log($("#bo_temporal").is(":checked"));
	if($("#bo_temporal").is(":checked")){
		$("#div_termino").show("medium");
	}else{
		$("#div_termino").hide("medium");
	}
}