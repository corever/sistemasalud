<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<div class="box-body">
    <div id="div_tabla" class="table-responsive small"> 
        <table id="tablaVisita" class="table table-hover table-striped table-bordered  table-middle dataTable no-footer">
            <thead>
                <tr role="row">
                    <th align="center" width="5%"></th>
                    <th align="center" width="5%">Folio</th>
                    <th align="center" width="10%">Estado</th>
                    <th align="center" width="10%">Resultado</th>
                    <th align="center" width="15%">Fiscalizador</th>
                    <th align="center" width="10%">Región</th>
                    <th align="center" width="10%">Comuna</th>
                    <th align="center" width="15%">Dirección</th>
                    <th align="center" width="5%">Fecha</th>
                    <th align="center" width="15%">Observación</th>
                </tr>
            </thead>
            <tbody>
            {foreach $arr->arrVisitas as $visita}
                {assign var="json_visita" value=$visita->json_visita|@json_decode}
                <tr>
                    <td align="center">
                        <button class="btn btn-xs btn-primary" type="button" id="btnVerVisita" name="btnVerVisita" data-title="Ver Detalle Visita"
                                onclick="xModal.open('{$smarty.const.BASE_URI}/Bitacora/detalleVisita/?token={$visita->gl_token_fiscalizacion}','Ver Detalle Visita {$json_visita->datos_visita->gl_folio}',80)">
                            <i class="fa fa-search-plus"></i>
                        </button>
                    </td>
                    <td align="center">{$json_visita->datos_visita->gl_folio}</td>
                    <td align="center">
                        {if $visita->id_visita_estado == 1}
                            <span class="label label-danger">{$visita->gl_estado}</span>
                        {else}
                            <span class="label label-success">{$visita->gl_estado}</span>
                        {/if}
                    </td>
                    <td align="center">
                        {foreach $arr->arrTipoResultados as $resul}
                            {if $json_visita->datos_visita->resultado_inspeccion == $resul->id_tipo_visita_resultado}
                                {if $resul->id_tipo_visita_resultado == 1}
                                    <span class="label label-success">{$resul->gl_nombre}</span>
                                {elseif $resul->id_tipo_visita_resultado == 2}
                                    <span class="label label-danger">{$resul->gl_nombre}</span>
                                {elseif $resul->id_tipo_visita_resultado == 3}
                                    <span class="label label-info">{$resul->gl_nombre}</span>
                                {elseif $resul->id_tipo_visita_resultado == 4}
                                    <span class="label label-danger">{$resul->gl_nombre}</span>
                                {/if}
                            {/if}
                        {/foreach}
                    </td>
                    <td align="center">{$visita->gl_fiscalizador}</td>
                    <td align="center">{$json_visita->datos_visita->nombre_region}</td>
                    <td align="center">{$visita->datos_visita->nombre_comuna}</td>
                    <td align="center">{$json_visita->datos_visita->json_direccion_mordedura->gl_direccion}</td>
                    <td align="center">{$visita->fc_visita}</td>
                    <td align="center">{$visita->gl_observacion_visita}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>