PatenteChilena = {

    verificar: function(){
        patente = $('#gl_vehiculo_patente').val();
        patente = PatenteChilena.formatear(patente, null);
        if(PatenteChilena.validar(patente)){
            $('#gl_vehiculo_patente').val(patente);
            $('#gl_vehiculo_patente').parent().removeClass('has-error');
            $('#gl_vehiculo_patente').parent().addClass('has-success');
        }else{
            //$('#gl_vehiculo_patente').val('');
            $('#gl_vehiculo_patente').parent().addClass('has-error');
        }
    },
    formatear: function(patente, digitoVerificador){
        var sPatente = new String(patente);
        var sPatenteFormateado = '';
        sPatente = PatenteChilena.quitarFormato(sPatente);

        var verificador = sPatente.length > 6 ? sPatente.substring(6) : false;
        sPatente = sPatente.substring(0, 6);

        if (sPatente.length == 6){
            if (PatenteChilena.esAntigua(sPatente)){
                sPatente = [sPatente.slice(0, 2), '-', sPatente.slice(2)].join('');
            }else{
                sPatente = [sPatente.slice(0, 4), '-', sPatente.slice(4)].join('');
            }
        }
        if (verificador){
            sPatente += '-' + verificador;
        }
        return sPatente;
    },
    quitarFormato: function(patente){
        return patente.replace(/\W+/g, "").toUpperCase();
    },
    esAntigua: function(texto){
        return texto.match(/^[a-z]{2}[\.\- ]?[0-9]{2}[\.\- ]?[0-9]{2}$/i);
    },
    esNueva: function(texto){
        return texto.match(/^[b-d,f-h,j-l,p,r-t,v-z]{2}[\-\. ]?[b-d,f-h,j-l,p,r-t,v-z]{2}[\.\- ]?[0-9]{2}$/i);
    },
    validar: function(texto){
        texto = PatenteChilena.quitarFormato(texto);
        if (parseInt(texto.length) != 6){
            return false;
        }
        var verificador = texto.substring(5);
        texto = texto.substring(0, 6);


        if (this.esAntigua(texto) === this.esNueva(texto)){
            return false;
        }
        return true;

    },
};

$('#gl_vehiculo_patente').on('blur',PatenteChilena.verificar);
