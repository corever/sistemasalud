<?php

/**
******************************************************************************
* Sistema           : ANIMALES MORDEDORES
*
* Descripcion       : Modelo para Tabla mor_perfil_documento
*
* Plataforma        : !PHP
*
* Creacion          : 28/10/2018
*
* @name             DAOPerfilDocumento.php
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


class DAOPerfilDocumento extends Model {

    protected $_tabla           = "mor_perfil_documento";
    protected $_primaria        = "id_documento";
    protected $_transaccional	= false;

    function __construct() {

        parent::__construct();
    }

    public function getById($id){
        $query	= "	SELECT * FROM ".$this->_tabla."
            WHERE ".$this->_primaria." = ?";

        $param	= array($id);
        $result	= $this->db->getQuery($query,$param);

        if($result->numRows > 0){
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    /**
    * Descripción : Obtener por Perfil Usuario
    * @author  David Guzmán <david.guzman@cosof.cl> - 25/10/2018
    * @param   int   $id_perfil
    */
    public function getByPerfil($id_perfil){
        $query	= "	SELECT * FROM ".$this->_tabla."
            WHERE id_perfil = ? AND bo_estado = 1";

        $param	= array(intval($id_perfil));
        $result	= $this->db->getQuery($query,$param);

        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    /**
    * Descripción : Obtener activos
    * @author  David Guzmán <david.guzman@cosof.cl> - 06/06/2019
    * @param   
    */
    public function getListaActivo(){
        $query	= "	SELECT * FROM ".$this->_tabla."
                    WHERE bo_estado = 1";

        $result	= $this->db->getQuery($query);

        if($result->numRows > 0){
            return $result->rows;
        }else{
            return NULL;
        }
    }

    public function getByToken($gl_token) {
        $query	= "	SELECT *
                    FROM mor_perfil_documento
                    WHERE gl_token = ?";

        $params	= array($gl_token);
        $result	= $this->db->getQuery($query, $params);

        if($result->numRows > 0) {
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

    public function getByName($gl_name) {
        $query	= "	SELECT *
                    FROM mor_perfil_documento
                    WHERE gl_nombre = ?";

        $params	= array($gl_name);
        $result	= $this->db->getQuery($query, $params);

        if($result->numRows > 0) {
            return $result->rows->row_0;
        }else{
            return NULL;
        }
    }

}
?>
