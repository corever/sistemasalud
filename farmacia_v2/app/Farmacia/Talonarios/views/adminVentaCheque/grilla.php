<form id="formAsignarTalonario">
	<input type="hidden" readonly name="bodega_id" value="<?php echo $Bodega->bodega_id; ?>" />
</form>
<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla-talonariosAsignados" width="100%">
	<thead>
		<tr>
			<th width="10%"><?php echo \Traduce::texto("ID"); ?></th>
			<th width="10%"><?php echo \Traduce::texto("Fecha Venta"); ?></th>
			<th width="20%"><?php echo \Traduce::texto("Medico"); ?></th>
			<th width="20%"><?php echo \Traduce::texto("Serie [Inicial] [Final]"); ?></th>
			<th width="10%"><?php echo \Traduce::texto("Código Recaudación"); ?></th>
			<th width="30%"><?php echo \Traduce::texto("Estado Recaudación"); ?></th>
			<th width="10%"><?php echo \Traduce::texto("Acciones"); ?></th>
		</tr>
	</thead>
</table>