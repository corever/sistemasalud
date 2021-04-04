<form id="form_contacto" class="form-horizontal" enctype="multipart/form-data">

    <div class="panel panel-primary">
        <div class="panel-heading">
            Contacto Usuario
        </div>
        <div class="panel-body" id="div_body_contacto">
            <div class="form-group" id="tipo_contacto_0">
                <label for="tipo_contacto" class="control-label col-sm-2 col-xs-5 required">Tipo de Contacto</label>
                <div class="col-sm-3 col-xs-5">
                    <select class="form-control" id="tipo_contacto" name="tipo_contacto" {if $bo_editar == 1}disabled{/if}
                            onchange="ContactoPaciente.mostrar_tipo(this.value);">
                        <option value="0">Seleccione Tipo de Contacto</option>
                        {foreach $arrTipoContacto as $item}
                            <option value="{$item->id_tipo_contacto}" {if $item->id_tipo_contacto == $arr.id_tipo_contacto}selected{/if} >{$item->gl_nombre_contacto}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="form-group tipo_contacto" id="tipo_contacto_1" style="display: none">
                <label for="telefono_fijo" class="control-label col-sm-2 col-xs-5">Teléfono Fijo</label>
                <div class='col-sm-3 col-xs-5'>
                    <input type='text' class="form-control" id='telefono_fijo' name='telefono_fijo' value="{$arr.telefono_fijo}" onKeyPress="return soloNumeros(event)" >
                </div>
            </div>

            <div class="form-group tipo_contacto" id="tipo_contacto_2" style="display: none">
                <label for="telefono_movil" class="control-label col-sm-2 col-xs-5">Teléfono Móvil</label>
                <div class='col-sm-3 col-xs-5'>
                    <input type='text' class="form-control" id='telefono_movil' name='telefono_movil' value="{$arr.telefono_movil}" onKeyPress="return soloNumeros(event)" >
                </div>
            </div>

            <div class="tipo_contacto" id="tipo_contacto_3" style="display: none">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="chkNoInforma" class="control-label col-sm-4 col-xs-5">No Informa Dirección</label>
                        <div class='col-sm-8 col-xs-12'>
                            <input id="chkNoInforma" type="checkbox" value='1' {if $arr.chkNoInforma == 1}checked{/if} onchange="ContactoPaciente.noInforma(this);">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-5">Región</label>
                        <div class="col-sm-8 col-xs-5">
                            <select class="form-control" id="region_contacto" name="region_contacto" onchange="Region.cargarComunasPorRegion(this.value, 'comuna_contacto')" {*onblur="validarVacio(this, 'Por favor Seleccione una Región')"*}>
                                <option value="0">Seleccione una Región</option>
                                {foreach $arrRegiones as $item}
                                    <option value="{$item->id_region}" {if $item->id_region == $arr.region_contacto}selected{else if $bo_ver != 1 && $item->id_region == $id_region_sesion}selected{/if}
                                            id="{$item->gl_latitud}" name="{$item->gl_longitud}">{$item->gl_nombre_region}</option>
                                {/foreach}
                            </select>
                            <span class="help-block hidden fa fa-warning"></span>
                        </div>

                        <label class="control-label col-sm-4 col-xs-5">Comuna</label>
                        <div class="col-sm-8 col-xs-5">
                            <select class="form-control" id="comuna_contacto" name="comuna_contacto"
                                    {*onblur="validarVacio(this, 'Por favor Seleccione una Comuna')"*}>
                                <option value="0">Seleccione una Comuna</option>
                                {if $bo_ver == 1 || $bo_editar == 1}
                                    <option value="{$arr.comuna_contacto}" selected>{$arr.gl_comuna}</option>
                                {/if}
                            </select>
                            <span class="help-block hidden fa fa-warning"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gl_direccion" class="control-label col-sm-4 col-xs-5">Dirección</label>
                        <div class='col-sm-8 col-xs-12'>
                            <input type='text' class="form-control" id='gl_direccion' name='gl_direccion' value="{$arr.gl_direccion}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gl_datos_referencia" class="control-label col-sm-4 col-xs-5">Datos de Referencia</label>
                        <div class='col-sm-8 col-xs-12'>
                            <textarea type='text' class="form-control" rows="4" id='gl_datos_referencia' name='gl_datos_referencia'>{$arr.gl_datos_referencia}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-sm-12">
                        <div id="mapContacto" data-editable="{if $bo_ver==1}0{else}1{/if}" style="width:100%;height:200px;"></div>
                        <div class="form-group">
                            <label for="gl_latitud_contacto" class="control-label col-sm-3">Latitud</label>
                            <div class="col-sm-3">
                                <input type="text" name="gl_latitud_contacto" id="gl_latitud_contacto" value="{$arr.gl_latitud}" placeholder="Latitud" class="form-control"/>
                            </div>
                            <label for="gl_longitud_contacto" class="control-label col-sm-1">Longitud</label>
                            <div class="col-sm-3">
                                <input type="text" name="gl_longitud_contacto"  id="gl_longitud_contacto" value="{$arr.gl_longitud}" placeholder="Longitud" class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group tipo_contacto" id="tipo_contacto_4" style="display: none">
                <label for="gl_email" class="control-label col-sm-2 col-xs-5">Email</label>
                <div class='col-sm-3 col-xs-5'>
                    <input type='text' class="form-control" id='gl_email' name='gl_email' value="{$arr.gl_email}" onblur="validaEmail(this, 'Correo Inválido!')">
                </div>
            </div>

            <div class="form-group tipo_contacto" id="tipo_contacto_5" style="display: none">
                <label for="gl_casilla_postal" class="control-label col-sm-2 col-xs-5">Casilla Postal</label>
                <div class='col-sm-3 col-xs-5'>
                    <input type='text' class="form-control" id='gl_casilla_postal' name='gl_casilla_postal' value="{$gl_casilla_postal}">
                </div>
            </div>
            {if $bo_ver != 1}
                <div class="row text-right">
                    <input type="text" class="form-control hidden" id="bo_editar" name="bo_editar" value="{$bo_editar}">
                    <input type="text" class="form-control hidden" id="id_contacto" name="id_contacto" value="{$id_contacto}">
                    <input type="text" class="form-control hidden" id="gl_token" name="gl_token" value="{$gl_token}">
                    <button type="button" id="guardar" onclick="ContactoPaciente.guardar_contacto(this)" class="btn btn-success">
                        <i class="fa fa-save"></i>  Guardar
                    </button>&nbsp;
                    <button type="button" id="cancelar"  class="btn btn-default" 
                            onclick="xModal.close()">
                        <i class="fa fa-remove"></i>  Cancelar
                    </button>
                </div><br>
            {/if}
        </div>
    </div>

</form>