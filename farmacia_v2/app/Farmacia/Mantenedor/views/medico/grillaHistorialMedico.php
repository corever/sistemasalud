<table class="table table-hover table-striped table-bordered dataTable no-footer grilla-perfiles-medico" id="grilla-perfiles-medico">
	<thead>
		<tr>
			<th><?php echo \Traduce::texto("Fecha"); ?></th>
			<th><?php echo \Traduce::texto("Tipo"); ?></th>
			<th><?php echo \Traduce::texto("Descripción"); ?></th>
			<th><?php echo \Traduce::texto("Usuario que realiza la acción"); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if(!empty($arrHistorial)): ?>
            <?php foreach ($arrHistorial as $key => $itm): ?>
                <tr>
                    <td class="text-center"><?php echo ($itm->fc_creacion)?$itm->fc_creacion:"-"; ?></td>
                    <td class="text-center"><?php echo ($itm->gl_tipo_historial)?$itm->gl_tipo_historial:"-"; ?></td>
                    <td class="text-center"><?php echo ($itm->gl_descripcion)?$itm->gl_descripcion:"-"; ?></td>
                    <td class="text-center"><?php echo ($itm->gl_usuario_accion)?$itm->gl_usuario_accion:"-"; ?></td>
                </tr>
            <?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
