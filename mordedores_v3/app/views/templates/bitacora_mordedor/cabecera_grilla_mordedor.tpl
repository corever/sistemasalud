<table class="table table-hover table-striped table-bordered dataTable no-footer" width="100%" border="1">
    <thead>
        <tr>
            <th align="center"><b>Fecha Visita</b></th>
            <th align="center"><b>Estado</b></th>
            <th align="center"><b>Resultado</b></th>
            <th align="center"><b>Fiscalizador</b></th>
            <th align="center"><b>Observaciones Visita</b></th>
            <th align="center"><b>Sintomas de rabia</b></th>
            <th align="center"><b>Descripción Mordedor</b></th>
            <th align="center"><b>Tipo de Sintomas</b></th>
            <th align="center"><b>Detalle</b></th>
        </tr>
    </thead>
    <tbody>
        {if $arr->arrVisitasMordedor}
            {foreach from=$arr->arrVisitasMordedor key=key item=item}
                {assign var=itm_mordedor value=$item->json_mordedor}
                {assign var=itm_dueno value=$item->json_dueno}
                {assign var=itm_tipo_sintoma value=$item->json_tipo_sintoma}
                {assign var=itm_resultado_isp value=$item->json_resultado_isp}
                {assign var=itm_otros_datos value=$item->json_otros_datos}
                <tr>
                    <td align="left">{if $item->fc_visita}{$item->fc_visita}{else}{$item->fc_crea_visita}{/if}</td>
                    <td align="left">
                        {if $item->id_visita_estado == 1}
                            <span class="form-control label label-danger">{$item->gl_estado}</span>
                        {else}
                            <span class="form-control label label-success">{$item->gl_estado}</span>
                        {/if}
                    </td>
                    <td align="left">
                        {if $item->id_visita_estado == 2 && $item->id_tipo_visita_resultado != 4}
                            {if $item->id_tipo_visita_resultado == 1}
                                <span class="form-control label label-success">{$item->gl_tipo_resultado}</span>
                            {elseif $item->id_tipo_visita_resultado == 2}
                                <span class="form-control label label-danger">{$item->gl_tipo_resultado}</span>
                            {elseif $item->id_tipo_visita_resultado == 3}
                                <span class="form-control label label-info">{$item->gl_tipo_resultado}</span>
                            {elseif $item->id_tipo_visita_resultado == 5}
                                <span class="form-control label label-danger">{$item->gl_tipo_resultado}</span>
                            {else}
                                -
                            {/if}
                        {else}
                            {if $item->id_tipo_visita_perdida == 1}
                                <span class="form-control label label-danger">{$item->gl_tipo_perdida}</span>
                            {elseif $item->id_tipo_visita_perdida == 2}
                                <span class="form-control label label-info">{$item->gl_tipo_perdida}</span>
                            {elseif $item->id_tipo_visita_perdida == 3}
                                <span class="form-control label label-warning">{$item->gl_tipo_perdida}</span>
                            {elseif $item->id_tipo_visita_perdida == 4}
                                <span class="form-control label label-default">{$item->gl_tipo_perdida}</span>
                            {elseif $item->id_tipo_visita_perdida == 5}
                                <span class="form-control label label-warning">{$item->gl_tipo_perdida}</span>
                            {else}
                                -
                            {/if}
                        {/if}
                    </td>
                    <td align="left">{$item->gl_fiscalizador}</td>
                    <td align="left">{(!empty($item->gl_descripcion)) ? $item->gl_descripcion : '-'}</td>
                    <td align="left">
                        {if $item->bo_sintoma_rabia == 1}
                            <span class="form-control label label-danger">SI</span>
                        {else}
                            <span class="form-control label label-success">NO</span>
                        {/if}
                    </td>
                    <td align="left">{(!empty($item->gl_observacion_visita)) ? $item->gl_observacion_visita : '-'}</td>
                    <td align="left">{$item->listado_sintomas}</td>
                    <td align="center">
                        <button class="btn btn-xs btn-primary" type="button" id="btnVerVisita" name="btnVerVisita" data-title="Ver Detalle Visita"
                                onclick="xModal.open('{$smarty.const.BASE_URI}/Bitacora/detalleVisita/?token={$item->gl_token_fiscalizacion}','Ver Detalle Visita {$item->folio_expediente}',80)">
                            <i class="fa fa-search-plus"></i>
                        </button>
                    </td>
                </tr>
                
            {/foreach}
        {else}
            <tr><td colspan="6" align="center">Sin Visitas al Mordedores</td></tr>
        {/if}
    </tbody>
</table>