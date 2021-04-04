<style>
	label {
		font-weight: 100 !important;
		font-size: 14px !important;
	}
</style>
<div class="col-md-12">
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title"><?php echo \Traduce::texto("Búsqueda Avanzada"); ?></h3>
		</div>
		<div class="card-body" style="display: block;">
			<form id="formBuscar" action="#" method="post" class="form-horizontal">
				<div class="row">
					<div class="col-6">
						<label class="form-label" for="mur_fk_comuna"><?php echo \Traduce::texto("Estado"); ?></label>
						<select class="form-control form-control-sm" id="mur_fk_comuna" name="mur_fk_comuna">
							<?php if (!isset($arrComuna) || count((array) $arrComuna) == 0 || count((array) $arrComuna) > 1) : ?>
								<option value="0">Seleccione una Comuna</option>
							<?php endif; ?>
							<?php if (isset($arrComuna) && is_array($arrComuna)) :
								foreach ($arrComuna as $key => $Comuna) : ?>
									<option value="<?php echo $Comuna->comuna_id ?>" <?php echo (isset($arrFiltros['mur_fk_comuna']) && $arrFiltros['mur_fk_comuna'] == $Comuna->comuna_id) ? "selected" : ""; ?>>
										<?php echo $Comuna->comuna_nombre; ?>
									</option>
							<?php endforeach;
							endif; ?>
						</select>
					</div> 
					<div class="col-6">
						<label class="form-label" for="mur_fk_region"><?php echo \Traduce::texto("Región"); ?></label>
						<select class="form-control form-control-sm" id="mur_fk_region" name="mur_fk_region">
							<?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
								<option value="0">Seleccione una Región</option>
							<?php endif; ?>
							<?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
									<option value="<?php echo $region->region_id ?>" <?php echo (isset($arrFiltros['mur_fk_region']) && $arrFiltros['mur_fk_region'] == $region->region_id) ? "selected" : ""; ?>><?php echo $region->nombre_region_corto; ?></option>
							<?php endforeach;
							endif; ?>
						</select>
					</div>
				</div> 
				<div class="row float-right">
					<div class="col-auto">
						<button type="button" id="limpiar" class="btn btn-default btn-xs" onclick="AdminVendedorTalonario.limpiarFiltros();">
							<i class="fas fa-sync-alt"></i> <?php echo \Traduce::texto("Limpiar Filtros"); ?>
						</button>
					</div>
					<div class="col-auto">
						<button type="button" id="buscar" class="btn bg-teal btn-xs" onclick="AdminVendedorTalonario.buscar();">
							<i class="fa fa-search"></i> <?php echo \Traduce::texto("Buscar"); ?>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>