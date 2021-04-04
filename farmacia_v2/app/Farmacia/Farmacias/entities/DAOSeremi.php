<?php
/**
 ******************************************************************************
 * Sistema           : FARMACIA
 *
 * Descripcion       : Modelo para firma de seremi
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 26/08/2020
 *
 * @name             DAOSeremi.php
 *
 * @version          1.0
 *
 * @author           Camila Figueroa
 *
 ******************************************************************************
 * !ControlCambio
 * --------------
 * !cProgramador				!cFecha		!cDescripcion
 * ---------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
namespace App\Farmacia\Farmacias\Entity;

class DAOSeremi extends \pan\Kore\Entity{

	const TOKEN_PERFIL_ADMINISTRADOR = "6e707064b948a2ab6ea7ab69513c0663ef70b3b9";
	const TOKEN_PERFIL_FISCALIZADOR = "ae5d153c8c746994b82710616b78a237f3294628";
	
	protected $tabla_seremi			            	= TABLA_SEREMI;
	protected $tabla_firmante			            = TABLA_FIRMANTE;
	protected $tabla_usuario						= TABLA_ACCESO_USUARIO;
	protected $primary_key		            = "mu_id";

	function __construct(){
		parent::__construct();
	}



	
	/**
	 * Permite obtener un tipo de firmante
	 * @author Camila Figueroa
	 * @return array 
	 */
	public function getTipoFirmanteById($id_seremi){
		$query	= "	SELECT 
		id_firmante 		AS id_firmante,
		gl_tipo_firmante 	AS gl_firmante
	FROM
		".TABLA_FIRMANTE." ftf
		INNER JOIN ".TABLA_SEREMI." ser ON
		ser.id_tipo_firmante = ftf.id_firmante where ser.id_seremi =".$id_seremi."";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows(0);
		}else{
            return NULL;
		}
	}
	
	/**
	 * Permite obtener los tipos de firmantes disponibles
	 * @author Camila Figueroa
	 * @return array 
	 */
	public function getTiposDeFirmante(){
		$query	= "	SELECT 
		id_firmante 		AS id_firmante,
		gl_tipo_firmante 	AS gl_firmante
		FROM ".TABLA_FIRMANTE."";

		$result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
	}

	/**
	 * Permite obtener todos los datos de un seremi 
	 * @author Camila Figueroa
	 * @return array 
	 */
	public function getSeremiById($id_seremi){
		$query	= "	SELECT 
		ser.id_seremi 				AS id_seremi,
		ser.fk_usuario 				AS id_usuario,
		ser.id_region_midas 		AS id_region,
		ser.id_comuna_midas 		AS id_comuna,
		ser.genero_seremi 			AS gl_genero,
		ser.seremi_trato 			AS gl_trato,
		ser.seremi_cargo 			AS gl_cargo,
		ser.seremi_autoridad 		AS gl_autoridad,
		ser.seremi_nombre 			AS gl_nombre,
		ser.seremi_apellido_paterno AS gl_paterno,
		ser.seremi_apellido_materno AS gl_materno,
		ser.seremi_direccion 		AS gl_direccion,
		ser.seremi_fax 				AS gl_fax,
		ser.seremi_email 			AS gl_email,
		ser.seremi_decreto 			AS gl_decreto,
		ser.seremi_decreto_fecha 	AS fc_decreto,
		ser.seremi 					AS bo_seremi,
		ser.seremi_fecha_creacion 	AS fc_creacion,
		ser.seremi_estado 			AS bo_estado,
		ser.url_firma 				AS gl_firma,
		ser.fk_rol 					AS id_rol,
		ser.id_tipo_firmante 		AS id_firmante,
		ser.id_decreto_delegado		AS id_ds_delegado,
		ser.fc_decreto_delegado		AS fc_ds_delegado,
		ser.id_territorio			AS id_territorio,
		usr.mu_telefono		 		AS gl_telefono,
		usr.mu_rut 					AS gl_rut,
		usr.mu_fecha_nacimiento 	AS fc_nacimiento,
		usr.mu_id 					AS id_usuario,
		usr.mu_telefono_codigo		AS cd_fono
		FROM ".TABLA_SEREMI." ser
		LEFT JOIN ".TABLA_ACCESO_USUARIO." usr on usr.mu_id = ser.fk_usuario 
		WHERE ser.id_seremi = ".$id_seremi."";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows(0);
		}else{
            return NULL;
		}
	}


	/**
	* Descripción : Actualiza el estado de un registro de seremi a habilitado o inhabilitado segun corresponda
	* @author  Camila figueroa	
	*/
	public function actualizaEstadoSeremi($id_seremi,$bo_activo){
		$query	= "	UPDATE ".$this->tabla_seremi."
					SET seremi_estado = ?
					WHERE id_seremi = ? ";
		$param	= array($bo_activo,$id_seremi);
		$resp	= $this->db->execQuery($query, $param);

		return $resp;
	}


	/**
	* Descripción : Obtener listado de trato ej : Sr , Sra , Dr. ...
	* @author  Camila Figueroa
	* @return  array  tipos de trato
	*/
    public function getListaOrdenadaTrato(){

        $query	= "SELECT 
		seremi_trato 
		FROM ".$this->tabla_seremi." 
		GROUP BY seremi_trato 
		ORDER BY seremi_trato DESC";

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }
    /**
	* Descripción : Obtener Lista de Seremis
	* @author  Camila Figueroa
	* @return  array  Información del seremi
	*/
	public function getListaSeremis($params){
        $param  = array();
        $where  = " WHERE ";
		$query	= " SELECT						
						CONCAT(COALESCE(seremi.seremi_nombre,''),' ',
						COALESCE(seremi.seremi_apellido_paterno ,''),' ',
						COALESCE(seremi.seremi_apellido_materno ,'')) 	AS gl_nombre_completo,
						seremi.seremi_email 							AS gl_email,	
						seremi.seremi_telefono 							AS gl_telefono,
						seremi.url_firma 								AS gl_firma,
						seremi.seremi_estado 							AS bo_activo,
						seremi.id_seremi 								AS id_seremi	
					FROM  ".$this->tabla_seremi."  seremi
                    ";

        if (!empty($params)) {
            if (isset($params['id_region']) && intval($params['id_region']) > 0) {
                $query      .= "$where seremi.id_region_midas = ?";
                $param[]    = intval($params['id_region']);
                $where      = " AND ";
            }

            if (isset($params['gl_nombre']) && trim($params['gl_nombre']) != "") {
                $query .= "$where (seremi.seremi_nombre LIKE '%". mb_strtoupper($params['gl_nombre'])."%'";
                $query .= "OR seremi.seremi_apellido_paterno LIKE '%". mb_strtoupper($params['gl_nombre'])."%'";
                $query .= "OR seremi.seremi_apellido_materno LIKE '%". mb_strtoupper($params['gl_nombre'])."%'";
                $query .= "OR CONCAT(seremi.seremi_nombre,' ',seremi.seremi_apellido_paterno,' ',seremi.seremi_apellido_materno) LIKE '%". mb_strtoupper($params['gl_nombre'])."%')";
                $where  = " AND ";
            }
            if (isset($params['gl_email']) && trim($params['gl_email']) != "") {                
                    $query .= "$where seremi.seremi_email LIKE '%".$params['gl_email']."%'";
                    $where  = " AND ";                
            }
        }

		$result	= $this->db->getQuery($query,$param)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}


	/**
	* Descripción : Modificar Usuario con perfil de Seremi en BD
	* @author Camila Figueroa
	*  
	*/
	public function modificarUsuario($datosSeremi){		

		$query	= "	UPDATE ".$this->tabla_usuario."
					SET
						mu_direccion               	='".trim($datosSeremi["gl_direccion"])."',
                        id_region_midas               ='".trim($datosSeremi["id_region"])."',
						mu_telefono                	='".trim($datosSeremi["gl_telefono"])."',
						mu_telefono_codigo			='".trim($datosSeremi["cd_fono"])."',
                        mu_correo                   ='".trim($datosSeremi["gl_email"])."',
						mu_fecha_nacimiento     	='".trim($datosSeremi["fc_nacimiento"])."',
						fecha_actualizacion     	='".trim($datosSeremi["fecha_actualizacion"])."'
					WHERE 
						mu_id=".trim($datosSeremi["id_usuario"])."";
								
		$resp	= $this->db->execQuery($query, $datosSeremi);
		file_put_contents('php://stderr', PHP_EOL . print_r("Respuesta modificarUsuario: ".$resp, TRUE). PHP_EOL, FILE_APPEND);
		if($resp){			
			return "OK";
		}else{			
			return "ERROR";
		}
		
	}


	/**
	* Descripción : Modificar datos de Seremi en BD
	* @author Camila Figueroa
	*  
	*/
	public function modificarSeremi($datosSeremi){

		$query	= "	UPDATE ".$this->tabla_seremi."
					SET
						seremi_trato               	='".trim($datosSeremi["gl_trato"])."',
                        id_region_midas               	='".trim($datosSeremi["id_region"])."',
                        seremi_telefono           	='".trim($datosSeremi["cd_fono"]).trim($datosSeremi["gl_telefono"])."',
                        seremi_email                ='".trim($datosSeremi["gl_email"])."',
						seremi_decreto     			='".trim($datosSeremi["gl_ds"])."',
						seremi_decreto_fecha		='".trim($datosSeremi["fecha_ds"])."',
						seremi_direccion 			='".trim($datosSeremi["gl_direccion"])."',
						id_tipo_firmante 			='".trim($datosSeremi["id_firmante"])."',
						genero_seremi				='".trim($datosSeremi["id_genero"])."',
						fk_usuario					='".trim($datosSeremi["id_usuario"])."',
						id_decreto_delegado			='".trim($datosSeremi["gl_ds_delegado"])."',
						fc_decreto_delegado			='".trim($datosSeremi["fc_ds_delegada"])."'	,
						id_territorio				='".trim($datosSeremi["id_territorio"])."',
						url_firma					='".trim($datosSeremi["gl_firma"])."'					
					WHERE 
						id_seremi=".trim($datosSeremi["id_seremi"])."";
		
		$resp	= $this->db->execQuery($query, $datosSeremi);
		file_put_contents('php://stderr', PHP_EOL . print_r("Respuesta modificarSeremi: ".$resp, TRUE). PHP_EOL, FILE_APPEND);
		if($resp){			
			return "OK";
		}else{			
			return "ERROR";
		}
		
	}


	  /**
    * Descripción   : Insertar nuevo seremi
    * @author       : Camila Figueroa
    * @param        : array
    * @return       : int
    */
    public function insertaSeremi($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->tabla_seremi."
								(
                                    fk_usuario,
                                    id_region_midas,
                                    id_comuna_midas,
                                    genero_seremi,
                                    seremi_trato,
                                    seremi_cargo,
									seremi_autoridad,
									seremi_nombre,
									seremi_apellido_paterno,
									seremi_apellido_materno,
									seremi_direccion,
									seremi_telefono,
									seremi_fax,
									seremi_email,
									seremi_decreto,
									seremi_decreto_fecha,
									seremi,
									seremi_fecha_creacion,
									seremi_estado,
									url_firma,
									fk_rol,
									id_tipo_firmante,
									id_decreto_delegado,
									fc_decreto_delegado,
									id_territorio
								)
								VALUES
								(
									?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now(),?,?,?,?,?,?,?
								)";

		if($this->db->execQuery($query,$params)){
            $id = $this->db->getLastId();
        }

        return $id;
	}
	

	/**
	* Descripción : Obtiene informacion de archivo adjunto (imagen firma)
	* @author  Camila Figueroa
	* @return  array  
	*/
	public function buscarAdjuntoById($id_seremi){
        $param  = array();        
		$query	= " SELECT 
					fk_usuario 					AS id_usuario,
					url_firma 					AS gl_firma,
					seremi_decreto_fecha 		AS fc_ds,
					fc_decreto_delegado 		AS fc_ds_delegado
					FROM ".$this->tabla_seremi." 
					WHERE id_seremi = ".$id_seremi."						
                    ";

		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
			return $result->getRows(0);
		}else{
			return NULL;
		}
	}

	/**
	 * Valida la existencia de un usuario 
	 *  @param $gl_rut_usuario de usuario
	 *  @return array con binario true o false
	 */
	public function existeUsuario($gl_rut_usuario){      
		$query	= " SELECT 
					count(*) AS bo_existe 
					FROM ".$this->tabla_usuario." 
					WHERE UPPER(REPLACE(REPLACE(mu_rut,'.',''),'-','')) = UPPER(REPLACE(REPLACE('".$gl_rut_usuario."','-',''),'.',''))						
                    ";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){			
			return $result->getRows(0)->bo_existe;
		}else{
			return NULL;
		}
	}

	/**
	 * Valida que exista un seremi asociado al mismo rut y al mismo territorio y region 
	 *  @param rut de usuario id_territorio e identificador de region
	 *  @return array con binario true o false
	 */
	public function validaNuevoSeremi($id_usuario,$id_territorio,$id_region){      
		$query	= "SELECT count(*) as bo_valido 
		FROM ".$this->tabla_usuario." mu 
			INNER JOIN ".$this->tabla_seremi." ser ON ser.fk_usuario = mu.mu_id
		WHERE 
			mu.mu_id = ".$id_usuario."
			and ser.id_region_midas =".$id_region." and ser.id_territorio =".$id_territorio."";

			
			$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){			
			
			return $result->getRows(0)->bo_valido;
		}else{
			return NULL;
		}
	}

		/**
	 * Obtiene el id de un usuario mediante su rut
	 *  @param rut de usuario id_territorio e identificador de region
	 *  @return array con binario true o false
	 */
	public function getIdUsuarioByRut($gl_rut){      
		$query	= "SELECT mu_id as id_usuario
		FROM ".$this->tabla_usuario." mu 			
		WHERE 
			UPPER(REPLACE(REPLACE(mu.mu_rut,'.',''),'-','')) = UPPER(REPLACE(REPLACE('".$gl_rut."','.',''),'-',''))";
			
			$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){			
			return $result->getRows(0)->id_usuario;
		}else{
			return NULL;
		}
	}


	/**
	* Descripción : Actualiza el correo electronico de un usuario
	* @author  Camila figueroa	
	*/
	public function actualizaMailUsuario($id_usuario, $gl_correo){
		$query	= "UPDATE ".$this->tabla_usuario." 
		SET mu_correo = ? 
		WHERE mu_id = ? ";
		
		$param	= array($gl_correo,$id_usuario);
		$resp	= $this->db->execQuery($query, $param);
		
		return $resp;
	}

}


