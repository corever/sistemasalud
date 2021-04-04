$(document).ready(function() { 
    $("#establecimiento_salud").select2({ width: '100%' });  

    $( "#buscar" ).on( "click", function() {
        var formulario = $("#form").serializeArray();
        $.ajax({
            url : BASE_URI + 'index.php/Historico/recargarGrillaHistorico', 
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
            }
            , 
            error : function(){
                    xModal.danger('Error: Intente nuevamente',function(){
                    });
            }
        });
    });
});

$("#region").on('change', function (e) {
	if ($('#bool_region').val() == 1) {
		$("#region option[value="+$('#reg').val()+"]").prop('selected',true);
	}
  //obtenerEstablecimientos();
});

$(".select2").select2({
	language: "es",
	tags: false,
	placeholder: "Seleccione un Centro de Salud"

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
    url : BASE_URI + 'index.php/Paciente/cambiarEstadoAlarma',
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