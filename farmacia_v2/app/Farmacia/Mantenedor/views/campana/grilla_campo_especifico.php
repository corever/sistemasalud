<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive col-lg-12" data-row="10">
			<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla">
				<thead>
					<tr>
						<th width="5%">		N°				</th>
						<th width="10%">	Tipo			</th>
						<th width="10%">	Nombre			</th>
						<th width="10%">	Requisito		</th>
						<th width="2%">		Opciones		</th>
					</tr>
				</thead>
				<tbody align="center">
					<?php if (isset($arrEspecifico) && is_array($arrEspecifico)) :
						foreach ($arrEspecifico as $key => $value) : ?>
							<tr>
								<td><?php echo $key + 1 ?></td>
								<td><?php echo isset($value['gl_tipo_campo']) ? $value['gl_tipo_campo'] : " -- "; ?></td>
								<td><?php echo isset($value['gl_nombre_campo']) ? $value['gl_nombre_campo'] : " -- "; ?></td>
								<td><?php /*echo $value['bo_required'] == 1 ? "Obligatorio" : "Opcional"; */?></td>
								<td>
									<?php
									if($value['id_tipo_campo'] == 1){
									?>
									<button type="button" data-toggle="tooltip" class="btn btn-xs btn-primary"
										onclick="xModal.open('<?php echo BASE_HOST ?>index.php/Mantenedor/Campana/agregarOpcionesaCriterio/<?php echo $key ?>','Agregar Opciones a Select <?php echo $value['gl_nombre_campo'] ?>','md')"
										data-hasqtip="68" oldtitle="A&ntilde;adir Opci&oacute;nes" data-title="A&ntilde;adir Opci&oacute;nes" aria-describedby="qtip-68">
										<i class="fa fa-plus"></i>
									</button>
									<?php	
									}
									?>
									<button type="button" onclick="borrarCampoTemporal(<?php echo $key ?>)" data-toggle="tooltip" class="btn btn-xs btn-danger" data-hasqtip="68" oldtitle="Eliminar" data-title="Eliminar" aria-describedby="qtip-68">
										<i class="fa fa-trash"></i>
									</button>
								</td>
							</tr>
					<?php
						endforeach;
					endif;
					?>

				</tbody>

			</table>
		</div>
	</div>
</div>