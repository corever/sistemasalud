
var Reportes = {
    init : function(){
		Reportes.buscar();
	},
    
    buscar : function(){
        var id_region           = $("#id_region").val();
		var id_oficina          = $("#id_oficina").val();
		var id_comuna           = $("#id_comuna").val();
		var id_establecimiento  = $("#id_establecimiento").val();
		var id_estado           = $("#id_estado").val();
		var id_resultado_visita = $("#id_resultado_visita").val();
		var fc_inicio           = $("#fc_inicio").val();
		var fc_termino          = $("#fc_termino").val();
		var bo_domicilio_conocido = $("#bo_domicilio_conocido").val();


		var data = {
					id_region:id_region,
					id_oficina:id_oficina,
					id_comuna:id_comuna,
					fc_inicio:fc_inicio,
					fc_termino:fc_termino,
					id_establecimiento:id_establecimiento,
					id_estado:id_estado,
					id_resultado_visita:id_resultado_visita,
                    bo_domicilio_conocido:bo_domicilio_conocido
				};

		$.ajax({
            url : BASE_URI+"index.php/Reportes/muestraInformes",
            dataType : 'html',
            type : 'post',
            data : data,
            success : function(response){
                $("#contenedor-tabla-informe").html(response);
            }
        });
        $.ajax({
            url : BASE_URI+"index.php/Reportes/reporteVisitas",
            dataType : 'html',
            type : 'post',
            data : data,
            success : function(response){
                $("#contenedor-tabla-visitas").html(response);
                var dataOptions = {
                  pageLength  : 10,
                  language  : {
                          "url": url_base + "static/js/plugins/DataTables/lang/es.json"
                        },
                  fnDrawCallback: function (oSettings) {
                    $(this).fadeIn("slow");
                  },
                  dom     : 'Bflrtip',
                  buttons: [
                    {
                      extend: 'excelHtml5',
                      text: 'Exportar a Excel',
                      filename: 'Grilla',
                      exportOptions: {
                        modifier: {
                          page: 'all'
                        }
                      }
                    }
                  ]
                }; 
                $("#tablaVisitas").DataTable(dataOptions);
            }
        });
        $.ajax({
            url : BASE_URI+"index.php/Reportes/reporteVisitasOficinas",
            dataType : 'html',
            type : 'post',
            data : {id_region:id_region,id_oficina:id_oficina,id_comuna:id_comuna,fc_inicio:fc_inicio,fc_termino:fc_termino,
                    id_establecimiento:id_establecimiento,id_estado:id_estado,id_resultado_visita:id_resultado_visita,bo_domicilio_conocido:bo_domicilio_conocido},
            success : function(response){
                $("#contenedor-tabla-visitas-oficinas").html(response);
                var dataOptions = {
                  pageLength  : 10,
                  language  : {
                          "url": url_base + "static/js/plugins/DataTables/lang/es.json"
                        },
                  fnDrawCallback: function (oSettings) {
                    $(this).fadeIn("slow");
                  },
                  dom     : 'Bflrtip',
                  buttons: [
                    {
                      extend: 'excelHtml5',
                      text: 'Exportar a Excel',
                      filename: 'Grilla',
                      exportOptions: {
                        modifier: {
                          page: 'all'
                        }
                      }
                    }
                  ]
                }; 
                $("#tablaVisitasOficinas").DataTable(dataOptions);
                /*var total_columnas = $("#tablaVisitasOficinas").DataTable().columns(':visible').count();
                if(total_columnas == 8){
                  $("#tablaVisitasOficinas").dataTable().fnFakeRowspan(0)
                                                  .fnFakeRowspan(1)
                                                  .fnFakeRowspan(2)
                                                  .fnFakeRowspan(3)
                                                  .fnFakeRowspan(4)
                                                  .fnFakeRowspan(5);
                }else{
                  $("#tablaVisitasOficinas").dataTable().fnFakeRowspan(0)
                                                  .fnFakeRowspan(1)
                                                  .fnFakeRowspan(2)
                                                  .fnFakeRowspan(3)
                                                  .fnFakeRowspan(4);  
                }*/
            }
        });
		$.ajax({
            url : BASE_URI+"index.php/Reportes/establecimientosNotifican",
            dataType : 'html',
            type : 'post',
            data : data,
            success : function(response){
                $("#contenedor-tabla-establecimientos-notifican").html(response);
                var dataOptions = {
                  pageLength  : 10,
                  language  : {
                          "url": url_base + "static/js/plugins/DataTables/lang/es.json"
                        },
                  fnDrawCallback: function (oSettings) {
                    $(this).fadeIn("slow");
                  },
                  dom     : 'Bflrtip',
                  buttons: [
                    {
                      extend: 'excelHtml5',
                      text: 'Exportar a Excel',
                      filename: 'Grilla',
                      exportOptions: {
                        modifier: {
                          page: 'all'
                        }
                      }
                    }
                  ]
                }; 
                $("#tablaEstablecimientosNotifican").DataTable(dataOptions);
            }
        });
	},
    
    quitarFiltros : function(){
        var fecha = new Date();
        var año = fecha.getFullYear();
        var mes = fecha.getMonth()+1;
        var dia = fecha.getDate();
		$("#id_region option:eq(0)").prop('selected', true);
		$("#id_oficina option:eq(0)").prop('selected', true);
        $('#id_comuna').html('<option value=""> Todas </option>');
		$("#id_establecimiento").html('<option value=""> Todas </option>');
        $("#id_estado option:eq(0)").prop('selected', true);
        $("#id_resultado_visita option:eq(0)").prop('selected', true);
        
        var output = (dia<10 ? '0' : '') + dia + '/' + (mes<10 ? '0' : '') + mes + '/' + año;
        
        $("#fc_inicio").val('01/01/'+año);
        $("#fc_termino").val(output);
        
        $("#btnBuscar").trigger("click");
	},
};

$(document).ready(function() {
    setTimeout(function() {Reportes.init();}, 2000);
});

$("#fc_inicio").datepicker({
    locale: "es",
    format: "DD/MM/YYYY",
    maxDate: "now",
    useCurrent: false,
    inline: false
});

$("#fc_termino").datepicker({
    locale: "es",
    format: "DD/MM/YYYY",
    maxDate: "now",
    useCurrent: false,
    inline: false
});

$(".select2").select2({
	language: "es",
	tags: false
});