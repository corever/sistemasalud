<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla-establecimiento">
    <thead>
        <tr>
            <th width="30%">Nombre</th>
            <th width="40%">Descripción</th>
            <th width="20%">Estado</th>
            <th width="5%">Opciones</th>
        </tr>
    </thead>
    <tbody>
        {*foreach from=$arr_data item=itm}
            <tr>
                <td class="text-center">{$itm->gl_nombre_establecimiento}</td>
                <td class="text-center">{$itm->gl_direccion_establecimiento}</td>
                <td class="text-center">
                    {if $itm->bo_estado == "1"}
                        <div style="color:green;"> Activo </div>
                    {else}
                        <div style="color:red;"> Inactivo </div>
                    {/if}
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-xs btn-success" data-title="Editar" data-toggle="tooltip"
                            onclick="xModal.open('{$smarty.const.BASE_URI}/Mantenedor/editarEstablecimiento/?token={$itm->gl_token}', 'Editar Establecimiento', '45');">
                        <i class="fa fa-edit"></i></button>
                </td>
            </tr>
        {/foreach*}
    </tbody>
</table>