<?php
/**
 ******************************************************************************
 * Sistema           :	Farmacia v2
 * 
 * Descripcion       : Modelo para obtener local
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 21/09/2020
 * 
 * @name             DAOLocal.php
 * 
 * @version          1.0
 *
 * @author           Gabriel Díaz <gabriel.diaz@cosof.cl>
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
class DAOLocal{

	protected $_tabla						=	TABLA_LOCAL;
	protected $_primaria					=	"local_id";
	protected $_transaccional				=	FALSE;
	protected $_conn						=	NULL;
	protected $_respuesta					=	array();


	function __construct($conn = NULL) {
		if($conn !== NULL){
			$this->_conn =  $conn;
		}else{
			$this->_conn =  new MySQL();
		}
	}

	public function getById($id_usuario){
		$id_usuario	= validar($id_usuario,'numero');
		
		if(!empty($id_usuario)){
			$query	= "	SELECT * FROM ".$this->_tabla." WHERE ".$this->_primaria." = ".$id_usuario;
			$data		= $this->_conn->consulta($query);
			$respuesta	= $this->_conn->fetch_assoc($data);
			$this->_conn->dispose($data);

			if(!empty($respuesta)){
				return $respuesta;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}

	public function getByRut($rut){
		$rut	= validar($rut,'string');
		
		if(!empty($rut)){
			$query	= "	SELECT * FROM ".$this->_tabla." WHERE gl_rut = '".$rut."'";
			$data		= $this->_conn->consulta($query);
			$respuesta	= $this->_conn->fetch_assoc($data);
			$this->_conn->dispose($data);

			if(!empty($respuesta)){
				return $respuesta;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}

	public function getByCodigo($codigo){
		$codigo			=	validar($codigo,	'string');

		if(!empty($codigo)){
			$query		=
			"	SELECT	*
				FROM	".	$this->_tabla	."
				WHERE	gl_codigo_midas			=	'".	$codigo	."'
			";

			$data		=	$this->_conn->consulta($query);
			$respuesta	=	$this->_conn->fetch_assoc($data);
			
			$this->_conn->dispose($data);

			if(!empty($respuesta)){
				return $respuesta;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}
	

	public function insert($parametros){
		$sql		=
		"	INSERT INTO ".$this->_tabla." (
				fk_farmacia,
				ordenamiento,
				local_nombre,
				local_numero,
				local_direccion,
				local_lat,
				local_lng,
				local_impide_turnos,
				local_telefono,
				local_fono_codigo,
				local_fono,
				fk_localidad,
				fk_region,
				fk_comuna,
				fk_local_tipo,
				local_numero_resolucion,
				local_fecha_resolucion,
				local_tipo_alopatica,
				local_tipo_homeopatica,
				local_tipo_movil,
				local_tipo_urgencia,
				local_estado,
				local_tipo_franquicia,
				local_recetario,
				local_tiene_recetario,
				local_recetario_tipo,
				id_recetario_tipo,
				local_recetario_fk_detalle,
				json_recetario_detalle,
				local_preparacion_solidos,
				local_preparacion_liquidos,
				local_preparacion_esteriles,
				local_preparacion_cosmeticos,
				local_preparacion_homeopaticos,
				resolucion_url,
				id_region_midas,
				id_comuna_midas,
				json_recorrido,
				activa_mapa,
				factor_riesgo,
				rakin_numero,
				ip_cadena_acceso,
				gl_token,
				bo_ws
			)VALUES (
				".	validar($parametros["fk_farmacia"],								"numero")		.	",
				".	validar($parametros["ordenamiento"],							"numero")		.	",
				'".	validar($parametros["local_nombre"],							"string")		.	"',
				'".	validar($parametros["local_numero"],							"string")		.	"',
				'".	validar($parametros["local_direccion"],							"string")		.	"',
				'".	validar($parametros["local_lat"],								"string")		.	"',
				'".	validar($parametros["local_lng"],								"string")		.	"',
				".	validar($parametros["local_impide_turnos"],						"numero")		.	",
				'".	validar($parametros["local_telefono"],							"string")		.	"',
				'".	validar($parametros["local_fono_codigo"],						"string")		.	"',
				'".	validar($parametros["local_fono"],								"string")		.	"',
				".	validar($parametros["fk_localidad"],							"numero")		.	",
				".	validar($parametros["fk_region"],								"numero")		.	",
				".	validar($parametros["fk_comuna"],								"numero")		.	",
				".	validar($parametros["fk_local_tipo"],							"numero")		.	",
				'".	validar($parametros["local_numero_resolucion"],					"string")		.	"',
				'".	validar($parametros["local_fecha_resolucion"],					"string")		.	"',
				".	validar($parametros["local_tipo_alopatica"],					"numero")		.	",
				".	validar($parametros["local_tipo_homeopatica"],					"numero")		.	",
				".	validar($parametros["local_tipo_movil"],						"numero")		.	",
				".	validar($parametros["local_tipo_urgencia"],						"numero")		.	",
				".	validar($parametros["local_estado"],							"numero")		.	",
				".	validar($parametros["local_tipo_franquicia"],					"numero")		.	",
				".	validar($parametros["local_recetario"],							"numero")		.	",
				".	validar($parametros["local_tiene_recetario"],					"numero")		.	",
				".	validar($parametros["local_recetario_tipo"],					"numero")		.	",
				".	validar($parametros["id_recetario_tipo"],						"numero")		.	",
				'".	validar($parametros["local_recetario_fk_detalle"],				"string")		.	"',
				'".	$parametros["json_recetario_detalle"]											.	"',
				".	validar($parametros["local_preparacion_solidos"],				"numero")		.	",
				".	validar($parametros["local_preparacion_liquidos"],				"numero")		.	",
				".	validar($parametros["local_preparacion_esteriles"],				"numero")		.	",
				".	validar($parametros["local_preparacion_cosmeticos"],			"numero")		.	",
				".	validar($parametros["local_preparacion_homeopaticos"],			"numero")		.	",
				'".	validar($parametros["resolucion_url"],							"string")		.	"',
				".	validar($parametros["id_region_midas"],							"numero")		.	",
				".	validar($parametros["id_comuna_midas"],							"numero")		.	",
				'".	$parametros["json_recorrido"]													.	"',
				".	validar($parametros["activa_mapa"],								"numero")		.	",
				'".	validar($parametros["factor_riesgo"],							"string")		.	"',
				'".	validar($parametros["rakin_numero"],							"string")		.	"',
				'".	validar($parametros["ip_cadena_acceso"],						"string")		.	"',
				'".	validar($parametros["gl_token"],								"string")		.	"',
				1
		)";
        
        $data		=	$this->_conn->consulta($sql);
        $visitaId	=	$this->_conn->getInsertId($data);
        return	$visitaId;
	}

	public function update($parametros, $id){
		$this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
	}
}