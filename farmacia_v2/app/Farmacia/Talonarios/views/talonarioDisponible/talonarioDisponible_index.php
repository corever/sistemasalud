<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <!--<h1></h1>-->
            <!-- float-sm-right-->
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)">Farmacia</a></li>
               <li class="breadcrumb-item active"><?php echo \Traduce::texto("Talonarios"); ?></li>
            </ol>
         </div>
         <div class="col-sm-6">
            <?php /*
            <button type="button" class="btn bg-teal btn-xs mt-2" style="float:right;" 
            onclick="xModal.open('<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Mantenedor/Usuario/agregarBodega/','Agregar Bodega','90');">
            <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo \Traduce::texto("Agregar Bodega"); ?></button>
            <a data-toggle="collapse" href="#collapseFilter" aria-expanded="true" class="btn btn-xs btn-default mt-2 mr-2" style="float:right;">
               <i class="fas fa-filter"></i> <?php echo \Traduce::texto("Filtros"); ?>
            </a>
            */ ?>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>

<!-- Filtros de Busqueda -->
<!-- <section id="collapseFilter" class="content panel-collapse collapse in">
   <div class="container-fluid">
      <div class="row mb-2">
         <?php // echo $talonarioDisponible_filtros; 
         ?>
      </div>
   </div>
</section> -->

<section class="content">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-md-12">
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title"><?php echo \Traduce::texto("Listado de Talonarios Asignados"); ?></h3>
               </div>
               <div class="card-body">
                  <div class="table-responsive col-lg-12" data-row="10">
                     <div id="contenedor-tabla-talonarioDisponible">
                        <?php echo $talonarioDisponible_grilla; ?>
                     </div>
                  </div>
               </div>
               <div class="card-footer">

                  <form id="formCrearTalonario">

                     <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="id_motivo" class="col-sm-4 col-form-label control-label"><?php echo \Traduce::texto("Motivo"); ?></label>
                        <div class="col-sm-8">
                           <select class="form-control select2" id="id_motivo" name="id_motivo">
                              <option value="0">Seleccione Tipo Motivo</option>
                              <?php foreach ($arrTalonarioTipoMotivo as $item) : ?>
                                 <option value="<?php echo $item->id_talonario_tipo_motivo; ?>"><?php echo $item->gl_talonario_tipo_motivo; ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>

                     <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="gl_observacion" class="col-sm-4 col-form-label required-left"><?php echo \Traduce::texto("Observación"); ?></label>
                        <div class="col-sm-8">
                           <textarea class="form-control" rows="3" id="gl_observacion" name="gl_observacion"></textarea>
                        </div>
                     </div>

                  </form>

                  <button type="button" class="btn btn-sm btn-info" onclick="talonarioDisponible.transferirTalonarioSeleccionados()" data-toggle="tooltip" title="Transferir Talonarios">
                     <i class="fa fa-exchange-alt"></i>
                     &nbsp;&nbsp;Transferir Talonarios
                  </button>

                  <button type="button" class="btn btn-sm btn-danger" onclick="talonarioDisponible.eliminarTalonarioSeleccionados()" data-toggle="tooltip" title="Eliminar Talonarios">
                     <i class="fa fa-times"></i>
                     &nbsp;&nbsp;Eliminar Talonarios
                  </button>

                  <button type="button" class="btn btn-sm btn-warning" onclick="talonarioDisponible.mermaTalonarioSeleccionados()" data-toggle="tooltip" title="Talonarios Merma">
                     <i class="fa fa-trash"></i>
                     &nbsp;&nbsp;Merma
                  </button>

               </div>
            </div>
         </div>
      </div>
   </div>
</section>