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
					<!-- <div class="col-6">
						<label class="form-label" for="bodega_nombre"><?php // echo \Traduce::texto("Nombre bodega"); ?></label>
						<input class="form-control form-control-sm" id="bodega_nombre" name="bodega_nombre" value="<?php // echo (isset($arrFiltros['bodega_nombre'])) ? $arrFiltros['bodega_nombre'] : ""; ?>">
						<span class="help-block hidden fa fa-warning"></span>
					</div> -->
					<div class="col-6">
						<label class="form-label" for="fk_bodega_tipo"><?php echo \Traduce::texto("Tipo de Bodega"); ?></label>
						<select class="form-control form-control-sm" id="fk_bodega_tipo" name="fk_bodega_tipo">
							<?php if (!isset($arrComuna) || count((array) $arrComuna) == 0 || count((array) $arrComuna) > 1) : ?>
								<option value="0">Seleccione una Tipo de Bodega</option>
							<?php endif; ?>
							<?php if (isset($arrBodegaTipo) && is_array($arrBodegaTipo)) :
								foreach ($arrBodegaTipo as $key => $BodegaTipo) : ?>
									<option value="<?php echo $BodegaTipo->bodega_tipo_id ?>" <?php echo (isset($arrFiltros['fk_bodega_tipo']) && $arrFiltros['fk_bodega_tipo'] == $BodegaTipo->bodega_tipo_id) ? "selected" : ""; ?>>
										<?php echo $BodegaTipo->bodega_tipo_nombre; ?>
									</option>
							<?php endforeach;
							endif; ?>
						</select>
					</div>
				<!-- </div>

				<div class="row"> -->
					<!-- <div class="col-6">
						<label class="form-label" for="bodega_direccion"><?php // echo \Traduce::texto("Dirección"); ?></label>
						<input class="form-control form-control-sm" id="bodega_direccion" name="bodega_direccion" value="<?php // echo (isset($arrFiltros['bodega_direccion'])) ? $arrFiltros['bodega_direccion'] : ""; ?>">
						<span class="help-block hidden fa fa-warning"></span>
					</div> -->
					<div class="col-6">
						<label class="form-label" for="fk_region"><?php echo \Traduce::texto("Región"); ?></label>
						<select class="form-control form-control-sm" id="fk_region" name="fk_region">
							<?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
								<option value="0">Seleccione una Región</option>
							<?php endif; ?>
							<?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
									<option value="<?php echo $region->region_id ?>" <?php echo (isset($arrFiltros['fk_region']) && $arrFiltros['fk_region'] == $region->region_id) ? "selected" : ""; ?>><?php echo $region->nombre_region_corto; ?></option>
							<?php endforeach;
							endif; ?>
						</select>
					</div>
				</div>

				<!--div class="row">
					<div class="col-4">
							<label class="form-label"><?php // echo \Traduce::texto("Activo"); ?></label>
							<select for="bo_activo" class="form-control form-control-sm" id="bo_activo" name="bo_activo">
								<option value="-1" <?php // echo (isset($arrFiltros['bo_activo']) && $arrFiltros['bo_activo'] == "-1") ? "selected" : ""; ?>><?php // echo \Traduce::texto("Todos"); ?></option>
								<option value="1" <?php // echo (isset($arrFiltros['bo_activo']) && $arrFiltros['bo_activo'] == "1") ? "selected" : ""; ?>><?php // echo \Traduce::texto("Activo"); ?></option>
								<option value="0" <?php // echo (isset($arrFiltros['bo_activo']) && $arrFiltros['bo_activo'] == "0") ? "selected" : ""; ?>><?php // echo \Traduce::texto("Inactivo"); ?></option>
							</select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
				</div-->
				<div class="row float-right">
					<div class="col-auto">
						<button type="button" id="limpiar" class="btn btn-default btn-xs" onclick="MantenedorBodega.limpiarFiltros();">
							<i class="fas fa-sync-alt"></i> <?php echo \Traduce::texto("Limpiar Filtros"); ?>
						</button>
					</div>
					<div class="col-auto">
						<button type="button" id="buscar" class="btn bg-teal btn-xs" onclick="MantenedorBodega.buscar();">
							<i class="fa fa-search"></i> <?php echo \Traduce::texto("Buscar"); ?>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>