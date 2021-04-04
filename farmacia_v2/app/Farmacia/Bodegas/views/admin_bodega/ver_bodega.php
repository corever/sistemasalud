<form id="formVerBodega">

    <div class="form-group row col-sm-12 col-xs-12">
        <label for="bodega_tipo_nombre" class="col-4 col-form-label"><?php echo \Traduce::texto("Tipo"); ?></label>
        <div class="col-8">
            <input value="<?php echo $BodegaTipo->bodega_tipo_nombre; ?>" type="text" readonly class="form-control-plaintext" />
        </div>
    </div>
    <div class="form-group row col-sm-12 col-xs-12">
        <label for="nombre_territorio" class="col-4 col-form-label"><?php echo \Traduce::texto("Territorio"); ?></label>
        <div class="col-8">
            <input value="<?php echo $Territorio->nombre_territorio; ?>" type="text" readonly class="form-control-plaintext" />
        </div>
    </div>
    <div class="form-group row col-sm-12 col-xs-12">
        <label for="region_nombre" class="col-4 col-form-label"><?php echo \Traduce::texto("Región"); ?></label>
        <div class="col-8">
            <input value="<?php echo $Region->region_nombre; ?>" type="text" readonly class="form-control-plaintext" />
        </div>
    </div>
    <div class="form-group row col-sm-12 col-xs-12">
        <label for="Comuna" class="col-4 col-form-label"><?php echo \Traduce::texto("Comuna"); ?></label>
        <div class="col-8">
            <input value="<?php echo $Comuna->comuna_nombre; ?>" type="text" readonly class="form-control-plaintext" />
        </div>
    </div>
    <div class="form-group row col-sm-12 col-xs-12">
        <label for="bodega_nombre" class="col-4 col-form-label"><?php echo \Traduce::texto("Nombre"); ?></label>
        <div class="col-8">
            <input value="<?php echo $Bodega->bodega_nombre; ?>" type="text" readonly class="form-control-plaintext" />
        </div>
    </div>
    <div class="form-group row col-sm-12 col-xs-12">
        <label for="bodega_direccion" class="col-4 col-form-label"><?php echo \Traduce::texto("Dirección"); ?></label>
        <div class="col-8">
            <input value="<?php echo $Bodega->bodega_direccion; ?>" type="text" readonly class="form-control-plaintext " />
        </div>
    </div>
    <div class="form-group row col-sm-12 col-xs-12">
        <label for="bodega_telefono" class="col-4 col-form-label"><?php echo \Traduce::texto("Telefono"); ?></label>
        <div class="col-8">
            <input value="<?php echo $Bodega->bodega_telefono; ?>" type="text" readonly class="form-control-plaintext " />
        </div>
    </div>
</form>