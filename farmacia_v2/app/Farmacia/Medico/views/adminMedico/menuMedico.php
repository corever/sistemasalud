
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
             <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)">Medico</a></li>
               <li class="breadcrumb-item active"><?php echo "Administración Medicos" ?></li>
            </ol>
         </div>
         <div class="col-sm-6">
            <button type="button" class="btn bg-teal btn-xs mt-2" style="float:right;" 
            onclick="xModal.open('<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Medico/AdminMedico/agregarMedico/','Registrar Medico','90');">
            <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo \Traduce::texto("Agregar Medico"); ?></button>
           <!-- <a data-toggle="collapse"  href="#collapseFilter" aria-expanded="true" class="btn btn-xs btn-default mt-2 mr-2" style="float:right;">
            <i class="fas fa-filter"></i> <?php /*echo \Traduce::texto("Filtros");*/ ?>
            </a>-->
         </div>
      </div>
   </div>
</section>

<!-- Filtros de Busqueda -->
<section id="collapseFilter" class="content panel-collapse collapse in">
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
                  <h3 class="card-title"><?php echo "Listado de Medicos"; ?></h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive col-lg-12" data-row="10">
                      <div id="contenedor-tabla-usuario">
                        <?php echo $grilla ?>
                      </div>
                  </div>
                </div>
            </div>
        </div>
      </div>
   </div>
</section>