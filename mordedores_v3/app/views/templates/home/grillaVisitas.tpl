<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<div class="box-body">
    <div id="div_tabla" class="table-responsive small"> 
        <table id="tablaVisitas" data-row="25" class="table table-hover table-striped table-bordered  table-middle dataTable no-footer">
            <thead>
                <tr role="row">
                    <th align="center" width="10%">Comuna</th>
                    <th align="center" width="10%">Con Domicilio</th>
                    <th align="center" width="10%">Sin Domicilio</th>
                    <th align="center" width="10%">Total Visitas</th>
                    {*<th align="center" width="15%">Realizadas</th>*}
                    <th align="center" width="10%">Perdidas</th>
                    <th align="center" width="10%">Sospechoso</th>
                    <th align="center" width="15%">No Sospechoso</th>
                    <th align="center" width="10%">Positivo</th>
                    <th align="center" width="10%">Negativo</th>
                </tr>
            </thead>
            <tbody>
            {if $arr_visitas_comuna}
                {foreach $arr_visitas_comuna as $comuna => $visita}
                    <tr>
                        <td align="center">{($visita["comuna"])?$visita["comuna"]:'Sin información'}</td>
                        <td align="center">{$visita["conocido"]}</td>
                        <td align="center">{$visita["no_conocido"]}</td>
                        {*<td align="center">{$visita["cant_total"]}</td>*}
                        <td align="center">{$visita["Visita Perdida"]+$visita["Sospechoso"]+$visita["No Sospechoso"]}</td>
                        <td align="center">{$visita["Visita Perdida"]}</td>
                        <td align="center">{$visita["Sospechoso"]}</td>
                        <td align="center">{$visita["No Sospechoso"]}</td>
                        <td align="center">{$visita["Positivo"]}</td>
                        <td align="center">{$visita["Negativo"]}</td>
                    </tr>
                {/foreach}
            {/if}
            </tbody>
        </table>
    </div>
</div>