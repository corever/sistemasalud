<table class="table table-hover table-responsive table-striped table-bordered no-footer" id="tabla-informe">
    <thead>
        <tr role="row">
            <th width="20%">Región</th>
            <th width="20%">Chipeados</th>
            <th width="20%">Domicilio Conocido</th>
            <th width="20%">Notificados</th>
            <th width="20%">Porcentaje de animales<br>Observables Identificados{*Chipeados Con Domicilio Conocido*}</th>
            {*<th width="20%">Chipeados Sin Domicilio Conocido</th>*}
            <th width="20%">Porcentaje de animales<br>Notificados Identificados{*Chipeados Notificados*}</th>
        </tr>
    </thead>
    <tbody>
    {if $arrInforme}
        {foreach $arrInforme as $item}
            <tr>
                <td align="center">{$item->gl_region}</td>
                <td align="center">{$item->nr_chipeados}</td>
                <td align="center">{$item->nr_domicilio_conocido}</td>
                <td align="center">{$item->total_mordedores}</td>
                <td align="center">
                    {if $item->nr_domicilio_conocido == 0}0{else}{math equation="(b/c)*a" a=100 b=$item->nr_chipeados c=$item->nr_domicilio_conocido format="%.2f"}{/if}%
                </td>
                {*
                <td align="center">
                    {if $item->nr_domicilio_desconocido == 0}0{else}{math equation="(b/c)*a" a=100 b=$item->nr_chipeados c=$item->nr_domicilio_desconocido format="%.2f"}{/if}%
                </td>
                *}
                <td align="center">
                    {if $item->total_mordedores == 0}0{else}{math equation="(b/c)*a" a=100 b=$item->nr_chipeados c=$item->total_mordedores format="%.2f"}{/if}%
                </td>
            </tr>
        {/foreach}
    {else}
        <tr><td colspan='3'>Ningún dato disponible en esta tabla</td></tr>
    {/if}
    </tbody>
</table>