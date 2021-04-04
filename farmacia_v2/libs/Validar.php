<?php

Class Validar {
    /**
     * 
     * @param string $input
     */
    public static function validarFecha($input) {
        $fecha = DateTime::createFromFormat("d/m/Y", $input);
        if (($fecha instanceof DateTime)) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @param array $parametros
     * @param string $input
     */
    public static function validarVacio($input) {
        if (empty($input)) {
            return false;
        }
        return true;
    }

    /**
     * Valida que la entrada solo contenga espacios y letras
     * @param string $input
     */
    public static function validarSoloEspaciosYLetras($input) {
        if (!preg_match("/^[a-zA-Z äëïöüÄËÏÖÜÿŸáéíóúÁÉÍÓÚñÑàèìòùÀÈÌÒÙâêîôûÂÊÎÔÛ]*$/", $input)) {
            return false;
        }
        return true;
    }
    
    public static function validarSoloEspaciosLetrasYNumeros($input) {
        if (!preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜÿŸáéíóúÁÉÍÓÚñÑàèìòùÀÈÌÒÙâêîôûÂÊÎÔÛ .,]*$/", $input)) {
            return false;
        }
        return true;
    }
        /**
     * Valida que la entrada solo contenga numeros, puntos o guiones
     * @param string $input
     */
    public static function validarSoloNumeros($input) {
        $regexp="/^[0-9.-]*$/";
        if (!preg_match($regexp, $this->_parametros[$input])) {
            return false;
        }
        return true;
    }
    /**
     * Valida que el email sea correcto
     * @param string $input_email
     */
    public static function validarEmail($email) {
        $mail_correcto  = 0;
        if((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
           if((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
              //miro si tiene caracter .
              if(substr_count($email,".")>= 1){
                 //obtengo la terminacion del dominio
                 $term_dom  = substr(strrchr ($email, '.'),1);
                 //compruebo que la terminación del dominio sea correcta
                 if(strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                    //compruebo que lo de antes del dominio sea correcto
                    $antes_dom      = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                    $caracter_ult   = substr($antes_dom,strlen($antes_dom)-1,1);
                    if ($caracter_ult != "@" && $caracter_ult != "."){
                       $mail_correcto   = 1;
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
     * Valida Rut perteneciente a empresa
     * @param string $rut
     * @return boolean
     */
    public static function validarRutEmpresa($rut) {
        if (Validar::validarRut($rut)) {
            $separado = explode("-", $rut);
            if (((int) $separado[0]) > 50000000) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Valida Rut perteneciente a persona
     * @param string $rut
     * @return boolean
     */
    public static function validarRutPersona($rut) {
        if (Validar::validarRut($rut)) {
            $separado = explode("-", $rut);
            if (((int) $separado[0]) < 50000000) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 
     */
    public static function validarRut($rut) {
		if(!empty($rut)){
			$rut	= preg_replace('/[^k0-9]/i', '', $rut);
			$dv		= substr($rut, -1);
			$numero = substr($rut, 0, strlen($rut) - 1);
			$i		= 2;
			$suma	= 0;
			foreach (array_reverse(str_split($numero)) as $v) {
				if ($i == 8)
					$i = 2;

				$suma += $v * $i;
				++$i;
			}

			$dvr = 11 - ($suma % 11);

			if ($dvr == 11)
				$dvr = '0';
			if ($dvr == 10)
				$dvr = 'K';

			if ($dvr == strtoupper($dv)){
				return true;
			}else {
				return false;
			}
        }else {
            return false;
        }
    }

    
	public static function validador($valor, $tipo, $opcion=null){
		$retorno	= '';

		if($tipo == 'numero'){
			if(isset($valor) AND !empty($valor)){
				if(trim($valor) == ''){
					$retorno = 0;
				}else{
					$retorno = intval(trim($valor));
				}
			}else{
				$retorno = 0;
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

		if($tipo == "date"){
			$retorno = '0000-00-00 00:00:00';
			if(isset($valor)){
				if(trim($valor) != ''){
					$parte = explode("/", $valor);
					if(count($parte) > 2){
						$retorno = $parte[2]."-".$parte[1]."-".$parte[0]." 00:00:00";
					}
				}
			}
		}

		if($tipo == "fecha_bd"){
			$retorno = '0000-00-00';
			if(isset($valor)){
				if(trim($valor) != ''){
					$parte	= explode('-', trim($valor));
					if(count($parte) > 2){
						$retorno	= $parte[0].'-'.$parte[1].'-'.$parte[2];
					}
				}
			}
		}

		if($tipo == "signo"){
			if(isset($valor)){
				if(trim($valor) != ""){
					$reemplazo_mayor	= '>';
					$reemplazo_menor	= '<';
					$valor_inicial		= str_replace($reemplazo_mayor,' ',$valor);
					$valor_final		= str_replace($reemplazo_menor,' ',$valor_inicial);
					$valor				= $valor_final;

					return $valor;
				}
			}
		}

		return $retorno;
	}

	public static function revisarString($string){
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

		return $string;
	}	
}