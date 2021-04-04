<!--Seleccionado-->
<a class="nav-link dropdown-toggle" id="idiomaSeleccionado" data-idioma="<?php echo $arrIdiomaSeleccionado->id_idioma; ?>" data-toggle="dropdown" href="javascript:void(0)" aria-expanded="true">
<img  src="<?php echo \pan\uri\Uri::getHost().$arrIdiomaSeleccionado->gl_url; ?>" style="width: 18px;height: 20px;">
&nbsp;<?php echo $arrIdiomaSeleccionado->gl_nombre . " - " . $arrIdiomaSeleccionado->gl_siglas; ?>  <span class="caret"></span>
</a>
<!--Lista otros idiomas-->
<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left:-113px; transform: translate3d(-5px, 40px, 0px);">
    <?php foreach($arrIdioma as $itemIdioma): ?>
      <a class="dropdown-item <?php echo ($itemIdioma->id_idioma == $arrIdiomaSeleccionado->id_idioma)?"active":""; ?>" id="idioma_lista_<?php echo $itemIdioma->id_idioma; ?>" data-idioma="<?php echo $itemIdioma->id_idioma; ?>" tabindex="-1" href="javascript:Base.cambioIdioma(<?php echo $itemIdioma->id_idioma; ?>);">
        <img  src="<?php echo \pan\uri\Uri::getHost().$itemIdioma->gl_url; ?>" style="width: 18px;height: 20px;right: 172px;top: 19px;">
        &nbsp;<?php echo $itemIdioma->gl_nombre . " - " . $itemIdioma->gl_siglas; ?>
      </a>
    <?php endforeach; ?>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" tabindex="-1" href="javascript:void(0)"><i class="fa fa-cog"></i>&nbsp;<?php echo \Traduce::texto("Configuración de Idiomas"); ?></a>
</div>