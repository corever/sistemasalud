<?php if($mostrar_ruta):?>
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Farmacias</a></li>
				<li class="breadcrumb-item"><a href="<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Farmacias/Empresa/">Empresas Farmac&eacute;uticas</a></li>
				<li class="breadcrumb-item active">Crear Empresa</li>
			</ol>
			</div>
		</div>
	</div>
</section>
<?php endif;?>

<section class="content">
	<div class="container-fluid">
		<div class="row mb-2 mt-3">
			<div class="col-12">
				<div class="card card-primary">
					<div class="card-body">
						<form id="formCrearEmpresa">
							
							<input type="hidden" id="gl_token" name="gl_token" value="<?php echo $empresa->gl_token; ?>"/>
	
							<?php if($bo_editar):?>
								<input type="hidden" id="ori_farmacia_razon_social"				name="ori_farmacia_razon_social"			value="<?php echo $empresa->farmacia_razon_social; ?>"/>
								<input type="hidden" id="ori_farmacia_nombre_fantasia"			name="ori_farmacia_nombre_fantasia"			value="<?php echo $empresa->farmacia_nombre_fantasia; ?>"/>
								<input type="hidden" id="ori_farmacia_nombre_representante"		name="ori_farmacia_nombre_representante"	value="<?php echo $empresa->farmacia_nombre_representante; ?>"/>
								<input type="hidden" id="ori_farmacia_rut_representante_midas"	name="ori_farmacia_rut_representante_midas"	value="<?php echo $empresa->farmacia_rut_representante_midas; ?>"/>
								<input type="hidden" id="ori_farmacia_direccion"				name="ori_farmacia_direccion"				value="<?php echo $empresa->farmacia_direccion; ?>"/>
								<input type="hidden" id="ori_fk_comuna"							name="ori_fk_comuna"						value="<?php echo $empresa->fk_comuna; ?>"/>
								<input type="hidden" id="ori_farmacia_fono_codigo"				name="ori_farmacia_fono_codigo"				value="<?php echo $empresa->farmacia_fono_codigo; ?>"/>
								<input type="hidden" id="ori_farmacia_fono"						name="ori_farmacia_fono"					value="<?php echo $empresa->farmacia_fono; ?>"/>
								<input type="hidden" id="original_id_caracter"					name="original_id_caracter"					value="<?php echo $empresa->id_caracter; ?>"/>
							<?php endif;?>
						
							<div class="row top-spaced">
								<div class="col-2">
									<label for="farmacia_caracter" class="control-label required-left">
										Car&aacute;cter
									</label>
								</div>
								<div class="col-4">
									<select class="form-control" id="farmacia_caracter" name="farmacia_caracter" required>
										<option value="">Seleccione</option>
										<?php foreach($arr_caracter as $item): ?>
											<option value="<?php echo $item->id_caracter ?>" <?php echo ($empresa->id_caracter == $item->id_caracter)?"selected":""; ?>>
												<?php echo $item->gl_nombre;?>
											</option>
										<?php endforeach;?>
									</select>
								</div>
							</div>

							<hr/>

							<div class="row top-spaced">
								<div class="col-2">
									<label for="gl_rut" class="control-label required-left">
										RUT
									</label>
								</div>
								<div class="col-4">
									<input type="text" class="form-control" id="gl_rut" name="gl_rut" placeholder="Ingrese RUT" required
										value="<?php	echo $empresa->farmacia_rut_midas;?>" onblur="Valida_Rut(this);"
										<?php if($bo_editar):?>
											readonly
										<?php endif;?>
										onkeyup="formateaRut(this), this.value = this.value.toUpperCase()" onkeypress="return soloNumerosYK(event)"/>
								</div>
							</div>

							<div class="row top-spaced">
								<div class="col-2">
									<label for="gl_razon_social" class="control-label required-left">
										Raz&oacute;n Social
									</label>
								</div>
								<div class="col-4">
									<input type="text" class="form-control" id="gl_razon_social" name="gl_razon_social" required
										placeholder="Razón Social" value="<?php echo $empresa->farmacia_razon_social; ?>"/>
								</div>
								<div class="col-2">
									<label for="gl_nombre_fantasia" class="control-label required-left">
										Nombre de Fantas&iacute;a
									</label>
								</div>
								<div class="col-4">
									<input type="text" class="form-control" id="gl_nombre_fantasia" name="gl_nombre_fantasia" required
										placeholder="Nombre de Fantas&iacute;a" value="<?php echo $empresa->farmacia_razon_social; ?>"/>
								</div>
							</div>

							<hr/>

							<div class="row top-spaced">
								<div class="col-2">
									<label for="gl_rut_representante" class="control-label required-left">
										RUN Representante Legal
									</label>
								</div>
								<div class="col-4">
									<input type="text" class="form-control" id="gl_rut_representante" name="gl_rut_representante" required
										placeholder="Ingrese RUN" value="<?php	echo $empresa->farmacia_rut_representante_midas;?>" 
										onkeyup="formateaRut(this), this.value = this.value.toUpperCase()" onkeypress="return soloNumerosYK(event)"
										onblur="Valida_Rut(this);Utils.cargarPersonaWS(this.value,'gl_nombres_representante');"/>
								</div>
							</div>

							<div class="row top-spaced">
								<div class="col-2">
									<label for="gl_nombres_representante" class="control-label required-left">
										Nombre Representante Legal
									</label>
								</div>
								<div class="col-10">
									<input type="text" class="form-control" id="gl_nombres_representante" name="gl_nombres_representante" required
										placeholder="Ingrese Nombres del Representante" value="<?php echo $empresa->farmacia_nombre_representante; ?>"/>
								</div>
								<div class="col-2" hidden>
									<label for="gl_apellidos_representante" class="control-label required-left">
										Apellidos Representante Legal
									</label>
								</div>
								<div class="col-4" hidden>
									<input type="text" class="form-control" id="gl_apellidos_representante" name="gl_apellidos_representante" required
										placeholder="Ingrese Apellidos del Representante" value="<?php //echo $empresa->farmacia_razon_social; ?>"/>
								</div>
							</div>

							<hr/>

							<div class="row top-spaced">
								<div class="col-2">
									<label for="id_region" class="control-label required-left">
										Regi&oacute;n
									</label>
								</div>
								<div class="col-4">
									<select class="form-control" id="id_region" name="id_region" required
										onchange="Region.cargarComunasPorRegion(this.value,'id_comuna',<?php echo (isset($arr->id_comuna))?$arr->id_comuna:''; ?>);
										Region.cargarCodigosFonoPorRegion(this.value,'id_codigo_fono',<?php echo (isset($empresa->farmacia_fono_codigo))?$empresa->farmacia_fono_codigo:''; ?>)">
										<?php if($bo_editar):?>
											<?php foreach($arrRegion as $item): ?>
												<?php if($empresa->fk_region == $item->id_region_midas):?>
													<option value="<?php echo $item->id_region_midas ?>" <?php echo ($empresa->id_region_midas == $item->id_region_midas)?"selected":""; ?> >
														<?php echo $item->nombre_region_corto ?>
													</option>
												<?php endif;?>
											<?php endforeach;?>
										<?php else:?>
											<option value="0">Seleccione Región</option>
											<?php foreach($arrRegion as $item): ?>
												<option value="<?php echo $item->id_region_midas ?>" <?php echo ($empresa->id_region_midas == $item->id_region_midas)?"selected":""; ?> >
													<?php echo $item->nombre_region_corto ?>
												</option>
											<?php endforeach;?>
										<?php endif;?>
									</select>
								</div>
								<div class="col-2">
									<label for="id_comuna" class="control-label required-left">
										Comuna
									</label>
								</div>
								<div class="col-4">
									<select class="form-control" id="id_comuna" name="id_comuna" onchange="Region.cambioRegionPorComuna('id_comuna','id_region');" required>
										<?php if(empty($empresa)):?>
											<option value="0">Seleccione una Región</option>
										<?php else:?>
											<?php foreach($arrComuna as $item): ?>
												<option value="<?php echo $item->id_comuna_midas ?>" data-region="<?php echo $item->id_region_midas ?>" <?php echo ($empresa->id_comuna_midas == $item->id_comuna_midas)?"selected":""; ?> ><?php echo $item->comuna_nombre ?></option>
											<?php endforeach;?>
										<?php endif;?>
									</select>
								</div>
							</div>

							<div class="row top-spaced">
								<div class="col-2">
									<label for="gl_direccion" class="control-label required-left">
										Direcci&oacute;n
									</label>
								</div>
								<div class="col-4">
									<input type="text" class="form-control" id="gl_direccion" name="gl_direccion" required
										placeholder="Ingrese Nombre del Representante" value="<?php echo $empresa->farmacia_direccion; ?>"/>
								</div>
								<div class="col-2">
									<label for="gl_fono" class="control-label">
										Tel&eacute;fono
									</label>
								</div>
								<div class="col-4 form-row">
									<select class="form-control col-4" id="id_codigo_fono" name="id_codigo_fono">
										<option value="0">Seleccione</option>
										<?php foreach($arrCodfono as $item): ?>
											<option value="<?php echo $item->codfono_id ?>" <?php echo ($empresa->farmacia_fono_codigo == $item->codigo)?"selected":""; ?>
												data-codigo="<?php echo $item->codigo;?>">
												<?php echo $item->codigo_formato ?>
											</option>
										<?php endforeach;?>
									</select>
									<input type="text" class="form-control col-8" id="gl_fono" name="gl_fono" value="<?php echo $empresa->farmacia_fono; ?>"
									onkeypress="return soloNumerosYK(event)"/>
								</div>
							</div>
						</form>
					</div>

					<div class="top-spaced">&nbsp;</div>

					<div class="card-footer text-right top-spaced">
						<button type="button" class="btn btn-sm btn-danger"
							onclick="xModal.close()"
							data-toggle="tooltip" title="Cancelar"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar
						</button>
						<button type="button" class="btn btn-sm btn-success"
							<?php if($bo_editar):?>
								onclick="maestro_empresa.guardarEdicion()"
							<?php else:?>
								onclick="maestro_empresa.guardarEmpresa()"
							<?php endif;?>
							data-toggle="tooltip" title="Guardar"><i class="fa fa-save"></i>&nbsp;&nbsp;Guardar
						</button>
					</div>
				</div>
			</div>

			
		</div>
	</div>
</section>