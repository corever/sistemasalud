
<div class="card card-primary" style="border-style: solid; border-width: 1px; border-color: #ccdcf9; background: #ddf2ff;">
	<div class="card-header" style="background: #1e77ab;">
		<div class="card-title">
			<h6><b>DATOS PERSONALES</b></h6>
		</div>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse">
			<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<div class="row top-spaced">
			<div class="col-1">
				<label for="gl_rut" class="control-label required-left">RUT</label>
			</div>
			<div class="col-5">
				<input readonly type="text" class="form-control"  id="gl_rut" name="gl_rut" value="<?php echo isset($rut)?($rut):"";?>"
					onkeyup="formateaRut(this), this.value = this.value.toUpperCase()"/>
			</div>
		</div>
		<div class="row top-spaced">
			<div class="col-1">
				<label for="gl_nombre" class="control-label required-left"><?php echo \Traduce::texto("Nombre"); ?></label>
			</div>
			<div class="col-5">
				<input type="text" class="form-control" id="gl_nombre" name="gl_nombre" maxlength="20" onkeypress="return soloLetras(event)" value="<?php echo (isset($arr->gl_nombres))?$arr->gl_nombres:""; ?>"
					<?php echo (isset($arr->gl_rut) && isset($arr->bo_ws_validado) && $arr->bo_ws_validado)?"readonly":""; ?> onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
			</div>
		</div>
		<div class="row top-spaced">
			<div class="col-1">
				<label for="gl_apellido_paterno" class="control-label required-left"><?php echo \Traduce::texto("Apellido Paterno"); ?></label>
			</div>
			<div class="col-5">
				<input type="text" class="form-control" id="gl_apellido_paterno" maxlength="35" name="gl_apellido_paterno" onkeypress="return soloLetras(event)" value="<?php echo (isset($arr->gl_apellido_paterno))?$arr->gl_apellido_paterno:""; ?>"
					<?php echo (isset($arr->gl_rut) && isset($arr->bo_ws_validado) && $arr->bo_ws_validado)?"readonly":""; ?> onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
			</div>
			<div class="col-1">
				<label for="gl_apellido_materno" class="control-label required-left"><?php echo \Traduce::texto("Apellido Materno"); ?></label>
			</div>
			<div class="col-5">
				<input type="text" class="form-control" id="gl_apellido_materno" maxlength="35" name="gl_apellido_materno" onkeypress="return soloLetras(event)" value="<?php echo (isset($arr->gl_apellido_materno))?$arr->gl_apellido_materno:""; ?>"
					<?php echo (isset($arr->gl_rut) && isset($arr->bo_ws_validado) && $arr->bo_ws_validado)?"readonly":""; ?> onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
			</div>
		</div>
		<div class="row top-spaced">
			<div class="col-1">
				<label for="fc_nacimiento" class="control-label required-left"><?php echo \Traduce::texto("Fecha Nacimiento"); ?></label>
			</div>
			<div class="col-5">
				<div class="input-group">
					<input type="text" data-date-format='yy-mm-dd'  class="form-control float-left datepicker" id="fc_nacimiento" name="fc_nacimiento" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
					<div class="input-group-prepend">
						<span class="input-group-text">
						<i class="far fa-calendar-alt"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="col-1">
				<label for="gl_email" class="control-label required-left">Email</label>
			</div>
			<div class="col-5">
				<input readonly type="text" maxlength="70" class="form-control" id="gl_email" name="gl_email" onblur="validaEmail(this, 'Correo Inválido!')" value= "<?php echo isset($email)?($email):"";?>" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
			</div>
		</div>
		<div class="row top-spaced">
			<div class="col-1">
				<label for="id_profesion_dt" class="control-label required-left"><?php echo \Traduce::texto("Profesión"); ?></label>
			</div>
			<div class="col-5">
				<select class="form-control" id="id_profesion_dt" name="id_profesion_dt" >
					<?php if (!isset($arrProfesion) || count((array) $arrProfesion) == 0 || count((array) $arrProfesion) > 1) : ?>
					<option value="0">Seleccione Profesión</option>
					<?php endif; ?>
					<?php if (isset($arrProfesion) && is_array($arrProfesion)) : foreach ($arrProfesion as $key => $profesion) : 
						if($profesion->id_profesion==1 || $profesion->id_profesion==6){?>
					<option value="<?php echo $profesion->id_profesion ?>"><?php echo $profesion->nombre_profesion; ?></option>
					<?php } ?>
					<?php endforeach;
						endif; ?>
				</select>
			</div>
		</div>
		<div class="row top-spaced">
			<div class="col-2">
				<label class="control-label required-left">Certificado de título</label>
			</div>
			<div class="col-4">
				<div class="row">
					<div class="col-6">
						<label><input type="radio" class="labelauty" id="chk_certificado_n" name="chk_certificado_titulo" value="N"  data-labelauty="Ingresar N° de Registro" /></label>
					</div>
					<div class="col-6">
						<label><input type="radio" class="labelauty" id="chk_certificado_s" name="chk_certificado_titulo" value="A" data-labelauty="Adjuntar certificado" /></label>
					</div>
				</div>
			</div>
			<div id="div_n_registro" class="row col-6" style="display:none">
				<div class="col-2">
					<label class="control-label required-left">N° de Registro </label>
				</div>
				<div class="col-10">
					<input type="text"  maxlength="30" class="form-control"  id="nr_titulo" name="nr_titulo" onkeypress="return soloNumeros(event)" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
				</div>
			</div>
			<div id="div_archivo_titulo" class="row col-6" style="display:none">
				<div class="col-2">
					<label for="btnAdjuntar" class="control-label required-left">Certificado de Título</label>
				</div>
				<div class="col-10">
					<?php echo $grillaTituloDT; ?>
				</div>
			</div>
		</div>
		<div id="div_general_0" class="top-spaced">
			<div id="direccion" class="listaConsultas">
				<div class="row">
				</div>
				<div class="row top-spaced">
					<div class="col-1">
						<label class="control-label required-left">Región</label>
					</div>
					<div class="col-5">
						<?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : 
							if($id_region == $region->id_region_midas){									
							?>

						<input readonly class="form-control" name="gl_region_dt" id="gl_region_dt" region_id="<?php echo $region->id_region_midas ?>" value="<?php echo $region->nombre_region_corto; ?>"></input>
						<input hidden name="id_region_dt" id="id_region_dt" value="<?php echo $region->id_region_midas ?>"/>
						<?php }
							endforeach;
							endif; ?>
					</div>

					<div class="col-1">
						<label class="control-label required-left">Comuna</label>
					</div>
					<div class="col-5">
						<select name="id_comuna_dt" id="id_comuna_dt" class="form-control" value="" required>
							<?php if (!isset($arrComuna) || count((array) $arrComuna) == 0 || count((array) $arrComuna) > 1) : ?>
							<option value="0">Seleccione Comuna</option>
							<?php endif; ?>
							<?php 
								if (isset($arrComuna) && is_array($arrComuna)) : foreach ($arrComuna as $key => $comuna) : 
								    if($comuna->id_region_midas==$id_region){?>
							<option value="<?php echo $comuna->comuna_id ?>" data-region="<?php echo $comuna->comuna_id ?>"><?php echo $comuna->comuna_nombre; ?></option>
							<?php
								} 
								
								endforeach;
								endif; ?>
						</select>
					</div>
				</div>
				<div class ="row top-spaced">
					<div class="col-1">
						<label class="control-label required-left">Dirección</label>
					</div>
					<div class="col-5">
						<input type="text"  maxlength="45" class="form-control" name="direccion_dt" id="direccion_dt" required onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
					</div>
					<div class="col-1">
						<label class="control-label required-left">Teléfono</label>
					</div>
					<div class="col-5">
						<input type="text"  maxlength="15" class="form-control" name="telefono_dt" id="telefono_dt" onkeypress="return soloNumeros(event)" required onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
					</div>
				</div>
				<br>
				<text hidden></text>
			</div>
		</div>
	</div>
</div>
