<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="https://www.w3.org/1999/xhtml">

    <head>
		<meta name="viewport" content="width=device-width" />	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Solicitud de registro Director Técnico (DT)</title>
	</head>

	<body bgcolor="#FFFFFF" style="width: 100%!important;height: 100%;margin:0;padding:0;font-family:\'Helvetica Neue\', Helvetica, Helvetica, Arial, sans-serif;">
		
	
		<br/>

		<!-- HEADER -->
		<table width="100%" bgcolor="#34346b">
			<tr>
				<td></td>
				<td style="display:block!important;max-width:600px!important;margin:0 auto!important; clear:both!important;" >
	
					<div style="  display:block;margin:0 auto;max-width:600px;padding:15px;">
					    <table width="100%" bgcolor="#34346b">
							<tr>
                                <td></td>
								<td align="center">
									<h6 style="margin:0 !important;padding: 0;color:#bfead2;font-size:14px;font-weight:900;text-transform:uppercase;line-height:1.1;margin-bottom:15px; justify-content:center;">Notificación de MIDAS - Farmacia <strong></strong></h6>
								</td>
							</tr>
					    </table>
					</div>
	
				</td>
				<td></td>
			</tr>
		</table>
        <!-- /HEADER -->
		
		<!-- BODY -->
		<table width="100%">
			<tr>
				<td></td>
				<td style="clear:both !important;display:block !important;margin:0 auto !important;max-width:600px !important;" bgcolor="#FFFFFF">
					<div style="display:block;margin:0 auto;max-width:600px;padding:15px;">
                        <table width="100%">
                            <tr>
                                <td>
                                    <h3 style="color: #00048a;font-size:27px;font-weight:500;line-height:1.1;margin-bottom:15px;">Estimado Usuario,</h3>
                                    <p style="color: #100380;font-size:14px;font-size:17px;font-weight:normal;line-height:1.6;margin-bottom:10px;">Se informa con fecha <strong><?php echo date("Y/m/d"); ?></strong></p>
									<p style="color: #100380;font-size:14px;font-weight:normal;line-height:1.6;margin-bottom:10px;">Que sus datos cumplen con los criterios necesarios para continuar con el proceso de registro. <br>Por favor ingrese sus datos de Director Técnico en el siguiente Link, el cual será revisado por el Encargado Regional.</p>
                                    <!-- Confirmar Email -->
                                    <p style="color: #100380; background-color:#ECF8FF;margin-bottom:15px;padding:15px;font-size:14px;font-weight:normal;line-height:1.6;text-align:center;">
                                        <a style="color:#2BA6CB;font-weight:bold;" href="<?php echo \pan\uri\Uri::getHost()."Farmacia/Farmacias/RegistroDT/registro/request=".$_SESSION[\Constantes::SESSION_BASE]['registroDT']['datosSolicitud']['hash_data']."" ?>">FORMULARIO DE REGISTRO</a>
                                    </p>
									<p style="color: #100380;font-size:14px;font-weight:normal;line-height:1.6;margin-bottom:10px;">Le notificaremos cuando el formulario haya sido aceptado o rechazado. Agregue a su lista de contactos la siguiente casilla de correo: <a href="#">sistemamidas@minsal.cl</a></p>
                                    <!-- /Confirmar Email -->					
                                </td>
                            </tr>
                            <!-- no responder -->
                            <tr>
                                <td style="color: #100380;font-size: 12px;font-weight:normal;line-height:1.6;margin-bottom:10px;" align="center">
                                    Este correo se ha generado de forma automatica. <br/><strong>NO RESPONDER</strong>.
                                </td>
                            </tr>
                            <!-- /no responder -->
                        </table>
					</div>
				</td>
				<td></td>
			</tr>
		</table>
		<!-- /BODY -->
		
		<!-- FOOTER -->
		<table style="clear:both !important;width:100%;">
			<tr>
				<td></td>
				<td style="clear:both !important;display:block !important;margin:0 auto !important;max-width:600px !important;">
	
					<!-- links -->
					<div style="display:block;margin:0 auto;max-width:600px;padding:15px;">
						<table width="100%">
							<tr>
								<td align="center">
									<p style="font-size:14px;font-weight:normal;line-height:1.6;margin-bottom:10px;"> 
										<a style="color:#2BA6CB;" href="https://web.minsal.cl/">Ministerio de salud</a> | 
										<a style="color:#2BA6CB;" href="https://www.gob.cl/">Gobierno de Chile</a>
									</p>
								</td>
							</tr>
						</table>
					</div>
					<!-- /links -->
	
				</td>
				<td></td>
			</tr>
		</table>
		<!-- /FOOTER -->
	</body>
</html>