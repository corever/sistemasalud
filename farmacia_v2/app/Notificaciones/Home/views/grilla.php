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

<table id="grillaNotificaciones" class="table table-hover table-striped table-bordered dataTable no-footer" id="" width="100%">
	<thead>
		<tr>
			<th>Codigo Notificación</th>
			<th>Asunto</th>
			<th>Descripción</th>
			<th>Fecha Creación</th>
			<th>Estado</th>
			<th>Días Transcurridos</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($arrDatos as $item) : ?>
		<tr>
			<td align="center"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td align="center"></td>
			<td align="center"></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
