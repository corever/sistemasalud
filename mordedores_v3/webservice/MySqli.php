<?php

	require "db_config.php";
	date_default_timezone_set('America/Santiago');

	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
	
	/**
	 * [validar verifica el valor de la variable y lo formatea según el tipo indicado.]
	 * @param  [mixed] $valor [variable a evaluar]
	 * @param  string $tipo  	   [tipo de variable a evaluar (numero, auto, string, date)]
	 * @return [mixed]        [variable formateada]
	 */
	function validar($valor, $tipo, $opcion=null){
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
		
		if($tipo == "auto"){
			if(isset($valor)){
				if(trim($valor) == ""){
					return 8;
				}elseif($valor == 0){
					return 8;
				}
			}elseif($valor){
				return 8;
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
		
		if($tipo == "date"){
			$retorno = '0000-00-00 00:00:00';
			if(isset($valor)){
				if(trim($valor) == ""){
					$retorno = "0000-00-00 00:00:00";
				}
				else{
					$fechaHora = explode(" ", $valor);
					if (strpos($fechaHora[0], "/") !== false) {
					    $parte = explode("/", $fechaHora[0]);
					}else{
						$parte = explode("-", $fechaHora[0]);
					}
					if(count($parte)>2){
						$retorno = $parte[2]."-".$parte[1]."-".$parte[0]." 00:00:00";
					}else{
						$retorno = "0000-00-00 00:00:00";
					}
				}
			}else{
				$retorno = "0000-00-00 00:00:00";
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

					$retorno = $valor;
				}
			}
		}

		return $retorno;
	}

	/**
	 * [revisarString limpieza string contra inyecciones SQL]
	 * @param  string  $string    [string a evaluar]
	 * @param  boolean $mayuscula [si es true, pasa el string a mayusculas]
	 * @return string             [string formateado]
	 */
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
	
	/**
	 * [revisarStringLog quita las commillas de un string]
	 * @param  string $string [variable a evaluar]
	 * @return string         [string formateado]
	 */
	function revisarStringLog($string){
		//$reemplazar[] = "'";
		$reemplazar[] = '"';
		
		$string = str_replace($reemplazar,'',$string);
		 
		return $string;
	}		

	/**
	 * [formatearSoloFecha formatea fecha de formato Y/m/d al formato Y-m-d ]
	 * @param  string $fecha [fecha con formato Y/m/d]
	 * @return string        [fecha formateada Y-m-d]
	 */
	function formatearSoloFechaBD($fecha){

		$parte = explode("/", $fecha);
		if(count($parte)>2){
			$valor = $parte[2]."-".$parte[1]."-".$parte[0];
		}else{
			return "0000-00-00";
		}
		
		return $valor;
	}

	/**
	 * [formatearFecha formatea fecha de formato Y/m/d H:i:s al formato Y-m-d ]
	 * @param  [type] $fecha [fecha con formato Y/m/d H:i:s]
	 * @return string        [fecha formateada Y-m-d]
	 */
	function formatearFechaBD($fecha){

		$fecha_hora = explode(" ", $fecha);
		$parte = explode("/", $fecha_hora[0]);
		if(count($fecha_hora) > 1 && count($parte)>2){
			$valor = $parte[2]."-".$parte[1]."-".$parte[0];
		}
		else{
			return "0000-00-00";
		}
		return $valor;
	}

	/**
	 * [formatearFechaHoraBD formatea fecha de formato Y/m/d H:i:s al formato Y-m-d H:i:s ]
	 * @param  [type] $fecha [fecha con formato Y/m/d H:i:s]
	 * @return string        [fecha formateada Y-m-d H:i:s]
	 */
	function formatearFechaHoraBD($fecha, $separador = "/"){

		$fechaHora = explode(" ", $fecha);
		$parte = explode($separador, $fechaHora[0]);
		if(count($fechaHora) > 1 && count($parte)>2){
			$valor = $parte[2]."-".$parte[1]."-".$parte[0]." ".$fechaHora[1];
		}
		else if(count($parte)>2){
			$valor = $parte[2]."-".$parte[1]."-".$parte[0]." 00:00:00";
		}
		else{
			return "0000-00-00 00:00:00";
		}
		return $valor;
	}

	/**
	 * [formatearFechaHora se transforma string en date con el formato indicado]
	 * @param  [string] $fecha [string fecha a formatear]
	 * @param  [string] $fecha [formato de date]
	 * @return [date]          [fecha formateada]
	 */
	function formatearFechaHora($fecha, $formato){
		if(!empty($fecha)){
			$valor = date($formato, strtotime($fecha));
		}else{
			return date($formato, strtotime("0000-00-00"));
		}
		return $valor;
	}

	class MySQL
	{
		public $conexion;
		public $conexion_log;
		private $total_consultas;	
		
		public static $host = DB_HOST;
		public static $host_MIDAS = DB_HOST_MIDAS;
		public static $user = DB_USER;
		public static $user_MIDAS = DB_USER_MIDAS;
		public static $pass = DB_PASS;
		public static $pass_MIDAS = DB_PASS_MIDAS;
		public static $BD 	= DB_NAME;
		public static $BD_MIDAS 	= DB_NAME_MIDAS;
		public static $port	= DB_PORT;
		public static $port_MIDAS	= DB_PORT_MIDAS;
		public $mensaje_error = null;
		public $query_error = null;

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
			$query = $this->_getQueryString($consulta,$data);
			$resultado = $this->conexion->query($query);
			
			if(!$resultado){ 
				$mensaje = 'MySQLI Error: ' . $this->conexion->error;
				$this->mensaje_error = print_r(str_replace("'","",$mensaje), TRUE);
				$this->query_error = '/* '.print_r($query, TRUE).' */';
                file_put_contents('php://stderr', PHP_EOL.print_r($mensaje, TRUE).PHP_EOL, FILE_APPEND);
                file_put_contents('php://stderr', PHP_EOL.print_r($query, TRUE).PHP_EOL, FILE_APPEND);
				//echo "Error".$mensaje."::".$query;
				//echo "Error";
				
				$logfile=fopen("error_log/log_".date("d_m_Y").".csv","a"); 
				fputs($logfile,date("d-m-Y H:i:s").";".($query)."\n");
				//exit;
				throw new Exception('MySQLI Error');
			}else{
				$this->mensaje_error = null;
				$this->query_error = null;
			}
			
			$this->consultaLog($query);
			
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
	        
	        return $this->consulta($sql . $set . $where, array_merge(array_values($parametros), array($id)));
	    }
		
		public function consultaLog($consulta, $tipo_error=0)
		{
			$usuario		= 0;
			$ip_publica		= '0.0.0';
			$ip_privada		= '0.0.0';
			$tipo 			= '';

			if(isset($_SESSION['ss_id_usuario'])){
				$usuario	= $_SESSION['ss_id_usuario'];
			}
			if(!empty($_SERVER['REMOTE_ADDR'])) {
				$ip_publica	= $_SERVER['REMOTE_ADDR'];
			}
			if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
				$ip_privada	= $_SERVER['HTTP_X_FORWARDED_FOR'];
			}

			if($tipo_error == 0){
				$is_select	= stripos($consulta, 'SELECT ');
				$is_insert	= stripos($consulta, 'INSERT ');
				$is_update	= stripos($consulta, 'UPDATE ');
				$is_delete	= stripos($consulta, 'DELETE ');

				if( $is_select !== false ){
					$tipo	= 'SELECT';
				}else if( $is_insert !== false ){
					$tipo	= 'INSERT';
				}else if( $is_update !== false ){
					$tipo	= 'UPDATE';
				}else if( $is_delete !== false ){
					$tipo	= 'DELETE';
				}else{
					$tipo	= 'SELECT';
				}
			}else{
				$tipo		= 'Error '.$tipo_error;
			}
			
			$query			= 'INSERT INTO registro_auditoria
								(
									fk_usuario,
									tipo,
									query,
									ip_publica,
									ip_privada,
									fc_creacion
								)
								VALUES 	
								(	
									'.$usuario.', 
									"'.$tipo.'", 
									"'.revisarStringLog(trim($consulta)).'",
									"'.$ip_publica.'",
									"'.$ip_privada.'",
									now()
								)';

			if($tipo != 'SELECT'){
				$this->conexion_log->query($query);
			}
		}
		
		public function evento($id_sistema, $id_registro, $gl_tipo, $gl_comentario, $json)
		{
			$id_usuario		= 0;
			$ip_publica		= '0.0.0';
			$ip_privada		= '0.0.0';

			if(isset($_SESSION['ss_id_usuario'])){			
				$id_usuario	= $_SESSION['ss_id_usuario'];
			}
			if(!empty($_SERVER['REMOTE_ADDR'])) {
				$ip_publica	= $_SERVER['REMOTE_ADDR'];
			}
			if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip_privada	= $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			
			$consulta		= "INSERT INTO registro_evento
									(
										id_usuario,
										id_sistema,
										id_registro,
										gl_tipo,
										gl_comentario,
										json,
										ip_publica,
										ip_privada
									)
									VALUES
									(
										$id_usuario,
										$id_sistema,
										'$id_registro',
										'$gl_tipo',
										'$gl_comentario',
										'$json',
										'$ip_publica',
										'$ip_privada'
									)";
			
			$resultado		= $this->conexion->query($consulta);

			return true;
		}
		
		public function consultaArreglo($consulta,$data=null){ 
			$this->total_consultas++; 
			$query = $this->_getQueryString($consulta,$data);
			$resultado = $this->conexion->query($query);

			$arr = array();
			
			if($resultado){
				while($row = $this->fetch_assoc($resultado)){
					$arr[] = $row;
				}
				$this->mensaje_error = null;
				$this->query_error = null;
			}else{
				$mensaje = 'MySQLI Error: ' . $this->conexion ->error;
				$this->mensaje_error = print_r(str_replace("'","",$mensaje), TRUE);
				$this->query_error = '/* '.print_r($query, TRUE).' */';
                file_put_contents('php://stderr', PHP_EOL.print_r($mensaje, TRUE).PHP_EOL, FILE_APPEND);
                file_put_contents('php://stderr', PHP_EOL.print_r($query, TRUE).PHP_EOL, FILE_APPEND);
				$logfile=fopen("error_log/log_".date("d_m_Y").".csv","a"); 
				//exit;
				throw new Exception('MySQLI Error');
			}
			$this->consultaLog($query);
			
			return $arr;
		}
		
		public function queryUpdate($consulta){ 
			$resultado = $this->conexion->query($consulta);
		}		

		public function fetch_array($resultado){
			
			return $resultado->fetch_array();
		}

		public function fetch_assoc($resultado){
			return $resultado->fetch_assoc();
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
			$reemplazar[] = "select";
			$reemplazar[] = "insert";
			$reemplazar[] = "update";
			$reemplazar[] = "delete";
			$reemplazar[] = "schema";
			$reemplazar[] = "like";
			$reemplazar[] = "'";
			$reemplazar[] = '"';
			$reemplazar[] = '=';
			$reemplazar[] = '(';
			$reemplazar[] = ')';
			$reemplazar[] = '<';
			$reemplazar[] = '>';
			
			 $string = str_replace($reemplazar,'',$string);
			 
			return $string;
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

	}

