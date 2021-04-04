<section class="content-header">
    <h1><i class="fa fa-file-pdf-o"></i> <span>{$origen}</span></h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <h3> Lista de {if $perfil == 3}Descargas{else}Manuales{/if}</h3>
            <div class="col-sm-3">&nbsp;</div>
            <div class="col-sm-6">
                <table id="grilla_tickets" class="table table-bordered no-footer">
                    <thead>
                        <tr role="row">
                            <th class="col-md-1" align="center">Descargar</th>
                            <th class="col-md-8" align="center">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        {if $arrDocumento}
                            {foreach $arrDocumento as $item}
                                <tr>
                                    <td align="center">
                                        <button class="btn btn-xs btn-success" onclick="window.open('{$smarty.const.BASE_URI}{$base_url}/Manual/descargarDocumento/{$item->gl_token}')">
                                                <i class="fa fa-download"></i>
                                        </button>
                                    </td>
                                    <td align="center">{$item->gl_nombre_documento}</td>
                                </tr>
                            {/foreach}
                        {else}
                        <td colspan="2" align="center">Sin Datos</th>
                        {/if}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
