<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla">
	<thead>
		<tr>
			<th width="30%"><?php echo \Traduce::texto("Nombre"); ?></th>
			<th width="40%"><?php echo \Traduce::texto("Nombre Vista"); ?></th>
			<th width="20%"><?php echo \Traduce::texto("Estado"); ?></th>
			<th width="5%"><?php echo \Traduce::texto("Opciones"); ?></th>
		</tr>
	</thead>
	<tbody>
        <?php foreach ($arrRoles as $key => $itm): ?>
		<tr>
			<td class="text-center"><?php echo $itm->rol_nombre; ?></td>
			<td class="text-center"><?php echo $itm->rol_nombre_vista; ?></td>
			<td class="text-center">
                <?php if ($itm->bo_activo == "1"): ?>
                    <div style="color:green;"> <?php echo \Traduce::texto("Activo"); ?> </div>
                <?php else: ?>
                    	<div style="color:red;"> <?php echo \Traduce::texto("Inactivo"); ?> </div>
                <?php endif; ?>
			</td>
			<td class="text-center">
				<button type="button" class="btn btn-xs btn-success" title="<?php echo \Traduce::texto("Editar"); ?>" data-toggle="tooltip"
						onclick="xModal.open('<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Maestro/Rol/editarRol/<?php echo $itm->gl_token; ?>','<?php echo \Traduce::texto('Editar Rol'); ?>','xl');">
					<i class="fa fa-edit"></i></button>
				<?php if($itm->bo_activo == "1"): ?>
					<button type="button" class="btn btn-xs btn-danger" title="<?php echo \Traduce::texto("Desactivar"); ?>" data-toggle="tooltip"
							onclick="MaestroRol.setActivo('<?php echo $itm->gl_token; ?>',0);">
						<i class="fa fa-times"></i></button>
				<?php else: ?>
					<button type="button" class="btn btn-xs btn-success" title="<?php echo \Traduce::texto("Activar"); ?>" data-toggle="tooltip"
					onclick="MaestroRol.setActivo('<?php echo $itm->gl_token; ?>',1);">
						<i class="fa fa-check"></i></button>
				<?php endif; ?>
				<!--<button type="button"  //VER SI PUEDE ELIMINAR
						onclick=""
						data-toggle="tooltip" title="Eliminar Rol"
						class="btn btn-xs btn-danger">
						<i class="fa fa-eraser"></i>
				</button>-->
			</td>
		</tr>
        <?php endforeach; ?>
	</tbody>
</table>
