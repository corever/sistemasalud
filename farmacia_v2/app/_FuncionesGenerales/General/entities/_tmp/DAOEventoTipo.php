<?php

/**
 ******************************************************************************
 * Sistema           : MIS FISCALIZACIONES
 *
 * Descripcion       : Modelo para Tabla mfis_historial_evento_tipo
 *
 * Plataforma        : !PHP
 *
 * Creacion          : 09/10/2019
 *
 * @name             DAOEventoTipo.php
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


class DAOEventoTipo extends \pan\Kore\Entity
{
    protected $table            = TABLA_EVENTO_TIPO;
    protected $primary_key        = "id_evento_tipo";

    function __construct()
    {
        parent::__construct();
    }
}
