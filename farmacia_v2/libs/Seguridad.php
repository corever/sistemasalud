<?php
//if(!defined('BASE_PATH')) exit('No permitido acceder a este script');

//use HTMLPurifier;
//use HTMLPurifier_Config;
//use \Volnix\CSRF\CSRF 		as CSRF;

class Seguridad{

	public static function generar_sha512($string){
		return hash('sha512',$string);
	}

	public static function generar_sha256($string){
		return hash('sha256',$string);
	}

	public static function generar_base(){
		return \Constantes::SEGURIDAD_BASE;
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

		return Seguridad::generar_sha512($pass);
	}

	/**
	 * [generaTokenUsuario description]
	 * @return [type] [description]
	 */
	public static function generaTokenUsuario($gl_rut){
		$base       = Seguridad::generar_base();
        $random     = Seguridad::randomPass();
		$string     = $base.$random.$gl_rut;
        $gl_token   = Seguridad::generar_sha256($string);
		return $gl_token;
	}
	/**
	 * [generaTokenExpediente description]
	 * @return [type] [description]
	 */
	public static function generaTokenExpediente($region,$rut_trabajador,$fc_denuncia){
		$base       = Seguridad::generar_base();
        $random     = Seguridad::randomPass();
		$string     = $base.$random.$region.$rut_trabajador.$fc_denuncia;
        $gl_token   = Seguridad::generar_sha256($string);
		return $gl_token;
	}
	/**
	 * [generaTokenUsuario description]
	 * @return [type] [description]
	 */
	public static function generaTokenExpedienteDetalle($str){
		$base       = Seguridad::generar_base();
        $random     = Seguridad::randomPass();
		$string     = $base.$random.$str;
        $gl_token   = Seguridad::generar_sha256($string);
		return $gl_token;
	}

	/**
	 * [generaTokenExpediente description]
	 * @return [type] [description]
	 */
	public static function generaTokenAdjunto($gl_ruta){
		$base       = Seguridad::generar_base();
        $random     = Seguridad::randomPass();
		$string     = $base.$random.$gl_ruta;
        $gl_token   = Seguridad::generar_sha256($string);
		return $gl_token;
	}

	/**
	 * [generaTokenEmpresa description]
	 * @return string token único para Empresas
	 */

	public static function generaTokenEmpresa($rut,$gl_nombre){
		$base		=	Seguridad::generar_base();
		$random		=	Seguridad::randomPass();
		$string		=	$base.$rut.$gl_nombre.$random.microtime(true);
		$gl_token	=	Seguridad::generar_sha512($string);

		return $gl_token;
	}

	/**
	 * [generaTokenExpediente description]
	 * @return [type] [description]
	 */
	public static function generaTokenEESS($id_establecimiento){
		$base       = "Establecimiento";
        $random     = Seguridad::randomPass();
		$string     = $base.$random.$id_establecimiento;
        $gl_token   = Seguridad::generar_sha512($string);
		return $gl_token;
	}

	public static function generaTokenEstablecimiento($id_empresa,$gl_nombre_establecimiento,$nr_rci){
		$base       = "Establecimiento".microtime(true);
        $random     = Seguridad::randomPass();
		$string     = $base.$id_empresa.$gl_nombre_establecimiento.$nr_rci.microtime(true);
        $gl_token   = Seguridad::generar_sha1($string);

		return $gl_token;
	}

	/**
	 * [generaTokenUsuario description]
	 * @return [type] [description]
	 */
	public static function generaTokenNotificacion($str){
		$base       = "Notificacion";
        $random     = Seguridad::randomPass();
		$string     = $base.$random.$str;
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
	public static function ocultarRUT($gl_rut, $id_usuario, $ocultar=false){
		if($ocultar){
			$rut	= $id_usuario;
		}else{
			$rut	= $gl_rut;
		}

		return $rut;
	}

	/*
	* Crear Funcion para Censurar datos Sensibles.
	*/
	public static function censurarDato($texto,$rut){

		if (!empty($rut)) {
			$arrExplode	= explode("-",$rut);
			
			if(isset($arrExplode[0]) AND is_numeric($arrExplode[0]) AND intval($arrExplode[0]) < 50000000){
				$texto	= str_repeat("&#9641;",strlen($texto));
			}
		}

		return $texto;
	}

	/*
	public static function validarFuncionPerfil($perfil,$funcion){
		$Loader			= new Loader();
		$daoPerfiles	= $Loader->model('DAOPerfiles');
		return $daoPerfiles->validarPerfilFuncion($perfil,$funcion);
	}
	*/

	public static function getHash($base,$public_key,$private_key){
		$token	= hash('sha1',date('d/m/Y').$public_key);
		$string	= $base.$token;

		return hash_hmac('sha512',$string,$private_key);
	}


	public static function validar($valor, $tipo, $opcion=null){
		$retorno	= '';

		/**
		 * Este tipo de dato debe utilizarse siempre que se quiera obtener
		 * un numero. Puede utilizarse para tipos boolean siempre y cuando
		 * solo interese saber si es 0 o 1.
		 * Si un numero necesita diferenciar el NULL puede enviarse el parametro
		 * 'nullable'. Pero solo si es dato numerico. Si es dato boolean y necesita
		 * diferenciarce los null, es preferible utilizar el tipo de dato 'boolean'
		 */
		if($tipo == 'numero'){
			if(isset($valor) AND !empty($valor)){
				if(trim($valor) == ''){
					$retorno = 0;
				}else{
					$retorno = intval(trim($valor));
				}
			}else{
				if(isset($opcion) && $opcion == 'nullable'){
					$retorno = null;
				}else{
					$retorno = 0;
				}
			}
		}

		/**
		 * devuelve un array de valores numericos
		 */
		if($tipo == 'arr_numero'){
			if(!empty($valor) && is_array($valor)){
				$retorno = array_map(function($n){return intval($n);}, $valor);
			}else{
				$retorno = [];
			}
		}

		/**
		 * Este tipo de dato debe utilziarse solo cuando se quiere hacer una diferencia entre
		 * TRUE, FALSE o NULL
		 */
		if($tipo == 'boolean'){
			if($valor === NULL){
				return 'NULL';
			}
			else{
				if($valor == 1 || $valor == "1" || $valor == "true" || $valor == true){
					return 'TRUE';
				}
				else{
					return 'FALSE';
				}
			}
		}

		if($tipo == "string"){
			if(isset($valor)){
				if(!empty($opcion)){
					if($opcion=='strtoupper'){
						$retorno = strtr(strtoupper(trim($valor)),"àèìòùáéíóúÁÉÍÓÚçñÑäëïöü","ÀÈÌÒÙáéíóúÁÉÍÓÚÇñÑÄËÏÖÜ");
					}else if($opcion=='strtolower'){
						$retorno = strtr(strtolower(trim($valor)),"àèìòùáéíóúÁÉÍÓÚçñÑäëïöü","ÀÈÌÒÙáéíóúÁÉÍÓÚÇñÑÄËÏÖÜ");
					}else{
						$retorno = strtr(trim($valor),"àèìòùáéíóúÁÉÍÓÚçñÑäëïöü","ÀÈÌÒÙáéíóúÁÉÍÓÚÇñÑÄËÏÖÜ");
					}
				}else{
					$retorno = strtr(trim($valor),"àèìòùáéíóúÁÉÍÓÚçñÑäëïöü","ÀÈÌÒÙáéíóúÁÉÍÓÚÇñÑÄËÏÖÜ");
				}
				$retorno = self::revisarString($retorno);
			}
		}

		/**
		 * devuelve un array de valores string
		 */
		if($tipo == 'arr_string'){
			if(!empty($valor) && is_array($valor)){
				$retorno = array_map(function($n){return Seguridad::validar($n, 'string');}, $valor);
			}else{
				$retorno = [];
			}
		}

		if($tipo == "json"){
			if(isset($valor)){
				$retorno = self::revisarStringJson($valor);
			}
		}

		/**
		 * El tipo date acepta en la opción envíar el tipo de separador de la fecha
		 * Formatos de fecha aceptados para este tipo:
		 * 	   DD/MM/AAAA HH:MM:SS
		 * 	   DD-MM-AAAA HH:MM:SS
		 *
		 * Siempre devuelve el formato de datetime. Si el campo mysql es date, cortará la hora.
		 */
		if($tipo == "date"){
			$retorno = '0000-00-00 00:00:00';
			$separador = (!empty($opcion)) ? $opcion : '/';
			if(isset($valor)){
				if(trim($valor) != ''){
					$datetime = explode(" ", $valor);
					if(count($datetime) > 1){
						$date = explode($separador, $datetime[0]);
						if(count($date) >= 2){
							$retorno = $date[2]."-".$date[1]."-".$date[0]." ".$datetime[1];
						}
					}else{
						$date = explode($separador, $valor);
						if(count($date) >= 2){
							$retorno = $date[2]."-".$date[1]."-".$date[0];
						}
					}
				}
			}
		}

		/**
		 * El tipo fecha_bd acepta recibe fechas que ya tienen el formato de BD,
		 * pero no tienen el separador adecuado.
		 * Por defecto, buscará el separador '/', pero también acepta la opción para indicar
		 * de separador que debe reemplazarse por '-'
		 * Formatos de fecha aceptados para este tipo:
		 * 	   AAAA/MM/DD HH:MM:SS
		 * 	   AAAA-MM-DD HH:MM:SS
		 *
		 * Siempre devuelve el formato de datetime. Si el campo mysql es date, cortará la hora.
		 */
		if($tipo == "fecha_bd"){
			$retorno = '0000-00-00 00:00:00';
			$separador = (!empty($opcion)) ? $opcion : '/';
			if(isset($valor)){
				$datetime = explode(" ", $valor);
				if(count($datetime) > 1){
					$date = explode($separador, $datetime[0]);
					if(count($date) > 2){
						$retorno = $date[0]."-".$date[1]."-".$date[2]." ".$datetime[1];
					}
				}else{
					$date = explode($separador, $valor);
					if(count($date) > 2){
						$retorno = $date[0]."-".$date[1]."-".$date[2]." 00:00:00";
					}
				}
			}
		}

		return $retorno;
	}

	/**
	 * [revisarString función para sanitizar strings y prevenir SQL-injections]
	 * @param  [type] $string     [description]
	 * @param  array  $reemplazar [description]
	 * @return [type]             [description]
	 */
    public static function revisarStringJson($string, $reemplazar){
		$reemplazar[] = '`';
		$reemplazar[] = 'select ';
		$reemplazar[] = 'SELECT ';
		$reemplazar[] = 'insert ';
		$reemplazar[] = 'INSERT ';
		$reemplazar[] = 'update ';
		$reemplazar[] = 'UPDATE ';
		$reemplazar[] = 'delete ';
		$reemplazar[] = 'DELETE ';
		$reemplazar[] = 'schema ';
		$reemplazar[] = 'SCHEMA ';
		$reemplazar[] = 'create ';
		$reemplazar[] = 'CREATE ';
		$reemplazar[] = 'drop ';
		$reemplazar[] = 'DROP ';

		$reemplazar[] = ' from ';
		$reemplazar[] = ' FROM ';
		$reemplazar[] = ' where ';
		$reemplazar[] = ' WHERE ';
		$reemplazar[] = ' and ';
		$reemplazar[] = ' AND ';
		$reemplazar[] = ' having ';
		$reemplazar[] = ' HAVING ';
		$reemplazar[] = ' case ';
		$reemplazar[] = ' CASE ';
		$reemplazar[] = ' when ';
		$reemplazar[] = ' WHEN ';
		$reemplazar[] = ' end ';
		$reemplazar[] = ' END ';
		$reemplazar[] = ' if ';
		$reemplazar[] = ' IF ';
		$reemplazar[] = ' or ';
		$reemplazar[] = ' OR ';
		$reemplazar[] = ' else ';
		$reemplazar[] = ' ELSE ';
		$reemplazar[] = ' union ';
		$reemplazar[] = ' UNION ';

		$reemplazar[] = ' like';
		$reemplazar[] = ' LIKE';
		$reemplazar[] = ' concat';
		$reemplazar[] = ' CONCAT';
		$reemplazar[] = ' count';
		$reemplazar[] = ' COUNT';
		$reemplazar[] = ' rand';
		$reemplazar[] = ' RAND';
		$reemplazar[] = ' floor';
		$reemplazar[] = ' FLOOR';
		$reemplazar[] = '=';
		$reemplazar[] = '(';
		$reemplazar[] = ')';
		$reemplazar[] = ' * ';
		
		$string = str_replace($reemplazar,'',$string);
		 
        return self::sanitizeHtml($string);
    }

    /**
	 * [revisarString función para sanitizar strings y prevenir SQL-injections]
	 * A diferencia de revisarStringJson, quita tambien las comas y las comillas
	 * @param  [type] $string     [description]
	 * @param  array  $reemplazar [description]
	 * @return [type]             [description]
	 */
    public static function revisarString($string, $reemplazar = array()){
		$reemplazar[] = "'";
		$reemplazar[] = '"';
		$reemplazar[] = ';';
		$reemplazar[] = ',';

        return self::revisarStringJson($string, $reemplazar);
    }

    /**
     * [sanitizeHtml: funcion para limpiar strings de etiquetas html que puedan probocar un ataque XSS
     * @docs https://desarrolloweb.com/articulos/validar-filtrar-html-purifier.html
     *       https://blog.liplex.de/prevent-xss-through-html-sanitization-with-html-purifier/
     *       https://manuais.iessanclemente.net/index.php/Evitar_ataques_XSS_y_CSRF_con_PHP
     *       composer require ezyang/htmlpurifier --ignore-platform-reqs
     * @param  [type] $string [description]
     * @return [type]         [description]
     */
    public static function sanitizeHtml($string){
    	/*
    	//$purifier_config->set('Cache.SerializerPath', file_directory_temp());
    	$config = HTMLPurifier_Config::createDefault();
    	// Remove this after you configured your final set
        $config->set('Cache.DefinitionImpl', null);
        
        $config->set('Core.Encoding', 'UTF-8');

        $allowedElements = [
            'p[style]',
            'br',
            'b',
            'strong',
            'i',
            'em',
            's',
            'u',
            'ul',
            'ol',
            'li',
            'span[style|class|data-custom-id|contenteditable]',
            'table[style|class|border|cellpadding|cellspacing]',
            'th[style|class]',
            'thead[style|class]',
            'tbody[style|class]',
            'tr',
            'td[style|class|valign]',
            'div[style|class]',
            'img[src|style|class]',
        ];

        $config->set('HTML.Allowed', implode(',', $allowedElements));

        $def = $config->getHTMLDefinition(true);
        $def->addAttribute('span', 'data-custom-id', 'Text');
        $def->addAttribute('span', 'contenteditable', 'Text');

    	$htmlPurifier = new HTMLPurifier($config);
    	return $htmlPurifier->purify($string);*/
    	return htmlspecialchars(strip_tags($string, '<div><br><img><table><tr><th><td><tbody><thead>'));;
    }


    /**
     * [validarPost description]
     * @docs https://github.com/volnix/csrf
     *       https://www.phpcentral.com/pregunta/538/evitar-ataques-csrf-en-formularios-debate
     *       https://es.wikihow.com/evitar-ataques-CSRF-(falsificación-de-petición-en-sitios-cruzados)-con-PHP
     *       https://github.com/symfony/security-csrf	
     * @todo - agregar función para activar o desactivar csrf
     *       - ¿usar función $request->isAjax()?
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
	public static function validarPost($parametros){
		/*
		$token_name = CSRF::getTokenName();
		//file_put_contents('php://stderr', PHP_EOL . print_r("token_name", TRUE). PHP_EOL, FILE_APPEND);
		//file_put_contents('php://stderr', PHP_EOL . print_r($token_name, TRUE). PHP_EOL, FILE_APPEND);
		if(array_key_exists($token_name, $parametros)){
			if(!CSRF::validate($parametros)){
				//file_put_contents('php://stderr', PHP_EOL . print_r("TOKEN CSRF INVÁLIDO - 01", TRUE). PHP_EOL, FILE_APPEND);
				header('HTTP/1.1 401 Unauthorized');
				die();
			}
		}
		else if(array_key_exists("inputs_hidden", $parametros) && array_key_exists($token_name, $parametros["inputs_hidden"])){
			if(!CSRF::validate($parametros["inputs_hidden"])){
				//file_put_contents('php://stderr', PHP_EOL . print_r("TOKEN CSRF INVÁLIDO - 02", TRUE). PHP_EOL, FILE_APPEND);
				header('HTTP/1.1 401 Unauthorized');
				die();
			}
		}
		else if(array_key_exists("HTTP_X_CSRF_TOKEN", $_SERVER)){
			if(!CSRF::compare(CSRF::getToken(), $_SERVER["HTTP_X_CSRF_TOKEN"])){
				//file_put_contents('php://stderr', PHP_EOL . print_r("TOKEN CSRF INVÁLIDO - 03", TRUE). PHP_EOL, FILE_APPEND);
				header('HTTP/1.1 401 Unauthorized');
				die();
			}
		}
		else{
			//file_put_contents('php://stderr', PHP_EOL . print_r("TOKEN CSRF NO ENCONTRADO", TRUE). PHP_EOL, FILE_APPEND);
			//file_put_contents('php://stderr', PHP_EOL . print_r($parametros, TRUE). PHP_EOL, FILE_APPEND);
			//file_put_contents('php://stderr', PHP_EOL . print_r($_SERVER, TRUE). PHP_EOL, FILE_APPEND);

			header('HTTP/1.1 401 Unauthorized');
			//header('Location: ' . \pan\uri\Uri::getHost());
			die();
		}*/
		
		
	}


	public static function validarCamposDinamicos($json_campos_dinamicos){
		$campos_dinamicos = json_decode($json_campos_dinamicos, true);
		$result = array();
		if(!empty($campos_dinamicos) && is_array($campos_dinamicos)){
			foreach ($campos_dinamicos as $campo) {
				file_put_contents('php://stderr', PHP_EOL . print_r($campo, TRUE). PHP_EOL, FILE_APPEND);
				if(!empty($campo["validar"])){
					$valor_campo = null;
					if($campo["type"] == "select-multiple"){
						if(!isset($result[$campo["name"]])){
							$valor_campo = array();
						}
						$valor_campo[] = Seguridad::validar($campo["value"], $campo["validar"]);
					}else{
						$valor_campo = Seguridad::validar($campo["value"], $campo["validar"]);
					}
				}else{
					if($campo["type"] == "number" || $campo["type"] == "select-one"){
						$valor_campo = Seguridad::validar($campo["value"], 'numero');
					}
					else if($campo["type"] == "select-multiple"){
						$valor_campo = Seguridad::validar($campo["value"], 'arr_numero');
					}
					else if($campo["type"] == "checkbox"){
						$checkbox_value = Seguridad::validar($campo["value"], 'string');
						if($checkbox_value == 'off'){
							$valor_campo =  0;
						}
						else{
							$valor_campo = intval($campo["value"]);
						}
					}
					else{
						$valor_campo = Seguridad::validar($campo["value"], 'string');
					}
				}

				$result[$campo["name"]] = array(
					"value"	=> $valor_campo,
					"label"	=> Seguridad::validar($campo["label"], 'string'),
					"type"	=> Seguridad::validar($campo["type"], 'string'),
				);
				if(!empty($campo["option_label"])){
					if(is_array($campo["option_label"])){
						$option_label = Seguridad::validar($campo["option_label"], 'arr_string');
					}
					else{
						$option_label = Seguridad::validar($campo["option_label"], 'string');
					}
					$result[$campo["name"]]["option_label"] = $option_label;
				}
			}
		}
		return $result;
	}

	/* Generar Hash con una base + string o id clave */
	public static function hashBaseClave($base,$clave){
		$token	= hash('sha1',$base.$clave);
		return $token;
	}

	/*	Creación de gl_codigo_midas para Establecimientos Farmacéuticos.	*/
	public static function establecimientoCodigo($id_local){
		$cero					=	'';
		if($id_local <= 9){
			$cero				=	'0000';
		}else if($id_local <= 99){
			$cero				=	'000';
		}else if($id_local <= 999){
			$cero				=	'00';
		}else if($id_local <= 9999){
			$cero				=	'0';
		}
		$gl_codigo_midas		=	'FA'.$cero.$id_local;

		return	$gl_codigo_midas;
	}
}