<!-- NAVEGACIÓN PRINCIPAL -->
<?php foreach ($sideBar as $key => $val):
  
  $menu_open    = isset($val['subMenu']) && $val['bo_active'] ? "menu-open": "";
  $active       = $val['bo_active'] ? "active" : "";
  $boAgregar    = intval($val['bo_agregar']);
  $boModificar  = intval($val['bo_modificar']);
  $boEliminar   = intval($val['bo_eliminar']);
  $angleLeft    = isset($val['subMenu']) ? '&nbsp;<i class="right fas fa-angle-left"></i>' : '';
  $uri          = \pan\Uri\Uri::getBaseUri().$val['gl_url'];

  ?>
  <li class="nav-item has-treeview <?php echo $menu_open;?>">
    <a href="<?php echo $uri?>" class="nav-link <?php echo $active?>"
    data-agregar="<?php echo $boAgregar; ?>" data-modificar="<?php echo $boModificar; ?>" data-eliminar="<?php echo $boEliminar; ?>">
      <i class="nav-icon <?php echo $val['gl_icono_padre'] ?>"></i>
      <p>
        <?php echo \Traduce::texto($val['gl_nombre_opcion']).$angleLeft; ?>
      </p>
    </a>
    <?php if (isset($val['subMenu'])): ?>
      <ul class="nav nav-treeview">
        <?php foreach ($val['subMenu'] as $keySM => $valSM):
          $activeSM       = $valSM['bo_active'] ? "active": "";
          $boAgregarSM    = intval($valSM['bo_agregar']);
          $boModificarSM  = intval($valSM['bo_modificar']);
          $boEliminarSM   = intval($valSM['bo_eliminar']);
          $uriSM          = \pan\Uri\Uri::getBaseUri().$valSM['gl_url'];
          ?>
          <li class="nav-item">
            <a href="<?php echo $uriSM?>" class="nav-link <?php echo $activeSM?>"
              data-agregar="<?php echo $boAgregarSM; ?>" data-modificar="<?php echo $boModificarSM; ?>" data-eliminar="<?php echo $boEliminarSM; ?>">
              <i class="nav-icon <?php echo $valSM['gl_icono'] ?>"></i>
              <p><?php echo \Traduce::texto($valSM['gl_nombre_opcion']); ?></p>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </li>
<?php endforeach; ?>

<?php if ($_SESSION[\Constantes::SESSION_BASE]['id_usuario_original'] != 0): ?>
    <li class="nav-item has-treeview">
      <a href="#" id="btnVolverUsuario" class="nav-link">
        <i class="nav-icon fas fa-undo"></i>
        <p>Volver a mi Usuario</p>
      </a>
    </li>
<?php endif; ?>
    
<!--li class="nav-item has-treeview">  
  <a href="#" class="nav-link" onclick="Base.entrarModulo(this);" data-url="Farmacia/Home/MisSistemas/" data-id_modulo="0">
    <i class="nav-icon fas fa-sign-out-alt"></i>
    <p>Salir de Módulo</p>
  </a>
</li-->
<!-- FIN NAVEGACIÓN PRINCIPAL-->