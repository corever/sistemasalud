
<?php if(!$local->local_estado):?>
	<?php include_once("app/Farmacia/Farmacias/views/establecimiento/bitacora/deshabilitacion.php");?>
	<br/>
<?php endif;?>

<div class="box box-default bg-gradient-white">
	<div class="box-header with-border bg-gradient-light" onclick="colapsarDivs('cabecera_general')">
		<b>Información General</b>
		<div class="pull-right"><i id="i-cabecera_general" class="fa fa-chevron-down"></i></div>
	</div>
	<div class="box-body with-border" id="cabecera_general">

		<div class="col-md-12 row">
			<!-- Columna Izquierda -->
			<div class="col-md-6 row">
				<div class="col-md-6">
					<label class="control-label">
						N&uacute;mero RCI
					</label>
					<input type="text" class="form-control" value="<?php echo $local->rakin_numero; ?>" readonly/>
				</div>
				<div class="col-md-6">
					<label class="control-label">
						Factor Riesgo
					</label>
					<input type="text" class="form-control" value="<?php echo $local->factor_riesgo; ?>" readonly/>
				</div>
				
				<div class="col-md-6">
					<label class="control-label">
						Nombre del Establecimiento
					</label>
					<input type="text" class="form-control" value="<?php echo $local->local_nombre; ?>" readonly/>
				</div>
				<div class="col-md-6">
					<label class="control-label">
						Número del Establecimiento
					</label>
					<input type="text" class="form-control" value="<?php echo $local->local_numero; ?>" readonly/>
				</div>

				<div class="col-md-6">
					<label class="control-label">
						Tel&eacute;fono
					</label>
					<input type="text" class="form-control" value="<?php echo $local->local_telefono; ?>" readonly/>
				</div>
				<div class="col-md-6">
					<label class="control-label">
						¿Es Franquicia?
					</label>
					<input type="text" class="form-control" value="<?php echo ($local->local_tipo_franquicia)?'Si':'No'; ?>" readonly/>
				</div>
			</div>

			<!-- Columna Derecha -->
			<div class="col-md-6 row">

				<div class="col-md-6">
					&nbsp;
				</div>
				<div class="col-md-6">
					<label class="control-label">
						Fecha de Resolución
					</label>
					<input type="text" class="form-control" value="<?php echo date('d/m/Y',strtotime($local->local_fecha_resolucion)); ?>" readonly/>
				</div>
				
				<div class="col-md-12">
					<label class="control-label">
						Empresa Farmacéutica
					</label>
					<input type="text" class="form-control" value="<?php echo trim($local->gl_farmacia_rut.' '.$local->gl_farmacia_nombre); ?>" readonly/>
				</div>

				<div class="col-md-12">
					<label class="control-label">
						Clasificación
					</label>
					<input type="text" class="form-control" value="<?php echo $local->clasificaciones; ?>" readonly/>
				</div>
			</div>
		</div>

	</div>
</div>

<br/>
<?php if($local->local_tipo_movil):?>
	<div class="box box-default bg-gradient-white">
		<div class="box-header with-border bg-gradient-light" onclick="colapsarDivs('cabecera-direccion')">
			<b>Direcci&oacute;n Recorrido</b>
			<div class="pull-right"><i id="i-cabecera-direccion" class="fa fa-chevron-down"></i></div>
		</div>
		<div class="box-body with-border" id="cabecera-direccion">
			<div class="col-md-12 row">
				<?php include_once("app/Farmacia/Farmacias/views/establecimiento/form_direccion_recorrido.php");?>
			</div>
		</div>
	</div>
<?php else:?>
	<?php include_once("app/Farmacia/Farmacias/views/establecimiento/bitacora/direccion.php");?>
<?php endif;?>


<?php if($local->local_recetario):?>
	<br/>
	<?php include_once("app/Farmacia/Farmacias/views/establecimiento/bitacora/recetario.php");?>
<?php endif;?>

<br/>
<?php include_once("app/Farmacia/Farmacias/views/establecimiento/bitacora/horario.php");?>

<br/>
<?php include_once("app/Farmacia/Farmacias/views/establecimiento/bitacora/pestana_datos.php");?>