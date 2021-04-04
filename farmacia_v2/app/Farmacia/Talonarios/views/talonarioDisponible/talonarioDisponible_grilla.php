<form id="formAsignarTalonario">
	<input type="hidden" readonly name="tc_id" id="tc_id" value="<?php echo $TalonariosCreados->tc_id; ?>">
	<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla-talonarioDisponible" width="100%">
		<thead>
			<tr>
				<th width="10%"><?php echo \Traduce::texto("Serie"); ?></th>
				<th width="20%"><?php echo \Traduce::texto("Folio inicio"); ?></th>
				<th width="20%"><?php echo \Traduce::texto("Folio final"); ?></th>
				<th width="20%"><?php echo \Traduce::texto("Local de venta"); ?></th>
				<th width="10%"><?php echo \Traduce::texto("Fecha creación Talonario"); ?></th>
				<th width="10%"><?php echo \Traduce::texto("Estado Talonario"); ?></th>
				<th width="10%"><?php echo \Traduce::texto("Acciones"); ?></th>
			</tr>
		</thead>
	</table>
</form>