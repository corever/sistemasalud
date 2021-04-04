$(document).ready(function() { 
    $("#establecimiento_salud").select2({ width: '100%' });  

    $( "#exportar" ).on( "click", function() {
        var formulario = $("#form").serializeArray();
        $.ajax({
            url : BASE_URI + 'index.php/Reportes/exportarexcelAction', 
            data : formulario,
            type : 'post',
            dataType : 'json',
            success : function(response){
                if(response.correcto){
	                var blob = new Blob(["\ufeff",response.excel], { encoding:'UTF-8',type: 'application/vnd.ms-excel;chartset=utf-8' });
	                var link = document.createElement('a');
	                link.href = window.URL.createObjectURL(blob);
	                link.download = response.nombre;
	                link.click();
	            }else{
	                xModal.danger('Error: No se ha podido generar el Excel.');
	            }
            }, 
            error : function(xhr, textStatus, errorThrown){
					console.log(xhr);
					console.log(textStatus);
					console.log(errorThrown);
                    xModal.danger('Error: Ha ocurrido un error. Intente nuevamente o contacte con Soporte.');
            }
        });
    });
});

$("#region").on('change', function (e) {
	if ($('#bool_region').val() == 1) {
		$("#region option[value="+$('#reg').val()+"]").prop('selected',true);
	}
  obtenerEstablecimientos();
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