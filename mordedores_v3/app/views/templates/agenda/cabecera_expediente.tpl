<div class="panel panel-primary">
    <div class="panel-heading">
        Identificación de Mordedura
    </div>
    <div class="panel-body">
        <div class="row">
        <div class="col-sm-6">
            <div class="col-sm-12">
                <label for="gl_establecimiento" class="control-label">Establecimiento de Salud</label>
                <input type="text" value="{$arr->gl_establecimiento}" id="gl_establecimiento" name="gl_establecimiento" class="form-control" readonly>
            </div>
            </div>
            <div class="col-sm-6">
                <div class='col-sm-6'>
                    <label for="fechaingreso" class="control-label">Fecha Ingreso</label>
                    <input type='text' class="form-control" id='fechaingreso' name='fechaingreso' value="{$arr->fc_ingreso}" readonly>
                </div>
                <div class="col-sm-6">
                    <label for="horaingreso" class="control-label">Hora Ingreso</label>
                    <input type="text" name="horaingreso" id="horaingreso" value="{$arr->gl_hora_ingreso}" class="form-control" readonly>
                </div>
            </div>
        </div>
        <div class="top-spaced"></div>
        <div class="col-sm-6">
            <div class="col-sm-12">
                <label for="fc_mordedura" class="control-label">Fecha Mordedura</label>
                <input type="text" value="{$arr->fc_mordedura}" id="fc_mordedura" name="fc_mordedura" class="form-control" readonly>
            </div>
            <div class='col-sm-12'>
                <label for="gl_direccion" class="control-label">Dirección</label>
                <input type='text' class="form-control" 
                       value="{$arrDirMordedura.gl_direccion}, {$arr->comuna_mordedura}, {$arr->region_mordedura}" readonly>
            </div>
            <div class='col-sm-12'>
                <label for="gl_direccion" class="control-label">Datos Referencia</label>
                <input type='text' class="form-control"
                       value="{if $arrDirMordedura.gl_datos_referencia}{$arrDirMordedura.gl_datos_referencia}{else}-{/if}" readonly>
            </div>
            <div class="col-sm-6">
                <label for="gl_lugar_mordedura" class="control-label">Lugar Mordedura</label>
                <input type="text" name="gl_lugar_mordedura" id="gl_lugar_mordedura" class="form-control" readonly
                       value="{$arrExpediente.gl_lugar_mordedura}">
            </div>
            <div class="col-sm-6">
                <label for="gl_otro_lugar_mordedura" class="control-label">Otro (lugar)</label>
                <input type="text" name="gl_otro_lugar_mordedura" id="gl_otro_lugar_mordedura" class="form-control" readonly
                       value="{$arrExpediente.gl_otro_lugar_mordedura}">
            </div>
            <div class="col-sm-6">
                <label for="id_inicia_vacuna" class="control-label">Inicia Vacunación</label>
                <input type="text" name="id_inicia_vacuna" id="id_inicia_vacuna" class="form-control" readonly
                       value="{$arrExpediente.gl_inicia_vacuna}">
            </div>
            <div class="col-sm-6">
                <label for="tipo_mordedura" class="control-label">Tipo de Mordedura</label>
                <input type="text" name="tipo_mordedura" id="tipo_mordedura" class="form-control" readonly
                       value="{if $arrExpediente.gl_tipo_mordedura}{$arrExpediente.gl_tipo_mordedura}{/if}">
            </div>
            <div class="col-sm-12">
                <label for="grupo_mordedor" class="control-label">Grupo Animal Mordedor</label>
                <input type="text" name="grupo_mordedor" id="grupo_mordedor" class="form-control" readonly
                       value="{if $gl_animal_grupo}{$gl_animal_grupo}{else}-{/if}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="col-sm-12">
                <div id="mapExp" data-editable="1" style="width:100%;height:200px;"></div>
                <div class="form-group">
                    <label for="gl_latitud_exp" class="control-label col-sm-1">Latitud</label>
                    <div class="col-sm-3">
                        <input type="text" name="gl_latitud_exp" id="gl_latitud_exp" value="{$arrDirMordedura.gl_latitud}" placeholder="Latitud" class="form-control"/>
                    </div>
                    <label for="gl_longitud_contacto" class="control-label col-sm-1">Longitud</label>
                    <div class="col-sm-3">
                        <input type="text" name="gl_longitud_exp"  id="gl_longitud_exp" value="{$arrDirMordedura.gl_longitud}" placeholder="Longitud" class="form-control"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="top-spaced"></div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover table-striped table-bordered dataTable no-footer" width="100%" border="1">
                    <thead>
                        <tr>
                            <th align="center"><b>ESPECIE</b></th>
                            <th align="center"><b>RAZA</b></th>
                            <th align="center"><b>COLOR</b></th>
                            <th align="center"><b>TAMAÑO</b></th>
                            <th align="center"><b>DIRECCIÓN</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        {if $arrMordedor}
                            {foreach from=$arrMordedor key=key item=itm}
                                <tr>
                                    <td align="left">{$itm.gl_especie_animal}</td>
                                    <td align="left">{$itm.gl_raza_animal}</td>
                                    <td align="left">{$itm.gl_color_animal}</td>
                                    <td align="left">{$itm.gl_tamano_animal}</td>
                                    <td align="left">{$itm.gl_direccion}, {$itm.gl_comuna}, {$itm.gl_region}</td>
                                </tr>
                            {/foreach}
                        {else}
                            <tr><td colspan="5" align="center">Sin Mordedores</td></tr>
                        {/if}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="top-spaced"></div>
    </div>
</div>

<div class="top-spaced"></div>

{if $bo_ver == 1}
<div class="panel panel-primary">
    <div class="panel-heading">
        Identificación de Paciente
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-3">
                <label for="rut_pasaporte" class="control-label">Rut/Pasaporte</label>
                <input type="text" value="{if $arr->rut_paciente}{$arr->rut_paciente}{else if $arrPasaporte.gl_pasaporte}{$arrPasaporte.gl_pasaporte}{else}-{/if}"
                       id="rut_pasaporte" name="rut_pasaporte" class="form-control" readonly>
            </div>
            <div class='col-sm-3'>
                <label for="nombrePaciente" class="control-label">Nombre</label>
                <input type='text' class="form-control" id='nombrePaciente' name='nombrePaciente' value="{$arr->nombre_paciente} {$arr->apellidos_paciente}" readonly>
            </div>
            <div class="col-sm-3">
                <label for="regionPaciente" class="control-label">Región</label>
                <input type="text" name="regionPaciente" id="regionPaciente" value="{$arr->region_paciente}" class="form-control" readonly>
            </div>
            <div class="col-sm-3">
                <label for="comunaPaciente" class="control-label">Comuna</label>
                <input type="text" name="comunaPaciente" id="comunaPaciente" value="{$arr->comuna_paciente}" class="form-control" readonly>
            </div>
        </div>
        <div class="top-spaced"></div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover table-striped table-bordered dataTable no-footer" width="100%" border="1">
                    <thead>
                        <tr>
                            <th align="center"><b>TIPO DE CONTACTO</b></th>
                            <th align="center"><b>DATOS</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        {if $arrContactoPaciente}
                            {foreach from=$arrContactoPaciente key=key item=itm}
                                <tr>
                                    <td align="center">{$itm.json_datos.gl_tipo_contacto}</td>
                                    <td align="center">
                                        {if $itm.id_tipo_contacto == 1}
                                            {$itm.json_datos.telefono_fijo}
                                        {else if $itm.id_tipo_contacto == 2}
                                            {$itm.json_datos.telefono_movil}
                                        {else if $itm.id_tipo_contacto == 3}
                                            {$itm.json_datos.gl_direccion}, {$itm.json_datos.gl_comuna}, {$itm.json_datos.gl_region}
                                        {else if $itm.id_tipo_contacto == 4}
                                            {$itm.json_datos.gl_email}
                                        {else if $itm.id_tipo_contacto == 5}
                                            {$itm.json_datos.gl_casilla_postal}
                                        {/if}
                                    </td>
                                </tr>
                            {/foreach}
                        {else}
                            <tr><td colspan="2" align="center">Sin Contactos</td></tr>
                        {/if}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="top-spaced"></div>
    </div>
</div>

<div class="top-spaced"></div>
{/if}