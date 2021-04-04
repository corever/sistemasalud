/*$(document).ready(function() {
$('#password').keyup(function() {
$('#result').html(fuerzaPass($('#password').val()))
})
function fuerzaPass(password) {
var strength = 0
if (password.length < 6) {
return 'Muy corta'
}
if (password.length > 7) strength += 1
// If password contains both lower and uppercase characters, increase strength value.
if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
// If it has numbers and characters, increase strength value.
if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
// If it has one special character, increase strength value.
if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
// If it has two special characters, increase strength value.
if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
// Calculated strength value, we can return messages
// If value is less than 2
if (strength < 2) {
return 'Débil'
} else if (strength == 2) {
return 'Buena'
} else {
return 'Fuerte'
}
}
});*/

//Validar que Solo sean Numeros
function soloNumeros(e){
	var key = window.Event ? e.which : e.keyCode
	return (key >= 48 && key <= 57)
}
//Validar que Solo sean Numeros y comas
function soloNumerosYComa(e){
    var key = window.Event ? e.which : e.keyCode
	return (key >= 48 && key <= 57 || key == 44)
}

//Validar que solo sean Numeros y K para RUT
function soloNumerosYK(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras = "kK0123456789";//Se define todo el abecedario que se quiere que se muestre.
    especiales = [8, 37, 39, 46, 9]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.
    tecla_especial = false;
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }
    if(letras.indexOf(tecla) == -1 && !tecla_especial){
        return false;
      }
}

//Formateo Rut
function formateaRut(rut0)
{
        var cont = 0;
        var format;
        var rut1 = rut0.value;
        while (rut1.indexOf(".") != -1)
            rut1 = rut1.replace(".","");
        while (rut1.indexOf("-") != -1)
            rut1 = rut1.replace("-","");
//Validar tambien que solo pueda entrar Numeros y letra K
        if (rut1 != "" && rut1.length > 1){
        	format = "-" + rut1.substring(rut1.length - 1);
        } else {
        	format = "" + rut1.substring(rut1.length - 1);
        }
        for (var i = rut1.length - 2; i >= 0; i--) {
            format = rut1.substring(i, i + 1) + format;
            cont++;
        }
        document.getElementById($(rut0).prop("id")).value = format;
}

function Valida_Rut( rut ){
    
    var intlargo = rut.value;
    var tmpstr = "";
    if (intlargo.length> 0)
    {
		var re = /^[1-9]{1}[0-9]{0,7}\-([0-9]|[kK]){1}$/;
        crut = rut.value;
        var rutNo = ['33333333-3', '44444444-4', '55555555-5', '66666666-6', '77777777-7', '88888888-8', '99999999-9'];

        if(!re.test(crut) || $.inArray(crut, rutNo) != -1){
			Modal.danger('El RUT ingresado no es válido');
			$(rut).parent().addClass('has-error');
			$(rut).val('');
			return false;
		}

        for ( i=0; i <crut.length ; i++ )
        {
        if ( crut.charAt(i) != ' ' && crut.charAt(i) != '.' && crut.charAt(i) != '-' )
        	{
            tmpstr = tmpstr + crut.charAt(i);
        	}
        }
        largo = tmpstr.length;

        if ( largo <8 )
        {
			Modal.danger('El RUT ingresado no es válido (muy corto)');
			$(rut).parent().addClass('has-error');
            $(rut).val('');
            return false;
        }else if(largo > 9){
			Modal.danger('El RUT ingresado no es válido (muy largo)');
			$(rut).parent().addClass('has-error');
            $(rut).val('');
            return false;
        }
        rut1 = tmpstr;
        crut= tmpstr;
        largo = crut.length;

        if ( largo> 2 )
            rut1 = crut.substring(0, largo - 1);
        else
            rut1 = crut.charAt(0);

        dv = crut.charAt(largo-1);

        if ( rut1 == null || dv == null )
        return 0;

        var dvr = '0';
        suma = 0;
        mul  = 2;

        for (i= rut1.length-1 ; i>= 0; i--)
        {
            suma = suma + rut1.charAt(i) * mul;
            if (mul == 7)
                mul = 2;
            else
                mul++;
        }

        res = suma % 11;
        if (res==1)
            dvr = 'k';
        else if (res==0)
            dvr = '0';
        else
        {
            dvi = 11-res;
            dvr = dvi + "";
        }

        if ( dvr != dv.toLowerCase() )
        {
			Modal.danger('El RUT ingresado no es válido');
			$(rut).parent().addClass('has-error');
			$(rut).val('');
            return false;
        }

		if ($(rut).parent().hasClass('has-error')) {
			$(rut).parent().removeClass('has-error');
		}
		$(rut).parent().addClass('has-success');
        return true;
    }
}
//Validar rut

function validaRut(objetoRut){
  var tmpstr = "";
	var intlargo = objetoRut.value;
	if (intlargo.length> 0)
	{
		crut = objetoRut.value;
		largo = crut.length;
		if ( largo <2 )
		{
      $('#rut').parent().removeClass('has-success');
      $('#rut').parent().addClass('has-error');
			return false;
		}

		for ( i=0; i <crut.length ; i++ )
		if ((crut.charAt(i) != ' ') && (crut.charAt(i) != '.') && (crut.charAt(i) != '-'))
		{
			tmpstr = tmpstr + crut.charAt(i);
		}
		rut = tmpstr;
		crut = tmpstr;
		largo = crut.length;
		if ( largo> 2 )
			rut = crut.substring(0, largo - 1);
		else    rut = crut.charAt(0);

		dv = crut.charAt(largo-1);

		if ( rut == null || dv == null )
		return 0;

		var dvr = '0';
		suma = 0;
		mul  = 2;

		for (i= rut.length-1 ; i>= 0; i--)
		{
			suma = suma + rut.charAt(i) * mul;
			if (mul == 7)
				mul = 2;
			else
				mul++;
		}

		res = suma % 11;
		if (res==1)
			dvr = 'k';
		else if (res==0)
			dvr = '0';
		else
		{
			dvi = 11-res;
			dvr = dvi + "";
		}
                //Rut es Inválido
		if ( dvr != dv.toLowerCase() )
		{
        $('#rut').parent().removeClass('has-success');
        $('#rut').parent().addClass('has-error');
        return true;
		}
                //Rut Válido
        if ($('#rut').parent().hasClass('has-error'))
        {
            $('#rut').parent().removeClass('has-error');
        }
            $('#rut').parent().addClass('has-success');
            return false;
	}
}

//Validar Email
function validaEmail(email,mensaje_error) {
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

	if(email.value!=""){
		//Se muestra un texto a modo de ejemplo
		if (emailRegex.test(email.value)) {
			if($(email).parent().hasClass('has-error')){
				$(email).parent().removeClass('has-error');
			}
			$(email).parent().addClass('has-success');
			$(email).parent().find('span.help-block').addClass("hidden");
		}else{
			$(email).parent().addClass('has-error');
			$(email).parent().find('span.help-block').html(mensaje_error);
			$(email).parent().find('span.help-block').removeClass("hidden");
		}
	}else{
		$(email).parent().removeClass('has-error');
		$(email).parent().removeClass('has-success');
	}
}

 //Valida campo vacío
function validarVacio(metodo, mensaje_error){
    if ((metodo.value=="") || (/Seleccione/.test(metodo.value)) || (metodo.value ==0)){
        //En caso de que sea tipo FECHA porque tiene un parent mas
       /*if(/fec/.test(metodo.id)){
            $(metodo).parent().parent().find('span.help-block').html(mensaje_error);
            $(metodo).parent().parent().find('span.help-block').removeClass("hidden");
            $(metodo).parent().parent().addClass('has-error');
        }else{*/
        $(metodo).parent().find('span.help-block').html(mensaje_error);
        $(metodo).parent().find('span.help-block').removeClass("hidden");
        $(metodo).parent().addClass('has-error');//}
    }else{
        //En caso de que sea tipo FECHA porque tiene un parent mas
       /* if(/fec/.test(metodo.id)){
            if($(metodo).parent().parent().hasClass('has-error')){
                $(metodo).parent().parent().removeClass('has-error');
            }
            $(metodo).parent().parent().addClass('has-success');
            $(metodo).parent().parent().find('span.help-block').addClass("hidden");
        }else{*/
            if($(metodo).parent().hasClass('has-error')){
                $(metodo).parent().removeClass('has-error');
            }
            $(metodo).parent().addClass('has-success');
            $(metodo).parent().find('span.help-block').addClass("hidden");
        //}
    }
}

//Calcular Edad
function calcularYear(Fecha){
	var fields = Fecha.split('/');
	var dd		= fields[0];
	var mm		= fields[1];
	var yyyy	= fields[2];

	Fecha		= mm+'/'+dd+'/'+yyyy;

    fecha		= new Date(Fecha);
    hoy			= new Date();
    ed			= (hoy -fecha)/365/24/60/60/1000;
	ed			= ed.toFixed(2);
    if (ed >= 0)
     {return ed;}
     else{return null;}
}

//Calcular Edad
function calcularEdad(Fecha,input, Muerte = null){
	var fields = Fecha.split('/');
	var dd		= fields[0];
	var mm		= fields[1];
	var yyyy	= fields[2];
    var ed      = 0;
	Fecha		= mm+'/'+dd+'/'+yyyy;
    fecha		= new Date(Fecha);

    if(Muerte != null){
        muerte_fields   = Muerte.split('/');
        muerte_dd		= muerte_fields[0];
        muerte_mm		= muerte_fields[1];
        muerte_yyyy	    = muerte_fields[2];
	    Muerte		    = muerte_mm+'/'+muerte_dd+'/'+muerte_yyyy;
        muerte		    = new Date(Muerte);
        ed			    = parseInt((muerte -fecha)/365/24/60/60/1000);
    }else{
        hoy			    = new Date();
        ed			    = parseInt((hoy -fecha)/365/24/60/60/1000);
    }
    if (ed >= 0) {$(input).val(ed);}
	else {$(input).val("");}
}

//Mostrar DIV con checkbox
function showChk(mostrar,check,esconder1,esconder2) {
    if (document.getElementById(check).checked) {
        document.getElementById(mostrar).style.display='block';
        document.getElementById(esconder1).disabled='true';
        document.getElementById(esconder2).disabled='true';
    }
    else {
        document.getElementById(mostrar).style.display='none';
        document.getElementById(esconder1).removeAttribute('disabled');
        document.getElementById(esconder2).removeAttribute('disabled');
    }
}

//Limitar cantidad de caracteres
function limitarCaracteres(input, maximo, bo_modal=1) {
    lgth    = input.value.length;
    $('#count_'+input.id).text(maximo - lgth);
    if(lgth >= maximo){
        $('#count_'+input.id).text('0');
        $('#'+input.id).val(input.value.substring(0,maximo));
        if(bo_modal){
            xModal.danger('El máximo de caracteres a ingresar es de ' + maximo + '.', function(){
                xModal.closeAll();
            });
        }
    }
}

function validarFecha(input) {

    var allowBlank = true;
    var minYear = 1900;
    var maxYear = (new Date()).getFullYear();
    var errorMsg = "";

    // regular expression to match required date format
    re = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;

    if(input.value != '') {
      if(regs = input.value.match(re)) {
        if(regs[1] < 1 || regs[1] > 31) {
          errorMsg = "Valor Inválido para <b>Dia</b>: " + regs[1];
        } else if(regs[2] < 1 || regs[2] > 12) {
          errorMsg = "Valor Inválido para <b>Mes</b>: " + regs[2];
        } else if(regs[3] < minYear || regs[3] > maxYear) {
          errorMsg = "Valor Inválido para <b>Años</b>: " + regs[3] + " - Debe estar entre " + minYear + " y " + maxYear;
        }
      } else {
        errorMsg = "Formato de Fecha Inválido: " + input.value;
      }input
    } else if(!allowBlank) {
      errorMsg = "Campo vacio no permitido";
    }

    if(errorMsg != "") {
      xModal.danger(errorMsg);
      $(input).val('');
      return false;
    }

    return true;

}

/**
 * Restringe tipeo de caracteres diferentes a numeros y letras o espacio
 * @author Camila Figueroa 
 */
function soloNumerosYLetras(e) {
    var k;
    document.all ? k = e.keyCode : k = e.which;
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
}
/**
 *  Restringe tipeo de caracteres diferentes a letras o espacio
 * @author Camila Figueroa 
 */
function soloLetras(e) {
    var k;
    document.all ? k = e.keyCode : k = e.which;
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32);
}
