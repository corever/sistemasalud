 <form id="formAgregarBodega">

     <div class="form-group row col-sm-12 col-xs-12">
         <label for="fk_bodega_tipo" class="col-sm-4 col-form-label control-label required-left"><?php echo \Traduce::texto("Tipo"); ?></label>
         <div class="col-sm-8">
             <select class="form-control select2" id="fk_bodega_tipo" name="fk_bodega_tipo">
                 <option value="0">Seleccione Tipo Proveedor</option>
                 <?php foreach ($arrBodegaTipo as $item) : ?>
                     <option value="<?php echo $item->bodega_tipo_id; ?>" data-bodegatiposigla="<?php echo $item->bodega_tipo_sigla; ?>"><?php echo $item->bodega_tipo_nombre; ?></option>
                 <?php endforeach; ?>
             </select>
         </div>
     </div>

     <div class="form-group row col-sm-12 col-xs-12">
         <label for="fk_region" class="col-sm-4 col-form-label control-label required-left"><?php echo \Traduce::texto("Región"); ?></label>
         <div class="col-sm-8">
             <select class="form-control select2" id="fk_region" name="fk_region">
                 <option value="0">Seleccione Región</option>
                 <?php foreach ($arrRegion as $item) : ?>
                     <option value="<?php echo $item->region_id; ?>" data-regionnombrecorto="<?php echo $item->nombre_region_corto; ?>"><?php echo $item->region_nombre; ?></option>
                 <?php endforeach; ?>
             </select>
         </div>
     </div>

     <div class="form-group row col-sm-12 col-xs-12">
         <label for="fk_territorio" class="col-sm-4 col-form-label"><?php echo \Traduce::texto("Territorio"); ?></label>
         <div class="col-sm-8">
             <select class="form-control select2" id="fk_territorio" name="fk_territorio">
                 <option value="0">Seleccione Territorio</option>
                 <?php foreach ($arrTerritorio as $item) : ?>
                     <option value="<?php echo $item->territorio_id; ?>"><?php echo $item->nombre_territorio; ?></option>
                 <?php endforeach; ?>
             </select>
         </div>
     </div>

     <div class="form-group row col-sm-12 col-xs-12">
         <label for="fk_comuna" class="col-sm-4 col-form-label"><?php echo \Traduce::texto("Comuna"); ?></label>
         <div class="col-sm-8">
             <select class="form-control select2" id="fk_comuna" name="fk_comuna">
                 <option value="0">Seleccione Comuna</option>
                 <?php foreach ($arrComuna as $item) : ?>
                     <option value="<?php echo $item->comuna_id; ?>"><?php echo $item->comuna_nombre; ?></option>
                 <?php endforeach; ?>
             </select>
         </div>
     </div>

     <div class="form-group row col-sm-12 col-xs-12">
         <label for="bodega_nombre" class="col-4 col-form-label"><?php echo \Traduce::texto("Nombre"); ?></label>
         <div class="col-8">
             <input name="bodega_nombre" id="bodega_nombre" type="text" readonly class="form-control-plaintext" />
         </div>
     </div>

     <div class="form-group row col-sm-12 col-xs-12">
         <label for="bodega_direccion" class="col-4 col-form-label control-label required-left"><?php echo \Traduce::texto("Dirección"); ?></label>
         <div class="col-8">
             <input value="<?php echo $Bodega->bodega_direccion; ?>" name="bodega_direccion" id="bodega_direccion" type="text" class="form-control " />
         </div>
     </div>
     <div class="form-group row col-sm-12 col-xs-12">
         <label for="bodega_telefono" class="col-4 col-form-label control-label required-left"><?php echo \Traduce::texto("Teléfono"); ?></label>
         <div class="col-8">
             <input value="<?php echo $Bodega->bodega_telefono; ?>" name="bodega_telefono" id="bodega_telefono" type="text" class="form-control " />
         </div>
     </div>
 </form>