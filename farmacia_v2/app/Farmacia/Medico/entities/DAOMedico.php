<?php
/**
 ******************************************************************************
 * Sistema           : FARMACIA
 *
 * Descripcion       : Modelo para medico
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 04/09/2020
 *
 * @name             DAOMedico.php
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
namespace App\Farmacia\Medico\Entity;

class DAOMedico extends \pan\Kore\Entity{

	const TOKEN_PERFIL_ADMINISTRADOR = "6e707064b948a2ab6ea7ab69513c0663ef70b3b9";
	const TOKEN_PERFIL_FISCALIZADOR = "ae5d153c8c746994b82710616b78a237f3294628";
	
	protected $tabla_medico			            	= TABLA_MEDICO;	
	protected $tabla_usuario						= TABLA_ACCESO_USUARIO;
	protected $tabla_sucursal						= TABLA_SUCURSAL_MEDICO;

	function __construct(){
		parent::__construct();
	}


     /**
	* Descripción : Obtener Lista de Medicos
	* @author  Camila Figueroa
	* @return  array  Información del medicos
	*/
	public function getListaMedicos($params){
        $param  = array();
        $where  = " WHERE ";
		$query	= " SELECT						
						CONCAT(COALESCE(med.medico_nombre,''),' ',
						COALESCE(med.medico_apellidopat ,''),' ',
						COALESCE(med.medico_apellidomat ,'')) 		AS gl_nombre_completo,
						med.medico_correo 							AS gl_email,	
						med.medico_rut 								AS gl_rut,
						med.medico_estado 							AS bo_activo,
						med.id_medico 								AS id_medico	
					FROM  ".$this->tabla_medico."  med
                    ";

        if (!empty($params)) {

            if (isset($params['gl_nombre']) && trim($params['gl_nombre']) != "") {
                $query .= "$where (med.medico_nombre LIKE '%". mb_strtoupper($params['gl_nombre'])."%'";
                $query .= "OR med.medico_apellidopat LIKE '%". mb_strtoupper($params['gl_nombre'])."%'";
                $query .= "OR med.medico_apellidomat LIKE '%". mb_strtoupper($params['gl_nombre'])."%'";
                $query .= "OR CONCAT(med.medico_nombre,' ',med.medico_apellidopat,' ',med.medico_apellidomat) LIKE '%". mb_strtoupper($params['gl_nombre'])."%')";
                $where  = " AND ";
            }
            if (isset($params['gl_email']) && trim($params['gl_email']) != "") {                
                    $query .= "$where med.medico_correo LIKE '%".$params['gl_email']."%'";
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
	* Descripción : Actualiza el estado de un registro de medico a habilitado o inhabilitado segun corresponda
	* @author  Camila figueroa	
	*/
	public function actualizaEstadoMedico($id_medico,$bo_activo){
		$query	= "	UPDATE ".$this->tabla_medico."
					SET medico_estado = ?
					WHERE id_medico = ? ";
		$param	= array($bo_activo,$id_medico);
		$resp	= $this->db->execQuery($query, $param);

		return $resp;
	}

	/**
	 * Permite obtener todos los datos de un medico 
	 * @author Camila Figueroa
	 * @return array 
	 */
	public function getMedicoById($id_medico){
		$query	= "	SELECT 
		med.id_medico 				AS id_medico,
		med.fk_usuario 				AS id_usuario,
		med.medico_rut 				AS gl_rut,
		med.medico_rut_midas 		AS gl_rut_midas,
		med.medico_nombre 			AS gl_nombre,
		med.medico_apellidopat 		AS gl_paterno,
		med.medico_apellidomat 		AS gl_materno,
		med.medico_gen 				AS gl_genero,
		med.medico_fecha_nacimiento AS fc_nacimiento,
		med.medico_correo 			AS gl_email,
		med.id_region_midas		 	AS id_region,
		med.id_comuna_midas			AS id_comuna,
		med.direccion_medico		AS gl_direccion,
		med.fono		 			AS gl_telefono,
		med.fono_codigo 			AS gl_cod_telefono,
		med.fecha_creacion 			AS fc_creacion,
		med.medico_estado 			AS bo_estado,
		med.fecha_actualizacion 	AS fc_actualizacion,
		med.id_especialidad			AS id_especialidad
		FROM ".$this->tabla_medico." med
		WHERE med.id_medico = ".$id_medico."";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows(0);
		}else{
            return NULL;
		}
	}



		  /**
    * Descripción   : Insertar nuevo medico
    * @author       : Camila Figueroa
    * @param        : array
    * @return       : int
    */
    public function insertaMedico($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->tabla_medico."
								(
                                    fk_usuario,
                                    medico_rut,
                                    medico_rut_midas,
                                    medico_nombre,
                                    medico_apellidopat,
                                    medico_apellidomat,
									medico_gen,
									medico_fecha_nacimiento,
									medico_correo,
									id_region_midas,
									id_comuna_midas,
									direccion_medico,
									fono,
									fono_codigo,
									medico_estado,
									id_especialidad
								)
								VALUES
								(
									?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
								)";

		if($this->db->execQuery($query,$params)){
            $id = $this->db->getLastId();
        }

        return $id;
	}
	

		  /**
    * Descripción   : Insertar nueva consulta 
    * @author       : Camila Figueroa
    * @param        : array
    * @return       : int
    */
    public function insertaConsulta($params) {

        $id     = false;
        $query  = "INSERT INTO ".$this->tabla_sucursal."
					(fk_medico,id_region_midas,id_comuna_midas,direccion_sucursal,fono_codigo,fono
					)
					VALUES
					(?,?,?,?,?,?)";

		if($this->db->execQuery($query,$params)){
            $id = $this->db->getLastId();
        }

        return $id;
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
	 * Valida la existencia de un medico 
	 *  @param $rut_medico 
	 *  @return array con binario true o false
	 */
	public function existeMedico($rut_medico){      
		$query	= " SELECT 
					count(*) AS bo_existe 
					FROM ".$this->tabla_medico." 
					WHERE UPPER(REPLACE(REPLACE(medico_rut,'.',''),'-','')) = UPPER(REPLACE(REPLACE('".$rut_medico."','-',''),'.',''))						
                    ";
		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){			
			return $result->getRows(0)->bo_existe;
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

	
     /**
	* Descripción : Obtener Lista de Consultas Médicas
	* @author  Camila Figueroa
	* @return  array  Consultas médicas
	*/
	public function getConsultasMedicoById($id_medico){
        $param  = array();

		$query	= " SELECT						
						suc.id_sxm 				AS id_consulta,
						suc.fk_medico  			AS id_medico,
						suc.id_region_midas  	AS id_region,
						suc.id_comuna_midas		AS id_comuna,
						suc.direccion_sucursal  AS gl_direccion,
						suc.fono			    AS gl_telefono,
						suc.fecha_creacion	    AS fc_creacion,
						suc.fecha_actualizacion AS fc_actualizacion,
						suc.consulta_estado		AS bo_consulta
					FROM  ".$this->tabla_sucursal."  suc
					WHERE suc.fk_medico=".$id_medico."
                    ";

		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}


	/**
	* Descripción : Actualiza el correo electronico de un usuario
	* @author  Camila figueroa	
	*/
	public function actualizaMedico($params){
		$query	= "UPDATE ".$this->tabla_medico." 
		SET  medico_gen 		= ?, 
			 fk_usuario			= ?,
			 medico_correo		= ?,	
			 id_especialidad 	= ? 
		WHERE id_medico 		= ?";
		
		$resp	= $this->db->execQuery($query, $params);
		if(isset($resp)){
			return $resp;
		}else{
			return null;
		}
		
	}

	/**
	* Descripción : Elimina todas las consultas de un medico
	* @author  Camila figueroa	
	*/
	public function borrarConsultasMedico($id_medico){
		$query	= "DELETE FROM ".$this->tabla_sucursal." 
		WHERE fk_medico 		= ".$id_medico."";
		$param	= array($id_perfil);

		$response = $this->db->execQuery($query, $param);

		if ($response) {
			return TRUE;
		}else {
			return NULL;
		}
	}



}


