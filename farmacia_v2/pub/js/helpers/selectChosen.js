
Base.loadScript({
    // css : Base.getBaseDir() + 'pub/template/plugins/chosen/chosen.min.css',
    css : Base.getBaseDir() + 'pub/template/plugins/chosen/chosen.bootstrap.css',
    js : Base.getBaseDir() + 'pub/template/plugins/chosen/chosen.jquery.min.js'
});

var selectChosen = {

    initChosen : function(combo){
        $('#' + combo).chosen({
            width:"100%",
            no_results_text : "No se encuentran coincidencias",
            placeholder_text_multiple : "Seleccione una o varios items...",
            placeholder_text_single : "Seleccione...",
            search_contains:true
        });

        //$("#" + combo).trigger('chosen:updated');
        this.updateChosen(combo);
    },


    updateChosen : function(combo){
        $("#" + combo).trigger('chosen:updated');
    }

}
