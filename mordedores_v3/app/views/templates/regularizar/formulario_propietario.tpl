<div id="propietario{$cont}" class="tab-pane fade">

	<div class="row">
		<div class="top-spaced"></div>
		<!-- ES EXTRANJERO -->
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
			<label for="bo_extranjero" class="col-sm-12 control-label">¿Es extranjero? (*)</label>
			<div class="col-sm-12" id="bo_extranjero">
				<div class="col-xs-6">
					<input type="radio" name="bo_extranjero{$cont}"
						data-labelauty='SI' data-cant="{$cont}" onchange="Regularizar.extranjeroRadioBtn(this)" 
						value="1" {if $mordedor["propietario"]["bo_extranjero"] == 1} checked="selected"{/if}>
				</div>
				<div class="col-xs-6">
					<input type="radio" name="bo_extranjero{$cont}"
						data-labelauty='NO' data-cant="{$cont}" onchange="Regularizar.extranjeroRadioBtn(this)" 
						value="0" {if $mordedor["propietario"]["bo_extranjero"] == 0} checked="selected"{/if}>
				</div>
			</div>
		</div>
		
		<!-- RUT EMITIDO EN CHILE -->
		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12" id="div-bo_extranjero{$cont}" {if $mordedor["propietario"]["bo_extranjero"] == 0} style="display: none;"{/if}>
			<label for="extranjero" class="col-sm-12 control-label">¿Rut emitido en Chile? (*)</label>
			<div class="col-sm-12" id="extranjero{$cont}">
				<div class="col-xs-6">
					<input type="radio" name="emitidoChile{$cont}" 
						data-labelauty='SI' data-cant="{$cont}" onchange="Regularizar.emitidoChileRadioBtn(this)" 
						value="1" {if $mordedor["propietario"]["bo_rut_emitido"] == 1} checked="selected"{/if}>
				</div>
				<div class="col-xs-6">
					<input type="radio"  name="emitidoChile{$cont}"
						data-labelauty='NO' data-cant="{$cont}" onchange="Regularizar.emitidoChileRadioBtn(this)" 
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
			{if $mordedor["propietario"]["bo_extranjero"] == 1 && $mordedor["propietario"]["bo_rut_emitido"] == 0} style="display: none;"{/if}>
			<label for="gl_rut" class="col-sm-12 col-md-12 control-label">Identificación (RUT)</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="gl_rut{$cont}" id="gl_rut{$cont}" placeholder="RUT" class="form-control" value='{$mordedor["propietario"]["gl_rut"]}'>
			</div>
		</div>
		<!-- IDENTIFICACIÓN (PASAPORTE) -->
		<div class="col-lg-3 col-md-4 col-sm-6" id="div-gl_pasaporte{$cont}" {if $mordedor["propietario"]["bo_rut_emitido"] == 1} style="display: none;"{/if}>
			<label for="gl_pasaporte{$cont}" class="col-sm-12 col-md-12 control-label">Identificación (PASAPORTE)</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="gl_pasaporte{$cont}" id="gl_pasaporte{$cont}" placeholder="Pasaporte" class="form-control" value='{$mordedor["propietario"]["gl_pasaporte"]}'>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="top-spaced"></div>
		<!-- NOMBRE -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<label for="gl_nombre_propietario{$cont}" class="col-sm-12 col-md-12 control-label">Nombre (*)</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="gl_nombre_propietario{$cont}" id="gl_nombre_propietario{$cont}" placeholder="Nombre propietario" class="form-control" value='{$mordedor["propietario"]["gl_nombre"]}'>
			</div>
		</div>
		<!-- APELLIDO P -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<label for="apell_paterno_propietario{$cont}" class="col-sm-12 col-md-12 control-label">Apellido Paterno (*)</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="apell_paterno_propietario{$cont}" id="apell_paterno_propietario{$cont}" placeholder="Apellido Paterno" class="form-control" value='{$mordedor["propietario"]["gl_apellido_paterno"]}'>
			</div>
		</div>
		<!-- APELLIDO M -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<label for="apell_materno_propietario{$cont}" class="col-sm-12 col-md-12 control-label">Apellido Materno</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="apell_materno_propietario{$cont}" id="apell_materno_propietario{$cont}" placeholder="Apellido Materno" class="form-control" value='{$mordedor["propietario"]["gl_apellido_materno"]}'>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="top-spaced"></div>
		<!-- EMAIL -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<label for="gl_email{$cont}" class="col-sm-12 col-md-12 control-label">Email</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="gl_email{$cont}" id="gl_email{$cont}" placeholder="Email propietario" class="form-control" value='{$mordedor["propietario"]["gl_email"]}'>
			</div>
		</div>
		<!-- TELEFONO -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<label for="telefono_propietario{$cont}" class="col-sm-12 col-md-12 control-label">Teléfono</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="telefono_propietario{$cont}" id="telefono_propietario{$cont}" placeholder="Teléfono propietario" class="form-control" value='{$mordedor["propietario"]["telefono_propietario"]}'>
			</div>
		</div> 
	</div>
	
	<!-- DIRECCIÓN -->
	<div class="row form-group">
		<hr>
		<!-- REGION -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<label for="region_propietario{$cont}" class="col-sm-12 col-md-12 control-label">Región (*)</label>
			<div class="col-sm-12 col-md-12">
				<select for="region_propietario{$cont}" class="form-control" id="region_propietario{$cont}" name="region_propietario{$cont}" onchange="Region.cargarComunasPorRegion(this.value, 'comuna_propietario{$cont}',{$mordedor['propietario']['id_comuna']})">
					<option value="0">Seleccione una Región</option>
					{foreach $arrRegiones as $item}
						<option value="{$item->id_region}" id="{$item->gl_latitud}" name="{$item->gl_longitud}"
								{if $item->id_region == $mordedor["propietario"]["id_region"]}selected{/if}>{$item->gl_nombre_region}</option>
					{/foreach}
				</select>
			</div>
		</div>
		<!-- COMUNA -->
		<div class="col-lg-3 col-md-4 col-sm-6">
			<input type="hidden" value='{$mordedor["propietario"]["id_comuna"]}' id="comuna_propietario_respaldo{$cont}">
			<label for="comuna_propietario{$cont}" class="col-sm-12 col-md-12 control-label">Comuna (*)</label>
			<div class="col-sm-12 col-md-12">
				<select for="comuna_propietario{$cont}" class="form-control" id="comuna_propietario{$cont}" name="comuna_propietario{$cont}">  
				</select>
			</div>
		</div>
		<!-- DIRECCIÓN -->
		<div class="col-lg-3 col-md-4 col-sm-12">
			<label for="direccion_propietario{$cont}" class="col-sm-12 col-md-12 control-label">Dirección (*)</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="direccion_propietario{$cont}" id="direccion_propietario{$cont}" placeholder="Dirección propietario" class="form-control" value='{$mordedor["propietario"]["direccion"]}'>
			</div>
		</div>
		<!-- REFERENCIA -->
		<div class="col-lg-3 col-md-12 col-sm-12">
			<label for="referencias_direccion_propietario{$cont}" class="col-sm-12 col-md-12 control-label">Referencia</label>
			<div class="col-sm-12 col-md-12">
				<input type="text" name="referencias_direccion_propietario{$cont}" id="referencias_direccion_propietario{$cont}" placeholder="Referencias dirección" class="form-control" value='{$mordedor["propietario"]["referencia_direccion"]}'>
			</div>
		</div>
	</div>
</div>