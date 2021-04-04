<li class="nav-item dropdown">
    <a href="#" class="nav-link" data-toggle="dropdown">
        <i class="fa fa-user" alt="User Image"></i>
        <span class="hidden-xs"><?php echo $usuario; ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="#" class="dropdown-item">
            <p class="text-center"><i class="fa fa-user fa-3x img-circle"></i></p>
            <p class="text-center">
                <span href="<?php echo \pan\Uri\Uri::getBaseUri() ?>Farmacia/Mantenedor/Usuario/actualizar" class="h4">
                    <?php echo $usuario; ?> <br/> <?php echo $gl_nombre_perfil;?>
                </span>
            </p>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <div class="text-center">
              <?php if ($bo_cambio_usuario == 1 || $bo_cambio_usuario_real == 1): ?>
                <span onclick="Modal.open('<?php echo \pan\Uri\Uri::getBaseUri()?>Farmacia/Mantenedor/Usuario/cambiarUsuario', 'Cambiar de Usuario', '70');" class="btn btn-info btn-sm">
                    <i class="fa fa-exchange"></i> Cambiar de Usuario
                </span>
              <?php endif; ?>
            </div>
        </a>
    </div>
</li>
