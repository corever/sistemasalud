<form id="datosBase" hidden>
	<input type="text" id="id_opcion"        	name="id_opcion"        value="<?php echo $itm->m_v_id ?>" />
	<input type="text" id="id_modulo"  			name="id_modulo"  		value="<?php echo $itm->fk_modulo ?>" />
	<input type="text" id="gl_nombre_opcion" 	name="gl_nombre_opcion" value="<?php echo $itm->nombre_vista ?>" />
	<input type="text" id="gl_url"           	name="gl_url"           value="<?php echo $itm->gl_url ?>" />
	<input type="text" id="bo_activo"        	name="bo_activo"        value="<?php echo $itm->bo_activo ?>" />
</form>
<form id="formEditarOpcion" class="form-horizontal">
	<section class="content">
		<div class="panel panel-primary">
			<div class="panel-body">
			<input type="hidden" id="id_opcion" name="id_opcion" value="<?php echo $itm->m_v_id?>" />
			<div class="row">
                <div class="col-3">
					<label for="id_modulo_opcion" class="control-label required-left"> <?php echo \Traduce::texto("Módulo"); ?>: </label>
				</div>
            	<div class="col-6">
					<select id="id_modulo_opcion" name="id_modulo_opcion" class="form-control">
						<option value="0"> <?php echo \Traduce::texto("Seleccione Módulo"); ?> </option>
						<?php foreach ($arrModulo as $key => $modulo): ?>
							<option value="<?php echo $modulo->m_m_id; ?>"
								<?php if ($itm->fk_modulo == $modulo->m_m_id): ?> selected <?php endif; ?>
									> <?php echo $modulo->nombre_modulo; ?>
								</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="row top-spaced">
                <div class="col-3">
					<label for="gl_nombre_opcion" class="control-label required-left"> <?php echo \Traduce::texto("Nombre"); ?>: </label>
				</div>
            	<div class="col-6">
                    <input type="text" class="form-control" id="gl_nombre_opcion" name="gl_nombre_opcion" value="<?php echo $itm->nombre_vista; ?>" />
                </div>
			</div>

			<div class="row top-spaced">
                <div class="col-3">
					<label for="gl_url_opcion" class="control-label required-left"> URL: </label>
				</div>
            	<div class="col-6">
                    <input type="text" class="form-control" id="gl_url_opcion" name="gl_url_opcion" value="<?php echo $itm->gl_url; ?>" />
                </div>
			</div>

			<!--div class="row top-spaced">
                <div class="col-12">
                    <label for="gl_icono" class="control-label"> <?php /*echo \Traduce::texto("Icono"); ?>: </label>
                    <div class="row">
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="gl_icono" name="gl_icono" value="<?php echo $itm->gl_icono ?>" onchange="if(this.value.substr(-2)!='2x') $('#cambio').attr('class', this.value+' fa-2x'); else $('#cambio').attr('class', this.value);" />
                        </div>
                        <div class="col-sm-1">
                            <span id="cambio" class="<?php echo $itm->gl_icono ?>
                                <?php if (substr($itm->gl_icono,-2)!='2x'): ?>
                                     fa-2x
                                <?php endif;*/ ?>">
                            </span>
                        </div>
                    </div>
				</div>
			</div-->

			<div class="row top-spaced">
                <div class="col-3">
                    <label for="bo_activo" class="control-label"> <?php echo \Traduce::texto("Estado"); ?>: </label>
				</div>
				<div class="col-4">
					<select id="bo_activo" name="bo_activo" class="form-control">
						<option value="0"
							<?php if ($itm->bo_activo != 1): ?>
								selected
							<?php endif; ?>
							> <?php echo \Traduce::texto("Inactivo"); ?>
						</option>
						<option value="1"
							<?php if ($itm->bo_activo == 1): ?>
								selected
							<?php endif; ?>
							> <?php echo \Traduce::texto("Activo"); ?>
						</option>
					</select>
				</div>
			</div>

			<div class="modal-footer top-spaced" id="btn-terminar">
				<button class="btn btn-success" type="button" onclick="MaestroMenu.editarOpcion(this.form,this);"><i class="fa fa-save"></i>&nbsp; <?php echo \Traduce::texto("Guardar"); ?> </button>
				&nbsp;&nbsp;
				<button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; <?php echo \Traduce::texto("Cerrar"); ?> </button>
			</div>

			</div>
		</div>
	</section>
</form>
