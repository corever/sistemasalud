<form id="formAgregarPadre" class="form-horizontal">
	<section class="content">
		<div class="panel panel-primary">
			<div class="panel-body">

				<div class="form-group top-spaced">
					<label for="gl_nombre" class="col-sm-3 control-label"> Nombre: </label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="gl_nombre" name="gl_nombre" placeholder="Nombre Opción Padre">
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="gl_icono" class="col-sm-3 control-label"> Icono:</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="gl_icono" name="gl_icono" placeholder="fa fa-search" onchange="if(this.value.substr(-2)!='2x') $('#cambio').attr('class', this.value+' fa-2x'); else $('#cambio').attr('class', this.value);" />
					</div>
					<div class="col-sm-1">
						<span id="cambio" class="fa fa-search fa-2x"></span>
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="gl_url" class="col-sm-3 control-label"> URL (opcional):</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="gl_url" name="gl_url" placeholder="/Mantenedor/menu/">
					</div>
				</div>

				<div class="modal-footer top-spaced" id="btn-terminar">
					<button class="btn btn-success" type="button" onclick="Mantenedor_menu.agregarMenuPadre(this.form,this);"><i class="fa fa-save"></i>&nbsp; Guardar </button>
					&nbsp;&nbsp;
					<button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; Cerrar </button>
				</div>

			</div>
		</div>
	</section>
</form>