var FormDinamico = {
    clearInputsDiv: function(id){
        $("#"+id).find(':input').each(function() {
            switch(this.type) {
                case 'password':
                case 'text':
                case 'textarea':
                case 'file':
                case 'select-one':
                case 'select-multiple':
                case 'date':
                case 'number':
                case 'tel':
                case 'email':
                    jQuery(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
                    break;
            }
          });
    },
    validarMostrarDiv: function(input, validacion, div, valor_esperado = null){
        if(validacion == 'checked'){
            if(valor_esperado == false){
                if(!$(input).is(':checked')){
                    $("#"+div).show('medium');
                }else{
                    $("#"+div).hide('medium');
                    FormDinamico.clearInputsDiv(div);
                }
            }
            else{
                if($(input).is(':checked')){
                    $("#"+div).show('medium');
                }else{
                    $("#"+div).hide('medium');
                    FormDinamico.clearInputsDiv(div);
                }
            }
        }
        else{
            if($(input).prop('multiple')){
                var opciones_seleccionadas = $(input).val();
                var bo_coinsidencia = false;
                opciones_seleccionadas.forEach((opcion)=>{
                    var string_validacion = valor_esperado+validacion+opcion;
                    if(string_validacion.endsWith(validacion)){
                        bo_coinsidencia = true;
                    }
                    else if(eval(string_validacion)){
                        bo_coinsidencia = true;
                    }
                });
                if(bo_coinsidencia){
                    $("#"+div).show('medium');
                }else{
                    $("#"+div).hide('medium');
                    FormDinamico.clearInputsDiv(div);
                }
            }else{
                if(Array.isArray(valor_esperado)){
                    valor_esperado.forEach((opcion)=>{
                        var string_validacion = valor_esperado+validacion+opcion;
                        if(string_validacion.endsWith(validacion)){
                            bo_coinsidencia = true;
                        }
                        else if(eval(string_validacion)){
                            bo_coinsidencia = true;
                        }
                    });
                    if(bo_coinsidencia){
                        $("#"+div).show('medium');
                    }else{
                        $("#"+div).hide('medium');
                        FormDinamico.clearInputsDiv(div);
                    }
                }
                else{
                    var string_validacion = valor_esperado+validacion+$(input).val();
                    if(string_validacion.endsWith(validacion)){
                        $("#"+div).hide('medium');
                        FormDinamico.clearInputsDiv(div);
                    }
                    else if(eval(string_validacion)){
                        $("#"+div).show('medium');
                    }
                    else{
                        $("#"+div).hide('medium');
                        FormDinamico.clearInputsDiv(div);
                    }
                }
            }
        }
    },

    validarRequire(id = null){
        var error = '';
        //cargo listado de inputs que sean required
        if(id != null){
            var required = $("#"+id).find("input,select,textarea").filter('[required]:empty').filter(function() { return this.value == ""; });
        }
        else{
            var required = $('input,textarea,select').filter('[required]:empty').filter(function() { return this.value == ""; });
        }
        console.log(required)
        
        //verifico si existen campos required
        if(required.length > 0) {
            var labels = [];
            //si existen, recorro cada uno de los inputs required
            required.each((index,item)=>{                
                //verifico que el item esté visible
                if($("#" + item.id).is(":visible")){
                    var label = $("label[for='" + item.id + "']")[0];
                    var labelTextContent = label.textContent.replace('(*)', '').trim();
                    //verifico si ya agregué el label del input al listado de inputs incompletos
                    if(!labels.includes(labelTextContent)){
                        //si no se encuentra, lo agrego
                        console.log(labelTextContent)
                        console.log(labels)
                        labels.push(labelTextContent)
                    }
                }
            })
            //recorro todos los labels de los inputs incompletos, y armo el listado de errores
            labels.forEach((label)=>{
                error += '- El campo '+label+' es obligatorio<br/>';    
            })
        }
        /*if(error != ""){
            xModal.danger(error, function(){
                $(btn).attr('disabled',false).html(btnText);
            });
        }*/
        return error;
    },

    setValue(id, value, type){
        switch(type) {
            case 'password':
            case 'text':
            case 'textarea':
            case 'file':
            case 'select-one':
            case 'select-multiple':
            case 'date':
            case 'number':
            case 'tel':
            case 'email':
                $("#"+id).val(value).trigger("change");
                break;
            case 'checkbox':
            case 'radio':
                if(value == 1){
                    $("#"+id).prop( "checked", true ).trigger("change");
                }
                else{
                    $("#"+id).prop( "checked", false ).trigger("change");
                }
                break;
        }
    },

    procesar(id){
        //console.log($("#"+id).serializeObject());
        console.log($("#"+id).serializeFullArray());
    }
}; 

$(document).ready(function() {
    $.fn.serializeObject = function()
    {
        var o = {};
        var disabled = $(this).find('select:disabled').removeAttr('disabled');
        var a = this.serializeArray();
        disabled.attr('disabled','disabled');
        if(a.length == 0){
            var disabled = $(this).find('select:disabled').removeAttr('disabled');
            a = $(this).find("input,select,textarea").serializeArray();
            console.log($(this).find("input,select,textarea").serializeArray())
            disabled.attr('disabled','disabled');
        }
        $.each(a, function() {
            var name = this.name.replace(/\[\]/g, "");
            if (o[name] !== undefined) {
                if (!o[name].push) {
                    o[name] = [o[name]];
                }
                o[name].push(this.value || '');
            } else {
                if(this.name.includes("[]")){
                    o[name] = [this.value] || [];
                }else{
                    o[name] = this.value || '';
                }
            }
        });
        return o;
    };
    $.fn.serializeFullArray = function()
    {
        var result = [];
        var disabled = $(this).find('select:disabled').removeAttr('disabled');
        var a = this.serializeArray();
        disabled.attr('disabled','disabled');
        if(a.length == 0){
            var disabled = $(this).find('select:disabled').removeAttr('disabled');
            a = $(this).find("input,select,textarea").serializeArray();
            disabled.attr('disabled','disabled');
        }
        /************************************/
        var names = []
        $.each(a, function() {names.push(this.name);});
        $(this).find('input[type="checkbox"]:not(:checked)').each(function(){
            if($.inArray(this.name, names) === -1){
                a.push({name: this.name, value: 'off'});
            }
        });

        $.each(a, function() {
            var name = this.name.replace(/\[\]/g, "");
            var label = $("label[for='" + this.name + "']").text().replace('(*)', '').trim();//[0];
            if(label){
                this.label = label;
            }else{
                this.label = '';
            }

            this.type = $('[name$="'+name+'"]').prop('type');
            var data = $('[name$="'+name+'"]').data()

            if(this.type == "select-one"){
                var selectedText = $('[name$="'+name+'"] option:selected').html();
                this.option_label = selectedText.trim();
            }
            else if(this.type == "select-multiple"){
                this.option_label = [];
                $('[name$="id_tipo_paciente"] option:selected').toArray().map(item => this.option_label.push(item.text.trim()));
            }
            if(data && Object.entries(data).length){
                item = this
                Object.keys(data).forEach(function(currentValue) {
                    item[currentValue] = (data[currentValue] || '');
                });
                result.push(item);
            }else{
                result.push(this);
            }
        });
        return result;
    };
});