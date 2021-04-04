function agregarCampoTemporal() {
    var parametros = $("#formCampoEspecifico").serializeArray();

    var id_tipo_campo = $("#id_tipo_campo option:selected").val();
    var bo_required = $("#bo_required option:selected").val();
    var gl_nombre_campo = $("#gl_nombre_campo").val();
    var gl_tipo_campo = $("#id_tipo_campo option:selected").text();
    // var gl_opciones = $("#gl_opciones").val();
    // var arrOpciones = null;
    var mensaje = "";

    if (id_tipo_campo == 0) { mensaje += "- Debe escoger el tipo de campo.<br>"; }
    if (!gl_nombre_campo || gl_nombre_campo.length == 0) { mensaje += "- Debe escribir un nombre para el campo.<br>"; }
    if (bo_required < 0) { mensaje += "- Debe seleccionar un requisito.<br>"; }
    // if (!gl_opciones) { mensaje += "- Debe ingresar al menos 2 opciones.<br>"; }
    // else {
    //     var lines = gl_opciones.split("\n");
    //     lines.forEach(opt => {
    //         if (opt.trim().length > 0) { arrOpciones.push(opt.trim()); alert(opt); }
    //     });
    //     // FIXME: No guarda array
    //     if (arrOpciones.length == 0) { mensaje += "- Debe ingresar por lo menos 2 opciones válidas.<br>"; }
    // }

    parametros.push({ "name": "gl_tipo_campo", "value": gl_tipo_campo });
    // parametros.push({ "name": "opciones", "value": arrOpciones });

    if (mensaje == "") {
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: Base.getBaseUri() + "index.php/Mantenedor/Campana/crearCampoTemporal",
            error: function (xhr, textStatus, errorThrown) {
            	Modal.danger('Error interno. Intente nuevamente o comuníquese con Mesa de Ayuda');
            },
            success: function (data) {
                if (data.correcto) {
                    Modal.success(data.mensaje,function(){
                        $("#grillaEspecifico").html(data.grilla);
                        $("#gl_nombre_campo").val('');
                        $("#gl_descripcion").val('');
                        $("#id_tipo_campo").val(0);
                        xModal.close();
                    });
                } else {
                    //Base.buttonProccessEnd(btn);
					Modal.danger(data.mensaje);
                    //xModal.danger('Ha ocurrido un Error. Si este persiste, favor contactar a Mesa de Ayuda.');
                }
            }
        });
    } else {
        Modal.danger(mensaje, function () { Base.buttonProccessEnd(btn); });
    }
}

function borrarCampoTemporal(data) {
    // alert(data);
    $.ajax({
        dataType: "json",
        cache: false,
        async: true,
        data: { data: data },
        type: "post",
        url: Base.getBaseUri() + "index.php/Mantenedor/Campana/borrarCampoTemporal",
        error: function (xhr, textStatus, errorThrown) {
        },
        success: function (data) {
            if (data.correcto) {
                $("#grillaEspecifico").html(data.array);
            } else {
                Base.buttonProccessEnd(btn);
                xModal.danger(data.mensaje);
            }
        }
    });
}


$("#id_tipo_campo").on('change', function (e) {
    var id_tipo = $('#id_tipo_campo').val();
    if (id_tipo == 4) {
        $('#span-opciones').show("slow");
        $('#gl_opciones').val("");
    } else {
        $('#span-opciones').hide("slow");
        $('#gl_opciones').val("");
    }
});

function agregarOpcionesCriterio(form,e){
    var parametros      =   $(form).serializeArray();
    var opcion          =   $('#opcion').val();
    var gl_opciones     =   $('#gl_opciones').val();
    var msg_error       =   '';

    console.log(opcion);
    console.log(gl_opciones);

    if(opcion === undefined || opcion == ''){
        msg_error       +=   ' -    Ha ocurrido un error inesperado. Por favor, vuelva a intentar. Si el error persiste, por favor contacte a Mesa de Ayuda.';
    }
    else if(gl_opciones == ''){
        msg_error       +=   ' -    Debe a&ntilde;adir al menos una opci&oacute;n.';
    }

    if(msg_error != ''){
        xModal.danger(msg_error);
    }else{
        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: Base.getBaseUri() + "index.php/Mantenedor/Campana/agregarOpciones",
            error: function (xhr, textStatus, errorThrown) {
            },
            success: function (data) {
                 if (data.correcto) {
                    Modal.success('Opciones agregadas Exitosamente.',function(){
                        $("#contenedor-opciones-agregadas").html(data.grilla);
                        $("#gl_opciones").val('');
                        //xModal.close();
                    });
                } else {
                    //Base.buttonProccessEnd(btn);
					 Modal.danger(data.mensaje);
                    //xModal.danger('Ha ocurrido un Error. Si este persiste, favor contactar a Mesa de Ayuda.');
                }
            }
        });
    }
}
