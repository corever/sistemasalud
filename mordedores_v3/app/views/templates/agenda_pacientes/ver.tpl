<table class="table table-hover table-striped table-bordered dataTable no-footer" width="100%" border="1">
    <thead>
        <tr>
            <th align="center"><b>FOLIO</b></th>
            <th align="center"><b>ESTABLECIMIENTO SALUD</b></th>
            <th align="center"><b>N° VACUNA</b></th>
            <th align="center"><b>PACIENTE</b></th>
            <th align="center"><b>FECHA</b></th>
            <th align="center"><b>ESTADO</b></th>
            <th align="center"><b>OPCIONES</b></th>
        </tr>
    </thead>
    <tbody>
        {if $arr}
            {assign var=item value=$arr}
            <tr>
                <td align="center">{$item.gl_folio}</td>
                <td align="center">{$item.gl_establecimiento}</td>
                <td align="center">{$item.nr_vacuna}</td>
                <td align="center">{$item.gl_nombre_paciente}</td>
                <td align="center">{$item.fc_vacuna}</td>
                <td align="center">
                    {if $item.id_estado == 2}
                        <span class="label label-success">{$item.gl_vacuna}</span>
                    {else}
                        <span class="label label-primary">{$item.gl_vacuna}</span>
                    {/if}
                </td>
                <td align="center">
                    {if $item.id_estado != 2}
                        <button type="button" data-toggle="tooltip" class="btn btn-xs btn-success" data-title="Aplicar Vacuna"
                                onclick="xModal.open('{$smarty.const.BASE_URI}/AgendaPacientes/aplicarVacuna/?id_agenda={$item.id_agenda}','Aplicar Vacuna',60);">
                            <i class="fa fa-eyedropper"></i>
                        </button>
                    {/if}
                    <button type="button" data-toggle="tooltip" class="btn btn-xs btn-warning" data-title="Derivar"
                            onclick="xModal.open('{$smarty.const.BASE_URI}/AgendaPacientes/derivar/?id_agenda={$item.id_agenda}','Derivar',60);">
                        <i class="fa fa-share-square-o"></i>
                    </button>
                    <button type="button" data-toggle="tooltip" class="btn btn-xs btn-info" data-title="Bitácora"
                            onclick="xModal.open('{$smarty.const.BASE_URI}/AgendaPacientes/bitacora/?id_agenda={$item.id_agenda}','Bitácora Agenda',60);">
                        <i class="fa fa-eye"></i>
                    </button>
                </td>
            </tr>
        {else}
            <tr>
                <td colspan="5" align="center">Sin Información</td>
            </tr>
        {/if}
    </tbody>
</table>