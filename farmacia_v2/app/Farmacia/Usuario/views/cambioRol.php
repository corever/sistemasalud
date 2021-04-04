<div class="content" style="z-index: 850;">
    <div class="simplebox grid740-left" style="z-index: 840;">
        <form action="<?php echo \pan\uri\Uri::getHost(); ?>Farmacia/Usuario/Login/cambioRolConfirmado" method="post" accept-charset="utf-8">
            <div class="row top-spaced"></div>
            <div class="row top-spaced"></div>
            <div class="row top-spaced">
                <div class="col-2">&nbsp;</div>
                <div class="col-2">
                    <label for="id_rol_usuario" class="control-label required-left"><?php echo \Traduce::texto("Rol"); ?></label>
                </div>
                <div class="col-6">
                    <select class="form-control" id="id_rol_usuario" name="id_rol_usuario" >
                        <?php if (isset($arrRoles) && is_array($arrRoles)) : foreach ($arrRoles as $key => $rol) : ?>
                            <option value="<?php echo $rol->mur_fk_rol; ?>" ><?php echo $rol->gl_rol; ?></option>
                        <?php endforeach;
                        endif; ?>
                    </select>
                </div>
            </div>
            <div class="row top-spaced"></div>
            <div class="row top-spaced" id="div_acciones">
                <div class="col-4">&nbsp;</div>
                <div class="col-6">
                    <button class="btn btn-success" type="button" onclick="submit();"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Ingresar"); ?> </button>
                </div>
            </div>
        </form>
    </div>
    <div class="clear" style="z-index: 800;"></div>
</div>