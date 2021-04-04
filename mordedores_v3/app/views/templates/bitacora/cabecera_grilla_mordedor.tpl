<table class="table table-hover table-striped table-bordered dataTable no-footer" width="100%" border="1">
    <thead>
        <tr>
            <th align="center"><b>FOLIO</b></th>
            <th align="center"><b>GRUPO</b></th>
            <th align="center"><b>ESPECIE</b></th>
            <th align="center"><b>RAZA</b></th>
            <th align="center"><b>COLOR</b></th>
            <th align="center"><b>TAMAÑO</b></th>
            <th align="center"><b>DIRECCIÓN MORDEDOR</b></th>
            <th align="center"><b>FISCALIZADOR</b></th>
            {if $resultado_isp == 1}
                <th align="center"><b>Resultado</b></th>
                <th align="center"><b>Resultado ISP</b></th>
            {/if}
            {if $bo_opciones == 1}<th align="center">Opciones</th>{/if}
        </tr>
    </thead>
    <tbody>
        {if $arr->arrMordedor}
            {foreach from=$arr->arrMordedor key=key item=item}
                {assign var=json_mordedor value=$item.json_mordedor}
                <tr>
                    <td align="left">{$item.gl_folio_mordedor}</td>
                    <td align="center">
                        {if $item.id_animal_grupo == 1}
                            <span class="label label-warning">{$item.gl_nombre_corto_grupo}</span>
                        {else if $item.id_animal_grupo == 2}
                            <span class="label label-info">{$item.gl_nombre_corto_grupo}</span>
                        {else if $item.id_animal_grupo == 3}
                            <span class="label label-success">{$item.gl_nombre_corto_grupo}</span>
                        {/if}
                    </td>
                    <td align="left">{$json_mordedor.gl_especie_animal}</td>
                    <td align="left">{$json_mordedor.gl_raza_animal}</td>
                    <td align="left">{$json_mordedor.gl_color_animal}</td>
                    <td align="left">{$json_mordedor.gl_tamano_animal}</td>
                    <td align="left">
                        {if $json_mordedor.gl_direccion != ""}
                            {$json_mordedor.gl_direccion}, {if $item.gl_comuna_mordedor}{$item.gl_comuna_mordedor}{else}{$json_mordedor.gl_comuna}{/if},
                            {if $item.gl_region_mordedor}{$item.gl_region_mordedor}{else}{$json_mordedor.gl_region}{/if}
                        {else}
                            <label class="label label-info">Sin Dirección</label>
                        {/if}
                    </td>
                    <td align="left">{if $item.nombre_fiscalizador}{$item.nombre_fiscalizador} ({$item.gl_exp_mor_estado}){else}No Asignado{/if}</td>
                    {if $resultado_isp == 1}
                        <td align="center">
                        {if $item.bo_rabia == 1}
                            <span class="label label-danger">Sospechoso</span>
                        {else}
                            <span class="label label-success">No Sospechoso</span>
                        {/if}
                        </td>
                        <td align="center">
                        {if $item.id_tipo_resultado_isp == 1}
                            <span class="label label-danger">Positivo</span>
                        {else if $item.id_tipo_resultado_isp == 2}
                            <span class="label label-success">Negativo</span>
                        {else}
                                -
                        {/if}
                        </td>
                    {/if}
                    {if $bo_opciones == 1}
                    <td align="center">
                        {if $bandeja == 'asignar'}
                            {if $json_mordedor.id_region_animal == $id_region_usuario or $id_perfil_usuario == 1}{$item.bo_ultimo_volver_visitar}
                                {if ($item.id_exp_mor_estado == 1 or ($item.id_exp_mor_estado == 11 && $arr->bo_ultimo_volver_visitar == 2))
                                    && $item.id_animal_grupo == 3 && ($json_mordedor.bo_domicilio_conocido == 1 or $json_mordedor.bo_vive_con_paciente == 1)}
                                    <button type="button" data-toggle="tooltip" class="btn btn-xs btn-success" data-title="Asignar"
                                            onclick="xModal.open('{$smarty.const.BASE_URI}/Agenda/asignarFiscalizador/{$item.token_exp_mor}/{$json_mordedor.id_region_animal}/{$json_mordedor.id_comuna_animal}/{$item.token_fiscalizador}', 'Asignar Fiscalizador {$json_mordedor.gl_folio_mordedor}', 60)">
                                        <i class="fa fa-user-plus"></i>
                                    </button>
                                {else if $item.id_exp_mor_estado == 9 && $item.id_animal_grupo == 3 && ($json_mordedor.bo_domicilio_conocido == 1 or $json_mordedor.bo_vive_con_paciente == 1)}
                                    <button type="button" data-toggle="tooltip" class="btn btn-xs btn-warning" data-title="Reasignar"
                                            onclick="xModal.open('{$smarty.const.BASE_URI}/Agenda/asignarFiscalizador/{$item.token_exp_mor}/{$json_mordedor.id_region_animal}/{$json_mordedor.id_comuna_animal}/{$item.token_fiscalizador}', 'Reasignar Fiscalizador {$json_mordedor.gl_folio_mordedor}', 60)">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                {else if $json_mordedor.gl_direccion == ""}
                                    <label class="label label-info">Sin Dirección</label>
                                {/if}
                            {/if}
                        {elseif $bandeja == 'devolver'}
                            {if $item.id_fiscalizador == $id_usuario}
                                {if ($item.id_exp_mor_estado == 6 or $item.id_exp_mor_estado == 14 or $item.id_exp_mor_estado == 7) && $item.id_animal_grupo == 3}
                                    <button type="button" data-toggle="tooltip" class="btn btn-xs btn-warning" data-title="Devolver"
                                            onclick="Fiscalizador.devolverSupervisor('{$item.token_exp_mor}');">
                                        <i class="fa fa-undo"></i>
                                    </button>
                                {/if}
                            {/if}
                        {*elseif $bandeja == 'programar'}
                            {if $item.id_fiscalizador == $id_usuario or $id_perfil_usuario == 1}
                                {if ($item.id_exp_mor_estado == 2 or $item.id_exp_mor_estado == 13) && $json_mordedor.id_animal_grupo == 3}
                                    <button type="button" data-toggle="tooltip" class="btn btn-xs btn-success" data-title="Programar"
                                            onclick="xModal.open('{$smarty.const.BASE_URI}/Agenda/programarVisita/{$item.token_exp_mor}/0', 'Programar Visita', 60)">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                {else if ($item.id_exp_mor_estado == 6 or $item.id_exp_mor_estado == 14) && $json_mordedor.id_animal_grupo == 3}
                                    <button type="button" data-toggle="tooltip" class="btn btn-xs btn-warning" data-title="Reprogramar"
                                            onclick="xModal.open('{$smarty.const.BASE_URI}/Agenda/programarVisita/{$item.token_exp_mor}/1', 'Reprogramar Visita', 60)">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                {/if}
                            {/if*}
                        {elseif $bandeja == 'asignar_microchip'}
                            {if $json_mordedor.id_region_animal == $id_region_usuario or $id_perfil_usuario == 1}
                                {if ($item.id_exp_mor_estado == 1 or ($item.id_exp_mor_estado == 11 && $arr->bo_ultimo_volver_visitar == 2))
                                    && $item.id_animal_grupo == 3 && ($json_mordedor.bo_domicilio_conocido == 1 or $json_mordedor.bo_vive_con_paciente == 1)}
                                    <button type="button" data-toggle="tooltip" class="btn btn-xs btn-success" data-title="Asignar"
                                            onclick="xModal.open('{$smarty.const.BASE_URI}/Microchip/asignarFiscalizador/{$item.token_exp_mor}/{$json_mordedor.id_region_animal}/{$json_mordedor.id_comuna_animal}/{$item.token_fiscalizador_microchip}', 'Asignar Fiscalizador {$json_mordedor.gl_folio_mordedor}', 60)">
                                        <i class="fa fa-user-plus"></i>
                                    </button>
                                {else if $item.id_exp_mor_estado == 9 && $item.id_animal_grupo == 3 && ($json_mordedor.bo_domicilio_conocido == 1 or $json_mordedor.bo_vive_con_paciente == 1)}
                                    <button type="button" data-toggle="tooltip" class="btn btn-xs btn-warning" data-title="Reasignar"
                                            onclick="xModal.open('{$smarty.const.BASE_URI}/Microchip/asignarFiscalizador/{$item.token_exp_mor}/{$json_mordedor.id_region_animal}/{$json_mordedor.id_comuna_animal}/{$item.token_fiscalizador_microchip}', 'Reasignar Fiscalizador {$json_mordedor.gl_folio_mordedor}', 60)">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                {else if $json_mordedor.gl_direccion == ""}
                                    <label class="label label-info">Sin Dirección</label>
                                {/if}
                            {/if}
                        {elseif $bandeja == 'administrativo'}
                            {if ($item.id_region_estableci == $id_region_usuario) or ($json_mordedor.id_region_animal == $id_region_usuario)}
                                {if $item.id_exp_mor_estado == 1 && $item.bo_domicilio_conocido == 0}
                                    <button type="button" data-toggle="tooltip" class="btn btn-xs btn-warning" data-title="Editar Dirección"
                                            onclick="xModal.open('{$smarty.const.BASE_URI}/Administrativo/editarDireccion/{$item.token_exp_mor}', 'Editar Dirección {$json_mordedor.gl_folio_mordedor}', 60)">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                {/if}
                            {/if}
                        {/if}
                        
                        {if $resultado_isp == 1 && $item.bo_rabia == 1 && $item.id_tipo_resultado_isp != 1 && $item.id_tipo_resultado_isp != 2}
                            <button type="button" data-toggle="tooltip" class="btn btn-xs btn-warning" data-title="Informar Resultado ISP"
                                    onclick="xModal.open('{$smarty.const.BASE_URI}/Administrativo/guardarResultadoISP/{$json_mordedor.gl_folio_mordedor}', 'Guardar Resultado Visita {$json_mordedor.gl_folio_mordedor}', 55)">
                                <i class="fa fa-flask"></i>
                            </button>
                        {/if}
                    </td>
                    {/if}
                </tr>
            {/foreach}
        {else}
            <tr><td colspan="6" align="center">Sin Mordedores</td></tr>
        {/if}
    </tbody>
</table>