<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_acceso_usuario
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 08/05/2018
 * 
 * @name             DAOAccesoUsuario.php
 * 
 * @version          1.0
 *
 * @author           David Guzmán <david.guzman@cosof.cl>
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
class DAOAccesoUsuario extends Model {

    protected $_tabla			= "mor_acceso_usuario";
    protected $_primaria		= "id_usuario";
    protected $_transaccional	= false;

    function __construct(){
        parent::__construct();       
    }

    public function getLista(){
        $query	= "	SELECT * FROM ".$this->_tabla;
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    public function getById($id){
        $query	= "	SELECT	*
					FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param	= array($id);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

	/**
	* Descripción : Obtiene Usuario por Rut
	* @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	* @param   string  $gl_rut
	*/
    public function getByRut($gl_rut) {
        $query	= "	SELECT * 
					FROM ".$this->_tabla."
					WHERE gl_rut = ?";

		$param	= array($gl_rut);
        $result	= $this->db->getQuery($query,$param);

        if ($result->numRows > 0) {
            return $result->rows->row_0;
        } else {
            return NULL;
        }
    }

	/**
	* Descripción : Valida Usuario si tiene rol principal, si tiene otro rol deja como principal ese
	* @author  David Guzmán <david.guzman@cosof.cl> - 03/10/2018
	* @param   string	$gl_rut del usuario.
	* @return  object  Información del usuario
	*/
    public function validarUsuario($gl_rut) {
        $query	= "	SELECT 
						usuario.id_usuario
					FROM mor_acceso_usuario usuario 
						INNER JOIN mor_acceso_usuario_perfil usuario_perfil 
							ON (usuario_perfil.id_usuario = usuario.id_usuario
								AND usuario_perfil.bo_principal = 1 
								AND usuario_perfil.bo_activo = 1)
						INNER JOIN mor_acceso_perfil perfil ON usuario_perfil.id_perfil= perfil.id_perfil
					WHERE usuario.gl_rut = ?";

        $param	= array($gl_rut);
        $result	= $this->db->getQuery($query,$param);
        
        //Si Existe retorna true
        if ($result->numRows > 0) {
            return TRUE;
        } else {
            $query	= "	UPDATE mor_acceso_usuario_perfil
                        SET bo_principal = 0
                        WHERE mor_acceso_usuario_perfil.id_usuario = (SELECT id_usuario FROM mor_acceso_usuario WHERE gl_rut = ?)";
            
            $param	= array($gl_rut);
            
            if($this->db->execQuery($query,$param)){
                //Busca otro perfil para dejarlo como principal
                $query	= "	SELECT 
                                usuario_perfil.id_usuario_perfil
                            FROM mor_acceso_usuario usuario 
                                INNER JOIN mor_acceso_usuario_perfil usuario_perfil 
                                    ON (usuario_perfil.id_usuario = usuario.id_usuario
                                        AND usuario_perfil.bo_activo = 1)
                                INNER JOIN mor_acceso_perfil perfil ON usuario_perfil.id_perfil= perfil.id_perfil
                            WHERE usuario.gl_rut = ? LIMIT 1";

                $param	= array($gl_rut);
                $result	= $this->db->getQuery($query,$param);
                
                if ($result->numRows > 0) {
                    $arr = $result->rows->row_0;
                    $id_usuario_perfil = $arr->id_usuario_perfil;
                    
                    //setea bo_principal en 1 perfil encontrado
                    $query	= "	UPDATE mor_acceso_usuario_perfil
                                SET bo_principal = 1
                                WHERE mor_acceso_usuario_perfil.id_usuario_perfil = ?";

                    $param	= array($id_usuario_perfil);
                    if($this->db->execQuery($query,$param)){
                        return TRUE;
                    }else{
                        //No marcó ninguno como principal
                        return FALSE;
                    }
                    
                }else{
                    //No tiene mas perfiles para marcar como principal
                    return FALSE;
                }
                
            }else{
                //Error: no realizo acción
                return FALSE;
            }
        }
    }

	/**
	* Descripción : Obtener la información para Validar al usuario e Iniciar la Session
	* @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	* @param   string	$gl_rut del usuario.
	* @param   string	$gl_password  del usuario.
	* @return  object  Información del usuario
	*/
    public function getLogin($gl_rut, $gl_password) {
        $query	= "	SELECT 
						usuario.*,
						usuario_perfil.id_usuario_perfil,
						usuario_perfil.id_perfil,
                        usuario_perfil.id_establecimiento,
                        usuario_perfil.id_servicio,
                        usuario_perfil.id_region,
                        usuario_perfil.id_oficina,
                        usuario_perfil.id_comuna,
                        usuario_perfil.id_laboratorio,
						perfil.bo_establecimiento,
						perfil.bo_nacional,
						perfil.bo_regional,
						perfil.bo_oficina,
						perfil.bo_comunal,
						perfil.bo_seremi
					FROM mor_acceso_usuario usuario 
						LEFT JOIN mor_acceso_usuario_perfil usuario_perfil 
							ON (usuario_perfil.id_usuario = usuario.id_usuario
								AND usuario_perfil.bo_principal = 1 
								AND usuario_perfil.bo_activo = 1)
						LEFT JOIN mor_acceso_perfil perfil ON usuario_perfil.id_perfil= perfil.id_perfil
					WHERE usuario.gl_rut = ? 
						AND usuario.gl_password = ?";

        $param	= array($gl_rut, $gl_password);
        $result	= $this->db->getQuery($query, $param);

        if ($result->numRows > 0) {
            return $result->rows->row_0;
        } else {
            return NULL;
        }
    }

	/**
	* Descripción : Obtener la información para Validar al usuario que ingresa 
	* desde MIDAS e Iniciar la Session
	* @author  David Guzmán <david.guzman@cosof.cl>
	* @param   string	$gl_rut del usuario.
	* @return  object  Información del usuario
	*/
    public function getLoginMidas($gl_rut) {
        $query	= "	SELECT 
                        usuario.*,
						usuario_perfil.id_usuario_perfil,
						usuario_perfil.id_perfil,
                        usuario_perfil.id_establecimiento,
                        usuario_perfil.id_servicio,
                        usuario_perfil.id_region,
                        usuario_perfil.id_oficina,
                        usuario_perfil.id_comuna,
                        usuario_perfil.id_laboratorio,
						perfil.bo_establecimiento,
						perfil.bo_nacional,
						perfil.bo_regional,
						perfil.bo_oficina,
						perfil.bo_comunal,
						perfil.bo_seremi
					FROM mor_acceso_usuario usuario 
						LEFT JOIN mor_acceso_usuario_perfil usuario_perfil 
							ON (usuario_perfil.id_usuario = usuario.id_usuario 
								AND usuario_perfil.bo_principal = 1 
								AND usuario_perfil.bo_activo = 1)
						LEFT JOIN mor_acceso_perfil perfil ON usuario_perfil.id_perfil= perfil.id_perfil
					WHERE TRIM(usuario.gl_rut) = ? ";

        $param	= array(trim($gl_rut));
        $result	= $this->db->getQuery($query, $param);

        if ($result->numRows > 0) {
            return $result->rows->row_0;
        } else {
            return NULL;
        }
    }
	
	/**
	* Descripción : Obtiene datos de Usuario Logueado
	* @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	* @param   int $id_usuario
	*/
    public function getLoginByID($id_usuario) {
        $query	= "	SELECT 
						usuario.*,
						usuario_perfil.id_usuario_perfil,
						usuario_perfil.id_perfil,
                        usuario_perfil.id_establecimiento,
                        usuario_perfil.id_servicio,
                        usuario_perfil.id_region,
                        usuario_perfil.id_oficina,
                        usuario_perfil.id_comuna,
                        usuario_perfil.id_laboratorio,
						perfil.bo_establecimiento,
						perfil.bo_nacional,
						perfil.bo_regional,
						perfil.bo_oficina,
						perfil.bo_comunal,
						perfil.bo_seremi
					FROM mor_acceso_usuario usuario 
						LEFT JOIN mor_acceso_usuario_perfil usuario_perfil 
							ON (usuario_perfil.id_usuario = usuario.id_usuario
								AND usuario_perfil.bo_principal = 1 
								AND usuario_perfil.bo_activo = 1)
						LEFT JOIN mor_acceso_perfil perfil ON usuario_perfil.id_perfil= perfil.id_perfil
					WHERE usuario.id_usuario = ? ";

        $param	= array($id_usuario);
        $result	= $this->db->getQuery($query, $param);

        if ($result->numRows > 0) {
            return $result->rows->row_0;
        } else {
            return NULL;
        }
    }

	/**
	* Descripción : Setea Login
	* @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	* @param   array   $datos
	*/
    public function setUltimoLogin($datos){
        $query	= "	UPDATE mor_acceso_usuario
					SET fc_ultimo_login         = now(),
                        id_usuario_actualiza	= ".intval($_SESSION[SESSION_BASE]['id']).",
						fc_actualiza			= now()
					WHERE id_usuario = ? ";

        if ($this->db->execQuery($query, $datos)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

	/**
	* Descripción : Setea Password
	* @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	* @param   array   $datos
	*/
	/*
    public function setPassword($datos){
        $query	= "	UPDATE mor_acceso_usuario
					SET gl_password             = ? ,
                        fc_ultimo_login         = ?,
                        id_usuario_actualiza	= ".intval($_SESSION[SESSION_BASE]['id']).",
						fc_actualiza			= now()
					WHERE id_usuario = ? ";

        if ($this->db->execQuery($query, $datos)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    */
    
    /*CAMBIO PASSWORD*/
    public function setSoloPassword($datos){
        $query	= "	UPDATE mor_acceso_usuario
					SET gl_password     = ?
					WHERE id_usuario    = ? ";

        if ($this->db->execQuery($query, $datos)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	/**
	* Descripción : Obtener la información todos los usuarios junto con la 
	* informacion de perfil
	* @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
	* @param   array   $parametros
	* @return  object  Todos los usuarios junto la informacion de perfil.
	*/
    public function getListaJoinPerfil($params=array()) {
        $query	= "	SELECT
						usuario.*,
                        (
                            SELECT 
								GROUP_CONCAT(p.gl_nombre_perfil SEPARATOR ', ')
                            FROM mor_acceso_usuario_perfil usuario_perfil
								LEFT JOIN mor_acceso_perfil p ON usuario_perfil.id_perfil = p.id_perfil
                            WHERE usuario_perfil.bo_activo = 1 
								AND usuario_perfil.id_usuario = usuario.id_usuario
                        ) AS gl_nombre_perfil
					FROM mor_acceso_usuario usuario";

		$where = " WHERE ";
        if(!empty($params)){
            if(isset($params['id_region']) && $params['id_region'] > 0){
                $query .= "$where ".intval($params['id_region'])." IN (SELECT mor_acceso_usuario_perfil.id_region FROM mor_acceso_usuario_perfil
                                                                WHERE mor_acceso_usuario_perfil.id_usuario = usuario.id_usuario)";
                $where = " AND ";
            }
            if(isset($params['id_oficina']) && $params['id_oficina'] > 0){
                if($params['id_perfil'] == 0 || $params['id_perfil'] == 6 || $params['id_perfil'] == 10 || $params['id_perfil'] == 14){
                    $query .= "$where ".intval($params['id_oficina'])." IN (SELECT mor_acceso_usuario_perfil.id_oficina FROM mor_acceso_usuario_perfil
                                                                    WHERE mor_acceso_usuario_perfil.id_usuario = usuario.id_usuario)";
                    $where = " AND ";
                }
            }
            if(isset($params['id_comuna']) && $params['id_comuna'] > 0){
                if($params['id_perfil'] == 0 || $params['id_perfil'] == 6 || $params['id_perfil'] == 10 || $params['id_perfil'] == 14){
                    $query .= "$where ".intval($params['id_comuna'])." IN (SELECT ofi_com.id_comuna FROM mor_direccion_oficina_comuna ofi_com 
                                                                    LEFT JOIN mor_acceso_usuario_perfil ON mor_acceso_usuario_perfil.id_oficina = ofi_com.id_oficina
                                                                    WHERE mor_acceso_usuario_perfil.id_usuario = usuario.id_usuario)";
                    $where = " AND ";
                }
            }
            if(isset($params['id_perfil']) && $params['id_perfil'] > 0){
                $query .= "$where ".intval($params['id_perfil'])." IN (SELECT mor_acceso_usuario_perfil.id_perfil FROM mor_acceso_usuario_perfil
                                                                WHERE mor_acceso_usuario_perfil.id_usuario = usuario.id_usuario)";
                $where = " AND ";
            }
            if(isset($params['bo_activo']) && $params['bo_activo'] != ""){
                if($params['bo_activo'] == 0 || $params['bo_activo'] == 1){
                    $query .= "$where usuario.bo_activo = ". intval($params['bo_activo']);
                    $where = " AND ";
                }
            }
        }
        
        $result	= $this->db->getQuery($query);
        if ($result->numRows > 0) {
            return $result->rows;
        } else {
            return NULL;
        }
    }
	
	/**
	* Descripción : Obtener detalle de usuario por ID
	* @author  David Guzmán <david.guzman@cosof.cl> - 10/05/2018
	* @param   int   $id_usuario
	* @return  object  información de usuario
	*/
    public function getDetalleByID($id_usuario) {
        $params = array();
        $query	= "	SELECT 
						usuario.*,
						perfil.id_perfil,
						perfil.gl_nombre_perfil,
                        (SELECT gl_nombre_region FROM mor_direccion_region WHERE id_region = usuario_perfil.id_region) AS gl_nombre_region,
						usuario_perfil.id_establecimiento
					FROM mor_acceso_usuario usuario 
						LEFT JOIN mor_acceso_usuario_perfil usuario_perfil 
							ON (usuario.id_usuario = usuario_perfil.id_usuario 
								AND usuario_perfil.bo_activo = 1 
								AND usuario_perfil.bo_principal = 1)
						LEFT JOIN mor_acceso_perfil perfil ON usuario_perfil.id_perfil = perfil.id_perfil
                    WHERE usuario.id_usuario = ?";

        $param	= array($id_usuario);
        $result	= $this->db->getQuery($query,$param);
        if ($result->numRows > 0) {
            return $result->rows->row_0;
        } else {
            return NULL;
        }
    }
	
	/**
	* Descripción : Obtener detalle de usuario por token
	* @author  David Guzmán <david.guzman@cosof.cl> - 11/05/2018
	* @param   string   $gl_token
	* @return  object  información de usuario
	*/
    public function getDetalleByToken($gl_token) {
        $params = array();
        $query	= "	SELECT 
						usuario.*,
						perfil.id_perfil,
						perfil.gl_nombre_perfil,
						(SELECT gl_nombre_region FROM mor_direccion_region WHERE id_region = usuario_perfil.id_region) AS gl_nombre_region,
                        usuario_perfil.id_establecimiento
					FROM mor_acceso_usuario usuario 
						LEFT JOIN mor_acceso_usuario_perfil usuario_perfil 
							ON (usuario.id_usuario = usuario_perfil.id_usuario AND usuario_perfil.bo_activo = 1 
							AND usuario_perfil.bo_principal = 1)
						LEFT JOIN mor_acceso_perfil perfil ON usuario_perfil.id_perfil = perfil.id_perfil
                    WHERE usuario.gl_token = ?";

        $param	= array($gl_token);
        $result	= $this->db->getQuery($query,$param);
        if ($result->numRows > 0) {
            return $result->rows->row_0;
        } else {
            return NULL;
        }
    }
	
	/**
	 * Descripción : Setea Usuario
     * @author  David Guzmán <david.guzman@cosof.cl> - 08/05/2018
     * @param   array   $parametros
	 */
    public function updateUsuario($parametros){
        $query	= "	UPDATE mor_acceso_usuario
					SET 
						gl_nombres              = COALESCE(".$parametros['gl_nombres'].",gl_nombres),
						gl_apellidos            = COALESCE(".$parametros['gl_apellidos'].",gl_apellidos),
						gl_email                = COALESCE(".$parametros['gl_email'].",gl_email),
						bo_activo               = ".$parametros['bo_estado'].",
						bo_cambio_usuario       = ".$parametros['bo_cambio_usuario'].",
						bo_informar_web         = ".$parametros['bo_informar_web'].",
                        id_usuario_actualiza    = ".intval($_SESSION[SESSION_BASE]['id']).",
						fc_actualiza			= now()
					WHERE id_usuario = ".$parametros['id_usuario']."";

        if ($this->db->execQuery($query, $parametros)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	/**
	 * Descripción : Insertar Nuevo Usuario
	 * @author  David Guzmán <david.guzman@cosof.cl> - 10/05/2018
     * @param   array  $parametros
	 */
    public function insertNuevo($parametros){
        $query	= "	INSERT INTO mor_acceso_usuario (
						gl_token,
						gl_rut,
						gl_password,
						gl_nombres,
						gl_apellidos,
						gl_email,
                        bo_cambio_usuario,
                        bo_informar_web,
						id_usuario_crea,
						fc_crea
                    ) VALUES (?,?,?,?,?,?,?,?,".intval($_SESSION[SESSION_BASE]['id']).",now())";
        
        if ($this->db->execQuery($query,$parametros)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
	
    /**
	 * Descripción : Obtener listado de fiscalizadores
	 * @author  David Guzmán <david.guzman@cosof.cl> - 23/05/2018
     * @param   int  $id_region
	 */
    public function obtenerFiscalizadores($id_region=null,$id_comuna=null,$id_oficina=null){
        $params = array();
        $query	= "	SELECT DISTINCT
                        usuario.*,
                        IFNULL((    SELECT 1 FROM mor_acceso_usuario_perfil usuario_perfil2
                                    WHERE usuario_perfil2.id_usuario = usuario.id_usuario
                                    AND usuario_perfil2.id_perfil = 14 LIMIT 1   ), 0    ) AS bo_municipal
                    FROM mor_acceso_usuario usuario
						LEFT JOIN mor_acceso_usuario_perfil usuario_perfil ON usuario.id_usuario = usuario_perfil.id_usuario
                    WHERE usuario_perfil.bo_activo = 1 
						AND usuario_perfil.id_perfil IN (6,14) 
						AND usuario.bo_activo = 1
                    ";
        
        if($id_comuna!=null){
            $query .= " AND usuario_perfil.id_oficina = (
														SELECT 
															id_oficina 
														FROM mor_direccion_oficina_comuna 
														WHERE bo_estado = 1 
															AND id_comuna = ?
														LIMIT 1
														) ";
            $params = array_merge($params,array($id_comuna));
        }
        if($id_oficina!=null){
            $query .= " AND usuario_perfil.id_oficina = ?";
            $params = array_merge($params,array($id_oficina));
        }
        if($id_region!=null){
            $query .= " AND usuario_perfil.id_region = ? ";
            $params = array_merge($params,array($id_region));
        }
        
        $result	= $this->db->getQuery($query,$params);
        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
}

?>