<?php
date_default_timezone_set('America/Santiago');

	function validar($valor, $tipo, $opcion=null){
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
				$retorno = revisarString($retorno);
			}
		}

		if($tipo == "json"){
			if(isset($valor)){
				$retorno = revisarStringJson($valor);
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
							$retorno = $date[2]."-".$date[1]."-".$date[0]." ".$datetime[1];
						}
					}else{
						$date = explode($separador, $valor);
						if(count($date) > 2){
							$retorno = $date[2]."-".$date[1]."-".$date[0]." 00:00:00";
						}
					}
				}
			}
		}

		/**
		 * El tipo fecha_bd recibe fechas que ya tienen el formato de BD,
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
						$retorno = $date[0]."-".$date[1]."-".$date[1]." ".$datetime[1];
					}
				}else{
					$date = explode($separador, $valor);
					if(count($date) > 2){
						$retorno = $date[0]."-".$date[1]."-".$date[1]." 00:00:00";
					}
				}
			}
		}

		/**
		 */
		if($tipo == "fecha_detectar"){
			$datetime 		= explode(" ", $valor);

			if(count($datetime) > 1){
				$date		= $datetime[0];
				$datetime 	= ' '.$datetime[1];
			}else{
				$datetime 	= ' 00:00:00';
				$date		= $valor;
			}

			if(strpos($date,'.')){
				$date   = str_replace('.','-',$date);
			}
			if(strpos($date,'/')){
				$date   = str_replace('/','-',$date);
			}

			if(strpos($date,'-')){
				$arrFecha = explode('-',$date);
				if(count($arrFecha) == 3){
					$date_anio	= $arrFecha[2];
					$anio		= date("Y");
					if(strlen($date_anio) >= 2 || strlen($date_anio) >= 4){
						if(strlen($date_anio) == 2){
							$d = (strlen($arrFecha[0]) == 1) ? '0'.$arrFecha[0]:$arrFecha[0];
							$m = (strlen($arrFecha[1]) == 1) ? '0'.$arrFecha[1]:$arrFecha[1];
							if((int)$date_anio <= (int)substr($anio, -2)){
								$y = '20'.$date_anio;
							}else{
								$y = '19'.$date_anio;
							}
							$date = $y.'-'.$m.'-'.$d;
							if(validateDate($d.'-'.$m.'-'.$y)){
								return ($y <= $anio) ? $date.$datetime : NULL;
							}
						}elseif(strlen($date_anio) == 4 && (int)$date_anio <= (int)$anio && (int)$date_anio >= ((int)$anio - 100) ){
							if(validateDate($date)){
								return date("Y-m-d h:i:s", strtotime($date.$datetime));
							}
						}
					}
				}
			}else{
				return null;
			}
		}

		/**
		 * El tipo fecha_utc recibe fechas con formato 2019-07-17T12:27:18-04:00
		 * Siempre devuelve el formato de datetime
		 */
		if($tipo == "fecha_utc"){
			$retorno = '0000-00-00 00:00:00';
			if(isset($valor) && !empty(trim($valor))){
				$retorno = date("Y-m-d h:i:s", strtotime($valor));
			}
		}

		return $retorno;
	}

	function validateDate($date, $format = 'd-m-Y'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function revisarString($string){
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

    function revisarStringJson($string){
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
		 
        return $string;
    }
	
    function revisarStringLog($string){
		//$reemplazar[]	= "'";
		$reemplazar[]	= '"';
		$string			= str_replace($reemplazar,'',$string);
		 
        return $string;
    }

	/*
	function formatearSoloFecha($fecha){
		$parte = explode("/", $fecha);
		if(count($parte)>2){
			$valor = $parte[2]."-".$parte[1]."-".$parte[0];
		}else{
			return "0000-00-00";
		}
		
		$valor = $parte[2]."-".$parte[1]."-".$parte[0];
		
		return $valor;
	}

	function formatearFecha($fecha){

		$parte = explode("/", $fecha);
		if(count($parte)>2){
			$valor = $parte[2]."-".$parte[1]."-".$parte[0]." 00:00:00";
		}else{
			return "0000-00-00";
		}
		$valor = $parte[2]."-".$parte[1]."-".$parte[0];
		return $valor;
	}

	function formatearFechaHora($fecha){

		$parte = explode("/", $fecha);
		if(count($parte)>2){
			$valor = $parte[2]."-".$parte[1]."-".$parte[0]." 00:00:00";
		}else{
			return "0000-00-00";
		}
		return $valor;
	}

	function formatearFechaHoraBD($fecha){
		$fechaHora = explode(" ",$fecha);
		$parte = explode("/", $fechaHora[0]);
		if(count($parte)>2){
			if(isset($fechaHora[1])){
				$valor = $parte[2]."-".$parte[1]."-".$parte[0]." ".$fechaHora[1];
			}else{
				$valor = $parte[2]."-".$parte[1]."-".$parte[0];
			}
		}else{
			return "0000-00-00";
		}
		return $valor;
	}
	*/

class MySQL 
{

    public	$conexion;
    public	$conexion_log;
	
	private	$total_consultas;

	const	ERROR_SYNTAX		=	1064;
	const	MYSQL_EXCEPTION		=	'MYSQL_EXCEPTION';

	public static $host			=	DB_HOST;
	public static $user			=	DB_USER;
	public static $pass			=	DB_PASS;
	public static $BD			=	DB_NAME;
	public static $port			=	DB_PORT;
	public static $host_MIDAS	=	NULL;
	public static $user_MIDAS	=	NULL;
	public static $pass_MIDAS	=	NULL;
	public static $BD_MIDAS		=	NULL;
	public static $port_MIDAS	=	NULL;

    public function __construct($bo_midas = false){
        if(!isset($this->conexion)){
			if($bo_midas){
				$this->conexion = new mysqli(self::$host_MIDAS,self::$user_MIDAS,self::$pass_MIDAS,self::$BD_MIDAS,self::$port_MIDAS);
				$this->conexion_log = new mysqli(self::$host_MIDAS,self::$user_MIDAS,self::$pass_MIDAS,self::$BD_MIDAS,self::$port_MIDAS);
			}else{	
				$this->conexion = new mysqli(self::$host,self::$user,self::$pass,self::$BD,self::$port);
				$this->conexion_log = new mysqli(self::$host,self::$user,self::$pass,self::$BD,self::$port);
			}
			mysqli_set_charset($this->conexion,"utf8");
		}
    }

    public function consulta($consulta,$data=null){ 
		$this->total_consultas++; 
		$time_inicio = microtime(true);
		$query = $this->_getQueryString($consulta,$data);

		$resultado = $this->conexion->query($query);
		
		if(!$resultado){ 
			$mensaje = 'MySQLI Error: ' . $this->conexion->error;
            file_put_contents('php://stderr', PHP_EOL . print_r("[line 286 - MySqli.php] - Error".$mensaje."::".$consulta, TRUE). PHP_EOL, FILE_APPEND);
            throw new Exception($this->conexion->error);
			//echo "Error".$mensaje."::".$query;
			//echo "Error";
			
			//$logfile=fopen("log_".date("d_m_Y").".csv","a"); 
			//fputs($logfile,date("d-m-Y H:i:s")."// ".$_SESSION['ss_id_usuario']."//".$_SERVER["SCRIPT_FILENAME"]." // ".($consulta)."\n");
            //exit;
		}
		$tiempo_total = ((microtime(true) - $time_inicio));
		
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}		
		
		//$this->consultaLog($consulta,$tiempo_total,$ip);
		
		return $resultado;
	}

	/**
     * 
     * @param string $tabla
     * @param array $parametros
     * @param string $primaria
     * @param int $id
     */
    public function update($tabla,$parametros = array(), $primaria, $id ){
        $sql = "UPDATE " . $tabla . " SET ";
        $set = "";
        $coma = "";
        foreach($parametros as $campo => $valor){
            $set .= $coma. $campo . " = ?";
            $coma = ",";
        }
        
        $where = " WHERE " . $primaria . " = ?";
		$query = $this->_getQueryString($sql . $set . $where, array_merge(array_values($parametros), array($id)));

        return $this->consulta($sql . $set . $where, array_merge(array_values($parametros), array($id)));
    }

	/**
     * obtener query con parametros incluidos
     * @param  [type] $query [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    private function _getQueryString($query,$data=null){
        if($data){
            if(is_array($data)){
                $indexed = $data==array_values($data);
                foreach($data as $k=>$v) {
                    if(is_string($v)) $v="'$v'";
                    if(is_null($v)) $v=" NULL ";
                    if($indexed) $query = preg_replace('/\?/',$v,$query,1);
                    else $query = str_replace(":$k",$v,$query);
                }   
            }else{
                if(is_string($data)) $data="'$data'";
                $query = preg_replace('/\?/',$data,$query,1);
                
            }
             
        }
        $fechas_vacias = array("'0000-00-00 00:00:00'","'0000-00-00'");
        $query = str_replace($fechas_vacias, "null", $query);
		
        return $query;
           
    }

	
	public function consultaLog($consulta,$tiempo,$ip){
	
		//if( strtoupper(substr(trim($consulta),0,6)) != "SELECT"){
	
	
			//revisar si sin consultas simples	
			/*
			if	(	(	strpos($consulta,"tra_opcion") or 
						strpos($consulta,"tra_perfil_opcion") or 
						strpos($consulta,"from region_chile") or
						strpos($consulta,"from comuna_chile") or
						strpos($consulta,"concat_ws(") or
						strpos($consulta,"FROM tipo_instalacion_alimento") or
						strpos($consulta,"select * from tra_beneficio") or
						strpos($consulta,"SELECT * FROM fin_alimentos WHERE tipo_inst_id =") or
						strpos($consulta,"and tra_tramite.cd_estado not in") or
						strpos($consulta,"from tipo_producto") or
						strpos($consulta,"from pais") or
						strpos($consulta,"from presentacion") or
						strpos($consulta,"FROM formatos") or
						strpos($consulta,"auditorias") or
						strpos($consulta,"FROM naturaleza_producto") or
						strpos($consulta,"from tipo_producto") or
						strpos($consulta,"where id_perfil =") or
						strpos($consulta,"FROM entidades_emisoras") or
						strpos($consulta,"from tipo_vehiculo") or
						strpos($consulta,"FROM sustancias_peligrosas") or
						strpos($consulta,"FROM uso_previsto_sqp") or
						strpos($consulta,"from tra_tramite_visita_conclusiones") or
						strpos($consulta,"from seremis") or
						strpos($consulta,"from tipo_instalacion_alimento_atributos") 
					)
				)
			{
				//Si es consulta simple, no se guarda registro	
				return true;
				
			}			
	
			if(!isset($_SESSION['ss_id_usuario'])){
				$usuario = 1;
			}else{
				$usuario = $_SESSION['ss_id_usuario'];
			}		
	
			$arr_partes = explode(" ",trim($consulta));
						
						
			$query = '	INSERT INTO asd_datos_respaldos.auditorias 
								(	id_usuario, 
									fecha_ejecucion, 
									sentencia,
									tipo,
									tiempo,
									ip)
						VALUES 	(	'.$usuario.', 
									now(), 
									"'.revisarStringLog(trim($consulta)).'",
									"'.strtoupper(substr(trim($consulta),0,6)).'",
									'.$tiempo.',
									"'.$ip.'")';
		
			$this->conexion_log->query($query);
			*/
		//}	
	}
	
    public function evento($id_tramite,$id_tipo,$gl_comentario,$firmado=false){
		
		//1: 	Tramite ingresado
		//2:	Modificado
		/*
		if(!isset($_SESSION['ss_id_usuario']) or $gl_comentario == "DIFERENCIA DE ARANCEL"){
			$usuario = 1;
		}else{
			$usuario = $_SESSION['ss_id_usuario'];
		}
		
		if(!$firmado){
			$consulta = "insert into tra_tramite_evento
										(id_tramite,
										id_tipo,
										gl_comentario,
										fc_ingreso,
										id_usuario)
									VALUES
										($id_tramite,
										$id_tipo,
										'$gl_comentario',
										now(),
										".$usuario."
										)";
			
			$resultado = $this->conexion->query($consulta);
		}
		
		$consulta 	= "SELECT gl_origen FROM tra_tramite WHERE id_tramite = $id_tramite";
		
		$resultado 	= $this->conexion->query($consulta);
		$row		= $this->fetch_assoc($resultado);
		
		if($row['gl_origen'] == "CORFO_EE"){
			$this->eventoEEEstado($id_tramite,$usuario,$gl_comentario);
			
			$resp = $this->get_data("http://127.0.0.1/testing/jsonp/sendCambioEstado.php");
		}
		
		if($row['gl_origen'] == "SICEX"){
			$this->eventoSICEX($id_tramite);
		}
		*/
        return true;
    }
	
	public function get_data($url){
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	public function eventoEEEstado($id_tramite,$id_usuario,$gl_comentario){
		/*
		$consulta 	= "SELECT gl_codigo,cd_estado FROM tra_tramite WHERE id_tramite = $id_tramite";
		
		$resultado 	= $this->conexion->query($consulta);
		$row		= $this->fetch_assoc($resultado);
		
		$consulta = "	INSERT INTO tra_evento_ws (	id_tramite,
													fc_ingreso,
													id_usuario,
													id_estado,
													gl_comentario,
													gl_tipo) VALUES (	$id_tramite,
																		now(),
																		$id_usuario,
																		".$row['cd_estado'].",
																		'$gl_comentario',
																		'cambioEstado')";
		
		$resultado 	= $this->conexion->query($consulta);
		*/
		return true;
	}
	
    public function eventoSICEX($id_tramite){
		/*
		include_once('nusoap/lib/nusoap.php');		
		
		//$client = new nusoap_client('https://sicexqa.minsal.cl/minsal/ws_sicex/wservice/IISA/proveedor/IISA.cambioEstado/IISA.cambioEstado.php?wsdl','wsdl');
		$client = new nusoap_client('https://sicexpre.minsal.cl/minsal/ws_sicex/wservice/IISA/proveedor/IISA.cambioEstado/IISA.cambioEstado.php?wsdl','wsdl');
		
		//$consulta 	= "SELECT gl_cuerpo FROM tra_registro_ws WHERE id_tramite = $id_tramite AND gl_funcion = 'confirmacionPago'";
		$consulta 	= "SELECT id_ruce,id_cuerpo FROM tra_tramite WHERE id_tramite = $id_tramite";
		
		$resultado 	= $this->conexion->query($consulta);
		$row		= $this->fetch_assoc($resultado);
		
		//$gl_cuerpo 	= json_decode($row['gl_cuerpo'],true);
		$id_ruce	= $row['id_ruce'];
		$id_cuerpo  = $row['id_cuerpo'];
		
		//print_r($gl_cuerpo);die();
		
		$consulta 	= "SELECT gl_codigo,cd_estado FROM tra_tramite WHERE id_tramite = $id_tramite";
		
		$resultado 	= $this->conexion->query($consulta);
		$row2		= $this->fetch_assoc($resultado);
		
		$param['IISAcambioEstadoConsulta']['cabecera']['idRuce']	= $id_ruce;
		$param['IISAcambioEstadoConsulta']['cabecera']['idCuerpo']	= $id_cuerpo;
		$param['IISAcambioEstadoConsulta']['cabecera']['idTramite']	= $id_tramite;
		$param['IISAcambioEstadoConsulta']['cabecera']['glTramite']	= $row2['gl_codigo'];
		$param['IISAcambioEstadoConsulta']['cabecera']['cdEstado']	= $row2['cd_estado'];
		$param['IISAcambioEstadoConsulta']['cabecera']['fcEstado']	= date("Y-m-d H:m:i");
		
		$json = json_encode($param['IISAcambioEstadoConsulta']['cabecera']);
		//print_r($json);die();
		*/
		
		/*
		$param['IISAcambioEstadoConsulta']['cabecera']['idRuce']	= "20151016IMPS0000021197";
		$param['IISAcambioEstadoConsulta']['cabecera']['idCuerpo']	= "SCI.TR.TR.003|M1.102|DO201510160000001901|4";
		$param['IISAcambioEstadoConsulta']['cabecera']['idTramite']	= "196428";
		$param['IISAcambioEstadoConsulta']['cabecera']['glTramite']	= "196428";
		$param['IISAcambioEstadoConsulta']['cabecera']['cdEstado']	= 5;
		$param['IISAcambioEstadoConsulta']['cabecera']['fcEstado']	= "2015-10-16 11:35:05";
		*/
		//$param = array('idRuce' => '2','param_txt' => 'DVD');
		
		/*
		$result = $client->call('getIISAcambioEstado', $param);
		
		if ($client->fault) {
			$respuesta = $result;
		} else {	// Chequea errores
			$err = $client->getError();
			if ($err) {		// Muestra el error
				$respuesta = $err;
			} else {		// Muestra el resultado
				$respuesta = @json_encode($result);
			}
		}
		
		$ip = $_SERVER["REMOTE_ADDR"];		
		
		$consulta 	= "INSERT INTO tra_registro_ws (fc_ingreso,ip,id_tramite,gl_cuerpo,gl_respuesta,gl_funcion) VALUES (now(),'$ip',$id_tramite,'$json','$respuesta','eventoSICEX')";
		$resultado 	= $this->conexion->query($consulta);
		*/
		
        return true;
    }
	
	function logWS($glfuncion,$idTramite,$arrEntrada,$arrRespuesta){
		/*
		$ip		= $_SERVER["REMOTE_ADDR"];
		
		$sql 	= "INSERT INTO tra_registro_ws
									(	`fc_ingreso`, 
										`ip`, 
										`id_tramite`, 
										`gl_cuerpo`,
										`gl_respuesta`,
										`gl_funcion`
										) 
									VALUES 
									(	now(), 
										'$ip', 
										'$idTramite', 
										'".json_encode($arrEntrada)."',
										'".json_encode($arrRespuesta)."',
										'$glfuncion'
										);";
		
		$result = $this->queryUpdate($sql);
		*/
	}
	
    public function consultaArreglo($consulta){ 
        $this->total_consultas++; 
        $resultado = $this->conexion->query($consulta);

		$arr = array();

		if(!$resultado){ 
			$mensaje = 'MySQLI Error: ' . $this->conexion->error;
            file_put_contents('php://stderr', PHP_EOL . print_r("[line 610 - MySqli.php] - Error".$mensaje."::".$consulta, TRUE). PHP_EOL, FILE_APPEND);
            throw new Exception($this->conexion->error);
			//echo "Error".$mensaje."::".$query;
			//echo "Error";
			
			//$logfile=fopen("log_".date("d_m_Y").".csv","a"); 
			//fputs($logfile,date("d-m-Y H:i:s")."// ".$_SESSION['ss_id_usuario']."//".$_SERVER["SCRIPT_FILENAME"]." // ".($consulta)."\n");
		}else{
			while($row = $this->fetch_assoc($resultado)){
				$arr[] = $row;
			}
		}
		
        return $arr;
    }	
	
    public function queryUpdate($consulta){ 
        $resultado = $this->conexion->query($consulta);
    }		

    public function fetch_array($resultado){
        
        return $resultado->fetch_array();
    }

    public function fetch_assoc($resultado){
    	if(is_bool($resultado)){
    		return false;
    	}
    	else{
    		return $resultado->fetch_assoc();
    	}
    }

   
    public function num_rows($resultado){
        return $resultado->num_rows();
    }

    public function getTotalConsultas(){
        return $this->total_consultas; 
    }
    
    public function getInsertId(){
        return $this->conexion->insert_id; 
    }    
    
    public function dispose(&$resultado){
		$resultado->free_result();
		if($this->conexion->more_results()){
			while($this->conexion->next_result($this->conexion)){
				$resultado->free_result();
			}	
		}	
    }

    public function cerrar_conexion(){
		$this->conexion->close();
        return true;
    }
	
    public function revisarString($string){
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
	
	public function addEvento($id,$id_evento,$txt_consulta=""){
        /*
        global $_SESSION;
        
        $query_original = $txt_consulta;
        
        if(trim($txt_consulta) != ""){
            $arr_split = explode(" ",$txt_consulta);
            if(strtoupper(trim($arr_split[0])) == "CALL"){
                $arr_split = explode("(",$arr_split[1]);
                    $txt_consulta = $arr_split[0];
            }           
        }
        
        $id_usuario = $_SESSION['arr_usr']['USUA_id'];
        
        $query = "CALL spa_sum_ins_evento
                        ('$id', 
                        '$id_evento', 
                        '$id_usuario',
                        '".mysql_real_escape_string($txt_consulta)."',
                        '".mysql_real_escape_string($query_original)."')";

        $rst = $this->consulta($query);
        $this->dispose();
		*/
    }

    public function lastCallError(){
    	return $this->conexion->errno;
    }
}