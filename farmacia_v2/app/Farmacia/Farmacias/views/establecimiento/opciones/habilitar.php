<?php include_once("app/Farmacia/Farmacias/views/establecimiento/bitacora/deshabilitacion.php");?>

<br/>

<div class="box box-default bg-gradient-white">
	<div class="box-header with-border bg-gradient-light">
		<b>Detalle de Habilitación</b>
	</div>
	<div class="box-body with-border">
		<div class="col-md-12 row">
			<!-- Columna Izquierda -->
			<div class="col-md-6">
				<div class="col-md-4">
					<label for="fc_habilitacion" class="control-label">
						Fecha Habilitación
					</label>
				</div>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" class="form-control float-left datepicker" id="fc_habilitacion" name="fc_habilitacion" autocomplete="off" required readonly/>
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="far fa-calendar-alt"></i>
							</span>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>
</div>

<div class="box box-footer text-right top-spaced bottom-spaced">
	<input type="hidden" id="gl_token_habilitar" name="gl_token_habilitar" value="<?php echo $token;?>"/>

	<button type="button" class="btn btn-md btn-danger"
		onclick="xModal.close()"
		data-toggle="tooltip" title="cancelar"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar
	</button>

	<span style="padding-left:2em;">
		&nbsp;
	</span>

	<button type="button" class="btn btn-md btn-success"
		onclick="maestro_establecimiento.habilitar(this)"
		data-toggle="tooltip" title="Habilitar"><i class="fa fa-lock-open"></i>&nbsp;&nbsp;Habilitar
	</button>
</div>