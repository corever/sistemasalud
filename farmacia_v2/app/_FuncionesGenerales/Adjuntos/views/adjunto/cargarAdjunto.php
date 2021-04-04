<section class="content">
	<form id="form_nuevo_adjunto" class="form-horizontal" enctype="multipart/form-data">
	    <input type="hidden" name="bo_comentario" id="bo_comentario" value="<?php echo $bo_comentario;?>" readonly/>
		<input type="hidden" name="idForm" id="idForm" value="<?php echo $idForm;?>" readonly/>
		<input type="hidden" name="extAdjunto" id="extAdjunto" value="<?php echo $extAdjunto;?>" readonly/>
		<input type="hidden" name="nombreGrilla" id="nombreGrilla" value="<?php echo $idGrillaAdjunto;?>" readonly/>

        <div class="card card-primary">
            <div class="card-body">
				<div class="row">
					<?php if (isset($arrTipoAdjuntos['gl_nombre'])) : ?>
						<div class="col-4">
							<input hidden name="id_tipo_adjunto" id="id_tipo_adjunto" value="<?php echo $arrTipoAdjuntos['id_tipo']; ?>">
							<label for="id_tipo_adjunto" class="required-left">Tipo de Documento</label>
						</div>
						<div class="col-8">
							<input type="text" class="form-control" value="<?php echo $arrTipoAdjuntos['gl_nombre'];?>" readonly >
						</div>
					<?php else: ?>
						<div class="col-4">
							<label for="id_tipo_adjunto" class="required-left">Tipo de Documento</label>
						</div>
						<div class="col-8">
							<select class="form-control" name="id_tipo_adjunto" id="id_tipo_adjunto">
								<option value="">Seleccione Tipo de documento</option>
								<?php foreach ($arrTipoAdjuntos as $key => $id_tipo_adjunto) : ?>
									<option value="<?php echo $key; ?>">
										<?php echo $id_tipo_adjunto['gl_nombre']; ?>		
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					<?php endif; ?>
				</div>
            	<div class="row top-spaced">
	            	<div class="col-4">
						<label for="adjunto" class="required-left">Adjunto</label>
					</div>
	            	<div class="col-8">
	            		<input type="file" name="adjunto" id="adjunto" class="form-control" />
	            	</div>
	            </div>

	            <?php if($bo_comentario):?>
				<div class="row top-spaced">
	            	<div class="col-4">
	            		<label for="adjunto">Comentario</label>
					</div>
	            	<div class="col-8">
	            		<textarea class="form-control" id="" name="comentario_adjunto" rows="2"></textarea>
	            	</div>
	            </div>
	            <?php endif;?>
            </div>

            <hr/>
            <div class="card-footer">
                <div class="d-flex justify-content-around">
                    <button type="button" class="btn btn-success btn-lg" id="btn_guardar" name="btn_guardar" 
                    	onclick="Adjunto.guardar(this.form, this);">
                        <i class="fa fa-save"></i>  Guardar adjunto
                    </button>
                    <button type="button" class="btn btn-default btn-lg" id="cancelar"
                            onclick="xModal.close()">
                        <i class="fa fa-remove"></i>  Cancelar
                    </button>
                </div>
            </div>
        </div>
    </form>
</section>