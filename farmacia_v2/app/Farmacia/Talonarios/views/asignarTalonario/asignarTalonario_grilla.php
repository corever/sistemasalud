<form id="formAsignarTalonario">
	<input type="hidden" readonly name="bodega_id" value="<?php echo $Bodega->bodega_id; ?>" />
</form>
<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla-asignarTalonario" width="100%">
	<thead>
		<tr>
			<th width="10%"><?php echo \Traduce::texto("Serie"); ?></th>
			<th width="20%"><?php echo \Traduce::texto("Folio inicio"); ?></th>
			<th width="20%"><?php echo \Traduce::texto("Folio final"); ?></th>
			<th width="10%"><?php echo \Traduce::texto("Cantidad de folios"); ?></th>
			<th width="30%"><?php echo \Traduce::texto("Bodega"); ?></th>
			<th width="10%"><?php echo \Traduce::texto("Acciones"); ?></th>
		</tr>
	</thead>
</table>