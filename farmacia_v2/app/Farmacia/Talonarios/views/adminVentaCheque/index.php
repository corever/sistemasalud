<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <!-- float-sm-right-->
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)">Farmacia</a></li>
               <li class="breadcrumb-item active"><?php echo \Traduce::texto("Administrar Venta Cheque"); ?></li>
            </ol>
         </div>
         <div class="col-sm-6">
            <a data-toggle="collapse"  href="#collapseFilter" aria-expanded="false" class="btn btn-xs btn-default mt-2 mr-2" style="float:right;">
            <i class="fas fa-filter"></i> <?php echo \Traduce::texto("Filtros"); ?>
            </a>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>

<!-- Filtros de Busqueda -->
<section id="collapseFilter" class="content panel-collapse collapse">
   <div class="container-fluid">
      <div class="row mb-2">
         <?php echo $filtros ?>
      </div>
   </div>
</section>

<section class="content">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-md-12">
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title"><?php echo \Traduce::texto("Listado De Talonarios Asignados"); ?></h3>
               </div>
               <div class="card-body">
                  <div class="table-responsive col-lg-12" data-row="10">
                     <div id="contenedor-tabla-talonarios-asignados">
                        <?php echo $grilla; ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>