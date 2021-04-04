<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<div class="box-body">
    <div id="div_tabla" class="table-responsive small"> 
        <table id="tablaEstablecimientos" class="table table-hover table-striped table-bordered dataTable table-middle no-footer">
            <thead>
                <tr role="row">
                    <th align="center" width="10%">Establecimiento</th>
                    <th align="center" width="10%">Total Notificaciones</th>
                    <th align="center" width="10%">Con Domicilio Conocido</th>
                    <th align="center" width="10%">Sin Domicilio Conocido</th>
                    <th align="center" width="10%">Notificación Web</th>
                    <th align="center" width="10%">Notificación Manual</th>
                </tr>
            </thead>
            <tbody>
                {if $arrEstablecimientos}                
                    {foreach $arrEstablecimientos as $key => $est}
                        <tr>
                            <td align="center">{$est->gl_nombre_establecimiento}</td>
                            <td align="center">{$est->cant_total}</td>
                            <td align="center">{$est->con_domicilio}</td>
                            <td align="center">{$est->sin_domicilio}</td>
                            <td align="center">{$est->informada_web}</td>
                            <td align="center">{$est->informada_manual}</td>
                        </tr>
                    {/foreach}
                {/if}
            </tbody>
        </table>
    </div>
</div>