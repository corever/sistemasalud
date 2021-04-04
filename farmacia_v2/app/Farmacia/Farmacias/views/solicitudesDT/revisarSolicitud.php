<form id="form_datos_personales">
	<div class="card card-primary" style="border-style: solid; border-width: 1px; border-color: #ccdcf9; background: #ddf2ff;">
		<div class="card-header" style="background: #1e77ab;">
			<div class="card-title">
				<h6><b>DATOS PERSONALES</b></h6>
			</div>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="card-body">
			<div class="row top-spaced">
				<div class="col-1">
					<label for="gl_rut" class="control-label ">RUT</label>
				</div>
				<div class="col-5">
					<input readonly type="text" class="form-control"  id="gl_rut" name="gl_rut"/>
				</div>
			</div>
			<div class="row top-spaced">
				<div class="col-1">
					<label for="gl_nombre" class="control-label "><?php echo \Traduce::texto("Nombre"); ?></label>
				</div>
				<div class="col-5">
					<input readonly type="text" class="form-control" id="gl_nombre" name="gl_nombre"/>
				</div>
			</div>
			<div class="row top-spaced">
				<div class="col-1">
					<label for="gl_apellido_paterno" class="control-label "><?php echo \Traduce::texto("Apellido Paterno"); ?></label>
				</div>
				<div class="col-5">
					<input readonly type="text" class="form-control" id="gl_apellido_paterno"  name="gl_apellido_paterno"/>
				</div>
				<div class="col-1">
					<label for="gl_apellido_materno" class="control-label "><?php echo \Traduce::texto("Apellido Materno"); ?></label>
				</div>
				<div class="col-5">
					<input readonly type="text" class="form-control" id="gl_apellido_materno"  name="gl_apellido_materno"/>
				</div>
			</div>
			<div class="row top-spaced">
				<div class="col-1">
					<label for="fc_nacimiento" class="control-label "><?php echo \Traduce::texto("Fecha Nacimiento"); ?></label>
				</div>
				<div class="col-5">
					<div class="input-group">
						<input readonly type="text" data-date-format='yy-mm-dd'  class="form-control float-left datepicker" id="fc_nacimiento" name="fc_nacimiento">
						<div class="input-group-prepend">
							<span class="input-group-text">
							<i class="far fa-calendar-alt"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="col-1">
					<label for="gl_email" class="control-label ">Email</label>
				</div>
				<div class="col-5">
					<input readonly type="text" class="form-control" id="gl_email" name="gl_email" />
				</div>
			</div>
			<div class="row top-spaced">
				<div class="col-1">
					<label for="id_profesion_dt" class="control-label "></label>
				</div>
				<div class="col-5">
					<input readonly class="form-control" id="id_profesion_dt" name="id_profesion_dt" ></input>
				</div>
			</div>
			<div class="row top-spaced">
				<div class="col-1">
					<label class="control-label ">Certificado de título</label>
				</div>
				<div class="col-5">
					<input readonly class="form-control" id="ver_certificado_titulo" name="ver_certificado_titulo"> </input>
				</div>
			</div>
			<div id="div_general_0" class="top-spaced">
				<div id="direccion" class="listaConsultas">
					<div class="row">
					</div>
					<div class="row top-spaced">
						<div class="col-1">
							<label class="control-label ">Región</label>
						</div>
						<div class="col-5">                                
							<input readonly class="form-control" name="gl_region_dt" id="gl_region_dt"></input>                                
						</div>
						<div class="col-1">
							<label class="control-label ">Comuna</label>
						</div>
						<div class="col-5">
							<input readonly name="id_comuna_dt" id="id_comuna_dt" class="form-control"  ></input>                                
						</div>
					</div>
					<div class ="row top-spaced">
						<div class="col-1">
							<label class="control-label ">Dirección</label>
						</div>
						<div class="col-5">
							<input readonly type="text"  class="form-control" name="direccion_dt" id="direccion_dt">
						</div>
						<div class="col-1">
							<label class="control-label ">Teléfono</label>
						</div>
						<div class="col-5">
							<input readonly type="text"  class="form-control" name="telefono_dt" id="telefono_dt">
						</div>
					</div>
					<br>
					<text hidden></text>
				</div>
			</div>
		</div>
	</div>
</form>
<form id="form_datos_farmacia">
	<div class="card card-success" style="border-style: solid; border-width: 1px; border-color: #ccdcf9; background: #ddf2ff;">
		<div class="card-header" style="background: #1e77ab;">
			<div class="card-title">
				<h6><b>DATOS FARMACIA</b></h6>
			</div>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="card-body">
			<div class="row top-spaced">
				<div class="col-1">
					<label class="control-label ">Región</label>
				</div>
				<div class="col-5">
					<input readonly class="form-control" id="id_region_famacia" name="id_region_famacia"></input>
				</div>
				<div class="col-1">
					<label class="control-label ">Comuna</label>
				</div>
				<div class="col-5">
					<input readonly class="form-control" id="id_comuna_farmacia" name="id_comuna_farmacia"></input>
				</div>
			</div>
			<div class ="row top-spaced">
				<div class="col-1">
					<label class="control-label ">Dirección</label>
				</div>
				<div class="col-5">
					<input readonly type="text" class="form-control" name="gl_direccion_farmacia" id="gl_direccion_farmacia">
				</div>
				<div class="col-1">
					<label class="control-label ">Nombre Alternativo</label>
				</div>
				<div class="col-5">
					<input readonly type="text" class="form-control" name="gl_nombre_farmacia" id="gl_nombre_farmacia" >
				</div>
				<br><br>
			</div>
			<div class ="row top-spaced">
				<div class="col-1">
					<label class="control-label ">RUT</label>
				</div>
				<div class="col-5">
					<input readonly  type="text" class="form-control"  id="gl_rut_farmacia" name="gl_rut_farmacia" />
				</div>
				<div class="col-1">
					<label class="control-label ">Número de local</label>
				</div>
				<div class="col-5">
					<input readonly type="text" class="form-control" name="nr_local_farmacia" id="nr_local_farmacia">
				</div>
				<br><br>
			</div>
			<div class ="row top-spaced">
				<div class="col-1">
					<label class="control-label ">Email de contacto</label>
				</div>
				<div class="col-5">
					<input readonly type="text" class="form-control" name="gl_email_farmacia" id="gl_email_farmacia">
				</div>
				<div class="col-1">
					<label class="control-label ">Teléfono</label>
				</div>
				<div class="col-5">
					<input readonly type="text" class="form-control" name="gl_telefono_farmacia"  id="gl_telefono_farmacia"> 
				</div>
				<br><br>
			</div>
		</div>
	</div>
</form>
<form id="form_motivo_solicitud">
	<div class="card card-danger" style="border-style: solid; border-width: 1px; border-color: #ccdcf9;">
		<div class="card-header" style="background: #00a1de">
			<div class="card-title">
				<h6><b>DECLARACION DE SOLICITUD</b></h6>
			</div>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="card-body" style="background: #ddf2ff;">
		</div>
	</div>
	<div class="card card-primary">
		<div class="card-header" style="background: #1e77ab;">
			<h6><b>OBSERVACIONES</b></h6>
		</div>
		<div class="card-body" style="background: #ddf2ff;">
			<div class="col-12">
				<text class="form-control" name="gl_observaciones_registro" id="gl_observaciones_registro" style="border: 0px;background: #ddf2ff;" >OBSERVACION DE TEST</text>
				<br>
			</div>
		</div>
	</div>
</form>
<div class="card card-danger">
	<div class="card-header">
		<h6><b>INDICAR OBSERVACION A LA SOLICITUD</b></h6>
	</div>
	<div class="card-body">
		<div class="col-12">
			<textarea maxlength="1000" class="form-control" name="gl_observaciones_registro" id="gl_observaciones_registro" rows="4" style="resize:none" onkeypress="return soloNumerosYLetras(event)" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"></textarea>
			<br>
		</div>
	</div>
</div>