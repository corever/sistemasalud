/*
Base.loadScript({
    css :   [Base.getBaseDir() + 'pub/template/plugins/datatables/dataTables.bootstrap.css'],
    js : [
        Base.getBaseDir() + 'pub/template/plugins/datatables/jquery.dataTables.min.js',
        Base.getBaseDir() + 'pub/template/plugins/datatables/dataTables.bootstrap.min.js',
        Base.getBaseDir() + 'pub/template/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js',
        Base.getBaseDir() + 'pub/template/plugins/datatables/plugin/JSZip/jszip.min.js',
        Base.getBaseDir() + 'pub/template/plugins/datatables/plugin/buttons/buttons.html5.min.js',

        ]
});
*/

Base.loadScript({
    css :   [],
    js  : []
});

/*
        Base.getBaseDir() + 'pub/template/plugins/datatables/plugin/pdfmake/pdfmake.min.js',
        Base.getBaseDir() + 'pub/template/plugins/datatables/plugin/pdfmake/vfs_fonts.js'

*/

var Tables = {

    initTable : function(tabla, options){

        var buttons		= [];
        var columnas	= ':visible';
        var titulo		= 'Encuestas';

        if($("#"+tabla).attr('data-row')) {
            var filas = parseInt($("#"+tabla).attr("data-row"));
        } else {
            var filas = 10;
        }
        
        if($("#"+tabla).attr('data-exportar')) {
            columnas    = $("#"+tabla).attr("data-exportar");
        }
        if($("#"+tabla).attr('data-titulo')) {
            titulo        += ' - '+$("#"+tabla).attr("data-titulo");
        }        

        if($("#"+tabla).hasClass("export")){
            buttons = [
                {
                    extend: 'excelHtml5',
                    text: 'Exportar a Excel',
                    filename: titulo,
                    title: titulo,
                    exportOptions: {
                        columns: [columnas],
                        modifier: {
                            page: 'all'
                        }
                    }
                }
            ];
        }

        var dataOptions = {
            "lengthMenu": [5,10, 20, 25, 50, 100],
            "pageLength": filas,
            "destroy" : true,
            "aaSorting": [],
            "deferRender": true,
			stateSave: true,			
            dom: 'Blfrtip',
            buttons: buttons,
            language:
                {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }

        };


        if(options !== undefined && (typeof options === 'object')){
            dataOptions.push(options);
        }

        var table = $("#" + tabla).dataTable(dataOptions);
		$("#" + tabla).fadeIn('3000');

    }

};
