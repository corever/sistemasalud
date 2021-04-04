<form id="formNuevoUsuario" class="form-horizontal">
	<section class="content">
        
        <input id="gl_token_usuario" name="gl_token_usuario" value="" hidden>
        
		<?php echo $datosMedico ?>
        
		<div class="top-spaced" id="div_acciones" align="right">
            <button class="btn btn-danger" type="button" onclick="xModal.close(); "><i class="fa fa-close"></i> <?php echo \Traduce::texto("Cerrar"); ?> </button>
		</div>
	</section>
</form>
