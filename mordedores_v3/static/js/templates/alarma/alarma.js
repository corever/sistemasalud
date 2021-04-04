function cambiarEstadoAlarma(id_alarma){
  if(!id_alarma){
    var id_alarma = $("#id_alarma").val();
  }
  var fechacontacto = $("#fechacontacto").val();
  var horacontacto = $("#horacontacto").val();
  var chkcontacto = $("#chkcontacto").is(':checked');
  var observaciones = $("#gl_observaciones_alarma").val();

  var msg_error = "";
  if(chkcontacto == true){
    if(fechacontacto == ""){
      msg_error += "Debe ingresar la fecha de contacto con el paciente. </br>"
    }
    if(horacontacto == ""){
      msg_error += "Debe ingresar la hora de contacto con el paciente. </br>"
    }
  }
  if(observaciones == ""){
      msg_error += "Debe ingresar observaciones. </br>"
    }

  if(msg_error != ""){
    xModal.danger(msg_error);
  }else{
    var parametros =[
                    {"name": 'alarma',"value": id_alarma},
                    {"name": 'estado',"value": 4},
                    {"name": 'fechacontacto',"value": fechacontacto},
                    {"name": 'horacontacto',"value": horacontacto},
                    {"name": 'chkcontacto',"value": (chkcontacto)?1:0},
                    {"name": 'gl_observaciones_alarma',"value": observaciones},
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
  }
};

$("#fechacontacto").datepicker({
    locale: "es",
    format: "DD/MM/YYYY",
    maxDate: "now",
    useCurrent: false,
    inline: false,
    beforeShow: function() {
        //Para que aparezca en Modal
        setTimeout(function(){
            $('.ui-datepicker').css('z-index', 99999999999999);
        }, 0);
    }
});
$("#horacontacto").timepicker({});

function toogleFechaHoraContacto(){
    $(".fechahoracontacto").toggle();
}