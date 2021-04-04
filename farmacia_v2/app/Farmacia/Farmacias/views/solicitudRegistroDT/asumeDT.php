<div class="col-12" style="display: block;" id="contenedor_id_asume_funciones_dt">
	<div class="row top-spaced">
		<div class="col-6">
			<div class="col-12">
				<div class="row top-spaced">
					<div class="col-3">
						<label class="required-left">Adjuntar declaración</label>
					</div>
					<div class="col-9">
						<?php echo $grillaDeclaracionDT; ?>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="row top-spaced">
					<div class="col-3">
						<label class="required-left">Asume funciones </label>
					</div>
					<div class="col-9">
						<select id="id_funcion_asume" name="id_funcion_asume" class="form-control">
							<option id="0" value="0">Seleccione funcion</option>
							<option id="1" value="Direccion">Dirección Técnica</option>
							<option id="2" value="Reemplazante">Reemplazante Dirección Técnica</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="row top-spaced">
					<div class="col-3">
						<label class="required-left">Motivo </label>
					</div>
					<div class="col-9">
						<select id="id_motivo_asume" name="id_motivo_asume" class="form-control" onchange="RegistroDT.motivoAsume(this.id);">
							<option id="0" value="0">Seleccione motivo</option>
							<option id="1" value="Traslado">Traslado de local</option>
							<option id="2" value="Feriado">Reemplazo feriado legal</option>
							<option id="3" value="Licencia">Reemplazo licencia médica</option>
							<option id="4" value="Otro">Otro</option>
						</select>
						<div id="contenedor_input_otro_motivo_asume" style="display:none">
							<input type="text"  maxlength="40" name="gl_otro_motivo_asume_dt" id="gl_otro_motivo_asume_dt" class="form-control" placeholder="Escriba el motivo" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
						</div>
					</div>
					<!--new-->
				</div>
			</div>
			<!-- fin primer row -->
		
			<!-- fin zona izquierda  -->
		</div>
		<!-- inicio zona derecha -->
		<div class="col-6 top-spaced">
		<div class="col-12">
				<div class="row top-spaced"></div>
				<div class="row top-spaced"></div>
				<div class="row top-spaced">
					<div class="col-3">
						<label class="required-left">Periodo de función </label>
					</div>
					<div class="col-9">
						<select id="id_fecha_asume" name="id_fecha_asume" class="form-control">
							<option id="0" value="0">Seleccione periodo de función</option>
							<option id="1" value="Temporal">Asume temporalmente</option>
							<option id="2" value="Definitiva">Asume definitivamente</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="row top-spaced">
					<div class="col-6">
						<div class="row">
							<div class="col-6">
								<label class="control-label required-left">Desde</label>
							</div>
							<div class="col-6">
								<div class="input-group">
									<input type="text" data-date-format='yy-mm-dd'  class="form-control float-left datepicker" id="fc_asume_desde" name="fc_asume_desde" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
									<div class="input-group-prepend">
										<span class="input-group-text">
										<i class="far fa-calendar-alt"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6" id="div_hasta_asume_dt">
						<div class="row">
							<div class="col-6">
								<label class="control-label required-left">Hasta</label>
							</div>
							<div class="col-6">
								<div class="input-group">
									<input type="text" data-date-format='yy-mm-dd'  class="form-control float-left datepicker" id="fc_asume_hasta" name="fc_asume_hasta" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
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
			</div>
		</div>
		<!-- fin zona derecha -->
	</div>
	<br>
	<!-- fin row principal -->   
	<div class="row top-spaced">
		<div class="col-12">
		<div class="form-group">
				<label for="id_notificacion">Indicar horarios de ejercicio profesional <i>(para habilitar ingreso de horarios haga clic sobre el nombre del(los) día(s) correspondiente(s))</i>:</label>

				<div >&nbsp;</div>
				<table class="table small table-condensed">
					<thead>

					</thead>
					<tbody>
						<tr style="border-line: 0px;">							
							<td style="display:inline-block;max-width: 220px;">
								<input type="checkbox" class="labelauty chk_dia_ejercicio" id="lunes"     name="lunes"    value="lunes"      data-labelauty="LUNES" />
								<div class="input-group date" id="lunes_hora_desde" data-target-input="nearest">
									<input placeholder="DESDE" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_desde_lunes" name="gl_hora_desde_lunes" data-target="#lunes_hora_desde" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#lunes_hora_desde" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
								<div class="input-group date" id="lunes_hora_hasta" data-target-input="nearest">
									<input placeholder="HASTA" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_hasta_lunes" name="gl_hora_hasta_lunes" data-target="#lunes_hora_hasta" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#lunes_hora_hasta" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
							<td style="display:inline-block;max-width: 220px;"> 
								<input type="checkbox" class="labelauty chk_dia_ejercicio" id="martes"     name="lunes"    value="martes"      data-labelauty="MARTES" />
								<div class="input-group date" id="martes_hora_desde" data-target-input="nearest">
									<input placeholder="DESDE" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_desde_martes" name="gl_hora_desde_martes" data-target="#martes_hora_desde" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#martes_hora_desde" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
								<div class="input-group date" id="martes_hora_hasta" data-target-input="nearest">
									<input placeholder="HASTA" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_hasta_martes" name="gl_hora_hasta_martes" data-target="#martes_hora_hasta" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#martes_hora_hasta" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
							</td>
							<td style="display:inline-block;max-width: 220px;">			
								<input type="checkbox" class="labelauty chk_dia_ejercicio" id="miercoles" name="miercoles" value="miercoles"  data-labelauty="MIÉRCOLES" />					
								<div class="input-group date" id="miercoles_hora_desde" data-target-input="nearest">
									<input placeholder="DESDE" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_desde_miercoles" name="gl_hora_desde_miercoles" data-target="#miercoles_hora_desde" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#miercoles_hora_desde" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
								<div class="input-group date" id="miercoles_hora_hasta" data-target-input="nearest">
									<input placeholder="HASTA" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_hasta_miercoles" name="gl_hora_hasta_miercoles" data-target="#miercoles_hora_hasta" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#miercoles_hora_hasta" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
							</td>
							<td style="display:inline-block;max-width: 220px;">		
								<input type="checkbox" class="labelauty chk_dia_ejercicio" id="jueves"    name="jueves"   value="jueves"     data-labelauty="JUEVES" />						
								<div class="input-group date" id="jueves_hora_desde" data-target-input="nearest">
									<input placeholder="DESDE" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_desde_jueves" name="gl_hora_desde_jueves" data-target="#jueves_hora_desde" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#jueves_hora_desde" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
								<div class="input-group date" id="jueves_hora_hasta" data-target-input="nearest">
									<input placeholder="HASTA" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_hasta_jueves" name="gl_hora_hasta_jueves" data-target="#jueves_hora_hasta" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#jueves_hora_hasta" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
							</td>
							<td style="display:inline-block;max-width: 220px;">
								<input type="checkbox" class="labelauty chk_dia_ejercicio" id="viernes"   name="viernes"  value="viernes"    data-labelauty="VIERNES" />
								<div class="input-group date" id="viernes_hora_desde" data-target-input="nearest">
									<input placeholder="DESDE" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_desde_viernes" name="gl_hora_desde_viernes" data-target="#viernes_hora_desde" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#viernes_hora_desde" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
								<div class="input-group date" id="viernes_hora_hasta" data-target-input="nearest">
									<input placeholder="HASTA" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_hasta_viernes" name="gl_hora_hasta_viernes" data-target="#viernes_hora_hasta" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#viernes_hora_hasta" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
							</td>
							<td style="display:inline-block;max-width: 220px;">						
								<input type="checkbox" class="labelauty chk_dia_ejercicio" id="sabados"   name="sabados"  value="sabados"    data-labelauty="SÁBADO" />		
								<div class="input-group date" id="sabados_hora_desde" data-target-input="nearest">
									<input placeholder="DESDE" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_desde_sabados" name="gl_hora_desde_sabados" data-target="#sabados_hora_desde" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#sabados_hora_desde" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
								<div class="input-group date" id="sabados_hora_hasta" data-target-input="nearest">
									<input placeholder="HASTA" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_hasta_sabados" name="gl_hora_hasta_sabados" data-target="#sabados_hora_hasta" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#sabados_hora_hasta" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
							</td>
							<td style="display:inline-block;max-width: 220px;">					
								<input type="checkbox" class="labelauty chk_dia_ejercicio" id="domingos"  name="domingos" value="domingos"   data-labelauty="DOMINGO" />			
								<div class="input-group date" id="domingos_hora_desde" data-target-input="nearest">
									<input placeholder="DESDE" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_desde_domingos" name="gl_hora_desde_domingos" data-target="#domingos_hora_desde" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#domingos_hora_desde" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
								<div class="input-group date" id="domingos_hora_hasta" data-target-input="nearest">
									<input placeholder="HASTA" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_hasta_domingos" name="gl_hora_hasta_domingos" data-target="#domingos_hora_hasta" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#domingos_hora_hasta" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
							</td>
							<td style="display:inline-block;max-width: 220px;">		
								<input type="checkbox" class="labelauty chk_dia_ejercicio" id="festivos"  name="festivos" value="festivos"   data-labelauty="FESTIVO" />						
								<div class="input-group date" id="festivos_hora_desde" data-target-input="nearest">
									<input placeholder="DESDE" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_desde_festivos" name="gl_hora_desde_festivos" data-target="#festivos_hora_desde" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#festivos_hora_desde" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
								<div class="input-group date" id="festivos_hora_hasta" data-target-input="nearest">
									<input placeholder="HASTA" type="text" maxlength="5" class="form-control datetimepicker-input" id="gl_hora_hasta_festivos" name="gl_hora_hasta_festivos" data-target="#festivos_hora_hasta" disabled="" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
									<div class="input-group-append" data-target="#festivos_hora_hasta" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-clock"></i></div>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>