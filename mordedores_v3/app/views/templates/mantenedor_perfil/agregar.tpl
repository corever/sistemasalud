<form id="formAgregarPerfil" class="form-horizontal">
	<section class="content">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="form-group top-spaced">
					<label for="gl_nombre" class="col-sm-3 control-label"> Nombre </label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="gl_nombre" name="gl_nombre" value="">
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="gl_descripcion" class="col-sm-3 control-label"> Descripción </label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="gl_descripcion" name="gl_descripcion" value="">
					</div>
				</div>
                
                <div class="form-group top-spaced">
					<label for="bo_tipo_perfil" class="col-sm-3 control-label"> Territorio </label>
					<div class="col-sm-7">
                        <label><input type="radio" name="bo_tipo_perfil" id="bo_tipo_perfil_1" value="1" >&nbsp;Nacional</label>&ensp;
                        <label><input type="radio" name="bo_tipo_perfil" id="bo_tipo_perfil_2" value="2" >&nbsp;Regional</label>&ensp;
                        <label><input type="radio" name="bo_tipo_perfil" id="bo_tipo_perfil_3" value="3" >&nbsp;Oficina</label>&ensp;
                        <label><input type="radio" name="bo_tipo_perfil" id="bo_tipo_perfil_4" value="4" >&nbsp;Comunal</label>
					</div>
				</div>
                
                <div class="form-group top-spaced">
					<label for="bo_institucion" class="col-sm-3 control-label"> Institución </label>
					<div class="col-sm-7">
                        <label><input type="radio" name="bo_institucion" id="bo_institucion_1" value="1" >&nbsp;Seremi</label>&ensp;
                        <label><input type="radio" name="bo_institucion" id="bo_institucion_2" value="2" >&nbsp;Establecimiento Salud</label>
					</div>
				</div>
				
				<div class="form-group top-spaced">
						<label class="col-sm-3 control-label">&nbsp;</label>
				</div>
						
				{foreach from=$arr_padre item=padre}
					<div class="form-group">
						<label class="col-sm-3 control-label"> {$padre->gl_nombre_opcion}: </label>
						<div class="col-sm-4">
							<label><input type="checkbox" name="{$padre->id_opcion}" id="{$padre->id_opcion}" onclick="mostrarHijos(this)" {if $padre->activo == 1} checked {/if} >
								&nbsp;<i class="{$padre->gl_icono}-2x"></i> {$padre->gl_nombre_opcion}</label>
						</div>
					</div>
					<div id="opcion_hijo_{$padre->id_opcion}" style="display: none">
						{foreach from=$arr_opcion item=opcion}
							{if $opcion->id_opcion_padre == $padre->id_opcion}
								<div class="form-group">
									<label for="gl_space" class="col-sm-3 control-label">&nbsp;</label>
									<div class="col-sm-4">
										&nbsp;&nbsp;&nbsp;&nbsp;
										<label><input type="checkbox" name="{$opcion->id_opcion}" id="{$opcion->id_opcion}" {if $opcion->activo == 1} checked {/if} >
											&nbsp;<i class="{$opcion->gl_icono}"></i> <span >{$opcion->gl_nombre_opcion}</span></label>
									</div>
								</div>
							{/if}
						{/foreach}
					</div>
				{/foreach}
				
				<div class="modal-footer top-spaced" id="btn-terminar">
					<button class="btn btn-success" type="button" onclick="Mantenedor_perfil.agregarPerfil(this.form,this);"><i class="fa fa-save"></i>&nbsp; Guardar </button>
					&nbsp;&nbsp;
					<button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; Cerrar </button>
				</div>

			</div>
		</div>
	</section>
</form>