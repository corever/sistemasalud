<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<div class="box-body">
    <div id="div_tabla" class="table-responsive small"> 
        <table id="tablaVisitasRegion" data-row="25" class="table table-hover table-striped table-bordered  table-middle dataTable no-footer">
            <thead>
                <tr role="row">
                    <th align="center" width="10%">Orden Territorio</th>
                    <th align="center" width="10%">Nombre Región</th>
                    <th align="center" width="10%">Con Domicilio</th>
                    <th align="center" width="10%">Sin Domicilio</th>
                    <th align="center" width="10%">Total Visitas</th>
                    {*<th align="center" width="15%">Realizadas</th>*}
                    <th align="center" width="10%">Perdidas</th>
                    <th align="center" width="10%">Sospechosos</th>
                    <th align="center" width="15%">No Sospechosos</th>
                </tr>
            </thead>
            <tbody>
            {if $arr_visitas_region}
                {foreach $arr_visitas_region as $region => $visita}
                    <tr>
                        <td align="center">{$visita["numero_region"]}</td>
                        <td align="center">{$visita["region"]}</td>
                        <td align="center">{$visita["conocido"]}</td>
                        <td align="center">{$visita["no_conocido"]}</td>
                        <td align="center">{$visita["cant_total"]}</td>
                        {*<td align="center">{$visita["realizadas"]}</td>*}
                        <td align="center">{$visita["Visita Perdida"]}</td>
                        <td align="center">{$visita["Sospechoso"]}</td>
                        <td align="center">{$visita["No Sospechoso"]}</td>
                    </tr>
                {/foreach}
            {/if}
            </tbody>
        </table>
    </div>
</div>