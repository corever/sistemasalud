
var Reportes = {
    init : function(){
		Reportes.buscar();
	},
    
    buscar : function(){
        var id_region               = $("#id_region").val();
		var id_oficina              = $("#id_oficina").val();
		var id_comuna               = $("#id_comuna").val();
		var id_establecimiento      = $("#id_establecimiento").val();
		var id_servicio             = $("#id_servicio").val();
		var id_estado               = $("#id_estado").val();
		var id_resultado_visita     = $("#id_resultado_visita").val();
		var fc_inicio               = $("#fc_inicio").val();
		var fc_termino              = $("#fc_termino").val();
		var bo_domicilio_conocido   = $("#bo_domicilio_conocido").val();
		$.ajax({
            url : BASE_URI+"index.php/Reportes/graficar",
            dataType : 'json',
            type : 'post',
            data : {id_region:id_region,id_oficina:id_oficina,id_comuna:id_comuna,fc_inicio:fc_inicio,fc_termino:fc_termino,id_servicio:id_servicio,
                    id_establecimiento:id_establecimiento,id_estado:id_estado,id_resultado_visita:id_resultado_visita,bo_domicilio_conocido:bo_domicilio_conocido},
            success : function(response){
                Reportes.graficarVisitasMordedores(response.arrVisitasMordedores);
                Reportes.graficarDomicilios(response.arrDomicilios);
                Reportes.graficarNotificacionEstablecimientos(response.arrVisitasMordedores);
                Reportes.grillaEstablecimientos(response.grillaEstablecimientos);
            }
        });
	},
    
    quitarFiltros : function(){
        var fecha = new Date();
        var año = fecha.getFullYear();
        var mes = fecha.getMonth()+1;
        var dia = fecha.getDate();
		$("#id_region option:eq(0)").prop('selected', true);
		$("#id_servicio option:eq(0)").prop('selected', true);
		$("#id_oficina option:eq(0)").prop('selected', true);
        $('#id_comuna').html('<option value=""> Todas </option>');
		$("#id_establecimiento").html('<option value=""> Todas </option>').trigger("change");
        $("#id_estado option:eq(0)").prop('selected', true);
        $("#id_resultado_visita option:eq(0)").prop('selected', true);
        
        var output = (dia<10 ? '0' : '') + dia + '/' + (mes<10 ? '0' : '') + mes + '/' + año;
        
        $("#fc_inicio").val('01/01/'+año);
        $("#fc_termino").val(output);
        
        $("#btnBuscar").trigger("click");
	},

    graficarVisitasMordedores: function(data){
        var datos = [];
        var color = {"Se Niega a Visita":"#3c8dbc","Visita Perdida":"#f39c12","No Sospechoso":"#00a65a","Sospechoso":"#dd4b39","No Realizadas":"#ADD8E6"};
        $.each(data, function(i, value){
          var item = {'estado' : i, 'total' : parseInt(value), 'color': color[i]};
          datos.push(item);
        });
        var chart = AmCharts.makeChart("grafico_visitas_mordedores", {
            "type": "pie",
            "startDuration": 0,
            "labelRadius": -35,
            "labelText": "[[percents]]%",
            color: "#FFF",
            fontSize: 14,
            labelsEnabled: true,
            autoMargins: false,
            marginTop: 10,
            marginBottom: 10,
            marginLeft: 10,
            marginRight: 10,
            pullOutRadius: 10,
            "theme": "light",
            "legend": {
                "position": "right",
                "marginRight": 100,
                "autoMargins": false
            },
            "dataProvider": datos,
            "colorField": "color",
            "valueField": "total",
            "titleField": "estado",
            "balloon": {
                "fixedPosition": true
            },
            "export": {
                "enabled": true
            }
        });
    },

    graficarDomicilios: function(data){        
        var datos = [];
        var color = {"Conocido":"#00a65a","No Conocido":"#f39c12"};
        $.each(data, function(i, value){
          var item = {'estado' : i, 'total' : parseInt(value), 'color': color[i]};
          datos.push(item);
        });
        var chart = AmCharts.makeChart("grafico_domicilios", {
            "type": "pie",
            "startDuration": 0,
            "labelRadius": -35,
            "labelText": "[[percents]]%",
            color: "#FFF",
            fontSize: 14,
            labelsEnabled: true,
            autoMargins: false,
            marginTop: 10,
            marginBottom: 10,
            marginLeft: 10,
            marginRight: 10,
            pullOutRadius: 10,
            "theme": "light",
            "legend": {
                "position": "right",
                "marginRight": 100,
                "autoMargins": false
            },
            "dataProvider": datos,
            "colorField": "color",
            "valueField": "total",
            "titleField": "estado",
            "balloon": {
                "fixedPosition": true
            },
            "export": {
                "enabled": true
            }
        });
    },

    graficarNotificacionEstablecimientos: function(data){
        var datos = [];
        var color = {"Se Niega a Visita":"#3c8dbc","Visita Perdida":"#f39c12","No Sospechoso":"#00a65a","Sospechoso":"#dd4b39","No Realizadas":"#ADD8E6"};
        $.each(data, function(i, value){
          var item = {'estado' : i, 'total' : parseInt(value), 'color': color[i]};
          datos.push(item);
        });
        var chart = AmCharts.makeChart("grafico_notificacion_establecimiento", {
            "type": "pie",
            "startDuration": 0,
            "labelRadius": -35,
            "labelText": "[[percents]]%",
            color: "#FFF",
            fontSize: 14,
            labelsEnabled: true,
            autoMargins: false,
            marginTop: 10,
            marginBottom: 10,
            marginLeft: 10,
            marginRight: 10,
            pullOutRadius: 10,
            "theme": "light",
            "legend": {
                "position": "right",
                "marginRight": 100,
                "autoMargins": false
            },
            "dataProvider": datos,
            "colorField": "color",
            "valueField": "total",
            "titleField": "estado",
            "balloon": {
                "fixedPosition": true
            },
            "export": {
                "enabled": true
            }
        });
    },

    grillaEstablecimientos: function(grilla){
        $("#contenedor-tabla-establecimientos").html(grilla);
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
        $("#tablaEstablecimientos").DataTable(dataOptions);
    },

};

$(document).ready(function() {
    setTimeout(function(){;Reportes.init();}, 2000);
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

