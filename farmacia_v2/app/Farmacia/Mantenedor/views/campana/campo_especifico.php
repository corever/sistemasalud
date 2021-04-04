<form id="formCampoEspecifico" class="form-horizontal">
    <section class="content">
        <div class="panel panel-primary">
            <input type="hidden" name="id_campana" id="id_campana" value="<?php echo $id_campana?>" />
            <div class="panel-body">

                <div class="form-group top-spaced">
                    <label for="gl_nombre_campana" class="col-sm-5 control-label"> Datos Adicionales <span class="text-red">(*):</span> </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="gl_nombre_campo" name="gl_nombre_campo" placeholder="Nombre del Campo" />
                    </div>
                </div>

                <div class="form-group top-spaced">
                    <label for="id_tipo_campo" class="col-sm-5 control-label"> Tipo <span class="text-red">(*): </label>
                    <div class="col-sm-4">
                        <select id="id_tipo_campo" class="form-control" name="id_tipo_campo">
                            <option value="0">
                                Seleccione Tipo de Campo
                            </option>
                            <?php foreach ($arrTipoCampo as $key => $tipo_campo) : ?>
                                <option value="<?php echo $tipo_campo->id_tipo ?>"><?php echo $tipo_campo->gl_nombre ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group top-spaced">
                    <label for="gl_descripcion" class="col-sm-5 control-label"> Descripci&oacute;n <span class="text-red">(*):</span> </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="gl_descripcion" name="gl_descripcion" placeholder="Descripci&oacute;n del Campo" />
                    </div>
                </div>

                <div class="form-group top-spaced">
                    <label class="col-sm-5 control-label"></label>
                    <div class="col-sm-4">
                        <button class="btn btn-default btn-sm" type="button" onclick="agregarCampoTemporal()"> Agregar </button>
                    </div>
                </div>
                <div id="grillaEspecifico">
                    <?php echo $grillaEspecifico ?>
                </div>

                <div class="modal-footer top-spaced" id="btn-terminar">
                     <!--<button class="btn btn-success" type="button" onclick=""><i class="fa fa-save"></i>&nbsp; Guardar </button>
                    &nbsp;&nbsp;-->
                    <button class="btn btn-success" type="button" onclick="xModal.close();" id="btn_cerrar"><i class="fa fa-close"></i>&nbsp; Aceptar </button>
                </div>

            </div>
        </div>
    </section>
</form>