 <div class="table-responsive col-lg-12" data-row="10">
    <table id="tablaPrincipal" class="table table-hover table-striped table-bordered dataTable no-footer" data-sorting="1" data-sorting-order="asc" data-bandeja="{$bandeja}">
        <thead>
            <tr role="row">
                <th class="text-center" width="5%">Folio</th>
                <th class="text-center" width="5%">Fecha Registro</th>
                <th class="text-center" width="15%">Establecimiento Salud</th>
                {if $bandeja == 'nacional' or $bandeja == 'admin'}<th class="text-center" width="10%">Región<br>Mordedor</th>{/if}
                <th class="text-center" width="10%">Comuna Establecimiento<br> de Salud</th>
                <th class="text-center" width="5%">Fecha de Mordedura</th>
                <th class="text-center" width="5%">Días desde Mordedura</th>
                <th class="text-center" width="5%">Días en Bandeja</th>
               <!-- <th class="text-center" width="15%">Fiscalizador</th>-->
                <th class="text-center" width="10%">Estado</th>
                <!--<th class="text-center" width="10%">Resultado</th>-->
                <th class="text-center" width="10%">¿Inicia <br>Vacunación?</th>
                <th class="text-center" width="10%">Teléfono</th>
                <th class="text-center" width="10%">Especie Mordedor</th>
                <th class="text-center" width="10%">¿Paciente observa animal?</th>
                <th class="text-center" width="10%">Opciones</th>
            </tr>
        </thead>
        <tbody>
            {assign var=contador value=1}
            {foreach $arrResultado as $item}
                <tr class=  {if $item->id_alarma_estado == 1 or $item->id_ultimo_evento == 33}
                                'danger'
                            {else if $item->id_alarma_estado == 2}
                                'warning'
                            {else if $item->id_alarma_estado == 4}
                                'success'
                            {else if $item->bo_paciente_observa == 1}
                                'info'
                            {else}
                                ''
                            {/if}>

                    <td style="{$color}" class="text-center" nowrap> {$item->gl_folio} </td>
                    <td style="{$color}" class="text-center"> {$item->fc_ingreso} </td>
                    <td style="{$color}" class="text-center"> {$item->gl_establecimiento} </td>
                    {if $bandeja == 'nacional' or $bandeja == 'admin'}<td style="{$color}" class="text-center"> {$item->gl_region_mordedor} </td>{/if}
                    <td style="{$color}" class="text-center"> {$item->gl_comuna_establecimiento} </td>
                    <td style="{$color}" class="text-center"> {$item->fc_mordedura} </td>
                    <td style="{$color}" class="text-center"> {$item->dias_mordedura} </td>
                    <td style="{$color}" class="text-center"> {$item->dias_bandeja} </td>
                    <td style="{$color}" class="text-center">
                        <span class="{$item->gl_class_estado}">{$item->gl_nombre_estado}</span>
                    </td>

                    <td style="{$color}" class="text-center">
                        {if ($item->id_inicia_vacuna)=='1'}
                            <span class="label label-success">Sí</span>
                        {/if}
                        {if ($item->id_inicia_vacuna)=='2'}
                            <span class="label label-danger">No</span>
                        {/if}
                    </td>
                    <td style="{$color}" class="text-center"> {($item->telefono)?$item->telefono:'No aplica'} </td>
                  <!--  <td style="{$color}" class="text-center">
                        {if $item->gl_nombre_fiscalizador != ""}
                            {$item->gl_nombre_fiscalizador}
                            {assign var="grupo_fiscalizador" value=$item->grupo_fiscalizador}
                        {else if $item->gl_nombre_fiscalizador_microchip != ""}
                            {$item->gl_nombre_fiscalizador_microchip}
                            {assign var="grupo_fiscalizador" value=$item->grupo_fiscalizador_microchip}
                        {else}No Asignado{assign var="grupo_fiscalizador" value=""}{/if}
                    </td>-->
                    <input type="text" value="{$item->id_alarma}" id="id_alarma" name="id_alarma" class="hidden">
                  <!--  <td class="text-center">
                        {if $item->id_tipo_visita_resultado == 2 || $item->id_tipo_visita_resultado_mor == 2}
                            <span class="label label-danger">Sospechoso</span>
                        {else if $item->nr_visitas_mordedor > 0 && $item->id_expediente_estado == 11 && $item->id_ultimo_visita_resultado != 5}
                            <span class="label label-success">No Sospechoso</span>
                        {else if $item->id_ultimo_visita_estado == 1}
                            <span class="label label-danger">Perdida</span>
                        {else if $item->id_ultimo_visita_resultado == 5}
                            <span class="label label-danger">Se Niegan a Visita</span>
                        {else}
                            -
                        {/if}
                    </td>-->
                    <input type="text" value="{$item->id_tipo_alarma}" id="id_tipo_alarma" name="id_tipo_alarma" class="hidden">
                   <!-- <td class="text-center">
                        {if $item->id_tipo_visita_resultado_mor == 2}
                            {if $item->id_resultado_isp_1 == 1}
                                <span class="label label-danger">Positivo</span>
                            {else if $item->nr_visitas_mordedor > 0 && $item->id_resultado_isp_2 == 2}
                                <span class="label label-success">Negativo</span>
                            {else}
                                -
                            {/if}
                        {else}
                            -
                        {/if}
                    </td>-->
                    <input type="text" value="{$item->id_alarma_estado}" id="id_alarma_estado" name="id_alarma_estado" class="hidden">

                                            <!--td style="{$color}" class="text-center"> {*$item->gl_resultado*} </td-->
                    <td style="{$color}" class="text-center">
                        {if $item->id_animal_grupo == 1}
                            <span class="label label-warning">{$item->gl_grupo_animal}</span>
                        {elseif $item->id_animal_grupo == 2}
                            <span class="label label-info">{$item->gl_grupo_animal}</span>
                        {else}
                            <span class="label label-success">{$item->gl_especie}</span>
                        {/if}
                    </td>
                    <!-- paciente observa? -->
                    <td style="{$color}" class="text-center">
                        {if $item->bo_paciente_observa == 1}
                            <span class="label label-info">Sí</span>
                        {else}
                            <span class="label label-warning">No</span>
                        {/if}
                    </td>
                    <td style="{$color}" class="text-center" nowrap>

                        <input type="text" value="{$item->gl_token}" id="token_expediente" name="token_expediente" class="hidden">
                        <input type="text" value="{$item->gl_token_fiscalizador}" id="token_fiscalizador" name="token_fiscalizador" class="hidden">
                        <input type="text" value="{$item->id_expediente_estado}" id="estado_expediente" name="estado_expediente" class="hidden">
                        <input type="text" value="{$bandeja}" id="bandeja" name="bandeja" class="hidden">

                        {assign var="token_expediente"				value= $item->gl_token}
                        {assign var="token_fiscalizador"			value= $item->gl_token_fiscalizador}
                        {assign var="expediente_estado"				value= $item->id_expediente_estado}
                        {assign var="arr_expediente"				value= $item->json_expediente|@json_decode}
                        {assign var="arr_mordedor"					value= $item->json_mordedor|@json_decode}
                        {assign var="id_animal_grupo"				value= $item->id_animal_grupo}
                        {assign var="grupo_estado"					value= $item->grupo_expediente_mordedor_estado}
                        {assign var="gl_folio"						value= $item->gl_folio}
                        {assign var="nr_visitas"					value= $item->nr_visitas}
						{assign var="bo_domicilio_conocido"			value= $item->bo_domicilio_conocido}
						{assign var="bo_all_domicilio_conocido"		value= $item->bo_all_domicilio_conocido}
                        {assign var="id_tipo_visita_resultado"		value= $item->id_tipo_visita_resultado}
                        {assign var="id_tipo_visita_resultado_mor"	value= $item->id_tipo_visita_resultado_mor}
                        {assign var="id_resultado_isp_1"			value= $item->id_resultado_isp_1}
                        {assign var="id_resultado_isp_2"			value= $item->id_resultado_isp_2}
                        {assign var="bo_paciente_observa"			value= $item->bo_paciente_observa}
                        {assign var="boton_llamado_observa"			value= $item->boton_llamado_observa}
                        {assign var="grupo_resultado_isp"			value= $item->grupo_resultado_isp}
                        {assign var="id_ultimo_visita_estado"       value= $item->id_ultimo_visita_estado}
                        {assign var="id_ultimo_tipo_visita_perdida" value= $item->id_ultimo_tipo_visita_perdida}
                        {assign var="bo_ultimo_volver_visitar"      value= $item->bo_ultimo_volver_visitar}

                        {php} echo Boton::botonGrilla(
														$template->getTemplateVars('bandeja'),
														$template->getTemplateVars('token_expediente'),
														$template->getTemplateVars('token_fiscalizador'),
														$template->getTemplateVars('grupo_estado'),
														$template->getTemplateVars('id_animal_grupo'),
														$template->getTemplateVars('microchip'),
														$template->getTemplateVars('gl_folio'),
														$template->getTemplateVars('nr_visitas'),
														$template->getTemplateVars('expediente_estado'),
														$template->getTemplateVars('bo_domicilio_conocido'),
														$template->getTemplateVars('id_tipo_visita_resultado'),
														$template->getTemplateVars('id_tipo_visita_resultado_mor'),
														$template->getTemplateVars('id_resultado_isp_1'),
														$template->getTemplateVars('id_resultado_isp_2'),
														$template->getTemplateVars('bo_all_domicilio_conocido'),
														$template->getTemplateVars('grupo_fiscalizador'),
                                                        $template->getTemplateVars('bo_paciente_observa'),
                                                        $template->getTemplateVars('boton_llamado_observa'),
                                                        $template->getTemplateVars('grupo_resultado_isp'),
                                                        $template->getTemplateVars('id_ultimo_visita_estado'),
                                                        $template->getTemplateVars('id_ultimo_tipo_visita_perdida'),
                                                        $template->getTemplateVars('bo_ultimo_volver_visitar')
													); 
						{/php}
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>