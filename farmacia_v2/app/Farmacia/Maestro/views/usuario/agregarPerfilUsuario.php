<form id="formNuevoPerfilUsuario" class="form-horizontal" autocomplete="off">
	<section class="content">
        <div class="form-group">
                        
            <div class="card card-primary" id="card_perfiles">
                <div class="card card-header" id="card_heading_perfiles">Datos</div>
                <div class="card-body">
                    
                    <input id="gl_token_usuario" name="gl_token_usuario" value="<?php echo $gl_token; ?>" hidden>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="id_perfil_usuario" class="control-label required"><?php echo \Traduce::texto("Perfil"); ?></label>
                            <div>
                                <select class="form-control select2" id="id_perfil_usuario" name="id_perfil_usuario">
                                    <option value="0">Seleccione Perfil</option>
                                    <?php foreach($arrPerfiles as $item): ?>
                                        <option value="<?php echo $item->id_perfil; ?>" ><?php echo $item->gl_nombre_perfil; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="chk_bo_jefe" class="control-label">Jefe</label>
                            <div>
                                <input type="checkbox" class="" id="chk_bo_jefe" name="chk_bo_jefe" value="1" >
                            </div>
                        </div>
                    </div>

                    <div class="top-spaced">&nbsp;</div>

                </div>
            </div>
        </div>

        <div class="top-spaced" align="right" id="btn-terminar" style="background-color: #dddddd;">
            <button class="btn btn-success" type="button" onclick="MantenedorUsuario.agregarPerfilUsuario($(this.form).serializeArray(), this);"><i class="fa fa-save"></i>&nbsp; <?php echo \Traduce::texto("Guardar"); ?> </button>
            <button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; <?php echo \Traduce::texto("Cerrar"); ?> </button>
        </div>
        
	</section>
</form>