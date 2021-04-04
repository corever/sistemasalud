<section class="content">
    <div class="container-fluid">
        <div class="row mb-2 mt-3">
            <div class="col-12">
                <div class="card card-primary">

                    <div class="card-header">

                        <h3 class="card-title"><?php echo \Traduce::texto("Ingresar Talonario Cheque"); ?></h3>

                    </div>
                    <div class="card-body">

                        <form id="formIngresarTalonario">

                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="gl_serie" class="col-sm-4 col-form-label required-left"><?php echo \Traduce::texto("Serie"); ?></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="gl_serie" name="gl_serie">
                                </div>
                            </div>
                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="nr_cantidadTalonario" class="col-sm-4 col-form-label required-left"><?php echo \Traduce::texto("Cantidad talonarios"); ?></label>
                                <div class="col-sm-8">
                                    <input type="number" value="1" min="1" class="form-control" id="nr_cantidadTalonario" name="nr_cantidadTalonario">
                                </div>
                            </div>
                            <div class="">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="row">
                                        <div class="form-group  row col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <label for="nr_folioInicial" class="col-sm-6 col-form-label required-left"><?php echo \Traduce::texto("Folio inicial"); ?></label>
                                            <div class="col-sm-6">
                                                <input type="number" value="1" min="1" class="form-control" id="nr_folioInicial" name="nr_folioInicial">
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <label for="nr_folioFinal" class="col-sm-6 col-form-label"><?php echo \Traduce::texto("Folio final"); ?></label>
                                            <div class="col-sm-6">
                                                <input type="number" value="1" min="1" class="form-control " readonly id="nr_folioFinal" name="nr_folioFinal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            /**
                             * Se comenta ya que se setea por defecto en 50
                             * <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                             *    <label for="nr_cantidadChequesPorTalonario" class="required-left"><?php echo \Traduce::texto("Cantidad cheques por talonario"); ?></label>
                             *    <input type="text" class="form-control" id="nr_cantidadChequesPorTalonario" name="nr_cantidadChequesPorTalonario" value="50">
                             * </div>
                             */
                            ?>

                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="id_proveedor" class="col-sm-4 col-form-label control-label required-left"><?php echo \Traduce::texto("Proveedor"); ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="id_proveedor" name="id_proveedor">
                                        <option value="0">Seleccione Tipo Proveedor</option>
                                        <?php foreach ($arrTalonarioTipoProveedor as $item) : ?>
                                            <option value="<?php echo $item->id_talonario_tipo_proveedor; ?>"><?php echo $item->gl_talonario_tipo_proveedor; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="id_documento" class="col-sm-4 col-form-label control-label required-left"><?php echo \Traduce::texto("Documento"); ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="id_documento" name="id_documento">
                                        <option value="0">Seleccione Tipo Documento</option>
                                        <?php foreach ($arrTalonarioTipoDocumento as $item) : ?>
                                            <option value="<?php echo $item->id_talonario_tipo_documento; ?>"><?php echo $item->gl_talonario_tipo_documento; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="nr_documento" class="col-sm-4 col-form-label required-left"><?php echo \Traduce::texto("N&uacute;mero Documento"); ?></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nr_documento" name="nr_documento">
                                </div>
                            </div>
                            <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="fc_documento" class="col-sm-4 col-form-label control-label required-left"><?php echo \Traduce::texto("Fecha Documento"); ?></label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" readonly class="form-control float-left datepicker" id="fc_documento" name="fc_documento" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-sm btn-success" id="ingresarTalonarios" data-toggle="tooltip" title="Ingresar"><i class="fa fa-save"></i>&nbsp;&nbsp;Ingresar
                        </button>
                        <button type="button" class="btn btn-sm btn-warning" id="cancelarIngresarTalonarios" data-toggle="tooltip" title="Cancelar"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>