var Notificaciones = {

    cargarGrilla : function(){

		$.ajax({
			processData : false,
			cache       : false,
			async       : true,
			type        : 'post',
			dataType    : 'text',
			contentType : false,
			url: Base.getBaseUri() + "Notificaciones/Home/MisNotificaciones/cargarGrilla",
			error: function(xhr, textStatus, errorThrown){
				alert("Error");
			},
			success: function (response) {
				$("#dvGrillaNotificaciones").html(response);				
				$("#grillaNotificaciones").dataTable({
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

}
