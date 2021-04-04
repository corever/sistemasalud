<?php

class DataValidator {

    public static function  validar($valor, $tipo, $opcion=null){
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
						if(count($date) > 2){
							if(strlen($date[0]) < 4) {
								$retorno = $date[2]."-".$date[1]."-".$date[0]." ".$datetime[1];
							} else {
								$retorno = $valor;
							}
						}
					}else{
						$date = explode($separador, $valor);
						if(count($date) > 2){
							if(strlen($date[0]) < 4) {
								$retorno = $date[2]."-".$date[1]."-".$date[0]." 00:00:00";
							} else {
								$retorno = $valor;
							}
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

    public static function  revisarString($string){
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
		$reemplazar[] = "'";
		$reemplazar[] = '"';
		$reemplazar[] = '(';
		$reemplazar[] = ')';
		$reemplazar[] = ' * ';
		//$reemplazar[] = ';';
		//$reemplazar[] = ',';
		
		 $string = str_replace($reemplazar,'',$string);
		 
        return self::Utf8_ansi($string);
    }

    public static function  revisarStringJson($string){
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
		//$reemplazar[] = "'";
		//$reemplazar[] = '"';
		//$reemplazar[] = '(';
		//$reemplazar[] = ')';
		//$reemplazar[] = ' * ';
		//$reemplazar[] = ';';
		//$reemplazar[] = ',';
		
		$string = str_replace($reemplazar,'',$string);
		 
        return self::Utf8_ansi($string);
    }

    public static function  Utf8_ansi($valor='') {
	    $utf8_ansi2 = array(
	    "\u00c0" =>"À",
	    "\u00c1" =>"Á",
	    "\u00c2" =>"Â",
	    "\u00c3" =>"Ã",
	    "\u00c4" =>"Ä",
	    "\u00c5" =>"Å",
	    "\u00c6" =>"Æ",
	    "\u00c7" =>"Ç",
	    "\u00c8" =>"È",
	    "\u00c9" =>"É",
	    "\u00ca" =>"Ê",
	    "\u00cb" =>"Ë",
	    "\u00cc" =>"Ì",
	    "\u00cd" =>"Í",
	    "\u00ce" =>"Î",
	    "\u00cf" =>"Ï",
	    "\u00d1" =>"Ñ",
	    "\u00d2" =>"Ò",
	    "\u00d3" =>"Ó",
	    "\u00d4" =>"Ô",
	    "\u00d5" =>"Õ",
	    "\u00d6" =>"Ö",
	    "\u00d8" =>"Ø",
	    "\u00d9" =>"Ù",
	    "\u00da" =>"Ú",
	    "\u00db" =>"Û",
	    "\u00dc" =>"Ü",
	    "\u00dd" =>"Ý",
	    "\u00df" =>"ß",
	    "\u00e0" =>"à",
	    "\u00e1" =>"á",
	    "\u00e2" =>"â",
	    "\u00e3" =>"ã",
	    "\u00e4" =>"ä",
	    "\u00e5" =>"å",
	    "\u00e6" =>"æ",
	    "\u00e7" =>"ç",
	    "\u00e8" =>"è",
	    "\u00e9" =>"é",
	    "\u00ea" =>"ê",
	    "\u00eb" =>"ë",
	    "\u00ec" =>"ì",
	    "\u00ed" =>"í",
	    "\u00ee" =>"î",
	    "\u00ef" =>"ï",
	    "\u00f0" =>"ð",
	    "\u00f1" =>"ñ",
	    "\u00f2" =>"ò",
	    "\u00f3" =>"ó",
	    "\u00f4" =>"ô",
	    "\u00f5" =>"õ",
	    "\u00f6" =>"ö",
	    "\u00f8" =>"ø",
	    "\u00f9" =>"ù",
	    "\u00fa" =>"ú",
	    "\u00fb" =>"û",
	    "\u00fc" =>"ü",
	    "\u00fd" =>"ý",
	    "\u00ff" =>"ÿ");

	    return strtr($valor, $utf8_ansi2);      

	}
	
    public static function  revisarStringLog($string){
		//$reemplazar[]	= "'";
		$reemplazar[]	= '"';
		$string			= str_replace($reemplazar,'',$string);
		 
        return $string;
    }
	
	public static function validaRut($rut) {
		if(empty($rut)){ return false; }
		if($rut == '-'){ return false; }

		/* Validar que RUT no sea 0-0, 00-0 etc */
		if( preg_match('/^[0]+-[0]{1}$/',$rut) == 1 or preg_match('/^[0]+-[0]{1}$/',$rut) === false ){ return false; }

	    if( strpos($rut,"-") == false ){
	        $RUT[0] = substr($rut, 0, -1);
	        $RUT[1] = substr($rut, -1);
	    }else{
	        $RUT	= explode("-", trim($rut));
	    }

	    $elRut		= str_replace(".", "", trim($RUT[0]));
	    $factor		= 2;
	    $suma		= 0;

	    for($i = strlen($elRut)-1; $i >= 0; $i--):
	        $factor = $factor > 7 ? 2 : $factor;
	        $suma += $elRut{$i}*$factor++;
	    endfor;

	    $resto		= $suma % 11;
	    $dv			= 11 - $resto;

	    if( $dv == 11 ){
	        $dv	= '0';
	    }else if( $dv == 10 ){
	        $dv = "k";
	    }else{
	        $dv = $dv;
	    }

		if($dv == trim(strtolower($RUT[1]))){
			return true;
		}else{
			return false;
		}
	}

	public static function validaNombreArchivo($nombre_adjunto){
		#$arr_permitidos	= array('jpeg','jpg','png','gif','tiff','bmp','pdf','txt','csv','doc','docx','ppt','pptx','xls','xlsx','tar','zip','gzip','rar','7z');
		$arr_permitidos	= array('jpeg','jpg','png','gif','tiff','bmp','pdf','txt','csv','doc','docx','ppt','pptx','xls','xlsx','eml');
		$nombre_adjunto = trim($nombre_adjunto);
		$nombre_adjunto = trim($nombre_adjunto,".");

		$extension		= substr(strrchr($nombre_adjunto, "."), 1); 
		$partes			= explode(".".$extension, $nombre_adjunto); 
		$nombre_adjunto	= $partes[0];
		$extension		= strtolower($extension);

		if($nombre_adjunto == ''){ return false; }
		if($extension == ''){ return false; }
		if(!in_array($extension, $arr_permitidos)){ return false; }
		
		$arr_buscar 	= array(" ","  ","á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ","°","'",'"',',',';','/','%20','..','.','º','&');
		$arr_reemplazar = array("_","_","a","e","i","o","u","n","A","E","I","O","U","N","_","_",'_','_','_','_','_','_','_','_','_');
		
		$nombre_adjunto	= str_replace($arr_buscar,$arr_reemplazar,$nombre_adjunto);
		$nombre_adjunto	= trim($nombre_adjunto,"_");
		$retorno		= $nombre_adjunto.'.'.$extension;

		return strtolower($retorno);
	}
	
	public static function validaFechaBD($fecha)
	{
		if(empty($fecha)){ return '0000-00-00'; }
		if($fecha == '-'){ return '0000-00-00'; }
		if($fecha == '?'){ return '0000-00-00'; }
		
		$fecha		= trim($fecha);
        $fecha		= explode(' ', $fecha);
        $fecha		= $fecha[0];

		$f2			= explode('/', $fecha);
		if(count($f2) == 3){
			if($f2[2] >= '2000'){
				$ff		= $f2[2].'-'.$f2[1].'-'.$f2[0];
				return $ff;
			}else if($f2[0] >= '2000'){
				$ff		= $f2[0].'-'.$f2[1].'-'.$f2[2];
				return $ff;			
			}else{
				return '0000-00-00';
			}

		}else{
			$f		= date_create($fecha);
			if($f){
				$fecha	= date_format($f,'Y-m-d');
				$f3		= explode('-', $fecha);

				if($f3[0] >= '2000'){
					return $fecha;
				}else{
					return '0000-00-00';
				}
			}else{
				return '0000-00-00';
			}
		}
	}

	public static function validarFechaCorrecta($string) {
		//file_put_contents('php://stderr', PHP_EOL . print_r('validarFechaCorrecta', TRUE). PHP_EOL, FILE_APPEND);
		$parte = explode(" ", $string);
		$fecha = $parte[0];
	    $matches = array();
	    //file_put_contents('php://stderr', PHP_EOL . print_r("fecha a validar:", TRUE). PHP_EOL, FILE_APPEND);
	    //file_put_contents('php://stderr', PHP_EOL . print_r($fecha, TRUE). PHP_EOL, FILE_APPEND);
	    $pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/';
	    if (!preg_match($pattern, $fecha, $matches)){
	    	//file_put_contents('php://stderr', PHP_EOL . print_r('fallo 1', TRUE). PHP_EOL, FILE_APPEND);
	    	return false;	
	    }
	    elseif (!checkdate($matches[2], $matches[1], $matches[3])){
	    	//file_put_contents('php://stderr', PHP_EOL . print_r('fallo 2', TRUE). PHP_EOL, FILE_APPEND);
	    	return false;
	    }
	    else{
	    	return true;
	    }
	}

	/* Formatear Rut con puntos y guion */
	public static function formatearRut($rut)
	{
		$rutTmp = explode( "-", $rut );
		return number_format( $rutTmp[0], 0, "", ".") . '-' . $rutTmp[1];
	}

	public static function quitarFormatoRut($rut)
	{
		$strRut = str_replace(".","",$rut);
		$strRut = str_replace("-","",$strRut);
		return $strRut;
	}
}