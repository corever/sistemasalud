<form id="formNuevoUsuario" class="form-horizontal" autocomplete="off">
	<section class="content">
        <div class="form-group">
            <div class="col-12">

            <div class="card card-primary">
                <div class="card-header"> Roles Usuario </div>
                <div class="card-body">

                        <input id="gl_token_usuario" name="gl_token_usuario" value="<?php echo $gl_token; ?>" hidden>
                        
                        <div class="row">
                            <div class="col-12" id="btnNuevoRol">
                                <button type="button" class="btn btn-xs btn-success" data-toggle="tooltip" title="Agregar Rol Usuario" style="float:right;"
                                    onclick="MantenedorUsuario.nuevoRol();">
                                    <i class="fa fa-plus"></i>&nbsp;Agregar Rol
                                </button>
                            </div>

                            <div id="agregarRolDiv" class="col-12" style="display:none;">

                                <div class="row col-6">
                                    <div class="col-sm-6">
                                        <label><input type="radio" class="labelauty" id="chk_institucional_si" name="chk_institucional"
                                        onclick="$('#div_roles_no_institucional').hide(200);$('#div_roles_institucional').show(200);MantenedorUsuario.resetAgregarRol(1);"
                                        value="1" <?php echo ($arr->chk_genero == "M")?"checked":""; ?> data-labelauty="Institucional" /></label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label><input type="radio" class="labelauty" id="chk_institucional_no" name="chk_institucional"
                                        onclick="$('#div_roles_institucional').hide(200);$('#div_roles_no_institucional').show(200);MantenedorUsuario.resetAgregarRol(1);"
                                        value="2" <?php echo ($arr->chk_genero == "F")?"checked":""; ?> data-labelauty="No Institucional" /></label>
                                    </div>
                                </div>
                                <div class="row" id="div_roles_institucional" style="display:none;">
                                    <div class="col-6">
                                        <label for="id_rol_institucional_usuario" class="control-label required"><?php echo \Traduce::texto("Rol"); ?></label>
                                        <select class="form-control select2" id="id_rol_institucional_usuario" name="id_rol_institucional_usuario"
                                            onchange="MantenedorUsuario.cambioRol(this);">
                                            <option value="0">Seleccione Rol</option>
                                            <?php foreach($arrRolIns as $item): ?>
                                                <option value="<?php echo $item->rol_id; ?>" data-institucional="" ><?php echo $item->rol_nombre_vista; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="div_roles_no_institucional" style="display:none;">
                                    <div class="col-6">
                                        <label for="id_rol_no_institucional_usuario" class="control-label required"><?php echo \Traduce::texto("Rol"); ?></label>
                                        <select class="form-control select2" id="id_rol_no_institucional_usuario" name="id_rol_no_institucional_usuario"
                                                onchange="MantenedorUsuario.cambioRol(this);">
                                            <option value="0">Seleccione Rol</option>
                                            <?php foreach($arrRolNoIns as $item): ?>
                                                <option value="<?php echo $item->rol_id; ?>" data-institucional="" ><?php echo $item->rol_nombre_vista; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="div_profesiones" style="display:none;">
                                    <div class="col-sm-12">
                                        <label for="id_profesion_usuario" class="control-label required"><?php echo \Traduce::texto("Profesión"); ?></label>
                                        <select class="form-control select2" id="id_profesion_usuario" name="id_profesion_usuario">
                                            <option value="0">Seleccione Profesión</option>
                                            <?php foreach($arrProfesion as $item): ?>
                                                <option value="<?php echo $item->id_profesion; ?>" ><?php echo $item->nombre_profesion; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="div_local_farmaceutico" style="display:none;">
                                    <div class="col-sm-12">
                                        <label for="id_local_farmaceutico_usuario" class="control-label required"><?php echo \Traduce::texto("Local Farmaceutico"); ?></label>
                                        <select class="form-control select2" id="id_local_farmaceutico_usuario" name="id_local_farmaceutico_usuario">
                                            <option value="0">Seleccione Local</option>
                                            <?php foreach($arrLocal as $item): ?>
                                                <option value="<?php echo $item->local_id; ?>" ><?php echo $item->local_nombre." N° ".$item->local_numero." ".$item->local_direccion; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="div_fecha_inicio_termino" style="display:none;">
                                    <div class="col-sm-6">
                                        <label for="fc_inicio_usuario" class="control-label required-left"><?php echo \Traduce::texto("Fecha de Inicio"); ?></label>
                                        <div class="input-group">
                                            <input type="text" readonly class="form-control float-left datepicker" id="fc_inicio_usuario" name="fc_inicio_usuario"
                                                value="<?php echo (isset($arr->fc_inicio_usuario))?\Fechas::formatearHtml($arr->fc_inicio_usuario):""; ?>" autocomplete="off">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="fc_termino_usuario" class="control-label required-left"><?php echo \Traduce::texto("Fecha de Termino"); ?></label>
                                        <div class="input-group">
                                            <input type="text" readonly class="form-control float-left datepicker" id="fc_termino_usuario" name="fc_termino_usuario"
                                                value="<?php echo (isset($arr->fc_termino_usuario))?\Fechas::formatearHtml($arr->fc_termino_usuario):""; ?>" autocomplete="off">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6" id="div_region_usuario" style="display:none;">
                                        <label for="id_region_usuario" class="control-label required-left"><?php echo \Traduce::texto("Región"); ?></label>
                                        <select class="form-control" id="id_region_usuario" name="id_region_usuario"
                                            onchange="Region.cargarTerritorioPorRegion(this.value,'id_territorio_usuario');Region.cargarFarmaciasPorRegion(this.value,'id_empresa_farmaceutica_usuario');" >
                                            <?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
                                                <option value="0">Seleccione una Región</option>
                                            <?php endif; ?>
                                            <?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
                                                    <option value="<?php echo $region->id_region_midas ?>" <?php echo (isset($arr->id_region) && $arr->id_region == $region->id_region_midas)?"selected":""; ?> ><?php echo $region->nombre_region_corto; ?></option>
                                            <?php endforeach;
                                            endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6" id="div_territorio_usuario" style="display:none;">
                                        <label for="id_territorio_usuario" class="control-label required-left"><?php echo \Traduce::texto("Territorio"); ?></label>
                                        <select class="form-control" id="id_territorio_usuario" name="id_territorio_usuario"
                                           onchange="Region.cargarBodegaPorTerritorio(this.value,'id_bodega_usuario','',$('#id_region_usuario').val());" >
                                            <?php if (!isset($arrTerritorio) || count((array) $arrTerritorio) == 0 || count((array) $arrTerritorio) > 1) : ?>
                                                <option value="0">Seleccione un Territorio</option>
                                            <?php endif; ?>
                                            <?php if (isset($arrTerritorio) && is_array($arrTerritorio)) : foreach ($arrTerritorio as $key => $territorio) : ?>
                                                    <option value="<?php echo $territorio->territorio_id ?>" data-region="<?php echo $territorio->id_region_midas ?>" <?php echo (isset($arr->id_territorio) && $arr->id_territorio == $territorio->territorio_id)?"selected":""; ?> ><?php echo $territorio->nombre_territorio; ?></option>
                                            <?php endforeach;
                                            endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row"id="div_empresa_farmaceutica_usuario" style="display:none;">
                                    <div class="col-sm-6">
                                        <label for="id_empresa_farmaceutica_usuario" class="control-label required-left"><?php echo \Traduce::texto("Empresa Farmacéutica"); ?></label>
                                        <select class="form-control select2" id="id_empresa_farmaceutica_usuario" name="id_empresa_farmaceutica_usuario">
                                            <option value="0">Seleccione Farmacia</option>
                                            <?php foreach($arrFarmacia as $item): ?>
                                                <option value="<?php echo $item->farmacia_id; ?>" ><?php echo $item->farmacia_rut." - ".$item->farmacia_razon_social; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row"id="div_local_venta_usuario" style="display:none;">
                                    <div class="col-sm-6">
                                        <label for="id_bodega_usuario" class="control-label required-left"><?php echo \Traduce::texto("Local de Venta"); ?></label>
                                        <select class="form-control select2" id="id_bodega_usuario" name="id_bodega_usuario">
                                            <option value="0">Seleccione Local</option>
                                            <?php foreach($arrBodega as $item): ?>
                                                <option value="<?php echo $item->bodega_id; ?>" ><?php echo $item->bodega_nombre; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="top-spaced" id="div_acciones" align="right">
                                    <button class="btn btn-xs btn-success" type="button" onclick="MantenedorUsuario.guardarRol($(this.form).serializeArray(), this);"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Guardar Rol"); ?> </button>
                                    <button class="btn btn-xs btn-danger" type="button" onclick="MantenedorUsuario.cancelarAgregaRol();"><i class="fa fa-close"></i> <?php echo \Traduce::texto("Cancelar"); ?> </button>
                                </div>
                            </div>

                            <div class="top-spaced">&nbsp;</div>

                            <div class="table-responsive col-12" id="contenedor-grilla-roles">
                                <?php include_once("grillaRolesUsuario.php"); ?> 
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="top-spaced">&nbsp;</div>
            </div>
        </div>

        <div class="top-spaced" align="right" id="btn-terminar" style="background-color: #dddddd;">
            <!--button class="btn btn-success" type="button" onclick="Mantenedor_usuario.editarRoles($(this.form).serializeArray(), this);"><i class="fa fa-save"></i>&nbsp; Guardar </button-->
            <button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; Cerrar </button>
        </div>
        
	</section>
</form>