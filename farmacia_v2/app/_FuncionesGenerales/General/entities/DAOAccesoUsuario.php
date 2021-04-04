<?php
/**
 ******************************************************************************
 * Sistema           : SUMARIOS V4
 *
 * Descripcion       : Modelo para Tabla hope_acceso_usuario
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 13/05/2020
 *
 * @name             DAOAccesoUsuario.php
 *
 * @version          1.0
 *
 * @author           David Guzman <david.guzman@cosof.cl>
 *
 ******************************************************************************
 * !ControlCambio
 * --------------
 * !cProgramador				!cFecha		!cDescripcion
 * ---------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
namespace App\_FuncionesGenerales\General\Entity;

class DAOAccesoUsuario extends \pan\Kore\Entity{

	const TOKEN_PERFIL_ADMINISTRADOR = "6e707064b948a2ab6ea7ab69513c0663ef70b3b9";
	const TOKEN_PERFIL_FISCALIZADOR = "ae5d153c8c746994b82710616b78a237f3294628";

	protected $table			            = TABLA_ACCESO_USUARIO;
	protected $primary_key		            = "mu_id";

	function __construct(){
		parent::__construct();
	}

	public function getLista(){
		$query	= "SELECT * FROM ".$this->table;
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}

	public function getByToken($gl_token){
		$query	= "	SELECT
						usu.mu_id AS id_usuario,
						usu.gl_token,
						usu.mu_rut_midas AS gl_rut,
						usu.mu_nombre AS gl_nombres,
						usu.mu_apellido_paterno AS gl_apellido_paterno,
						usu.mu_apellido_materno AS gl_apellido_materno,
						profesion.fk_profesion AS id_profesion,
						UPPER(SUBSTRING(usu.mu_genero,1,1)) AS chk_genero,
						usu.mu_fecha_nacimiento AS fc_nacimiento,
						usu.mu_correo AS gl_email,
						usu.id_region_midas AS id_region,
						usu.id_comuna_midas AS id_comuna,
						usu.mu_direccion AS gl_direccion,
						usu.mu_telefono_codigo AS id_codfono,
						usu.mu_telefono AS gl_telefono,
						usu.bo_ws_validado AS bo_ws_validado,
						usu.bo_cambio_usuario AS bo_cambio_usuario
					FROM ".$this->table." usu
					LEFT JOIN ".TABLA_PROFESION_USUARIO." profesion ON usu.mu_id = profesion.fk_usuario
					WHERE gl_token = '".$gl_token."'";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows(0);
		}else{
            return NULL;
		}
	}

	public function getByValidaEmail($gl_valida_email){
		$query	= "SELECT * FROM ".$this->table." WHERE gl_valida_email = '".$gl_valida_email."'";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows(0);
		}else{
            return NULL;
		}
	}

    public function validarEmail($gl_valida_email){
		$query	= "	UPDATE ".$this->table."
					SET bo_valida_email     = 1,
                        fc_valida_email     = now()
					WHERE gl_valida_email   = ?";
		$resp	= $this->db->execQuery($query, array($gl_valida_email));

		return $resp;
	}

    public function marcarEmailEnviado($id_usuario){
		$query	= "	UPDATE ".$this->table."
					SET bo_valida_email_enviado = 1
					WHERE id_usuario   = ?";
		$resp	= $this->db->execQuery($query, array($id_usuario));

		return $resp;
	}

    public function marcarEmailVisto($id_usuario){
		$query	= "	UPDATE ".$this->table."
					SET bo_valida_email_visto   = 1,
                        fc_valida_email_visto   = now()
					WHERE id_usuario = ?";
		$resp	= $this->db->execQuery($query, array($id_usuario));

		return $resp;
	}

	public function getNombreCompletoById($id_usuario){
		$query	= "	SELECT
						CONCAT(usuario.gl_nombres, ' ', usuario.gl_apellidos) as nombre_completo
						FROM        ".$this->table." usuario
		WHERE       usuario.".$this->primary_key." = ?";

		$param	= array($id_usuario);
		$result = $this->db->getQuery($query, $param)->runQuery();

		if($result->getNumRows()>0){
            return ucwords(strtolower($result->getRows(0)->nombre_completo));
		}else{
            return NULL;
		}
	}

	public function regularizarPass(){
		set_time_limit(100000);
		error_reporting(0);
		ini_set('display_errors', '0');
		ini_set('memory_limit', '-1');

		$query	= "	SELECT
						*
                    FROM	".$this->table." usuario
                    WHERE	usuario.gl_password IS NULL";
					// WHERE	usuario.gl_token IS NULL";

		$result = $this->db->getQuery($query)->runQuery();

		foreach ($result->getRows() as $usuario){
			$gl_password = \Seguridad::generar_sha512($usuario->contrasena);
			$gl_token	 = \Seguridad::generaTokenUsuario($usuario->rut);

			$this->setPass($usuario->id_usuario, $gl_password);
			$this->setToken($usuario->id_usuario, $gl_token);
		}

	}

	public function setPass($id, $gl_password){
		$query	= "	UPDATE ".$this->table."
					SET gl_password_v2  = '$gl_password'
					WHERE ".$this->primary_key." = ? ";
		$param	= array($id);
		$resp	= $this->db->execQuery($query, $param);

		return $resp;
	}

	public function setToken($id, $gl_token){
		$query	= "	UPDATE ".$this->table."
					SET gl_token  = '$gl_token'
					WHERE ".$this->primary_key." = ? ";
		$param	= array($id);
		$resp	= $this->db->execQuery($query, $param);

		return $resp;
	}

	public function getLoginSoloRut($gl_rut){
		$query	= "	SELECT
						usuario.*,
						region.region_nombre,
						region.nombre_region_corto,
						comuna.comuna_nombre
					FROM        ".$this->table." usuario
					LEFT JOIN ".TABLA_DIRECCION_REGION." ON usuario.id_region_midas = region.id_region_midas
					LEFT JOIN ".TABLA_DIRECCION_COMUNA." ON usuario.id_comuna_midas = comuna.id_comuna_midas
					WHERE       usuario.mu_rut_midas	= ?";

        $param	= array($gl_rut);
		$result = $this->db->getQuery($query, $param)->runQuery();

		return $result->getRows(0);
	}

	/**
	* Descripción : Obtener la información para Validar al usuario e Iniciar la Session
	* @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	* @param   string	$gl_rut del usuario.
	* @param   string	$gl_password  del usuario.
	* @return  object  Información del usuario
	*/
    public function getLogin($gl_rut, $gl_password, $retornaLista = FALSE) {
        $query	= "	SELECT
						usuario.*,
						region.region_nombre,
						region.nombre_region_corto,
						comuna.comuna_nombre
					FROM        ".$this->table." usuario
					LEFT JOIN ".TABLA_DIRECCION_REGION." ON usuario.id_region_midas = region.id_region_midas
					LEFT JOIN ".TABLA_DIRECCION_COMUNA." ON usuario.id_comuna_midas = comuna.id_comuna_midas
                    WHERE       usuario.mu_rut_midas	= ?
                    AND         usuario.mu_pass 		= ?
					";

        $param	= array($gl_rut, $gl_password);
        $result	= $this->db->getQuery($query, $param)->runQuery();

        $rows	= $result->getRows();

        if (!empty($rows) && !$retornaLista) {
            return $rows[0];
        }else {
            return $rows;
        }
	}

	/**
	 * Descripción : Copia de getLogin sin parámetro $gl_password, utilizada por WS de Formularios
	 * creada para no alterar función original
	 * @param   string	$gl_email del usuario.
	 * @return  object  Información del usuario
	 */
	public function getByEmail($gl_email, $retornaLista = FALSE) {
        $query	= "	SELECT
						usuario.*,
                        pais.gl_nombre_pais AS gl_pais
                    FROM        ".$this->table." usuario
                    LEFT JOIN   hope_direccion_pais  pais  ON  usuario.id_pais   = pais.id_pais
                    WHERE       usuario.gl_email    = ?";

        $param	= array($gl_email);
        $result	= $this->db->getQuery($query, $param)->runQuery();

        $rows	= $result->getRows();

        if (!empty($rows) && !$retornaLista) {
            return $rows[0];
        }else {
            return $rows;
        }
    }

	/**
	* Descripción : Setea activo (habilita/deshabilita usuario)
	* @author  David Guzmán <david.guzman@cosof.cl> - 02/06/2020
	* @param   array   $id
	*/
	public function setActivoByToken($gl_token,$bo_activo){
		$query	= "	UPDATE ".$this->table."
					SET mu_estado_sistema = ?
					WHERE gl_token = ? ";
		$param	= array($bo_activo,$gl_token);
		$resp	= $this->db->execQuery($query, $param);

		return $resp;
	}

	/**
	* Descripción : Setea Login
	* @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	* @param   array   $id
	*/
	public function setUltimoLogin($id){
		$query	= "	UPDATE ".$this->table."
					SET fc_ultimo_login = now()
					WHERE ".$this->primary_key." = ? ";
		$param	= array($id);
		$resp	= $this->db->execQuery($query, $param);

		return $resp;
	}

	public function getById($id, $retornaLista = FALSE){
		$query	= "	SELECT	*
					FROM ".$this->table."
					WHERE ".$this->primary_key." = ?";

		$param	= array($id);
		$result	= $this->db->getQuery($query,$param)->runQuery();

		$rows	= $result->getRows();

		if (!empty($rows) && !$retornaLista) {
			return $rows[0];
		}else {
			return $rows;
		}
	}

    /**
	* Descripción : Obtener Lista Mantenedor Usuario
	* @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	* @param   string	$gl_rut del usuario.
	* @param   string	$gl_password  del usuario.
	* @return  object  Información del usuario
	*/
	public function getListaMantenedor($params){
        $param  = array();
        $where  = " WHERE ";
		$query	= " SELECT
						usuario.mu_rut AS gl_rut,
						usuario.gl_token,
						CONCAT(COALESCE(usuario.mu_nombre,''),' ',COALESCE(usuario.mu_apellido_paterno,''),' ',COALESCE(usuario.mu_apellido_materno,'')) AS gl_nombre_completo,
						usuario.mu_correo AS gl_email,
						usuario.mu_direccion AS gl_direccion,
						usuario.mu_telefono AS gl_telefono,
						usuario.mu_estado_sistema AS bo_activo,
						UPPER(SUBSTRING(usuario.mu_genero,1,1)) AS gl_genero,
                        IFNULL((SELECT GROUP_CONCAT(DISTINCT rol.rol_nombre_vista SEPARATOR ', ') FROM ".TABLA_ACCESO_USUARIO_ROL." usu_rol
                                LEFT JOIN ".TABLA_ACCESO_ROL." rol ON rol.rol_id = usu_rol.mur_fk_rol
								WHERE usu_rol.mur_fk_usuario = usuario.mu_id AND usu_rol.mur_estado_activado = 1),'') AS gl_roles
                    FROM    ".$this->table." usuario
                    ";

        if (!empty($params)) {
            if (isset($params['id_region']) && intval($params['id_region']) > 0) {
                $query      .= "$where usuario.id_region_midas = ?";
                $param[]    = intval($params['id_region']);
                $where      = " AND ";
            }
            if (isset($params['id_comuna']) && intval($params['id_comuna']) > 0) {
                $query      .= "$where usuario.id_comuna_midas = ?";
                $param[]    = intval($params['id_comuna']);
                $where      = " AND ";
            }
            if (isset($params['id_rol']) && intval($params['id_rol']) > 0) {
                $query      .= "$where usuario.mu_id IN (SELECT usu_rol.mur_fk_usuario FROM ".TABLA_ACCESO_USUARIO_ROL." usu_rol
                                                WHERE usu_rol.mur_fk_usuario = usuario.mu_id AND usu_rol.mur_fk_rol = ? AND usu_rol.mur_estado_activado = 1)";
                $param[]    = intval($params['id_rol']);
                $where      = " AND ";
            }
            if (isset($params['bo_activo']) && ($params['bo_activo'] == "1" || $params['bo_activo'] == "0")) {
                $query      .= "$where usuario.mu_estado_sistema = ?";
                $param[]    = intval($params['bo_activo']);
                $where      = " AND ";
            }
            if (isset($params['gl_nombre']) && trim($params['gl_nombre']) != "") {
                $query .= "$where (usuario.mu_nombre LIKE '%". mb_strtoupper($params['gl_nombre'])."%'";
                $query .= "OR usuario.mu_apellido_paterno LIKE '%". mb_strtoupper($params['gl_nombre'])."%'";
                $query .= "OR usuario.mu_apellido_materno LIKE '%". mb_strtoupper($params['gl_nombre'])."%'";
                $query .= "OR CONCAT(usuario.mu_nombre,' ',usuario.mu_apellido_paterno,' ',usuario.mu_apellido_materno) LIKE '%". mb_strtoupper($params['gl_nombre'])."%')";
                $where  = " AND ";
            }
            if (isset($params['gl_email']) && trim($params['gl_email']) != "") {
                //if(\Email::validar_email($params['gl_email'])){
                    $query .= "$where usuario.mu_correo LIKE '%".$params['gl_email']."%'";
                    $where  = " AND ";
                //}
            }
            if (isset($params['gl_rut']) && trim($params['gl_rut']) != "") {
				$query .= "$where (usuario.mu_rut LIKE '%".$params['gl_rut']."%' OR usuario.mu_rut_midas LIKE '%".$params['gl_rut']."%')";
				$where  = " AND ";
            }
		}
		
		$query .= " LIMIT 1000";

		$result	= $this->db->getQuery($query,$param)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}

    /**
    * Descripción   : Insertar nuevo usuario.
    * @author       : <david.guzman@cosof.cl>
    * @param        : array
    * @return       : int
    */
    public function insertNuevo($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->table."
								(
                                    gl_token,
                                    mu_rut,
                                    mu_rut_midas,
                                    mu_nombre,
                                    mu_apellido_paterno,
                                    mu_apellido_materno,
									mu_genero,
									mu_fecha_nacimiento,
									mu_correo,
									id_region_midas,
									id_comuna_midas,
									mu_direccion,
									mu_telefono_codigo,
									mu_telefono,
									gl_password_v2,
									mu_pass,
									mu_estado_sistema,
                                    usuario_fecha_creacion
								)
								VALUES
								(
									?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now()
								)";

		if($this->db->execQuery($query,$params)){
            $id = $this->db->getLastId();
        }

        return $id;
    }

	/**
	* Descripción : Editar Usuario
	* @author  David Guzmán <david.guzman@cosof.cl> - 07/01/2020
	* @param   array   $gl_token, $params
	*/
	public function modificar($gl_token,$params){
		$query	= "	UPDATE ".$this->table."
					SET
						mu_nombre              	= ?,
                        mu_apellido_paterno   	= ?,
                        mu_apellido_materno    	= ?,
                        mu_genero            	= ?,
						mu_fecha_nacimiento 	= ?,
						mu_correo				= ?,
                        id_region_midas       	= ?,
						id_comuna_midas        	= ?,
						mu_direccion			= ?,
						mu_telefono_codigo		= ?,
                        mu_telefono             = ?
					WHERE gl_token = '$gl_token'";

		$resp	= $this->db->execQuery($query, $params);

		return $resp;
	}

    /**
	* Descripción   : Obtener Usuarios por Expediente
	* @author      : David Guzmán <david.guzman@cosof.cl>
	*/
    public function getListaActivos() {
        $query	= "	SELECT
						usuario.*,
                        (SELECT count(id) FROM ".TABLA_USUARIO_PERFIL_V4." usu_rol
                         WHERE usuario.id_usuario = usu_rol.id_usuario AND usu_rol.bo_activo = 1) AS cont_rol
					FROM ".$this->table." usuario
                    WHERE usuario.bo_activo = 1
					ORDER BY upper(gl_nombres) ";

        $result	= $this->db->getQuery($query)->runQuery();
		if($result->getNumRows()>0){
			return $result->getRows();
        } else {
            return NULL;
        }
	}

    public function getRolesUsuario($id_usuario) {
        $query = "SELECT hope_acceso_rol.nombre FROM hope_acceso_usuario_rol
            LEFT JOIN hope_acceso_rol ON hope_acceso_rol.id = hope_acceso_usuario_rol.id_rol
            WHERE id_usuario = ". $id_usuario ."
            GROUP BY id_rol";

        $result	= $this->db->getQuery($query)->runQuery();
        if ($result->getNumRows()>0) {
            return $result->getRows();
        } else {
            return NULL;
        }

	}

	/**
	 * Validar usuario login app (Formularios)
	 */
	public function validarFiscalizador($id){
		$roles	= array();
		$sql 		= "SELECT ".TABLA_ACCESO_PERFIL.".gl_token AS token
						FROM ".TABLA_ACCESO_USUARIO_PERFIL."
						LEFT JOIN ".TABLA_ACCESO_PERFIL." ON ".TABLA_ACCESO_PERFIL.".id_rol = ".TABLA_ACCESO_USUARIO_PERFIL.".id_rol
						WHERE id_usuario = ".(int)$id."
						AND bo_activo = 1;";

		$result	= $this->db->getQuery($sql)->runQuery();
		// file_put_contents('php://stderr', PHP_EOL . "result: " . print_r($result, TRUE). PHP_EOL, FILE_APPEND);
		$bo_fiscalizador = false;

		if($result->getNumRows()>0) {
			try {
				foreach ($result->getRows() as $row) {
					if($row->token == self::TOKEN_PERFIL_FISCALIZADOR
						|| $row->token == self::TOKEN_PERFIL_ADMINISTRADOR){
						$bo_fiscalizador = true;
					}
				}
			} catch (Exception $e) {
				return false;
			}
		}

		return $bo_fiscalizador;
	}

	public function validarDispositivo($id_usuario, $token_dispositivo, $appVersion, $gl_email) {
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
        $sql = "SELECT gl_token_dispositivo, bo_activo
        		FROM ".TABLA_DISPOSITIVO_USUARIO."
        		WHERE id_usuario = ". (int)$id_usuario."
                    AND fc_login = (SELECT MAX(fc_login)
                                    FROM ".TABLA_DISPOSITIVO_USUARIO."
									WHERE id_usuario = ". (int)$id_usuario.");";
                                    // AND bo_usuario_midas = ".validar($bo_usuario_midas, 'boolean').");";

		$result	= $this->db->getQuery($sql)->runQuery();
		$ultimo_dispositivo = $result->getRows(0);

        /**
         * Verifico si el dispositivo actual es un dispositivo distinto al último dispositivo
         */
        if($ultimo_dispositivo->gl_token_dispositivo != $token_dispositivo) {

        	/**
        	 * Si es un dispositivo distinto al último, lo inserto para registrarlo
        	 */
        	$sql = "INSERT INTO ".TABLA_DISPOSITIVO_USUARIO." (
                    id_usuario,
                    gl_token_dispositivo,
                    fc_login,
                    bo_activo,
                    gl_version,
                    id_usuario_crea
                )
                VALUES (
                     " . $id_usuario 		. " ,
                    '" . $token_dispositivo . "',
                    '" . date("Y-m-d H:i:s"). "',
                    1,
                    '" . $appVersion		. "',
                     " . $id_usuario 		. "
                );";

			// $this->_conn->consulta($sql);
			$this->db->execQuery($sql);


            /**
             * Si, además, el último dispositivo registrado se encuentra activo, notifico al usuario
             */
        	if($ultimo_dispositivo->bo_activo == true) {
	        	$daoMensajeUsuario  = new \App\Formularios\webserviceRest\Entity\DAOWebservDAOMensajeUsuarioceToken();

	            $mensaje_usuario = "<p style=\"color:red;text-align:center;\"><b>Se detectaron multiples sesiones.</b><br> Ha iniciado una nueva sesión con un dispositivo diferente.<br>Por favor, asegurese de:</p><ul style=\"color:red;list-style-type: disc !important;padding-left: 30px;padding-right: 20px;\"><li>Verificar que todas sus asignaciones hayan sido correctamente sincronizadas.</li><li>Cerrar la sesión en el dispositivo que ya no usará.</li><li>Recargar los datos del dispositivo nuevo.</li></ul><p style=\"color:red;text-align: center;\"><br><b>LAS SESIONES MULTIPLES PUEDE GENERAR INFORMACIÓN DUPLICADA.</b></p>";
				$datos_mensaje = array(
						"id_tipo_mensaje" => \App\Formularios\webserviceRest\Entity\DAOWebservDAOMensajeUsuarioceToken::TIPO_MENSAJE_WARN,
	        			"bo_activo" => true,
	        			"gl_mensaje" => addslashes($mensaje_usuario),
						"gl_email" => $gl_email,
						"gl_token_dispositivo" => $token_dispositivo,
						"gl_version" => $appVersion,
						"bo_mensaje_entregado" => false,
						"id_usuario_crea" => $id_usuario,
	    			);

	    		//Creo una notificacion para el nuevo dispositivo del usuario.
				$daoMensajeUsuario->insert($datos_mensaje);
				//Creo una notificacion para el último dispositivo utilizado por el usuario.
	            $datos_mensaje["gl_token_dispositivo"] = $ultimo_dispositivo->gl_token_dispositivo;
	            $daoMensajeUsuario->insert($datos_mensaje);
        	}
        }
    }

	/**
	* Descripción : Obtener la información para Validar al usuario e Iniciar la Session
	* @author  David Guzmán <david.guzman@cosof.cl> - 27/07/2020
	* @param   string	$gl_rut del usuario.
	* @param   string	$gl_password  del usuario.
	* @return  object  Información del usuario
	*/
    public function getLoginV2($gl_rut, $gl_password, $retornaLista = FALSE) {
        $query	= "	SELECT
						usuario.*,
						region.region_nombre,
						region.nombre_region_corto,
						comuna.comuna_nombre
					FROM        ".$this->table." usuario
					LEFT JOIN ".TABLA_DIRECCION_REGION." ON usuario.id_region_midas = region.id_region_midas
					LEFT JOIN ".TABLA_DIRECCION_COMUNA." ON usuario.id_comuna_midas = comuna.id_comuna_midas
                    WHERE       usuario.mu_rut_midas	= ?
                    AND         usuario.gl_password_v2  = ?
					";

        $param	= array($gl_rut, $gl_password);
        $result	= $this->db->getQuery($query, $param)->runQuery();

        $rows	= $result->getRows();

        if (!empty($rows) && !$retornaLista) {
            return $rows[0];
        }else {
            return $rows;
        }
	}

	/*
	* Descripción : Obtener listado de Medicos
	* @author  David Guzmán <david.guzman@cosof.cl> - 27/08/2020
	* @return  object  Listado de Medicos
	*/
	public function getListaMedicos(){
		$query	= "	SELECT
						*,
						CONCAT(COALESCE(usuario.mu_nombre,''),' ',COALESCE(usuario.mu_apellido_paterno,''),' ',COALESCE(usuario.mu_apellido_materno,'')) AS gl_nombre_completo
					FROM ".$this->table." usuario
					LEFT JOIN ".TABLA_PROFESION_USUARIO." profesion_usuario ON usuario.mu_id = profesion_usuario.fk_usuario
					WHERE profesion_usuario.fk_profesion = 2";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}


}
