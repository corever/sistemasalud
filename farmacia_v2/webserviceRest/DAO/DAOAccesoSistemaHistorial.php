<?php
/**
 ******************************************************************************
 * Sistema           : FARMACIA
 * 
 * Descripcion       : Modelo para Tabla ws_acceso_sistemas_historial
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 09/08/2018
 * 
 * @name             DAOAccesoSistemaHistorial.php
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
class DAOAccesoSistemaHistorial{
	protected $_tabla			=	TABLA_ACCESO_SISTEMA_HISTORIAL;
	protected $_primaria		=	"id_auditoria_ws";
	protected $_transaccional	=	false;
	protected $_conn			=	null;
	protected $_respuesta		=	array();

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

	public function llamadasMetodoPorMes($metodo,$id_sistema){//$hash){
		$query  = " SELECT COUNT(*) AS cantidad_llamadas 
					FROM ".$this->_tabla."
					WHERE gl_ws_metodo = '".$metodo."'
					AND id_sistema = '".$id_sistema."'
					AND (fc_crea BETWEEN (NOW() - INTERVAL 1 MONTH) AND NOW())";
					//AND gl_hash = '".$hash."'
		$result = $this->_conn->consulta($query);

		if($result->num_rows>0){
			$data = $this->_conn->fetch_assoc($result);
			return $data["cantidad_llamadas"];
		}else{
			return 0;
		}
	}

	public function llamadasMetodoPorDia($metodo,$id_sistema){//$hash){
		$fecha_actual = date("Y-m-d");
		$query  = " SELECT COUNT(*) AS cantidad_llamadas 
					FROM ".$this->_tabla."
					WHERE gl_ws_metodo = '".$metodo."'
					AND id_sistema = '".$id_sistema."'
					AND (fc_crea BETWEEN '".$fecha_actual." 00:00:00' AND '".$fecha_actual." 23:59:59')";
					//AND gl_hash = '".$hash."'
		$result = $this->_conn->consulta($query);

		if($result->num_rows>0){
			$data = $this->_conn->fetch_assoc($result);
			return $data["cantidad_llamadas"];
		}else{
			return 0;
		}
	}

	public function llamadasMetodoPorHora($metodo,$id_sistema){//$hash){
		$hora_actual = date("Y-m-d H:i:s");
		$ultima_hora = date("Y-m-d H:i:s",strtotime("-1 hours"));
		$query  = " SELECT COUNT(*) AS cantidad_llamadas 
					FROM ".$this->_tabla."
					WHERE gl_ws_metodo = '".$metodo."'
					AND id_sistema = '".$id_sistema."'
					AND (fc_crea BETWEEN '".$ultima_hora."' AND '".$hora_actual."')";
					//AND gl_hash = '".$hash."'
		$result = $this->_conn->consulta($query);

		if($result->num_rows>0){
			$data = $this->_conn->fetch_assoc($result);
			return $data["cantidad_llamadas"];
		}else{
			return 0;
		}
	}
	
	function insAccesoHistorial($params){
		$id				= 0;

		if(!empty($params)){
			
			if(!empty($params['REQUEST'])){
				$gl_public_key		= validar($params['REQUEST']['public_key'],'string');
				$gl_hash			= validar($params['REQUEST']['hash'],'string');
				$gl_ws_version		= validar($params['REQUEST']['version_ws'],'string');
				$gl_ws_metodo		= validar($params['REQUEST']['metodo'],'string');
				$bo_ws_success		= validar($params['respuesta']['bo_estado'],'numero');
			}else{
				$gl_public_key		= '';
				$gl_hash			= '';
				$gl_ws_version		= '';
				$gl_ws_metodo		= 'URL DIRECTO';
				$bo_ws_success		= 0;
			}
			
			$id_usuario				= validar($params['id_usuario'],'numero');
			$id_sistema				= validar($params['id_sistema'],'numero');
			$gl_rut					= validar($params['gl_rut'],'string');
			$gl_origen				= validar($params['gl_origen'],'string');
			$gl_ws_ejecucion_time	= $params['ejecucion_time'];
			$json_auditoria			= addslashes(json_encode($params));
			$json_respuesta			= addslashes(json_encode($params['respuesta']));
			
			$query		= "	INSERT INTO ".$this->_tabla."
								(
								id_usuario,
								id_sistema,
								gl_rut,
								gl_origen,
								gl_public_key,
								gl_hash,
								gl_ws_version,
								gl_ws_metodo,
								bo_ws_success,
								gl_ws_ejecucion_time,
								json_auditoria,
								json_respuesta,
								id_usuario_crea
								)
							VALUES
								(
								$id_usuario,
								$id_sistema,
								'$gl_rut',
								'$gl_origen',
								'$gl_public_key',
								'$gl_hash',
								'$gl_ws_version',
								'$gl_ws_metodo',
								$bo_ws_success,
								'$gl_ws_ejecucion_time',
								'$json_auditoria',
								'$json_respuesta',
								id_usuario
								)
							";

			$result	= $this->_conn->consulta($query);
			$id		= $this->_conn->getInsertId();
		}

		return $id;
	}

	public function update($parametros, $id){
		$this->_conn->update($this->_tabla,$parametros, $this->_primaria, $id );
	}

	function cerrar_conexion(){
		$this->_conn->cerrar_conexion();
	}

}

?>