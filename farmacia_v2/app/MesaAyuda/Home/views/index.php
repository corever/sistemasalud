<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <!--<h1>Mesa de Ayuda</h1>-->
             <!-- float-sm-right-->
             <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)">PAHO::HOPE</a></li>
               <li class="breadcrumb-item active"><?php echo \Traduce::texto("MesaAyuda"); ?></li>
            </ol>
         </div>
         <div class="col-xs-12 col-md-6">
            <button class="btn btn-xs bg-teal btn-flat margin" style="float:right;" onclick="MesaAyuda.agregarTicket();">
            <i class="fa fa-plus"></i> Nuevo Ticket
            </button>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>

<section class="content" id="registroTicket" style="display:none;">
   <div class="col-12">
      <div class="box box-primary">
         <div class="box-header">
            <h3 class="box-title"><?php echo \Traduce::texto("Registro de Ticket"); ?></h3>
         </div>
            <div class="box-body">
               <form  id="form" class="form-horizontal" enctype="application/x-www-form-urlencoded" action="" method="post">
                  <input type="text" id="rut" name="rut" hidden value="<?php echo $rut ?>" />

                  <div class="row top-spaced">
                     <div class="col-3">
                        <label for="gl_asunto" class="required-left">Asunto:</label>
                     </div>
                     <div class="col-9">
                        <input type="text" id="gl_asunto" name="gl_asunto" class="form-control" value="<?php echo $gl_asunto; ?>" />
                     </div>
                     <span class="help-block hidden"></span>
                  </div>
                  <div class="row top-spaced">
                     <div class="col-3">
                        <label for="gl_telefono" class="required-left">Tel&eacute;fono de Contacto:</label>
                     </div>
                     <div class="col-9">
                        <input type="text" id="gl_telefono" name="gl_telefono" class="form-control" value="<?php echo $gl_telefono; ?>" />
                     </div>
                     <span class="help-block hidden"></span>
                  </div>

                  <div class="row top-spaced">
                     <div class="col-3">
                        <label for="gl_email" class="required-left">Email de Contacto:</label>
                        </div>
                     <div class="col-9">
                        <input type="text" id="gl_email" name="gl_email" class="form-control element-search" value="<?php echo $gl_email; ?>" />
                     </div>
                     <span class="help-block hidden"></span>
                  </div>

                  <div class="row top-spaced">
                     <div class="col-3">
                        <label for="gl_mensaje" class="required-left">Mensaje:</label>
                     </div>
                     <div class="col-9">
                        <textarea class="form-control" rows="2" id="gl_mensaje" name="gl_mensaje"><?php echo $gl_mensaje; ?></textarea>
                     </div>
                  </div>

                  <div class="row top-spaced">
                     <div class="col-3">
                        <label>&nbsp;Adjunte Evidencia:</label>
                     </div>
                     <div class="col-6">
                        <!-- Include btnAdjuntar y grilla -->
                        <?php include('app/_FuncionesGenerales/Adjuntos/views/btnAdjuntar.php'); ?>
                     </div>
                  </div>
                  <div class="row float-right top-spaced">
					      <div class="col-12">
                        <button id="enviarTicket" type="button" class="btn btn-xs btn-success btn-flat margin" onclick="MesaAyuda.enviarTicket(this);">
                           <i class="fa fa-fax"></i> Registrar Ticket
                        </button>
                     </div>
                  </div>
               </form>
            </div>
      </div>
   </div>
</section>

<section class="content">
   <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title"><?php echo \Traduce::texto("Lista de Tickets"); ?></h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive col-lg-12" data-row="10">
                      <div id="contenedor-tickets">
                        <?php echo $grilla; ?>
                      </div>
                  </div>
                </div>
            </div>
        </div>
      </div>
   </div>
</section>