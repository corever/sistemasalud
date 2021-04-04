<form id="formEditarEstablecimiento" class="form-horizontal">
    <section class="content">
        <div class="panel panel-primary">
            <div class="panel-body">
                <input type="hidden" id="gl_token" name="gl_token" value="{$itm->gl_token}" />

                <div class="form-group top-spaced">
                    <label for="gl_nombre" class="col-sm-3 control-label"> Nombre (*) </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="gl_nombre" name="gl_nombre" value="{$itm->gl_nombre_establecimiento}">
                    </div>
                </div>

                <div class="form-group top-spaced">
                    <label for="gl_descripcion" class="col-sm-3 control-label"> Tipo Establecimiento (*) </label>
                    <div class="col-sm-7">
                        <select class="form-control" id="tipo_establecimiento" name="tipo_establecimiento">
                            <option value="0">Seleccione Tipo</option>
                            {foreach $arrTipoEstablecimiento as $item}
                                <option value="{$item->id_establecimiento_tipo}"
                                        {if $item->id_establecimiento_tipo == $itm->id_establecimiento_tipo}selected{/if}>{$item->gl_nombre}</option>
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
                                <option value="{$item->id_region}" id="{$item->gl_latitud}" name="{$item->gl_longitud}"
                                        {if $item->id_region == $itm->id_region}selected{/if}>{$item->gl_nombre_region}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                
                <div class="form-group top-spaced">
                    <label for="comuna" class="col-sm-3 control-label"> Comuna (*) </label>
                    <div class="col-sm-7">
                        <select class="form-control" id="comuna_establecimiento" name="comuna_establecimiento">
                            <option value="0">Seleccione una Comuna</option>
                            {foreach $arrComunas as $item}
                                <option value="{$item->id_comuna}"
                                        {if $item->id_comuna == $itm->id_comuna}selected{/if}>{$item->gl_nombre_comuna}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                
                <div class="form-group top-spaced">
                    <label for="gl_direccion" class="col-sm-3 control-label"> Dirección (*) </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="gl_direccion" name="gl_direccion" value="{$itm->gl_direccion_establecimiento}">
                    </div>
                </div>
                
                <div class="form-group top-spaced">
                    <label for="gl_telefono" class="col-sm-3 control-label"> Teléfono </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="gl_telefono" name="gl_telefono" value="{$itm->gl_telefono}">
                    </div>
                </div>
                
                <div class="form-group top-spaced">
                    <label for="servicio" class="col-sm-3 control-label"> Servicio de Salud (*) </label>
                    <div class="col-sm-7">
                        <select class="form-control" id="servicio" name="servicio">
                            <option value="0">Seleccione Servicio</option>
                            {foreach $arrServicio as $item}
                                <option value="{$item->id_servicio}"
                                        {if $item->id_servicio == $itm->id_servicio}selected{/if}>{$item->gl_nombre_servicio}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="form-group top-spaced">
                    <label class="col-sm-3 control-label">&nbsp;</label>
                </div>

                <div class="modal-footer top-spaced" id="btn-terminar">
                    <button class="btn btn-success" type="button" onclick="Mantenedor_establecimiento.editarEstablecimiento(this.form, this);"><i class="fa fa-save"></i>&nbsp; Guardar </button>
                    &nbsp;&nbsp;
                    <button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; Cerrar </button>
                </div>

            </div>
        </div>
    </section>
</form>