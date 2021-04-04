        <div class="panel panel-primary">
				<div class="panel-heading">

				</div>
                <div class="table-responsive col-lg-12" data-row="10">
					<table id="tablaPrincipal" class="table table-hover table-striped table-bordered dataTable no-footer">
						<thead>
							<tr role="row">
								<!-- th class="text-center" width="1%">ID</th -->
								<th class="text-center" width="5%">RUT / Pasaporte</th>
								<th class="text-center" width="5%">Fecha Registro</th>
								<th class="text-center" width="25%">Nombre</th>
								<th class="text-center" width="10%">Comuna</th>
								<th class="text-center" width="25%">Establecimiento Salud</th>
								<th class="text-center" width="10%">Estado</th>
								<th class="text-center" width="5%">Cantidad atenciones</th>
								<th class="text-center" width="5%">Reconoce violencia</th>
								<th class="text-center" width="5%">Participa</th>
								<th class="text-center" width="5%">Exámen PAP o Mamografía Alterado</th>
								<th class="text-center" width="1px">Dias primera visita?</th>
								<th class="text-center">Acciones</th>
							</tr>
						</thead>
						<tbody>
							{foreach $arrResultado as $item}
								{if $item->nr_examen_alterado > 0}
									<tr>
											<!-- td class="text-center"> {$item->id_paciente} </td -->
										<td style="color:#ff0000; background: #F7D3D2;" class="text-center" nowrap> {$item->gl_identificacion} </td>
										<td style="color:#ff0000; background: #F7D3D2;" class="text-center"> {$item->fc_crea} </td>
										<td style="color:#ff0000; background: #F7D3D2;" class="text-left"> {$item->gl_nombres} {$item->gl_apellidos} </td>
										<td style="color:#ff0000; background: #F7D3D2;" class="text-left"> {$item->gl_nombre_comuna} </td>
										<td style="color:#ff0000; background: #F7D3D2;" class="text-center"> {$item->gl_institucion} </td>
										<td style="color:#ff0000; background: #F7D3D2;" class="text-center" nowrap> {$item->gl_nombre_estado_caso} </td>
										<td style="color:#ff0000; background: #F7D3D2;" class="text-center" nowrap> {$item->nr_motivo_consulta} </td>
										<td style="background: #F7D3D2;" class="text-center" nowrap>
											{if $item->bo_reconoce == 1}
												<span class="label label-danger">Si</span>
											{else}
												<span class="label label-success">No</span>
											{/if}
										</td>
										<td style="background: #F7D3D2;" class="text-center" nowrap>
											{if $item->bo_acepta_programa == 1}
												<span class="label label-danger">Si</span>
											{else}
												<span class="label label-success">No</span>
											{/if}
										</td>
										<td style="background: #F7D3D2;" class="text-center" nowrap>
											<span class="label label-danger">Si</span>
										</td>
										<td style="color:#ff0000; background: #F7D3D2;" class="text-center" nowrap> {$item->nr_dias_primera_visita} </td>
										<td style="background: #F7D3D2;" class="text-center" nowrap>
											<button type="button" 
													onClick="xModal.open('{$smarty.const.BASE_URI}/Paciente/ver/{$item->id_paciente}', 'Detalle Registro', 85);" 
													data-toggle="tooltip" 
													class="btn btn-xs btn-info"
													data-title="Ver Registro">
												<i class="fa fa-search"></i>
											</button>
											<button type="button" 
													class="btn btn-xs btn-success" 
													onClick="location.href = '{$base_url}/Empa/nuevo/{$item->id_paciente}';" 
													data-toggle="tooltip" 
                                                    data-title="Formulario EMPA">
												<i class="fa fa-book"></i>
											</button>
											{if $item->bo_reconoce == 0}
												<button type="button" class="btn btn-xs btn-danger" 
														onClick="location.href = '{$base_url}/Reconoce/identificarAgresor/{$item->id_paciente}';"
														data-toggle="tooltip" 
                                                        data-title="Reconoce Violencia">
													<i class="fa fa-bullhorn"></i>
												</button>
											{/if}
											{if $mostrar_plan == 1}
												<button type="button"
														onclick="location.href = '{$base_url}/Medico/plan_tratamiento/{$item->id_paciente}'"
														data-toggle="tooltip" 
														data-title="Plan Tratamiento" 
														class="btn btn-xs btn-default">
													<i class="fa fa-medkit"></i>
												</button>
											{/if}
											<button type="button"
													onClick="xModal.open('{$smarty.const.BASE_URI}/Bitacora/ver/{$item->id_paciente}', 'Registro número : {$item->id_paciente}', 85);" 
													data-toggle="tooltip" 
													data-title="Revisar bitácora" 
													class="btn btn-xs btn-primary">
												<i class="fa fa-info-circle"></i>
											</button>
										</td>
									</tr>
								{else}
									<tr>
											<!-- td class="text-center"> {$item->id_paciente} </td -->
										<td class="text-center" nowrap> {$item->gl_identificacion} </td>
										<td class="text-center"> {$item->fc_crea} </td>
										<td class="text-left"> {$item->gl_nombres} {$item->gl_apellidos} </td>
										<td class="text-left"> {$item->gl_nombre_comuna} </td>
										<td class="text-center"> {$item->gl_institucion} </td>
										<td class="text-center" nowrap> {$item->gl_nombre_estado_caso} </td>
										<td class="text-center" nowrap> {$item->nr_motivo_consulta} </td>
										<td class="text-center" nowrap> 
											{if $item->bo_reconoce == 1}
												<span class="label label-danger">Si</span>
											{else}
												<span class="label label-success">No</span>
											{/if}
										</td>
										<td class="text-center" nowrap>
											{if $item->bo_acepta_programa == 1}
												<span class="label label-danger">Si</span>
											{else}
												<span class="label label-success">No</span>
											{/if}								
										</td>
										<td class="text-center" nowrap>
											<span class="label label-success">No</span>
										</td>
										<td class="text-center" nowrap> {$item->nr_dias_primera_visita} </td>
										<td class="text-center" nowrap>
											<button type="button" 
													onClick="xModal.open('{$smarty.const.BASE_URI}/Paciente/ver/{$item->id_paciente}', 'Detalle Registro', 85);" 
													data-toggle="tooltip" 
													class="btn btn-xs btn-info"
													data-title="Ver Registro">
												<i class="fa fa-search"></i>
											</button>
											<button type="button" 
													class="btn btn-xs btn-success" 
													onClick="location.href = '{$base_url}/Empa/nuevo/{$item->id_paciente}';" 
													data-toggle="tooltip" 
                                                    data-title="Formulario EMPA">
												<i class="fa fa-book"></i>
											</button>
											{if $item->bo_reconoce == 0}
												<button type="button" class="btn btn-xs btn-danger" 
														onClick="location.href = '{$base_url}/Reconoce/identificarAgresor/{$item->id_paciente}';"
														data-toggle="tooltip" 
                                                        data-title="Reconoce Violencia">
													<i class="fa fa-bullhorn"></i>
												</button>
											{/if}
											{if $mostrar_plan == 1}
												<button type="button"
														onclick="location.href = '{$base_url}/Medico/plan_tratamiento/{$item->id_paciente}'"
														data-toggle="tooltip" 
														data-title="Plan Tratamiento" 
														class="btn btn-xs btn-default">
													<i class="fa fa-medkit"></i>
												</button>
											{/if}
											<button type="button"
													onClick="xModal.open('{$smarty.const.BASE_URI}/Bitacora/ver/{$item->id_paciente}', 'Registro número : {$item->id_paciente}', 85);" 
													data-toggle="tooltip" 
													data-title="Revisar bitácora" 
													class="btn btn-xs btn-primary">
												<i class="fa fa-info-circle"></i>
											</button>
										</td>
									</tr>

								{/if}	

							{/foreach}
						</tbody>
					</table>
			</div>
		</div>