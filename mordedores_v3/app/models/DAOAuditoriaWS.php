<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_auditoria_ws
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 08/05/2018
 * 
 * @name             DAOAuditoriaWS.php
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
class DAOAuditoriaWS extends Model {

    protected $_tabla			= "mor_auditoria_ws";
    protected $_primaria		= "id_auditoria_login";
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
        $query	= "	SELECT * FROM ".$this->_tabla."
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
	 * Descripción : Obtiene información por Id de Usuario
	 * @author  David Guzmán - david.guzman@cosof.cl - 08/05/2018
     * @param   int $id_usuario
	 */
    public function getByIdUsuario($id_usuario) {
        $query	= "	SELECT * 
					FROM mor_auditoria_login_ws
					WHERE id_usuario = ?";

		$param	= array($id_usuario);
        $result	= $this->db->getQuery($query,$param);

        if ($result->numRows > 0) {
            return $result->rows->row_0;
        } else {
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene información por Rut de Usuario
	 * @author  David Guzmán - david.guzman@cosof.cl - 08/05/2018
     * @param   string $gl_rut
	 */
    public function getByRut($gl_rut) {
        $query	= "	SELECT * 
					FROM mor_auditoria_login_ws
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
	 * Descripción : Inserta registro en tabla "mor_auditoria_login_ws"
	 * @author  David Guzmán - david.guzman@cosof.cl - 08/05/2018
     * @param   int    $id_usuario
     * @param   string $rut_usuario
     * @param   string $gl_origen
     * @param   string $token
	 */
	public function registro_login($id_usuario, $rut_usuario, $gl_origen, $token = ''){
		$ip_privada	= '0.0.0';
		$ip_publica	= '0.0.0';

		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip_privada	= $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		if(!empty($_SERVER['REMOTE_ADDR'])) {
			$ip_publica	= $_SERVER['REMOTE_ADDR'];
		}
		
		$query	= " INSERT INTO mor_auditoria_login_ws 
						(
							id_usuario,
							gl_rut,
							gl_origen,
							gl_token,
							ip_privada,
							ip_publica
						)
						VALUES (?,?,?,?,?,?)";
		$param	= array($id_usuario,$rut_usuario,$gl_origen,$token,$ip_privada,$ip_publica);
		return $this->db->execQuery($query,$param);
	}
    
    public function getByIdBichito($id_ws_bichito){
        $query	= "	SELECT *
                    FROM mor_auditoria_ws_bichito
					WHERE id_auditoria_login = ?";

		$param	= array($id_ws_bichito);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

}

?>