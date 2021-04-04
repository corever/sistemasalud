<table class="table table-hover table-striped table-bordered dataTable no-footer" id="tabla-perfiles-usuario">
	<thead>
		<tr>
            {if $bo_ver!=1}
                <th width="10%">Opciones</th>
            {/if}
            <th width="10%">Perfil</th>
            <th width="20%">Región</th>
            <th width="20%">Oficina</th>
            <th width="20%">Comuna</th>
            <th width="20%">Establecimiento Salud</th>
            <th width="20%">Servicio Salud</th>
            <th width="10%">Principal</th>
		</tr>
	</thead>
	<tbody>
	{if $perfiles_usuario}
		{foreach $perfiles_usuario as $perfil_us}
		<tr>
            {if $bo_ver!=1}
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger" title="ELIMINAR" 
                            onclick="Mantenedor_usuario.deleteRol(this,{$perfil_us->id_usuario_perfil});"><i class="fa fa-trash-o"></i></button>
                </td>
            {/if}
            <td class="text-center">{$perfil_us->gl_nombre_perfil}</td>
            <td class="text-center">{if $perfil_us->nombre_region}{$perfil_us->nombre_region}{else}-- Todas --{/if}</td>
            <td class="text-center">{if $perfil_us->nombre_oficina}{$perfil_us->nombre_oficina}{else}-- Todas --{/if}</td>
            <td class="text-center">{if $perfil_us->nombre_comuna}{$perfil_us->nombre_comuna}{else}-- Todas --{/if}</td>
            <td class="text-center">{if $perfil_us->nombre_establecimiento}{$perfil_us->nombre_establecimiento}{else}-- Todas --{/if}</td>
            <td class="text-center">{if $perfil_us->nombre_servicio}{$perfil_us->nombre_servicio}{else}-{/if}</td>
            <td class="text-center">
                {if $perfil_us->bo_principal==1}
                    <label><span class="label label-success">
                        <input type="radio" id="chk_principal_{$perfil_us->id_usuario_perfil}" onchange="Mantenedor_usuario.cambioChk(this);" 
                               value="{$perfil_us->id_usuario_perfil}" name="chk_principal" class="chk_principal" checked {if $bo_ver==1}disabled{/if}>
                        </span></label>
                {else}
                    <label><span class="label label-danger">
                        <input type="radio" id="chk_principal_{$perfil_us->id_usuario_perfil}" onchange="Mantenedor_usuario.cambioChk(this);" 
                               value="{$perfil_us->id_usuario_perfil}" name="chk_principal" class="chk_principal" {if $bo_ver==1}disabled{/if}>
                        </span></label>
                {/if}
            </td>
		</tr>
		{/foreach}
	{else}
        <tr><td colspan='4' >Ningún dato disponible en esta tabla</td></tr>
    {/if}
	</tbody>
</table>