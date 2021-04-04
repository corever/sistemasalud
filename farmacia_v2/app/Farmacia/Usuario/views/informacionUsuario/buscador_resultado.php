<section class="content">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-md-12">
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title"><?php echo \Traduce::texto("Resultado de Filtros: Usuarios"); ?></h3>
               </div>
               <div class="card-body">
                  <div class="table-responsive col-lg-12" data-row="10">
                     <div id="divGrillaInformacionUsuario">

                        <table class="table table-hover table-striped table-bordered dataTable no-footer" id="grillaInformacionUsuario" width="100%">
                           <thead>
                              <tr>
                                 <th width="10%"><?php echo \Traduce::texto("RUT"); ?></th>
                                 <th width="20%"><?php echo \Traduce::texto("Usuario"); ?></th>
                                 <th width="10%"><?php echo \Traduce::texto("Región"); ?></th>
                                 <th width="10%"><?php echo \Traduce::texto("Estado"); ?></th>
                                 <!-- <th width="5%"><?php // echo \Traduce::texto("Institucional"); 
                                                      ?></th> -->
                                 <th width="20%"><?php echo \Traduce::texto("Rol"); ?></th>
                                 <th width="20%"><?php echo \Traduce::texto("Profesión"); ?></th>
                                 <th width="10%"><?php echo \Traduce::texto("Acciones"); ?></th>
                              </tr>
                           </thead>
                        </table>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>