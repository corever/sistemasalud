<form id="formAgregar" class="form-horizontal">
	<section class="content">
		<div class="card card-default">
			<div class="card-body">
                
                <div class="row">
                    <div class="col-6">
                        <label for="id_padre" class="control-label"> <?php echo \Traduce::texto("Padre"); ?>: </label>
                        <select id="id_padre" name="id_padre" class="form-control">
                            <option value="0"> <?php echo \Traduce::texto("Sin Padre"); ?> </option>
                            <?php foreach ($arr_padre as $key => $padre): ?>
                                <option value="<?php echo $padre->id_opcion ?>" id="<?php echo $padre->gl_url?>"> <?php echo $padre->gl_nombre_opcion ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-6">
                        <label for="id_modulo" class="control-label"> <?php echo \Traduce::texto("Modulo"); ?>: </label>
                        <select id="id_modulo" name="id_modulo" class="form-control">
                            <option value="0"> <?php echo \Traduce::texto("Sin Módulo"); ?> </option>
                            <?php foreach ($arrModulo as $key => $modulo): ?>
                                <option value="<?php echo $modulo->id_modulo; ?>"> <?php echo $modulo->gl_nombre; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
				</div>
                
				<div class="row top-spaced">
                    <div class="col-12">
                        <label for="gl_nombre" class="control-label required-left"> <?php echo \Traduce::texto("Nombre"); ?>: </label>
                        <input type="text" class="form-control" id="gl_nombre" name="gl_nombre" placeholder="Nombre Opción">
                    </div>
				</div>

				<div class="row top-spaced">
                    <div class="col-12">
                        <label for="gl_url" class="control-label"> URL (opcional):</label>
                        <input type="text" class="form-control" id="gl_url" name="gl_url" placeholder="Farmacia/Mantenedor/menu/">
                    </div>
                </div>

				<div class="row top-spaced">
                    <div class="col-12">
                        <label for="gl_icono" class="control-label"> <?php echo \Traduce::texto("Icono"); ?>:</label>
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="gl_icono" name="gl_icono" placeholder="fas fa-search"
                                onkeyup="if(this.value.substr(-2)!='2x') $('#cambio').attr('class', this.value+' fa-2x'); else $('#cambio').attr('class', this.value);" />
                            </div>
                            <div class="col-sm-1">
                                <span id="cambio" class="fas fa-search fa-2x"></span>
                            </div>
                        </div>
					</div>
				</div>

				<div class="modal-footer top-spaced" id="btn-terminar">
					<button class="btn btn-success" type="button" onclick="MantenedorMenu.agregarMenu(this.form,this);"><i class="fa fa-save"></i>&nbsp; <?php echo \Traduce::texto("Guardar"); ?> </button>
					&nbsp;&nbsp;
					<button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; <?php echo \Traduce::texto("Cerrar"); ?> </button>
				</div>

			</div>
		</div>
	</section>
</form>
