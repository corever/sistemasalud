<div class="box box-default bg-gradient-white">
	<div class="box-header with-border bg-gradient-light" onclick="colapsarDivs('cabecera-recetario')">
		<b>Recetario</b>
		<div class="pull-right"><i id="i-cabecera-recetario" class="fa fa-chevron-down"></i></div>
	</div>
	<div class="box-body with-border" id="cabecera-recetario">

		<div class="col-md-12 row">
			<div class="col-md-12 row">
				<div class="col-md-4">
					<label class="control-label">
						Detalle Recetario
					</label>
					<input type="text" class="form-control" value="<?php echo ucwords(strtolower($local->gl_nombre_tipo_recetario)); ?>" readonly/>
				</div>
			</div>

			<div class="col-md-12 row top-spaced">
				<div class="col-md-12">
					<label class="control-label">
						Tipo de Recetas
					</label>
				</div>
				<?php foreach ($local->arr_recetario as $receta):?>
					<div class="col-md-3">
						<input type="text" class="form-control top-spaced" value="<?php echo $receta["numero"]." - ".$receta["nombre"]; ?>" readonly/>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

	</div>
</div>