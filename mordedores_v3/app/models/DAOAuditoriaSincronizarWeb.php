<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_auditoria_sincronizar_web
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 23/11/2018
 * 
 * @name             DAOAuditoriaSincronizarWeb.php
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
class DAOAuditoriaSincronizarWeb extends Model {

    protected $_tabla			= "mor_auditoria_sincronizar_web";
    protected $_primaria		= "id_sincronizar_web";
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
	 * Descripción : Inserta registro en tabla "mor_auditoria_sincronizar_web"
	 * @author  David Guzmán - david.guzman@cosof.cl - 23/11/2018
     * @param   string $gl_origen
     * @param   array $array_log
	 */
	public function registro_log($gl_origen,$id_expediente,$array_log){
		$gl_ip_privada	= '0.0.0';
		$gl_ip_publica	= '0.0.0';
		$id_usuario		= intval($_SESSION[SESSION_BASE]['id']);
		$id_expediente	= intval($id_expediente);

		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$gl_ip_privada	= $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		if(!empty($_SERVER['REMOTE_ADDR'])) {
			$gl_ip_publica	= $_SERVER['REMOTE_ADDR'];
		}
		
		$query	= " INSERT INTO ".$this->_tabla." 
						(
							id_usuario,
							gl_origen,
							id_expediente,
							json_log,
							json_session,
							gl_ip_privada,
							gl_ip_publica
						)
						VALUES (?,?,?,?,?,?,?)";
		$param	= array($id_usuario,$gl_origen,$id_expediente,json_encode($array_log,JSON_UNESCAPED_SLASHES),json_encode($_SESSION[SESSION_BASE],JSON_UNESCAPED_SLASHES ),$gl_ip_privada,$gl_ip_publica);
		//$param	= array($gl_origen,addslashes(json_encode($array_log)),addslashes(json_encode($_SESSION[SESSION_BASE])),$gl_ip_privada,$gl_ip_publica);
		return $this->db->execQuery($query,$param);
	}

}

?>