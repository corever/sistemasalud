
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
             <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)">Farmacia</a></li>
               <li class="breadcrumb-item active">Venta de Talonarios</li>
            </ol>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>

<form id="formVentaTalonario" class="form-horizontal">
	<section class="content">
		<div class="card card-primary">
            <div class="card-header"> Venta de Talonarios </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-info"></i> Información :</h4>La búsqueda se puede realizar Tipeando el RUT o el Nombre del Profesional de la Salud
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="id_profesional_medico" class="control-label">Profesional Médico</label>
                    </div>
                    <div class="col-6">
                        <select class="form-control select2" id="id_profesional_medico" name="id_profesional_medico" >
                            <?php if (!isset($arrProfesional) || count((array) $arrProfesional) == 0 || count((array) $arrProfesional) > 1) : ?>
                                <option value="0">Seleccione un Profesional</option>
                            <?php endif; ?>
                            <?php if (isset($arrProfesional) && is_array($arrProfesional)) : foreach ($arrProfesional as $key => $profesional) : ?>
                                    <option value="<?php echo $profesional->mu_id; ?>" <?php echo (isset($arr->id_profesional) && $arr->id_profesional == $profesional->mu_id)?"selected":""; ?> ><?php echo $profesional->mu_rut." - ".$profesional->gl_nombre_completo; ?></option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                </div>
                <div class="row top-spaced">
                    <div class="col-4">
                        <label for="id_talonarios_disponibles" class="control-label required-left"><?php echo \Traduce::texto("Talonarios Disponibles"); ?></label>
                    </div>
                    <div class="col-6">
                        <select class="form-control select2" multiple="multiple" id="id_talonarios_disponibles" name="id_talonarios_disponibles[]" data-placeholder="Seleccione Talonario(s)" >
                            <?php /*if (!isset($arrTalonario) || count((array) $arrTalonario) == 0 || count((array) $arrTalonario) > 1) : ?>
                                <option value="0">Seleccione Talonario(s)</option>
                            <?php endif;*/ ?>
                            <?php if (isset($arrTalonario) && is_array($arrTalonario)) : foreach ($arrTalonario as $key => $talonario) : ?>
                                    <option value="<?php echo $talonario->asignacion_id; ?>" ><?php echo $talonario->gl_talonario; ?></option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                </div>
                <div class="row top-spaced">
                    <div class="col-4">
                        <label class="control-label required-left">¿Es PYME?</label>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <label><input type="radio" class="labelauty" id="chk_es_pyme_0" name="chk_es_pyme" value="0" <?php echo ($arr->chk_genero == "0")?"checked":""; ?> data-labelauty="NO" onclick="VentaTalonario.verificarPyme();" /></label>
                            </div>
                            <div class="col-sm-6">
                                <label><input type="radio" class="labelauty" id="chk_es_pyme_1" name="chk_es_pyme" value="1" <?php echo ($arr->chk_genero == "1")?"checked":""; ?> data-labelauty="SI" onclick="VentaTalonario.verificarPyme();" /></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="div_es_pyme" style="display:none;">
                    <div class="col-4">
                        <label for="btnAdjuntar" class="control-label required-left"><?php echo \Traduce::texto("Adjunto PYME"); ?></label>
                    </div>
                    <div class="col-6">
                        <!-- Include btnAdjuntar y grilla -->
                        <?php include('app/_FuncionesGenerales/Adjuntos/views/btnAdjuntar.php'); ?>
                    </div>
                    <div class="col-10 top-spaced">
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-info"></i> Información :</h4>
                            El arancel total a cobrar para aquellas empresas que, de acuerdo a lo establecido en el articulo segundo de la ley Nº 20.416, acrediten ser <b>microempresas, pequeñas o medianas empresas</b> será de $1.000.
                            <br>- Para verificar dicho beneficio ingrese a link del SII <a href="https://zeus.sii.cl/cvc/stc/stc.html" target="_blank"> https://zeus.sii.cl/cvc/stc/stc.html </a>
                            <br>- Para mayor información, favor contactar con Soporte.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
		<div class="top-spaced" id="div_acciones" align="right">
            <button class="btn btn-success" type="button" onclick="VentaTalonario.guardarVenta($(this.form).serializeArray(), this);"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Guardar"); ?> </button>
            <button class="btn btn-danger" type="button" onclick="window.location='<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Home/Dashboard/';"><i class="fa fa-close"></i> <?php echo \Traduce::texto("Cancelar"); ?> </button>
		</div>
	</section>
</form>
