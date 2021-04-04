<form id="formEditarOpcion" class="form-horizontal">
	<section class="content">
		<div class="panel panel-primary">
			<div class="panel-body">
			<input type="hidden" id="id_opcion" name="id_opcion" value="{$itm->id_opcion}" />

			<div class="form-group top-spaced">
				<label class="col-sm-3 control-label"> ¿Es Menú Hijo? </label>
				<div class="col-sm-4">
					<label>
                        <input class="bo_hijo" type="radio" name="bo_hijo" id="bo_hijo_1" onchange='Mantenedor_menu.mostrarPadre(this.value);' value="1"
                               {if $itm->id_opcion_padre != 0}checked{/if}>SI
                    </label>&nbsp;&nbsp;
					<label>
                        <input class="bo_hijo" type="radio" name="bo_hijo" id="bo_hijo_0" onchange='Mantenedor_menu.mostrarPadre(this.value);' value="0"
                               {if $itm->id_opcion_padre == 0}checked{/if}>NO
                    </label>&nbsp;&nbsp;
				</div>
			</div>
                    
			<div class="form-group top-spaced" id="div_select_padre" {if $itm->id_opcion_padre == 0}style="display:none"{/if}>
				<label class="col-sm-3 control-label"> Padre: </label>
				<div class="col-sm-4">
					<select id="id_padre" name="id_padre" class="form-control">
						<option value="0"> Seleccione Padre</option>
						{foreach from=$arr_padre item=padre}
                            {if $padre->id_opcion != $itm->id_opcion}
                                <option value="{$padre->id_opcion}" {if $itm->id_opcion_padre == $padre->id_opcion} selected {/if} > {$padre->gl_nombre_opcion} </option>
                            {/if}
						{/foreach}
					</select>
				</div>
			</div>

			<div class="form-group top-spaced">
				<label for="gl_nombre_opcion" class="col-sm-3 control-label"> Nombre: </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="gl_nombre_opcion" name="gl_nombre_opcion" value="{$itm->gl_nombre_opcion}" />
				</div>
			</div>
			
			<div class="form-group top-spaced">
				<label for="gl_url" class="col-sm-3 control-label"> URL: </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="gl_url" name="gl_url" value="{$itm->gl_url}" />
				</div>
			</div>
			
			<div class="form-group top-spaced">
				<label for="gl_icono" class="col-sm-3 control-label"> Icono: </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="gl_icono" name="gl_icono" value="{$itm->gl_icono}" onchange="if(this.value.substr(-2)!='2x') $('#cambio').attr('class', this.value+' fa-2x'); else $('#cambio').attr('class', this.value);" />
				</div>
				<div class="col-sm-1">
					<span id="cambio" class="{$itm->gl_icono}{$itm->gl_icono}{if substr($itm->gl_icono,-2)!='2x'} fa-2x{/if}"></span>
				</div>
			</div>

			<div class="form-group top-spaced">
				<label for="bo_activo" class="col-sm-3 control-label"> Estado: </label>
				<div class="col-sm-4">
					<select id="bo_activo" name="bo_activo" class="form-control">
						<option value="0" {if $itm->bo_activo != 1} selected {/if} > Inactivo </option>
						<option value="1" {if $itm->bo_activo == 1} selected {/if} > Activo </option>
					</select>
				</div>
			</div>

			<div class="modal-footer top-spaced" id="btn-terminar">
				<button class="btn btn-success" type="button" onclick="Mantenedor_menu.editarOpcion(this.form,this);"><i class="fa fa-save"></i>&nbsp; Guardar </button>
				&nbsp;&nbsp;
				<button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; Cerrar </button>
			</div>

			</div>
		</div>
	</section>
</form>