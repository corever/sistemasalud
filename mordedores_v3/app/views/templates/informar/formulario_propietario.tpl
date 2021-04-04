<div id="propietario{$cont}">
	<div class="top-spaced"></div>

	<div class="box-header">
		<h3 class="box-title" style="width: 100%"> Datos Propietario </h3>
	</div>
	
	<div class="row">
		<div class="top-spaced"></div>
		<!-- ES EXTRANJERO -->
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<label for="bo_extranjero" class="col-sm-12 control-label required">¿Es extranjero?</label>
			<div class="col-sm-12" id="bo_extranjero">
				<div class="col-xs-6">
					<input type="radio" name="bo_extranjero{$cont}"
						data-labelauty='SI' data-cant="{$cont}" onchange="Visita.extranjeroRadioBtn(this)" 
						value="1" {if $mordedor["propietario"]["bo_extranjero"] == 1} checked="selected"{/if}>
				</div>
				<div class="col-xs-6">
					<input type="radio" name="bo_extranjero{$cont}"
						data-labelauty='NO' data-cant="{$cont}" onchange="Visita.extranjeroRadioBtn(this)" 
						value="0" {if $mordedor["propietario"]["bo_extranjero"] == 0} checked="selected"{/if}>
				</div>
			</div>
		</div>
		
		<!-- RUT EMITIDO EN CHILE -->
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12" id="div-bo_extranjero{$cont}" {if $mordedor["propietario"]["bo_extranjero"] == 0} style="display: none;"{/if}>
			<label for="extranjero" class="col-sm-12 control-label required">¿Rut emitido en Chile?</label>
			<div class="col-sm-12" id="extranjero{$cont}">
				<div class="col-xs-6">
					<input type="radio" name="emitidoChile{$cont}"
						data-labelauty='SI' data-cant="{$cont}" onchange="Visita.emitidoChileRadioBtn(this)" 
						value="1" {if $mordedor["propietario"]["bo_rut_emitido"] == 1} checked="selected"{/if}>
				</div>
				<div class="col-xs-6">
					<input type="radio"  name="emitidoChile{$cont}"
						data-labelauty='NO' data-cant="{$cont}" onchange="Visita.emitidoChileRadioBtn(this)" 
						value="0" {if $mordedor["propietario"]["bo_rut_emitido"] == 0} checked="selected"{/if}>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="top-spaced"></div>
		<!-- NACIONALIDAD -->
		<div class="col-lg-3 col-md-4 col-sm-6" id="div-nacionalidad{$cont}" {if $mordedor["propietario"]["bo_extranjero"] == 0} style="display: none;"{/if}>
			<label for="nacionalidad{$cont}" class="col-sm-12 col-md-12 control-label">Nacionalidad</label>
			<div class="col-sm-12 col-md-12">
				<select class="form-control select2" id="nacionalidad{$cont}" name="nacionalidad{$cont}" class="form-control">
					<option value="0">Seleccione Nacionalidad</option>
					{foreach $arrNacionalidad as $item}
						<option value="{$item->id_nacionalidad}" {if $item->id_pais == $mordedor["propietario"]["nacionalidad"]["id"]}selected{/if} id="{$item->id_pais}_{$cont}">{$item->gl_nombre_nacionalidad}</option>
					{/foreach}
				</select>
			</div>
		</div>
		<!-- IDENTIFICACIÓN (RUT) -->
		<div class="col-lg-3 col-md-4 col-sm-6" id="div-gl_rut{$cont}"
			{if $mordedor["propietario"]["bo_extranjero"] == 1} style="display: none;"{/if}>
			<label for="gl_rut" class="col-sm-12 col-md-12 control-label required">Identificación (RUT)</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="gl_rut{$cont}" id="gl_rut{$cont}" placeholder="RUT" onkeyup="formateaRut(this), this.value = this.value.toUpperCase()"
                       onkeypress ="return soloNumerosYK(event)" onblur="Valida_Rut(this);Visita.revisarPropietario({$cont});"
				class="form-control" value='{if $mordedor["bo_paciente_dueno"]==1}{$mordedor["arr_paciente"]["gl_rut"]}{/if}'>
			</div>
		</div>
		<!-- IDENTIFICACIÓN (PASAPORTE) -->
		<div class="col-lg-3 col-md-4 col-sm-6" id="div-gl_pasaporte{$cont}" 
			{if $mordedor["propietario"]["bo_extranjero"] == 0} style="display: none;"{/if}>
			<label for="gl_pasaporte{$cont}" class="col-sm-12 col-md-12 control-label required">Identificación (PASAPORTE)</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="gl_pasaporte{$cont}" id="gl_pasaporte{$cont}" placeholder="Pasaporte" class="form-control" 
				value='{if $mordedor["bo_paciente_dueno"]==1}{$mordedor["propietario"]["gl_pasaporte"]}{/if}'>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="top-spaced"></div>
		<!-- NOMBRE -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<label for="gl_nombre_propietario{$cont}" class="col-sm-12 col-md-12 control-label required">Nombre</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="gl_nombre_propietario{$cont}" id="gl_nombre_propietario{$cont}" placeholder="Nombre propietario" class="form-control" 
				value='{if $mordedor["bo_paciente_dueno"]==1}{$mordedor["arr_paciente"]["gl_nombres"]}{/if}'>
			</div>
		</div>
		<!-- APELLIDO P -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<label for="apell_paterno_propietario{$cont}" class="col-sm-12 col-md-12 control-label required">Apellido Paterno</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="apell_paterno_propietario{$cont}" id="apell_paterno_propietario{$cont}" placeholder="Apellido Paterno" class="form-control" 
				value='{if $mordedor["bo_paciente_dueno"]==1}{$mordedor["arr_paciente"]["gl_apellido_paterno"]}{/if}'>
			</div>
		</div>
		<!-- APELLIDO M -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<label for="apell_materno_propietario{$cont}" class="col-sm-12 col-md-12 control-label">Apellido Materno</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="apell_materno_propietario{$cont}" id="apell_materno_propietario{$cont}" placeholder="Apellido Materno" class="form-control" 
				value='{if $mordedor["bo_paciente_dueno"]==1}{$mordedor["arr_paciente"]["gl_apellido_materno"]}{/if}'>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="top-spaced"></div>
		<!-- EMAIL -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<label for="gl_email{$cont}" class="col-sm-12 col-md-12 control-label">Email</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="gl_email{$cont}" id="gl_email{$cont}" placeholder="Email propietario" class="form-control" 
				value='{foreach $mordedor["propietario"]["contacto_paciente"] as $item}{if $item->id_tipo_contacto == 4}{$item["gl_email"]}{/if}{/foreach}'>
			</div>
		</div>
		<!-- TELEFONO -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<label for="telefono_propietario{$cont}" class="col-sm-12 col-md-12 control-label">Teléfono</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="telefono_propietario{$cont}" id="telefono_propietario{$cont}" placeholder="Teléfono propietario" class="form-control" 
					value='{foreach $mordedor["propietario"]["contacto_paciente"] as $item}{if $item["id_tipo_contacto"] == 1}{$item["telefono_fijo"]}{/if}{/foreach}'>
			</div>
		</div> 
	</div>
	
	<!-- DIRECCIÓN -->
	<div class="row form-group">
		<hr>
		<!-- REGION -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<label for="region_propietario{$cont}" class="col-sm-12 col-md-12 control-label required">Región</label>
			<div class="col-sm-12 col-md-12">
				<select for="region_propietario{$cont}" class="form-control" id="region_propietario{$cont}" name="region_propietario{$cont}" onchange="Region.cargarComunasPorRegion(this.value, 'comuna_propietario{$cont}',{$mordedor['propietario']['id_comuna']})">
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
			<input type="hidden" value='{$mordedor["propietario"]["id_comuna"]}' id="comuna_propietario_respaldo{$cont}">
			<label for="comuna_propietario{$cont}" class="col-sm-12 col-md-12 control-label required">Comuna</label>
			<div class="col-sm-12 col-md-12">
				<select for="comuna_propietario{$cont}" class="form-control" id="comuna_propietario{$cont}" name="comuna_propietario{$cont}">
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
			<label for="direccion_propietario{$cont}" class="col-sm-12 col-md-12 control-label required">Dirección</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="direccion_propietario{$cont}" id="direccion_propietario{$cont}" placeholder="Dirección propietario" class="form-control" 
				value='{$mordedor["gl_direccion"]}'>
			</div>
		</div>
		<!-- REFERENCIA -->
		<div class="col-lg-3 col-md-12 col-sm-12">
			<label for="referencias_direccion_propietario{$cont}" class="col-sm-12 col-md-12 control-label">Referencia</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="referencias_direccion_propietario{$cont}" id="referencias_direccion_propietario{$cont}" placeholder="Referencias dirección" class="form-control" 
				value='{if $mordedor["bo_paciente_dueno"]==1 || $mordedor["bo_vive_con_paciente"]==1} {$mordedor["gl_referencias_animal"]} {/if}'>
			</div>
		</div>
	</div>
</div>