
<section class="content">
    
    <div class="panel panel-primary">
        <input type="text" value="{$id_agenda}" id="id_agenda" name="id_agenda" class="hidden">
        <div class="panel-heading">
            Aplicar Vacuna
        </div>
        
        <div class="top-spaced"></div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4 col-md-2">&nbsp;</div>
                <div class="col-lg-5 col-md-8">
                    <label for="fc_vacuna_aplicada" class="control-label">Fecha</label>
                    <div class="input-group">
                        <input for="fc_vacuna_aplicada" type='text' class="form-control" id='fc_vacuna_aplicada' name='fc_vacuna_aplicada'
                               onblur="validarVacio(this, '')" value="{$smarty.now|date_format:"%d/%m/%Y"}" autocomplete="off">
                        <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fc_vacuna_aplicada').focus();"></i></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-2">&nbsp;</div>
                <div class="col-lg-5 col-md-8">
                    <label for="hora_vacuna_aplicada" class="control-label">Hora</label>
                    <div class="input-group">
                        <input for="hora_vacuna_aplicada" type="text" name="hora_vacuna_aplicada" id="hora_vacuna_aplicada" autocomplete="off"
                               value="{$smarty.now|date_format:"%H:%M"}" onblur="validarVacio(this, '')" class="form-control">
                        <span class="input-group-addon"><i class="fa fa-clock-o" onClick="$('#hora_vacuna_aplicada').focus();"></i></span>
                    </div>
                </div>
            </div>
            <div class="top-spaced"></div>
            <div class="row">
                <div class="col-lg-4 col-md-2">&nbsp;</div>
                <div class="col-lg-6 col-md-8">
                    <button type="button" onclick="Agenda.aplicar_vacuna(this);" class="btn btn-success">
						<i class="fa fa-save"></i>  Guardar
					</button>&nbsp;
					<button type="button" id="cancelar"  class="btn btn-default" 
                            onclick="xModal.close();">
						<i class="fa fa-remove"></i>  Cancelar
					</button>
                </div>
            </div>
        </div>

        <div class="top-spaced"></div>
        
    </div>
</section>