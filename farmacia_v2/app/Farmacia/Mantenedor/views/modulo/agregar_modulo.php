<form id="formAgregarPerfil" class="form-horizontal">
	<section class="content">
        
        <div class="row">

            <div class="col-sm-6"> 
                 <div class="card card-primary">
                    <div class="card-header"><?php echo \Traduce::texto("Datos Generales"); ?></div>
                    <div class="card-body">
                        
                        <input id="id_perfil" name="id_perfil" value="<?php echo (isset($arr->id_perfil))?$arr->id_perfil:""; ?>" hidden>
                        
                        <div class="col-sm-12">
                            <label for="gl_nombre_perfil" class="control-label required"><?php echo \Traduce::texto("Nombre"); ?></label>
                            <div>
                                <input type="text" class="form-control" id="gl_nombre_perfil" name="gl_nombre_perfil"
                                       value="<?php echo (isset($arr->gl_nombre_perfil))?$arr->gl_nombre_perfil:""; ?>" >
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="gl_descripcion_perfil" class="control-label"><?php echo \Traduce::texto("Descripción"); ?></label>
                            <div>
                                <textarea type="text" class="form-control" id="gl_descripcion_perfil" name="gl_descripcion_perfil"
                                          maxlength="100" ><?php echo (isset($arr->gl_descripcion))?$arr->gl_descripcion:""; ?></textarea>
                            </div>
                        </div>

                        <div class="top-spaced">&nbsp;</div>

                    </div>
                </div>
            </div>
                    
            <div class="col-sm-6">
                <div class="card card-primary">
                    <div class="card-header"><?php echo \Traduce::texto("Opciones de Menú"); ?></div>
                    <div class="card-body">
                        
                        <div class="col-sm-12">
                            <div>
                                <button type="button" class="btn btn-xs btn-success" id="btnSeleccionaTodo" name="btnSeleccionaTodo" onclick="MantenedorPerfil.seleccionaTodo();" >
                                    <i class="fa fa-check-square-o"></i>&nbsp;<?php echo \Traduce::texto("Seleccionar Todo"); ?>
                                </button>
                                <button type="button" class="btn btn-xs btn-danger" id="btnDeseleccionaTodo" name="btnDeseleccionaTodo" onclick="MantenedorPerfil.deseleccionaTodo();" >
                                    <i class="fa fa-square-o"></i>&nbsp;<?php echo \Traduce::texto("Deseleccionar Todo"); ?>
                                </button>
                            </div>
                        </div>

                        <div class="top-spaced">&nbsp;</div>
                        
                        <ul>
                        <?php foreach($arr_padre as $padre): ?>
                            <div class="row">
                                <label><input type="checkbox" class="chkOpciones" name="<?php echo $padre->id_opcion ?>" id="<?php echo $padre->id_opcion ?>"
                                              onclick="MantenedorPerfil.mostrarHijos(this)" <?php if (($padre->bo_activo == 1 && !$opPerfil) || in_array($padre->id_opcion,$opPerfil)): ?> checked <?php endif; ?> >
                                    &nbsp;<i class="<?php echo $padre->gl_icono ?>-2x"></i> <?php echo $padre->gl_nombre_opcion ?></label>

                                <div id="opcion_hijo_<?php echo $padre->id_opcion; ?>" <?php if(($padre->bo_activo == 0)): ?> style="display: none" <?php endif; ?>>
                                    <?php foreach($arr_opcion as $opcion): ?>
                                        <?php if ($opcion->id_opcion_padre == $padre->id_opcion): ?>
                                            <ul>
                                                <div class="row">
                                                    <label><input type="checkbox" class="chkOpciones" name="<?php echo $opcion->id_opcion ?>" id="<?php echo $opcion->id_opcion ?>" <?php if (($opcion->bo_activo == 1 && !$opPerfil) || in_array($opcion->id_opcion,$opPerfil)): ?> checked <?php endif; ?> >
                                                        &nbsp;<i class="<?php echo $opcion->gl_icono ?>"></i> <span ><?php echo $opcion->gl_nombre_opcion ?></span></label>
                                                </div>
                                            </ul>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

			</div>
		</div>
				
        <div class="top-spaced" align="right" id="btn-terminar" style="background-color: #dddddd;">
            <?php if(!isset($arr->id_perfil)): ?>
                <button class="btn btn-success" type="button" onclick="MantenedorPerfil.agregarPerfil($(this.form).serializeArray(), this);"><i class="fa fa-save"></i>&nbsp; <?php echo \Traduce::texto("Guardar"); ?> </button>
            <?php else: ?>
                <button class="btn btn-success" type="button" onclick="MantenedorPerfil.editarPerfil($(this.form).serializeArray(), this);"><i class="fa fa-save"></i>&nbsp; <?php echo \Traduce::texto("Guardar"); ?> </button>
            <?php endif; ?>
            <button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; <?php echo \Traduce::texto("Cerrar"); ?> </button>
        </div>
        
	</section>
</form>