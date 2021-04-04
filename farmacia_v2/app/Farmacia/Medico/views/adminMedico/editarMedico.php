<div class="card card-primary">

	<div class="card-header"> Datos Medico </div>
	<div class="card-body">
	<input hidden id="id_medico" value="<?php echo $arrDatosMedico->id_medico; ?>"/>
	<div class="row" id="form_nuevo_medico">
            <div class="col-2">
                <label for="gl_rut_medico" class="control-label required-left">RUT Medico</label>
            </div>
            <div class="col-4">
                <input readonly type="text" class="form-control"  id="gl_rut_medico" name="gl_rut_medico" value="<?php echo (isset($arrDatosMedico->gl_rut))?$arrDatosMedico->gl_rut:""; ?>"
                    onkeyup="formateaRut(this), this.value = this.value.toUpperCase()" onkeypress="return soloNumerosYK(event)" <?php echo (isset($arrDatosmedico->gl_rut))?"readonly":""; ?>
                    onblur="Valida_Rut(this); Utils.cargarPersonaWS(this.value,'gl_nombre_medico','gl_apellido_paterno_medico','gl_apellido_materno_medico');" />
            </div>

            <div class="col-2">
				<label for="gl_email_medico" class="control-label required-left">Email</label>
            </div>
            <div class="col-4">
				<input type="text" class="form-control" id="gl_email_medico" name="gl_email_medico" onblur="validaEmail(this, 'Correo Inválido!')"
						value="<?php echo (isset($arrDatosMedico->gl_email))?$arrDatosMedico->gl_email:""; ?>"/>
            </div>    
        </div>

		
        <div class="row top-spaced">
            <div class="col-2">
				<label for="fc_nacimiento_medico" class="control-label required-left"><?php echo \Traduce::texto("Fecha Nacimiento"); ?></label>
            </div>
            <div class="col-4">
				<div class="input-group">
                    <input readonly type="text" data-date-format='yy-mm-dd'  class="form-control float-left datepicker" id="fc_nacimiento_medico" name="fc_nacimiento_medico"
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
                <select readonly class="form-control" id="id_profesion_medico" name="id_profesion_medico" >
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
						<option value="<?php echo $especialidad->id_especialidad; ?>" <?php echo (isset($arrDatosMedico->id_especialidad) && $arrDatosMedico->id_especialidad == $especialidad->id_especialidad)?"selected":""; ?> ><?php echo $especialidad->gl_especialidad; ?></option>
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
                <input readonly type="text" class="form-control" id="gl_nombre_medico" name="gl_nombre_medico" onkeypress="return soloLetras(event)" value="<?php echo (isset($arrDatosMedico->gl_nombre))?$arrDatosMedico->gl_nombre:""; ?>"/>
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label for="gl_apellido_paterno_medico" class="control-label required-left"><?php echo \Traduce::texto("Apellido Paterno"); ?></label>
                </div>
            <div class="col-4">
                <input readonly type="text" class="form-control" id="gl_apellido_paterno_medico" name="gl_apellido_paterno_medico" onkeypress="return soloLetras(event)" value="<?php echo (isset($arrDatosMedico->gl_paterno))?$arrDatosMedico->gl_paterno:""; ?>"/>
            </div>
            <div class="col-2">
                <label for="gl_apellido_materno_medico" class="control-label required-left"><?php echo \Traduce::texto("Apellido Materno"); ?></label>
                </div>
            <div class="col-4">
                <input type="text" readonly class="form-control" id="gl_apellido_materno_medico" name="gl_apellido_materno_medico" onkeypress="return soloLetras(event)" value="<?php echo (isset($arrDatosMedico->gl_materno))?$arrDatosMedico->gl_materno:""; ?>"/>
            </div>
        </div>

        <div class="row top-spaced">
            <div class="col-2">
                <label class="control-label required-left">Género</label>
            </div>
            <div class="col-4">
				<div class="row">
                    <div class="col-sm-6">
                        <label><input type="radio" class="labelauty" id="chk_genero_medico_m" name="chk_genero_medico" value="M" <?php echo ($arrDatosMedico->gl_genero == "masculino")?"checked":""; ?> data-labelauty="Masculino" /></label>
                    </div>
                    <div class="col-sm-6">
                        <label><input type="radio" class="labelauty" id="chk_genero_medico_f" name="chk_genero_medico" value="F" <?php echo ($arrDatosMedico->gl_genero == "femenino")?"checked":""; ?> data-labelauty="Femenino" /></label>
                    </div>
                </div>
            </div>
        </div>
<!-- codigo de inputs dinamicos -->

			
		<form method="POST">
			
			<input type="button" class="btn btn-success" value="Agregar Consulta +" onClick="MantenedorMedico.addInput('dynamicInput');">
			<?php 
			if(isset($arrConsultas)){
				$maximo = sizeOf($arrConsultas);
			}else{
				$maximo = 1;
			}
			for($i=0;$i<$maximo;$i++){
				if($i>0){
					$eliminar = 'style="display:block; float:right;"';
				}else{
					
					$eliminar='style="display:none; float:right;"';
				}
				echo '<div id="div_general_'.$i.'" class="top-spaced" style="border-style: solid; border-width: 1px; border-color: #ced4da;">
					<div id="dynamicInput" class="listaConsultas" style="background: #007bff21;">

					<div class="row">
						<div class="col-6">
							<label class="control-label left" id="gl_consulta_'.$i.'">Datos Consulta '.($i+1).' :</label>
						</div>
						<div class="col-6">
							<button '.$eliminar.' class="btn btn-danger eliminarConsulta" id="eliminarConsulta_'.$i.'" onClick="MantenedorMedico.removeInput(this);"><i class="fa fa-trash" aria-hidden="true"></i></button>
						</div>
					</div>
					<div class="row top-spaced">
						<div class="col-1">
								<label class="control-label required-left">Region</label>
						</div>
						<div class="col-5">
							<select id="selectRegion_'.$i.'" class="form-control">';?>
								<?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
									<option value="0">Seleccione una Región</option>
								<?php endif; ?>
								<?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
										<option value="<?php echo $region->region_id ?>" <?php echo (isset($arrConsultas[$i]->id_region) && $arrConsultas[$i]->id_region == $region->region_id)?"selected":""; ?> ><?php echo $region->nombre_region_corto; ?></option>
								<?php endforeach;
								endif; ?>
							<?php echo '</select>
						</div>
						<div class="col-1">
							<label class="control-label required-left">Comuna</label>
						</div>
						<div class="col-5">
							<select id="selectComuna_'.$i.'" class="form-control">';?>
									<?php if (!isset($arrComuna) || count((array) $arrComuna) == 0 || count((array) $arrComuna) > 1) : ?>
										<option value="0">Seleccione Comuna</option>
									<?php endif; ?>
									<?php if (isset($arrComuna) && is_array($arrComuna)) : foreach ($arrComuna as $key => $comuna) : ?>
										<option value="<?php echo $comuna->comuna_id ?>" <?php echo (isset($arrConsultas[$i]->id_comuna) && $arrConsultas[$i]->id_comuna == $comuna->comuna_id)?"selected":""; ?> ><?php echo $comuna->comuna_nombre; ?></option>
									<?php endforeach;
									endif; ?>
							<?php echo '</select>
						</div>
					</div>
						<div class ="row top-spaced">
								<div class="col-1">
									<label class="control-label required-left">Direccion</label>
								</div>
								<div class="col-5">
									<input type="text" class="form-control" id="direccion_'.$i.'" value="'.$arrConsultas[$i]->gl_direccion.'">
								</div>
								<div class="col-1">
									<label class="control-label required-left">Teléfono</label>
								</div>
								<div class="col-5">
									<input type="text" class="form-control" id="telefono_'.$i.'" value="'.$arrConsultas[$i]->gl_telefono.'">
								</div>
						</div>
						<br>
						<p hidden type="text">
					</div>
				</div>'; 
			}?>
			
		</form>
	</div>
</div>

