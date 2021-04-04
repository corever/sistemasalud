
<style>
	label{
		font-weight: 100  !important;
		font-size  : 14px !important;
	}
</style>
<div class="col-md-12">
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title"><?php echo \Traduce::texto("Busqueda Avanzada"); ?></h3>
		</div>
		<div class="card-body" style="display: block;">
			<form id="formBuscar" action="#" method="post" class="form-horizontal">
				<div class="row">
					<div class="col-2">
						<label class="form-label"><?php echo \Traduce::texto("Región"); ?></label>
					</div>
					<div class="col-4">
						<select class="form-control form-control-sm" id="id_region" name="id_region"
							onchange="Region.cargarComunasPorRegion(this.value,'id_comuna',<?php echo (isset($arrFiltros['id_comuna']))?$arrFiltros['id_comuna']:''; ?>);"  >
                            <?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
                                <option value="0">Seleccione una Región</option>
                            <?php endif; ?>
                            <?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
								<option value="<?php echo $region->id_region_midas ?>"
									<?php echo (isset($arrFiltros['id_region']) && $arrFiltros['id_region'] == $region->id_region_midas)?"selected":""; ?>
									><?php echo $region->nombre_region_corto; ?></option>
                            <?php endforeach;
                            endif; ?>
                        </select>
					</div>
					<div class="col-2">
                        <label class="form-label"><?php echo \Traduce::texto("Comuna"); ?></label>
					</div>
					<div class="col-4">
						<select class="form-control form-control-sm" id="id_comuna" name="id_comuna"
							onchange="Region.cambioRegionPorComuna(this.id,'id_region');" >
                            <?php if (!isset($arrComuna) || count((array) $arrComuna) == 0 || count((array) $arrComuna) > 1) : ?>
                                <option value="0">Seleccione una Comuna</option>
                            <?php endif; ?>
                            <?php if (isset($arrComuna) && is_array($arrComuna)) : foreach ($arrComuna as $key => $comuna) : ?>
								<option value="<?php echo $comuna->comuna_id ?>" data-region="<?php echo $comuna->id_region_midas ?>"
									<?php echo (isset($arrFiltros['id_comuna']) && $arrFiltros['id_comuna'] == $comuna->comuna_id)?"selected":""; ?>
									><?php echo $comuna->comuna_nombre; ?></option>
                            <?php endforeach;
                            endif; ?>
                        </select>
					</div>
				</div>
				<div class="row top-spaced">
					<div class="col-2">
                        <label class="form-label"><?php echo \Traduce::texto("Rol"); ?></label>
					</div>
					<div class="col-4">
                        <select for="id_rol" class="form-control form-control-sm" id="id_rol" name="id_rol">
                            <option value="0"><?php echo \Traduce::texto("Seleccione un Rol"); ?></option>
                            <?php foreach ($arrRoles as $key => $item) : ?>
                                <option value="<?php echo $item->rol_id ?>"
                                        <?php echo (isset($arrFiltros['id_rol']) && $arrFiltros['id_rol'] == $item->rol_id)?"selected":""; ?>
                                        ><?php echo $item->rol_nombre_vista; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="help-block hidden fa fa-warning"></span>
					</div>
					<div class="col-2">
                        <label class="form-label" for="gl_nombre"><?php echo \Traduce::texto("Nombre"); ?></label>
					</div>
					<div class="col-4">
                        <input class="form-control form-control-sm" id="gl_nombre" name="gl_nombre" placeholder="Juan Pérez"
                               value="<?php echo (isset($arrFiltros['gl_nombre']))?$arrFiltros['gl_nombre']:""; ?>">
                        <span class="help-block hidden fa fa-warning"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-2">
                        <label class="form-label" for="gl_email">Email</label>
					</div>
					<div class="col-4">
                        <input class="form-control form-control-sm" id="gl_email" name="gl_email" placeholder="ejemplo@correo.cl"
                               value="<?php echo (isset($arrFiltros['gl_email']))?$arrFiltros['gl_email']:""; ?>">
                        <span class="help-block hidden fa fa-warning"></span>
					</div>
					<div class="col-2">
                        <label class="form-label" for="gl_rut">Rut</label>
					</div>
					<div class="col-4">
                        <input class="form-control form-control-sm" id="gl_rut" name="gl_rut" placeholder="12345678-9"
                               value="<?php echo (isset($arrFiltros['gl_rut']))?$arrFiltros['gl_rut']:""; ?>">
                        <span class="help-block hidden fa fa-warning"></span>
					</div>
				</div>
				<!--div class="row">
					<div class="col-4">
							<label class="form-label"><?php echo \Traduce::texto("Activo"); ?></label>
							<select for="bo_activo" class="form-control form-control-sm" id="bo_activo" name="bo_activo">
								<option value="-1" <?php echo (isset($arrFiltros['bo_activo']) && $arrFiltros['bo_activo'] == "-1")?"selected":""; ?>><?php echo \Traduce::texto("Todos"); ?></option>
								<option value="1" <?php echo (isset($arrFiltros['bo_activo']) && $arrFiltros['bo_activo'] == "1")?"selected":""; ?>><?php echo \Traduce::texto("Activo"); ?></option>
								<option value="0" <?php echo (isset($arrFiltros['bo_activo']) && $arrFiltros['bo_activo'] == "0")?"selected":""; ?>><?php echo \Traduce::texto("Inactivo"); ?></option>
							</select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
				</div-->
				<div class="row float-right">
					<div class="col-auto">
						<button type="button" id="limpiar" class="btn btn-default btn-xs" onclick="MantenedorUsuario.limpiarFiltros();">
							<i class="fas fa-sync-alt"></i> <?php echo \Traduce::texto("Limpiar Filtros"); ?>
						</button>
					</div>
					<div class="col-auto">
						<button type="button" id="buscar" class="btn bg-teal btn-xs" onclick="MantenedorUsuario.buscar();">
							<i class="fa fa-search"></i> <?php echo \Traduce::texto("Buscar"); ?>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
