<section class="content">
	<div class="container-fluid">
		<div class="row mb-2 mt-3">
			<div class="col-12">
				<div class="card card-primary">
					<div class="card-body">
						<form id="formInhabilitarEstablecimiento">
							<input type="hidden" id="gl_token" name="gl_token" value="<?php echo $token;?>"/>

							<div class="row top-spaced">
								<div class="col-2">
									<label for="id_motivo" class="control-label">
										Motivo Inhabilitaci&oacute;n
									</label>
								</div>
								<div class="col-4">
									<select class="form-control" id="id_motivo" name="id_motivo" onchange="cambio_motivo(this)" required>
										<option value="0">Seleccione Motivo</option>
										<?php foreach($arr_motivos as $tipo): ?>	
											<option value="<?php echo $tipo->motivo_inhabilitacion_id; ?>"><?php echo ucwords(mb_strtolower($tipo->motivo_inhabilitacion_nombre)); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-2 bo_temporal" style="display:none;">
									<label for="bo_temporal" class="control-label">
										Inhabilitaci&oacute;n Temporal
									</label>
								</div>
								<div class="col-4 bo_temporal" style="display:none;">
									<input type="checkbox" id="bo_temporal" name="bo_temporal" value="1" onclick="ver_chk_temporal();">
								</div>
							</div>

							<hr/>

							<div class="row top-spaced">
								<div class="col-md-2 col-sm-2">
									<label for="fc_inicio" class="control-label">
									Fecha Inhabilitaci&oacute;n
									</label>
								</div>
								<div class="col-md-4 col-sm-4">
									<div class="input-group">
										<input type="text" class="form-control float-left datepicker" id="fc_inicio" name="fc_inicio" autocomplete="off" readonly required/>
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="far fa-calendar-alt"></i>
											</span>
										</div>
									</div>
								</div>

								<span id="div_termino" style="display:none;" class="col-md-6 col-sm-6 row">
									<div class="col-md-4 col-sm-4">
										<label for="fc_termino" class="control-label">
										Fecha T&eacute;rmino Inhabilitaci&oacute;n
										</label>
									</div>
									<div class="col-md-8 col-sm-8">
										<div class="input-group">
											<input type="text" class="form-control float-left datepicker" id="fc_termino" name="fc_termino" autocomplete="off" readonly required/>
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="far fa-calendar-alt"></i>
												</span>
											</div>
										</div>
									</div>
								</span>
							</div>

							<!-- <div id="div_motivo" style="display:none;"> -->
							<hr/>
							<div class="row top-spaced">
								<div class="col-2">
									<label for="gl_motivo" class="control-label">
										Motivo (Opcional)
									</label>
								</div>
								<div class="col-6">
									<textarea class="form-control" id="gl_motivo" name="gl_motivo" rows="4"></textarea>
								</div>
							</div>
							<!-- </div> -->
						</form>
					</div>
					<div class="card-footer">
						<div class="col-md-12 text-right">
							<button type="button" class="btn btn-sm btn-danger" onclick="xModal.close()">
								<i class="fa fa-times"></i>	&nbsp;&nbsp;Cancelar
							</button>

							&nbsp;&nbsp;&nbsp;

							<button type="button" class="btn btn-sm btn-success" onclick="Opciones.cambiarEstado()">
								<i class="fa fa-save"></i>	&nbsp;&nbsp;Guardar
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
