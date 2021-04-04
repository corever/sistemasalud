
<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla-usuarios" width="100%">
	<thead>
		<tr>
			<th width="10%">Rut</th>
			<th width="20%"><?php echo \Traduce::texto("Nombre"); ?></th>
			<th width="20%"><?php echo \Traduce::texto("Email"); ?></th>
			<th width="10%"><?php echo \Traduce::texto("Teléfono"); ?></th>
			<th width="10%"><?php echo \Traduce::texto("Género"); ?></th>
			<th width="20%"><?php echo \Traduce::texto("Dirección"); ?></th>
			<th width="10%"><?php echo \Traduce::texto("Opciones"); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php /*if (isset($arrData)): ?>
			<?php foreach ($arrData as $key => $itm): ?>
				<tr>
					<td class="text-center"><?php echo $itm->gl_email; ?></td>
					<td class="text-center"><?php echo $itm->gl_nombre_completo; ?></td>
					<td class="text-center"><?php echo $itm->gl_pais; ?></td>
					<td class="text-center"><?php echo $itm->fc_nacimiento; ?></td>
					<td class="text-center"><?php echo $itm->gl_perfiles; ?></td>
					<td class="text-center">
						<?php if ($itm->bo_activo): ?>
							<div style="color:green;"> <?php echo \Traduce::texto("Activo"); ?> </div>
						<?php else: ?>
							<div style="color:red;"> <?php echo \Traduce::texto("Inactivo"); ?> </div>
						<?php endif; ?>

					</td>
					<td class="text-center">
						<button type="button"
								onclick="Modal.open('<?php echo \pan\Uri\Uri::getHost(); ?>/Mantenedor/Usuario/editarUsuario/<?php echo $itm->gl_token ?>','<?php echo \Traduce::texto('Editar Usuario'); ?>','xlg');"
								data-toggle="tooltip" data-title="<?php echo \Traduce::texto('Editar Usuario'); ?>"
								class="btn btn-xs btn-success">
								<i class="fa fa-edit"></i>
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif;*/ ?>
	</tbody>
</table>
