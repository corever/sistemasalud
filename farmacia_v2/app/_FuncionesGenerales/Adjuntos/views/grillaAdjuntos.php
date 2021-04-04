<table id="tabla-adjuntos" class="table table-hover table-bordered" align="center"
        data-idForm="<?php echo (!empty($idForm)?$idForm:'adjuntos');?>">
    <thead>
        <tr>
            <th>Nombre Archivo</th>
            <th  class="column-view-hidden">Tipo Archivo</th>
            <th width="50px" nowrap >Descargar</th>
            <th width="50px" nowrap  class="column-view-hidden">Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($arrAdjuntos)): ?>
            <?php foreach ($arrAdjuntos as $key => $adjunto): ?>
                <tr>
                    <td align="center">
                        <strong><?php if(isset($adjunto['gl_nombre'])){
                            echo $adjunto['gl_nombre'];
                        }
                        else if(isset($adjunto['nombre_adjunto'])){
                            echo $adjunto['nombre_adjunto'];
                        }
                        else{
                            echo "Sin Información";    
                        }
                        ?></strong>
                    </td>
                    <td align="center"  class="column-view-hidden">
                        <?php echo $adjunto['gl_tipo'] ?>
                    </td>
                    <td align="center">
                        <a class="btn btn-xs btn-primary" href="javascript:void(0);" 
                                onclick="Adjunto.descargar(this,<?php echo $key; ?>, '<?php echo $adjunto['bo_temporal']; ?>');">
                            <i class="fa fa-download fa-1x"></i>
                        </a>
                    </td>
                    <td align="center"  class="column-view-hidden">
                        <button class="btn btn-xs btn-danger" type="button" 
                                onclick="Adjunto.eliminar(this,<?php echo $key; ?>,'<?php echo $nombreGrilla; ?>');">
                            <i class="fa fa-trash fa-1x"></i>
                        </button>
                    </td>
                </tr>

            <?php endforeach; ?>
        <?php endif; ?>

    </tbody>
</table>

