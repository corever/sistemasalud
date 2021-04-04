<?php if(!defined('BASE_PATH')) exit('No se permite acceder a este script');

class Email{

	function __construct(){
		
	}

	/**
	 * Enviar correo electronico
	 * @param  string 	$destinatario		email de destino
	 * @param  string 	$remitente 			email de remitente
	 * @param  string 	$nombre_remitente 	nombre del remitente
	 * @param  string 	$asunto				asunto del email
	 * @param  string 	$mensaje			mensaje del email
	 * @param  array 	$adjuntos			archivos adjuntos en email
	 * @return boolean						TRUE si el email se envia correctamente
	 */
	public static function sendEmail($destinatario,$remitente,$nombre_remitente,$asunto,$mensaje,$adjuntos=null){
		require_once 'phpmailer/class.phpmailer.php';
		
		$mail = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host			= "mail.minsal.cl";			// SMTP server
		//$mail->SMTPDebug	= 2;						// enables SMTP debug information (for testing)
		$mail->SMTPAuth		= true;						// enable SMTP authentication
		$mail->Host			= "mail.minsal.cl";			// sets the SMTP server
		$mail->Port			= 25;						// set the SMTP port for the GMAIL server 465
		$mail->Username		= "sistemas";				// SMTP account username
		$mail->Password		= "siste14S";				// SMTP account password
		$nombre_remitente	= 'midas@minsal.cl';
		$mail->CharSet		= 'utf-8';
		$mail->IsHTML(true);
		$mail->From			= $nombre_remitente;
		$mail->FromName		= 'No responder - Minsal';
		$mail->Subject		= $asunto;
		$mail->AddAddress($destinatario);
		$mail->Body			= $mensaje;

		if($adjuntos){
			if(is_array($adjuntos)){

			}
		}

		if($mail->Send()){
			return true;
		}else{
			return false;
		}
	}
}

?>