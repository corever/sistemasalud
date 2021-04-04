
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

<table id="grillaMesaAyuda" class="table table-hover table-striped table-bordered dataTable no-footer" id="" width="100%">
	<thead>
		<tr>
			<th>Codigo Ticket</th>
			<th>Asunto</th>
			<th>Email</th>
			<th>Fecha Creación</th>
			<th>Estado</th>
			<th>Días Transcurridos</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($arrDatos as $item) : ?>
		<tr>
			<td align="center"><?php echo $item['gl_codigo_soporte'] ?></td>
			<td><?php echo $item['asunto_soporte'] ?></td>
			<td><?php echo $item['email_usuario'] ?></td>
			<td><?php echo $item['fc_creacion'] ?></td>
			<td><?php echo $item['gl_nombre_estado'] ?></td>
			<td align="center"><?php echo $item['dias_bandeja'] ?></td>
			<td align="center">
			<button type="button" class="btn btn-xs btn-default" onclick="alert('En desarrollo..');" data-toggle="tooltip" title="Ver Formulario"><i class="fa fa-eye"></i></button>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
