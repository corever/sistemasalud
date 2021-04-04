<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_visita_animal_mordedor
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 25/05/2018
 * 
 * @name             DAOVisitaAnimalMordedor.php
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
class DAOVisitaAnimalMordedor extends Model{

    protected $_tabla			= "mor_visita_animal_mordedor";
    protected $_primaria		= "id_visita_mordedor";
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
                        mordedor.*,
                        mordedor.gl_nombre AS gl_animal_nombre,
                        IF(dueno.id_dueno IS NULL,
                                'SIN DUEÑO',
                                CONCAT(dueno.gl_nombre,' ',dueno.gl_apellido_paterno,' ',dueno.gl_apellido_materno)
                        ) AS gl_nombre_dueno,
                        IF(dueno.gl_rut IS NULL,
                                '',
                                dueno.gl_rut
                        ) AS gl_rut_dueno,
                        especie.gl_nombre AS gl_animal_especie,
                        raza.gl_nombre AS gl_animal_raza,
                        estado.gl_nombre AS gl_animal_estado,
                        productivo.gl_nombre AS gl_animal_estado_reproductivo,
                        sexo.gl_nombre AS gl_animal_sexo,
                        tamano.gl_nombre AS gl_animal_tamano,
                        region.gl_nombre_region AS gl_region_mordedor,
                        comuna.gl_nombre_comuna AS gl_comuna_mordedor,
                        visita.*,
                        DATE_FORMAT(visita.fc_visita, '%d-%m-%Y') AS fc_visita,
                        DATE_FORMAT(visita.fc_fin_sincronizacion, '%d-%m-%Y') AS fc_sincronizacion,
                        expediente_mordedor.gl_folio_mordedor AS gl_folio_mordedor,
                        GROUP_CONCAT(DISTINCT CONCAT('- ',fiscalizador.gl_nombres,' ',fiscalizador.gl_apellidos) SEPARATOR '<br>') AS gl_nombre_fiscalizador,
                        GROUP_CONCAT(DISTINCT CONCAT('- ',fiscalizador_microchip.gl_nombres,' ',fiscalizador_microchip.gl_apellidos) SEPARATOR '<br>') AS gl_nombre_fiscalizador_microchip,
                        GROUP_CONCAT(DISTINCT CONCAT('- ',fiscalizador_perdida.gl_nombres,' ',fiscalizador_perdida.gl_apellidos) SEPARATOR '<br>') AS gl_nombre_fiscalizador_perdida,
                        IFNULL(visita_estado.gl_nombre,(SELECT gl_nombre FROM mor_visita_estado WHERE id_visita_estado = visita.id_visita_estado)) AS gl_visita_estado,
                        IFNULL((SELECT gl_descripcion FROM mor_visita_tipo_perdida WHERE id_tipo_visita_perdida = visita.id_tipo_visita_perdida),'') AS gl_tipo_perdida,
                        IFNULL(visita_resultado.gl_nombre,(SELECT gl_nombre FROM mor_visita_tipo_resultado
                                                            WHERE id_tipo_visita_resultado = visita.id_tipo_visita_resultado)) AS gl_visita_resultado,
                        mordedor.json_otros_datos AS json_otros_mordedor,
                        mordedor.json_direccion AS json_direccion_mordedor
                        
                    FROM mor_visita visita
                    LEFT JOIN mor_visita_animal_mordedor m ON m.id_visita = visita.id_visita
                    LEFT JOIN mor_visita_estado visita_estado ON m.id_visita_estado = visita_estado.id_visita_estado
                    LEFT JOIN mor_visita_tipo_resultado visita_resultado ON m.id_tipo_visita_resultado = visita_resultado.id_tipo_visita_resultado
                    LEFT JOIN mor_animal_mordedor mordedor ON m.id_mordedor = mordedor.id_mordedor
                    LEFT JOIN mor_expediente_mordedor expediente_mordedor ON m.id_mordedor = expediente_mordedor.id_mordedor
                    LEFT JOIN mor_acceso_usuario fiscalizador ON expediente_mordedor.id_fiscalizador = fiscalizador.id_usuario
                    LEFT JOIN mor_acceso_usuario fiscalizador_microchip ON expediente_mordedor.id_fiscalizador_microchip = fiscalizador_microchip.id_usuario
                    LEFT JOIN mor_acceso_usuario fiscalizador_perdida ON visita.id_fiscalizador = fiscalizador_perdida.id_usuario
                    LEFT JOIN mor_dueno dueno ON m.id_dueno = dueno.id_dueno
                    LEFT JOIN mor_animal_especie especie ON mordedor.id_animal_especie = especie.id_animal_especie
                    LEFT JOIN mor_animal_raza raza ON mordedor.id_animal_raza = raza.id_animal_raza
                    LEFT JOIN mor_animal_estado estado ON mordedor.id_animal_estado = estado.id_animal_estado
                    LEFT JOIN mor_animal_estado_productivo productivo ON mordedor.id_estado_productivo = productivo.id_estado_productivo
                    LEFT JOIN mor_animal_sexo sexo ON mordedor.id_animal_sexo = sexo.id_animal_sexo
                    LEFT JOIN mor_animal_tamano tamano ON mordedor.id_animal_tamano = tamano.id_animal_tamano
                    LEFT JOIN mor_direccion_region region ON mordedor.id_region = region.id_region
                    LEFT JOIN mor_direccion_comuna comuna ON mordedor.id_comuna = comuna.id_comuna
					WHERE visita.id_expediente = ?";

		$param	= array($id_expediente);
        $result	= $this->db->getQuery($query,$param);
        
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
	 * Descripción : Obtener por id_visita
	 * @author  David Guzmán <david.guzman@cosof.cl> - 01/06/2018
     * @param   int $id_visita 
	 */
    public function getByIdVisita($id_visita){
        $query	= "	SELECT DISTINCT
                        mordedor.*,
                        m.id_visita_estado,
                        m.id_tipo_visita_resultado,
                        m.gl_descripcion AS gl_descripcion_mordedor,
                        m.json_tipo_sintoma AS json_tipo_sintoma,
                        m.json_mordedor AS json_mordedor_visita,
                        m.json_dueno AS json_dueno_visita,
                        visita_mordedor_estado.gl_nombre AS visita_mordedor_estado,
                        m.id_animal_estado AS id_visita_animal_estado,
                        visita_animal_estado.gl_nombre AS visita_animal_estado,
                        m.id_tipo_visita_perdida,
                        visita_tipo_perdida.gl_descripcion AS visita_tipo_perdida,
                        DATE_FORMAT(mordedor.fc_eutanasia, '%d-%m-%Y') AS fecha_eutanasia,
                        DATE_FORMAT(mordedor.fc_muerte, '%d-%m-%Y') AS fecha_muerte,
                        IF(dueno.id_dueno IS NULL,
                                'SIN DUEÑO',
                                CONCAT(dueno.gl_nombre,' ',dueno.gl_apellido_paterno,' ',dueno.gl_apellido_materno)
                        ) AS gl_nombre_dueno,
                        IF(dueno.gl_rut IS NULL,
                                '-',
                                dueno.gl_rut
                        ) AS gl_rut_dueno,
                        IF(dueno.gl_pasaporte IS NULL,
                                '-',
                                dueno.gl_pasaporte
                        ) AS gl_pasaporte,
                        dueno.bo_extranjero AS bo_dueno_extranjero,
                        dueno.bo_rut_informado,
                        IFNULL(dueno.gl_email,'-') AS gl_email_dueno,
                        IFNULL(dueno.json_direccion,'') AS json_direccion_dueno,
                        IFNULL(region_dueno.gl_nombre_region,'-') AS gl_region_dueno,
                        IFNULL(comuna_dueno.gl_nombre_comuna,'-') AS gl_comuna_dueno,
                        especie.gl_nombre AS gl_animal_especie,
                        raza.gl_nombre AS gl_animal_raza,
                        estado.gl_nombre AS gl_animal_estado,
                        tamano.gl_nombre AS gl_animal_tamano,
                        sexo.gl_nombre AS gl_animal_sexo,
                        productivo.gl_nombre AS gl_animal_productivo,
                        region.gl_nombre_region AS gl_region,
                        comuna.gl_nombre_comuna AS gl_comuna,
                        microchip.gl_nombre AS gl_nombre_microchip,
                        vacuna.id_animal_vacuna,
                        IFNULL(vacuna.gl_motivo_vacuna,'-') AS gl_motivo_vacuna,
                        IFNULL(vacuna.gl_certificado_vacuna,'-') AS gl_certificado_vacuna,
                        IFNULL(vacuna.gl_numero_serie_vacuna,'-') AS gl_numero_serie_vacuna,
                        IFNULL(CONCAT(vacuna.id_duracion_inmunidad,' año(s)'),'-') AS id_duracion_inmunidad,
                        IFNULL(vacuna.gl_laboratorio,'-') AS gl_laboratorio,
                        IFNULL(vacuna.gl_medicamento,'-') AS gl_medicamento,
                        IFNULL( DATE_FORMAT(vacuna.fc_vacunacion, '%d-%m-%Y'),'-') AS fc_vacunacion,
                        IFNULL( DATE_FORMAT(vacuna.fc_caducidad_vacuna, '%d-%m-%Y'),'-') AS fc_caducidad_vacuna,
                        IFNULL((SELECT gl_folio_mordedor FROM mor_expediente_mordedor 
                                WHERE id_mordedor = mordedor.id_mordedor AND id_expediente = visita.id_expediente LIMIT 1),'') AS gl_folio_mordedor,
                        visita_tipo_resultado.gl_nombre AS gl_tipo_resultado
                        
                    FROM mor_visita_animal_mordedor m
                    LEFT JOIN mor_visita_estado visita_mordedor_estado ON m.id_visita_estado = visita_mordedor_estado.id_visita_estado
                    LEFT JOIN mor_animal_estado visita_animal_estado ON m.id_animal_estado = visita_animal_estado.id_animal_estado
                    LEFT JOIN mor_visita_tipo_perdida visita_tipo_perdida ON m.id_tipo_visita_perdida = visita_tipo_perdida.id_tipo_visita_perdida
                    LEFT JOIN mor_visita_tipo_resultado visita_tipo_resultado ON m.id_tipo_visita_resultado = visita_tipo_resultado.id_tipo_visita_resultado

                    LEFT JOIN mor_visita visita ON m.id_visita = visita.id_visita
                    LEFT JOIN mor_visita_animal_vacuna vacuna ON (m.id_visita = vacuna.id_visita AND m.id_mordedor = vacuna.id_mordedor)
                    LEFT JOIN mor_visita_estado_microchip microchip ON m.id_estado_microchip = microchip.id_estado_microchip
                    LEFT JOIN mor_animal_mordedor mordedor ON m.id_mordedor = mordedor.id_mordedor
                    LEFT JOIN mor_dueno dueno ON m.id_dueno = dueno.id_dueno
                    LEFT JOIN mor_animal_especie especie ON mordedor.id_animal_especie = especie.id_animal_especie
                    LEFT JOIN mor_animal_raza raza ON mordedor.id_animal_raza = raza.id_animal_raza
                    LEFT JOIN mor_animal_estado estado ON mordedor.id_animal_estado = estado.id_animal_estado
                    LEFT JOIN mor_animal_tamano tamano ON mordedor.id_animal_tamano = tamano.id_animal_tamano
                    LEFT JOIN mor_animal_sexo sexo ON mordedor.id_animal_sexo = sexo.id_animal_sexo
                    LEFT JOIN mor_animal_estado_productivo productivo ON mordedor.id_estado_productivo = productivo.id_estado_productivo
                    LEFT JOIN mor_direccion_region region ON mordedor.id_region = region.id_region
                    LEFT JOIN mor_direccion_comuna comuna ON mordedor.id_comuna = comuna.id_comuna
                    LEFT JOIN mor_direccion_region region_dueno ON dueno.id_region = region_dueno.id_region
                    LEFT JOIN mor_direccion_comuna comuna_dueno ON dueno.id_comuna = comuna_dueno.id_comuna
					WHERE visita.id_visita = ?";

		$param	= array($id_visita);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
    /**
	 * Descripción : Editar ISP
     * @author  David Guzmán <david.guzman@cosof.cl> - 25/07/2018
     * @param   string $gl_token
	 */
    public function editarISP($id_mordedor,$id_resultado_isp,$json_isp){
        $query	= "	UPDATE ".$this->_tabla."
					SET 
						id_tipo_resultado_isp   = $id_resultado_isp,
                        json_resultado_isp      = '".json_encode($json_isp)."',
                        id_usuario_actualiza    = ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza            = now()
					WHERE id_mordedor = $id_mordedor";

        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>