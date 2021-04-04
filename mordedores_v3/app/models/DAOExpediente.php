<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 *
 * Descripcion       : Modelo para Tabla mor_expediente
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 11/05/2018
 *
 * @name             DAOExpediente.php
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
class DAOExpediente extends Model
{

    protected $_tabla = "mor_expediente";
    protected $_primaria = "id_expediente";
    protected $_transaccional = false;

    function __construct()
    {
        parent::__construct();
    }

    public function getLista()
    {
        $query = "	SELECT * FROM " . $this->_tabla;
        $result = $this
            ->db
            ->getQuery($query);

        if ($result->numRows > 0)
        {
            return $result->rows;
        }
        else
        {
            return NULL;
        }
    }

    public function getById($id)
    {
        $query = "	SELECT * FROM " . $this->_tabla . "
					WHERE " . $this->_primaria . " = ?";

        $param = array(
            $id
        );
        $result = $this
            ->db
            ->getQuery($query, $param);

        if ($result->numRows > 0)
        {
            return $result
                ->rows->row_0;
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Descripción : Obtener Expediente por token
     * @author  David Guzmán <david.guzman@cosof.cl> - 16/05/2018
     * @param   string   $gl_token
     */
    public function getByToken($gl_token)
    {

        $query = "	SELECT
						expediente.*
					FROM " . $this->_tabla . " expediente
                    WHERE expediente.gl_token = ?";

        $param = array(
            $gl_token
        );
        $result = $this
            ->db
            ->getQuery($query, $param);
        if ($result->numRows > 0)
        {
            return $result
                ->rows->row_0;
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Descripción : Obtener token por id_expediente
     * @author  Victor Retamal <victor.retamal@cosof.cl> - 17/11/2018
     * @param   int   $id_expediente
     */
    public function getTokenById($id_expediente)
    {

        $query = "	SELECT
						expediente.gl_token
					FROM " . $this->_tabla . " expediente
                    WHERE expediente.id_expediente = ?";

        $param = array(
            $id_expediente
        );
        $result = $this
            ->db
            ->getQuery($query, $param);
        if ($result->numRows > 0)
        {
            return $result
                ->rows
                ->row_0->gl_token;
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Descripción : Obtener token por gl_folio
     * @author  Victor Retamal <victor.retamal@cosof.cl> - 17/11/2018
     * @param   string   $gl_folio
     */
    public function getTokenByFolio($gl_folio)
    {

        $query = "	SELECT
						expediente.gl_token
					FROM " . $this->_tabla . " expediente
                    WHERE expediente.gl_folio = ?";

        $param = array(
            $gl_folio
        );
        $result = $this
            ->db
            ->getQuery($query, $param);
        if ($result->numRows > 0)
        {
            return $result
                ->rows
                ->row_0->gl_token;
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Descripción : Obtener Expediente por token
     * @author  David Guzmán <david.guzman@cosof.cl> - 16/05/2018
     * @param   string   $gl_token
     */
    public function getByPaciente($id_paciente)
    {
        $meses_atras = 3;

        $query = "	SELECT
                        DATEDIFF(DATE_FORMAT(now(),'%Y-%m-%d'),mor_expediente.fc_ingreso) AS nr_cantidad_dias,
						mor_expediente.gl_folio,
						mor_expediente.gl_token,
                        mor_expediente.id_expediente_estado AS id_estado,
                        estado.gl_nombre AS gl_nombre_estado,
                        estado.gl_class AS gl_class_estado,
                        DATE_FORMAT(mor_expediente.fc_notificacion_seremi, '%d-%m-%Y') AS fc_notificacion_seremi,
                        DATE_FORMAT(mor_expediente.fc_mordedura, '%d-%m-%Y') AS fc_mordedura,
                        DATE_FORMAT(mor_expediente.fc_crea,'%d-%m-%Y') AS fc_ingreso,
                        DATEDIFF(CURDATE(),mor_expediente.fc_mordedura) AS dias_mordedura,
                        DATEDIFF(CURDATE(),mor_expediente.fc_crea) AS dias_bandeja,
                        establecimiento.gl_nombre_establecimiento AS gl_establecimiento,
                        region_mordedura.gl_nombre_region AS gl_region_mordedura,
                        comuna_mordedura.gl_nombre_comuna AS gl_comuna_mordedura,
                        paciente.gl_rut AS rut_paciente,
                        CONCAT(paciente.gl_nombres,' ',paciente.gl_apellido_paterno,' ',paciente.gl_apellido_materno) AS nombre_paciente,
                        paciente.gl_rut AS rut_usuario_creador,
                        CONCAT(usuario_crea.gl_nombres,' ',usuario_crea.gl_apellidos) AS nombre_usuario_creador,
                        IFNULL((SELECT id_animal_grupo FROM mor_expediente_mordedor
                                WHERE id_expediente = mor_expediente.id_expediente LIMIT 1),'') AS id_animal_grupo,
                        IFNULL((SELECT grupo.gl_nombre_corto FROM mor_expediente_mordedor mor
                                LEFT JOIN mor_animal_grupo grupo ON mor.id_animal_grupo = grupo.id_animal_grupo
                                WHERE mor.id_expediente = mor_expediente.id_expediente LIMIT 1),'') AS gl_grupo_animal
                    FROM " . $this->_tabla . "
                    LEFT JOIN mor_expediente_estado estado ON mor_expediente.id_expediente_estado = estado.id_expediente_estado
                    LEFT JOIN mor_establecimiento_salud establecimiento ON mor_expediente.id_establecimiento = establecimiento.id_establecimiento
                    LEFT JOIN mor_direccion_region region_mordedura ON mor_expediente.id_region_mordedura = region_mordedura.id_region
                    LEFT JOIN mor_direccion_comuna comuna_mordedura ON mor_expediente.id_comuna_mordedura = comuna_mordedura.id_comuna
                    LEFT JOIN mor_paciente paciente ON mor_expediente.id_paciente = paciente.id_paciente
                    LEFT JOIN mor_acceso_usuario usuario_crea ON mor_expediente.id_usuario_crea = usuario_crea.id_usuario

                    WHERE mor_expediente.id_paciente = ? AND mor_expediente.fc_ingreso BETWEEN DATE_ADD(CURDATE(),INTERVAL -$meses_atras MONTH) AND now()
                    ORDER BY mor_expediente.id_expediente DESC";

        $param = array(
            $id_paciente
        );
        $result = $this
            ->db
            ->getQuery($query, $param);
        if ($result->numRows > 0)
        {
            return $result->rows;
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Descripción : Inserta Nuevo Expediente
     * @author  David Guzmán <david.guzman@cosof.cl> - 16/05/2018
     * @param   array $params
     */
    public function insertarExpediente($params)
    {
        $query = "  INSERT INTO " . $this->_tabla . "
                        (
                            gl_token,
                            gl_folio,
                            id_expediente_estado,
                            id_establecimiento,
                            fc_ingreso,
                            gl_hora_ingreso,
                            fc_notificacion_seremi,
                            gl_observacion,
                            fc_mordedura,
                            id_region_mordedura,
                            id_comuna_mordedura,
                            json_direccion_mordedura,
                            json_paciente,
                            json_expediente,
                            bo_paciente_observa,
                            bo_crea_establecimiento,
                            id_paciente,
                            id_inicia_vacuna,
                            id_usuario_crea
                        )
					VALUES
                        (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?," . intval($_SESSION[SESSION_BASE]['id']) . ")";

        if ($this
            ->db
            ->execQuery($query, $params))
        {
            return $this
                ->db
                ->getLastId();
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Descripción : Obtener Expediente por token
     * @author  David Guzmán <david.guzman@cosof.cl> - 22/05/2018
     * @param   string   $gl_token
     */
    public function getDetalleByToken($gl_token)
    {

        $query = "	SELECT
						expediente.*,
                        DATE_FORMAT(expediente.fc_ingreso,'%d-%m-%Y') AS fc_ingreso,
                        DATE_FORMAT(expediente.fc_crea,'%d-%m-%Y') AS fc_crea,
                        DATE_FORMAT(expediente.fc_notificacion_seremi,'%d-%m-%Y') AS fc_notificacion_seremi,
                        DATE_FORMAT(expediente.fc_mordedura,'%d-%m-%Y') AS fc_mordedura,
                        establecimiento.gl_nombre_establecimiento AS gl_establecimiento,
                        region_establecimiento.gl_nombre_region AS gl_region_establecimiento,
                        comuna_establecimiento.gl_nombre_comuna AS gl_comuna_establecimiento,
                        region_mordedura.gl_nombre_region AS region_mordedura,
                        comuna_mordedura.gl_nombre_comuna AS comuna_mordedura,
                        p.gl_rut AS rut_paciente,
                        p.bo_rut_informado AS bo_rut_informado_paciente,
                        region_paciente.gl_nombre_region AS region_paciente,
                        comuna_paciente.gl_nombre_comuna AS comuna_paciente,
                        p.gl_nombres AS nombre_paciente,
                        CONCAT(p.gl_apellido_paterno,' ',p.gl_apellido_materno) AS apellidos_paciente,
                        pd.json_pasaporte AS json_pasaporte,
                        DATE_FORMAT(pd.fc_nacimiento,'%d-%m-%Y') AS fc_nacimiento_paciente,
                        pd.nr_edad AS nr_edad_paciente,
                        prevision.gl_nombre_prevision AS nombre_prevision_paciente,
                        p.id_paciente AS id_paciente,
                        sexo.gl_tipo_sexo AS gl_tipo_sexo,
                        nacionalidad_paciente.gl_nombre_nacionalidad AS gl_nacionalidad_paciente,
                        pais_paciente.gl_nombre_pais AS gl_pais_paciente
					FROM " . $this->_tabla . " expediente
                    LEFT JOIN mor_establecimiento_salud establecimiento ON expediente.id_establecimiento = establecimiento.id_establecimiento
                    LEFT JOIN mor_direccion_region region_establecimiento ON establecimiento.id_region = region_establecimiento.id_region
                    LEFT JOIN mor_direccion_comuna comuna_establecimiento ON establecimiento.id_comuna = comuna_establecimiento.id_comuna
                    LEFT JOIN mor_expediente_paciente ep ON expediente.id_expediente = ep.id_expediente
                    LEFT JOIN mor_direccion_region region_mordedura ON expediente.id_region_mordedura = region_mordedura.id_region
                    LEFT JOIN mor_direccion_comuna comuna_mordedura ON expediente.id_comuna_mordedura = comuna_mordedura.id_comuna
                    LEFT JOIN mor_paciente p ON ep.id_paciente = p.id_paciente
                    LEFT JOIN mor_direccion_region region_paciente ON p.id_region = region_paciente.id_region
                    LEFT JOIN mor_direccion_comuna comuna_paciente ON p.id_comuna = comuna_paciente.id_comuna
                    LEFT JOIN mor_paciente_datos pd ON p.id_paciente = pd.id_paciente
                    LEFT JOIN mor_general_prevision prevision ON pd.id_prevision = prevision.id_prevision
                    LEFT JOIN mor_tipo_sexo sexo ON pd.id_tipo_sexo = sexo.id_tipo_sexo
                    LEFT JOIN mor_direccion_nacionalidad nacionalidad_paciente ON pd.id_nacionalidad = nacionalidad_paciente.id_nacionalidad
                    LEFT JOIN mor_direccion_pais pais_paciente ON pd.id_pais_origen = pais_paciente.id_pais
                    WHERE expediente.gl_token = ?";

        $param = array(
            $gl_token
        );
        $result = $this
            ->db
            ->getQuery($query, $param);
        if ($result->numRows > 0)
        {
            return $result
                ->rows->row_0;
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Descripción : Obtener Lista Detalle Expedientes
     * @author  David Guzmán <david.guzman@cosof.cl> - 22/05/2018
     * @param   int   $id_centro_salud, int $id_usuario
     */
    public function getListaDetalle($params = null)
    {
        $param = array();
        $id_perfil = $_SESSION[SESSION_BASE]['perfil'];
        $id_region = $_SESSION[SESSION_BASE]['id_region'];

        $query = "	SELECT
						expediente.*,
                        DATE_FORMAT(expediente.fc_crea,'%d-%m-%Y') AS fc_ingreso,
                        DATE_FORMAT(expediente.fc_notificacion_seremi,'%d-%m-%Y') AS fc_notificacion_seremi,
                        DATE_FORMAT(expediente.fc_mordedura,'%d-%m-%Y') AS fc_mordedura,
                        region_establecimiento.gl_nombre_region AS gl_region_establecimiento,
                        comuna_establecimiento.gl_nombre_comuna AS gl_comuna_establecimiento,
                        establecimiento.id_comuna         AS comuna_establecimiento,
                        establecimiento.id_region         AS region_establecimiento,
                        GROUP_CONCAT(DISTINCT CONCAT('- ',fiscalizador.gl_nombres,' ',fiscalizador.gl_apellidos) SEPARATOR '<br>') AS gl_nombre_fiscalizador,
                        GROUP_CONCAT(DISTINCT CONCAT('- ',fiscalizador_microchip.gl_nombres,' ',fiscalizador_microchip.gl_apellidos) SEPARATOR '<br>') AS gl_nombre_fiscalizador_microchip,
                        fiscalizador.gl_token AS gl_token_fiscalizador,
                        estado.gl_nombre AS gl_nombre_estado,
                        estado.gl_class AS gl_class_estado,
                        (SELECT gl_nombre_region FROM mor_direccion_region reg
                            LEFT JOIN mor_direccion_comuna comu ON reg.id_region = comu.id_region
                            WHERE comu.id_comuna = establecimiento.id_comuna) AS gl_region_est,
                        DATEDIFF(CURDATE(),expediente.fc_mordedura) AS dias_mordedura,
                        DATEDIFF(CURDATE(),expediente.fc_crea) AS dias_bandeja,
                        establecimiento.gl_nombre_establecimiento AS gl_establecimiento,
                        IFNULL(mem.json_mordedor,'') AS json_mordedor,
                        IFNULL((SELECT id_animal_grupo FROM mor_expediente_mordedor
                                WHERE id_expediente = expediente.id_expediente LIMIT 1),'') AS id_animal_grupo,
                        IFNULL((SELECT grupo.gl_nombre_corto FROM mor_expediente_mordedor mor
                                LEFT JOIN mor_animal_grupo grupo ON mor.id_animal_grupo = grupo.id_animal_grupo
                                WHERE mor.id_expediente = expediente.id_expediente LIMIT 1),'') AS gl_grupo_animal,
                        IFNULL((SELECT GROUP_CONCAT(id_expediente_mordedor_estado SEPARATOR ',')
                                FROM mor_expediente_mordedor WHERE id_expediente = expediente.id_expediente),'') AS grupo_expediente_mordedor_estado,
                        (SELECT count(id_visita) FROM mor_visita WHERE id_expediente = expediente.id_expediente) AS nr_visitas,
                        IFNULL((SELECT count(id_visita_mordedor) FROM mor_visita_animal_mordedor
                            LEFT JOIN mor_visita ON mor_visita.id_visita = mor_visita_animal_mordedor.id_visita
                            WHERE mor_visita.id_expediente = expediente.id_expediente),0) AS nr_visitas_mordedor,
                        IFNULL((   SELECT visita_mordedor.id_tipo_resultado_isp FROM mor_visita_animal_mordedor visita_mordedor
                                LEFT JOIN mor_visita visita ON visita_mordedor.id_visita = visita.id_visita
                                WHERE visita.id_expediente = expediente.id_expediente AND visita_mordedor.id_tipo_resultado_isp = 1 LIMIT 1),'') AS id_resultado_isp_1,
                        IFNULL((   SELECT visita_mordedor.id_tipo_resultado_isp FROM mor_visita_animal_mordedor visita_mordedor
                                LEFT JOIN mor_visita visita ON visita_mordedor.id_visita = visita.id_visita
                                WHERE visita.id_expediente = expediente.id_expediente AND visita_mordedor.id_tipo_resultado_isp = 2 LIMIT 1),'') AS id_resultado_isp_2,
                        IFNULL((   SELECT visita_mordedor.id_tipo_visita_resultado FROM mor_visita_animal_mordedor visita_mordedor
                                LEFT JOIN mor_visita visita ON visita_mordedor.id_visita = visita.id_visita
                                WHERE visita.id_expediente = expediente.id_expediente AND visita_mordedor.id_tipo_visita_resultado = 2 LIMIT 1),'') AS id_tipo_visita_resultado_mor,
                        IFNULL((   SELECT visita.id_tipo_visita_resultado FROM mor_visita visita
                                WHERE visita.id_expediente = expediente.id_expediente AND visita.id_tipo_visita_resultado = 2 LIMIT 1),'') AS id_tipo_visita_resultado,
                        IF((SELECT count(bo_domicilio_conocido) FROM mor_expediente_mordedor
                                WHERE id_expediente = expediente.id_expediente AND bo_domicilio_conocido = 1)>0,1,0) AS bo_domicilio_conocido,
                        IF((SELECT count(bo_domicilio_conocido) FROM mor_expediente_mordedor
                                WHERE id_expediente = expediente.id_expediente AND bo_domicilio_conocido = 0)=0,1,0) AS bo_all_domicilio_conocido,
                        IFNULL((SELECT GROUP_CONCAT(id_region_mordedor SEPARATOR ',') FROM mor_expediente_mordedor
								WHERE id_expediente = expediente.id_expediente AND bo_domicilio_conocido = 0),0) AS arr_id_region_mordedor,
                        IFNULL((SELECT GROUP_CONCAT(DISTINCT reg_mordedor.gl_nombre_region SEPARATOR '<br>') FROM mor_expediente_mordedor
                                LEFT JOIN mor_direccion_region reg_mordedor ON mor_expediente_mordedor.id_region_mordedor = reg_mordedor.id_region
								WHERE id_expediente = expediente.id_expediente),'') AS gl_region_mordedor,
                        IFNULL((SELECT GROUP_CONCAT(DISTINCT com_mordedor.gl_nombre_comuna SEPARATOR '<br>') FROM mor_expediente_mordedor
                                LEFT JOIN mor_direccion_comuna com_mordedor ON mor_expediente_mordedor.id_comuna_mordedor = com_mordedor.id_comuna
								WHERE id_expediente = expediente.id_expediente),'') AS gl_comuna_mordedor,
						(SELECT count(*) FROM mor_expediente_mordedor WHERE id_expediente = expediente.id_expediente) AS nr_mordedores,
                        (SELECT id_visita_estado FROM mor_visita
                            WHERE id_expediente = expediente.id_expediente ORDER BY id_visita DESC LIMIT 1) AS id_ultimo_visita_estado,
                        (SELECT id_tipo_visita_perdida FROM mor_visita
                            WHERE id_expediente = expediente.id_expediente ORDER BY id_visita DESC LIMIT 1) AS id_ultimo_tipo_visita_perdida,
                        (SELECT id_tipo_visita_resultado FROM mor_visita
                            WHERE id_expediente = expediente.id_expediente ORDER BY id_visita DESC LIMIT 1) AS id_ultimo_visita_resultado,
                        (SELECT bo_volver_a_visitar FROM mor_visita
                            WHERE id_expediente = expediente.id_expediente ORDER BY id_visita DESC LIMIT 1) AS bo_ultimo_volver_visitar,
                        IF((SELECT count(bo_ubicable) FROM mor_expediente_mordedor
                                WHERE id_expediente = expediente.id_expediente AND bo_ubicable = 1)>0,1,0) AS bo_ubicable,
                        GROUP_CONCAT(DISTINCT fiscalizador.id_usuario SEPARATOR ',') AS grupo_fiscalizador,
                        GROUP_CONCAT(DISTINCT fiscalizador_microchip.id_usuario SEPARATOR ',') AS grupo_fiscalizador_microchip,
                        IFNULL((SELECT id_evento_tipo FROM mor_historial_evento
                                WHERE id_expediente = expediente.id_expediente AND id_evento_tipo IN (32,33,34) ORDER BY id_evento DESC LIMIT 1),0) AS boton_llamado_observa,
                        IFNULL((SELECT GROUP_CONCAT(IFNULL(visita_mordedor.id_tipo_resultado_isp,0) SEPARATOR ',')
                                FROM mor_visita_animal_mordedor visita_mordedor
                                LEFT JOIN mor_visita visita ON visita_mordedor.id_visita = visita.id_visita
                                WHERE visita.id_expediente = expediente.id_expediente),'') AS grupo_resultado_isp,
                        (SELECT count(bo_domicilio_conocido) FROM mor_expediente_mordedor
                            WHERE id_expediente = expediente.id_expediente AND bo_domicilio_conocido = 1) AS sin_direccion,
                        (SELECT id_evento_tipo FROM mor_historial_evento WHERE id_expediente = expediente.id_expediente ORDER BY id_evento DESC LIMIT 1) AS id_ultimo_evento
					FROM " . $this->_tabla . " expediente
                    LEFT JOIN mor_establecimiento_salud establecimiento ON expediente.id_establecimiento = establecimiento.id_establecimiento
                    LEFT JOIN mor_expediente_paciente ep ON expediente.id_expediente = ep.id_expediente
                    LEFT JOIN mor_paciente_datos pd ON ep.id_paciente = pd.id_paciente
                    LEFT JOIN mor_direccion_region region_establecimiento ON establecimiento.id_region = region_establecimiento.id_region
                    LEFT JOIN mor_direccion_comuna comuna_establecimiento ON establecimiento.id_comuna = comuna_establecimiento.id_comuna
                    LEFT JOIN mor_expediente_mordedor mem on mem.id_expediente = expediente.id_expediente
                    LEFT JOIN mor_acceso_usuario fiscalizador ON mem.id_fiscalizador = fiscalizador.id_usuario
                    LEFT JOIN mor_acceso_usuario fiscalizador_microchip ON mem.id_fiscalizador_microchip = fiscalizador_microchip.id_usuario
                    LEFT JOIN mor_expediente_estado estado ON expediente.id_expediente_estado = estado.id_expediente_estado                                        
                    LEFT JOIN mor_direccion_oficina_comuna ofi ON establecimiento.id_comuna = ofi.id_comuna                    
                    ";

        $where = " WHERE ";

        //SI ES PERFIL FISCALIZADOR SE SETEA PARAMETRO ID_FISCALIZADOR DIRECTAMENTE
        if ($id_perfil == 6 || $id_perfil == 14)
        {
            $params['id_fiscalizador'] = $_SESSION[SESSION_BASE]['id'];
        }

        if (!empty($params))
        {

            if (isset($params['editar_direccion']) && $params['editar_direccion'] == 1)
            {
                $query .= "INNER JOIN mor_visita visita ON visita.id_expediente = expediente.id_expediente";
            }
            if (isset($params['id_establecimiento']) && $params['id_establecimiento'] > 0)
            {
                $query .= "$where expediente.id_establecimiento = ?";
                $param = array_merge($param, array(
                    intval($params['id_establecimiento'])
                ));
                $where = " AND ";
            }

            // aqui se deben incorporar los parametros nuevos de filtro
            if (isset($params['id_region']) && $params['id_region'] > 0)
            {
                $query_administrativo = "";
                if ($id_perfil == 12)
                {
                    $query_administrativo = "OR establecimiento.id_region = ? ";
                    $param = array_merge($param, array(
                        intval($params['id_region'])
                    ));
                }
                $query .= "$where (? IN (SELECT id_region_mordedor FROM mor_expediente_mordedor WHERE id_expediente = expediente.id_expediente) $query_administrativo) ";
                $param = array_merge($param, array(
                    intval($params['id_region'])
                ));
                $where = " AND ";
            }
            if (isset($params['id_usuario_crea']) && $params['id_usuario_crea'] > 0)
            {
                $query .= "$where expediente.id_usuario_crea = ?";
                $param = array_merge($param, array(
                    intval($params['id_usuario_crea'])
                ));
                $where = " AND ";
            }
            if (isset($params['id_fiscalizador']) && $params['id_fiscalizador'] > 0)
            {
                $query .= "$where (? IN (SELECT id_fiscalizador FROM mor_expediente_mordedor
                                   WHERE id_expediente = expediente.id_expediente)";
                $param = array_merge($param, array(
                    intval($params['id_fiscalizador'])
                ));
                $query .= " OR ? IN (SELECT id_fiscalizador_microchip FROM mor_expediente_mordedor
                                   WHERE id_expediente = expediente.id_expediente))";
                $param = array_merge($param, array(
                    intval($params['id_fiscalizador'])
                ));
                $where = " AND ";
            }
            if (isset($params['id_region_establecimiento']) && $params['id_region_establecimiento'] > 0)
            {
                $query .= "$where establecimiento.id_region = ?";
                $param = array_merge($param, array(
                    intval($params['id_region_establecimiento'])
                ));
                $where = " AND ";
            }
            if (!empty($params['id_oficina']) && $params['id_oficina'] > 0)
            { //ADMINISTRATIVO NO busca por oficina (solo por su Region) --> esto ya no aplica
                if ($id_perfil != 12)
                {
                    $query .= "$where ( expediente.id_expediente IN (SELECT mor_expediente_mordedor.id_expediente
                                                        FROM mor_animal_mordedor
                                                        LEFT JOIN mor_expediente_mordedor ON mor_expediente_mordedor.id_mordedor = mor_animal_mordedor.id_mordedor
                                                        LEFT JOIN mor_direccion_oficina_comuna oficina_comuna1 ON oficina_comuna1.id_comuna = mor_animal_mordedor.id_comuna
                                                        WHERE oficina_comuna1.id_oficina = ?) OR
                                    expediente.id_expediente IN (SELECT mor_expediente_mordedor.id_expediente
                                                        FROM mor_expediente_mordedor
                                                        LEFT JOIN mor_direccion_oficina_comuna oficina_comuna2 ON oficina_comuna2.id_comuna = mor_expediente_mordedor.id_comuna_mordedor
                                                        WHERE oficina_comuna2.id_oficina = ?))";
                    $param = array_merge($param, array(
                        intval($params['id_oficina'])
                    ));
                    $param = array_merge($param, array(
                        intval($params['id_oficina'])
                    ));
                }
                $query .= "$where ofi.id_oficina = ?";
                $param = array_merge($param, array(
                    intval($params['id_oficina'])
                ));
                $where = " AND ";
            }
            if (isset($params['bo_domicilio_conocido']))
            {
                $query .= "$where ? IN (SELECT bo_domicilio_conocido FROM mor_expediente_mordedor WHERE id_expediente = expediente.id_expediente)";
                $param = array_merge($param, array(
                    intval($params['bo_domicilio_conocido'])
                ));
                $where = " AND ";
            }
            if (isset($params['id_expediente_estado']) && $params['id_expediente_estado'] > 0)
            {
                $query .= "$where expediente.id_expediente_estado = ?";
                $param = array_merge($param, array(
                    intval($params['id_expediente_estado'])
                ));
                $where = " AND ";
            }
            if (isset($params['id_animal_grupo']) && $params['id_animal_grupo'] > 0)
            {
                $query .= "$where id_animal_grupo = ?";
                $param = array_merge($param, array(
                    intval($params['id_animal_grupo'])
                ));
                $where = " AND ";
            }
            if (!empty($params['comuna']) && $params['comuna'] > 0)
            {
                $query .= "$where establecimiento.id_comuna = ?";
                $param = array_merge($param, array(
                    intval($params['comuna'])
                ));
                //$param  = array_merge($param,array(intval($params['comuna'])));
                $where = " AND ";
            }
            if (!empty($params['documento']))
            {
                $query .= "$where (ep.id_paciente IN (SELECT id_paciente FROM mor_paciente WHERE gl_rut LIKE ?)
                                    OR pd.json_pasaporte LIKE ?)";
                $param = array_merge($param, array(
                    "%" . $params['documento'] . "%"
                ));
                $param = array_merge($param, array(
                    "%" . $params['documento'] . "%"
                ));
                $where = " AND ";
            }
            if (!empty($params['folio_expediente']))
            {
                $query .= "$where expediente.gl_folio LIKE ?";
                $param = array_merge($param, array(
                    "%" . $params['folio_expediente'] . "%"
                ));
                $where = " AND ";
            }
            if (!empty($params['folio_mordedor']))
            {
                $query .= "$where expediente.id_expediente IN (SELECT id_expediente FROM mor_expediente_mordedor WHERE gl_folio_mordedor LIKE ?)";
                $param = array_merge($param, array(
                    "%" . $params['folio_mordedor'] . "%"
                ));
                $where = " AND ";
            }
            if (!empty($params['microchip_mordedor']))
            {
                $query .= "$where expediente.id_expediente IN (SELECT mor_expediente_mordedor.id_expediente
                                                                FROM mor_animal_mordedor
                                                                LEFT JOIN mor_expediente_mordedor ON mor_expediente_mordedor.id_mordedor = mor_animal_mordedor.id_mordedor
                                                                WHERE gl_microchip LIKE ?)";
                $param = array_merge($param, array(
                    "%" . $params['microchip_mordedor'] . "%"
                ));
                $where = " AND ";
            }
            if (!empty($params['nombre_fiscalizador']))
            {
                $query .= "$where fiscalizador.gl_nombres LIKE ?";
                $query .= "$where fiscalizador.gl_apellidos LIKE ?";
                $param = array_merge($param, array(
                    "%" . $params['nombre_fiscalizador'] . "%"
                ));
                $param = array_merge($param, array(
                    "%" . $params['nombre_fiscalizador'] . "%"
                ));
                $where = " AND ";
            }

        }

        if (!empty($params['fecha_desde']) && !empty($params['fecha_hasta']))
        {
            $query .= " $where expediente.fc_mordedura BETWEEN " . Fechas::formatearBaseDatos($params['fecha_desde']) . " AND " . Fechas::formatearBaseDatos($params['fecha_hasta']);
            $where = " AND ";
        }
        else if (!empty($params['fecha_desde']))
        {
            $query .= " $where expediente.fc_mordedura >= " . Fechas::formatearBaseDatos($params['fecha_desde']);
            $where = " AND ";
        }
        if (!isset($params['editar_direccion']))
        {
                //Bandeja Registros o Bandeja Microchip
                if (isset($params['bo_dias']) && $params['bo_dias'])
                { //MICROCHIP (Ingresado, Asignado y Devuelto) con más de 15 días desde la Mordedura
                    $query .= " $where (DATEDIFF(CURDATE(),expediente.fc_mordedura) >= 15" . " AND expediente.id_expediente_estado IN (1,6,9,14))";
                    $where = " AND ";
                }
                else
                { //REGISTROS
                    if (isset($params['id_fiscalizador']) && $params['id_fiscalizador'] > 0)
                    { // con FISCALIZADOR
                        $query .= " $where (DATEDIFF(CURDATE(),expediente.fc_mordedura) <= 60 AND expediente.id_expediente_estado IN (6,7,14) )";
                        $where = " AND ";
                    }
                    else
                    { //Registros (menos de 15 días desde la Mordedura)
                        $query .= " $where (DATEDIFF(CURDATE(),expediente.fc_mordedura) < 15 AND expediente.id_expediente_estado IN (1,6,7,9,11))";

                        //Si es perfil Administrativo busca Sin Dirección
                        if (isset($params['editar_direccion']) && $params['editar_direccion'] == 1)
                        {
                            $query .= " AND (SELECT count(bo_domicilio_conocido) FROM mor_expediente_mordedor
                                        WHERE id_expediente = expediente.id_expediente AND bo_domicilio_conocido = 1) > 0";
                        }
                        else
                        {
                            if (isset($id_perfil) && $id_perfil == 12)
                            {
                                $query .= " AND (SELECT count(bo_domicilio_conocido) FROM mor_expediente_mordedor
                                        WHERE id_expediente = expediente.id_expediente AND bo_domicilio_conocido = 1) = 0";
                            }
                            else if ($id_perfil != 3)
                            { //Muestra los Con Dirección (excepto para perfil Establecimiento de Salud = ve todos los de el)
                                $query .= " AND (SELECT count(bo_domicilio_conocido) FROM mor_expediente_mordedor
                                        WHERE id_expediente = expediente.id_expediente AND bo_domicilio_conocido = 1) > 0";
                            }

                        }
                        $where = " AND ";
                    }
                }
        }
        //Para no mostrar Estado = Cerrada
        if (isset($params['no_cerrada']))
        {
            $query .= "$where expediente.id_expediente_estado NOT IN (3)";
        }

        $query .= " GROUP BY expediente.id_expediente";

        //echo $this->db->getQueryString($query,$param); die;
        file_put_contents('php://stderr', PHP_EOL . "query: " . print_r($query, true) . PHP_EOL, FILE_APPEND);
        $result = $this
            ->db
            ->getQuery($query, $param);

        if ($result->numRows > 0)
        {
            return $result->rows;
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Descripción : Obtener Lista Detalle Expedientes
     * @author  David Guzmán <david.guzman@cosof.cl> - 22/05/2018
     * @param   array   $params
     */
    public function buscarExpedientes($params = null)
    {
        $param = array();
        $id_perfil = $_SESSION[SESSION_BASE]['perfil'];
        $id_comuna = $_SESSION[SESSION_BASE]['id_comuna'];
        $query = " SELECT
                        expediente.*,
                        DATE_FORMAT(expediente.fc_crea,'%d-%m-%Y') AS fc_ingreso,
                        DATE_FORMAT(expediente.fc_mordedura,'%d-%m-%Y') AS fc_mordedura,
                        region_mordedura.gl_nombre_region AS region_mordedura,
                        comuna_mordedura.gl_nombre_comuna AS comuna_mordedura,
                        GROUP_CONCAT(DISTINCT CONCAT('- ',fiscalizador.gl_nombres,' ',fiscalizador.gl_apellidos) SEPARATOR '<br>') AS gl_nombre_fiscalizador,
                        GROUP_CONCAT(DISTINCT CONCAT('- ',fiscalizador_microchip.gl_nombres,' ',fiscalizador_microchip.gl_apellidos) SEPARATOR '<br>') AS gl_nombre_fiscalizador_microchip,
                        fiscalizador.gl_token AS gl_token_fiscalizador,
                        estado.gl_nombre AS gl_nombre_estado,
                        estado.gl_class AS gl_class_estado,
                        (SELECT gl_nombre_region FROM mor_direccion_region reg
                            LEFT JOIN mor_direccion_comuna comu ON reg.id_region = comu.id_region
                            WHERE comu.id_comuna = establecimiento.id_comuna) AS gl_region_est,
                        (SELECT gl_nombre_corto FROM mor_direccion_region reg
                            LEFT JOIN mor_direccion_comuna comu ON reg.id_region = comu.id_region
                            WHERE comu.id_comuna = establecimiento.id_comuna) AS gl_region_est_corto,
                        (SELECT comu.gl_nombre_comuna FROM mor_direccion_comuna comu WHERE comu.id_comuna = establecimiento.id_comuna) AS gl_comuna_est,
                        DATEDIFF(CURDATE(),expediente.fc_mordedura) AS dias_mordedura,
                        DATEDIFF(CURDATE(),expediente.fc_crea) AS dias_bandeja,
                        establecimiento.gl_nombre_establecimiento AS gl_establecimiento,
                        IFNULL(mem.json_mordedor,'') AS json_mordedor,
                        IFNULL((SELECT id_animal_grupo FROM mor_expediente_mordedor
                                WHERE id_expediente = expediente.id_expediente LIMIT 1),'') AS id_animal_grupo,
                        IFNULL((SELECT grupo.gl_nombre_corto FROM mor_expediente_mordedor mor
                                LEFT JOIN mor_animal_grupo grupo ON mor.id_animal_grupo = grupo.id_animal_grupo
                                WHERE mor.id_expediente = expediente.id_expediente LIMIT 1),'') AS gl_grupo_animal,
                        IFNULL((SELECT GROUP_CONCAT(id_expediente_mordedor_estado SEPARATOR ',')
                                FROM mor_expediente_mordedor WHERE id_expediente = expediente.id_expediente),'') AS grupo_expediente_mordedor_estado,
                        CONCAT(paciente.gl_nombres,' ',paciente.gl_apellido_paterno,' ',paciente.gl_apellido_materno) AS gl_nombre_paciente,
                        IFNULL(paciente.gl_rut,'') AS gl_rut_paciente,
                        (SELECT count(id_visita) FROM mor_visita WHERE id_expediente = expediente.id_expediente) AS nr_visitas,
                        IFNULL((SELECT count(id_visita_mordedor) FROM mor_visita_animal_mordedor
                            LEFT JOIN mor_visita ON mor_visita.id_visita = mor_visita_animal_mordedor.id_visita
                            WHERE mor_visita.id_expediente = expediente.id_expediente),0) AS nr_visitas_mordedor,
                        IFNULL((   SELECT visita_mordedor.id_tipo_resultado_isp FROM mor_visita_animal_mordedor visita_mordedor
                                LEFT JOIN mor_visita visita ON visita_mordedor.id_visita = visita.id_visita
                                WHERE visita.id_expediente = expediente.id_expediente AND visita_mordedor.id_tipo_resultado_isp = 1 LIMIT 1),'') AS id_resultado_isp_1,
                        IFNULL((   SELECT visita_mordedor.id_tipo_resultado_isp FROM mor_visita_animal_mordedor visita_mordedor
                                LEFT JOIN mor_visita visita ON visita_mordedor.id_visita = visita.id_visita
                                WHERE visita.id_expediente = expediente.id_expediente AND visita_mordedor.id_tipo_resultado_isp = 2 LIMIT 1),'') AS id_resultado_isp_2,
                        IFNULL((   SELECT visita_mordedor.id_tipo_visita_resultado FROM mor_visita_animal_mordedor visita_mordedor
                                LEFT JOIN mor_visita visita ON visita_mordedor.id_visita = visita.id_visita
                                WHERE visita.id_expediente = expediente.id_expediente AND visita_mordedor.id_tipo_visita_resultado = 2 LIMIT 1),'') AS id_tipo_visita_resultado_mor,
                        IFNULL((   SELECT visita.id_tipo_visita_resultado FROM mor_visita visita
                                WHERE visita.id_expediente = expediente.id_expediente AND visita.id_tipo_visita_resultado = 2 LIMIT 1),'') AS id_tipo_visita_resultado,
                        IFNULL((SELECT bo_domicilio_conocido FROM mor_expediente_mordedor
                                WHERE id_expediente = expediente.id_expediente AND bo_domicilio_conocido = 0 LIMIT 1),1) AS bo_domicilio_conocido,
                        IF((SELECT count(bo_domicilio_conocido) FROM mor_expediente_mordedor
                            WHERE id_expediente = expediente.id_expediente AND bo_domicilio_conocido = 0)=0,1,0) AS bo_all_domicilio_conocido,
                        IFNULL((SELECT GROUP_CONCAT(DISTINCT reg_mordedor.gl_nombre_region SEPARATOR '<br>') FROM mor_expediente_mordedor
                                LEFT JOIN mor_direccion_region reg_mordedor ON mor_expediente_mordedor.id_region_mordedor = reg_mordedor.id_region
								WHERE id_expediente = expediente.id_expediente),'') AS gl_region_mordedor,
                        IFNULL((SELECT GROUP_CONCAT(DISTINCT com_mordedor.gl_nombre_comuna SEPARATOR '<br>') FROM mor_expediente_mordedor
                                LEFT JOIN mor_direccion_comuna com_mordedor ON mor_expediente_mordedor.id_comuna_mordedor = com_mordedor.id_comuna
								WHERE id_expediente = expediente.id_expediente),'') AS gl_comuna_mordedor,
                        (SELECT id_visita_estado FROM mor_visita
                            WHERE id_expediente = expediente.id_expediente ORDER BY id_visita DESC LIMIT 1) AS id_ultimo_visita_estado,
                        (SELECT id_tipo_visita_perdida FROM mor_visita
                            WHERE id_expediente = expediente.id_expediente ORDER BY id_visita DESC LIMIT 1) AS id_ultimo_tipo_visita_perdida,
                        (SELECT id_tipo_visita_resultado FROM mor_visita
                            WHERE id_expediente = expediente.id_expediente ORDER BY id_visita DESC LIMIT 1) AS id_ultimo_visita_resultado,
                        (SELECT bo_volver_a_visitar FROM mor_visita
                            WHERE id_expediente = expediente.id_expediente ORDER BY id_visita DESC LIMIT 1) AS bo_ultimo_volver_visitar,
                        IF((SELECT count(bo_ubicable) FROM mor_expediente_mordedor
                                WHERE id_expediente = expediente.id_expediente AND bo_ubicable = 1)>0,1,0) AS bo_ubicable,
                        GROUP_CONCAT(DISTINCT fiscalizador.id_usuario SEPARATOR ',') AS grupo_fiscalizador,
                        GROUP_CONCAT(DISTINCT fiscalizador_microchip.id_usuario SEPARATOR ',') AS grupo_fiscalizador_microchip,
                        IFNULL((SELECT id_evento_tipo FROM mor_historial_evento
                                WHERE id_expediente = expediente.id_expediente AND id_evento_tipo  IN (32,33,34) ORDER BY id_evento DESC LIMIT 1),0) AS boton_llamado_observa,
                        IFNULL((SELECT GROUP_CONCAT(IFNULL(visita_mordedor.id_tipo_resultado_isp,0) SEPARATOR ',')
                                FROM mor_visita_animal_mordedor visita_mordedor
                                LEFT JOIN mor_visita visita ON visita_mordedor.id_visita = visita.id_visita
                                WHERE visita.id_expediente = expediente.id_expediente),'') AS grupo_resultado_isp,
                        (SELECT count(bo_domicilio_conocido) FROM mor_expediente_mordedor
                            WHERE id_expediente = expediente.id_expediente AND bo_domicilio_conocido = 0) AS sin_direccion,
                        (SELECT id_evento_tipo FROM mor_historial_evento WHERE id_expediente = expediente.id_expediente ORDER BY id_evento DESC LIMIT 1) AS id_ultimo_evento
                    FROM " . $this->_tabla . " expediente
                    LEFT JOIN mor_establecimiento_salud establecimiento ON expediente.id_establecimiento = establecimiento.id_establecimiento
                    LEFT JOIN mor_expediente_paciente ep ON expediente.id_expediente = ep.id_expediente
                    LEFT JOIN mor_paciente paciente ON ep.id_paciente = paciente.id_paciente
                    LEFT JOIN mor_paciente_datos pd ON ep.id_paciente = pd.id_paciente
                    LEFT JOIN mor_direccion_region region_mordedura ON expediente.id_region_mordedura = region_mordedura.id_region
                    LEFT JOIN mor_direccion_comuna comuna_mordedura ON expediente.id_comuna_mordedura = comuna_mordedura.id_comuna
                    LEFT JOIN mor_expediente_mordedor mem on mem.id_expediente = expediente.id_expediente
                    LEFT JOIN mor_acceso_usuario fiscalizador ON mem.id_fiscalizador = fiscalizador.id_usuario
                    LEFT JOIN mor_acceso_usuario fiscalizador_microchip ON mem.id_fiscalizador_microchip = fiscalizador_microchip.id_usuario
                    LEFT JOIN mor_expediente_estado estado ON expediente.id_expediente_estado = estado.id_expediente_estado
                    ";

        $where = " WHERE ";
        $query_list = array();

        //SI ES PERFIL FISCALIZADOR SE SETEA PARAMETRO ID_FISCALIZADOR DIRECTAMENTE
        if ($id_perfil == 6 || $id_perfil == 14)
        {
            $params['id_fiscalizador'] = $_SESSION[SESSION_BASE]['id'];
        }

        if (!empty($params))
        {
            if (!empty($params['establecimiento_salud']))
            {
                $query_list[] = "expediente.id_establecimiento = ?";
                $param = array_merge($param, array(
                    intval($params['establecimiento_salud'])
                ));
            }
            if (!empty($params['in_establecimiento']))
            {
                $query_list[] = "expediente.id_establecimiento IN (" . $params['in_establecimiento'] . ")";
            }
            if (!empty($params['region']))
            {
                $query_administrativo = "";
                if ($id_perfil == 12 || $id_perfil == 13 || $id_perfil == 15)
                { //PERFIL ADMINISTRATIVO o COMUNAL o SERVICIO SALUD
                    $query_administrativo = "OR establecimiento.id_region = " . intval($params['region']) . " ";
                } /*else{
                    $query_administrativo = "OR ".intval($params['region'])." = expediente.id_region_mordedura";
                }*/
                $query_list[] = "(" . intval($params['region']) . " IN (SELECT mor_expediente_mordedor.id_region_mordedor
                                                        FROM mor_expediente_mordedor
                                                            WHERE id_expediente = expediente.id_expediente) $query_administrativo)";
            }
            if (!empty($params['comuna']))
            {
                if ($id_perfil == 13 || $id_perfil == 15)
                { //PERFIL COMUNAL o SERVICIO SALUD
                    $query_list[] = "establecimiento.id_comuna = " . intval($params['comuna']);
                }
                else
                {
                    $query_list[] = "(expediente.id_expediente IN (SELECT mor_expediente_mordedor.id_expediente
                                                          FROM mor_expediente_mordedor
                                                          LEFT JOIN mor_animal_mordedor
                                                              ON mor_expediente_mordedor.id_mordedor = mor_animal_mordedor.id_mordedor
                                                              WHERE (mor_animal_mordedor.id_comuna = " . intval($params['comuna']) . "
                                                                OR mor_expediente_mordedor.id_comuna_mordedor = " . intval($params['comuna']) . ")
                                                                AND mor_expediente_mordedor.id_expediente = expediente.id_expediente))";
                }
            }
            if (!empty($params['id_oficina']) && $params['id_oficina'] > 0 && $id_perfil != 12 && ($params['bo_ubicable'] == "" || $params['bo_ubicable'] == 1) && ($params['bo_domicilio_conocido'] == "" || $params['bo_domicilio_conocido'] == 1))
            {
                $query_ubicable = "";
                $query_domicilio = "";
                if ($params['bo_ubicable'] == "")
                { //Si es Todos (SI y NO Ubicable)
                    $query_ubicable = "OR expediente.id_expediente IN (SELECT id_expediente FROM mor_expediente_mordedor
                                                            WHERE bo_ubicable = 0 AND expediente.id_expediente = id_expediente)";
                }
                if ($params['bo_domicilio_conocido'] == "")
                { //Si es Todos (SI y NO domicilio conocido)
                    $query_domicilio = "OR expediente.id_expediente IN (SELECT id_expediente FROM mor_expediente_mordedor
                                                            WHERE bo_domicilio_conocido = 0 AND expediente.id_expediente = id_expediente)";
                }
                if ($id_perfil == 13 || $id_perfil == 15)
                { //PERFIL COMUNAL o SERVICIO SALUD
                    $query_list[] = "(establecimiento.id_comuna = " . intval($params['comuna']) . "$query_ubicable $query_domicilio)";
                }
                else
                {

                    $query_list[] = "( expediente.id_expediente IN (SELECT mor_expediente_mordedor.id_expediente
                                                            FROM mor_expediente_mordedor
                                                            LEFT JOIN mor_animal_mordedor ON mor_expediente_mordedor.id_mordedor = mor_animal_mordedor.id_mordedor
                                                            LEFT JOIN mor_direccion_oficina_comuna oficina_comuna1 ON oficina_comuna1.id_comuna = mor_animal_mordedor.id_comuna
                                                                WHERE oficina_comuna1.id_oficina = ?) OR
                                        expediente.id_expediente IN (SELECT mor_expediente_mordedor.id_expediente
                                                            FROM mor_expediente_mordedor
                                                            LEFT JOIN mor_direccion_oficina_comuna oficina_comuna2 ON oficina_comuna2.id_comuna = mor_expediente_mordedor.id_comuna_mordedor
                                                                WHERE oficina_comuna2.id_oficina = ?) $query_ubicable $query_domicilio)";
                    $param = array_merge($param, array(
                        intval($params['id_oficina'])
                    ));
                    $param = array_merge($param, array(
                        intval($params['id_oficina'])
                    ));
                }
            }
            if (!empty($params['id_servicio']))
            {
                $query_list[] = "(establecimiento.id_servicio = ?)";
                $param = array_merge($param, array(
                    intval($params['id_servicio'])
                ));
            }
            if (!empty($params['rut']))
            {
                $query_list[] = "ep.id_paciente IN (SELECT id_paciente FROM mor_paciente WHERE gl_rut LIKE '%" . $params['rut'] . "%')";
            }
            if (!empty($params['folio_expediente']))
            {
                $query_list[] = "expediente.gl_folio LIKE '%" . $params['folio_expediente'] . "%'";
            }
            if (isset($params['token_expediente']) && !empty($params['token_expediente']))
            {
                $query_list[] = "expediente.gl_token = '" . $params['token_expediente'] . "'";
            }
            else if (!empty($params['fecha_hasta']))
            {
                $query_list[] .= " expediente.fc_mordedura <= " . Fechas::formatearBaseDatos($params['fecha_hasta']);
            }
            if (isset($params['bo_ubicable']) && $params['bo_ubicable'] != "")
            {
                $query_list[] = "expediente.id_expediente IN (SELECT id_expediente FROM mor_expediente_mordedor
                                                            WHERE bo_ubicable = " . intval($params['bo_ubicable']) . " AND expediente.id_expediente = id_expediente)";
            }
            if (isset($params['bo_domicilio_conocido']) && $params['bo_domicilio_conocido'] != "")
            {
                $query_list[] = "expediente.id_expediente IN (SELECT id_expediente FROM mor_expediente_mordedor
                                                            WHERE bo_domicilio_conocido = " . intval($params['bo_domicilio_conocido']) . " AND expediente.id_expediente = id_expediente)";
            }
            if (isset($params['bo_microchip']) && $params['bo_microchip'] != "")
            {
                if ($params['bo_microchip'] == 0)
                {
                    $query_list[] = " ((expediente.id_expediente NOT IN (SELECT mor_expediente_mordedor.id_expediente
                                                            FROM mor_animal_mordedor
                                                            LEFT JOIN mor_expediente_mordedor
                                                                ON mor_expediente_mordedor.id_mordedor = mor_animal_mordedor.id_mordedor
                                                                WHERE mor_expediente_mordedor.id_expediente = expediente.id_expediente AND
                                                                (mor_animal_mordedor.gl_microchip != '' AND mor_animal_mordedor.gl_microchip IS NOT NULL)))
                                        AND
                                      (expediente.id_expediente NOT IN (SELECT mor_visita.id_expediente
                                                            FROM mor_animal_mordedor
                                                            LEFT JOIN mor_visita_animal_mordedor ON mor_visita_animal_mordedor.id_mordedor = mor_animal_mordedor.id_mordedor
                                                            LEFT JOIN mor_visita ON mor_visita_animal_mordedor.id_visita = mor_visita.id_visita
                                                                WHERE mor_visita.id_expediente = expediente.id_expediente AND
                                                                (mor_animal_mordedor.gl_microchip != '' AND mor_animal_mordedor.gl_microchip IS NOT NULL)))
                                        )";
                }
                elseif ($params['bo_microchip'] == 1)
                {
                    $query_list[] = " ((expediente.id_expediente IN (SELECT mor_expediente_mordedor.id_expediente
                                                            FROM mor_animal_mordedor
                                                            LEFT JOIN mor_expediente_mordedor
                                                                ON mor_expediente_mordedor.id_mordedor = mor_animal_mordedor.id_mordedor
                                                                WHERE mor_expediente_mordedor.id_expediente = expediente.id_expediente AND
                                                                (mor_animal_mordedor.gl_microchip != '' AND mor_animal_mordedor.gl_microchip IS NOT NULL)))
                                        OR
                                      (expediente.id_expediente IN (SELECT mor_visita.id_expediente
                                                            FROM mor_animal_mordedor
                                                            LEFT JOIN mor_visita_animal_mordedor ON mor_visita_animal_mordedor.id_mordedor = mor_animal_mordedor.id_mordedor
                                                            LEFT JOIN mor_visita ON mor_visita_animal_mordedor.id_visita = mor_visita.id_visita
                                                                WHERE mor_visita.id_expediente = expediente.id_expediente AND
                                                                (mor_animal_mordedor.gl_microchip != '' AND mor_animal_mordedor.gl_microchip IS NOT NULL)))
                                        )";
                }
            }
            if (isset($params['bo_crea_establecimiento']) && $params['bo_crea_establecimiento'] != "")
            {
                $query_list[] = " expediente.bo_crea_establecimiento = " . intval($params['bo_crea_establecimiento']);
            }
            if (!empty($params['folio_mordedor']))
            {
                $query_list[] = "expediente.id_expediente IN (SELECT id_expediente FROM mor_expediente_mordedor WHERE gl_folio_mordedor LIKE '%" . $params['folio_mordedor'] . "%')";
            }
            if (!empty($params['microchip_mordedor']))
            {
                $query_list[] = "expediente.id_expediente IN (SELECT mor_expediente_mordedor.id_expediente
                                                        FROM mor_animal_mordedor
                                                        LEFT JOIN mor_expediente_mordedor
                                                            ON mor_expediente_mordedor.id_mordedor = mor_animal_mordedor.id_mordedor
                                                            WHERE gl_microchip LIKE '%" . $params['microchip_mordedor'] . "%')";
            }
            if (!empty($params['nombre_fiscalizador']))
            {
                $query_list[] .= "fiscalizador.gl_nombres LIKE '%" . $params['nombre_fiscalizador'] . "%'";
                $query_list[] .= "fiscalizador.gl_apellidos LIKE '%" . $params['nombre_fiscalizador'] . "%'";
            }
            if (!empty($params['pasaporte']))
            {
                $query_list[] .= "pd.json_pasaporte LIKE '%" . $params['pasaporte'] . "%'";
            }
            if (isset($params['id_fiscalizador']) && $params['id_fiscalizador'] > 0)
            {
                $query_list[] .= "(expediente.id_expediente IN (SELECT id_expediente FROM mor_expediente_mordedor
                                   WHERE id_fiscalizador = " . intval($params['id_fiscalizador']) . " AND id_expediente = expediente.id_expediente) 
                                   OR expediente.id_expediente IN (SELECT id_expediente FROM mor_expediente_mordedor
                                   WHERE id_fiscalizador_microchip = " . intval($params['id_fiscalizador']) . " AND id_expediente = expediente.id_expediente))";
            }
            if (isset($params['id_resultado']) && $params['id_resultado'] != "")
            {
                if ($params['id_resultado'] == 1)
                { //Sospechoso
                    $query_list[] = " expediente.id_expediente IN (SELECT mor_visita.id_expediente FROM mor_visita
                                                                    LEFT JOIN mor_visita_animal_mordedor ON mor_visita.id_visita = mor_visita_animal_mordedor.id_visita
                                                                    WHERE mor_visita_animal_mordedor.id_tipo_visita_resultado = 2
                                                                    AND mor_visita.id_visita = (SELECT MAX(id_visita) FROM mor_visita WHERE id_expediente = expediente.id_expediente))";
                }
                elseif ($params['id_resultado'] == 2)
                { // NO Sospechoso
                    $query_list[] = " expediente.id_expediente IN (SELECT mor_visita.id_expediente FROM mor_visita
                                                                    LEFT JOIN mor_visita_animal_mordedor ON mor_visita.id_visita = mor_visita_animal_mordedor.id_visita
                                                                    WHERE mor_visita_animal_mordedor.id_tipo_visita_resultado = 1
                                                                    AND mor_visita.id_visita = (SELECT MAX(id_visita) FROM mor_visita WHERE id_expediente = expediente.id_expediente))";
                }
                elseif ($params['id_resultado'] == 3)
                { //Visita Perdida
                    $query_list[] = " expediente.id_expediente IN (SELECT mor_visita.id_expediente FROM mor_visita
                                                                    LEFT JOIN mor_visita_animal_mordedor ON mor_visita.id_visita = mor_visita_animal_mordedor.id_visita
                                                                    WHERE ((mor_visita.id_visita_estado = 1 AND mor_visita.id_tipo_visita_perdida != 1)
                                                                    OR (mor_visita_animal_mordedor.id_tipo_visita_perdida > 0 AND mor_visita_animal_mordedor.id_tipo_visita_perdida != 1))
                                                                    AND mor_visita.id_visita = (SELECT MAX(id_visita) FROM mor_visita WHERE id_expediente = expediente.id_expediente))";
                }
                elseif ($params['id_resultado'] == 4)
                { //Se Niega a Visita
                    $query_list[] = " expediente.id_expediente IN (SELECT mor_visita.id_expediente FROM mor_visita
                                                                    LEFT JOIN mor_visita_animal_mordedor ON mor_visita.id_visita = mor_visita_animal_mordedor.id_visita
                                                                    WHERE (mor_visita.id_tipo_visita_resultado = 5 OR mor_visita_animal_mordedor.id_tipo_visita_resultado = 5)
                                                                    AND mor_visita.id_visita = (SELECT MAX(id_visita) FROM mor_visita WHERE id_expediente = expediente.id_expediente))";
                }
            }
            /**BUSCA POR FECHA SI NO HA INGRESADO FISCALIZADOR,RUT,PASAPORTE,FOLIOS O MICROCHIP (08-11-18)**/
            if ((empty($params['id_fiscalizador']) && ($_SESSION[SESSION_BASE]['perfil'] != 6 || $_SESSION[SESSION_BASE]['perfil'] != 14)) && empty($params['rut']) && empty($params['pasaporte']) && empty($params['folio_expediente']) && empty($params['folio_mordedor']) && empty($params['microchip_mordedor']))
            {
                if (!empty($params['fecha_desde']) && !empty($params['fecha_hasta']))
                {
                    $query_list[] .= " expediente.fc_mordedura BETWEEN " . Fechas::formatearBaseDatos($params['fecha_desde']) . " AND " . Fechas::formatearBaseDatos($params['fecha_hasta']);
                }
                else if (!empty($params['fecha_desde']))
                {
                    $query_list[] .= " expediente.fc_mordedura >= " . Fechas::formatearBaseDatos($params['fecha_desde']);
                }
            }
        }

        if ($id_perfil == 15)
        {
            $query_list[] = "(establecimiento.id_servicio = " . intval($_SESSION[SESSION_BASE]['id_servicio']) . ")";
        }

        if ($id_perfil == 13)
        { //COMUNAL
            $query_list[] = "(establecimiento.id_comuna = " . intval($id_comuna) . ")";
        }

        if (!empty($query_list))
        {
            $query .= $where . implode(" AND ", $query_list);
            $query .= " AND expediente.id_expediente_estado != 17";
        }
        else
        {
            $query .= $where . " expediente.id_expediente_estado != 17";
        }

        $query .= " GROUP BY expediente.id_expediente";

        //echo $this->db->getQueryString($query,$param); die;
        $result = $this
            ->db
            ->getQuery($query, $param);
        if ($result->numRows > 0)
        {
            return $result->rows;
        }
        else
        {
            return NULL;
        }
    }

    public function cambiarEstado($id_expediente, $id_estado)
    {
        $query = "	UPDATE " . $this->_tabla . "
					SET
						id_expediente_estado	= " . intval($id_estado) . ",
                        id_usuario_actualiza	= " . intval($_SESSION[SESSION_BASE]['id']) . ",
                        fc_actualiza			= now()
					WHERE id_expediente = '$id_expediente'";

        if ($this
            ->db
            ->execQuery($query))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Descripción : Asignar Fiscalizador
     * @author  David Guzmán <david.guzman@cosof.cl> - 23/05/2018
     * @param   int $id_fiscalizador, string $gl_token
     */
    /*
    public function asignarFiscalizador($id_fiscalizador,$gl_token){
        $query	= "	UPDATE ".$this->_tabla."
    	SET
    		id_fiscalizador         = ".intval($id_fiscalizador).",
                        id_supervisor           = ".intval($_SESSION[SESSION_BASE]['id']).",
    		id_expediente_estado    = 2,
                        fc_asignado             = now(),
                        id_usuario_actualiza	= ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza			= now()
    	WHERE gl_token = '$gl_token'";
    
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    */

    /**
     * Descripción : Asignar Fiscalizador
     * @author  David Guzmán <david.guzman@cosof.cl> - 29/05/2018
     * @param   int $id_fiscalizador, string $gl_token
     */
    /*
    public function programarVisita($fc_programado,$gl_token){
        $query	= "	UPDATE ".$this->_tabla."
    	SET
    		id_expediente_estado    = 6,
                        fc_programado           = '$fc_programado',
                        id_usuario_actualiza	= ".intval($_SESSION[SESSION_BASE]['id']).",
                        fc_actualiza			= now()
    	WHERE gl_token = '$gl_token'";
    
        if ($this->db->execQuery($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    */

    /**
     * Descripción : Asignar Fiscalizador
     * @author  David Guzmán <david.guzman@cosof.cl> - 29/05/2018
     * @param   string $gl_token
     */
    public function devolverProgramacion($gl_token)
    {
        $query = "	UPDATE " . $this->_tabla . "
					SET
						id_expediente_estado    = 9,
                        id_usuario_actualiza	= " . intval($_SESSION[SESSION_BASE]['id']) . ",
                        fc_actualiza			= now()
					WHERE gl_token = '$gl_token'";

        if ($this
            ->db
            ->execQuery($query))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Descripción : Obtener Mordedores por id_expediente y/o id_fiscalizador
     * @author  Victor Retamal <victor.retamal@cosof.cl> - 04/06/2018
     * @param   int   $id_expediente
     * @param   int   $id_fiscalizador
     */
    public function getJsonMordedor($id_expediente = 0, $id_fiscalizador = 0, $formato = 0, $bo_array = true)
    {
        $arr = array();
        $id_expediente = intval($id_expediente);
        $id_fiscalizador = intval($id_fiscalizador);
        $arr_exp_mordedor = $this->getExpedienteMordedor($id_expediente, $id_fiscalizador);

        if (!empty($arr_exp_mordedor))
        {
            switch ($formato)
            {
                case 0:
                    foreach ($arr_exp_mordedor as $mordedor)
                    {
                        $arr = array_merge($arr, json_decode($mordedor->json_mordedor, $bo_array));
                    }
                break;
                case 1:
                    foreach ($arr_exp_mordedor as $mordedor)
                    {
                        $id_expediente = $mordedor->id_expediente;
                        $id_fiscalizador = $mordedor->id_fiscalizador;

                        $arr[$id_expediente][$id_fiscalizador][] = $mordedor->json_mordedor;
                    }
                break;
                case 2:
                    foreach ($arr_exp_mordedor as $mordedor)
                    {
                        $mordedor = json_decode($mordedor->json_mordedor, $bo_array);
                        $arr[] = $mordedor;
                    }
                break;
                case 3:
                    foreach ($arr_exp_mordedor as $mordedor)
                    {
                        $arr[] = $mordedor;
                    }
                break;
                case 4:
                    $arr = $arr_exp_mordedor;
                break;
                break;
                case 5:
                    foreach ($arr_exp_mordedor as $mordedor)
                    {
                        $merge = array(
                            'id_expediente' => $mordedor->id_expediente,
                            'token_exp_mor' => $mordedor->gl_token,
                            'id_animal_grupo' => $mordedor->id_animal_grupo,
                            'gl_nombre_corto_grupo' => $mordedor->gl_nombre_corto_grupo,
                            'bo_domicilio_conocido' => $mordedor->bo_domicilio_conocido,
                            'id_fiscalizador' => ($mordedor->id_fiscalizador_microchip) ? $mordedor->id_fiscalizador_microchip : $mordedor->id_fiscalizador,
                            'nombre_fiscalizador' => ($mordedor->nombre_fiscalizador_chip) ? $mordedor->nombre_fiscalizador_chip : $mordedor->nombre_fiscalizador,
                            'token_fiscalizador' => ($mordedor->token_fiscalizador_chip) ? $mordedor->token_fiscalizador_chip : $mordedor->token_fiscalizador,
                            'nombre_supervisor' => $mordedor->nombre_supervisor,
                            'gl_folio_mordedor' => $mordedor->gl_folio_mordedor,
                            'id_paciente' => $mordedor->id_paciente,
                            'id_mordedor' => $mordedor->id_mordedor,
                            'id_exp_mor_estado' => $mordedor->id_expediente_mordedor_estado,
                            'gl_exp_mor_estado' => $mordedor->gl_exp_mor_estado,
                            'fc_asignado' => $mordedor->fc_asignado,
                            'fc_programado' => $mordedor->fc_programado,
                            'id_region_estableci' => $mordedor->id_region_establecimiento,
                            'bo_rabia' => $mordedor->bo_rabia,
                            'id_tipo_resultado_isp' => $mordedor->id_tipo_resultado_isp,
                            'json_mordedor' => json_decode($mordedor->json_mordedor, $bo_array) ,
                            'gl_region_mordedor' => $mordedor->gl_region_mordedor,
                            'gl_comuna_mordedor' => $mordedor->gl_comuna_mordedor,
                        );

                        $arr[] = $merge;
                    }
                break;
                default:
                    $arr = array();
                break;
            }
        }

        return $arr;
    }

    public function getExpedienteMordedor($id_expediente = 0, $id_fiscalizador = 0)
    {
        $arr = array();
        $param = NULL;
        $id_expediente = intval($id_expediente);
        $id_fiscalizador = intval($id_fiscalizador);

        if ($id_expediente > 0 or $id_fiscalizador > 0)
        {
            $query = "	SELECT
						exp_mordedor.*,
                        estado.gl_nombre AS gl_exp_mor_estado,
                        DATE_FORMAT(exp_mordedor.fc_asignado,'%d-%m-%Y') AS fc_asignado,
                        DATE_FORMAT(exp_mordedor.fc_programado,'%d-%m-%Y') AS fc_programado,
						CONCAT(supervisor.gl_nombres,' ',supervisor.gl_apellidos) AS nombre_supervisor,
						CONCAT(fiscalizador.gl_nombres,' ',fiscalizador.gl_apellidos) AS nombre_fiscalizador,
						fiscalizador.gl_token AS token_fiscalizador,
						fiscalizador_chip.gl_token AS token_fiscalizador_chip,
						CONCAT(fiscalizador_chip.gl_nombres,' ',fiscalizador_chip.gl_apellidos) AS nombre_fiscalizador_chip,
                        grupo.gl_nombre_corto AS gl_nombre_corto_grupo,
                        establecimiento.id_region AS id_region_establecimiento,
                        ani_mordedor.bo_rabia AS bo_rabia,
                        (   SELECT id_tipo_resultado_isp FROM mor_visita_animal_mordedor
                            WHERE id_mordedor = exp_mordedor.id_mordedor LIMIT 1    ) AS id_tipo_resultado_isp,
                        region_mordedor.gl_nombre_region as gl_region_mordedor,
                        comuna_mordedor.gl_nombre_comuna as gl_comuna_mordedor
					FROM mor_expediente_mordedor exp_mordedor
					LEFT JOIN mor_acceso_usuario supervisor ON exp_mordedor.id_supervisor = supervisor.id_usuario
					LEFT JOIN mor_acceso_usuario fiscalizador ON exp_mordedor.id_fiscalizador = fiscalizador.id_usuario
					LEFT JOIN mor_acceso_usuario fiscalizador_chip ON exp_mordedor.id_fiscalizador_microchip = fiscalizador_chip.id_usuario
					LEFT JOIN mor_expediente_estado estado ON exp_mordedor.id_expediente_mordedor_estado = estado.id_expediente_estado
                    LEFT JOIN mor_animal_grupo grupo ON exp_mordedor.id_animal_grupo = grupo.id_animal_grupo
                    LEFT JOIN mor_animal_mordedor ani_mordedor ON exp_mordedor.id_mordedor = ani_mordedor.id_mordedor
                    LEFT JOIN mor_expediente expediente ON exp_mordedor.id_expediente = expediente.id_expediente
                    LEFT JOIN mor_establecimiento_salud establecimiento ON expediente.id_establecimiento = establecimiento.id_establecimiento
                    LEFT JOIN mor_direccion_region region_mordedor ON exp_mordedor.id_region_mordedor = region_mordedor.id_region
                    LEFT JOIN mor_direccion_comuna comuna_mordedor ON exp_mordedor.id_comuna_mordedor = comuna_mordedor.id_comuna
					";

            if ($id_expediente > 0 and $id_fiscalizador > 0)
            {
                $query .= " WHERE exp_mordedor.id_expediente = ? AND exp_mordedor.id_fiscalizador = ? ";
                $param = array(
                    $id_expediente,
                    $id_fiscalizador
                );
            }
            else if ($id_expediente > 0)
            {
                $query .= " WHERE exp_mordedor.id_expediente = ? ";
                $param = array(
                    $id_expediente
                );
            }
            else if ($id_fiscalizador > 0)
            {
                $query .= " WHERE exp_mordedor.id_fiscalizador = ? ";
                $param = array(
                    $id_fiscalizador
                );
            }

            $result = $this
                ->db
                ->getQuery($query, $param);
            if ($result->numRows > 0)
            {
                return $result->rows;
            }
        }

        return $arr;
    }

    /**
     * Descripción : Obtener Expediente por token
     * @author  David Guzmán <david.guzman@cosof.cl> - 24/05/2018
     * @param   string   $token_expediente
     */
    public function getBitacoraByToken($token_expediente, $bo_cabecera = 0)
    {

        $query = "	SELECT
						expediente.*,
                        DATE_FORMAT(expediente.fc_ingreso,'%d-%m-%Y') AS fc_ingreso,
                        DATE_FORMAT(expediente.fc_notificacion_seremi,'%d-%m-%Y') AS fc_notificacion_seremi,
                        DATE_FORMAT(expediente.fc_mordedura,'%d-%m-%Y') AS fc_mordedura,
                        establecimiento.gl_nombre_establecimiento AS gl_establecimiento,
                        region_mordedura.gl_nombre_region AS region_mordedura,
                        comuna_mordedura.gl_nombre_comuna AS comuna_mordedura,
                        p.gl_rut AS rut_paciente,
                        p.bo_rut_informado AS bo_rut_informado_paciente,
                        region_paciente.gl_nombre_region AS region_paciente,
                        comuna_paciente.gl_nombre_comuna AS comuna_paciente,
                        p.gl_nombres AS nombre_paciente,
                        CONCAT(p.gl_apellido_paterno,' ',p.gl_apellido_materno) AS apellidos_paciente,
                        pd.json_pasaporte AS json_pasaporte,
                        DATE_FORMAT(pd.fc_nacimiento,'%d-%m-%Y') AS fc_nacimiento_paciente,
                        pd.nr_edad AS nr_edad_paciente,
                        prevision.gl_nombre_prevision AS nombre_prevision_paciente,
                        p.id_paciente AS id_paciente,
                        sexo.gl_tipo_sexo AS gl_tipo_sexo,
                        nacionalidad_paciente.gl_nombre_nacionalidad AS gl_nacionalidad_paciente,
                        pais_paciente.gl_nombre_pais AS gl_pais_paciente,
                        CONCAT(supervisor.gl_nombres,' ',supervisor.gl_apellidos) AS gl_nombre_supervisor,
                        estado.gl_nombre AS gl_nombre_estado,
                        estado.gl_class AS gl_class_estado,
                        (SELECT bo_volver_a_visitar FROM mor_visita
                            WHERE id_expediente = expediente.id_expediente ORDER BY id_visita DESC LIMIT 1) AS bo_ultimo_volver_visitar
					FROM " . $this->_tabla . " expediente
                    LEFT JOIN mor_establecimiento_salud establecimiento ON expediente.id_establecimiento = establecimiento.id_establecimiento
                    /* LEFT JOIN mor_expediente_paciente ep ON (expediente.id_expediente = ep.id_expediente AND ep.bo_estado = 1) */
                    LEFT JOIN mor_direccion_region region_mordedura ON expediente.id_region_mordedura = region_mordedura.id_region
                    LEFT JOIN mor_direccion_comuna comuna_mordedura ON expediente.id_comuna_mordedura = comuna_mordedura.id_comuna
                    LEFT JOIN mor_paciente p ON expediente.id_paciente = p.id_paciente
                    LEFT JOIN mor_direccion_region region_paciente ON p.id_region = region_paciente.id_region
                    LEFT JOIN mor_direccion_comuna comuna_paciente ON p.id_comuna = comuna_paciente.id_comuna
                    LEFT JOIN mor_paciente_datos pd ON p.id_paciente = pd.id_paciente
                    LEFT JOIN mor_general_prevision prevision ON pd.id_prevision = prevision.id_prevision
                    LEFT JOIN mor_tipo_sexo sexo ON pd.id_tipo_sexo = sexo.id_tipo_sexo
                    LEFT JOIN mor_direccion_nacionalidad nacionalidad_paciente ON pd.id_nacionalidad = nacionalidad_paciente.id_nacionalidad
                    LEFT JOIN mor_direccion_pais pais_paciente ON pd.id_pais_origen = pais_paciente.id_pais
                    LEFT JOIN mor_acceso_usuario supervisor ON expediente.id_usuario_crea = supervisor.id_usuario
                    LEFT JOIN mor_expediente_estado estado ON expediente.id_expediente_estado = estado.id_expediente_estado
                    WHERE expediente.gl_token = ?";

        $param = array(
            $token_expediente
        );
        $result = $this
            ->db
            ->getQuery($query, $param);

        if ($result->numRows > 0)
        {
            $arr = $result
                ->rows->row_0;
            $id_expediente = $arr->id_expediente;

            $contactos = $this->getContactosByPaciente($arr->id_paciente);
            $arr->arrPasaporte = json_decode($arr->json_pasaporte, true);
            $arr->arrDirMordedura = json_decode($arr->json_direccion_mordedura, true);
            $arr->arrMordedor = $this->getJsonMordedor($id_expediente, 0, 5, true);
            $arr->arrExpediente = json_decode($arr->json_expediente, true);
            $animal_grupo = (isset($arr->arrMordedor[0])) ? $this->getAnimalGrupoById($arr->arrMordedor[0]['id_animal_grupo']) : "";
            $arr->gl_animal_grupo = (!empty($animal_grupo)) ? $animal_grupo->gl_nombre : "";
            $arr_contactos = array();

            if (!empty($contactos))
            {
                foreach ($contactos AS $key => $contacto)
                {
                    $arr_contactos[$key]['id_paciente_contacto'] = $contacto->id_paciente_contacto;
                    $arr_contactos[$key]['id_tipo_contacto'] = $contacto->id_tipo_contacto;
                    $arr_contactos[$key]['json_datos'] = json_decode($contacto->json_dato_contacto, true);
                }
            }

            $arr->arrVisitas = $this->getVisitaByExpediente($id_expediente);

            if ($bo_cabecera == 0)
            {
                $arr->arrContactoPac = $arr_contactos;
                $arr->arrAdjuntos = $this->getAdjuntosByExpediente($id_expediente);
                $arr->arrTipoAdjunto = $this->getlistaTipoAdjuntos();
                $arr->arrEventos = $this->getHistorialByExpediente($id_expediente);
                $arr->arrMordedores = $this->getMordedoresByExpediente($id_expediente);
                $arr->arrTipoResultados = $this->getTipoResultadosVisita();
                $arr->arrTipoComentario = $this->getlistaTipoComentarioHistorial();
            }

            return $arr;

        }
        else
        {
            return NULL;
        }
    }

    //Obtiene contactos de paciente para Bitacora
    function getContactosByPaciente($id_paciente)
    {
        $query = "	SELECT	*
					FROM mor_paciente_contacto
					WHERE id_paciente = ? AND bo_estado = 1";

        $param = array(
            $id_paciente
        );
        $result = $this
            ->db
            ->getQuery($query, $param);

        if ($result->numRows > 0)
        {
            return $result->rows;
        }
        else
        {
            return NULL;
        }
    }
    //Obtiene grupo de animal para Bitacora
    function getAnimalGrupoById($id)
    {
        $query = "	SELECT * FROM mor_animal_grupo
					WHERE id_animal_grupo = ?";

        $param = array(
            $id
        );
        $result = $this
            ->db
            ->getQuery($query, $param);

        if ($result->numRows > 0)
        {
            return $result
                ->rows->row_0;
        }
        else
        {
            return NULL;
        }
    }
    //Obtiene adjuntos por expediente para Bitacora
    function getAdjuntosByExpediente($id_expediente)
    {
        $query = "	SELECT
                        adjunto.*,
                        DATE_FORMAT(adjunto.fc_crea, '%d-%m-%Y') AS fc_crea,
                        at.gl_nombre_tipo_adjunto AS gl_tipo,
                        CONCAT(u.gl_nombres,' ',u.gl_apellidos) AS nombre_usuario
                    FROM mor_adjunto adjunto
                    LEFT JOIN mor_adjunto_tipo at ON adjunto.id_adjunto_tipo = at.id_adjunto_tipo
                    LEFT JOIN mor_acceso_usuario u ON adjunto.id_usuario_crea = u.id_usuario
                    WHERE adjunto.id_expediente = ?";

        $params = array(
            $id_expediente
        );
        $result = $this
            ->db
            ->getQuery($query, $params);

        if ($result->numRows > 0)
        {
            return $result->rows;
        }
        else
        {
            return NULL;
        }
    }
    //Obtiene adjuntos tipos para Bitacora
    function getlistaTipoAdjuntos()
    {
        $query = "	SELECT * FROM mor_adjunto_tipo";
        $result = $this
            ->db
            ->getQuery($query);

        if ($result->numRows > 0)
        {
            return $result->rows;
        }
        else
        {
            return NULL;
        }
    }
    //Obtiene tipos comentarios para Bitacora
    function getlistaTipoComentarioHistorial()
    {
        $query = " SELECT 
						* 
					FROM mor_historial_comentario_tipo 
					WHERE bo_estado = 1 
						AND bo_mostrar = 1
					ORDER BY nr_orden ASC";
        $result = $this
            ->db
            ->getQuery($query);

        if ($result->numRows > 0)
        {
            return $result->rows;
        }
        else
        {
            return NULL;
        }
    }
    //Obtiene historial eventos para Bitacora
    function getHistorialByExpediente($id_expediente)
    {
        $query = "	SELECT
                        evento.*,
                        DATE_FORMAT(evento.fc_crea, '%d-%m-%Y %H:%i:%s') AS fc_crea,
                        evento_tipo.gl_nombre_evento_tipo AS gl_nombre_evento,
                        comentario_tipo.gl_nombre_tipo_comentario AS gl_nombre_tipo_comentario,
                        CONCAT(creador.gl_nombres,' ',creador.gl_apellidos) AS gl_nombre_usuario
                    FROM mor_historial_evento evento
						LEFT JOIN mor_historial_evento_tipo evento_tipo ON evento.id_evento_tipo = evento_tipo.id_evento_tipo
						LEFT JOIN mor_historial_comentario_tipo comentario_tipo ON evento.id_tipo_comentario = comentario_tipo.id_comentario_tipo
						LEFT JOIN mor_acceso_usuario creador ON evento.id_usuario_crea = creador.id_usuario
					WHERE id_expediente = ? AND evento.bo_estado = 1";

        $param = array(
            $id_expediente
        );
        $result = $this
            ->db
            ->getQuery($query, $param);

        if ($result->numRows > 0)
        {
            return $result->rows;
        }
        else
        {
            return NULL;
        }
    }
    //Obtiene visitas para Bitacora
    function getVisitaByExpediente($id_expediente)
    {
        $query = "	SELECT
                        visita.*,
                        DATE_FORMAT(visita.fc_visita, '%d-%m-%Y') AS fc_visita,
                        visita.id_visita_estado AS id_estado,
                        estado.gl_nombre AS gl_estado,
                        tipo_perdida.gl_descripcion AS tipo_visita_perdida,
                        IFNULL(tipo_resultado.gl_nombre,'-') AS tipo_resultado_visita,
                        CONCAT(fiscalizador.gl_nombres,' ',fiscalizador.gl_apellidos) AS gl_fiscalizador,
                        region.gl_nombre_region AS gl_region_mordedura,
                        comuna.gl_nombre_comuna AS gl_comuna_mordedura,
                        expediente.json_direccion_mordedura,
                        (   SELECT visita_mordedor.id_tipo_visita_resultado FROM mor_visita_animal_mordedor visita_mordedor
                            WHERE visita_mordedor.id_visita = visita.id_visita AND visita_mordedor.id_tipo_visita_resultado = 2 LIMIT 1
                            ) AS id_tipo_visita_resultado_mor,
                        (   SELECT GROUP_CONCAT(mor_expediente_mordedor.gl_folio_mordedor SEPARATOR '<br>') FROM mor_expediente_mordedor
                            LEFT JOIN mor_visita_animal_mordedor visita_mordedor ON mor_expediente_mordedor.id_mordedor = visita_mordedor.id_mordedor
                            WHERE visita_mordedor.id_visita = visita.id_visita AND mor_expediente_mordedor.id_expediente = visita.id_expediente) AS gl_folio_mordedores,
                        IFNULL((   SELECT visita_mordedor.id_tipo_resultado_isp FROM mor_visita_animal_mordedor visita_mordedor
                                WHERE visita.id_visita = visita_mordedor.id_visita AND visita_mordedor.id_tipo_resultado_isp = 1 LIMIT 1),'') AS id_resultado_isp_1,
                        IFNULL((   SELECT visita_mordedor.id_tipo_resultado_isp FROM mor_visita_animal_mordedor visita_mordedor
                                WHERE visita.id_visita = visita_mordedor.id_visita AND visita_mordedor.id_tipo_resultado_isp = 2 LIMIT 1),'') AS id_resultado_isp_2,
                        IFNULL((SELECT count(id_visita_mordedor) FROM mor_visita_animal_mordedor
                            WHERE mor_visita_animal_mordedor.id_visita = visita.id_visita),0) AS nr_visitas_mordedor
                    FROM mor_visita visita
						LEFT JOIN mor_visita_estado estado ON visita.id_visita_estado = estado.id_visita_estado
						LEFT JOIN mor_acceso_usuario fiscalizador ON visita.id_fiscalizador = fiscalizador.id_usuario
                        LEFT JOIN mor_visita_tipo_perdida tipo_perdida ON tipo_perdida.id_tipo_visita_perdida = visita.id_tipo_visita_perdida
                        LEFT JOIN mor_visita_tipo_resultado tipo_resultado ON visita.id_tipo_visita_resultado = tipo_resultado.id_tipo_visita_resultado
                        LEFT JOIN mor_expediente expediente ON visita.id_expediente = expediente.id_expediente
                        LEFT JOIN mor_direccion_region region ON expediente.id_region_mordedura = region.id_region
                        LEFT JOIN mor_direccion_comuna comuna ON expediente.id_comuna_mordedura = comuna.id_comuna
					WHERE visita.id_expediente = ?";

        $param = array(
            $id_expediente
        );
        $result = $this
            ->db
            ->getQuery($query, $param);

        if ($result->numRows > 0)
        {
            return $result->rows;
        }
        else
        {
            return NULL;
        }
    }
    //Obtiene tipo resultados visita
    function getTipoResultadosVisita()
    {
        $query = "	SELECT
                        *
                    FROM mor_visita_tipo_resultado
                    WHERE bo_estado = 1";

        $result = $this
            ->db
            ->getQuery($query);

        if ($result->numRows > 0)
        {
            return $result->rows;
        }
        else
        {
            return NULL;
        }
    }

    //Obtiene mordedores visitados para Bitacora
    function getMordedoresByExpediente($id_expediente)
    {
        $query = "	SELECT
                        mordedor.*,
                        animal_mordedor.*,
                        IF(dueno.id_dueno IS NULL,
                                'SIN DUEÑO',
                                CONCAT(dueno.gl_nombre,' ',dueno.gl_apellido_paterno,' ',dueno.gl_apellido_materno)
                        ) AS gl_nombre_dueno,
                        IF(dueno.gl_rut,dueno.gl_rut,dueno.gl_pasaporte) AS gl_rut_dueno,
                        IFNULL(dueno.id_dueno,'') AS token_dueno,
                        especie.gl_nombre AS gl_animal_especie,
                        raza.gl_nombre AS gl_animal_raza,
                        estado.gl_nombre AS gl_animal_estado,
                        grupo.gl_nombre AS gl_animal_grupo,
                        region.gl_nombre_region AS gl_region,
                        comuna.gl_nombre_comuna AS gl_comuna,
                        IFNULL((SELECT gl_folio_mordedor FROM mor_expediente_mordedor
                                WHERE id_mordedor = mordedor.id_mordedor AND id_expediente = visita.id_expediente LIMIT 1),'') AS gl_folio_mordedor
                    FROM mor_visita_animal_mordedor mordedor
						LEFT JOIN mor_visita visita ON mordedor.id_visita = visita.id_visita
						LEFT JOIN mor_animal_mordedor animal_mordedor ON animal_mordedor.id_mordedor = mordedor.id_mordedor
						LEFT JOIN mor_dueno dueno ON mordedor.id_dueno = dueno.id_dueno
						LEFT JOIN mor_animal_especie especie ON animal_mordedor.id_animal_especie = especie.id_animal_especie
						LEFT JOIN mor_animal_raza raza ON animal_mordedor.id_animal_raza = raza.id_animal_raza
						LEFT JOIN mor_animal_estado estado ON animal_mordedor.id_animal_estado = estado.id_animal_estado
						LEFT JOIN mor_animal_grupo grupo ON animal_mordedor.id_animal_grupo = grupo.id_animal_grupo
						LEFT JOIN mor_direccion_region region ON animal_mordedor.id_region = region.id_region
						LEFT JOIN mor_direccion_comuna comuna ON animal_mordedor.id_comuna = comuna.id_comuna
					WHERE visita.id_visita_estado = 2 AND visita.id_expediente = ?";

        $param = array(
            $id_expediente
        );
        $result = $this
            ->db
            ->getQuery($query, $param);

        if ($result->numRows > 0)
        {
            return $result->rows;
        }
        else
        {
            return NULL;
        }
    }

}

?>
