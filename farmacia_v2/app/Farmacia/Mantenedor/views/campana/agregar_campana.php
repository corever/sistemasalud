<div class="row">
	<div class="col-xs-12">
		<form id="formAgregarCampana" class="form-horizontal">
		
			<input type="hidden" name="id" id="id" <?php if (isset($campana)) :?> value="<?php echo $campana->id_campana?>" <?php endif;?> />
		    <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo?>" />
			<div class="panel panel-primary">
				<div class="panel-heading">
					Formulario para  
					<?php if ($tipo == \App\Fiscalizaciones\Entity\DAOCampana::TIPO_CAMPANA) :?>
						<strong>CAMPAÑA</strong>
					<?php elseif ($tipo == \App\Fiscalizaciones\Entity\DAOCampana::TIPO_PROGRAMA) :?>
						<strong>PROGRAMA</strong>
					<?php endif;?>
				</div>
				<div class="panel-body">
					<div class="col-xs-12">
						
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<label>Ámbito(s) <span class="text-red">(*)</label>
									<div class="row">
										<?php foreach ($arrAmbito as $ambito) :?>
										<div class="col-xs-12 col-sm-6 col-md-4">
											<div class="checkbox">
												<label>
													<input type="checkbox" class="ambitos" name="ambitos[]" id="ambito_<?php echo $ambito->id_ambito?>" value="<?php echo $ambito->id_ambito?>" <?php if (isset($ambitos) and in_array($ambito->id_ambito, $ambitos)):?> checked <?php endif?>  /> <?php echo mb_strtoupper($ambito->gl_nombre)?>
												</label>
											</div>
										</div>				
										<?php endforeach;?>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<label> Nombre <span class="text-red">(*):</span> </label>
													<input type="text" class="form-control" id="gl_nombre_campana" name="gl_nombre_campana" <?php if (isset($campana)) :?> value="<?php echo $campana->gl_nombre?>" <?php endif;?>  />
								</div>
							</div>
						</div>

						<?php if (\Pan\Utils\SessionPan::getSession('perfil') == \App\General\Entity\DAOAccesoPerfil::ENCARGADO_NACIONAL or \Pan\Utils\SessionPan::getSession('perfil') == \App\General\Entity\DAOAccesoPerfil::ADMINISTRADOR) :?>
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<div class="checkbox-inline">
										<label>
													<input type="checkbox" value="SI" name="campana_nacional" id="campana_nacional" onclick="if(this.checked){$('.campana_nacional').prop('disabled', true);$('#contenedor-regiones').hide();}else{$('.campana_nacional').prop('disabled', false);$('#contenedor-regiones').show();}"  <?php if(isset($campana) and $es_nacional) :?> checked <?php endif;?>   /> Es Nacional <span class="help-block">(Al marca esta casilla, el ingreso será válido para todas las regiones)</span>
										</label>
									</div>
								</div>
							</div>
						</div>
						<?php endif;?>

						<div class="row">

							<?php if (\Pan\Utils\SessionPan::getSession('perfil') == \App\General\Entity\DAOAccesoPerfil::ENCARGADO_NACIONAL or \Pan\Utils\SessionPan::getSession('perfil') == \App\General\Entity\DAOAccesoPerfil::ADMINISTRADOR) :?>

							<div id="contenedor-regiones"  <?php if(isset($campana) and $es_nacional) :?> style="display:none" <?php endif;?> >
									<?php if (isset($arrFiltros['arrRegiones']) && is_array($arrFiltros['arrRegiones'])) :?>
										
										<?php foreach ($arrFiltros['arrRegiones'] as $key => $region):?>
										<div class="form-group">
											<div class="col-xs-12 col-sm-6">
												<div class="checkbox">
													<label>
										<input type="checkbox" class="regiones_nacional" data-nombre="<?php echo mb_strtoupper($region->gl_nombre_region)?>" name="id_region_campana[]" id="id_region_campana_<?php echo $region->id_region?>" value="<?php echo $region->id_region?>" onclick="if(this.checked){MantenedorCampana.cargarOficinaPorRegion(this.value,'contenedor-oficinas-region-<?php echo $region->id_region?>');} else {$('#contenedor-oficinas-region-<?php echo $region->id_region?>').html('');}"   <?php if (isset($arr_regiones_oficinas) and in_array($region->id_region, $arr_regiones_oficinas)) :?> checked <?php endif;?>  /> <strong><?php echo mb_strtoupper($region->gl_nombre_region)?></strong>
													</label>
												</div>
											</div>
											<div class="col-xs-12 small" id="contenedor-oficinas-region-<?php echo $region->id_region?>" ></div>
										</div>
										<?php endforeach;?>
									<?php endif;?>
								</div>
							<?php else:?>

							<div class="form-group">
								<div class="col-xs-12 col-sm-12 col-md-4">
									
									<label> Región: </label>
													<select id="id_region_campana" name="id_region_campana" class="form-control campana_nacional" onchange="MantenedorCampana.cargarOficinaPorRegion(this.value,'contenedor-oficinas');" <?php if (isset($campana) and $es_nacional) :?> disabled <?php endif;?> >
										<?php if (!isset($arrFiltros['arrRegiones']) || count((array) $arrFiltros['arrRegiones']) == 0 || count((array) $arrFiltros['arrRegiones']) > 1) : ?>
											<option value="0">-- Seleccione --</option>
										<?php endif; ?>
										<?php if (isset($arrFiltros['arrRegiones']) && is_array($arrFiltros['arrRegiones'])) : foreach ($arrFiltros['arrRegiones'] as $key => $region) : ?>
										<option value="<?php echo $region->id_region ?>"  <?php if (isset($campana) and ($campana->id_region == $region->id_region)) :?> selected <?php endif;?> ><?php echo $region->gl_nombre_region ?></option>
										<?php endforeach;
										endif; ?>
										<!-- <option value="0">-- Seleccione --</option>
										<?php /*foreach ($arrRegion as $key => $region): ?>
												<option value="<?php echo $region->id_region ?>"> <?php  echo $region->gl_nombre_region?></option>
										<?php endforeach;*/ ?> -->
									</select>
									
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<label> Oficinas: </label>
									<div class="form-group" id="contenedor-oficinas">
										<?php if (isset($arrFiltros['arrOficina']) && is_array($arrFiltros['arrOficina'])) :?>
											<?php foreach ($arrFiltros['arrOficina'] as $key => $oficina) : ?>
											<div class="col-xs-12 col-sm-6">
												<div class="checkbox">
													<label>
														<input type="checkbox" class="oficina-region" name="id_oficina_campana[]" id="id_oficina_campana_<?php echo $oficina->id_oficina?>" value="<?php echo $oficina->id_oficina?>" /> <?php echo $oficina->gl_nombre_oficina?>
													</label>
												</div>
											</div>
											<?php endforeach;?>
										<?php endif;?>
									</div>
								</div>
								<!-- <div class="col-xs-12 col-sm-12 col-md-4">
									<label> Comuna: </label>
									<select id="id_comuna_campana" name="id_comuna_campana" class="form-control campana_nacional"  >
										<?php if (!isset($arrFiltros['arrComuna']) || count((array) $arrFiltros['arrComuna']) == 0 || count((array) $arrFiltros['arrComuna']) > 1) : ?>
											<option value="0">-- Seleccione --</option>
										<?php endif; ?>
										<?php if (isset($arrFiltros['arrComuna']) && is_array($arrFiltros['arrComuna'])) : foreach ($arrFiltros['arrComuna'] as $key => $comuna) : ?>
												<option value="<?php echo $comuna->id_comuna ?>"><?php echo $comuna->gl_nombre_comuna ?></option>
										<?php endforeach;
										endif; ?> 
									</select>
								</div> -->
							</div>
						
						<?php endif;?>
						</div>

						<div class="row">
							<div class="form-group">
								<div class="col-xs-12 col-md-4">
									<label for="gl_nombre_opcion""> Fecha Inicio <span class="text-red">(*): </label>
									<div class="input-group">
									<input for="fechaInicia" type="text" class="col-md-12 col-sm-12 form-control" id="fechaInicia" name="fechaInicia" readonly <?php if (isset($campana)) :?>  value="<?php echo \Fechas::formatearHtml($campana->fc_inicia)?>" <?php endif;?> >
										<span for="fechaInicia" class="input-group-addon campana"><i class="fa fa-calendar" onclick="$('#fechaInicia').focus();"></i></span>
									</div>
								</div>

								<div class="col-xs-12 col-md-4">
									<label for="gl_url"> Fecha Término <span class="text-red">(*): </label>
									<div class="input-group">
									<input for="fechaFinaliza" type="text" class="col-md-12  col-sm-12 form-control" id="fechaFinaliza" name="fechaFinaliza" readonly  <?php if (isset($campana)) :?> value="<?php echo \Fechas::formatearHtml($campana->fc_finaliza)?>" <?php endif;?> >
										<span for="fechaFinaliza" class="input-group-addon campana"><i class="fa fa-calendar" onclick="$('#fechaFinaliza').focus();"></i></span>
									</div>
								</div>
							</div>
						</div>

									
						<div class="row">
							<div class="form-group">
								<div class="col-xs-12">
									<label> Comentario: </label>
									<input id="cantCaracteres" name="cantCaracteres" hidden value="<?php echo $cantCaracteres ?>">
									<textarea class="form-control" id="gl_comentario" name="gl_comentario" rows="5" maxlength="<?php echo $cantCaracteres ?>" style="resize:none"><?php if (isset($campana)) :?><?php echo $campana->gl_comentario?><?php endif;?></textarea>
									<span class="help-block">Caracteres disponibles: <?php echo $cantCaracteres ?></span>
								</div>
							</div>
						</div>

						<!-- Opciones Específicas -->
						<div class="row">
							<div class="form-group">
								<div class="col-xs-12">
									<button class="btn btn-default btn-sm" type="button" onclick="$('#contenedor-form-datos-adicionales').slideDown();"> Agregar Datos Adicionales </button> <i class="fa fa-info-circle" style="cursor:pointer;" onclick="Modal.open('<?php echo \Pan\Uri\Uri::getBaseUri()?>Mantenedor/Campana/verInfoDatosAdicionales','Información Datos Adicionales');"></i>
								</div>
							</div>
							<div id="contenedor-form-datos-adicionales" style="display:none">
								<div class="form-group small">
									<div class="col-xs-12 col-sm-12 col-md-4">
										<label>Datos Adicionales <span class="text-red">(*):</span> </label>
										<input type="text" class="form-control datos-adicionales" id="gl_nombre_campo" name="gl_nombre_campo" placeholder="Nombre del Campo" />
									</div>
									<div class="col-xs-12 col-sm-12 col-md-5">
										<label> Descripci&oacute;n <span class="text-red">(*):</span> </label>
										<input type="text" class="form-control datos-adicionales" id="gl_descripcion_campo" name="gl_descripcion_campo" placeholder="Descripci&oacute;n del Campo" />
									</div>
									<div class="col-xs-12 col-sm-12 col-md-3">
										<label> Tipo de campo <span class="text-red">(*): </label>
										<select id="id_tipo_campo" class="form-control datos-adicionales" name="id_tipo_campo" onchange="if(this.value==<?php echo \App\General\Entity\DAOTipoCampo::TIPO_LISTA_UNICA?> || this.value==<?php echo \App\General\Entity\DAOTipoCampo::TIPO_LISTA_MULTIPLE?>){$('#contenedor-datos-adicionales-select').show();}else{$('#contenedor-datos-adicionales-select').hide();}">
											<option value="">Seleccione Tipo</option>
											<?php foreach ($arrTipoCampo as $tipo_campo) : ?>
												<option value="<?php echo $tipo_campo->id_tipo ?>"><?php echo $tipo_campo->gl_nombre ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group small" id="contenedor-datos-adicionales-select" style="display:none;">
									<div class="col-xs-12">
										<label>Agregue las Opciones separadas por una coma (",")</label>
										<input type="text" class="form-control datos-adicionales" id="gl_opciones" name="gl_opciones" placeholder="Opcion1, Opcion2, Opcion3, ..." />
									</div>
								</div>

								<div class="form-group small">
									<div class="col-xs-12 text-right">
										<button type="button" class="btn btn-warning btn-sm btn-flat" onclick="MantenedorCampana.agregarDatosAdicionales();"><i class="fa fa-plus"></i> Agregar</button>
										<button type="button" class="btn btn-default btn-sm btn-flat" onclick="$('#contenedor-form-datos-adicionales').slideUp();$('.datos-adicionales').val('');"><i class="fa fa-arrow-up"></i></button>
									</div>
								</div>
							</div>
						</div>

						<div class="row" id="contenedor-datos-adicionales">
							<label>Datos adicionales</label>
							<table class="table table-bordered table-condensed small" id="tabla-datos-adicionales">
								<thead>
									<tr>
										<th>Tipo</th>
										<th>Nombre</th>
										<th>Opciones</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php if (isset($arr_campos_especificos) and count($arr_campos_especificos) > 0) :?>
										<?php foreach ($arr_campos_especificos as $campo) :?>
											<tr>
											<td class="text-center" width="15%"><?php echo $campo['nombre_tipo_campo_adicional']?></td>
											<td class="text-center"><?php echo $campo['nombre_campo_adicional']?> <i class="fa fa-info-circle" data-toggle="tooltip" title="<?php echo $campo['descripcion_campo_adicional']?>"></i></td>
											<td class="text-center"><?php echo $campo['opciones_campo_adicional']?></td>
											<td class="text-center" width="5%"><button type="button" class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove();"><i class="fa fa-trash-o"></i></button></td>
											<input type="hidden" name="nombre_campo_adicional[]" class="datos-adicionales-nombres" value="<?php echo $campo['nombre_campo_adicional']?>" />
											<input type="hidden" name="descripcion_campo_adicional[]" value="<?php echo $campo['descripcion_campo_adicional']?>" />
											<input type="hidden" name="tipo_campo_adicional[]" value="<?php echo $campo['tipo_campo_adicional']?>" />
											<input type="hidden" name="nombre_tipo_campo_adicional[]" value="<?php echo $campo['nombre_tipo_campo_adicional']?>" />
											<input type="hidden" name="opciones_campo_adicional[]" value="<?php echo $campo['opciones_campo_adicional']?>" />
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>

						</div>


						<div class="row">
							<div class="col-xs-12 text-right">
								<div class="form-group">
									<button class="btn btn-success" type="button" onclick="MantenedorCampana.agregarCampana(this.form,this);"><i class="fa fa-save"></i> Guardar </button>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>

		</form>
	</div>

</div>


