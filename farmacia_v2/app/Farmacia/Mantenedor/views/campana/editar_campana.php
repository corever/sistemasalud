<form id="formEditarCampana" class="form-horizontal">
	<input type="text" id="id_campana" name="id_campana" value="<?php echo $campana->id_campana ?>" style="display:none" />
	<section class="content">
		<div class="panel panel-primary">
			<div class="panel-body">

			<div class="form-group top-spaced">
					<label for="id_ambito" class="col-sm-5 control-label"> Ámbito <span class="text-red">(*): </label>
					<div class="col-sm-4">
                        <?php $ambitos = json_decode($campana->json_ambito, true);?>
						<select id="ambitos" class="form-control chosen" name="ambitos" multiple>
							<option value="0">Seleccione Ambito</option>
							<?php foreach ($arrAmbito as $key => $ambito) : ?>
								<option value="<?php echo $ambito->id_ambito ?>" <?php if ((is_array($ambitos) and in_array($ambito->id_ambito, $ambitos)) or ($ambito->id_ambito == $ambitos)) : ?> selected <?php endif; ?> ><?php echo $ambito->gl_nombre ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="gl_nombre_campana" class="col-sm-5 control-label"> Nombre <span class="text-red">(*): </label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="gl_nombre_campana" name="gl_nombre_campana" placeholder="Nombre Campaña / Programa" value="<?php echo $campana->gl_nombre ?>" />
					</div>
				</div>


                <div class="form-group top-spaced">
                    <label for="gl_nombre_campana" class="col-sm-5 control-label"> ¿Campaña Nacional? <span class="text-red">(*):</span> </label>
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="SI" name="campana_nacional" id="campana_nacional" onclick="if(this.checked){$('.campana_nacional').prop('disabled', true);}else{$('.campana_nacional').prop('disabled', false);}" <?php if ($campana->id_region == 0 or is_null($campana->id_region)) :?> checked <?php endif;?>  /> Si
                            </label>
                        </div>

                    </div>
                </div>

				<?php /*
				<div class="form-group top-spaced">
					<label for="gl_nr_orden" class="col-sm-5 control-label"> Nª Orden <span class="text-red">(*): </label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="gl_nr_orden" name="gl_nr_orden" placeholder="Número de Orden" value="<?php echo $campana->nr_orden ?>" onkeypress="return soloNumeros(event)" />
					</div>
				</div>
				*/ ?>
				
		

				<div class="form-group top-spaced">
					<label for="id_region_campana" class="col-sm-5 control-label"> Región: </label>
					<div class="col-sm-4">
						<select id="id_region_campana" name="id_region_campana" class="form-control campana_nacional" onchange="Region.cargarOficinaByRegion(this.value,'id_oficina_campana',<?php echo !empty($campana->id_oficina) ? $campana->id_oficina : 0   ?>, function(){ $('#id_oficina_campana').trigger('change');});"   <?php if ($campana->id_region == 0 or is_null($campana->id_region)) :?> disabled <?php endif;?> >
							<option value="0">-- Seleccione --</option>
							<?php foreach ($arrRegion as $key => $region) : ?>
								<option value="<?php echo $region->id_region ?>" <?php if ($campana->id_region == $region->id_region) : ?> selected <?php endif; ?>>
									<?php echo $region->gl_nombre_region ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="id_oficina_campana" class="col-sm-5 control-label"> Oficina: </label>
					<div class="col-sm-4">
						<select id="id_oficina_campana" name="id_oficina_campana" class="form-control campana_nacional" onchange="Region.cargarComunaByOficina(this.value, 'id_comuna_campana',<?php echo $campana->id_comuna ?>);"  <?php if ($campana->id_region == 0 or is_null($campana->id_region)) :?> disabled <?php endif;?>>
							<option value="0">-- Seleccione --</option>
						</select>
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="id_comuna_campana" class="col-sm-5 control-label"> Comuna: </label>
					<div class="col-sm-4">
						<select id="id_comuna_campana" name="id_comuna_campana" class="form-control campana_nacional"  <?php if ($campana->id_region == 0 or is_null($campana->id_region)) :?> disabled <?php endif;?>>
							<option value="0">-- Seleccione --</option>
						</select>
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="gl_nombre_opcion" class="col-sm-5 control-label"> Fecha Inicia <span class="text-red">(*): </label>
					<div class="col-md-4 col-sm-4  col-xs-12">
						<div class="input-group">
							<input for="fechaInicia" type="text" class="col-md-12 col-sm-12 form-control" id="fechaInicia" name="fechaInicia" readonly="" value="<?php echo !empty($campana->fc_inicia) ? date("d/m/Y", strtotime($campana->fc_inicia)) : ""  ?>">
							<span for="fechaInicia" class="input-group-addon campana"><i class="fa fa-calendar" onclick="$('#fechaInicia').focus();"></i></span>
						</div>
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="gl_url" class="col-sm-5 control-label"> Fecha Finaliza <span class="text-red">(*): </label>
					<div class="col-md-4 col-sm-4  col-xs-12">
						<div class="input-group">
							<input for="fechaFinaliza" type="text" class="col-md-12  col-sm-12 form-control" id="fechaFinaliza" name="fechaFinaliza" readonly="" value="<?php echo !empty($campana->fc_finaliza) ? date("d/m/Y", strtotime($campana->fc_finaliza)) : ""  ?>">
							<span for="fechaFinaliza" class="input-group-addon campana"><i class="fa fa-calendar" onclick="$('#fechaFinaliza').focus();"></i></span>
						</div>
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="gl_comentario" class="col-sm-5 control-label"> Comentario: </label>
					<div class="col-sm-4">
						<textarea class="form-control" id="gl_comentario" name="gl_comentario" rows="5" style="resize:none"><?php echo $campana->gl_comentario ?></textarea>
					</div>
				</div>

				<div class="form-group top-spaced">
					<label for="id_campana_estado" class="col-sm-5 control-label"> Estado: </label>
					<div class="col-sm-4">
						<select id="id_campana_estado" name="id_campana_estado" class="form-control">
							<option value="-1">-- Seleccione --</option>
							<option value="1" <?php if ($campana->bo_estado == 1) : ?> selected <?php endif; ?>>Activo
							</option>
							<option value="0" <?php if ($campana->bo_estado == 0) : ?> selected <?php endif; ?>>Inactivo
							</option>
						</select>
					</div>
				</div>

                <!-- Opciones Específicas -->
                <div class="form-group top-spaced">
                    <label for="" class="col-sm-5 control-label">Necesita el Registro de campos Específicos: </label>
                    <div class="col-sm-4">

                        <button class="btn btn-default btn-sm" type="button" onclick="xModal.open('<?php echo BASE_HOST ?>index.php/Mantenedor/Campana/agregarCampoEspecifico/<?php echo $campana->id_campana?>','Agregar Campo Específico','lg')"> Agregar Datos Adicionales </button>
                    </div>
                </div>

                <div class="form-group top-spaced">
                    <div class="col-xs-12">
                        <label>Campos Específicos</label>
                        <?php if ($arrCamposEspecificos):?>
                            <table class="table table-condensed table-bordered small" id="tabla-campos-especificos-edicion-campana">
                                <thead>
                                <tr>
                                    <th width="5%">		N°				</th>
                                    <th width="10%">	Tipo			</th>
                                    <th width="10%">	Nombre			</th>
                                    <th width="10%">	Requisito		</th>
                                    <th width="2%">		Opciones		</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($arrCamposEspecificos as $key => $val) :?>
                                <?php $value = json_decode($val->json_code, true);?>
                                <tr>
                                    <td class="text-center"><?php echo $key + 1 ?></td>
                                    <td class="text-center"><?php echo isset($value['gl_tipo_campo']) ? $value['gl_tipo_campo'] : " -- "; ?></td>
                                    <td class="text-center"><?php echo isset($value['gl_nombre_campo']) ? $value['gl_nombre_campo'] : " -- "; ?></td>
                                    <td><?php /*echo $value['bo_required'] == 1 ? "Obligatorio" : "Opcional"; */?></td>
                                    <td class="text-center">
                                        <?php
                                        if($value['id_tipo_campo'] == 1):?>
                                            <button type="button" data-toggle="tooltip" class="btn btn-xs btn-primary"
                                                    onclick="xModal.open('<?php echo BASE_HOST ?>index.php/Mantenedor/Campana/agregarOpcionesaCriterio/<?php echo $key ?>','Agregar Opciones a Select <?php echo $value['gl_nombre_campo'] ?>','md')"
                                                    data-hasqtip="68" oldtitle="A&ntilde;adir Opci&oacute;nes" data-title="A&ntilde;adir Opci&oacute;nes" aria-describedby="qtip-68">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        <?php endif ?>
                                        <button type="button" onclick="borrarCampoTemporal(<?php echo $key ?>)" data-toggle="tooltip" class="btn btn-xs btn-danger" data-hasqtip="68" oldtitle="Eliminar" data-title="Eliminar" aria-describedby="qtip-68">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        <?php endif;?>
                    </div>
                </div>


				<div class="modal-footer top-spaced" id="btn-terminar">
					<button class="btn btn-success" type="button" onclick="MantenedorCampana.editarCampana(this.form,this);"><i class="fa fa-save"></i>&nbsp; Guardar </button>
					&nbsp;&nbsp;
					<button class="btn btn-danger" type="button" onclick="xModal.close();" id="btn_cerrar"><i class="fa fa-close"></i>&nbsp; Cerrar </button>
				</div>



			</div>
		</div>
	</section>
</form>