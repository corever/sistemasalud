<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla">
	<thead>
		<tr>
			<th width="5%">N°</th>
			<th width="5%"><?php echo \Traduce::texto("Icono"); ?></th>
			<th width="20%"><?php echo \Traduce::texto("Nombre Opción"); ?></th>
			<th width="20%"><?php echo \Traduce::texto("Nombre Padre"); ?></th>
			<th width="20%">URL</th>
			<th width="20%"><?php echo \Traduce::texto("Modulo"); ?></th>
			<th width="10%"><?php echo \Traduce::texto("Estado"); ?></th>
			<th width="5%"><?php echo \Traduce::texto("Opciones"); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($arr_data as $key => $itm): ?>
			<?php  //file_put_contents('php://stderr', PHP_EOL . print_r($itm, TRUE). PHP_EOL, FILE_APPEND);?>
		<tr>
			<td class="text-center"> <?php echo $itm->id_opcion; ?></td>
			<td class="text-center">
				<i class="<?php echo $itm->gl_icono. " ";
				 				if(substr($itm->gl_icono,-2)!='2x'){
									echo 'fa-2x';
								} ?>"
					data-toggle="tooltip"
					data-title="<?php echo $itm->gl_icono ?>" >
				</i>
			</td>
			<td class="text-center"><?php  echo $itm->gl_nombre_opcion; ?></td>
			<td class="text-center"><?php  echo ($itm->gl_nombre_padre != "")?$itm->gl_nombre_padre:"<div style='color:red;'>-</div>"; ?></td>
			<td class="text-center"><?php  echo $itm->gl_url; ?></td>
			<td class="text-center"><?php  echo $itm->gl_modulo; ?></td>
			<td class="text-center">
				<?php if ($itm->bo_activo === "1"): ?>
					<div style="color:green;"> <?php echo \Traduce::texto("Activo"); ?> </div>
				<?php else: ?>
					<div style="color:red;"> <?php echo \Traduce::texto("Inactivo"); ?> </div>
				<?php endif; ?>
			</td>
			<td class="text-center">
				<button type="button" class="btn btn-xs btn-success" data-toggle="tooltip" data-title="<?php echo \Traduce::texto("Editar"); ?>"
						onclick="xModal.open('<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Mantenedor/Menu/editarMenu/<?php echo $itm->id_opcion; ?>','<?php echo \Traduce::texto('Editar Menú'); ?>','lg');">
						<i class="fa fa-edit"></i></button>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
