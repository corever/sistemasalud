<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <!--<h1></h1>-->
            <!-- float-sm-right-->
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)">Farmacia</a></li>
               <li class="breadcrumb-item active"><?php echo \Traduce::texto("Mi Bodega"); ?></li>
            </ol>
         </div> 
      </div>
   </div>
   <!-- /.container-fluid -->
</section>

<section class="content">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-md-12">
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title"><?php echo \Traduce::texto("Mi Bodegas"); ?></h3>
               </div>
               <div class="card-body">
                  <?php echo $vista; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>