<?php
/**
 ******************************************************************************
 * Sistema           : SUMARIOS V4
 *
 * Descripcion       : Modelo para Tabla sum_usuario
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 08/05/2018
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
 * <luis.estay@cosof.cl>		17/07/2019 		Se modifica getLogin()
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
namespace App\Hope\Usuario\Entity;

class DAOUsuario extends \pan\Kore\Entity{

	protected $_tabla			            = 'hop_usuario';
	protected $_primaria		            = "id_usuario";
	protected $_transaccional	            = false;
	protected $_tablaPerfilV4               = 'hop_usuario_perfil';
	protected $_tablaPerfilUsuarioV4        = '';
	// protected $_tablaInhabilitarAbogadoV4   = TABLA_INHABILITAR_ABOGADO_V4;

	protected $table = 'sum_usuario';
	protected $primary_key = 'USUA_id';

	function __construct(){
		parent::__construct();
	}

	public function getLista(){
		$query	= "SELECT * FROM ".$this->_tabla;
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}

	public function getByToken($gl_token){
		$query	= "SELECT * FROM ".$this->_tabla." WHERE gl_token = '".$gl_token."'";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows(0);
		}else{
            return NULL;
		}
	}

	public function getNombreCompletoById($id_usuario){
		$query	= "	SELECT      
						CONCAT(usuario.nombres, ' ', usuario.apellidos) as nombre_completo
						FROM        ".$this->_tabla." usuario
		WHERE       usuario.".$this->_primaria." = ?";

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
                    FROM	".$this->_tabla." usuario
                    WHERE	usuario.gl_password IS NULL";
					// WHERE	usuario.gl_token IS NULL";

		$result = $this->db->getQuery($query)->runQuery();

		foreach ($result->getRows() as $usuario){
			$gl_password = \Seguridad::generar_sha512($usuario->contrasena);
			$gl_token	 = \Seguridad::generaTokenUsuario($usuario->rut);
			
			$this->setPass($usuario->USUA_id, $gl_password);
			$this->setToken($usuario->USUA_id, $gl_token);
		}
		
	}

	public function setPass($id, $gl_password){
		$query	= "	UPDATE ".$this->_tabla."
					SET gl_password  = '$gl_password'
					WHERE ".$this->_primaria." = ? ";
		$param	= array($id);
		$resp	= $this->db->execQuery($query, $param);

		return $resp;
	}

	public function setToken($id, $gl_token){
		$query	= "	UPDATE ".$this->_tabla."
					SET gl_token  = '$gl_token'
					WHERE ".$this->_primaria." = ? ";
		$param	= array($id);
		$resp	= $this->db->execQuery($query, $param);

		return $resp;
	}

	public function getUsuariosLoginSoloRut($gl_rut){
		$query	= "	SELECT      
						usuario.*,
						oficina.id_oficina AS id_oficina,
						perfil.id AS id_perfil,
						perfil.nombre AS gl_nombre_perfil,
						ambito.id AS id_ambito,
                        ambito.nombre AS gl_nombre_ambito
                    FROM        ".$this->_tabla." usuario
                    LEFT JOIN   sum_v4_usuario_perfil  usuario_perfil  ON  ( usuario_perfil.id_usuario  = ".$this->_primaria."
                                                                            AND usuario_perfil.defecto = 1)
                    LEFT JOIN   sum_v4_perfil       perfil          ON  usuario_perfil.id_perfil    = perfil.id
                    LEFT JOIN   sum_usuario_oficina oficina         ON  (usuario_perfil.id    = oficina.id_usuario_perfil AND oficina.defecto = 1)
                    LEFT JOIN   sum_usuario_ambito  usuario_ambito  ON  (usuario_perfil.id    = usuario_ambito.id_usuario_perfil AND usuario_ambito.defecto = 1)
                    LEFT JOIN   sum_ambito          ambito          ON  (usuario_ambito.id_ambito   = ambito.id)
                    WHERE       usuario.rut = ?";

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
        		
		$query	= "	SELECT u.*,p.id_perfil,p.id_usuario_perfil,p.bo_estado 
				FROM hop_usuario u left join hop_usuario_perfil p on u.id_usuario=p.id_usuario;
				WHERE u.gl_rut = ?
					AND (1=1 or u.gl_password = ?)";


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
	* Descripción : Setea Login
	* @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	* @param   array   $id
	*/
	public function setUltimoLogin($id){
		$query	= "	UPDATE ".$this->_tabla."
					SET ultimo_ingreso  = now()
					WHERE ".$this->_primaria." = ? ";
		$param	= array($id);
		$resp	= $this->db->execQuery($query, $param);

		return $resp;
	}

	public function getById($id, $retornaLista = FALSE){
		$query	= "	SELECT	*
					FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

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
        $where  = " WHERE ";
		$query	= " SELECT      
						usuario.rut AS gl_rut,
						CONCAT(COALESCE(usuario.nombres,''),' ',COALESCE(usuario.apellidos,'')) AS gl_nombre_completo,
						usuario.email AS gl_email,
						usuario.activo AS bo_activo,
						usuario.gl_token AS gl_token,
                        IFNULL((SELECT GROUP_CONCAT(DISTINCT perfil.nombre SEPARATOR ', ') FROM sum_v4_usuario_perfil usu_perfil
                                LEFT JOIN sum_v4_perfil perfil ON perfil.id = usu_perfil.id_perfil
								WHERE usu_perfil.id_usuario = usuario.USUA_id AND usu_perfil.bo_activo = 1),'') AS gl_perfiles,
                        IFNULL((SELECT IF(COUNT(perfil.nombre) > 1,'_PERSONALIZADO',perfil.nombre) FROM sum_v4_usuario_perfil usu_perfil
                                LEFT JOIN sum_v4_perfil perfil ON perfil.id = usu_perfil.id_perfil
								WHERE usu_perfil.id_usuario = usuario.USUA_id AND usu_perfil.defecto = 1),'') AS gl_perfil
                    FROM    ".$this->_tabla." usuario
                    ";
        
        if (!empty($params)) {
            if (isset($params['id_region']) && intval($params['id_region']) > 0) {
                $query .= "$where usuario.id_region = ". intval($params['id_region']);
                $where  = " AND ";
            }
            if (isset($params['id_oficina']) && intval($params['id_oficina']) > 0) {
                $query .= "$where usuario.USUA_id IN (SELECT perfil.id_usuario FROM sum_usuario_oficina oficina
                                                        LEFT JOIN sum_v4_usuario_perfil perfil ON oficina.id_usuario_perfil = perfil.id
                                                        WHERE perfil.id_usuario = usuario.USUA_id AND oficina.id_oficina = ".intval($params['id_oficina']).")";
                $where  = " AND ";
            }
            if (isset($params['id_perfil']) && intval($params['id_perfil']) > 0) {
                $query .= "$where usuario.USUA_id IN (SELECT usu_perfil.id_usuario FROM sum_v4_usuario_perfil usu_perfil
                                                WHERE usu_perfil.id_usuario = usuario.USUA_id AND usu_perfil.id_perfil = ".intval($params['id_perfil']).")";
                $where  = " AND ";
            }
            if (isset($params['bo_activo']) && ($params['bo_activo'] == "1" || $params['bo_activo'] == "0")) {
                $query .= "$where usuario.activo = ".intval($params['bo_activo']);
                $where  = " AND ";
            }
        }
        
		$result	= $this->db->getQuery($query)->runQuery();

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
        $query  = "INSERT INTO ".$this->_tabla."
								(
                                    gl_token,
                                    rut,
                                    nombres,
                                    apellidos,
                                    direccion,
                                    id_region,
                                    celular,
                                    telefono,
                                    email,
                                    usuario,
                                    gl_password,
                                    id_usuario_crea,
                                    fc_creacion,
                                    es_v4
								)
								VALUES
								(
									?,?,?,?,?,?,?,?,?,?,?,?,now(),1
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
		$query	= "	UPDATE ".$this->_tabla."
					SET
                        nombres                 = ?,
                        apellidos               = ?,
                        direccion               = ?,
                        id_region               = ?,
                        celular                 = ?,
                        telefono                = ?,
                        email                   = ?,
                        activo                  = ?,
                        bo_cambio_perfil        = ?,
                        bo_cambio_usuario       = ?,
                        id_usuario_actualiza    = ?,
                        fc_actualiza            = now()
					WHERE gl_token = '$gl_token'";
        
		$resp	= $this->db->execQuery($query, $params);

		return $resp;
	}

	/**
	* Descripción : Obtener Usuario Juridico Especifico
	* @author  Guillermo Royo <guillermo.royo@cosof.cl> - 08/01/2020
	* @param   array   $id
	*/
	public function getUsuarioJuridicoById($id){
		$query	= "	SELECT      
						usuario.*
					FROM ".$this->_tabla." usuario
					WHERE  usuario.".$this->_primaria." = ".$id."
						";

		$param	= array($id);
		$result = $this->db->getQuery($query, $param)->runQuery();
		
		return $result->getRows(0);
	}

	/**
	* Descripción : Obtener Usuarios Juridicos Con Perfil
	* @author  Guillermo Royo <guillermo.royo@cosof.cl> - 08/01/2020
	*/
	public function getUsuariosJuridicos(){
		$query	= "	SELECT      
						usuario.".$this->_primaria.",
						usuario.nombres,
						usuario.apellidos,
						perfil.id

					FROM ".$this->_tabla." 			usuario
					LEFT JOIN   sum_v4_usuario_perfil  usuario_perfil  ON  usuario_perfil.id_usuario  = usuario.".$this->_primaria."
					LEFT JOIN   sum_v4_perfil  		perfil  		ON  usuario_perfil.id_perfil  = perfil.id
					WHERE       usuario.activo = 1
					AND			(usuario_perfil.id_perfil = 20 OR usuario_perfil.id_perfil = 21) 
					";


		$result	= $this->db->getQuery($query)->runQuery();
		if($result->getNumRows()>0){
			return $result->getRows();
		}else{
			return NULL;
		}
	}


	/**
 * Descripción: Obtener todos los usuarios con perfil Abogado, incluye perfil ABOGADO REVISOR, ABOGADO
 * @autor Andrea Arancibia 
 * @return Lista de Abogados
 */
	public function getListaAbogados(){
		$where  = " WHERE ";
		
		$query	= " SELECT
						usuario.rut AS gl_rut,
						CONCAT(COALESCE(usuario.nombres,''),' ',COALESCE(usuario.apellidos,'')) AS gl_nombre_completo,
						usuario.email AS gl_email,
						usuario.activo AS bo_activo,
						usuario.gl_token AS gl_token,
                        IFNULL((SELECT GROUP_CONCAT(DISTINCT perfil.nombre SEPARATOR ', ') FROM sum_v4_usuario_perfil usu_perfil
                                LEFT JOIN sum_v4_perfil perfil ON perfil.id = usu_perfil.id_perfil
								WHERE usu_perfil.id_usuario = usuario.USUA_id AND usu_perfil.bo_activo = 1),'') AS gl_perfiles,
                        IFNULL((SELECT IF(COUNT(perfil.nombre) > 1,'_PERSONALIZADO',perfil.nombre) FROM sum_v4_usuario_perfil usu_perfil
                                LEFT JOIN sum_v4_perfil perfil ON perfil.id = usu_perfil.id_perfil
								WHERE usu_perfil.id_usuario = usuario.USUA_id AND usu_perfil.defecto = 1),'') AS gl_perfil,
						IFNULL(inhabilitado.gl_estado,'') AS  gl_estado,
						usu_perfil.id_perfil AS id_perfil,
						usuario.USUA_id AS id_usuario
                    FROM    ".$this->_tabla." usuario
                    LEFT JOIN  ".$this->_tablaPerfilUsuarioV4." usu_perfil   ON  ( usu_perfil.id_usuario = usuario.USUA_id )
					LEFT JOIN  ".$this->_tablaPerfilV4."        perfil       ON (perfil.id = usu_perfil.id_perfil )
					LEFT JOIN  ".$this->_tablaInhabilitarAbogadoV4."  inhabilitado ON (usuario.USUA_id = inhabilitado.id_usuario )
					
					WHERE usuario.USUA_id IN (SELECT usu_perfil.id_usuario 
					                          FROM ".$this->_tablaPerfilUsuarioV4." usu_perfil
											  left join ".$this->_tabla." usuario  on usuario.USUA_id= usu_perfil.id_usuario
											  left join ".$this->_tablaPerfilV4." perfil on usu_perfil.id_perfil = perfil.id
											  WHERE usu_perfil.id_usuario = usuario.USUA_id AND usu_perfil.id_perfil in( 5,6,7,8))
                    		
                    ";
		$result	= $this->db->getQuery($query)->runQuery();
		file_put_contents('php://stderr', PHP_EOL . print_r($this->db->showQuery(), TRUE). PHP_EOL, FILE_APPEND);
		//file_put_contents('php://stderr', PHP_EOL . print_r($this->db->getQuery($query,$params)->showQuery(), TRUE). PHP_EOL, FILE_APPEND);
		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}
	

	

	/**
	* Descripción : Obtener Usuarios por Expediente 
	* @author  Javier Echiburu <javier.echiburu@cosof.cl> 
	*/
	public function getUsuariosDeExpediente($ids){
		$query	= "	SELECT      
						".$this->_primaria.",
						rut,
						nombres,
						apellidos,
						email

					FROM ".$this->_tabla."
					WHERE  USUA_id IN (".$ids.")";


		$result	= $this->db->getQuery($query)->runQuery();
		if($result->getNumRows()>0){
			return $result->getRows();
		}else{
			return NULL;
		}
	}
    
    /**
	* Descripción   : Obtener Usuarios por Expediente 
	* @author      : David Guzmán <david.guzman@cosof.cl>
	*/
    public function getListaActivos() {
        $query	= "	SELECT
						usuario.*,
                        (SELECT count(id) FROM ".TABLA_USUARIO_PERFIL_V4." usu_perfil
                         WHERE usuario.USUA_id = usu_perfil.id_usuario AND usu_perfil.bo_activo = 1) AS cont_perfil
					FROM ".$this->_tabla." usuario
                    WHERE usuario.activo = 1
					ORDER BY upper(nombres) ";
        
        $result	= $this->db->getQuery($query)->runQuery();
		if($result->getNumRows()>0){
			return $result->getRows();
        } else {
            return NULL;
        }
	}
	

	public function getUsuariosPerfilNuevo($id_perfil_nuevo, $id_region = null)
    {
		$query = '
			select su.USUA_id,
			su.nombres,
			su.apellidos,
			inhabilitado.gl_estado as inhabilitado_estado
			from sum_usuario su 
			left join sum_v4_usuario_perfil up on up.id_usuario = su.USUA_id
			left join  '.$this->_tablaInhabilitarAbogadoV4.'  inhabilitado ON (su.USUA_id = inhabilitado.id_usuario )
            where up.id_perfil = ' . (int)$id_perfil_nuevo . ' and up.bo_activo = 1 and su.activo = 1';

        if (!is_null($id_region) and $id_region > 0 ) {
            $query .= ' and su.id_region = ' . (int)$id_region;
		}
		

        $result	= $this->db->getQuery($query)->runQuery();
		if($result->getNumRows()>0){
			return $result->getRows();
        } else {
            return NULL;
        }


    }
}
