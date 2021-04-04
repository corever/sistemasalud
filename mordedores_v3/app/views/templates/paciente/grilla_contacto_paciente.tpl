<table class="table table-hover table-responsive table-striped table-bordered dataTable no-footer" id="tabla-razones">
	<thead>
		<tr role="row">
            <th width="20%">Tipo</th>
			<th width="70%">Datos</th>
			<th width="10%">Opciones</th>
		</tr>
	</thead>
	<tbody>
	{if $arrContactoPaciente}
		{foreach $arrContactoPaciente as $key=>$item}
		<tr>
            <td align="center">{$item.gl_tipo_contacto}</td>
            <td align="center">
                {if $item.id_tipo_contacto == 1}
                    {$item.telefono_fijo}
                {else if $item.id_tipo_contacto == 2}
                    {$item.telefono_movil}
                {else if $item.id_tipo_contacto == 3}
                    {if $item.chkNoInforma == 1}
                        No Tiene
                    {else}
                        {$item.gl_direccion}, {$item.gl_comuna}, {$item.gl_region}
                    {/if}
                {else if $item.id_tipo_contacto == 4}
                    {$item.gl_email}
                {else if $item.id_tipo_contacto == 5}
                    {$item.gl_casilla_postal}
                {/if}
            </td>
            <td align="center">
                <button type="button" id="ver_contacto" name="ver_contacto" title="Ver" class="btn btn-sm btn-info"
                        onclick="xModal.open('{$smarty.const.BASE_URI}/Paciente/verContactoPaciente/?id_contacto={$key}', 'Ver', 70);"><i class="fa fa-info-circle"></i></button>
                <button type="button" id="editar_contacto" name="editar_contacto" title="Editar" class="btn btn-sm btn-success"
                        onclick="xModal.open('{$smarty.const.BASE_URI}/Paciente/verContactoPaciente/?id_contacto={$key}&bo_editar=1', 'Editar', 70);"><i class="fa fa-edit"></i></button>
                <button type="button" id="elimina_contacto" name="elimina_contacto" title="Eliminar" class="btn btn-sm btn-danger"
                        onclick="ContactoPaciente.eliminarContactoGrilla({$key});"><i class="fa fa-trash"></i></button>
            </td>
		</tr>
		{/foreach}
	{else}
        <tr><td colspan='3'>Ningún dato disponible en esta tabla</td></tr>
    {/if}
	</tbody>
</table>