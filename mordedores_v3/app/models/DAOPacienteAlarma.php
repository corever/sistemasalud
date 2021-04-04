<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_paciente_alarma
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 09/05/2018
 * 
 * @name             DAOPacienteAlarma.php
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
class DAOPacienteAlarma extends Model{

    protected $_tabla			= "mor_paciente_alarma";
    protected $_primaria		= "id_alarma";
    protected $_transaccional	= false;

    function __construct()
    {
        parent::__construct();
    }

    public function getLista(){
        $query  = " SELECT * FROM ".$this->_tabla;
        $result = $this->db->getQuery($query);
        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    public function getListaDetalle($params=null){
        $param  = array();
        $query	= "	SELECT  alarma.*,
                            DATE_FORMAT(alarma.fc_crea,'%d-%m-%Y') AS fecha_creacion,
                            paciente_alarma_tipo.gl_nombre_alarma AS nombre_tipo_alarma,
                            paciente_alarma_estado.gl_nombre_alarma AS nombre_alarma_estado,
                            paciente.gl_nombres AS paciente_nombre,
                            paciente.gl_apellido_paterno AS paciente_apellido_paterno,
                            paciente.gl_apellido_materno AS paciente_apellido_materno,
                            acceso_usuario.gl_nombres AS usuario_nombre,
                            acceso_usuario.gl_apellidos AS usuario_apellidos,
                            expediente.gl_token AS token_expediente,
                            expediente.gl_folio,
                            DATE_FORMAT(expediente.fc_mordedura,'%d-%m-%Y') AS fc_mordedura
                    FROM ".$this->_tabla." alarma
                    LEFT JOIN mor_expediente expediente ON expediente.id_expediente = alarma.id_expediente 
                    LEFT JOIN mor_paciente_alarma_tipo paciente_alarma_tipo ON paciente_alarma_tipo.id_tipo_alarma = alarma.id_tipo_alarma
                    LEFT JOIN mor_paciente_alarma_estado paciente_alarma_estado ON paciente_alarma_estado.id_alarma_estado = alarma.id_alarma_estado
                    LEFT JOIN mor_paciente paciente ON paciente.id_paciente = alarma.id_paciente
                    LEFT JOIN mor_acceso_usuario acceso_usuario ON acceso_usuario.id_usuario = alarma.id_usuario_crea";
        if(!empty($params)){
            $where = " WHERE ";
            if(isset($params['id_establecimiento'])){
                $query .= "$where expediente.id_establecimiento = ?";
                $param  = array_merge($param,array(intval($params['id_establecimiento'])));
                $where = " AND ";
            }
            if(isset($params['id_perfil'])){
                $query .= "$where alarma.id_perfil = ?";
                $param  = array_merge($param,array(intval($params['id_perfil'])));
                $where = " AND ";
            }
            if(isset($params['id_expediente'])){
                $query .= "$where alarma.id_expediente = ?";
                $param  = array_merge($param,array(intval($params['id_expediente'])));
                $where = " AND ";
            }
            $where .= "alarma.bo_mostrar = 1 AND alarma.id_alarma_estado != 3";
            $where .= " AND (alarma.id_alarma_estado IN (1)
                            OR alarma.id_alarma IN (SELECT id_alarma FROM mor_paciente_alarma
                                                    WHERE id_alarma_estado = 4 AND fc_actualiza >= DATE_SUB(curdate(), INTERVAL 2 WEEK)))";
            $query .= $where;
            //$query .= chop($where," AND ");
        }
        
        $result	= $this->db->getQuery($query,$param);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    public function getById($id){
        $query  = " SELECT * FROM ".$this->_tabla."
                    WHERE ".$this->_primaria." = ?";

        $param  = array($id);
        $result = $this->db->getQuery($query,$param);
        
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene información más detalle de tabla "mor_paciente_alarma"
     * @author  David Guzmán <david.guzman@cosof.cl> - 09/05/2018
     * @param   int $id_paciente
     */
    public function getByIdPaciente($id_paciente){
        $query  = " SELECT  pa.*,
                            pat.gl_nombre_alarma AS gl_tipo_alarma,
                            pae.gl_nombre_alarma AS gl_estado_alarma,
                            per.gl_nombre_perfil AS gl_nombre_perfil
                    FROM mor_paciente_alarma pa
                    LEFT JOIN mor_paciente_alarma_tipo pat ON pat.id_tipo_alarma = pa.id_tipo_alarma
                    LEFT JOIN mor_paciente_alarma_estado pae ON pae.id_alarma_estado = pa.id_alarma_estado
                    LEFT JOIN mor_acceso_perfil per ON per.id_perfil = pa.id_perfil
                    WHERE   pa.bo_mostrar = 1
                    AND     pa.id_paciente = ?";
        $param  = array($id_paciente);
        $result = $this->db->getQuery($query,$param);
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
    /**
	 * Descripción : Inserta Nueva Alarma Paciente
	 * @author  Pablo Jimenez <pablo.jimenez@cosof.cl> - 06/06/2018
     * @param   array $params 
	 */
    public function insertarPacienteAlarma($params) {
        $query = "  INSERT INTO ".$this->_tabla."
                        (
                            id_paciente,
                            id_tipo_alarma,
                            id_perfil,
                            id_alarma_estado,
                            id_usuario_crea
                        )
					VALUES 
                        (?,?,?,?,?,".intval($_SESSION[SESSION_BASE]['id']).")";

        if ($this->db->execQuery($query,$params)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
    
	/**
	 * Descripción : UPDATE paciente alarma
	 * @author  Pablo Jimenez <pablo.jimenez@cosof.cl> - 06/06/2018
     * @param   array   $params
	 */
	public function updatePacienteAlarma($params,$id_alarma){
        $query	= "	UPDATE ".$this->_tabla."
					SET id_paciente       = ".$params['id_paciente'].",
                        id_tipo_alarma    = ".$params['id_tipo_alarma'].",
                        id_perfil         = ".$params['id_perfil'].",
                        id_alarma_estado  = ".$params['id_alarma_estado']."
                            
					WHERE id_alarma = $id_alarma";
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Descripción : UPDATE paciente alarma
     * @author  Pablo Jimenez <pablo.jimenez@cosof.cl> - 06/06/2018
     * @param   array   $params
     */
    public function cambiarEstadoAlarma($id_alarma, $id_estado, $json_otros_datos=array()){
        $query  = " UPDATE ".$this->_tabla."
                    SET id_alarma_estado  = ".intval($id_estado).",
                    id_usuario_actualiza = ".intval($_SESSION[SESSION_BASE]['id']).",
                    fc_actualiza = now()";
        if(!empty($json_otros_datos)){
            $query .= ",json_otros_datos = '".json_encode($json_otros_datos)."' ";
        }
        $query .= " WHERE id_alarma = ".intval($id_alarma);
        
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>