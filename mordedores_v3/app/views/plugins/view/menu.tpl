{if $smarty.session.id_usuario_original != 0}
	<li>
		<a href="#" id="btnVolverUsuario"><i class="fa fa-undo fa-2x"></i> <span>Volver a mi Usuario</span></a>
	</li>
{/if}
{foreach $opciones as $opcion}  
  
	{if $opcion->id_opcion_padre == 0 AND !$opcion->bo_tiene_hijo}
	<li>
		<a href="{$base_url}{$opcion->gl_url}">
            <i class="{$opcion->gl_icono}"></i>
            <span>{if $opcion->id_opcion == 7000 && $id_perfil == 3}Descargas{else}{$opcion->gl_nombre_opcion}{/if}</span>
        </a>
	</li>
	{else}
		{if $opcion->id_opcion_padre == 0 AND $opcion->bo_tiene_hijo}
			<li>
				<a href="">
				<i class="{$opcion->gl_icono}"></i> <span>{$opcion->gl_nombre_opcion}</span></a>
				<ul class="treeview-menu">
					{foreach $subOpciones as $subOpcion}  
						{if $opcion->id_opcion == $subOpcion->id_opcion_padre}
							<li>
								<a href="{$base_url}{$subOpcion->gl_url}"><i class="{$subOpcion->gl_icono}"></i> <span>{$subOpcion->gl_nombre_opcion}</span></a>
							</li>
						{/if}
					{/foreach}
				</ul>
			</li>
		{/if}
	{/if}
	
{/foreach}