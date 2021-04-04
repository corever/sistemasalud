<li class="dropdown user user-menu active">
    <!-- Menu Toggle Button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <!-- The user image in the navbar-->
        <i class="fa fa-user" alt="User Image"></i>
        <!-- hidden-xs hides the username on small devices so only the image appears. -->
        <span class="hidden-xs">{$usuario} <br> {$gl_nombre_perfil}</span>
    </a>
    <ul class="dropdown-menu">
        <!-- The user image in the menu -->
        <li class="user-header">
			<i class="fa fa-user fa-3x img-circle"></i>
            <p>
                <a href="{$smarty.const.BASE_URI}/Login/actualizar" class="h4">
                    {$usuario} <br/> {$gl_nombre_perfil}
                </a>
            </p>
        </li>

        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-center">
				{if $bo_cambio_usuario == 1 || $bo_cambio_usuario_real == 1}
					<a onclick="xModal.open('{$smarty.const.BASE_URI}/Mantenedor/cambiarUsuario/','Cambiar de Usuario','70');" class="btn btn-info btn-sm">
						<i class="fa fa-exchange"></i> Cambiar de Usuario
					</a>
				{/if}
				{if $count > 1}
					<a onclick="xModal.open('{$smarty.const.BASE_URI}/Mantenedor/cambiarPerfil/','Cambiar de Perfil','70');" class="btn btn-primary btn-sm">
						<i class="fa fa-user"></i> Cambiar de Perfil
					</a>
				{/if}
                <!-- a href="{$smarty.const.BASE_URI}/Login/logoutUsuario" class="btn btn-danger btn-sm">
					<i class="fa fa-sign-out"></i> Cerrar Sesión
				</a -->
            </div>
        </li>
    </ul>
</li>