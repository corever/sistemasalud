<?php
/**
 ******************************************************************************
 * Sistema           : SUMARIOS V4
 *
 * Descripcion       : Modelo para Tabla sum_auditoria
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 03/01/2020
 *
 * @name             DAOAuditoriaLogin.php
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
namespace App\_FuncionesGenerales\General\Entity;

class DAOAuditoriaLogin extends \pan\Kore\Entity{

	protected $table			= "hope_auditoria_login";
    protected $primary_key		= "id_auditoria_login";
	protected $_transaccional	= false;

    function __construct(){
        parent::__construct();       
    }

    public function getLista(){
        $query	= "	SELECT * FROM ".$this->table;
        $result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
    }

    public function getById($id){
        $query	= "	SELECT * FROM ".$this->table."
					WHERE ".$this->primary_key." = ". intval($id);

		$result = $this->db->getQuery($query)->runQuery();

		return $result->getRows(0);
    }

    /**
	 * Descripción : Obtiene información por Id de Usuario
	 * @author  David Guzmán - <david.guzman@cosof.cl> - 03/01/2020
     * @param   int $id_usuario
	 */
    public function getByIdUsuario($id_usuario) {
        $query	= "	SELECT * 
					FROM ".$this->table."
					WHERE id_usuario = " . intval($id_usuario);

		$result = $this->db->getQuery($query)->runQuery();

		return $result->getRows(0);
    }

    /**
	 * Descripción : Obtiene información por Rut de Usuario
	 * @author  David Guzmán - <david.guzman@cosof.cl> - 03/01/2020
     * @param   string $gl_rut
	 */
    public function getByRut($gl_rut) {
        $query	= "	SELECT * 
					FROM ".$this->table."
					WHERE gl_rut = '$gl_rut'";

		$result = $this->db->getQuery($query)->runQuery();

		return $result->getRows(0);
    }

    /**
	 * Descripción : Inserta registro en tabla "mor_auditoria_login"
	 * @author  David Guzmán - <david.guzman@cosof.cl> - 03/01/2020
     * @param   int    $id_usuario
     * @param   string $email_usuario
     * @param   string $gl_origen
     * @param   string $token
	 */
	public function registroLogin($id_usuario, $email_usuario, $gl_origen, $token = ''){
		$ip_privada	= '0.0.0';
		$ip_publica	= '0.0.0';

		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip_privada	= $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		if(!empty($_SERVER['REMOTE_ADDR'])) {
			$ip_publica	= $_SERVER['REMOTE_ADDR'];
		}
		
		$query	= " INSERT INTO ".$this->table." 
						(
							id_usuario,
							gl_email,
							gl_origen,
							gl_token,
							ip_privada,
							ip_publica
						)
						VALUES (?,?,?,?,?,?)";
		$param	= array($id_usuario,$email_usuario,$gl_origen,$token,$ip_privada,$ip_publica);
		return $this->db->execQuery($query,$param);
	}
}
