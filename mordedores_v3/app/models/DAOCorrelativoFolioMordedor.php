<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_correlativo_folio_mordedor
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 04/06/2018
 * 
 * @name             DAOCorrelativoFolioMordedor.php
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
class DAOCorrelativoFolioMordedor extends Model{

    protected $_tabla           = "mor_correlativo_folio_mordedor";
    protected $_primaria		= "id_correlativo";
    protected $_transaccional	= false;

    function __construct()
    {
        parent::__construct();
    }

    public function getLista(){
        $query	= "SELECT * FROM ".$this->_tabla;
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
        $result	= $this->db->getQuery($query, $param);

        if($result->numRows>0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Inserta Nuevo correlativo
	 * @author  David Guzmán <david.guzman@cosof.cl> - 04/06/2018
     * @param   array $params 
	 */
    public function insertarCorrelativo($params) {
        $query = "  INSERT INTO ".$this->_tabla."
                        (
                            nr_year,
                            id_region,
                            id_usuario_crea
                        )
					VALUES 
                        (?,?,".intval($_SESSION[SESSION_BASE]['id']).")";

        if ($this->db->execQuery($query,$params)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
	
    /**
	 * Descripción : actualizo id_expediente_mordedor
     * @author  David Guzmán <david.guzman@cosof.cl> - 12/03/2019
     * @param   int $id_expediente_mordedor, int $id_correlativo
	 */
    public function actualizoIdExpedienteMordedor($id_expediente_mordedor,$id_correlativo){
        
        if(intval($id_correlativo) > 0 && intval($id_expediente_mordedor) > 0){

            $query	= "	UPDATE ".$this->_tabla."
                        SET 
                            id_expediente_mordedor  = ".intval($id_expediente_mordedor)."
                        WHERE id_correlativo = ".intval($id_correlativo);

            if ($this->db->execQuery($query)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }
}

?>