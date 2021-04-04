$(document).ready(function () {
	var isDisabled      = $("#region_contacto").is(':disabled');
	var longitud_region = $("#region_contacto").children(":selected").attr("name");
	var latitud_region  = $("#region_contacto").children(":selected").attr("id");
	if (isDisabled){
		$("#gl_longitud_exp").val(longitud_region);
		$("#gl_latitud_exp").val(latitud_region);
		$("#gl_latitud_exp").trigger("change");
	}
	
	var agenda = new Array();
	$('#calendarPacientes').fullCalendar({
		header: {
			left	: 'prev,next today',
			center	: 'title',
			right	: 'month, listWeek'
		},
		navLinks	: true,
		height		: 650,
		editable	: false,
		eventLimit	: true,
		/* events		: agenda, */
		eventClick	: function(event) {
			if (event.url) {
				xModal.open(event.url, 'Agenda Pacientes', 85);
				return false;
			}
		}
	});
});