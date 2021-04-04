<div class="box box-default bg-gradient-white">
	<div class="box-header with-border bg-gradient-light" onclick="colapsarDivs('cabecera-horario')">
		<b>Horario</b>
		<div class="pull-right"><i id="i-cabecera-horario" class="fa fa-chevron-down"></i></div>
	</div>
	<div class="box-body with-border" id="cabecera-horario">

		<div class="col-md-12 row">
			<div style="display: block;overflow-x: auto;white-space: nowrap;">
				<table style='width:100%' class='table table-striped border-gray w-100' id="tabla_horarios">
					<thead>
						<th class="bg-primary"></th>
						<th class='row_lunes bg-primary text-center'>
							<b>Lunes</b>
						</th>
						<th class='row_martes bg-primary text-center'>
							<b>Martes</b>
						</th>
						<th class='row_miercoles bg-primary text-center'>
							<b>Miercoles</b>
						</th>
						<th class='row_jueves bg-primary text-center'>
							<b>Jueves</b>
						</th>
						<th class='row_viernes bg-primary text-center'>
							<b>Viernes</b>
						</th>
						<th class='row_sabado bg-primary text-center'>
							<b>Sabado</b>
						</th>
						<th class='row_domingo bg-primary text-center'>
							<b>Domingo</b>
						</th>
						<th class='row_festivo bg-primary text-center'>
							<b>Festivo</b>
						</th>
					</thead>
					<tbody>
						<tr align="center">
							<td nowrap><b>Inicio Mañana</b></td>
							<td class='row_lunes'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_lunes["lunes_man_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_martes'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_martes["martes_man_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_miercoles'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_miercoles["miercoles_man_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_jueves'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_jueves["jueves_man_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_viernes'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_viernes["viernes_man_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_sabado'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_sabado["sabado_man_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_domingo'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_domingo["domingo_man_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_festivo'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_festivos["festivo_man_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
						</tr>
						<tr align="center" <?php if($local->bo_continuado):?>style="display:none;"<?php endif;?>>
							<td nowrap><b>Fin Mañana</b></td>
							<td class='row_lunes'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_lunes["lunes_man_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_martes'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_martes["martes_man_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_miercoles'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_miercoles["miercoles_man_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_jueves'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_jueves["jueves_man_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_viernes'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_viernes["viernes_man_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_sabado'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_sabado["sabado_man_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_domingo'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_domingo["domingo_man_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_festivo'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_festivos["festivo_man_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
						</tr>
						<tr align="center" <?php if($local->bo_continuado):?>style="display:none;"<?php endif;?>>
							<td nowrap><b>Inicio Tarde</b></td>
							<td class='row_lunes'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_lunes["lunes_tar_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_martes'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_martes["martes_tar_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_miercoles'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_miercoles["miercoles_tar_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_jueves'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_jueves["jueves_tar_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_viernes'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_viernes["viernes_tar_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_sabado'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_sabado["sabado_tar_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_domingo'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_domingo["domingo_tar_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_festivo'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_festivos["festivo_tar_inicio"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
						</tr>
						<tr align="center">
							<td nowrap><b>Fin Tarde</b></td>
							<td class='row_lunes'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_lunes["lunes_tar_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_martes'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_martes["martes_tar_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_miercoles'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_miercoles["miercoles_tar_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_jueves'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_jueves["jueves_tar_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_viernes'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_viernes["viernes_tar_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_sabado'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_sabado["sabado_tar_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_domingo'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_domingo["domingo_tar_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
							<td class='row_festivo'>
								<div class='input-group' style="min-width:110px">
									<input class='form-control' value='<?php echo $local->json_festivos["festivo_tar_fin"];?>' readonly></input>
									<span class='input-group-append'>
										<span class="input-group-text">
											<i class="far fa-clock"></i>
										</span>
									</span>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>