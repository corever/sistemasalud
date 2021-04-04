<form id="form_recorrido">
	<div class="card card-body">
		<div class="row">
				<div class="top-spaced col-md-6">
					<!-- Region -->
					<div class="row top-spaced">
					<div class="col-4">
						<label for="id_region_recorrido" class="control-label required-left">
							Regi&oacute;n
						</label>
					</div>
					<div class="col-8">
						<select class="form-control" id="id_region_recorrido" name="id_region_recorrido" required_mapa
							onchange="Region.cargarComunasPorRegion(this.value,'id_comuna_recorrido',<?php echo (isset($arr->id_comuna))?$arr->id_comuna:''; ?>);
							cambiarLatitudLongitud('id_region_recorrido','gl_direccion_recorrido','gl_latitud_recorrido','gl_longitud_recorrido');">
							<?php if($bo_editar):?>guardarEdicion
								<?php foreach($arrRegion as $item): ?>
									<?php if($establecimiento->fk_region == $item->id_region_midas):?>
										<option value="<?php echo $item->id_region_midas ?>"
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
										data-longitud="<?php echo $item->gl_longitud ?>">
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
						<label for="id_comuna_recorrido" class="control-label required-left">
							Comuna
						</label>
					</div>
					<div class="col-8">
						<select class="form-control" id="id_comuna_recorrido" name="id_comuna_recorrido" onchange="Region.cambioRegionPorComuna('id_comuna_recorrido','id_region_recorrido');Region.cargarLocalidadPorComuna(this.value,'id_localidad_recorrido',<?php echo (isset($establecimiento->id_localidad))?$establecimiento->id_localidad:''; ?>);
						cambiarLatitudLongitud('id_comuna_recorrido','gl_direccion_recorrido','gl_latitud_recorrido','gl_longitud_recorrido');" required_mapa>
							<?php if(empty($establecimiento)):?>
								<option value="0">Seleccione una Región</option>
							<?php else:?>
								<?php foreach($arrComuna as $item): ?>
									<option value="<?php echo $item->comuna_id ?>" data-region="<?php echo $item->fk_region ?>"
										data-latitud="<?php echo $item->gl_latitud ?>"
										data-longitud="<?php echo $item->gl_longitud ?>">
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
						<label for="id_localidad_recorrido" class="control-label required-left">
							Localidad
						</label>
					</div>
					<div class="col-8">
						<select class="form-control" id="id_localidad_recorrido" name="id_localidad_recorrido" required_mapa>
							<?php if($bo_editar):?>
								<?php foreach($arr_localidad as $item): ?>
									<?php if($establecimiento->fk_localidad == $item->localidad_id):?>
										<option value="<?php echo $item->localidad_id ?>">
											<?php echo $item->localidad_nombre ?>
										</option>
									<?php endif;?>
								<?php endforeach;?>
							<?php else:?>
								<option value="0">Seleccione una Comuna</option>
							<?php endif;?>
						</select>
					</div>
				</div>
			
				<!-- Direccion -->
				<div class="row top-spaced">
					<div class="col-4">
						<label for="gl_direccion_recorrido" class="control-label required-left">
							Direcci&oacute;n
						</label>
					</div>
					<div class="col-8">
						<input type="text" class="form-control" id="gl_direccion_recorrido" name="gl_direccion_recorrido" value="" required_mapa>
					</div>
				</div>
			</div>
			
			<!-- Mapa -->
			<div class="top-spaced col-md-6">
				<div class="col-12">
					<div id="mapa_recorrido" data-editable="1" style="width:100%;height:300px;"></div>
					<div class="form-group row" style="margin-top: 15px !important;">
						<label for="gl_latitud_recorrido" class="control-label col-sm-2">Latitud</label>
						<div class="col-sm-4">
							<input type="text" name="gl_latitud_recorrido" id="gl_latitud_recorrido"
								value="<?php echo $gl_latitud; ?>"
								placeholder="latitud"class="form-control" readonly/>
						</div>
						<label for="gl_longitud_recorrido" class="control-label col-sm-2">Longitud</label>
						<div class="col-sm-4">
							<input type="text" name="gl_longitud_recorrido" id="gl_longitud_recorrido"
								value="<?php echo $gl_longitud; ?>"
								placeholder="longitud" class="form-control" readonly/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card card-footer">
		<div class="text-right top-spaced bottom-spaced">
			<button type="button" class="btn btn-md btn-danger"
				onclick="xModal.close();"
				data-toggle="tooltip" title="cancelar"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar
			</button>

			<span style="padding-left:2em;">
				&nbsp;
			</span>

			<button type="button" class="btn btn-md btn-success"
			onclick="Recorrido.guardarPunto(this)"
			data-toggle="tooltip" title="Guardar"><i class="fa fa-save"></i>&nbsp;&nbsp;Guardar Punto de Recorrdio
			</button>
		</div>
	</div>
</form>