<?php
	
	function validaRut($rut) {
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

	function validaNombreArchivo($nombre_adjunto){
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
	
	function validaFechaBD($fecha)
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

	function validarFechaCorrecta($string) {
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

	function generar_sha1($string){
		return hash('sha1',$string);
	}

	function generar_sha256($string){
		return hash('sha256',$string);
	}

	function generar_sha512($string){
		return hash('sha512',$string);
	}

	/**
	 * [passAleatorio description]
	 * @return [type] [description]
	 */
	function randomPass($largo=6){
		$cadena			= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$longitudCadena	= strlen($cadena);
		$pass			= "";
		$longitudPass	= $largo;

		for($i = 1 ; $i <= $longitudPass ; $i++){
			$pos	= rand(0,$longitudCadena-1);
			$pass	.= substr($cadena,$pos,1);
		}

		return generar_sha512($pass);
	}

	/*function getHash($base,$public_key,$private_key){
		$token	= hash('sha1',date('d/m/Y').$public_key);
		$string	= $base.$token;

		return hash_hmac('sha512',$string,$private_key);
	}*/

	function getHash($base,$public_key,$private_key,$token_ws = ''){
		$token	= hash('sha1',$token_ws.$public_key);
		$string	= $base.$token;

		return hash_hmac('sha512',$string,$private_key);
	}
	
	if(!function_exists('hash_equals'))	{
		function hash_equals($str1, $str2){
			if(strlen($str1) != strlen($str2))
			{
				return false;
			}
			else
			{
				$res = $str1 ^ $str2;
				$ret = 0;
				for($i = strlen($res) - 1; $i >= 0; $i--)
				{
					$ret |= ord($res[$i]);
				}
				return !$ret;
			}
		}
	}

	function getHashUnico($base,$public_key,$private_key){
		$unico	= bin2hex(openssl_random_pseudo_bytes(15));
		$token	= hash('sha1',date('d/m/Y').$public_key);
		$string	= $base.$token.$unico;

		return hash_hmac('sha512',$string,$private_key);
	}

	function getHashDatosGob($base,$public_key,$private_key,$token_ws){
		$token	= hash('sha1',$token_ws.$public_key);
		$string	= $base.$token;

		return hash_hmac('sha512',$string,$private_key);
	}

	/*Crea Calendario para pdf mostrando fechas de vacunacion*/
    function creaCalendario($fecha_ingreso,$fechas,$nr_dosis_inicia=1){
        # definimos los valores iniciales para nuestro calendario
        
        $j = 0;
        foreach($fechas['mes'] as $key => $item){
            if($j==0){
                $diaActual      = $fechas['dia'][$key];
                $mes_actual     = $fechas['mes'][$key];
                $year           = $fechas['ano'][$key];
                $mes_siguiente  = date("n",strtotime($fecha_ingreso."+ 1 month"));
            }
            if($mes_siguiente == $item){
                unset($fechas['dia'][$key]);
                unset($fechas['mes'][$key]);
                unset($fechas['ano'][$key]);
            }
            $j++;
        }

        # Obtenemos el dia de la semana del primer dia
        # Devuelve 0 para domingo, 6 para sabado
        $diaSemana      = date("w",mktime(0,0,0,$mes_actual,1,$year))+7;
        # Obtenemos el ultimo dia del mes
        $ultimoDiaMes   = date("d",(mktime(0,0,0,$mes_actual+1,1,$year)-1));
        $last_cell      = $diaSemana + $ultimoDiaMes;

        $meses          = array(1=> "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                                    "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        
        $calendario = " <table id='calendar' width='100%' border='1' style='page-break-inside:avoid'>
                            <caption> ".$meses[$mes_actual]." ".$year." </caption>
                            <tr>
                                <th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th>
                                <th>Vie</th><th>Sab</th><th>Dom</th>
                            </tr>
                            <tr bgcolor='silver'>";
        $cont       = $nr_dosis_inicia;
        for($i=1;$i<=42;$i++){
            if($i==$diaSemana){
                $day = 1;
            }
            if($i < $diaSemana || $i >= $last_cell){
                $calendario .= "<td>&nbsp;</td>";
            }else{
                if(in_array($day,$fechas['dia'])){
                    //$texto      = ($fechas['dia'][0]==$day)?"- Inicia":"- Vacuna";
                    $texto      = " (".$cont."° Dosis)";
                    $calendario .= "<td class='hoy'>$day $texto</td>";
                    $cont++;
                }else{
                    $calendario .= "<td>$day</td>";
                }
                $day++;
            }
            if($i%7==0){
                $calendario .= "</tr><tr>\n";
            }
        }
        
        $calendario .= "</tr></table>";
        
        return $calendario;
	}
	

	function generaTokenEstablecimiento($id_empresa,$gl_nombre_establecimiento,$nr_rci){
		$base       = "Establecimiento".microtime(true);
        $random     = randomPass();
		$string     = $base.$id_empresa.$gl_nombre_establecimiento.$nr_rci.microtime(true);
        $gl_token   = generar_sha1($string);

		return $gl_token;
	}
	
	/*	Creación de gl_codigo_midas para Establecimientos Farmacéuticos.	*/
	function establecimientoCodigo($id_local){
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

	function checkDateFormat($date){
		if(strpos($date,'.')){
			$date   = str_replace('.','-',$date);
		}
		if(strpos($date,'/')){
			$date   = str_replace('/','-',$date);
		}
		
		if(strpos($date,'-')){
			$arrFecha = explode('-',$date);
			if(count($arrFecha) == 3){
				$date_anio = $arrFecha[2];
				if(strlen($date_anio) >= 2 || strlen($date_anio) >= 4){
					$anio = date("Y");
					if(strlen($date_anio) == 2){
						$d = (strlen($arrFecha[0]) == 1) ? '0'.$arrFecha[0]:$arrFecha[0];
						$m = (strlen($arrFecha[1]) == 1) ? '0'.$arrFecha[1]:$arrFecha[1];
						if((int)$date_anio <= (int)substr($anio, -2)){
							$y = '20'.$date_anio;
						}else{
							$y = '19'.$date_anio;
						}
						$date = $d.'-'.$m.'-'.$y;
						if(validar_format($date)){
							return $date;
						}
					}elseif(strlen($date_anio) == 4 && (int)$date_anio <= (int)$anio && (int)$date_anio >= ((int)$anio - 100) ){
						if(validar_format($date)){
							return $date;
						}
					}
				}
			}
		}

		return $date;
	}

	function validar_format($date, $format = 'd-m-Y'){
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

	function stdToArray($std){
		$arr = array();
		if ($std) {
			foreach ($std as $item) {
				$arr[] = json_decode(json_encode($item),TRUE);
			}
		}
		return $arr;
	}

	function formatearBaseDatosSinComilla($fecha,$separador="-"){
		if(empty($fecha) || is_null($fecha) || $fecha == "NULL"){
			return 'NULL';
		}
		if (strpos($fecha, " ") !== false){
			$time	= explode(" ",$fecha);
			return self::formatearBaseDatos($time[0]) . " " . $time[1];
		}else{
			$fecha	= (strpos($fecha, "/") !== false) ? explode("/",$fecha): explode("-",$fecha);
			//verifico si la fecha ya está en el orden correcto
			if(strlen($fecha[0]) < 4){
				return $fecha[2] . $separador . $fecha[1] . $separador . $fecha[0];
			}else{
				return $fecha[0] . $separador . $fecha[1] . $separador . $fecha[2];
			}
		}
	}
?>