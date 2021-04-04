<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title" style="width: 100%">
            Expediente {$folio_actividad}
		{php}
			echo Boton::getBotonBitacora($template->getTemplateVars('token_expediente'),$template->getTemplateVars('folio_actividad'));
		{/php}
        </h3>

    </div>

    {if empty($id_visita_estado)}
    <div class="box-body">
        <form id="form-fiscalizacion">
            <input type="hidden" value="1" id="ingresa_datos_visita" name="ingresa_datos_visita">
            <div class="panel-group" id="accordion_fiscalizacion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion_fiscalizacion" href="#fiscalizacion">Fiscalización</a>
                        </h4>
                    </div>
                    <div id="fiscalizacion" class="panel-collapse collapse in">
                        <div class="panel-body">
							<!-- FORMULARIO FISCALIZACION -->
							<div id="datos_fiscalizacion" class="tab-pane fade active in">
								<div class="row form-group">
									<!-- ESTADO -->
									<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
										<label for="id_visita_estado" class="col-sm-12 control-label">Estado Visita (*)</label>
										<div class="col-sm-12" id="id_visita_estado">
											<div class="col-xs-6">
												<input type="radio" name="id_visita_estado"
													data-labelauty='Realizada' data-cant="0" onchange="Regularizar.visitaEstadoBtn(this)" 
													value="2" {if $id_visita_estado == 2} checked="selected"{/if}>
											</div>
											<div class="col-xs-6">
												<input type="radio" name="id_visita_estado"
													data-labelauty='Perdida' data-cant="0" onchange="Regularizar.visitaEstadoBtn(this)" 
													value="1" {if $id_visita_estado == 1} checked="selected"{/if}>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row form-group" id='div_datos_realizada' style="display: none;">
									<!-- ESTADO -->
									<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
										<label for="fecha_inspeccion" class="col-sm-12 control-label">Fecha de Visita (*)</label>
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
											<label for="fecha_inspeccion_perdida" class="col-sm-12 control-label">Fecha de Visita (*)</label>
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
											<label for="id_tipo_perdida" class="col-xs-12 control-label">Motivo (*)</label>
											<div class="col-xs-12">
												<select onchange="Regularizar.visitaPerdidaMotivo(this)" class="form-control" id="id_tipo_perdida" name="id_tipo_perdida">
													<option value="0">Seleccione Motivo</option>
													{foreach $arrTipoPerdida as $item}
														<option value="{$item->id_tipo_visita_perdida}" {if $item->id_tipo_visita_perdida == $mordedor["id_tipo_visita_perdida"]}selected{/if} >{$item->gl_descripcion}</option>
													{/foreach}
												</select>
											</div>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12" id="input_otro_perdida" style="display: none;">
											<label for="gl_otro_perdida" class="col-sm-12 control-label">Otro (*)</label>
											<div class="col-sm-12">
												<input type="text" name="gl_otro_perdida" id="gl_otro_perdida" 
													data-cant="0" class="form-control"
													value='{$gl_otro_perdida}'>
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

								{*
								<!-- Resultado Visita -->
								<div class="col-md-3 col-sm-12">
									<label for="resultado_inspeccion" class="col-sm-12 control-label">Resultado visita</label>
									<div class="col-sm-12" id="resultado_inspeccion">
										<div class="radio"><label>
											<input type="radio" class="resultado_inspeccion" name="resultado_inspeccion" data-cant="0" value="1" {if $resultado_inspeccion == 1} checked="selected"{/if}>No sospechoso
										</label></div>
										<div class="radio"><label>
											<input type="radio" class="resultado_inspeccion" name="resultado_inspeccion" data-cant="0" value="2" {if $resultado_inspeccion == 2} checked="selected"{/if}>Sospechoso
										</label></div>
										<div class="radio"><label>
											<input type="radio" class="resultado_inspeccion" name="resultado_inspeccion" data-cant="0" value="3" {if $resultado_inspeccion == 3} checked="selected"{/if}>Sin Datos
										</label></div>
										<div class="radio"><label>
											<input type="radio" class="resultado_inspeccion" name="resultado_inspeccion" data-cant="0" value="4" {if $resultado_inspeccion == 4} checked="selected"{/if}>Visita Perdida
										</label></div>
									</div>
								</div>
								*}
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {else}
		<div class="box-body" style="display: none;">
			<form id="form-fiscalizacion">
				<input type="hidden" value="0" id="ingresa_datos_visita" name="ingresa_datos_visita">
			</form>
		</div>
    {/if}

    <div class="box-body">
        <form id="form-regularizar">
            <div class="panel-group" id="accordion">
                <input type="hidden" value="{$cantidad_mordedores}" id="cantidad_mordedores" name="cantidad_mordedores">
                <input type="hidden" value="{$folio_actividad}" id="folio_actividad" name="folio_actividad">
                {foreach $mordedores as $mordedor}
                    <input type="hidden" value="{$mordedor['gl_folio_mordedor']}" id="gl_folio_mordedor{$cont}" name="gl_folio_mordedor{$cont}">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#datos_mordedor_{$mordedor['gl_folio_mordedor']}">Mordedor {$mordedor['gl_folio_mordedor']}</a>
                            </h4>
                        </div>
                        <div id="datos_mordedor_{$mordedor['gl_folio_mordedor']}" data-index="{$cont}" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="row">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#mordedor_{$mordedor['gl_folio_mordedor']}">Mordedor</a></li>
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
                    </div>
                    {assign var="cont" value=$cont+1}
                {/foreach}
            </div>
        </form>

        <div class="form-group clearfix  text-right">
            <button type="button" onclick="javascript:$(this).attr('disabled', 'disabled');Regularizar.guardarFiscalizacion(this);" class="btn btn-success">
                <i class="fa fa-save"></i>  Guardar
            </button>
            <button type="button" id="cancelar"  class="btn btn-default"
                    onclick="location.reload()">
                <i class="fa fa-remove"></i>  Cancelar
            </button>
        </div>

    </div>
</div>
