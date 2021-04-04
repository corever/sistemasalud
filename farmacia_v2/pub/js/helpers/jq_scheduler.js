Base.loadScript({
	css	:	Base.getBaseDir()	+	'pub/js/plugins/jquery-schedule/schedule.min.css',
	js	:	[
		Base.getBaseDir()	+	'pub/js/plugins/jquery-schedule/schedule.min.js',
	]
});

var Horarios = {

	init : function(item, options){
		
	},

	test	:	function(){
		$('#schedule').jqs({
			mode: 'read',
			hour: 24,
			days: 8,
			periodDuration: 30,
			data: [],
			periodOptions: true,
			periodColors: [],
			periodTitle: '',
			periodBackgroundColor: 'rgba(82, 155, 255, 0.5)',
			periodBorderColor: '#2a3cff',
			periodTextColor: '#000',
			periodRemoveButton: 'Remove',
			periodDuplicateButton: 'Duplicate',
			periodTitlePlaceholder: 'Title',
			daysList: [
			  '<h5>Lunes</h5>',
			  '<h5>Martes</h5>',
			  '<h5>Miércoles</h5>',
			  '<h5>Jueves</h5>',
			  '<h5>Viernes</h5>',
			  '<h5>Sábado</h5>',
			  '<h5>Domingo</h5>',
			  '<h5>Feriados</h5>'
			],
			onInit: function () {},
			onAddPeriod: function () {},
			onRemovePeriod: function () {},
			onDuplicatePeriod: function () {},
			onClickPeriod: function () {}
		  });
		  $('#schedule').jqs('export');
	},

	cargar	:	function(arr,tipo){
		arr			=	JSON.parse(arr);
		periodos	=	[];
		gl_tipo		=	"";

		if(tipo == 1){
			gl_tipo	=	"Horario del Local";
		}

		$.each(arr, function(index, per){
			if(per != null){
				_arr	=	[];
				$.each(per, function(i, p){
					_arr.push(
						{
							start				:	p.inicio,
							end					:	p.fin,
							title				:	index + ' ALO',
							tipo				:	gl_tipo,
							// backgroundColor		:	'#000',
							// borderColor			:	'#000',
							// textColor			:	'#fff',
							// color				:	'#fff'
						}
					);
				});

				periodos.push({day:parseInt(index),periods : _arr})
			}
		});

		$('#schedule').jqs('import', periodos);
		// 	{
		// 		day		: 4,
		// 		periods	:	[
		// 			{
		// 				start				:	'10:00',
		// 				end					:	'12:00',
		// 				title				:	'A black period',
		// 				backgroundColor		:	'#000',
		// 				borderColor			:	'#000',
		// 				textColor			:	'#fff',
		// 				color				:	'#fff'
		// 			}
		// 		]
		// 	},
		// 	{
		// 		day		: 4,
		// 		periods	:	[
		// 			{
		// 				start				:	'13:00',
		// 				end					:	'18:00',
		// 				title				:	'A black period 2',
		// 				backgroundColor		:	'#000',
		// 				borderColor			:	'#000',
		// 				textColor			:	'#fff',
		// 				color				:	'#fff'
		// 			}
		// 		]
		// 	},
		// 	{
		// 		day		: 4,
		// 		periods	:	[
		// 			{
		// 				start				:	'18:00',
		// 				end					:	'20:00',
		// 				title				:	'A black period 5',
		// 				backgroundColor		:	'#fff',
		// 				borderColor			:	'#fff',
		// 				textColor			:	'#000',
		// 			}
		// 		]
		// 	}
		// ]);
	}
};


var	colores	=	{
	funcionamiento	:	{
		"backgroundColor"		:	"rgba(82, 155, 255, 0.5)",
		"borderColor"			:	"rgb(42, 60, 255)",
		"textColor"					:	"rgb(0, 0, 0)",
	}
};