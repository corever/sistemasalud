<?php
/**
 ******************************************************************************
 * Sistema           : wsNotificacionAccidentes
 * 
 * Descripcion       : Modelo para obtener Tokens
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 12/09/2018
 * 
 * @name             DAOSeguridad.php
 * 
 * @version          1.0
 *
 * @author           Pablo Jimenez <pablo.jimenez@cosof.cl>
 * 
 ******************************************************************************
 * !ControlCambio
 * --------------
 * !cProgramador				!cFecha		!cDescripcion 
 * ----------------------------------------------------------------------------
 * 
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
class DAOSeguridad{

	public static function generar_sha256($string){
		return hash('sha256',$string);
	}

	public static function generar_sha512($string){
		return hash('sha512',$string);
	}
	
	/**
	 * [passAleatorio description]
	 * @return [type] [description]
	 */
	public static function randomPass($largo=6){
		$cadena			= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";		
		$longitudCadena	= strlen($cadena);
		$pass			= "";		
		$longitudPass	= $largo;

		for($i = 1 ; $i <= $longitudPass ; $i++){
			$pos	= rand(0,$longitudCadena-1);
			$pass	.= substr($cadena,$pos,1);
		}
		
		return $pass;
	}

    /**
	 * [generaTokenUsuario description]
	 * @return [type] [description]
	 */
	public static function generaTokenUsuario($gl_rut){
		$base       = "Mordedores";
        $random     = DAOSeguridad::randomPass();
		$string     = $base.$random.$gl_rut;
        $gl_token   = DAOSeguridad::generar_sha512($string);
		return $gl_token;
	}
	/**
	 * [generaTokenExpediente description]
	 * @return [type] [description]
	 */
	public static function generaTokenExpediente($id_establecimiento,$fc_ingreso,$hora_ingreso){
		$base       = "Mordedores";
        $random     = DAOSeguridad::randomPass();
		$string     = $base.$random.$id_establecimiento.$fc_ingreso.$hora_ingreso;
        $gl_token   = DAOSeguridad::generar_sha512($string);
		return $gl_token;
	}
	/**
	 * [generaTokenExpediente description]
	 * @return [type] [description]
	 */
	public static function generaTokenExpedienteMordedor($id_region,$fc_ingreso){
		$base       = "Mordedores";
        $random     = DAOSeguridad::randomPass();
		$string     = $base.$random.$id_region.$fc_ingreso;
        $gl_token   = DAOSeguridad::generar_sha512($string);
		return $gl_token;
	}   

	/**
	 * [generaTokenExpediente description]
	 * @return [type] [description]
	 */
	public static function generaTokenAdjunto($gl_ruta){
		$base       = "Mordedores";
        $random     = DAOSeguridad::randomPass();
		$string     = $base.$random.$gl_ruta;
        $gl_token   = DAOSeguridad::generar_sha512($string);
		return $gl_token;
	}

	public static function generarTokenVisita(){
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	      // 32 bits for "time_low"
	      mt_rand(0, 0xffff), mt_rand(0, 0xffff),

	      // 16 bits for "time_mid"
	      mt_rand(0, 0xffff),

	      // 16 bits for "time_hi_and_version",
	      // four most significant bits holds version number 4
	      mt_rand(0, 0x0fff) | 0x4000,

	      // 16 bits, 8 bits for "clk_seq_hi_res",
	      // 8 bits for "clk_seq_low",
	      // two most significant bits holds zero and one for variant DCE1.1
	      mt_rand(0, 0x3fff) | 0x8000,

	      // 48 bits for "node"
	      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
	    );
	}
}