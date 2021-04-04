<link rel="stylesheet" href="{$static}css/plugins/select2.min.css" />

<form id="formCambioUsuario">

	<input type="text" value="{$gl_token}" id="gl_token" name="gl_token" class="hidden" readonly>
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title"> <i class="fa fa-exchange"></i> Cambiar de Usuario </h3>
		</div>
		<div class="box-body">
			<div class="form-group">
				<div class="col-lg-2 col-xs-4">
					<label class="control-label">Seleccione un Usuario : </label>
				</div>
				<div class="col-lg-6 col-xs-8">
					<select id="id_usuario_cambio" name="id_usuario_cambio" class="form-control select2" style="width: 700px;">
						{foreach $arr_data as $data}
                            {if $data->gl_nombre_perfil}
                                <option value="{$data->gl_token}">{$data->gl_nombres} {$data->gl_apellidos}</option>
                            {/if}
						{/foreach}
					</select>
				</div>
			</div>
		</div>
		<div class="top-spaced"></div>

		<div class="form-group col-sm-12" align="right">
			<button type="button" id="btnCambioUsuario" class="btn btn-success">
				<i class="fa fa-exchange"></i> Aceptar
			</button>&nbsp;
			<button type="button" id="cancelar" class="btn btn-default" onclick="xModal.close()">
				<i class="fa fa-remove"></i> Cancelar
			</button>
		</div>
	</div>

</form>