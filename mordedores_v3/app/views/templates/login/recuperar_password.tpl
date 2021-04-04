<!DOCTYPE html>
<html lang="es">
	<head>
		{include file="layout/css.tpl"}
		<script> var BASE_URI = '{$base_url}' + '/'; </script>
	</head>
	<body class="body-login">
		<br/><br/><br/>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="login-banner text-center">
						<br/> <img src="{$static}images/logo_minsal.png" />
						<br/> <h1 class="text-center">Prevenci&oacute;n de Femicidios</h1>
					</div>
					<div class="portlet portlet-green">
						<div class="portlet-body">
							<div id="form-success" class="hidden">
								<div id="mensaje-modificacion" class="alert alert-success"></div>
								<button onclick="location.href='{$base_url}'" class="btn btn-lg btn-primary btn-block" type="button">
									Continuar <i class="fa fa-forward"></i>
								</button>
							</div>
							<div id="form-contenedor">
								<form role="form" id="form">
									<fieldset>
										<div class="alert alert-warning">
											Para recuperar su contraseña, ingrese su RUT y le será enviada una nueva contraseña al Email.
										</div>
										<div class="form-group">
											<input type="text" class="form-control" maxlength="12" 
												   onkeyup="formateaRut(this),validaRut(this),this.value = this.value.toUpperCase()"
												   onkeypress ="return soloNumerosYK(event)"
												   name="rut" id="rut" placeholder="Ingrese su Rut"/>
											<br/>
											<div id="form-error" class="alert alert-danger hidden">
												<i class="fa fa-warning fa-2x"></i> &nbsp; No se encontró un usuario para el RUT ingresado.
											</div>
										</div>
										<button id="enviar" class="btn btn-lg btn-primary btn-block" type="button">
											Enviar <i class="fa fa-send"></i>
										</button>   
									</fieldset>
									<br/>

									<div class="form-group">
										<p class="btn btn-lg btn-default btn-block">
											<a href="javascript:location.href='{$base_url}';">Volver</a>
										</p>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		{include file="layout/js.tpl"}
	</body>
</html>