<form id="formInhabilitarLoteTalonarios">

    <input value="<?php echo $TalonariosCreados->gl_token; ?>" name="gl_token" id="gl_token" type="hidden" />

    <div class="form-group row col-sm-12 col-xs-12">
        <label for="gl_serie" class="col-4 col-form-label"><?php echo \Traduce::texto("Serie"); ?></label>
        <div class="col-8">
            <input value="<?php echo $TalonariosCreados->talonario_serie; ?>" id="gl_serie" type="text" readonly class="form-control-plaintext" />
        </div>
    </div>

    <div class="form-group row col-sm-12 col-xs-12">
        <label for="nr_folioInicial" class="col-sm-4 col-form-label"><?php echo \Traduce::texto("Folio inicial"); ?></label>
        <div class="col-8">
            <input value="<?php echo $TalonariosCreados->talonario_folio_inicial; ?>" id="nr_folioInicial" type="text" readonly class="form-control-plaintext" />
        </div>
    </div>

    <div class="form-group row col-sm-12 col-xs-12">
        <label for="nr_folioFinal" class="col-sm-4 col-form-label"><?php echo \Traduce::texto("Folio final"); ?></label>
        <div class="col-8">
            <input value="<?php echo $TalonariosCreados->talonario_folio_final; ?>" id="nr_folioFinal" type="text" readonly class="form-control-plaintext" />
        </div>
    </div>

    <div class="form-group row col-sm-12 col-xs-12">
        <label for="id_motivo" class="col-sm-4 col-form-label required-left"><?php echo \Traduce::texto("Motivo"); ?></label>
        <div class="col-sm-8">
            <select class="form-control select2" id="id_motivo" name="id_motivo">
                <option value="0">Seleccione Motivo</option>
                <?php foreach ($arrTalonarioTipoMotivo as $item) : ?>
                    <option value="<?php echo $item->id_talonario_tipo_motivo; ?>"><?php echo $item->gl_talonario_tipo_motivo; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row col-sm-12 col-xs-12">
        <label for="gl_observacion" class="col-sm-4 col-form-label required-left"><?php echo \Traduce::texto("Observación"); ?></label>
        <div class="col-sm-8">
            <textarea class="form-control" rows="3" id="gl_observacion" name="gl_observacion"></textarea>
        </div>
    </div>

</form>