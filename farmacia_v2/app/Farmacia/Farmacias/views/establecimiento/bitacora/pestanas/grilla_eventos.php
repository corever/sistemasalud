<table class="table small table-hover table-striped table-bordered dataTable no-footer" id="tabla_eventos" width="100%">
	<thead>
		<tr  class="text-center">
			<th>Fecha</th>
			<th>Tipo de evento</th>
			<th>Descripci&oacute;n</th>
			<th>Realizada por</th>
		</tr>
	</thead>
	<tbody>
		<?php if (isset($arr_historial)): ?>
			<?php foreach ($arr_historial as $key => $itm): ?>
				<tr>
					<td class="text-center">
						<?php echo $itm->fc_crea_format.' <br/> <b> '.$itm->hr_crea_format.' </b>'; ?>
					</td>
					<td class="text-center"><?php echo $itm->gl_tipo_historial; ?></td>
					<td><?php echo $itm->gl_historial; ?></td>
					<td class="text-center"><?php echo $itm->crea_nombe_completo.'<br/><b>'.$itm->gl_rut_usuario.'<b>'; ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>