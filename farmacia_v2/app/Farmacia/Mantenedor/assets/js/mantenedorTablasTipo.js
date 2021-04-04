var MantenedorTablasTipo = {

    cargarGrillaTiposFormulario : function(filtros = null){

		let dataIn = null;

		if(filtros != null){
			dataIn = new FormData();
			let  getFiltros = filtros.serializeArray();
			$.each(getFiltros, function (index, campo) {
				dataIn.append(campo.name, campo.value);
			});
		}

		$.ajax({
			processData : false,
			cache       : false,
			async       : true,
			type        : 'post',
			dataType    : 'text',
			data        : dataIn,
			contentType : false,
			url: Base.getBaseUri() + "Farmacia/Mantenedor/TablasTipo/cargarGrillaTiposFormulario",
			error: function(xhr, textStatus, errorThrown){
				alert("Error");
			},
			success: function (response) {
				$("#dvGrilla").html(response);				
				$("#grilla").dataTable({
					"lengthMenu": [10, 20, 25, 50, 100],
					"pageLength": 10,
					"destroy" : true,
					"aaSorting": [],
					"deferRender": true,
					"language": {
						"url": Base.getBaseDir() + "/pub/js/plugins/DataTables/lang/"+Base.traduceTexto("es.json")
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
                    }],
				}).show(800);	
			}
		});
	},

	limpiarFiltros : function(){
		MantenedorTablasTipo.cargarGrillaTiposFormulario();
		$('#bo_activo').val('');
	},

	agregarTipo : function(btn){

		let getDtable = $('#dTable').val();
		let getDfield = $('#dField').val();
		let getDval   = $('#gl_nombre').val();

		if(getDtable == '' ||
		   getDfield == '' ||
		   getDval == ''){
			return false;
		}
		
		$.ajax({
			dataType	: "json",
			cache		: false,
			async		: true,
			data		: {
				'dTable': getDtable,
				'dField': getDfield,
				'dVal'  : getDval
			},
			type		: "post",
			url: Base.getBaseUri() + "Farmacia/Mantenedor/TablasTipo/procesarTipo",
			error: function(xhr, textStatus, errorThrown){
				alert("Error");
			},
			success: function (response) {
				if (response.correcto) {
					xModal.success(response.mensaje,function () {
						xModal.closeAll();
						location.href = window.location.href;
					});
				} else {
					xModal.info(data.mensaje,function(){});
				}
			}
		});
	},

	setEstado : function(id, operacion, dTable){
       
        if(id        == undefined || 
           operacion == undefined ||
           dTable    == undefined ){
            return false;
        }

        xModal.confirm('Estimado/a, ¿esta seguro de realizar el cambio de estado?',function () {
            let dataIn = new FormData();
            dataIn.append("id", id);
            dataIn.append("operacion", operacion);
            dataIn.append("dTable", dTable);
            
            $.ajax({
                dataType   : "json",
                cache      : false,
                async      : true,
                data       : dataIn,
                processData: false,
                contentType: false,
                type       : "post",
                url        : Base.getBaseUri() + "Farmacia/Mantenedor/TablasTipo/setEstado",
                error: function (xhr, textStatus, errorThrown) {
                    xModal.danger('Error', function () {});
                },
                success: function (response) {
                   
                    if(response.correcto){
                        xModal.success(response.mensaje,function () {
							xModal.closeAll();
							location.href = window.location.href;
                        });
                    }else{
                        xModal.danger(response.mensaje,function () {});
                    }
                }
            });
        });
    },

	
    
}