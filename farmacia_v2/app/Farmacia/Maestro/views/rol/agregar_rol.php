<form id="formAgregarRol" class="form-horizontal">
	<section class="content">
        
        <div class="row">

            <div class="col-sm-4"> 
                 <div class="card card-primary">
                    <div class="card-header"><?php echo \Traduce::texto("Datos Generales"); ?></div>
                    <div class="card-body">
                        
                        <input id="id_rol" name="id_rol" value="<?php echo (isset($arr->rol_id))?$arr->rol_id:""; ?>" hidden>
                        
                        <div class="col-sm-12">
                            <label for="gl_nombre_rol" class="control-label required-left"><?php echo \Traduce::texto("Nombre"); ?></label>
                            <div>
                                <input type="text" class="form-control" id="gl_nombre_rol" name="gl_nombre_rol"
                                       value="<?php echo (isset($arr->rol_nombre))?$arr->rol_nombre:""; ?>" >
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <label for="gl_nombre_vista_rol" class="control-label required-left"><?php echo \Traduce::texto("Nombre Vista"); ?></label>
                            <div>
                                <input type="text" class="form-control" id="gl_nombre_vista_rol" name="gl_nombre_vista_rol"
                                       value="<?php echo (isset($arr->rol_nombre_vista))?$arr->rol_nombre_vista:""; ?>" >
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <label for="gl_territorialidad" class="control-label required-left"><?php echo \Traduce::texto("Territorialidad"); ?></label>
                            <div class="pl-3">
                                <div class="form-check">
                                  <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="gl_territorialidad" value="bo_territorialidad_nacional" <?php echo (($arr->bo_nacional == 1))?"checked":""; ?>>Nivel Nacional
                                  </label>
                                </div>
                                <div class="form-check disabled">
                                  <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="gl_territorialidad" value="bo_territorialidad_regional" <?php echo (($arr->bo_regional == 1))?"checked":""; ?>>Nivel Regional
                                  </label>
                                </div>
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

                        <div class="top-spaced">&nbsp;</div>
                        <div class="col-sm-12">
                            <?php echo \Traduce::texto("Menú"); ?> / <?php echo \Traduce::texto("Permisos"); ?>
                            <table class="table table-hover table-striped table-bordered dataTable no-footer">
                            <tbody>
                                <?php foreach($arr_padre as $padre): ?>
                                    
                                    <tr class="contenedorOpcion" data-opcion="<?php echo $padre->m_m_id; ?>" style="background-color:#f2f2f2;" >
                                        <td colspan="2" width="55%">
                                        <label><input type="checkbox" class="chkOpciones" name="<?php echo $padre->m_m_id ?>" id="<?php echo $padre->m_m_id ?>"
                                            onclick="MaestroRol.mostrarHijos(this);MaestroRol.mostrarPermisos(this);" <?php if (in_array($padre->m_m_id,$opRolPadre)): ?> checked <?php endif; ?> >
                                            &nbsp;<i class="<?php echo $padre->gl_icono ?>-2x"></i> <?php echo $padre->nombre_modulo; ?></label>
                                        </td>
                                        <?php if(false): ?>
                                            <!--td width="15%">
                                            <label for="chk_permisos_1_<?php echo $padre->m_m_id; ?>" class="control-label"><?php echo \Traduce::texto("Agregar"); ?></label>
                                            <input type="checkbox" class="chkPermisos" id="chk_permisos_1_<?php echo $padre->m_m_id; ?>" name="chk_permisos_1[]" value="<?php echo $padre->m_m_id; ?>"
                                                <?php if (!isset($arrPermisoOpcion[$padre->m_m_id])): ?> disabled="disabled" <?php endif; ?>
                                                <?php if ($arrPermisoOpcion[$padre->m_m_id]["1"] == 1): ?> checked <?php endif; ?> >
                                            </td>
                                            <td width="15%">
                                            <label for="chk_permisos_2_<?php echo $padre->m_m_id; ?>" class="control-label"><?php echo \Traduce::texto("Modificar"); ?></label>
                                            <input type="checkbox" class="chkPermisos" id="chk_permisos_2_<?php echo $padre->m_m_id; ?>" name="chk_permisos_2[]" value="<?php echo $padre->m_m_id; ?>"
                                                <?php if (!isset($arrPermisoOpcion[$padre->m_m_id])): ?> disabled="disabled" <?php endif; ?>
                                                <?php if ($arrPermisoOpcion[$padre->m_m_id]["2"] == 1): ?> checked <?php endif; ?> >
                                            </td>
                                            <td width="15%">
                                            <label for="chk_permisos_3_<?php echo $padre->m_m_id; ?>" class="control-label"><?php echo \Traduce::texto("Eliminar"); ?></label>
                                            <input type="checkbox" class="chkPermisos" id="chk_permisos_3_<?php echo $padre->m_m_id; ?>" name="chk_permisos_3[]" value="<?php echo $padre->m_m_id; ?>"
                                                <?php if (!isset($arrPermisoOpcion[$padre->m_m_id])): ?> disabled="disabled" <?php endif; ?>
                                                <?php if ($arrPermisoOpcion[$padre->m_m_id]["3"] == 1): ?> checked <?php endif; ?> >
                                            </td-->
                                        <?php endif; ?>                                       
                                    </tr>

                                    <?php foreach($arr_opcion as $opcion): ?>
                                        <?php if ($opcion->fk_modulo == $padre->m_m_id): ?>
                                            <tr class="contenedorOpcion opcion_hijo_<?php echo $opcion->fk_modulo; ?>" data-opcion="<?php echo $opcion->m_v_id; ?>" style="background-color:#ffffff; <?php echo ($boAgregar || !in_array($padre->m_m_id,$opRolPadre))?'display:none':''; ?>">
                                                <td width="5%"><i class="fa fa-arrow-right"></i></td>
                                                <td width="50%">
                                                    <label><input type="checkbox" class="chkOpciones" name="<?php echo $opcion->m_v_id ?>" id="<?php echo $opcion->m_v_id ?>"
                                                    <?php if (in_array($opcion->m_v_id,$opRol)): ?> checked <?php endif; ?> onchange="MaestroRol.mostrarPermisos(this);" >
                                                    &nbsp;<i class="<?php echo $opcion->gl_icono ?>"></i> <span ><?php echo $opcion->nombre_vista; ?></span></label>
                                                </td>
                                                <?php if(false): ?>
                                                    <!--td width="15%">
                                                        <label for="chk_permisos_1_<?php echo $opcion->m_v_id; ?>" class="control-label"><?php echo \Traduce::texto("Agregar"); ?></label>
                                                        <input type="checkbox" class="chkPermisos" id="chk_permisos_1_<?php echo $opcion->m_v_id; ?>" name="chk_permisos_1[]" value="<?php echo $opcion->m_v_id; ?>"
                                                            <?php if (!isset($arrPermisoOpcion[$opcion->m_v_id])): ?> disabled="disabled" <?php endif; ?>
                                                            <?php if ($arrPermisoOpcion[$opcion->m_v_id]["1"] == 1): ?> checked <?php endif; ?> >
                                                    </td>
                                                    <td width="15%">
                                                        <label for="chk_permisos_2_<?php echo $opcion->m_v_id; ?>" class="control-label"><?php echo \Traduce::texto("Modificar"); ?></label>
                                                        <input type="checkbox" class="chkPermisos" id="chk_permisos_2_<?php echo $opcion->m_v_id; ?>" name="chk_permisos_2[]" value="<?php echo $opcion->m_v_id; ?>"
                                                            <?php if (!isset($arrPermisoOpcion[$opcion->m_v_id])): ?> disabled="disabled" <?php endif; ?>
                                                            <?php if ($arrPermisoOpcion[$opcion->m_v_id]["2"] == 1): ?> checked <?php endif; ?> >
                                                    </td>
                                                    <td width="15%">
                                                        <label for="chk_permisos_3_<?php echo $opcion->m_v_id; ?>" class="control-label"><?php echo \Traduce::texto("Eliminar"); ?></label>
                                                        <input type="checkbox" class="chkPermisos" id="chk_permisos_3_<?php echo $opcion->m_v_id; ?>" name="chk_permisos_3[]" value="<?php echo $opcion->m_v_id; ?>"
                                                        <?php if (!isset($arrPermisoOpcion[$opcion->m_v_id])): ?> disabled="disabled" <?php endif; ?>
                                                        <?php if ($arrPermisoOpcion[$opcion->m_v_id]["3"] == 1): ?> checked <?php endif; ?> >
                                                    </td-->
                                                <?php endif; ?>  
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
            <?php if(!isset($arr->rol_id)): ?>
                <button class="btn btn-success" type="button" onclick="MaestroRol.agregarRol($(this.form).serializeArray(), this);"><i class="fa fa-save"></i>&nbsp; <?php echo \Traduce::texto("Guardar"); ?> </button>
            <?php else: ?>
                <button class="btn btn-success" type="button" onclick="MaestroRol.editarRol($(this.form).serializeArray(), this);"><i class="fa fa-save"></i>&nbsp; <?php echo \Traduce::texto("Guardar"); ?> </button>
            <?php endif; ?>
            <button class="btn btn-danger" type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; <?php echo \Traduce::texto("Cerrar"); ?> </button>
        </div>
        
	</section>
</form>