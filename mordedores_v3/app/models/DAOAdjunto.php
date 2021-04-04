<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 *
 * Descripcion       : Modelo para Tabla mor_adjunto
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 08/05/2018
 *
 * @name             DAOAdjunto.php
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
class DAOAdjunto extends Model{

    protected $_tabla           = "mor_adjunto";
    protected $_primaria        = "id_adjunto";
    protected $_transaccional	= false;

    function __construct()
    {
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
	 * Descripción : Obtiene por Id de Paciente
	 * @author  David Guzmán - david.guzman@cosof.cl - 08/05/2018
	 */
    public function getByIdPaciente($id_paciente) {
        $query	= "	SELECT *
			FROM mor_adjunto
			WHERE id_paciente = ?";

		$params	= array($id_paciente);
        $result	= $this->db->getQuery($query, $params);

		if($result->numRows > 0) {
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene por Id de Expediente
	 * @author  David Guzmán - david.guzman@cosof.cl - 08/05/2018
	 */
    public function getByIdExpediente($id_expediente) {
        $query	= "	SELECT
                        adj.*,
                        DATE_FORMAT(adj.fc_crea, '%d-%m-%Y') AS fc_crea,
                        at.gl_nombre_tipo_adjunto AS gl_tipo,
                        CONCAT(u.gl_nombres,' ',u.gl_apellidos) AS nombre_usuario
                    FROM mor_adjunto adj
                    LEFT JOIN mor_adjunto_tipo at ON adj.id_adjunto_tipo = at.id_adjunto_tipo
                    LEFT JOIN mor_acceso_usuario u ON adj.id_usuario_crea = u.id_usuario
                    WHERE adj.id_expediente = ?";

		$params	= array($id_expediente);
        $result	= $this->db->getQuery($query, $params);

		if($result->numRows > 0) {
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene por Id de Expediente
     * @author  Pablo Jimenez - pablo.jimenez@cosof.cl - 20/07/2018
     */
    public function getByIdExpedienteIdFiscalizador($id_expediente, $id_fiscalizador) {
        $query  = " SELECT
                        adj.*,
                        DATE_FORMAT(adj.fc_crea, '%d-%m-%Y') AS fc_crea,
                        at.gl_nombre_tipo_adjunto AS gl_tipo,
                        CONCAT(u.gl_nombres,' ',u.gl_apellidos) AS nombre_usuario
                    FROM mor_adjunto adj
                    LEFT JOIN mor_adjunto_tipo at ON adj.id_adjunto_tipo = at.id_adjunto_tipo
                    LEFT JOIN mor_acceso_usuario u ON adj.id_usuario_crea = u.id_usuario
                    WHERE adj.id_expediente = ?
                    AND adj.id_fiscalizador = ?";

        $params = array($id_expediente, $id_fiscalizador);
        $result = $this->db->getQuery($query, $params);

        if($result->numRows > 0) {
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene por Id de Visita
	 * @author  David Guzmán - david.guzman@cosof.cl - 01/06/2018
	 */
    public function getByVisitaAndMordedor($id_visita,$id_mordedor) {
        $query	= "	SELECT
                        adj.*,
                        DATE_FORMAT(adj.fc_crea, '%d-%m-%Y') AS fc_crea,
                        at.gl_nombre_tipo_adjunto AS gl_tipo,
                        CONCAT(u.gl_nombres,' ',u.gl_apellidos) AS nombre_usuario
                    FROM mor_adjunto adj
                    LEFT JOIN mor_adjunto_tipo at ON adj.id_adjunto_tipo = at.id_adjunto_tipo
                    LEFT JOIN mor_acceso_usuario u ON adj.id_usuario_crea = u.id_usuario
                    WHERE adj.id_visita = ? AND adj.id_mordedor = ?";

		$params	= array($id_visita,$id_mordedor);
        $result	= $this->db->getQuery($query, $params);

		if($result->numRows > 0) {
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene por Id de mordedor
     * @author  Pablo Jimenez - pablo.jimenez@cosof.cl - 18/06/2018
     */
    public function getByMordedor($id_mordedor) {
        $query  = " SELECT
                        adj.*,
                        DATE_FORMAT(adj.fc_crea, '%d-%m-%Y') AS fc_crea,
                        at.gl_nombre_tipo_adjunto AS gl_tipo,
                        CONCAT(u.gl_nombres,' ',u.gl_apellidos) AS nombre_usuario
                    FROM mor_adjunto adj
                    LEFT JOIN mor_adjunto_tipo at ON adj.id_adjunto_tipo = at.id_adjunto_tipo
                    LEFT JOIN mor_acceso_usuario u ON adj.id_usuario_crea = u.id_usuario
                    WHERE adj.id_mordedor = ?";

        $params = array($id_mordedor);
        $result = $this->db->getQuery($query, $params);

        if($result->numRows > 0) {
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene por Token
	 * @author  David Guzmán - david.guzman@cosof.cl - 08/05/2018
	 */
    public function getByToken($gl_token) {
        $query	= "	SELECT *
			FROM mor_adjunto
			WHERE gl_token = ?";

		$params	= array($gl_token);
        $result	= $this->db->getQuery($query, $params);

		if($result->numRows > 0) {
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtiene por Expediente y Tipo adjunto
	 * @author  David Guzmán - david.guzman@cosof.cl - 11/06/2018
	 */
    public function getByExpedienteyTipo($id_expediente,$id_tipo=0) {
        $query	= "	SELECT *
			FROM mor_adjunto
			WHERE id_expediente = ? AND id_adjunto_tipo = ?";

		$params	= array($id_expediente,$id_tipo);
        $result	= $this->db->getQuery($query, $params);

		if($result->numRows > 0) {
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Inserta Nuevo Adjunto
	 * @author  David Guzmán <david.guzman@cosof.cl> - 22/05/2018
     * @param   array $params
	 */
    public function insertarAdjunto($params) {
        $query = "  INSERT INTO ".$this->_tabla."
                        (
                            gl_token,
                            id_expediente,
                            id_visita,
                            id_paciente,
                            id_mordedor,
                            id_adjunto_tipo,
                            gl_nombre,
                            gl_path,
                            gl_glosa,
                            id_fiscalizador,
                            id_usuario_crea
                        )
					VALUES
                        (?,?,?,?,?,?,?,?,?,?,".intval($_SESSION[SESSION_BASE]['id']).")";

        if ($this->db->execQuery($query,$params)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }

    public function updateAdjunto($id, $nombre, $estado, $path, $glosa) {

        $query	= "	UPDATE ".$this->_tabla."
                        SET gl_nombre               = '".$nombre."',
                            bo_estado	            = ".$estado.",
                            gl_path 	            = '".$path."',
                            gl_glosa 	            = '".$glosa."'
					WHERE id_adjunto = '".$id."'
                    ";

        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>