

	$(document).ajaxStart(function() {
		$('#cargando').fadeIn();
	}).ajaxStop(function() {
		$('#cargando').fadeOut();

	});

	$.fn.hasAttr = function (name) {
		return this.attr(name) !== undefined;
	};

	var url = window.location.pathname;
	url = url.split("index.php");
	if (url[0] !== undefined) {
		var url_base = url[0];
	} else {
		var url_base = '/';
	}

	var BASE_URI = url_base;
	var HOST = window.location.protocol + "//" + window.location.hostname;

	var tablas;
	
	$(document).ready(function () {
		tablas = new Array();
		var tablas = $("table.dataTable");
		var tabla = $("table.dataTable");
		
		tablas.each(function(index, item){
			tabla = $(item);

			if(tabla.data('row')) {
	            var filas = parseInt(tabla.data("row"));
	        } else {
	            var filas = 10;
			}
			
			if(tabla.data('no-export')) {
	            var buttons = [];
	        } else {
	            var buttons = [
					{
					extend: 'excelHtml5',
					text: 'Exportar a Excel',
					filename: 'Grilla',
					exportOptions: {
						modifier: {
							page: 'all'
						}
					}}];
	        }

			var dataOptions = {
				pageLength	: filas,
				/*sorting	: [],*/
				language	: {
								"url": url_base + "static/js/plugins/DataTables/lang/es.json"
							},
				fnDrawCallback: function (oSettings) {
					$(this).fadeIn("slow");
				},
				dom			: 'Bflrtip',
				buttons: buttons
			}; 

			if(tabla.data('columnas')) {
				var aoColumns = [];
				if(tabla.data('columnas') == 'supervisor'){
					aoColumns = [ 
							{ "sClass": "center" },
							{ "sClass": "center","sType": "eu_date" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center","sType": "eu_date" },
						];
					if(tabla.data('bandeja') && (tabla.data('bandeja') == 'nacional' || tabla.data('bandeja') == 'admin')){
						aoColumns.splice(3, 0, { "sClass": "center" });
					}
				}
				else if(tabla.data('columnas') == 'seremi'){
					aoColumns = [ 
							{ "sClass": "center" },
							{ "sClass": "center","sType": "eu_date" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center" },
							{ "sClass": "center","sType": "eu_date" },
						];
					if(tabla.data('bandeja') && (tabla.data('bandeja') == 'nacional' || tabla.data('bandeja') == 'admin')){
						aoColumns.splice(3, 0, { "sClass": "center" });
					}
				}

				dataOptions.aoColumns = aoColumns;
	        }
	        if(tabla.data('sorting')) {
	        	if(tabla.data('sorting-order')){
	        		var order = tabla.data('sorting-order');
	        	}else{
	        		var order = "desc";
	        	}
	            var sorting = [[ parseInt(tabla.data('sorting')), order ]];
				dataOptions.aaSorting = sorting;
	        }

			tabla.DataTable(dataOptions);
		});
		
		/*$(".datepicker").datepicker({
			dateFormat: 'dd/mm/yy'
		});
	*/

		//called when key is pressed in textbox
		$(".numbers").keypress(function (e) {
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				return false;
			}
		});


		// se inician tablas
		/*$("table.dataTable").livequery(function () {
			;
			if ($(this).parent().hasAttr('data-row')) {
				var filas = parseInt($(this).parent().attr("data-row"));
			} else {
				var filas = 10;
			}

		   var id = $(this).attr("id");
			$(".dataTable.paginada").DataTable({
				"pageLength": filas,
				"aaSorting": [],
				"language": {
					"url": url_base + "static/js/plugins/DataTables-1.10.5/lang/es.json"
				},
				"fnDrawCallback": function (oSettings) {
					$(this).fadeIn("slow");
				},
				"dom": 'Bfrtip',
				"buttons": [
					'excelHtml5'
				]
			});

		});*/

		//$(".rut").mask('000000000-A', {reverse: true});


	});

	$(window).load(function () {
		$("#contenido").fadeIn("slow");
		//$( ".div-contenido-cargando").hide();
	});

	/**
	 * Boquea el boton despues de hacer click
	 * @param {type} boton
	 * @param {type} e
	 * @returns {buttonStartProcess.retorno}
	 */
	function buttonStartProcess(boton, e) {
		e.preventDefault();
		$(boton).prop('disabled', true);

		var clase_boton = $(boton).children("i").attr("class");
		$(boton).children("i").attr("class", "fa fa-refresh fa-spin");

		var retorno = {"boton": boton, "clase": clase_boton};
		
		return retorno;
		alert("SI LLEGA")
	}

	/**
	 * Desbloquea el boton
	 * @param {type} retorno
	 * @returns {undefined}
	 */
	function buttonEndProcess(retorno) {
		$(retorno.boton).prop('disabled', false);
		$(retorno.boton).children("i").attr("class", retorno.clase);
	}

	/**
	 * Procesa errores en llamadas ajax
	 * @returns {undefined}
	 */
	function errorAjax() {
		// procesar error
	}

	/**
	 * Procesa los errores en la validacion de formularios
	 * Ilumina los input con error
	 * @param {type} errores
	 * @returns {undefined}
	 */
	function procesaErrores(errores) {
		$.each(errores, function (i, valor) {
			var parent = getFormParent($("#" + i).parent(), 1);

			if (parent != null) {
				if (valor != "") {
					$(parent).addClass("has-error");
					$(parent).children(".help-block").removeClass("hidden");
					$(parent).children(".help-block").html("<i class=\"fa fa-warning\"></i> " + valor);
				} else {
					$(parent).removeClass("has-error");
					$(parent).children(".help-block").addClass("hidden");
				}
			}
		});
	}

	function limpiaErrores(errores) {
		$.each(errores, function (i) {
			var parent = getFormParent($("#" + i).parent(), 1);

			if (parent != null) {
					$(parent).removeClass("has-error");
					$(parent).children(".help-block").addClass("hidden");
					$(parent).children(".help-block").html("");
			}
		});
	}


	function getFormParent(parent, intento) {
		if (intento > 4) {
			return null;
		} else {
			if ($(parent).hasClass("form-group")) {
				return parent;
			} else {
				return getFormParent($(parent).parent(), intento + 1);
			}
		}
	}

	/**
	 * Oculta un div con el efecto Fade
	 * @param {type} div
	 * @returns {undefined}
	 */
	function ocultarConFade(div) {
		$("#" + div).stop().animate({opacity: 0.05}, 3000, function () {
			$("#" + div).hide();
			$("#" + div).css("opacity", 1);
		});
	}

	function colorbox(url) {


		$().colorbox({
			iframe: true,
			href: url,
			width: "90%",
			height: "90%"
		});
	}

	function colorbox_upload(url) {


		$().colorbox({
			iframe: true,
			href: url,
			width: "50%",
			height: "50%"
		});
	}

    $("[data-toggle='tooltip']").livequery(function(){
        var my		= "bottom center";
        var at		= "top center";
		var texto	= '';

		if($(this).attr("data-title") != "" && $(this).attr("data-title") != "undefined"){
            texto = $(this).attr("data-title");
        }
        $(this).qtip({ 
            position: {
                my: my,
                at: at
            },
			content	: {
						text	: texto
					},
        });
    });

	$(".infoTip").livequery(function(){
		var titulo	= 'Explicación de la Funcionalidad';
		var texto	= '';
        var pos = '';

		if($(this).attr("data-titulo") != "" && $(this).attr("data-titulo") != "undefined"){
            titulo = $(this).attr("data-titulo");
        }
		if($(this).attr("data-texto") != "" && $(this).attr("data-texto") != "undefined"){
            texto = $(this).attr("data-texto");
        }
		
        var auxPos = $(this).attr("data-pos");
        if(auxPos == "pull-right")
        {
            var pos = "top right";
        }
        else
        {
            var pos = "top left";
        }

		$(this).qtip({
			show	: 'click',
			hide	: 'click',
			content	: {
						button	: true,
						title	: titulo,
						text	: texto
					},
          position: {
                     my: pos, 
                     at: 'bottom left'
                },
			events	: {
						render: function(event, api) {
							var elem = api.elements.overlay;
						}
					}
		});
	});

	//datatable con Funcionalidad de Elegir Columnas a Exportar, Titulo del archivo
    $(".datatable.datatableNew").livequery(function(){
        
        if($(this).parent().hasAttr('data-row')) {
            var filas = parseInt($(this).parent().attr("data-row"));
        } else {
            var filas = 10;
        }
        
        var id			= $(this).attr("id");
		var columnas	= ':visible';
		var titulo		= 'Prevencion_de_Femicidios';
        var buttons		= [];

		if($(this).hasAttr('data-exportar')) {
            columnas	= $(this).attr("data-exportar");
        }
		if($(this).hasAttr('data-titulo')) {
            titulo		+= ' - '+$(this).attr("data-titulo");
        }

		buttons	= [
					{
						extend	: 'excelHtml5',
						title	: titulo,
						exportOptions: {
							columns: [columnas]
						}
					},
					{
						extend	: 'pdfHtml5',
						title	: titulo,
						exportOptions: {
							columns: [columnas]
						}
					}
				];

        var tb = $(this).DataTable({
            "lengthMenu"	: [[5,10, 20, 25, 50, 100], [5, 10, 20, 25, 50, 100]],
            "pageLength"	: filas,
            "destroy"		: true,
            "aaSorting"		: [],
            "deferRender"	: true,
            dom				: 'Bfrtip',
            buttons			: buttons,
            language		: {
								"url": url_base + "static/js/plugins/DataTables/lang/es.json"
							 },
            "fnDrawCallback": function( oSettings ) {
                $("#" + id).removeClass("hidden");
             }
        });
    });

    //boton para exportar tabla a excel
    $(".buttons-excel").livequery(function(){
       $(this).html("<i class=\"fa fa-download\"></i> Exportar a EXCEL");
       $(this).removeClass("dt-button");
       $(this).addClass("btn btn-primary btn-xs");
    });
    
    $(".buttons-pdf").livequery(function(){
       $(this).html("<i class=\"fa fa-file-pdf-o\"></i> EXPORTAR a PDF");
       $(this).removeClass("dt-button");
       $(this).addClass("btn btn-success btn-xs");
    });
    
    $(".buttons-print").livequery(function(){
       $(this).html("<i class=\"fa fa-print\"></i> Imprimir");
       $(this).removeClass("dt-button");
       $(this).addClass("btn btn-default btn-xs");
    });
	
	// funcion para que funcione el calendario estilo ASD, 
	// autor : orlando.vazquez@cosof.cl
	
	$(function () {
		$(".datepicker").datetimepicker({
			locale: "es",
			format: "DD/MM/YYYY",
		});
	});
	//funcion para que funcione la seleccion de hora estilo ASD {ahora mismo se ve gigante y no se porque :( }
	//autor : orlando.vazquez@cosof.cl
	 $(function () {
                $(".timepicker").datetimepicker({
                    format: "LT"
                });
            });



	$("#btnVolverUsuario").livequery(function(){
		btn	= this;
        $(btn).click(function(e){
			btn.disabled = true;
			var btnTexto = $(btn).html();
			$(btn).html('Cambiando...');

			$.ajax({
				dataType	: "json",
				cache		: false,
				async		: true,
				type		: "post",
				url			: BASE_URI + "index.php/Mantenedor/volver_usuario", 
				error		: function(xhr, textStatus, errorThrown){
								xModal.info('Error al cambiar de usuario.');
				},
				success		: function(data){
								if(data.correcto){
									xModal.success('Se procederá con el Cambio de Usuario');
									setTimeout(function () {
										location.href = BASE_URI;
									}, 2000);
								}else{
									xModal.info(data.mensaje);
								}
				}
			});

			$(btn).html(btnTexto).attr('disabled', false);
        });
    });

function ocultaMuestraVista(id){
    if($("#"+id).is(':hidden')){        
        $("#"+id).fadeIn();
        $("#i-"+id).removeClass('glyphicon glyphicon-chevron-up').addClass('glyphicon glyphicon-chevron-down');
    }else{
        $("#"+id).fadeOut();
        $("#i-"+id).removeClass('glyphicon glyphicon-chevron-down').addClass('glyphicon glyphicon-chevron-up');
    }
}

var base_animal ={
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

	cargarVacunasPorLaboratorio: function(laboratorio,combo,medicamento){
		if(laboratorio != 0){
			$.post(BASE_URI+'index.php/Regularizar/cargarMedicamentosporLaboratorio',{laboratorio:laboratorio},function(response){
				if(response.length > 0){
					var total = response.length;
					var options = '<option value="0">Seleccione nombre</option>';
					for(var i=0; i<total; i++){
						if(medicamento == response[i].id_vacuna){
							options += '<option value="'+response[i].id_vacuna+'" selected >'+response[i].gl_nombre_vacuna+'</option>';	
						}else{
							options += '<option value="'+response[i].id_vacuna+'" >'+response[i].gl_nombre_vacuna+'</option>';
						}
						
					}
					$('#'+combo).html(options);
				}else{
                    $('#'+combo).html('<option value="0">Seleccione nombre</option>');
                }
			},'json');
		}else{
            $('#'+combo).html('<option value="0">Seleccione nombre</option>');
		}
	},
}