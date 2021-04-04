<div class="top-spaced"></div>
<div id="mordedor_{$mordedor['gl_folio_mordedor']}">
	
	<input type="hidden" value="0" id="id_mordedor{$cont}" name="id_mordedor{$cont}">

	<div class="row" id='div_se_niega_visita'>
		<div class="top-spaced"></div>
		<!-- ESTADO -->
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<label for="bo_se_niega_visita" class="col-sm-12 control-label required">¿Se niega a visita?</label>
			<div class="col-sm-12" id="bo_se_niega_visita">
				<div class="col-xs-6">
					<input type="radio" name="bo_se_niega_visita{$cont}"
						data-labelauty='SI' data-cant="{$cont}" onchange="Visita.niegaVisitaBtn(this)" 
						value="1">
				</div>
				<div class="col-xs-6">
					<input type="radio" name="bo_se_niega_visita{$cont}"
						data-labelauty='NO' data-cant="{$cont}" onchange="Visita.niegaVisitaBtn(this)" 
						value="0" checked>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row" id='div_sumario_{$cont}' style="display: none;">
		<div class="top-spaced"></div>
		<!-- SUMARIO -->
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<label for="bo_inicia_sumario" class="col-sm-12 control-label required">¿Se inicia Sumario?</label>
			<div class="col-sm-12" id="bo_inicia_sumario">
				<div class="col-xs-6">
					<input type="radio" name="bo_inicia_sumario{$cont}"
						data-labelauty='SI' data-cant="{$cont}" onchange="Visita.iniciaSumarioBtn(this)" 
						value="1" {if $mordedor["bo_inicia_sumario"] == 1} checked="selected"{/if}>
				</div>
				<div class="col-xs-6">
					<input type="radio" name="bo_inicia_sumario{$cont}"
						data-labelauty='NO' data-cant="{$cont}" onchange="Visita.iniciaSumarioBtn(this)" 
						value="0" {if $mordedor["bo_inicia_sumario"] == 0} checked="selected"{/if}>
				</div>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-lg-12 col-xs-12">
				<label for="gl_observacion_sumario" class="col-lg-12 col-xs-12 control-label required">Observaci&oacute;n</label>
				<div class="col-lg-6 col-sm-12">
					<textarea class="form-control" rows="4" name="gl_observacion_sumario_{$cont}" id="gl_observacion_sumario_{$cont}" placeholder="Observaci&oacute;n">{$mordedor["gl_observacion_sumario"]}</textarea>
				</div>
			</div>
		</div>
		<div class="row form-group" id="descargos_{$cont}" style="display: none;">
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
				<label for="fecha_descargos" class="col-sm-12 control-label required">Fecha de Descargos</label>
				<div class="col-sm-12">
					<div class="input-group col-xs-12">
						<input type="text" name="fecha_descargos_{$cont}" id="fecha_descargos_{$cont}" readonly
							data-cant="0" class="form-control fc_clase"
							value='{$fecha_descargos|date_format:"%d/%m/%Y"}'>
						<span class="help-block hidden fa fa-warning"></span>
						<span class="input-group-addon" onClick="$('#fecha_descargos_{$cont}').focus();"><i class="fa fa-calendar"></i></span>
					</div>
				</div>
			</div>
			<!-- CERTIFICADO SUMARIO -->
			<div class="col-lg-8 col-md-6 col-sm-12">
				<label for="certificado_microchip{$cont}" class="col-sm-12 col-md-12 control-label required">Acta</label>
				<div class="col-sm-4">
					<button type="button" id="btnAdjuntoMicrochip{$cont}" class="btn btn-sm btn-success"
							onclick="xModal.open('{$smarty.const.BASE_URI}/Regularizar/adjuntar/?id_tipo_adjunto=8&cont_mordedor={$cont}', 'Agregar Adjunto Sumario',45);" >
						<i class="fa fa-plus-circle" aria-hidden="true"></i> Adjuntar Acta
					</button>
				</div>
			</div>
			<div class="col-lg-8 col-md-6 col-sm-12">
				<div class="col-md-8">
					<div class="col-sm-12" id="grilla-adjunto8-{$cont}">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="div_mordedor_{$cont}">
		<div class="top-spaced"></div>
		<div class="row">
			<!-- ESTADO -->
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
				<label for="id_animal_estado" class="col-sm-12 control-label required">Estado Animal al momento de la Visita</label>
				<div class="col-sm-12" id="id_animal_estado">
					<div class="col-xs-6">
						<input type="radio" class="id_animal_estado{$cont}" name="id_animal_estado{$cont}"
							data-labelauty='Vivo' data-cant="{$cont}" onchange="Visita.estadoAnimalBtn(this)"
							value="1" checked="selected">
					</div>
					<div class="col-xs-6">
						<input type="radio" class="id_animal_estado{$cont}" name="id_animal_estado{$cont}"
							data-labelauty='Muerto' data-cant="{$cont}" onchange="Visita.estadoAnimalBtn(this)"
							value="2">
					</div>
				</div>
			</div>
		</div>

		<div id="div_motivo_muerte_mordedor{$cont}" name="div_motivo_muerte_mordedor{$cont}" style="display:none;">
			<div class="row">
				<!-- MOTIVO MUERTE -->
				<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
					<label for="gl_motivo_muerte" class="col-sm-12 control-label required">Motivo de Muerte</label>
					<div class="col-sm-12" id="gl_motivo_muerte">
						<div class="col-xs-6">
							<input type="radio" class="gl_motivo_muerte{$cont}" name="gl_motivo_muerte{$cont}"
								data-labelauty='Sospecha de rabia' data-cant="{$cont}" onchange="Visita.motivoMuerteBtn(this)"
								value="1" {if $mordedor["gl_motivo_muerte"] == 1} checked="selected"{/if}>
						</div>
						<div class="col-xs-6">
							<input type="radio" class="gl_motivo_muerte{$cont}" name="gl_motivo_muerte{$cont}"
								data-labelauty='No sospecha de rabia' data-cant="{$cont}" onchange="Visita.motivoMuerteBtn(this)"
								value="0" {if $mordedor["gl_motivo_muerte"] == 2} checked="selected"{/if}>
						</div>
					</div>
				</div>
			</div>
			<div id="div_motivo_muerte_mordedor_otro{$cont}" name="div_motivo_muerte_mordedor_otro{$cont}" style="display:none;">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<label for="gl_descripcion_muerte{$cont}" class="col-sm-12 col-md-12 control-label">Descripción</label>
						<div class="col-sm-12 col-md-12">
							<textarea name="gl_descripcion_muerte{$cont}" rows="6" id="gl_descripcion_muerte{$cont}" placeholder="Ingrese descripción" class="form-control">{$mordedor["gl_apariencia"]}</textarea>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="div_microchip_mordedor{$cont}" name="div_microchip_mordedor{$cont}">
			<!-- MICRO CHIP -->
			<hr>
			<div class="row">
				<!-- MICROCHIP PREVIAMENTE INSTALADO -->
				<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
					<label class="col-sm-12 col-md-12 control-label">¿Animal tiene microchip previamente instalado?</label>
					<div class="col-sm-12" id="bo_microchipInstalado{$cont}">
                        <div class="col-xs-6">
                            <input type="radio" class="bo_microchipInstalado{$cont}" name="bo_microchipInstalado{$cont}"
                                data-labelauty='SI' data-cant="{$cont}" onchange="Visita.tieneMicrochipInstalado({$cont})" 
                                value="1">
                        </div>
                        <div class="col-xs-6">
                            <input type="radio" class="bo_microchipInstalado{$cont}" name="bo_microchipInstalado{$cont}"
                                data-labelauty='NO' data-cant="{$cont}" onchange="Visita.tieneMicrochipInstalado({$cont})" 
                                value="0" checked>
                        </div>
                    </div>
				</div>
				<!-- INSTALADOR MICROCHIP -->
				<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6" id="div_instalador_microchip{$cont}" style="display:{if $mordedor["instalador_microchip"] == ""}none;{/if}">
					<label for="gl_microchip{$cont}" class="col-sm-12 col-md-12 control-label">¿Quién instaló el microchip?</label>
					<div class="col-sm-12 col-md-12">
						<select for="instalador_microchip{$cont}" class="form-control" id="instalador_microchip{$cont}" name="instalador_microchip{$cont}"
                                onchange="Visita.cambioInstaladorMicrochip(this.value,{$cont});" >
                            <option value="0">Seleccione</option>
                            {foreach $arrInstaladorMicrochip as $item}
                                <option value="{$item->id_instalador_microchip}" {if $item->id_instalador_microchip == $mordedor["instalador_microchip"]}selected{/if}>{$item->gl_nombre}</option>
                            {/foreach}
                        </select>
					</div>
				</div>
				<!-- OTRO INSTALADOR MICROCHIP -->
				<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6" id="div_otro_instalador_microchip{$cont}" style="display:{if $mordedor["gl_otro_instalador_microchip"] == ""}none;{/if}">
					<label for="gl_otro_instalador_microchip{$cont}" class="col-sm-12 col-md-12 control-label">Otro Instalador Microchip</label>
					<div class="col-sm-12 col-md-12">
						<input type="text" name="gl_otro_instalador_microchip{$cont}" id="gl_otro_instalador_microchip{$cont}"
                               placeholder="Otro Instalador de Microchip" class="form-control" value='{$mordedor["gl_otro_instalador_microchip"]}'>
					</div>
				</div>
            </div>
            <div class="row">
				<!-- NÚMERO MICRO CHIP -->
				<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
					<label for="gl_microchip{$cont}" class="col-sm-12 col-md-12 control-label required">Número de Microchip</label>
					<div class="col-sm-12 col-md-12">
						<input data-cant="{$cont}" type="text" name="gl_microchip{$cont}" id="gl_microchip{$cont}" onchange="Visita.buscarMicrochip({$cont});"
                               placeholder="Número de Microchip" class="form-control" value='{$mordedor["gl_microchip"]}'>
					</div>
				</div>
				<!-- FECHA MICRO CHIP -->
				<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
					<label for="fc_microchip{$cont}" class="col-sm-12 col-md-12 control-label">Fecha de Microchip</label>
					<div class="col-sm-12 col-md-12">
						<div class="input-group">
							<input for="fc_microchip{$cont}" type='text' class="form-control"
								data-cant="{$cont}" id='fc_microchip{$cont}' name='fc_microchip{$cont}'
								value='{if $mordedor["fc_microchip"] != ""}{$mordedor["fc_microchip"]|date_format:"%d/%m/%Y"}{else}{$smarty.now|date_format:"%d/%m/%Y"}{/if}' readonly>
							<span class="help-block hidden fa fa-warning"></span>
							<span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fc_microchip{$cont}').focus();"></i></span>

						</div>
					</div>
				</div>
			
				<!-- CERTIFICADO MICRO CHIP -->
				<div class="col-lg-8 col-md-6 col-sm-12">
					<label for="certificado_microchip{$cont}" class="col-sm-12 col-md-12 control-label required">
                        Certificado Microchip&nbsp;
                        <i class="fa fa-question-circle" title="Puede sacar foto al lector o al certificado"></i>
                    </label>
                    
					<div class="col-sm-4">	
						<button type="button" id="btnAdjuntoMicrochip" class="btn btn-sm btn-success"
								onclick="xModal.open('{$smarty.const.BASE_URI}/Informar/adjuntar/?id_tipo_adjunto=5&cont_mordedor={$cont}', 'Agregar Adjunto Microchip', 45);" >
							<i class="fa fa-plus-circle" aria-hidden="true"></i> Adjuntar Certificado
						</button>
					</div>
					<div class="col-sm-8">
						<div class="col-sm-8" id="grilla-adjunto5-{$cont}">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="div_informacion_mordedor{$cont}" name="div_informacion_mordedor{$cont}">	
			<hr>
			<div class="row form-group">
				<!-- ESPECIE -->
				<div class="col-lg-3 col-md-4 col-sm-6">
					<label for="id_animal_especie{$cont}" class="col-sm-12 col-md-12 control-label required">Especie</label>
					<div class="col-sm-12 col-md-12">
						<select for="id_animal_especie{$cont}" class="form-control" id="id_animal_especie{$cont}" name="id_animal_especie{$cont}" onchange="base_animal.cargarRazaporEspecie(this.value, 'id_animal_raza{$cont}', {$mordedor['id_animal_especie']})">
							<option value="0">Seleccione una especie</option>
								{foreach $arrAnimalEspecie as $item}
									<option value="{$item->id_animal_especie}" {if $item->id_animal_especie == $mordedor["id_animal_especie"]}selected{/if} >{$item->gl_nombre}</option>
								{/foreach}
						</select>
					</div>
				</div>
				<!-- RAZA -->
				<div class="col-lg-3 col-md-4 col-sm-6">
					<label for="id_animal_raza{$cont}" class="col-sm-12 col-md-12 control-label">Raza</label>
					<div class="col-sm-12 col-md-12">
						<select for="id_animal_raza{$cont}" class="form-control" id="id_animal_raza{$cont}" name="id_animal_raza{$cont}">
							<option value="0">Seleccione una raza</option>
							{foreach $mordedor["arr_razas"] as $item}
								<option value="{$item->id_animal_raza}" {if $item->id_animal_raza == $mordedor["id_animal_raza"]}selected{/if} >{$item->gl_nombre}</option>
							{/foreach}
						</select>
					</div>
				</div>
				<!-- NOMBRE -->
				<div class="col-lg-3 col-md-4 col-sm-6">
					<label for="nombre_mordedor{$cont}" class="col-sm-12 col-md-12 control-label">Nombre Mordedor</label>
					<div class="col-sm-12 col-md-12">
						<input type="text" name="nombre_mordedor{$cont}" id="nombre_mordedor{$cont}" placeholder="Nombre mordedor" class="form-control" value='{$mordedor["nombre_animal"]}'>
					</div>
				</div>
				<!-- COLOR -->
				<div class="col-lg-3 col-md-4 col-sm-6">
					<label for="gl_color_animal{$cont}" class="col-sm-12 col-md-12 control-label">Color</label>
					<div class="col-sm-12 col-md-12">
						<input type="text" name="gl_color_animal{$cont}" id="gl_color_animal{$cont}" placeholder="Color mordedor" class="form-control" value='{$mordedor["gl_color_animal"]}'>
					</div>
				</div>
			</div>
			
			<div class="row form-group">
				<!-- TAMAÑO -->
				<div class="col-lg-3 col-md-4 col-sm-6">
					<label for="id_animal_tamano{$cont}" class="col-sm-12 col-md-12 control-label">Tamaño</label>
					<div class="col-sm-12 col-md-12">
						<select class="form-control" id="id_animal_tamano{$cont}" name="id_animal_tamano{$cont}">
							<option value="0">Seleccione</option>
							{foreach $arrAnimalTamano as $item}
								<option value="{$item->id_animal_tamano}" {if $item->id_animal_tamano == $mordedor["id_animal_tamano"]}selected{/if}>{$item->gl_nombre}</option>
							{/foreach}
						</select>
					</div>
				</div>
				<!-- EDAD (AÑOS) -->
				<div class="col-lg-3 col-md-4 col-sm-6">
					<label for="nr_edad{$cont}" class="col-sm-12 col-md-12 control-label">Edad (años)</label>
					<div class="col-sm-12 col-md-12">
						<input type="text" name="nr_edad{$cont}" id="nr_edad{$cont}" placeholder="Edad mordedor" class="form-control" value='{$mordedor["nr_edad"]}' onchange='Visita.cambiaEdad({$cont});'>
					</div>
				</div>
				<!-- EDAD (MESES) -->
				<div class="col-lg-3 col-md-4 col-sm-6">
					<label for="nr_edad_meses{$cont}" class="col-sm-12 col-md-12 control-label">Edad (meses)</label>
					<div class="col-sm-12 col-md-12">
						<input type="text" name="nr_edad_meses{$cont}" id="nr_edad_meses{$cont}" placeholder="Edad (meses) mordedor" class="form-control" value='{$mordedor["nr_edad_meses"]}' onchange='Visita.cambiaEdad({$cont});'>
					</div>
				</div>
				<!-- PESO -->
				<div class="col-lg-3 col-md-4 col-sm-6">
					<label for="nr_peso{$cont}" class="col-sm-12 col-md-12 control-label">Peso (kilos)</label>
					<div class="col-sm-12 col-md-12">
						<input type="text" name="nr_peso{$cont}" id="nr_peso{$cont}" placeholder="Peso mordedor" class="form-control" value='{$mordedor["nr_peso"]}'>
					</div>
				</div>
			</div>
			
			<div class="row form-group">
				<!-- DESCRIPCIÓN -->
				<div class="col-md-6 col-sm-12">
					<label for="gl_apariencia{$cont}" class="col-sm-12 col-md-12 control-label">Descripción</label>
					<div class="col-sm-12 col-md-12">
						<textarea name="gl_apariencia{$cont}" rows="6" id="gl_apariencia{$cont}" placeholder="Descripción mordedor" class="form-control">{$mordedor["gl_apariencia"]}</textarea>
					</div>
				</div>
				<!-- SEXO -->
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<label for="id_animal_sexo" class="col-sm-12 control-label">Sexo</label>
					<div class="col-sm-12" id="id_animal_sexo">
						<input type="radio" class="id_animal_sexo{$cont}" name="id_animal_sexo{$cont}" 
							data-labelauty='Macho' data-cant="{$cont}" value="1" {if $mordedor["id_animal_sexo"] == 1} checked="selected"{/if}>
						<input type="radio" class="id_animal_sexo{$cont}" name="id_animal_sexo{$cont}"
							data-labelauty='Hembra' data-cant="{$cont}" value="0" {if $mordedor["id_animal_sexo"] == 2} checked="selected"{/if}>
						<input type="radio" class="id_animal_sexo{$cont}" name="id_animal_sexo{$cont}"
							data-labelauty='No identificado' data-cant="{$cont}" value="0" {if $mordedor["id_animal_sexo"] == 3} checked="selected"{/if}>
					</div>
				</div>
				<!-- ESTADO REPRODUCTIVO -->
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<label for="estado_reproductivo{$cont}" class="col-sm-12 control-label">Estado reproductivo </label>
					<div class="col-sm-12" id="estado_reproductivo{$cont}">
						{foreach $arrEstadoReproductivo as $item}
							<input type="radio" class="id_estado_productivo{$cont}" name="id_estado_productivo{$cont}" 
							data-labelauty='{$item->gl_nombre}' data-cant="{$cont}" value="{$item->id_estado_productivo}" {if $mordedor["id_estado_productivo"] == $item->id_estado_productivo } checked="selected"{/if}>
						{/foreach}
					</div>
				</div>
			</div>
		</div>

		<div id="div_direccon_mordedor{$cont}" name="div_direccon_mordedor{$cont}">
			<div class="row">
				<hr>
				<!-- DIRECCIÓN -->
				<div id="div_direccon_mordedor" name="div_direccon_mordedor">
					<div class="row form-group">
						<!-- REGION -->
						<div class="col-lg-3 col-md-4 col-sm-6">
							<label for="id_region_animal{$cont}" class="col-sm-12 col-md-12 control-label required">Región</label>
							<div class="col-sm-12 col-md-12">
								<select for="id_region_animal{$cont}" class="form-control" id="id_region_animal{$cont}" name="id_region_animal{$cont}" onchange="Region.cargarComunasPorRegion(this.value, 'id_comuna_animal{$cont}', {$mordedor['id_comuna_animal']})">
									<option value="0">Seleccione una Región</option>
									{foreach $arrRegiones as $item}
										<option value="{$item->id_region}" id="{$item->gl_latitud}" name="{$item->gl_longitud}"
											{if $item->id_region == $mordedor["id_region_animal"]}selected{/if}>{$item->gl_nombre_region}</option>
									{/foreach}
								</select>
							</div>
						</div>

						<!-- COMUNA -->
						<div class="col-lg-3 col-md-4 col-sm-6">
							<input type="hidden" value='{$mordedor["id_comuna_animal"]}' id="id_comuna_animal_respaldo{$cont}">
							<label for="id_comuna_animal{$cont}" class="col-sm-12 col-md-12 control-label required">Comuna</label>
							<div class="col-sm-12 col-md-12">
								<select for="id_comuna_animal{$cont}" class="form-control" id="id_comuna_animal{$cont}" name="id_comuna_animal{$cont}">
									<option value="0">Seleccione una Comuna</option>
									{foreach $mordedor["arr_comunas"] as $item}
										<option value="{$item->id_comuna}" id="{$item->gl_latitud_comuna}" name="{$item->gl_longitud_comuna}"
											{if $item->id_comuna == $mordedor["id_comuna_animal"]}selected{/if}>{$item->gl_nombre_comuna}</option>
									{/foreach}
								</select>
							</div>
						</div>

						<!-- DIRECCIÓN -->
						<div class="col-lg-3 col-md-4 col-sm-12">
							<label for="gl_direccion_mordedor{$cont}" class="col-sm-12 col-md-12 control-label required">Dirección</label>
							<div class="col-sm-12 col-md-12">
								<input type="text" name="gl_direccion_mordedor{$cont}" id="gl_direccion_mordedor{$cont}" placeholder="Dirección Mordedor" class="form-control" value='{$mordedor["gl_direccion"]}'>
							</div>
						</div>

						<!-- REFERENCIA -->
						<div class="col-lg-3 col-md-12">
							<label for="gl_referencias_animal{$cont}" class="col-sm-12 col-md-12 control-label">Referencias</label>
							<div class="col-sm-12 col-md-12">
								<input type="text" name="gl_referencias_animal{$cont}" id="gl_referencias_animal{$cont}" placeholder="Referencia dirección" class="form-control" value='{$mordedor["gl_referencias_animal"]}'>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<hr>
				<div class="row form-group">
					<!-- SINTOMATOLOGÍA -->
					<div class="row form-group">
						<!-- SINTOMATOLOGÍA -->
						<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
							<label for="bo_sintomas_rabia" class="col-md-12 control-label required">Sintomatología</label>
							<div class="col-sm-12" id="bo_sintomas_rabia">
								<div class="col-xs-6">
									<input type="radio" class="bo_sintomas_rabia{$cont}" name="bo_sintomas_rabia{$cont}" 
										onchange="Visita.sintomatologiaRadioBtn(this)" data-cant="{$cont}"
										data-labelauty='SI' value="1" >
								</div>
								<div class="col-xs-6">
									<input type="radio" class="bo_sintomas_rabia{$cont}" name="bo_sintomas_rabia{$cont}"
										onchange="Visita.sintomatologiaRadioBtn(this)" data-cant="{$cont}"
										data-labelauty='NO' value="0"checked="selected">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row form-group sintoma_si{$cont}" style="display: none;">
					<!-- SÍNTOMAS -->
					<div class="row">
						<div class="col-sm-12">
							<label for="sintomas{$cont}" class="col-sm-12 control-label required">Selecione el o los Síntomas</label>
							<div class="col-sm-12" id="sintomas{$cont}">
								{foreach $arrSintomas as $item}
									<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
										<input type="checkbox" name="chk-sintomas{$cont}[]" data-labelauty="{$item->gl_nombre}|{$item->gl_nombre}" data-cant="{$cont}" value="{$item->id_tipo_sintoma}" 
											{foreach $mordedor["tipos_sintoma"] as $sintoma}
												{if $sintoma["id"] == $item->id_tipo_sintoma} checked="selected"{/if}
											{/foreach}>
									</div>
								{/foreach}
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="top-spaced"></div>
						<!-- DESCRIPCIÓN -->
						<div class="col-md-6 col-xs-12">
							<div class="col-lg-12">
								<label for="gl_descripcion{$cont}" class="col-sm-12 col-md-12 control-label">Describa síntomas</label>
								<div class="col-sm-12">
									<textarea name="gl_descripcion{$cont}" rows="6" id="gl_descripcion{$cont}" placeholder="Descripción síntomas" class="form-control">{$mordedor["gl_descripcion"]}</textarea>
								</div>
							</div>
						</div>

						<!--EUTANASIA -->
						<div class="col-md-6 col-xs-12">
							<!-- FECHA EUTANASIA -->
							<div class="col-lg-4 col-md-6 col-sm-6">
								<label for="fc_eutanasia{$cont}" id="lbl_fecha_eutanasia{$cont}" class="col-sm-12 col-md-12 control-label">Fecha Eutanasia</label>
								<div class="col-sm-12 col-md-12">
									<div class="input-group">
										<input for="fc_eutanasia{$cont}" type='text' class="form-control fc_clase" id='fc_eutanasia{$cont}' name='fc_eutanasia{$cont}'
												value='{$mordedor["fc_eutanasia"]|date_format:"%d/%m/%Y"}' readonly>
										<span class="help-block hidden fa fa-warning"></span>
										<span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fc_eutanasia{$cont}').focus();"></i></span>
									</div>
								</div>
							</div>
							<!-- CERTIFICADO EUTANASIA -->
							<div class="col-lg-4 col-md-6 col-sm-6">
								<label for="certificado_eutansia{$cont}" id="lbl_certificado_eutanasia{$cont}" class="col-sm-12 col-md-12 control-label">Certificado Eutanasia</label>
								<div class="col-sm-12">	
									<button type="button" id="btnAdjuntoEutanasia" class="btn btn-sm btn-success"
											onclick="xModal.open('{$smarty.const.BASE_URI}/Informar/adjuntar/?id_tipo_adjunto=3&cont_mordedor={$cont}', 'Agregar Adjunto Eutanasia', 45);" >
										<i class="fa fa-plus-circle" aria-hidden="true"></i> Adjuntar Certificado
									</button>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="col-md-12" id="grilla-adjunto3-{$cont}">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row sintoma_no{$cont}">
				<hr>
				<div class="row form-group">
					<!-- QUIÉN PROPORCIONA LA VACUNA -->
					<div class="col-lg-3 col-md-4 col-sm-6">
						<label for="bo_antirrabica_vigente{$cont}" class="col-sm-12 col-md-12 control-label required">
                            Al momento de la visita&nbsp;
                            <i class="fa fa-question-circle" title='La opción "Pendiente por motivos médicos" solo es aplicable en casos en que el diagnóstico no sea compatible con un cuadro de rabia.'></i>
                        </label>
						<div class="col-sm-12 col-md-12">
							<select for="bo_antirrabica_vigente{$cont}" class="form-control" id="bo_antirrabica_vigente{$cont}" name="bo_antirrabica_vigente{$cont}"
                                    onchange="Visita.cambioVacunaVigencia(this.value,{$cont});" >
								<option value="-1">Seleccionar</option>
                                {foreach $arrVacunaVigencia as $item}
                                    <option value="{$item->id_tablet}" id="" name="vigencia{$cont}"
                                            {if $item->id_tablet == $mordedor["bo_antirrabica_vigente"]}selected{/if}>{$item->gl_nombre}</option>
                                {/foreach}
							</select>
						</div>
					</div>
                    <!-- OTRO VIGENCIA VACUNA -->
					<div class="col-lg-3 col-md-4 col-sm-6" id="div_otro_vigencia{$cont}" style="display:{if $mordedor["vacunas"][0]["gl_otro_vigencia"] == ""}none;{/if}">
						<label for="gl_otro_vigencia{$cont}" class="col-sm-12 col-md-12 control-label required">Otra Motivo de Pendiente</label>
						<div class="col-sm-12 col-md-12">
							<input type="text" name="gl_otro_vigencia{$cont}" id="gl_otro_vigencia{$cont}"
                                   placeholder="Ingrese Otra Vigencia" class="form-control" value='{$mordedor["vacunas"][0]["gl_otro_vigencia"]}'>
						</div>
					</div>
                    <div id='div_preguntas_vacuna_pt1{$cont}'>
                        <!-- LABORATORIO -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <label for="id_laboratorio{$cont}" class="col-sm-12 col-md-12 control-label required">Laboratorio</label>
                            <div class="col-sm-12 col-md-12">
                                <select for="id_laboratorio{$cont}" class="form-control" id="id_laboratorio{$cont}" name="id_laboratorio{$cont}" 
                                    onchange="Visita.mostrar_divOtroLaboratorio(this.value,{$cont});base_animal.cargarVacunasPorLaboratorio(this.value, 'id_medicamento{$cont}', {$mordedor['vacunas'][0]['id_medicamento']})">
                                    <option value="0">Seleccione un Laboratorio</option>
                                    {foreach $arrLaboratorios as $item}
                                        <option value="{$item->id_vacuna_laboratorio}" id="" name="{$item->id_vacuna_laboratorio}_{$cont}"
                                                {if $item->id_vacuna_laboratorio == $mordedor["vacunas"][0]["id_laboratorio"]}selected{/if}>{$item->gl_nombre_laboratorio}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <!-- OTRO NOMBRE LABORATORIO -->
                        <div class="col-lg-3 col-md-4 col-sm-6" id="div_laboratorio_otro{$cont}" style="display:{if $mordedor["vacunas"][0]["gl_laboratorio_otro"] == ""}none;{/if}">
                            <label for="gl_laboratorio_otro{$cont}" class="col-sm-12 col-md-12 control-label required">Otro Laboratorio</label>
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="gl_laboratorio_otro{$cont}" id="gl_laboratorio_otro{$cont}"
                                       placeholder="Ingrese Otro Laboratorio" class="form-control" value='{$mordedor["vacunas"][0]["gl_laboratorio_otro"]}'>
                            </div>
                        </div>
                        <!-- VACUNA/MEDICAMENTO (NOMBRE) -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <label for="id_medicamento{$cont}" class="col-sm-12 col-md-12 control-label required">Nombre comercial Vacuna</label>
                            <div class="col-sm-12 col-md-12">
                                <select for="id_medicamento{$cont}" class="form-control" id="id_medicamento{$cont}" name="id_medicamento{$cont}"
                                        onchange="Visita.mostrar_divOtroMedicamento(this.value,{$cont});" >
                                    <option value="0">Seleccionar nombre</option>
                                    {foreach $arrVacunas as $item}
                                        <option value="{$item->id_vacuna}" name="{$item->id_vacuna}_{$cont}"
                                                {if $item->id_vacuna == $mordedor["vacunas"][0]["id_medicamento"]}selected{/if}>{$item->gl_nombre_vacuna}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <!-- OTRO NOMBRE VACUNA -->
                        <div class="col-lg-3 col-md-4 col-sm-6" id="div_medicamento_otro{$cont}" style="display:{if $mordedor["vacunas"][0]["gl_medicamento_otro"] == ""}none;{/if}">
                            <label for="gl_medicamento_otro{$cont}" class="col-sm-12 col-md-12 control-label required">Otro Nombre Vacuna</label>
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="gl_medicamento_otro{$cont}" id="gl_medicamento_otro{$cont}"
                                       placeholder="Ingrese Otro Nombre Vacuna" class="form-control" value='{$mordedor["vacunas"][0]["gl_medicamento_otro"]}'>
                            </div>
                        </div>
                        <!-- NÚMERO CERTIFICADO -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <label for="numero_certificado{$cont}" class="col-sm-12 col-md-12 control-label required">Número de certificado</label>
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="numero_certificado{$cont}" id="numero_certificado{$cont}" placeholder="Referencia dirección" class="form-control" value='{$mordedor["vacunas"][0]["gl_certificado_vacuna"]}'>
                            </div>
                        </div>
					</div>
				</div>
				<div id='div_preguntas_vacuna_pt2{$cont}'>
                    <div class="row form-group sintoma_no{$cont}">
                        <!-- NÚMERO SERIE -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <label for="gl_numero_serie_vacuna{$cont}" class="col-sm-12 col-md-12 control-label required">Número de serie</label>
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="gl_numero_serie_vacuna{$cont}" id="gl_numero_serie_vacuna{$cont}" placeholder="Número de serie" class="form-control" value='{$mordedor["vacunas"][0]["gl_numero_serie_vacuna"]}'>
                            </div>
                        </div>
                        <!-- FECHA VACUNACIÓN -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <label for="fc_vacunacion{$cont}" class="col-sm-12 col-md-12 control-label required">Fecha vacunación</label>
                            <div class="col-sm-12 col-md-12">
                                <div class="input-group">
                                    <input readonly for="fc_vacunacion{$cont}" type='text' class="form-control fc_vacunacion_clase" id='fc_vacunacion{$cont}' name='fc_vacunacion{$cont}'
                                        data-cant="{$cont}" onchange="Visita.duracionInmunidad($('#fc_vacunacion{$cont}'), 'fc_proxima_vacunacion{$cont}')" 
                                        value='{$mordedor["fc_vacunacion"]|date_format:"%d/%m/%Y"}'>
                                    <span class="help-block hidden fa fa-warning"></span>
                                    <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fc_vacunacion{$cont}').focus();"></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- DURACIÓN INMUNIDAD -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <label for="id_duracion_inmunidad{$cont}" class="col-sm-12 col-md-12 control-label required">Duración inmunidad</label>
                            <div class="col-sm-12 col-md-12">
                                <select for="id_duracion_inmunidad{$cont}" class="form-control" id="id_duracion_inmunidad{$cont}" name="id_duracion_inmunidad{$cont}"
                                         data-cant="{$cont}" onchange="Visita.mostrar_divOtroDuracionInmunidad(this.value,{$cont});Visita.duracionInmunidad($('#fc_vacunacion{$cont}'),'fc_proxima_vacunacion{$cont}')">
                                    <option value="0">Seleccione duración</option>
                                    {foreach $arrDuracionInmunidad as $item}
                                        <option value="{$item->id_duracion_inmunidad}" id="" name="{$item->id_duracion_inmunidad}_{$cont}"
                                                {if $item->id_duracion_inmunidad == $mordedor["id_duracion_inmunidad"]}selected{/if}>{$item->gl_descripcion}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <!-- OTRO NOMBRE VACUNA -->
                        <div class="col-lg-3 col-md-4 col-sm-6" id="div_duracion_inmunidad_otro{$cont}" style="display:{if $mordedor["gl_duracion_inmunidad_otro"] == ""}none;{/if}">
                            <label for="gl_duracion_inmunidad_otro{$cont}" class="col-sm-12 col-md-12 control-label required">Otra Duración Inmunidad (Años)</label>
                            <div class="col-sm-12 col-md-12">
                                <input type="text" name="gl_duracion_inmunidad_otro{$cont}" id="gl_duracion_inmunidad_otro{$cont}" onkeypress ="return soloNumerosYK(event)" maxlength="2"
                                    data-cant="{$cont}" onchange="Visita.duracionInmunidad($('#fc_vacunacion{$cont}'), 'fc_proxima_vacunacion{$cont}')" 
                                    placeholder="Ingrese Duración Inmunidad" class="form-control" value='{$mordedor["gl_duracion_inmunidad_otro"]}'>
                            </div>
                        </div>
                        <!-- FECHA PROXIMA VACUNACIÓN -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <label for="fc_proxima_vacunacion{$cont}" class="col-sm-12 col-md-12 control-label">Fecha próxima vacunación</label>
                            <div class="col-sm-12 col-md-12">
                                <div class="input-group">
                                    <input readonly for="fc_proxima_vacunacion{$cont}" type='text' class="form-control fc_clase" id='fc_proxima_vacunacion{$cont}' name='fc_proxima_vacunacion{$cont}'
                                            value='{$mordedor["fc_proxima_vacunacion"]|date_format:"%d/%m/%Y"}'>
                                    <span class="help-block hidden fa fa-warning"></span>
                                    <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fc_proxima_vacunacion{$cont}').focus();"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group sintoma_no{$cont}">
                        <!-- CERTIFICADO VACUNA ANTIRRÁBICA -->
                        <div class="col-sm-4">
                            <label for="certificado_vacuna_antirrabica{$cont}" class="col-sm-12 col-md-12 control-label required">Certificado vacuna antirrábica</label>
                            <div class="col-sm-12">	
                                <button type="button" id="btnAdjuntoVacuna" class="btn btn-sm btn-success"
                                        onclick="xModal.open('{$smarty.const.BASE_URI}/Informar/adjuntar/?id_tipo_adjunto=6&cont_mordedor={$cont}', 'Agregar Adjunto Vacuna Antirrábica', 45);" >
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Adjuntar Certificado
                                </button>
                            </div>
                        </div>
                        <!-- GRILLA DE DOCUMENTO ADJUNTO -->
                        <div class="col-sm-8">
                            <div class="col-sm-6" id="grilla-adjunto6-{$cont}">
                            </div>
                        </div>
                    </div>
				</div>
			</div>

		</div>

	</div>
    
    <!-- FORMULARIO PROPIETARIO -->
    {include './formulario_propietario.tpl'}

</div>