<?php

namespace App\Farmacia\Bodegas\Entity;

class DAOBodegaTipo extends \pan\Kore\Entity
{

    protected $table       = TABLA_BODEGA_TIPO;
    protected $primary_key = "bodega_tipo_id";

    function __construct()
    {
        parent::__construct();
    }

}
