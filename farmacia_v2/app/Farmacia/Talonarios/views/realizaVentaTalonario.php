<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Farmacia</a></li>
                    <li class="breadcrumb-item active">Previsualización Venta de Talonarios</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<form id="formRealizaVentaTalonario" class="form-horizontal">
    <div class="row">
        <div class="col-8">
            <section class="content">
                <div class="card card-primary">
                    <div class="card-header"> Datos Medico Cirujano </div>
                    <div class="card-body">
                        <input type="hidden" id="id_profesional_medico" name="id_profesional_medico" value="<?php echo $arrMedico->id_usuario; ?>">
                        <table class="table">
                            <tr>
                                <td>Nombre </td>
                                <td><?php echo $arrMedico->gl_nombres . " " . $arrMedico->gl_apellido_paterno . " " . $arrMedico->gl_apellido_materno; ?> </td>
                            </tr>
                            <tr>
                                <td>Rut </td>
                                <td> <?php echo $arrMedico->gl_rut; ?> </td>
                            </tr>
                            <tr>
                                <td>Correo </td>
                                <td> <?php echo $arrMedico->gl_email; ?> </td>
                            </tr>
                            <tr>
                                <td>Especialidad </td>
                                <td> <?php echo $arrMedico->gl_especialidad; ?> </td>
                            </tr>
                            <tr>
                                <td>Dir. Consulta </td>
                                <td> <?php echo $arrMedico->gl_direccion; ?> </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header"> Talonarios Vendidos </div>
                        <div class="card-body">
                            <input type="hidden" id="id_profesional_medico" name="id_profesional_medico" value="<?php echo $arrMedico->id_usuario; ?>">
                            <table class="table">
                                <tr>
                                    <td>Serie - Correlativo </td>
                                </tr>
                                <?php foreach($arrTalonario as $talonario): ?>
                                    <tr>
                                        <td> <?php echo $talonario->gl_talonario; ?> </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="top-spaced" id="div_acciones" align="right">
                        <button class="btn btn-success" type="button" onclick="VentaTalonario.realizarVentaBD($(this.form).serializeArray(), this);"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Generar Venta"); ?> </button>
                        <button class="btn btn-danger" type="button" onclick="window.location='<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Talonarios/Talonario/ventaTalonario/';"><i class="fa fa-close"></i> <?php echo \Traduce::texto("Cancelar"); ?> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header"> Historial Últimas 5 Compras </div>
                <div class="card-body">
                    <input type="hidden" id="id_profesional_medico" name="id_profesional_medico" value="<?php echo $arrMedico->id_usuario; ?>">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Serie</th>
                                <th>Folio</th>
                                <th>Local Venta</th>
                                <th>Fecha Compra</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($arrUltimasCompras)): ?>
                                <?php foreach($arrUltimasCompras as $item): ?>
                                <tr>
                                    <td><?php echo $item->gl_serie; ?></td>
                                    <td><?php echo $item->gl_folio; ?></td>
                                    <td><?php echo $item->gl_local_venta; ?></td>
                                    <td><?php echo $item->fc_compra; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" align="center">Sin registros</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>

<!--div class="row">
    <div class="col-4">
        <label for="btnAdjuntar" class="control-label required-left"><?php //echo \Traduce::texto("Adjunto PYME"); ?></label>
    </div>
    <div class="col-6">
        <!-- Include btnAdjuntar y grilla ->
        <?php //include('app/_FuncionesGenerales/Adjuntos/views/btnAdjuntar.php'); ?>
    </div>
</div-->