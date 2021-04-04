<div class="panel panel-primary">

    <div class="panel-body">
        
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <div class="form-group">
                        &ensp;&ensp;&ensp;El paciente con RUT <strong style=" font-size: 14px;" >{$rut}</strong> tiene notificaciones registradas en los ultimos 3 meses.
                        <br> &ensp;&ensp;&ensp;Favor de <strong>Revisar</strong> y <strong>Marcar</strong>
                        <button class="btn btn-xs btn-success" style="pointer-events: none;"><i class='fa fa-check'></i></button> si notificación corresponde a una de las siguientes:
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12" id="grilla-contacto-paciente">
                <div class="table-responsive col-lg-12" data-row="10">
                    <table id="tablaPrincipal" class="table table-hover table-striped table-bordered dataTable no-footer">
                        <thead>
                            <tr role="row">
                                <th class="text-center" width="5%">Folio</th>
                                <th class="text-center" width="5%">Fecha Registro</th>
                                <th class="text-center" width="15%">Establecimiento Salud</th>
                                <th class="text-center" width="10%">Región Mordedura</th>
                                <th class="text-center" width="5%">Fecha de Mordedura</th>
                                <th class="text-center" width="10%">Grupo Mordedor</th>
                                <th class="text-center" width="10%">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $arrResultado as $item}
                                <tr>
                                    <td style="{$color}" class="text-center" nowrap> {$item->gl_folio} </td>
                                    <td style="{$color}" class="text-center"> {$item->fc_ingreso} </td>
                                    <td style="{$color}" class="text-center"> {$item->gl_establecimiento} </td>
                                    <td style="{$color}" class="text-center"> {$item->gl_region_mordedura} </td>
                                    <td style="{$color}" class="text-center"> {$item->fc_mordedura} </td>
                                    <td style="{$color}" class="text-center">
                                        {if $item->id_animal_grupo == 1}
                                            <span class="label label-warning">{$item->gl_grupo_animal}</span>
                                        {elseif $item->id_animal_grupo == 2}
                                            <span class="label label-info">{$item->gl_grupo_animal}</span>
                                        {else}
                                            <span class="label label-success">{$item->gl_grupo_animal}</span>
                                        {/if}
                                    </td>
                                    <td style="{$color}" class="text-center" nowrap>
                                        {assign var="token_expediente" value=$item->gl_token}
                                        {assign var="gl_folio" value=$item->gl_folio}
                                        {assign var="gl_rut" value=$rut}

                                        {php}
                                            echo Boton::getBotonBitacora(   $template->getTemplateVars('token_expediente'),
                                                                            $template->getTemplateVars('gl_folio'));

                                            echo Boton::getBotonNotificacionRepetida(   $template->getTemplateVars('token_expediente'),
                                                                                        $template->getTemplateVars('gl_folio'),
                                                                                        $template->getTemplateVars('gl_rut'));
                                        {/php}
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-group row top-spaced">
            <div class="col-sm-12 text-center">
                <button type="button" onclick="xModal.close();" class="btn btn-md btn-warning">
                    <i class="fa fa-close"></i>&nbsp; Cancelar - No corresponde a ning&uacute;n Caso
                </button>
            </div>
        </div>

    </div>
</div>