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
   <form action="#" id="form" class="col-xs-12 col-sm-12 col-md-12">
     <div class="card pl-1 mb-0">
         <div class="card-header">
            <h3 class="card-title text-primary"><i class="far fa-id-card"></i>&nbsp;<?php echo \Traduce::texto("Información de Contacto"); ?></h3>
         </div>
         <div class="card-body row pb-2">
            <div class="col-6">
               <div class="form-group">
                  <label for="email" class="required-left">Email</label>
                  <input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="ejemplo@gmail.com">
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label for="telefono" class="required-left"><?php echo \Traduce::texto("Teléfono"); ?></label>
                  <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" placeholder="">
               </div>
            </div>
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="card pl-1 mb-0">
            <div class="card-header">
               <h3 class="card-title text-primary"><i class="fas fa-file-signature"></i>&nbsp;<?php echo \Traduce::texto("Datos de Solicitud"); ?></h3>
            </div>
            <div class="card-body row pb-2">
               <div class="col-6">
                  <div class="form-group">
                     <label for="asunto" class="required-left"><?php echo \Traduce::texto("Asunto"); ?></label>
                     <input type="text" class="form-control form-control-sm" id="asunto" name="asunto">
                  </div>
               </div>
               <div class="col-12">
                  <div class="form-group">
                     <label for="mensaje" class="required-left"><?php echo \Traduce::texto("Mensaje"); ?></label>
                     <textarea id="mensaje" name="mensaje" rows="3" class="form-control form-control-sm"></textarea>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <label for=""><?php echo \Traduce::texto("Adjuntar Evidencias"); ?></label>
                     <a type="button" id="addfileButton" class="btn btn-xs btn-default" style="width:100%;" onclick="xModal.open('<?php echo \Pan\Uri\Uri::getBaseUri(); ?>_FuncionesGenerales/Adjuntos/Adjuntos/nuevoAdjunto','Cargar Adjunto','',true,'200');">
                     <i class="fa fa-fw fa-upload"></i> <?php echo \Traduce::texto("Mensaje para adjuntar"); ?>
                     </a>
                  </div>
               </div>
               <div class="col-12" id="adjuntos">
                  <table id="adjuntos" class="table table-hover table-bordered" align="center" data-idform="adjuntos">
                     <thead>
                        <tr>
                           <th><?php echo \Traduce::texto("Nombre Archivo"); ?></th>
                           <th><?php echo \Traduce::texto("Tipo Archivo"); ?></th>
                           <th width="50px" nowrap=""><?php echo \Traduce::texto("Descargar"); ?></th>
                           <th width="50px" nowrap=""><?php echo \Traduce::texto("Eliminar"); ?></th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 text-right mt-5">
         <button class="btn bg-teal btn-sm" type="button" onclick="MesaAyuda.enviarTicket($(this))"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Guardar"); ?></button>
         <button class="btn btn-default btn-sm" "="" type="button" onclick="xModal.close();"><i class="fas fa-times"></i> <?php echo \Traduce::texto("Cancelar"); ?></button>
      </div>
   </form>
</div>