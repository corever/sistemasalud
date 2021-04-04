<form id="formHistorialUsuario" class="form-horizontal" autocomplete="off">
	<section class="content">
        <div class="form-group">

            <div class="card card-primary">
                <div class="card card-header"><?php echo \Traduce::texto("Historial de Usuario"); ?></div>
                <div class="card-body">

                    <input id="gl_token_usuario" name="gl_token_usuario" value="<?php echo $gl_token; ?>" hidden>

                    <div class="row">
                        <div class="table-responsive col-md-12" id="contenedor-grilla-perfiles">
                            <?php include_once("grillaHistorialUsuario.php"); ?> 
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