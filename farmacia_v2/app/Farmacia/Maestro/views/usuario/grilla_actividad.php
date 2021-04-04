
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

<table id="grillaActividad" class="table table-hover table-striped table-bordered dataTable no-footer" id="" width="100%">
	<thead>
		<tr>
			<th width="">#</th>
			<th width="">Fecha</th>
			<th width="">Tipo</th>
			<th width="">Descripción de Actividad</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($arrDatos as $item) : ?>
		<tr>
			<td><?php echo '';?></td>
			<td><?php echo '';?></td>
			<td><?php echo '';?></td>
			<td><?php echo '';?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
