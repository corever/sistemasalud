<link rel="stylesheet" href="{$static}css/labelauty/jquery-labelauty.css"/>

<div class="">
	<form id="form-fiscalizacion-web">
		<div class="box-header">
			<h3 class="box-title" style="width: 100%">
				Expediente {$folio_actividad}
			{php}
				echo Boton::getBotonBitacora($template->getTemplateVars('token_expediente'),$template->getTemplateVars('folio_actividad'));
			{/php}
			</h3>

		</div>

		<div class="box-body">
			<input type="hidden" value="1" id="ingresa_datos_visita" name="ingresa_datos_visita">
			<input type="hidden" value="WEB" id="origen_visita" name="origen_visita">
			<input type="hidden" value="{$id_expediente}" id="id_expediente" name="id_expediente">
			
			<div class="panel-group" id="accordion_fiscalizacion">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
						{* <a data-toggle="collapse" data-parent="#accordion_fiscalizacion" href="#fiscalizacion">Fiscalización</a> *}
						 <span>Fiscalización</span>
						</h4>
					</div>
					<div id="fiscalizacion" class="panel-collapse collapse in">
						<div class="panel-body">
							<!-- FORMULARIO FISCALIZACION -->
							<div id="datos_fiscalizacion" class="tab-pane fade active in">
								<div class="row form-group">
									<!-- ESTADO -->
									<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
										<label for="id_visita_estado" class="col-sm-12 control-label required">Estado Visita</label>
										<div class="col-sm-12" id="id_visita_estado">
											<div class="col-xs-6">
												<input type="radio" name="id_visita_estado"
													data-labelauty='Realizada' data-cant="0" onchange="Visita.visitaEstadoBtn(this)" 
													value="2" {if $id_visita_estado == 2} checked="selected"{/if}>
											</div>
											<div class="col-xs-6">
												<input type="radio" name="id_visita_estado"
													data-labelauty='Perdida' data-cant="0" onchange="Visita.visitaEstadoBtn(this)" 
													value="1" {if $id_visita_estado == 1} checked="selected"{/if}>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row form-group" id='div_datos_realizada'>
									<!-- ESTADO -->
									<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
										<label for="fecha_inspeccion" class="col-sm-12 control-label required">Fecha de Visita</label>
										<div class="col-sm-12">
											<div class="input-group col-xs-12">
												<input type="text" name="fecha_inspeccion" id="fecha_inspeccion" readonly
													data-labelauty='SI' data-cant="0" class="form-control fc_clase"
													value='{$fecha_inspeccion|date_format:"%d/%m/%Y"}'>
												<span class="help-block hidden fa fa-warning"></span>
												<span class="input-group-addon" onClick="$('#fecha_inspeccion').focus();"><i class="fa fa-calendar"></i></span>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row form-group" id='div_datos_perdida' style="display: none;">
									<!-- ESTADO -->
									<div class="row form-group">
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
											<label for="fecha_inspeccion_perdida" class="col-sm-12 control-label required">Fecha de Visita</label>
											<div class="col-sm-12">
												<div class="input-group col-xs-12">
													<input type="text" name="fecha_inspeccion_perdida" id="fecha_inspeccion_perdida" readonly
														data-cant="0" class="form-control fc_clase"
														value='{$fecha_inspeccion|date_format:"%d/%m/%Y"}'>
													<span class="help-block hidden fa fa-warning"></span>
													<span class="input-group-addon" onClick="$('#fecha_inspeccion').focus();"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
											<label for="id_tipo_perdida" class="col-xs-12 control-label required">Motivo</label>
											<div class="col-xs-12">
												<select onchange="Visita.visitaPerdidaMotivo(this)" class="form-control" id="id_tipo_perdida" name="id_tipo_perdida">
													<option value="0">Seleccione Motivo</option>
													{foreach $arrTipoPerdida as $item}
														<option value="{$item->id_tipo_visita_perdida}" {if $item->id_tipo_visita_perdida == $mordedor["id_tipo_visita_perdida"]}selected{/if} >{$item->gl_descripcion}</option>
													{/foreach}
												</select>
											</div>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12" id="input_otro_perdida" style="display: none;">
											<label for="gl_otro_perdida" class="col-sm-12 control-label required">Otro Motivo</label>
											<div class="col-sm-12">
												<input type="text" name="gl_otro_perdida" id="gl_otro_perdida" 
													data-cant="0" class="form-control"
													value='{$gl_otro_perdida}'>
											</div>
										</div>
									</div>
                                    <div class="col-lg-4 col-md-6 col-sm-8 col-xs-12" id="div_volvera_visitar" style="display:none;" >
                                        <label for="bo_volver_a_visitar" class="col-sm-12 control-label required">¿Volverá a visitar?</label>
                                        <div class="col-sm-12" id="bo_volver_a_visitar">
                                            <div class="col-xs-6">
                                                <input type="radio" name="bo_volver_a_visitar"
                                                    data-labelauty='SI'
                                                    value="1" {if $mordedor["bo_volver_a_visitar"] == 1} checked="selected"{/if}>
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="radio" name="bo_volver_a_visitar"
                                                    data-labelauty='NO'
                                                    value="0" {if $mordedor["bo_volver_a_visitar"] == 0} checked="selected"{/if}>
                                            </div>
                                        </div>
                                    </div>
									<div class="row form-group">
										<div class="col-lg-12 col-xs-12">
											<label for="gl_observacion_perdida" class="col-lg-12 col-xs-12 control-label">Observaci&oacute;n</label>
											<div class="col-lg-6 col-sm-12">
												<textarea class="form-control" rows="4" name="gl_observacion_perdida" id="gl_observacion_perdida" placeholder="Observaci&oacute;n">{$gl_observacion_perdida}</textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="box-body">
			<input type="hidden" value="{$cantidad_mordedores}" id="cantidad_mordedores" name="cantidad_mordedores">
			<input type="hidden" value="{$folio_actividad}" id="folio_actividad" name="folio_actividad">
			
			<div id="div_mordedores">
				{foreach $mordedores as $mordedor}
					<div class="panel-group" id="accordion_{$mordedor['gl_folio_mordedor']}">
						<input type="hidden" value="{$mordedor['gl_folio_mordedor']}" id="gl_folio_mordedor{$cont}" name="gl_folio_mordedor{$cont}">

						<div class="panel panel-default">
							<div class="box-header">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion_{$mordedor['gl_folio_mordedor']}" href="#datos_mordedor_{$mordedor['gl_folio_mordedor']}">Datos Mordedor {$mordedor['gl_folio_mordedor']}</a>
								</h4>
							</div>
							{*
							<div id="datos_mordedor_{$mordedor['gl_folio_mordedor']}" data-index="{$cont}" class="panel-collapse collapse in">
								<div class="panel-body">
									<div class="row">
										<ul class="nav nav-tabs">
											<li class="active"><a data-toggle="tab" href="#mordedor_{$mordedor['gl_folio_mordedor']}">Datos Mordedor</a></li>
											<li><a data-toggle="tab" href="#propietario{$cont}">Propietario</a></li>
										</ul>
										<div class="tab-content">
											<!-- FORMULARIO MORDEDOR -->
											{include './formulario_mordedor.tpl'}
											<!-- FORMULARIO PROPIETARIO -->
											{include './formulario_propietario.tpl'}
										</div>
									</div>
								</div>
							</div>
							*}
							<div class="row panel-collapse collapse in" id="datos_mordedor_{$mordedor['gl_folio_mordedor']}" data-index="{$cont}">
								{include './formulario_mordedor.tpl'}
							</div>
						</div>
						{assign var="cont" value=$cont+1}
					</div>
				{/foreach}
			</div>

			<div class="form-group clearfix  text-right">
				<button type="button" onclick="javascript:$(this).attr('disabled', 'disabled');Visita.guardarFiscalizacion(this);" class="btn btn-success">
					<i class="fa fa-save"></i>  Guardar
				</button>
				<button type="button" id="cancelar"  class="btn btn-default"
						onclick="location.reload()">
					<i class="fa fa-remove"></i>  Cancelar
				</button>
			</div>

		</div>
	</form>
</div>