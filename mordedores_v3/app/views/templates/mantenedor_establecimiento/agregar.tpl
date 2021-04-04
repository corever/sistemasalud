<form id="formAgregarEstablecimiento" class="form-horizontal">
    <section class="content">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="form-group top-spaced">
                    <label for="gl_nombre" class="col-sm-3 control-label"> Nombre (*) </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="gl_nombre" name="gl_nombre" value="">
                    </div>
                </div>

                <div class="form-group top-spaced">
                    <label for="gl_descripcion" class="col-sm-3 control-label"> Tipo Establecimiento (*) </label>
                    <div class="col-sm-7">
                        <select class="form-control" id="tipo_establecimiento" name="tipo_establecimiento">
                            <option value="0">Seleccione Tipo</option>
                            {foreach $arrTipoEstablecimiento as $item}
                                <option value="{$item->id_establecimiento_tipo}">{$item->gl_nombre}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                
                <div class="form-group top-spaced">
                    <label for="region" class="col-sm-3 control-label"> Región (*) </label>
                    <div class="col-sm-7">
                        <select class="form-control" id="region_establecimiento" name="region_establecimiento"
                                onchange="Region.cargarComunasPorRegion(this.value,'comuna_establecimiento');Region.cargarServicioPorRegion(this.value, 'servicio')">
                            <option value="0">Seleccione una Región</option>
                            {foreach $arrRegiones as $item}
                                <option value="{$item->id_region}" id="{$item->gl_latitud}" name="{$item->gl_longitud}">{$item->gl_nombre_region}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                
                <div class="form-group top-spaced">
                    <label for="comuna" class="col-sm-3 control-label"> Comuna (*) </label>
                    <div class="col-sm-7">
                        <select class="form-control" id="comuna_establecimiento" name="comuna_establecimiento">
                            <option value="0">Seleccione una Comuna</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group top-spaced">
                    <label for="gl_direccion" class="col-sm-3 control-label"> Dirección (*) </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="gl_direccion" name="gl_direccion" value="">
                    </div>
                </div>
                
                <div class="form-group top-spaced">
                    <label for="gl_telefono" class="col-sm-3 control-label"> Teléfono </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="gl_telefono" name="gl_telefono" value="">
                    </div>
                </div>
                
                <div class="form-group top-spaced">
                    <label for="servicio" class="col-sm-3 control-label"> Servicio de Salud (*) </label>
                    <div class="col-sm-7">
                        <select class="form-control" id="servicio" name="servicio">
                            <option value="0">Seleccione Servicio</option>
                        </select>
                    </div>
                </div>

                <div class="form-group top-spaced">
                    <label class="col-sm-3 control-label">&nbsp;</label>
                </div>

                <div class="modal-footer top-spaced" id="btn-terminar">
                    <button class="btn btn-success" type="button" onclick="Mantenedor_establecimiento.agregarEstablecimiento(this.form, this);"><i class="fa fa-save"></i>&nbsp; Guardar </button>
                    &nbsp;&nbsp;
                    <button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; Cerrar </button>
                </div>

            </div>
        </div>
    </section>
</form>