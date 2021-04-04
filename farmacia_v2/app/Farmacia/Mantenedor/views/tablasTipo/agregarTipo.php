<style>
   .card {
   box-shadow:none;
   border-radius: 0;
   }
   .card>.card-header{
   border-bottom: 1px solid rgba(0,0,0,.125);
   }
   label {
   font-weight: 100 !important;
   font-size: 14px !important;
   }
</style>

<div class="row">
   <form action="#" id="formTipo" class="col-xs-12 col-sm-12 col-md-12">
    <input type="hidden" name="dTable" id="dTable" value="<?php echo $dTable?>">
    <input type="hidden" name="dField" id="dField" value="<?php echo $dField?>">
     <div class="card pl-1 mb-0">
         <div class="card-header pl-0">
            <h3 class="card-title text-primary"><i class="fas fa-file-signature"></i>&nbsp;<?php echo \Traduce::texto("Información Básica del Tipo"); ?></h3>
         </div>
         <div class="card-body row pb-2 pl-0">
            <div class="col-12">
                <div class="form-group row">
                  <label for="gl_nombre" class="required-left col-4"><?php echo \Traduce::texto("Nombre/Descripción"); ?></label>
                  <input type="text" class="form-control form-control-sm col-8" id="gl_nombre" name="gl_nombre" placeholder="">
               </div>
            </div>
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 text-right mt-5">
         <button class="btn bg-teal btn-sm" type="button" onclick="MantenedorTablasTipo.agregarTipo($(this))"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Guardar"); ?></button>
         <button class="btn btn-default btn-sm" "="" type="button" onclick="xModal.close();"><i class="fas fa-times"></i> <?php echo \Traduce::texto("Cancelar"); ?></button>
      </div>
   </form>
</div>