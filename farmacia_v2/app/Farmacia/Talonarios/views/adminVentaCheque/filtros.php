
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
                        <label class="form-label"><?php echo \Traduce::texto("Fecha Venta"); ?></label>
					</div>
					<div class="col-4">
							<div class="input-group">
							<input type="text" readonly class="form-control float-left yearselect" id="fc_venta_talonario" name="fc_venta_talonario"
								value="<?php echo (isset($arrFiltros->fc_venta_talonario))?\Fechas::formatearHtml($arrFiltros->fc_venta_talonario):""; ?>" autocomplete="off">
							<div class="input-group-prepend" for="fc_venta_talonario">
								<span class="input-group-text">
									<i class="far fa-calendar-alt"></i>
								</span>
							</div>
						</div>
                        <span class="help-block hidden fa fa-warning"></span>
					</div>
					<div class="col-2">
                        <label class="form-label" for="gl_nombre_medico"><?php echo \Traduce::texto("Nombre Médico"); ?></label>
					</div>
					<div class="col-4">
                        <input class="form-control form-control-sm" id="gl_nombre_medico" name="gl_nombre_medico" placeholder="Juan Pérez"
                               value="<?php echo (isset($arrFiltros['gl_nombre_medico']))?$arrFiltros['gl_nombre_medico']:""; ?>">
                        <span class="help-block hidden fa fa-warning"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-2">
                        <label class="form-label" for="gl_codigo_recaudacion">Código Recaudación</label>
					</div>
					<div class="col-4">
                        <input class="form-control form-control-sm" id="gl_codigo_recaudacion" name="gl_codigo_recaudacion" placeholder=""
                               value="<?php echo (isset($arrFiltros['gl_codigo_recaudacion']))?$arrFiltros['gl_codigo_recaudacion']:""; ?>">
                        <span class="help-block hidden fa fa-warning"></span>
					</div>
				</div>
				<div class="row float-right">
					<div class="col-auto">
						<button type="button" id="limpiar" class="btn btn-default btn-xs" onclick="AdminVentaCheque.limpiarFiltros();">
							<i class="fas fa-sync-alt"></i> <?php echo \Traduce::texto("Limpiar Filtros"); ?>
						</button>
					</div>
					<div class="col-auto">
						<button type="button" id="buscar" class="btn bg-teal btn-xs" onclick="AdminVentaCheque.buscar();">
							<i class="fa fa-search"></i> <?php echo \Traduce::texto("Buscar"); ?>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
