<!-- NAVEGACIÓN MENU SUPERIOR -->
<?php foreach ($sideBar as $key => $val): 
  
  $menu_open   = isset($val['subMenu']) && $val['bo_active'] ? "menu-open": "";
  $active      = $val['bo_active'] ? "active" : "";
  $uri         = \pan\Uri\Uri::getBaseUri().$val['gl_url'];

  ?>
  <li class="nav-item dropdown">
  <a id="dropdownSubMenu_<?php echo $menu->id_opcion; ?>" href="<?php echo $uri?>" data-toggle="dropdown" aria-haspopup="true"
    aria-expanded="true" class="nav-link dropdown-toggle <?php echo $active?>"><?php echo \Traduce::texto($val['gl_nombre_opcion']); ?></a>
    <?php if (isset($val['subMenu'])): ?>
      <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
        <?php foreach ($val['subMenu'] as $keySM => $valSM): 
          $activeSM = $valSM['bo_active'] ? "active": "";
          $uriSM    = \pan\Uri\Uri::getBaseUri().$valSM['gl_url'];
          ?>
          <li><a href="<?php echo $uriSM?>" class="dropdown-item <?php echo $activeSM?>"><i class="nav-icon <?php echo $valSM['gl_icono'] ?>"></i>&nbsp;<?php echo \Traduce::texto($valSM['gl_nombre_opcion']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </li>
<?php endforeach; ?>
<!-- FIN NAVEGACIÓN MENU SUPERIOR-->