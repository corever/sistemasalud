<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<div class="box-body">
    <div id="div_tabla" class="table-responsive small"> 
        <table class="table table-hover table-striped table-bordered  table-middle dataTable no-footer">
            <thead>
                <tr role="row">
                    <th align="center" width="5%"></th>
                    <th align="center" width="5%">Folio Mordedor</th>
                    <th align="center" width="10%">Estado</th>
                    <th align="center" width="10%">Resultado Visita</th>
                    <th align="center" width="10%">Resultado Laboratorio</th>
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
                {assign var="mordedores" value=$json_visita->datos_visita->mordedores}
                {assign var="json_direccion_expediente" value=$visita->json_direccion_mordedura|@json_decode}
                <tr>
                    <td align="center">
                        <button class="btn btn-xs btn-primary" type="button" id="btnVerVisita" name="btnVerVisita" data-title="Ver Detalle Visita"
                                onclick="xModal.open('{$smarty.const.BASE_URI}/Bitacora/detalleVisita/?token={$visita->gl_token_fiscalizacion}','Ver Detalle Visita {$json_visita->datos_visita->gl_folio}',80)">
                            <i class="fa fa-search-plus"></i>
                        </button>
                    </td>
                    <td align="center">
                        {if $visita->gl_folio_mordedores != ""}
                            {$visita->gl_folio_mordedores}
                        {else}
                            {foreach from=$mordedores item=item_mordedor}
                                {$item_mordedor->gl_folio_mordedor}<br>
                            {/foreach}
                        {/if}
                        
                        </td>
                    <td align="center">
                        {if $visita->id_visita_estado == 1}
                            <span class="label label-danger">{$visita->gl_estado}</span>
                        {else}
                            <span class="label label-success">{$visita->gl_estado}</span>
                        {/if}
                    </td>
                    <td align="center">

                        {if $visita->id_visita_estado == 2 && $visita->id_tipo_visita_resultado != 4}
                            {if $visita->id_tipo_visita_resultado == 2 || $visita->id_tipo_visita_resultado_mor == 2}
                                <span class="label label-danger">Sospechoso</span>
                            {elseif $visita->id_tipo_visita_resultado == 1}
                                <span class="label label-success">No Sospechoso</span>
                            {elseif $visita->id_tipo_visita_resultado == 3}
                                <span class="label label-info">Sin Datos</span>
                            {elseif $visita->id_tipo_visita_resultado == 5}
                                <span class="label label-danger">{$visita->tipo_resultado_visita}</span>
                            {else}
                                -
                            {/if}
                        {else}
                           {if $visita->id_tipo_visita_perdida == 1}
                                <span class="label label-danger">{$visita->tipo_visita_perdida}</span>
                            {elseif $visita->id_tipo_visita_perdida == 2}
                                <span class="label label-info">{$visita->tipo_visita_perdida}</span>
                            {elseif $visita->id_tipo_visita_perdida == 3}
                                <span class="label label-warning">{$visita->tipo_visita_perdida}</span>
                            {elseif $visita->id_tipo_visita_perdida == 4}
                                <span class="label label-default">{$visita->tipo_visita_perdida}</span>
                            {elseif $visita->id_tipo_visita_perdida == 5}
                                <span class="label label-warning">{$visita->tipo_visita_perdida}</span>
                            {else}
                                -
                            {/if}
                        {/if}
                        
                    </td>
                    <td class="text-center">
                        {if $visita->id_tipo_visita_resultado_mor == 2}
                            {if $visita->id_resultado_isp_1 == 1}
                                <span class="label label-danger">Positivo</span>
                            {else if $visita->nr_visitas_mordedor > 0 && $visita->id_resultado_isp_2 == 2}
                                <span class="label label-success">Negativo</span>
                            {else}
                                -
                            {/if}
                        {else}
                            -
                        {/if}
                    </td>
                    <td align="center">{$visita->gl_fiscalizador}</td>
                    <td align="center">{(!empty($json_visita->datos_visita->nombre_region)) ? $json_visita->datos_visita->nombre_region : $visita->gl_region_mordedura}</td>
                    <td align="center">{(!empty($json_visita->datos_visita->nombre_comuna)) ? $json_visita->datos_visita->nombre_comuna : $visita->gl_comuna_mordedura}</td>
                    <td align="center">{(!empty($json_visita->datos_visita->json_direccion_mordedura)) ? $json_visita->datos_visita->json_direccion_mordedura->gl_direccion : $json_direccion_expediente->gl_direccion}</td>
                    <td align="center">{$visita->fc_visita}</td>
                    <td align="center">{$visita->gl_observacion_visita}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>