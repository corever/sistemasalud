$(document).ready(function() {
    $("#establecimiento_salud").select2({ width: '100%' });

    $( "#buscar" ).on( "click", function() {
        var id_perfil   = $("#id_perfil").val();
        var parametros  = $("#form").serializeArray();
        var arr         = new Array();
        $.each(parametros, function( index, value ) {
            arr[value.name] = value.value;
        });
        
        var dColumns =  [
                            { "data": "folio",              "class": "text-center"},
                            { "data": "fc_ingreso",         "class": "text-center"},
                            { "data": "establecimiento",    "class": "text-center"},
                            { "data": "gl_region_mordedor", "class": "text-center"},
                            { "data": "gl_comuna_mordedor", "class": "text-center"},
                            { "data": "sin_dir",            "class": "text-center"},
                            { "data": "fc_mordedura",       "class": "text-center"},
                            { "data": "dias_mordedura",     "class": "text-center"},
                            { "data": "dias_bandeja",       "class": "text-center"},
                            { "data": "fiscalizador",       "class": "text-center"},
                            { "data": "estado",             "class": "text-center"},
                            { "data": "resultado_obs",      "class": "text-center"},
                            { "data": "resultado_lab",      "class": "text-center"},
                            { "data": "grupo_mordedor",     "class": "text-center"},
                            { "data": "bo_paciente_observa","class": "text-center"},
                            { "data": "opciones",           "class": "text-center"}
                        ];
                
        if(id_perfil == 15 || id_perfil == 13){ //PERFIL SERVICIO SALUD
            delete dColumns.splice(3,1); //REGION MORDEDOR
            delete dColumns.splice(7,1); //DIAS BANDEJA
            delete dColumns.splice(7,1); //FISCALIZADOR
            dColumns[3].data    = "gl_comuna_est";
        }

        $("#grilla-buscar").dataTable({
            "lengthMenu": [5,10, 20, 25, 50, 100],
            "pageLength": 10,
            "language"  : {"url": url_base + "static/js/plugins/DataTables/lang/es.json"},
            "destroy" : true,
            "aaSorting": [],
            "deferRender": true,
            dom: 'Bflrtip',
            buttons: [{
                        extend: 'excelHtml5',
                        text: 'Exportar a Excel',
                        filename: 'Grilla',
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            }
                        }
            }],
            ajax: {
                "method": "POST",
                "url": BASE_URI + 'index.php/Buscar/recargarGrillaBuscar',
                "data" : arr,
                error: function (xhr, error, code){
                    //console.log("El rango de fechas ingresado tiene demasiadas Notificaciones, favor Modificar o Solicitar a Soporte");
                    xModal.info("El rango de fechas ingresado tiene demasiadas Notificaciones, favor Modificar o Solicitar a Soporte");
                }
            },
            columns: dColumns
        });

        /*$.ajax({
            url : BASE_URI + 'index.php/Buscar/recargarGrillaBuscar',
            data : formulario,
            type : 'post',
            dataType : 'json',
            success : function(response){
                console.log(response);
                if(response.correcto == true){
                    $("#contenedor-grilla-pacientes").html(response.grilla);
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
                    $("#tablaPrincipal").DataTable(dataOptions);
                }
                else{
                    xModal.danger("ERROR: Intente nuevamente",function(){
                    });
                }
            },
            error : function(){
                    xModal.danger('Error: Intente nuevamente',function(){
                    });
            }
        });*/
    });
});
/*
$("#region").on('change', function (e) {
	if ($('#bool_region').val() == 1) {
		$("#region option[value="+$('#reg').val()+"]").prop('selected',true);
	}
  obtenerEstablecimientos();
});
*/
$(".select2").select2({
	language: "es",
	tags: false,
});


$("#fecha_desde").datepicker({
    locale: "es",
    format: "DD/MM/YYYY",
    maxDate: "now",
    useCurrent: false,
    inline: false
});

$("#fecha_hasta").datepicker({
    locale: "es",
    format: "DD/MM/YYYY",
    maxDate: "now",
    useCurrent: false,
    inline: false
});

function verAlarma(boton){
  var parametros =[
                  {"name": 'alarma',"value": $(boton).data("alarma")},
                  {"name": 'estado',"value": $(boton).data("estado")},
                ];
  $.ajax({
    dataType: "json",
    cache: false,
    async: true,
    data: parametros,
    type: "post",
    url : BASE_URI + 'index.php/Home/cambiarEstadoAlarma',
    error: function (xhr, textStatus, errorThrown) {
      xModal.danger('Error: No se pudo actualizar el estado de la Alarma');
    },
    success: function (data) {
      if (data.correcto) {
          xModal.success('Éxito: '+data.mensaje);
          setTimeout(function () {
              location.reload();
          }, 2000);
      } else {
        xModal.danger('Error: '+ data.mensaje);
      }
    }
  });
};

function obtenerEstablecimientos(){
  var parametros =[{"name": 'region',"value": $("#region").val()}];
  $.ajax({
    dataType: "json",
    cache: false,
    async: true,
    data: parametros,
    type: "post",
    url : BASE_URI + 'index.php/Buscar/listarEstablecimientos',
    success: function (data) {
      $('.select2').html('');
      data.forEach(function (element){
        var option = new Option(element.text, element.id);
        $(".select2").append(option);
      });
      $(".select2").select2({ width: '100%' });
    }
  });
}