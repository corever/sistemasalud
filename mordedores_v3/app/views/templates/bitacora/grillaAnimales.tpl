<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<div class="box-body">
    <div id="div_tabla" class="table-responsive small"> 
        <table id="tablaAnimal" class="table table-hover table-striped table-bordered  table-middle dataTable no-footer">
            <thead>
                <tr role="row">
                    <th align="center" width="5%">Folio</th>
                    <th align="center" width="5%">Grupo</th>
                    <th align="center" width="5%">Microchip</th>
                    <th align="center" width="10%">Nombre</th>
                    <th align="center" width="10%">Especie</th>
                    <th align="center" width="10%">Raza</th>
                    <th align="center" width="5%">Estado</th>
                    <th align="center" width="5%">Necesita Vacuna</th>
                    <th align="center" width="5%">Antirrabica Vigente</th>
                    <th align="center" width="15%">Dirección</th>
                    <th align="center" width="10%">Datos dueño</th>
                    <th align="center" width="10%">Bitacora Mordedor</th>
                </tr>
            </thead>
            <tbody>
            {if isset($arr->arrMordedores->row_0)}
                {foreach $arr->arrMordedores as $morde}
                    <tr>
                        <td class="text-center">{$morde->gl_folio_mordedor}</td>
                        <td class="text-center">{$morde->gl_animal_grupo}</td>
                        <td class="text-center">{$morde->gl_microchip}</td>
                        <td class="text-center">{$morde->gl_nombre}</td>
                        <td class="text-center">{$morde->gl_animal_especie}</td>
                        <td class="text-center">{$morde->gl_animal_raza}</td>
                        <td class="text-center">{$morde->gl_animal_estado}</td>
                        <td class="text-center">{if $morde->bo_necesita_vacuna == 1}SI{else}NO{/if}</td>
                        <td class="text-center">{if $morde->bo_antirrabica_vigente == 1}SI{else}NO{/if}</td>
                        <td class="text-center">
                            {assign var="json_direccion" value=$morde->json_direccion|@json_decode}
                             {$json_direccion->gl_direccion} {$morde->gl_comuna} {$morde->gl_region}
                        </td>
                        <td class="text-center">
                            {if $morde->token_dueno || $morde->gl_pasaporte}
                                {$morde->gl_nombre_dueno}<br>{$morde->gl_rut_dueno}
                                <button onclick="xModal.open('{$smarty.const.BASE_URI}/Bitacora/verDueno/?token_dueno={$morde->token_dueno}', 'Ver Dueño de Mordedor {$morde->gl_nombre}', 70);" 
                                        title="Detalle Dueño" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                            {else}
                                Sin Dueño
                            {/if}
                        </td>
                        <td class="text-center">
                            {if !empty($morde->gl_microchip)}
                                <button type="button" onclick="xModal.open('{$smarty.const.BASE_URI}/BitacoraMordedor/ver/{$morde->gl_microchip}', 'Bitácora Mordedor {$morde->gl_folio_mordedor}', 70)" data-toggle="tooltip" class="btn btn-xs btn-primary" data-title="Bitácora Mordedor" data-hasqtip="48" aria-describedby="qtip-48">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            {else}
                {foreach from=$arr->arrMordedor key=key item=morde}
                    {assign var=json_mordedor value=$morde.json_mordedor}
                    <tr>
                        <td class="text-center">{$json_mordedor.gl_folio_mordedor}</td>
                        <td class="text-center">{$json_mordedor.gl_grupo_animal}</td>
                        <td class="text-center">-</td>
                        <td class="text-center">{$json_mordedor.nombre_animal}</td>
                        <td class="text-center">{$json_mordedor.gl_especie_animal}</td>
                        <td class="text-center">{$json_mordedor.gl_raza_animal}</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">
                            {$json_mordedor.gl_direccion}, {$json_mordedor.gl_comuna}, {$json_mordedor.gl_region}
                        </td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                    </tr>
                {/foreach}
            {/if}
            </tbody>
        </table>            
    </div>
</div>