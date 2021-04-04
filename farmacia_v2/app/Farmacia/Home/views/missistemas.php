<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <!--<div class="col-sm-6">
            <h1>Panel de Sistemas</h1>
         </div>-->
         <div class="col-sm-6">
            <!-- float-sm-right-->
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)">PAHO::HOPE</a></li>
               <li class="breadcrumb-item active"><?php echo \Traduce::texto("PaneldeSistemas"); ?></li>
            </ol>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <?php foreach($arrModulo as $key => $item): ?>
               <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box <?php echo $item->gl_color; ?>">
                     <div class="inner" style="min-height:98px;">
                           <h3 style="font-size: 1.5rem;font-weight: 100;"><?php echo \Traduce::texto($item->gl_nombre); ?></h3>
                           <p><?php echo $item->gl_descripcion; ?></p>
                     </div>
                     <div class="icon">
                           <i class="<?php echo $item->gl_icono; ?>"></i>
                     </div>
                     <a href="javascript:void(0)" onclick="Base.entrarModulo(this);" data-url="<?php echo $item->gl_url; ?>" data-id_modulo="<?php echo $item->id_modulo; ?>"
                        class="small-box-footer"><?php echo \Traduce::texto("IngresarModulo"); ?> <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
               </div>
         <?php endforeach; ?>
      </div>
   </div>
    
   
    
    <?php /*
    <div class="row">
       <div class="col-md-6">
          <div class="card card-primary">
             <div class="card-header">
                <h5 class="card-title">Establecimientos</h5>
                <div class="card-tools">
                   <button type="button" class="btn btn-tool" data-card-widget="collapse">
                   <i class="fas fa-minus"></i>
                   </button>
                </div>
             </div>
             <div class="card-body" style="display: block;">
                <div class="row">
                   <div class="hide" id="grafico_domicilios"></div>
                   <a href="<?php echo \pan\Uri\Uri::getBaseUri()."Establecimiento/Home/Dashboard"?>">
                   <i class="fa fa-arrow-right"></i>  &nbsp; &nbsp;
                   <span>IR a establecimientos</span>
                   </a>
                </div>
                <!-- Bitacora -->
                <div class="row">
                   <?php
                      $dataIn['callAsync']  = 'Establecimientos/Bitacora/AdministrarBitacora';//debe ser obligatorio
                      $dataIn['id']         = 'test';
                      $dataIn['folio']      = 'test';
                   ?>
                   <a href="javascript:void(0)" 
                      onClick="Bitacora.loadBitacora($(this))"
                      data-in='<?php echo json_encode($dataIn);?>'>
                   <i class="fa fa-arrow-right"></i>  &nbsp; &nbsp;
                   <span>Preview Bitacora</span>
                   </a>
                </div>
                <!-- Fin Bitacora -->

             </div>
          </div>
       </div>
    </div>
    */ ?>
    
</section>