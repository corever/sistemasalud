<div class="card card-primary">
	<div class="card-header"> Datos Usuario </div>
	<div class="card-body">

        <input type="text" hidden id="bo_ws_validado" name="bo_ws_validado" value="<?php echo (isset($arr->bo_ws_validado))?$arr->bo_ws_validado:""; ?>">

        <div class="row">
            <div class="col-2">
                <label for="gl_rut_usuario" class="control-label required-left">RUT</label>
            </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_rut_usuario" name="gl_rut_usuario" value="<?php echo (isset($arr->gl_rut))?$arr->gl_rut:""; ?>"
                    onkeyup="formateaRut(this), this.value = this.value.toUpperCase()" onkeypress="return soloNumerosYK(event)" <?php echo (isset($arr->gl_rut))?"readonly":""; ?>
                    onblur="Valida_Rut(this); Utils.cargarPersonaWS(this.value,'gl_nombre_usuario','gl_apellido_paterno_usuario','gl_apellido_materno');" />
            </div>
            <!--div class="col-sm-3">
                <label for="bo_cambio_usuario" class="control-label"><?php echo \Traduce::texto("Cambio Usuario"); ?></label>
                <select id="bo_cambio_usuario" class="form-control" name="bo_cambio_usuario">
                    <option value="0" <?php echo (isset($arr->bo_cambio_usuario) && intval($arr->bo_cambio_usuario) == 0)?"selected":""; ?>> No </option>
                    <option value="1" <?php echo (isset($arr->bo_cambio_usuario) && intval($arr->bo_cambio_usuario) == 1)?"selected":""; ?>> Si </option>
                </select>
            </div-->
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label for="gl_nombre_usuario" class="control-label required-left"><?php echo \Traduce::texto("Nombre"); ?></label>
            </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_nombre_usuario" name="gl_nombre_usuario" value="<?php echo (isset($arr->gl_nombres))?$arr->gl_nombres:""; ?>"
                    <?php echo (isset($arr->gl_rut) && isset($arr->bo_ws_validado) && $arr->bo_ws_validado)?"readonly":""; ?> />
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label for="gl_apellido_paterno_usuario" class="control-label required-left"><?php echo \Traduce::texto("Apellido Paterno"); ?></label>
                </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_apellido_paterno_usuario" name="gl_apellido_paterno_usuario" value="<?php echo (isset($arr->gl_apellido_paterno))?$arr->gl_apellido_paterno:""; ?>"
                    <?php echo (isset($arr->gl_rut) && isset($arr->bo_ws_validado) && $arr->bo_ws_validado)?"readonly":""; ?>/>
            </div>
            <div class="col-2">
                <label for="gl_apellido_materno_usuario" class="control-label required-left"><?php echo \Traduce::texto("Apellido Materno"); ?></label>
                </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_apellido_materno_usuario" name="gl_apellido_materno_usuario" value="<?php echo (isset($arr->gl_apellido_materno))?$arr->gl_apellido_materno:""; ?>"
                    <?php echo (isset($arr->gl_rut) && isset($arr->bo_ws_validado) && $arr->bo_ws_validado)?"readonly":""; ?>/>
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label for="id_profesion_usuario" class="control-label">Profesión</label>
                </div>
            <div class="col-4">
                <select class="form-control" id="id_profesion_usuario" name="id_profesion_usuario" >
                    <?php if (!isset($arrProfesion) || count((array) $arrProfesion) == 0 || count((array) $arrProfesion) > 1) : ?>
                        <option value="0">Seleccione una Profesión</option>
                    <?php endif; ?>
                    <?php if (isset($arrProfesion) && is_array($arrProfesion)) : foreach ($arrProfesion as $key => $profesion) : ?>
                            <option value="<?php echo $profesion->id_profesion; ?>" <?php echo (isset($arr->id_profesion) && $arr->id_profesion == $profesion->id_profesion)?"selected":""; ?> ><?php echo $profesion->nombre_profesion; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label class="control-label required-left">Género</label>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-sm-6">
                        <label><input type="radio" class="labelauty" id="chk_genero_usuario_m" name="chk_genero_usuario" value="M" <?php echo ($arr->chk_genero == "M")?"checked":""; ?> data-labelauty="Masculino" /></label>
                    </div>
                    <div class="col-sm-6">
                        <label><input type="radio" class="labelauty" id="chk_genero_usuario_f" name="chk_genero_usuario" value="F" <?php echo ($arr->chk_genero == "F")?"checked":""; ?> data-labelauty="Femenino" /></label>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <label for="fc_nacimiento_usuario" class="control-label required-left"><?php echo \Traduce::texto("Fecha Nacimiento"); ?></label>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input type="text" readonly class="form-control float-left datepicker" id="fc_nacimiento_usuario" name="fc_nacimiento_usuario"
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
            <div class="col-2">
                <label for="gl_email_usuario" class="control-label required-left">Email</label>
            </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_email_usuario" name="gl_email_usuario" onblur="validaEmail(this, 'Correo Inválido!')"
                       value="<?php echo (isset($arr->gl_email))?$arr->gl_email:""; ?>"/>
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label for="id_region_usuario" class="control-label required-left"><?php echo \Traduce::texto("Región"); ?></label>
            </div>
            <div class="col-4">
                <select class="form-control" id="id_region_usuario" name="id_region_usuario" onchange="Region.cargarComunasPorRegion(this.value,'id_comuna_usuario',<?php echo (isset($arr->id_comuna))?$arr->id_comuna:''; ?>);" >
                    <?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
                        <option value="0">Seleccione una Región</option>
                    <?php endif; ?>
                    <?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
                            <option value="<?php echo $region->id_region_midas ?>" <?php echo (isset($arr->id_region) && $arr->id_region == $region->id_region_midas)?"selected":""; ?> ><?php echo $region->nombre_region_corto; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="col-2">
                <label for="id_comuna_usuario" class="control-label required-left"><?php echo \Traduce::texto("Comuna"); ?></label>
            </div>
            <div class="col-4">
                <select class="form-control" id="id_comuna_usuario" name="id_comuna_usuario"     >
                    <?php if (!isset($arrComuna) || count((array) $arrComuna) == 0 || count((array) $arrComuna) > 1) : ?>
                        <option value="0">Seleccione una Comuna</option>
                    <?php endif; ?>
                    <?php if (isset($arrComuna) && is_array($arrComuna)) : foreach ($arrComuna as $key => $comuna) : ?>
                            <option value="<?php echo $comuna->comuna_id ?>" data-region="<?php echo $comuna->id_region_midas ?>" <?php echo (isset($arr->id_comuna) && $arr->id_comuna == $comuna->comuna_id)?"selected":""; ?> ><?php echo $comuna->comuna_nombre; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label for="gl_direccion_usuario" class="control-label required-left">Dirección</label>
            </div>
            <div class="col-10">
                <input type="text" class="form-control" id="gl_direccion_usuario" name="gl_direccion_usuario"
                       value="<?php echo (isset($arr->gl_direccion))?$arr->gl_direccion:""; ?>"/>
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label for="id_codregion_usuario" class="control-label required-left">Código Teléfono</label>
            </div>
            <div class="col-4">
                <select class="form-control" id="id_codregion_usuario" name="id_codregion_usuario" >
                    <?php if (!isset($arrCodRegion) || count((array) $arrCodRegion) == 0 || count((array) $arrCodRegion) > 1) : ?>
                        <option value="0">Seleccione código</option>
                    <?php endif; ?>
                    <?php if (isset($arrCodRegion) && is_array($arrCodRegion)) : foreach ($arrCodRegion as $key => $codRegion) : ?>
                            <option value="<?php echo $codRegion->codfono_id ?>" data-region="<?php echo $codRegion->id_region_midas; ?>" <?php echo (isset($arr->id_codfono) && $arr->id_codfono == $codRegion->codfono_id)?"selected":""; ?> ><?php echo $codRegion->codigo ." (".$codRegion->provincia.")"; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="col-2">
                <label for="gl_telefono_usuario" class="control-label required-left"><?php echo \Traduce::texto("Teléfono"); ?></label>
            </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_telefono_usuario" name="gl_telefono_usuario" value="<?php echo (isset($arr->gl_telefono))?$arr->gl_telefono:""; ?>"/>
            </div>
        </div>
	</div>
</div>