<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>
<link rel="stylesheet" href="{$static}css/labelauty/jquery-labelauty.css"/>

<section class="content-header">
    <h1><i class="fa fa-bug"></i>&nbsp; Regularizar </h1>
</section>

<section class="content" id="contenedor-buscar">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title" style="width: 100%">
				Seleccione origen de datos a Regularizar
			</h3>
		</div>
		<div class="box-body">
		
			<form id="form" action="#" method="post" class="form-horizontal">
				<!-- FILTROS DE REGULARIZACION -->
				<div class="form-group">
					<div class="col-lg-4 col-md-3 col-sm-2"></div>
					<div class="col-lg-4 col-md-6 col-sm-8">
						<label class="radio-inline">
							<input type="radio" name="origen" value="codigo" checked>Código Bichito
						</label>

						<label class="radio-inline">
							<input type="radio" name="origen" value="adjunto">Archivos de Respaldo
						</label>

					</div>
					<div class="col-lg-4 col-md-3 col-sm-2"></div>
				</div>
				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="row" style="margin-top: 10px;">
						<!-- CÓDIGO -->
						<div id="div_input_codigo">
							<div class="col-lg-4 col-xs-2"></div>
							<div class="col-lg-4 col-xs-8">
								<label for="input_codigo" class="col-md-4 col-xs-6 control-label" style="text-align: left;">Ingrese código</label>
								<div class="col-md-4 col-xs-6">
									<input type="text" id="input_codigo" name="input_codigo" value="" class="form-control" placeholder="Código">
								</div>
								<span class="help-block hidden fa fa-warning"></span>
							</div>
							<div class="col-lg-4 col-xs-2"></div>
						</div>
						<!-- RESPALDO -->
						<div id="div_input_adjunto" style="display: none;">
							<div class="col-lg-4 col-sm-4"></div>

							<div class="col-lg-4 col-sm-4">
								<div class="form-group">
									<label for="archivo_adjunto" class="col-sm-12 col-md-3 control-label" style="text-align: left;"></label>
									<div class="col-xs-12 col-md-9">
										<input type="file" id="archivo_adjunto" name="archivo_adjunto" class="forma-control" onchange="Regularizar.habilitarBtnSubir()">
									</div>
									<span class="help-block hidden fa fa-warning"></span>
								</div>
							</div>

							<div class="col-lg-4 col-sm-4"></div>
						</div>
					</div>
				</div>
				
				<!-- BOTONES -->
				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-12">
						<label class="control-label col-sm-4">&nbsp;</label>
						<div class="col-sm-8" align="right">
							<button type="button" id="buscar" class="btn btn-sm btn-info" onclick="Regularizar.buscar(this)">
								<i class="fa fa-search"></i>  Buscar
							</button>
							<button type="button" id="subir" class="btn btn-sm btn-info" style="display: none;" disabled onclick="Regularizar.leerAdjunto(this)">
								<i class="fa fa-upload"></i>  Cargar Adjunto
							</button>
							<button type="button" id="btn_limpia_filtros" class="btn btn-sm bg-purple" onclick="Regularizar.limpiarDatos(this)">
								<i class="fa fa-mail-reply"></i>  Limpiar Datos
							</button>
						</div>
					</div>
				</div>
			
			</form>
		</div>
	</div>

    <div class="table-responsive top-spaced" id="contenedor-archivo-adjunto" style="display: none;">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title" style="width: 100%">
                    Archivo a procesar:
                </h3>
            </div>
            <div class="box-body">
                <div class="col-lg-12 col-sm-12 pull-right"></div>
                <div class="col-lg-2 col-sm-12">
                </div>
                <div class="col-lg-8 col-sm-12">
                    <table class="table table-hover table-responsive table-striped table-bordered no-footer" id="tabla-respaldos">
                        <thead>
                            <tr role="row">
                                <th width="10%">Nombre archivo</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody id="body-respaldo">
                            <tr id='respaldoNodata' data-info='nodata'><td class='text-center' colspan='2' data-datos='nodatos'> No hay respaldos para mostrar</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-2 col-sm-12"></div>
            </div>
        </div>
    </div>

    <div class="table-responsive top-spaced" id="contenedor-fiscalizacion-tabla" style="display: none;"></div>
    
</section>

<section class="content" id="contenedor-expediente" style="display: none;">
    <div class="table-responsive top-spaced" id="contenedor-formulario-expediente"></div>
</section>