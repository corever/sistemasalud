<?php //if(!\Constantes::URL_LINK) exit('No se permite acceder a este script');

include_once('phpmailer/class.phpmailer.php');
class Email{

	function __construct(){

	}

	/**
	 * Enviar correo electronico
	 * @return boolean						TRUE si el email se envia correctamente
	 */
	public static function sendEmail($to, $asunto, $mensaje, $cc = null, $bcc = null, $adjuntos = null) {

		try {

			$mail				= new PHPMailer();
			$remitente			= 'No responder - MINSAL';
			$nombre_remitente	= 'sistemamidas@minsal.cl';
			$respuesta			= array("correcto" => FALSE, "error" => "");

			$mail->IsSMTP(); 								// telling the class to use SMTP
			//$mail->SMTPDebug	= 2;						// enables SMTP debug information (for testing)
			$mail->SMTPAuth		= true;						// enable SMTP authentication
			$mail->Host			= "mail.minsal.cl";			// sets the SMTP server
			$mail->Port			= 25;						// set the SMTP port for the GMAIL server 465
			$mail->Username		= "sistemamidas";			// SMTP account username
			$mail->Password		= "Minsal.2018";			// SMTP account password
			$mail->CharSet		= 'utf-8';
			$mail->IsHTML(true);
			$mail->From			= $nombre_remitente;
			$mail->FromName		= $remitente;
			$mail->Subject		= $asunto;
			$mail->Body			= $mensaje;

			//Destinatario
			//Usar validar_email($email);
			if(isset($to) && $to!=null){
				if(is_array($to)){
					foreach($to as $email => $name){
						if (self::validar_email($email)) {
							$mail->AddAddress($email, $name);
						}
					}
				}elseif(is_string($to)){
					if (self::validar_email($to)) {
						$mail->AddAddress($to);
					}
				}
			}
			//Con Copia
			if(isset($cc) && $cc!=null){
				if(is_array($cc)){
					foreach($cc as $email => $name){
						$mail->AddBCC($email, $name);
					}
				}else{
					$mail->AddAddress($cc);
				}
			}
			//Con Copia Oculta
			if(isset($bcc) && $bcc!=null){
				if(is_array($bcc)){
					foreach($bcc as $email => $name){
						$mail->AddBCC($email, $name);
					}
				}else{
					$mail->AddAddress($bcc);
				}
			}
			//$mail->AddBCC('andrea.arancibia@cosof.cl', 'Andrea Arancibia');
			//$mail->AddBCC('pr.henriquezr@gmail.com', 'Priscila Henriquez');
			//$mail->AddBCC('victor.retamal@cosof.cl', 'Victor Retamal');
			//$mail->AddBCC('david.guzman@cosof.cl', 'David Guzmán');
			if($adjuntos){
				if(is_array($adjuntos)){
					foreach($adjuntos as $key => $adjunto){
						$mail->AddAttachment($adjunto);
					}
				}else{
					$mail->AddAttachment($adjuntos);
				}
			}

			if($mail->Send()){
				$respuesta["correcto"] = TRUE;
			}else{
				// guardar registro de error en envio de email
				$respuesta["error"]		= "Error al enviar email";
				$respuesta["correcto"] 	= FALSE;
			}
		} catch (phpmailerException $e) {
			// guardar registro de error en envio de email
			$respuesta["error"] 	= $e->errorMessage();
			$respuesta["correcto"] 	= FALSE;
		} catch (Exception $e) {
			// guardar registro de error en envio de email
			$respuesta["error"] 	= $e->getMessage();
			$respuesta["correcto"] 	= FALSE;
		}

		return $respuesta;
	}

	// Validar Email
	public static function validar_email($email){
		$mail_correcto	= 0;
		if((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
		   if((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
			  //miro si tiene caracter .
			  if(substr_count($email,".")>= 1){
				 //obtengo la terminacion del dominio
				 $term_dom	= substr(strrchr ($email, '.'),1);
				 //compruebo que la terminación del dominio sea correcta
				 if(strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
					//compruebo que lo de antes del dominio sea correcto
					$antes_dom		= substr($email,0,strlen($email) - strlen($term_dom) - 1);
					$caracter_ult	= substr($antes_dom,strlen($antes_dom)-1,1);
					if ($caracter_ult != "@" && $caracter_ult != "."){
					   $mail_correcto	= 1;
					}
				 }
			  }
		   }
		}

		if($mail_correcto){
		   return true;
		}else{
		   return false;
		}
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
	public static function sendEmail_pass($destinatario,$remitente,$nombre_remitente,$asunto,$mensaje,$adjuntos=null){
		require_once 'phpmailer/class.phpmailer.php';
		
		$mail = new \PHPMailer();
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
		//$mail->AddAddress($destinatario);
		$mail->Body			= $mensaje;

		if($adjuntos){
			if(is_array($adjuntos)){

			}
		}

		if(isset($destinatario) && $destinatario!=null){
			if(is_array($destinatario)){
				foreach($destinatario as $email => $name){
					if (self::validar_email($email)) {
						$mail->AddAddress($email, $name);
					}
				}
			}elseif(is_string($destinatario)){
				if (self::validar_email($destinatario)) {
					$mail->AddAddress($destinatario);
				}
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