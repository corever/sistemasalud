<div class="card card-primary">
	<div class="card-header"> Datos Medico </div>
	<div class="card-body">
        <div class="row">
            <div class="col-sm-9">
                <label for="gl_rut_medico" class="control-label required-left">RUT</label>
                <input type="text" class="form-control" id="gl_rut_medico" name="gl_rut_medico" value="<?php echo (isset($arr->gl_rut))?$arr->gl_rut:""; ?>"
                    onkeyup="formateaRut(this), this.value = this.value.toUpperCase()" onkeypress="return soloNumerosYK(event)" <?php echo (isset($arr->gl_rut))?"readonly":""; ?>
                    onblur="Valida_Rut(this); Utils.cargarPersonaWS(this.value,'gl_nombre','gl_apellido_paterno','gl_apellido_materno');" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="gl_nombre_medico" class="control-label required-left"><?php echo \Traduce::texto("Nombre"); ?></label>
                <input type="text" class="form-control" id="gl_nombre_medico" name="gl_nombre_medico" value="<?php echo (isset($arr->gl_nombres))?$arr->gl_nombres:""; ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="gl_apellido_paterno_medico" class="control-label required-left"><?php echo \Traduce::texto("Apellido Paterno"); ?></label>
                <input type="text" class="form-control" id="gl_apellido_paterno_medico" name="gl_apellido_paterno_medico" value="<?php echo (isset($arr->gl_apellido_paterno))?$arr->gl_apellido_paterno:""; ?>"/>
            </div>
            <div class="col-sm-6">
                <label for="gl_apellido_materno_medico" class="control-label required-left"><?php echo \Traduce::texto("Apellido Materno"); ?></label>
                <input type="text" class="form-control" id="gl_apellido_materno_medico" name="gl_apellido_materno_medico" value="<?php echo (isset($arr->gl_apellido_materno))?$arr->gl_apellido_materno:""; ?>"/>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="id_profesion_medico" class="control-label">Profesión</label>
                <select class="form-control" id="id_profesion_medico" name="id_profesion_medico" >
                    <?php if (!isset($arrProfesion) || count((array) $arrProfesion) == 0 || count((array) $arrProfesion) > 1) : ?>
                        <option value="0">Seleccione una Profesión</option>
                    <?php endif; ?>
                    <?php if (isset($arrProfesion) && is_array($arrProfesion)) : foreach ($arrProfesion as $key => $profesion) : ?>
                            <option value="<?php echo $profesion->id_profesion; ?>" <?php echo (isset($arr->id_profesion) && $arr->id_profesion == $profesion->id_profesion)?"selected":""; ?> ><?php echo $profesion->nombre_profesion; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
						<div class="col-sm-6">
								<label for="id_especialidad_medico" class="control-label">Especialidad</label>
								<select class="form-control" id="id_espacialidad_medico" name="id_especialidad_medico" >
                    <?php if (!isset($arrEspecialidad) || count((array) $arrEspecialidad) == 0 || count((array) $arrEspecialidad) > 1) : ?>
                        <option value="0">Seleccione una Especialidad</option>
                    <?php endif; ?>
                    <?php if (isset($arrEspecialidad) && is_array($arrEspecialidad)) : foreach ($arrEspecialidad as $key => $especialidad) : ?>
                            <option value="<?php echo $especialidad->id_especialidad; ?>" <?php echo (isset($arr->id_especialidad) && $arr->id_especialidad == $especialidad->id_especialidad)?"selected":""; ?> ><?php echo $especialidad->especialidad_nombre; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
						</div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label class="control-label required-left">Género</label>
                <div class="row">
                    <div class="col-sm-6">
                        <label><input type="radio" class="labelauty" id="chk_genero_medico_m" name="chk_genero_medico" value="M" <?php echo ($arr->chk_genero == "M")?"checked":""; ?> data-labelauty="Masculino" /></label>
                    </div>
                    <div class="col-sm-6">
                        <label><input type="radio" class="labelauty" id="chk_genero_medico_f" name="chk_genero_medico" value="F" <?php echo ($arr->chk_genero == "F")?"checked":""; ?> data-labelauty="Femenino" /></label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <label for="fc_nacimiento_medico" class="control-label required-left"><?php echo \Traduce::texto("Fecha Nacimiento"); ?></label>
                <div class="input-group">
                    <input type="text" readonly class="form-control float-left datepicker" id="fc_nacimiento_medico" name="fc_nacimiento_medico"
                           value="<?php echo (isset($arr->fc_nacimiento))?\Fechas::formatearHtml($arr->fc_nacimiento):""; ?>" autocomplete="off">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="gl_email_medico" class="control-label required-left">Email</label>
                <input type="text" class="form-control" id="gl_email_medico" name="gl_email_medico" onblur="validaEmail(this, 'Correo Inválido!')"
                       value="<?php echo (isset($arr->gl_email))?$arr->gl_email:""; ?>"/>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="id_region_medico" class="control-label required-left"><?php echo \Traduce::texto("Región"); ?></label>
                <select class="form-control" id="id_region_medico" name="id_region_medico" onchange="Region.cargarComunasPorRegion(this.value,'id_comuna_usuario',<?php echo (isset($arr->id_comuna))?$arr->id_comuna:''; ?>);" >
                    <?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
                        <option value="0">Seleccione una Región</option>
                    <?php endif; ?>
                    <?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
                            <option value="<?php echo $region->region_id ?>" <?php echo (isset($arr->id_region) && $arr->id_region == $region->region_id)?"selected":""; ?> ><?php echo $region->nombre_region_corto; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="col-sm-6">
                <label for="id_comuna_medico" class="control-label required-left"><?php echo \Traduce::texto("Comuna"); ?></label>
                <select class="form-control" id="id_comuna_medico" name="id_comuna_medico"     >
                    <?php if (!isset($arrComuna) || count((array) $arrComuna) == 0 || count((array) $arrComuna) > 1) : ?>
                        <option value="0">Seleccione una Comuna</option>
                    <?php endif; ?>
                    <?php if (isset($arrComuna) && is_array($arrComuna)) : foreach ($arrComuna as $key => $comuna) : ?>
                            <option value="<?php echo $comuna->comuna_id ?>" data-region="<?php echo $comuna->fk_region ?>" <?php echo (isset($arr->id_comuna) && $arr->id_comuna == $comuna->comuna_id)?"selected":""; ?> ><?php echo $comuna->comuna_nombre; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="gl_direccion_medico" class="control-label required-left">Dirección</label>
                <input type="text" class="form-control" id="gl_direccion_medico" name="gl_direccion_medico"
                       value="<?php echo (isset($arr->gl_direccion))?$arr->gl_direccion:""; ?>"/>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <label for="id_codregion_medico" class="control-label required-left">Código Teléfono</label>
                <select class="form-control" id="id_codregion_medico" name="id_codregion_medico" >
                    <?php if (!isset($arrCodRegion) || count((array) $arrCodRegion) == 0 || count((array) $arrCodRegion) > 1) : ?>
                        <option value="0">Seleccione código</option>
                    <?php endif; ?>
                    <?php if (isset($arrCodRegion) && is_array($arrCodRegion)) : foreach ($arrCodRegion as $key => $codRegion) : ?>
                            <option value="<?php echo $codRegion->codfono_id ?>" data-region="<?php echo $codRegion->fk_region; ?>" <?php echo (isset($arr->id_codfono) && $arr->id_codfono == $codRegion->codfono_id)?"selected":""; ?> ><?php echo $codRegion->codigo ." (".$codRegion->provincia.")"; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="col-sm-6">
                <label for="gl_telefono_medico" class="control-label required-left"><?php echo \Traduce::texto("Teléfono"); ?></label>
                <input type="text" class="form-control" id="gl_telefono_medico" name="gl_telefono_medico" value="<?php echo (isset($arr->gl_telefono))?$arr->gl_telefono:""; ?>"/>
            </div>
        </div>
	</div>
	<div class="card-header"> Datos Consulta </div>
	<div class="card-body">
	<div class="row">
			<div class="col-sm-6">
					<label for="id_region_consulta" class="control-label required-left"><?php echo \Traduce::texto("Región"); ?></label>
					<select class="form-control" id="id_region_consulta" name="id_region_consulta" onchange="Region.cargarComunasPorRegion(this.value,'id_comuna_usuario',<?php echo (isset($arr->id_comuna))?$arr->id_comuna:''; ?>);" >
							<?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
									<option value="0">Seleccione una Región</option>
							<?php endif; ?>
							<?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
											<option value="<?php echo $region->region_id ?>" <?php echo (isset($arr->id_region) && $arr->id_region == $region->region_id)?"selected":""; ?> ><?php echo $region->nombre_region_corto; ?></option>
							<?php endforeach;
							endif; ?>
					</select>
			</div>
			<div class="col-sm-6">
					<label for="id_comuna_consulta" class="control-label required-left"><?php echo \Traduce::texto("Comuna"); ?></label>
					<select class="form-control" id="id_comuna_consulta" name="id_comuna_consulta"     >
							<?php if (!isset($arrComuna) || count((array) $arrComuna) == 0 || count((array) $arrComuna) > 1) : ?>
									<option value="0">Seleccione una Comuna</option>
							<?php endif; ?>
							<?php if (isset($arrComuna) && is_array($arrComuna)) : foreach ($arrComuna as $key => $comuna) : ?>
											<option value="<?php echo $comuna->comuna_id ?>" data-region="<?php echo $comuna->fk_region ?>" <?php echo (isset($arr->id_comuna) && $arr->id_comuna == $comuna->comuna_id)?"selected":""; ?> ><?php echo $comuna->comuna_nombre; ?></option>
							<?php endforeach;
							endif; ?>
					</select>
			</div>
	</div>
	<div class="row">
			<div class="col-sm-12">
					<label for="gl_direccion_consulta" class="control-label required-left">Dirección</label>
					<input type="text" class="form-control" id="gl_direccion_consulta" name="gl_direccion_consulta"
								 value="<?php echo (isset($arr->gl_direccion))?$arr->gl_direccion_consulta:""; ?>"/>
			</div>
	</div>
	<div class="row">
			<div class="col-sm-3">
					<label for="id_codregion_consulta" class="control-label required-left">Código Teléfono</label>
					<select class="form-control" id="id_codregion_consulta" name="id_codregion_consulta" >
							<?php if (!isset($arrCodRegion) || count((array) $arrCodRegion) == 0 || count((array) $arrCodRegion) > 1) : ?>
									<option value="0">Seleccione código</option>
							<?php endif; ?>
							<?php if (isset($arrCodRegion) && is_array($arrCodRegion)) : foreach ($arrCodRegion as $key => $codRegion) : ?>
											<option value="<?php echo $codRegion->codfono_id ?>" data-region="<?php echo $codRegion->fk_region; ?>" <?php echo (isset($arr->id_codfono) && $arr->id_codfono == $codRegion->codfono_id)?"selected":""; ?> ><?php echo $codRegion->codigo ." (".$codRegion->provincia.")"; ?></option>
							<?php endforeach;
							endif; ?>
					</select>
			</div>
			<div class="col-sm-6">
					<label for="gl_telefono_consulta" class="control-label required-left"><?php echo \Traduce::texto("Teléfono"); ?></label>
					<input type="text" class="form-control" id="gl_telefono_consulta" name="gl_telefono_consulta" value="<?php echo (isset($arr->gl_telefono_consulta))?$arr->gl_telefono_consulta:""; ?>"/>
			</div>
	</div>
	</div>
</div>
