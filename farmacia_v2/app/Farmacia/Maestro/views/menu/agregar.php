<form id="formAgregar" class="form-horizontal">
	<section class="content">
		<div class="card card-default">
			<div class="card-body">
                
                <div class="row">                    
                    <div class="col-3">
                        <label for="id_modulo_opcion" class="control-label required-left"> <?php echo \Traduce::texto("Modulo"); ?>: </label>
                    </div>
                    <div class="col-6">
                        <select id="id_modulo_opcion" name="id_modulo_opcion" class="form-control">
                            <option value="0"> <?php echo \Traduce::texto("Seleccione Módulo"); ?> </option>
                            <?php foreach ($arrModulo as $key => $modulo): ?>
                                <option value="<?php echo $modulo->m_m_id; ?>"> <?php echo $modulo->nombre_modulo; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
				</div>
                
				<div class="row top-spaced">
                    <div class="col-3">
                        <label for="gl_nombre_opcion" class="control-label required-left"> <?php echo \Traduce::texto("Nombre"); ?>: </label>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" id="gl_nombre_opcion" name="gl_nombre_opcion" placeholder="Nombre Opción">
                    </div>
				</div>

				<div class="row top-spaced">
                    <div class="col-3">
                        <label for="gl_url" class="control-label required-left"> URL (opcional):</label>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" id="gl_url_opcion" name="gl_url_opcion" placeholder="Farmacia/Maestro/Menu/">
                    </div>
                </div>

				<!--div class="row top-spaced">
                    <div class="col-12">
                        <label for="gl_icono" class="control-label"> <?php //echo \Traduce::texto("Icono"); ?>:</label>
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
				</div-->

				<div class="modal-footer top-spaced" id="btn-terminar">
					<button class="btn btn-success" type="button" onclick="MaestroMenu.agregarMenu(this.form,this);"><i class="fa fa-save"></i>&nbsp; <?php echo \Traduce::texto("Guardar"); ?> </button>
					&nbsp;&nbsp;
					<button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; <?php echo \Traduce::texto("Cerrar"); ?> </button>
				</div>

			</div>
		</div>
	</section>
</form>
