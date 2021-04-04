var idForm = $("#idForm").val();
// var id_region_tramitacion = $("#id_region_seremi_tramitacion").val();

var Direccion = {

	guardar : function(id_form, btn){

		// let e               = jQuery.Event( "click" );
        // let button_process  = buttonStartProcess($(btn), e);

        // let btnText = $("#btnGuardar").prop('disabled',true).html();
        let mensaje		= "";
		let params      = $("#"+id_form).serializeArray();

		params.push({"name": 'idForm',"value": idForm});

        // $("#btnGuardar").html('Guardando... <i class="fa fa-spin fa-spinner"></i>');

        if(mensaje !== ""){
            Modal.danger("Por favor revisar: <br><br>" + mensaje_validacion,function(){
                // $("#btnGuardar").html(btnText).prop('disabled', false);
				buttonEndProcess(button_process);
            });
        }else{

            $.ajax({
                url : Base.getBaseUri() + '_FuncionesGenerales/Direccion/guardarDireccion',
                type : 'post',
                dataType : 'json',
                data : params,
                success : function(response){
                    if(response.correcto){
						// if(response.html != ""){
						//
						// }
						// console.log(response);
                        Modal.success('Dirección ingresada correctamente', function() {
							Direccion.cargarGrilla(response.text_dir);
							if($("#panel_body_direccion" + response.text_dir).css('display') == 'none')ocultaMuestraVista('panel_body_direccion' + response.text_dir);
							Modal.closeAll();
						});

                    }else{
                        Modal.danger(response.mensaje, function(){
							// $("#btnGuardar").html(btnText).prop('disabled', false);
                            //location.reload();
                        });
                    }
                },
                error : function(response){
                    Modal.danger('Error en sistema. Intente nuevamente o comuníquese con Soporte', function(){
                        // $("#btnGuardar").html(btnText).prop('disabled', false);
                    });
                }
            })
        }
	},

    validar : function () {

		// validar form
    },

	setRegion : function(id = 0) {

		$("#id_region_direccion").val(id);
	},

	cargarComunas : function (id_region = id_region_tramitacion) {

		$.ajax({
            data : {idForm: formId},
            url : Base.getBaseUri() + '_FuncionesGenerales/Direccion/cargarGrilla',
            dataType : 'html',
            type : 'post',
            success : function(response){
                $("#div_grilla_direccion").html(response);
            }
        });
	},

	cargarGrilla : function(text_dir = '') {

		$.ajax({
            data : {idForm: formId,text_dir:text_dir},
            url : Base.getBaseUri() + '_FuncionesGenerales/Direccion/cargarGrilla',
            dataType : 'html',
            type : 'post',
            success : function(response){

				let multiDireccion = $('#bo_multiple_direccion' + text_dir).val();

				$("#div_grilla_direccion" + text_dir).html(response);

				if (multiDireccion == 0 || multiDireccion == undefined) {
                    if ($("#tabla_direccion" +  text_dir + " tr:last td").length > 1){
                        $('#btn_agregar_direccion' + text_dir).hide();
                    }else {
                        $('#btn_agregar_direccion' + text_dir).fadeIn();
                    }
                }
            }
        });
	},

	eliminar : function(key,text_dir = '') {
		//console.log(key);
		if (key != undefined) {

			$.ajax({
	            data : {idForm: formId, key : key, text_dir: text_dir},
	            url : Base.getBaseUri() + '_FuncionesGenerales/Direccion/eliminarDireccion',
	            dataType : 'json',
	            type : 'post',
	            success : function(response){
	                if (response.correcto) {
						Direccion.cargarGrilla(text_dir);
						//if(response.sinDirecciones) ocultaMuestraVista('panel_body_direccion' + text_dir);

                        let multiDireccion = $('#bo_multiple_direccion' + text_dir).val();
                        if (multiDireccion == 0 || multiDireccion == undefined) {
                            if ($("#tabla_direccion" +  text_dir +" tr:last td").length > 1){
                                $('#btn_agregar_direccion' + text_dir).hide();
                            }else {
                                $('#btn_agregar_direccion' + text_dir).fadeIn();
                            }
                        }
	                }
	            }
	        });
		}
	},

	toggleBtnAgregar : function() {

		let id_region = $("#id_seremi_tramitacion").val();

		if (id_region != 0) {
			$("#btn_agregar_direccion").prop('disabled', false);
		} else {
			$("#btn_agregar_direccion").prop('disabled', false);
		}
	},

};

// console.log(idForm);
