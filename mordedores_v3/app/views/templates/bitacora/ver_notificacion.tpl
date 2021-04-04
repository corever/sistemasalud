<div class="panel panel-primary">
    <div class="panel-heading" style="cursor:pointer;" onclick="ocultaMuestraVista('identificacion_establecimiento');">
        Identificación de Establecimiento <div class="pull-right"><i id="i-identificacion_establecimiento" class="glyphicon glyphicon-chevron-down"></i></div>
    </div>
    <div class="panel-body" id="identificacion_establecimiento">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <label>Establecimiento Salud</label>
                <input type="text" class="form-control" value="{$arrExpediente->gl_establecimiento}" readonly>
            </div>
            <div class="col-md-3 col-xs-6">
                <label>Fecha Atención</label>
                <input type="text" class="form-control" value="{$arrExpediente->fc_ingreso} {$arrExpediente->gl_hora_ingreso}" readonly>
            </div>
            <div class="col-md-3 col-xs-6">
                <label>Fecha Notificación</label>
                <input type="text" class="form-control" value="{$arrExpediente->fc_notificacion_seremi}" readonly>
            </div>
        </div>
        
        <div class="row">&nbsp;</div>
    </div>
</div>

<div class="top-spaced"></div>

<div class="panel panel-primary">
    <div class="panel-heading" style="cursor:pointer;" onclick="ocultaMuestraVista('identificacion_paciente');">
        Identificación de Paciente <div class="pull-right"><i id="i-identificacion_paciente" class="glyphicon glyphicon-chevron-down"></i></div>
    </div>
    <div class="panel-body" id="identificacion_paciente">
        <div class="row">
            <div class="col-md-3 col-xs-6">
                <label>RUT/Pasaporte</label>
                <input type="text" class="form-control" value="{if $arrExpediente->rut_paciente}{$arrExpediente->rut_paciente}{else if $arrPasaporte.gl_pasaporte}{$arrPasaporte.gl_pasaporte}{else}-{/if}" readonly>
            </div>
            <div class="col-sm-3 col-xs-6">
                <label>Nombre</label>
                <input type='text' class="form-control"value="{$arrExpediente->nombre_paciente} {$arrExpediente->apellidos_paciente}" readonly>
            </div>
            <div class="col-sm-3 col-xs-6">
                <label>Fecha Nacimiento</label>
                <input type="text" value="{$arrExpediente->fc_nacimiento_paciente}" class="form-control" readonly>
            </div>
            <div class="col-sm-3 col-xs-6">
                <label>Edad</label>
                <input type="text" value="{$arrExpediente->nr_edad_paciente}" class="form-control" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 col-xs-6">
                <label>País</label>
                <input type="text" value="{$arrExpediente->gl_pais_paciente}" class="form-control" readonly>
            </div>
            <div class="col-sm-3 col-xs-6">
                <label>Nacionalidad</label>
                <input type="text" value="{$arrExpediente->gl_nacionalidad_paciente}" class="form-control" readonly>
            </div>
            <div class="col-sm-3 col-xs-6">
                <label>Sexo</label>
                <input type="text" value="{$arrExpediente->gl_tipo_sexo}" class="form-control" readonly>
            </div>
            <div class="col-sm-3 col-xs-6">
                <label>Previsión</label>
                <input type="text" value="{$arrExpediente->nombre_prevision_paciente}" class="form-control" readonly>
            </div>
        </div>
        <div class="row">
            {if $arrExpediente->arrContactoPac}
                {foreach from=$arrExpediente->arrContactoPac key=key item=itm}
                    {if $itm.id_tipo_contacto == 1}
                        {assign var=valor_contacto value=$itm.json_datos.telefono_fijo}
                    {else if $itm.id_tipo_contacto == 2}
                        {assign var=valor_contacto value=$itm.json_datos.telefono_movil}
                    {else if $itm.id_tipo_contacto == 3}
                        {assign var=valor_contacto value=$itm.json_datos.gl_direccion|cat:", "|cat:$itm.json_datos.gl_comuna|cat:", "|cat:$itm.json_datos.gl_region}
                        {assign var=img_direccion value=$itm.json_datos.img_direccion}
                    {else if $itm.id_tipo_contacto == 4}
                        {assign var=valor_contacto value=$itm.json_datos.gl_email}
                    {else if $itm.id_tipo_contacto == 5}
                        {assign var=valor_contacto value=$itm.json_datos.gl_casilla_postal}
                    {/if}
                    <div class="{if $itm.id_tipo_contacto == 3}col-sm-6{else}col-sm-3{/if} col-xs-6">
                        <label>{$itm.json_datos.gl_tipo_contacto}</label>
                        <input type="text" value="{$valor_contacto}" class="form-control" readonly>
                    </div>
                {/foreach}
            {/if}
            {*<div class="col-sm-6">
                <br>
                <img src='{$img_direccion}' style="max-width: 600px; max-height: 400px">
            </div>*}
        </div>
        
        <div class="row">&nbsp;</div>
    </div>
</div>

<div class="top-spaced"></div>

<div class="panel panel-primary">
    <div class="panel-heading" style="cursor:pointer;" onclick="ocultaMuestraVista('identificacion_mordedura');">
        Identificación de Mordedura <div class="pull-right"><i id="i-identificacion_mordedura" class="glyphicon glyphicon-chevron-down"></i></div>
    </div>
    <div class="panel-body" id="identificacion_mordedura">
        <div class="col-md-6">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <label>Fecha Mordedura</label>
                    <input type="text" value="{$arrExpediente->fc_mordedura}" class="form-control" readonly>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <label>Lugar Mordedura</label>
                    <input type="text" value="{$arrExpediente->arrExpediente.gl_lugar_mordedura}" class="form-control" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <label>Dirección de Mordedura</label>
                    <input type="text" class="form-control" readonly
                           value="{$arrExpediente->arrDirMordedura.gl_direccion}, {$arrExpediente->comuna_mordedura}, {$arrExpediente->region_mordedura}">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <label>Datos Referencia</label>
                    <textarea type="text" class="form-control" style="max-width:100%;min-width:100%;" width="100%" readonly
                              >{if $arrExpediente->arrDirMordedura.gl_datos_referencia}{$arrExpediente->arrDirMordedura.gl_datos_referencia}{else}-{/if}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <label>Inicia Vacunación</label>
                    {if $arrExpediente->id_inicia_vacuna == 1}
                        <span class="form-control label label-success">{$arrExpediente->arrExpediente.gl_inicia_vacuna}</span>
                    {else}
                        <span class="form-control label label-warning">{$arrExpediente->arrExpediente.gl_inicia_vacuna}</span>
                    {/if}
                </div>
                <div class="col-sm-6 col-xs-12">
                    <label>Tipo Mordedura</label>
                    <input type="text" value="{$arrExpediente->arrExpediente.gl_tipo_mordedura}" class="form-control" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <label>Observaciones</label>
                    <textarea type="text" class="form-control" style="max-width:100%;min-width:100%;" width="100%" readonly>{$arrExpediente->gl_observacion}</textarea>
                </div>
            </div>
            
            <div class="row">&nbsp;</div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <br>
                <img src='{$arrExpediente->arrDirMordedura.img_direccion}' style="max-width: 600px; max-height: 400px">
            </div>
        </div>
            
        
    </div>
</div>

<div class="top-spaced"></div>

<div class="panel panel-primary">
    <div class="panel-heading" style="cursor:pointer;" onclick="ocultaMuestraVista('identificacion_mordedor');">
        Identificación de Mordedor <div class="pull-right"><i id="i-identificacion_mordedor" class="glyphicon glyphicon-chevron-down"></i></div>
    </div>
    <div class="panel-body" id="identificacion_mordedor">
        <div class="row">
            <div class="col-sm-3 col-xs-12">
                <label>Grupo Animal</label>
                <input type="text" value="{$arrExpediente->gl_animal_grupo}" class="form-control" readonly>
            </div>
            <div class="col-sm-9 col-xs-12">
                <label>Observaciones</label>
                <input type="text" class="form-control" value="{$arrExpediente->gl_observacion}" readonly>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover table-striped table-bordered dataTable no-footer" width="100%" border="1">
                    <thead>
                        <tr>
                            <th align="center"><b>FOLIO</b></th>
                            <th align="center"><b>ESPECIE</b></th>
                            <th align="center"><b>RAZA</b></th>
                            <th align="center"><b>NOMBRE</b></th>
                            <th align="center"><b>COLOR</b></th>
                            <th align="center"><b>TAMAÑO</b></th>
                            <th align="center"><b>DIRECCIÓN DE MORDEDOR</b></th>
                        </tr>
                    </thead>
                    </tbody>
                        {foreach from=$arrExpediente->arrMordedor key=key item=itm}
                            {assign var=item value=$itm.json_mordedor}
                            <tr>
                                <td align="center"><b>{$itm.gl_folio_mordedor}</b></td>
                                <td align="center">{$item.gl_especie_animal}</td>
                                <td align="center">{$item.gl_raza_animal}</td>
                                <td align="center">{$item.nombre_animal}</td>
                                <td align="center">{$item.gl_color_animal}</td>
                                <td align="center">{$item.gl_tamano_animal}</td>
                                <td align="center">{$item.gl_direccion}, {$item.gl_comuna}, {$item.gl_region}</td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
            
        <div class="row">&nbsp;</div>
    </div>

</div>