var maestro_empresa = {
    init : function(){
        $("#btn_buscar").on('click',maestro_empresa.cargarGrilla);
	},
	
	crear			:	function(){
		setTimeout(() => {
			location.href	=	Base.getBaseUri() + "Farmacia/Farmacias/Empresa/creacionEmpresa";
		}, 300);
	},
    
    cargarGrilla : function(){
        formData = $("#formMaestroEmpresa").serializeArray();
        $.ajax({
            data : formData,
            url     : Base.getBaseUri() + "Farmacia/Farmacias/empresa/cargarGrilla",
            dataType : 'json',
            type : 'post',
            success : function(response){
                if(response.estado){
                    $("#contenedor_grilla_empresa").html(response.html);
                    $("#grillaEmpresa").dataTable({
                        "lengthMenu": [5, 10, 20, 25, 50, 100],
                        "pageLength": 10,
                        "destroy": true,
                        "aaSorting": [],
                        "deferRender": true,
                        "language": {
                            "url": Base.getBaseDir() + "pub/js/plugins/DataTables/lang/"+Base.traduceTexto("es.json")
                        },
                        dom: 'Bflrtip',
                        buttons: [{
                            extend: 'excelHtml5',
                            className: 'btn btn-default btn-xs',
                            text: '<i class=\"fa fa-download\"></i> '+Base.traduceTexto("Exportar a Excel"),
                            filename: 'Grilla',
                            exportOptions: {
                                modifier: {
                                    page: 'all'
                                }
                            }
                        }]
                    });
                }
            }
        });
    },

    editarEmpresa : function(id){
        
        $.ajax({
            url     : Base.getBaseUri() + "Farmacia/Farmacias/empresa/editarEmpresa",
            dataType : 'json',
            type : 'post',
            data : id,
            success : function(response){
                if(response.estado){
                    console.log(response.mensaje);
                    xModal.open(response.html,'Editar Empresa', 90, 'modal_editarEmpresa');
                }else{
                    xModal.danger(response.mensaje);
                }
            }
        });
    },
	guardarEdicion : function(){
		var	formData									=	$("#formCrearEmpresa").serializeArray();
		
		//	Originales
		var	original_farmacia_razon_social				=	$("#ori_farmacia_razon_social").val();
		var	original_farmacia_nombre_fantasia			=	$("#ori_farmacia_nombre_fantasia").val();
		var	original_farmacia_nombre_representante		=	$("#ori_farmacia_nombre_representante").val();
		var	original_farmacia_rut_representante_midas	=	$("#ori_farmacia_rut_representante_midas").val();
		var	original_farmacia_direccion					=	$("#ori_farmacia_direccion").val();
		var	original_fk_comuna							=	$("#ori_fk_comuna").val();
		var	original_farmacia_fono_codigo				=	$("#ori_farmacia_fono_codigo").val();
		var	original_farmacia_fono						=	$("#ori_farmacia_fono").val();
		var	original_id_caracter						=	$("#original_id_caracter").val();

		//	Formulario
		var	gl_nombre_fantasia							=	$("#gl_nombre_fantasia").val().trim();
		var	gl_razon_social								=	$("#gl_razon_social").val().trim();
		var	gl_nombres_representante					=	$("#gl_nombres_representante").val().trim();
		var	gl_apellidos_representante					=	$("#gl_apellidos_representante").val().trim();
		var	gl_rut_representante						=	$("#gl_rut_representante").val();
		var	gl_direccion								=	$("#gl_direccion").val().trim();
		var	id_comuna									=	$("#id_comuna").val();
		var	id_codigo_fono								=	$("#id_codigo_fono option:selected").data("codigo");
		var	gl_fono										=	$("#gl_fono").val().trim();
		var	id_caracter									=	$("#farmacia_caracter").val();
		
		var	error										=	Base.verificarRequeridos();
		var	bo_cambios									=	false;

		if(error	==	""){
			if(original_farmacia_razon_social				!=	gl_razon_social){
				bo_cambios									=	true;
			}
			if(original_farmacia_nombre_fantasia			!=	gl_nombre_fantasia){
				bo_cambios									=	true;
			}
			if(original_farmacia_nombre_representante		!=	gl_nombres_representante){
				bo_cambios									=	true;
			}
			if(original_farmacia_rut_representante_midas	!=	gl_rut_representante){
				bo_cambios									=	true;
			}
			if(original_farmacia_direccion					!=	gl_direccion){
				bo_cambios									=	true;
			}
			if(original_fk_comuna							!=	id_comuna){
				bo_cambios									=	true;
			}
			if(parseInt(original_farmacia_fono_codigo)		!=	id_codigo_fono){
				bo_cambios									=	true;
			}
			if(original_farmacia_fono						!=	gl_fono){
				bo_cambios									=	true;
			}
			if(original_id_caracter							!=	id_caracter){
				bo_cambios									=	true;
			}
		}

		if(error	!=	''){
			xModal.danger(error);
		}else{
			if(bo_cambios == true){
				$.ajax({
					url			:	Base.getBaseUri() + "Farmacia/Farmacias/empresa/edicionEmpresa",
					dataType	:	'json',
					type		:	'post',
					data		:	formData,
					error		:	function(){
						xModal.danger("Ha ocurrido un Error, si este persiste favor contactar a <b>Mesa de Ayuda</b>.");
					},
					success		:	function(response){
						if(response.correcto){
							xModal.success("Empresa <b>"+gl_razon_social+"</b> actualizado Exitosamente.", function () {
								xModal.closeAll();
								maestro_empresa.cargarGrilla();
							});
						}else{
							xModal.danger(response.mensaje);
						}
					}
				});
			}else{
				xModal.warning("Edición sin cambios detectados.");
			}
		}
	},

    // guardarEmpresa : function(){
    //     let formData  = $("#formCrearEmpresa").serializeArray();
    //     let msgError = '';

    //     if ($.trim($("#farmacia_caracter").val()) == "") {
    //         msgError += "- "+Base.traduceTexto("Caracter es Obligatorio")+". <br>";
    //     }

    //     if ($.trim($("#farmacia_rut_midas").val()) == "") {
    //         msgError += "- "+Base.traduceTexto("RUT es Obligatorio")+". <br>";
    //     }

    //     if ($.trim($("#farmacia_razon_social").val()) == "") {
    //         msgError += "- "+Base.traduceTexto("Raz&oacute;n Social es Obligatorio")+". <br>";
    //     }

    //     if ($.trim($("#farmacia_nombre_fantasia").val()) == "") {
    //         msgError += "- "+Base.traduceTexto("Nombre de Fantasia es Obligatorio")+". <br>";
    //     }

    //     if ($.trim($("#farmacia_direccion").val()) == "") {
    //         msgError += "- "+Base.traduceTexto("Direcci&oacute;n es Obligatorio")+". <br>";
    //     }

    //     if ($.trim($("#fk_region").val()) == "0") {
    //         msgError += "- "+Base.traduceTexto("Regi&oacute;n es Obligatorio")+". <br>";
    //     }

    //     if ($.trim($("#fk_comuna").val()) == "0") {
    //         msgError += "- "+Base.traduceTexto("Comuna es Obligatorio")+". <br>";
    //     }

    //     if ($.trim($("#farmacia_nombre_representante").val()) == "") {
    //         msgError += "- "+Base.traduceTexto("Nombre de Representante es Obligatorio")+". <br>";
    //     }

    //     if ($.trim($("#farmacia_rut_representante_midas").val()) == "") {
    //         msgError += "- "+Base.traduceTexto("RUT de Representante es Obligatorio")+". <br>";
    //     }

    //     if(msgError != ''){
    //         xModal.success(msgError);

    //     }else{
    //         $.ajax({
    //             url     : Base.getBaseUri() + "Farmacia/Farmacias/empresa/guardarEmpresa",
    //             dataType : 'json',
    //             type : 'post',
    //             data : formData,
    //             success : function(response){
    //                 if(response.resultado){
    //                     xModal.success(response.mensaje, function () {
    //                         xModal.closeAll();
    //                         maestro_empresa.cargarGrilla();
    //                     });
    //                 }else{
    //                     xModal.danger(response.mensaje);
    //                 }
    //             }
    //         });
    //     }
    // },

	guardarEmpresa : function(){
		let formData	=	$("#formCrearEmpresa").serializeArray();
		var	error		=	Base.verificarRequeridos();

		if(error	!=	''){
			xModal.danger(error);
		}else{
			$.ajax({
				url			:	Base.getBaseUri() + "Farmacia/Farmacias/empresa/guardarEmpresa",
				dataType	:	'json',
				type		:	'post',
				data		:	formData,
				error		:	function(){
					xModal.danger("Ha ocurrido un Error, si este persiste favor contactar a <b>Mesa de Ayuda</b>.");
				},
				success		:	function(response){
					if(response.resultado){
						xModal.success(response.mensaje, function () {
							xModal.closeAll();
							maestro_empresa.cargarGrilla();
						});
					}else{
						xModal.danger(response.mensaje);
					}
				}
			});
		}
	},
	cambiarEstado: function(token,estado,raz_soc){
		msg				=	"";

		if(estado){
			msg			=	"Se <b>deshabilitara</b> la Empresa <b>"+raz_soc+"</b>.";
		}else{
			msg			=	"Se <b>habilitará</b> la Empresa <b>"+raz_soc+"</b>.";
		}

		xModal.confirm(msg, function(){
			msg_error	=	"Ha ocurrido un error, si este persiste favor contactar con Mesa de <b>Ayuda</b>.";
			$.ajax({
				url			:	Base.getBaseUri()	+	"Farmacia/Farmacias/empresa/cambiarEstado",
				dataType	:	'json',
				type		:	'post',
				data		:	{
					gl_token	:	token,
					bo_estado	:	estado,
				},
				error		:	function(){
					xModal.danger($msg_error);
				},
				success		:	function(response){
					if(response.correcto){
						xModal.success(response.mensaje, function(){
							setTimeout(() => {
								maestro_empresa.cargarGrilla();
							}, 300);
						});
					}else{
						if(response.mensaje){
							msg_error	=	response.mensaje;
						}
						xModal.danger(msg_error);
					}
				}
			});
		});
	}
};
maestro_empresa.init();

function e_ed(e){
	token	=	$(e).closest('tr').data("token");
	if(token != ""){
		xModal.open(Base.getBaseUri()   +   'Farmacia/Farmacias/empresa/editarEmpresa/'+token, 'Editar Empresa', '90');
	}else{
		xModal.warning("Ha ocurrido un problema, si este persiste favor contactar con <b>Mesa de Ayuda</b>.");
	}
}

function e_est(e){
	token	=	$(e).closest('tr').data("token");
	estado	=	$(e).closest('tr').data("estado");
	raz_soc	=	$(e).closest('tr').data("raz_soc");

	if(token != ""){
		maestro_empresa.cambiarEstado(token,estado,raz_soc);
	}else{
		xModal.warning("Ha ocurrido un problema, si este persiste favor contactar con <b>Mesa de Ayuda</b>.");
	}
}
