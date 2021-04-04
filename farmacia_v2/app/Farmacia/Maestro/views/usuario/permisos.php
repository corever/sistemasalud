<div class="hv-item-children">
    <div class="hv-item-child">
        <div class="person">
            <i class="fa fa-list fa-3x" style="color:white"></i>
            <p class="name" style="margin-top:6px"><strong>Agregar</strong></p>
            <div class="checkbox checkbox-success">
                <input class="styled" data-orden="1" value="1"
                    <?php if (in_array("1",$permisosUsuario[$id_opcion_permiso])): ?> checked <?php endif; ?>
                    id="checkboxPermiso1-<?php echo $id_opcion_permiso; ?>" type="checkbox"><label for="checkboxPermiso1-<?php echo $id_opcion_permiso; ?>"></label>
            </div>
        </div>
    </div>
    <div class="hv-item-child">
        <div class="person">
            <i class="fa fa-list fa-3x" style="color:white"></i>
            <p class="name" style="margin-top:6px"><strong>Modificar</strong></p>
            <div class="checkbox checkbox-success">
                <input class="styled" data-orden="2" value="2"
                    <?php if (in_array("2",$permisosUsuario[$id_opcion_permiso])): ?> checked <?php endif; ?>
                    id="checkboxPermiso2-<?php echo $id_opcion_permiso; ?>" type="checkbox"><label for="checkboxPermiso2-<?php echo $id_opcion_permiso; ?>"></label>
            </div>
        </div>
    </div>
    <div class="hv-item-child">
        <div class="person">
            <i class="fa fa-list fa-3x" style="color:white"></i>
            <p class="name" style="margin-top:6px"><strong>Eliminar</strong></p>
            <div class="checkbox checkbox-success">
                <input class="styled" data-orden="3" value="3"
                    <?php if (in_array("3",$permisosUsuario[$id_opcion_permiso])): ?> checked <?php endif; ?>
                    id="checkboxPermiso3-<?php echo $id_opcion_permiso; ?>" type="checkbox"><label for="checkboxPermiso3-<?php echo $id_opcion_permiso; ?>"></label>
            </div>
        </div>
    </div>
</div>