<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla-roles-medico">
	<thead>
		<tr>
			<th>Rol</th>
			<th>Asignación</th>
			<th>Estado</th>
			<th>Opciones</th>
		</tr>
	</thead>
	<tbody>
		<?php if(!empty($arrRolMedico)): ?>
            <?php foreach ($arrRolMedico as $key => $itm): ?>
                <tr>
                    <td class="text-center"> <?php echo $itm->gl_rol; ?></td>
                    <td class="text-center">
                        <?php //orden de asignacion: local,bodega,territorio,region,farmacia y si es rol = 15 se agrega br con razon social de farmacia ?>
                        <?php
                            $var1 = '-';
                            $var2 = '';

                            if(!empty($itm->local_nombre)){
                                $var1 = $itm->local_nombre.' '.$itm->local_numero;
                            }elseif(!empty($itm->gl_bodega)){
                                $var1 = $itm->gl_bodega;
                            }elseif(!empty($itm->gl_territorio)){
                                $var1 = $itm->gl_territorio;
                            }elseif(!empty($itm->gl_region)){
                                $var1 = $itm->gl_region;
                            }elseif(!empty($itm->gl_farmacia)){
                                $var1 = $itm->gl_farmacia_razon_social;
                            }
                            if($itm->mur_fk_rol == 15){
                                $var2 = $itm->gl_farmacia_razon_social;
                            }

                            echo $var1;
                            echo (!empty($var2) && $var1 != null)?"<br>".$var2:"";
                        ?>
                    </td>
                    <td class="text-center"><?php echo ($itm->mur_estado_activado == 1)?"ACTIVO":"INACTIVO"; ?></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar Rol"
                                onclick="Mantenedor_medico.eliminaRol(this,<?php echo $itm->mur_id; ?>)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
