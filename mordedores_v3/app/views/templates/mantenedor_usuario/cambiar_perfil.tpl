
<script type="text/javascript" src="{$static}js/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="{$static}js/plugins/select2/i18n/es.js"></script>
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css" />

	
<form id="formCambioPerfil">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title"> <i class="fa fa-exchange"></i> Cambiar de Perfil </h3>
		</div>
		<div class="box-body">
			<div class="form-group">
				<div class="col-lg-3 col-xs-5">
					<label class="control-label">Seleccione un Usuario : </label>
				</div>
				<div class="col-lg-6 col-xs-8">
					<select id="id_perfil_cambio" name="id_perfil_cambio" class="form-control" style="width: 500px;">
						{foreach $perfiles as $perfil}
                            {if $perfil->gl_nombre_perfil}
                                {if $perfil->bo_nacional == 1}
                                    {assign var=parentesis value=""}
                                {elseif $perfil->bo_regional == 1}
                                    {assign var=parentesis value=$perfil->nombre_region}
                                {elseif $perfil->bo_oficina == 1}
                                    {assign var=parentesis value=$perfil->nombre_oficina}
                                {elseif $perfil->bo_comunal == 1}
                                    {assign var=parentesis value=$perfil->nombre_comuna}
                                {/if}
                                {if $perfil->bo_establecimiento == 1}
                                    {assign var=parentesis value=$perfil->nombre_establecimiento}
                                {/if}
                                {if $perfil->id_perfil == 15}
                                    {assign var=parentesis value=$perfil->nombre_servicio}
                                {/if}
                                <option value="{$perfil->id_usuario_perfil}" {if $id_usuario_perfil == $perfil->id_usuario_perfil}selected disabled{/if}
                                        >{$perfil->gl_nombre_perfil} {if $parentesis}({$parentesis}){/if}</option>
                            {/if}
						{/foreach}
					</select>
				</div>
			</div>
		</div>
		<div class="top-spaced"></div>

		<div class="form-group col-sm-12" align="right">
			<button type="button" id="btnCambioPerfil" class="btn btn-success">
				<i class="fa fa-exchange"></i> Aceptar
			</button>&nbsp;
			<button type="button" id="cancelar" class="btn btn-default" onclick="xModal.close()">
				<i class="fa fa-remove"></i> Cancelar
			</button>
		</div>
	</div>

</form>