<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<div class="box-body">
    <div id="div_tabla" class="table-responsive small"> 
        <table id="tablaEstablecimientosNotifican" class="table table-hover table-striped table-bordered dataTable table-middle no-footer">
            <thead>
                <tr role="row">
                    <th align="center" width="10%">Establecimiento</th>
                    <th align="center" width="10%">Región Establecimiento</th>
                    <th align="center" width="10%">Comuna Establecimiento</th>
                    <th align="center" width="10%">Nombre Usuario</th>
                    <th align="center" width="10%">Cantidad Notificaciones</th>
                </tr>
            </thead>
            <tbody>
                
            {if $arrEstablecimientosNotifican}                
                {foreach $arrEstablecimientosNotifican as $key => $est}
                    <tr>
                        <td align="center">{$est->gl_nombre_establecimiento}</td>
                        <td align="center">{$est->gl_nombre_region}</td>
                        <td align="center">{$est->gl_nombre_comuna}</td>
                        <td align="center">{$est->gl_nombres} {$est->gl_apelidos}</td>
                        <td align="center">{$est->cantidad_expediente}</td>
                    </tr>
                {/foreach}
            {/if}
            </tbody>
        </table>
    </div>
</div>