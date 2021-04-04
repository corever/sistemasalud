<div class="card card-primary">
	<div class="card-header"> Datos Seremi </div>
    
	<div class="card-body">            
    
        <div class="row">
            <div class="col-2">
                <label for="gl_rut_seremi" class="control-label">RUT Seremi</label>
            </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_rut_seremi" name="gl_rut_seremi" value="<?php echo isset($arrDatosSeremi->gl_rut)?$arrDatosSeremi->gl_rut:"" ?>"
                    onkeyup="formateaRut(this), this.value = this.value.toUpperCase()" onkeypress="return soloNumerosYK(event)" <?php echo (isset($arrDatosSeremi->gl_rut))?"readonly":""; ?>
                    onblur="Valida_Rut(this); Utils.cargarPersonaWS(this.value,'gl_nombre_seremi','gl_apellido_paterno_seremi','gl_apellido_materno');" readonly />
            </div>

            <div class="col-2">
                <label for="fc_nacimiento_seremi" class="control-label required-left"><?php echo \Traduce::texto("Fecha Nacimiento"); ?></label>
            </div>
            <div class="col-4">
            <div class="input-group">
                    <input type="text" readonly data-date-format='yy-mm-dd'  class="form-control float-left datepicker" id="fc_nacimiento_seremi" name="fc_nacimiento_seremi"
                           value="<?php echo (isset($arrDatosSeremi->fc_nacimiento))?\Fechas::formatearHtml($arrDatosSeremi->fc_nacimiento):""; ?>" autocomplete="off">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                </div>
            </div>    
        </div>
        <!--input que tiene el id del usuario-->
        <input hidden type="text" class="form-control float-left" id="id_usuario" name="id_usuario" value="<?php echo (isset($arrDatosSeremi->id_usuario))?\Fechas::formatearHtml($arrDatosSeremi->id_usuario):""; ?>"/>
        <!--input que tiene el id del seremi-->
        <input hidden type="text" class="form-control float-left" id="id_seremi" name="id_seremi" value="<?php echo (isset($arrDatosSeremi->id_seremi))?\Fechas::formatearHtml($arrDatosSeremi->id_seremi):""; ?>"/>

        <div class="row top-spaced">
            <div class="col-2">
                <label for="id_trato_seremi" class="control-label required-left">Trato</label>
            </div>
            <div class="col-4">            
                <select class="form-control" id="id_trato_seremi" name="id_trato_seremi" >
                    <?php if (!isset($arrTrato) || count((array) $arrTrato) == 0 || count((array) $arrTrato) > 1) : ?>
                        <option value="0">Seleccione trato</option>
                    <?php endif; ?>
                    <?php if (isset($arrTrato) && is_array($arrTrato)) : foreach ($arrTrato as $key => $trato) : ?>
                            <option value="<?php echo $trato->seremi_trato; ?>" <?php echo (isset($arrDatosSeremi->gl_trato) && $arrDatosSeremi->gl_trato == $trato->seremi_trato)?"selected":""; ?> ><?php echo $trato->seremi_trato; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="col-2">
                <label for="gl_nombre_seremi" class="control-label required-left"><?php echo \Traduce::texto("Nombre"); ?></label>
            </div>
            <div class="col-4">
                <input type="text" readonly class="form-control" id="gl_nombre_seremi" name="gl_nombre_seremi" onkeypress="return soloLetras(event)"  value="<?php echo (isset($arrDatosSeremi->gl_nombre))?$arrDatosSeremi->gl_nombre:""; ?>"/>                    
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label for="gl_apellido_paterno_seremi"  class="control-label required-left"><?php echo \Traduce::texto("Apellido Paterno"); ?></label>
            </div>
            <div class="col-4">
                <input type="text" class="form-control" readonly id="gl_apellido_paterno_seremi" name="gl_apellido_paterno_seremi" onkeypress="return soloLetras(event)"  value="<?php echo (isset($arrDatosSeremi->gl_paterno))?$arrDatosSeremi->gl_paterno:""; ?>"                    />
            </div>
            <div class="col-2">
                <label for="gl_apellido_materno_seremi"  class="control-label required-left"><?php echo \Traduce::texto("Apellido Materno"); ?></label>
                </div>
            <div class="col-4">
                <input type="text" class="form-control" readonly id="gl_apellido_materno_seremi" name="gl_apellido_materno_seremi" onkeypress="return soloLetras(event)"  value="<?php echo (isset($arrDatosSeremi->gl_materno))?$arrDatosSeremi->gl_materno:""; ?>"/>
            </div>
        </div>


        <div class="row top-spaced">
            <div class="col-2">
                <label for="gl_email_seremi" class="control-label required-left">Email</label>
            </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_email_seremi" name="gl_email_seremi" onblur="validaEmail(this, 'Correo Inválido!')"
                       value="<?php echo (isset($arrDatosSeremi->gl_email))?$arrDatosSeremi->gl_email:""; ?>"/>
            </div>
        </div>


        <div class="row top-spaced">
       
            <div class="col-2">
                <label class="control-label required-left">Tipo</label>
            </div>            
            <div class="col-4">
                <select class="form-control" id="id_tipo_firmante" name="id_tipo_firmante" onchange="MantenedorSeremi.mostarInputsDelegado(this.value);" >
                <?php if (!isset($arrTiposDeFirmante) || count((array) $arrTiposDeFirmante) == 0 || count((array) $arrTiposDeFirmante) > 1) : ?>
                        <option value="0">Seleccione Tipo Firmante</option>
                    <?php endif; ?>
                    <?php if (isset($arrTiposDeFirmante) && is_array($arrTiposDeFirmante)) : foreach ($arrTiposDeFirmante as $key => $firmante) : ?>
                            <option value="<?php echo $firmante->id_firmante ?>" <?php echo (isset($tipoFirmante->id_firmante) && $firmante->id_firmante == $tipoFirmante->id_firmante)?"selected":""; ?> ><?php echo $firmante->gl_firmante; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>

            <div class="col-2">
                <label class="control-label required-left">Género</label>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-sm-6">
                        <label><input type="radio" class="labelauty" id="chk_genero_seremi_m" name="chk_genero_seremi" value="M" <?php echo ($arrDatosSeremi->gl_genero == "M")?"checked":""; ?> data-labelauty="Masculino" /></label>
                    </div>
                    <div class="col-sm-6">
                        <label><input type="radio" class="labelauty" id="chk_genero_seremi_f" name="chk_genero_seremi" value="F" <?php echo ($arrDatosSeremi->gl_genero == "F")?"checked":""; ?> data-labelauty="Femenino" /></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row top-spaced">
            <div class="col-2">
                <label class="control-label required-left">D.S N°</label>
            </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_ds_decreto" name="gl_ds_decreto" onkeypress="return soloNumeros(event)" 
                value="<?php echo (isset($arrDatosSeremi->gl_decreto))?$arrDatosSeremi->gl_decreto:""; ?>"/>   
            </div> 
            <div class="col-2">
                <label class="control-label required-left">Fecha</label>
            </div>
            <div class="col-4">
                <div class="input-group">
                        <input type="text" class="form-control float-left datepicker" id="fc_ds" name="fc_ds"
                            value="<?php echo (isset($arrDatosSeremi->fc_decreto))?str_replace("//","",\Fechas::formatearHtml($arrDatosSeremi->fc_decreto)):""; ?>" autocomplete="off">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                </div>
                
            </div>  
        </div>

        <div class="row top-spaced" id="form_firma_delegada" <?php if($tipoFirmante->id_firmante!=1) echo "style='display: none;'";?>>
            <div class="col-2">
                <label class="control-label required-left">Decreto Firma Delegada</label>
            </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_ds_decreto_delegado" name="gl_ds_decreto_delegado" onkeypress="return soloNumeros(event)" 
                value="<?php echo (isset($arrDatosSeremi->id_ds_delegado))?$arrDatosSeremi->id_ds_delegado:""; ?>"/>   
            </div> 
            <div class="col-2">
                <label class="control-label required-left">Fecha decreto Delegado</label>
            </div>
            <div class="col-4">
                <div class="input-group">
                        <input type="text" class="form-control float-left datepicker" id="fc_ds_delegado" name="fc_ds_delegado"
                            value="<?php echo (isset($arrDatosSeremi->fc_ds_delegado))?str_replace("//","",\Fechas::formatearHtml($arrDatosSeremi->fc_ds_delegado)):""; ?>" autocomplete="off">
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
                <label for="btnAdjuntar" class="control-label required-left">Firma Imagen</label>
            </div>
            <div class="col-4">
                <?php include('app/_FuncionesGenerales/Adjuntos/views/btnAdjuntar.php');?>
            </div> 
        </div>

        <div class="row top-spaced">
            <div class="col-2">
                <label for="id_region_seremi" class="control-label required-left"><?php echo \Traduce::texto("Región"); ?></label>
            </div>
            <div class="col-4">
                <select class="form-control" id="id_region_seremi" name="id_region_seremi" >
                    <?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
                        <option value="0">Seleccione una Región</option>
                    <?php endif; ?>
                    <?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
                            <option value="<?php echo $region->region_id ?>" <?php echo (isset($arrDatosSeremi->id_region) && $arrDatosSeremi->id_region == $region->region_id)?"selected":""; ?> ><?php echo $region->nombre_region_corto; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="col-2">
                <label for="id_territorio_seremi" class="control-label required-left"><?php echo \Traduce::texto("Territorio"); ?></label>
            </div>
            <div class="col-4">            
                <select class="form-control" id="id_territorio_seremi" name="id_territorio_seremi">
                    <?php if (!isset($arrTerritorio) || count((array) $arrTerritorio) == 0 || count((array) $arrTerritorio) > 1) : ?>
                        <option value="0">Seleccione Territorio</option>
                    <?php endif; ?>
                    <?php if (isset($arrTerritorio) && is_array($arrTerritorio)) : foreach ($arrTerritorio as $key => $territorio) : ?>
                            <option value="<?php echo $territorio->territorio_id ?>" <?php echo (isset($arrDatosSeremi->id_territorio) && $arrDatosSeremi->id_territorio == $territorio->territorio_id)?"selected":""; ?> ><?php echo $territorio->nombre_territorio; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label for="gl_direccion_seremi" class="control-label required-left">Dirección</label>
            </div>
            <div class="col-10">
                <input type="text" class="form-control" id="gl_direccion_seremi" name="gl_direccion_seremi"
                       value="<?php echo (isset($arrDatosSeremi->gl_direccion))?$arrDatosSeremi->gl_direccion:""; ?>"/>
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label for="id_codregion_seremi" class="control-label required-left">Código Teléfono</label>
            </div>
            <div class="col-4">
                <select class="form-control" id="id_codregion_seremi" name="id_codregion_seremi" >
                    <?php if (!isset($arrCodRegion) || count((array) $arrCodRegion) == 0 || count((array) $arrCodRegion) > 1) : ?>
                        <option value="0">Seleccione código</option>
                    <?php endif; ?>
                    <?php if (isset($arrCodRegion) && is_array($arrCodRegion)) : foreach ($arrCodRegion as $key => $codRegion) : ?>
                            <option value="<?php echo $codRegion->codfono_id ?>" data-region="<?php echo $codRegion->fk_region; ?>" <?php echo (isset($arrDatosSeremi->cd_fono) && $arrDatosSeremi->cd_fono == $codRegion->codfono_id)?"selected":""; ?> ><?php echo $codRegion->codigo ." (".$codRegion->provincia.")"; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="col-2">
                <label for="gl_telefono_seremi" class="control-label required-left"><?php echo \Traduce::texto("Teléfono"); ?></label>
            </div>
            <div class="col-4">
                <input type="text" class="form-control" id="gl_telefono_seremi" name="gl_telefono_seremi" value="<?php echo (isset($arrDatosSeremi->gl_telefono))?$arrDatosSeremi->gl_telefono:""; ?>"/>
            </div>
        </div>
	</div>
</div>

