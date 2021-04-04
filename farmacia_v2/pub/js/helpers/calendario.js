Base.loadScript({
    css : Base.getBaseDir() + 'pub/template/plugins/datepicker/datepicker3.css',
    js : [
        Base.getBaseDir() + 'pub/template/plugins/datepicker/bootstrap-datepicker.js',
        Base.getBaseDir() + 'pub/template/plugins/datepicker/locales/bootstrap-datepicker.es.js'
    ]
});

/*document.write('<link href="'+public_url + 'bower_components/admin-lte/plugins/datepicker/datepicker3.css" type="text/css" rel="stylesheet" />');
document.write('<script src="'+public_url + 'bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>');*/

var Calendario = {

    init : function(item, options){
        var item_calendario = undefined;
        if(item !== undefined){
            item_calendario = $("#"+item);
        }else{
            item_calendario = $(".datepicker");
        }

        item_calendario.datepicker({
            autoclose : true,
            language : 'es',
            weekStart : 1,
            format : "dd/mm/yyyy",
            todayHighlight: true
        });

    }

};

