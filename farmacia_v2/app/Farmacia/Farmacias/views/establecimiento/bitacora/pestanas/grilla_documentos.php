<table class="table small table-hover table-striped table-bordered dataTable no-footer" id="grilla_adjuntos" width="100%">
	
	<thead>
		<tr>
			<th>Fecha</th>
			<th>Tipo Adjunto</th>
			<th>Descripci&oacute;n</th>
			<th>Usuario Crea</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php if (isset($adjuntos)): ?>
			<?php foreach ($adjuntos as $key => $itm): ?>
				<tr>
					<td class="text-center">
						<?php //echo $itm->fc_crea_format.' <br/> <b> '.$itm->hr_crea_format.' </b>'; ?>
					</td>
					<td class="text-center"><?php //echo ucfirst(strtolower($itm->gl_nombre_tipo_adjunto)); ?></td>
					<td class="text-center"><?php //echo $itm->gl_nombre_archivo; ?></td>
					<td class="text-center"><?php //echo $itm->gl_nombre_crea; ?></td>
					<td class="text-center">
						<button type="button" class="btn btn-xs btn-success"
							onclick="window.open('<?php //echo BASE_HOST ?>index.php/General/Adjunto/verOficial/<?php //echo $itm->gl_token ?>')"
							>
							<i class="fa fa-download"></i>
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
