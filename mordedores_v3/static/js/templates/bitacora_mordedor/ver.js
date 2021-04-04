/* global BASE_URI */

var Bitacora = {
    
    guardarNuevoAdjunto: function (form,btn) {
        var error = false;
        var msg_error = '';        
        
        var tkexp = form.token_expediente.value;
        //alert(idpac);
        var tipodoc = form.tipoAdj.value;
        //alert(tipodoc);
        var path = form.archivo.value;
        //alert(path);
        var comentario = form.comentario_adjunto.value;
        //alert(comentario);
        /* descripción tipo doc */
        var tipotxt = tipoAdj.options[tipoAdj.selectedIndex].text;
        /* nombre de tipo de documento a mayusculas*/
        tipotxt = tipotxt.toUpperCase();
        
        if (tipodoc == 0) {
            msg_error += 'Seleccione Tipo de documento<br/>';
            error = true;
        }
        
        if (path == "") {
            msg_error += 'Seleccione Archivo<br/>';
            error = true;
        }
        
        if (error) {
            xModal.danger(msg_error,function(){
            });
        } else {
            extensiones_permitidas = new Array('.jpeg', '.jpg', '.png', '.gif', 
                                               '.tiff', '.bmp', '.pdf', '.txt', 
                                               '.csv', '.doc', '.docx', '.ppt', 
                                               '.pptx', '.xls', '.xlsx');
            permitida   = false;
            string      = path;
            extension   = (string.substring(string.lastIndexOf("."))).toLowerCase();

            for(var i = 0; i < extensiones_permitidas.length; i++) {
                if (extensiones_permitidas[i] == extension){
                    permitida = true;
                    break;
                }
            }

            if (!permitida) {
                msg_error += 'El Tipo de archivo que intenta subir no está permitido.<br><br>'
                msg_error += 'Favor elija un archivo con las siguientes extensiones: <br>'
                msg_error += extensiones_permitidas.join(' ')+'<br/>';
                xModal.warning(msg_error);
            } else {
                //$(form).submit();
                
                var formulario = new FormData();
                formulario.append('tkexp', tkexp);
                formulario.append('tipodoc',tipodoc);
                formulario.append('tipotxt',tipotxt);
                formulario.append('comentario',comentario);
                
                var inputFileImage = document.getElementById("archivo");
                var file = inputFileImage.files[0];
                formulario.append('archivo',file);
                //alert(BASE_URI + 'index.php/Bitacora/guardarNuevoAdjunto');
                //console.log(formulario);                
                $.ajax({
                    url : BASE_URI + 'index.php/Bitacora/guardarNuevoAdjunto', 
                    data : formulario,
                    processData : false,
                    cache : false,
                    async : true,
                    type : 'post',
                    dataType : 'json',
                    contentType : false,
                    success : function(response){
                        if(response.correcto == true){
                            xModal.success("OK: El archivo fue guardado", function(){
                                $("#grilla-adjuntos").html(response.grilla);
                                habilitarAdjunto();
                            });
                        }
                        else{
                            xModal.danger("ERROR: El archivo NO fue guardado",function(){
                            });
                        }
                    }
                    , 
                    error : function(){
                            xModal.danger('Error: Intente nuevamente',function(){
                            });
                    }
                });
            }
        }
    }
}