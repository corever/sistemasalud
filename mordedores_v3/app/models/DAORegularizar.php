<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripcion       : Modelo para Tablas para regularizar
 *
 * Plataforma        : !PHP
 * 
 * Creacion          : 03/10/2018
 * 
 * @name             DAORegularizar.php
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
class DAORegularizar extends Model {

    function __construct(){
        parent::__construct();       
    }

	/*REGULARIZAR Direccion expediente mordedura*/
    function getJsonDireccionMordedura(){
        $query	= "	SELECT id_expediente, json_direccion_mordedura FROM mor_expediente WHERE id_expediente BETWEEN 19822 AND 20832";
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
    function setJsonDireccionMordedura($id_expediente,$json_direccion){
        $query	= "	UPDATE mor_expediente
                    SET json_direccion_mordedura = '".addslashes($json_direccion)."'
                    WHERE id_expediente = ". intval($id_expediente);

        if($this->db->execQuery($query)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /*REGULARIZAR direccion animal mordedor*/
    function getJsonDireccion(){
        $query	= "	SELECT id_mordedor,json_direccion FROM mor_animal_mordedor WHERE id_mordedor BETWEEN 8833 AND 9203";
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
    function setJsonDireccion($id_mordedor,$json_direccion){
        $query	= "	UPDATE mor_animal_mordedor
                    SET json_direccion = '".addslashes($json_direccion)."'
                    WHERE id_mordedor = ". intval($id_mordedor);

        if($this->db->execQuery($query)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /*REGULARIZAR paciente contacto*/
    function getJsonDireccionPaciente(){
        $query	= "	SELECT id_paciente_contacto,json_dato_contacto
                    FROM mor_paciente_contacto
                    WHERE id_tipo_contacto = 3 AND id_paciente_contacto BETWEEN 46660 AND 48694";
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
    function setJsonDireccionPaciente($id_paciente_contacto,$json_direccion){
        $query	= "	UPDATE mor_paciente_contacto
                    SET json_dato_contacto = '".addslashes($json_direccion)."'
                    WHERE id_paciente_contacto = ". intval($id_paciente_contacto);

        if($this->db->execQuery($query)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /*REGULARIZAR EXPEDIENTE_MORDEDOR*/
    public function getListaExpedienteMordedor(){
        $query	= "	SELECT * FROM mor_expediente_mordedor WHERE id_expediente_mordedor BETWEEN 33153 AND 34163";
        $result	= $this->db->getQuery($query);

        if($result->numRows>0){
            return $result->rows;
        }else{
            return NULL;
        }
    }
    
    function setJsonExpedienteMordedor($id_expediente_mordedor,$json_mordedor){
        $query	= "	UPDATE mor_expediente_mordedor
                    SET json_mordedor = '".addslashes($json_mordedor)."'
                    WHERE id_expediente_mordedor = ". intval($id_expediente_mordedor);

        if($this->db->execQuery($query)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function getAnimalEspecieById($id){
        $query	= "	SELECT * FROM mor_animal_especie
					WHERE id_animal_especie = ?";

		$param	= array($id);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }
    
    public function getAnimalRazaById($id){
        $query	= "	SELECT * FROM mor_animal_raza
					WHERE id_animal_raza = ?";

		$param	= array($id);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }
    
    public function getAnimalTamanoById($id){
        $query	= "	SELECT * FROM mor_animal_tamano
					WHERE id_animal_tamano = ?";

		$param	= array($id);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }
    
    public function getAnimalGrupoById($id){
        $query	= "	SELECT * FROM mor_animal_grupo
					WHERE id_animal_grupo = ?";

		$param	= array($id);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }
    
    public function getAnimalMordedorById($id){
        $query	= "	SELECT * FROM mor_animal_mordedor
					WHERE id_mordedor = ?";

		$param	= array($id);
        $result	= $this->db->getQuery($query,$param);
		
        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }
	
}

?>