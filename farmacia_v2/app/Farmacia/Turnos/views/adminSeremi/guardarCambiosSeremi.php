<form id="formNuevoUsuario" class="form-horizontal">
	<section class="content">
        
        <input id="gl_token_usuario" name="gl_token_usuario" value="<?php echo (isset($arr->gl_token))?$arr->gl_token:""; ?>" hidden>
        
		<?php echo $datosSeremi ?>
        
		<div class="top-spaced" id="div_acciones" align="right">
            <?php if ($boEditar == 1): ?>
                <button class="btn btn-success" type="button" onclick="MantenedorSeremi.editarSeremi($(this.form).serializeArray(), this);"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Guardar"); ?> </button>
            <?php else: ?>
                <button class="btn btn-success" type="button" onclick="MantenedorSeremi.editarSeremi($(this.form).serializeArray(), this);"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Guardar"); ?> </button>
            <?php endif; ?>
            <button class="btn btn-danger" type="button" onclick="xModal.close();MantenedorSeremi.borrarCacheFirma();"><i class="fa fa-close"></i> <?php echo \Traduce::texto("Cerrar"); ?> </button>
		</div>
	</section>
</form>
