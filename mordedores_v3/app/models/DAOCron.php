<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_cron
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 23/01/2019
 * 
 * @name             DAOCron.php
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
class DAOCron extends Model {

    protected $_tabla			= "mor_cron";
    protected $_primaria		= "id_cron";
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

    public function getCronByDia(){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE fc_cron = ?";

		$param	= array(date('Y-m-d'));
		//$param	= array(date('2019-01-22'));
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

	public function registroCron($nr_cantidad,$gl_rut,$json_datos){
		
		$query	= " INSERT INTO ".$this->_tabla." 
						(
							nr_cantidad,
							fc_cron,
							gl_rut,
							json_datos,
							bo_estado
						)
						VALUES (?,?,?,?,?)";
		$param	= array($nr_cantidad,date('Y-m-d'),$gl_rut,$json_datos,1);

		return $this->db->execQuery($query,$param);
	}

    public function selectMicrochip(){
        $query	= "	SELECT 
						mor_expediente.id_expediente,
						mor_expediente.gl_folio,
						mor_expediente.id_expediente_estado,
						mor_expediente_mordedor.id_expediente_mordedor_estado,
						mor_expediente_mordedor.gl_folio_mordedor,
						DATEDIFF(CURDATE(),mor_expediente.fc_mordedura) Dias
					FROM `mor_expediente`
						LEFT JOIN mor_expediente_mordedor 
							ON mor_expediente_mordedor.id_expediente=mor_expediente.id_expediente 
					WHERE DATEDIFF(CURDATE(),mor_expediente.fc_mordedura) > 15
						AND mor_expediente_mordedor.bo_domicilio_conocido=1
						AND mor_expediente_mordedor.bo_activo=1
						AND mor_expediente_mordedor.id_expediente_mordedor_estado IN (6,7)";

        $result	= $this->db->getQuery($query);

        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    public function updateMicrochip(){
		$data	= $this->selectMicrochip();
		
		$query	= "	UPDATE mor_expediente_mordedor em
						LEFT JOIN mor_expediente e ON em.id_expediente=e.id_expediente
					SET
						em.id_expediente_mordedor_estado= 14,
						em.id_fiscalizador_microchip	= id_fiscalizador,
						em.id_usuario_actualiza			= ".intval($_SESSION[SESSION_BASE]['id']).",
						em.fc_actualiza					= now()
					WHERE DATEDIFF(CURDATE(),e.fc_mordedura) > 15
						AND em.bo_domicilio_conocido	= 1
						AND em.bo_activo				= 1
						AND em.id_expediente_mordedor_estado IN (6,7)";

		if($this->db->execQuery($query)) {
			return $data;
		}else{
			return FALSE;
		}
    }

    /*SI ES ASIGNADA MICROCHIP CON VISITA PERDIDA QUE QUEDÓ EN PENDIENTE CON MAS DE 90 DIAS SE DEVUELVE*/
    public function selectMicrochipDias($nr_dias){
		
		$query	= "	SELECT DISTINCT
                        expediente.*
                    FROM mor_expediente expediente
                        LEFT JOIN mor_expediente_mordedor exp_mor ON exp_mor.id_expediente = expediente.id_expediente
                        LEFT JOIN mor_visita vis ON expediente.id_expediente = vis.id_expediente
                                                AND vis.id_visita = (SELECT MAX(id_visita) FROM mor_visita
                                                                    WHERE id_expediente = expediente.id_expediente)
                    WHERE
                        exp_mor.id_expediente_mordedor_estado = 14
                        AND expediente.id_expediente_estado = 7
                        AND expediente.fc_mordedura <= DATE_FORMAT(CURDATE() - INTERVAL ".intval($nr_dias)." DAY,'%Y-%m-%d')
                        AND vis.id_visita_estado = 1 AND vis.bo_volver_a_visitar = 0";

		$result	= $this->db->getQuery($query);

        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /*SI ES ASIGNADA MICROCHIP CON VISITA PERDIDA QUE QUEDÓ EN PENDIENTE CON MAS DE 90 DIAS SE DEVUELVE*/
    public function updateMicrochipDias($nr_dias){
		$data	= $this->selectMicrochipDias($nr_dias);
		
		$query	= "	UPDATE mor_expediente expediente
                        LEFT JOIN mor_expediente_mordedor exp_mor ON exp_mor.id_expediente = expediente.id_expediente
                        LEFT JOIN mor_visita vis ON expediente.id_expediente = vis.id_expediente
                                                AND vis.id_visita = (SELECT MAX(id_visita) FROM mor_visita
                                                                    WHERE id_expediente = expediente.id_expediente)
                    SET 
                        expediente.id_expediente_estado         = 9,
                        exp_mor.id_expediente_mordedor_estado   = 9,
                        exp_mor.id_fiscalizador                 = NULL,
                        exp_mor.id_fiscalizador_microchip       = NULL,
                        exp_mor.fc_asignado                     = NULL,
                        exp_mor.fc_programado                   = NULL
                    WHERE
                        exp_mor.id_expediente_mordedor_estado = 14
                        AND expediente.id_expediente_estado = 7
                        AND expediente.fc_mordedura <= DATE_FORMAT(CURDATE() - INTERVAL ".intval($nr_dias)." DAY,'%Y-%m-%d')
                        AND vis.id_visita_estado = 1 AND vis.bo_volver_a_visitar = 0";

		if($this->db->execQuery($query)) {
			return $data;
		}else{
			return FALSE;
		}
    }

}

?>