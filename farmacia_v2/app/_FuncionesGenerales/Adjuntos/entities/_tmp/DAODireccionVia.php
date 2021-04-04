<?php

/**
 ******************************************************************************
 * Sistema           : MIS FISCALIZACIONES
 *
 * Descripcion       : Modelo para Tabla mfis_direccion_tipo_via
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 09/10/2019
 *
 * @name             DAODireccionVia.php
 *
 * @version          1.0
 *
 * @author           Francisco Valdés <francisco.valdes@cosof.cl>
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

namespace App\General\Entity;


class DAODireccionVia extends \pan\Kore\Entity
{
    protected $table            = TABLA_DIRECCION_VIA;
    protected $primary_key        = "id_direccion_via";

    function __construct()
    {
        parent::__construct();
    }
}
