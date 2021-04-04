<div class="content" style="z-index: 850;">
    <div class="simplebox grid740-left" style="z-index: 840;">
        <form action="<?php echo \pan\uri\Uri::getHost(); ?>Farmacia/Usuario/Login/cambioUsuario" method="post" accept-charset="utf-8">
            <div class="row top-spaced">
                <div class="col-2">&nbsp;</div>
                <div class="col-2">
                    <label for="id_rol_usuario" class="control-label required-left"><?php echo \Traduce::texto("Usuario"); ?></label>
                </div>
                <div class="col-6">
                    <input hidden id="bo_url" name="bo_url" value="1">
                    <select class="form-control select2" id="gl_token" name="gl_token" >
                        <?php if (isset($arrUsuario) && is_array($arrUsuario)) : foreach ($arrUsuario as $key => $usuario) : ?>
                            <?php if($usuario->gl_token != $_SESSION[\Constantes::SESSION_BASE]['gl_token']): ?>
                            <option value="<?php echo $usuario->gl_token; ?>" ><?php echo $usuario->mu_rut_midas." - ".$usuario->mu_nombre." ".$usuario->mu_apellido_paterno." ".$usuario->mu_apellido_materno; ?></option>
                        <?php
                                endif;
                            endforeach;
                        endif; ?>
                    </select>
                </div>
            </div>
            <div class="row top-spaced"></div>
            <div class="row top-spaced" id="div_acciones">
                <div class="col-4">&nbsp;</div>
                <div class="col-6">
                    <button class="btn btn-success" type="button" onclick="submit();"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Cambiar Usuario"); ?> </button>
                </div>
            </div>
        </form>
    </div>
    <div class="clear" style="z-index: 800;"></div>
</div>