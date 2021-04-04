<div class="box box-default bg-gradient-white">
	<div class="box-header with-border bg-gradient-light" onclick="colapsarDivs('cabecera-direccion')">
		<b>Direcci&oacute;n</b>
		<div class="pull-right"><i id="i-cabecera-direccion" class="fa fa-chevron-down"></i></div>
	</div>
	<div class="box-body with-border" id="cabecera-direccion">

		<div class="col-md-12 row">
			<!-- Columna Izquierda -->
			<div class="col-md-6 row">
				<div class="col-md-12">
					<label class="control-label">
						Regi&oacute;n
					</label>
					<input type="text" class="form-control" value="<?php echo ucwords(strtolower($local->gl_nombre_region)); ?>" readonly/>
				</div>
				<div class="col-md-6">
					<label class="control-label">
						Comuna
					</label>
					<input type="text" class="form-control" value="<?php echo ucwords(strtolower($local->gl_nombre_comuna)); ?>" readonly/>
				</div>
				
				<div class="col-md-6">
					<label class="control-label">
						Localidad
					</label>
					<input type="text" class="form-control" value="<?php echo ucwords(strtolower($local->gl_localidad)); ?>" readonly/>
				</div>
				<div class="col-md-12">
					<label class="control-label">
						Direcci&oacute;n
					</label>
					<input type="text" class="form-control" value="<?php echo $local->local_direccion; ?>" readonly/>
				</div>

				<div class="col-md-6">
					<label class="control-label">
						Latitud
					</label>
					<input type="text" class="form-control" value="<?php echo $local->local_lat; ?>" readonly/>
				</div>
				<div class="col-md-6">
					<label class="control-label">
						Longitud
					</label>
					<input type="text" class="form-control" value="<?php echo $local->local_lng; ?>" readonly/>
				</div>
			</div>

			<!-- Columna Derecha -->
			<div class="col-md-6">
				<div id="mapaDireccion" data-editable="0" style="width:100%;height:300px;"></div>
				<div class="form-group row" style="margin-top: 15px !important;" hidden>
					<label for="gl_latitud_direccion" class="control-label col-sm-2">Latitud</label>
					<div class="col-sm-4">
						<input type="text" name="gl_latitud_direccion" id="gl_latitud_direccion"
							value="<?php echo ($establecimiento->local_lat)?$establecimiento->local_lat:$gl_latitud ?>"
							placeholder="latitud"class="form-control" readonly/>
					</div>
					<label for="gl_longitud_direccion" class="control-label col-sm-2">Longitud</label>
					<div class="col-sm-4">
						<input type="text" name="gl_longitud_direccion" id="gl_longitud_direccion"
							value="<?php echo ($establecimiento->local_lng)?$establecimiento->local_lng:$gl_longitud ?>"
							placeholder="longitud" class="form-control" readonly/>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>