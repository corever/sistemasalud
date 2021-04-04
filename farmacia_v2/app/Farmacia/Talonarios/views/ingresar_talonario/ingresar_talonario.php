<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!--<h1>Mesa de Ayuda</h1>-->
                <!-- float-sm-right-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Farmacia</a></li>
                    <li class="breadcrumb-item active"><?php echo \Traduce::texto("Talonarios"); ?></li>
                </ol>
            </div>
            <!-- <div class="col-sm-6">
                <button type="button" class="btn bg-teal btn-xs mt-2" style="float:right;" onclick="xModal.open('<?php // echo \Pan\Uri\Uri::getBaseUri(); 
                                                                                                                    ?>MesaAyuda/Home/MisTickets/agregarTicket','Registrar Ticket','lg');">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php // echo \Traduce::texto("Nuevo Ticket"); 
                                                            ?>
                </button>
            </div> -->
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<?php echo $formulario_ingresar_talonario; ?>
  