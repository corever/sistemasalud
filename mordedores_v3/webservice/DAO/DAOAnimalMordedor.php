<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_animal_mordedor
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOAnimalMordedor.php
 * 
 * @version          1.0
 *
 * @author           Pablo Jimenez <pablo.jimenez@cosof.cl>
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
class DAOAnimalMordedor{
    const ESTADO_ANIMAL_VIVO			= 1;
    const ESTADO_ANIMAL_MUERTO			= 2;
    const ESTADO_ANIMAL_NO_ENCONTRADO	= 3;    

    const ESTADO_MICROCHIP_INGRESADO	= 1;
    const ESTADO_MICROCHIP_REGISTRADO	= 12;
    
    const GRUPO_ANIMAL_SILVESTRE		= 1;
    const GRUPO_ANIMAL_ROEDOR			= 2;
    const GRUPO_ANIMAL_PERRO_GATO		= 3;

    protected $_tabla           = "mor_animal_mordedor";
    protected $_primaria		= "id_mordedor";
    protected $_transaccional	= false;
    protected $_conn            = null;
    protected $_respuesta       = array();

    function __construct($conn = null) {
        if($conn !== null){
            $this->_conn =  $conn;
        }else{
            $this->_conn =  new MySQL();
        }
    }

    public function getLista(){
        $query	= "	SELECT * FROM ".$this->_tabla;
        $result = $this->_conn->consultaArreglo($query);
        
        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    public function getById($id){
        $query	= "	SELECT * FROM ".$this->_tabla."
					WHERE ".$this->_primaria." = ?";

		$param  = array($id);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    public function getByMicrochip($gl_microchip){
        $query  = " SELECT id_mordedor FROM ".$this->_tabla."
                    WHERE gl_microchip = ?
                    ORDER BY id_mordedor DESC
                    LIMIT 1";

        $param  = array($gl_microchip);
        $result = $this->_conn->consulta($query,$param);

        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }

    public function insert($datos_mordedor){

        $fecha_actual = date("Y-m-d H:i:s");
        
        $json_otros_datos = array(
                "nr_edad" => $datos_mordedor["nr_edad"],
                "nr_edad_meses" => $datos_mordedor["nr_edad_meses"],
                "nr_peso" => $datos_mordedor["nr_peso"],
                "gl_apariencia"     => $datos_mordedor["gl_apariencia"],
                "gl_color_animal"   => $datos_mordedor["gl_color_animal"],
                "gl_motivo_muerte"  => $datos_mordedor["gl_motivo_muerte"],
                "gl_motivo_otro"    => $datos_mordedor["gl_motivo_otro"],
                "bo_microchipInstalado"			=> $datos_mordedor["bo_microchipInstalado"],//indica si el microchip estaba instalado antes de la visita. 1:sí 2:NO
				"instalador_microchip"			=> $datos_mordedor["instalador_microchip"],//quién instaló el microchip dato : { id: , nombre: ''}
				"gl_otro_instalador_microchip"	=> $datos_mordedor["gl_otro_instalador_microchip"],//si escoge la opción (otro) se especifica
				"gl_otro_vigencia" => $datos_mordedor["gl_otro_vigencia"]//bo_antirrabica_vigente = "Otros" (id=4) => gl_otro_vigencia.
			);

        $json_direccion = array(
                "gl_direccion" => $datos_mordedor["gl_direccion"],
                "gl_direccion_coordenadas" => $datos_mordedor["gl_direccion_coordenadas"],
                "gl_direccion_detalles" => $datos_mordedor["gl_direccion_detalles"]
            );
        
        /**
         * [bo_antirrabica_vigente No es Boolean, es un ID]
         */
        $sql = "INSERT INTO ".$this->_tabla." (
                        id_dueno,
                        id_animal_estado,
                        bo_antirrabica_vigente,
                        bo_necesita_vacuna,
                        id_animal_grupo,
                        id_animal_especie,
                        id_animal_raza,
                        id_animal_sexo,
                        json_otros_datos,
                        id_animal_tamano,
                        id_comuna,
                        bo_vive_con_dueno,
                        bo_callejero,
                        gl_nombre,
                        gl_microchip,
                        id_estado_microchip,
                        fc_vacuna,
                        fc_vacuna_expira,
                        id_duracion_inmunidad,
                        bo_eutanasiado,
                        fc_eutanasia,
                        bo_rabia,
                        bo_mordedor_habitual,
                        fc_muerte,
                        fc_desparacitado,
                        json_direccion,
                        fc_microchip,
                        gl_otra_especie,
                        id_estado_productivo,
                        gl_otra_raza,
                        id_region,
                        json_vacuna,
                        nr_cantidad_casos,
                        fc_crea,
                        fc_actualiza,
                        id_usuario_crea,
                        id_usuario_actualiza
                    )
                    VALUES (            
                         ".  validar($datos_mordedor["id_dueno"]              , "numero") ." ,
                         ".  validar($datos_mordedor["id_animal_estado"]      , "numero") ." ,
                         ".  validar($datos_mordedor["bo_antirrabica_vigente"], "numero") ." ,
                         ".  validar($datos_mordedor["bo_necesita_vacuna"]    , "numero") ." ,
                         ".  validar($datos_mordedor["id_animal_grupo"]       , "numero") ." ,
                         ".  validar($datos_mordedor["id_animal_especie"]     , "numero") ." ,
                         ".  validar($datos_mordedor["id_animal_raza"]        , "numero") ." ,
                         ".  validar($datos_mordedor["id_animal_sexo"]        , "numero") ." ,
                        '".  addslashes(json_encode($json_otros_datos, JSON_UNESCAPED_UNICODE))."',
                         ".  validar($datos_mordedor["id_animal_tamano"]      , "numero") ." ,
                         ".  validar($datos_mordedor["id_comuna"]             , "numero") ." ,
                         ".  validar($datos_mordedor["bo_vive_con_dueno"]     , "numero") ." ,
                         ".  validar($datos_mordedor["bo_callejero"]          , "numero") ." ,
                        '".  validar($datos_mordedor["gl_nombre"]             , "string") ."',
                        '".  validar($datos_mordedor["gl_microchip"]          , "string") ."',
                         ".  validar($datos_mordedor["id_estado_microchip"]   , "numero") ." ,
                        '".  validar($datos_mordedor["fc_vacuna"]             , "date")   ."',
                        '".  validar($datos_mordedor["fc_vacuna_expira"]      , "date")   ."',
                         ".  validar($datos_mordedor["id_duracion_inmunidad"] , "numero") ." ,
                         ".  validar($datos_mordedor["bo_eutanasiado"]        , "numero") ." ,
                        '".  validar($datos_mordedor["fc_eutanasia"]          , "date")   ."',
                         ".  validar($datos_mordedor["bo_rabia"]              , "numero") ." ,
                         ".  validar($datos_mordedor["bo_mordedor_habitual"]  , "numero") ." ,
                        '".  validar($datos_mordedor["fc_muerte"]             , "date")   ."',
                        '".  validar($datos_mordedor["fc_desparacitado"]      , "date")   ."',
                        '".  addslashes(json_encode($json_direccion, JSON_UNESCAPED_UNICODE))."',
                        '".  validar($datos_mordedor["fc_microchip"]          , "date")   ."',
                        '".  validar($datos_mordedor["gl_otra_especie"]       , "string") ."',
                         ".  validar($datos_mordedor["id_estado_productivo"]  , "numero") ." ,
                        '".  validar($datos_mordedor["gl_otra_raza"]          , "string") ."',
                         ".  validar($datos_mordedor["id_region"]             , "numero") ." ,
                        '".  addslashes($datos_mordedor["json_vacuna"]) ."',
                         1,
                        '".  $fecha_actual  ."',
                        '".  $fecha_actual  ."',
                         ".  $datos_mordedor["id_usuario"]    ." ,
                         ".  $datos_mordedor["id_usuario"]    ."
                    )";
        
        $data = $this->_conn->consulta($sql);
        $mordedorId = $this->_conn->getInsertId($data);

        return $mordedorId;
    }


    public function update($parametros, $id){
        $this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
    }

    /*
     * Se usa en DAOExpediente.php Linea 292
     * Obtiene datos mordedor by ID Expediente
    */
    public function getByIdExpediente($id){
    	/**
         * [bo_antirrabica_vigente No es Boolean, es un ID]
         */
        
        $query  = " SELECT 
                        mor_animal_mordedor.id_mordedor,
                        mor_animal_mordedor.id_dueno,
                        mor_animal_mordedor.gl_microchip,
                        mor_animal_mordedor.gl_nombre,
                        mor_animal_mordedor.gl_otra_especie,
                        mor_animal_mordedor.gl_otra_raza,
                        mor_animal_mordedor.bo_antirrabica_vigente,
                        mor_animal_mordedor.bo_mostrar,
                        mor_animal_mordedor.bo_necesita_vacuna,
                        mor_animal_mordedor.bo_vive_con_dueno,
                        mor_animal_mordedor.bo_eutanasiado,
                        mor_animal_mordedor.bo_mordedor_habitual,
                        mor_animal_mordedor.bo_rabia AS bo_sintomas_rabia,
                        mor_animal_mordedor.json_direccion,
                        mor_animal_mordedor.json_otros_datos,
                        mor_animal_mordedor.fc_eutanasia,
                        mor_animal_mordedor.fc_desparacitado,
                        mor_animal_mordedor.fc_vacuna,
                        mor_animal_mordedor.fc_vacuna_expira,
                        mor_animal_mordedor.fc_microchip,
                        mor_animal_mordedor.fc_muerte,
                        mor_animal_mordedor.json_vacuna,
                        mor_animal_mordedor.nr_cantidad_casos,
                        mor_animal_mordedor.id_animal_estado,
                        mor_animal_mordedor.id_animal_especie,
                        mor_animal_mordedor.id_estado_productivo,
                        mor_animal_mordedor.id_animal_raza,
                        mor_animal_mordedor.id_animal_sexo,
                        mor_animal_mordedor.id_animal_tamano,
                        mor_animal_mordedor.id_region AS id_region_animal,
                        mor_direccion_region.gl_nombre_region,
                        mor_animal_mordedor.id_comuna AS id_comuna_animal,
                        mor_direccion_comuna.gl_nombre_comuna,
                        mor_animal_mordedor.id_duracion_inmunidad
                    FROM mor_animal_mordedor
                    LEFT JOIN mor_animal_estado ON 
                                mor_animal_estado.id_animal_estado = mor_animal_mordedor.id_animal_estado
                    LEFT JOIN mor_animal_especie ON 
                                mor_animal_especie.id_animal_especie = mor_animal_mordedor.id_animal_especie
                    LEFT JOIN mor_animal_estado_productivo ON 
                                mor_animal_estado_productivo.id_estado_productivo = mor_animal_mordedor.id_estado_productivo
                    LEFT JOIN mor_animal_raza ON 
                                mor_animal_raza.id_animal_raza = mor_animal_mordedor.id_animal_raza
                    LEFT JOIN mor_animal_sexo ON
                                mor_animal_sexo.id_animal_sexo = mor_animal_mordedor.id_animal_sexo
                    LEFT JOIN mor_animal_tamano ON 
                                mor_animal_tamano.id_animal_tamano = mor_animal_mordedor.id_animal_tamano
                    LEFT JOIN mor_direccion_region ON 
                                mor_direccion_region.id_region = mor_animal_mordedor.id_region
                    LEFT JOIN mor_direccion_comuna ON 
                                mor_direccion_comuna.id_comuna = mor_animal_mordedor.id_comuna
                    LEFT JOIN mor_tipo_duracion_inmunidad ON 
                                mor_tipo_duracion_inmunidad.id_duracion_inmunidad = mor_animal_mordedor.id_duracion_inmunidad
                    LEFT JOIN mor_expediente_mordedor ON 
                                mor_expediente_mordedor.id_mordedor = mor_animal_mordedor.id_mordedor
                    LEFT JOIN mor_expediente ON 
                                mor_expediente.id_expediente = mor_expediente_mordedor.id_expediente
                    WHERE mor_expediente_mordedor.id_expediente = ?
                        AND  mor_expediente_mordedor.id_expediente_mordedor_estado IN 
                                (SELECT id_expediente_estado 
                                FROM mor_expediente_estado 
                                WHERE bo_estado = 1 
                                AND bo_visita = 1)";

        $param  = array($id);
        $result = $this->_conn->consultaArreglo($query,$param);
        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    /*
     * Se usa en EnviarFiscalizacionMordedores.php Linea 641
     * Obtiene datos mordedor by ID Expediente
    */
    public function getByIdExpedienteWS($id){
        
        $query  = " SELECT 
                        mor_animal_mordedor.*,
                        mor_animal_mordedor.bo_rabia AS bo_sintomas_rabia
                    FROM mor_animal_mordedor
                    LEFT JOIN mor_expediente_mordedor ON 
                                mor_expediente_mordedor.id_mordedor = mor_animal_mordedor.id_mordedor
                    WHERE mor_expediente_mordedor.id_expediente = ?";

        $param  = array($id);
        $result = $this->_conn->consultaArreglo($query,$param);
        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    public function getMordedoresRegion($regiones){
    	/**
         * [bo_antirrabica_vigente No es Boolean, es un ID]
         */
        $query  = " SELECT 
                        mor_animal_mordedor.id_mordedor,
                        mor_animal_mordedor.id_dueno,
                        mor_animal_mordedor.gl_microchip,
                        mor_animal_mordedor.gl_nombre,
                        mor_animal_mordedor.gl_otra_especie,
                        mor_animal_mordedor.gl_otra_raza,
                        mor_animal_mordedor.bo_antirrabica_vigente,
                        mor_animal_mordedor.bo_mostrar,
                        mor_animal_mordedor.bo_necesita_vacuna,
                        mor_animal_mordedor.bo_vive_con_dueno,
                        mor_animal_mordedor.bo_eutanasiado,
                        mor_animal_mordedor.bo_mordedor_habitual,
                        mor_animal_mordedor.bo_rabia AS bo_sintomas_rabia,
                        mor_animal_mordedor.json_direccion,
                        mor_animal_mordedor.json_otros_datos,
                        mor_animal_mordedor.fc_eutanasia,
                        mor_animal_mordedor.fc_desparacitado,
                        mor_animal_mordedor.fc_vacuna,
                        mor_animal_mordedor.fc_vacuna_expira,
                        mor_animal_mordedor.fc_microchip,
                        mor_animal_mordedor.fc_muerte,
                        mor_animal_mordedor.json_vacuna,
                        mor_animal_mordedor.nr_cantidad_casos,
                        mor_animal_mordedor.id_animal_estado,
                        mor_animal_mordedor.id_animal_especie,
                        mor_animal_mordedor.id_estado_productivo,
                        mor_animal_mordedor.id_animal_raza,
                        mor_animal_mordedor.id_animal_sexo,
                        mor_animal_mordedor.id_animal_tamano,
                        mor_animal_mordedor.id_region AS id_region_animal,
                        mor_direccion_region.gl_nombre_region,
                        mor_animal_mordedor.id_comuna AS id_comuna_animal,
                        mor_direccion_comuna.gl_nombre_comuna,
                        mor_animal_mordedor.id_duracion_inmunidad
                    FROM mor_animal_mordedor
                    LEFT JOIN mor_animal_estado ON 
                                mor_animal_estado.id_animal_estado = mor_animal_mordedor.id_animal_estado
                    LEFT JOIN mor_animal_especie ON 
                                mor_animal_especie.id_animal_especie = mor_animal_mordedor.id_animal_especie
                    LEFT JOIN mor_animal_estado_productivo ON 
                                mor_animal_estado_productivo.id_estado_productivo = mor_animal_mordedor.id_estado_productivo
                    LEFT JOIN mor_animal_raza ON 
                                mor_animal_raza.id_animal_raza = mor_animal_mordedor.id_animal_raza
                    LEFT JOIN mor_animal_sexo ON
                                mor_animal_sexo.id_animal_sexo = mor_animal_mordedor.id_animal_sexo
                    LEFT JOIN mor_animal_tamano ON 
                                mor_animal_tamano.id_animal_tamano = mor_animal_mordedor.id_animal_tamano
                    LEFT JOIN mor_direccion_region ON 
                                mor_direccion_region.id_region = mor_animal_mordedor.id_region
                    LEFT JOIN mor_direccion_comuna ON 
                                mor_direccion_comuna.id_comuna = mor_animal_mordedor.id_comuna
                    LEFT JOIN mor_tipo_duracion_inmunidad ON 
                                mor_tipo_duracion_inmunidad.id_duracion_inmunidad = mor_animal_mordedor.id_duracion_inmunidad
                    WHERE mor_animal_mordedor.id_region IN (?)
                    AND mor_animal_mordedor.gl_microchip IS NOT NULL 
                    AND mor_animal_mordedor.gl_microchip != ''";

        $param  = array($regiones);
        $result = $this->_conn->consultaArreglo($query,$param);

        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }
}

?>