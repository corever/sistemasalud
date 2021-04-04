<div class="modal-body">
	<div class="col-xs-12">
		<form class="form-horizontal">
			<input type="hidden" id="id_opcion" name="id_opcion" value="{$itm->id_opcion}" />

			<div class="form-group top-spaced">
				<label for="gl_nombre_padre" class="col-xs-2 control-label clabel"> Padre </label>
				<div class="col-xs-3">
					<input type="text" class="form-control" id="gl_nombre_padre" name="gl_nombre_padre" value="{$itm->gl_nombre__padre}" readonly />
				</div>
			</div>

			<div class="form-group top-spaced">
				<label for="gl_nombre_opcion" class="col-xs-2 control-label clabel"> Nombre </label>
				<div class="col-xs-3">
					<input type="text" class="form-control" id="gl_nombre_opcion" name="gl_nombre_opcion" value="{$itm->gl_nombre_opcion}" readonly />
				</div>
			</div>

			<div class="form-group top-spaced">
				<label for="gl_nombre" class="col-xs-2 control-label clabel"> Perfiles </label>
				<div class="col-sm-9">
					<div class="row col-sm-12">
						<div class="form-check">
							{foreach from=$arr_perfil item=perfil}
								<div class="col-xs-4">
									<input type="checkbox" name="arr_perfil[{$perfil->id_perfil}]" id="arr_perfil[{$perfil->id_perfil}]" value="{$perfil->id_perfil}" {if $perfil->activo == 1} checked {/if} >&nbsp; {$perfil->gl_nombre}
								</div>
							{/foreach}
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer top-spaced">
				<div id="btn-terminar">
					<button class="btn btn-xs btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" > Cerrar </button>
					<button class="btn btn-xs btn-success" type="button" onclick="Mantenedor_menu.editarMenuPerfil(this.form,this);"> Guardar </button>
				</div>
			</div>

		</form>
	</div>
</div>