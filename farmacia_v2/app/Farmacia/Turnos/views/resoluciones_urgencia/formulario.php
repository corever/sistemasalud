<section class="content">
    <div class="container-fluid">
        <div class="row mb-2 mt-3">
            <div class="col-12">

                <form id="formIngresarResolucionUrgencia">

                    <div class="card card-primary">

                        <div class="card-header">

                            <h3 class="card-title"><?php echo \Traduce::texto("Formulario"); ?></h3>

                        </div>

                        <div class="card-body">


                            <div class="form-group row col-sm-12 col-xs-12">
                                <label for="id_region" class="col-sm-4 col-form-label control-label required-left"><?php echo \Traduce::texto("Región"); ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="id_region" name="id_region">
                                        <option value="0">Seleccione una Región</option>
                                        <?php foreach ($arrRegion as $item) : ?>
                                            <option value="<?php echo $item->id_region_midas; ?>"><?php echo $item->region_nombre; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row col-sm-12 col-xs-12">
                                <label for="id_comuna" class="col-sm-4 col-form-label control-label required-left"><?php echo \Traduce::texto("Comuna"); ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="id_comuna" name="id_comuna">
                                        <option value="0">Seleccione una Comuna</option>
                                        <?php foreach ($arrComuna as $item) : ?>
                                            <option value="<?php echo $item->id_comuna_midas; ?>"><?php echo $item->comuna_nombre; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row col-sm-12 col-xs-12">
                                <label for="id_establecimiento_urgencia" class="col-sm-4 col-form-label control-label required-left"><?php echo \Traduce::texto("Establecimiento urgencia"); ?></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="id_establecimiento_urgencia" name="id_establecimiento_urgencia">
                                        <option value="0">Seleccione un Establecimiento Urgencia</option>
                                        <?php foreach ($arrEstablecimientoUrgencia as $item) : ?>
                                            <option value="<?php echo $item->local_id; ?>"><?php echo $item->local_nombre; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>


                            <div class="">
                                <div class=" ">
                                    <div class="row">
                                        <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <label for="id_periodo" class="col-sm-4 col-form-label control-label required-left"><?php echo \Traduce::texto("Período"); ?></label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" id="id_periodo" name="id_periodo">
                                                    <option value="0">Seleccione una Período</option>
                                                    <?php foreach ($arrPeriodo as $item) : ?>
                                                        <!-- <option value="<?php echo $item->id_turno_tipo_periodo; ?>" data-diainicio="<?php echo date('d \d\e F', $item->gl_turno_tipo_dia_mes_inicio); ?>" data-diatermino="<?php echo date('d \d\e F', $item->gl_turno_tipo_dia_mes_termino); ?>"> -->
                                                        <option value="<?php echo $item->id_turno_tipo_periodo; ?>" data-diainicio="<?php echo $item->gl_turno_tipo_dia_mes_inicio; ?>" data-diatermino="<?php echo  $item->gl_turno_tipo_dia_mes_termino; ?>">
                                                            <?php echo $item->gl_turno_tipo_periodo; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <label for="id_anyo" class="col-sm-4 col-form-label control-label required-left"><?php echo \Traduce::texto("Año"); ?></label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" id="id_anyo" name="id_anyo">
                                                    <!-- <option value="0">Seleccione una Año</option> -->
                                                    <?php
                                                    foreach ($arrAnyo as $key => $item) : ?>
                                                        <option value="<?php echo $item->id; ?>"><?php echo $item->value; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row  col-sm-12 col-xs-12">
                                <label for="fc_inicio" class="col-sm-4 col-form-label control-label"><?php echo \Traduce::texto("Fecha Inicio"); ?></label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" readonly class="form-control-plaintext" id="fc_inicio" placeholder="La fecha de inicio del Período.">
                                        <!-- <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row col-sm-12 col-xs-12">
                                <label for="fc_termino" class="col-sm-4 col-form-label control-label"><?php echo \Traduce::texto("Fecha Término"); ?></label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" readonly class="form-control-plaintext" id="fc_termino" placeholder="La fecha de término del Período.">
                                        <!-- <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                            <h4>Texto Resolución</h4>

                            <div class="form-group row col-sm-12 col-xs-12">
                                <label for="gl_punto2" class="col-sm-4 col-form-label required-left"><?php echo \Traduce::texto("Punto 2"); ?></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" rows="3" id="gl_punto2" name="gl_punto2">La farmacia de urgencia atenderá público en forma permanente los 365 días del año y durante las 24 horas del día.</textarea>
                                    <span class="help-text">Este texto lo puede modificar. Ejemplo: "La farmacia de urgencia atenderá público en forma permanente los 365 días del año y durante las 24 horas del día."</span>
                                </div>
                            </div>


                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-success" id="ingresar" data-toggle="tooltip" title="Ingresar">
                                <i class="fa fa-save"></i>&nbsp;&nbsp;Ingresar
                            </button>
                            <button type="button" class="btn btn-sm btn-warning" id="cancelar" data-toggle="tooltip" title="Cancelar">
                                <i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar
                            </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</section>