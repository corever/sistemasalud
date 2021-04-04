
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
                        <label class="form-label" for="gl_nombre"><?php echo \Traduce::texto("Nombre"); ?></label>
					</div>
					<div class="col-4">
                        <input class="form-control form-control-sm" id="gl_nombre" name="gl_nombre" placeholder="Juan Pérez"
                               value="<?php echo (isset($arrFiltros['gl_nombre']))?$arrFiltros['gl_nombre']:""; ?>">
                        <span class="help-block hidden fa fa-warning"></span>
					</div>
					<div class="col-2">
                        <label class="form-label" for="gl_email">Email</label>
					</div>
					<div class="col-4">
                        <input class="form-control form-control-sm" id="gl_email" name="gl_email" placeholder="ejemplo@correo.cl"
                               value="<?php echo (isset($arrFiltros['gl_email']))?$arrFiltros['gl_email']:""; ?>">
                        <span class="help-block hidden fa fa-warning"></span>
					</div>
				</div>

				<div class="row float-right">
					<div class="col-auto">
						<button type="button" id="limpiar" class="btn btn-default btn-xs" onclick="MantenedorSeremi.limpiarFiltros();">
							<i class="fas fa-sync-alt"></i> <?php echo \Traduce::texto("Limpiar Filtros"); ?>
						</button>
					</div>
					<div class="col-auto">
						<button type="button" id="buscar" class="btn bg-teal btn-xs" onclick="MantenedorSeremi.buscar();">
							<i class="fa fa-search"></i> <?php echo \Traduce::texto("Buscar"); ?>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
