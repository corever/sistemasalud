<table class="table table-hover table-striped table-bordered" id="tabla-campanas">
	<thead>
		<tr>
			<th width="5%">Código</th>
			<th width="15%">Nombre</th>
			<th width="15%">Ambito(s)</th>
			<!-- <th width="2%">Nª Orden</th> -->
			<th width="15%">Region</th>
			<th width="15%">Oficina</th>
			<!-- <th width="10%">Comuna</th> -->
			<th width="10%">Fecha Inicio</th>
			<th width="10%">Fecha Término</th>
			<th width="20%">Comentario</th>
			<th width="5%">Estado</th>
			<th width="5%">Opciones</th>
		</tr>
	</thead>
	<tbody align="center">
		<?php if ($arrCampana and count($arrCampana) > 0) :?>
		<?php foreach ($arrCampana as $key => $itm) : ?>			
			<tr>
				<td class="text-center"><?php echo $itm->gl_folio_campana; ?></td>
				
				<td> <?php echo $itm->gl_nombre; ?></td>

				<td>
					<?php // Mostrar ambitos
						if (isset($itm->json_ambito) && is_array(json_decode($itm->json_ambito))) {
							$separador = "";
							foreach (json_decode($itm->json_ambito) as $ambito) {
								echo $separador . $arrAmbito[$ambito];
								$separador = " | ";
							}
						}
						?>
				</td>

				<!-- <td> <?php echo $itm->nr_orden; ?></td> -->
				<td> <?php echo !empty($itm->regiones) ? str_replace(',', ',<br/>',$itm->regiones) : "Nacional"; ?></td>
				<td> <?php echo !empty($itm->oficinas) ? str_replace(',', ',<br/>',$itm->oficinas) : "Nacional"; ?></td>
				<!-- <td> <?php echo !empty($itm->nombre_comuna) ? $itm->nombre_comuna : "-"; ?></td> -->
				<td> <?php echo !empty($itm->fc_inicia) ? date("d/m/Y", strtotime($itm->fc_inicia)) : "-" ?> </td>
				<td> <?php echo !empty($itm->fc_finaliza) ? date("d/m/Y", strtotime($itm->fc_finaliza)) : "-" ?> </td>
				<td> <?php echo $itm->gl_comentario;       ?></td>

				<td class="text-center">
					<?php if ($itm->bo_estado === "1") : ?>
						<div style="color:green;"> Activo </div>
					<?php else : ?>
						<div style="color:red;"> Inactivo </div>
					<?php endif; ?>
				</td>
				<td class="text-center">
					

					<?php if ($itm->bo_estado === "1") : ?>
						<button type="button" class="btn btn-xs btn-success btn-flat" data-toggle="tooltip" data-title="Editar" onclick="Modal.open('<?php echo BASE_HOST ?>index.php/Mantenedor/Campana/editarCampana/<?php echo $itm->id_campana; ?>','Editar','lg');"><i class="fa fa-edit"></i></button>
						<button type="button" class="btn btn-xs btn-danger btn-flat" data-toggle="tooltip" data-title="DESHABILITAR" onclick="MantenedorCampana.inhabilitar(<?php echo $itm->id_campana?>, <?php echo $itm->bo_programa?>);"><i class="fa fa-remove"></i></button>
					<?php else :?>
						<button type="button" class="btn btn-xs btn-warning btn-flat" data-toggle="tooltip" data-title="HABILITAR" onclick="MantenedorCampana.habilitar(<?php echo $itm->id_campana?>, <?php echo $itm->bo_programa?>);"><i class="fa fa-check"></i></button>
					<?php endif;?>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php endif;?>
	</tbody>
</table>