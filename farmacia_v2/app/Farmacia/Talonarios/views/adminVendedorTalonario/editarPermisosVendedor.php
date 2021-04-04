
<input value="<?php echo $Vendedor->gl_token; ?>" name="token" id="token" type="hidden" />

<form id="formEditarPermisosVendedor">
    <div class="form-group row col-sm-12 col-xs-12">
        <label for="vendedor" class="col-4 col-form-label"><?php echo \Traduce::texto("Vendedor"); ?></label>
        <div class="col-8">
            <input value="<?php echo $Vendedor->vendedor; ?>" id="vendedor" type="text" readonly class="form-control-plaintext" />
        </div>
    </div>

    <h4>Permisos</h4>

    <div class="form-group row col-sm-12 col-xs-12">
        <label for="bo_crear_medico" class="col-4 col-form-label"><?php echo \Traduce::texto("Crear médico"); ?></label>
        <div class="col-8">
            <div class="form-check">
                <input class="form-check-input bo_crear_medico" <?php echo (1 === (int)$Vendedor->bo_crear_medico ? " checked=\"checked\" " : ""); ?> type="checkbox" value="1" id="bo_crear_medico" name="bo_crear_medico">
            </div>
        </div>
    </div>

    <div class="form-group row col-sm-12 col-xs-12">
        <label for="bo_inhabilitar_medico" class="col-4 col-form-label"><?php echo \Traduce::texto("Inhabilitar médico"); ?></label>
        <div class="col-8">
            <div class="form-check">
                <input class="form-check-input bo_inhabilitar_medico" <?php echo (1 === (int)$Vendedor->bo_inhabilitar_medico ? " checked=\"checked\" " : ""); ?> type="checkbox" value="1" id="bo_inhabilitar_medico" name="bo_inhabilitar_medico">
            </div>
        </div>
    </div>

    <div class="form-group row col-sm-12 col-xs-12">
        <label for="bo_editar_medico" class="col-4 col-form-label"><?php echo \Traduce::texto("Editar médico"); ?></label>
        <div class="col-8">
            <div class="form-check">
                <input class="form-check-input bo_editar_medico" <?php echo (1 === (int)$Vendedor->bo_editar_medico ? " checked=\"checked\" " : ""); ?> type="checkbox" value="1" id="bo_editar_medico" name="bo_editar_medico">
            </div>
        </div>
    </div>

    <div class="form-group row col-sm-12 col-xs-12">
        <label for="bo_asignarse_talonarios" class="col-4 col-form-label"><?php echo \Traduce::texto("Asignarse Talonarios"); ?></label>
        <div class="col-8">
            <div class="form-check">
                <input class="form-check-input bo_asignarse_talonarios" <?php echo (1 === (int)$Vendedor->bo_asignarse_talonarios ? " checked=\"checked\" " : ""); ?> type="checkbox" value="1" id="bo_asignarse_talonarios" name="bo_asignarse_talonarios">
            </div>
        </div>
    </div>

</form>