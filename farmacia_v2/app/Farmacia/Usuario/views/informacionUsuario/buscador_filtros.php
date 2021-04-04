<section class="content">
    <div class="container-fluid">
        <div class="row mb-2 mt-3">
            <div class="col-12">

                <!-- Apply any bg-* class to to the info-box to color it -->
                <div class="info-box bg-info">
                    <span class="info-box-icon"><i class="fa fa-info"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Información</span>
                        <span class="info-box-number">Los filtros son independientes. Puede usar uno o más criterios de búsqueda.</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->

                <div class="card card-primary">

                    <div class="card-header">

                        <h3 class="card-title"><?php echo \Traduce::texto("Filtros"); ?></h3>

                    </div>
                    <form id="formInfoUsuario">

                        <input type="hidden" class="form-control" id="bo_buscar" value="0">

                        <div class="card-body">

                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="gl_rut_usuario" class="col-sm-4 col-form-label"><?php echo \Traduce::texto("RUT Usuario"); ?></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-uppercase" id="gl_rut_usuario" name="gl_rut_usuario">
                                </div>
                            </div>

                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="gl_nombres_apellidos" class="col-sm-4 col-form-label"><?php echo \Traduce::texto("Nombre(s) y/o Apellido(s)"); ?></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-uppercase" id="gl_nombres_apellidos" name="gl_nombres_apellidos">
                                </div>
                            </div>

                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="fk_region" class="col-sm-4 col-form-label control-label"><?php echo \Traduce::texto("Región"); ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="fk_region" name="fk_region">
                                        <option value="0">Seleccione Región</option>
                                        <?php foreach ($arrRegion as $item) : ?>
                                            <option value="<?php echo $item->id_region_midas; ?>"><?php echo $item->region_nombre; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="fk_estado" class="col-sm-4 col-form-label control-label"><?php echo \Traduce::texto("Estado"); ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="fk_estado" name="fk_estado">
                                        <option value="0">Seleccione Estado</option>
                                        <?php foreach ($arrUsuarioEstado as $item) : ?>
                                            <option value="<?php echo $item->usuario_estado_id; ?>"><?php echo $item->usuario_estado_nombre; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="bo_institucional" class="col-sm-4 col-form-label control-label"><?php echo \Traduce::texto("Institucional"); ?></label>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="radio" id="bo_institucional_1" name="bo_institucional" value="1" />
                                            <label for="bo_institucional_1">Si es Institucional</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="radio" id="bo_institucional_0" name="bo_institucional" value="0" />
                                            <label for="bo_institucional_0">No Institucional</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="fk_roles" class="col-sm-4 col-form-label control-label"><?php echo \Traduce::texto("Roles"); ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="fk_roles" name="fk_roles[]" multiple>
                                        <!-- <option value="0">Seleccione al menos un Rol</option> -->
                                        <?php foreach ($arrRoles as $item) : ?>
                                            <option value="<?php echo $item->rol_id; ?>"><?php echo $item->rol_nombre; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <!-- <span class="help-text">Seleccione al menos un Rol</span> -->
                                </div>
                            </div>

                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="fk_profesiones" class="col-sm-4 col-form-label control-label"><?php echo \Traduce::texto("Profesión"); ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="fk_profesiones" name="fk_profesiones[]" multiple>
                                        <!-- <option value="0">Seleccione al menos una Profesión</option> -->
                                        <?php foreach ($arrProfesiones as $item) : ?>
                                            <option value="<?php echo $item->id_profesion; ?>"><?php echo $item->nombre_profesion; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <!-- <span class="help-text">Seleccione al menos una Profesión</span> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-success" id="buscar" data-toggle="tooltip" title="Buscar"><i class="fa fa-search"></i>&nbsp;&nbsp;Buscar
                            </button>
                            <button type="reset" class="btn btn-sm btn-warning" id="cancelar" data-toggle="tooltip" title="Limpiar"><i class="fa fa-times"></i>&nbsp;&nbsp;Limpiar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>