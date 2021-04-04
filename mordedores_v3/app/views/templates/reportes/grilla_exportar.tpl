 <table>
    <thead>
        <tr>
            <th colspan="20">Notificación</th>
            <th colspan="22">Visita</th>
        </tr>
        <tr>
            <th>Folio</th>
            <th>Fecha Registro</th>
            <th>Fecha Notificación Seremi</th>
            <th>Establecimiento Salud</th>
            <th>Paciente</th>
            <th>Dirección Paciente</th>
            <th>Teléfono Paciente</th>
            <th>Email Paciente</th>
            <th>Edad Paciente</th>
            <th>Sexo Paciente</th>
            <th>Fecha Mordedura</th>
            <th>Dirección Mordedura</th>
            <th>Lugar Mordedura</th>
            <th>Inicia Vacunación</th>
            <th>Tipo de Mordedura</th>
            <th>Dias desde Mordedura</th>
            <th>Dias en Bandeja</th>
            <th>Estado</th>
            <th>Grupo Mordedor</th>
            <th>Especie Mordedor</th>
            
            <th>Folio Mordedor</th>
            <th>Fecha Visita</th>
            <th>Fecha Sincronización</th>
            <th>Estado Visita</th>
            <th>Resultado Visita</th>
            <th>Motivo Visita Perdida</th>
            <th>Nombre Fiscalizador</th>
            <th>Estado Mordedor</th>
            <th>Especie Mordedor</th>
            <th>Raza Mordedor</th>
            <th>Nombre Mordedor</th>
            <th>Color Mordedor</th>
            <th>Tamaño Mordedor</th>
            <th>Sexo Mordedor</th>
            <th>Edad Mordedor</th>
            <th>Edad Meses Mordedor</th>
            <th>Peso Mordedor</th>
            <th>Estado Reproductivo Mordedor</th>
            <th>Dirección Mordedor</th>
            <th>¿Presenta sintomatología asociada a un cuadro de rabia?</th>
            <th>¿Mordedor Habitual?</th>
            <th>¿El animal tenía la vacuna antirrábica viigente al momento de la visita?</th>
            <th>¿La AS administra la vacuna al momento de la visita?</th>
            <th>Microchip</th>
        </tr>
    </thead>
    <tbody>
        {foreach $arrResultado as $item}
            {assign var=json_paciente               value=$item->json_paciente|@json_decode}
            {assign var=json_direccion_mordedura    value=$item->json_direccion_mordedura|@json_decode}
            {assign var=json_expediente             value=$item->json_expediente|@json_decode}
            
            {assign var=direccion_paciente  value=''}
            {assign var=telefono_paciente   value=''}
            {assign var=email_paciente      value=''}
            
            {foreach $json_paciente->contacto_paciente as $contacto}
                {if $contacto->id_tipo_contacto == 3}
                    {assign var=direccion_paciente value=$contacto->gl_direccion|cat:", "|cat:$contacto->gl_comuna|cat:", "|cat:$contacto->gl_region}
                {/if}
                {if $contacto->id_tipo_contacto == 2}
                    {assign var=telefono_paciente value=$contacto->telefono_movil}
                {/if}
                {if $contacto->id_tipo_contacto == 4}
                    {assign var=email_paciente value=$contacto->gl_email}
                {/if}
            {/foreach}
            {if $item->arrVisitas}
                {foreach $item->arrVisitas as $visita}
                    {assign var=json_otros value=$visita->json_otros_mordedor|@json_decode}
                    {assign var=json_direccion_mordedor value=$visita->json_direccion_mordedor|@json_decode}
                    <tr>
                        <!--NOTIFICACION-->
                        <td> {$item->gl_folio} </td>
                        <td> {$item->fc_ingreso} {$item->gl_hora_ingreso}</td>
                        <td> {$item->fc_notificacion_seremi}</td>
                        <td> {$item->gl_establecimiento} </td>
                        <td>
                            {$item->gl_nombre_paciente} 
                            {if $item->gl_rut_paciente}
                                ({$item->gl_rut_paciente})
                            {else if $json_paciente->json_pasaporte->gl_pasaporte}
                                ({$json_paciente->json_pasaporte->gl_pasaporte})
                            {/if}
                        </td>
                        <td> {$direccion_paciente} </td>
                        <td> {$telefono_paciente} </td>
                        <td> {$email_paciente} </td>
                        <td> {$json_paciente->nr_edad} </td>
                        <td> {$item->gl_sexo_paciente} </td>

                        <td> {$item->fc_mordedura} </td>
                        <td> {$json_direccion_mordedura->gl_direccion}, {$item->comuna_mordedura}, {$item->region_mordedura} </td>
                        <td> {$json_expediente->gl_lugar_mordedura} </td>
                        <td> {$json_expediente->gl_inicia_vacuna} </td>
                        <td> {$json_expediente->gl_tipo_mordedura} </td>
                        <td> {$item->dias_mordedura} </td>
                        <td> {$item->dias_bandeja} </td>
                        <td> {$item->gl_nombre_estado}</td>
                        <td> {$item->gl_grupo_animal}</td>
                        <td> {$item->gl_especie_animal}</td>

                        <!--VISITA-->
                        <td> {$visita->gl_folio_mordedor} </td>
                        <td> {$visita->fc_visita} </td>
                        <td> {$visita->fc_sincronizacion} </td>
                        <td> {$visita->gl_visita_estado} </td>
                        <td> {$visita->gl_visita_resultado} </td>
                        <td> {if $visita->gl_tipo_perdida}{$visita->gl_tipo_perdida}{/if} </td>
                        <td> 
                            {if $visita->gl_visita_estado != "Perdida" && $visita->gl_nombre_fiscalizador_microchip != ""}
                                {$visita->gl_nombre_fiscalizador_microchip}
                            {else if $visita->gl_visita_estado != "Perdida" && $visita->gl_nombre_fiscalizador != ""}
                                {$visita->gl_nombre_fiscalizador}
                            {else if $visita->gl_visita_estado == "Perdida" && $visita->gl_nombre_fiscalizador_perdida != ""}
                                {$visita->gl_nombre_fiscalizador_perdida}
                            {/if}
                        </td>
                        <td> {$visita->gl_animal_estado} </td>
                        <td> {$visita->gl_animal_especie} </td>
                        <td> {$visita->gl_animal_raza} </td>
                        <td> {$visita->gl_animal_nombre} </td>
                        <td> {$json_otros->gl_color_animal} </td>
                        <td> {$visita->gl_animal_tamano} </td>
                        <td> {$visita->gl_animal_sexo} </td>
                        <td> {$json_otros->nr_edad} </td>
                        <td> {$json_otros->nr_edad_meses} </td>
                        <td> {$json_otros->nr_peso} </td>
                        <td> {$visita->gl_animal_estado_reproductivo} </td>
                        <td> {$json_direccion_mordedor->gl_direccion}{if $visita->gl_comuna_mordedor}, {$visita->gl_comuna_mordedor}{/if}{if $visita->gl_region_mordedor}, {$visita->gl_region_mordedor}{/if}</td>
                        <td> {if $visita->bo_rabia == 1}SI{else}NO{/if}</td>
                        <td> {if $visita->bo_mordedor_habitual == 1}SI{else}NO{/if}</td>
                        <td> {if $visita->bo_antirrabica_vigente == 1}SI{else}NO{/if}</td>
                        <td> {if $visita->bo_antirrabica_vigente == 0}SI{else}NO{/if}</td>
                        <td> {if $visita->gl_microchip}{$visita->gl_microchip}{else}-{/if}</td>
                    </tr>
                {/foreach}
            {else}
                <tr>
                    <!--NOTIFICACION-->
                    <td> {$item->gl_folio} </td>
                    <td> {$item->fc_ingreso} {$item->gl_hora_ingreso}</td>
                    <td> {$item->fc_notificacion_seremi}</td>
                    <td> {$item->gl_establecimiento} </td>
                    <td>
                        {$item->gl_nombre_paciente} 
                        {if $item->gl_rut_paciente}
                            ({$item->gl_rut_paciente})
                        {else if $json_paciente->json_pasaporte->gl_pasaporte}
                            ({$json_paciente->json_pasaporte->gl_pasaporte})
                        {/if}
                    </td>
                    <td> {$direccion_paciente} </td>
                    <td> {$telefono_paciente} </td>
                    <td> {$email_paciente} </td>
                    <td> {$json_paciente->nr_edad} </td>
                    <td> {$item->gl_sexo_paciente} </td>

                    <td> {$item->fc_mordedura} </td>
                    <td> {$json_direccion_mordedura->gl_direccion}, {$item->comuna_mordedura}, {$item->region_mordedura} </td>
                    <td> {$json_expediente->gl_lugar_mordedura} </td>
                    <td> {$json_expediente->gl_inicia_vacuna} </td>
                    <td> {$json_expediente->gl_tipo_mordedura} </td>
                    <td> {$item->dias_mordedura} </td>
                    <td> {$item->dias_bandeja} </td>
                    <td> {$item->gl_nombre_estado}</td>
                    <td> {$item->gl_grupo_animal}</td>
                    <td> {$item->gl_especie_animal}</td>

                    <!--VISITA-->
                    {"<td>-</td>"|str_repeat:24}
                </tr>
            {/if}
        {/foreach}
    </tbody>
</table>