<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_historial_evento
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 08/05/2018
 * 
 * @name             DAOHistorialEvento.php
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
class DAOHistorialEvento extends Model{

    protected $_tabla           = "mor_historial_evento";
    protected $_primaria		= "id_evento";
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
	 * Descripción : Obtener por id_expediente
	 * @author  David Guzmán <david.guzman@cosof.cl> - 25/05/2018
     * @param   int $id_expediente 
	 */
    public function getByIdExpediente($id_expediente){
        $query	= "	SELECT 
                        e.*,
                        DATE_FORMAT(e.fc_crea, '%d-%m-%Y %H:%i:%s') AS fc_crea,
                        et.gl_nombre_evento_tipo,
                        CONCAT(creador.gl_nombres,' ',creador.gl_apellidos) AS gl_nombre_usuario
                    FROM mor_historial_evento e
                    LEFT JOIN mor_historial_evento_tipo et ON e.id_evento_tipo = et.id_evento_tipo
                    LEFT JOIN mor_acceso_usuario creador ON e.id_usuario_crea = creador.id_usuario
					WHERE id_expediente = ?";

		$param	= array($id_expediente);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
    /**
	 * Descripción : Inserta Nuevo Evento
	 * @author  David Guzmán <david.guzman@cosof.cl> - 16/05/2018
     * @param   array $params 
	 */
    public function insertarEvento($params) {
        $query = "  INSERT INTO ".$this->_tabla."
                        (
                            id_evento_tipo,
                            id_expediente,
                            id_paciente,
                            id_mordedor,
                            id_tipo_comentario,
                            gl_otro_tipo_comentario,
                            gl_descripcion,
                            mostrar_in,
                            id_usuario_crea
                        )
					VALUES 
                        (?,?,?,?,?,?,?,?,".intval($_SESSION[SESSION_BASE]['id']).")";

        if ($this->db->execQuery($query,$params)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
}

?>