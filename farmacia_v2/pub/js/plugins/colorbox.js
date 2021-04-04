var Colorbox = {
    open : function(_url,_wide,callback){
        //var wide = 100;
        if(_wide !== undefined){
                wide = _wide;
        }
        


        if(callback && (typeof callback == "function")){
                var callback = callback;
        }else{
                var callback = function (){};
        }
        
        $.colorbox({iframe:true, 
            width:_wide, 
            height:'95%',
            scrolling:true,
            fixed:true,
            onClosed: callback(),										
            href: _url,
            escKey : false,
            overlayClose : false
        }); 
    },

    close : function(){
            parent.$.colorbox.close();
    }
};