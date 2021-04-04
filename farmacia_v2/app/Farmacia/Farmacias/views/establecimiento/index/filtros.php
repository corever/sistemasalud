<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="card card-primary">
		<div class="card-header">Filtros</div>
		<div class="card-body">
			<form id="formMaestroEstablecimiento" class="form-horizontal">
				<!-- Tipo Establecimiento -->
				<div class="row top-spaced">
					<div class="col-2">
						<label for="id_local_tipo" class="control-label">
							Tipo de Establecimiento
						</label>
					</div>
					<div class="col-4">
						<select class="form-control" id="id_local_tipo" name="id_local_tipo" >
							<option value="">Todos</option>
							<?php foreach($arrTipoEstablecimiento as $tipo): ?>
								<?php	//	Excluído Farm Popular	?>
								<?php if($tipo->local_tipo_id != 7):?>
									<option value="<?php echo $tipo->local_tipo_id; ?>"><?php echo ucwords(mb_strtolower($tipo->local_tipo_nombre)); ?></option>
								<?php endif;?>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<!-- Region -->
				<div class="row top-spaced">
					<div class="col-2">
						<label for="id_region" class="control-label">
							Regi&oacute;n
						</label>
					</div>
					<div class="col-4">
						<select class="form-control" id="id_region" name="id_region" onchange="Region.cargarComunasPorRegion(this.value,'id_comuna',<?php echo (isset($arr->id_comuna))?$arr->id_comuna:''; ?>);">
							<?php if(count($arrRegion)>1): ?>
								<option value="0">Seleccione Región</option>
								<?php foreach($arrRegion as $item): ?>
									<option value="<?php echo $item->id_region_midas ?>"
									<?php echo ($establecimiento->id_region_midas == $item->id_region_midas)?"selected":""; ?> >
										<?php echo $item->nombre_region_corto ?>
									</option>
								<?php endforeach;?>
							<?php else:?>
								<?php foreach($arrRegion as $item): ?>
									<option value="<?php echo $item->id_region_midas ?>" selected>
										<?php echo $item->nombre_region_corto ?>
									</option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
			
				<!-- Comuna -->
					<div class="col-2">
						<label for="id_comuna" class="control-label">
							Comuna
						</label>
					</div>
					<div class="col-4">
						<select class="form-control" id="id_comuna" name="id_comuna" onchange="Region.cambioRegionPorComuna('id_comuna','id_region');Region.cargarLocalidadPorComuna(this.value,'id_localidad',<?php echo (isset($establecimiento->id_localidad))?$establecimiento->id_localidad:''; ?>);">
							<option value="0">Seleccione una Región</option>
						</select>
					</div>
				</div>
			
				<!-- Localidad -->
				<div class="row top-spaced">
					<div class="col-2">
						<label for="id_localidad" class="control-label">
							Localidad
						</label>
					</div>
					<div class="col-4">
						<select class="form-control" id="id_localidad" name="id_localidad" >
							<option value="0">Seleccione una Comuna</option>
						</select>
					</div>

				<!-- Estado -->
					<div class="col-2">
						<label for="local_estado" class="control-label">
							Estado
						</label>
					</div>
					<div class="col-4">
						<select class="form-control" id="local_estado" name="local_estado" >
							<option value="99">Todas</option>
							<option value="1">Habilitado</option>
							<option value="0">Deshabilitado</option>
						</select>
					</div>
				</div>

				<!-- Movil -->
				<div class="row top-spaced">
					<div class="col-2">
						<label for="id_movil" class="control-label">
							Móvil
						</label>
					</div>
					<div class="col-4">
						<select class="form-control" id="id_movil" name="id_movil" >
							<option value="99">Todas</option>
							<option value="1">Si</option>
							<option value="0">No</option>
						</select>
					</div>

				<!-- Popular -->
					<div class="col-2">
						<label for="id_popular" class="control-label">
							Farmacia "Popular"
						</label>
					</div>
					<div class="col-4">
						<select class="form-control" id="id_popular" name="id_popular" >
							<option value="99">Todas</option>
							<option value="1">Si</option>
							<option value="0">No</option>
						</select>
					</div>
				</div>

				<!-- DT Asignado -->
				<div class="row top-spaced">
					<div class="col-2">
						<label for="dt_asignado" class="control-label">
							DT Asignado
						</label>
					</div>
					<div class="col-4">
						<select class="form-control" id="dt_asignado" name="dt_asignado" >
							<option value="99">Todas</option>
							<option value="1">Si</option>
							<option value="0">No</option>
						</select>
					</div>

				<!-- Turno -->
					<div class="col-2">
						<label for="sel_turno" class="control-label">
							Con Turno
						</label>
					</div>
					<div class="col-4">
						<select class="form-control" id="sel_turno" name="sel_turno" >
							<option value="99">Todas</option>
							<option value="1">Si</option>
							<option value="0">No</option>
						</select>
					</div>
				</div>
			</form>
		</div>
		<div class="card-footer text-right">
			<button type="button" class="btn btn-sm btn-warning" onclick="Grilla.limpiar_filtros();" ><i class="fa fa-eraser"></i>
				&nbsp;&nbsp;Limpiar Filtros
			</button>
			
			&nbsp;&nbsp;&nbsp;&nbsp;

			<button type="button" class="btn btn-sm btn-success" id="btn_buscar" onclick="Grilla.cargar(this)"
				data-toggle="tooltip" title="Buscar Establecimiento"><i class="fa fa-search"></i>&nbsp;&nbsp;Buscar
			</button>
		</div>
	</div>
</div>