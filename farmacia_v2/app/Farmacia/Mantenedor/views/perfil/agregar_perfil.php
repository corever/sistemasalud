<form id="formAgregarPerfil" class="form-horizontal">
	<section class="content">
        
        <div class="row">

            <div class="col-sm-4"> 
                 <div class="card card-primary">
                    <div class="card-header"><?php echo \Traduce::texto("Datos Generales"); ?></div>
                    <div class="card-body">
                        
                        <input id="id_perfil" name="id_perfil" value="<?php echo (isset($arr->id_perfil))?$arr->id_perfil:""; ?>" hidden>
                        
                        <div class="col-sm-12">
                            <label for="gl_nombre_perfil" class="control-label required-left"><?php echo \Traduce::texto("Nombre"); ?></label>
                            <div>
                                <input type="text" class="form-control" id="gl_nombre_perfil" name="gl_nombre_perfil"
                                       value="<?php echo (isset($arr->gl_nombre_perfil))?$arr->gl_nombre_perfil:""; ?>" >
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="gl_descripcion_perfil" class="control-label required-left"><?php echo \Traduce::texto("Descripción"); ?></label>
                            <div>
                                <textarea type="text" class="form-control" id="gl_descripcion_perfil" name="gl_descripcion_perfil"
                                          maxlength="100" ><?php echo (isset($arr->gl_descripcion))?$arr->gl_descripcion:""; ?></textarea>
                            </div>
                        </div>

                        <div class="top-spaced">&nbsp;</div>

                    </div>
                </div>
            </div>
                    
            <div class="col-sm-8">
                <div class="card card-primary">
                    <div class="card-header"><?php echo \Traduce::texto("Opciones de Menú"); ?></div>
                    <div class="card-body">
                        
                        <div class="col-sm-12">
                            <?php echo \Traduce::texto("Modulo"); ?>
                            <div>
                                <?php $cont = 1; ?>
                                <?php foreach($arrModulo as $modulo): ?>
                                    <button type="button" class="btnModulo btn btn-xs <?php echo ($cont == 1)?$modulo->gl_color:''; ?>" data-color="<?php echo $modulo->gl_color; ?>"
                                        id="btnModulo<?php echo $modulo->id_modulo; ?>" name="btnModulo<?php echo $modulo->id_modulo; ?>" onclick="MantenedorPerfil.mostrarMenuByModulo(<?php echo $modulo->id_modulo; ?>);" >
                                        <i class="<?php echo $modulo->gl_icono; ?>"></i>&nbsp;<?php echo \Traduce::texto($modulo->gl_nombre); ?>
                                    </button>
                                    <?php 
                                        if($cont == 1){
                                            $id_modulo_primero = $modulo->id_modulo;
                                        }
                                        $cont++;
                                    ?>
                                <?php endforeach; ?>

                                <?php /*
                                <button type="button" class="btn btn-xs btn-success" id="btnSeleccionaTodo" name="btnSeleccionaTodo" onclick="MantenedorPerfil.seleccionaTodo();" >
                                    <i class="fa fa-check-square-o"></i>&nbsp;<?php echo \Traduce::texto("Seleccionar Todo"); ?>
                                </button>
                                <button type="button" class="btn btn-xs btn-danger" id="btnDeseleccionaTodo" name="btnDeseleccionaTodo" onclick="MantenedorPerfil.deseleccionaTodo();" >
                                    <i class="fa fa-square-o"></i>&nbsp;<?php echo \Traduce::texto("Deseleccionar Todo"); ?>
                                </button>
                                */ ?>
                            </div>
                        </div>

                        <div class="top-spaced">&nbsp;</div>
                        <div class="col-sm-12">
                            <?php echo \Traduce::texto("Menú"); ?> / <?php echo \Traduce::texto("Permisos"); ?>
                            <table class="table table-hover table-striped table-bordered dataTable no-footer">
                            <tbody>
                                <?php foreach($arr_padre as $padre): ?>
                                    
                                    <tr class="contenedorOpcion" data-modulo="<?php echo ($padre->id_modulo); ?>" data-opcion="<?php echo $padre->id_opcion; ?>"
                                        style="background-color:#f2f2f2;<?php echo ($padre->id_modulo != $id_modulo_primero)?'display:none;':''; ?>" >
                                        <td colspan="2" width="55%">
                                        <label><input type="checkbox" class="chkOpciones" name="<?php echo $padre->id_opcion ?>" id="<?php echo $padre->id_opcion ?>"
                                            onclick="MantenedorPerfil.mostrarHijos(this);MantenedorPerfil.mostrarPermisos(this);" <?php if (in_array($padre->id_opcion,$opPerfil)): ?> checked <?php endif; ?> >
                                            &nbsp;<i class="<?php echo $padre->gl_icono ?>-2x"></i> <?php echo $padre->gl_nombre_opcion ?></label>
                                        </td>
                                        <td width="15%">
                                        <label for="chk_permisos_1_<?php echo $padre->id_opcion; ?>" class="control-label"><?php echo \Traduce::texto("Agregar"); ?></label>
                                        <input type="checkbox" class="chkPermisos" id="chk_permisos_1_<?php echo $padre->id_opcion; ?>" name="chk_permisos_1[]" value="<?php echo $padre->id_opcion; ?>"
                                            <?php if (!isset($arrPermisoOpcion[$padre->id_opcion])): ?> disabled="disabled" <?php endif; ?>
                                            <?php if ($arrPermisoOpcion[$padre->id_opcion]["1"] == 1): ?> checked <?php endif; ?> >
                                        </td>
                                        <td width="15%">
                                        <label for="chk_permisos_2_<?php echo $padre->id_opcion; ?>" class="control-label"><?php echo \Traduce::texto("Modificar"); ?></label>
                                        <input type="checkbox" class="chkPermisos" id="chk_permisos_2_<?php echo $padre->id_opcion; ?>" name="chk_permisos_2[]" value="<?php echo $padre->id_opcion; ?>"
                                            <?php if (!isset($arrPermisoOpcion[$padre->id_opcion])): ?> disabled="disabled" <?php endif; ?>
                                            <?php if ($arrPermisoOpcion[$padre->id_opcion]["2"] == 1): ?> checked <?php endif; ?> >
                                        </td>
                                        <td width="15%">
                                        <label for="chk_permisos_3_<?php echo $padre->id_opcion; ?>" class="control-label"><?php echo \Traduce::texto("Eliminar"); ?></label>
                                        <input type="checkbox" class="chkPermisos" id="chk_permisos_3_<?php echo $padre->id_opcion; ?>" name="chk_permisos_3[]" value="<?php echo $padre->id_opcion; ?>"
                                            <?php if (!isset($arrPermisoOpcion[$padre->id_opcion])): ?> disabled="disabled" <?php endif; ?>
                                            <?php if ($arrPermisoOpcion[$padre->id_opcion]["3"] == 1): ?> checked <?php endif; ?> >
                                        </td>                                        
                                    </tr>

                                    <?php foreach($arr_opcion as $opcion): ?>
                                        <?php if ($opcion->id_opcion_padre == $padre->id_opcion): ?>
                                            <tr class="contenedorOpcion opcion_hijo_<?php echo $opcion->id_opcion_padre; ?>" data-modulo="<?php echo ($padre->id_modulo); ?>"  data-opcion="<?php echo $opcion->id_opcion; ?>"
                                                style="background-color:#ffffff;<?php echo ($padre->id_modulo != $id_modulo_primero && !in_array($opcion->id_opcion,$opPerfil))?'display:none;':''; ?>">
                                                <td width="5%"><i class="fa fa-arrow-right"></i></td>
                                                <td width="50%">
                                                    <label><input type="checkbox" class="chkOpciones" name="<?php echo $opcion->id_opcion ?>" id="<?php echo $opcion->id_opcion ?>"
                                                    <?php if (in_array($opcion->id_opcion,$opPerfil)): ?> checked <?php endif; ?> onchange="MantenedorPerfil.mostrarPermisos(this);" >
                                                    &nbsp;<i class="<?php echo $opcion->gl_icono ?>"></i> <span ><?php echo $opcion->gl_nombre_opcion ?></span></label>
                                                    </td>
                                                    <td width="15%">
                                                    <label for="chk_permisos_1_<?php echo $opcion->id_opcion; ?>" class="control-label"><?php echo \Traduce::texto("Agregar"); ?></label>
                                                    <input type="checkbox" class="chkPermisos" id="chk_permisos_1_<?php echo $opcion->id_opcion; ?>" name="chk_permisos_1[]" value="<?php echo $opcion->id_opcion; ?>"
                                                        <?php if (!isset($arrPermisoOpcion[$opcion->id_opcion])): ?> disabled="disabled" <?php endif; ?>
                                                        <?php if ($arrPermisoOpcion[$opcion->id_opcion]["1"] == 1): ?> checked <?php endif; ?> >
                                                    </td>
                                                    <td width="15%">
                                                    <label for="chk_permisos_2_<?php echo $opcion->id_opcion; ?>" class="control-label"><?php echo \Traduce::texto("Modificar"); ?></label>
                                                    <input type="checkbox" class="chkPermisos" id="chk_permisos_2_<?php echo $opcion->id_opcion; ?>" name="chk_permisos_2[]" value="<?php echo $opcion->id_opcion; ?>"
                                                        <?php if (!isset($arrPermisoOpcion[$opcion->id_opcion])): ?> disabled="disabled" <?php endif; ?>
                                                        <?php if ($arrPermisoOpcion[$opcion->id_opcion]["2"] == 1): ?> checked <?php endif; ?> >
                                                    </td>
                                                    <td width="15%">
                                                    <label for="chk_permisos_3_<?php echo $opcion->id_opcion; ?>" class="control-label"><?php echo \Traduce::texto("Eliminar"); ?></label>
                                                    <input type="checkbox" class="chkPermisos" id="chk_permisos_3_<?php echo $opcion->id_opcion; ?>" name="chk_permisos_3[]" value="<?php echo $opcion->id_opcion; ?>"
                                                        <?php if (!isset($arrPermisoOpcion[$opcion->id_opcion])): ?> disabled="disabled" <?php endif; ?>
                                                        <?php if ($arrPermisoOpcion[$opcion->id_opcion]["3"] == 1): ?> checked <?php endif; ?> >
                                                </td>
                                            </tr>
                                            
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
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
            <button class="btn btn-danger" type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; <?php echo \Traduce::texto("Cerrar"); ?> </button>
        </div>
        
	</section>
</form>