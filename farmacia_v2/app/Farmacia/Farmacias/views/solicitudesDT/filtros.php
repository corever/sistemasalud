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
						<label class="form-label">Estado de solicitud</label>
					</div>
					<div class="col-4">
						<select class="form-control form-control-sm" id="id_estado" name="id_estado">
							<option id="0" value="">Seleccione un estado</option>
							<option id="1" value="0">PENDIENTE</option>
							<option id="2" value="1">APROBADA</option>
							<option id="3" value="2">RECHAZADA</option>
						</select>
					</div>
					<div class="col-2">
						<label class="form-label" for="fc_desde">Fecha Desde</label>
					</div>
					<div class="col-4">
						<input class="form-control form-control-sm" id="fc_desde" name="fc_desde" placeholder="YYYY-MM-DD">
						<span class="help-block hidden fa fa-warning"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-2">
						<label class="form-label" for="gl_tipo">Tipo solicitud</label>
					</div>
					<div class="col-4">
						<select class="form-control form-control-sm" id="gl_tipo" name="gl_tipo">
							<option id="0" value="">Seleccione un tipo</option>
							<option id="1" value="ASUME">ASUME DT</option>
							<option id="2" value="CESE">CESA DT</option>
						</select>
					</div>
					<div class="col-2">
						<label class="form-label" for="fc_hasta">Fecha Hasta</label>
					</div>
					<div class="col-4">
						<input class="form-control form-control-sm" id="fc_desde" name="fc_desde" placeholder="YYYY-MM-DD">
						<span class="help-block hidden fa fa-warning"></span>
					</div>
				</div>
				<div class="row float-right">
					<div class="col-auto">
						<button type="button" id="limpiar" class="btn btn-default btn-xs" onclick="SolicitudesDT.limpiarFiltros();">
						<i class="fas fa-sync-alt"></i> <?php echo \Traduce::texto("Limpiar Filtros"); ?>
						</button>
					</div>
					<div class="col-auto">
						<button type="button" id="buscar" class="btn bg-teal btn-xs" onclick="SolicitudesDT.buscar();">
						<i class="fa fa-search"></i> <?php echo \Traduce::texto("Buscar"); ?>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>