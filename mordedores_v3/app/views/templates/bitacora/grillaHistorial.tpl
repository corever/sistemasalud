<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<div class="box-body">
    <div id="div_tabla" class="table-responsive small"> 
        <table id="tablaHistorial" class="table table-hover table-striped table-bordered  table-middle dataTable no-footer">
            <thead>
                <th align="center" width="10%">Fecha</th>
                <th align="center" width="20%">Evento</th>
                <th align="center" width="20%">Tipo Comentario</th>
                <th align="center" width="20%">Realizada por</th>
                <th align="center" width="">Comentario</th>
            </thead>
            <tbody>
            {foreach $arr->arrEventos as $his}
                <tr>
                    <td>{$his->fc_crea}</td>
                    <td>{$his->gl_nombre_evento}</td>
                    <td>
                        {if $his->id_tipo_comentario == 3 && $his->gl_otro_tipo_comentario != ""}
                            {$his->gl_nombre_tipo_comentario} ({$his->gl_otro_tipo_comentario})
                        {else}
                            {$his->gl_nombre_tipo_comentario}
                        {/if}
                    </td>
                    <td>{$his->gl_nombre_usuario}</td>
                    <td>{$his->gl_descripcion}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>            
    </div>
    
</div>