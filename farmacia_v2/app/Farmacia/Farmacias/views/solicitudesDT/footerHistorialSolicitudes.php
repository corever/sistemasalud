<form id="formSolicitud" class="form-horizontal">
	<section class="content">
        
        <input id="gl_token_usuario" name="gl_token_usuario" value="<?php echo (isset($arr->gl_token))?$arr->gl_token:""; ?>" hidden>
        
		<?php echo $datosSolicitud ?>
        
		<div class="top-spaced" id="div_acciones" align="right">
            <button class="btn btn-danger" type="button" onclick="xModal.close(); SolicitudesDT.borrarCacheFirma();"><i class="fa fa-close"></i> <?php echo \Traduce::texto("Cerrar"); ?> </button>
		</div>
	</section>
</form>
