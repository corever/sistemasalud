var url_site    = window.location.protocol + '//' + window.location.hostname + '//' + window.location.pathname;

$(document).ajaxStart(function() {
    $('#cargando').fadeIn();
}).ajaxStop(function() {
    $('#cargando').fadeOut();

});

var Base = {

    ERROR_GENERAL : 'Error en Sistema. Intente nuevamente o comuníquese con Mesa de Ayuda',

	btnText : '',
	/**
	 * Cambia apariencia de btn miestras se realiza una acción o procesamiento
	 * @param  {[type]} btn     [description]
	 * @param  {[type]} message [description]
	 * @return {[type]}         [description]
	 */
	buttonProccessStart : function(btn, message='Procesando'){
		var $this = this;
		$this.btnText = $(btn).attr('disabled',true).html();
		$(btn).html(message + '...<i class="fa fa-spin fa-spinner"></i>');
	},

	dataTable1 : function(nombreClase,bo_ordenAsc,columnDefs=null){

        var $this = this;
        let tipo_orden = "desc";

        if(typeof bo_ordenAsc != "undefined" && bo_ordenAsc){
            tipo_orden = "asc"
        }

		$("."+nombreClase).dataTable( {
					"sPaginationType": "full_numbers",
					"autoWidth": true,
                    "destroy"  : true,
					//"aaSorting": [[ 0, null]],
					"sDom": 'T<"clear">lfrtip',
						"bDeferRender": false,
						"oTableTools": {
								"sRowSelect": "multi",
								"sSwfPath": "js/swf/copy_csv_xls_pdf.swf",
								"aButtons": [ "xls" ]
                        },
                        "language": {
                            "url": $this.getBaseDir() + "pub/js/plugins/DataTables/lang/"+jsonTraductor.urlJsonDataTable
                        },
						/*"oLanguage": {
							"sEmptyTable": "Sin resultados",
							"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
							"sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
							"sInfoFiltered": "(De un total de _MAX_ registros)",
							"sLengthMenu": "_MENU_ resultados por p&aacute;gina",
							"sSearch": "Buscar:",
							"sZeroRecords": "Sin resultados",
							"oPaginate": {
								"sFirst": "Primera",
								"sLast": "&Uacute;ltima",
								"sNext": "Siguiente",
								"sPrevious": "Anterior"
							}
						},*/
                //"aoColumns" : aoColumns,
                columnDefs: columnDefs,
		} );
	},

	dataTable2 : function(nombreClase,orden=null,aoColumns=null){

        var aaSorting = null;

        if(orden == "asc"){
            aaSorting = [[ 0, "asc"]];
        }
        else if(orden == "desc"){
            aaSorting = [[ 0, "desc"]];
        }
        else{
            aaSorting = [];
        }

		$("."+nombreClase).dataTable( {
					"sPaginationType": "full_numbers",
					"autoWidth": true,
                    "destroy"  : true,
					"aaSorting": aaSorting,
					"sDom": 'T<"clear">lfrtip',
						"bDeferRender": false,
						"oTableTools": {
								"sRowSelect": "multi",
								"sSwfPath": "js/swf/copy_csv_xls_pdf.swf",
								"aButtons": [ "xls" ]
						},
						"language": {
                            "url": $this.getBaseDir() + "pub/js/plugins/DataTables/lang/"+jsonTraductor.urlJsonDataTable
                        },
						/*"oLanguage": {
							"sEmptyTable": "Sin resultados",
							"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
							"sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
							"sInfoFiltered": "(De un total de _MAX_ registros)",
							"sLengthMenu": "_MENU_ resultados por p&aacute;gina",
							"sSearch": "Buscar:",
							"sZeroRecords": "Sin resultados",
							"oPaginate": {
								"sFirst": "Primera",
								"sLast": "&Uacute;ltima",
								"sNext": "Siguiente",
								"sPrevious": "Anterior"
							}
						},*/
                "aoColumns" : aoColumns,
                //columnDefs: columnDefs,
		} );
	},

	buttonProccessEnd : function(btn){
		var $this = this;
		$(btn).html($this.btnText).attr('disabled',false);
	},


    loadScript : function(source, callback) {

	    if(source.css !== undefined){
            console.log("1");
            if(typeof source.css === 'string'){
            console.log("11");
            document.write('<link href="'+ source.css + '?' + Math.random() + '" type="text/css" rel="stylesheet" />');
            }else if(typeof source.css === 'object'){
            console.log("111");
            var scripts = source.css;
                var totalScripts = scripts.length;
                for(var i = 0; i < totalScripts; i++){
                    document.write('<link href="'+ scripts[i] + '?' + Math.random() + '" type="text/css" rel="stylesheet" />');
                }
            }else{
                console.log('Error con fichero ' . source.css);
            }
        }

	    if(source.js !== undefined){
            console.log("2");

            if(typeof source.js === 'string'){
            console.log("22");
            document.write('<script src="'+source.js + '?' + Math.random() + '" type="text/javascript"></script>');
            }else if(typeof source.js === 'object'){
            console.log("222");
            var scripts = source.js;
                var totalScripts = scripts.length;
                for(var i = 0; i < totalScripts; i++){
                    document.write('<script src="'+ scripts[i] + '?' + Math.random() + '" type="text/javascript"></script>');
                }
            }else{
                console.log('Error con fichero ' . source.js);
            }

        }

    },

    /**
     * Obtener directorio base de ejecucoin web
     * @returns {string}
     */
    getBaseDir__ : function(){
        var host = window.location.host;
        var protocol = window.location.protocol;
        var url = window.location.pathname;
        
        url = url.split("index.php");
        
        if(url[0] !== undefined){
            var base_uri = protocol + "//" + host + url[0];
        }else{
            var base_uri = protocol + "//" + host ;
        }
        return base_uri;
    },

    /**
     * Obtener directorio base de ejecucoin web
     * @returns {string}
     */
    getBaseDir: function(){
        return listConstantes.BASE_URI;
    },

    getBaseDirTramite : function(){
        var host		= window.location.host;
        var protocol	= window.location.protocol;
        var url			= window.location.pathname.split("index.php");
        var dir			= url[1] !== undefined ? url[1].split("/") : [''];

		carpeta			= dir[1] !== undefined ? dir[1] + '/' : [''];
        if(url[0] !== undefined){
            var base_uri = protocol + "//" + host + url[0] + "index.php/" + carpeta;
        }else{
            var base_uri = protocol + "//" + host ;
        }

        return base_uri;
    },

    /**
     * Obtener url base de ejecucion
     * @returns {string}
     */
    getBaseUri__ : function(){
        var host = window.location.host;
        var protocol = window.location.protocol;
        var url = window.location.pathname; 
        url = url.split("index.php");
        if(url[0] !== undefined){
            var base_uri = protocol + "//" + host + url[0];
        }else{
            var base_uri = protocol + "//" + host ;
        }
        // return base_uri + 'index.php/';
        return base_uri;
    },

    /**
     * Obtener url base de ejecucion
     * @returns {string}
     */
    getBaseUri : function(){
        return listConstantes.BASE_URI;
    },


    /**
     * Validar formato de email
     * @param email
     * @returns {boolean}
     */
    validarEmail : function(email){
        if(email === "")
            return false;

        var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email) ? true : false;
    }, 

    loadingStart : function(contenedor){
        $("#" + contenedor).append('<div class="col-xs-12 text-center" id="loading"><i class="fa fa-spin fa-spinner fa-5x"></i></div>');
    },

    loadingStop : function(func){
        if(typeof func === 'function'){
            $("#loading").fadeOut(func());
        }else{
            $("#loading").fadeOut();
        }
    },

    desactivarReemplazoUsuario : function(){
        
        $.post(Base.getBaseUri() + "_FuncionesGenerales/Usuario/desactivarReemplazoUsuario",{},function(response){
            
            if(response.correcto){ 
                alert(response.mensaje) 
                //Modal.success(response.mensaje, function(){});
                location.href = response.url;
            }else{          
                alert(response.mensaje);
                //Modal.danger(response.mensaje, function(){});
            }

        },'json');
    },
    
    cerrarModalRevisarSession : function(){
        var idForm = $("#idForm").val();
        $.ajax({
            dataType	: "json",
            cache		: false,
            async		: true,
            data		: {idForm:idForm},
            type		: "post",
            url			: Base.getBaseUri() + "_FuncionesGenerales/Funciones/unsetFormularioSession", 
            error		: function(xhr, textStatus, errorThrown){
                            //console.log('Error al Actualizar Vista Previa.');
            },
            success		: function(data){
                
            }
        });
    },
    
    entrarModulo: function (modulo) {
        var url         = $(modulo).data("url");
        var id_modulo   = $(modulo).data("id_modulo");
        
        $.ajax({
            dataType	: "json",
            cache		: false,
            async		: true,
            data		: {id_modulo:id_modulo},
            type		: "post",
            url			: Base.getBaseUri() + "Farmacia/Home/MisSistemas/entrarModulo",
            error		: function(xhr, textStatus, errorThrown){
                xModal.info('Error al cargar grilla.');
            },
            success		: function(data){
                location.href = Base.getBaseUri() + url;
            }
        });
    },

    cambioIdioma: function (id_idioma){
        
        var htmlSeleccionado    = $("#idioma_lista_"+id_idioma).html();
        
        $("#idiomaSeleccionado").html(htmlSeleccionado);
        $("#idiomaSeleccionado").data("idioma",id_idioma);
        $("#idiomaSeleccionado").attr("data-idioma",id_idioma);

        $.ajax({
            dataType	: "json",
            cache		: false,
            async		: true,
            data		: {id_idioma:id_idioma},
            type		: "post",
            url			: Base.getBaseUri() + "_FuncionesGenerales/Traductor/Traductor/traducir",
            error		: function(xhr, textStatus, errorThrown){
                xModal.info('Error al traducir.');
            },
            success		: function(data){
                if(data.correcto){
                    //Traducir
                    jsonTraductor = data.jsonTraductor;
                    location.reload();
                }
            }
        });
        

    },

    traduceTexto: function(texto){

        let retorno = (jsonTraductorEsp[texto])?jsonTraductorEsp[texto]:texto;

        if(jsonTraductor[texto]){
            retorno = jsonTraductor[texto];
        }

        return retorno;

	},
	
	verificarRequeridos :   function(filter="required"){
		var error				=	"";
		//cargo listado de inputs que sean required
		var required			=	$('input,textarea,select').filter('['+filter+']').filter(function() { return (this.value == "" || this.value == 0); });
		var completados			=	$('input,textarea,select').filter('['+filter+']').filter(function() { return (this.value != ""	&& this.value !=	"0"); });
		// var	marca				=	' <span class="text-red">(*)</span>';
		var	marca				=	'';
		
		//verifico si existen campos required
		if(required.length > 0) {
			var labels	=	[];
			//si existen, recorro cada uno de los inputs required
			required.each((index,item)=>{
				//verifico que el item esté visible
				if($("#" + item.id).is(":visible")){
					var label = $("label[for='" + item.id + "']")[0];
					html = $("label[for='" + item.id + "']").prop('outerHTML');
					// if(html.indexOf(marca) == -1){
					// 	$("label[for='" + item.id + "']").html(html+marca);
					// 	// label.textContent = label.textContent+marca
					// }
					//verifico si ya agregué el label del input al listado de inputs incompletos
					if(!labels.includes(label.textContent)){
						//si no se encuentra, lo agrego
						labels.push(label.textContent.replace('(*)',''))
					}
				}
			})
			//recorro todos los labels de los inputs incompletos, y armo el listado de errores
			labels.forEach((label)=>{
				error	+=	'<b>-</b> El campo <b>'+label.trim()+'</b> es obligatorio.<br/>';	
			})
		}

		// if(completados.length > 0) {
		// 	//si existen, recorro cada uno de los inputs required
		// 	completados.each((index,item)=>{
		// 		//verifico que el item esté visible
		// 		if($("#" + item.id).is(":visible")){
		// 			html = $("label[for='" + item.id + "']").prop('outerHTML');
		// 			if(html.indexOf(marca) >= 0){
		// 				$("label[for='" + item.id + "']").html(html.replace(marca,''));
		// 			}
		// 		}
		// 	})
		// }

		return error;
	},

}; 

//onkeyup="this.value=convierteEnRut(this.value)"
function convierteEnRut(valor){
    var cont = 0, tmp_valor = "", i=0, valor2="";
    for(i=0;i<valor.length;i++){
            if(valor.charAt(i) == "0" || valor.charAt(i) == "1" || valor.charAt(i) == "2" || valor.charAt(i) == "3" || valor.charAt(i) == "4" || valor.charAt(i) == "5" || valor.charAt(i) == "6" || valor.charAt(i) == "7" || valor.charAt(i) == "8" || valor.charAt(i) == "9" || valor.charAt(i) == "k" || valor.charAt(i) == "K"){
                    if(valor.charAt(0) != "0" && valor.charAt(0) != "k" && valor.charAt(0) != "K"){
                            valor2 = valor2 + valor.charAt(i);
                    }
            }
    }
    for(i=valor2.length-1;i>=0;i--){
            if(cont==1){
                    tmp_valor = "-" + tmp_valor;
            }
            tmp_valor = valor2.charAt(i) + tmp_valor;
            cont++;
    }
    return tmp_valor;
}

function cargaSelectModulo(id, valor){
    $("#id_modulo").load(Base.getBaseDir() + 'index.php/Solicitudes/FormularioSolicitud/getModulos/' + id + '/' + valor);
    $("#id_sub").empty().append('<option value="">Seleccione Subclasificación</option>');
    $("#id_referente_negocio").empty().append('<option value="">Seleccione Referente</option>');
    $("#id_hito").empty().append('<option value="0">Sin hito asociado</option>');
    cargaReferenteContrato(id);
}

function cargaSelectSubModulo(id, valor){
    $("#id_sub").load(Base.getBaseDir() + 'index.php/Solicitudes/FormularioSolicitud/getSubModulos/' + id + '/' + valor);
    cargaSelectReferentesModulo(id);
    cargaSelectHitos(id);
}

function cargaSelectReferentesModulo(id, valor){
    $("#id_referente_negocio").load(Base.getBaseDir() + 'index.php/Solicitudes/FormularioSolicitud/getReferentesModulos/' + id + '/' + valor);
}
function cargaSelectReferentesSubModulo(id, valor){
    $("#id_referente_negocio").load(Base.getBaseDir() + 'index.php/Solicitudes/FormularioSolicitud/getReferentesSubModulos/' + id + '/' + valor);
}
function cargaSelectHitos(id, valor){
    $("#id_hito").load(Base.getBaseDir() + 'index.php/Solicitudes/FormularioSolicitud/getHito/' + id + '/' + valor);
}
function cargaReferenteContrato(id, valor){
    $("#referente_contrato").load(Base.getBaseDir() + 'index.php/Solicitudes/FormularioSolicitud/getReferenteContrato/' + id + '/' + valor);
 }
 function cambiaPerfil(id_perfil){
    var url = Base.getBaseUri() + 'Usuarios/Usuario/cambiaPerfil/'+id_perfil;
    window.location.href = url;

 }
/*
 $(document).ready(function() {
    //boton para exportar tabla a excel
    $(".buttons-excel").html("<i class=\"fa fa-download\"></i> Exportar a EXCEL");
    $(".buttons-excel").removeClass("dt-button");
    $(".buttons-excel").addClass("btn btn-default btn-xs btn-excel");
    
});¨*/

function btnExcelGrilla(){
    //boton para exportar tabla a excel
    setTimeout(function(){
        $(".buttons-excel").html("<i class=\"fa fa-download\"></i> Exportar a EXCEL");
        $(".buttons-excel").removeClass("dt-button");
        $(".buttons-excel").addClass("btn btn-primary btn-xs btn-excel");
    },500);
}

function Valida_Rut( rut ){
    var intlargo = rut.value;
    var tmpstr = "";
    if (intlargo.length> 0)
    {
		var re = /^[1-9]{1}[0-9]{0,7}\-([0-9]|[kK]){1}$/;
        crut = rut.value;

		if(!re.test(crut)){
			if(typeof Modal != "undefined"){
                Modal.danger('El RUT ingresado no es válido');
            }
            if(typeof xModal != "undefined"){
                xModal.danger('El RUT ingresado no es válido');
            }
			$(rut).parent().addClass('has-error');
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

        if ( largo <3 )
        {   
            if(typeof Modal != "undefined"){
                Modal.danger('El RUT ingresado no es válido (muy corto)');
            }
            if(typeof xModal != "undefined"){
                xModal.danger('El RUT ingresado no es válido (muy corto)');
            }
			$(rut).parent().addClass('has-error');
            return false;
        }else if(largo > 9){
			if(typeof Modal != "undefined"){
                Modal.danger('El RUT ingresado no es válido (muy largo)');
            }
            if(typeof xModal != "undefined"){
                xModal.danger('El RUT ingresado no es válido (muy largo)');
            }
			$(rut).parent().addClass('has-error');
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
            if(typeof Modal != "undefined"){
                if(typeof Modal != "undefined"){
                    Modal.danger('El RUT ingresado no es válido (muy largo)');
                }
                if(typeof xModal != "undefined"){
                    xModal.danger('El RUT ingresado no es válido (muy largo)');
                }
            }
            if(typeof xModal != "undefined"){
                if(typeof Modal != "undefined"){
                    Modal.danger('El RUT ingresado no es válido (muy largo)');
                }
                if(typeof xModal != "undefined"){
                    xModal.danger('El RUT ingresado no es válido (muy largo)');
                }
            }
		
			$(rut).parent().addClass('has-error');
            return false;
        }

		if ($(rut).parent().hasClass('has-error')) {
			$(rut).parent().removeClass('has-error');
		}
		$(rut).parent().addClass('has-success');
        return true;
    }

}
    
/**
 * Boquea el boton despues de hacer click
 * @param {type} boton
 * @param {type} e
 * @returns {buttonStartProcess.retorno}
 */
function buttonStartProcess(boton, e) {
    e.preventDefault();
    $(boton).prop('disabled', true);

    var clase_boton = $(boton).children("i").attr("class");
    $(boton).children("i").attr("class", "fas fa-redo fa-spin");

    var retorno = {"boton": boton, "clase": clase_boton};

    return retorno;
}

/**
 * Desbloquea el boton
 * @param {type} retorno
 * @returns {undefined}
 */
function buttonEndProcess(retorno) {
    $(retorno.boton).prop('disabled', false);
    $(retorno.boton).children("i").attr("class", retorno.clase);
} 

$("#btnVolverUsuario").on("click",function(){
        btn	            = this;
        btn.disabled    = true;
        var btnTexto    = $(btn).html();
        $(btn).html('Cambiando...');

        $.ajax({
            dataType	: "json",
            cache		: false,
            async		: true,
            type		: "post",
            url			: Base.getBaseUri() + "Farmacia/Usuario/Login/volverUsuario", 
            error		: function(xhr, textStatus, errorThrown){
                            xModal.info('Error al cambiar de usuario.');
            },
            success		: function(data){
                            if(data.correcto){
                                xModal.success('Se procederá con el Cambio de Usuario',function () {
                                    location.href = Base.getBaseUri() + 'Farmacia/Home/MisSistemas';
                                });
                            }else{
                                xModal.info(data.mensaje);
                            }
            }
        });

        $(btn).html(btnTexto).attr('disabled', false);
});

function replaceLast(x, y, z){
  var a = x.split("");
  a[x.lastIndexOf(y)] = z;
  return a.join("");
}

var dataOptions = {
	fnInitComplete: function(oSettings, json) {
      $(this).fadeIn("slow");
    },	
    language: {
		"url": Base.getBaseUri() + "/pub/js/plugins/DataTables/lang/es.json"
    },
    fnDrawCallback: function (oSettings) {
        $(this).fadeIn("slow");
    },
	//dom: 'Bflrtip',
	"dom": '<"pull-left"f><"pull-right"l>tip',
    buttons: [{
        extend: 'excelHtml5',
        text: 'Exportar a Excel',
        filename: 'Fiscalizaciones',
        exportOptions: {
			columns: ".toExport",
			// columns: [':visible :not(:first-child)'],
            modifier: {
                page: 'all'
            }
		},
		className:'btn btn-primary btn-xs'		
	}],
	"scrollX": true,
	fixedColumns:   true,
	fixedColumns:   {
		rightColumns: 0,
		leftColumns: 2
	},

};

function colapsarDivs(id){
    if($("#"+id).is(':hidden')){        
        $("#"+id).fadeIn();
        $("#i-"+id).removeClass('fa fa-chevron-up').addClass('fa fa-chevron-down');
    }else{
        $("#"+id).fadeOut();
        $("#i-"+id).removeClass('fa fa-chevron-down').addClass('fa fa-chevron-up');
    }
}