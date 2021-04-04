<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
		<meta name="viewport" content="width=device-width" />	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Confirmar Email - HOPE OPS WEB</title>
	</head>

	<body bgcolor="#FFFFFF" style="width: 100%!important;height: 100%;margin:0;padding:0;font-family:\'Helvetica Neue\', Helvetica, Helvetica, Arial, sans-serif;">
		
		<!-- si no puede ver -->
		<table width="100%">
			<tr>
				<td align="center" style="font-size:10px" >Si no puede ver correctamente este email, <br/> dirijase a la dirección web: <a href="<?php echo \pan\uri\Uri::getHost(); ?>Farmacia/Usuario/Login/verEmail/<?php echo $gl_hash; ?>">VER EMAIL</a></td>
			</tr>
		</table>
		<!-- fin si no puede ver -->
	
		<br/>

		<!-- HEADER -->
		<table width="100%" bgcolor="#999999">
			<tr>
				<td></td>
				<td style="display:block!important;max-width:600px!important;margin:0 auto!important; clear:both!important;" >
	
					<div style="  display:block;margin:0 auto;max-width:600px;padding:15px;">
					    <table width="100%" bgcolor="#999999">
							<tr>
                                <td><img style="max-width:100%;" src="<?php echo \pan\uri\Uri::getHost(); ?>Farmacia/Usuario/Login/marcarVisto/<?php echo $gl_hash ?>" /></td>
								<td align="right">
									<h6 style="margin:0 !important;padding: 0;color:#444444;font-size:14px;font-weight:900;text-transform:uppercase;line-height:1.1;margin-bottom:15px;">Notificación de HOPE <strong><?php echo $resolucion ?></strong></h6>
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
                                    <h3 style="font-size:27px;font-weight:500;line-height:1.1;margin-bottom:15px;">Estimado <?php echo $gl_nombre. " " .$gl_apellido; ?>,</h3>
                                    <p style="font-size:14px;font-size:17px;font-weight:normal;line-height:1.6;margin-bottom:10px;">Se informa con fecha <strong><?php echo $fecha ?></strong></p>
									<p style="font-size:14px;font-weight:normal;line-height:1.6;margin-bottom:10px;">Que se ha creado un usuario con su email. Necesitamos que confirme su dirección de correo electrónico para confirmar que usted es el titular.</p>
                                    <!-- Confirmar Email -->
                                    <p style=" background-color:#ECF8FF;margin-bottom:15px;padding:15px;font-size:14px;font-weight:normal;line-height:1.6;text-align:center;">
                                        <a style="color:#2BA6CB;font-weight:bold;" href="<?php echo $gl_url ?>"> CONFIRMAR EMAIL</a>
                                    </p>
                                    <!-- /Confirmar Email -->					
                                </td>
                            </tr>
                            <!-- no responder -->
                            <tr>
                                <td style="font-size: 12px;font-weight:normal;line-height:1.6;margin-bottom:10px;" align="center">
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
										<a style="color:#2BA6CB;" href="http://www.paho.org/">OPS</a> | 
										<a style="color:#2BA6CB;" href="http://web.minsal.cl/">Ministerio de salud</a> | 
										<a style="color:#2BA6CB;" href="http://www.gob.cl/">Gobierno de Chile</a>
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