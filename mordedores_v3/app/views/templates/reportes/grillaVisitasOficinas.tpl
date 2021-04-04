<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<div class="box-body">
    <div id="div_tabla" class="table-responsive small"> 
        <table id="tablaVisitasOficinas" class="table table-hover table-striped table-bordered dataTable table-middle no-footer">
            <thead>
                <tr role="row">
                    {if $bandeja == "establecimiento" || $bandeja == "admin" || $bandeja == "nacional"}
                    <th align="center" width="10%">Región</th>
                    {/if}
                    <th align="center" width="10%">Oficina</th>
                    <th align="center" width="10%">Con Domicilio (Oficina)</th>
                    <th align="center" width="10%">Sin Domicilio (Oficina)</th>
                    <th align="center" width="10%">Total (Oficina)</th>
                    {*<th align="center" width="10%">Comuna</th>
                    <th align="center" width="10%">Con Domicilio (Comuna)</th>
                    <th align="center" width="10%">Sin Domicilio (Comuna)</th>*}
                </tr>
            </thead>
            <tbody>
                
            {if $arr_visitas_oficinas}
                
                {foreach $arr_visitas_oficinas as $region => $arrOficina}
                    {assign var=row_region value=0}
                    
                        {if $bandeja == "establecimiento" || $bandeja == "admin" || $bandeja == "nacional"}                            
                            {foreach $arrOficina as $oficina => $arrComuna2}
                                {assign var=row_region value=$row_region+count($arrComuna2)}
                            {/foreach}
                            
                        {/if}
                        
                        {foreach $arrOficina as $oficina => $arrComuna}
                            
                            {assign var=conocido_oficina value=0}
                            {assign var=no_conocido_oficina value=0}
                            
                            {foreach $arrComuna as $comuna2 => $item2}
                                {assign var=conocido_oficina value=$conocido_oficina+$item2["conocido"]}
                                {assign var=no_conocido_oficina value=$no_conocido_oficina+$item2["no_conocido"]}
                            {/foreach}
                            
                            {*foreach $arrComuna as $comuna => $item*}
                                <tr>
                                    {if $bandeja == "establecimiento" || $bandeja == "admin" || $bandeja == "nacional"}
                                        <td align="center">{$region}</td>
                                    {/if}
                                    <td align="center">{($oficina)?$oficina:'Sin Infromación'}</td>
                                    <td align="center">{$conocido_oficina}</td>
                                    <td align="center">{$no_conocido_oficina}</td>
                                    <td align="center">{$conocido_oficina+$no_conocido_oficina}</td>
                                    {*<td align="center">{($comuna)?$comuna:'Sin Infromación'}</td>
                                    <td align="center">{$item["conocido"]}</td>
                                    <td align="center">{$item["no_conocido"]}</td>*}
                                </tr>
                            {*/foreach*}
                        {/foreach}
                    
                {/foreach}
                
                
                {*assign var=contador value=0}
                {foreach $arr_visitas_oficinas as $region => $arrOficina}
                    {assign var=row_region value=0}
                    {assign var=contador value=$contador+1}
                    {if $contador == 1}
                        <tr>
                    {/if}
                        {if $bandeja == "establecimiento" || $bandeja == "admin" || $bandeja == "nacional"}                            
                            {foreach $arrOficina as $oficina => $arrComuna2}
                                {assign var=row_region value=$row_region+count($arrComuna2)}
                            {/foreach}
                            <td align="center" rowspan="{$row_region}">{$region}</td>
                        {/if}
                        
                        {assign var=contador2 value=0}
                        {foreach $arrOficina as $oficina => $arrComuna}
                            {assign var=contador2 value=$contador2+1}
                            
                            {assign var=conocido_oficina value=0}
                            {assign var=no_conocido_oficina value=0}
                            
                            {foreach $arrComuna as $comuna2 => $item2}
                                {assign var=conocido_oficina value=$conocido_oficina+$item2["conocido"]}
                                {assign var=no_conocido_oficina value=$no_conocido_oficina+$item2["no_conocido"]}
                            {/foreach}
                            
                            {if $contador > 0 && $contador2 > 1}
                                <tr>
                                    <td align="center" style="display: none;">{$region}</td>
                            {/if}
                            
                            <td align="center" rowspan="{count($arrComuna)}">{$oficina}</td>
                            <td align="center" rowspan="{count($arrComuna)}">{$conocido_oficina}</td>
                            <td align="center" rowspan="{count($arrComuna)}">{$no_conocido_oficina}</td>
                            <td align="center" rowspan="{count($arrComuna)}">{$conocido_oficina+$no_conocido_oficina}</td>
                            
                            {assign var=contador3 value=0}
                            {foreach $arrComuna as $comuna => $item}
                                {assign var=contador3 value=$contador3+1}
                                {if $contador > 0 && $contador3 > 1}
                                    <tr>
                                        <td align="center" style="display: none;">{$region}</td>
                                        <td align="center" style="display: none;">{$oficina}</td>
                                        <td align="center" style="display: none;">{$conocido_oficina}</td>
                                        <td align="center" style="display: none;">{$no_conocido_oficina}</td>
                                        <td align="center" style="display: none;">{$conocido_oficina+$no_conocido_oficina}</td>
                                {/if}
                                
                                    <td align="center">{$comuna}</td>
                                    <td align="center">{$item["conocido"]}</td>
                                    <td align="center">{$item["no_conocido"]}</td>
                                </tr>
                            {/foreach}
                        {/foreach}
                    
                {/foreach*}
            {/if}
            </tbody>
        </table>
    </div>
</div>