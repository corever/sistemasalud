<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_visita
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 25/05/2018
 * 
 * @name             DAOVisita.php
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
class DAOVisita extends Model{

    protected $_tabla			= "mor_visita";
    protected $_primaria		= "id_visita";
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
	 * Descripción : Obtener por id_expediente
	 * @author  David Guzmán <david.guzman@cosof.cl> - 25/05/2018
     * @param   int $id_expediente 
	 */
    public function getByIdExpediente($id_expediente){
        $query	= "	SELECT
                        v.*,
                        DATE_FORMAT(v.fc_visita, '%d-%m-%Y') AS fc_visita,
                        estado.gl_nombre AS gl_estado
                    FROM mor_visita v
                    LEFT JOIN mor_visita_estado estado ON v.id_visita_estado = estado.id_visita_estado
					WHERE v.id_expediente = ?";

		$param	= array($id_expediente);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtener por id_expediente
	 * @author  David Guzmán <david.guzman@cosof.cl> - 25/05/2018
     * @param   string $token_fiscalizacion 
	 */
    public function getByToken($token_fiscalizacion){
        $query	= "	SELECT
                        v.*,
                        DATE_FORMAT(v.fc_visita, '%d-%m-%Y') AS fc_visita,
                        DATE_FORMAT(v.fc_fin_sincronizacion, '%d-%m-%Y') AS fc_sincronizacion,
                        estado.gl_nombre AS gl_estado,
                        IFNULL(tipo_perdida.gl_descripcion,'-') AS gl_tipo_perdida,
                        IFNULL(tipo_resultado.gl_nombre,'-') AS gl_tipo_resultado,
                        CONCAT(fiscalizador.gl_nombres,' ',fiscalizador.gl_apellidos) AS gl_fiscalizador,
                        fiscalizador.gl_email AS gl_email_fiscalizador,
                        IFNULL(expediente.gl_folio,'-') AS gl_folio_expediente,
                        IFNULL(expediente.gl_token,'-') AS gl_token_expediente
                    FROM mor_visita v
                    LEFT JOIN mor_expediente expediente ON v.id_expediente = expediente.id_expediente
                    LEFT JOIN mor_visita_estado estado ON v.id_visita_estado = estado.id_visita_estado
                    LEFT JOIN mor_visita_tipo_perdida tipo_perdida ON v.id_tipo_visita_perdida = tipo_perdida.id_tipo_visita_perdida
                    LEFT JOIN mor_visita_tipo_resultado tipo_resultado ON v.id_tipo_visita_resultado = tipo_resultado.id_tipo_visita_resultado
                    LEFT JOIN mor_acceso_usuario fiscalizador ON v.id_fiscalizador = fiscalizador.id_usuario
                    
					WHERE v.gl_token_fiscalizacion = ?";

		$param	= array($token_fiscalizacion);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }
}

?>