

var MantenedorCampana = {


    init : function (tipo) {
        MantenedorCampana.cargarGrillaCampanas(tipo);
    },


    cargarGrillaCampanas : function (tipo) {
        $.ajax({
            url : BASE_URI + 'Mantenedor/Campana/cargarGrillaCampanas',
            data : {tipo:tipo} ,
            type : 'post',
            dataType : 'html',
            success : function (response) {
                $('#contenedor-tabla-campanas').html(response);
                Tables.initTable('tabla-campanas');
            }
        });
    },

    agregarCampana: function (form, btn) {
        Base.buttonProccessStart(btn);

        var mensaje = '';
        


        if ($('.ambitos:checked').length == 0) {
            mensaje += '- Debe escoger por lo menos un Ámbito.<br>';
        }
        if (form.gl_nombre_campana.value == "") {
            mensaje += '- Debe Ingresar el nombre.<br>';
        }

        // validar oficinas marcadas para regiones
        if (form.campana_nacional !== undefined) {
            if ($('#campana_nacional').is(':checked') === false) {
                if ($('.regiones_nacional:checked').length == 0) {
                    mensaje += '- Debe seleccionar la(s) región(es) a la cual va destinada o indicar si es NACIONAL <br/>';
                } else {
                    $('.regiones_nacional:checked').each( function () {
                        var region = $(this).val();
                        var nombre_region = $(this).data('nombre');
                        if ($('.oficina-region-' + region + ':checked').length == 0) {
                            mensaje += '- Debe seleccionar la o las oficinas para la ' + nombre_region + ' <br/>';
                        }
                    });
                }
            }
        } else {
            if ($('.oficina-region:checked').length == 0) {
                mensaje += '- Debe seleccionar por lo menos una oficina <br/>';
            }
        }

        /* if (bo_programa == -1) {
            mensaje += '- Debe Ingresar si es Campaña o Programa <br>';
        } */
        if (form.fechaInicia.value == "") {
            mensaje += '- Debe Ingresar la fecha de inicio. <br>';
        }
        if (form.fechaFinaliza.value == "") {
            mensaje += '- Debe Ingresar el fecha de termino. <br>';
        }

        var tipo = form.tipo.value;
        if (mensaje == "") {

            var parametros = $(form).serializeArray();
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: parametros,
                type: "post",
                url: Base.getBaseUri() + "index.php/Mantenedor/Campana/agregarCampanaDB",
                error: function (xhr, textStatus, errorThrown) {
                    Modal.danger('Error interno. Intente nuevamente o comuníquese con Mesa de Ayuda', function () {
                        Base.buttonProccessEnd(btn);
                    });
					
                },
                success: function (data) {
                    if (data.correcto) {
                        Modal.success(data.mensaje, function () {
                            MantenedorCampana.cargarGrillaCampanas(tipo);
                            Modal.closeAll();
                        });
                    } else {
                        Modal.danger(data.mensaje, function () {
                            Base.buttonProccessEnd(btn);
                        });
                    }
                }
            });
        } else {
            Modal.danger(mensaje, function () { Base.buttonProccessEnd(btn); });
        }
    },

    editarCampana: function (form, btn) {
        Base.buttonProccessStart(btn);
        var parametros = $(form).serializeArray();

        var id_campana = $('#id_campana').val();
        var gl_nombre = $('#gl_nombre_campana').val();
        var ambitos = $('#ambitos option:selected').val();
        var id_region_campana = $('#id_region_campana option:selected').val();
        var id_oficina_campana = $('#id_oficina_campana option:selected').val();
        var id_comuna_campana = $('#id_comuna_campana option:selected').val();
        var fechaInicia = $('#fechaInicia').val();
        var fechaFinaliza = $('#fechaFinaliza').val();
        var id_campana_estado = $('#id_campana_estado option:selected').val();

        console.log(id_campana);
        console.log(gl_nombre);
        // console.log(gl_nr_orden);
        console.log(ambitos);
        console.log(id_region_campana);
        console.log(id_oficina_campana);
        console.log(id_comuna_campana);
        console.log(fechaInicia);
        console.log(fechaFinaliza);
        console.log(id_campana_estado);

        var mensaje = "";
        if (true) {
            if (!ambitos || ambitos.length == 0) {
                mensaje += '- Debe Escoger el al menos un Ambito.<br>';
            }
            if (!gl_nombre) {
                mensaje += '- Debe Ingresar el nombre de la Campaña/Programa. <br>';
            }
            if (!fechaInicia) {
                mensaje += '- Debe Ingresar la fecha de inicio.<br>';
            }
            if (!fechaFinaliza) {
                mensaje += '- Debe Ingresar el fecha de termino.<br>';
            }
        }

        if (mensaje == "") {
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: parametros,
                type: "post",
                url: Base.getBaseUri() + "index.php/Mantenedor/Campana/editarCampanaDB",
                error: function (xhr, textStatus, errorThrown) {
                },
                success: function (data) {
                    if (data.correcto) {
                        xModal.success(data.mensaje);
                        setTimeout(function () {
                            location.href = Base.getBaseUri() + "Mantenedor/Campana/";
                            Base.buttonProccessEnd(btn);
                        }, 2000);
                    } else {
                        Base.buttonProccessEnd(btn);
                        xModal.danger(data.mensaje);
                    }
                }
            });
        } else {
            xModal.danger(mensaje, function () { Base.buttonProccessEnd(btn); });
        }
    },


    agregarDatosAdicionales : function () {
        var nombre_campo = $('#gl_nombre_campo').val();
        var tipo = $('#id_tipo_campo').val();
        var nombre_tipo = $("#id_tipo_campo option:selected").text();
        var descripcion = $('#gl_descripcion_campo').val();
        var opciones = $('#gl_opciones').val();

        if (nombre_campo !== "" && tipo !== "" && descripcion !== "") {

            /* revisar si existen otro campo con el mismo nombre */
            var repetidos = 0;
            $('.datos-adicionales-nombres').each( function () {
                if ($(this).val().toLowerCase() == nombre_campo.toLowerCase()) {
                    repetidos++;
                }
            });
            if (repetidos > 0) {
                Modal.danger('Existe un campo con el mismo nombre ingresado');
                return false;
            }

            if ((tipo == 1 || tipo == 3) && opciones == "") {
                Modal.danger('Debe ingresar las opciones para el tipo de campo seleccionado');
                return false;
            }

            /* validar que opciones ingresadas no hayan repetidos */
            if ((tipo == 1 || tipo == 3) && opciones != "") {
                var arr_opciones = opciones.split(',');
                var tmp_opcion = arr_opciones[0].trim();
                var repetido = '';
                if (arr_opciones.length > 1) {
                    for (var i = 1; i < arr_opciones.length; i++) {
                        
                        if (tmp_opcion.toLowerCase() == arr_opciones[i].trim().toLowerCase()) {
                            repetido = arr_opciones[i].trim();
                            tmp_opcion = repetido;
                        } 
                    }
                }

                if (repetido !== "") {
                    Modal.danger('Se ha encontrado que la opción <strong>' + repetido +'</strong> está repetida');
                    return false;
                }
            } 

            var fila = '<tr>';
            fila += '<td class="text-center" width="15%">' + nombre_tipo + '</td>';
            fila += '<td class="text-center">' + nombre_campo + ' <i class="fa fa-info-circle" data-toggle="tooltip" title="' + descripcion + '"></i></td>';
            fila += '<td class="text-center">' + opciones + '</td>';
            fila += '<td class="text-center" width="5%"><button type="button" class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove();"><i class="fa fa-trash-o"></i></button></td>';
            fila += '<input type="hidden" name="nombre_campo_adicional[]" class="datos-adicionales-nombres" value="' + nombre_campo + '" />';
            fila += '<input type="hidden" name="descripcion_campo_adicional[]" value="' + descripcion + '" />';
            fila += '<input type="hidden" name="tipo_campo_adicional[]" value="' + tipo + '" />';
            fila += '<input type="hidden" name="nombre_tipo_campo_adicional[]" value="' + nombre_tipo + '" />';
            fila += '<input type="hidden" name="opciones_campo_adicional[]" value="' + opciones + '" />';
            fila += '</tr>';

            $("#tabla-datos-adicionales tbody").append(fila);
            $(".datos-adicionales").val('');
            $('#contenedor-datos-adicionales-select').hide();
        } else {
            Modal.danger('Debe completar todos los campos');
        }
    },

    /**
     * Desactivar campana o programa
     * @param {integer} item ID campana/programa 
     * @param {integer} tipo Es campana o programa
     */
    inhabilitar : function (item, tipo) {
        Modal.confirm('¿Desea deshabilitar este item?', function () {
            $.ajax({
                url : BASE_URI + 'Mantenedor/Campana/deshabilitar',
                type : 'post',
                dataType : 'json',
                data : {item : item},
                success : function (response) {
                    if (response.correcto) {
                        Modal.success(response.mensaje, function () {
                            MantenedorCampana.cargarGrillaCampanas(tipo);
                        });
                    } else {
                        Modal.danger(response.mensaje);
                    }
                },
                error : function () {
                    Modal.danger('Error interno. Intente nuevamente o comuníquese con Mesa de Ayuda');
                }
            })
        });
    },
    

    habilitar : function (item, tipo) {
        Modal.confirm('¿Desea habilitar este item?', function () {
            $.ajax({
                url : BASE_URI + 'Mantenedor/Campana/habilitar',
                type : 'post',
                dataType : 'json',
                data : {item : item},
                success : function (response) {
                    if (response.correcto) {
                        Modal.success(response.mensaje, function () {
                            MantenedorCampana.cargarGrillaCampanas(tipo);
                        });
                    } else {
                        Modal.danger(response.mensaje);
                    }
                },
                error : function () {
                    Modal.danger('Error interno. Intente nuevamente o comuníquese con Mesa de Ayuda');
                }
            })
        });
    },


    cargarOficinaPorRegion: function (region, combo, oficina, callback = null) {
        var oficinas = '';
        if ($('#' + combo).attr("disabled") === undefined) {
            $.post(Base.getBaseUri() + "index.php/General/Regiones/cargarOficinasPorRegion", { region: region }, function (response) {

                if (response.length > 0) {
                    var total = response.length;
                    
                    for (var i = 0; i < total; i++) {
                        oficinas += '<div class="col-xs-12 col-sm-6">'+
                        '<div class="checkbox">'+
                            '<label>'+
                                '<input type="checkbox" class="oficina-region-' + region +'" name="id_oficina_campana[]" value="' + response[i].id_oficina + '" id="id_oficina_campana_' + response[i].id_oficina + '" /> '+ response[i].nombre_oficina +
                            '</label>'+
                        '</div>'+
                    '</div>';
                        /* if (oficina == response[i].id_oficina) {
                            options += '<option value="' + response[i].id_oficina + '"  selected >' + response[i].nombre_oficina + '</option>';
                        } else {
                            options += '<option value="' + response[i].id_oficina + '" >' + response[i].nombre_oficina + '</option>';
                        } */

                    }
                    $('#' + combo).html(oficinas);
                    if (callback && typeof callback === "function") {
                        callback();
                    }
                }
            }, 'json');
            $('#' + combo).html(oficinas);
        }
    },

};


var minVisita;
$("#fechaInicia").datepicker({
    // maxDate: "now",
    useCurrent: false,
    inline: true,
    beforeShow: function () {
        setTimeout(function () {
            $('.ui-datepicker').css('z-index', 99999999999999);
        }, 0);
    },
    onSelect: function () {
        var minVisita = $(this).datepicker('getDate');
        minVisita.setDate(minVisita.getDate() + 1);
        if (minVisita < Date.now()) { minVisita = "now"; } // Fecha finalizacion siempre mayor
        $('#fechaFinaliza').datepicker('option', 'minDate', minVisita);
    }
});


$("#fechaFinaliza").datepicker({
    // minDate: minVisita,
    useCurrent: false,
    inline: false,
    beforeShow: function () { //Para que aparezca en Modal
        setTimeout(function () {
            $('.ui-datepicker').css('z-index', 99999999999999);
        }, 0);
    }
});

$(".chosen").chosen();

$("#gl_comentario").bind('input propertychange', function () {
    var max = $("#cantCaracteres").val();
    var disponible = max - this.value.length;
    $("#charLeft").text(disponible);
});