
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
             <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)" class="active">Medico</a></li>
               <li class="breadcrumb-item active"><?php echo "Crear Medico Cirujano" ?></li>
            </ol>
         </div>
      </div>
   </div>
</section>



<section class="content">
   <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-md-12">
           <?php echo $registrar ?>
           <div class="top-spaced" id="div_acciones" align="right">
               <button class="btn btn-success" type="button" onclick="MantenedorMedico.agregarMedico($(this.form).serializeArray(), this);"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Guardar"); ?> </button>
	      	</div>
        </div>
      </div>
   </div>
</section>