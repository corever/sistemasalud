var cargar_mapa = true;

var Home = {


    graficoEstadosNacional : function(data,titulo){

        if(titulo !== undefined){
          $("#titulo_registros_estados").html(titulo);
        }
        
        var datos = [];
        $.each(data, function(i, value){
          var item = {'estado' : value.nombre, 'total' : parseInt(value.total)};
          datos.push(item);
        });
        var chart = AmCharts.makeChart("grafico_estados_general", {
            "type": "pie",
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
                "position": "bottom",
                "marginRight": 100,
                "autoMargins": false
            },
            "dataProvider": datos,
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


    graficoFechasRegistros : function(data, titulo){
      if(titulo !== undefined){
        $("#titulo_fechas_registros").html(titulo);
      }

      var datos = [];
      $.each(data, function(i, item){
        var fecha = {'date': item.fecha, 'value': parseInt(item.total)};
        datos.push(fecha);
      });
      
      var chart = AmCharts.makeChart("grafico_fechas_registros", {
          "type": "serial",
          "theme": "light",
          /*"language" : "es",*/
          "marginRight": 40,
          "marginLeft": 40,
          "autoMarginOffset": 20,
          "mouseWheelZoomEnabled":true,
          "dataDateFormat": "DD-MM-YYYY",
          "valueAxes": [{
              "id": "v1",
              "axisAlpha": 0,
              "position": "left",
              "ignoreAxisWidth":true,
              "integersOnly" : true
          }],
          "balloon": {
              "borderThickness": 1,
              "shadowAlpha": 0
          },
          "graphs": [{
              "id": "g1",
              "balloon":{
                "drop":true,
                "adjustBorderColor":false,
                "color":"#ffffff"
              },
              "bullet": "round",
              "bulletBorderAlpha": 1,
              "bulletColor": "#FFFFFF",
              "bulletSize": 5,
              "hideBulletsCount": 50,
              "lineThickness": 2,
              "title": "red line",
              "useLineColorForBulletBorder": true,
              "valueField": "value",
              "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
          }],
          "chartScrollbar": {
              "graph": "g1",
              "oppositeAxis":false,
              "offset":30,
              "scrollbarHeight": 80,
              "backgroundAlpha": 0,
              "selectedBackgroundAlpha": 0.1,
              "selectedBackgroundColor": "#888888",
              "graphFillAlpha": 0,
              "graphLineAlpha": 0.5,
              "selectedGraphFillAlpha": 0,
              "selectedGraphLineAlpha": 1,
              "autoGridCount":true,
              "color":"#AAAAAA"
          },
          "chartCursor": {
              "pan": true,
              "valueLineEnabled": true,
              "valueLineBalloonEnabled": true,
              "cursorAlpha":1,
              "cursorColor":"#258cbb",
              "limitToGraph":"g1",
              "valueLineAlpha":0.2,
              "valueZoomable":true
          },
          "valueScrollbar":{
            "oppositeAxis":false,
            "offset":50,
            "scrollbarHeight":10
          },
          "categoryField": "date",
          "categoryAxis": {
              "parseDates": true,
              "dashLength": 1,
              "minorGridEnabled": true
          },
          "export": {
              "enabled": true
          },
          "dataProvider": datos
      });

      chart.addListener("rendered", zoomChart);

      zoomChart();

      function zoomChart() {
          chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
      }
    },

    initMapaGestor : function(){
        var parametros = $("#form").serializeArray();
        if(cargar_mapa){
          var mapa = new MapaFormulario('mapa_gestor');

          mapa.seteaLatitud($("#latitud").val());
          mapa.seteaLongitud($("#longitud").val());
          mapa.seteaZoom(4);
          mapa.inicio();
          mapa.cargaMapa();  
          cargar_mapa = false;

          $.ajax({
			data : parametros,
            url : BASE_URI + 'index.php/Home/pacientesMapaDashboard',
            type : 'post',
            dataType : 'json',
            success : function(response){
             // console.log($response);
              /*
              if(response.pacientes){
                var total = response.pacientes.length;
                var icono = ''
                for(var i = 0; i < total; i++){
                  var posicion = new google.maps.LatLng( parseFloat(response.pacientes[i].latitud), parseFloat(response.pacientes[i].longitud)) ;

                  var paciente = new google.maps.Marker({
                      id : 'paciente_' + response.pacientes[i].id,
                      position: posicion,
                      map: mapa.getMapa(),
                      icon: BASE_URI + 'static/images/markers/mordedor.png'
                  });
                  var id_paciente = response.pacientes[i].id;
                  google.maps.event.addListener(paciente, 'click', function (){
                      xModal.open(BASE_URI + 'index.php/Bitacora/ver/' + id_paciente, 'Registro número : ' + id_paciente, 85);
                  });


                }  
              }
              */
            }
          });
          
        } 
    },

    initAlarmas : function(datos){
        $("#barra-reconoce-violencia").animate(
            {'width':datos.reconoce_violencia+'%'}
            ,500);

        $("#barra-pap-alterado").animate(
            {'width':datos.pap_alterado+'%'}
            ,500);
    },

    graficoVisitasMordedores : function(data,titulo){
        if(titulo !== undefined){
          $("#titulo_registros_estados").html(titulo);
        }
        
        var datos = [];
        var color = {"Se Niega a Visita":"#3c8dbc","Visita Perdida":"#f39c12","No Sospechoso":"#00a65a","Sospechoso":"#dd4b39"};
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

    graficoDomicilios : function(data,titulo){
        if(titulo !== undefined){
          $("#titulo_registros_estados").html(titulo);
        }
        
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
    }

}