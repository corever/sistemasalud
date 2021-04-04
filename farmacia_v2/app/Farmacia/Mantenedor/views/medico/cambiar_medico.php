<form id="formCambioMedico">

	<input type="text" value="<?php echo $gl_token ?>" id="gl_token" name="gl_token" class="hidden" readonly>
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title"> <i class="fa fa-exchange"></i> <?php echo \Traduce::texto("Cambiar de Medico"); ?> </h3>
		</div>
		<div class="box-body">
			<div class="form-group">
				<label class="control-label"><?php echo \Traduce::texto("Seleccione un medico"); ?> : </label>
				<select id="token_medico_cambio" name="token_medico_cambio" class="form-control select2" style="width: 700px;">
					<?php foreach ($arr_data as $key => $data): ?>
						<option value="<?php echo $data->gl_token ?>"><?php echo mb_strtoupper($data->gl_nombres." ".$data->gl_apellido_paterno." ".$data->gl_apellido_materno) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group" align="right">
				<button type="button" id="btnCambioMedico" class="btn btn-success"><i class="fa fa-exchange"></i> <?php echo \Traduce::texto("Aceptar"); ?></button>
			</div>
		</div>

	</div>

</form>
