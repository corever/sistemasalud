<table class="table table-hover table-responsive table-striped table-bordered dataTable no-footer" id="tabla-animal-mordedor">
    <thead>
        <tr role="row">
            <th width="10%">Es Dueño</th>
            <th width="10%">Especie</th>
            <th width="10%">Color</th>
            <th width="40%">Dirección</th>
            <th width="10%">Opciones</th>
        </tr>
    </thead>
    <tbody>
        {if $arrAnimalMordedor}
            {foreach $arrAnimalMordedor as $key=>$item}
                <tr>
                    <td align="center">
                        {if $item.bo_paciente_dueno == 1}
                            Si
                        {else}
                            No
                        {/if}
                    </td>
                    <td align="center">{$item.gl_especie_animal}</td>
                    <td align="center">{$item.gl_color_animal}</td>
                    <td align="center">
                        {if $item.gl_direccion && $item.gl_comuna && $item.gl_region}
                            {$item.gl_direccion}, {$item.gl_comuna}, {$item.gl_region}
                        {else}
                            <label class="label label-info">Sin Dirección</label>
                        {/if}
                    </td>
                    <td align="center">
                        <button type="button" id="ver_animal" name="ver_animal" data-title="Ver Detalle" class="btn btn-sm btn-info"
                                onclick="xModal.open('{$smarty.const.BASE_URI}/Paciente/verAnimal/?id_animal={$key}', 'Ver Animal Mordedor', 80);"><i class="fa fa-info-circle"></i></button>
                        <button type="button" id="elimina_animal" name="elimina_animal" data-title="Eliminar Mordedor" class="btn btn-sm btn-danger"
                                onclick="Animal.eliminarAnimalGrilla({$key});"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            {/foreach}
        {else}
            <tr><td colspan='4'>Ningún dato disponible en esta tabla</td></tr>
        {/if}
    </tbody>
</table>