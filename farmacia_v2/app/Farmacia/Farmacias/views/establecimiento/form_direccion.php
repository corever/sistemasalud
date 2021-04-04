
<div class="row">
	<div class="top-spaced col-md-6">
		<!-- Region -->
		<div class="row top-spaced">
			<div class="col-4">
				<label for="id_region" class="control-label required-left">
					Regi&oacute;n
				</label>
			</div>
			<div class="col-8">
				<select class="form-control" id="id_region" name="id_region" required
					onchange="Region.cargarComunasPorRegion(this.value,'id_comuna',<?php echo (isset($arr->id_comuna))?$arr->id_comuna:''; ?>);
					Region.cargarCodigosFonoPorRegion(this.value,'id_codigo_fono',<?php echo (isset($establecimiento->farmacia_fono_codigo))?$establecimiento->farmacia_fono_codigo:''; ?>);
					cambiarLatitudLongitud('id_region');
				">
					<?php if($bo_editar):?>guardarEdicion
						<?php foreach($arrRegion as $item): ?>
							<?php if($establecimiento->id_region_midas == $item->id_region_midas):?>
								<option value="<?php echo $item->id_region_midas ?>" <?php echo ($establecimiento->id_region_midas == $item->id_region_midas)?"selected":""; ?>
									data-latitud="<?php echo $item->gl_latitud ?>"
									data-longitud="<?php echo $item->gl_longitud ?>"
								>
									<?php echo $item->nombre_region_corto ?>
								</option>
							<?php endif;?>
						<?php endforeach;?>
					<?php else:?>
						<option value="0">Seleccione Región</option>
						<?php foreach($arrRegion as $item): ?>
							<option value="<?php echo $item->id_region_midas ?>"
								data-latitud="<?php echo $item->gl_latitud ?>"
								data-longitud="<?php echo $item->gl_longitud ?>"
							<?php echo ($establecimiento->id_region_midas == $item->id_region_midas)?"selected":""; ?> >
								<?php echo $item->nombre_region_corto ?>
							</option>
						<?php endforeach;?>
					<?php endif;?>
				</select>
			</div>
		</div>
	
		<!-- Comuna -->
		<div class="row top-spaced">
			<div class="col-4">
				<label for="id_comuna" class="control-label required-left">
					Comuna
				</label>
			</div>
			<div class="col-8">
				<select class="form-control" id="id_comuna" name="id_comuna" onchange="Region.cambioRegionPorComuna('id_comuna','id_region');Region.cargarLocalidadPorComuna(this.value,'id_localidad',<?php echo (isset($establecimiento->id_localidad))?$establecimiento->id_localidad:''; ?>);cambiarLatitudLongitud('id_comuna');" required>
					<?php if(empty($establecimiento)):?>
						<option value="0">Seleccione una Región</option>
					<?php else:?>
						<?php foreach($arrComuna as $item): ?>
							<option value="<?php echo $item->id_comuna_midas ?>" data-region="<?php echo $item->id_region_midas ?>"
								data-latitud="<?php echo $item->gl_latitud ?>"
								data-longitud="<?php echo $item->gl_longitud ?>"
								<?php echo ($establecimiento->id_comuna_midas == $item->id_comuna_midas)?"selected":""; ?>>
								<?php echo $item->comuna_nombre ?>
							</option>
						<?php endforeach;?>
					<?php endif;?>
				</select>
			</div>
		</div>
	
		<!-- Localidad -->
		<div class="row top-spaced">
			<div class="col-4">
				<label for="id_localidad" class="control-label required-left">
					Localidad
				</label>
			</div>
			<div class="col-8">
				<select class="form-control" id="id_localidad" name="id_localidad" required>
					<?php if($bo_editar):?>
						<?php foreach($arr_localidad as $item): ?>
							<?php if($establecimiento->fk_localidad == $item->localidad_id):?>
								<option value="<?php echo $item->localidad_id ?>" <?php echo ($establecimiento->fk_localidad == $item->localidad_id)?"selected":""; ?> >
									<?php echo $item->localidad_nombre ?>
								</option>
							<?php endif;?>
						<?php endforeach;?>
					<?php else:?>
						<option value="0">Seleccione una Comuna</option>
						<!-- 
							<?php //foreach($arr_localidad as $item): ?>
							<option value="<?php //echo $item->region_id ?>" <?php //echo ($establecimiento->fk_region_midas == $item->region_id)?"selected":""; ?>>
								<?php //echo $item->nombre_region_corto ?>
							</option>
							<?php //endforeach;?> 
						-->
					<?php endif;?>
				</select>
			</div>
		</div>
	
		<!-- Direccion -->
		<div class="row top-spaced">
			<div class="col-4">
				<label for="gl_direccion" class="control-label required-left">
					Direcci&oacute;n
				</label>
			</div>
			<div class="col-8">
				<input type="text" class="form-control" id="gl_direccion" name="gl_direccion" value="<?php echo $establecimiento->local_direccion; ?>" required>
			</div>
		</div>
	</div>
	
	<!-- Mapa -->
	<div class="top-spaced col-md-6">
		<div class="col-12">
			<div id="mapaDireccion" data-editable="1" style="width:100%;height:300px;"></div>
			<div class="form-group row" style="margin-top: 15px !important;">
				<label for="gl_latitud_direccion" class="control-label col-sm-2">Latitud</label>
				<div class="col-sm-4">
					<input type="text" name="gl_latitud_direccion" id="gl_latitud_direccion"
						value="<?php echo ($establecimiento->local_lat)?$establecimiento->local_lat:$gl_latitud ?>"
						placeholder="latitud"class="form-control" readonly/>
				</div>
				<label for="gl_longitud_direccion" class="control-label col-sm-2">Longitud</label>
				<div class="col-sm-4">
					<input type="text" name="gl_longitud_direccion" id="gl_longitud_direccion"
						value="<?php echo ($establecimiento->local_lng)?$establecimiento->local_lng:$gl_longitud ?>"
						placeholder="longitud" class="form-control" readonly/>
				</div>
			</div>
		</div>
	</div>
</div>
