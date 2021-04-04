<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_expediente
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 14/05/2018
 * 
 * @name             DAOExpediente.php
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
class DAOExpediente{
    ///ESTADOS_EXPEDIENTE
    const ESTADO_INGRESADO  = 1;
    const ESTADO_ASIGNADO   = 2;
    const ESTADO_CERRADO    = 3;
    const ESTADO_PROGRAMADO = 6;
    const ESTADO_PENDIENTE  = 7;
    const ESTADO_SIN_DATOS  = 8;
    const ESTADO_DEVUELTO   = 9;
    const ESTADO_SOSPECHOSO = 10;
    const ESTADO_REASIGNAR  = 12;
    const ESTADO_VISITA_INFORMADA  = 11;
    const ESTADO_ANIMAL_CON_DUENO_CONOCIDO = 4; //Animal con dueño o domicilio conocido
    const ESTADO_animal_SIN_DUENO_CONOCIDO = 5; //Animal sin dueño ni domicilio conocido

    protected $_tabla           = "mor_expediente";
    protected $_primaria		= "id_expediente";
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

    public function update($parametros, $id){
        $this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
    }

    public function updateEstadoExpediente($parametros, $id){
        $daoExpedienteMordedor = new DAOExpedienteMordedor($this->_conn);
        $mordedores_expediente = $daoExpedienteMordedor->getByExpediente($id);
        $mordedores_visitados = true;
        foreach ((array)$mordedores_expediente as $mordedor) {
            if($mordedor["id_expediente_mordedor_estado"] != self::ESTADO_VISITA_INFORMADA){
                $mordedores_visitados = false;
            }
        }

        if($mordedores_visitados){
            $id_expediente_estado = self::ESTADO_VISITA_INFORMADA;
        }else{
            $id_expediente_estado = self::ESTADO_PENDIENTE;
        }

        $parametros_expediente = array(
            "id_usuario_actualiza" => $parametros["id_usuario"],
            "fc_actualiza" => $parametros["fc_actualiza"],
            "id_expediente_estado" => $id_expediente_estado
        );
        $this->_conn->update($this->_tabla,$parametros_expediente, $this->_primaria, $id);
    }

    function cerrar_conexion(){
        $this->_conn->cerrar_conexion();
    }

    /**
     * [getFiscalizacionesMordedores Devuelve el listado de fiscalizaciones asignadas a un usuario]
     * @param  integer $id_usuario [identificador del fiscalizador]
     * @return Array               [listado de fiscalizaciones]
     */
    function getFiscalizacionesMordedores($id_usuario = 0){
        try{
            ####Datos Incidente Mordedura
            $sql = "SELECT DISTINCT
                        mor_expediente.gl_folio AS gl_folio,
                        mor_expediente.id_expediente AS id_expediente,
                        mor_expediente.gl_token AS token_expediente,
                        mor_expediente.fc_mordedura AS fecha_mordedura,
                        mor_expediente.fc_ingreso AS fecha_ingreso,
                        mor_expediente.id_region_mordedura AS id_region_mordedura,
                        mor_direccion_region.gl_nombre_region AS nombre_region,
                        mor_expediente.id_comuna_mordedura AS id_comuna_mordedura,
                        mor_direccion_comuna.gl_nombre_comuna AS nombre_comuna,
                        mor_expediente.id_expediente_estado AS id_expediente_estado,
                        mor_expediente_estado.gl_nombre AS nombre_expediente_estado,
                        mor_expediente.id_establecimiento AS id_establecimiento,
                        mor_expediente.gl_hora_ingreso AS hora_ingreso,
                        mor_expediente.gl_observacion AS observacion,
                        mor_expediente.json_expediente AS json_expediente,
                        mor_expediente.json_direccion_mordedura AS json_direccion_mordedura,
                        mor_expediente.id_usuario_crea,
                        mor_establecimiento_salud.gl_token AS token_establecimiento_salud,
                        comuna_centro_salud.gl_nombre_comuna AS nombre_comuna_establecimiento_salud,
                        mor_establecimiento_salud.gl_nombre_establecimiento AS nombre_establecimiento_salud,
                        mor_establecimiento_salud.gl_direccion_establecimiento AS direccion_establecimiento_salud,
                        mor_establecimiento_salud.gl_telefono AS telefono_establecimiento_salud,
                        mor_expediente_mordedor.id_expediente_mordedor_estado AS estado_expediente_mordedor
                    FROM mor_expediente
                        LEFT JOIN mor_expediente_mordedor ON mor_expediente_mordedor.id_expediente = mor_expediente.id_expediente
                        LEFT JOIN mor_direccion_region ON mor_direccion_region.id_region = mor_expediente.id_region_mordedura
                        LEFT JOIN mor_direccion_comuna ON mor_direccion_comuna.id_comuna = mor_expediente.id_comuna_mordedura
                        LEFT JOIN mor_expediente_estado ON mor_expediente_estado.id_expediente_estado = mor_expediente.id_expediente_estado
                        LEFT JOIN mor_establecimiento_salud ON mor_establecimiento_salud.id_establecimiento = mor_expediente.id_establecimiento
                        LEFT JOIN mor_direccion_comuna comuna_centro_salud ON comuna_centro_salud.id_comuna = mor_establecimiento_salud.id_comuna
                    WHERE mor_expediente_mordedor.id_expediente_mordedor_estado IN (SELECT id_expediente_estado FROM mor_expediente_estado WHERE bo_estado = 1 AND bo_visita = 1)
                        AND (mor_expediente_mordedor.id_fiscalizador = ". (int)$id_usuario." AND mor_expediente_mordedor.id_expediente_mordedor_estado != 14 AND DATEDIFF(now(), mor_expediente.fc_mordedura) <= 15)
                        OR (mor_expediente_mordedor.id_fiscalizador_microchip = ". (int)$id_usuario." AND mor_expediente_mordedor.id_expediente_mordedor_estado = 14)";
            
            $fiscalizaciones = $this->_conn->consultaArreglo($sql);
            
            $daoVisita      = new DAOVisita($this->_conn);
            $daoDueno       = new DAODueno($this->_conn);
            $daoPaciente    = new DAOPaciente($this->_conn);
            $daoUsuario     = new DAOUsuario($this->_conn);
            $daoAnimalMordedor      = new DAOAnimalMordedor($this->_conn);
            $daoExpedienteMordedor  = new DAOExpedienteMordedor($this->_conn);
            
            foreach ($fiscalizaciones as &$fiscalizacion) {
                $datos_generales_ficha          = array();
                $detalles_paciente              = array();
                $detalles_propietario           = array();
                $detalles_incidente             = array();
                $paciente_propietario           = array();
                $detalles_mordedores            = array();
                $detalles_establecimiento_salud = array();

                /*OBTENGO LISTA DE TODOS LOS MORDEDORES DE EXPEDIENTE PARA DETALLE VISITA*/
                $mordedores_expediente = $daoExpedienteMordedor->getByExpediente($fiscalizacion["id_expediente"]);
                foreach ($mordedores_expediente as $mordedor_expediente) {
                    $json_mordedor_expediente = json_decode($mordedor_expediente["json_mordedor"],true);
                    if(!empty($mordedor_expediente["id_mordedor"]) && $mordedor_expediente["id_mordedor"] > 0){
                        $cantidadVisitas = $daoVisita->getCantidadVisitasByExpediente($mordedor_expediente["id_expediente"], $mordedor_expediente["id_mordedor"]);
                        $ultimaVisita = $daoVisita->getUltimaVisitaMordedor($mordedor_expediente["id_expediente"], $mordedor_expediente["id_mordedor"]);
                    }
                    $detalle_mordedor = array();
                        
                    $detalle_mordedor[] = array("nombre" => "Especie"   ,"valor" => $json_mordedor_expediente["gl_especie_animal"]);
                    $detalle_mordedor[] = array("nombre" => "Raza"      ,"valor" => $json_mordedor_expediente["gl_raza_animal"]);
                    $detalle_mordedor[] = array("nombre" => "Color"     ,"valor" => $json_mordedor_expediente["gl_color_animal"]);
                    $detalle_mordedor[] = array("nombre" => "Tamaño"    ,"valor" => $json_mordedor_expediente["gl_tamano_animal"]);
                    $detalle_mordedor[] = array("nombre" => "Dirección" ,"valor" => $json_mordedor_expediente["gl_direccion"]);
                    $detalle_mordedor[] = array("nombre" => "Referencias Dirección" ,"valor" => $json_mordedor_expediente["gl_referencias_animal"]);
                    $detalle_mordedor[] = array("nombre" => "Comuna" ,"valor" => $json_mordedor_expediente["gl_comuna"]);

                    if(isset($cantidadVisitas)){
                        $detalle_mordedor[] = array("nombre" => "Cantidad de visitas"   ,"valor" => $cantidadVisitas["cantidad"]);
                    }
                    if(isset($ultimaVisita)){
                        $estado = ($ultimaVisita["id_visita_estado"] == 2) ? "Realizada" : "Perdida";
                        $detalle_mordedor[] = array("nombre" => "Estado Ultima Visita"   ,"valor" => $estado);
                    }

                    $detalles_mordedores[]= array("nombre" => "Mordedor Folio ".$mordedor_expediente["gl_folio_mordedor"],"valor" => $detalle_mordedor, "type" => "array"); 
                }

                /*OBTENGO LISTA DE TODOS LOS MORDEDORES ASIGNADOS AL FISCALIZADOR*/
                $mordedores_expediente = $daoExpedienteMordedor->getByFiscalizador($fiscalizacion["id_expediente"], (int)$id_usuario);
                $json_mordedores_fiscalizador = array();
                foreach ($mordedores_expediente as $mordedor) {
                    $json_mordedores_fiscalizador []= json_decode($mordedor["json_mordedor"],true);
                }
                $fiscalizacion["json_mordedor"] = json_encode($json_mordedores_fiscalizador);

                /*VALIDAR SI VISITA ES PARA TOMA DE MICROCHIO*/
                if($fiscalizacion["estado_expediente_mordedor"] == 14){
                    $fiscalizacion["bo_visita_microchip"] = 1;
                }else{
                    $fiscalizacion["bo_visita_microchip"] = 0;
                }

                /*OBTENGO LISTA DE PACIENTES DEL EXPEDIENTE*/
                $pacientes = $daoPaciente->getInformacionPacienteByIdExpediente($fiscalizacion["id_expediente"]);
                foreach ($pacientes as &$paciente) {
                    $json_pasaporte = (!empty($paciente["json_pasaporte"])) ? json_decode($paciente["json_pasaporte"], true):array();

                    $nombre_completo_paciente = $paciente["nombres"]." ".$paciente["apellido_paterno"]." ".$paciente["apellido_materno"];
                    if(!empty(trim($nombre_completo_paciente))){
                        $detalles_paciente[] = array("nombre" => "Nombre", "valor" => $nombre_completo_paciente);
                    }

                    $detalles_paciente[] = array("nombre" => "RUT"              , "valor" => $paciente["rut"]);
                    $detalles_paciente[] = array("nombre" => "Pasaporte"        , "valor" => $json_pasaporte["gl_pasaporte"]);
                    $detalles_paciente[] = array("nombre" => "Edad"             , "valor" => $paciente["edad"]);
                    $detalles_paciente[] = array("nombre" => "País de Origen"   , "valor" => $paciente["pais_origen"]);
                    //$detalles_paciente[] = array("nombre" => "Comuna"           , "valor" => $paciente["comuna"]);

                    $paciente_propietario["id_propietario"] = null;
                    $paciente_propietario["gl_rut"]     = $paciente["rut"];
                    $paciente_propietario["region"]     = $paciente["gl_nombre_region"];
                    $paciente_propietario["id_region"]  = $paciente["id_region"];
                    $paciente_propietario["comuna"]     = $paciente["comuna"];
                    $paciente_propietario["id_comuna"]  = $paciente["id_comuna"];
                    $paciente_propietario["gl_nombre"]  = $paciente["nombres"];
                    $paciente_propietario["gl_apellido_paterno"] = $paciente["apellido_paterno"];
                    $paciente_propietario["gl_apellido_materno"] = $paciente["apellido_materno"];
                    $paciente_propietario["bo_conocido"] = true;
                    $paciente_propietario["bo_rut_informado"] = $paciente["bo_rut_informado"];
                    $paciente_propietario["bo_extranjero"] = $paciente["bo_extranjero"];
                    $paciente_propietario["nacionalidad"] = $paciente["nacionalidad"];
                    $paciente_propietario["id_pais"] = $paciente["id_pais_origen"];
                    $paciente_propietario["bo_rut_emitido"] = null;
                    $paciente_propietario["gl_pasaporte"] = null;
                    $paciente_propietario["departamento_direccion"] = null;
                   
                    $datos_contacto = $daoPaciente->getDatosContactoByIdPaciente($paciente["id_paciente"]);
                   
                    foreach ($datos_contacto as $dato_contacto) {
                        $json_dato_contacto = json_decode($dato_contacto["json_dato_contacto"], true);

                        if($json_dato_contacto["id_tipo_contacto"] == DAOTipoContacto::TIPO_CONTACTO_TELEFONO_FIJO){
                            $detalles_paciente[] = array("nombre" => "Teléfono Fijo", "valor" => $json_dato_contacto["telefono_fijo"]);
                            $fiscalizacion["telefono_fijo_paciente"] = $json_dato_contacto["telefono_fijo"];
                            $paciente_propietario["telefono_propietario"] = $json_dato_contacto["telefono_fijo"];
                        }
                        if($json_dato_contacto["id_tipo_contacto"] == DAOTipoContacto::TIPO_CONTACTO_TELEFONO_MOVIL){
                            $detalles_paciente[] = array("nombre" => "Teléfono Movil", "valor" => $json_dato_contacto["telefono_movil"]);
                            $fiscalizacion["telefono_movil_paciente"] = $json_dato_contacto["telefono_movil"];
                            $paciente_propietario["telefono_propietario"] = $json_dato_contacto["telefono_movil"];
                        }
                        if($json_dato_contacto["id_tipo_contacto"] == DAOTipoContacto::TIPO_CONTACTO_DIRECCION){
                            $detalles_direccion = array();
                            $detalles_direccion[] = array("nombre" => "Calle", "valor" => $json_dato_contacto["gl_direccion"]);
                            $paciente_propietario["direccion"] = $json_dato_contacto["gl_direccion"];
                            if(!empty($json_dato_contacto["gl_datos_referencia"])){
                                $detalles_direccion[] = array("nombre" => "Referencia", "valor" => $json_dato_contacto["gl_datos_referencia"]);
                                $paciente_propietario["referencia_direccion"] = $json_dato_contacto["gl_datos_referencia"];
                            }
                            /*if(!empty($json_dato_contacto["gl_comuna"])){
                                $detalles_direccion[] = array("nombre" => "Comuna", "valor" => $json_dato_contacto["gl_comuna"]);
                            }*/
                            if(!empty($json_dato_contacto["img_direccion"])){
                                $detalles_direccion[] = array("nombre" => "img_direccion", "valor" => $json_dato_contacto["img_direccion"], "type" => "image");
                            }
                            $detalles_paciente[]= array("nombre" => "Dirección","valor" => $detalles_direccion, "type" => "array"); 
                        }
                        if($json_dato_contacto["id_tipo_contacto"] == DAOTipoContacto::TIPO_CONTACTO_EMAIL){
                            $detalles_paciente[] = array("nombre" => "Correo Electrónico", "valor" => $json_dato_contacto["gl_email"]);
                            $paciente_propietario["gl_email"] = $json_dato_contacto["gl_email"];  
                        }
                    }
                }
                $fiscalizacion["pacientes"] = $pacientes;


                /*OBTENGO LISTA DE MORDEDORES REGISTRADOS EN LA BD*/
                $listado_mordedores = $daoAnimalMordedor->getByIdExpediente($fiscalizacion["id_expediente"]);
                if(is_array($listado_mordedores)){
                    /*OBTENGO DATOS DEL DUEÑO*/
                    foreach ($listado_mordedores as $index => $mordedor) {
                        $expediente_mordedor = $daoExpedienteMordedor->getByIdMordedor($mordedor["id_mordedor"], $fiscalizacion["id_expediente"]);
                        $mordedor["gl_folio_mordedor"] = $expediente_mordedor["gl_folio_mordedor"];
                        $mordedor["id_estado_microchip"] = $daoAnimalMordedor::ESTADO_MICROCHIP_REGISTRADO;
                        if(!empty($mordedor["id_dueno"])){
                            $dueno_mordedor = $daoDueno->getDuenoMordedor($mordedor["id_dueno"]);

                            if(isset($dueno_mordedor)){
                                $json_contacto = json_decode($dueno_mordedor["json_contacto"], true);
                                foreach ($json_contacto as $nombre => $valor) {
                                    $dueno_mordedor[$nombre] = $valor;
                                }
                                unset($dueno_mordedor["json_contacto"]);
                                $json_contacto = json_decode($dueno_mordedor["json_direccion"], true);
                                foreach ($json_contacto as $nombre => $valor) {
                                    $dueno_mordedor[$nombre] = $valor;
                                }
                                unset($dueno_mordedor["json_direccion"]);
                            }
                            $mordedor["propietario"] = $dueno_mordedor;
                            
                            $nombre_completo_dueno_mordedor = $dueno_mordedor["nombres"]." ".$dueno_mordedor["apellido_paterno"]." ".$dueno_mordedor["apellido_materno"];
                            
                            if(!empty(trim($nombre_completo_dueno_mordedor))){
                                $detalles_propietario[] = array("nombre" => "Nombre Propietario",     "valor" => $nombre_completo_dueno_mordedor);
                            }
                            if(!empty($dueno_mordedor["json_direccion"])){
                                $json_direccion_dueno = json_decode($dueno_mordedor["json_direccion"], true);
                                if(!empty($json_direccion_dueno["direccion"])){
                                    $detalles_propietario[] = array("nombre" => "Dirección Propietario",     "valor" => $json_direccion_dueno["direccion"]);
                                }   
                            }
                        }else{
                            if(intval($mordedor["bo_vive_con_paciente"]) == 1 && intval($mordedor["bo_paciente_dueno"]) == 1){
                                $mordedor["propietario"] = $paciente_propietario;
                            }
                            else if(intval($mordedor["bo_vive_con_paciente"]) == 1){
                                $datos_base_propietario = array();
                                $datos_base_propietario["direccion"] = $paciente_propietario["direccion"];
                                $datos_base_propietario["referencia_direccion"] = $paciente_propietario["referencia_direccion"];
                                $datos_base_propietario["id_comuna"] = $paciente_propietario["id_comuna"];
                                $datos_base_propietario["id_region"] = $paciente_propietario["id_region"]; 
                                $mordedor["propietario"] = $datos_base_propietario;
                            }else{
                                if(!isset($mordedor["propietario"])){
                                    $datos_base_propietario = array();
                                    $datos_base_propietario["direccion"] = $mordedor["gl_direccion"];
                                    $datos_base_propietario["referencia_direccion"] = $mordedor["gl_referencias_animal"];
                                    $datos_base_propietario["id_comuna"] = $mordedor["id_comuna_animal"];
                                    $datos_base_propietario["id_region"] = $mordedor["id_region_animal"];   

                                    $mordedor["propietario"] = $datos_base_propietario;
                                }
                            }
                        }
                        $mordedor["id"] = (int)$index+1; //id interno para la tablet

                        $json_direccion = json_decode($mordedor["json_direccion"]);
                        $mordedor["gl_direccion"] = $json_direccion->gl_direccion;
                        $mordedor["gl_direccion_coordenadas"] = $json_direccion->gl_direccion_coordenadas;
                        $mordedor["gl_direccion_detalles"] = $json_direccion->gl_direccion_detalles;
                        unset($mordedor["json_direccion"]);

                        $json_otros_datos = json_decode($mordedor["json_otros_datos"]);
                        $mordedor["nr_edad"] = $json_otros_datos->nr_edad;
                        $mordedor["nr_peso"] = $json_otros_datos->nr_peso;
                        $mordedor["gl_apariencia"] = $json_otros_datos->gl_apariencia;
                        $mordedor["gl_color_animal"] = $json_otros_datos->gl_color_animal;
                        unset($mordedor["json_otros_datos"]);

                        if(isset($mordedor["json_vacuna"]) && !empty($mordedor["json_vacuna"])){
                            $mordedor["vacunas"] = $mordedor["json_vacuna"];
                            unset($mordedor["json_vacuna"]);
                        }

                        $mordedor["bo_se_niega_visita"] = 0;
                        
                        $listado_mordedores[$index] = $mordedor;
                    }
                }
                
                //Trasnformo el json_expediente para ser leido por la app
                $json_expediente = json_decode($fiscalizacion["json_expediente"], true);
                $fiscalizacion["json_expediente"]           = $json_expediente;

                //Trasnformo el json_direccion_mordedura para ser leido por la app
                $json_direccion_mordedura = json_decode($fiscalizacion["json_direccion_mordedura"], true);
                $fiscalizacion["json_direccion_mordedura"]  = $json_direccion_mordedura;
                
                //Transformo json_mordedor para procesar los datos de los mordedores
                $json_mordedor = json_decode($fiscalizacion["json_mordedor"], true);

                //Si existen los mordedores en la BD, utilizo esa información
                if(!empty($listado_mordedores)){
                    $fiscalizacion["mordedores"] =  $listado_mordedores;
                }else{
                    //Si no existen, transformo los mordedores del expediente para ser leido por la app
                    foreach ((array)$json_mordedor as $index => &$mordedor) {
                        $mordedor["id"] = (int)$index+1; //id interno para la tablet
                        $mordedor["id_mordedor"] = null;
                        $mordedor["gl_nombre"] = $mordedor["nombre_animal"];
                        $mordedor["bo_vive_con_dueno"] = intval($mordedor["bo_vive_con_paciente"]);
                        $mordedor["id_animal_estado"] = $daoAnimalMordedor::ESTADO_ANIMAL_VIVO;
                        $mordedor["bo_se_niega_visita"] = 0;

                        if(intval($mordedor["bo_vive_con_paciente"]) == 1 && intval($mordedor["bo_paciente_dueno"]) == 1){
                            $mordedor["propietario"] = $paciente_propietario;
                        }
                        else if(intval($mordedor["bo_vive_con_paciente"]) == 1){
                            $datos_base_propietario = array();
                            $datos_base_propietario["direccion"] = $paciente_propietario["direccion"];
                            $datos_base_propietario["referencia_direccion"] = $paciente_propietario["referencia_direccion"];
                            $datos_base_propietario["id_comuna"] = $paciente_propietario["id_comuna"];
                            $datos_base_propietario["id_region"] = $paciente_propietario["id_region"]; 
                            $mordedor["propietario"] = $datos_base_propietario;
                        }else{
                            if(!isset($mordedor["propietario"])){
                                $datos_base_propietario = array();
                                $datos_base_propietario["direccion"] = $mordedor["gl_direccion"];
                                $datos_base_propietario["referencia_direccion"] = $mordedor["gl_referencias_animal"];
                                $datos_base_propietario["id_comuna"] = $mordedor["id_comuna_animal"];
                                $datos_base_propietario["id_region"] = $mordedor["id_region_animal"];   

                                $mordedor["propietario"] = $datos_base_propietario;
                            }
                        }

                        $json_mordedor[$index] = $mordedor;
                    }
                    $fiscalizacion["mordedores"] =  $json_mordedor;
                }
                //Elimino información basura
                unset($fiscalizacion["json_mordedor"]);

                //Si tengo dirección de mordedura, la envío a la app
                $direccion_incidente = null;
                if(!empty($json_direccion_mordedura)){
                    $direccion_incidente = $json_direccion_mordedura["gl_direccion"];
                    $datos_generales_ficha[] = array("nombre" => "Dirección Incidente","valor" => $direccion_incidente);

                    $direccion_referencia = $json_direccion_mordedura["gl_datos_referencia"];
                    $datos_generales_ficha[] = array("nombre" => "Referencia Dirección Incidente","valor" => $direccion_referencia);
                }

                $fiscalizacion["datos_generales_ficha"] = $datos_generales_ficha; //Trajeta de incidente Home App


                /****OBTENGO LA INFORMACIÓN PARA EL DETALLE DEL EXPEDIENTE*****/
                $fecha_mordedura = null;
                if(!empty($fiscalizacion["fecha_mordedura"])){
                    $fecha_mordedura = date('d/m/Y', strtotime($fiscalizacion["fecha_mordedura"]));
                }
                $fecha_ingreso = null;
                if(!empty($fiscalizacion["fecha_ingreso"])){
                    $fecha_ingreso = date('d/m/Y', strtotime($fiscalizacion["fecha_ingreso"]));
                }           

                $detalles_incidente[] = array("nombre" => "Folio"                   ,"valor" => $fiscalizacion["gl_folio"]); 
                $detalles_incidente[] = array("nombre" => "Fecha"                   ,"valor" => $fecha_mordedura); 
                $detalles_incidente[] = array("nombre" => "Fecha Ingreso"           ,"valor" => $fecha_ingreso);
                $detalles_incidente[] = array("nombre" => "Cantidad de Mordedores"  ,"valor" => count($fiscalizacion["mordedores"]));
                $detalles_incidente[] = array("nombre" => "Comuna"                  ,"valor" => $fiscalizacion["nombre_comuna"]);
                $detalles_incidente[] = array("nombre" => "Dirección"               ,"valor" => $direccion_incidente);
                $detalles_incidente[] = array("nombre" => "Referencia Dirección"    ,"valor" => $direccion_referencia);
                $detalles_incidente[] = array("nombre" => "Lugar"                   ,"valor" => $json_expediente["gl_lugar_mordedura"]);
                $detalles_incidente[] = array("nombre" => "Tipo"                    ,"valor" => $json_expediente["gl_tipo_mordedura"]);
                $detalles_incidente[] = array("nombre" => "Observaciones"           ,"valor" => $fiscalizacion["observacion"]);

                $detalles_establecimiento_salud[] = array("nombre" => "Nombre",     "valor" => $fiscalizacion["nombre_establecimiento_salud"]);
                $detalles_establecimiento_salud[] = array("nombre" => "Teléfono",   "valor" => $fiscalizacion["telefono_establecimiento_salud"]);
                $detalles_establecimiento_salud[] = array("nombre" => "Dirección",  "valor" => $fiscalizacion["direccion_establecimiento_salud"]);
                $detalles_establecimiento_salud[] = array("nombre" => "Comuna",     "valor" => $fiscalizacion["nombre_comuna_establecimiento_salud"]);

                $usuario_crea = $daoUsuario->getById($fiscalizacion["id_usuario_crea"]);
                $detalles_establecimiento_salud[] = array("nombre" => "Nombre Contacto" ,"valor" => $usuario_crea["gl_nombres"]." ".$usuario_crea["gl_apellidos"]);
                $detalles_establecimiento_salud[] = array("nombre" => "Correo Electrónico Contacto"  ,"valor" => $usuario_crea["gl_email"]);              
                
                $datos_contacto_usuario_crea = $daoUsuario->getDatosContactoByIdUsuario($fiscalizacion["id_usuario_crea"]);

                foreach ($datos_contacto_usuario_crea as $dato_contacto) {
                        $json_dato_contacto = json_decode($dato_contacto["json_dato_contacto"], true);

                        if($dato_contacto["id_tipo_contacto"] == DAOTipoContacto::TIPO_CONTACTO_TELEFONO_FIJO){
                            $detalles_establecimiento_salud[] = array("nombre" => "Teléfono Fijo Contacto", "valor" => $json_dato_contacto["telefono_fijo"]);       
                        }
                        if($dato_contacto["id_tipo_contacto"] == DAOTipoContacto::TIPO_CONTACTO_TELEFONO_MOVIL){
                            $detalles_establecimiento_salud[] = array("nombre" => "Teléfono Movil Contacto", "valor" => $json_dato_contacto["telefono_movil"]);       
                        }
                        if($dato_contacto["id_tipo_contacto"] == DAOTipoContacto::TIPO_CONTACTO_DIRECCION){
                            $detalles_direccion = array();
                            $detalles_direccion[] = array("nombre" => "Dirección", "valor" => $json_dato_contacto["gl_direccion"]);
                            if(!empty($json_dato_contacto["gl_datos_referencia"])){
                                $detalles_direccion[] = array("nombre" => "Referencia Dirección", "valor" => $json_dato_contacto["gl_datos_referencia"]);
                            }
                            if(!empty($json_dato_contacto["gl_comuna"])){
                                $detalles_direccion[] = array("nombre" => "Comuna", "valor" => $json_dato_contacto["gl_comuna"]);
                            }
                            $detalles_establecimiento_salud[]= array("nombre" => "Dirección Contacto","valor" => $detalles_direccion, "type" => "array"); 
                        }
                        if($dato_contacto["id_tipo_contacto"] == DAOTipoContacto::TIPO_CONTACTO_EMAIL){
                            $detalles_establecimiento_salud[] = array("nombre" => "Correo Electrónico Contacto", "valor" => $json_dato_contacto["gl_email"]);       
                        }
                    }

                //ARMO ESTRUCTURA GENERICA PARA DETALLES FISCALIZACION
                $fiscalizacion["datos_cabecera"] = array(
                        "detalles_incidente" => $detalles_incidente,
                        "detalles_mordedores_expediente" => $detalles_mordedores,
                        "detalles_propietario" => $detalles_propietario,
                        "detalles_paciente" => $detalles_paciente,
                        "detalles_establecimiento_salud" => $detalles_establecimiento_salud,
                    );

                if(empty($fiscalizacion["datos_cabecera"]["detalles_propietario"])){
                    unset($fiscalizacion["datos_cabecera"]["detalles_propietario"]);
                }
            }

            return $fiscalizaciones;
        } catch (Exception $e){
            file_put_contents('php://stderr', PHP_EOL . print_r($e->getMessage(), TRUE). PHP_EOL, FILE_APPEND);
            return false;
        }
    }



    /**
	 * Descripción : Asignar Fiscalizador
     * @author  David Guzmán <david.guzman@cosof.cl> - 29/05/2018
     * @param   string $gl_token
	 */
    public function devolverProgramacion($id_expediente, $id_usuario){
        $query	= "	UPDATE ".$this->_tabla."
					SET
						id_expediente_estado    = 9,
                        id_usuario_actualiza	= ".intval($id_usuario).",
                        fc_actualiza			= now()
					WHERE id_expediente = '$id_expediente'";

        $result = $this->_conn->consulta($query);
        if($result->num_rows>0){
            return $this->_conn->fetch_assoc($result);
        }else{
            return NULL;
        }
    }
}

?>