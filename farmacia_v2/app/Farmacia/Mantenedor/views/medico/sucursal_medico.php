<div class="card card-primary">
	<div class="card-header"> Datos Consulta</div>
	<div class="card-body">
			<div class="row">
					<div class="col-sm-6">
							<label for="id_region_consulta" class="control-label required-left"><?php echo \Traduce::texto("Región"); ?></label>
							<select class="form-control" id="id_region_consulta" name="id_region_consulta" onchange="Region.cargarComunasPorRegion(this.value,'id_comuna_usuario',<?php echo (isset($arr->id_comuna))?$arr->id_comuna:''; ?>);" >
									<?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
											<option value="0">Seleccione una Región</option>
									<?php endif; ?>
									<?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
													<option value="<?php echo $region->region_id ?>" <?php echo (isset($arr->id_region) && $arr->id_region == $region->region_id)?"selected":""; ?> ><?php echo $region->nombre_region_corto; ?></option>
									<?php endforeach;
									endif; ?>
							</select>
					</div>
					<div class="col-sm-6">
							<label for="id_comuna_consulta" class="control-label required-left"><?php echo \Traduce::texto("Comuna"); ?></label>
							<select class="form-control" id="id_comuna_consulta" name="id_comuna_consulta"     >
									<?php if (!isset($arrComuna) || count((array) $arrComuna) == 0 || count((array) $arrComuna) > 1) : ?>
											<option value="0">Seleccione una Comuna</option>
									<?php endif; ?>
									<?php if (isset($arrComuna) && is_array($arrComuna)) : foreach ($arrComuna as $key => $comuna) : ?>
													<option value="<?php echo $comuna->comuna_id ?>" data-region="<?php echo $comuna->fk_region ?>" <?php echo (isset($arr->id_comuna) && $arr->id_comuna == $comuna->comuna_id)?"selected":""; ?> ><?php echo $comuna->comuna_nombre; ?></option>
									<?php endforeach;
									endif; ?>
							</select>
					</div>
			</div>
			<div class="row">
					<div class="col-sm-12">
							<label for="gl_direccion_consulta" class="control-label required-left">Dirección</label>
							<input type="text" class="form-control" id="gl_direccion_consulta" name="gl_direccion_consulta"
										 value="<?php echo (isset($arr->gl_direccion))?$arr->gl_direccion_consulta:""; ?>"/>
					</div>
			</div>
			<div class="row">
					<div class="col-sm-3">
							<label for="id_codregion_consulta" class="control-label required-left">Código Teléfono</label>
							<select class="form-control" id="id_codregion_consulta" name="id_codregion_consulta" >
									<?php if (!isset($arrCodRegion) || count((array) $arrCodRegion) == 0 || count((array) $arrCodRegion) > 1) : ?>
											<option value="0">Seleccione código</option>
									<?php endif; ?>
									<?php if (isset($arrCodRegion) && is_array($arrCodRegion)) : foreach ($arrCodRegion as $key => $codRegion) : ?>
													<option value="<?php echo $codRegion->codfono_id ?>" data-region="<?php echo $codRegion->fk_region; ?>" <?php echo (isset($arr->id_codfono) && $arr->id_codfono == $codRegion->codfono_id)?"selected":""; ?> ><?php echo $codRegion->codigo ." (".$codRegion->provincia.")"; ?></option>
									<?php endforeach;
									endif; ?>
							</select>
					</div>
					<div class="col-sm-6">
							<label for="gl_telefono_consulta" class="control-label required-left"><?php echo \Traduce::texto("Teléfono"); ?></label>
							<input type="text" class="form-control" id="gl_telefono_consulta" name="gl_telefono_consulta" value="<?php echo (isset($arr->gl_telefono_consulta))?$arr->gl_telefono_consulta:""; ?>"/>
					</div>
			</div>
	</div>
</div>
