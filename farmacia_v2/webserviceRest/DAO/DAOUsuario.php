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
class DAOUsuario{

    const TOKEN_PERFIL_ADMINISTRADOR		=	"6e707064b948a2ab6ea7ab69513c0663ef70b3b9";
	const TOKEN_PERFIL_FISCALIZADOR_SEREMI	=	"9af6a2a37acbb7b72f866e754adc0f37405b79dd";
	protected $_tabla						=	"usuario";
    protected $_primaria					=	"id";
    protected $_transaccional				=	false;
    protected $_conn						=	null;
    protected $_respuesta					=	array();


    function __construct($conn = null) {
        if($conn !== null){
            $this->_conn =  $conn;
        }else{
            $this->_conn =  new MySQL();
        }
    }

    public function getLista(){
        $query	= "	SELECT * FROM ".$this->_tabla;
        $data		= $this->_conn->consulta($query);
		$respuesta	= $this->_conn->fetch_assoc($data);
		$this->_conn->dispose($data);

		if(!empty($respuesta)){
			return $respuesta;
		}else{
			return NULL;
		}
    }

    public function getById($id_usuario){
		$id_usuario	= validar($id_usuario,'numero');
		
		if(!empty($id_usuario)){
			$query	= "	SELECT * FROM ".$this->_tabla." WHERE ".$this->_primaria." = ".$id_usuario;
			$data		= $this->_conn->consulta($query);
			$respuesta	= $this->_conn->fetch_assoc($data);
			$this->_conn->dispose($data);

			if(!empty($respuesta)){
				return $respuesta;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }

    public function getByRut($rut){
		$rut	= validar($rut,'string');
		
		if(!empty($rut)){
			$query	= "	SELECT * FROM ".$this->_tabla." WHERE gl_rut = '".$rut."'";
			$data		= $this->_conn->consulta($query);
			$respuesta	= $this->_conn->fetch_assoc($data);
			$this->_conn->dispose($data);

			if(!empty($respuesta)){
				return $respuesta;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }

    function getUsuarioByRutMIDAS($rut)
	{	
		$bo_midas = true;
		$conn =  new MySQL($bo_midas);

		$respuesta	= array();//, TRUE as bo_usuario_midas 
		$sql 		= "SELECT id as id_usuario, usuario.*
						FROM usuario 
						WHERE rut = '".(string)$rut."'
						AND bo_activo = 1;";

		$data		= $conn->consulta($sql);
		$respuesta	= $conn->fetch_assoc($data);
		
		$conn->dispose($data);
		$conn->cerrar_conexion();
		
		return $respuesta;
	}

    public function getLogin($params){
		$gl_rut		= validar($params["rut"],'string');
		$rol		= $params["rol"];
		//$gl_clave	= hash("sha512", validar($gl_clave,'string'));

		if(!empty($gl_rut)){
			$query	=
			"	SELECT		u.id,
							u.rut,
							u.password,
							u.email,
							u.nombre,
							u.apellido
				FROM		".	$this->_tabla	."		u
				LEFT JOIN	usuario_oficina_rol_ambito	uora	ON	uora.id_usuario	=	u.id
			";
			
			
			$where	=	"	WHERE		u.rut				=	'$gl_rut' 
							AND			u.habilitado		=	1";
			//AND gl_password = '$gl_clave'
			
			//TODO: corregir opciones de region y rol
			if(isset($rol)){
				$where.= "	AND			uora.id_rol			=	$rol
							AND			uora.bo_activo		=	1
				";
			}
			/*
			if(isset($region)){
				$where .= " AND mur.region IN ($region) ";
			}
			*/

			$limit		=	" LIMIT 1 ";
			$sql		=	$query.$where.$limit;
			$data		=	$this->_conn->consulta($sql);
			$respuesta	=	$this->_conn->fetch_assoc($data);
			$this->_conn->dispose($data);

			if(!empty($respuesta)){
				return $respuesta;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }

    
    function getUsuarioLoginMIDAS($rut, $password)
	{	
		$bo_midas = true;
		$conn =  new MySQL($bo_midas);

		$respuesta	= array();//, TRUE as bo_usuario_midas 
		$sql 		= "SELECT usuario.id as id_usuario, usuario.*
						FROM usuario 
						WHERE rut = '".(string)$rut."' 
						AND password = '".hash("sha1", $password)."'
						AND bo_activo = 1;";
		$data		= $conn->consulta($sql);
		$respuesta	= $conn->fetch_assoc($data);
		
		$conn->dispose($data);
		$conn->cerrar_conexion();
		
		return $respuesta;
	} 
    

    function getPerfilesByIdUsuario($id){
		$respuesta	= array();
		$sql 		= "SELECT id_perfil, id_region, id_oficina 
						FROM acceso_usuario_perfil 
						WHERE id_usuario = ".(int)$id."
						AND bo_activo = 1;";
		
		$respuesta		= $this->_conn->consultaArreglo($sql);
		
		return $respuesta;
	}

	function validarFiscalizador($id){
		$perfiles	= array();
		$sql 		= "SELECT acceso_perfil.gl_token AS token
						FROM acceso_usuario_perfil 
						LEFT JOIN acceso_perfil ON acceso_perfil.id_perfil = acceso_usuario_perfil.id_perfil
						WHERE id_usuario = ".(int)$id."
						AND bo_activo = 1;";
		
		$perfiles		= $this->_conn->consultaArreglo($sql);

		$bo_fiscalizador = false;
		if(is_array($perfiles)){
			foreach ($perfiles as $perfil) {
				if($perfil["token"] == self::TOKEN_PERFIL_FISCALIZADOR_SEREMI
					|| $perfil["token"] == self::TOKEN_PERFIL_ADMINISTRADOR){
					$bo_fiscalizador = true;
				}
			}
		}
		return $bo_fiscalizador;
	}

	function getRegionesUsuario($id_usuario)
	{
		$respuesta	= array();

		$sql = "SELECT id_region 
				FROM acceso_usuario_perfil 
				LEFT JOIN acceso_perfil ON acceso_perfil.id_perfil = acceso_usuario_perfil.id_perfil
				WHERE bo_activo = 1 
				AND acceso_perfil.gl_token = '".self::TOKEN_PERFIL_FISCALIZADOR_SEREMI."'
				AND id_usuario = ".(int)$id_usuario;

		$respuesta		= $this->_conn->consultaArreglo($sql);
		
		return $respuesta;
	}



	function validarDispositivo($id_usuario, $token_dispositivo, $appVersion, $gl_rut, $bo_usuario_midas){
		/**
		 * buscar dispositivo
		 * si no existe, crearlo
		 * si existe, validar si está activo
		 * si no está activo, ponerlo activo
		 *
		 * 
		 * 
		 * @todo si un usuario se logea con su usuario midas, no podrá hacer fiscalizaciones. por lo tanto, en este momento es irrelevante.
		 */
		
		/**
		 * Busco el último dispositivo en el cual el usuario hizo login.
		 */
        $sql = "SELECT gl_token_dispositivo 
        		FROM dispositivo_usuario 
        		WHERE id_usuario = ". (int)$id_usuario."
                    AND fc_login = (SELECT MAX(fc_login) 
                                    FROM dispositivo_usuario 
                                    WHERE id_usuario = ". (int)$id_usuario."
                                    AND bo_usuario_midas = ".validar($bo_usuario_midas, 'boolean').");";
        $data = $this->_conn->consulta($sql);
        $ultimo_dispositivo = $this->_conn->fetch_assoc($data);
        $this->_conn->dispose($data);

        /**
         * Verifico si el dispositivo actual es un dispositivo distinto al último dispositivo
         */
        if($ultimo_dispositivo['gl_token_dispositivo'] != $token_dispositivo){

        	/**
        	 * Si es un dispositivo distinto al último, lo inserto para registrarlo
        	 */
        	$sql = "INSERT INTO dispositivo_usuario (
                    id_usuario,
                    gl_token_dispositivo,
                    fc_login,
                    bo_usuario_midas,
                    bo_activo,
                    gl_version,
                    id_usuario_crea
                )
                VALUES (
                     " . $id_usuario 		. " ,
                    '" . $token_dispositivo . "',
                    '" . date("Y-m-d H:i:s"). "',
                     " . validar($bo_usuario_midas, 'boolean') . " ,
                    1,
                    '" . $appVersion		. "',
                     " . $id_usuario 		. "
                );";

            $this->_conn->consulta($sql);


            /**
             * Si, además, el último dispositivo registrado se encuentra activo, notifico al usuario
             */
        	if($ultimo_dispositivo["bo_activo"] == true){
	        	include_once("DAO/DAOMensajeUsuario.php");
	            $daoMensajeUsuario = new DAOMensajeUsuario($this->_conn);

	            $mensaje_usuario = "<p style=\"color:red;text-align:center;\"><b>Se detectaron multiples sesiones.</b><br> Ha iniciado una nueva sesión con un dispositivo diferente.<br>Por favor, asegurese de:</p><ul style=\"color:red;list-style-type: disc !important;padding-left: 30px;padding-right: 20px;\"><li>Verificar que todas sus asignaciones hayan sido correctamente sincronizadas.</li><li>Cerrar la sesión en el dispositivo que ya no usará.</li><li>Recargar los datos del dispositivo nuevo.</li></ul><p style=\"color:red;text-align: center;\"><br><b>LAS SESIONES MULTIPLES PUEDE GENERAR INFORMACIÓN DUPLICADA.</b></p>";
				$datos_mensaje = array(
						"id_tipo_mensaje" => DAOMensajeUsuario::TIPO_MENSAJE_WARN,
	        			"bo_activo" => true,
	        			"gl_mensaje" => addslashes($mensaje_usuario),
						"gl_rut" => $gl_rut,
						"gl_token_dispositivo" => $token_dispositivo,
						"gl_version" => $appVersion,
						"bo_mensaje_entregado" => false,
						"id_usuario_crea" => $id_usuario,
	    			);

	    		//Creo una notificacion para el nuevo dispositivo del usuario.
				$daoMensajeUsuario->insert($datos_mensaje);
				//Creo una notificacion para el último dispositivo utilizado por el usuario.
	            $datos_mensaje["gl_token_dispositivo"] = $ultimo_dispositivo['gl_token_dispositivo'];
	            $daoMensajeUsuario->insert($datos_mensaje);
        	}            
        }
    }


    function desactivarDispositivo($id_usuario, $token_dispositivo, $appVersion, $gl_rut, $bo_usuario_midas){		
		/**
		 * Busco el dispositivo desde el que el usuario está cerrando la sesión
		 */
        $sql = "SELECT id_dispositivo_usuario 
        		FROM dispositivo_usuario 
        		WHERE id_usuario = ". (int)$id_usuario."
        			AND gl_token_dispositivo LIKE '".$token_dispositivo."'
        			AND gl_version LIKE = '".$appVersion."'
        			AND bo_usuario_midas = ".$bo_usuario_midas."
                    AND fc_login = (SELECT MAX(fc_login) 
                                    FROM dispositivo_usuario 
                                    WHERE id_usuario = ". (int)$id_usuario." 
                                    AND gl_token_dispositivo LIKE '".$token_dispositivo."'
                                    AND bo_usuario_midas = ".$bo_usuario_midas.");";
        $data = $this->_conn->consulta($sql);
        $ultimo_dispositivo = $this->_conn->fetch_assoc($data);
        $this->_conn->dispose($data);

        /**
         * Verifico si el dispositivo actual es un dispositivo distinto al último dispositivo
         */
        if(!empty($ultimo_dispositivo)){

        	/**
        	 * Si es un dispositivo distinto al último, lo inserto para registrarlo
        	 */
        	$sql = "UPDATE table_name
					SET bo_activo=FALSE
					WHERE id_dispositivo_usuario=".$ultimo_dispositivo["id_dispositivo_usuario"];

            $this->_conn->consulta($sql);
        }
    }

	/*
	public function getLogin($gl_rut,$gl_clave, $rol=''){
		$gl_rut		= validar($gl_rut,'string');
		$rol		= validar($rol,'string');
		$gl_clave	= validar($gl_clave,'string');

		if(!empty($gl_rut)){
			$and_rol	= (!empty($rol))?" AND mur.mur_fk_rol IN ($rol) ":'';
			
			$query	= "	SELECT 
							mu_id 
						FROM ".$this->_tabla." mu
							INNER JOIN maestro_usuario_rol mur ON mur.mur_fk_usuario = mu.mu_id
						WHERE mu.mu_rut_midas = '$gl_rut' 
							AND mu.mu_pass = '$gl_clave'
							AND mu.mu_estado_sistema = 1
							AND mur.mur_estado_activado = 1
							$and_rol
						LIMIT 1";
			$result = $this->_conn->consultaArreglo($query);

			if(!empty($result)){
				return $result[0]['mu_id'];
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }
	

    public function getLoginTest($gl_rut, $rol=''){
		$gl_rut		= validar($gl_rut,'string');
		$rol		= validar($rol,'string');

		if(!empty($gl_rut)){
			$and_rol	= (!empty($rol))?" AND mur.mur_fk_rol IN ($rol) ":'';
			
			$query	= "	SELECT 
							mu_id 
						FROM ".$this->_tabla." mu
							INNER JOIN maestro_usuario_rol mur ON mur.mur_fk_usuario = mu.mu_id
						WHERE mu.mu_rut_midas = '$gl_rut' 
							AND mu.mu_estado_sistema = 1
							AND mur.mur_estado_activado = 1
							$and_rol
						LIMIT 1";
			$result = $this->_conn->consultaArreglo($query);

			if(!empty($result)){
				return $result[0]['mu_id'];
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }
	*/

	function getDataFiscalizador($id){

		$sql		=	"	SELECT		us_p.id_region
							FROM		acceso_usuario_perfil	us_p
							LEFT JOIN	acceso_perfil			per		ON	per.id_perfil	=	us_p.id_perfil
							WHERE		us_p.id_usuario				=		".	(int)$id	."
							AND			us_p.id_perfil				=		35
							AND			us_p.bo_activo				=		1;
		";
		
		$data		=	$this->_conn->consulta($sql);
		$respuesta	=	$this->_conn->fetch_assoc($data);
		$this->_conn->dispose($data);

		if(!empty($respuesta)){
			return $respuesta;
		}else{
			return NULL;
		}
	}
}