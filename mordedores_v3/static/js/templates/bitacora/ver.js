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
                        }else{
                            xModal.danger(response.mensaje,function(){
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
    },

    guardarNuevoComentario: function (form,btn) {
        var tkexp           = form.token_expediente.value;
        var comentario      = form.comentario.value;
        var tipoComent      = form.tipoComent.value;
        var otroTipoComent  = form.otroTipoComent.value;
        
        if(tipoComent == 0){
            xModal.danger("Debe Seleccionar el tipo de comentario");
        }
        else if(tipoComent == 3 && $.trim(otroTipoComent) == ""){
            xModal.danger("Debe Seleccionar el Otro tipo de comentario");
        }
        else if(comentario == ''){
            xModal.danger("Debe Ingresar Un comentario");
        }else{
            var formulario = new FormData();
            formulario.append('tkexp', tkexp);
            formulario.append('comentario',comentario);
            formulario.append('tipoComent',tipoComent);
            formulario.append('otroTipoComent',otroTipoComent);
            console.log(formulario);
            $.ajax({
                url : BASE_URI + 'index.php/Bitacora/guardarNuevoComentario',
                data : formulario,
                processData : false,
                cache : false,
                async : true,
                type : 'post',
                dataType : 'json',
                contentType : false,
                success : function(response){
                    if(response.correcto == true){
                        xModal.success("OK: El comentario fue guardado", function(){
                            $("#comentario").val("");
                            $("#tipoComent").val(0);
                            $("#otroTipoComent").val("");
                            $("#tablaHistorial").html(response.grilla);
                            habilitar();
                        });
                    }
                    else{
                        xModal.danger("ERROR: El comentario NO fue guardado",function(){
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
    },

    modificarAdjunto : function(form, btn) {

        var error = false;
        var msg_error = '';
        var token_adjunto = form.token_adjunto.value;
        var nombre = form.nombre_txt.value;
        var path = form.archivo_adj.value;
        var comentario = form.comentario_adjunto.value;


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
                msg_error += 'Por Favor, elija un archivo con las siguientes extensiones: <br>'
                msg_error += extensiones_permitidas.join(' ')+'<br/>';
                xModal.warning(msg_error);
            } else {

                var formulario = new FormData();

                formulario.append('token_adjunto', token_adjunto);
                formulario.append('nombre', nombre);
                formulario.append('comentario',comentario);

                var inputFileImage = document.getElementById("archivo_adj");
                var file = inputFileImage.files[0];
                formulario.append('archivo_adj',file);
                //alert(BASE_URI + 'index.php/Bitacora/guardarNuevoAdjunto');

                $.ajax({
                    url : BASE_URI + 'index.php/Bitacora/modificarAdjunto',
                    data : formulario,
                    processData : false,
                    cache : false,
                    async : true,
                    type : 'post',
                    dataType : 'json',
                    contentType : false,
                    success : function(response){
                        if(response.correcto){
                            xModal.success("OK: El archivo fue reemplazado", function(){
                                $("#grilla-adjuntos").html(response.grilla);
                                $("#modificar_adjunto").remove();
                            });

                        }else{
                            xModal.danger(response.mensaje,function(){
                                $("#modificar_adjunto").remove();
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
    },

}