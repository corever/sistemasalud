$(document).ready(function () {
	
	
	var agenda = new Array();
    
    var arrAgenda = $('#arrAgendaExamenes').val();
        
    if (arrAgenda != "") {
        arrAgenda = arrAgenda.substring(0,arrAgenda.length-1);
        var arrayAgenda = arrAgenda.split(';');

        for (var i=0; i<arrayAgenda.length; i++) {
            var subarrAgenda= arrayAgenda[i].split(',');
            var folio		= subarrAgenda[0];
            var id_agenda	= subarrAgenda[3];
            var id_estado	= subarrAgenda[4];
            var tooltip 	= subarrAgenda[5];
            var descripcion = subarrAgenda[6];
            var gl_estado   = subarrAgenda[7];
            var fecha		= "";

            if (subarrAgenda[2] == "") {
                fecha = subarrAgenda[1];
            } else {
                fecha = subarrAgenda[1].toString() + 'T' + 
                        subarrAgenda[2].toString();
            }
            
            agenda[i] = {   title: folio, descripcion:descripcion, gl_estado:gl_estado, start: fecha, id_estado:id_estado, tooltip:tooltip,
                            url: BASE_URI + "index.php/AgendaPacientes/ver/?id_agenda="+id_agenda };
        }
    }
    
	$('#calendarPacientes').fullCalendar({
		header: {
			left	: 'prev,next today',
			center	: 'title',
			right	: 'month, listWeek'
		},
		navLinks	: true,
		height		: 800,
		editable	: false,
		eventLimit	: true,
		events		: agenda,
		eventRender	: function(event,element) {
            element.find('.fc-title').append("</br>" + event.descripcion + "</br>" + event.gl_estado);
			if (event.id_estado == 2) {
				element.css({
                    'background-color': '#00a65a',
                    'border-color': '#00a65a'
                });
			}
            
            element.qtip({
                content: event.tooltip,
                style: {
                    background: 'black',
                    color: '#FFFFFF'
                },
                position: {
                    corner: {
                        target: 'center',
                        tooltip: 'bottomMiddle'
                    }
                }
            });
		},
		eventClick	: function(event) {
			if (event.url) {
				xModal.open(event.url, 'Ver Detalle', 70);
				return false;
			}
		}
	});
});

var Agenda = {
    aplicar_vacuna: function() {
        
    },
    derivar: function() {
        
    }
};