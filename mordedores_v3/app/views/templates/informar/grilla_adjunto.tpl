<table class="table table-hover table-responsive table-striped table-bordered dataTable no-footer" id="tabla-razones">
    <thead>
        <tr role="row">
            <th width="70%">Nombre</th>
            <th width="30%">Opciones</th>
        </tr>
    </thead>
    <tbody>
        {if $arrAdjunto}
            <tr>
                <td align="center">
                    {$arrAdjunto.gl_descripcion}
                </td>
                <td align="center">
                    <button type="button" id="ver_documento" name="ver_documento" title="Ver" class="btn btn-sm btn-info"
                            onclick="window.open('{$smarty.const.BASE_URI}/Informar/verAdjunto/{$arrAdjunto.id_adjunto_tipo}/{$cont_mordedor}', '_blank');"><i class="fa fa-info-circle"></i></button>
                    {*<button type="button" id="elimina_documento" name="elimina_documento" title="Eliminar" class="btn btn-sm btn-danger"
                            onclick="Adjunto.borrarAdjunto({$cont_mordedor},{$arrAdjunto.id_adjunto_tipo});"><i class="fa fa-trash"></i></button>*}
                </td>
            </tr>
        {else}
            <tr><td colspan='3'>Ningún dato disponible en esta tabla</td></tr>
        {/if}
    </tbody>
</table>