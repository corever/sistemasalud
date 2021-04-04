<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_paciente_agenda
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 09/05/2018
 * 
 * @name             DAOPacienteAgenda.php
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
class DAOPacienteAgenda extends Model{

    protected $_tabla			= "mor_paciente_agenda";
    protected $_primaria		= "id_agenda";
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
        $id = intval($id);
        
        if($id > 0){
            $query	= "	SELECT 
                            agenda.*,
                            CONCAT(paciente.gl_nombres,' ',paciente.gl_apellido_paterno,' ',paciente.gl_apellido_materno) AS gl_nombre_paciente,
                            IFNULL(paciente.gl_rut,'') AS gl_rut_paciente,
                            IFNULL(paciente_datos.json_pasaporte,'') AS json_pasaporte,
                            expediente.gl_folio,
                            establecimiento.gl_nombre_establecimiento
                        FROM ".$this->_tabla." agenda
                        LEFT JOIN mor_paciente paciente ON agenda.id_paciente = paciente.id_paciente
                        LEFT JOIN mor_paciente_datos paciente_datos ON agenda.id_paciente = paciente_datos.id_paciente
                        LEFT JOIN mor_expediente expediente ON agenda.id_expediente = expediente.id_expediente
                        LEFT JOIN mor_establecimiento_salud establecimiento ON agenda.id_establecimiento = establecimiento.id_establecimiento
                        WHERE agenda.".$this->_primaria." = $id";

            $result	= $this->db->getQuery($query);

            if($result->numRows > 0){
                return $result->rows->row_0;
            }else{
                return NULL;
            }
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Trae Agenda por Establecimiento
	 * @author  David Guzmán <david.guzman@cosof.cl> - 07/09/2018
     * @param   array $params 
	 */
    public function getByEstablecimiento($id_establecimiento){
        $id_establecimiento = intval($id_establecimiento);
        
        if($id_establecimiento > 0){
            $query	= "	SELECT
                            agenda.*,
                            CONCAT(paciente.gl_nombres,' ',paciente.gl_apellido_paterno,' ',paciente.gl_apellido_materno) AS gl_nombre_paciente,
                            IFNULL(paciente.gl_rut,'') AS gl_rut_paciente,
                            IFNULL(paciente_datos.json_pasaporte,'') AS json_pasaporte,
                            expediente.gl_folio
                        FROM ".$this->_tabla." agenda
                        LEFT JOIN mor_paciente paciente ON agenda.id_paciente = paciente.id_paciente
                        LEFT JOIN mor_paciente_datos paciente_datos ON agenda.id_paciente = paciente_datos.id_paciente
                        LEFT JOIN mor_expediente expediente ON agenda.id_expediente = expediente.id_expediente
                        WHERE agenda.id_establecimiento = ?";

            $param	= array($id_establecimiento);
            $result	= $this->db->getQuery($query,$param);

            if($result->numRows > 0){
                return $result->rows;
            }else{
                return NULL;
            }
        }else{
            return NULL;
        }
    }
    
    /**
	 * Descripción : Inserta Nuevo registro de Agenda
	 * @author  David Guzmán <david.guzman@cosof.cl> - 06/09/2018
     * @param   array $params 
	 */
    public function insertarAgenda($data) {
        $query = "  INSERT INTO ".$this->_tabla."
                        (
                            id_expediente,
                            id_paciente,
                            id_establecimiento,
                            json_agenda,
                            gl_observacion,
                            id_usuario_crea
                        )
					VALUES 
                        (
                            ".intval($data['id_expediente']).",
                            ".intval($data['id_paciente']).",
                            ".intval($data['id_establecimiento']).",
                            '".$data['json_agenda']."',
                            '".$data['gl_observacion']."',
                            ".intval($_SESSION[SESSION_BASE]['id'])."
                        )";

        if ($this->db->execQuery($query)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }

}

?>