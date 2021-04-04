

$(document).ready(function() {
    $("#applet-ejecutar-firma").livequery(function(){
        $(this).on('click', function(e) {
            var button_process = buttonStartProcess($(this), e);

            if ($('#mySelect').val() != "1") {
                Modal.danger('Debe seleccionar un certificado para poder firmar');
                buttonEndProcess(button_process);
                return false; 
            } 

            var parametros = {
                "id_expediente" : $("#firma_expediente").val(),
                "id_expediente_detalle" : $("#firma_expediente_detalle").val(),
                "texto" : ""
            };
            
            if( $('#texto_propuesta').length ){
                parametros.texto = tinyMCE.get('texto_propuesta').getContent();
            }

            /* if(validador == "prepara_amonestacion"){
                if( $('#texto_propuesta').length ){
                    var texto_resolucion = tinyMCE.get('texto_propuesta').getContent();
                }else{
                    var texto_resolucion = $("#contenido_vista_previa_amonestacion").html();
                }
                
                var parametros = {
                    "id_expediente" : $("#firma_expediente").val(),
                    "id_expediente_detalle" : $("#firma_expediente_detalle").val(),
                    "texto" : texto_resolucion
                };


                //parametros.texto = $("contenido_vista_previa_amonestacion").html();
            } */


            $.ajax({
                dataType: "json",
                cache:false,
                async: false,
                data: parametros,
                type: "post",
                url: Base.getBaseUri() + "index.php/BandejaTrabajo/Firmador/validarDocumento", 
                error: function(xhr, textStatus, errorThrown){
                    //errorAjax();
                    buttonEndProcess(button_process);
                },
                success:function(data){
                    
                    var retorno;
                    var correcto = true;
                    var mensaje = "";
                    var firmando = false;
                    var total_firmados = 0;
                    
                    if(data.correcto){

                        var total = data.responsables.length;
                        var responsables = data.responsables;
                        for(var i = 0; i < total; i++){
                            var repo = 0;
                            if(data.repo){
                                repo = 1;
                            }

                            function checkVariable(resp) {
                                setTimeout(function(){
                                    console.log("Tiempo espera 1 seg");
                                    console.log("Firma para " + resp);
                                    retorno = firmar($("#firma_expediente").val() + "/" + resp + "/" + $("#firma_usuario").val() + "/" + data.codigo + "/" + repo, button_process);
                                    total_firmados++;
                                },1000, resp);
                                /*if(firmando){
                                    console.log("Tiempo espera 1 seg");
                                    setTimeout(checkVariable,1000);
                                }else{
                                    console.log("Tiempo espera 1 seg");
                                    console.log("Firma para " + resp);
                                    retorno = firmar($("#firma_expediente").val() + "/" + resp + "/" + $("#firma_usuario").val() + "/" + data.codigo + "/" + repo, button_process);
                                    total_firmados++;
                                }*/
                            }
                            checkVariable(responsables[i]);
                            //setTimeout(checkVariable,1000);

                            /*$.ajax({
                                url : BASE_URI + 'index.php/Expedientes/subExpedienteFirmado',
                                data : {id_detalle_expediente :  responsables[i]},
                                type : 'post',
                                dataType : 'json',
                                async : false,
                                cache : false,
                                success : function(response){
                                    if(response.estado == false){
                                        console.log("Firma para " + responsables[i]);
                                        retorno = firmar($("#firma_expediente").val() + "/" + responsables[i] + "/" + $("#firma_usuario").val() + "/" + data.codigo + "/" + repo, button_process);
                                        
                                    }
                                }
                            })*/

                            /*console.log("Firma para " + responsables[i]);
                            retorno = firmar($("#firma_expediente").val() + "/" + responsables[i] + "/" + $("#firma_usuario").val() + "/" + data.codigo + "/" + repo, button_process);*/// callApplet(data.codigo, value);
                        }

                    } else {
                         Modal.danger( data.mensaje, function(){
                             buttonEndProcess(button_process);
                         } );
                    }

                }
            });
        });
    });
});

function firmar(parametros, btn){
    
    parent.signFEAExtension(parametros,btn);
    return esperarFirma();
    

    
}


/*evento que captura cuando termina de firmar el documento */

/*document.addEventListener("respSignFeaExtension",function(e){	
	endSignatureProcess(e);
},true);*/


function esperarFirma(){
    
}

function sleep(delay) {
    /*var start = new Date().getTime();
    while (new Date().getTime() < start + delay);*/
}


/************ MÉTODOS EN COMÚN ************/

/* obtiene el resultado final de la firma */
/*function endSignatureProcess(data){
    console.log("Recibiendo mensaje");
    console.log(data);
    firmando = false;
    resultado_firma = data;
}*/