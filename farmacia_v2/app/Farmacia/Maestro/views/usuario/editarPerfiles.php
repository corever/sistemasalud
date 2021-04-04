<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/select2/select2.css" />

<form id="formNuevoUsuario" class="form-horizontal" autocomplete="off">
	<section class="content">
        <div class="form-group">

            <div class="card card-primary">
                <div class="card card-header"><?php echo \Traduce::texto("Perfiles Usuario"); ?></div>
                <div class="card-body">

                    <input id="gl_token_usuario" name="gl_token_usuario" value="<?php echo $gl_token; ?>" hidden>

                    <div class="row">
                        <div class="col-md-12" align="right">
                            <button type="button" class="btn btn-xs btn-success" data-toggle="tooltip" title="<?php echo \Traduce::texto("Agregar Perfil Usuario"); ?>"
                                    onclick="xModal.open('<?php echo \pan\uri\Uri::getHost(); ?>Farmacia/Maestro/Usuario/agregarPerfilUsuario/<?php echo $gl_token; ?>','<?php echo \Traduce::texto('Agregar Perfil Usuario'); ?>',40);">
                                <i class="fa fa-plus"></i>&nbsp;<?php echo \Traduce::texto("Agregar Perfil"); ?>
                            </button>
                        </div>
                        <div class="table-responsive col-md-12" id="contenedor-grilla-perfiles">
                            <?php include_once("grillaPerfilesUsuario.php"); ?> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="top-spaced">&nbsp;</div>
                
        </div>

        <div class="top-spaced" align="right" id="btn-terminar" style="background-color: #dddddd;">
            <!--button class="btn btn-success" type="button" onclick="Mantenedor_usuario.editarPerfiles($(this.form).serializeArray(), this);"><i class="fa fa-save"></i>&nbsp; Guardar </button-->
            <button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; <?php echo \Traduce::texto("Cerrar"); ?> </button>
        </div>
        
	</section>
</form>