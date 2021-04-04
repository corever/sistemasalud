<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<div class="box-body">
    <div id="div_tabla" class="table-responsive small col-lg-12">
        <table id="tablaAdjunto" class="table table-hover table-striped table-bordered  table-middle dataTable no-footer">
            <thead>

                <th align="center" width="10%">Fecha</th>
                <th align="center" width="10%">Tipo</th>
                <th align="center" width="20%">Documento</th>
                <th align="center" width="30%">Comentario</th>
                <th align="center" width="20%">Funcionario</th>
                <th align="center" width="10%">Opciones</th>
            </thead>
            <tbody>
            {foreach $arr->arrAdjuntos as $adj}
                <tr>
                    {if $adj->bo_estado == 1}
                    <td>{$adj->fc_crea}</td>
                    <td>{$adj->gl_tipo}</td>
                    <td>{$adj->gl_nombre}</td>
                    <td>{$adj->gl_glosa}</td>
                    <td>{$adj->nombre_usuario}</td>
                    <td align="center">
                        <a class="btn btn-sm btn-primary" id="btnDescarga"
                           onclick="window.open('{$smarty.const.BASE_URI}/Adjunto/verByToken/?token={$adj->gl_token}')">
                            <i class="fa fa-download"></i>
                        </a>
                        {if $id_perfil == 1}
                        <a class="btn btn-sm btn-warning" id="btnModificar"
                           onclick="xModal.open('{$smarty.const.BASE_URI}/Adjunto/modificarAdjunto/?token={$adj->gl_token}', 'Modificar Adjunto', null, 'modificar_adjunto');">
                            <i class="fa fa-edit"></i>
                        </a>
                        {/if}
                    </td>
                    {/if}
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>