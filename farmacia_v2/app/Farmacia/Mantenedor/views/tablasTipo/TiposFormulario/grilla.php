
<style>

th,td{
	text-align:center;
}

label{
	font-weight: 100  !important;
	font-size  : 14px !important;
}

.fa-clock{
	font-size: 10px;
}
</style>

<?php
	$prefix = "ft-";
?>
<table id="grilla" class="table table-hover table-striped table-bordered dataTable no-footer" id="" width="100%">
	<thead>
		<tr>
			<th>#</th>
			<th><?php echo \Traduce::texto("Nombre del Tipo"); ?></th>
			<th><?php echo \Traduce::texto("Fecha Creación"); ?></th>
			<th><?php echo \Traduce::texto("Estado"); ?></th>
			<th><?php echo \Traduce::texto("Opciones"); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($arrDatos as $item) : ?>
		<tr>
		<td><?php echo $prefix.$item->id_formulario_tipo?></td>
		<td><?php echo $item->gl_nombre?></td>
		<td><?php echo '<i class="far fa-clock"></i>&nbsp;'.$item->fc_crea?></td>
		<td><?php echo $item->bo_activo ? '<span class="text-teal">'.\Traduce::texto("Activo").'</span>' : '<span class="text-danger">'.\Traduce::texto("Deshabilitado").'</span>';    ?></td>
		<td>
			<?php echo $item->bo_activo ? '<button type="button" class="btn btn-xs btn-default" onclick="MantenedorTablasTipo.setEstado('.$item->id_formulario_tipo.', \'disable\', \'_DAOFormulariosTipo\');" data-toggle="tooltip" title="'.\Traduce::texto("Deshabilitar Formato Formulario").'"><i class="fas fa-ban"></i></button>' : '<button type="button" class="btn btn-xs btn-default" onclick="MantenedorTablasTipo.setEstado('.$item->id_formulario_tipo.',\'enable\', \'_DAOFormulariosTipo\');" data-toggle="tooltip" title="'.\Traduce::texto("Habilitar Formato Formulario").'"><i class="fas fa-sync"></i></button>'; ?>
		</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>