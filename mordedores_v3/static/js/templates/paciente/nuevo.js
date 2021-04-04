/* global BASE_URI */
$("#guardar").on('click', function (e) {
    var button_process	= buttonStartProcess($(this), e);
    var parametros		= $("#form").serializeArray();
    var region			= $("#region").val();
    var fc_nacimiento	= $("#fc_nacimiento").val();
    var mensaje_error	= "";

    if ($("#establecimientosalud option:selected").val() === "0") {
        mensaje_error += '- Debe seleccionar un Centro de Salud<br>';
    }
    if ($("#fechaingreso").val() == '') {
        mensaje_error += '- El campo Fecha de Atención a Paciente es Obligatorio<br>';
    }
    if ($("#fechanotificacion").val() == '') {
        mensaje_error += '- El campo Fecha de Notificación a SEREMI es Obligatorio<br>';
    }
    if ((!$("#chk_no_informado").is(":checked") && !$("#chkextranjero").is(":checked")) && $("#rut").val() == '') {
        mensaje_error += '- El campo RUT es Obligatorio<br>';
    }
    if ($("#nombres").val() == '') {
        mensaje_error += '- El campo Nombres es Obligatorio<br>';
    }
    if ($("#apellido_paterno").is(":checked") && $("#rut").val() == '') {
        mensaje_error += '- El campo Apellido Paterno es Obligatorio<br>';
    }
    if($("#telefono_paciente").val() == ''){
        mensaje_error += '- El campo Teléfono es Obligatorio<br>';
    }
	/*
    if (fc_nacimiento == '') {
        mensaje_error += '- El campo Fecha de Nacimiento es Obligatorio<br>';
    }
	*/
   /* Se comenta 10-01-19 por peticion de Carla
    if ($("#id_pais_origen option:selected").val() === "0") {
        mensaje_error += '- Debe seleccionar el País de origen del Paciente<br>';
    }
    */
    if ($("#fc_mordedura").val() == '') {
        mensaje_error += '- Debe ingresar Fecha de Mordedura<br>';
    }
    if ($("#region option:selected").val() === "0") {
        mensaje_error += '- Debe seleccionar la region de Mordedura<br>';
    }
    if ($("#comuna option:selected").val() === "0") {
        mensaje_error += '- Debe seleccionar la comuna de Mordedura<br>';
    }
    /*
    if ($("#direccion").val() == "") {
        mensaje_error += '- Debe seleccionar la Dirección de Mordedura<br>';
    }
    */
    if ($("#id_lugar_mordedura option:selected").val() === "0") {
        mensaje_error += '- Debe seleccionar lugar de Mordedura<br>';
    }
    if ($('input:radio[name=id_inicia_vacuna]:checked').val() === undefined) {
        mensaje_error += '- Debe informar si Inicia Vacuna (Si/No)<br>';
    }
    if ($("#id_animal_grupo option:selected").val() === "0") {
        mensaje_error += '- Debe seleccionar un grupo de Animal<br>';
    }

    if(mensaje_error != ""){
        xModal.danger(mensaje_error,function(){buttonEndProcess(button_process);});
    }else {
        if ($('#chkextranjero').is(':checked')) {
            parametros.push({
                "name": 'chkextranjero',
                "value": 1
            });
        } else {
            parametros.push({
                "name": 'chkextranjero',
                "value": 0
            });
        }
        if ($('#chk_no_informado').is(':checked')) {
            parametros.push({
                "name": 'chk_no_informado',
                "value": 1
            });
        } else {
            parametros.push({
                "name": 'chk_no_informado',
                "value": 0
            });
        }
        parametros.push({
            "name": 'region',
            "value": region
        });
        if ($('#gl_codigo_fonasa').val() == "") {
            parametros.push({
                "name": 'gl_codigo_fonasa',
                "value": 'NULL'
            });
        } else {
            parametros.push({
                "name": 'gl_codigo_fonasa',
                "value": "'" + $('#gl_codigo_fonasa').val() + "'"
            });
        }
        var imagenMapa      = new EventoReporteMapaImagen('map');
        imagenMapa.crearImagen(function(){
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: parametros,
                type: "post",
                url: BASE_URI + "index.php/Paciente/GuardarRegistro",
                error: function (xhr, textStatus, errorThrown) {
                    buttonEndProcess(button_process);
                    xModal.danger('Error: No se pudo Ingresar un nuevo Registro ' + errorThrown);
                },
                success: function (data) {
                    buttonEndProcess(button_process);
                    if (data.correcto) {
                        //DESCARGA PDF EXPEDIENTE
                        //window.open(BASE_URI + "index.php/Paciente/generarPdfExpediente/"+data.token_expediente,'_blank');
						/*
                        xModal.success('Éxito: ' + data.mensaje);
                        setTimeout(function () {
                            location.href = BASE_URI + "index.php/Paciente";
                        }, 5000);
						*/
						xModal.success('Éxito: ' + data.mensaje,function(){  location.href = BASE_URI + "index.php/Paciente"; });
                    } else {
                        xModal.danger('Error: ' + data.mensaje_error);
                    }
                }
            });
        });
    }

});


$("#chkextranjero").on('click', function (e) {
    if ($('#chkextranjero').is(':checked')) {
        $('#nacional').hide();
        $('#rut').val("");
        $('#extranjero').show();
        $("#div_rut_no_informado").hide();
        $("#chk_no_informado").prop("checked", false);
    } else {
        $('#nacional').show();
        $('#extranjero').hide();
        $('#inputextranjero').val("");
        //$('#listado-adjuntos-fonasa').html("");
        $("#div_rut_no_informado").show();
    }
});

$("#chk_no_informado").on('click', function (e) {
    if ($('#chk_no_informado').is(':checked')) {
        $('#nacional').hide();
        $('#rut').val("");
    } else {
        $('#nacional').show();
    }
});

$("#id_animal_grupo").on('change', function (e) {
    if ($(this).val() == 3) {
        $('#div_nuevo_mordedor').show();
        $('#div_grilla_mordedor').show();
    } else {
        $('#div_nuevo_mordedor').hide();
        $('#div_grilla_mordedor').hide();
    }
});

$("#id_lugar_mordedura").on('change', function (e) {
    if ($(this).val() == 3) {
        $('#div_otro_lugar').show();
    } else {
        $('#div_otro_lugar').hide();
        $('#gl_otro_lugar_mordedura').val("");
    }
});

$("#region").on('change', function (e) {
    $("#direccion").val("");
    var longitud_region = $("#region").children(":selected").attr("name");
    var latitud_region = $("#region").children(":selected").attr("id");

    $("#gl_longitud").val(longitud_region);
    $("#gl_latitud").val(latitud_region);
    $("#gl_latitud").trigger("change");

    if ($('#establecimientosalud').is('[disabled=disabled]')) {
        $('#form').find('#establecimientosalud').attr('disabled', false);
        $("#cambio_direccion").val("1"); //variable global JS
    }

});
$("#comuna").on('change', function (e) {
    $("#direccion").val("");
    var longitud_comuna = $("#comuna").children(":selected").attr("name");
    var latitud_comuna = $("#comuna").children(":selected").attr("id");

    $("#gl_longitud").val(longitud_comuna);
    $("#gl_latitud").val(latitud_comuna);
    $("#gl_latitud").trigger("change");

    if ($('#establecimientosalud').is('[disabled=disabled]')) {
        $('#form').find('#establecimientosalud').attr('disabled', false);
        $("#cambio_direccion").val("1");//variable global JS
    }

});

$("#bo_paciente_observa1").on('click', function() {
    $("#descargarInst").show();
});
$("#bo_paciente_observa_0").on('click', function() {
    $("#descargarInst").hide();
});

function IniciaVacunacion(valor){
if(valor == 1){
    $("#descargarInstVac").show(); 
    $("#NotaNoVac").hide(); 
}else{
    $("#descargarInstVac").hide();
    $("#NotaNoVac").show(); 
}

}


var Base64Binary = {
    /* Ejemplo de uso
     var uintArray	= Base64Binary.decode(data);
     var byteArray	= Base64Binary.decodeArrayBuffer(data);
     */
    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

    /* will return a  Uint8Array type */
    decodeArrayBuffer: function (input) {
        var bytes = (input.length / 4) * 3;
        var ab = new ArrayBuffer(bytes);
        this.decode(input, ab);

        return ab;
    },

    removePaddingChars: function (input) {
        var lkey = this._keyStr.indexOf(input.charAt(input.length - 1));
        if (lkey == 64) {
            return input.substring(0, input.length - 1);
        }
        return input;
    },

    decode: function (input, arrayBuffer) {
        //get last chars to see if are valid
        input = this.removePaddingChars(input);
        input = this.removePaddingChars(input);

        var bytes = parseInt((input.length / 4) * 3, 10);

        var uarray;
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;
        var j = 0;

        if (arrayBuffer)
            uarray = new Uint8Array(arrayBuffer);
        else
            uarray = new Uint8Array(bytes);

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        for (i = 0; i < bytes; i += 3) {
            //get the 3 octects in 4 ascii chars
            enc1 = this._keyStr.indexOf(input.charAt(j++));
            enc2 = this._keyStr.indexOf(input.charAt(j++));
            enc3 = this._keyStr.indexOf(input.charAt(j++));
            enc4 = this._keyStr.indexOf(input.charAt(j++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            uarray[i] = chr1;
            if (enc3 != 64)
                uarray[i + 1] = chr2;
            if (enc4 != 64)
                uarray[i + 2] = chr3;
        }

        return uarray;
    }
}

$("#btnDescarga").on('click', function (e) {
    var button_process = buttonStartProcess($(this), e);
    var parametros = $("#form").serializeArray();
    var gl_rut = $("#rut").val();
    var inputextranjero = $("#inputextranjero").val();

    if (rut == '' && inputextranjero == '') {
        xModal.info('Debe ingresar un RUT o un Pasaporte.');
    } else {

        $.ajax({
            dataType: "json",
            cache: false,
            async: true,
            data: parametros,
            type: "post",
            url: BASE_URI + "index.php/Paciente/generarConsentimiento",
            error: function (xhr, textStatus, errorThrown) {
                xModal.danger('Error: No se ha podido generar el PDF.<br> Favor informar a Mesa de Ayuda.');
            },
            success: function (data) {
                if (data.correcto) {
                    var byteArray = Base64Binary.decodeArrayBuffer(data.base64);
                    var blob = new Blob([byteArray], {type: 'application/pdf'});
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = data.filename;
                    link.click();
                } else {
                    xModal.danger('No se ha podido generar el PDF.<br> Favor informar a Mesa de Ayuda.');
                }
            }
        });
    }
    buttonEndProcess(button_process);
});

//Formatea Fecha
function formattedDate(date) {
    var d = new Date(date || Date.now()),
            day = '' + d.getDate(),
            month = '' + (d.getMonth() + 1),
            year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [day, month, year].join('/');
}

var Paciente = {
    revisar: function () {
        var rut = $("#rut").val();
        var inputextranjero = $("#inputextranjero").val();
        //if (rut != "") {
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: {rut: rut},
                type: "post",
                url: BASE_URI + "index.php/Paciente/revisarExistePaciente",
                error: function (xhr, textStatus, errorThrown) {
                    //xModal.danger('Error al Buscar');
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.open(BASE_URI + "index.php/Paciente/revisarPaciente/"+rut,"Revisar Notificaciones Paciente",85,0);
                        
                        $("#token_paciente").val(data.gl_token);
                        $("#nombres").val(data.gl_nombres);
                        $("#apellido_paterno").val(data.gl_apellido_paterno);
                        $("#apellido_materno").val(data.gl_apellido_materno);
                        $("#fc_nacimiento").val(data.fc_nacimiento);
                        $("#fc_nacimiento").trigger('change');
                        $('#opcionPrevision').val(data.id_prevision);
                        $('#id_tipo_sexo').val(data.id_tipo_sexo);
                        $("#id_pais_origen").val(data.id_pais_origen).trigger('change');
                        $("#id_nacionalidad").val(data.id_nacionalidad).trigger('change');
                        $("#email_paciente").val(data.email_paciente);
                        $("#telefono_paciente").val(data.telefono_paciente).trigger('change');

                        $.ajax({
                            data: {gl_token: ""},
                            url: BASE_URI + "index.php/Paciente/grillaContactoPaciente",
                            dataType: 'html',
                            type: 'post',
                            success: function (response) {
                                $("#grilla-contacto-paciente").html(response);
                            }
                        });
                        
                    } else {
                        $("#token_paciente").val("");
                        $("#nombres").val(data.gl_nombres);
                        $("#apellido_paterno").val(data.gl_apellido_paterno);
                        $("#apellido_materno").val(data.gl_apellido_materno);
                        $("#fc_nacimiento").val(data.fc_nacimiento).trigger("change");
                        //$("#edad").val("");
                        $('#opcionPrevision').val("0");
                        $('#id_tipo_sexo').val(data.id_sexo);
                        $("#id_pais_origen").val("0").trigger('change');
                        $("#id_nacionalidad").val("0").trigger('change');
                        $("#email_paciente").val("");
                        $("#telefono_paciente").val("").trigger('change');
                    }
                }
            });
        /*
	} else {
            if ($('#chkextranjero').is(':checked') && inputextranjero === "") {
                xModal.info("Debe ingresar un RUT o un Pasaporte");
            }
        }
	*/
    },
    notificacionRepetida: function(btn,token_expediente,gl_folio,gl_rut){
        btn.disabled = true;
        var btnTexto = $(btn).html();
        if (token_expediente != "") {
            xModal.confirm('¿Está Seguro de que corresponde a Notificación Folio <strong>'+gl_folio+'</strong>?\n\
                            <br>* Si presiona "SI" será redirigido a Notificación seleccionada para revisar detalles.',function(){
                $.ajax({
                    dataType: "json",
                    cache: false,
                    async: true,
                    data: {token_expediente: token_expediente},
                    type: "post",
                    url: BASE_URI + "index.php/Paciente/notificacionRepetida",
                    error: function (xhr, textStatus, errorThrown) {
                        //xModal.danger('Error al Buscar');
                    },
                    success: function (data) {
                        if (data.correcto) {
                            location.href = BASE_URI + "index.php/Buscar/index/?token_expediente="+token_expediente;
                        }

                    }
                });
            });
            $(btn).html(btnTexto).attr('disabled', false);
        }else{
            $(btn).html(btnTexto).attr('disabled', false);
        }
    }
};

function guardarAdjunto(form, btn) {
    btn.disabled = true;
    var btnTexto = $(btn).html();
    $(btn).html('Guardando...');

    if (form.adjunto.value == "") {
        xModal.warning('Error: Debe seleccionar un archivo para adjuntarlo');
        $(btn).html(btnTexto).attr('disabled', false);
    } else {
        extensiones_permitidas = new Array('.jpeg', '.jpg', '.png', '.gif', '.tiff', '.bmp', '.pdf', '.txt', '.csv', '.doc', '.docx', '.ppt', '.pptx', '.xls', '.xlsx');
        permitida = false;
        string = form.adjunto.value;
        extension = (string.substring(string.lastIndexOf("."))).toLowerCase();

        for (var i = 0; i < extensiones_permitidas.length; i++) {
            if (extensiones_permitidas[i] == extension) {
                permitida = true;
                break;
            }
        }

        if (!permitida) {
            xModal.warning('El Tipo de archivo que intenta subir no está permitido.<br><br>Favor elija un archivo con las siguientes extensiones: <br>' + extensiones_permitidas.join(' '));
            $(btn).html(btnTexto).attr('disabled', false);
        } else {
            $(form).submit();
        }
    }
}

function cargarListadoAdjuntos() {
    var tipo_adjunto = $("#tipo_adj").val();
    $.post(BASE_URI + 'index.php/Paciente/cargarListadoAdjuntos/' + tipo_adjunto, function (response)
    {
        if (tipo_adjunto == 3) {
            parent.$("#listado-adjuntos-fonasa").html(response).show();
        } else {
            parent.$("#listado-adjuntos").html(response).show();
        }
    });
}

function borrarAdjunto(adjunto) {
    $.post(BASE_URI + 'index.php/Paciente/borrarAdjunto/' + adjunto, function (response)
    {
        $("#listado-adjuntos").html(response);
    });
}

$(document).ready(function () {
    var isDisabled = $("#region").is(':disabled');
    var longitud_region = $("#region").children(":selected").attr("name");
    var latitud_region = $("#region").children(":selected").attr("id");
    if (isDisabled) {
        $("#gl_longitud").val(longitud_region);
        $("#gl_latitud").val(latitud_region);
        $("#gl_latitud").trigger("change");
    }
    var mapaMordedura = new MapaFormulario("map");
    mapaMordedura.seteaIcono("static/images/markers/mordedor3.png");
    mapaMordedura.seteaLatitudInput("gl_latitud");
    mapaMordedura.seteaLongitudInput("gl_longitud");
    mapaMordedura.seteaLongitud("-70.6504492");
    mapaMordedura.seteaLatitud("-33.4378305");
    mapaMordedura.seteaZoom(18);
    mapaMordedura.seteaPlaceInput("direccion");
    mapaMordedura.inicio();
    mapaMordedura.cargaMapa();
    mapaMordedura.setMarkerInputs();

});

function mostrarFonasaExtranjero(id_prevision) {
    if ($('#chkextranjero').is(':checked')) {
        if (id_prevision === "1") {
            $('#groupFonasaExtranjero').removeClass("hidden");
        } else {

            $('#groupFonasaExtranjero').addClass("hidden");
        }
    } else {
        $('#groupFonasaExtranjero').addClass("hidden");
    }
}

$("#id_pais_origen").on('change', function (e) {
    if ($("#id_pais_origen").val() > 0) {
        var nacionalidad = $("#id_pais_origen").val();
        //$("#id_nacionalidad").children().attr("id").val(4).trigger("change");
        //$('#id_nacionalidad').find('option:selected').removeProp('selected').trigger("change");
        $("#id_nacionalidad option[id='" + nacionalidad + "']").prop("selected", "selected").trigger("change");
    }
});

$(".select2").select2({
    language: "es",
    tags: false

});

//Fecha HOY para limitar calendario FC_NACIMIENTO
var hoy = new Date();
var dd = hoy.getDate();
var mm = hoy.getMonth() + 1; //hoy es 0!
var yyyy = hoy.getFullYear();

if (dd < 10) {
    dd = '0' + dd
}

if (mm < 10) {
    mm = '0' + mm
}

hoy = mm + '/' + dd + '/' + yyyy;


$("#fc_nacimiento").datepicker({
    locale: "es",
    format: "DD/MM/YYYY",
    maxDate: "now",
    useCurrent: false,
    inline: false,
    yearRange: "1900:"+yyyy
});

$("#fechaingreso").datepicker({
    locale: "es",
    format: "DD/MM/YYYY",
    maxDate: "now",
    useCurrent: false,
    inline: false
});

$("#fechanotificacion").datepicker({
    locale: "es",
    format: "DD/MM/YYYY",
    maxDate: "now",
    useCurrent: false,
    inline: false
});

$("#fc_mordedura").datepicker({
    locale: "es",
    format: "DD/MM/YYYY",
    maxDate: "now",
    useCurrent: false,
    inline: false
});

$("#horaingreso").timepicker({});

function cambioFechaIngreso() {
    var min = $('#fechaingreso').datepicker('getDate');

    $('#fechanotificacion').datepicker('destroy');
    $("#fechanotificacion").datepicker({
        locale: "es",
        format: "DD/MM/YYYY",
        minDate: min,
        maxDate: "now",
        useCurrent: false,
        inline: false
    });

    $('#fc_mordedura').datepicker('destroy');
    $("#fc_mordedura").datepicker({
        locale: "es",
        format: "DD/MM/YYYY",
        maxDate: min,
        useCurrent: false,
        inline: false
    });

    $('#fc_mordedura').val($('#fechaingreso').val());

    //$('#fechaingreso').trigger("blur");
}


$('#cambiarTelefono').on('click',function(){
    if($(this).prop('checked')) {
        //console.log('Seleccionado');
        $('#telefono_paciente').removeAttr('disabled');
    }else{
        //console.log('deseleccionado');
        $("#telefono_paciente").attr('disabled','disabled');
    }
  

});

function cambiarTelefono(){
    if ($('#telefono_paciente').val() != "") {
        $("#bo_informa_telefono").prop("checked",false);
    }else{
        $("#bo_informa_telefono").prop("checked",true);
    }
}