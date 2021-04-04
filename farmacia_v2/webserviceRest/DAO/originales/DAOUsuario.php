<?php
/**
 ******************************************************************************
 * Sistema           : WSFarmacia
 * 
 * Descripcion       : Modelo para obtener Usuarios
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 07/07/2018
 * 
 * @name             DAOUsuario.php
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
class DAOUsuario{

	protected $_tabla           = "acceso_usuario";
    protected $_primaria		= "id_usuario";
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

    public function getById($id_usuario){
		$id_usuario	= validar($id_usuario,'numero');
		
		if(!empty($id_usuario)){
			$query	= "	SELECT * FROM ".$this->_tabla." WHERE ".$this->_primaria." = ".$id_usuario;
			$result = $this->_conn->consultaArreglo($query);
			
			if(!empty($result)){
				return $result;
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
			$result = $this->_conn->consultaArreglo($query);
			
			if(!empty($result)){
				return $result;
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }

    public function getLogin($params){
		$gl_rut		= validar($params["rut"],'string');
		//$gl_clave	= hash("sha512", validar($gl_clave,'string'));

		if(isset($params["rol"])){
			$rol		= validar($params["rol"],'string');
		}
		if(isset($params["region"])){
			$region		= validar($params["region"],'int');
		}

		if(!empty($gl_rut)){
			$query	= "	SELECT 
							id_usuario,
							gl_rut,
							gl_password,
							gl_token,
							gl_email,
							gl_nombres,
							gl_apellidos
						FROM ".$this->_tabla;
			
			$where  =" WHERE gl_rut = '$gl_rut' 
							AND bo_activo = 1";
			//AND gl_password = '$gl_clave'
			
			//TODO: corregir opciones de region y rol
			if(isset($rol)){
				$where.= " AND mur.mur_fk_rol IN ($rol) ";
			}
			if(isset($region)){
				$where .= " AND mur.region IN ($region) ";
			}
			
			$limit = " LIMIT 1 ";
			$sql = $query.$where.$limit;
			
			$data		= $this->_conn->consulta($sql);
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

    function getPerfilesByIdUsuario($id){
		$respuesta	= array();
		$sql 		= "SELECT id_perfil, id_region, id_oficina 
						FROM acceso_usuario_perfil 
						WHERE id_usuario = ".(int)$id."
						AND bo_activo = 1;";
		
		$respuesta		= $this->_conn->consultaArreglo($sql);
		
		return $respuesta;
	}

	function validarFiscalizador($id){
		$perfiles	= array();
		$sql 		= "SELECT acceso_perfil.gl_token AS token
						FROM acceso_usuario_perfil 
						LEFT JOIN acceso_perfil ON acceso_perfil.id_perfil = acceso_usuario_perfil.id_perfil
						WHERE id_usuario = ".(int)$id."
						AND bo_activo = 1;";
		
		$perfiles		= $this->_conn->consultaArreglo($sql);

		$bo_fiscalizador = false;
		if(is_array($perfiles)){
			foreach ($perfiles as $perfil) {
				if($perfil["token"] == self::TOKEN_PERFIL_FISCALIZADOR_SEREMI
					|| $perfil["token"] == self::TOKEN_PERFIL_ADMINISTRADOR){
					$bo_fiscalizador = true;
				}
			}
		}
		return $bo_fiscalizador;
	}

	function getRegionesUsuario($id_usuario)
	{
		$respuesta	= array();

		$sql = "SELECT id_region 
				FROM acceso_usuario_perfil 
				LEFT JOIN acceso_perfil ON acceso_perfil.id_perfil = acceso_usuario_perfil.id_perfil
				WHERE bo_activo = 1 
				AND acceso_perfil.gl_token = '".self::TOKEN_PERFIL_FISCALIZADOR_SEREMI."'
				AND id_usuario = ".(int)$id_usuario;

		$respuesta		= $this->_conn->consultaArreglo($sql);
		
		return $respuesta;
	}

}