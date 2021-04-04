<section class="content">
   <div class="container-fluid">
      <div class="row mb-1">
         <div class="col-md-12">
            <div class="card card-primary">
               <div class="card-header">

                  <h3 class="card-title"><?php echo \Traduce::texto("Información Bodega"); ?></h3>

               </div>
               <div class="card-body">

                  <form  class="form-inline">

                     <div class="form-group row">
                        <label for="bodega_nombre" class="col-4 col-form-label"><?php echo \Traduce::texto("Nombre"); ?></label>
                        <div class="col-8">
                           <input type="text" readonly id="bodega_nombre" class="form-control-plaintext" value="<?php echo $Bodega->bodega_nombre; ?>">
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="bodega_tipo_nombre" class="col-4 col-form-label"><?php echo \Traduce::texto("Tipo"); ?></label>
                        <div class="col-8">
                           <input type="text" readonly id="bodega_tipo_nombre" class="form-control-plaintext" value="<?php echo $BodegaTipo->bodega_tipo_nombre; ?>">
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="region_nombre" class="col-4 col-form-label"><?php echo \Traduce::texto("Región"); ?></label>
                        <div class="col-8">
                           <input type="text" readonly id="region_nombre" class="form-control-plaintext" value="<?php echo $Region->region_nombre; ?>">
                        </div>
                     </div>

                  </form>

               </div>
            </div>
         </div>
      </div>
   </div>
</section>