<div class="card card-primary">
	<div class="card-header"> Datos Medico </div>
	<div class="card-body">
	<div class="row" id="form_nuevo_medico">
            <div class="col-2">
                <label for="gl_rut_medico" class="control-label required-left">RUT Medico</label>
            </div>
            <div class="col-4">
                <input type="text" class="form-control"  id="gl_rut_medico" name="gl_rut_medico" value="<?php echo (isset($arr->gl_rut))?$arr->gl_rut:""; ?>"
                    onkeyup="formateaRut(this), this.value = this.value.toUpperCase()" onkeypress="return soloNumerosYK(event)" <?php echo (isset($arr->gl_rut))?"readonly":""; ?>
                    onblur="Valida_Rut(this); Utils.cargarPersonaWS(this.value,'gl_nombre_medico','gl_apellido_paterno_medico','gl_apellido_materno_medico');" />
            </div>

            <div class="col-2">
				<label for="gl_email_medico" class="control-label required-left">Email</label>
            </div>
            <div class="col-4">
				<input type="text" class="form-control" id="gl_email_medico" name="gl_email_medico" onblur="validaEmail(this, 'Correo Inválido!')"
						value="<?php echo (isset($arr->gl_email))?$arr->gl_email:""; ?>"/>
            </div>    
        </div>

		
        <div class="row top-spaced">
            <div class="col-2">
				<label for="fc_nacimiento_medico" class="control-label required-left"><?php echo \Traduce::texto("Fecha Nacimiento"); ?></label>
            </div>
            <div class="col-4">
				<div class="input-group">
                    <input type="text" data-date-format='yy-mm-dd'  class="form-control float-left datepicker" id="fc_nacimiento_medico" name="fc_nacimiento_medico"
                           value="<?php echo (isset($arrDatosMedico->fc_nacimiento))?\Fechas::formatearHtml($arrDatosMedico->fc_nacimiento):""; ?>" autocomplete="off">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>


		<div class="row top-spaced">
            <div class="col-2">
                <label for="id_profesion_medico" class="control-label required-left"><?php echo \Traduce::texto("Profesión"); ?></label>
            </div>
            <div class="col-4">
                <select class="form-control" id="id_profesion_medico" name="id_profesion_medico" >
                    <?php if (!isset($arrProfesion) || count((array) $arrProfesion) == 0 || count((array) $arrProfesion) > 1) : ?>
                        <option value="0">Seleccione Profesión</option>
                    <?php endif; ?>
                    <?php if (isset($arrProfesion) && is_array($arrProfesion)) : foreach ($arrProfesion as $key => $profesion) : 
                            if($profesion->id_profesion==2){?>
                            <option value="<?php echo $profesion->id_profesion ?>"><?php echo $profesion->nombre_profesion; ?></option>
                      <?php } ?>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="col-2">
                <label for="id_especialidad_medico" class="control-label required-left"><?php echo \Traduce::texto("Especialidad"); ?></label>
            </div>
            <div class="col-4">
                <select class="form-control" id="id_especialidad_medico" name="id_especialidad_medico">
                    <?php if (!isset($arrEspecialidad) || count((array) $arrEspecialidad) == 0 || count((array) $arrEspecialidad) > 1) : ?>
                        <option value="0">Seleccione Especialidad</option>
                    <?php endif; ?>
                    <?php if (isset($arrEspecialidad) && is_array($arrEspecialidad)) : foreach ($arrEspecialidad as $key => $especialidad) : ?>
                            <option value="<?php echo $especialidad->id_especialidad ?>" data-region="<?php echo $especialidad->id_especialidad ?>"><?php echo $especialidad->gl_especialidad; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
        </div>

        <div class="row top-spaced">

            <div class="col-2">
                <label for="gl_nombre_medico" class="control-label required-left"><?php echo \Traduce::texto("Nombre"); ?></label>
            </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_nombre_medico" name="gl_nombre_medico" onkeypress="return soloLetras(event)" value="<?php echo (isset($arr->gl_nombres))?$arr->gl_nombres:""; ?>"
                    <?php echo (isset($arr->gl_rut) && isset($arr->bo_ws_validado) && $arr->bo_ws_validado)?"readonly":""; ?> />
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label for="gl_apellido_paterno_medico" class="control-label required-left"><?php echo \Traduce::texto("Apellido Paterno"); ?></label>
                </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_apellido_paterno_medico" name="gl_apellido_paterno_medico" onkeypress="return soloLetras(event)" value="<?php echo (isset($arr->gl_apellido_paterno))?$arr->gl_apellido_paterno:""; ?>"
                    <?php echo (isset($arr->gl_rut) && isset($arr->bo_ws_validado) && $arr->bo_ws_validado)?"readonly":""; ?>/>
            </div>
            <div class="col-2">
                <label for="gl_apellido_materno_medico" class="control-label required-left"><?php echo \Traduce::texto("Apellido Materno"); ?></label>
                </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_apellido_materno_medico" name="gl_apellido_materno_medico" onkeypress="return soloLetras(event)" value="<?php echo (isset($arr->gl_apellido_materno))?$arr->gl_apellido_materno:""; ?>"
                    <?php echo (isset($arr->gl_rut) && isset($arr->bo_ws_validado) && $arr->bo_ws_validado)?"readonly":""; ?>/>
            </div>
        </div>



        <div class="row top-spaced">
         


            <div class="col-2">
                <label class="control-label required-left">Género</label>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-sm-6">
                        <label><input type="radio" class="labelauty" id="chk_genero_medico_m" name="chk_genero_medico" value="M" <?php echo ($arr->chk_genero == "M")?"checked":""; ?> data-labelauty="Masculino" /></label>
                    </div>
                    <div class="col-sm-6">
                        <label><input type="radio" class="labelauty" id="chk_genero_medico_f" name="chk_genero_medico" value="F" <?php echo ($arr->chk_genero == "F")?"checked":""; ?> data-labelauty="Femenino" /></label>
                    </div>
                </div>
            </div>
        </div>
<!-- codigo de inputs dinamicos -->

			
		<form method="POST">
			
			<input type="button" class="btn btn-success" value="Agregar Consulta +" onClick="MantenedorMedico.addInput('dynamicInput');">
			<div id="div_general_0" class="top-spaced" style="border-style: solid; border-width: 1px; border-color: #ced4da;">
				<div id="dynamicInput" class="listaConsultas" style="background: #007bff21;">
                <div class="row">
                    <div class="col-6">
						<label class="control-label left" id="gl_consulta_0">Datos Consulta 1 :</label>
					</div>
                    <div class="col-6">
				        <button style="display:none; float:right;" class="btn btn-danger eliminarConsulta" id="eliminarConsulta_0" onClick="MantenedorMedico.removeInput(this);"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </div>
                </div>
				<div class="row top-spaced">
					<div class="col-1">
							<label class="control-label required-left">Region</label>
					</div>
					<div class="col-5">
						<select id="selectRegion_0" class="form-control">
							<?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
								<option value="0">Seleccione una Región</option>
							<?php endif; ?>
							<?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
									<option value="<?php echo $region->region_id ?>" <?php echo (isset($arr->id_region) && $arr->id_region == $region->region_id)?"selected":""; ?> ><?php echo $region->nombre_region_corto; ?></option>
							<?php endforeach;
							endif; ?>
						</select>
					</div>
					<div class="col-1">
						<label class="control-label required-left">Comuna</label>
					</div>
					<div class="col-5">
						<select id="selectComuna_0" class="form-control">
								<?php if (!isset($arrComuna) || count((array) $arrComuna) == 0 || count((array) $arrComuna) > 1) : ?>
									<option value="0">Seleccione Comuna</option>
								<?php endif; ?>
								<?php if (isset($arrComuna) && is_array($arrComuna)) : foreach ($arrComuna as $key => $comuna) : ?>
										<option value="<?php echo $comuna->comuna_id ?>" data-region="<?php echo $comuna->comuna_id ?>"><?php echo $comuna->comuna_nombre; ?></option>
								<?php endforeach;
								endif; ?>
						</select>
					</div>
				</div>
					<div class ="row top-spaced">
							<div class="col-1">
								<label class="control-label required-left">Direccion</label>
							</div>
							<div class="col-5">
								<input type="text" class="form-control" id="direccion_0">
							</div>
							<div class="col-1">
								<label class="control-label required-left">Teléfono</label>
							</div>
							<div class="col-5">
								<input type="text" class="form-control" id="telefono_0">
							</div>
						
					</div>
                    <br>
					<p hidden type="text">
				</div>
			</div>
			
		</form>

</div>

