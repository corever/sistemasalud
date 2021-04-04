Base.loadScript({
    css : Base.getBaseDir() + 'pub/template/plugins/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css',
    js: Base.getBaseDir() + 'pub/template/plugins/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js'
});


var Modal = {

    /**
     * Modal para dialogo de confirmacion
     * @param message Mensaje o texto a mostrar
     * @param callback_ok funcion a ejecutar al apretar SI
     * @param callback_no funcion a ejecutar al apretar NO
     */
    confirm : function(message, callback_ok, callback_no){
        BootstrapDialog.confirm({
            title: 'Confirmación',
            message: message,
            type: BootstrapDialog.TYPE_WARNING,
            btnCancelLabel: 'No',
            btnCancelClass : 'btn-flat btn-default',
            btnOKLabel: 'Si',
            btnOKClass: 'btn-flat btn-warning',
            callback: function(result) {
                if(result) {
                    if(typeof callback_ok === 'function'){
                        callback_ok();
                    }
                }else {
                    if(typeof callback_no === 'function'){
                        callback_no();
                    }
                }
            }

        })
    },

    /**
     * Modal para mostrar mensajes de error
     * @param message mensaje a mostrar
     * @param callback funcion a ejecutar
     */
    danger : function(message, callback){
        BootstrapDialog.alert({
            title: 'Error',
            message: message,
            type: BootstrapDialog.TYPE_DANGER,
            buttonLabel: 'Aceptar',
            callback: function(result) {
                if(typeof callback === 'function'){
                    callback();
                }

            }
        });
    },

    /**
     * Modal para mostrar mensajes de exito
     * @param message
     * @param callback
     */
    success : function(message, callback){
        BootstrapDialog.alert({
            title: 'Éxito',
            message: message,
            type: BootstrapDialog.TYPE_SUCCESS,
            buttonLabel: 'Aceptar',
            callback: function(result) {
                if(typeof callback === 'function'){
                    callback();
                }

            }
        });
    },

    /**
     * Modal para mostrar mensajes de información
     * @param message
     * @param callback
     */
    info : function(message, callback){
        BootstrapDialog.alert({
            title: 'Informaci&oacute;n',
            message: message,
            type: BootstrapDialog.TYPE_INFO,
            buttonLabel: 'Aceptar',
            callback: function(result) {
                if(typeof callback === 'function'){
                    callback();
                }

            }
        });
    },

    /**
     * Modal para abrir pop up con otra vista o pagina
     * @param url Url de la vista a cargar
     * @param title Titulo para el modal
     * @param buttons Arreglo de botones de acciones para el modal. Si no se especifican, se crea solo el boton Cerrar modal
     * @param size Tamaño del modal. Puede ser 'sm' para pequeño o 'lg' para ancho
     */
    open : function(url,title,size){

        var modal_size = BootstrapDialog.SIZE_NORMAL;
        if(size == 'sm'){
            modal_size = BootstrapDialog.SIZE_SMALL;
        }else if(size == 'lg'){
            modal_size = BootstrapDialog.SIZE_WIDE;
        }


        BootstrapDialog.show({
            size : modal_size,
            closable : true,
			closeByBackdrop: false,
            closeByKeyboard: false,
            title : title,
            message: $('<div></div>').load(url),
            buttons : [{
                label: 'Cerrar',
                cssClass: 'btn-default btn-flat',
                action: function(dialogItself){
                    dialogItself.close();
                }
            }]
        });
    },

	/**
     * Modal para abrir pop up con otra vista o pagina SIN CERRAR
     * @param url Url de la vista a cargar
     * @param title Titulo para el modal
     * @param size Tamaño del modal. Puede ser 'sm' para pequeño o 'lg' para ancho
     */
	openSC : function(url,title,size){

        var modal_size = BootstrapDialog.SIZE_NORMAL;
        if(size == 'sm'){
            modal_size = BootstrapDialog.SIZE_SMALL;
        }else if(size == 'lg'){
            modal_size = BootstrapDialog.SIZE_WIDE;
        }


        BootstrapDialog.show({
            size : modal_size,
            closable : true,
			closeByBackdrop: false,
            closeByKeyboard: false,
            title : title,
            message: $('<div></div>').load(url)
        });
    },

    openSuccessCancel : function(url,title,size,txtBtnSuccess,txtBtnCancel,iconsuccess,iconcancel){
        var modal_size   = BootstrapDialog.SIZE_NORMAL;
        var icono_ok     = 'ok';
        var icono_cancel = 'remove';

        if(size == 'sm'){
            modal_size = BootstrapDialog.SIZE_SMALL;
        }else if(size == 'lg'){
            modal_size = BootstrapDialog.SIZE_WIDE;
        }

        if(typeof txtBtnSuccess == "undefined" || txtBtnSuccess == "") txtBtnSuccess = "Aceptar";        
        if(typeof txtBtnCancel == "undefined" || txtBtnCancel == "")    txtBtnCancel = "Cancelar";
        if(typeof iconsuccess != "undefined" && iconsuccess != "")          icono_ok = iconsuccess;
        if(typeof iconsuccess != "undefined" && iconsuccess != "")      icono_cancel = iconcancel;

        BootstrapDialog.show({
            size : modal_size,
            closable : true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            title : title,
            message: $('<div></div>').load(url),
            buttons : [{
                label: txtBtnSuccess,
                icon: 'glyphicon glyphicon-' + icono_ok,
                id: 'btn_success',
                cssClass: 'btn-success btn-flat'                
            },
            {
                label: txtBtnCancel,
                icon: 'glyphicon glyphicon-' + icono_cancel,
                id: 'btn_cancel',
                cssClass: 'btn-danger btn-flat',
                action: function(dialogItself){
                    dialogItself.close();
                }
            }]
        });        
    },

    /**
     * Cerrar todos los modales abiertos
     */
    closeAll : function(){
        BootstrapDialog.closeAll();
    },

    closeFront : function(){
        i = 0;
        $.each(BootstrapDialog.dialogs,function(id,dialog){
            i++;
            if(Object.keys(BootstrapDialog.dialogs).length > 1){
                if((Object.keys(BootstrapDialog.dialogs).length - 1) == i){                    
                    dialog.close();                    
                }
            }else{
                if((Object.keys(BootstrapDialog.dialogs).length) == i){                   
                    dialog.close();                    
                }

            }

        });
    },


    openIframe : function(url,title,size, height){

        var modal_size = BootstrapDialog.SIZE_NORMAL;
        if(size == 'sm'){
            modal_size = BootstrapDialog.SIZE_SMALL;
        }else if(size == 'lg'){
            modal_size = BootstrapDialog.SIZE_WIDE;
        }

        var _height = '90%';
        if (height !== undefined) {
            _height = height;
        }
        var _cssClass = ''

        BootstrapDialog.show({
            size : modal_size,
            closable : true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            title : title,
            message: $('<div style="height:' + _height +'"></div>').html('<iframe src="' + url + '" frameborder="0" style="width:100%"></iframe>'),
            buttons : [{
                label: 'Cerrar',
                cssClass: 'btn-default btn-flat',
                action: function(dialogItself){
                    dialogItself.close();
                }
            }]
        });
    },


}