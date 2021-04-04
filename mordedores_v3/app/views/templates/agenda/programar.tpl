<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<section class="content">
    
    <div class="panel panel-primary">
        <input type="text" value="{$token_exp_mor}" id="token_expediente_mordedor" name="token_expediente_mordedor" class="hidden">
        <input type="text" value="{$bo_reprogramar}" id="bo_reprogramar" name="bo_reprogramar" class="hidden">
        <input type="text" value="{$bandeja}" id="gl_bandeja" name="gl_bandeja" class="hidden">
        <div class="panel-heading">
            {if $bo_reprogramar == 1}Reprogramar{else}Programar{/if} Visita
        </div>
        
        <div class="top-spaced"></div>
        
        <div class="panel-body">
            <div class="row">
                
                <div class="col-sm-2">&nbsp;</div>
                
                <div class="col-sm-3">
                    <label for="fc_programado" class="control-label">Fecha Visita</label>
                    <div class="input-group">
                        <input for="fc_programado" type='text' class="form-control datepicker" id='fc_programado' name='fc_programado'
                               onblur="validarVacio(this, '')" value="{$smarty.now|date_format:"%d/%m/%Y"}">
                        <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fc_programado').focus();"></i></span>
                    </div>
                </div>
                            
                <div class="col-sm-3">
                    <label for="hora_programado" class="control-label">Hora Visita</label>
                    <div class="input-group">
                        <input for="hora_programado" type="text" name="hora_programado" id="hora_programado" value="{$smarty.now|date_format:"%H:%M"}" 
                               onblur="validarVacio(this, '')" class="form-control">
                        <span class="input-group-addon"><i class="fa fa-clock-o" onClick="$('#hora_programado').focus();"></i></span>
                    </div>
                </div>
                                   
            </div>
                                   
            <div class="top-spaced"></div>
            <div class="row">
                <div class="col-sm-2">&nbsp;</div>
                <div class="col-sm-6">
                    <button type="button" onclick="Fiscalizador.programarVisita();" class="btn btn-success">
						<i class="fa fa-save"></i>  {if $bo_reprogramar == 1}Reprogramar{else}Programar{/if}
					</button>&nbsp;
					<button type="button" id="cancelar"  class="btn btn-default" 
                            onclick="xModal.close();">
						<i class="fa fa-remove"></i>  Cancelar
					</button>&nbsp;
					<button type="button" id="cancelar"  class="btn btn-warning" 
                            onclick="Fiscalizador.devolverSupervisor();">
						<i class="fa fa-undo"></i>  Devolver
					</button>
                </div>
            </div>
        </div>

        <div class="top-spaced"></div>
        
    </div>
</section>