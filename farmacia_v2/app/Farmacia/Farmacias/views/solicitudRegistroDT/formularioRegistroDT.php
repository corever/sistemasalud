<div class="card card-primary">
	<div class="card-header card-dt-purple">					
		<h5><b>SOLICITUD INSCRIPCION DIRECTOR TÉCNICO - FARMACIA </b></h5>
	</div>
	<div class="card-body">
		<div class="alert alert-info" role="alert" style="background:#6e9fca; border-color: #8fbaca;">
			<i class="fa fa-info-circle"></i> Será contactado, vía email, una vez que se revise y valide la información.
		</div>
		<form id="form_datos_personales">
			<?php	include('datosPersonalesDT.php'); ?>
		</form>
		<form id="form_datos_farmacia">
			<?php   include('datosFarmaciaDT.php'); ?>
		</form>
		<form id="form_motivo_solicitud">
			<?php	
			include('motivoSolicitudDT.php'); ?>
		</form>
		
		<div class="alert alert-warning" style="background: #fdff9c; border-color: #ffd65d;">
			<p style="padding-left:20px" class="text-bold"></p>
			<div class="col-12">
				<div class="radio">
					<label>
					<input type="radio" name="gl_declaracion_registro" id="gl_declaracion_registro" value="SI" checked="">
					Declaro que la información proporcionada en el presente formulario fue registrada en el Libro de Recetas, de acuerdo al Art. 19o Letra c, del D.S. No 466/84 “Aprueba Reglamento de Farmacias, Droguerías, Almacenes Farmacéuticos, Botiquines y Depósitos Autorizados”
					</label>
				</div>
			</div>
		</div>
		<div class="card card-primary">
			<div class="card-header" style="background: #1e77ab;">					
				<h6><b>OBSERVACIONES ADICIONALES</b></h6>
			</div>
			<div class="card-body" style="background: #ddf2ff;">
				<div class="col-12">
					<textarea class="form-control" name="gl_observaciones_registro" id="gl_observaciones_registro" rows="4" style="resize:none" onkeypress="return soloNumerosYLetras(event)" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"></textarea>
					<br>
				</div>
				<div class="top-spaced" id="div_acciones" align="right">
					<button class="btn btn-success" type="button" onclick="RegistroDT.guardarInscripcion(this);"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Guardar"); ?> </button>
				</div>	
			</div>	
		</div>		
	</div>						
</div>