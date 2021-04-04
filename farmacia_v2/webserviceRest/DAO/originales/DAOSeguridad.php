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
}