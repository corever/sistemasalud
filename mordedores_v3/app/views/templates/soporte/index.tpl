<div class="row">
    <div class="col-xs-12">
		<section class="content-header">
			<h1><i class="fa fa-life-ring"></i> <span>Mesa de ayuda</span></h1>
		</section>
                    
        <div id="accordion" class="panel">
            <div class="panel-heading margin-remove">
                <a class="btn btn-xs btn-success" style="color: #fff !important;" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
					<i class="fa fa-plus"></i> Nuevo ticket
                </a>
                <div class="clearfix"></div>
            </div>
			
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body well">
				
                    <form  id="form" class="form-horizontal" enctype="application/x-www-form-urlencoded" action="" method="post">
						<input type="text" id="rut" name="rut" class="hidden" value="{$rut}" />

						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Asunto:</label>
							<div class="col-sm-10">
								<input type="text" id="asunto" name="asunto" class="form-control" />
							</div>
							<span class="help-block hidden"></span>
						</div>						
						
                        <div class="form-group">
							<label for="telefono" class="col-sm-2 control-label ">Tel&eacute;fono de Contacto:</label>
							<div class="col-sm-10">
								<input type="text" id="telefono" name="telefono" class="form-control" />
							</div>	
							<span class="help-block hidden"></span>
                        </div>
						
                        <div class="form-group">
                           
                                <label for="email" class="col-sm-2 control-label ">Email de Contacto:</label>
								<div class="col-sm-10">
									<input type="text" id="email" name="email" class="form-control element-search" value="{$email}" />
								</div>	
                                <span class="help-block hidden"></span>
                           
                        </div>

                        <div class="form-group">
							<label for="mensaje" class="col-sm-2 control-label">Mensaje:</label>
							<div class="col-sm-10">
								<textarea  class="form-control" rows="4" id="mensaje" name="mensaje" value=""></textarea>
                            </div>
                        </div>
                        <div class="form-group">
							<label for="mensaje" class="col-sm-2 control-label">&nbsp;</label>
							<div class="col-sm-10">
								<a type="button" id="addfileButton" class="btn btn-xs btn-default" onclick="xModal.open('{$base_url}/Soporte/cargarAdjunto','Cargar Adjunto','',true,'200');">Adjuntar Archivo</a>
                            </div>
							<span class="help-block hidden"></span>
                        </div>						
						

						<div class="form-group">
								<div class="form-group clearfix">
								<div class="col-xs-12" id="listado-adjuntos" name="listado-adjuntos"></div>
                            </div>
						</div>
						
                        <div class="form-group">
							<label for="mensaje" class="col-sm-2 control-label">&nbsp;</label>
							<div class="col-sm-10">
								<button data-rel="" id="guardar" type="button" class="btn btn-success righted">
									<i class=""></i> Enviar
								</button>
                            </div>
							<span class="help-block hidden"></span>
                        </div>												

                    </form>
                </div>
            </div>
        </div>

		{grilla}

    </div>
</div>
