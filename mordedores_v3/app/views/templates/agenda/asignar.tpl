<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<section class="content">
    
    <div class="panel panel-primary">
        <input type="text" value="{$token_exp_mor}" id="token_asignar" name="token_asignar" class="hidden">
        <input type="text" value="{$reasignar}" id="bo_reasignar" name="bo_reasignar" class="hidden">
        <input type="text" value="{$bandeja}" id="gl_bandeja" name="gl_bandeja" class="hidden">
        <div class="panel-heading">
            {if $reasignar}Reasignar{else}Asignar{/if}
        </div>
        
        <div class="top-spaced"></div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4 col-md-2">&nbsp;</div>
                <div class="col-lg-5 col-md-8">
                    <label for="fiscalizador" class="control-label">Fiscalizador (*)</label>
                    <select type="text" id="fiscalizador" name="fiscalizador" class="form-control">
                        <option value="0"> Seleccione Fiscalizador </option>
                        {foreach $arrFiscalizadores as $itm}
                            <option {if $reasignar && $tokenFiscalizador == $itm->gl_token}selected{/if}
                                    value="{$itm->gl_token}" >{$itm->gl_nombres} {$itm->gl_apellidos} {if $itm->bo_municipal == 1}[MUNICIPAL]{/if}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="top-spaced"></div>
            <div class="row">
                <div class="col-lg-4 col-md-2">&nbsp;</div>
                <div class="col-lg-6 col-md-8">
                    <button type="button" onclick="Fiscalizador.asignarFiscalizador(this);" class="btn btn-success">
						<i class="fa fa-save"></i>  Asignar
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