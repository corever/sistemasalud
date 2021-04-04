<?php if(!defined('BASE_PATH')) exit('No permitido acceder a este script');

class Seguridad{

	public static function generar_sha512($string){
		return hash('sha512',$string);
	}

	public static function generar_sha256($string){
		return hash('sha256',$string);
	}

	public static function generar_sha1($string){
		return hash('sha1',$string);
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
        $random     = Seguridad::randomPass();
		$string     = $base.$random.$gl_rut;
        $gl_token   = Seguridad::generar_sha512($string);
		return $gl_token;
	}
	/**
	 * [generaTokenExpediente description]
	 * @return [type] [description]
	 */
	public static function generaTokenExpediente($id_establecimiento,$fc_ingreso,$hora_ingreso){
		$base       = "Mordedores";
        $random     = Seguridad::randomPass();
		$string     = $base.$random.$id_establecimiento.$fc_ingreso.$hora_ingreso;
        $gl_token   = Seguridad::generar_sha512($string);
		return $gl_token;
	}
	/**
	 * [generaTokenExpediente description]
	 * @return [type] [description]
	 */
	public static function generaTokenExpedienteMordedor($id_region,$fc_ingreso){
		$base       = "Mordedores";
        $random     = Seguridad::randomPass();
		$string     = $base.$random.$id_region.$fc_ingreso;
        $gl_token   = Seguridad::generar_sha512($string);
		return $gl_token;
	}

	/**
	 * [generaTokenExpediente description]
	 * @return [type] [description]
	 */
	public static function generaTokenAdjunto($gl_ruta){
		$base       = "Mordedores";
        $random     = Seguridad::randomPass();
		$string     = $base.$random.$gl_ruta;
        $gl_token   = Seguridad::generar_sha512($string);
		return $gl_token;
	}

	public static function generaTokenEstablecimiento($id_establecimiento,$gl_nombre_establecimiento){
		$base       = "Mordedores";
        //$random     = Seguridad::randomPass();
		$string     = $base.$id_establecimiento.$gl_nombre_establecimiento;
        $gl_token   = Seguridad::generar_sha512($string);
		
		return $gl_token;
	}

	public static function validarSesionUsuario($url=null){
		if(Session::getSession('activo') == null){
			if($url){
				Session::setSession('url_redirect',$url);
			}
			header('Location:'.BASE_URI);
			#header('Location:https://midas.minsal.cl/midas/');
		}
	}

	/*
	*  Cambiar RUT por ID dependiendo de la Bandeja donde se ve
	*/
	public static function ocultarRUT($gl_rut, $id_usuario, $bandeja=''){
		if($bandeja == 'Paciente'){
			$rut	= $id_usuario;
		}else if($bandeja == 'Bitacora'){
			$rut	= $id_usuario;
		}else{
			$rut	= $gl_rut;
		}

		return $rut;
	}

	/*
	* Crear Funcion para Censurar datos Sensibles.
	*/
	public static function censurarDato($dato, $perfil, $largo=4){
		
	}

	/*
	public static function validarFuncionPerfil($perfil,$funcion){
		$Loader			= new Loader();
		$daoPerfiles	= $Loader->model('DAOPerfiles');
		return $daoPerfiles->validarPerfilFuncion($perfil,$funcion);
	}
	*/

}