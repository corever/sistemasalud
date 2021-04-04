<?php
	
	function validaRut($rut)
	{
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

	function validaNombreArchivo($nombre_adjunto)
	{
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
		
		return $pass;
	}
    
	/**
	 * [generaTokenUsuario description]
	 * @return [type] [description]
	 */
	function generaTokenUsuario($gl_rut){
		$base       = "Mordedores";
        $random     = randomPass();
		$string     = $base.$random.$gl_rut;
        $gl_token   = generar_sha512($string);
		return $gl_token;
	}
?>