var table{$title};

$(document).ready( function() {
    table{$title} = initTable{$title}();
  
    $(".formulario-buscar").click(function(){
       var tabla = $(this).attr("data-rel");
       $("#" + tabla).dataTable().api()
                                 .draw(false);
    });
    
    $(".formulario-limpiar").click(function(){
        var tabla = $(this).attr("data-rel");
        var form = $("#form-busqueda-" + tabla);

        $(form).find(".element-search").val("");

        $("#" + tabla).dataTable().api()
                                 .draw(false);
    });
    
    $(".element-search").keypress(function (evt) {
        var charCode = evt.charCode || evt.keyCode;
        console.log(charCode);
        if (charCode  == 13) {
            $(this).parent().parent().parent().find(".formulario-buscar").trigger("click");
            return false;
        }
    });
});
 
function initTable{$title}() {
  return $('#{$title}').dataTable( {
        "processing": true,
        "serverSide": true,
        "stateSave": false,
        "searching": false,
        "language": {
                                "url": url_base + "static/js/plugins/DataTables-1.10.5/lang/es.json"
                            },
        "columns": [
                    {$columns}
                  ],
        "ajax": {
            "url": "{$base_url}/index.php/Grid/listar/",
            "type": "POST",
            "data": function ( d ) {
                d.name = "{$title}";
                {$params}
                d.format = "json";
            }
        }
    });
}