<div class="table-responsive">
	<table id="grillaEmpresa" name="tablaPrincipal" class="table table-hover table-striped table-bordered dataTable no-footer">
		<thead>
			<tr>
				<th class="center">Nombre de  Fantas&iacute;a</th>
				<th class="center">RUT Farmacia</th>
				<th class="center">Raz&oacute;n Social</th>
				<th class="center">Reg&iacute;on</th>
				<th class="center">Acciones</th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($arrEmpresas as $key => $item): ?>
				<tr data-token="<?php echo $item->gl_token;?>" data-estado="<?php echo $item->farmacia_estado;?>" data-raz_soc="<?php echo $item->farmacia_razon_social;?>">
					<td class="center">
						<?php echo $item->farmacia_nombre_fantasia; ?>
					</td>
					<td class="center" style="white-space:nowrap;">
						<?php echo $item->farmacia_rut_midas; ?>
					</td>
					<td class="center raz_soc">
						<?php echo $item->farmacia_razon_social; ?>
					</td>
					<td class="center">
						<?php echo $item->region_nombre; ?>
					</td>
					<td class="center">
						<?php if($item->farmacia_estado): ?>
							<button type="button" class="btn btn-xs btn-success" onclick="e_ed(this)"><i class="fa fa-edit"></i></button>
							<button type="button" class="btn btn-xs btn-danger" onclick="e_est(this)"><i class="fa fa-ban"></i></button>
						<?php else: ?>
							<button type="button" class="btn btn-xs btn-success" onclick="e_est(this)"><i class="fa fa-check"></i></button>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>