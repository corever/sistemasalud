<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_animal_mordedor
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 11/05/2018
 * 
 * @name             DAOAnimalMordedor.php
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
class DAOAnimalMordedor extends Model{

    protected $_tabla           = "mor_animal_mordedor";
    protected $_primaria		= "id_mordedor";
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
    
    public function getByMicrochip($gl_microchip){
        
        $query	= "	SELECT
                        animal_mordedor.*,
                        DATE_FORMAT(animal_mordedor.fc_microchip, '%d/%m/%Y') AS fc_microchip_format
                    FROM ".$this->_tabla." animal_mordedor
					WHERE gl_microchip = ?";

        $result	= $this->db->getQuery($query,array($gl_microchip));
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }
    
    /**
	 * Descripción : Inserta Nuevo Mordedor
	 * @author  David Guzmán <david.guzman@cosof.cl> - 14/05/2018
     * @param   array $params 
	 */
    public function insertarMordedor($params) {

       

        $query = "  INSERT INTO ".$this->_tabla."
                        (
                            id_animal_estado,
                            id_animal_especie,
                            id_animal_raza,
                            id_region,
                            id_comuna,
                            gl_nombre,
                            bo_vive_con_dueno,
                            json_direccion,
                            json_otros_datos,
                            id_usuario_crea
                        )
					VALUES 
                        (?,?,?,?,?,?,?,?,?,".intval($_SESSION[SESSION_BASE]['id']).")";

        if ($this->db->execQuery($query,$params)) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }

    /**
     * Descripción : Obtener Mordedor por Microchip
     * @author  Pablo Jimenez <pablo.jimenez@cosof.cl> - 24/05/2018
     * @param   string   $codigo_microchip
     */
    public function getBitacoraByToken($codigo_microchip,$bo_cabecera=0) {
        
        $query  = " SELECT 
                        mor_animal_mordedor.id_mordedor,
                        mor_animal_mordedor.nr_cantidad_casos,
                        mor_animal_mordedor.gl_microchip,
                        mor_animal_mordedor.gl_nombre,
                        mor_animal_mordedor.gl_otra_especie,
                        mor_animal_mordedor.gl_otra_raza,
                        mor_animal_mordedor.bo_antirrabica_vigente,
                        mor_animal_mordedor.bo_mostrar,
                        mor_animal_mordedor.bo_necesita_vacuna,
                        mor_animal_mordedor.bo_eutanasiado,
                        mor_animal_mordedor.bo_vive_con_dueno,
                        mor_animal_mordedor.bo_callejero,
                        mor_animal_mordedor.bo_mordedor_habitual,
                        mor_animal_mordedor.bo_rabia,
                        mor_animal_mordedor.json_vacuna,
                        mor_animal_mordedor.json_direccion,
                        mor_animal_mordedor.json_otros_datos,
                        CONCAT(mor_dueno.gl_nombre,' ', mor_dueno.gl_apellido_paterno,' ', mor_dueno.gl_apellido_materno) AS dueno,
                        mor_dueno.gl_rut AS rut_dueno,
                        mor_dueno.gl_pasaporte AS pasaporte_dueno,
                        mor_animal_estado.id_animal_estado AS id_animal_estado,
                        mor_animal_estado.gl_nombre AS animal_estado,
                        mor_visita_estado_microchip.gl_nombre AS visita_estado_microchip,
                        mor_animal_especie.gl_nombre AS animal_especie,
                        mor_animal_estado_productivo.gl_nombre AS animal_estado_productivo,
                        mor_animal_raza.gl_nombre AS animal_raza,
                        mor_animal_sexo.gl_nombre AS animal_sexo,
                        mor_animal_tamano.gl_nombre AS animal_tamano,
                        mor_animal_grupo.gl_nombre AS animal_grupo,
                        mor_tipo_duracion_inmunidad.gl_descripcion AS duracion_inmunidad,
                        DATE_FORMAT(mor_animal_mordedor.fc_eutanasia,'%d-%m-%Y') AS fc_eutanasia,
                        DATE_FORMAT(mor_animal_mordedor.fc_desparacitado,'%d-%m-%Y') AS fc_desparacitado,
                        DATE_FORMAT(mor_animal_mordedor.fc_vacuna,'%d-%m-%Y') AS fc_vacuna,
                        DATE_FORMAT(mor_animal_mordedor.fc_vacuna_expira,'%d-%m-%Y') AS fc_vacuna_expira,
                        DATE_FORMAT(mor_animal_mordedor.fc_microchip,'%d-%m-%Y') AS fc_microchip,
                        DATE_FORMAT(mor_animal_mordedor.fc_muerte,'%d-%m-%Y') AS fc_muerte,
                        mor_direccion_region.gl_nombre_region,
                        mor_direccion_comuna.gl_nombre_comuna,
                        IFNULL(mor_visita_animal_vacuna.id_animal_vacuna,0) AS id_animal_vacuna
                    FROM ".$this->_tabla." mor_animal_mordedor
                    LEFT JOIN mor_dueno                     ON    mor_dueno.id_dueno = mor_animal_mordedor.id_dueno
                    LEFT JOIN mor_animal_estado             ON    mor_animal_estado.id_animal_estado = mor_animal_mordedor.id_animal_estado
                    LEFT JOIN mor_visita_estado_microchip   ON    mor_visita_estado_microchip.id_estado_microchip = mor_animal_mordedor.id_estado_microchip
                    LEFT JOIN mor_visita_animal_vacuna      ON    mor_visita_animal_vacuna.id_mordedor = mor_animal_mordedor.id_mordedor
                    LEFT JOIN mor_animal_especie            ON    mor_animal_especie.id_animal_especie = mor_animal_mordedor.id_animal_especie
                    LEFT JOIN mor_animal_estado_productivo  ON    mor_animal_estado_productivo.id_estado_productivo = mor_animal_mordedor.id_estado_productivo
                    LEFT JOIN mor_animal_raza               ON    mor_animal_raza.id_animal_raza = mor_animal_mordedor.id_animal_raza
                    LEFT JOIN mor_animal_sexo               ON    mor_animal_sexo.id_animal_sexo = mor_animal_mordedor.id_animal_sexo
                    LEFT JOIN mor_animal_tamano             ON    mor_animal_tamano.id_animal_tamano = mor_animal_mordedor.id_animal_tamano
                    LEFT JOIN mor_animal_grupo              ON    mor_animal_grupo.id_animal_grupo = mor_animal_mordedor.id_animal_grupo
                    LEFT JOIN mor_direccion_region          ON    mor_direccion_region.id_region = mor_animal_mordedor.id_region
                    LEFT JOIN mor_direccion_comuna          ON    mor_direccion_comuna.id_comuna = mor_animal_mordedor.id_comuna
                    LEFT JOIN mor_tipo_duracion_inmunidad   ON    mor_tipo_duracion_inmunidad.id_duracion_inmunidad = mor_animal_mordedor.id_duracion_inmunidad
                    WHERE mor_animal_mordedor.gl_microchip = ?";

        $param  = array($codigo_microchip);
        $result = $this->db->getQuery($query,$param);

        if ($result->numRows > 0) {
            $arr				= $result->rows->row_0;
            $id_mordedor		= $arr->id_mordedor;
            $json_direccion		= json_decode($arr->json_direccion, true);
            $direccion_mordedor	= array();
            foreach ($json_direccion as $nombre => $valor) {
                $direccion_mordedor[$nombre] = $valor;
            }
            $arr->direccion_mordedor = $direccion_mordedor;
            /*
            $contactos              = $this->getContactosByPaciente($arr->id_paciente);
            $arr->arrPasaporte      = json_decode($arr->json_pasaporte,TRUE);
            $arr->arrDirMordedura   = json_decode($arr->json_direccion_mordedura,TRUE);
            $arr->arrMordedor       = $this->getJsonMordedor($id_expediente,0,5,true);
            $arr->arrExpediente     = json_decode($arr->json_expediente,TRUE);
            $animal_grupo           = (isset($arr->arrMordedor[0]))?$this->getAnimalGrupoById($arr->arrMordedor[0]['json_mordedor']['id_animal_grupo']):"";
            $arr->gl_animal_grupo   = (!empty($animal_grupo))?$animal_grupo->gl_nombre:"";
            $arr_contactos          = array();
            
            if(!empty($contactos)){
                foreach($contactos AS $key => $contacto){
                    $arr_contactos[$key]['id_paciente_contacto']   = $contacto->id_paciente_contacto;
                    $arr_contactos[$key]['id_tipo_contacto']       = $contacto->id_tipo_contacto;
                    $arr_contactos[$key]['json_datos']             = json_decode($contacto->json_dato_contacto,TRUE);
                }
            }
            */
            if($bo_cabecera == 0){
                //$arr->arrContactoPac    = $arr_contactos;
                $arr->arrVisitasMordedor  = $this->getVisitaMordedorByMordedor($id_mordedor);
            }

            return $arr;
            
        } else {
            return NULL;
        }
    }

    //Obtiene visitas mordedor para Bitacora
    function getVisitaMordedorByMordedor($id_mordedor){
        $query  = " SELECT
                        visita_animal_mordedor.gl_microchip,
                        visita_animal_mordedor.id_animal_estado,
                        visita_animal_mordedor.id_estado_microchip,
                        visita_animal_mordedor.id_tipo_visita_resultado,
                        visita_animal_mordedor.id_region_mordedor,
                        visita_animal_mordedor.bo_vive_con_dueno,
                        visita_animal_mordedor.bo_callejero,
                        visita_animal_mordedor.id_estado_productivo,
                        visita_animal_mordedor.bo_antirrabica_vigente,
                        visita_animal_mordedor.gl_descripcion,
                        visita_animal_mordedor.json_mordedor,
                        visita_animal_mordedor.json_dueno,
                        visita_animal_mordedor.json_tipo_sintoma,
                        visita_animal_mordedor.json_resultado_isp,
                        visita_animal_mordedor.fc_eutanasia,
                        
                        visita.id_expediente,
                        visita.id_tipo_visita_perdida,
                        visita.id_tipo_visita_resultado,
                        visita.gl_observacion_visita,
                        visita.bo_sintoma_rabia,
                        visita.bo_sumario,
                        visita.gl_token_fiscalizacion,
                        DATE_FORMAT(visita.fc_visita, '%d-%m-%Y') AS fc_visita,
                        DATE_FORMAT(visita.fc_crea, '%d-%m-%Y') AS fc_crea_visita,
                        estado.gl_nombre AS gl_estado,
                        estado.id_visita_estado AS id_visita_estado,
                        CONCAT(fiscalizador.gl_nombres,' ',fiscalizador.gl_apellidos) AS gl_fiscalizador,
                        
                        visita_animal_vacuna.id_tipo_vacuna,
                        visita_animal_vacuna.gl_motivo_vacuna,
                        visita_animal_vacuna.id_duracion_inmunidad,
                        visita_animal_vacuna.gl_certificado_vacuna,
                        visita_animal_vacuna.gl_numero_serie_vacuna,
                        visita_animal_vacuna.id_laboratorio,
                        visita_animal_vacuna.gl_laboratorio,
                        visita_animal_vacuna.gl_medicamento,
                        visita_animal_vacuna.fc_vacunacion,
                        visita_animal_vacuna.fc_caducidad_vacuna,
                        visita_animal_vacuna.json_otros_datos,
                        expediente.gl_folio AS folio_expediente,
                        IFNULL((SELECT gl_descripcion FROM mor_visita_tipo_perdida WHERE id_tipo_visita_perdida = visita.id_tipo_visita_perdida),'') AS gl_tipo_perdida,
                        visita_tipo_resultado.gl_nombre AS gl_tipo_resultado
                    FROM mor_visita_animal_mordedor visita_animal_mordedor
                        LEFT JOIN mor_visita visita ON visita.id_visita = visita_animal_mordedor.id_visita AND visita.bo_exito_sincronizar = 1
                        LEFT JOIN mor_expediente expediente ON expediente.id_expediente = visita.id_expediente
                        LEFT JOIN mor_visita_estado estado ON visita.id_visita_estado = estado.id_visita_estado
                        LEFT JOIN mor_acceso_usuario fiscalizador ON visita.id_fiscalizador = fiscalizador.id_usuario
                        LEFT JOIN mor_visita_animal_vacuna visita_animal_vacuna ON visita_animal_vacuna.id_visita = visita.id_visita 
                                                                                AND visita_animal_vacuna.id_mordedor = visita_animal_mordedor.id_mordedor
                        LEFT JOIN mor_visita_tipo_resultado visita_tipo_resultado ON visita_animal_mordedor.id_tipo_visita_resultado = visita_tipo_resultado.id_tipo_visita_resultado
                    WHERE visita_animal_mordedor.id_mordedor = ?";

        $param  = array($id_mordedor);
        $result = $this->db->getQuery($query,$param);
        
        if($result->numRows > 0){
            $visitas = array();
            foreach ($result->rows as &$value) {
                $sintomas = json_decode($value->json_tipo_sintoma,true);
                $listado_sintomas = '';
                foreach ($sintomas as $sintoma) {
                    $listado_sintomas .= " ".$sintoma["nombre"];
                    $listado_sintomas .= ",";
                }
                $listado_sintomas = chop($listado_sintomas,",");
                $value->listado_sintomas = $listado_sintomas;
            }
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
}

?>