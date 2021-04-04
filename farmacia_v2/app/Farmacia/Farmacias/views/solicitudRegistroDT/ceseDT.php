<div class="col-12 " style="display: block;" id="contenedor_id_cese_funciones_dt">
	<div class="row top-spaced">
		<div class="col-6">
			<div class="row top-spaced">
				<div class="col-3">
					<label class="required-left">Función que cesa</label>
				</div>
				<div class="col-9">
					<select id="id_cese_funciones" name="id_cese_funciones" class="form-control">
						<option id="0" value="0">Seleccione función</option>
						<option id="1" value="Direccion">Dirección Técnica</option>
						<option id="2" value="Reemplazante">Reemplazante Dirección Técnica</option>
					</select>
				</div>
			</div>
			<div class="row top-spaced">
				<div class="col-3">
					<label class="required-left">Periodo efectivo</label>
				</div>
				<div class="col-9">
					<select id="id_fecha_cese" name="id_fecha_cese" class="form-control">
						<option id="0" value="0">Seleccione tipo de periodo</option>
						<option id="1" value="Temporal">Cese temporal de funciones</option>
						<option id="2" value="Definitivo">Cese definitivo de funciones</option>
					</select>
				</div>
			</div>
			<div class="row top-spaced">
				<div class="col-6">
					<div class="row top-spaced">
						<div class="col-4">
							<label class="control-label required-left">Desde</label>
						</div>
						<div class="col-8">
							<div class="input-group">
								<input type="text" data-date-format='yy-mm-dd'  class="form-control float-left datepicker" id="fc_cese_desde" name="fc_cese_desde" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
								<div class="input-group-prepend">
									<span class="input-group-text">
									<i class="far fa-calendar-alt"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6" id="div_hasta_cese_dt" name="div_hasta_cese_dt">
					<div class="row top-spaced">
						<div class="col-4">
							<label class="control-label required-left">Hasta</label>
						</div>
						<div class="col-8">
							<div class="input-group">
								<input type="text" data-date-format='yy-mm-dd'  class="form-control float-left datepicker" id="fc_cese_hasta" name="fc_cese_hasta" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
								<div class="input-group-prepend">
									<span class="input-group-text">
									<i class="far fa-calendar-alt"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--fin zona izquierda-->
		</div>
		<!--zona derecha-->
		<div class="col-6">
			<div class="row top-spaced">
				<div class="col-3">
					<label class="required-left">Motivo</label>
				</div>
				<div class="col-9">
					<select id="id_motivo_cese" name="id_motivo_cese" class="form-control" onchange="RegistroDT.motivoCese(this.id);">
						<option id="0" value="0">Seleccione motivo</option>
						<option id="1" value="Feriado">Feriado Legal</option>
						<option id="2" value="Licencia">Licencia Médica</option>
						<option id="3" value="Renuncia">Renuncia</option>
						<option id="4" value="Otro">Otro</option>
					</select>
					<div id="contenedor_input_otro_motivo_cese" style="display:none">
						<input type="text" name="gl_otro_motivo_cese_dt" id="gl_otro_motivo_cese_dt" class="form-control" placeholder="Escriba el otro motivo para cesar" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
					</div>
				</div>
			</div>
			<div class="row top-spaced">
				<div class="col-12">
					<div class="col-12">
						<label class="required-left">Dejo los saldos y registros de productos Estupefacientes y Psicotrópicos</label>
						<div class="radio">
							<label>
							<input type="radio" name="cese_saldos_productos" value="Conforme"> Conforme
							</label>
						</div>
						<div class="radio">
							<label>
							<input type="radio" name="cese_saldos_productos" value="Disconforme"> Disconforme
							</label>
						</div>
						<div class="radio">
							<label>
							<input type="radio" name="cese_saldos_productos" value="No existe saldo de medicamentos sujetos a control legal"> No existe saldo de medicamentos sujetos a control legal
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>