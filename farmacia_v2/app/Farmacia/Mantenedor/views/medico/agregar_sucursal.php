<form id="formNuevaSucursalMedico" class="form-horizontal">
	<section class="content">

        <input id="gl_token_medico" name="gl_token_medico" value="<?php print_r($medico); ?>" hidden>

		<?php echo $datosSucursal ?>

		<div class="top-spaced" id="div_acciones" align="right">
            <?php if ($boEditar == 1): ?>
                <button class="btn btn-success" type="button" onclick="MantenedorMedico.editarSucursal($(this.form).serializeArray(), this);"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Guardar"); ?> </button>
            <?php else: ?>
                <button class="btn btn-success" type="button" onclick="MantenedorMedico.agregarSucursal($(this.form).serializeArray(), this);"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Guardar"); ?> </button>
            <?php endif; ?>
            <button class="btn btn-danger" type="button" onclick="xModal.close();"><i class="fa fa-close"></i> <?php echo \Traduce::texto("Cerrar"); ?> </button>
		</div>
	</section>
</form>
