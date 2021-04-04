
<section class="content">
    
    <div class="panel panel-primary">
        <input type="text" value="{$token_expediente}" id="token_expediente" name="token_expediente" class="hidden">
        <input type="text" value="{$bandeja}" id="gl_bandeja" name="gl_bandeja" class="hidden">
        <div class="panel-heading">
            Cerrar Notificación
        </div>
        
        <div class="top-spaced"></div>
        
        <div class="panel-body">
            <div class="row">
                
                <div class="col-sm-2">&nbsp;</div>
                            
                <div class="col-sm-8">
                    <label for="txt_motivo_cerrado" class="control-label">Motivo</label>
                    <textarea type="text" name="txt_motivo_cerrado" id="txt_motivo_cerrado" rows="4" class="form-control"></textarea>
                </div>
                
            </div>
                                   
            <div class="top-spaced"></div>
            <div class="row">
                <div class="col-sm-2">&nbsp;</div>
                <div class="col-sm-6">
                    <button type="button" onclick="cerrarNotificacion.guardarBD(this);" class="btn btn-success">
						<i class="fa fa-save"></i>  Confirmar
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