<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Farmacias</a></li>
				<li class="breadcrumb-item"><a href="<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Farmacias/establecimiento/">Establecimientos Farmac&eacute;uticos</a></li>
				<li class="breadcrumb-item active">Crear Establecimiento</li>
			</ol>
			</div>
		</div>
	</div>
</section>


<section class="content">
	<div class="container-fluid">
		<div class="col-lg-12 col-md-12">
			<form id="formEstablecimiento">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="card card-primary">
						<div class="card-header">
							<h5>
								Datos del <b>Establecimiento Farmac&eacute;utico</b>
							</h5>
						</div>
						<div class="card-body">
							<!--	TODO:	Esconder/Mostrar con Región Valparaíso	-->
							<div class="row top-spaced">
								<div class="row col-md-6 w-100" <?php if(!$bo_rci):?>style="display:none;"<?php endif; ?> id="div_rci">
									<div class="col-md-4">
										<label for="nr_rci" class="control-label required-left">
											N&uacute;mero RCI
										</label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" id="nr_rci" name="nr_rci" value="<?php echo $establecimiento->rakin_numero; ?>" required>
									</div>
								</div>

								<div class="row col-md-6 w-100">
									<div class="col-md-4">
										<label for="factor_riesgo" class="control-label required-left">
											Factor Riesgo
										</label>
									</div>
									<div class="col-md-8">
										<select class="form-control" id="factor_riesgo" name="factor_riesgo" required>
											<option value="">Seleccione</option>
											<option value="Alto" <?php echo ($establecimiento->factor_riesgo == "Alto")?"selected":""; ?> >Alto</option>
											<option value="Mediano" <?php echo ($establecimiento->factor_riesgo == "Mediano")?"selected":""; ?> >Mediano</option>
											<option value="Bajo" <?php echo ($establecimiento->factor_riesgo == "Bajo")?"selected":""; ?> >Bajo</option>
										</select>
									</div>
								</div>
							</div>

							<div class="row top-spaced">
								<div class="col-2">
									<label for="nr_resolucion_apertura" class="control-label required-left">
										N&uacute;mero Resoluci&oacute;n de Apertura
									</label>
								</div>
								<div class="col-4">
									<input type="text" class="form-control" id="nr_resolucion_apertura" name="nr_resolucion_apertura"  value="<?php echo $establecimiento->local_numero_resolucion; ?>">
								</div>

								<div class="col-2">
									<label for="fc_resolucion" class="control-label required-left">
										Fecha de Resoluci&oacute;n
									</label>
								</div>
								<div class="col-4">
									<div class="input-group">
										<input type="text" readonly class="form-control float-left datepicker" id="fc_resolucion" name="fc_resolucion" autocomplete="off" required value="<?php echo (isset($establecimiento) && $establecimiento->local_fecha_resolucion != "0000-00-00")?date("d/m/Y",strtotime($establecimiento->local_fecha_resolucion)):""; ?>"/>
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="far fa-calendar-alt"></i>
											</span>
										</div>
									</div>
								</div>
							</div>

							<hr/>

							<div class="row top-spaced">
								<div class="col-2">
									<label for="id_farmacia" class="control-label required-left">
										Empresa Farmac&eacute;utica
									</label>
								</div>
								<div class="col-8">
									<select class="form-control select2" id="id_farmacia" name="id_farmacia" required>
										<?php if(!empty($establecimiento->gl_farmacia_nombre)):?>
											<option value="<?php echo $establecimiento->fk_farmacia;?>">
												<?php echo $establecimiento->gl_farmacia_nombre;?>
											</option>
										<?php endif;?>
									</select>
								</div>

							</div>

							<hr/>

							<div class="row top-spaced">
								<div class="col-2">
									<label for="local_nombre" class="control-label required-left">
										Nombre del Establecimiento
									</label>
								</div>
								<div class="col-4">
									<input type="text" class="form-control" id="local_nombre" name="local_nombre" value="<?php echo $establecimiento->local_nombre; ?>" required>
								</div>

								
								<div class="col-2">
									<label for="local_numero" class="control-label required-left">
										N&uacute;mero del Establecimiento
									</label>
								</div>
								<div class="col-4">
									<input type="text" class="form-control" id="local_numero" name="local_numero" value="<?php echo $establecimiento->local_numero; ?>" required>
								</div>
							</div>

							<div class="row top-spaced">
								<div class="col-2">
									<label for="local_fono" class="control-label required-left">
										Tel&eacute;fono
									</label>
								</div>
								<div class="col-4 form-row">
									<select class="form-control col-4" id="local_fono_codigo" name="local_fono_codigo">
										<option value="0">Seleccione</option>
										<?php foreach($arrCodfono as $item): ?>
											<option value="<?php echo $item->codfono_id ?>" <?php echo ($establecimiento->local_fono_codigo == $item->codigo)?"selected":""; ?>
												data-codigo="<?php echo $item->codigo;?>">
												<?php echo $item->codigo_formato ?>
											</option>
										<?php endforeach;?>
									</select>
									<input type="text" class="form-control col-8" id="local_fono" name="local_fono" value="<?php echo $establecimiento->local_fono; ?>"
									onkeypress="return soloNumerosYK(event)"/>
								</div>
							</div>

							<hr/>
							
							<!-- TODO:	Tipo Botiquin publico - check "Ver en el Mapa" -->
							<div class="row top-spaced">
								<div class="col-2">
									<label for="id_tipo_establecimiento" class="control-label required-left">
										Tipo de Establecimiento
									</label>
								</div>
								<div class="col-4">
									<select class="form-control" id="id_tipo_establecimiento" name="id_tipo_establecimiento" required>
										<option value="0">Seleccione</option>
										<?php foreach($arr_local_tipo as $item): ?>
											<option value="<?php echo $item->local_tipo_id ?>" <?php echo ($establecimiento->fk_local_tipo == $item->local_tipo_id)?"selected":""; ?> >
												<?php echo $item->local_tipo_nombre ?>
											</option>
										<?php endforeach;?>
									</select>
								</div>

								<div class="col-2">
									&nbsp;
								</div>

								<div class="col-2">
									<label for="bo_franquicia" class="control-label">
										¿Es Franquicia?
									</label>
								</div>
								<div class="col-2" style="font-size:14px;">
									<input type="checkbox" class="checkbox" id="bo_franquicia" name="bo_franquicia"
									<?php if($establecimiento->local_tipo_franquicia == "1"):?> checked <?php endif; ?>/>
								</div>

							</div>

							<div class="row top-spaced" id="div_ver_mapa" <?php if($establecimiento->fk_local_tipo != "4"):?> style="display:none;"<?php endif; ?>>
								<div class="col-2">
									<label for="bo_ver_mapa" class="control-label">
										Ver en el Mapa
									</label>
								</div>
								<div class="col-2" style="font-size:14px;">
									<input type="checkbox" class="checkbox" id="bo_ver_mapa" name="bo_ver_mapa"
									<?php if($establecimiento->activa_mapa == "1"):?> checked <?php endif; ?>/>
								</div>

								<div class="row top-spaced">
									<div class="col-lg-1 col-md-1">
									</div>
									<div class="info-box  col-lg-10 col-md-10">
										<span class="info-box-icon bg-warning" style="margin-top:10px;margin-bottom:10px;">
											<i style="color:white;" class="fa fa-exclamation-triangle"></i>
										</span>
										<div class="info-box-content">
											<span class="info-box-number text-warning"><h5> Ver en el Mapa</h5></span>
											<span class="info-box-number">
												Si selecciona esta opción, este Establecimiento Farmacéutico será visible en el sitio web: <a target="_blank" href="http://turnosdefarmacia.cl/">http://turnosdefarmacia.cl/</a>
											</span>
										</div>
									</div>
								</div>
							</div>


							<hr/>
							
							<div class="row top-spaced">
								<div class="col-2">
									<label for="chk_clasificacion" class="control-label">
										Clasificaci&oacute;n
									</label>
								</div>
								<div class="col-2">
									<?php foreach( $arr_clasificacion as $item):?>
										<div class="col-md-12">
											<label class="checkbox-inline" style="margin-left:0px !important;">
												<input type="checkbox" name="arr_clasificacion"
												id="bo_<?php echo str_replace(" ","_",strtolower(\Utils::remove_accents($item->gl_nombre))) ?>" value="<?php echo $item->id_clasificacion?>">
												&nbsp;&nbsp;<?php echo $item->gl_nombre;?>
											</label>
										</div>
									<?php endforeach;?>
								</div>
							</div>
						</div>
					</div>

					<!-- Direccion -->
					<div id="div_direccion_tradicional" class="card card-primary">
						<div class="card-header">
							<h5>
								Direcci&oacute;n
							</h5>
						</div>
						<div class="card-body">
							<div id="div_form_direccion">
								<?php include_once("app/Farmacia/Farmacias/views/establecimiento/form_direccion.php");?>
							</div>
						</div>
					</div>

					<!-- Direcciones Recorrido -->
					<div id="div_direccion_recorrido" class="card card-primary" style="display:none;">
						<div class="card-header">
							<h5>
								Recorrido Realizado
							</h5>
						</div>
						<div class="card-body">
							<div class="col-lg-12  text-right">
								<button type="button" class="btn btn-lg btn-success"
									onclick="Recorrido.agregar(this)">
									<i class="fa fa-plus"></i>&nbsp;&nbsp;<b>Agregar Recorrido</b>
								</button>
							</div>
							<div id="div_form_direccion_recorrido">
								<?php include_once("app/Farmacia/Farmacias/views/establecimiento/form_direccion_recorrido.php");?>
							</div>
						</div>
					</div>

					<br/>
					
					<!-- Recetario -->
					<div class="card card-primary box box-primary">
						<div class="card-body">
							<div class="col-lg-12  text-right">
								<button type="button" class="btn btn-lg btn-success"
									onclick="maestro_establecimiento.agregarRecetario(this)">
									<i class="fa fa-plus"></i>&nbsp;&nbsp;<b>Agregar Recetario</b>
								</button>
								<input type="hidden" id="bo_recetario" name="bo_recetario" value="<?php (isset($establecimiento) && $establecimiento->local_recetario == "1") ? "1":"0"; ?>"/>
							</div>
							<div id="div_form_recetario" style="display:<?php if($establecimiento->local_recetario != "1"):?>none;<?php else:?>block;<?php endif;?>">
								<?php include_once("app/Farmacia/Farmacias/views/establecimiento/form_recetario.php");?>
							</div>
						</div>
					</div>


					<!-- Horario -->
					<div class="card card-primary">
						<div class="card-header">
							<h5>
								Horario
							</h5>
						</div>
						<div class="card-body">
							<div class="col-lg-12 col-md-12 row">
								<div class="col-lg-7 col-md-7 card card-primary">
									<span class="bg-grey" style="margin:15px;">
										<div class="col-lg-6 col-md-6 text-left row">
											<label for="chk_clasificacion" class="control-label">
												<h6><b>Seleccione Días de Funcionamiento</b></h6>
											</label>
										</div>
										<div class="col-lg-12 col-md-12 text-left">
											<button id="btn_horario_lunes" type="button" class="btn btn-outline-<?php if(!isset($establecimiento->json_lunes) || !empty($establecimiento->json_lunes)):?>success<?php else:?>danger<?php endif;?>"		onclick="Horario.deshabilitar_dia(this,'lunes');">Lunes</button>
											<button id="btn_horario_martes" type="button" class="btn btn-outline-<?php if(!isset($establecimiento->json_martes) || !empty($establecimiento->json_martes)):?>success<?php else:?>danger<?php endif;?>"		onclick="Horario.deshabilitar_dia(this,'martes');">Martes</button>
											<button id="btn_horario_miercoles" type="button" class="btn btn-outline-<?php if(!isset($establecimiento->json_miercoles) || !empty($establecimiento->json_miercoles)):?>success<?php else:?>danger<?php endif;?>"	onclick="Horario.deshabilitar_dia(this,'miercoles');">Miercoles</button>
											<button id="btn_horario_jueves" type="button" class="btn btn-outline-<?php if(!isset($establecimiento->json_jueves) || !empty($establecimiento->json_jueves)):?>success<?php else:?>danger<?php endif;?>"		onclick="Horario.deshabilitar_dia(this,'jueves');">Jueves</button>
											<button id="btn_horario_viernes" type="button" class="btn btn-outline-<?php if(!isset($establecimiento->json_viernes) || !empty($establecimiento->json_viernes)):?>success<?php else:?>danger<?php endif;?>"		onclick="Horario.deshabilitar_dia(this,'viernes');">Viernes</button>
											<button id="btn_horario_sabado" type="button" class="btn btn-outline-<?php if(!isset($establecimiento->json_sabado) || !empty($establecimiento->json_sabado)):?>success<?php else:?>danger<?php endif;?>"		onclick="Horario.deshabilitar_dia(this,'sabado');">Sabado</button>
											<button id="btn_horario_domingo" type="button" class="btn btn-outline-<?php if(!isset($establecimiento->json_domingo) || !empty($establecimiento->json_domingo)):?>success<?php else:?>danger<?php endif;?>"		onclick="Horario.deshabilitar_dia(this,'domingo');">Domingo</button>
											<button id="btn_horario_festivo" type="button" class="btn btn-outline-<?php if(!isset($establecimiento->json_festivos) || !empty($establecimiento->json_festivos)):?>success<?php else:?>danger<?php endif;?>"	onclick="Horario.deshabilitar_dia(this,'festivo');">Festivo</button>
										</div>
									</span>
								</div>
								<!-- <div class="col-lg-1 col-md-1">
									&nbsp;
								</div> -->
								<div class="col-lg-5 col-md-5 row card" style="margin-left:5px;">
									<span class="bg-grey" style="margin:15px;">
										<div class="col-lg-12 col-md-12 text-right">
											<div class="col-lg-6 col-md-6 text-left row">
												<label for="chk_clasificacion" class="control-label">
													<h6><b>Copiar Horario</b></h6>
												</label>
											</div>
											<div class="col-lg-12 col-md-12 text-left">
												<div class="row top-spaced">
													<div class="col-lg-2 col-md-4 col-sm-4">
														<label for="horario_copiar_desde" class="control-label">
															Desde
														</label>
													</div>
													<div class="col-lg-3 col-md-8 col-sm-8 form-row">
														<select class="form-control" id="horario_copiar_desde" name="horario_copiar_desde">
															<option data-idx="0"	id="desde_lunes" 		value="lunes">		Lunes				</option>
															<option data-idx="1"	id="desde_martes" 		value="martes">		Martes				</option>
															<option data-idx="2"	id="desde_miercoles" 	value="miercoles">	Mi&eacute;rcoles	</option>
															<option data-idx="3"	id="desde_jueves" 		value="jueves">		Jueves				</option>
															<option data-idx="4"	id="desde_viernes" 		value="viernes">	Viernes				</option>
															<option data-idx="5"	id="desde_sabado" 		value="sabado">		S&aacute;bado		</option>
															<option data-idx="6"	id="desde_domingo" 		value="domingo">	Domingo				</option>
															<option data-idx="7"	id="desde_festivo" 		value="festivo">	Festivo				</option>
														</select>
													</div>
	
													<div class="col-lg-1 col-md-0 col-sm-0">
														&nbsp;
													</div>
	
													<div class="col-lg-2 col-md-4 col-sm-4">
														<label for="horario_copiar_hasta" class="control-label">
															Hasta
														</label>
													</div>
													<div class="col-lg-3 col-md-8 col-sm-8 form-row">
														<select class="form-control" id="horario_copiar_hasta" name="horario_copiar_hasta">
															<option data-idx="0"	id="hasta_lunes"		 value="lunes">		Lunes				</option>
															<option data-idx="1"	id="hasta_martes"		 value="martes">	Martes				</option>
															<option data-idx="2"	id="hasta_miercoles"	 value="miercoles">	Mi&eacute;rcoles	</option>
															<option data-idx="3"	id="hasta_jueves"		 value="jueves">	Jueves				</option>
															<option data-idx="4"	id="hasta_viernes"		 value="viernes">	Viernes				</option>
															<option data-idx="5"	id="hasta_sabado"		 value="sabado">	S&aacute;bado		</option>
															<option data-idx="6"	id="hasta_domingo"		 value="domingo">	Domingo				</option>
															<option data-idx="7"	id="hasta_festivo"		 value="festivo">	Festivo				</option>
														</select>
													</div>
													<div class="d-md-none d-sm-none d-xs-none d-lg-block col-lg-1">
														<button type="button" class="btn btn-success" onclick="Horario.copiar_rango(this);">Copiar</button>
													</div>
													<div class="d-lg-none col-md-12 col-sm-12 text-right top-spaced">
														<button type="button" class="btn btn-success" onclick="Horario.copiar_rango(this);">Copiar</button>
													</div>
												</div>
											</div>
	
										</div>
									</span>
								</div>
							</div>

							<div id="div_form_horario" class="top-spaced">
								<div class="col-lg-12 row  bottom-spaced">
									<div class="col-1 text-right" style="font-size:14px;">
										<input type="checkbox" class="checkbox" id="bo_impide_turno" name="bo_impide_turno"
										<?php if($establecimiento->local_impide_turnos == "1"):?> checked <?php endif; ?>/>
									</div>
									<div class="col-4">
										<label for="bo_impide_turno" class="control-label">
											¿ Ubicaci&oacute;n impide realizaci&oacute;n de turnos ?
										</label>
									</div>
									<div class="col-6 text-right">
										<button type="button" class="btn btn-lg btn-success" id="btn_cambio_horario"
											onclick="Horario.cambioHorario(this)"><i class="far fa-calendar-alt">
											</i>&nbsp;&nbsp;<b>Seleccionar - Horario No Continuado</b>
										</button>
										<input type="hidden" name="bo_horario_continuado" id="bo_horario_continuado" value="1">
									</div>

									<input type="hidden" name="bo_horario_lunes"		id="bo_horario_lunes"		value="<?php echo (isset($establecimiento))	?	(!empty($establecimiento->json_lunes)?"1":"0")		:	"1";?>"/>
									<input type="hidden" name="bo_horario_martes"		id="bo_horario_martes"		value="<?php echo (isset($establecimiento))	?	(!empty($establecimiento->json_martes)?"1":"0")		:	"1";?>"/>
									<input type="hidden" name="bo_horario_miercoles"	id="bo_horario_miercoles"	value="<?php echo (isset($establecimiento))	?	(!empty($establecimiento->json_miercoles)?"1":"0")	:	"1";?>"/>
									<input type="hidden" name="bo_horario_jueves"		id="bo_horario_jueves"		value="<?php echo (isset($establecimiento))	?	(!empty($establecimiento->json_jueves)?"1":"0")		:	"1";?>"/>
									<input type="hidden" name="bo_horario_viernes"		id="bo_horario_viernes"		value="<?php echo (isset($establecimiento))	?	(!empty($establecimiento->json_viernes)?"1":"0")		:	"1";?>"/>
									<input type="hidden" name="bo_horario_sabado"		id="bo_horario_sabado"		value="<?php echo (isset($establecimiento))	?	(!empty($establecimiento->json_sabado)?"1":"0")		:	"1";?>"/>
									<input type="hidden" name="bo_horario_domingo"		id="bo_horario_domingo"		value="<?php echo (isset($establecimiento))	?	(!empty($establecimiento->json_domingo)?"1":"0")		:	"1";?>"/>
									<input type="hidden" name="bo_horario_festivo"		id="bo_horario_festivo"		value="<?php echo (isset($establecimiento))	?	(!empty($establecimiento->json_festivos)?"1":"0")		:	"1";?>"/>
								</div>
								<?php include_once("app/Farmacia/Farmacias/views/establecimiento/form_horario.php");?>
							</div>
						</div>
					</div>

					<input type="hidden" id="gl_token" name="gl_token" value="<?php echo (isset($establecimiento))?$establecimiento->gl_token:"";?>"/>

					<!-- Fin - Botón Guardar -->
					<div class="text-right top-spaced bottom-spaced">
						<button type="button" class="btn btn-md btn-danger"
							onclick="xModal.close()"
							data-toggle="tooltip" title="cancelar"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar
						</button>

						<span style="padding-left:2em;">
							&nbsp;
						</span>

						<button type="button" class="btn btn-md btn-success"
							onclick="maestro_establecimiento.guardarEstablecimiento()"
							data-toggle="tooltip" title="Guardar"><i class="fa fa-save"></i>&nbsp;&nbsp;Guardar
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>