<form id="formAgregarHijo" class="form-horizontal">
	<section class="content">
		<div class="panel panel-primary">
			<div class="panel-body">

				<div class="form-group top-spaced">
					<label for="id_padre" class="col-sm-3 control-label"> Padre: </label>
					<div class="col-sm-4">
						<select id="id_padre" name="id_padre" class="form-control">
							<option value="0"> Seleccione Padre </option>
							{foreach from=$arr_padre item=padre}
								<option value="{$padre->id_opcion}" id="{$padre->gl_url}"> {$padre->gl_nombre_opcion} </option>
							{/foreach}
						</select>
					</div>
					<div class="col-sm-1" id="alerta_padre" style="display: none">	
						<span class="btn btn-xs btn-danger infoTip info_padre" data-pos="pull-right" data-titulo="Importante:" data-texto="hola">
							<li class="fa fa-question-circle"></li>
						</span>
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="gl_nombre_opcion" class="col-sm-3 control-label"> Nombre: </label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="gl_nombre_opcion" name="gl_nombre_opcion" placeholder="Nombre Opción" />
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="gl_url" class="col-sm-3 control-label"> URL: </label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="gl_url" name="gl_url" placeholder="/Mantenedor/menu/" />
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="gl_icono" class="col-sm-3 control-label"> Icono:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="gl_icono" name="gl_icono" placeholder="fa fa-save" onchange="if(this.value.substr(-2)!='2x') $('#cambio').attr('class', this.value+' fa-2x'); else $('#cambio').attr('class', this.value);" />
					</div>
					<div class="col-sm-1">
						<span id="cambio" class="fa fa-save fa-2x"></span>
					</div>
				</div>

				<div class="modal-footer top-spaced" id="btn-terminar">
					<button class="btn btn-success" type="button" onclick="Mantenedor_menu.agregarMenuOpcion(this.form,this);"><i class="fa fa-save"></i>&nbsp; Guardar </button>
					&nbsp;&nbsp;
					<button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; Cerrar </button>
				</div>

			</div>
		</div>
	</section>
</form>