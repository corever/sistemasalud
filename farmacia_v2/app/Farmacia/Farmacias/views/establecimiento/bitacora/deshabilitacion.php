<div class="box box-danger bg-gradient-white">
	<div class="box-header with-border bg-gradient-light text-danger" onclick="colapsarDivs('cabecera_deshabilitado')">
		<b>Deshabilitada</b>
		<div class="pull-right"><i id="i-cabecera_deshabilitado" class="fa fa-chevron-down"></i></div>
	</div>
	<div class="box-body with-border" id="cabecera_deshabilitado">

		<div class="col-md-12 row">
			<!-- Columna Izquierda -->
			<div class="col-md-6 row">
				<div class="col-md-6">
					<label class="control-label">
						Motivo Inhabilitación
					</label>
					<input type="text" class="form-control" value="<?php echo $local->gl_motivo_inhabilitacion; ?>" readonly/>
				</div>
				<?php if($local->local_motivo_deshabilitacion != 1):?>
					<div class="col-md-6 row">
						&nbsp;
					</div>
					<div class="col-md-6" >
						<label class="control-label">
							Fecha Inhabilitación
						</label>
						<input type="text" class="form-control" value="<?php echo $local->fc_inicio_deshabilita; ?>" readonly/>
					</div>
					
					<div class="col-md-6">
						<label class="control-label">
							Fecha Término Inhabilitación
						</label>
						<input type="text" class="form-control" value="<?php echo $local->fc_termino_deshabilita; ?>" readonly/>
					</div>
				<?php else:?>
					<div class="col-md-6" >
						<label class="control-label">
							Fecha Inhabilitación
						</label>
						<input type="text" class="form-control" value="<?php echo $local->fc_inicio_deshabilita; ?>" readonly/>
					</div>
				<?php endif;?>
				
			</div>

			<?php if($local->local_motivo_deshabilitacion == 5):?>
				<!-- Columna Derecha -->
				<div class="col-md-6 row">
					<div class="col-md-12">
						<label class="control-label">
							Motivo
						</label>
						<textarea type="text" class="form-control" rows="3" readonly><?php echo $local->local_detalle_deshabilitacion;?></textarea>
					</div>
				</div>
			<?php endif;?>

		</div>

	</div>
</div>