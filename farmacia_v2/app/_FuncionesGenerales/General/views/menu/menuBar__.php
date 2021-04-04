<?php if ($opciones) :?>
<?php foreach ($opciones as $key => $opcion): ?>

  <?php if ($opcion->id_opcion_padre == 0 && !$opcion->bo_tiene_hijo): ?>
    <li class="nav-item has-treeview">
        <a href="<?php echo \pan\Uri\Uri::getBaseUri().$opcion->gl_url?>" class="nav-link">
            <i class="<?php echo $opcion->gl_icono ?>"></i>
            <p><?php echo $opcion->gl_nombre_opcion ?></p>
        </a>
    </li>
  <?php else: ?>
    <?php if ($opcion->id_opcion_padre == 0 && $opcion->bo_tiene_hijo): ?>
      <li class="nav-item has-treeview">
        <a href="" class="nav-link">
            <i class="<?php echo $opcion->gl_icono ?>"></i>
            <p><?php echo $opcion->gl_nombre_opcion ?><i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
            <?php if ($subOpciones) :?>
              <?php foreach ($subOpciones as $key => $subOpcion): ?>
                <?php if ($opcion->id_opcion == $subOpcion->id_opcion_padre): ?>
                  <li class="nav-item">
                    <a href="<?php echo \pan\Uri\Uri::getBaseUri().$subOpcion->gl_url?>" class="nav-link">
                        <i class="<?php echo $subOpcion->gl_icono ?>"></i>
                        <p><?php echo $subOpcion->gl_nombre_opcion ?></p>
                    </a>
                  </li>
                <?php endif; ?>
              <?php endforeach; ?>
          <?php endif;?>
        </ul>
      </li>
    <?php endif; ?>
  <?php endif; ?>

<?php endforeach; ?>
<?php endif?>

<?php if ($_SESSION[\Constantes::SESSION_BASE]['id_usuario_original'] != 0): ?>
    <li class="nav-item has-treeview">
        <a href="#" id="btnVolverUsuario" class="nav-link">
            <i class="fas fa-undo"></i>
            <p>Volver a mi Usuario</p>
        </a>
    </li>
<?php endif; ?>
    
<li class="nav-item has-treeview">  
    <a href="<?php echo \pan\Uri\Uri::getBaseUri() . "Farmacia/Usuario/Login/logoutUsuario" ?>" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Salir</p>
    </a>
</li>

