<div class="table-responsive">
	<table id="grillaEstablecimiento" name="tablaPrincipal" class="table table-hover table-striped table-bordered dataTable no-footer">
		<thead>
			<tr>
				<th class="text-center" width="5%">		N&uacute;mero RCI				</th>
				<th class="text-center" width="15%">	Empresa Farmac&eacute;utica		</th>
				<th class="text-center" width="15%">	Nombre Local					</th>
				<th class="text-center" width="5%">		N&uacute;mero Local				</th>
				<th class="text-center" width="15%">	Director T&eacute;cnico (DT)	</th>
				<th class="text-center" width="15%">	Direcci&oacute;n				</th>
				<th class="text-center" width="15%">	Comuna							</th>
				<th class="text-center" width="15%">	Localidad						</th>
				<th class="text-center" width="5%">		Acciones						</th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($establecimientos as $item): ?>
				<tr align="center" data-token="<?php echo $item->gl_token;?>" data-estado="<?php echo $item->local_estado;?>">
					<td><?php echo $item->rakin_numero;?></td>
					<td><?php echo $item->gl_farmacia_nombre.(($item->gl_farmacia_rut)?"<br/><b>".$item->gl_farmacia_rut."</b>":"");?></td>									
					<td><?php echo $item->local_nombre;?></td>
					<td><?php echo $item->local_numero;?></td>
                    <td><?php echo $item->local_dt;?></td>
                    <td><?php echo $item->local_direccion;?></td>
                    <td><?php echo $item->gl_nombre_comuna;?></td>
                    <td><?php echo $item->gl_localidad;?></td>
					<td nowrap>
						<?php if($item->local_estado): ?>
							<!-- Deshabilitar -->
                            <button type="button" class="btn-d" onclick="est(this);"><i class="fa fa-lock"></i></button>
							<!-- Editar -->
							<button type="button" class="btn-s" onclick="ed(this)"><i class="fa fa-edit"></i></button>
							<!-- Agregar DT -->
							<button type="button" class="btn-w" onclick="dt(this)"><i class="fa fa-user"></i></button>
							<!-- Detalle Horario Funcionamiento y Quimicos -->
                            <button type="button" class="btn-s" onclick="hq(this)"><i class="fa fa-calendar"></i></button>
							<!-- Personas Asignadas a Farmacia -->
                            <button type="button" class="btn-s" onclick="paf(this)"><i class="fa fa-users"></i></button>
							<!-- Ver Establecimiento -->
                            <button type="button" class="btn-i" onclick="ver(this)" ><i class="fa fa-search"></i></button>
						<?php else: ?>
                            <button type="button" class="btn-s" onclick="est(this);"><i class="fa fa-lock-open"></i></button>
                            <button type="button" class="btn-i" onclick="ver(this)" ><i class="fa fa-search"></i></button>
						<?php endif; ?>

					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>