<button class="btn btn-success btn-xs" type="button" id="btnAdjuntar<?php echo (!empty($idGrillaAdjunto))?$idGrillaAdjunto:"adjuntos"; ?>" name="btnAdjuntar"
        onclick="Adjunto.cargarAdjunto(this,<?php echo '\''.$boComentarioAdj.'\',\''.$idTipoAdjunto.'\',\''.$extensionAdjunto.'\',\''.$idForm.'\',\''.$idGrillaAdjunto.'\''; ?>);">
    <i class="fa fa-save"></i> <?php echo \Traduce::texto("Adjuntar"); ?>
</button>
<input id="cantAdjuntos" name="cantAdjuntos" value="<?php echo $cantAdjuntos; ?>" hidden>
<input id="extensionAdjunto" name="extensionAdjunto" value="<?php echo $extensionAdjunto; ?>" hidden>
<input id="idGrillaAdjunto" name="idGrillaAdjunto" value="<?php echo $idGrillaAdjunto; ?>" hidden>
<div id="<?php echo (!empty($idGrillaAdjunto))?$idGrillaAdjunto:"adjuntos"; ?>" style="display:none;">
    <?php include('grillaAdjuntos.php'); ?>
</div>