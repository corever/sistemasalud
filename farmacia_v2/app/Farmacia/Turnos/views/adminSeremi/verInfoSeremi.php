<div class="card card-primary">
	<div class="card-header"> Datos Seremi </div>
	<div class="card-body">
        <div class="row">
            <div class="col-2">
                <label for="gl_rut_usuario" class="control-label">RUT Seremi</label>
            </div>
            <div class="col-4">
                <input readonly type="text" class="form-control" value="<?php echo isset($arrDatosSeremi->gl_rut)?$arrDatosSeremi->gl_rut:"" ?> "/>
            </div>

            <div class="col-2">
                <label class="control-label "><?php echo \Traduce::texto("Fecha Nacimiento"); ?></label>
            </div>
            <div class="col-4">            
                <input readonly type="text" class="form-control" value="<?php echo isset($arrDatosSeremi->fc_nacimiento)?$arrDatosSeremi->fc_nacimiento:"" ?>"/>
            </div>    
        </div>


        <div class="row top-spaced">
            <div class="col-2">
                <label class="control-label ">Trato</label>
            </div>
            <div class="col-4">  
                <input readonly type="text" class="form-control" value="<?php echo isset($arrDatosSeremi->gl_trato)?$arrDatosSeremi->gl_trato:"" ?>"/>          
            </div>
            <div class="col-2">
                <label  class="control-label "><?php echo \Traduce::texto("Nombre"); ?></label>
            </div>
            <div class="col-4">
                <input readonly type="text" class="form-control" value="<?php echo isset($arrDatosSeremi->gl_nombre)?$arrDatosSeremi->gl_nombre:"" ?>"/>    
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label  class="control-label "><?php echo \Traduce::texto("Apellido Paterno"); ?></label>
            </div>
            <div class="col-4">
                <input readonly type="text" class="form-control" value="<?php echo isset($arrDatosSeremi->gl_paterno)?$arrDatosSeremi->gl_paterno:"" ?>"/>  
            </div>
            <div class="col-2">
                <label class="control-label "><?php echo \Traduce::texto("Apellido Materno"); ?></label>
            </div>
            <div class="col-4">
                <input readonly type="text" class="form-control" value="<?php echo isset($arrDatosSeremi->gl_materno)?$arrDatosSeremi->gl_materno:"" ?>"/>  
            </div>
        </div>


        <div class="row top-spaced">
            <div class="col-2">
                <label for="gl_email_usuario" class="control-label ">Email</label>
            </div>
            <div class="col-10">
                <input readonly type="text" class="form-control" value="<?php echo isset($arrDatosSeremi->gl_email)?$arrDatosSeremi->gl_email:"" ?>"/>  
            </div>
        </div>


        <div class="row top-spaced">
            <div class="col-2">
                    <label class="control-label ">Género</label>
            </div>
            <div class="col-4">
                <input readonly type="text" class="form-control" value="<?php echo isset($arrDatosSeremi->gl_genero)?$arrDatosSeremi->gl_genero:"" ?>"/>  
            </div>
            <div class="col-2">
                <label class="control-label ">Tipo Firma</label>
            </div>
            <div class="col-4">
                <input readonly type="text" class="form-control"  value="<?php echo isset($tipoFirmante->gl_firmante)?$tipoFirmante->gl_firmante:"" ?>"/>    
            </div> 
        </div>

        <div class="row top-spaced">

            <div class="col-2">
                <label class="control-label ">D.S N°</label>
            </div>
            <div class="col-4">
                <input readonly type="text" class="form-control"  value="<?php echo isset($arrDatosSeremi->gl_decreto)?$arrDatosSeremi->gl_decreto:"" ?>"/>    
            </div> 
            <div class="col-2">
                <label class="control-label ">Fecha D.S</label>
            </div>
            <div class="col-4">
                <div class="input-group">
                        <input type="text" readonly class="form-control " value="<?php echo (isset($arrDatosSeremi->fc_decreto))?str_replace("//","",\Fechas::formatearHtml($arrDatosSeremi->fc_decreto)):""; ?>">
                </div>                
            </div>  
        </div>


        <div class="row top-spaced" id="form_firma_delegada" <?php if($tipoFirmante->id_firmante!=1) echo "style='display: none;'";?>>
            <div class="col-2">
                <label class="control-label ">N° D.S Delegada</label>
            </div>
            <div class="col-4">
                <input type="text" readonly class="form-control " value="<?php echo (isset($arrDatosSeremi->id_ds_delegado))?str_replace("//","",\Fechas::formatearHtml($arrDatosSeremi->id_ds_delegado)):""; ?>">
            </div> 
            <div class="col-2">
                <label class="control-label ">Fecha D.S Delegada</label>
            </div>
            <div class="col-4">
                <div class="input-group">
                        <input type="text" readonly class="form-control " value="<?php echo (isset($arrDatosSeremi->fc_ds_delegado))?str_replace("//","",\Fechas::formatearHtml($arrDatosSeremi->fc_ds_delegado)):""; ?>">
                </div>                
            </div>  
        </div>

        <div class="row top-spaced">
            <div class="col-2">
                <label class="control-label ">Imagen Firma</label>
            </div>
            <div class="col-4">
                <?php include('app/_FuncionesGenerales/Adjuntos/views/btnAdjuntar.php');?>  
            </div> 

        </div>

        <div class="row top-spaced">
            <div class="col-2">
                <label for="id_region_usuario" class="control-label "><?php echo \Traduce::texto("Región"); ?></label>
            </div>
            <div class="col-4">
            <select readonly class="form-control" id="id_region_seremi" name="id_region_seremi">
                    <?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
                        <option value="0"></option>
                    <?php endif; ?>
                    <?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
                            <option value="<?php echo $region->region_id ?>" <?php echo (isset($arrDatosSeremi->id_region) && $arrDatosSeremi->id_region == $region->region_id)?"selected":""; ?> ><?php echo $region->nombre_region_corto; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="col-2">
                <label for="id_territorio_seremi" class="control-label "><?php echo \Traduce::texto("Territorio"); ?></label>
            </div>
            <div class="col-4">
                <select readonly class="form-control" id="id_territorio_seremi" name="id_territorio_seremi">
                    <?php if (!isset($arrTerritorio) || count((array) $arrTerritorio) == 0 || count((array) $arrTerritorio) > 1) : ?>
                        <option value="0"></option>
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
                <label for="gl_direccion_usuario" class="control-label ">Dirección</label>
            </div>
            <div class="col-10">            
                <input readonly type="text" class="form-control" value="<?php echo isset($arrDatosSeremi->gl_direccion)?$arrDatosSeremi->gl_direccion:"" ?>"/>  
            </div>
        </div>
        <div class="row top-spaced">
            <div class="col-2">
                <label for="id_codregion_usuario" class="control-label ">Teléfono</label>
            </div>
            <div class="col-4">
                <input readonly type="text" class="form-control" value="<?php echo isset($arrDatosSeremi->gl_telefono)?(isset($arrDatosSeremi->cd_fono)?$arrDatosSeremi->cd_fono:"").$arrDatosSeremi->gl_telefono:"" ?>"/>  
            </div>
        </div>
	</div>
</div>

<script>
// sleep time expects milliseconds
function sleep (time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}
$( document ).ready(function() {    
    // Usage!
sleep(400).then(() => {    
    $(".column-view-hidden").hide();
});
    
});
</script>