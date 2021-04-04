<?php

/**
 ******************************************************************************
 * Sistema           : MIS FISCALIZACIONES
 *
 * Descripcion       : Modelo para Tabla mfis_campana_tipo_especifico
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 08/10/2019
 *
 * @name             DAOCampoEspecifico.php
 *
 * @version          1.0
 *
 * @author           Francisco Valdés <francisco.valdes@cosof.cl>
 *
 ******************************************************************************
 * !ControlCambio
 * --------------
 * !cProgramador				    !cFecha		!cDescripcion
 * ----------------------------------------------------------------------------
 * 
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

namespace App\Mantenedor\Entity;

class DAOCampoEspecifico extends \pan\Kore\Entity
{

    protected $table        = TABLA_CAMPANA_TIPO_ESPECIFICO;
    protected $primary_key    = "id_especifico";

    function __construct()
    {
        parent::__construct();
    }

    public function getLista($bo_estado = 1)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE bo_estado = " . $bo_estado;
        $result    = $this->db->getQuery($query)->runQuery();
        if ($result->getNumRows() > 0) {
            return $result->getRows();
        } else {
            return NULL;
        }
    }

    
}
