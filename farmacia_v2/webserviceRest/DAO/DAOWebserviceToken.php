<?php
/**
 ******************************************************************************
 * Sistema           : WSBase
 * 
 * Descripcion       : Modelo para obtener Usuarios
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 07/07/2018
 * 
 * @name             DAOUsuario.php
 * 
 * @version          1.0
 *
 * @author           Victor Retamal <victor.retamal@cosof.cl>
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
class DAOWebserviceToken{

	protected $_tabla			=	TABLA_ACCESO_SISTEMA_TOKEN;
	protected $_primaria		=	"id_webservice_token";
	protected $_transaccional	=	false;
	protected $_conn			=	null;
	protected $_respuesta		=	array();

	function __construct($conn = null) {
		/*
		if($conn !== null){
			$this->_conn =  $conn;
		}else{
			$this->_conn =  new MySQL();
		}
		*/
		$this->_conn =  new MySQL();
	}

	public function getLista(){
		$query	= "	SELECT * FROM ".$this->_tabla;
		$result = $this->_conn->consultaArreglo($query);
		
		if(!empty($result)){
			return $result;
		}else{
			return NULL;
		}
	}

	public function getById($id_usuario){
		$id_usuario	= validar($id_usuario,'numero');
		
		if(!empty($id_usuario)){
			$query	= "	SELECT * FROM ".$this->_tabla." WHERE ".$this->_primaria." = ".$id_usuario;
			$result = $this->_conn->consultaArreglo($query);
			
			if(!empty($result)){
				return $result;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}

	public function getByRut($gl_rut, $rol=''){
		$gl_rut	= validar($gl_rut,'string');

		if(!empty($gl_rut)){
			$query	= "	SELECT * FROM ".$this->_tabla." WHERE gl_rut = '$gl_rut'";
			$result = $this->_conn->consultaArreglo($query);
			
			if(!empty($result)){
				return $result;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}

	public function getByToken($gl_token){
		$gl_token	= validar($gl_token,'string');

		if(!empty($gl_token)){
			$query	= "	SELECT 
							*
						FROM ".$this->_tabla."
						WHERE gl_token = '$gl_token'
							ORDER BY ".$this->_primaria." DESC
							LIMIT 1
						";
			/**
			 * Quito el parametro bo_utilizado, dado que me interesa saber si el hash ya fue utilizado
			 * en apiExterna.php, y así poder envíar el mensaje de error correspondiente
			 *	AND bo_utilizado = 0
			*/
			//$_SESSION[SESSION_BASE]['arrTokenquery']	= addcslashes($query);
			$result = $this->_conn->consulta($query);
			
			if($result->num_rows>0){
				return $this->_conn->fetch_assoc($result);
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}

	public function getToken($gl_ambiente,$gl_public_key){
		$gl_ambiente	= validar($gl_ambiente,'string');
		$gl_public_key	= validar($gl_public_key,'string');

		if(!empty($gl_ambiente) AND !empty($gl_public_key)){
			$query	= "	SELECT 
							gl_token
						FROM ".$this->_tabla."
						WHERE gl_ambiente = '$gl_ambiente'
							AND gl_public_key = '$gl_public_key'
							AND bo_utilizado = 0
							ORDER BY ".$this->_primaria." DESC
							LIMIT 1
						";
			//$_SESSION[SESSION_BASE]['arrTokenquery']	= addcslashes($query);
			$result = $this->_conn->consultaArreglo($query);
			
			if(!empty($result)){
				return $result;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}

	function insertarRegistro($gl_token,$gl_ambiente,$gl_public_key,$json_respuesta,$gl_rut){
		$id				= 0;
		$gl_rut			= validar($gl_rut,'string');
		$gl_token		= validar($gl_token,'string');
		$gl_ambiente	= validar($gl_ambiente,'string');
		$gl_public_key	= validar($gl_public_key,'string');
		$json_respuesta	= json_encode($json_respuesta,JSON_UNESCAPED_UNICODE);
			
		if(!empty($gl_token)){
			$query		= "	INSERT INTO ".$this->_tabla."
								(
								gl_rut,
								gl_token,
								gl_ambiente,
								gl_public_key,
								json_respuesta,
								id_usuario_crea
								)
							VALUES
								(
								'$gl_rut',
								'$gl_token',
								'$gl_ambiente',
								'$gl_public_key',
								'$json_respuesta',
								0
								)
							";

			$result	= $this->_conn->consulta($query);
			$id		= $this->_conn->getInsertId();
			$this->_conn->cerrar_conexion();
		}

		return $id;
	}

	function updateEstado($gl_token,$bo_utilizado){
		$gl_token	= validar($gl_token,'string');
		$retorno	= false;
			
		if(!empty($gl_token)){
			$query		= "	UPDATE ".$this->_tabla."
								SET bo_utilizado = ".intval($bo_utilizado).",
								fc_actualiza = now()
							WHERE gl_token = '$gl_token'
							";
			$result	= $this->_conn->consulta($query);
			$retorno= true;
			$this->_conn->cerrar_conexion();
		}

		return $retorno;
	}

}