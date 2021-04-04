<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla">
	<thead>
		<tr>
			<th width="30%"><?php echo \Traduce::texto("Nombre"); ?></th>
			<th width="40%"><?php echo \Traduce::texto("Descripción"); ?></th>
			<th width="20%"><?php echo \Traduce::texto("Estado"); ?></th>
			<th width="5%"><?php echo \Traduce::texto("Opciones"); ?></th>
		</tr>
	</thead>
	<tbody>
        <?php foreach ($arrModulo as $key => $itm): ?>
		<tr>
			<td class="text-center"><?php echo $itm->gl_nombre; ?></td>
			<td class="text-center"><?php echo $itm->gl_descripcion; ?></td>
			<td class="text-center">
                <?php if ($itm->bo_estado == "1"): ?>
                    <div style="color:green;"> <?php echo \Traduce::texto("Activo"); ?> </div>
                <?php else: ?>
                    	<div style="color:red;"> <?php echo \Traduce::texto("Inactivo"); ?> </div>
                <?php endif; ?>
			</td>
			<td class="text-center">
				<button type="button" class="btn btn-xs btn-success" title="<?php echo \Traduce::texto("Editar"); ?>" data-toggle="tooltip"
						onclick="xModal.open('<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Mantenedor/Modulo/editarModulo/<?php echo $itm->gl_token ?>','<?php echo \Traduce::texto('Editar Módulo'); ?>','lg');">
					<i class="fa fa-edit"></i></button>
				<!--<button type="button"  //VER SI PUEDE ELIMINAR
						onclick=""
						data-toggle="tooltip" title="Eliminar Módulo"
						class="btn btn-xs btn-danger">
						<i class="fa fa-eraser"></i>
				</button>-->
			</td>
		</tr>
        <?php endforeach; ?>
	</tbody>
</table>
