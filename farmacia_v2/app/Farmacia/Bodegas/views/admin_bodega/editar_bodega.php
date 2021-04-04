<form id="formEditarBodega">

    <input value="<?php echo $Bodega->gl_token; ?>" name="gl_token" id="gl_token" type="hidden" />

    <div class="form-group row col-sm-12 col-xs-12">
        <label for="bodega_tipo_nombre" class="col-4 col-form-label"><?php echo \Traduce::texto("Tipo"); ?></label>
        <div class="col-8">
            <input value="<?php echo $BodegaTipo->bodega_tipo_nombre; ?>" id="bodega_tipo_nombre" type="text" readonly class="form-control-plaintext" />
        </div>
    </div>
    <div class="form-group row col-sm-12 col-xs-12">
        <label for="nombre_territorio" class="col-4 col-form-label"><?php echo \Traduce::texto("Territorio"); ?></label>
        <div class="col-8">
            <input value="<?php echo $Territorio->nombre_territorio; ?>" id="nombre_territorio" type="text" readonly class="form-control-plaintext" />
        </div>
    </div>
    <div class="form-group row col-sm-12 col-xs-12">
        <label for="region_nombre" class="col-4 col-form-label"><?php echo \Traduce::texto("Región"); ?></label>
        <div class="col-8">
            <input value="<?php echo $Region->region_nombre; ?>" id="region_nombre" type="text" readonly class="form-control-plaintext" />
        </div>
    </div>
    <div class="form-group row col-sm-12 col-xs-12">
        <label for="Comuna" class="col-4 col-form-label"><?php echo \Traduce::texto("Comuna"); ?></label>
        <div class="col-8">
            <input value="<?php echo $Comuna->comuna_nombre; ?>" id="comuna_nombre" type="text" readonly class="form-control-plaintext" />
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
            <input value="<?php echo $Bodega->bodega_direccion; ?>" name="bodega_direccion" id="bodega_direccion" type="text" class="form-control " />
        </div>
    </div>
    <div class="form-group row col-sm-12 col-xs-12">
        <label for="bodega_telefono" class="col-4 col-form-label"><?php echo \Traduce::texto("Telefono"); ?></label>
        <div class="col-8">
            <input value="<?php echo $Bodega->bodega_telefono; ?>" name="bodega_telefono" id="bodega_telefono" type="text" class="form-control " />
        </div>
    </div>

</form>