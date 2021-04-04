<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tabla mor_acceso_usuario
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 17/05/2018
 * 
 * @name             DAOUsuario.php
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
class DAOUsuario{
	const TOKEN_PERFIL_ADMINISTRADOR = "6e707064b948a2ab6ea7ab69513c0663ef70b3b9";
	const TOKEN_PERFIL_FISCALIZADOR_SEREMI = "ae5d153c8c746994b82710616b78a237f3294628";
	protected $_tabla           = "mor_acceso_usuario";
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

	function getUsuarioLogin($rut, $password)
	{	
		$respuesta	= array();
		$sql 		= "SELECT * 
						FROM mor_acceso_usuario 
						WHERE gl_rut = '".(string)$rut."' 
						AND gl_password = '".hash("sha512", $password)."'
						AND bo_activo = 1;";
		$data		= $this->_conn->consulta($sql);
		$respuesta	= $this->_conn->fetch_assoc($data);
		
		$this->_conn->dispose($data);
		
		return $respuesta;
	} 

	function getUsuarioLoginMIDAS($rut, $password)
	{	
		$bo_midas = true;
		$conn =  new MySQL($bo_midas);

		$respuesta	= array();//, TRUE as bo_usuario_midas 
		$sql 		= "SELECT usuario.*
						FROM usuario 
						WHERE rut = '".(string)$rut."' 
						AND password = '".hash("sha1", $password)."'
						AND bo_activo = 1;";
		$data		= $conn->consulta($sql);
		$respuesta	= $conn->fetch_assoc($data);
		
		$conn->dispose($data);
		$conn->cerrar_conexion();
		
		return $respuesta;
	} 

	function getUsuarioByRut($rut)
	{	
		$respuesta	= array();
		$sql 		= "SELECT * 
						FROM mor_acceso_usuario 
						WHERE gl_rut = '".(string)$rut."'
						AND bo_activo = 1;";
		$data		= $this->_conn->consulta($sql);
		$respuesta	= $this->_conn->fetch_assoc($data);
		
		$this->_conn->dispose($data);	
		
		return $respuesta;
	} 


	function getUsuarioByRutMIDAS($rut)
	{	
		$bo_midas = true;
		$conn =  new MySQL($bo_midas);

		$respuesta	= array();//, TRUE as bo_usuario_midas 
		$sql 		= "SELECT id as id_usuario, usuario.*
						FROM usuario 
						WHERE rut = '".(string)$rut."'
						AND bo_activo = 1;";

		$data		= $conn->consulta($sql);
		$respuesta	= $conn->fetch_assoc($data);
		
		$conn->dispose($data);
		$conn->cerrar_conexion();
		
		return $respuesta;
	} 


	function getPerfilesByIdUsuario($id){
		$respuesta	= array();
		$sql 		= "SELECT id_perfil, id_region, id_oficina 
						FROM mor_acceso_usuario_perfil 
						WHERE id_usuario = ".(int)$id."
						AND bo_activo = 1;";
		
		$respuesta		= $this->_conn->consultaArreglo($sql);
		
		return $respuesta;
	}

	function validarFiscalizador($id){
		$perfiles	= array();
		$sql 		= "SELECT mor_acceso_perfil.gl_token AS token
						FROM mor_acceso_usuario_perfil 
						LEFT JOIN mor_acceso_perfil ON mor_acceso_perfil.id_perfil = mor_acceso_usuario_perfil.id_perfil
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
				FROM mor_acceso_usuario_perfil 
				LEFT JOIN mor_acceso_perfil ON mor_acceso_perfil.id_perfil = mor_acceso_usuario_perfil.id_perfil
				WHERE bo_activo = 1 
				AND mor_acceso_perfil.gl_token = '".self::TOKEN_PERFIL_FISCALIZADOR_SEREMI."'
				AND id_usuario = ".(int)$id_usuario;

		$respuesta		= $this->_conn->consultaArreglo($sql);
		
		return $respuesta;
	}

	public function getDatosContactoByIdUsuario($id){        
        $query  = " SELECT json_dato_contacto, id_tipo_contacto
                    FROM mor_acceso_usuario_contacto
                    WHERE bo_estado = 1 
                    AND id_usuario = ?";

        $param  = array($id);
        $result = $this->_conn->consultaArreglo($query,$param);

        if(!empty($result)){
            return $result;
        }else{
            return NULL;
        }
    }

}

